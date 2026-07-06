<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $sql = $conn->prepare("
        SELECT
            (
                SELECT COUNT(*)
                FROM corporate_agency
                WHERE reference_no = :user_id
                AND status IN (1,3)
            )AS te_count,
            (   SELECT COUNT(*)
                FROM sub_franchisee
                WHERE reference_no = :user_id
                AND status IN (1,3)
            ) fcount,
            (   SELECT COUNT(*)
                FROM institution
                WHERE reference_no = :user_id
                AND status IN (1,3)
            ) icount,
            (
                (
                    SELECT COUNT(*)
                    FROM ca_travelagency ta
                    INNER JOIN corporate_agency ca
                        ON ta.reference_no = ca.corporate_agency_id
                    WHERE ca.reference_no = :user_id
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                )
                +
                (
                    SELECT COUNT(*)
                    FROM ca_travelagency ta
                    INNER JOIN sub_franchisee ca
                        ON ta.reference_no = ca.sub_franchisee_id
                    WHERE ca.reference_no = :user_id
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                )
            ) AS tc_count,
            (
                SELECT COUNT(*)
                FROM institution_branch_manager ta
                INNER JOIN institution ca
                    ON ta.reference_no = ca.institution_id
                WHERE ca.reference_no = :user_id
                AND ta.status IN (1,3)
                AND ca.status IN (1,3)
            ) AS ibr_count,

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
                +
                (
                    SELECT COUNT(*)
                    FROM ca_customer cu
                    INNER JOIN ca_travelagency ta
                        ON cu.ta_reference_no = ta.ca_travelagency_id
                    INNER JOIN sub_franchisee ca
                        ON ta.reference_no = ca.sub_franchisee_id
                    WHERE ca.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                )
                +
                (
                    SELECT COUNT(*)
                    FROM ca_customer cu
                    INNER JOIN ca_travelagency ta
                        ON cu.ta_reference_no = ta.ca_travelagency_id
                    WHERE ta.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ta.status IN (1,3)
                )
                +
                (
                    SELECT COUNT(*)
                    FROM ca_customer cu
                    INNER JOIN institution_branch_manager ta
                        ON cu.ta_reference_no = ta.institution_branch_manager_id
                    INNER JOIN institution ca
                        ON ta.reference_no = ca.institution_id
                    WHERE ca.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                )
            ) AS cu_count,

            (
                (
                    SELECT COALESCE(SUM(business_package_amount),0)
                    FROM goa_bm_payout
                    WHERE bm_id = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id 
                )
                +
                (
                    SELECT COALESCE(SUM(commission_mf),0)
                    FROM sub_franchisee_payout
                    WHERE master_franchisee = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(commision_bm),0)
                    FROM ca_cu_payout
                    WHERE business_mentor = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(bm_amt),0)
                    FROM product_payout
                    WHERE bm_id = :user_id
                )
            ) AS all_earning,
            (
                (
                    SELECT COALESCE(SUM(business_package_amount),0)
                    FROM goa_bm_payout
                    WHERE bm_id = :user_id AND status=2 
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id AND status_bm_mf_sf=2
                )
                +
                (
                    SELECT COALESCE(SUM(commission_mf),0)
                    FROM sub_franchisee_payout
                    WHERE master_franchisee = :user_id AND status_mf=2
                )
                +
                (
                    SELECT COALESCE(SUM(commision_bm),0)
                    FROM ca_cu_payout
                    WHERE business_mentor = :user_id AND status_bm=2
                )
                +
                (
                    SELECT COALESCE(SUM(bm_amt),0)
                    FROM product_payout
                    WHERE bm_id = :user_id AND bm_status=2
                )
            ) AS all_pending_earning,
            (
                (
                    SELECT COALESCE(SUM(business_package_amount),0)
                    FROM goa_bm_payout
                    WHERE bm_id = :user_id AND status=1 
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id AND status_bm_mf_sf=1
                )
                +
                (
                    SELECT COALESCE(SUM(commission_mf),0)
                    FROM sub_franchisee_payout
                    WHERE master_franchisee = :user_id AND status_mf=1
                )
                +
                (
                    SELECT COALESCE(SUM(commision_bm),0)
                    FROM ca_cu_payout
                    WHERE business_mentor = :user_id AND status_bm=1
                )
                +
                (
                    SELECT COALESCE(SUM(bm_amt),0)
                    FROM product_payout
                    WHERE bm_id = :user_id AND bm_status=1
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
            'te_count' => (int)$data['te_count'],
            'i_count' => (int)$data['icount'],
            'f_count' => (int)$data['fcount'],
            'tc_count' => (int)$data['tc_count'],
            'ibr_count' => (int)$data['ibr_count'],
            'cu_count' => (int)$data['cu_count'],
            'all_earning' => (int)$data['all_earning'],
            'all_paid_earning' => (int)$data['all_paid_earning'],
            'all_pending_earning' => (int)$data['all_pending_earning'],
        ]
    ], JSON_PRETTY_PRINT);

    exit;
?>