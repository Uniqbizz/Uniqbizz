<?php
require '../../../connect.php';

$id = $_POST['id'];
$userID = $_POST['userID'];
$paymentMessage = $_POST['paymentMessage'];
$commi = $_POST['amt'];
$status = $_POST['status'];
$identity = $_POST['identity'];
$message = $_POST['message'];
$col_status = 1;
$sub_franchisee = $_POST['sub_franchisee'];

// TDS calculation
$tdsAmount = $commi * 2 / 100;
$total = $commi - $tdsAmount; 

if ($identity == 'zonal_manager' || $identity == 'master_franchisee') {
    $sql3 = "INSERT INTO `sub_franchisee_payout_paid` 
             (`user_id`, `payout_message`, `payout_details`, `sub_franchisee`, `amount`, `tds`, `total_payable`) 
             VALUES (:user_id, :payout_message, :payout_details, :sub_franchisee, :amount, :tds, :total_payable)";
    
    $stmt = $conn->prepare($sql3);
    $result = $stmt->execute([
        ':user_id'        => $userID, 
        ':payout_message' => $message, 
        ':payout_details' => $paymentMessage, 
        ':sub_franchisee' => $sub_franchisee, 
        ':amount'         => $commi, 
        ':tds'            => $tdsAmount,
        ':total_payable'  => $total
    ]);
}

echo $result ? "1" : "0";
?>
