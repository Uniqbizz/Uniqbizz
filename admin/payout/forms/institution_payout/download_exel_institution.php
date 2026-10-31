<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'] ?? '';
$payoutMonth = $_GET['payoutMonth'] ?? '';
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

if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout' || $payoutmessage == 'TotalPayout'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $sql ="(SELECT s.id, s.employees as userId, s.message_emp as message, sp.payout_details, s.commission_emp as comm_amt, s.institution, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, 'employees' as identity 
                FROM institution_payout s
                LEFT JOIN institution_payout_paid sp on sp.user_id=s.employees 
                WHERE YEAR(s.created_date) = :payoutYear AND MONTH(s.created_date) = :payoutMonth AND (s.employees <> 'NA' AND s.employees <> 'Not Applicable' AND s.employees IS NOT NULL)) 
                UNION
                (SELECT s.id, s.bm_mf_sf as userId, s.message_bm_mf_sf as message, sp.payout_details, s.commission_bm_mf_sf as comm_amt, s.institution, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, '".$designation."' as identity 
                FROM institution_payout s
                LEFT JOIN institution_payout_paid sp on sp.user_id=s.bm_mf_sf 
                WHERE YEAR(s.created_date) = :payoutYear AND MONTH(s.created_date) = :payoutMonth AND (s.bm_mf_sf <> 'NA' AND s.bm_mf_sf <> 'Not Applicable' AND s.bm_mf_sf IS NOT NULL)) 
                order by created_date desc ";


    $params = [
                ':payoutYear' => $payoutYear,
                ':payoutMonth' => $payoutMonth
            ];

    $stmt2 = $conn->prepare($sql);
    $stmt2->execute($params);
} 

if($payoutmessage == 'TotalPayoutAll'){
    $output="";
    // $stmt2 = "SELECT * FROM ca_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $sql ="(SELECT s.id, s.employees as userId, s.message_emp as message, sp.payout_details, s.commission_emp as comm_amt, s.institution, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, 'employees' as identity 
                FROM institution_payout s
                LEFT JOIN institution_payout_paid sp on sp.user_id=s.employees 
                WHERE (s.employees <> 'NA' AND s.employees <> 'Not Applicable' AND s.employees IS NOT NULL)) 
                UNION
                (SELECT s.id, s.bm_mf_sf as userId, s.message_bm_mf_sf as message, sp.payout_details, s.commission_bm_mf_sf as comm_amt, s.institution, s.created_date,IFNULL(sp.created_date, 'NA') AS paydate, s.status, '".$designation."' as identity 
                FROM institution_payout s
                LEFT JOIN institution_payout_paid sp on sp.user_id=s.bm_mf_sf 
                WHERE (s.bm_mf_sf <> 'NA' AND s.bm_mf_sf <> 'Not Applicable' AND s.bm_mf_sf IS NOT NULL)) 
                order by created_date desc ";

    $params = [];

    $stmt2 = $conn->prepare($sql);
    $stmt2->execute($params);
    
} 

