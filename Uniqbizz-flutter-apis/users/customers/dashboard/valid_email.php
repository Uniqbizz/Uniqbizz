<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
$data = json_decode(file_get_contents("php://input"), true);
$email = isset($data['email']) ? trim($data['email']) : '';

if (empty($email)) {
    echo json_encode(['status' => false, 'message' => 'Email is missing']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `ca_customer` WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->fetchColumn();

    echo json_encode([
        'status' => $count > 0,
        'message' => $count > 0 ? 'Email exists' : 'Email does not exist'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'message' => 'Database error',
        'error' => $e->getMessage()
    ]);
}
