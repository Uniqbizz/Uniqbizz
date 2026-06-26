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
                CONCAT(ca.firstname,' ',ca.lastname) AS name,
                ca.register_date AS activity_date
            FROM corporate_agency ca
            INNER JOIN super_techno_enterprise st
                ON ca.reference_no = st.super_techno_enterprise_id
            INNER JOIN executive_techno_enterprise ete
                ON st.reference_no = ete.executive_techno_enterprise_id
            WHERE ete.reference_no = :user_id
            AND ca.status IN (1,3)
            AND st.status IN (1,3)
            AND ete.status IN (1,3)
            ORDER BY ca.register_date DESC
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
        | New I Added
        |--------------------------------------------------------------------------
        */

        $sqlF = $conn->prepare("
            SELECT
                CONCAT(i.firstname,' ',i.lastname) AS name,
                i.register_date AS activity_date
            FROM institution i
            INNER JOIN executive_techno_enterprise ete
                ON i.reference_no=ete.executive_techno_enterprise_id
            WHERE ete.reference_no = :user_id
            AND i.status IN (1,3)
            AND ete.status IN (1,3)
            ORDER BY i.register_date DESC
            LIMIT 2
        ");

        $sqlF->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlF->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'I',
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
            SELECT
                CONCAT(cu.firstname,' ',cu.lastname) AS customer_name,
                cu.register_date
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
            ORDER BY cu.register_date DESC
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
                cte_amount,
                created_date
            FROM techno_enterprise_payout
            WHERE cte_id = :user_id
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
                'description' => '+ ₹ '.number_format($row['cte_amount']),
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
                commission_cte,
                created_date
            FROM ca_cu_payout
            WHERE cte_id = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlCRecruitment->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlCRecruitment->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'customer',
                'title' => 'Holiday Account Commission Credited',
                'description' => '+ ₹ '.number_format($row['commission_cte']),
                'date' => $row['created_date']
            ];
        }
        /*
        |--------------------------------------------------------------------------
        | Institution Recruitment Commission
        |--------------------------------------------------------------------------
        */

        $sqlFRecruitment = $conn->prepare("
            SELECT
                commission_emp,
                created_date
            FROM institution_payout
            WHERE employees = :user_id
            ORDER BY created_date DESC
            LIMIT 2
        ");

        $sqlFRecruitment->execute([
            ':user_id' => $userId
        ]);

        foreach($sqlFRecruitment->fetchAll(PDO::FETCH_ASSOC) as $row){

            $activities[] = [
                'type' => 'recruitment',
                'title' => 'Institution Recruitment Commission Credited',
                'description' => '+ ₹ '.number_format($row['commission_emp']),
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
                bch_amt,
                created_date
            FROM product_payout
            WHERE bch_id = :user_id
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
                'description' => '+ ₹ '.number_format($row['bch_amt']),
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