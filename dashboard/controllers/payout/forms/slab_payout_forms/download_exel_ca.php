<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$tds_percentage = 2 / 100;
$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F');

if ($payoutmessage == 'PreviousPayout') {
    $output = "";
    $stmt2 = "SELECT * FROM bm_payout_history WHERE bm_user_id = '" . $user_id  . "' AND YEAR(payout_date) = '" . $payoutYear . "' AND MONTH(payout_date) = '" . $payoutMonth . "'";
    $stmt2 = $conn->prepare($stmt2);
    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt2->rowCount() > 0) {
        $output .= '<h2 style="text-align:center">Previous Payout List as of ' . $monthName . ',' . $payoutYear . '</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Mentor</th>
                <th class="mobile_view">Business Mentor Name</th>
                <th class="mobile_view">Techno Enterprise</th>
                <th class="mobile_view">Techno Enterprise Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th ><span class="long-name">Payout Details</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
        foreach ($stmt2->fetchAll() as $key => $row2) {
            // date in proper format 
            //if payout is paid/decline
            if ($row2['payout_status'] == 2 || $row2['payout_status'] == 3) {
                $dt = new DateTime($row['release_date']);
                $dt = $dt->format('Y-m-d');
            }
            //if payout is pending 
            else {
                $dt = new DateTime($row2['payout_date']);
                $dt = $dt->format('Y-m-d');
            }
            $id = $row2['id'];
            // get the commission amount of BA's
            $Commi = $row2['payout_amount'];

            (int)$Commi_TDS = (int)$Commi * $tds_percentage;
            (int)$Commi_Total = (int)$Commi - (int)$Commi_TDS;


            // // date in proper formate
            // $dt = new DateTime($row2['created_date']);
            // $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row2['message_bm'];
            //$message1 =  str_replace('.', '<br>', $message1);
            // $message2 = $row2['message_details'];
            // $message2 =  str_replace('.', '<br>', $message2);

            $sql1 = $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='" . $row2['bm_user_id'] . "'");
            $sql1->execute();
            $sql1->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql1->rowCount() > 0) {
                foreach (($sql1->fetchAll()) as $key => $row1) {
                    $ta_name = $row1['firstname'] . ' ' . $row1['lastname'];
                }
            }

            $sql2 = $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='" . $row2['ca_user_id'] . "'");
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql2->rowCount() > 0) {
                foreach (($sql2->fetchAll()) as $key => $row3) {
                    $ca_name = $row3['firstname'] . ' ' . $row3['lastname'];
                }
            }

            $output .= '<tr>
                    <td >' .  $dt . '</td>
                    <td>' . $row2['bm_user_id'] . '</td>
                    <td>' . $ta_name . '</td>
                    <td>' . $row2['ca_user_id'] . '</td>
                    <td>' . $ca_name . '</td>
                    <td class="message">' . $message1 . '</td>
                    <td style="text-align:center;">' . $Commi . '/-</td>
                    <td style="text-align:center;">' . $Commi_TDS . '/-</td>
                    <td style="text-align:center;">' . $Commi_Total . '/-</td>';
            if ($row2['payout_status'] == 1) {
                $output .= '<td style="text-align:center;">Pending</td>';
            } else if ($row2['payout_status'] == 2) {
                $output .= '<td style="text-align:center;">Paid</td>';
            } else {
                $output .= '<td style="text-align:center;">Blocked</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Previous_Payout_List.xls");
        echo $output;
    } else {
        echo '<script>console.log("No Previous Payout Data");window.history.back();</script>';
    }
}

