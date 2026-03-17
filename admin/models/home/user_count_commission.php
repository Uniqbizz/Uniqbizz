<?php  
    require '../../connect.php';
    include '../../controllers/common_controllers/currency_function.php';

    $month = $_POST['month'];
    $year = $_POST['year'];

    // $filter variable for getting user count and revenue, $filter2 variable for commission calculations
    if(!empty($month) && !empty($year)){
        $filter = " AND MONTH(register_date) = '$month' AND YEAR(register_date) = '$year' ";
        $filter2 = " AND MONTH(created_date) = '$month' AND YEAR(created_date) = '$year' ";
    }else{
        $filter = "";
        $filter2 = "";
    }

    // Small Optimization

    // Instead of:

    // MONTH(created_date) = '$month'
    // AND YEAR(created_date) = '$year'

    // Use BETWEEN (faster because it uses indexes).

    // Example:
    // $startDate = "$year-$month-01";
    // $endDate = date("Y-m-t", strtotime($startDate));
    // $filter = " AND register_date BETWEEN '$startDate' AND '$endDate' ";
    // $filter2 = " AND created_date BETWEEN '$startDate' AND '$endDate' ";

    // This makes dashboard queries much faster on large tables.
?>

<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-primary-subtle rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users text-primary-emphasis"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Business Mentors</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(business_mentor_id) AS total_users_bm FROM business_mentor WHERE user_type='26' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_bm = $row['total_users_bm'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_bm.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_bm FROM business_mentor WHERE user_type='26' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_bm = $row['total_users_revenue_bm'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_bm).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_bm,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_bm,

                /* TOTAL AMOUNT (PAID + PENDING) */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'BM%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'BM%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'BM%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'BM%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_bm
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_bm = $row['commission_paid_amount_bm'] ?? 0;
            $commission_pending_amount_bm = $row['commission_pending_amount_bm'] ?? 0;
            $commission_all_bm = $row['commission_all_bm'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_bm).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Master Franchisees</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(master_franchisee_id) AS total_users_mf FROM master_franchisee WHERE user_type='28' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_mf = $row['total_users_mf'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_mf.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_mf FROM master_franchisee WHERE user_type='28' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_mf = $row['total_users_revenue_mf'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_mf).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_mf,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status = 2 $filter2),0)
                ) AS commission_paid_amount_mf,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'MF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'MF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'MF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'MF%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_mf
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_mf = $row['commission_paid_amount_mf'] ?? 0;
            $commission_pending_amount_mf = $row['commission_pending_amount_mf'] ?? 0;
            $commission_all_mf = $row['commission_all_mf'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_mf).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Sponsor Franchisees</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(sponsor_franchisee_id) AS total_users_sf FROM sponsor_franchisee WHERE user_type='30' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_sf = $row['total_users_sf'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_sf.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_sf FROM sponsor_franchisee WHERE user_type='30' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_sf = $row['total_users_revenue_sf'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_sf).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_sf,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_sf,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_ta_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_bm) FROM ca_cu_payout WHERE business_mentor LIKE 'SF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_mf) FROM sub_franchisee_payout WHERE master_franchisee LIKE 'SF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commission_bm_mf_sf) FROM institution_payout WHERE bm_mf_sf LIKE 'SF%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(bm_amt) FROM product_payout WHERE bm_id LIKE 'SF%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_sf
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_sf = $row['commission_paid_amount_sf'] ?? 0;
            $commission_pending_amount_sf = $row['commission_pending_amount_sf'] ?? 0;
            $commission_all_sf = $row['commission_all_sf'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_sf).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-danger rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Techno Enterprises</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(corporate_agency_id) AS total_users_te FROM corporate_agency WHERE user_type='16' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_te = $row['total_users_te'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_te.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_te FROM corporate_agency WHERE user_type='16' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_te = $row['total_users_revenue_te'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_te).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_te,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_te,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'TE%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'TE%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'TE%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_te;
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_te = $row['commission_paid_amount_te'] ?? 0;
            $commission_pending_amount_te = $row['commission_pending_amount_te'] ?? 0;
            $commission_all_te = $row['commission_all_te'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_te).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Franchisees</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(sub_franchisee_id) AS total_users_sub_f FROM sub_franchisee WHERE user_type='29' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_sub_f = $row['total_users_sub_f'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_sub_f.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_sub_f FROM sub_franchisee WHERE user_type='29' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_sub_f = $row['total_users_revenue_sub_f'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_sub_f).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_sub_f,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_sub_f,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'F%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'F%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'F%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_sub_f;
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_sub_f = $row['commission_paid_amount_sub_f'] ?? 0;
            $commission_pending_amount_sub_f = $row['commission_pending_amount_sub_f'] ?? 0;
            $commission_all_sub_f = $row['commission_all_sub_f'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_sub_f).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Institution</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(institution_id) AS total_users_ins FROM institution WHERE user_type='32' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_ins = $row['total_users_ins'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_ins.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_ins FROM institution WHERE user_type='32' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_ins = $row['total_users_revenue_ins'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_ins).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_ins,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(commision_te) FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_ins,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_te) FROM ca_ta_payout WHERE techno_enterprise LIKE 'I%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(commision_te)  FROM ca_cu_payout WHERE techno_enterprise LIKE 'I%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(te_amt) FROM product_payout WHERE te_id LIKE 'I%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_ins;
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_ins = $row['commission_paid_amount_ins'] ?? 0;
            $commission_pending_amount_ins = $row['commission_pending_amount_ins'] ?? 0;
            $commission_all_ins = $row['commission_all_ins'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_ins).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-info rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users" style="color: #ffffff;"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Travel Consultants</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(ca_travelagency_id) AS total_users_tc FROM ca_travelagency WHERE user_type='11' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_tc = $row['total_users_tc'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_tc.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_tc FROM ca_travelagency WHERE user_type='11' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_tc = $row['total_users_revenue_tc'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_tc).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 
                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc) FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_tc,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc) FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_tc,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(commision_tc)  FROM ca_cu_payout WHERE travel_consultant LIKE 'TA%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(ta_amt) FROM product_payout WHERE ta_id LIKE 'TA%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_tc;
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_tc = $row['commission_paid_amount_tc'] ?? 0;
            $commission_pending_amount_tc = $row['commission_pending_amount_tc'] ?? 0;
            $commission_all_tc = $row['commission_all_tc'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_tc).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="d-flex py-2 align-content-center">
        <div class="bg-info-subtle rounded-circle d-flex justify-content-center align-items-center" style="width: 37px; height: 35px;">
            <i class="fa-solid fa-users text-info-emphasis"></i>
        </div>
        <p class="text-dark fs-5 align-content-center ps-2">Customers</p>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT COUNT(ca_customer_id) AS total_users_cu FROM ca_customer WHERE user_type='10' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_cu = $row['total_users_cu'] ?? 0;
            echo '<p class="text-dark fs-5">'.$total_users_cu.'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_cu FROM ca_customer WHERE user_type='10' AND status='1' $filter ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_users_revenue_cu = $row['total_users_revenue_cu'] ?? 0;
            echo '<p class="text-dark fs-5 text-end">'.formatIndianCurrency($total_users_revenue_cu).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-center">
        <?php
            $stmt = $conn->prepare("
                SELECT 

                /* PAID AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status = 1 $filter2),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status = 1 $filter2),0)
                ) AS commission_paid_amount_cu,

                /* PENDING AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status = 2 $filter2),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status = 2 $filter2),0)
                ) AS commission_pending_amount_cu,

                /* TOTAL AMOUNT */
                (
                    COALESCE((SELECT SUM(cu1_amt) FROM product_payout WHERE cu1_id LIKE 'CU%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(cu2_amt) FROM product_payout WHERE cu2_id LIKE 'CU%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(cu3_amt) FROM product_payout WHERE cu3_id LIKE 'CU%' AND status IN (1,2) $filter2),0) +
                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE customer_id LIKE 'CU%' AND status IN (1,2) $filter2),0)
                ) AS commission_all_cu;
            ");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $commission_paid_amount_cu = $row['commission_paid_amount_cu'] ?? 0;
            $commission_pending_amount_cu = $row['commission_pending_amount_cu'] ?? 0;
            $commission_all_cu = $row['commission_all_cu'] ?? 0;
            echo '<p class="text-success fs-5 text-end">&#8377;'.formatIndianCurrency($commission_all_cu).'</p>';
        ?>
    </td>
