<?php
header('Content-Type: application/json');

require '../../../connect.php'; // your DB connection file

// Function to format number in Indian numbering format
function formatIndianNumber($num)
{
    $decimalPart = "";

    $num = (string) $num;
    if (strpos($num, '.') !== false) {
        list($num, $decimalPart) = explode('.', $num);
        $decimalPart = '.' . $decimalPart;
    }

    $lastThree = substr($num, -3);
    $rest = substr($num, 0, -3);

    if ($rest != '') {
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        $num = $rest . ',' . $lastThree;
    }

    return $num . $decimalPart;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}


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

try {
    // Verify user is valid TA
    $stmt1 = $conn->prepare("SELECT * FROM `login` WHERE status = '1' AND `user_id` = ? AND `user_type_id` = '11'");
    $stmt1->execute([$userId]);

    if ($stmt1->rowCount() === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User not found or not a valid TA.'
        ]);
        exit;
    }

    // Fetch latest balance
    $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
    $stmt2->execute([':ta_id' => $userId]);
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);

    $available_bal = $result['available_balance'] ?? 0;
    $formatted_bal = formatIndianNumber($available_bal);

    echo json_encode([
        'success' => true,
        'data' => [
            'user_id' => $userId,
            'available_balance' => (float)$available_bal,
            'formatted_balance' => $formatted_bal
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
