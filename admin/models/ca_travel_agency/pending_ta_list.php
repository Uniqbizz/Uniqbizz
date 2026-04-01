<?php
    $sql = "SELECT 'tc' AS user_type,tc.id,tc.ca_travelagency_id AS user_id_str,tc.firstname,tc.lastname,tc.reference_no,tc.registrant,tc.country_code,tc.contact_no,
                tc.email,tc.address,tc.date_of_birth,tc.added_on,tc.address,tc.register_by,tc.country,tc.state,tc.city,tc.comp_check,tc.status,
                tc.transfer_check,IFNULL(tu.id,'NA') AS transfer_id,tc.user_type AS user_type_val
            FROM ca_travelagency tc
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = tc.ca_travelagency_id
                AND tu.transfer_status = 1
            WHERE tc.status IN ('0','2')
            OR (tc.status='1' AND tc.transfer_check='1' AND tu.id IS NOT NULL)
            UNION ALL
            SELECT 'ibr' AS user_type,ibr.id,ibr.institution_branch_manager_id AS user_id_str,ibr.firstname,ibr.lastname,ibr.reference_no,ibr.registrant,ibr.country_code,ibr.contact_no,
                ibr.email,ibr.address,ibr.date_of_birth,ibr.added_on,ibr.address,ibr.register_by,ibr.country,ibr.state,ibr.city,ibr.comp_check,
                ibr.status,ibr.transfer_check,IFNULL(tu.id,'NA') AS transfer_id,ibr.user_type AS user_type_val
            FROM institution_branch_manager ibr
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = ibr.institution_branch_manager_id
                AND tu.transfer_status = 1
            WHERE ibr.status IN ('0','2')
            OR (ibr.status='1' AND ibr.transfer_check='1' AND tu.id IS NOT NULL)
            ORDER BY id ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        foreach(($stmt->fetchAll()) as $key => $row) {
            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y');

            $rd= new DateTime($row['added_on']);
            $rdate= $rd->format('d-m-Y');

            echo'<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                <td><p class="mb-1">'.$row['reference_no'].'</p>
                    <p class="mb-0">'.$row['registrant'].'</p>
                </td>
                <td>
                    <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                    <p class="mb-0">'.$row['email'].'</p>
                </td>
                
                <td>'.$row['address'].'</td>
                <td>'.$rdate.'</td>';
                if($row['status']== '2'){
                    echo'<td><span class="badge text-bg-warning">Pending</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                <li><a href="#" onclick=\'editfuncCust("' .$row["id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","pending","'.$row["user_type_val"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","pending","'.$row["user_type"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                <li><a href="#" onclick=\'confirmfunc("' .$row["id"]. '","' .$row["email"]. '","' .$row["reference_no"]. '","'.$row["comp_check"].'","'.$row["user_type"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                            </ul>
                        </div>
                    </td>';
                }else if ($row['transfer_check'] == '1')  {
                    $user_id_str =$row['user_id_str'];
                    echo '<td><span class="badge text-bg-info">Transfer Requested</span></td>
                            <td>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 2, \''.$row['user_type_val'].'\')" class="dropdown-item">
                                            <i class="mdi mdi-check-circle text-success me-1"></i> Approve
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 3, \''.$row['user_type_val'].'\')" class="dropdown-item">
                                            <i class="mdi mdi-trash-can text-danger me-1"></i> Reject
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" 
                                            onclick=\'editfuncCust("' . $user_id_str . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . strtolower($row['user_type']) . '")\'
                                            
                                            class="dropdown-item">
                                            <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View Request
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            </td>';
                }else{
                    echo'<td><span class="badge text-bg-danger">Delete</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","deleted","'.$row["user_type"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                            </ul>
                        </div>
                    </td>';
                }
            echo'</tr>';
        }
    }
?>