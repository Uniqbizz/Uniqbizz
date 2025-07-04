
<?php
// <!-- Pending payment Model data add to table   -->
    require '../../../connect.php';

    // id, status, col_update

    $id = $_POST['id'];
    $idUser = $_POST['userID'];
    $commi = $_POST['amt'];
    $paymentMessage = $_POST['message'];
    $status = $_POST['status'];
    $col_update = $_POST['col_update'];
    $col_status = 1;

    // TDS calculation
    $tdsAmount = $commi * 5/100;
    $total = $commi - $tdsAmount; 
    
    // update message status from corporate_agency_payout_level table
   
    $sql3 = "UPDATE cbd_payout SET status=:status WHERE id = :id ";
    $stmt = $conn->prepare($sql3);
    $result = $stmt -> execute(array(
        ':status' => $col_status,
        ':id' => $id
    ));

    if($result){
        echo "1";
    }else{
        echo "0";
    }
?>