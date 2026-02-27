<?php
    $sql = "SELECT * FROM `ca_travelagency` WHERE status = '3' ORDER BY ca_travelagency_id ASC ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        foreach(($stmt->fetchAll()) as $key => $row) {
            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y');

            $rd= new DateTime($row['register_date']);
            $rdate= $rd->format('d-m-Y');


            $reference_no = substr($row['reference_no'], 0, 1) == 'F' ? substr($row['reference_no'], 0, 1):substr($row['reference_no'], 0, 2);
            if ($reference_no == "TE" || $reference_no == "CA") {
                $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
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
                $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                $stmt2 = $conn -> prepare($sql2);
                $stmt2 -> execute();
                $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                if($stmt2->rowCount()>0){
                    foreach(($stmt2->fetchAll()) as $key2 => $row2){
                        $name = $row2['registrant'];
                        $id = $row2['reference_no'];
                    }
                }
            }else if($reference_no == "F"){
                $sql2 = "SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY sub_franchisee_id ASC ";
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
                $sql2 = "SELECT * FROM `master_franchisee` WHERE master_franchisee_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY master_franchisee_id ASC ";
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
                <td>'.$row['ca_travelagency_id'].'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                <td><p class="mb-1">'.$row['reference_no'].'</p>
                    <p class="mb-0">'.$row['registrant'].'</p>
                </td>
                <td><p class="mb-1">'.$id.'</p>
                    <p class="mb-0">'.$name.'</p>
                </td>
                <td>'.(trim($row['amount']) !== '' ? $row['amount'] : 0) .'</td>
                <td>
                    <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                    <p class="mb-0">'.$row['email'].'</p>
                </td>
                <td>'.$row['address'].'</td>
                <td>'.$rdate.'</td>';
            echo'<td><span class="badge text-bg-danger">Deactive</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">
                            <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["ca_travelagency_id"]. '","deactivate")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                        </ul>
                    </div>
                </td>';
        echo'</tr>';
        }
    }
?>