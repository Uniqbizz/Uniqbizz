<?php
header('Content-Type: application/json');
require '../../../connect.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
$response = [
    'status' => false,
    'message' => '',
    'data' => []
];

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = isset($data['userId']) ? $data['userId'] : '';

    if (!$userId) {
        throw new Exception("Missing 'user_id' parameter.");
    }

    // Get current year and month
    $DateYear = date('Y');
    $DateMonth = date('m');

    // ----------- Redeemable Count -----------
    $stmt = $conn->prepare("SELECT
            SUM(COALESCE(credit_amount, 0)) AS credit_amt,
            SUM(COALESCE(debit_amount, 0)) AS debit_amt,
            (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance
        FROM customer_reference_wallet_utilization
        WHERE customer_id = :userId");
    $stmt->execute(['userId' => $userId]);
    $redeemableTotal = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;

    // var_dump($userId, $redeemableTotal);

    $stmt = $conn->prepare("SELECT
            SUM(COALESCE(credit_amount, 0)) AS credit_amt,
            SUM(COALESCE(debit_amount, 0)) AS debit_amt,
            (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance
        FROM customer_reference_wallet_utilization
        WHERE customer_id = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month");
    $stmt->execute(['userId' => $userId, 'year' => $DateYear, 'month' => $DateMonth]);
    $redeemableMonth = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;

    // ----------- Booking Points Count -----------
    $stmt = $conn->prepare("SELECT
            SUM(COALESCE(credit_amount, 0)) AS credit_amt,
            SUM(COALESCE(debit_amount, 0)) AS debit_amt,
            (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance FROM customer_reference_booking_points_utilization WHERE customer_id = :userId");
    $stmt->execute(['userId' => $userId]);
    $bookingTotal = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;

    $stmt = $conn->prepare("SELECT
            SUM(COALESCE(credit_amount, 0)) AS credit_amt,
            SUM(COALESCE(debit_amount, 0)) AS debit_amt,
            (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance FROM customer_reference_booking_points_utilization WHERE customer_id = :userId  AND YEAR(created_date) = :year AND MONTH(created_date) = :month");
    $stmt->execute(['userId' => $userId, 'year' => $DateYear, 'month' => $DateMonth]);
    $bookingMonth = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;

    // ----------- Redeemable Wallet History -----------
    $stmt = $conn->prepare("SELECT referral_message, referral_amount, created_date, status FROM customer_reference_payout WHERE customer_id = :userId AND referral_amount IS NOT NULL ORDER BY id DESC");
    $stmt->execute(['userId' => $userId]);
    $walletHistory = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $formattedDate = date('d-m-Y', strtotime($row['created_date']));
        $referralText = $row['referral_message'];

        // Format referral_message
        $formattedText = $referralText;
        $split = explode('referring', $referralText, 2);
        if (count($split) == 2) {
            $firstPart = trim($split[0]) . ' referring';
            $afterReferring = trim($split[1]);

            if (strpos($afterReferring, 'through') !== false) {
                $split2 = explode('through', $afterReferring, 2);
                $secondPart = trim($split2[0]);
                $thirdPart = trim($split2[1]);
                $formattedText = $firstPart . "\n" . $secondPart . "\n" . $thirdPart;
            } else {
                $formattedText = $firstPart . "\n" . $afterReferring;
            }
        }

        $walletHistory[] = [
            'message' => $formattedText,
            'amount' => $row['referral_amount'],
            'date' => $formattedDate,
            'status' => ($row['status'] == '1') ? 'Paid' : (($row['status'] == '2') ? 'Pending' : 'Unknown')
        ];
    }
    // ----------- Booking Wallet History -----------
    $stmt1 = $conn->prepare("SELECT booking_message, booking_points, created_date, status FROM customer_reference_payout WHERE customer_id = :userId AND booking_points IS NOT NULL ORDER BY id DESC");
    $stmt1->execute(['userId' => $userId]);
    $bookingWalletHistory = [];

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $formattedDate = date('d-m-Y', strtotime($row['created_date']));
        $referralText = $row['booking_message'];

        // Format booking_message
        $formatted_text = '';

        $split = explode('points', $referralText, 2); // Step 1: Split after 'points'
        if (count($split) == 2) {
            $first_part = trim($split[0]) . ' points';
            $after_points = trim($split[1]);

            $referring_split = explode('referring', $after_points, 2); // Step 2: Split after 'referring'
            if (count($referring_split) == 2) {
                $second_part = 'referring ' . trim($referring_split[1]);

                // Step 3: Handle "through"
                if (stripos($second_part, 'through') !== false) {
                    $through_split = explode('through', $second_part, 2);
                    $referring_clause = trim($through_split[0]);
                    $through_clause = 'through ' . trim($through_split[1]);

                    $formatted_text = $first_part . "\n" . 'referring ' . $referring_clause . '\n' . $through_clause;
                } else {
                    $formatted_text = $first_part . "\n" . 'referring ' . $referring_split[1];
                }
            } else {
                // No "referring" found after points
                $formatted_text = $first_part . "\n" . $after_points;
            }
        } else {
            // No "points" found
            $formatted_text = $referralText;
        }

        $bookingWalletHistory[] = [
            'message' => $formatted_text,
            'amount' => $row['booking_points'],
            'date' => $formattedDate,
            'status' => ($row['status'] == '3' ? 'Credited' : 'unknown')
        ];
    }

    // ----------- Final Response -----------
    $response['status'] = true;
    $response['message'] = 'Wallet data fetched successfully';
    $response['data'] = [
        'reference_count' => [
            'total' => (int)$redeemableTotal,
            'this_month' => (int)$redeemableMonth
        ],
        'booking_points_count' => [
            'total' => (int)$bookingTotal,
            'this_month' => (int)$bookingMonth
        ],
        [
            'redeemable_wallet_history' => $walletHistory,
            'booking_wallet_history' => $bookingWalletHistory
        ]

    ];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Output JSON
echo json_encode($response);
