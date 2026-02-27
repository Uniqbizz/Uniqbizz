<?php
require '../../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

if ($payoutMonth && $payoutMonth) {
    $dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
    $monthName = $dateObj->format('F'); 
}else{
    $monthName = 'NA';
}

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
                $BC_Commi = $row2['commision_bm'];
                $CA_Commi = $row2['commision_te'];
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
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_te'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_tc'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_mentor']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bm'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_te'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_mentor'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['techno_enterprise'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_te_ta'] == 0){
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
                $BC_Commi = $row2['commision_bm'];
                $CA_Commi = $row2['commision_te'];
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
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_te'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_tc'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_mentor']."'");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach (($sql1->fetchAll()) as $key => $row1) {
                        $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                    }
                } 

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bm'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_te'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_mentor'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['techno_enterprise'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_te_ta'] == 0){
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
    //total payout ca_ta_payout_paid
    // $output="";
    // $stmt2 = "SELECT * FROM ca_ta_payout_paid WHERE YEAR(date) = '".$payoutYear."' AND MONTH(date) = '".$payoutMonth."' ";
    // $stmt2 = $conn -> prepare($stmt2);
    // $stmt2 -> execute();
    // $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    // if($stmt2 -> rowCount()>0){
    // 	$output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>
    //     <table border="1" style="text-align:center">
    //         <tr>
    //             <th >Date</th>
    //             <th class="mobile_view">Business Consultant</th>
    //             <th class="mobile_view">Business Consultant Name</th>
    //             <th class="mobile_view">Corporate Agency</th>
    //             <th class="mobile_view">Corporate Agency Name</th>
    //             <th ><span class="long-name">Payout Message</th>
    //             <th ><span class="long-name">Payout Details</th>
    //             <th class="mobile_view tab_view">Amount</th>
    //             <th class="mobile_view" >TDS</th>
    //             <th style="text-align:center;">Total Payable</th>
    //             <th style="text-align:center;">Status</th>
    //         </tr>';
    //         foreach($stmt2->fetchAll() as $key => $row2){
    //             $rd= new DateTime($row2['date']);
    //             $newDate= $rd->format('d-m-Y');
    //             $id = $row2['id'];

    //             // date in proper formate
    //             $dt = new DateTime($row2['date']);
    //             $dt = $dt->format('Y-m-d');

    //             // replace dot at end of the line with break statement
    //             $message1 = $row2['payout_message'];
    //             $message1 =  str_replace('.','<br>',$message1); 
    //             $message2 = $row2['payout_details'];
    //             $message2 =  str_replace('.','<br>',$message2); 
                
    //             $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_consultant` where business_consultant_id='".$row2['business_mentor']."'");
    //             $sql1->execute();
    //             $sql1->setFetchMode(PDO::FETCH_ASSOC);
    //             if($sql1->rowCount()>0){
    //                 foreach (($sql1->fetchAll()) as $key => $row1) {
    //                     $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
    //                 }
    //             } 

    //             $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
    //             $sql2->execute();
    //             $sql2->setFetchMode(PDO::FETCH_ASSOC);
    //             if($sql2->rowCount()>0){
    //                 foreach (($sql2->fetchAll()) as $key => $row3) {
    //                     $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
    //                 }
    //             } 

    //             $output .= '<tr>
    //                 <td >'.$newDate.'</td>
    //                 <td>'.$row2['business_mentor'].'</td>
    //                 <td>'.$ta_name.'</td>
    //                 <td>'.$row2['techno_enterprise'].'</td>
    //                 <td>'.$ca_name.'</td>
    //                 <td class="message">'.$message1.'</td>
    //                 <td class="message">'.$message2.'</td>
    //                 <td style="text-align:center;">'.$row2['amount'].'</td>
    //                 <td style="text-align:center;">'.$row2['tds'].'/-</td>
    //                 <td style="text-align:center;">'.$row2['total_payable'].'/-</td>';
    //                 if($row2['status'] == 0){
    //                     $output .='<td style="text-align:center;">Pending</td>';
    //                 }else{
    //                     $output .='<td style="text-align:center;">Paid</td>';
    //                 }
    //             $output .='</tr>';
             
    //         }
    //     $output .= '</table>';
    //     header("Content-Type: application/xls");
    //     header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
    //     echo $output;
    // }else{
    //     echo 'No Total Payout Data';                                                    
    // }
    
    //total payout ca_ta_payout
    
    $output="";
    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center"> Payout List as of '.$monthName.','.$payoutYear.'</h2>
       <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Mentor</th>
                <th class="mobile_view">Business Mentor Name</th>
                <th class="mobile_view">Techno Enterprise</th>
                <th class="mobile_view">Techno Enterprise Name</th>
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
                $BC_Commi = $row2['commision_bm'];
                $CA_Commi = $row2['commision_te'];
                $ca_ta_Commi = $row2['tc_amt_paid'];
               
                (int)$BC_Commi_TDS = (int)$BC_Commi*2/100;
                (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

                (int)$CA_Commi_TDS = (int)$CA_Commi*2/100;
                (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
                (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

                // date in proper formate
                $dt = new DateTime($row2['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row2['message_bm'];
                $message1 =  str_replace('.','<br>',$message1); 
                $message2 = $row2['message_te'];
                $message2 =  str_replace('.','<br>',$message2); 
                $message3 = $row2['message_tc'];
                $message3 =  str_replace('.','<br>',$message3); 
                
                $bmID = $row2['business_mentor'];
                $reference_id = substr($bmID, 0, 2);
                    if ($reference_id == "BM") {
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
                            }
                        } 
                    }else if($reference_id == "BH"){    
                        $sql1= $conn->prepare("SELECT name FROM `employees` where user_type = '25' AND  employee_id='".$row2['business_mentor']."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $ta_name = $row1['name'];
                            }
                        } 
                    }

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td class="message">'.$message1.'</td>
                    <td style="text-align:center;">'.$BC_Commi.'</td>
                    <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
                    if($row2['status_bm'] == 0){
                        $output .='<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .='<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                
                $output .='<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$row2['business_mentor'].'</td>
                    <td>'.$ta_name.'</td>
                    <td>'.$row2['techno_enterprise'].'</td>
                    <td>'.$ca_name.'</td>
                    <td >'.$message2.'</td>
                    <td style="text-align:center;">'.$CA_Commi.'</td>
                    <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
                    <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
                    if($row2['status_te'] == 0){
                        $output .= '<td style="text-align:center;">Pending</td>';
                    }else{
                        $output .= '<td style="text-align:center;">Paid</td>';
                    }
                $output .='</tr>';
                
                // if($message3){
                //     $output .= '<tr>
                //         <td >'.$newDate.'</td>
                //         <td>'.$row2['business_mentor'].'</td>
                //         <td>'.$ta_name.'</td>
                //         <td>'.$row2['techno_enterprise'].'</td>
                //         <td>'.$ca_name.'</td>
                //         <td >'.$message3.'</td>
                //         <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                //         <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                //         if($row2['status_te_ta'] == 0){
                //             $output .='<td style="text-align:center;">Pending</td>';
                //         }else{
                //             $output .= '<td style="text-align:center;">Paid</td>';
                //         }
                //     $output .='</tr>';
                // }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Payout_List.xls");
        echo $output;
    }else{
        echo 'No Payout Data';                                                    
    }
}

// if($payoutmessage == 'allPayout'){
//     if($designation == 'business_mentor'){
//         if($user_id){
//             $where.='AND techno_enterprise = "'.$user_id.'" ';
//         }
//         if($payoutMonth && $payoutYear){
//             $where.='AND YEAR(created_date) = "'.$payoutYear.'" AND MONTH(created_date) = "'.$payoutMonth.'"';
//         }
//         $stmt2 = " SELECT * FROM ca_ta_payout WHERE 1=1 ";
//     }else if($designation == 'corporate_agency'){
//         $where='';
//         if($user_id){
//             $where.='AND techno_enterprise = "'.$user_id.'" ';
//         }
//         if($payoutMonth && $payoutYear){
//             $where.='AND YEAR(created_date) = "'.$payoutYear.'" AND MONTH(created_date) = "'.$payoutMonth.'"';
//         }
//         $stmt2 = " SELECT * FROM ca_ta_payout WHERE  techno_enterprise <> '' ".$where;
//     }
//     $output="";
//     $stmt2 = $conn -> prepare($stmt2);
//     $stmt2 -> execute();
//     $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
//     if($stmt2 -> rowCount()>0){
//     	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
//         <table border="1" style="text-align:center">
//             <tr>
//                 <th >Date</th>
//                 <th class="mobile_view">Business Mentor</th>
//                 <th class="mobile_view">Business Mentor Name</th>
//                 <th class="mobile_view">Corporate Agency</th>
//                 <th class="mobile_view">Corporate Agency Name</th>
//                 <th ><span class="long-name">Payout Details</th>
//                 <th class="mobile_view tab_view">Amount</th>
//                 <th class="mobile_view" >TDS</th>
//                 <th style="text-align:center;">Total Payable</th>
//                 <th style="text-align:center;">Status</th>
//             </tr>';
//             foreach($stmt2->fetchAll() as $key => $row2){
//                 $rd= new DateTime($row2['created_date']);
//                 $newDate= $rd->format('d-m-Y');
//                 $id = $row2['id'];

//                 // get the commission amount of BA's
//                 $BC_Commi = $row2['commision_bm'];
//                 $CA_Commi = $row2['commision_te'];
//                 $ca_ta_Commi = $row2['tc_amt_paid'];
               
//                 (int)$BC_Commi_TDS = (int)$BC_Commi*5/100;
//                 (int)$BC_Commi_Total = (int)$BC_Commi-(int)$BC_Commi_TDS; 

//                 (int)$CA_Commi_TDS = (int)$CA_Commi*5/100;
//                 (int)$CA_Commi_Total = (int)$CA_Commi-(int)$CA_Commi_TDS; 

//                 (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*5/100;
//                 (int)$ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 

//                 // date in proper formate
//                 $dt = new DateTime($row2['created_date']);
//                 $dt = $dt->format('Y-m-d');

//                 // replace dot at end of the line with break statement
//                 $message1 = $row2['message_bm'];
//                 $message1 =  str_replace('.','<br>',$message1); 
//                 $message2 = $row2['message_te'];
//                 $message2 =  str_replace('.','<br>',$message2); 
//                 $message3 = $row2['message_tc'];
//                 $message3 =  str_replace('.','<br>',$message3); 
                
//                 $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$row2['business_mentor']."'");
//                 $sql1->execute();
//                 $sql1->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql1->rowCount()>0){
//                     foreach (($sql1->fetchAll()) as $key => $row1) {
//                         $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
//                     }
//                 }else{
//                     $ta_name ='NA';
//                 }
//                 if ($row2['techno_enterprise']) {
//                     $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['techno_enterprise']."'");
//                     $sql2->execute();
//                     $sql2->setFetchMode(PDO::FETCH_ASSOC);
//                     if($sql2->rowCount()>0){
//                         foreach (($sql2->fetchAll()) as $key => $row3) {
//                             $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
//                         }
//                     } 
//                 }else{
//                     $ca_name='NA';
//                 }

//                 $output .= '<tr>
//                     <td >'.$newDate.'</td>
//                     <td>'.$row2['business_mentor']??'NA'.'</td>
//                     <td>'.$ta_name.'</td>
//                     <td>'.$row2['techno_enterprise'] ?? 'NA'.'</td>
//                     <td>'.$ca_name.'</td>
//                     <td class="message">'.$message1.'</td>
//                     <td style="text-align:center;">'.$BC_Commi.'</td>
//                     <td style="text-align:center;">'.$BC_Commi_TDS.'/-</td>
//                     <td style="text-align:center;">'.$BC_Commi_Total.'/-</td>';
//                     if($row2['status_bm'] == 0){
//                         $output .='<td style="text-align:center;">Pending</td>';
//                     }else{
//                         $output .='<td style="text-align:center;">Paid</td>';
//                     }
//                 $output .='</tr>';
                
                
//                 $output .='<tr>
//                     <td >'.$newDate.'</td>
//                     <td>'.$row2['business_mentor']??'NA'.'</td>
//                     <td>'.$ta_name.'</td>
//                     <td>'.$row2['techno_enterprise'] ?? 'NA'.'</td>
//                     <td>'.$ca_name.'</td>
//                     <td >'.$message2.'</td>
//                     <td style="text-align:center;">'.$CA_Commi.'</td>
//                     <td style="text-align:center;">'.$CA_Commi_TDS.'/-</td>
//                     <td style="text-align:center;">'.$CA_Commi_Total.'/-</td>';
//                     if($row2['status_te'] == 0){
//                         $output .= '<td style="text-align:center;">Pending</td>';
//                     }else{
//                         $output .= '<td style="text-align:center;">Paid</td>';
//                     }
//                 $output .='</tr>';
               
//             }
//         $output .= '</table>';
//         header("Content-Type: application/xls");
//         header("Content-Disposition: attachment;filename=All_Payout_List.xls");
//         echo $output;
//     }else{
//         echo 'No All Payout Data';                                                    
//     }
// }

// Assume PDO connection $conn already exists

$payoutmessage = $_GET['payoutmessage'] ?? '';
$payoutYear    = $_GET['payoutYear'] ?? null;
$payoutMonth   = $_GET['payoutMonth'] ?? null;
$designation   = $_SESSION['designation'] ?? '';
$user_id       = $_SESSION['user_id'] ?? '';

if ($payoutmessage == 'allPayout') {

    $where = '';

    if ($designation == 'business_mentor') {
        if (!empty($user_id)) {
            $where .= ' AND techno_enterprise = :user_id ';
        }
    } else if ($designation == 'corporate_agency') {
        $where .= ' AND techno_enterprise <> "" ';
        if (!empty($user_id)) {
            $where .= ' AND techno_enterprise = :user_id ';
        }
    }

    if (!empty($payoutMonth) && !empty($payoutYear)) {
        $where .= ' AND YEAR(created_date) = :payoutYear AND MONTH(created_date) = :payoutMonth ';
    }

    $stmt2 = $conn->prepare("SELECT * FROM ca_ta_payout WHERE techno_enterprise <> '' $where");

    if (!empty($user_id)) {
        $stmt2->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    }
    if (!empty($payoutMonth) && !empty($payoutYear)) {
        $stmt2->bindValue(':payoutYear', $payoutYear, PDO::PARAM_INT);
        $stmt2->bindValue(':payoutMonth', $payoutMonth, PDO::PARAM_INT);
    }

    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt2->rowCount() > 0) {

        // Month name logic (optional date safe)
        if (!empty($payoutMonth) && !empty($payoutYear)) {
            $monthObj  = DateTime::createFromFormat('!m', $payoutMonth);
            $monthName = $monthObj ? $monthObj->format('F') : 'NA';
        } else {
            $monthName = 'All Time';
            $payoutYear = '';
        }

        $output  = '<h2 style="text-align:center">All Payout List as of ' . $monthName . ' ' . $payoutYear . '</h2>';
        $output .= '<table border="1" style="text-align:center">
            <tr>
                <th>Date</th>
                <th>Business Mentor</th>
                <th>Business Mentor Name</th>
                <th>Corporate Agency</th>
                <th>Corporate Agency Name</th>
                <th>Payout Details</th>
                <th>Amount</th>
                <th>TDS</th>
                <th>Total Payable</th>
                <th>Status</th>
            </tr>';

        foreach ($stmt2->fetchAll() as $row2) {

            // Safe date formatting
            if (!empty($row2['created_date']) && $row2['created_date'] != '0000-00-00') {
                $rd = DateTime::createFromFormat('Y-m-d H:i:s', $row2['created_date'])
                      ?: DateTime::createFromFormat('Y-m-d', $row2['created_date']);
                $newDate = $rd ? $rd->format('d-m-Y') : 'NA';
            } else {
                $newDate = 'NA';
            }

            $BC_Commi = (int)$row2['commision_bm'];
            $CA_Commi = (int)$row2['commision_te'];

            $BC_Commi_TDS   = (int)($BC_Commi * 5 / 100);
            $BC_Commi_Total = $BC_Commi - $BC_Commi_TDS;

            $CA_Commi_TDS   = (int)($CA_Commi * 5 / 100);
            $CA_Commi_Total = $CA_Commi - $CA_Commi_TDS;

            // $message1 = nl2br(str_replace('.', ".\n", $row2['message_bm'] ?? ''));
            // $message2 = nl2br(str_replace('.', ".\n", $row2['message_te'] ?? ''));
            $message1=$row2['message_bm'];
            $message2=$row2['message_te'];

            // Fetch BM name
            $ta_name = 'NA';
            if (!empty($row2['business_mentor'])) {
                $sql1 = $conn->prepare("SELECT firstname, lastname FROM business_mentor WHERE business_mentor_id = ?");
                $sql1->execute([$row2['business_mentor']]);
                if ($r = $sql1->fetch(PDO::FETCH_ASSOC)) {
                    $ta_name = $r['firstname'] . ' ' . $r['lastname'];
                }else{
                    $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? ");
                    $sql1->execute([$row2['business_mentor']]);
                    if ($r = $sql1->fetch(PDO::FETCH_ASSOC)) {
                        $ta_name = $r['name'];
                    }
                }
            }

            // Fetch CA name
            $ca_name = 'NA';
            if (!empty($row2['techno_enterprise'])) {
                $sql2 = $conn->prepare("SELECT firstname, lastname FROM corporate_agency WHERE corporate_agency_id = ?");
                $sql2->execute([$row2['techno_enterprise']]);
                if ($r = $sql2->fetch(PDO::FETCH_ASSOC)) {
                    $ca_name = $r['firstname'] . ' ' . $r['lastname'];
                }else{
                    $sql2 = $conn->prepare("SELECT firstname, lastname FROM sub_franchisee WHERE sub_franchisee_id = ?");
                    $sql2->execute([$row2['techno_enterprise']]);
                    if ($r = $sql2->fetch(PDO::FETCH_ASSOC)) {
                        $ca_name = $r['firstname'] . ' ' . $r['lastname'];
                    }
                }
            }

            $output .= '<tr>
                <td>' . $newDate . '</td>
                <td>' . ($row2['business_mentor'] ?? 'NA') . '</td>
                <td>' . $ta_name . '</td>
                <td>' . ($row2['techno_enterprise'] ?? 'NA') . '</td>
                <td>' . $ca_name . '</td>
                <td>' . $message1 . '</td>
                <td>' . $BC_Commi . '</td>
                <td>' . $BC_Commi_TDS . '</td>
                <td>' . $BC_Commi_Total . '</td>
                <td>' . ($row2['status_bm'] == 1 ? 'Paid' : 'Pending') . '</td>
            </tr>';

            $output .= '<tr>
                <td>' . $newDate . '</td>
                <td>' . ($row2['business_mentor'] ?? 'NA') . '</td>
                <td>' . $ta_name . '</td>
                <td>' . ($row2['techno_enterprise'] ?? 'NA') . '</td>
                <td>' . $ca_name . '</td>
                <td>' . $message2 . '</td>
                <td>' . $CA_Commi . '</td>
                <td>' . $CA_Commi_TDS . '</td>
                <td>' . $CA_Commi_Total . '</td>
                <td>' . ($row2['status_te'] == 1 ? 'Paid' : 'Pending') . '</td>
            </tr>';
        }

        $output .= '</table>';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=All_Payout_List.xls");
        echo $output;
        exit;
    } else {
        echo 'No All Payout Data';
    }
}


    
?>