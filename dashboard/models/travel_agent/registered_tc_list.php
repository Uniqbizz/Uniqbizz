<?php

    if($userType == "24"){
        
        $stmt = $conn->prepare("SELECT employee_id FROM employees WHERE reporting_manager = ? AND user_type = '25'");
        $stmt->execute([$userId]);
        $userBDMS = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($userBDMS as $userBDM){

            $bdm_id = $userBDM['employee_id']; //  FIXED

            // ================= DIRECT TC WITH BDM =================
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id,date_of_birth,register_date,reference_no,firstname,lastname,registrant,contact_no,status
                                    FROM ca_travelagency 
                                    WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {

                $bd = new DateTime($userCATA['date_of_birth']);
                $datev = (new DateTime($userCATA['register_date']))->format('d-m-Y'); 

                $ref = get_reference($conn, $userCATA['reference_no']);

                echo '<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
                        <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>
                        <p class="mb-1">'.$ref[1].'</p>
                        <p class="mb-0">'.$ref[0].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';

                    echo ($userCATA['status'] == '1')
                        ? '<td><span class="badge bg-success">Active</span></td>'
                        : '<td><span class="badge bg-danger">Deactive</span></td>';

                echo '</tr>';
            }

            // ================= BDM → BM =================
            $stmt2 = $conn->prepare("
                SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                UNION
                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28'
                UNION ALL
                SELECT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26'
            ");
            $stmt2->execute([$bdm_id,$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM){
                
                $bm_id = $userBM['id'];

                // ================= BM → CA =================
                $stmt2 = $conn->prepare("
                    SELECT sub_franchisee_id AS suser_id FROM sub_franchisee WHERE reference_no = ?
                    UNION ALL
                    SELECT institution_id AS suser_id FROM institution WHERE reference_no = ?
                    UNION ALL
                    SELECT corporate_agency_id AS suser_id FROM corporate_agency WHERE reference_no = ?
                ");
                $stmt2->execute([$bm_id,$bm_id,$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){

                    $stmt4 = $conn->prepare("
                        SELECT ca_travelagency_id AS tc_id,firstname,lastname,registrant,reference_no,contact_no,date_of_birth,register_date,status
                        FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')
                        UNION ALL
                        SELECT institution_branch_manager_id AS tc_id,firstname,lastname,registrant,reference_no,contact_no,date_of_birth,register_date,status
                        FROM institution_branch_manager WHERE reference_no = ? AND (status = '1' OR status = '3')
                    ");
                    $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA){

                        $datev = (new DateTime($userCATA['register_date']))->format('d-m-Y'); 
                        $ref = get_reference($conn, $userCATA['reference_no']); //  FIXED

                        echo '<tr>
                            <td>
                                <p>'.$userCATA['tc_id'].'</p>
                                <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td>
                                <p class="mb-1">'.$ref[1].'</p>
                                <p class="mb-0">'.$ref[0].'</p>
                            </td>
                            <td>'.$userCATA['contact_no'].'</td>
                            <td>'.$datev.'</td>';

                            echo ($userCATA['status'] == '1')
                                ? '<td><span class="badge bg-success">Active</span></td>'
                                : '<td><span class="badge bg-danger">Deactive</span></td>';

                        echo '</tr>';
                    }
                }

                // ================= DIRECT TC WITH BM =================
                $stmt4 = $conn->prepare("
                    SELECT ca_travelagency_id AS tc_id,firstname,lastname,registrant,reference_no,contact_no,date_of_birth,register_date,status
                    FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')
                ");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA){

                    $datev = (new DateTime($userCATA['register_date']))->format('d-m-Y'); 
                    $ref = get_reference($conn, $userCATA['reference_no']);

                    echo '<tr>
                        <td>
                            <p>'.$userCATA['tc_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td>
                            <p class="mb-1">'.$ref[1].'</p>
                            <p class="mb-0">'.$ref[0].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';

                        echo ($userCATA['status'] == '1')
                            ? '<td><span class="badge bg-success">Active</span></td>'
                            : '<td><span class="badge bg-danger">Deactive</span></td>';

                    echo '</tr>';
                }
            }
        }
    }else if($userType == "25"){
        //direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT ca_travelagency_id,date_of_birth,register_date,reference_no,firstname,lastname,contact_no,status,user_type
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['register_date']);
            $datev= $dt->format('d-m-Y');

            echo'<tr>
                <td>
                    <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['ca_travelagency_id'].'</p>
                    <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                </td>
                <td>
                    <p>'.$userCATA['reference_no'].'</p>
                    <p>'.$userCATA['registrant'].'</p>
                </td>
                <td>'.$userCATA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCATA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                }
            echo'</tr>';
        }
        //BDM->MF/SF/BM
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                UNION
                                SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28'
                                UNION ALL
                                SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId,$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF/BM->F/TE/I->TC/IBR
            $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                    UNION ALL
                                    SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?
                                    UNION ALL
                                    SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS tc_id,firstname,lastname,registrant, reference_no,contact_no,status,date_of_birth,register_date,user_type
                                        FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')
                                        UNION ALL
                                        SELECT institution_branch_manager_id AS tc_id,firstname,lastname,registrant, reference_no,contact_no,status,date_of_birth,register_date,user_type
                                        FROM institution_branch_manager WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['tc_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }   
            }
            
            //direct TC with BM/MF Ref
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id,firstname,lastname,registrant, reference_no,contact_no,status,date_of_birth,register_date,user_type
                                        FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>
                        <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['ca_travelagency_id'].'</p>
                        <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
            
        }
        //BDM->F/TE/I-TC/IBR
        $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                UNION ALL
                                SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?
                                UNION ALL
                                SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt2->execute([$userId,$userId,$userId]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS tc_id,firstname,lastname,registrant, reference_no,contact_no,status,date_of_birth,register_date,user_type
                                    FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')
                                    UNION ALL
                                    SELECT institution_branch_manager_id AS tc_id,firstname,lastname,registrant, reference_no,contact_no,status,date_of_birth,register_date,user_type
                                    FROM institution_branch_manager WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['tc_id'].'</p>
                        <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }   
        }
        
        
    }
    else if($userType == "16" || $userType == "26" || $userType == "29" || $userType == "28" || $userType == "30" || $userType == '32'){
        if(in_array($userType, ["28","29","30","26"])){
            // Create a function to print the CA Travel Agency Row (to avoid duplicate code)
            function showCaTravelAgencyRow($userCATA, $conn,$userId,$userType){
                $bdate = (new DateTime($userCATA['date_of_birth']))->format('d-m-Y');
                $datev = (new DateTime($userCATA['register_date']))->format('d-m-Y');
                $message=$userCATA['user_type'] == 11 ? 'ca_travelagency' : ($userCATA['user_type'] == 33 ? 'institution_branch_manager' : '');
                echo '<tr>
                        <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['user_id'].'</p><p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p></td>
                        <td><p>'.$userCATA['reference_no'].'</p><p>'.$userCATA['registrant'].'</p></td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';

                if($userCATA['status'] == '1'){
                    echo '<td><span class="badge bg-success">Active</span></td>';
                    if (substr($userCATA['reference_no'], 0, 2) === 'MF' || 
                        substr($userCATA['reference_no'], 0, 2) === 'SF' ||
                        substr($userCATA['reference_no'], 0, 1) === 'F' || 
                        substr($userCATA['reference_no'], 0, 1) === 'I'){
                        echo '<td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCATA["user_id"].'","'.$userCATA["reference_no"].'","'.$userCATA["country"].'","'.$userCATA["state"].'","'.$userCATA["city"].'","'.$message.'")\'>
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> 
                                                    Overview
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCATA["user_id"]. '","' .$userCATA["country"]. '","' .$userCATA["state"]. '","' .$userCATA["city"]. '","registered","'.$userCATA['user_type'].'")\'>
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> 
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCATA["id"].'","'.$userCATA["user_id"].'","'.$userCATA["reference_no"].'","registered","'.$userId.'","'.$userType.'","'.$userCATA['user_type'].'")\'>
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> 
                                                    Delete
                                                    </a>
                                                </li>
                                        </ul>
                                    </div>
                                </td>';  
                    }else{
                        echo '<td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCATA["user_id"].'","'.$userCATA["reference_no"].'","'.$userCATA["country"].'","'.$userCATA["state"].'","'.$userCATA["city"].'","'.$message.'")\'>
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> 
                                                    Overview
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>';  
                    }    
                }else{
                    echo '<td><span class="badge bg-danger">Deactive</span></td>';

                    $logsCheck = $conn->prepare("SELECT * FROM logs WHERE user_id=? AND operation='deactivated' ORDER BY register_date DESC LIMIT 1 ");
                    $logsCheck->execute([$userCATA["user_id"]]);
                    $resLog = $logsCheck->fetch(PDO::FETCH_ASSOC);

                    $referenceMap = [
                        "1" => "Admin",
                        "29" => "Franchisee",
                        "28" => "Master Franchisee",
                        "30" => "Sponsor Franchisee",
                        "32" => "Institution"
                    ];

                    $deactivatedBy = isset($referenceMap[$resLog['from_whom']]) ? $referenceMap[$resLog['from_whom']] : 'Unknown';

                    echo '<td>Deactivated by '.$deactivatedBy.'</td>';
                }

                echo '</tr>';
            }
            // Fetch sub_franchisee referrals
            $stmt2 = $conn->prepare("SELECT sub_franchisee_id as suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_id as suser_id FROM `institution` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT corporate_agency_id as suser_id FROM `corporate_agency` WHERE reference_no = ?");
            $stmt2->execute([$userId,$userId,$userId]);
            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($referrals as $referral){
                $userCA = $referral['suser_id'];

                $stmt4 = $conn->prepare("SELECT id,ca_travelagency_id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,
                                        contact_no,status,user_type,register_date,country,state,city
                                        FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')
                                        UNION ALL
                                        SELECT id,institution_branch_manager_id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,
                                        contact_no,status,user_type,register_date,country,state,city
                                        FROM institution_branch_manager WHERE reference_no=? AND (status ='1' OR status='3')");
                $stmt4->execute([$userCA,$userCA]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    showCaTravelAgencyRow($userCATA, $conn,$userId,$userType);
                }
            }

            // Additional check: Master Franchisee can have direct CA
            if($userType == "28" || $userType =="29"){
                $stmtDirectCA = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmtDirectCA->execute([$userId]);
                $directCAs = $stmtDirectCA->fetchAll(PDO::FETCH_ASSOC);

                foreach ($directCAs as $userCATA) {
                    showCaTravelAgencyRow($userCATA, $conn,$userId,$userType);
                }
            }
            
        }else{
            if($userType == '16'){
                $sql4 = "SELECT *,CASE WHEN tm.te_id IS NOT NULL THEN 1 ELSE 0 END AS alloted_check
                    FROM `ca_travelagency` 
                    LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = '" . $userId . "'
                    WHERE (reference_no = '$userId' OR tm.te_id = '" . $userId . "') AND (status = '1' OR status = '3') ";
            }else{
                $sql4 = "SELECT ca_travelagency_id AS ca_travelagency_id,id,date_of_birth,register_date,firstname,lastname,contact_no,status,reference_no,registrant,country,state,city,user_type
                         FROM `ca_travelagency` WHERE reference_no = '$userId' AND (status = '1' OR status = '3')
                         UNION ALL
                         SELECT institution_branch_manager_id AS ca_travelagency_id,id,date_of_birth,register_date,firstname,lastname,contact_no,status,reference_no,registrant,country,state,city,user_type
                         FROM `institution_branch_manager` WHERE reference_no = '$userId' AND (status = '1' OR status = '3') ";
            }
            $stmt4 = $conn -> prepare($sql4);
            $stmt4 -> execute();
            $stmt4 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt4 -> rowCount()>0){
                foreach(($stmt4 -> fetchAll()) as $key => $row){
                    $bd= new DateTime($row['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($row['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    $lastName=$row['lastname'];
                    if($userType ='16'){
                        if(!empty($row['alloted_check'])){
                            if($row['alloted_check'] == 1){
                                $lastName.='<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea; width: fit-content;">
                                        Allotted TC
                                    </small>';
                            }
                        }
                    }
                    echo'<tr>
                        <td>
                            <p><span class="badge bg-secondary lable-width">' . strtoupper($row['user_type'] == '11'?'tc':($row['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$row['ca_travelagency_id'].'</p>
                            <p>'.$row['firstname'].' '.$lastName.'</p>
                        </td>';
                        if(!empty($row['alloted_check'])){
                            if($row['alloted_check'] == 1){
                                echo'<td>

                                        <p>Allotted TC</p>
                                    </td>';
                            }
                        }else{
                            echo'<td>
                                    <p>'.$row['reference_no'].'</p>
                                    <p>'.$row['registrant'].'</p>
                                </td>';
                        }
                    echo'<td>'.$row['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        
                        if($row['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                        if($userType == '16' || $userType == "26" || $userType == "28" || $userType == "29" || $userType == "30"){ 
                            if($row['status'] == '1'){
                                echo'<td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["ca_travelagency_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_travelagency")\'>
                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> 
                                                    Overview
                                                </a>
                                            </li>';
                                if($userType =='16'){
                                    if(!empty($row['alloted_check'])){
                                        if($row['alloted_check'] == 0){
                                            echo'<li>
                                                    <a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_travelagency_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered","'.$row['user_type'].'")\'>
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> 
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$userType.',"'.$row['user_type'].'")\'>
                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> 
                                                        Delete
                                                    </a>
                                                </li>';
                                        }
                                    }else{
                                        echo'<li>
                                                <a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_travelagency_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered","'.$row['user_type'].'")\'>
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> 
                                                    Edit
                                                </a>
                                            </li>
                                            <li>    
                                                <a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$row['user_type'].'")\'>
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> 
                                                    Delete
                                                </a>
                                            </li>'; 
                                    }
                                }
                                echo'   </ul>
                                    </div>
                                </td>';
                            }else{
                                echo'<td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","deactivate","'.$userId.'","'.$userType.'")\'>
                                                    <i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> 
                                                    Restore
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>';
                            }
                        }    
                    echo'</tr>';
                }
            }
        } 
            
    }else if($userType == "31"){
        
        //direct TC with RM Ref
        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS ca_travelagency_id,date_of_birth,register_date,firstname,lastname,contact_no,status,user_type
                         FROM `ca_travelagency` WHERE reference_no = ? AND (status = '1' OR status = '3')
                         UNION ALL
                         SELECT institution_branch_manager_id AS ca_travelagency_id,date_of_birth,register_date,firstname,lastname,contact_no,status,user_type
                         FROM `institution_branch_manager` WHERE reference_no = ?' AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId,$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['register_date']);
            $datev= $dt->format('d-m-Y');

            echo'<tr>
                <td>
                    <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['ca_travelagency_id'].'</p>
                    <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                </td>
                <td>
                    <p>'.$userCATA['reference_no'].'</p>
                    <p>'.$userCATA['registrant'].'</p>
                </td>
                <td>'.$userCATA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCATA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                }
            echo'</tr>';
        }
        //RM->MF/SF/BM
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                 UNION ALL
                                 SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' 
                                 UNION ALL
                                 SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$bdm_id]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF/BM->F/TE/I->TC/IBR
            $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                      ");
            $stmt2->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id,date_of_birth,register_date,firstname,lastname,reference_no,
                                         registrant,contact_no,status,user_type FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')
                                         UNION ALL
                                         SELECT institution_branch_manager_id AS user_id,date_of_birth,register_date,firstname,lastname,reference_no,
                                         registrant,contact_no,status,user_type FROM institution_branch_manager WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>
                            <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['user_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }   
            }
            
            //direct TC with SF/MF Ref
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id,date_of_birth,register_date,firstname,lastname,reference_no,
                                    registrant,contact_no,status,user_type FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')
                                    UNION ALL
                                    SELECT institution_branch_manager_id AS user_id,date_of_birth,register_date,firstname,lastname,reference_no,
                                    registrant,contact_no,status,user_type FROM institution_branch_manager WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id,$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>
                        <p><span class="badge bg-secondary lable-width">' . strtoupper($userCATA['user_type'] == '11'?'tc':($userCATA['user_type'] == '33'?'i':'')) . '</span>&nbsp;'.$userCATA['ca_travelagency_id'].'</p>
                        <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
            
        }
        
    }
?>