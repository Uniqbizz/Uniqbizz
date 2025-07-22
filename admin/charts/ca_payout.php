<?php
    require '../connect.php';

    //get total count of TE/corporate_agency_id and total sum of amount 
    $sql = $conn->prepare(" SELECT COUNT(corporate_agency_id) as id, SUM(amount) as amount FROM `corporate_agency` WHERE  status = '1'");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_paid_ca_id=$row['id'];
            $total_paid_ca_amt =  $row['amount'];
        }   
    }

    //5 lakhs TE/CA Count
    $sql1 = $conn->prepare(" SELECT COUNT(corporate_agency_id) as id FROM `corporate_agency` WHERE amount = '500000' AND status = '1'");
    $sql1->execute();
    $sql1->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql1->rowCount()>0){
        foreach (($sql1->fetchAll()) as $key => $row) {
            $total_5L_ca_id=$row['id'];
            
        }   
    }

    //3 lakhs TE/CA Count
    $sql2 = $conn->prepare(" SELECT COUNT(corporate_agency_id) as id FROM `corporate_agency` WHERE amount = '300000' AND status = '1'");
    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql2->rowCount()>0){
        foreach (($sql2->fetchAll()) as $key => $row) {
            $total_3L_ca_id=$row['id'];
            
        }   
    }

    //2 lakhs TE/CA Count
    $sql3 = $conn->prepare(" SELECT COUNT(corporate_agency_id) as id FROM `corporate_agency` WHERE amount = '200000' AND status = '1'");
    $sql3->execute();
    $sql3->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql3->rowCount()>0){
        foreach (($sql3->fetchAll()) as $key => $row) {
            $total_2L_ca_id=$row['id'];
            
        }   
    }

    // $totalCA = $total_paid_ca_id + $total_unpaid_ca_id;
    // add total amount and store it in variable
    // $total_sp_pay = $total_spm_pay +  $total_spb_pay + $total_spa_pay + $total_spu_pay;

    // store it in array to pass it in chart
    $array_data = array( 
                        $total_paid_ca_id,
                        $total_paid_ca_amt,
                        $total_5L_ca_id,
                        $total_3L_ca_id,
                        $total_2L_ca_id
                        );
    $json_encode =  json_encode($array_data);
        
    echo $json_encode;

?>