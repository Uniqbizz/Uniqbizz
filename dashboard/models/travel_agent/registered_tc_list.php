<?php
    if($userType == "24"){
        
        $stmt = $conn -> prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            //BDM->BM
            $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['business_mentor_id'];
                //BM->TE->TC
                $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['corporate_agency_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                    $stmt4->execute([$userCA['corporate_agency_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['id'];
                        //echo $userCA.'=>'.$userTA.'</br>';

                        $bd= new DateTime($userCATA['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCATA['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 2);
                        if ($reference_no == "TE" || $reference_no == "CA") {
                            $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                            $stmt2 = $conn -> prepare($sql2);
                            $stmt2 -> execute();
                            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                            if($stmt2->rowCount()>0){
                                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                    $name = $row2['registrant'];
                                    $id = $row2['reference_no'];
                                }
                            }
                        }else if($reference_no == "BM"){
                            $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                            $stmt2 = $conn -> prepare($sql2);
                            $stmt2 -> execute();
                            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                            if($stmt2->rowCount()>0){
                                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                    $name = $row2['registrant'];
                                    $id = $row2['reference_no'];
                                }
                            }
                        }

                        echo'<tr>
                            <td>
                                <p>'.$userCATA['ca_travelagency_id'].'</p>
                                <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td><p class="mb-1">'.$id.'</p>
                                <p class="mb-0">'.$name.'</p>
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
                
                //direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 2);
                    if ($reference_no == "TE" || $reference_no == "CA") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }else if($reference_no == "BM"){
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //direct TC with BDM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                
                $reference_no = substr($userCATA['reference_no'], 0, 2);
                if ($reference_no == "TE" || $reference_no == "CA") {
                    $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                    $stmt2 = $conn -> prepare($sql2);
                    $stmt2 -> execute();
                    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                    if($stmt2->rowCount()>0){
                        foreach(($stmt2->fetchAll()) as $key2 => $row2){
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }
                }else if($reference_no == "BM"){
                    $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                    $stmt2 = $conn -> prepare($sql2);
                    $stmt2 -> execute();
                    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                    if($stmt2->rowCount()>0){
                        foreach(($stmt2->fetchAll()) as $key2 => $row2){
                            $name = $row2['registrant'];
                            $id = $row2['reference_no'];
                        }
                    }
                }

                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
                        <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td><p class="mb-1">'.$id.'</p>
                        <p class="mb-0">'.$name.'</p>
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
            //BDM->MF/SF
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                        UNION
                                        SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                //MF/SF->F->TC
                $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['sub_franchisee_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                    $stmt4->execute([$userCA['sub_franchisee_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['id'];
                        //echo $userCA.'=>'.$userTA.'</br>';

                        $bd= new DateTime($userCATA['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCATA['register_date']);
                        $datev= $dt->format('d-m-Y'); 
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                        if ($reference_no == "F") {
                            $sql2 = "SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                            $stmt2 = $conn -> prepare($sql2);
                            $stmt2 -> execute();
                            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                            if($stmt2->rowCount()>0){
                                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                    $name = $row2['registrant'];
                                    $id = $row2['reference_no'];
                                }
                            }
                        }else if($reference_no == "MF"){
                            $sql2 = "SELECT * FROM `master_franchisee` WHERE master_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                            $stmt2 = $conn -> prepare($sql2);
                            $stmt2 -> execute();
                            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                            if($stmt2->rowCount()>0){
                                foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                    $name = $row2['registrant'];
                                    $id = $row2['reference_no'];
                                }
                            }
                        }
                        

                        echo'<tr>
                            <td>
                                <p>'.$userCATA['ca_travelagency_id'].'</p>
                                <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                            </td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td><p class="mb-1">'.$id.'</p>
                                <p class="mb-0">'.$name.'</p>
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
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 2);
                    if ($reference_no == "TE" || $reference_no == "CA") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }else if($reference_no == "BM"){
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //BDM->F-TC
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                    if ($reference_no == "F") {
                        $sql2 = "SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }else if($reference_no == "MF"){
                        $sql2 = "SELECT * FROM `master_franchisee` WHERE master_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }
                    

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //BDM->TE-TC
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['corporate_agency_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                    if ($reference_no == "F") {
                        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }else if($reference_no == "BM"){
                        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                        $stmt2 = $conn -> prepare($sql2);
                        $stmt2 -> execute();
                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt2->rowCount()>0){
                            foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                $name = $row2['registrant'];
                                $id = $row2['reference_no'];
                            }
                        }
                    }

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
                            <p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
    }else if($userType == "25"){
        
        //BDM->BM
        $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['business_mentor_id'];
            //BM->TE->TC
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['corporate_agency_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
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
            
            //direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
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
        //direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['register_date']);
            $datev= $dt->format('d-m-Y');

            echo'<tr>
                <td>
                    <p>'.$userCATA['ca_travelagency_id'].'</p>
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
        //BDM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
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
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
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
        //BDM->F-TC
        $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt2->execute([$userId]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['sub_franchisee_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
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
        //BDM->TE-TC
        $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt2->execute([$userId]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['corporate_agency_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$userCA['corporate_agency_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
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
    else if($userType == "16" || $userType == "26" || $userType == "29" || $userType == "28" || $userType == "30"){
        if(in_array($userType, ["28","29","30"])){
            // Create a function to print the CA Travel Agency Row (to avoid duplicate code)
            function showCaTravelAgencyRow($userCATA, $conn,$userId,$userType){
                $bdate = (new DateTime($userCATA['date_of_birth']))->format('d-m-Y');
                $datev = (new DateTime($userCATA['register_date']))->format('d-m-Y');

                echo '<tr>
                        <td><p>'.$userCATA['ca_travelagency_id'].'</p><p>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</p></td>
                        <td><p>'.$userCATA['reference_no'].'</p><p>'.$userCATA['registrant'].'</p></td>
                        <td>'.$userCATA['contact_no'].'</td>
                        <td>'.$datev.'</td>';

                if($userCATA['status'] == '1'){
                    echo '<td><span class="badge bg-success">Active</span></td>';
                    if (substr($userCATA['reference_no'], 0, 2) === 'MF' || substr($userCATA['reference_no'], 0, 1) === 'F'){
                        echo '<td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCATA["ca_travelagency_id"].'","'.$userCATA["reference_no"].'","'.$userCATA["country"].'","'.$userCATA["state"].'","'.$userCATA["city"].'","ca_travelagency")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                            <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userCATA["ca_travelagency_id"]. '","' .$userCATA["country"]. '","' .$userCATA["state"]. '","' .$userCATA["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                            <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCATA["id"].'","'.$userCATA["ca_travelagency_id"].'","'.$userCATA["reference_no"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
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
                                            <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCATA["ca_travelagency_id"].'","'.$userCATA["reference_no"].'","'.$userCATA["country"].'","'.$userCATA["state"].'","'.$userCATA["city"].'","ca_travelagency")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                        </ul>
                                    </div>
                                </td>';  
                    }    
                }else{
                    echo '<td><span class="badge bg-danger">Deactive</span></td>';

                    $logsCheck = $conn->prepare("SELECT * FROM logs WHERE user_id=? AND operation='deactivated' ORDER BY register_date DESC LIMIT 1 ");
                    $logsCheck->execute([$userCATA["ca_travelagency_id"]]);
                    $resLog = $logsCheck->fetch(PDO::FETCH_ASSOC);

                    $referenceMap = [
                        "1" => "Admin",
                        "29" => "Franchisee",
                        "28" => "Master Franchisee",
                        "30" => "Sponsor Franchisee"
                    ];

                    $deactivatedBy = isset($referenceMap[$resLog['from_whom']]) ? $referenceMap[$resLog['from_whom']] : 'Unknown';

                    echo '<td>Deactivated by '.$deactivatedBy.'</td>';
                }

                echo '</tr>';
            }
            // Fetch sub_franchisee referrals
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ?");
            $stmt2->execute([$userId]);
            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($referrals as $referral){
                $userCA = $referral['sub_franchisee_id'];

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$userCA]);
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
                $sql4 = "SELECT * FROM `ca_travelagency` WHERE reference_no = '$userId' AND (status = '1' OR status = '3') ";
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
                            <p>'.$row['ca_travelagency_id'].'</p>
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
                                            <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["ca_travelagency_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_travelagency")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>';
                                if($userType =='16'){
                                    if(!empty($row['alloted_check'])){
                                        if($row['alloted_check'] == 0){
                                            echo'<li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_travelagency_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>';
                                        }
                                    }else{
                                        echo'<li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["ca_travelagency_id"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                            <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>'; 
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
                                            <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["ca_travelagency_id"].'","'.$row["reference_no"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
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
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
        $stmt4->execute([$bdm_id]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['register_date']);
            $datev= $dt->format('d-m-Y');

            echo'<tr>
                <td>
                    <p>'.$userCATA['ca_travelagency_id'].'</p>
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
        //RM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '28' ");
        $stmt2->execute([$bdm_id]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['register_date']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>
                            <p>'.$userCATA['ca_travelagency_id'].'</p>
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
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>
                        <p>'.$userCATA['ca_travelagency_id'].'</p>
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