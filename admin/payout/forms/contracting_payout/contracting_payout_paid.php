
<?php
// <!-- Pending payment Model data add to table   -->
    require '../../../connect.php';

    // id, status, col_update

    $id = $_POST['id'];
    $paymentMessage = $_POST['paymentMessage'];
    $commi = $_POST['amt'];
    $status = $_POST['status'];
    $identity = $_POST['identity'];
    $col_status = 1;

    // TDS calculation
    $tdsAmount = $commi * 2/100;
    $total = $commi - $tdsAmount; 
    
    // update message status from corporate_agency_payout_level table
    if($identity == 'caPayout'){
   
        $sql3 = "UPDATE ca_payout SET status=:status, Message_details=:Message_details, comm_amtTDS=:comm_amtTDS, comm_amtTotal=:comm_amtTotal WHERE id = :id ";
        $stmt = $conn->prepare($sql3);
        $result = $stmt -> execute(array(
            ':Message_details' => $paymentMessage, 
            ':comm_amtTDS' => $tdsAmount, 
            ':comm_amtTotal' => $total, 
            ':status' => $col_status,
            ':id' => $id
        ));

    }else if($identity == 'goaBm'){

        $sql3 = "UPDATE goa_bm_payout SET status=:status, Message_details=:Message_details, comm_amtTDS=:comm_amtTDS, comm_amtTotal=:comm_amtTotal WHERE id = :id ";
        $stmt = $conn->prepare($sql3);
        $result = $stmt -> execute(array(
            ':Message_details' => $paymentMessage, 
            ':comm_amtTDS' => $tdsAmount, 
            ':comm_amtTotal' => $total, 
            ':status' => $col_status,
            ':id' => $id
        ));

    } else if($identity == 'goaBdm'){

        $sql3 = "UPDATE goa_bdm_payout SET status=:status, Message_details=:Message_details, comm_amtTDS=:comm_amtTDS, comm_amtTotal=:comm_amtTotal WHERE id = :id ";
        $stmt = $conn->prepare($sql3);
        $result = $stmt -> execute(array(
            ':Message_details' => $paymentMessage, 
            ':comm_amtTDS' => $tdsAmount, 
            ':comm_amtTotal' => $total, 
            ':status' => $col_status,
            ':id' => $id
        ));

    }

    if($result){
        echo "1";
    }else{
        echo "0";
    }
?>