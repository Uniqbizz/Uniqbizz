<?php
require '../../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";

    $stmt2 = "SELECT id, customer_id,refered_customer_id,refered_customer_type,referral_level, referral_message as message1, referral_amount as comm_amt1, created_date, status 
              FROM `customer_reference_payout` 
              WHERE customer_id='".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'
                    AND referral_amount IS NOT NULL
              ORDER BY created_date desc";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    //echo $stmt2;
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Customer Id</th>
                <th class="mobile_view">Customer Name</th>
                <th class="mobile_view">Refered Customer ID</th>
                <th class="mobile_view">Refered Customer Name</th>
                <th class="mobile_view tab_view">Level</th>
                <th ><span class="long-name">Referal Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Referal Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt1'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message1'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details']??'NA';
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['customer_id'];
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['customer_id']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 
                $userId1 = $row2['refered_customer_id'];
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['refered_customer_id']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row1) {
                        $refered_customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 
                
                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$customer_name.'</td>
                    <td>'.$userId1.'</td>
                    <td>'.$refered_customer_name.'</td>
                    <td>'.$row2['referral_level'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else if($row2['status'] == 1){
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
        echo $output;
    }else{
        echo "<script>
            alert('No Previous Payout Data Available');
            history.back();
          </script>";                                                       
    }
} 

if($payoutmessage == 'NextPayout'){
    $output="";
    $stmt2 = "SELECT id, customer_id,refered_customer_id,refered_customer_type,referral_level, referral_message as message1, referral_amount as comm_amt1, created_date, status 
              FROM `customer_reference_payout` 
              WHERE customer_id='".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'
                    AND referral_amount IS NOT NULL
              ORDER BY created_date desc";

    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Customer Id</th>
                <th class="mobile_view">Customer Name</th>
                <th class="mobile_view">Refered Customer ID</th>
                <th class="mobile_view">Refered Customer Name</th>
                <th class="mobile_view tab_view">Level</th>
                <th ><span class="long-name">Referal Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Referal Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt1'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message1'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['customer_id'];
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['customer_id']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 
                $userId1 = $row2['refered_customer_id'];
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['refered_customer_id']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row1) {
                        $refered_customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                }  

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$customer_name.'</td>
                    <td>'.$userId1.'</td>
                    <td>'.$refered_customer_name.'</td>
                    <td>'.$row2['referral_level'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else if($row2['status'] == 1){
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        echo $output;
    }else{ 
        echo "<script>
            alert('No Next Payout Data Available');
            history.back();
          </script>";                                                      
    }
} 

if($payoutmessage == 'TotalPayout'){
    //show paid payout only
    $output="";
    $stmt2 = "SELECT id, customer_id,refered_customer_id,refered_customer_type,referral_level, referral_message as message1, referral_amount as comm_amt1, created_date, status 
              FROM `customer_reference_payout` 
              WHERE customer_id='".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'
                    AND referral_amount IS NOT NULL AND status='1'
              ORDER BY created_date desc";

    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Customer Id</th>
                <th class="mobile_view">Customer Name</th>
                <th class="mobile_view">Refered Customer ID</th>
                <th class="mobile_view">Refered Customer Name</th>
                <th class="mobile_view tab_view">Level</th>
                <th ><span class="long-name">Referal Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Referal Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt1'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message1'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['customer_id'];
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['customer_id']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 
                $userId1 = $row2['refered_customer_id'];
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['refered_customer_id']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row1) {
                        $refered_customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$customer_name.'</td>
                    <td>'.$userId1.'</td>
                    <td>'.$refered_customer_name.'</td>
                    <td>'.$row2['referral_level'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else if($row2['status'] == 1){
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
        echo $output;
    }else{ 
        echo "<script>
            alert('No Total Payout Data Available');
            history.back();
          </script>";                                                      
    }
}

if($payoutmessage == 'allPayout'){

    $stmt2 = "SELECT id, customer_id,refered_customer_id,refered_customer_type,referral_level, referral_message as message1, referral_amount as comm_amt1, created_date, status 
              FROM `customer_reference_payout` 
              WHERE customer_id='".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."'
                    AND referral_amount IS NOT NULL
              ORDER BY created_date desc";

    $output="";
   
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Customer Id</th>
                <th class="mobile_view">Customer Name</th>
                <th class="mobile_view">Refered Customer ID</th>
                <th class="mobile_view">Refered Customer Name</th>
                <th class="mobile_view tab_view">Level</th>
                <th ><span class="long-name">Referal Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Referal Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt1'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message1'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['customer_id'];
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['customer_id']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 
                $userId1 = $row2['refered_customer_id'];
                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_customer` where ca_customer_id='".$row2['refered_customer_id']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row1) {
                        $refered_customer_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$customer_name.'</td>
                    <td>'.$userId1.'</td>
                    <td>'.$refered_customer_name.'</td>
                    <td>'.$row2['referral_level'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else if($row2['status'] == 1){
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=All_Payout_List.xls");
        echo $output;
    }else{
        echo "<script>
            alert('No Payout Data Available');
            history.back();
          </script>";                                                  
    }
}

    
?>