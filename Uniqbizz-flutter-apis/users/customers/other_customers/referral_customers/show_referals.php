<?php
header('Content-Type: application/json');
require '../../../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON data"
    ]);
    exit;
}

if (!isset($data['customer_id']) || empty($data['customer_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "customer_id is required"
    ]);
    exit;
}

$customer_id = $data['customer_id'];

$query = "
    SELECT 
        registrant,
        reference_no,
        ta_reference_no,
        ta_reference_name
    FROM ca_customer
    WHERE ca_customer_id = :customer_id
    AND status = 1
";

try {

    $stmt = $conn->prepare($query);

    $stmt->execute([
    ':customer_id' => $customer_id
    ]);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {

        echo json_encode([
            "status" => "success",
            "data" => $result
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => "No records found"
        ]);

    }

} catch (PDOException $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}
?>