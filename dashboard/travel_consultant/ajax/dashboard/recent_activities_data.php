<?php

include_once(__DIR__.'/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $activities = [];

    /*
    |--------------------------------------------------------------------------
    | New Neo Select Customers Added (Pending)
    |--------------------------------------------------------------------------
    */

    $sqlPending = $conn->prepare("
        SELECT
            CONCAT(firstname,' ',lastname) AS name,
            added_on AS activity_date
        FROM ca_customer
        WHERE reference_no = :user_id
        AND status = 2
        ORDER BY added_on DESC
        LIMIT 6
    ");

    $sqlPending->execute([
        ':user_id' => $userId
    ]);

    foreach($sqlPending->fetchAll(PDO::FETCH_ASSOC) as $row){

        $activities[] = [
            'type'  => 'pending_customer',
            'title' => 'Added a new Neo Select Customer '.$row['name'],
            'date'  => $row['activity_date']
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Neo Select Customer Activated
    |--------------------------------------------------------------------------
    */

    $sqlActivated = $conn->prepare("
        SELECT
            CONCAT(firstname,' ',lastname) AS name,
            register_date AS activity_date
        FROM ca_customer
        WHERE reference_no = :user_id
        AND status = 1
        ORDER BY register_date DESC
        LIMIT 6
    ");

    $sqlActivated->execute([
        ':user_id' => $userId
    ]);

    foreach($sqlActivated->fetchAll(PDO::FETCH_ASSOC) as $row){

        $activities[] = [
            'type'  => 'customer_activation',
            'title' => $row['name'].' activated holiday account',
            'date'  => $row['activity_date']
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | New Booking
    |--------------------------------------------------------------------------
    */

    $sqlBooking = $conn->prepare("
        SELECT
            name AS customer_name,
            created_date
        FROM bookings
        WHERE ta_id = :user_id
        ORDER BY created_date DESC
        LIMIT 6
    ");

    $sqlBooking->execute([
        ':user_id' => $userId
    ]);

    foreach($sqlBooking->fetchAll(PDO::FETCH_ASSOC) as $row){

        $activities[] = [
            'type'  => 'booking',
            'title' => 'New booking from '.$row['customer_name'],
            'date'  => $row['created_date']
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Activation Commission
    |--------------------------------------------------------------------------
    */

    $sqlCommission = $conn->prepare("
        SELECT
            commision_tc,
            created_date
        FROM ca_cu_payout
        WHERE travel_consultant = :user_id
        ORDER BY created_date DESC
        LIMIT 6
    ");

    $sqlCommission->execute([
        ':user_id' => $userId
    ]);

    foreach($sqlCommission->fetchAll(PDO::FETCH_ASSOC) as $row){

        $activities[] = [
            'type'  => 'commission',
            'title' => 'Commission of + ₹ '.number_format($row['commision_tc'],2).' earned from activation',
            'date'  => $row['created_date']
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Latest 6 Activities
    |--------------------------------------------------------------------------
    */

    usort($activities, function($a, $b){

        return strtotime($b['date']) <=> strtotime($a['date']);

    });

    $activities = array_slice($activities, 0, 6);


    echo json_encode([
        'status' => true,
        'data'   => $activities
    ]);

} catch(Exception $e){

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data'    => []
    ]);

}