<?php

require '../connect.php';

date_default_timezone_set('Asia/Kolkata');
$currentYear = date("Y");

$current_year  = $_POST['year'] ?? 'all';
$current_month = $_POST['month'] ?? 'all';

$params = [];
$filter = "";

/* Filtering Logic */

if ($current_year == 'all' && $current_month == 'all') {

    // default → current year
    $filter = "YEAR(register_date) = ?";
    $params[] = $currentYear;

} elseif ($current_year != "all" && $current_month == "all") {

    $filter = "YEAR(register_date) = ?";
    $params[] = $current_year;

} elseif ($current_year == "all" && $current_month != "all") {

    $filter = "MONTH(register_date) = ?";
    $params[] = $current_month;

} else {

    $filter = "YEAR(register_date) = ? AND MONTH(register_date) = ?";
    $params[] = $current_year;
    $params[] = $current_month;

}


/* Convert number to Indian currency format */

function formatIndianCurrency($num) {

    if (!$num) return "0";

    if ($num >= 10000000) {
        return number_format($num / 10000000, 2) . ' Cr';
    }
    elseif ($num >= 100000) {
        return number_format($num / 100000, 2) . ' L';
    }
    elseif ($num >= 1000) {
        return number_format($num / 1000, 2) . ' K';
    }

    return $num;
}


$stmt = $conn->prepare("
    SELECT 
        SUM(CASE WHEN MONTH(register_date)=1 THEN 1 ELSE 0 END) AS jan,
        SUM(CASE WHEN MONTH(register_date)=2 THEN 1 ELSE 0 END) AS feb,
        SUM(CASE WHEN MONTH(register_date)=3 THEN 1 ELSE 0 END) AS mar,
        SUM(CASE WHEN MONTH(register_date)=4 THEN 1 ELSE 0 END) AS apr,
        SUM(CASE WHEN MONTH(register_date)=5 THEN 1 ELSE 0 END) AS may,
        SUM(CASE WHEN MONTH(register_date)=6 THEN 1 ELSE 0 END) AS jun,
        SUM(CASE WHEN MONTH(register_date)=7 THEN 1 ELSE 0 END) AS jul,
        SUM(CASE WHEN MONTH(register_date)=8 THEN 1 ELSE 0 END) AS aug,
        SUM(CASE WHEN MONTH(register_date)=9 THEN 1 ELSE 0 END) AS sep,
        SUM(CASE WHEN MONTH(register_date)=10 THEN 1 ELSE 0 END) AS oct,
        SUM(CASE WHEN MONTH(register_date)=11 THEN 1 ELSE 0 END) AS nov,
        SUM(CASE WHEN MONTH(register_date)=12 THEN 1 ELSE 0 END) AS `dec`,
        COUNT(ca_customer_id) AS total_customers,
        SUM(paid_amount) AS revenue
    FROM ca_customer
    WHERE $filter
    AND status = '1'
");

$stmt->execute($params);

$result = $stmt->fetch(PDO::FETCH_ASSOC);


$data = [
    $result['jan'] ?? 0,
    $result['feb'] ?? 0,
    $result['mar'] ?? 0,
    $result['apr'] ?? 0,
    $result['may'] ?? 0,
    $result['jun'] ?? 0,
    $result['jul'] ?? 0,
    $result['aug'] ?? 0,
    $result['sep'] ?? 0,
    $result['oct'] ?? 0,
    $result['nov'] ?? 0,
    $result['dec'] ?? 0
];

$response = [
    "months" => ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
    "data" => $data,
    "count" => $result['total_customers'] ?? 0,
    "revenue" => formatIndianCurrency($result['revenue'] ?? 0)
];

echo json_encode($response);

?>