<?php
require '../../../connect.php';
$date = date('Y');

// product payout commission
$data7 = $conn->prepare("SELECT * FROM `product_commission` WHERE status = 1");
$data7->execute();
$data7->setFetchMode(PDO::FETCH_ASSOC);
$product_payout_data = $data7->fetchAll();

// return as JSON
header('Content-Type: application/json');
echo json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
