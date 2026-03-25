<?php
require '../../../connect.php';
header('Content-Type: application/json');

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
 
$user_id = getData('userId');
 
 
try {
    // Step 1: Fetch top 5 customers under this TC
    $stmt = $conn->prepare("
        SELECT ca_customer_id AS id, firstname, lastname, register_date
        FROM ca_customer
        WHERE ta_reference_no = ? AND status = '1'
        ORDER BY ca_customer_id DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    $topCustomers = [];
 
    // Step 2: For each customer, calculate total, active, and inactive counts
    foreach ($customers as $cust) {
        $id = $cust['id'];
 
        // Total referrals under this customer
        $totalStmt = $conn->prepare("SELECT COUNT(*) FROM ca_customer WHERE reference_no = ? AND status='1'");
        $totalStmt->execute([$id]);
        $totalCount = (int)$totalStmt->fetchColumn();
 
        // Active = registered this month
        $activeStmt = $conn->prepare("
            SELECT COUNT(*) FROM ca_customer
            WHERE reference_no = ? AND status='1'
              AND MONTH(register_date) = MONTH(CURDATE())
              AND YEAR(register_date) = YEAR(CURDATE())
        ");
        $activeStmt->execute([$id]);
        $activeCount = (int)$activeStmt->fetchColumn();
 
        // Inactive = registered in other months
        $inactiveStmt = $conn->prepare("
            SELECT COUNT(*) FROM ca_customer
            WHERE reference_no = ? AND status='1'
              AND NOT (MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE()))
        ");
        $inactiveStmt->execute([$id]);
        $inactiveCount = (int)$inactiveStmt->fetchColumn();
 
        $topCustomers[] = [
            "id" => $id,
            "name" => trim($cust['firstname'] . ' ' . $cust['lastname']),
            "register_date" => date('d-m-Y', strtotime($cust['register_date'])),
            "total_referrals" => $totalCount,
            "active_count" => $activeCount,
            "inactive_count" => $inactiveCount
        ];
    }
 
    echo json_encode([
        "status" => "success",
        "user_id" => $user_id,
        "top_customers" => $topCustomers
    ]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}