<?php

// Set headers to allow cross-origin requests and return JSON
header("Content-Type: application/json; charset=UTF-8");

// Include DB config
require '../../../connect.php';

$response = [];
// $userId = "CU240001";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
// Capture JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}
$stmt2 = $conn->prepare("SELECT * FROM ca_customer WHERE reference_no = :userId AND status='1'");
$stmt2->bindParam(":userId", $data["userId"]);
$stmt2->execute();
$referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

foreach ($referrals as $referral) {
    $rd = new DateTime($referral['register_date']);
    $rdate = $rd->format('d-m-Y');
    $id = $referral['ca_customer_id'];
    $firstName = $referral['firstname'];
    $lastName = $referral['lastname'];
    $prfilePic = $referral['profile_pic'];
    $status = $referral['status'];

    $count = 0;
    $activeCount = 0;
    $inactiveCount = 0;

    // Total referrals
    $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE reference_no = ?");
    $stmt4->execute([$id]);
    $count = $stmt4->rowCount();

    // // Active profile picture
    // $stmt4 = $conn->prepare("SELECT profile_pic FROM ca_customer WHERE reference_no = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
    // $stmt4->execute([$id]);
    // $activeUserProfile = $stmt4->fetch();
    // $activeProfile = $activeUserProfile['profile_pic'];

    // // Inactive profile picture
    // $stmt4 = $conn->prepare("SELECT profile_pic FROM ca_customer WHERE reference_no = ? AND status='3' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
    // $stmt4->execute([$id]);
    // $inactiveUserProfile = $stmt4->fetch();
    // $inactiveProfile = $inactiveUserProfile['profile_pic'];

    // Active referrals (this month)
    $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE reference_no = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
    $stmt4->execute([$id]);
    $activeCount = $stmt4->rowCount();

    // Inactive referrals (not this month)
    $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE reference_no = ? AND status='3' AND (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))");
    $stmt4->execute([$id]);
    $inactiveCount = $stmt4->rowCount();

    $response[] = [
        'ca_customer_id' => $id,
        'name' => $firstName . ' ' . $lastName,
        'register_date' => $rdate,
        'profile_pic' => $prfilePic,
        'status' => $status,
        'total_referrals' => $count,
        // 'active profile' => $activeProfile,
        // 'inactive profile' => $inactiveProfile,
        'active_referrals' => $activeCount,
        'inactive_referrals' => $inactiveCount

    ];
}

// Final JSON output
echo json_encode([
    'status' => 'success',
    'data' => $response
]);
