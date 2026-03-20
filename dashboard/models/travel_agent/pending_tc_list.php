<?php

    include 'get_upper_channel.php';

    if($userType == "24"){
        
        $stmt = $conn -> prepare("SELECT employee_id FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            //direct TC with BDM Ref
            $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                    FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                    ");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                $ref = get_reference($conn, $row['reference_no']);
                
                echo'<tr>
                    <td>'.$userCATA['user_id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td><p class="mb-1">'.$ref[1].'</p>
                        <p class="mb-0">'.$ref[0].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            } 
            //BDM->MF/SF/BM
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                     UNION ALL
                                     SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'
                                     UNION ALL
                                     SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26'    ");
            $stmt2->execute([$bdm_id,$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                //MF/SF/BM->TE/F/I->TC/IBR
                $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                         UNION ALL
                                         SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ?
                                         UNION ALL
                                         SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id,$bm_id,$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['suser_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                             UNION ALL
                                             SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                    $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['user_id'];
                        //echo $userCA.'=>'.$userTA.'</br>';

                        $bd= new DateTime($userCATA['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCATA['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        
                        $ref = get_reference($conn, $row['reference_no']);
                        

                        echo'<tr>
                            <td>'.$userCATA['user_id'].'</td>
                            <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td><p class="mb-1">'.$ref[1].'</p>
                                <p class="mb-0">'.$ref[0].'</p>
                            </td>
                            <td>'.$userCATA['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCATA['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Delete</span></td>';
                            }
                        echo'</tr>';
                    }   
                }
                
                //direct TC with MF/BM Ref
                $stmt4 = $conn->prepare("SELECT id ,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                         FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    $ref = get_reference($conn, $row['reference_no']);
                    
                    echo'<tr>
                        <td>'.$userCATA['id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$ref[1].'</p>
                            <p class="mb-0">'.$ref[0].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Delete</span></td>';
                        }
                    echo'</tr>';
                }
            }
            //BDM->F/I/TE-TC/IBR
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id,$bdm_id,$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                         FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                         UNION ALL
                                         SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                         FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    $ref = get_reference($conn, $row['reference_no']);
                    
                    echo'<tr>
                        <td>'.$userCATA['user_id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$ref[1].'</p>
                            <p class="mb-0">'.$ref[0].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Delete</span></td>';
                        }
                    echo'</tr>';
                }   
            }
        }
    }else if($userType == "25"){
        //direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                ");
        $stmt4->execute([$user_id]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['user_id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 
            $ref = get_reference($conn, $row['reference_no']);
            
            echo'<tr>
                <td>'.$userCATA['user_id'].'</td>
                <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                <td>
                    <p>'.$userCATA['reference_no'].'</p>
                    <p>'.$userCATA['registrant'].'</p>
                </td>
                <td><p class="mb-1">'.$ref[1].'</p>
                    <p class="mb-0">'.$ref[0].'</p>
                </td>
                <td>'.$userCATA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCATA['status'] == '2')
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                else{
                    echo'<td><span class="badge bg-danger">Delete</span></td>';
                }
            echo'</tr>';
        } 
        //BDM->MF/SF/BM
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                 UNION ALL 
                                 SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'
                                 UNION ALL
                                 SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId,$userId,$user_id]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF/BM->F/TE/I->TC/IBR
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                         FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                         UNION ALL
                                         SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                         FROM institution_branch_manager WHERE reference_no=? AND (status ='2' OR status='0')");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>'.$userCATA['user_id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Delete</span></td>';
                        }
                    echo'</tr>';
                }   
            }
            
            //direct TC with MF/BM Ref
            $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                     UNION ALL
                                     SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                     FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
            $stmt4->execute([$bm_id,$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>'.$userCATA['user_id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            }
        }
        //BDM->F/I/TE-TC/IBR
        $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
        $stmt2->execute([$bm_id]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                     UNION ALL
                                     SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                     FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['user_id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            }   
        }
    }else if($userType == "26" || $userType == "28" || $userType == "30"){
        $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
        
        $stmt2->execute([$userId,$user_id,$user_id]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($referrals as $referral){
            $userCA = $referral['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                     UNION ALL
                                     SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                     FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
            $stmt4->execute([$userCA,$userCA]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['user_id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '2'){
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    }else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            }   
        }
        
        //direct TC with BM/MF Ref
        
        $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                UNION ALL
                                SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
        $stmt4->execute([$userId,$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['user_id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 

            echo'<tr>
                <td>'.$userCATA['user_id'].'</td>
                <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                <td>
                    <p>'.$userCATA['reference_no'].'</p>
                    <p>'.$userCATA['registrant'].'</p>
                </td>
                <td>'.$userCATA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCATA['status'] == '2'){
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                }else{
                    echo'<td><span class="badge bg-danger">Delete</span></td>';
                }
                echo'</tr>';
        }  

    }else if($userType == "16" || $userType == "29" || $userType == "32"){
        $sql3 = "SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                UNION ALL
                SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ";
        
        $stmt3 = $conn -> prepare($sql3);
        $stmt3 -> execute([$userId,$userId]);
        $stmt3 -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt3 -> rowCount()>0){
            foreach(($stmt3 -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$row['user_id'].'</td>
                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td>
                        <p>'.$row['reference_no'].'</p>
                        <p>'.$row['registrant'].'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "31"){
        
        //direct TC with RM Ref
        $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                     UNION ALL
                                     SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                     FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
        $stmt4->execute([$userId,$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['user_id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 

            echo'<tr>
                <td>'.$userCATA['user_id'].'</td>
                <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                <td>
                    <p>'.$userCATA['reference_no'].'</p>
                    <p>'.$userCATA['registrant'].'</p>
                </td>
                <td>'.$userCATA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCATA['status'] == '2')
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                else{
                    echo'<td><span class="badge bg-danger">Delete</span></td>';
                }
            echo'</tr>';
        }
        //RM->MF/SF/BM
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                 UNION ALL 
                                 SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'
                                 UNION ALL
                                 SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId,$userId,$user_id]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF/BM->F/I/TE->TC/IBR
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT DISTINCT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
            $stmt2->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                        FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                        UNION ALL
                                        SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                        FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>'.$userCATA['user_id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCATA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Delete</span></td>';
                        }
                    echo'</tr>';
                }   
            }
            
            //direct TC with MF/BM Ref
            $stmt4 = $conn->prepare("SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status 
                                     FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')
                                     UNION ALL
                                     SELECT id AS user_id,date_of_birth,added_on,registrant,reference_no,lastname,firstname,contact_no,status
                                     FROM institution_branch_manager WHERE reference_no = ? AND  (status = '2' OR status = '0') ");
            $stmt4->execute([$bm_id,$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>'.$userCATA['user_id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td>'.$userCATA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCATA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delete</span></td>';
                    }
                echo'</tr>';
            }
        }
        
    }
?>