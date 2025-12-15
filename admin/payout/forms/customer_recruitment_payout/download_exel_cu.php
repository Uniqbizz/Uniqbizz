<?php
require '../../../connect.php';

function normalize($val) {
    $val = trim((string) $val);
    return ($val === '' || strtolower($val) === 'null') ? null : $val;
}

$payoutYear    = normalize($_GET['payoutYear']);
$payoutMonth   = normalize($_GET['payoutMonth']);
$payoutmessage = normalize($_GET['payoutmessage']);
$designation   = normalize($_GET['designation']);
$user_id       = normalize($_GET['user_id']);

$tdsPer = 2/100;
$monthName = '';

if ($payoutMonth !== null) {
    $dateObj = DateTime::createFromFormat('!m', $payoutMonth);
} else {
    // $dateObj = new DateTime();
    // $payoutMonth = $dateObj->format('m');
    // $payoutYear = $dateObj->format('Y');
    // $monthName = $dateObj->format('F');
    $payoutMonth = '';
    $payoutYear = '';
    $monthName = '';
}

// new combine code added for next and prev 07-08-2025
if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout'){
   
    //new code to get pending and paid payout statments
    $output="";
    $stmt2 = "SELECT * FROM ca_cu_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">'.$payoutmessage.' List as of '.$monthName.','.$payoutYear.'</h2>
       <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Designation</th>
                <th class="mobile_view">User ID</th>
                <th class="mobile_view">User Name</th>
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

                //user assign
                $BM_id = $row2['business_mentor'];
                $TE_id = $row2['techno_enterprise'];
                $TC_id = $row2['travel_consultant'];

                // get the commission amount of BA's
                $BM_Commi = $row2['commision_bm'];
                $TE_Commi = $row2['commision_te'];
                $ca_ta_Commi = $row2['commision_tc'];
               
                (int)$BM_Commi_TDS = (int)$BM_Commi*$tdsPer;
                (int)$BM_Commi_Total = (int)$BM_Commi-(int)$BM_Commi_TDS; 

                (int)$TE_Commi_TDS = (int)$TE_Commi*$tdsPer;
                (int)$TE_Commi_Total = (int)$TE_Commi-(int)$TE_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*$tdsPer;
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
                
                $user_id = substr($BM_id, 0, 2);
                if($user_id == "BM"){
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$BM_id."'");
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                        }
                    } 
                }else if($user_id == "BH"){
                    $sql1= $conn->prepare("SELECT name FROM `employees` where employee_id='".$BM_id."'");
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $bm_name = $row1['name'];
                        }
                    } 
                }

                if($TE_id){
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$TE_id."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $te_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                }else{
                    $TE_id = "No TE";
                    $te_name = "No TE";
                }

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$TC_id."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $tc_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 

                if(!$row['business_mentor'] == ""){
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>Business Mentor</td>
                        <td>'.$BM_id.'</td>
                        <td>'.$bm_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td style="text-align:center;">'.$BM_Commi.'</td>
                        <td style="text-align:center;">'.$BM_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$BM_Commi_Total.'/-</td>';
                        if($row2['status_bm'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }
                
                if(!$row['techno_enterprise'] == ""){
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>Techno Enterprise</td>
                        <td>'.$TE_id.'</td>
                        <td>'.$te_name.'</td>
                        
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$TE_Commi.'</td>
                        <td style="text-align:center;">'.$TE_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$TE_Commi_Total.'/-</td>';
                        if($row2['status_te'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .= '<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }   
                   
                if(!$row['travel_consultant'] == ""){
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>Travel Consultant</td>
                        <td>'.$TC_id.'</td>
                        <td>'.$tc_name.'</td>
                        <td >'.$message3.'</td>
                        <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                        <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                        <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                        if($row2['status_tc'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .= '<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Monthly_Payout_List.xls");
        echo $output;
    }else{
        echo '<script>
                    alert("No Data");
                    window.history.back()
              </script>';                                                    
    }
}

if($payoutmessage == 'TotalPayout'){
   
    //new code to get pending and paid payout statments
    $output="";
    $stmt2 = "SELECT * FROM ca_cu_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
    	$output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>
       <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">Designation</th>
                <th class="mobile_view">User ID</th>
                <th class="mobile_view">User Name</th>
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

                //user assign
                $BM_id = $row2['business_mentor'];
                $TE_id = $row2['techno_enterprise'];
                $TC_id = $row2['travel_consultant'];

                // get the commission amount of BA's
                $BM_Commi = $row2['commision_bm'];
                $TE_Commi = $row2['commision_te'];
                $ca_ta_Commi = $row2['commision_tc'];
               
                (int)$BM_Commi_TDS = (int)$BM_Commi*$tdsPer;
                (int)$BM_Commi_Total = (int)$BM_Commi-(int)$BM_Commi_TDS; 

                (int)$TE_Commi_TDS = (int)$TE_Commi*$tdsPer;
                (int)$TE_Commi_Total = (int)$TE_Commi-(int)$TE_Commi_TDS; 

                (int)$ca_ta_Commi_TDS = (int)$ca_ta_Commi*$tdsPer;
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
                
                $user_id = substr($BM_id, 0, 2);
                if($user_id == "BM"){
                    $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$BM_id."'");
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                        }
                    } 
                }else if($user_id == "BH"){
                    $sql1= $conn->prepare("SELECT name FROM `employees` where employee_id='".$BM_id."'");
                    $sql1->execute();
                    $sql1->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql1->rowCount()>0){
                        foreach (($sql1->fetchAll()) as $key => $row1) {
                            $bm_name = $row1['name'];
                        }
                    } 
                }

                if($TE_id){
                    $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$TE_id."'");
                    $sql2->execute();
                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql2->rowCount()>0){
                        foreach (($sql2->fetchAll()) as $key => $row3) {
                            $te_name = $row3['firstname']. ' ' .$row3['lastname'];
                        }
                    } 
                }else{
                    $TE_id = "No TE";
                    $te_name = "No TE";
                }

                $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$TC_id."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $tc_name = $row3['firstname']. ' ' .$row3['lastname'];
                    }
                } 
                
                if(!$row['business_mentor'] == ""){
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>Business Mentor</td>
                        <td>'.$BM_id.'</td>
                        <td>'.$bm_name.'</td>
                        <td class="message">'.$message1.'</td>
                        <td style="text-align:center;">'.$BM_Commi.'</td>
                        <td style="text-align:center;">'.$BM_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$BM_Commi_Total.'/-</td>';
                        if($row2['status_bm'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .='<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }   
                
                if(!$row['techno_enterprise'] == ""){
                    $output .='<tr>
                        <td >'.$newDate.'</td>
                        <td>Techno Enterprise</td>
                        <td>'.$TE_id.'</td>
                        <td>'.$te_name.'</td>
                        
                        <td >'.$message2.'</td>
                        <td style="text-align:center;">'.$TE_Commi.'</td>
                        <td style="text-align:center;">'.$TE_Commi_TDS.'/-</td>
                        <td style="text-align:center;">'.$TE_Commi_Total.'/-</td>';
                        if($row2['status_te'] == 2){
                            $output .= '<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .= '<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }
                 
                if(!$row['travel_consultant'] == ""){
                    $output .= '<tr>
                        <td >'.$newDate.'</td>
                        <td>Travel Consultant</td>
                        <td>'.$TC_id.'</td>
                        <td>'.$tc_name.'</td>
                        <td >'.$message3.'</td>
                        <td style="text-align:center;">'.$ca_ta_Commi.'</td>
                        <td style="text-align:center;"> '.$ca_ta_Commi_TDS.'/-</td>
                        <td style="text-align:center;"> '.$ca_ta_Commi_Total.'/-</td>';
                        if($row2['status_tc'] == 2){
                            $output .='<td style="text-align:center;">Pending</td>';
                        }else{
                            $output .= '<td style="text-align:center;">Paid</td>';
                        }
                    $output .='</tr>';
                }
               
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Monthly_Payout_List.xls");
        echo $output;
    }else{
         echo '<script>
                    alert("No Data");
                    window.history.back()
              </script>';                                                     
    }
}

if($payoutmessage == 'allPayout'){
   
    $query = "SELECT * FROM ca_cu_payout WHERE 1";
    $params = [];
    $output = "";
 
    // CASE 1: Only designation
    if ($designation && !$user_id && !$payoutYear && !$payoutMonth) {
       
        if ($designation == 'business_mentor') {
            $query .= " AND business_mentor IS NOT NULL";
        } elseif ($designation == 'corporate_agency') {
            $query .= " AND (techno_enterprise IS NOT NULL AND techno_enterprise !='')";
        } elseif ($designation == 'ca_travelagency') {
            $query .= " AND travel_consultant IS NOT NULL";
        }
    }
    // CASE 2: Only month/year
    elseif (!$designation && !$user_id && $payoutYear && $payoutMonth) {
        $query .= " AND YEAR(created_date) = ? AND MONTH(created_date) = ?";
        $params[] = $payoutYear;
        $params[] = $payoutMonth;
    }
    // CASE 3: Designation + month/year
    elseif ($designation && !$user_id && $payoutYear && $payoutMonth) {
        if ($designation == 'business_mentor') {
            $query .= " AND business_mentor IS NOT NULL";
        } elseif ($designation == 'corporate_agency') {
            $query .= " AND (techno_enterprise IS NOT NULL AND techno_enterprise !='')";
        } elseif ($designation == 'ca_travelagency') {
            $query .= " AND travel_consultant IS NOT NULL";
        }
        $query .= " AND YEAR(created_date) = ? AND MONTH(created_date) = ?";
        $params[] = $payoutYear;
        $params[] = $payoutMonth;
    }
    // CASE 4: Designation + user_id
    elseif ($designation && $user_id && !$payoutYear && !$payoutMonth) {
        if ($designation == 'business_mentor') {
            $query .= " AND business_mentor = ?";
            $params[] = $user_id;
        } elseif ($designation == 'corporate_agency') {
            $query .= " AND (techno_enterprise = ?) ";
            $params[] = $user_id;
            $params[] = $user_id;
        } elseif ($designation == 'ca_travelagency') {
            $query .= " AND travel_consultant = ?";
            $params[] = $user_id;
        }
    }
    // CASE 5: Designation + user_id + month/year
    elseif ($designation && $user_id && $payoutYear && $payoutMonth) {
        if ($designation == 'business_mentor') {
            $query .= " AND business_mentor = ?";
            $params[] = $user_id;
        } elseif ($designation == 'corporate_agency') {
            $query .= " AND techno_enterprise = ? ";
            $params[] = $user_id;
            $params[] = $user_id;
        } elseif ($designation == 'ca_travelagency') {
            $query .= " AND travel_consultant = ?";
            $params[] = $user_id;
        }
        $query .= " AND YEAR(created_date) = ? AND MONTH(created_date) = ?";
        $params[] = $payoutYear;
        $params[] = $payoutMonth;
    }
 
    $query .= " ORDER BY id DESC";
 
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    // print_r($stmt);
    // exit;
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    $output .= "<table border='1' class='table table-bordered table-striped'>";
    $output .= "<thead>
    <tr>
        <th>S.No</th>
        <th>Designation</th>
        <th>Id and Name</th>
        <th>Date</th>
        <th>Message</th>
        <th>Amount</th>
        <th>TDS</th>
        <th>Net</th>
        <th>Status</th>
    </tr>
    </thead><tbody>";
 
    if ($results) {
        $i = 1;
        foreach ($results as $row) {
            $amount = 0;
            $message = '';
            $status = '';
 
            if ($designation == 'business_mentor') {
                $reference =substr($row['business_mentor'],0,2);
                $name='';
                    if($reference == 'SF'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, sponsor_franchisee_id
                                                 FROM sponsor_franchisee
                                                 WHERE sponsor_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['sponsor_franchisee_id'] . ')';
                            }
                        }
 
                        $designation_name = "Sponsor Franchisee";
                    }else if($reference == 'MF'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, master_franchisee_id
                                                 FROM master_franchisee
                                                 WHERE master_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['master_franchisee_id'] . ')';
                            }
                        }
                        $designation_name = "Master Franchisee";
                    }else if($reference == 'BM'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, business_mentor_id
                                                 FROM business_mentor
                                                 WHERE business_mentor_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['business_mentor_id'] . ')';
                            }
                        }
                        $designation_name = "Business Mentor";
                    }else if($reference == 'BH'){
                        $sql0=$conn->prepare("SELECT user_type,name,employee_id FROM employees WHERE employee_id=:employee_id");
                        $sql0->bindParam(':employee_id',$row['business_mentor'],PDO::PARAM_STR);
                        $sql0->execute();

                        if ($sql0->rowCount() > 0) {
                            foreach ($sql0->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['business_mentor_id'] . ')';
                                $designation_name = $row1['user_type'] == '31'?"Relationship Manager":($row1['user_type'] == '25'?"Business Development Manager":"NA");
                            }
                        }
                        
                        
                    }else{
                        $name ="NA";
                        $designation_name = "NA";
                    }
                $message = $row['message_bm'];
                $amount = (float)$row['commision_bm'];
                $status = $row['status_bm']== '1'?'Paid':'Pending';
                $designation_name = "Business Mentor";
               
                $tds = $amount * $tdsPer;
                $net = $amount - $tds;
 
                $output .= "<tr>
                    <td>{$i}</td>
                    <td>$designation_name</td>
                    <td>$name</td>
                    <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                    <td>{$message}</td>
                    <td>Rs." . number_format($amount, 2) . "</td>
                    <td>Rs." . number_format($tds, 2) . "</td>
                    <td>Rs." . number_format($net, 2) . "</td>
                    <td>{$status}</td>
                </tr>";
                $i++;
            }
            else if ($designation == 'corporate_agency') {
                if (!empty($row['techno_enterprise'])) {
                    $reference =substr($row['techno_enterprise'],0,1) == 'F'?substr($row['techno_enterprise'],0,1):substr($row['techno_enterprise'],0,2);
                    $name='';
                    if($reference == 'F'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, sub_franchisee_id
                                                 FROM sub_franchisee
                                                 WHERE sub_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['techno_enterprise'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['sub_franchisee_id'] . ')';
                            }
                        }
                        $designation_name = "Franchisee";
                    }else if($reference == 'TE' || $reference == 'CA'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, corporate_agency_id
                                                 FROM corporate_agency
                                                 WHERE corporate_agency_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['techno_enterprise'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['corporate_agency_id'] . ')';
                            }
                        }
                        $designation_name = "Techno Enterprise";
                    }else{
                        $name="NA";
                        $designation_name = "NA";
                    }
                    $message = $row['message_te'];
                    $amount = (float)$row['commision_te'];
                    $status = $row['status_te']== '1'?'Paid':'Pending';
                }
                $tds = $amount * $tdsPer;
                $net = $amount - $tds;
 
                $output .= "<tr>
                    <td>{$i}</td>
                    <td>$designation_name</td>
                    <td>$name</td>
                    <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                    <td>{$message}</td>
                    <td>Rs." . number_format($amount, 2) . "</td>
                    <td>Rs." . number_format($tds, 2) . "</td>
                    <td>Rs." . number_format($net, 2) . "</td>
                    <td>{$status}</td>
                </tr>";
                $i++;
            }
            else if ($designation == 'ca_travelagency') {
                $name='';
                $sql1 = $conn->prepare(" SELECT firstname, lastname, ca_travelagency_id
                                                 FROM ca_travelagency
                                                 WHERE ca_travelagency_id = :mentor_id
                                              ");
                $sql1->bindParam(':mentor_id', $row['travel_consultant'], PDO::PARAM_STR);
                $sql1->execute();
               
                if ($sql1->rowCount() > 0) {
                    foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                        $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['ca_travelagency_id'] . ')';
                    }
                }
                $message = $row['message_tc'];
                $amount = (float)$row['commision_tc'];
                $status = $row['status_tc']== '1'?'Paid':'Pending';
                $designation_name = "Travel Consultant";
                $tds = $amount * $tdsPer;
               
                $net = $amount - $tds;
 
                $output .= "<tr>
                    <td>{$i}</td>
                    <td>$designation_name</td>
                    <td>$name</td>
                    <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                    <td>{$message}</td>
                    <td>Rs." . number_format($amount, 2) . "</td>
                    <td>Rs." . number_format($tds, 2) . "</td>
                    <td>Rs." . number_format($net, 2) . "</td>
                    <td>{$status}</td>
                </tr>";
                $i++;
            } else {
                if ($row['commision_bm'] !=0 ) {
                    $reference =substr($row['business_mentor'],0,2);
                    $name='';
                    if($reference == 'SF'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, sponsor_franchisee_id
                                                 FROM sponsor_franchisee
                                                 WHERE sponsor_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['sponsor_franchisee_id'] . ')';
                            }
                        }
 
                        $designation_name = "Sponsor Franchisee";
                    }else if($reference == 'MF'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, master_franchisee_id
                                                 FROM master_franchisee
                                                 WHERE master_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['master_franchisee_id'] . ')';
                            }
                        }
                        $designation_name = "Master Franchisee";
                    }else if($reference == 'BM'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, business_mentor_id
                                                 FROM business_mentor
                                                 WHERE business_mentor_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['business_mentor'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['business_mentor_id'] . ')';
                            }
                        }
                        $designation_name = "Business Mentor";
                    }else if($reference == 'BH'){
                        $sql0=$conn->prepare("SELECT user_type,name,employee_id FROM employees WHERE employee_id=:employee_id");
                        $sql0->bindParam(':employee_id',$row['business_mentor'],PDO::PARAM_STR);
                        $sql0->execute();

                        if ($sql0->rowCount() > 0) {
                            foreach ($sql0->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['name'] . ' (' . $row1['employee_id'] . ')';
                                $designation_name = $row1['user_type'] == '31'?"Relationship Manager":($row1['user_type'] == '25'?"Business Development Manager":"NA");
                            }
                        }
                        
                        
                    }else{
                        $name ="NA";
                        $designation_name = "NA";
                    }
                    $message = $row['message_bm'];
                    $amount = (float)$row['commision_bm'];
                    $status = $row['status_bm']== '1'?'Paid':'Pending';
                    $tds = $amount * $tdsPer;
                    $net = $amount - $tds;
 
                    $output .= "<tr>
                        <td>{$i}</td>
                        <td>$designation_name</td>
                        <td>$name</td>
                        <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                        <td>{$message}</td>
                        <td>Rs." . number_format($amount, 2) . "</td>
                        <td>Rs." . number_format($tds, 2) . "</td>
                        <td>Rs." . number_format($net, 2) . "</td>
                        <td>{$status}</td>
                    </tr>";
                    $i++;
                }
                if ($row['commision_te']!=0) {
                    $reference =substr($row['techno_enterprise'],0,1) == 'F'?substr($row['techno_enterprise'],0,1):substr($row['techno_enterprise'],0,2);
                    $name='';
                    if($reference == 'F'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, sub_franchisee_id
                                                 FROM sub_franchisee
                                                 WHERE sub_franchisee_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['techno_enterprise'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['sub_franchisee_id'] . ')';
                            }
                        }
                        $designation_name = "Franchisee";
                    }else if($reference == 'TE' || $reference == 'CA'){
                        $sql1 = $conn->prepare(" SELECT firstname, lastname, corporate_agency_id
                                                 FROM corporate_agency
                                                 WHERE corporate_agency_id = :mentor_id
                                              ");
                        $sql1->bindParam(':mentor_id', $row['techno_enterprise'], PDO::PARAM_STR);
                        $sql1->execute();
                       
                        if ($sql1->rowCount() > 0) {
                            foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                                $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['corporate_agency_id'] . ')';
                            }
                        }
                        $designation_name = "Techno Enterprise";
                    }else{
                        $name="NA";
                        $designation_name = "NA";
                    }
                    $message = $row['message_te'];
                    $amount = (float)$row['commision_te'];
                    $status = $row['status_te']== '1'?'Paid':'Pending';
                    $tds = $amount * $tdsPer;
                    $net = $amount - $tds;
 
                    $output .= "<tr>
                        <td>{$i}</td>
                        <td>$designation_name</td>
                        <td>$name</td>
                        <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                        <td>{$message}</td>
                        <td>Rs." . number_format($amount, 2) . "</td>
                        <td>Rs." . number_format($tds, 2) . "</td>
                        <td>Rs." . number_format($net, 2) . "</td>
                        <td>{$status}</td>
                    </tr>";
                    $i++;
                }
                if ($row['commision_tc']!=0) {
                    $designation_name = "Travel Consultant";
                    $name='';
                    $sql1 = $conn->prepare(" SELECT firstname, lastname, ca_travelagency_id
                                                 FROM ca_travelagency
                                                 WHERE ca_travelagency_id = :mentor_id
                                              ");
                    $sql1->bindParam(':mentor_id', $row['travel_consultant'], PDO::PARAM_STR);
                    $sql1->execute();
                   
                    if ($sql1->rowCount() > 0) {
                        foreach ($sql1->fetchAll(PDO::FETCH_ASSOC) as $row1) {
                            $name = $row1['firstname'] . ' ' . $row1['lastname'] . ' (' . $row1['ca_travelagency_id'] . ')';
                        }
                    }
                    $message =  $row['message_tc'];
                    $amount = (float)$row['commision_tc'];
                    $status = $row['status_tc']== '1'?'Paid':'Pending';
                    $tds = $amount * $tdsPer;
                    $net = $amount - $tds;
 
                    $output .= "<tr>
                        <td>{$i}</td>
                        <td>$designation_name</td>
                        <td>$name</td>
                        <td>" . date('d-m-Y', strtotime($row['created_date'])) . "</td>
                        <td>{$message}</td>
                        <td>Rs." . number_format($amount, 2) . "</td>
                        <td>Rs." . number_format($tds, 2) . "</td>
                        <td>Rs." . number_format($net, 2) . "</td>
                        <td>{$status}</td>
                    </tr>";
                    $i++;
                }
            }
        }
    } else {
        echo "<script>alert('No data found');</script>";
        exit;
    }
 
    $output .= "</tbody></table>";
 
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=All_Payout_List.xls");
    echo $output;
 
}

    
?>