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

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                    $stmt4->execute([$userCA['corporate_agency_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['id'];
                        //echo $userCA.'=>'.$userTA.'</br>';

                        $bd= new DateTime($userCATA['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCATA['added_on']);
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
                            <td>'.$userCATA['id'].'</td>
                            <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td><p class="mb-1">'.$id.'</p>
                                <p class="mb-0">'.$name.'</p>
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
                
                //direct TC with BM Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
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
                        <td>'.$userCATA['id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //direct TC with BDM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$bdm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
                    <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                    <td>
                        <p>'.$userCATA['reference_no'].'</p>
                        <p>'.$userCATA['registrant'].'</p>
                    </td>
                    <td><p>'.$userCATA['reference_no'].'</p>
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
            //BDM->MF/SF
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                        UNION 
                                        SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                //MF/SF->F->TC
                $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
                $stmt2->execute([$bm_id]);
                $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                foreach($userCAs as $userCA){
                    $userCAID = $userCA['sub_franchisee_id'];
                    // echo $userCA;

                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                    $stmt4->execute([$userCA['sub_franchisee_id']]);
                    $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($userCATAs as $userCATA) {
                        $userTA = $userCATA['id'];
                        //echo $userCA.'=>'.$userTA.'</br>';

                        $bd= new DateTime($userCATA['date_of_birth']);
                        $bdate= $bd->format('d-m-Y');
                        $dt= new DateTime($userCATA['added_on']);
                        $datev= $dt->format('d-m-Y'); 
                        
                        $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                        
                        if ($reference_no == "F") {
                            $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
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
                            $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
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
                            <td>'.$userCATA['id'].'</td>
                            <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                            <td>
                                <p>'.$userCATA['reference_no'].'</p>
                                <p>'.$userCATA['registrant'].'</p>
                            </td>
                            <td><p class="mb-1">'.$id.'</p>
                                <p class="mb-0">'.$name.'</p>
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
                
                //direct TC with MF/SF Ref
                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$bm_id]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                        
                    if ($reference_no == "F") {
                        $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
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
                        $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
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
                        <td>'.$userCATA['id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //BDM->F-TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                    
                    if ($reference_no == "F") {
                        $sql2 = "SELECT registrant,reference_no FROM `sub_franchisee` WHERE sub_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
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
                        $sql2 = "SELECT registrant,reference_no FROM `master_franchisee` WHERE master_franchisee_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
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
                        <td>'.$userCATA['id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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
            //BDM->TE-TC
            $stmt2 = $conn->prepare("SELECT DISTINCT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
            $stmt2->execute([$bdm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['corporate_agency_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    
                    $reference_no = substr($userCATA['reference_no'], 0, 1) == 'F'?substr($userCATA['reference_no'], 0, 1):substr($userCATA['reference_no'], 0, 2);
                    
                    if ($reference_no == "CA" || $reference_no== "TE") {
                        $sql2 = "SELECT registrant,reference_no FROM `corporate_agency` WHERE corporate_agency_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY sponsor_franchisee_id ASC ";
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
                        $sql2 = "SELECT registrant,reference_no FROM `business_mentor` WHERE business_mentor_id = '".$userCATA['reference_no']."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
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
                        <td>'.$userCATA['id'].'</td>
                        <td>'.$userCATA['firstname'].' '.$userCATA['lastname'].'</td>
                        <td>
                            <p>'.$userCATA['reference_no'].'</p>
                            <p>'.$userCATA['registrant'].'</p>
                        </td>
                        <td><p class="mb-1">'.$id.'</p>
                            <p class="mb-0">'.$name.'</p>
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

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['corporate_agency_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>'.$userCATA['id'].'</td>
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
            
            //direct TC with BM Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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
        //direct TC with BDM Ref
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 

            echo'<tr>
                <td>'.$userCATA['id'].'</td>
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
        //BDM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION 
                                    SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>'.$userCATA['id'].'</td>
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
            
            //direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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
        //BDM->F-TC
        $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
        $stmt2->execute([$bm_id]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['sub_franchisee_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$userCA['sub_franchisee_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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
        //BDM->TE-TC
        $stmt2 = $conn->prepare("SELECT DISTINCT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? ");
        $stmt2->execute([$bm_id]);
        $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($userCAs as $userCA){
            $userCAID = $userCA['corporate_agency_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$userCA['corporate_agency_id']]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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
        if ($userLname == "28" || $userType == "30") {
            $stmt2 = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE reference_no = ? ");
        }else{
            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
        }
        $stmt2->execute([$userId]);
        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($referrals as $referral){
            $userCA = ($userType == '28'|| $userType == "30")?$referral['sub_franchisee_id']:$referral['corporate_agency_id'];
            // echo $userCA;

            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$userCA]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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
        
        //direct TC with BM Ref
        
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 

            echo'<tr>
                <td>'.$userCATA['id'].'</td>
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

    }else if($userType == "16" || $userType == "29"){
        $sql3 = "SELECT *
                FROM `ca_travelagency` 
                WHERE reference_no = '$userId' AND (status = '2' OR status = '0') ";
        
        $stmt3 = $conn -> prepare($sql3);
        $stmt3 -> execute();
        $stmt3 -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt3 -> rowCount()>0){
            foreach(($stmt3 -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$row['id'].'</td>
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
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCATAs as $userCATA) {
            $userTA = $userCATA['id'];
            //echo $userCA.'=>'.$userTA.'</br>';

            $bd= new DateTime($userCATA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCATA['added_on']);
            $datev= $dt->format('d-m-Y'); 

            echo'<tr>
                <td>'.$userCATA['id'].'</td>
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
        //RM->MF/SF
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION 
                                    SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            //MF/SF->F->TC
            $stmt2 = $conn->prepare("SELECT DISTINCT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? ");
            $stmt2->execute([$bm_id]);
            $userCAs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach($userCAs as $userCA){
                $userCAID = $userCA['sub_franchisee_id'];
                // echo $userCA;

                $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
                $stmt4->execute([$userCA['sub_franchisee_id']]);
                $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCATAs as $userCATA) {
                    $userTA = $userCATA['id'];
                    //echo $userCA.'=>'.$userTA.'</br>';

                    $bd= new DateTime($userCATA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCATA['added_on']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>'.$userCATA['id'].'</td>
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
            
            //direct TC with MF/SF Ref
            $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND  (status = '2' OR status = '0')");
            $stmt4->execute([$bm_id]);
            $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCATAs as $userCATA) {
                $userTA = $userCATA['id'];
                //echo $userCA.'=>'.$userTA.'</br>';

                $bd= new DateTime($userCATA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCATA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                
                echo'<tr>
                    <td>'.$userCATA['id'].'</td>
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