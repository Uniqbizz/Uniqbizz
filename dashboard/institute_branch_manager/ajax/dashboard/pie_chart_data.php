<?php

include_once(__DIR__.'/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    // Activation Commission
    $sqlActivation = $conn->prepare("
        SELECT COALESCE(SUM(commision_tc),0) AS activation_commission
        FROM ca_cu_payout
        WHERE travel_consultant = :user_id
    ");

    $sqlActivation->execute([
        ':user_id' => $userId
    ]);

    $activation = (float)$sqlActivation->fetch(PDO::FETCH_ASSOC)['activation_commission'];


    // Trip Commission
    $sqlTrip = $conn->prepare("
        SELECT COALESCE(SUM(ta_amt),0) AS trip_commission
        FROM product_payout
        WHERE ta_id = :user_id
    ");

    $sqlTrip->execute([
        ':user_id' => $userId
    ]);

    $trip = (float)$sqlTrip->fetch(PDO::FETCH_ASSOC)['trip_commission'];

    $total = $activation + $trip;

    if($total > 0){

        $activationPercentage = round(($activation/$total)*100);
        $tripPercentage       = 100 - $activationPercentage;

    }else{

        $activationPercentage = 0;
        $tripPercentage = 0;

    }

    echo json_encode([
        'status' => true,
        'activation' => $activation,
        'trip' => $trip,
        'total' => $total,
        'activationPercentage' => $activationPercentage,
        'tripPercentage' => $tripPercentage
    ]);

}catch(Exception $e){

    echo json_encode([
        'status'=>false,
        'message'=>$e->getMessage()
    ]);

}