<?php

require '../../connect.php';

// Retrieve POST data
$created_date = $_POST['created_date'];
$ta_amount_id = $_POST['ta_amt_id'];
$ta_amount = $_POST['ta_amount'];
$taid = $_POST['taid'];
$status = $_POST['status'];
$rejection_reason = $_POST['rejection_reason'];

// Update the status in ta_top_up_payment
$stmt = $conn->prepare("UPDATE ta_top_up_payment SET status = :status,reject_reason=:reject_reason WHERE ta_id = :ta_id AND updated_date = :updated_date");
$result = $stmt->execute(array(
    ':status' => $status,
    ':reject_reason' => $rejection_reason,
    ':ta_id' => $taid,
    ':updated_date' => $created_date
));

// Fetch TA full name
$sqlName = "SELECT CONCAT(firstname, ' ', lastname) AS full_name FROM ca_travelagency WHERE ca_travelagency_id = :ta_id";
$stmtName = $conn->prepare($sqlName);
$stmtName->execute([':ta_id' => $taid]);
$ta = $stmtName->fetch(PDO::FETCH_ASSOC);

$ta_name = $ta ? $ta['full_name'] : 'Unknown';
$title = "TA top up";

// If the update is successful and status is 2 (approved), proceed to add the balance
if ($result && $status == 2) {
    // Insert the new credited amount into ta_top_up_utilisation
    $stmt = $conn->prepare("INSERT INTO ta_top_up_utilisation (ta_id, ta_top_up_amt_id, amount_credited,top_up_message) VALUES (:ta_id, :ta_top_up_amt_id, :amount_credited,:top_up_message)");
    $result2 = $stmt->execute(array(
        ':ta_id' => $taid,
        ':ta_top_up_amt_id' => $ta_amount_id,
        ':amount_credited' => $ta_amount,
        ':top_up_message'=>'TopUp Added'
    ));

    if ($result2) {
        // Fetch the latest available balance for the given ta_id
        $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1 OFFSET 1");
        $stmt2->execute(array(':ta_id' => $taid));
        $result3 = $stmt2->fetch(PDO::FETCH_ASSOC);
        // If no second last entry exists, fetch the latest entry
        if (!$result3) {
            $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
            $stmt2->execute(array(':ta_id' => $taid));
            $result3 = $stmt2->fetch(PDO::FETCH_ASSOC);
        }

        if ($result3) {
            // Calculate the new available balance
            $available_bal = $result3['available_balance'] + $ta_amount;
            

            // // Update the available balance in ta_top_up_utilisation
            $stmt3 = $conn->prepare("UPDATE ta_top_up_utilisation SET available_balance = :available_balance WHERE ta_id = :ta_id AND ta_top_up_amt_id = :ta_top_up_amt_id");
            $result4 = $stmt3->execute(array(
                ':ta_id' => $taid,
                ':ta_top_up_amt_id' => $ta_amount_id,
                ':available_balance' => (float)$available_bal
            ));

            if ($result4) {
                $sql2 = "INSERT INTO topup_logs (ta_id,ta_name,title,message,message2,from_whom,operation,updated_date,status) VALUES (:ta_id,:ta_name,:title,:message,:message2,:from_whom,:operation,:updated_date,:status)";
                $stmt = $conn->prepare($sql2);

                $result = $stmt->execute(array(
                    ':ta_id'=>$taid,
                    ':ta_name'=>$ta_name,
                    ':title'=>$title,
                    ':message'=>'Approved',
                    ':message2'=>'Approved',
                    ':from_whom'=>'1',
                    ':operation'=>'Admin Approval',
                    ':updated_date'=>$created_date,
                    ':status'=>'Approved'
                ));
                echo $status;
            } 
        }
    }
} else {
    $sql2 = "INSERT INTO topup_logs (ta_id,ta_name,title,message,message2,from_whom,operation,updated_date,status) VALUES (:ta_id,:ta_name,:title,:message,:message2,:from_whom,:operation,:updated_date,:status)";
    $stmt = $conn->prepare($sql2);

    $result = $stmt->execute(array(
        ':ta_id'=>$taid,
        ':ta_name'=>$ta_name,
        ':title'=>$title,
        ':message'=>'Rejected',
        ':message2'=>'Rejected',
        ':from_whom'=>'1',
        ':operation'=>'Admin Rejection',
        ':updated_date'=>$created_date,
        ':status'=>'Rejected'
    ));
    echo $status;   
}
//echo '<script>console.log("' . $result3['available_balance'] . '")</script>';