if ($payoutmessage == 'NextPayout') {
    $output = "";
    $stmt2 = "SELECT * FROM bm_payout_history WHERE bm_user_id = '" . $user_id  . "' AND YEAR(payout_date) = '" . $payoutYear . "' AND MONTH(payout_date) = '" . $payoutMonth . "'";
    $stmt2 = $conn->prepare($stmt2);
    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt2->rowCount() > 0) {
        $output .= '<h2 style="text-align:center">Next Payout List as of ' . $monthName . ',' . $payoutYear . '</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Mentor</th>
                <th class="mobile_view">Business Mentor Name</th>
                <th class="mobile_view">Techno Enterprise</th>
                <th class="mobile_view">Techno Enterprise Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
        foreach ($stmt2->fetchAll() as $key => $row2) {
            // date in proper format 
            //if payout is paid/decline
            if ($row2['payout_status'] == 2 || $row2['payout_status'] == 3) {
                $dt = new DateTime($row2['release_date']);
                $dt = $dt->format('Y-m-d');
            }
            //if payout is pending 
            else {
                $dt = new DateTime($row2['payout_date']);
                $dt = $dt->format('Y-m-d');
            }
            $id = $row2['id'];
            // get the commission amount of BA's
            $Commi = $row2['payout_amount'];

            (int)$Commi_TDS = (int)$Commi * $tds_percentage;
            (int)$Commi_Total = (int)$Commi - (int)$Commi_TDS;


            // // date in proper formate
            // $dt = new DateTime($row2['created_date']);
            // $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row2['message_bm'];
            // $message1 =  str_replace('.', '<br>', $message1);
            // $message2 = $row2['message_details'];
            // $message2 =  str_replace('.', '<br>', $message2);

            $sql1 = $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='" . $row2['bm_user_id'] . "'");
            $sql1->execute();
            $sql1->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql1->rowCount() > 0) {
                foreach (($sql1->fetchAll()) as $key => $row1) {
                    $ta_name = $row1['firstname'] . ' ' . $row1['lastname'];
                }
            }

            $sql2 = $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='" . $row2['ca_user_id'] . "'");
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql2->rowCount() > 0) {
                foreach (($sql2->fetchAll()) as $key => $row3) {
                    $ca_name = $row3['firstname'] . ' ' . $row3['lastname'];
                }
            }

            $output .= '<tr>
                    <td >' .  $dt . '</td>
                    <td>' . $row2['bm_user_id'] . '</td>
                    <td>' . $ta_name . '</td>
                    <td>' . $row2['ca_user_id'] . '</td>
                    <td>' . $ca_name . '</td>
                    <td class="message">' . $message1 . '</td>
                    <td style="text-align:center;">' . $Commi . '/-</td>
                    <td style="text-align:center;">' . $Commi_TDS . '/-</td>
                    <td style="text-align:center;">' . $Commi_Total . '/-</td>';
            if ($row2['payout_status'] == 1) {
                $output .= '<td style="text-align:center;">Pending</td>';
            } else if ($row2['payout_status'] == 2) {
                $output .= '<td style="text-align:center;">Paid</td>';
            } else {
                $output .= '<td style="text-align:center;">Blocked</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        echo $output;
    } else {
        echo '<script>console.log("No Next Payout Data");window.history.back();</script>';
    }
}

