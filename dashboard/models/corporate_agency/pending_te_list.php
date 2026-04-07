<?php
    $srNo = 1;
    if($userType == "24"){

        $stmt = $conn -> prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            //TE through BM 
            $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['business_mentor_id'];
                
                $stmt4 = $conn->prepare("SELECT 'te' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `corporate_agency` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'");
                $stmt4->execute([$bm_id]);
                $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $userBC = $userCA['id'];
                    $bd= new DateTime($userCA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$srNo++.'</td>
                        <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                        <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                        <td>'.$userCA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        }
                    echo'</tr>';
                }
            }
            //direct TE by BDM
            $stmt4 = $conn->prepare("SELECT 'te' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `corporate_agency` WHERE reference_no = '".$bdm_id."' AND status = '2' OR status = '0'");
            $stmt4->execute();
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
            
            //direct Franchisee by BDM
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `sub_franchisee` WHERE reference_no = '".$bdm_id."' AND status = '2' OR status = '0'
                                    UNION ALL
                                    SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `institution` WHERE reference_no = '".$bdm_id."' AND status = '2' OR status = '0'");
            $stmt4->execute();
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
            //Franchisee through MF/SF 
            $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                    UNION
                                    SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id,$bdm_id]);
            
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                
                $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `sub_franchisee` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'
                                        UNION ALL
                                        SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `institution` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'");
                $stmt4->execute([$bm_id]);
                $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $userBC = $userCA['id'];
                    $bd= new DateTime($userCA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCA['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$srNo++.'</td>
                        <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;' .$userCA['firstname'].' '.$userCA['lastname'].'</td>
                        <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                        <td>'.$userCA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCA['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        }
                    echo'</tr>';
                }
            }
        }
    }else if($userType == "25"){
        
        //direct F/TE/I by BDM
        $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `sub_franchisee` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                                UNION ALL
                                SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `institution` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                                UNION ALL
                                SELECT 'te' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM corporate_agency WHERE reference_no ='".$userId."' AND status = '2' OR status = '0'");
        $stmt4->execute();
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['added_on']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td>'.$srNo++.'</td>
                <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '2')
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                else{
                    echo'<td><span class="badge bg-success">Active</span></td>';
                }
            echo'</tr>';
        }
        //TE/F/I through MF/SF/BM 
        $stmt2 = $conn->prepare("SELECT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28'
                                UNION
                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' 
                                UNION ALL
                                SELECT business_mentor_id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId,$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `sub_franchisee` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'
                                    UNION ALL
                                    SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `institution` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'
                                    UNION ALL
                                    SELECT 'te' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `corporate_agency` WHERE reference_no = '".$bm_id."' AND status = '2' OR status = '0'");
            $stmt4->execute();
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;' .$userCA['firstname'].' '.$userCA['lastname'].'</td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
        }
        
    }else if($userType == '26' || $userType == '28' || $userType == '30'){
        $sql = "SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `sub_franchisee` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                UNION ALL
                SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `institution` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                UNION ALL
                SELECT 'te' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `corporate_agency` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0' ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($rows)){
            foreach($rows as $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($row['user_type']) . '</span>&nbsp;'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td><p>'.$row['reference_no'].'</p><p>'.$row['registrant'].'</p></td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == '28' || $userType == '30'){
        $sql = "SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `sub_franchisee` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                UNION ALL
                SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status,registrant FROM `institution` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'";
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
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($row['user_type']) . '</span>&nbsp;'.$row['firstname'].' '.$row['lastname'].'</td>
                    <td><p>'.$row['reference_no'].'</p><p>'.$row['registrant'].'</p></td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == "31"){
        //Franchisee through MF/SF
        $stmt2 = $conn->prepare("SELECT master_franchisee AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '26' 
                                UNOIN 
                                SELECT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '26'");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `sub_franchisee` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                                    UNION ALL
                                    SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `institution` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'");
            $stmt4->execute([$bm_id]);
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$srNo++.'</td>
                    <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                echo'</tr>';
            }
        }
        
        //direct Franchisee by RM
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $stmt4 = $conn->prepare("SELECT 'f' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `sub_franchisee` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'
                                UNION ALL
                                SELECT 'i' AS user_type,firstname,lastname,date_of_birth,added_on,reference_no,contact_no,status FROM `institution` WHERE reference_no = '".$userId."' AND status = '2' OR status = '0'");
        $stmt4->execute([$userId]);
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['added_on']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td>'.$srNo++.'</td>
                <td><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type']) . '</span>&nbsp;'.$userCA['firstname'].' '.$userCA['lastname'].'</td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '2')
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                else{
                    echo'<td><span class="badge bg-success">Active</span></td>';
                }
            echo'</tr>';
        }
        
    }
?>