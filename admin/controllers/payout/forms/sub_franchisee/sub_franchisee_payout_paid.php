<?php
require '../../../../connect.php';

$id = $_POST['id'];
$userID = $_POST['userID'];
$paymentMessage = $_POST['paymentMessage'];
$commi = $_POST['amt'];
$status = $_POST['status'];
$user_desig = $_POST['user_desig'];
$message = $_POST['message'];
$sub_franchisee = $_POST['sub_franchisee'];
$col_status = 1;

// TDS calculation
$tdsAmount = $commi * 2 / 100;
$total = $commi - $tdsAmount; 

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

if($result){
    $stmt = $conn->prepare("UPDATE sub_franchisee_payout SET status_mf = :message_status WHERE id = :id ");
    $result2 = $stmt -> execute(array(
        ':message_status' => $col_status,
        ':id' => $id
    ));
}

echo $result ? "1" : "0";
?>