if ($payoutmessage == 'TotalPayout') {
    $output = "";
    $stmt2 = "SELECT * FROM bm_payout_history WHERE bm_user_id = '" . $user_id  . "' AND YEAR(payout_date) = '" . $payoutYear . "' AND MONTH(payout_date) = '" . $payoutMonth . "' AND payout_status=2";
    $stmt2 = $conn->prepare($stmt2);
    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt2->rowCount() > 0) {
        $output .= '<h2 style="text-align:center">Total Payout List as of ' . $monthName . ',' . $payoutYear . '</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Business Mentor</th>
                <th class="mobile_view">Business Mentor Name</th>
                <th class="mobile_view">Techno Enterprise</th>
                <th class="mobile_view">Techno Enterprise Name</th>
                <th ><span class="long-name">Payout Message</th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';
        foreach ($stmt2->fetchAll() as $key => $row2) {
            // date in proper format 
            //if payout is paid/decline
            if ($row2['payout_status'] == 2 || $row2['payout_status'] == 3) {
                $dt = new DateTime($row2['release_date']);
                $dt = $dt->format('Y-m-d');
            }
            //if payout is pending 
            else {
                $dt = new DateTime($row2['payout_date']);
                $dt = $dt->format('Y-m-d');
            }
            $id = $row2['id'];

            // get the commission amount of BA's
            $Commi = $row2['payout_amount'];

            (int)$Commi_TDS = (int)$Commi * $tds_percentage;
            (int)$Commi_Total = (int)$Commi - (int)$Commi_TDS;


            // date in proper formate
            // $dt = new DateTime($row2['created_date']);
            // $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row2['message_bm'];
            // $message1 =  str_replace('.', '<br>', $message1);
            // $message2 = $row2['message_details'];
            // $message2 =  str_replace('.', '<br>', $message2);

            $sql1 = $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='" . $row2['bm_user_id'] . "'");
            $sql1->execute();
            $sql1->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql1->rowCount() > 0) {
                foreach (($sql1->fetchAll()) as $key => $row1) {
                    $ta_name = $row1['firstname'] . ' ' . $row1['lastname'];
                }
            }

            $sql2 = $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='" . $row2['ca_user_id'] . "'");
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql2->rowCount() > 0) {
                foreach (($sql2->fetchAll()) as $key => $row3) {
                    $ca_name = $row3['firstname'] . ' ' . $row3['lastname'];
                }
            }

            $output .= '<tr>
                    <td >' . $newDate . '</td>
                    <td>' . $row2['business_consultant'] . '</td>
                    <td>' . $ta_name . '</td>
                    <td>' . $row2['corporate_agency'] . '</td>
                    <td>' . $ca_name . '</td>
                    <td class="message">' . $message1 . '</td>
                    <td style="text-align:center;">' . $Commi . '/-</td>
                    <td style="text-align:center;">' . $Commi_TDS . '/-</td>
                    <td style="text-align:center;">' . $Commi_Total . '/-</td>';
            if ($row2['payout_status'] == 1) {
                $output .= '<td style="text-align:center;">Pending</td>';
            } else if ($row2['payout_status'] == 2) {
                $output .= '<td style="text-align:center;">Paid</td>';
            } else {
                $output .= '<td style="text-align:center;">Blocked</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
        echo $output;
    } else {
        echo '<script>console.log("No Total Payout Data");window.history.back();</script>';
    }
}

// if($payoutmessage == 'allPayout'){
//     if($designation == 'travel_agent'){
//         $stmt2 = " SELECT * FROM ca_payout WHERE business_consultant = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     }else if($designation == 'corporate_agency'){
//         $stmt2 = " SELECT * FROM ca_payout WHERE corporate_agency = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
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
//                 <th class="mobile_view">Business Consultant</th>
//                 <th class="mobile_view">Business Consultant Name</th>
//                 <th class="mobile_view">Corporate Agency</th>
//                 <th class="mobile_view">Corporate Agency Name</th>
//                 <th ><span class="long-name">Payout Message</th>
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
//                 $Commi = $row2['comm_amt'];

//                 (int)$Commi_TDS = (int)$Commi*5/100;
//                 (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


//                 // date in proper formate
//                 $dt = new DateTime($row2['created_date']);
//                 $dt = $dt->format('Y-m-d');

//                 // replace dot at end of the line with break statement
//                 $message1 = $row2['message'];
//                 $message1 =  str_replace('.','<br>',$message1); 
//                 $message2 = $row2['message_details'];
//                 $message2 =  str_replace('.','<br>',$message2); 

//                 $sql1= $conn->prepare("SELECT firstname,lastname FROM `travel_agent` where travel_agent_id='".$row2['business_consultant']."'");
//                 $sql1->execute();
//                 $sql1->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql1->rowCount()>0){
//                     foreach (($sql1->fetchAll()) as $key => $row1) {
//                         $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
//                     }
//                 } 

//                 $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
//                 $sql2->execute();
//                 $sql2->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql2->rowCount()>0){
//                     foreach (($sql2->fetchAll()) as $key => $row3) {
//                         $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
//                     }
//                 } 

//                 $output .= '<tr>
//                     <td >'.$newDate.'</td>
//                     <td>'.$row2['business_consultant'].'</td>
//                     <td>'.$ta_name.'</td>
//                     <td>'.$row2['corporate_agency'].'</td>
//                     <td>'.$ca_name.'</td>
//                     <td class="message">'.$message1.'</td>
//                     <td class="message">'.$message2.'</td>
//                     <td style="text-align:center;">'.$Commi.'/-</td>
//                     <td style="text-align:center;">'.$Commi_TDS.'/-</td>
//                     <td style="text-align:center;">'.$Commi_Total.'/-</td>';
//                     if($row2['status'] == 0){
//                         $output .='<td style="text-align:center;">Pending</td>';
//                     }else{
//                         $output .='<td style="text-align:center;">Paid</td>';
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