if($payoutmessage == 'allPayout'){
    if ($designation == 'chief_techno_enterprise') {

        $sql = "
            SELECT
                s.id,
                s.employees AS userId,
                s.message_emp AS message,
                sp.payout_details,
                s.commission_emp AS comm_amt,
                s.institution,
                s.created_date,
                s.status,
                IFNULL(sp.created_date, 'NA') AS paydate,
                'Chief Techno Enterprise' AS identity
            FROM institution_payout s
            LEFT JOIN institution_payout_paid sp
                ON sp.user_id = s.employees
            WHERE
                s.employees <> 'NA'
                AND s.employees <> 'Not Applicable'
                AND s.employees IS NOT NULL
        ";

        // 1. Specific user + specific month/year
        if ($user_id && $payoutYear && $payoutMonth) {

            $sql .= "
                AND s.employees = :user_id
                AND YEAR(s.created_date) = :payoutYear
                AND MONTH(s.created_date) = :payoutMonth
            ";

            $params = [
                ':user_id' => $user_id,
                ':payoutYear' => $payoutYear,
                ':payoutMonth' => $payoutMonth
            ];

        // 2. Specific user + all dates
        } elseif ($user_id) {

            $sql .= " AND s.employees = :user_id ";

            $params = [
                ':user_id' => $user_id
            ];

        // 3. All users + specific month/year
        } elseif ($payoutYear && $payoutMonth) {

            $sql .= "
                AND YEAR(s.created_date) = :payoutYear
                AND MONTH(s.created_date) = :payoutMonth
                AND s.status = '1'
            ";

            $params = [
                ':payoutYear' => $payoutYear,
                ':payoutMonth' => $payoutMonth
            ];

        // 4. All users + all dates
        } else {
            $sql .="";
            $params = [];
        }

        $sql .= " ORDER BY s.created_date DESC ";
        
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute($params);
    }else if($designation == 'business_development_manager'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee='".$user_id."' AND master_franchisee LIKE 'MF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else if($payoutYear && $payoutMonth){
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'MF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'MF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }
    }else if($designation == 'executive_techno_enterprise'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee='".$user_id."' AND master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else if ($payoutYear && $payoutMonth){
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }
    }else if($designation == 'business_mentor'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee='".$user_id."' AND master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else if ($payoutYear && $payoutMonth){
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }
    }else if($designation == 'master_franchisee'){
        if ($user_id) {
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                FROM sub_franchisee_payout s
                LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                WHERE s.master_franchisee='".$user_id."' AND master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                ORDER BY created_date desc";
        }else if ($payoutYear && $payoutMonth){
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND YEAR(s.created_date) = '".$payoutYear."' AND MONTH(s.created_date) = '".$payoutMonth."'  AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                    ORDER BY created_date desc";
        }else{
            $stmt2 ="SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commission_mf as comm_amt, s.sub_franchisee, s.created_date, s.status,IFNULL(sp.created_date, 'NA') AS paydate ,'".$designation."' as identity 
                    FROM sub_franchisee_payout s
                    LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                    WHERE master_franchisee LIKE 'SF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
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

}

    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        $output = '';
    	$output .= '<h2 style="text-align:center"> Payout List as of '.$monthName.','.$payoutYear.'</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th >Date</th>
                <th class="mobile_view">CTE/BDM/ETE/BM/MF/SF ID</th>
                <th class="mobile_view">CTE/BDM/ETE/BM/MF/SF Name</th>
                <th class="mobile_view">Institution</th>
                <th class="mobile_view">Institution Name</th>
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

                $user_id = substr($userId, 0, 2);

                if($user_id == "MF"){
                    $bcNames = $conn -> prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$userId."' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['firstname'].' '.$row['lastname'];
                            $designation = "Master Franchisee";
                        }
                    }  
                } else if($user_id == "SF"){
                    $bcNames = $conn -> prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$userId."' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['firstname'].' '.$row['lastname'];
                            $designation = "Sponsor Franchisee";
                        }
                    }  
                }else if($user_id == "BM"){
                    $bcNames = $conn -> prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$userId."' AND user_type = '26' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['firstname'].' '.$row['lastname'];
                            $designation = "Business Mentor";
                        }
                    }  
                }else if($user_id == "BH"){
                    $bcNames = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$userId."' AND user_type = '25' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['name'];
                            $designation = "Business Development Manager";
                        }
                    }  
                }else if($user_id == "ET"){
                    $bcNames = $conn -> prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$userId."' AND user_type = '34' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['firstname'].' '.$row['lastname'];
                            $designation = "Executive Techno Enterprise";
                        }
                    }  
                }else if($user_id == "CT"){
                    $bcNames = $conn -> prepare("SELECT * FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$userId."' AND user_type = '36' AND status = 1");
                    $bcNames -> execute();
                    $bcNames -> setFetchMode(PDO::FETCH_ASSOC);
                    if($bcNames -> rowCount()>0){
                        foreach(($bcNames -> fetchAll()) as $key => $row){
                            $refname = $row['firstname'].' '.$row['lastname'];
                            $designation = "Chief Techno Enterprise";
                        }
                    }  
                }

                $sql2= $conn->prepare("SELECT name,registrant FROM `institution` where institution_id='".$row2['institution']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                if($sql2->rowCount()>0){
                    foreach (($sql2->fetchAll()) as $key => $row3) {
                        $ins_name = $row3['name'];
                        $bm_name=$row3['registrant'];
                    }
                } 

                $output .= '<tr>
                    <td >'.$newDate.'</td>
                    <td>'.$userId.'</td>
                    <td>'.$refname.'</td>
                    <td>'.$row2['institution'].'</td>
                    <td>'.$ins_name.'</td>
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
        header("Content-Disposition: attachment;filename=".$payoutmessage."_List.xls");
        echo $output;
    }else{
        echo 'No Payout Data';                                                    
    }    

?>