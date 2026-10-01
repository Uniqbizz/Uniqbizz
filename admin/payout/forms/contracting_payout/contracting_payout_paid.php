
<?php
// <!-- Pending payment Model data add to table   -->
    require '../../../connect.php';

    // id, status, col_update

    $id = $_POST['id'];
    $paymentMessage = $_POST['paymentMessage'];
    $commi = $_POST['amt'];
    $status = $_POST['status'];
    $identity = $_POST['identity'];
    $techno_enterprise = $_POST['techno_enterprise'];
    $userID = $_POST['userID'];
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

        $sql3 = "UPDATE goa_bdm_payout SET status=:status, Message_details=:Message_details, comm_amtTDS=:comm_amtTDS, paid_amount=:comm_amtTotal WHERE id = :id ";
        $stmt = $conn->prepare($sql3);
        $result = $stmt -> execute(array(
            ':Message_details' => $paymentMessage, 
            ':comm_amtTDS' => $tdsAmount, 
            ':comm_amtTotal' => $total, 
            ':status' => $col_status,
            ':id' => $id
        ));

    } else if ($identity == 'CTE') {
    
        try {
    
            // Update CTE payout status
            $sql3 = "UPDATE techno_enterprise_payout
                     SET cte_status = :status
                     WHERE id = :id";
    
            $stmt = $conn->prepare($sql3);
    
            $result0 = $stmt->execute(array(
                ':status' => $col_status,
                ':id'     => $id
            ));
    
            if ($result0) {
    
                // Insert payment details
                $sql4 = "INSERT INTO techno_enterprise_payout_paid
                         (
                             status,
                             payment_message,
                             tds,
                             paid_amount,
                             total_amount,
                             cte_id,
                             te_id
                         )
                         VALUES
                         (
                             :status,
                             :payment_message,
                             :tds,
                             :paid_amount,
                             :total_amount,
                             :cte_id,
                             :te_id
                         )";
    
                $stmt = $conn->prepare($sql4);
    
                $result = $stmt->execute(array(
                    ':status'          => $col_status,
                    ':payment_message' => $paymentMessage,
                    ':tds'             => $tdsAmount,
                    ':paid_amount'     => $total,
                    ':total_amount'    => $commi,
                    ':cte_id'          => $userID,
                    ':te_id'           => $techno_enterprise
                ));
    
            } else {
                $result = false;
            }
    
        } catch (PDOException $e) {
    
            error_log("CTE payout error: " . $e->getMessage());
            $result = false;
        }
    } else if($identity == 'ETE'){

        try {
    
            // Update CTE payout status
            $sql3 = "UPDATE techno_enterprise_payout
                     SET ete_status = :status
                     WHERE id = :id";
    
            $stmt = $conn->prepare($sql3);
    
            $result0 = $stmt->execute(array(
                ':status' => $col_status,
                ':id'     => $id
            ));
    
            if ($result0) {
    
                // Insert payment details
                $sql4 = "INSERT INTO techno_enterprise_payout_paid
                         (
                             status,
                             payment_message,
                             tds,
                             paid_amount,
                             total_amount,
                             ete_id,
                             te_id
                         )
                         VALUES
                         (
                             :status,
                             :payment_message,
                             :tds,
                             :paid_amount,
                             :total_amount,
                             :ete_id,
                             :te_id
                         )";
    
                $stmt = $conn->prepare($sql4);
    
                $result = $stmt->execute(array(
                    ':status'          => $col_status,
                    ':payment_message' => $paymentMessage,
                    ':tds'             => $tdsAmount,
                    ':paid_amount'     => $total,
                    ':total_amount'    => $commi,
                    ':ete_id'          => $userID,
                    ':te_id'           => $techno_enterprise
                ));
    
            } else {
                $result = false;
            }
    
        } catch (PDOException $e) {
    
            error_log("ETE payout error: " . $e->getMessage());
            $result = false;
        }

    } else if($identity == 'STE'){

        try {
    
            // Update CTE payout status
            $sql3 = "UPDATE techno_enterprise_payout
                     SET ste_status = :status
                     WHERE id = :id";
    
            $stmt = $conn->prepare($sql3);
    
            $result0 = $stmt->execute(array(
                ':status' => $col_status,
                ':id'     => $id
            ));
    
            if ($result0) {
    
                // Insert payment details
                $sql4 = "INSERT INTO techno_enterprise_payout_paid
                         (
                             status,
                             payment_message,
                             tds,
                             paid_amount,
                             total_amount,
                             ste_id,
                             te_id
                         )
                         VALUES
                         (
                             :status,
                             :payment_message,
                             :tds,
                             :paid_amount,
                             :total_amount,
                             :ste_id,
                             :te_id
                         )";
    
                $stmt = $conn->prepare($sql4);
    
                $result = $stmt->execute(array(
                    ':status'          => $col_status,
                    ':payment_message' => $paymentMessage,
                    ':tds'             => $tdsAmount,
                    ':paid_amount'     => $total,
                    ':total_amount'    => $commi,
                    ':ste_id'          => $userID,
                    ':te_id'           => $techno_enterprise
                ));
    
            } else {
                $result = false;
            }
    
        } catch (PDOException $e) {
    
            error_log("STE payout error: " . $e->getMessage());
            $result = false;
        }

    }

    if($result){
        echo "1";
    }else{
        echo "0";
    }
?>