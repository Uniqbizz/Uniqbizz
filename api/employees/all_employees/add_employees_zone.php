<?php
require '../../connect.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM zone WHERE status = '1'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$response = [];

if ($stmt->rowCount() > 0) {
    $response['status'] = 'success';
    $response['zones'] = $stmt->fetchAll();
} else {
    $response['status'] = 'error';
    $response['message'] = 'No zones available';
}

echo json_encode($response);
?>
