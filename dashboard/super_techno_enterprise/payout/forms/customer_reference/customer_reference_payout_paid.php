
<?php
// <!-- Pending payment Model data add to table   -->
    require '../../../connect.php';

    // id, status, col_update

    $id = $_POST['id'];
    $paymentMessage = $_POST['paymentMessage'];
    $commi = $_POST['amt'];
    $status = $_POST['status'];
    $col_status = 1;

    // TDS calculation
    $tdsAmount = $commi * 2/100;
    $total = $commi - $tdsAmount; 
    
    // update message status from customer_reference_payout table

    $sql3 = "UPDATE customer_reference_payout SET status=:status, Message_details=:Message_details, comm_amtTDS=:comm_amtTDS, comm_amtTotal=:comm_amtTotal WHERE id = :id ";
    $stmt = $conn->prepare($sql3);
    $result = $stmt -> execute(array(
        ':Message_details' => $paymentMessage, 
        ':comm_amtTDS' => $tdsAmount, 
        ':comm_amtTotal' => $total, 
        ':status' => $col_status,
        ':id' => $id
    ));


    if($result){
        echo "1";
    }else{
        echo "0";
    }
?>