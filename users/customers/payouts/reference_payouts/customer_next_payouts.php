<?php
header('Content-Type: application/json');
require '../../../../connect.php'; // assumes your PDO $conn setup

function truncateToTwoDecimals($number)
{
    return floor($number * 100) / 100;
}

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
    'data' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = isset($data['userId']) ? $data['userId'] : '';
    $nextMonth = isset($data['month']) ? $data['month'] : '';
    $nextYear = isset($data['year']) ? $data['year'] : '';
    $tdsPer = 0.02; // Adjust this rate as needed

    if ($userId && $nextMonth && $nextYear) {
        try {
            // Calculate total payout
            $stmt = $conn->prepare("
                SELECT SUM(referral_amount) as payout 
                FROM customer_reference_payout 
                WHERE customer_id = :userId 
                AND YEAR(created_date) = :year 
                AND MONTH(created_date) = :month
            ");
            $stmt->execute([
                'userId' => $userId,
                'year' => $nextYear,
                'month' => $nextMonth
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPayout = $result['payout'] ?? 0;

            $tds = $totalPayout * $tdsPer;
            $netPayout = truncateToTwoDecimals($totalPayout - $tds);

            // Get individual payout rows
            $stmt = $conn->prepare("
                SELECT id, customer_id as userId, referral_message as message1, booking_message as message2, 
                       referral_amount as comm_amt1, booking_points as comm_amt2, created_date, status 
                FROM customer_reference_payout 
                WHERE customer_id = :userId 
                AND YEAR(created_date) = :year 
                AND MONTH(created_date) = :month 
                ORDER BY created_date DESC
            ");
            $stmt->execute([
                'userId' => $userId,
                'year' => $nextYear,
                'month' => $nextMonth
            ]);

            $rows = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $date = (new DateTime($row['created_date']))->format('Y-m-d');
                $message = $row['message1'] ?: $row['message2'];
                $message = str_replace('.', '<br>', $message);

                $commission = $row['comm_amt1'] ?: $row['comm_amt2'];
                $tds = $row['comm_amt1'] ? $commission * $tdsPer : null;
                $total = $commission - ($tds ?? 0);

                $statusText = 'Pending';
                switch ($row['status']) {
                    case '1':
                        $statusText = 'Paid';
                        break;
                    case '3':
                        $statusText = 'Credited';
                        break;
                }

                $rows[] = [
                    'date' => $date,
                    'message' => strip_tags($message),
                    'amount' => $commission,
                    'tds' => $tds !== null ? number_format($tds, 2) : null,
                    'total_payable' => number_format($total, 2),
                    'status' => $statusText,
                    'download_link' => ($row['status'] != '3') ? "payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix={$row['id']}&userId={$row['userId']}&date={$date}&message=" . urlencode(strip_tags($message)) . "&message_status={$row['status']}&commission={$commission}" : null
                ];
            }

            $response = [
                'status' => 'success',
                'message' => 'Next payout data fetched',
                'data' => [
                    'total_payout' => number_format($netPayout, 2),
                    'records' => $rows
                ]
            ];
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Missing required fields';
    }
}

echo json_encode($response);
