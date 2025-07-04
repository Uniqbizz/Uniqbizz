<?php
require '../connect.php'; // Include your database connection
header('Content-Type: application/json');

$sql = "SELECT * FROM `package`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($employees as &$row) {
    
}
echo json_encode(["status" => "success", "data" => $employees]);
?>
