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
    $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
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
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th ><span class="long-name">Business Package</th>
                <th ><span class="long-name">Business Package Amount</th>
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
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
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
                    <td class="message">'.$row2['business_package'].'</td>
                    <td class="message">'.$row2['business_package_amount'].'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
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
    $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
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
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th ><span class="long-name">Business Package</th>
                <th ><span class="long-name">Business Package Amount</th>
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
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
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
                    <td class="message">'.$row2['business_package'].'</td>
                    <td class="message">'.$row2['business_package_amount'].'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
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
    $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' AND status='1' ";
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
                <th ><span class="long-name">Business Package</th>
                <th ><span class="long-name">Business Package Amount</th>
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
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
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
                    <td class="message">'.$row2['business_package'].'</td>
                    <td class="message">'.$row2['business_package_amount'].'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
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
        $stmt2 = " SELECT * FROM ca_payout WHERE business_consultant = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    }else if($designation == 'corporate_agency'){
        $stmt2 = " SELECT * FROM ca_payout WHERE corporate_agency = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
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
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th ><span class="long-name">Business Package</th>
                <th ><span class="long-name">Business Package Amount</th>
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
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_details'];
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
                    <td class="message">'.$row2['business_package'].'</td>
                    <td class="message">'.$row2['business_package_amount'].'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
               
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