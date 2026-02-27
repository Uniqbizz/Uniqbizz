<?php

    if($userType == "24"){
        
        $stmt = $conn -> prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            
            $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            //BM->TE->TC->TC->CU
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['business_mentor_id'];

                $stmt3 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
                $stmt3->execute([$bm_id]);
                $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['corporate_agency_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                    $stmt4->execute([$userCA['corporate_agency_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['ca_travelagency_id'];
                    //    echo $userCA.'=>'.$userTA.'</br>';

                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($userCACUs as $userCACU) {
                            $userCU = $userCACU['id'];
                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                            $bd= new DateTime($userCACU['date_of_birth']);
                            $bdate= $bd->format('d-m-Y');
                            $dt= new DateTime($userCACU['added_on']);
                            $datev= $dt->format('d-m-Y'); 
                            echo'<tr>
                                <td>'.$userCACU['id'].'</td>
                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                <td>
                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                </td>
                                <td>'.$userCACU['contact_no'].'</td>
                                <td>'.$datev.'</td>';
                                if($userCACU['status'] == '2')
                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                else{
                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                }
                            echo'</tr>';
                        }
                    }   
                }
                
                //direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }
            }
            //MF/SF->F->TC->TC->CU
            $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                        UNION
                                        SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];

                $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
                $stmt3->execute([$bm_id]);
                $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['sub_franchisee_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                    $stmt4->execute([$userCA['sub_franchisee_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['ca_travelagency_id'];
                    //    echo $userCA.'=>'.$userTA.'</br>';

                        $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                        $stmt5->execute([$userCATA['ca_travelagency_id']]);
                        $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($userCACUs as $userCACU) {
                            $userCU = $userCACU['id'];
                            // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                            $bd= new DateTime($userCACU['date_of_birth']);
                            $bdate= $bd->format('d-m-Y');
                            $dt= new DateTime($userCACU['added_on']);
                            $datev= $dt->format('d-m-Y'); 
                            echo'<tr>
                                <td>'.$userCACU['id'].'</td>
                                <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                                <td>
                                    <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                    <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                                </td>
                                <td>'.$userCACU['contact_no'].'</td>
                                <td>'.$datev.'</td>';
                                if($userCACU['status'] == '2')
                                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                                else{
                                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                                }
                            echo'</tr>';
                        }
                    }   
                }
                
                //direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }
            }
            //direct BDM->TC->CU by BDM ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }
            //BDM->TE->TC->CU
            $stmt3 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt3->execute([$bdm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['corporate_agency_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            //BDM->F->TC->CU
            $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt3->execute([$bdm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
        }
    }else if($userType == "25"){
        
        $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        //BM->TE->TC->TC->CU
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['business_mentor_id'];

            $stmt3 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt3->execute([$bm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['corporate_agency_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            
            //direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }
        }
        //MF/SF->F->TC->TC->CU
        $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];

            $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt3->execute([$bm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            
            //direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }
        }
        //direct BDM->TC->CU by BDM ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
        

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$userCACU['id'].'</td>
                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
            }
        }
        //BDM->TE->TC->CU
        $stmt3 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt3->execute([$userId]);
        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['corporate_agency_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$userCA['corporate_agency_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        //BDM->F->TC->CU
        $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt3->execute([$userId]);
        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['sub_franchisee_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        
    }else if($userType == "26" || $userType =="28" || $userType == "30"){
        if ($userType == "28" || $userType == "30") {
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        }else{
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        }    
        $stmt2->execute([$userId]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($referrals as $referral){
            $userCA = ($userType == "28"||$userType == "30")?$referral['sub_franchisee_id']:$referral['corporate_agency_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$userCA]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2'){
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        //     <td>
                        //     <div class="dropdown d-inline-block">
                        //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        //             <i class="ri-more-fill align-middle"></i>
                        //         </button>
                        //         <ul class="dropdown-menu dropdown-menu-end">
                        //             <!-- <li><a class="dropdown-item edit-item-btn" onclick=\'confirmfunc("' .$userCACU["id"]. '","' .$userCACU["email"]. '")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Confirm</a></li> -->
                        //             <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCACU["id"]. '","' .$userCACU["country"]. '","' .$userCACU["state"]. '","' .$userCACU["city"]. '","pending")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                        //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","pending")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                        //         </ul>
                        //     </div>
                        // </td>';
                        }else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        //     <td>
                        //     <div class="dropdown d-inline-block">
                        //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        //             <i class="ri-more-fill align-middle"></i>
                        //         </button>
                        //         <ul class="dropdown-menu dropdown-menu-end">
                        //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","deleted")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Activate</a></li>
                        //         </ul>
                        //     </div>
                        // </td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        
        //direct TC with BM/MF Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
        //    echo $userCA.'=>'.$userTA.'</br>';

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$userCACU['id'].'</td>
                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '2'){
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    //     <td>
                    //     <div class="dropdown d-inline-block">
                    //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    //             <i class="ri-more-fill align-middle"></i>
                    //         </button>
                    //         <ul class="dropdown-menu dropdown-menu-end">
                    //             <!-- <li><a class="dropdown-item edit-item-btn" onclick=\'confirmfunc("' .$userCACU["id"]. '","' .$userCACU["email"]. '")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Confirm</a></li> -->
                    //             <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCACU["id"]. '","' .$userCACU["country"]. '","' .$userCACU["state"]. '","' .$userCACU["city"]. '","pending")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                    //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","pending")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                    //         </ul>
                    //     </div>
                    // </td>';
                    }else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    //     <td>
                    //     <div class="dropdown d-inline-block">
                    //         <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    //             <i class="ri-more-fill align-middle"></i>
                    //         </button>
                    //         <ul class="dropdown-menu dropdown-menu-end">
                    //             <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCACU["id"].'","","deleted")\'><i class="ri-checkbox-circle-fill align-bottom me-2 text-muted"></i> Activate</a></li>
                    //         </ul>
                    //     </div>
                    // </td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "16" || $userType == "29"){
        
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
            // echo $userTA.'</br>';

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status='2' OR status = '0')");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$userCACU['id'].'</td>
                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Delected</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "11"){
        $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = '$userId' AND (status = '2' OR status = '0') ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td>
                        <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                        <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "10"){
        $sql = "SELECT * FROM `ca_customer` WHERE reference_no = '$userId' AND (status = '2' OR status = '0') ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td>
                        <p>'.$row['ta_reference_no'].' '.$row['ta_reference_name'].'</p>
                        <p>'.$row['reference_no'].' '.$row['registrant'].'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "31"){
        
        //MF/SF->F->TC->TC->CU
        $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];

            $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt3->execute([$bm_id]);
            $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['ca_travelagency_id'];
                //    echo $userCA.'=>'.$userTA.'</br>';

                    $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                    $stmt5->execute([$userCATA['ca_travelagency_id']]);
                    $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCACUs as $userCACU) {
                        $userCU = $userCACU['id'];
                        // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                        $bd= new DateTime($userCACU['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCACU['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        echo'<tr>
                            <td>'.$userCACU['id'].'</td>
                            <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                            <td>
                                <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                                <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                            </td>
                            <td>'.$userCACU['contact_no'].'</td>
                            <td>'.$datev.'</td>';
                            if($userCACU['status'] == '2')
                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                            else{
                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
                            }
                        echo'</tr>';
                    }
                }   
            }
            
            //direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }
        }
        //direct RM->TC->CU by BDM ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['ca_travelagency_id'];
        

            $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
            $stmt5->execute([$userCATA['ca_travelagency_id']]);
            $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCACUs as $userCACU) {
                $userCU = $userCACU['id'];
                // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                $bd= new DateTime($userCACU['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCACU['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$userCACU['id'].'</td>
                    <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                    <td>
                        <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                        <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                    </td>
                    <td>'.$userCACU['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCACU['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
            }
        }
        //RM->F->TC->CU
        $stmt3 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt3->execute([$userId]);
        $userCAs = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['sub_franchisee_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['ca_travelagency_id'];
            //    echo $userCA.'=>'.$userTA.'</br>';

                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status ='2' OR status = '0') ");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCACUs as $userCACU) {
                    $userCU = $userCACU['id'];
                    // echo $userId.'=>'.$userCA.'=>'.$userTA.'=>'.$userCU.'</br>';

                    $bd= new DateTime($userCACU['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCACU['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$userCACU['id'].'</td>
                        <td>'.$userCACU['firstname'].' '.$userCACU['lastname'].'</td>
                        <td>
                            <p>'.$userCACU['reference_no'].' '.$userCACU['registrant'].'</p>
                            <p>'.$userCACU['ta_reference_no'].' '.$userCACU['ta_reference_name'].'</p>
                        </td>
                        <td>'.$userCACU['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCACU['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                }
            }   
        }
        
    }
?>