<?php
// session_start();
require '../connect.php';

$ta_id = $_POST['ta_id'];
$ta_fname = $_POST['ta_fname'];
$ta_lname = $_POST['ta_lname'];
$ta_topup_amt = $_POST['ta_topup_amt'];
$ta_pay_mode = $_POST['ta_pay_mode'];
$ta_cheque_no = $_POST['ta_cheque_no'];
$ta_cheque_date = $_POST['ta_cheque_date'];
$ta_bank_name = $_POST['ta_bank_name'];
$ta_transaction_id = $_POST['ta_transaction_id'];
$ta_ref_img = $_POST['ta_ref_img'];
$ta_created_date = $_POST['ta_created_date'];
$ta_status=$_POST['ta_status'];

// data insertion for logs tables 
$title = "TA top up";
$message = "Added TA top up balance";
$ta_name=$ta_fname.' '.$ta_lname;
$fromWhom = $_POST['ta_id'];
$currentDate = date('Y-m-d H:i:s');//current date time
$reg_date=$currentDate;
$status='Pending';

$sql = "INSERT INTO `ta_top_up_payment` (ta_id, ta_fname, ta_lname, top_up_amt, pay_mode, cheque_no, cheque_date , bank_name, transaction_id, ref_img, updated_date, updated_by,status) VALUES (:ta_id, :ta_fname, :ta_lname, :top_up_amt, :pay_mode, :cheque_no, :cheque_date , :bank_name, :transaction_id, :ref_img, :updated_date, :updated_by, :status)";
$stmt3 = $conn->prepare($sql);
$result2 = $stmt3->execute(array(
    ':ta_id' =>$ta_id, 
    ':ta_fname'=>$ta_fname, 
    ':ta_lname'=>$ta_lname, 
    ':top_up_amt'=>$ta_topup_amt, 
    ':pay_mode'=>$ta_pay_mode, 
    ':cheque_no'=>$ta_cheque_no, 
    ':cheque_date'=>$ta_cheque_date, 
    ':bank_name'=>$ta_bank_name, 
    ':transaction_id'=>$ta_transaction_id, 
    ':ref_img'=>$ta_ref_img, 
    ':updated_date'=>$currentDate, 
    ':updated_by'=>$ta_id,
    ':status'=>$ta_status
));


if ($result2) {

    $sql2 = "INSERT INTO topup_logs (ta_id,ta_name,title,message,message2,from_whom,operation,updated_date,status) VALUES (:ta_id,:ta_name,:title,:message,:message2,:from_whom,:operation,:updated_date,:status)";
    $stmt = $conn->prepare($sql2);

    $result = $stmt->execute(array(
        ':ta_id'=>$ta_id,
        ':ta_name'=>$ta_name,
        ':title'=>$title,
        ':message'=>$message,
        ':message2'=>'',
        ':from_whom'=>$fromWhom,
        ':operation'=>'',
        ':updated_date'=>'',
        ':status'=>'Pending'
    ));

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
