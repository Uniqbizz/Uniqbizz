<?php
    if($userType == '24'){
        $stmt = $conn -> prepare("SELECT * FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        // print_r($userBDMS);
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            
            $stmt = $conn -> prepare("SELECT id,business_mentor_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'business_mentor' AS identity,user_type FROM `business_mentor` WHERE reference_no = ? AND user_type = '26' AND (status = '1' OR status = '3')
                                        UNION
                                        SELECT id,master_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'master_franchisee' AS identity,user_type FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28' AND (status = '1' OR status = '3')
                                        UNION
                                        SELECT id,sponsor_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'sponsor_franchisee' AS identity,user_type FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30' AND (status = '1' OR status = '3')
                                        ORDER BY register_date ASC");
            $stmt -> execute([$bdm_id,$bdm_id,$bdm_id]);
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt -> rowCount()>0){
                foreach(($stmt -> fetchAll()) as $key => $userBM){
                    $bm_id = $userBM['user_id'];
                    $bd= new DateTime($userBM['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userBM['register_date']);
                    $datev= $dt->format('d-m-Y'); 

                    echo'<tr>
                        <td>
                            <p>'.$userBM['user_id'].'</p>
                            <p><span class="badge bg-secondary lable-width">' . 
                                ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                                '</span>&nbsp; '.$userBM['firstname'].' '.$userBM['lastname'].'</p>
                        </td>
                        <td>
                            <p>'.$userBM['reference_no'].'</p>
                            <p>'.$userBM['registrant'].'</p>
                        </td>
                        <td>'.$userBM['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userBM['status'] == '3')
                            echo'<td><span class="badge bg-warning">Deactive</span></td>';
                        else{
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        }
                        if($userBM['status'] == '1'){
                            echo'<td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userBM["user_id"]. '","' .$userBM["reference_no"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","'.$userBM['identity'].'")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userBM["user_id"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
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
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                            </td>';
                        }
                    echo'</tr>';
                }
            }
        }
        

    }else if($userType == '25'){
        $stmt = $conn -> prepare("SELECT id,business_mentor_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'business_mentor' AS identity,user_type FROM `business_mentor` WHERE reference_no = ? AND user_type = '26' AND (status = '1' OR status = '3')
                                    UNION
                                    SELECT id,master_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'master_franchisee' AS identity,user_type FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28' AND (status = '1' OR status = '3')
                                    UNION
                                    SELECT id,sponsor_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'sponsor_franchisee' AS identity,user_type FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30' AND (status = '1' OR status = '3')
                                    ORDER BY register_date ASC");
        $stmt -> execute([$userId,$userId,$userId]);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $userBM){
                $bm_id = $userBM['user_id'];
                $bd= new DateTime($userBM['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userBM['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p>'.$userBM['user_id'].'</p>
                        <p><span class="badge bg-secondary lable-width">' . 
                                ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                                '</span>&nbsp; '.$userBM['firstname'].' '.$userBM['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userBM['reference_no'].'</p>
                        <p>'.$userBM['registrant'].'</p>
                    </td>
                    <td>'.$userBM['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userBM['status'] == '3')
                        echo'<td><span class="badge bg-warning">Deactive</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                    if($userBM['status'] == '1'){
                        echo'<td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userBM["user_id"]. '","' .$userBM["reference_no"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","'.$userBM['identity'].'")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userBM["user_id"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
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
                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                            </ul>
                        </div>
                        </td>';
                    }
                echo'</tr>';
            }
        }
    }else if($userType == '31'){
        $stmt = $conn -> prepare("SELECT id,master_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'master_franchisee' AS identity,user_type FROM `master_franchisee` WHERE reference_no = ? AND user_type = '28' AND (status = '1' OR status = '3')
                                    UNION
                                    SELECT id,sponsor_franchisee_id AS user_id,firstname,lastname,reference_no,registrant,contact_no,status,date_of_birth,register_date,country,state,city,branch,zone,'sponsor_franchisee' AS identity,user_type FROM `sponsor_franchisee` WHERE reference_no = ? AND user_type = '30' AND (status = '1' OR status = '3')
                                    ORDER BY register_date ASC");
        $stmt -> execute([$userId,$userId]);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach(($stmt -> fetchAll()) as $key => $userBM){
                $bm_id = $userBM['user_id'];
                $bd= new DateTime($userBM['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userBM['register_date']);
                $datev= $dt->format('d-m-Y'); 

                echo'<tr>
                    <td>
                        <p>'.$userBM['user_id'].'</p>
                        <p><span class="badge bg-secondary lable-width">' . 
                                ($row['user_type']=='26' ? strtoupper('bm') : ($row['user_type']== '28' ? strtoupper('mf') : ($row['user_type'] == '30' ? strtoupper('sf') : ''))) . 
                                '</span>&nbsp; '.$userBM['firstname'].' '.$userBM['lastname'].'</p>
                    </td>
                    <td>
                        <p>'.$userBM['reference_no'].'</p>
                        <p>'.$userBM['registrant'].'</p>
                    </td>
                    <td>'.$userBM['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userBM['status'] == '3')
                        echo'<td><span class="badge bg-warning">Deactive</span></td>';
                    else{
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    }
                    if($userBM['status'] == '1'){
                        echo'<td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userBM["user_id"]. '","' .$userBM["reference_no"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","'.$userBM['identity'].'")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$userBM["user_id"]. '","' .$userBM["country"]. '","' .$userBM["state"]. '","' .$userBM["city"]. '","' .$userBM["zone"]. '", "'.$userBM['branch'].'","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
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
                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userBM["id"].'","'.$userBM["user_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                            </ul>
                        </div>
                        </td>';
                    }
                echo'</tr>';
            }
        }
    }
?>