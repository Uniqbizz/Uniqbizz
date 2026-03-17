<?php

require '../connect.php';

header('Content-Type: application/json');

$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

//convert long number to short number with 2 decimal points and currency indication
include '../controllers/common_controllers/currency_function.php';


if($year == "all"){
    $filter = "";
}else{
    $filter = "AND YEAR(created_at) = '$year'";
}

$totals = [
    "International" => 0,
    "Domestic" => 0
];
$holiday_revenue = 0;
$stmt = $conn->prepare("SELECT * FROM bookings WHERE status = '1'");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

if($stmt->rowCount()){
    foreach($stmt->fetchAll() as $row){

        $booking_id = $row['id'];
        $package_id = $row['package_id'];

        // get package category
        $stmt2 = $conn->prepare("SELECT category_id FROM package WHERE id = ?");
        $stmt2->execute([$package_id]);
        $package = $stmt2->fetch(PDO::FETCH_ASSOC);

        if($package){

            $category = $package['category_id'];

            // get amount from booking_direct_bill
            $stmt3 = $conn->prepare("SELECT total_net_payable FROM booking_direct_bill WHERE bookings_id = ? $filter");
            $stmt3->execute([$booking_id]);

            if($stmt3->rowCount()){
                foreach($stmt3->fetchAll(PDO::FETCH_ASSOC) as $bill){

                    $amount = $bill['total_net_payable'];

                    if($category == 1){
                        $totals['International'] += $amount;
                    } 
                    else if($category == 2){
                        $totals['Domestic'] += $amount;
                    }

                    $holiday_revenue =  $totals['International'] +  $totals['Domestic'];
                }
            }
        }
    }
}

$data = [
    "labels" => ["International","Domestic"],
    "values" => [
        $totals['International'],
        $totals['Domestic']
    ],
    "holiday_revenue" => formatIndianCurrency($holiday_revenue) ?? 0
];

echo json_encode($data);