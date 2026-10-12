<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $activities = [];

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
            INNER JOIN institution ca
                ON ta.reference_no = ca.institution_id
            WHERE ca.reference_no = :user_id
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