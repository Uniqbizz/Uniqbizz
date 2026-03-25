<?php
header('Content-Type: application/json');
require '../../../connect.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
$response = array("status" => false, "message" => "Something went wrong");

// Get inputs
$data = json_decode(file_get_contents("php://input"), true);
$userId = isset($data['userId']) ? $data['userId'] : '';
$dateYear = date('Y');
$dateMonth = date('m');
$tdsPercentage = 0.02;

if ($userId != '') {
    try {
        // 1. Registered Customers
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM ca_customer WHERE reference_no = ? AND status = 1");
        $stmt->execute([$userId]);
        $totalRegistered = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $conn->prepare("SELECT COUNT(*) AS monthly FROM ca_customer WHERE reference_no = ? AND status = 1 AND YEAR(register_date) = ? AND MONTH(register_date) = ?");
        $stmt->execute([$userId, $dateYear, $dateMonth]);
        $monthlyRegistered = $stmt->fetch(PDO::FETCH_ASSOC)['monthly'];

        // 2. Completed Tours
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM product_payout WHERE cu_id = ? AND end_date < NOW()");
        $stmt->execute([$userId]);
        $totalCompletedTours = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $conn->prepare("SELECT COUNT(*) AS monthly FROM product_payout WHERE cu_id = ? AND end_date < NOW() AND YEAR(end_date) = ? AND MONTH(end_date) = ?");
        $stmt->execute([$userId, $dateYear, $dateMonth]);
        $monthlyCompletedTours = $stmt->fetch(PDO::FETCH_ASSOC)['monthly'];

        // 3. Upcoming Tours
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM product_payout WHERE cu_id = ? AND start_date > NOW()");
        $stmt->execute([$userId]);
        $totalUpcomingTours = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $conn->prepare("SELECT COUNT(*) AS monthly FROM product_payout WHERE cu_id = ? AND start_date > NOW() AND YEAR(start_date) = ? AND MONTH(start_date) = ?");
        $stmt->execute([$userId, $dateYear, $dateMonth]);
        $monthlyUpcomingTours = $stmt->fetch(PDO::FETCH_ASSOC)['monthly'];

        // 4. Commissions (Confirmed & Pending)
        $confirmedAmt = 0;
        $pendingAmt = 0;
        $custIds = ['cu1', 'cu2', 'cu2'];

        foreach ($custIds as $custId) {
            $columnId = $custId . '_id';
            $columnAmt = $custId . '_amt';

            // Pending
            $stmt = $conn->prepare("SELECT SUM($columnAmt) AS amt FROM product_payout WHERE $columnId = ? AND {$custId}_status = '2'");
            $stmt->execute([$userId]);
            $pendingAmt += floatval($stmt->fetch(PDO::FETCH_ASSOC)['amt']);
        }

        // Confirmed commissions (example from `ta_id`)
        $stmt = $conn->prepare("SELECT SUM(ta_amt) AS amt FROM product_payout WHERE ta_id = ? AND ta_status = '1'");
        $stmt->execute([$userId]);
        $confirmedAmt += floatval($stmt->fetch(PDO::FETCH_ASSOC)['amt']);

        // TDS calculations
        $pendingTds = $pendingAmt * $tdsPercentage;
        $confirmedTds = $confirmedAmt * $tdsPercentage;

        $pendingFinal = floor(($pendingAmt - $pendingTds) * 100) / 100;
        $confirmedFinal = floor(($confirmedAmt - $confirmedTds) * 100) / 100;

        // ✅ Final JSON response
        $response = [
            "status" => true,
            "message" => "Dashboard data fetched successfully",
            "data" => [
                "registered_customers" => [
                    "total" => intval($totalRegistered),
                    "this_month" => intval($monthlyRegistered)
                ],
                "completed_tours" => [
                    "total" => intval($totalCompletedTours),
                    "this_month" => intval($monthlyCompletedTours)
                ],
                "upcoming_tours" => [
                    "total" => intval($totalUpcomingTours),
                    "this_month" => intval($monthlyUpcomingTours)
                ],
                "commission_earned" => [
                    "confirmed" => number_format($confirmedFinal, 2),
                    "pending" => number_format($pendingFinal, 2)
                ]
            ]
        ];
    } catch (Exception $e) {
        $response = ["status" => false, "message" => "Error: " . $e->getMessage()];
    }
} else {
    $response = ["status" => false, "message" => "Missing user_id"];
}

echo json_encode($response);
