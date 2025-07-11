<?php
    require '../connect.php';

    //get total count of super_franchisee_id and total sum of amount which are matching "SFM" 
    $sql = $conn->prepare(" SELECT COUNT(super_franchisee_id) as sp_id , sum(amount) as amount FROM super_franchisee  WHERE super_franchisee_id LIKE 'SFM%' AND status='1' ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_spm_id=$row['sp_id'];
            $total_spm_pay =  $row['amount'];
        }   
    }

    //get total count of super_franchisee_id and total sum of amount which are matching "SFB" 
    $sql = $conn->prepare(" SELECT COUNT(super_franchisee_id) as sp_id , sum(amount) as amount FROM super_franchisee  WHERE super_franchisee_id LIKE 'SFB%' AND status='1' ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_spb_id=$row['sp_id'];
            $total_spb_pay = $row['amount'];
        }   
    }

    //get total count of super_franchisee_id and total sum of amount which are matching "SFA" 
    $sql = $conn->prepare(" SELECT COUNT(super_franchisee_id) as sp_id , sum(amount) as amount FROM super_franchisee  WHERE super_franchisee_id LIKE 'SFA%' AND status='1' ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_spa_id=$row['sp_id'];
            $total_spa_pay = $row['amount'];
        }   
    }

    //get total count of super_franchisee_id and total sum of amount which are matching "SFU" 
    $sql = $conn->prepare(" SELECT COUNT(super_franchisee_id) as sp_id , sum(amount) as amount FROM super_franchisee  WHERE super_franchisee_id LIKE 'SFU%' AND status='1' ");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_spu_id=$row['sp_id'];
            $total_spu_pay = $row['amount'];
        }   
    }

    //get total count of super_franchisee_id which are active" 
    $sql = $conn->prepare(" SELECT COUNT(super_franchisee_id) as sp_id FROM super_franchisee WHERE status='1'");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC); 
    if($sql->rowCount()>0){
        foreach (($sql->fetchAll()) as $key => $row) {
            $total_sp_id=$row['sp_id'];
        }   
    }

    // add total amount and store it in variable
    $total_sp_pay = $total_spm_pay +  $total_spb_pay + $total_spa_pay + $total_spu_pay;

    // store it in array to pass it in chart
    $array_data = array( 
                        $total_spm_id, 
                        $total_spb_id, 
                        $total_spa_id,
                        $total_spu_id,
                        $total_sp_id,
                        $total_spm_pay,
                        $total_spb_pay,
                        $total_spa_pay,
                        $total_spu_pay,
                        $total_sp_pay
                        );
    $json_encode =  json_encode($array_data);
        
    echo $json_encode;

    // $sql = $conn->prepare("SELECT SUM(referral) as total_referral, 
    //                             SUM(earlybird) as total_earlybird, 
    //                             SUM(incentive) as total_incentive,
    //                             SUM(total) as total_price 
    //                         FROM business_scheme_payout WHERE status='1' ");
    // $sql->execute();
    // $sql->setFetchMode(PDO::FETCH_ASSOC);
    // if($sql->rowCount()>0) {
    //     $data = $sql->fetch();

    //     $cpp_customer = 0;
    //     $cpp_customer_total = 0;
    //     $cpp_customer_suspence = 0;
    //     $cpp_travelagent = 0;
    //     $cpp_franchisee = 0;
            
    //         $sql_cust = $conn->prepare("SELECT SUM(customer_share) as cpp_customer, SUM(travel_agent_share) as cpp_travelagent FROM club_price_distribution ");
    //         $sql_cust->execute();
    //         $sql_cust->setFetchMode(PDO::FETCH_ASSOC);
    //         if($sql_cust->rowCount()>0) {
    //             $data_customer = $sql_cust->fetch();

    //             $cpp_customer_total = $data_customer['cpp_customer'];
    //             $cpp_travelagent = $data_customer['cpp_travelagent'];
    //         }    

    //         $sql_customer_suspence = $conn->prepare("SELECT SUM(suspence) as cpp_customer_suspence FROM clubprice_payout_customer ");
    //         $sql_customer_suspence->execute();
    //         $sql_customer_suspence->setFetchMode(PDO::FETCH_ASSOC);
    //         if($sql_customer_suspence->rowCount()>0) {
    //             $data_customer_suspence = $sql_customer_suspence->fetch();
    //             $cpp_customer_suspence = $data_customer_suspence['cpp_customer_suspence'];
    //         }

    //         $sql_franchisee = $conn->prepare("SELECT SUM(amount) as cpp_franchisee FROM clubprice_payout_franchisee ");
    //         $sql_franchisee->execute();
    //         $sql_franchisee->setFetchMode(PDO::FETCH_ASSOC);
    //         if($sql_franchisee->rowCount()>0) {
    //             $data_franchisee = $sql_franchisee->fetch();
    //             $cpp_franchisee = $data_franchisee['cpp_franchisee'];
    //         }

    //         $cpp_customer = (float)$cpp_customer_total - (float)$cpp_customer_suspence;
    //         $total_price = (float)$data['total_incentive'] + (float)$data['total_earlybird'] + $cpp_customer + (float)$cpp_travelagent + (float)$cpp_franchisee;
    //             // $data['total_price'];

    //     $array_data = array( 
    //                         $data['total_incentive'], 
    //                         $data['total_earlybird'], 
    //                         $cpp_customer, 
    //                         $total_price,
    //                         $cpp_travelagent,
    //                         $cpp_franchisee
    //                     );
    //     $json_encode =  json_encode($array_data);
        
    //     echo $json_encode;
    // }else{
    //     echo array(0,0,0,0,0,0);    
    // }
?>