</tr>
<tr>
    <td class="py-2 align-content-top">
        
        <p class="text-dark fs-5 d-flex justify-content-end fw-bolder ps-2">TOTAL :</p>
    </td>
    <td class="py-2 align-content-top">
        <?php
            //total user count
            $totalUsers = $total_users_bm + $total_users_mf + $total_users_sf + $total_users_te + $total_users_sub_f + $total_users_ins + $total_users_tc + $total_users_cu;
            echo '<p class="text-dark fs-5 fw-bolder">'. $totalUsers .'</p>';
        ?>
        
    </td>
    <td class="py-2 align-content-top">
        <?php 
            //total revenue
            $totalUsersRevenue = $total_users_revenue_bm + $total_users_revenue_mf + $total_users_revenue_sf + $total_users_revenue_te + $total_users_revenue_sub_f + $total_users_revenue_ins + $total_users_revenue_tc + $total_users_revenue_cu;      
            echo '<p class="text-dark fs-5 fw-bolder text-end">&#8377;' .formatIndianCurrency($totalUsersRevenue).'</p>';
        ?>
    </td>
    <td class="py-2 align-content-top">
        <?php  
            //total commission
            $commission_all = $commission_all_bm + $commission_all_mf + $commission_all_sf + $commission_all_te + $commission_all_sub_f + $commission_all_ins + $commission_all_tc + $commission_all_cu;
            echo '<p class="text-success fs-5 fw-bolder text-end">&#8377;'.formatIndianCurrency($commission_all).'</p>';
        ?>
        <!-- 09-03-2026 -->
        <?php   
            $paid_commission = $commission_paid_amount_bm + $commission_paid_amount_mf + $commission_paid_amount_sf + $commission_paid_amount_te + $commission_paid_amount_sub_f + $commission_paid_amount_ins + $commission_paid_amount_tc + $commission_paid_amount_cu;
            echo '<p class="text-primary fs-6 fw-bolder text-end mb-n1"><span class="text-dark">PAID: &nbsp;&nbsp;</span>&#8377;' .formatIndianCurrency($paid_commission). '</p>';
        ?>
        <?php 
            $pending_commission = $commission_pending_amount_bm + $commission_pending_amount_mf + $commission_pending_amount_sf + $commission_pending_amount_te + $commission_pending_amount_sub_f + $commission_pending_amount_ins + $commission_pending_amount_tc + $commission_pending_amount_cu;
            echo '<p class="text-primary fs-6 fw-bolder text-end mb-n1"><span class="text-dark">PENDING: &nbsp;&nbsp;</span>&#8377;' .formatIndianCurrency($pending_commission). '</p>';
        ?>
    </td>
</tr>  