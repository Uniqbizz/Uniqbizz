<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout'){
    $output="";
    $stmt2 = "SELECT * FROM cbd_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        if($payoutmessage == 'PreviousPayout'){
            $output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        }else{
            $output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        }
    	    
        $output .= '<table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Channel Business Director ID</th>
                <th class="mobile_view">Channel Business Director Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Type</th>
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
                $Commi = $row2['amount'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $payout_type = $row2['payout_type'];
                
                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['cbd_id'].'</td>
                    <td>'.$row2['cbd_name'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$payout_type.'</td>
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
        if($payoutmessage == 'PreviousPayout'){
            header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
        }else{
            header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        }
        echo $output;
    }else{
        echo 'No Previous/Next Payout Data';                                                    
    }
} 

if($payoutmessage == 'TotalPayout'){
    $output="";
    $stmt2 = "SELECT * FROM cbd_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' AND status='1' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Channel Business Director ID</th>
                <th class="mobile_view">Channel Business Director Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Type</th>
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
                $Commi = $row2['amount'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $payout_type = $row2['payout_type'];
                
                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['cbd_id'].'</td>
                    <td>'.$row2['cbd_name'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$payout_type.'</td>
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
    $stmt2 = " SELECT * FROM cbd_payout WHERE cbd_id = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $output="";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Channel Business Director ID</th>
                <th class="mobile_view">Channel Business Director Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Type</th>
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
                $Commi = $row2['amount'];
                
                (int)$Commi_TDS = (int)$Commi*5/100;
                (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 

                // replace dot at end of the line with break statement
                $message1 = $row2['message'];
                $message1 =  str_replace('.','<br>',$message1); 
                $payout_type = $row2['payout_type'];
                
                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['cbd_id'].'</td>
                    <td>'.$row2['cbd_name'].'</td>
                    <td class="message">'.$message1.'</td>
                    <td class="message">'.$payout_type.'</td>
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