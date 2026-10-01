<?php
    require '../../../connect.php';
    
    function normalize($val) {
        $val = trim((string) $val);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }
    
    $payoutYear    = normalize($_GET['payoutYear'] ?? '');
    $payoutMonth   = normalize($_GET['payoutMonth'] ?? '');
    $payoutmessage = normalize($_GET['payoutmessage'] ?? '');
    $designation   = normalize($_GET['designation'] ?? '');
    $user_id       = normalize($_GET['user_id'] ?? '');
    
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
    if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout' || $payoutmessage == 'TotalPayout'){
       
        //new code to get pending and paid payout statments
        $output="";
        $stmt2 = $conn->prepare("
            SELECT *
            FROM ca_cu_payout
            WHERE YEAR(created_date) = :payoutYear
              AND MONTH(created_date) = :payoutMonth
        ");
        
        $stmt2->execute([
            ':payoutYear'  => $payoutYear,
            ':payoutMonth' => $payoutMonth
        ]);

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
                    $CTE_id = $row2['cte_id']; //CTE
                    $BDM_id = $row2['business_development_manager']; //BDM, ETE
                    $BM_id = $row2['business_mentor']; //STE, BM / SF / MF
                    $TE_id = $row2['techno_enterprise']; //TE / F / I 
                    $TC_id = $row2['travel_consultant']; // TC / IBR
    
                    // get the commission amount of BA's
                    $CTE_Commi = $row2['commision_cte']; //CTE
                    $BDM_Commi = $row2['commision_bdm']; //BDM, ETE
                    $BM_Commi = $row2['commision_bm']; //STE, BM / SF / MF
                    $TE_Commi = $row2['commision_te']; //TE / F / I 
                    $ca_ta_Commi = $row2['commision_tc']; // TC / IBR
                   
                    $CTE_Commi_TDS = (int)$CTE_Commi*$tdsPer;
                    $CTE_Commi_Total = (int)$CTE_Commi-(int)$CTE_Commi_TDS; 
                    
                    $BDM_Commi_TDS = (int)$BDM_Commi*$tdsPer;
                    $BDM_Commi_Total = (int)$BDM_Commi-(int)$BDM_Commi_TDS; 
                   
                    $BM_Commi_TDS = (int)$BM_Commi*$tdsPer;
                    $BM_Commi_Total = (int)$BM_Commi-(int)$BM_Commi_TDS; 
    
                    $TE_Commi_TDS = (int)$TE_Commi*$tdsPer;
                    $TE_Commi_Total = (int)$TE_Commi-(int)$TE_Commi_TDS; 
    
                    $ca_ta_Commi_TDS = (int)$ca_ta_Commi*$tdsPer;
                    $ca_ta_Commi_Total = (int)$ca_ta_Commi-(int)$ca_ta_Commi_TDS; 
    
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
                    $message4 = $row2['message_bdm'];
                    $message4 =  str_replace('.','<br>',$message4); 
                    $message5 = $row2['message_cte'];
                    $message5 =  str_replace('.','<br>',$message5); 
                    
                    $cte_user_id = substr($CTE_id, 0, 2);
                    if($cte_user_id == "CT"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `chief_techno_enterprise` where chief_techno_enterprise_id='".$CTE_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $cte_name = $row1['firstname']. ' ' .$row1['lastname'];
                                $cte_designation = "Chief Techno Enterprise";
                            }
                        } 
                    }
                    
                    $bdm_user_id = substr($BDM_id, 0, 2);
                    if($bdm_user_id == "ET"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `executive_techno_enterprise` where executive_techno_enterprise_id='".$BDM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bdm_name = $row1['firstname']. ' ' .$row1['lastname'];
                                $bdm_designation = "Executive Techno Enterprise";
                            }
                        } 
                    }else if($bdm_user_id == "BH"){
                        $sql1= $conn->prepare("SELECT name FROM `employees` where employee_id='".$BDM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bdm_name = $row1['name'];
                                $bdm_designation = "Business Development Manager";
                            }
                        } 
                    }
                    
                    $bm_user_id = substr($BM_id, 0, 2);
                    if($bm_user_id == "BM"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `business_mentor` where business_mentor_id='".$BM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                                $bm_designation = "Business Mentor";
                            }
                        } 
                    }else if($bm_user_id == "BH"){
                        $sql1= $conn->prepare("SELECT name FROM `employees` where employee_id='".$BM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bm_name = $row1['name'];
                                $bm_designation = "Business Development Manager";
                            }
                        } 
                    }else if($bm_user_id == "MF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `master_franchisee` where master_franchisee_id='".$BM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                                $bm_designation = "Master Franchisee";
                            }
                        } 
                    }else if($bm_user_id == "SF"){
                        $sql1= $conn->prepare("SELECT firstname,lastname FROM `sponsor_franchisee` where sponsor_franchisee_id='".$BM_id."'");
                        $sql1->execute();
                        $sql1->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql1->rowCount()>0){
                            foreach (($sql1->fetchAll()) as $key => $row1) {
                                $bm_name = $row1['firstname']. ' ' .$row1['lastname'];
                                $bm_designation = "Sponsor Franchisee";
                            }
                        } 
                    }
                    
                    $te_user_id = (substr($TE_id, 0, 1) =='F' || substr($TE_id, 0, 1) =='I') ? substr($TE_id, 0, 1) : substr($TE_id, 0, 2) ;
                    if($te_user_id == "TE" || $te_user_id == "CA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$TE_id."'");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            foreach (($sql2->fetchAll()) as $key => $row3) {
                                $te_name = $row3['firstname']. ' ' .$row3['lastname'];
                                $te_designation = "Techno Enterprise";
                            }
                        } 
                    }else if($te_user_id == "F"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `sub_franchisee` where sub_franchisee_id='".$TE_id."'");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            foreach (($sql2->fetchAll()) as $key => $row3) {
                                $te_name = $row3['firstname']. ' ' .$row3['lastname'];
                                $te_designation = "Franchisee";
                            }
                        } 
                    }else if($te_user_id == "I"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `institution` where institution_id='".$TE_id."'");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            foreach (($sql2->fetchAll()) as $key => $row3) {
                                $te_name = $row3['name'];
                                $te_designation = "Institution";
                            }
                        } 
                    }else{
                        $TE_id = "No TE";
                        $te_name = "No TE";
                    }
    
                    $tc_user_id = substr($TC_id, 0, 2);
                    if($tc_user_id == "TA"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `ca_travelagency` where ca_travelagency_id='".$TC_id."'");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            foreach (($sql2->fetchAll()) as $key => $row3) {
                                $tc_name = $row3['firstname']. ' ' .$row3['lastname'];
                                $tc_designation = "Travel Consultant";
                            }
                        } 
                    }else if($tc_user_id == "IB"){
                        $sql2= $conn->prepare("SELECT firstname,lastname FROM `institution_branch_manager` where institution_branch_manager_id='".$TC_id."'");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            foreach (($sql2->fetchAll()) as $key => $row3) {
                                $tc_name = $row3['firstname']. ' ' .$row3['lastname'];
                                $tc_designation = "Institution Branch Manager";
                            }
                        } 
                    }
                    
                    if((!empty($row2['cte_id']))){
                        $output .= '<tr>
                            <td >'.$newDate.'</td>
                            <td>'.$cte_designation.'</td>
                            <td>'.$CTE_id.'</td>
                            <td>'.$cte_name.'</td>
                            <td class="message">'.$message5.'</td>
                            <td style="text-align:center;">'.$CTE_Commi.'</td>
                            <td style="text-align:center;">'.$CTE_Commi_TDS.'/-</td>
                            <td style="text-align:center;">'.$CTE_Commi_Total.'/-</td>';
                            if($row2['status_CTE'] == 2){
                                $output .='<td style="text-align:center;">Pending</td>';
                            }else{
                                $output .='<td style="text-align:center;">Paid</td>';
                            }
                        $output .='</tr>';
                    }
                    
                    if(!empty($row2['business_development_manager'])){
                        $output .= '<tr>
                            <td >'.$newDate.'</td>
                            <td>'.$bdm_designation.'</td>
                            <td>'.$BDM_id.'</td>
                            <td>'.$bdm_name.'</td>
                            <td class="message">'.$message4.'</td>
                            <td style="text-align:center;">'.$BDM_Commi.'</td>
                            <td style="text-align:center;">'.$BDM_Commi_TDS.'/-</td>
                            <td style="text-align:center;">'.$BDM_Commi_Total.'/-</td>';
                            if($row2['status_bdm'] == 2){
                                $output .='<td style="text-align:center;">Pending</td>';
                            }else{
                                $output .='<td style="text-align:center;">Paid</td>';
                            }
                        $output .='</tr>';
                    }
    
                    if(!empty($row2['business_mentor'])){
                        $output .= '<tr>
                            <td >'.$newDate.'</td>
                            <td>'.$bm_designation.'</td>
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
                    
                    if(!empty($row2['techno_enterprise'])){
                        $output .='<tr>
                            <td >'.$newDate.'</td>
                            <td>'.$te_designation.'</td>
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
                       
                    if(!empty($row2['travel_consultant'])){
                        $output .= '<tr>
                            <td >'.$newDate.'</td>
                            <td>'.$tc_designation.'</td>
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
                $query .= " AND (techno_enterprise IS NOT NULL AND techno_enterprise <>'')";
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
            if ($designation == 'BM_BDM_MF_SF_RM') {
                $i = 1;
                foreach ($results as $row) {
                    $amount = 0;
                    $message = '';
                    $status = '';
        
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
                        // $designation_name = "Business Mentor";
                    
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
                $output .= "</tbody></table>";
     
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=All_Payout_List.xls");
                echo $output;
                exit;
            }
            else if ($designation == 'corporate_agency') {
                $i = 1;
                foreach ($results as $row) {
                    $amount = 0;
                    $message = '';
                    $status = '';
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
                $output .= "</tbody></table>";
     
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=All_Payout_List.xls");
                echo $output;
                exit;
            }
            else if ($designation == 'ca_travelagency') {
                $i = 1;
                foreach ($results as $row) {
                    $amount = 0;
                    $message = '';
                    $status = '';
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
                } 
                $output .= "</tbody></table>";
     
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=All_Payout_List.xls");
                echo $output;
                exit;
            }else{
                $i = 1;
                foreach ($results as $row) {
                    $amount = 0;
                    $message = '';
                    $status = '';
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
                $output .= "</tbody></table>";
     
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=All_Payout_List.xls");
                echo $output;
                exit;
            }
            
        } else {
            echo "<script>alert('No data found');</script>";
            exit;
        }
    }
    
        
?>