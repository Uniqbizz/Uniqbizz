<?php

require "../connect.php";

header('Content-Type: application/json');

$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

//convert long number to short number with 2 decimal points and currency indication
function formatIndianCurrency($num) {
    $num = str_replace(',', '', $num);
    if ($num >= 10000000) {
        return number_format($num / 10000000, 2) . ' Cr';
    } elseif ($num >= 100000) {
        return number_format($num / 100000, 2) . ' L';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 2) . ' K';
    } else {
        return $num;
    }
}

if($year == "all"){
    $filter = "";
}else{
    $filter = "AND YEAR(register_date) = '$year'";
}

// Business Mentor
$stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_bm FROM business_mentor WHERE user_type='26' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_bm = $row['total_users_revenue_bm'] ?? 0;

// Master Franchisee
$stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_mf FROM master_franchisee WHERE user_type='28' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_mf = $row['total_users_revenue_mf'] ?? 0;

// Sponsor Franchisee
$stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_sf FROM sponsor_franchisee WHERE user_type='30' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_sf = $row['total_users_revenue_sf'] ?? 0;

//Techno Enterprise
$stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_te FROM corporate_agency WHERE user_type='16' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_te = $row['total_users_revenue_te'] ?? 0;

// Sub Franchisee
$stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_sub_f FROM sub_franchisee WHERE user_type='29' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_sub_f = $row['total_users_revenue_sub_f'] ?? 0;

// Institution
$stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_ins FROM institution WHERE user_type='32' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_ins = $row['total_users_revenue_ins'] ?? 0;

// Travel Consultant
$stmt = $conn->prepare("SELECT SUM(amount) AS total_users_revenue_tc FROM ca_travelagency WHERE user_type='11' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_tc = $row['total_users_revenue_tc'] ?? 0;

// Customer
$stmt = $conn->prepare("SELECT SUM(paid_amount) AS total_users_revenue_cu FROM ca_customer WHERE user_type='10' $filter ");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users_revenue_cu = $row['total_users_revenue_cu'] ?? 0;

$tota_revenue = $total_users_revenue_bm+$total_users_revenue_mf+$total_users_revenue_sf+$total_users_revenue_te+$total_users_revenue_sub_f+$total_users_revenue_ins+$total_users_revenue_tc+$total_users_revenue_cu;

$data = [
    "labels" => ["Business Mentor","Master Franchisee","Sponsor Franchisee","Techno Enterprise","Franchisee","Institution", "Travel Consultant","Customer"],
    "values" => [$total_users_revenue_bm,$total_users_revenue_mf,$total_users_revenue_sf,$total_users_revenue_te,$total_users_revenue_sub_f,$total_users_revenue_ins,$total_users_revenue_tc,$total_users_revenue_cu],
    "revenue" => [formatIndianCurrency($tota_revenue)],
    "year" => $year
];

echo json_encode($data);