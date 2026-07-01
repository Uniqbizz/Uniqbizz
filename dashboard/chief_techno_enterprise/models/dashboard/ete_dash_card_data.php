<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $sql = $conn->prepare("
        SELECT
            (
                (
                    SELECT COUNT(*)
                    FROM corporate_agency ca
                    INNER JOIN super_techno_enterprise st
                        ON ca.reference_no = st.super_techno_enterprise_id
                    INNER JOIN executive_techno_enterprise ete
                        ON st.reference_no = ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND ca.status IN (1,3)
                    AND st.status IN (1,3)
                    AND ete.status IN (1,3)
                )
                +
                (    SELECT COUNT(*)
                    FROM institution i
                    INNER JOIN executive_techno_enterprise ete
                        ON i.reference_no=ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND i.status IN (1,3)
                    AND ete.status IN (1,3)
                ) 
            ) AS te_count,
            (    SELECT COUNT(*)
                FROM super_techno_enterprise ste
                INNER JOIN executive_techno_enterprise ete
                    ON ste.reference_no=ete.executive_techno_enterprise_id
                WHERE ete.reference_no = :user_id
                AND ste.status IN (1,3)
                AND ete.status IN (1,3)
            ) AS ste_count,
            (    SELECT COUNT(*)
                FROM executive_techno_enterprise
                WHERE reference_no = :user_id
                AND status IN (1,3)
            ) AS ete_count,
            (
                (
                    SELECT COUNT(*)
                    FROM ca_travelagency ta
                    INNER JOIN corporate_agency ca
                        ON ta.reference_no = ca.corporate_agency_id
                    INNER JOIN super_techno_enterprise st
                        ON ca.reference_no = st.super_techno_enterprise_id
                    INNER JOIN executive_techno_enterprise ete
                        ON st.reference_no = ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                    AND st.status IN (1,3)
                    AND ete.status IN (1,3)
                )
                 +
                (
                    SELECT COUNT(*)
                    FROM institution_branch_manager ibr
                    INNER JOIN institution i
                        ON ibr.reference_no = i.institution_id
                    INNER JOIN executive_techno_enterprise ete
                        ON i.reference_no = ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND ibr.status IN (1,3)
                    AND i.status IN (1,3)
                    AND ete.status IN (1,3)
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
                    INNER JOIN super_techno_enterprise st
                        ON ca.reference_no = st.super_techno_enterprise_id
                    INNER JOIN executive_techno_enterprise ete
                        ON st.reference_no = ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ta.status IN (1,3)
                    AND ca.status IN (1,3)
                    AND st.status IN (1,3)
                    AND ete.status IN (1,3)
                )
                +
                (
                    SELECT COUNT(*)
                    FROM ca_customer cu
                    INNER JOIN institution_branch_manager ibr
                        ON cu.ta_reference_no = ibr.institution_branch_manager_id
                    INNER JOIN institution i
                        ON ibr.reference_no = i.institution_id
                    INNER JOIN executive_techno_enterprise ete
                        ON i.reference_no = ete.executive_techno_enterprise_id
                    WHERE ete.reference_no = :user_id
                    AND cu.status IN (1,3)
                    AND ibr.status IN (1,3)
                    AND i.status IN (1,3)
                    AND ete.status IN (1,3)
                )
            ) AS cu_count,

            (
                (
                    SELECT COALESCE(SUM(cte_amount),0)
                    FROM techno_enterprise_payout
                    WHERE cte_id = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(commission_cte),0)
                    FROM ca_cu_payout
                    WHERE cte_id = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(bch_amt),0)
                    FROM product_payout
                    WHERE bch_id = :user_id
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id
                )
            ) AS all_earning,
            (
                (
                    SELECT COALESCE(SUM(cte_amount),0)
                    FROM techno_enterprise_payout
                    WHERE cte_id = :user_id AND ete_status=2 
                )
                +
                (
                    SELECT COALESCE(SUM(commission_cte),0)
                    FROM ca_cu_payout
                    WHERE cte_id = :user_id AND status_cte=2
                )
                +
                (
                    SELECT COALESCE(SUM(bch_amt),0)
                    FROM product_payout
                    WHERE bch_id = :user_id AND bch_status=2
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id AND status_bm_mf_sf=2
                )
            ) AS all_pending_earning,
            (
                (
                    SELECT COALESCE(SUM(cte_amount),0)
                    FROM techno_enterprise_payout
                    WHERE cte_id = :user_id AND ste_status=1 
                )
                +
                (
                    SELECT COALESCE(SUM(commission_cte),0)
                    FROM ca_cu_payout
                    WHERE cte_id = :user_id AND status_cte=1
                )
                +
                (
                    SELECT COALESCE(SUM(bch_amt),0)
                    FROM product_payout
                    WHERE bch_id = :user_id AND bch_status=1
                )
                +
                (
                    SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                    FROM institution_payout
                    WHERE bm_mf_sf = :user_id AND status_bm_mf_sf=1
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
            'ste_count' => (int)$data['ste_count'],
            'ete_count' => (int)$data['ete_count'],
            'tc_count' => (int)$data['tc_count'],
            'cu_count' => (int)$data['cu_count'],
            'all_earning' => (int)$data['all_earning'],
            'all_paid_earning' => (int)$data['cu_count'],
            'all_pending_earning' => (int)$data['all_pending_earning'],
        ]
    ], JSON_PRETTY_PRINT);

    exit;
?>