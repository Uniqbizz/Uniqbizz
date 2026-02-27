<?php
    if($userType == '24'){
        $stmt = $conn -> prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        // print_r($userBDMS);
        $i=1;
        foreach( $userBDMS as $userBDM ){
            
            $bdm_id = $userBDM['employee_id'];
            
            $stmt = $conn -> prepare("SELECT * FROM `business_mentor` WHERE reference_no = ? AND user_type = '26' AND (status = '0' OR status = '2')
                                    UNION
                                    SELECT * FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' AND (status = '0' OR status = '2')
                                    UNION
                                    SELECT * FROM master_franchisee WHERE reference_no = ? AND user_type = '28' AND (status = '0' OR status = '2')
                                    ORDER BY added_on ASC"
                                    );
            $stmt -> execute([$bdm_id,$bdm_id,$bdm_id]);
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt -> rowCount()>0){
                foreach(($stmt -> fetchAll()) as $key => $row){
                    $bd= new DateTime($row['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($row['added_on']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td>'.$i.'</td>
                        <td><span class="badge bg-secondary lable-width">' . 
                            ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                            '</span>&nbsp; '.$row['firstname'].' '.$row['lastname'].'</td>
                        <td>
                            <p>'.$row['reference_no'].'</p>
                            <p>'.$row['registrant'].'</p>
                        </td>
                        <td>'.$row['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($row['status'] == '2')
                            echo'<td><span class="badge bg-warning">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deleted</span></td>';
                        }
                    echo'</tr>';
                    $i++;
                }
            }

        }

    }else if($userType == '25'){
        $stmt = $conn -> prepare("SELECT * FROM `business_mentor` WHERE reference_no = ? AND user_type = '26' AND (status = '0' OR status = '2')
                                    UNION
                                    SELECT * FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' AND (status = '0' OR status = '2')
                                    UNION
                                    SELECT * FROM master_franchisee WHERE reference_no = ? AND user_type = '28' AND (status = '0' OR status = '2')
                                    ORDER BY added_on ASC");
        $stmt -> execute([$userId,$userId,$userId]);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            $i=0;
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$i.'</td>
                    <td><span class="badge bg-secondary lable-width">' . 
                        ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                        '</span>&nbsp; '.$row['firstname'].' '.$row['lastname'].'</td>
                    <td>
                        <p>'.$row['reference_no'].'</p>
                        <p>'.$row['registrant'].'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
                $i++;
            }
        }
    }else if($userType == '31'){
        $stmt = $conn -> prepare("SELECT * FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' AND (status = '0' OR status = '2')
                                    UNION
                                    SELECT * FROM master_franchisee WHERE reference_no = ? AND user_type = '28' AND (status = '0' OR status = '2')
                                    ORDER BY added_on ASC");
        $stmt -> execute([$userId,$userId]);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            $i++;
            foreach(($stmt -> fetchAll()) as $key => $row){
                $bd= new DateTime($row['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($row['added_on']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td>'.$i.'</td>
                    <td><span class="badge bg-secondary lable-width">' . 
                        ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                        '</span>&nbsp; '.$row['firstname'].' '.$row['lastname'].'</td>
                        <p>'.$row['reference_no'].'</p>
                        <p>'.$row['registrant'].'</p>
                    </td>
                    <td>'.$row['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($row['status'] == '2')
                        echo'<td><span class="badge bg-warning">Pending</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deleted</span></td>';
                    }
                echo'</tr>';
                $i++;
            }
        }
    }
?>