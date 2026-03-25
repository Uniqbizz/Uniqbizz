<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Include your DB connection file
include '../../../connect.php'; // <-- replace with your actual DB connection

// Get input
// $userId = $_POST['userId'] ?? $_GET['userId'] ?? null;

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
 
// Get input
$userId = getData('userId');

// Current year and month
$DateYear = date('Y');
$DateMonth = date('m');

// Example TDS percentage (change as needed)
$tdsPercentage = 0.02; // 0.02

$response = [];

try {
    if (!$userId) {
        echo json_encode(["status" => "error", "message" => "userId is required"]);
        exit;
    }

    // ---------- Registered Customers ----------
    $stmt = $conn->prepare("SELECT COUNT(ca_customer_id) as total 
                            FROM ca_customer 
                            WHERE ta_reference_no = ? AND status = '1'");
    $stmt->execute([$userId]);
    $registeredTotal = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $stmt = $conn->prepare("SELECT COUNT(ca_customer_id) as total 
                            FROM ca_customer 
                            WHERE ta_reference_no = ? 
                            AND YEAR(register_date) = ? 
                            AND MONTH(register_date) = ? 
                            AND status = '1'");
    $stmt->execute([$userId, $DateYear, $DateMonth]);
    $registeredThisMonth = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // ---------- Completed Tours ----------
    $stmt = $conn->prepare("SELECT COUNT(ta_id) as total 
                            FROM product_payout 
                            WHERE ta_id = ? AND end_date < NOW()");
    $stmt->execute([$userId]);
    $completedTotal = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $stmt = $conn->prepare("SELECT COUNT(ta_id) as total 
                            FROM product_payout 
                            WHERE ta_id = ? 
                            AND end_date < NOW() 
                            AND YEAR(end_date) = ? 
                            AND MONTH(end_date) = ?");
    $stmt->execute([$userId, $DateYear, $DateMonth]);
    $completedThisMonth = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // ---------- Upcoming Tours ----------
    $stmt = $conn->prepare("SELECT COUNT(ta_id) as total 
                            FROM product_payout 
                            WHERE ta_id = ? AND start_date > NOW()");
    $stmt->execute([$userId]);
    $upcomingTotal = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $stmt = $conn->prepare("SELECT COUNT(ta_id) as total 
                            FROM product_payout 
                            WHERE ta_id = ? 
                            AND start_date > NOW() 
                            AND YEAR(start_date) = ? 
                            AND MONTH(start_date) = ?");
    $stmt->execute([$userId, $DateYear, $DateMonth]);
    $upcomingThisMonth = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // ---------- Commission Earned ----------
    // Pending
    $stmt = $conn->prepare("SELECT SUM(ta_amt) as amt 
                            FROM product_payout 
                            WHERE ta_id = ? AND ta_status = '2'");
    $stmt->execute([$userId]);
    $pendingAmt = $stmt->fetch(PDO::FETCH_ASSOC)['amt'] ?? 0;
    $finalAmtPending = number_format(floor(($pendingAmt - ($pendingAmt * $tdsPercentage)) * 100) / 100, 2);

    // Confirmed
    $stmt = $conn->prepare("SELECT SUM(ta_amt) as amt 
                            FROM product_payout 
                            WHERE ta_id = ? AND ta_status = '1'");
    $stmt->execute([$userId]);
    $confirmedAmt = $stmt->fetch(PDO::FETCH_ASSOC)['amt'] ?? 0;
    $finalAmtConfirm = number_format(floor(($confirmedAmt - ($confirmedAmt * $tdsPercentage)) * 100) / 100, 2);

    // ---------- JSON Response ----------
    $response = [
        "status" => "success",
        "data" => [
            "registered_customers" => [
                "total" => (int)$registeredTotal,
                "this_month" => (int)$registeredThisMonth
            ],
            "completed_tours" => [
                "total" => (int)$completedTotal,
                "this_month" => (int)$completedThisMonth
            ],
            "upcoming_tours" => [
                "total" => (int)$upcomingTotal,
                "this_month" => (int)$upcomingThisMonth
            ],
            "commission" => [
                "confirmed" => $finalAmtConfirm,
                "pending" => $finalAmtPending
            ]
        ]
    ];
} catch (Exception $e) {
    $response = ["status" => "error", "message" => $e->getMessage()];
}

echo json_encode($response);
