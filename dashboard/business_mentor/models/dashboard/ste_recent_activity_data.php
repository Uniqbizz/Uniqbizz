<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $activities = [];

        /*
        |--------------------------------------------------------------------------
        | New TE Added
        |--------------------------------------------------------------------------
        */

        $sqlTE = $conn->prepare("
            SELECT
                CONCAT(firstname,' ',lastname) AS name,
                register_date AS activity_date
            FROM corporate_agency
            WHERE reference_no = :user_id
            AND status IN (1,3)
            ORDER BY register_date DESC
            LIMIT 2
        ");

        $sqlTE->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlTE->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'te',
                'title' => 'New Techno Enterprise Added',
                'description' => $row['name'],
                'date' => $row['activity_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | New F Added
        |--------------------------------------------------------------------------
        */

        $sqlF = $conn->prepare("
            SELECT
                CONCAT(firstname,' ',lastname) AS name,
                register_date AS activity_date
            FROM sub_franchisee
            WHERE reference_no = :user_id
            AND status IN (1,3)
            ORDER BY register_date DESC
            LIMIT 2
        ");

        $sqlF->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlF->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'f',
                'title' => 'New Franchisee Added',
                'description' => $row['name'],
                'date' => $row['activity_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | New I Added
        |--------------------------------------------------------------------------
        */

        $sqlI = $conn->prepare("
            SELECT
                CONCAT(firstname,' ',lastname) AS name,
                register_date AS activity_date
            FROM institution
            WHERE reference_no = :user_id
            AND status IN (1,3)
            ORDER BY register_date DESC
            LIMIT 2
        ");

        $sqlI->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlI->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'i',
                'title' => 'New Institution Added',
                'description' => $row['name'],
                'date' => $row['activity_date']
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Neo Select Members
        |--------------------------------------------------------------------------
        */

        $sqlCU = $conn->prepare("
        SELECT *
        FROM (
            SELECT
                CONCAT(cu.firstname,' ',cu.lastname) AS customer_name,
                cu.register_date
            FROM ca_customer cu
            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id
            INNER JOIN sub_franchisee ca
                ON ta.reference_no = ca.sub_franchisee_id
            WHERE ca.reference_no = :user_id
            AND cu.status IN (1,3)

            UNION ALL

            SELECT
                CONCAT(cu.firstname,' ',cu.lastname) AS customer_name,
                cu.register_date
            FROM ca_customer cu
            INNER JOIN institution_branch_manager ta
                ON cu.ta_reference_no = ta.institution_branch_manager_id
            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id
            WHERE ca.reference_no = :user_id
            AND cu.status IN (1,3)

            UNION ALL

            SELECT
                CONCAT(cu.firstname,' ',cu.lastname) AS customer_name,
                cu.register_date
            FROM ca_customer cu
            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id
            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id
            WHERE ca.reference_no = :user_id
            AND cu.status IN (1,3)

            UNION ALL

            SELECT
                CONCAT(cu.firstname,' ',cu.lastname) AS customer_name,
                cu.register_date
            FROM ca_customer cu
            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id
            INNER JOIN business_mentor ca
                ON ta.reference_no = ca.business_mentor_id
            WHERE ta.reference_no = :user_id
            AND cu.status IN (1,3)
        ) AS customers
        ORDER BY register_date DESC
        LIMIT 2
        ");

        $sqlCU->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlCU->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'customer',
                'title' => 'New Select Membership Purchased',
                'description' => $row['customer_name'],
                'date' => $row['register_date']
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | TE Recruitment Commission
        |--------------------------------------------------------------------------
        */

        $sqlRecruitment = $conn->prepare("
            SELECT
                business_package_amount,
                created_date
            FROM goa_bm_payout
            WHERE bm_id = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlRecruitment->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlRecruitment->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'recruitment',
                'title' => 'TE Recruitment Commission Credited',
                'description' => '+ ₹ '.number_format($row['business_package_amount']),
                'date' => $row['created_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | Francisee Recruitment Commission
        |--------------------------------------------------------------------------
        */

        $sqlFRecruitment = $conn->prepare("
            SELECT
                commission_mf,
                created_date
            FROM sub_franchisee_payout
            WHERE master_franchisee = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlFRecruitment->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlFRecruitment->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'recruitment',
                'title' => 'Franchisee Recruitment Commission Credited',
                'description' => '+ ₹ '.number_format($row['commission_mf']),
                'date' => $row['created_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | Holiday Account Commission
        |--------------------------------------------------------------------------
        */

        $sqlCRecruitment = $conn->prepare("
            SELECT
                commision_bm,
                created_date
            FROM ca_cu_payout
            WHERE business_mentor = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlCRecruitment->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlCRecruitment->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'customerc',
                'title' => 'Holiday Account Commission Credited',
                'description' => '+ ₹ '.number_format($row['commision_bm']),
                'date' => $row['created_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | Booking Commission
        |--------------------------------------------------------------------------
        */

        $sqlBooking = $conn->prepare("
            SELECT
                bm_amt,
                created_date
            FROM product_payout
            WHERE bm_id = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlBooking->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlBooking->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'booking',
                'title' => 'Booking Commission Credited',
                'description' => '+ ₹ '.number_format($row['bm_amt']),
                'date' => $row['created_date']
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Sort Latest First
        |--------------------------------------------------------------------------
        */

        usort($activities, function ($a, $b) {
            return strtotime($b['date']) <=> strtotime($a['date']);
        });

        $activities = array_slice($activities, 0, 5);

        echo json_encode([
            'status' => true,
            'data' => $activities
        ]);

    } catch(Exception $e){

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>