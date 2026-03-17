<?php

    require '../../connect.php';
    include '../../controllers/common_controllers/currency_function.php';

    $month = $_POST['month'];
    $year = $_POST['year'];
    $user = $_POST['user'];

    if($user == "bm"){
        $smallPrefix = "bm";
        $BigPrefix = "BM";
        $tableName = "business_mentor";
        $tableId = "business_mentor_id";
        $userType = "26";
    }else if($user == "mf"){
        $smallPrefix = "mf";
        $BigPrefix = "MF";
        $tableName = "master_franchisee";
        $tableId = "master_franchisee_id";
        $userType = "28";
    }else if($user == "sf"){
        $smallPrefix = "sf";
        $BigPrefix = "SF";
        $tableName = "sponsor_franchisee";
        $tableId = "sponsor_franchisee_id";
        $userType = "30";
    }else if($user == "te"){
        $smallPrefix = "te";
        $BigPrefix = "TE";
        $tableName = "corporate_agency";
        $tableId = "corporate_agency_id";
        $userType = "16";
    }else if($user == "sub_f"){
        $smallPrefix = "subf";
        $BigPrefix = "SUBF";
        $tableName = "sub_franchisee";
        $tableId = "sub_franchisee_id";
        $userType = "29";
    }else if($user == "ins"){
        $smallPrefix = "ins";
        $BigPrefix = "INS";
        $tableName = "institution";
        $tableId = "institution_id";
        $userType = "32";
    }else if($user == "tc"){
        $smallPrefix = "tc";
        $BigPrefix = "TC";
        $tableName = "ca_travelagency";
        $tableId = "ca_travelagency_id";
        $userType = "11";
    }else if($user == "cu"){
        $smallPrefix = "cu";
        $BigPrefix = "CU";
        $tableName = "ca_customer";
        $tableId = "ca_customer_id";
        $userType = "10";
    }

    // $filter variable for getting user count and revenue, $filter2 variable for commission calculations
    if(!empty($month) && !empty($year)){
        $filter = " AND MONTH($smallPrefix.register_date) = '$month' AND YEAR($smallPrefix.register_date) = '$year' ";
        $filterRef = " AND MONTH(register_date) = '$month' AND YEAR(register_date) = '$year' ";

    }else{
        $filter = "";
        $filterRef = "";
    }

    

    if($user == 'bm' || $user == 'mf' || $user == 'sf'){
        $stmt = $conn->prepare("
            SELECT 
                $smallPrefix.$tableId AS user_id,
                $smallPrefix.firstname AS user_fname,
                $smallPrefix.lastname AS user_lname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status,

                COUNT(ref.user_id) AS total_references,
                SUM(ref.amount) AS total_revenue

            FROM $tableName $smallPrefix

            LEFT JOIN (

                /* Techno Enterprises */
                SELECT 
                    corporate_agency_id AS user_id,
                    reference_no,
                    amount,
                    register_date
                FROM corporate_agency
                WHERE user_type = 16 $filterRef

                UNION ALL

                /* Franchisees */
                SELECT 
                    sub_franchisee_id AS user_id,
                    reference_no,
                    amount,
                    register_date
                FROM sub_franchisee
                WHERE user_type = 29 $filterRef

                UNION ALL

                /* Institutions */
                SELECT 
                    institution_id AS user_id,
                    reference_no,
                    amount,
                    register_date
                FROM institution
                WHERE user_type = 32 $filterRef

            ) ref ON $smallPrefix.$tableId = ref.reference_no

            WHERE $smallPrefix.user_type = $userType 
            AND $smallPrefix.status = '1' 
            $filter

            GROUP BY 
                $smallPrefix.$tableId,
                $smallPrefix.firstname,
                $smallPrefix.lastname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status

            ORDER BY total_references DESC, total_revenue DESC
            LIMIT 5;
        ");
    }else if($user == 'te' || $user == 'sub_f' || $user == 'ins'){
        $stmt = $conn->prepare("
            SELECT 
                $smallPrefix.$tableId AS user_id,
                $smallPrefix.firstname AS user_fname,
                $smallPrefix.lastname AS user_lname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status,

                COUNT(ref.user_id) AS total_references,
                SUM(ref.amount) AS total_revenue

            FROM $tableName $smallPrefix

            LEFT JOIN (

                /* travel agency */
                SELECT 
                    ca_travelagency_id AS user_id,
                    reference_no,
                    amount,
                    register_date
                FROM ca_travelagency
                WHERE user_type = 11 $filterRef

            ) ref ON $smallPrefix.$tableId = ref.reference_no

            WHERE $smallPrefix.user_type = $userType 
            AND $smallPrefix.status = '1' 
            $filter

            GROUP BY 
                $smallPrefix.$tableId,
                $smallPrefix.firstname,
                $smallPrefix.lastname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status

            ORDER BY total_references DESC, total_revenue DESC
            LIMIT 5;
        ");
    }else if($user == 'tc'){
        $stmt = $conn->prepare("
            SELECT 
                $smallPrefix.$tableId AS user_id,
                $smallPrefix.firstname AS user_fname,
                $smallPrefix.lastname AS user_lname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status,

                COUNT(ref.user_id) AS total_references,
                SUM(ref.paid_amount) AS total_revenue

            FROM $tableName $smallPrefix

            LEFT JOIN (

                /* Customer */
                SELECT 
                    ca_customer_id AS user_id,
                    reference_no,
                    paid_amount,
                    register_date
                FROM ca_customer
                WHERE user_type = 10 $filterRef

            ) ref ON $smallPrefix.$tableId = ref.reference_no

            WHERE $smallPrefix.user_type = $userType 
            AND $smallPrefix.status = '1' 
            $filter

            GROUP BY 
                $smallPrefix.$tableId,
                $smallPrefix.firstname,
                $smallPrefix.lastname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status

            ORDER BY total_references DESC, total_revenue DESC
            LIMIT 5;
        ");
    }else if($user == 'cu'){
        $stmt = $conn->prepare("
            SELECT 
                $smallPrefix.$tableId AS user_id,
                $smallPrefix.firstname AS user_fname,
                $smallPrefix.lastname AS user_lname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status,

                COUNT(ref.user_id) AS total_references,
                SUM(ref.paid_amount) AS total_revenue

            FROM $tableName $smallPrefix

            LEFT JOIN (

                /* travel agency */
                SELECT 
                    ca_customer_id AS user_id,
                    reference_no,
                    paid_amount,
                    register_date
                FROM ca_customer
                WHERE user_type = 10 $filterRef

            ) ref ON $smallPrefix.$tableId = ref.reference_no

            WHERE $smallPrefix.user_type = $userType 
            AND $smallPrefix.status = '1' 
            $filter

            GROUP BY 
                $smallPrefix.$tableId,
                $smallPrefix.firstname,
                $smallPrefix.lastname,
                $smallPrefix.reference_no,
                $smallPrefix.registrant,
                $smallPrefix.profile_pic,
                $smallPrefix.status

            ORDER BY total_references DESC, total_revenue DESC
            LIMIT 5;
        ");
    }

    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount() > 0 ){
        foreach($stmt -> fetchAll() as $bm_user){
            echo '
                <tr>
                    <td class="py-2 align-content-center">
                        <p class="text-dark fs-6 text-center ps-2">'.htmlspecialchars($bm_user['user_id']) . ' </p>
                    </td>
                    <td class="py-2 align-content-center">
                        <p class="text-dark text-center fs-6">'.htmlspecialchars($bm_user['user_fname'] . ' ' . $bm_user['user_lname']).'</p>
                    </td>
                    <td class="py-2 align-content-center">
                        <p class="text-dark fs-6 text-end">'.htmlspecialchars($bm_user['total_references']).'</p>
                    </td>
                    <td class="py-2 align-content-center">
                        <p class="text-success fs-6 text-end">&#8377;'.htmlspecialchars(formatIndianCurrency($bm_user['total_revenue'])).'</p>
                    </td>
                </tr>
            ';
        }
    }else{
        echo'
            <tr>
                <td class="text-success fs-6" colspan="4"> <p> No Data Found </p> </td>
            </tr>
        ';
    }
?>