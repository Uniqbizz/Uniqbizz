<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

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
                    INNER JOIN corporate_agency ca
                        ON ta.reference_no = ca.corporate_agency_id
                    WHERE ca.reference_no = :user_id
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
                    AND cu.status=1
                )
                +
                (
                    SELECT COALESCE(SUM(amount),0)
                    FROM ca_travelagency
                    WHERE reference_no = :user_id
                    AND status=1
                )
                +
                (
                    SELECT COALESCE(SUM(bd.total_net_payable),0)
                    FROM bookings b
                    INNER JOIN booking_direct_bill bd
                        ON bd.bookings_id = b.id AND bd.status=1
                    INNER JOIN ca_travelagency ta
                        ON b.ta_id = ta.ca_travelagency_id
                    WHERE ta.reference_no = :user_id
                )
            ) AS all_revenue,
            (
                (
                    SELECT COALESCE(SUM(commision_te),0)
                    FROM ca_cu_payout
                    WHERE techno_enterprise = :user_id AND status_te=2
                )
                +
                (
                    SELECT COALESCE(SUM(te_amt),0)
                    FROM product_payout
                    WHERE te_id = :user_id AND te_status=2
                )
            ) AS all_pending_earning,
            (
                (
                    SELECT COALESCE(SUM(commision_te),0)
                    FROM ca_cu_payout
                    WHERE techno_enterprise = :user_id AND status_te=1
                )
                +
                (
                    SELECT COALESCE(SUM(te_amt),0)
                    FROM product_payout
                    WHERE te_id = :user_id AND te_status=1
                )
            ) AS all_paid_earning
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',
        'data' => [
            'tc_count' => (int)$data['tc_count'],
            'cu_count' => (int)$data['cu_count'],
            'all_earning' => (int)$data['all_earning'],
            'all_revenue' => (int)$data['all_revenue'],
            'all_paid_earning' => (int)$data['cu_count'],
            'all_pending_earning' => (int)$data['all_pending_earning'],
        ]
    ], JSON_PRETTY_PRINT);

    exit;
?>