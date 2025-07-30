<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../connect.php'; // Your PDO setup here

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['monthYear'])) {
    $monthYear = $_POST['monthYear']; // "2025-05"
    $date = explode("-", $monthYear);
    $year = $date[0];
    $month = $date[1];

    function getCount($conn, $table) {
        global $month, $year;
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM `$table` WHERE MONTH(register_date) = :month AND YEAR(register_date) = :year");
        $stmt->execute(['month' => $month, 'year' => $year]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] ?? 0;
    }

    echo json_encode([
        'bm_count'   => getCount($conn, 'business_mentor'),
        'emp_count'   => getCount($conn, 'employees'),
        'te_count'   => getCount($conn, 'corporate_agency'),
        'tc_count'   => getCount($conn, 'ca_travelagency'),
        'cust_count' => getCount($conn, 'ca_customer')
    ]);
}
?>