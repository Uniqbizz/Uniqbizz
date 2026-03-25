<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
        exit;
    }

    function getData($key, $default = null)
    {
        global $data;
        return isset($data[$key]) ? trim($data[$key]) : $default;
    }

    $userId = getData('userId');

    if (empty($userId)) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required parameter: userId'
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT id, top_up_amt, created_date, updated_date, status 
        FROM ta_top_up_payment 
        WHERE ta_id = :userId 
        ORDER BY id DESC
    ");
    $stmt->execute([':userId' => $userId]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$records) {
        echo json_encode([
            'success' => true,
            'message' => 'No top-up history found.',
            'data' => []
        ]);
        exit;
    }

    // Transform data for JSON output
    $formatted = [];
    $i = 1;
    foreach ($records as $row) {
        switch ($row['status']) {
            case '1':
                $statusLabel = 'Pending';
                break;
            case '2':
                $statusLabel = 'Approved';
                break;
            case '3':
                $statusLabel = 'Rejected';
                break;
            default:
                $statusLabel = 'Unknown';
                break;
        }

        $formatted[] = [
            'sr_no' => $i++,
            'top_up_amount' => $row['top_up_amt'],
            'created_date' => $row['created_date'],
            'updated_date' => $row['updated_date'],
            'status_code' => $row['status'],
            'status_label' => $statusLabel
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Top-up history fetched successfully.',
        'count' => count($formatted),
        'data' => $formatted
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
