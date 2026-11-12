<?php

require '../../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method.",
        "data" => []
    ]);
    exit;
}

try {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    if (!isset($data['userId']) || empty(trim($data['userId']))) {
        throw new Exception("User ID is required.");
    }

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | Dashboard Summary
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
            (
                (
                    SELECT COUNT(*)
                    FROM ca_travelagency
                    WHERE reference_no = :user_id
                    AND status IN (1,3)
                )
            ) AS tc_count,

            (
                (
                    SELECT COUNT(*)
                    FROM ca_customer cu
                    INNER JOIN ca_travelagency ta
                        ON cu.ta_reference_no = ta.ca_travelagency_id
                    INNER JOIN sub_franchisee ca
                        ON ta.reference_no = ca.sub_franchisee_id
                    WHERE ta.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                )
            ) AS cu_count,

            (
                (
                    SELECT COALESCE(SUM(commision_te),0)
                    FROM ca_cu_payout
                    WHERE techno_enterprise = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(te_amt),0)
                    FROM product_payout
                    WHERE te_id = :user_id
                )
            ) AS all_earning,

            (
                (
                    SELECT COALESCE(SUM(cu.paid_amount),0)
                    FROM ca_customer cu
                    INNER JOIN ca_travelagency ta
                        ON cu.ta_reference_no = ta.ca_travelagency_id
                    WHERE ta.reference_no = :user_id
                    AND cu.status = 1
                )
                +
                (
                    SELECT COALESCE(SUM(amount),0)
                    FROM ca_travelagency
                    WHERE reference_no = :user_id
                    AND status = 1
                )
                +
                (
                    SELECT COALESCE(SUM(bd.total_net_payable),0)
                    FROM bookings b
                    INNER JOIN booking_direct_bill bd
                        ON bd.bookings_id = b.id
                        AND bd.status = 1
                    INNER JOIN ca_travelagency ta
                        ON b.ta_id = ta.ca_travelagency_id
                    WHERE ta.reference_no = :user_id
                )
            ) AS all_revenue,

            (
                (
                    SELECT COALESCE(SUM(commision_te),0)
                    FROM ca_cu_payout
                    WHERE techno_enterprise = :user_id
                    AND status_te = 2
                )
                +
                (
                    SELECT COALESCE(SUM(te_amt),0)
                    FROM product_payout
                    WHERE te_id = :user_id
                    AND te_status = 2
                )
            ) AS all_pending_earning,

            (
                (
                    SELECT COALESCE(SUM(commision_te),0)
                    FROM ca_cu_payout
                    WHERE techno_enterprise = :user_id
                    AND status_te = 1
                )
                +
                (
                    SELECT COALESCE(SUM(te_amt),0)
                    FROM product_payout
                    WHERE te_id = :user_id
                    AND te_status = 1
                )
            ) AS all_paid_earning
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $result = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("No data found.");
    }

    echo json_encode([
        "status" => true,
        "message" => "Data fetched successfully.",
        "data" => [
            "tc_count" => (int)$result['tc_count'],
            "cu_count" => (int)$result['cu_count'],
            "total_revenue" => (int)$result['all_revenue'],
            "total_commission" => (int)$result['all_earning']
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);

}

exit;