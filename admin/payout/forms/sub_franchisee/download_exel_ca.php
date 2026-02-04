<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

// $dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
// $monthName = $dateObj->format('F'); 

$dateObj = DateTime::createFromFormat('!m', $payoutMonth);

if ($dateObj !== false) {
    $monthName = $dateObj->format('F');
} else {
    $monthName = '';
}


if($payoutmessage == 'PreviousPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 ="(SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, 'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL)) 
                UNION
                (SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, '".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)) 
                order by created_date desc ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">BDM/MF/SF/ZM</th>
                <th class="mobile_view">BDM/MF/SF/ZM Name</th>
                <th class="mobile_view">Franchisee</th>
                <th class="mobile_view">Franchisee Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['payout_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['userId'];

                $sql2= $conn->prepare("SELECT firstname,lastname,registrant FROM `sub_franchisee` where sub_franchisee_id='".$row2['sub_franchisee']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        $bm_name=$row3['registrant'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$bm_name.'</td>
                    <td>'.$row2['sub_franchisee'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='<td style="text-align:center;">'.$row2['paydate'].'</td>
                </tr>';
               
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
    $stmt2 = "(SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, 'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL))
                UNION
                (SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, '".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL))
                order by created_date desc ";

    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">BDM/MF/SF/ZM</th>
                <th class="mobile_view">BDM/MF/SF/ZM Name</th>
                <th class="mobile_view">Franchisee</th>
                <th class="mobile_view">Franchisee Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['payout_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['userId'];
                
                $sql2= $conn->prepare("SELECT firstname,lastname,registrant FROM `sub_franchisee` where sub_franchisee_id='".$row2['sub_franchisee']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        $bm_name=$row3['registrant'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$bm_name.'</td>
                    <td>'.$row2['sub_franchisee'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='<td style="text-align:center;">'.$row2['paydate'].'</td>
                </tr>';
               
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
    $stmt2 = " (SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, 'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL))
                UNION
                (SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, '".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL))
                order by created_date desc  ";

    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">BDM/MF/SF/ZM</th>
                <th class="mobile_view">BDM/MF/SF/ZM Name</th>
                <th class="mobile_view">Franchisee</th>
                <th class="mobile_view">Franchisee Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['payout_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['userId']; 

                $sql2= $conn->prepare("SELECT firstname,lastname,registrant FROM `sub_franchisee` where sub_franchisee_id='".$row2['sub_franchisee']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        $bm_name=$row3['registrant'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$bm_name.'</td>
                    <td>'.$row2['sub_franchisee'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='<td style="text-align:center;">'.$row2['paydate'].'</td>
                </tr>';
               
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

    if($designation == 'zonal_manager'){
        if($user_id){
            $stmt2 ="SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date, s.status, 'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE s.zonal_manager=".$user_id." AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL)
                ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date, s.status, 'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND s.status='1' AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL)
                ORDER BY created_date desc";
        }
        
        
    }else if($designation == 'master_franchisee'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee=".$user_id." AND master_franchisee LIKE 'MF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'MF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }
    }else if($designation == 'sponsor_franchisee'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee=".$user_id." AND master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }
    }else{
        $stmt2="(SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commission_zm as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'zonal_manager' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL))
                UNION
                (SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL))
                order by created_date desc";
    }

    $output="";
   
    $stmt2 = $conn -> prepare($stmt2);
    // print_r($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">BDM/BM</th>
                <th class="mobile_view">BDM/BM Name</th>
                <th class="mobile_view">Franchisee</th>
                <th class="mobile_view">Franchisee Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Paid Date</th>
            </tr>';
            foreach($stmt2->fetchAll() as $key => $row2){
                $rd= new DateTime($row2['created_date']);
                $newDate= $rd->format('d-m-Y');
                $id = $row2['id'];

                // get the commission amount of BA's
                $Commi = $row2['comm_amt'];
                
                (int)$Commi_TDS = (int)$Commi*2/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['payout_details'];
                $message2 =  str_replace('.','<br>',$message2); 

                $userId = $row2['userId'];          

                $sql2= $conn->prepare("SELECT firstname,lastname,registrant FROM `sub_franchisee` where sub_franchisee_id='".$row2['sub_franchisee']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                        $bm_name=$row3['registrant'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$bm_name.'</td>
                    <td>'.$row2['sub_franchisee'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$message2.'</td>
                    <td style="text-align:center;">'.$Commi.'/-</td>
                    <td style="text-align:center;">'.$Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$Commi_Total.'/-</td>';
                    if($row2['status'] == 2){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='<td style="text-align:center;">'.$row2['paydate'].'</td>
                </tr>';
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=All_Payout_List.xls");
        echo $output;
    }else{
        echo 'No Previous Payout Data';                                                    
    }
}

    
?>