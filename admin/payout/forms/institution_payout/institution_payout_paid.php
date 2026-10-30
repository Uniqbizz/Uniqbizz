<?php
require '../../../connect.php';

$id = $_POST['id'];
$userID = $_POST['userID'];
$paymentMessage = $_POST['paymentMessage'];
$commi = $_POST['amt'];
$status = $_POST['status'];
$user_desig = $_POST['user_desig'];
$message = $_POST['message'];
$institution = $_POST['institution'];
$col_status = 1;

// TDS calculation
$tdsAmount = $commi * 2 / 100;
$total = $commi - $tdsAmount; 

$prefix = substr($userID, 0, 2);
if($prefix == 'BH' || $prefix == 'CT'){
    $status_col = 'status_emp';
}else if($prefix == 'MF' || $prefix == 'SF' || $prefix == 'BM' || $prefix == 'ET'){
    $status_col = 'status_bm_mf_sf';
}

$sql3 = "INSERT INTO `institution_payout_paid` 
            (`user_id`, `payout_message`, `payout_details`, `institution`, `amount`, `tds`, `total_payable`) 
            VALUES (:user_id, :payout_message, :payout_details, :institution, :amount, :tds, :total_payable)";

$stmt = $conn->prepare($sql3);
$result = $stmt->execute([
    ':user_id'        => $userID, 
    ':payout_message' => $message, 
    ':payout_details' => $paymentMessage, 
    ':institution' => $institution, 
    ':amount'         => $commi, 
    ':tds'            => $tdsAmount,
    ':total_payable'  => $total
]);

if($result){
    $stmt = $conn->prepare("UPDATE institution_payout SET `$status_col` = :message_status WHERE id = :id ");
    $result2 = $stmt -> execute(array(
        ':message_status' => $col_status,
        ':id' => $id
    ));
}

echo $result ? "1" : "0";
?>
