<?php

    if($userType == "24"){
        
        $stmt = $conn -> prepare("SELECT employee_id FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            //BM/MF/SF->TE/F/I->TC/IBR->CU
            $stmt2 = $conn->prepare("SELECT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' 
                                     UNION ALL
                                     SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                     UNION ALL
                                     SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id,$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];

                $stmt3 = $conn->prepare("SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                         UNION ALL
                                         SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? 
                                         UNION ALL
                                         SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?");
                $stmt3->execute([$bm_id, $bm_id, $bm_id]);
                $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['suser_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?
                                             UNION ALL
                                             SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                    $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['user_id'];
                        //    echo $userCA.'=>'.$userTA.'</br>';

                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                        $stmt5->execute([$userCATA['user_id']]);
                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($userCACUs as $userCACU) {
                            $userCU = $userCACU['id'];
                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                            $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                            $bd= new DateTime($userCACU['date_of_birth']);
                            $bdate= $bd->format('d-m-Y');
                            $dt= new DateTime($userCACU['register_date']);
                            $datev= $dt->format('d-m-Y'); 
                            echo'<tr>
                                <td>
                                    <p>'.$userCACU['ca_customer_id'].'</p>
                                    <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                                </td>
                                <td>
                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                </td>
                                <td>
                                    <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                    <p class="mb-0">'.$comp_chek.'</p>
                                </td>
                                <td>'.$userCACU['contact_no'].'</td>
                                <td>'.$datev.'</td>';
                                if($userCACU['status'] == '1')
                                    echo'<td><span class="badge bg-success">Active</span></td>';
                                else{
                                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                }
                            echo'</tr>';
                        }
                    }   
                }
                
                //direct TC with BM/MF Ref
                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                        $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>
                                <p>'.$userCACU['ca_customer_id'].'</p>
                                <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>
                                <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                <p class="mb-0">'.$comp_chek.'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '1')
                                echo'<td><span class="badge bg-success">Active</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                            }
                        echo'</tr>';
                    }
                }  
            }
            //BDM->TE/F/I-TC/IBR->CU
            $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? 
                                     UNION ALL
                                     SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt3->execute([$bdm_id,$bdm_id,$bdm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                         UNION ALL
                                         SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                        $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>
                                <p>'.$userCACU['ca_customer_id'].'</p>
                                <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>
                                <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                <p class="mb-0">'.$comp_chek.'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '1')
                                echo'<td><span class="badge bg-success">Active</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            //BDM->TC->CU
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }  
        }
    }else if($userType == "25"){
        
        //BM/MF/SF->TE/F/I->TC/IBR->CU
        $stmt2 = $conn->prepare("SELECT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '26' 
                                 UNION ALL
                                 SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                 UNION ALL
                                 SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'");
        $stmt2->execute([$userId,$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];

            $stmt3 = $conn->prepare("SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ? 
                                     UNION ALL
                                     SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
            $stmt3->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                         uNION ALL
                                         SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                    //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                    $stmt5->execute([$userCATA['user_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                        $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>
                                <p>'.$userCACU['ca_customer_id'].'</p>
                                <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>
                                <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                <p class="mb-0">'.$comp_chek.'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '1')
                                echo'<td><span class="badge bg-success">Active</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            
            //direct TC with BM/MF Ref
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }  
        }
        
        //BDM->F/TE/TE-TC/IBR->CU
        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ? 
                                 UNION ALL
                                 SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?");
        $stmt3->execute([$userId,$userId,$userId]);
        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['user_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        //BDM->TC->CU
        $stmt4 = $conn->prepare("SELECT ca_travelagency FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>
                        <p>'.$userCACU['ca_customer_id'].'</p>
                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>
                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
        }   
        
    }else if( $userType == "26" || $userType =="28" || $userType =="30"){
        $stmt2 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
          
        $stmt2->execute([$userId,$userId,$userId]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($referrals as $referral){
            $userCA = $referral['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ? 
                                     UNION ALL
                                     SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
            $stmt4->execute([$userCA,$userCA]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['user_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $userCU = $userCACU['ca_customer_id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1'){
                            echo'<td><span class="badge bg-success">Active</span></td>';
                            
                        }else{
                            echo'<td><span class="badge bg-danger">Deactivate</span></td>';
                            
                        }
                    echo'</tr>';
                }
            }   
        }
        
        //direct TC with BM/MF Ref
        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? ");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                $userCU = $userCACU['ca_customer_id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>
                        <p>'.$userCACU['ca_customer_id'].'</p>
                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>
                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '1'){
                        echo'<td><span class="badge bg-success">Active</span></td>';
                        
                    }else{
                        echo'<td><span class="badge bg-danger">Deactivate</span></td>';
                        
                    }
                echo'</tr>';
            }
        }  
    }else if($userType == "16" || $userType == "29" || $userType == '32'){
        
        $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                 UNION ALL
                                 SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
        $stmt4->execute([$userId,$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['user_id'];
            // echo $userTA.'</br>';

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status='1' OR status = '3')");
            $stmt5->execute([$userCATA['user_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                // echo $userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>
                        <p>'.$userCACU['ca_customer_id'].'</p>
                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                        <td>
                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '3')
                        echo'<td><span class="badge bg-danger">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "11" || $userType == "33"){
        $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = '$userId' AND (status = '1' OR status = '3') ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['register_date']);
                $datev= $dt->format('d-m-Y'); 
                $comp_chek = $row['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                echo'<tr>
                    <td>
                        <p>'.$row['ca_customer_id'].'</p>
                        <p>'.$row['firstname'].' '.$row['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                        <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                    </td>
                    <td>
                        <p class="mb-0">'.$row['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    
                    if($row['status'] == '3')
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                    if($userType == '11'){
                        if($row['status'] == '1'){
                            echo'<td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["ca_customer_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_customer")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                        <li><a class="dropdown-item addref-item-btn" onclick=\'addRefFunc("' .$row["ca_customer_id"]. '","'.$userId.'","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","addreff")\'><i class="ri-contacts-fill align-bottom me-2 text-muted"></i> Add Ref</a></li>
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_customer_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>';
                        }else{
                            echo'<td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                        }
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "10"){
        $sql = "SELECT * FROM `ca_customer` WHERE reference_no = '$userId' AND (status = '1' OR status = '3') ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['register_date']);
                $datev= $dt->format('d-m-Y'); 
                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                echo'<tr>
                    <td>
                        <p>'.$row['ca_customer_id'].'</p>
                        <p>'.$row['firstname'].' '.$row['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                        <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                    </td>
                    <td>
                        <p class="mb-0">'.$row['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    
                    if($row['status'] == '3')
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                    if($userType == '10'){
                        if($row['status'] == '1'){
                            echo'<td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_customer_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>';
                        }else{
                            echo'<td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_customer_id"].'","'.$row["reference_no"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                        }
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "31"){
        
        //MF/SF->F->TC->CU
        $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];

            $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ? ");
            $stmt3->execute([$bm_id,$bm_id,$bm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['suser_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                         UNION ALL
                                         SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
                $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['user_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                    $stmt5->execute([$userCATA['user_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                        $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>
                                <p>'.$userCACU['ca_customer_id'].'</p>
                                <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>
                                <p class="mb-0">'.$userCACU['customer_type'].'</p>
                                <p class="mb-0">'.$comp_chek.'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '1')
                                echo'<td><span class="badge bg-success">Active</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            
            //direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }  
        }
        //BDM->F-TC->CU
        $stmt3 = $conn->prepare("SELECT sub_franchisee_id AS suser_id FROM `sub_franchisee` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT corporate_agency_id AS suser_id FROM `corporate_agency` WHERE reference_no = ?
                                 UNION ALL
                                 SELECT institution_id AS suser_id FROM `institution` WHERE reference_no = ?  ");
        $stmt3->execute([$userId,$userId,$userId]);
        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['suser_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM ca_travelagency WHERE reference_no = ?
                                     UNION ALL
                                     SELECT institution_branch_manager_id AS user_id FROM institution_branch_manager WHERE reference_no = ?");
            $stmt4->execute([$userCA['suser_id'],$userCA['suser_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['user_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
                $stmt5->execute([$userCATA['user_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                    $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>
                            <p>'.$userCACU['ca_customer_id'].'</p>
                            <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>
                            <p class="mb-0">'.$userCACU['customer_type'].'</p>
                            <p class="mb-0">'.$comp_chek.'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        //RM->TC->CU
        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='1' OR status = '3') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';
                $comp_chek = $userCACU['comp_chek'] == '1' ? 'complimentary' : 'Noncomplimentary'; 
                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>
                        <p>'.$userCACU['ca_customer_id'].'</p>
                        <p>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>
                        <p class="mb-0">'.$userCACU['customer_type'].'</p>
                        <p class="mb-0">'.$comp_chek.'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
        } 
            
        
    }
?>