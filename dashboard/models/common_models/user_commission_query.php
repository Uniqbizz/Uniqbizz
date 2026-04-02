<?php
    if ($userType == '26') { //BM
       
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status = 1 AND business_mentor='".$userId."'  ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status = 1 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status = 1 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status = 1 AND bm_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status = 2 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status = 2 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status = 2 AND bm_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT (PAID + PENDING) */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status IN (1,2) AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status IN (1,2) AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status IN (1,2) AND bm_id='".$userId."' ),0)
                ) AS commission_all
            ");
    }elseif ($userType == '28') { //MF
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status = 1 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status = 1 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status = 1 AND bm_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status = 2 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status = 2 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status = 2 AND bm_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0)
                ) AS commission_all
            ");
    }elseif ($userType == '30') { //SF
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status = 1 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status = 1 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status = 1 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status = 1 AND bm_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status = 2 AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status = 2 AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status = 2 AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status = 2 AND bm_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) AND business_mentor='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status IN (1,2) AND master_franchisee='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status IN (1,2) AND bm_mf_sf='".$userId."' ),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status IN (1,2) AND bm_id='".$userId."' ),0)
                ) AS commission_all
            ");
    }elseif ($userType == '29') { //F
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status = 1 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status = 1 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status = 1 AND te_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status = 2 AND te_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status IN (1,2) AND te_id='".$userId."' ),0)
                ) AS commission_all;
            ");
    }elseif ($userType == '16') { //TE
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status = 1  AND techno_enterprise='".$userId."'),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status = 1  AND techno_enterprise='".$userId."'),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status = 1  AND te_id='".$userId."'),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status = 2 AND te_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status IN (1,2) AND te_id='".$userId."' ),0)
                ) AS commission_all;
            ");
    }elseif ($userType == '32') { //I
       $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status = 1 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status = 1 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status = 1 AND te_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status = 2 AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status = 2 AND te_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status IN (1,2) AND techno_enterprise='".$userId."' ),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status IN (1,2) AND te_id='".$userId."' ),0)
                ) AS commission_all;
            ");
    }elseif ($userType == '11') {
        $sqlCAP = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc) FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status = 1 AND travel_consultant='".$userId."' ),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status = 1 AND ta_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc) FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status = 2 AND travel_consultant='".$userId."' ),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status = 2 AND ta_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc)  FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status IN (1,2) AND travel_consultant='".$userId."' ),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status IN (1,2) AND ta_id='".$userId."' ),0)
                ) AS commission_all;
            ");
    }elseif ($userType == '10') {
        $sqlCAP = $conn->prepare("
                SELECT 

                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status = 1 AND cu1_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status = 1 AND cu2_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status = 1 AND cu3_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status = 1 AND customer_id='".$userId."' ),0)
                ) AS commission_paid_amount,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status = 2 AND cu1_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status = 2 AND cu2_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status = 2 AND cu3_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status = 2 AND customer_id='".$userId."' ),0)
                ) AS commission_pending_amount,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status IN (1,2) AND cu1_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status IN (1,2) AND cu2_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status IN (1,2) AND cu3_id='".$userId."' ),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status IN (1,2) AND customer_id='".$userId."' ),0)
                ) AS commission_all;
            ");
    }
?>