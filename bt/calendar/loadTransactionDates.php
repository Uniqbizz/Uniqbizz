<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../connect.php'; // adjust path as needed

$transactionDates = [];

$sql = "SELECT register_date FROM login WHERE MONTH(register_date) = MONTH(CURDATE())
        AND YEAR(register_date) = YEAR(CURDATE()) AND id NOT IN (1, 2, 3, 4)
        ORDER BY register_date";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    $transactionDates[] = date('Y-m-d', strtotime($row['register_date']));
}

echo json_encode($transactionDates);
?>
