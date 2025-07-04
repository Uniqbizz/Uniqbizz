<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout'){
    $output="";
    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Consultant</th>
                <th class="mobile_view">Business Consultant Name</th>
                <th class="mobile_view">Corporate Agency</th>
                <th class="mobile_view">Corporate Agency Name</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $BC_Commi = $row2['commision_bc'];
                $CA_Commi = $row2['commision_ca'];
                $ca_ta_Commi = $row2['ca_ta_amt_paid'];
               
                (int)$BC_Commi_TDS = (int)$BC_Commi*5/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                (int)$CA_Commi_TDS = (int)$CA_Commi*5/100;
                (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
                (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bc'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_ca'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_ca_ta'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_consultant']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bc'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_ca'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_consultant'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['corporate_agency'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_ca_ta'] == 0){
                //             $output .='<td style="text-align:center;">Pending</td>';
                //         }else{
                //             $output .= '<td style="text-align:center;">Paid</td>';
                //         }
                //     $output .='</tr>';
                // }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
        echo $output;
    }else{
        echo 'No Previous Payout Data';                                                    
    }
} 

if($payoutmessage == 'NextPayout'){
    $output="";
    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
       <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Consultant</th>
                <th class="mobile_view">Business Consultant Name</th>
                <th class="mobile_view">Corporate Agency</th>
                <th class="mobile_view">Corporate Agency Name</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $BC_Commi = $row2['commision_bc'];
                $CA_Commi = $row2['commision_ca'];
                $ca_ta_Commi = $row2['ca_ta_amt_paid'];
               
                (int)$BC_Commi_TDS = (int)$BC_Commi*5/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                (int)$CA_Commi_TDS = (int)$CA_Commi*5/100;
                (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
                (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bc'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_ca'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_ca_ta'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_consultant']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bc'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_ca'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_consultant'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['corporate_agency'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_ca_ta'] == 0){
                //             $output .='<td style="text-align:center;">Pending</td>';
                //         }else{
                //             $output .= '<td style="text-align:center;">Paid</td>';
                //         }
                //     $output .='</tr>';
                // }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        echo $output;
    }else{
        echo 'No Next Payout Data';                                                    
    }
} 

if($payoutmessage == 'TotalPayout'){
    $output="";
    $stmt2 = "SELECT * FROM ca_ta_payout_paid WHERE YEAR(date) = '".$payoutYear."' AND MONTH(date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Consultant</th>
                <th class="mobile_view">Business Consultant Name</th>
                <th class="mobile_view">Corporate Agency</th>
                <th class="mobile_view">Corporate Agency Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // date in proper formate
                $dt = new DateTime($row2['date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['payout_message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['payout_details'];
                $message2 =  str_replace('.','<br>',$message2); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_consultant']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$row2['amount'].'</td>
                    <td style="text-align:center;">'.$row2['tds'].'/-</td>
                    <td style="text-align:center;">'.$row2['total_payable'].'/-</td>';
                    if($row2['status'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
             
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
        echo $output;
    }else{
        echo 'No Total Payout Data';                                                    
    }
}

if($payoutmessage == 'allPayout'){
    if($designation == 'business_consultant'){
        $stmt2 = " SELECT * FROM ca_ta_payout WHERE business_consultant = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($designation == 'corporate_agency'){
        $stmt2 = " SELECT * FROM ca_ta_payout WHERE corporate_agency = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($designation == 'BC_Ref'){
        $stmt2 = " SELECT * FROM ca_ta_payout WHERE BC_Ref = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }
    $output="";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Consultant</th>
                <th class="mobile_view">Business Consultant Name</th>
                <th class="mobile_view">Corporate Agency</th>
                <th class="mobile_view">Corporate Agency Name</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $BC_Commi = $row2['commision_bc'];
                $CA_Commi = $row2['commision_ca'];
                $ca_ta_Commi = $row2['ca_ta_amt_paid'];
               
                (int)$BC_Commi_TDS = (int)$BC_Commi*5/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                (int)$CA_Commi_TDS = (int)$CA_Commi*5/100;
                (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
                (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bc'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_ca'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_ca_ta'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_consultant']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bc'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_consultant'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['corporate_agency'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_ca'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_consultant'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['corporate_agency'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_ca_ta'] == 0){
                //             $output .='<td style="text-align:center;">Pending</td>';
                //         }else{
                //             $output .= '<td style="text-align:center;">Paid</td>';
                //         }
                //     $output .='</tr>';
                // }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=All_Payout_List.xls");
        echo $output;
    }else{
        echo 'No All Payout Data';                                                    
    }
}

    
?>