<?php
    if($userType == "24"){

        $stmt = $conn -> prepare("SELECT DISTINCT employee_id  FROM `employees` WHERE reporting_manager = ? AND user_type = '25' ");
        $stmt -> execute([$userId]);
        $userBDMS = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        foreach( $userBDMS as $userBDM ){
            $bdm_id = $userBDM['employee_id'];
            
            //BM->TE
            $stmt2 = $conn->prepare("SELECT DISTINCT business_mentor_id FROM business_mentor WHERE reference_no = ? AND user_type = '26' ");
            $stmt2->execute([$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['business_mentor_id'];
                
                $stmt4 = $conn->prepare("SELECT DISTINCT corporate_agency_id,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM corporate_agency WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id]);
                $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $userBC = $userCA['id'];
                    $bd= new DateTime($userCA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td><p><span class="badge bg-secondary lable-width">' . strtoupper('te') . '</span>&nbsp;'.$userCA['corporate_agency_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                        <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                        <td><p>'.$userCA['amount'].'</p></td>
                        <td>'.$userCA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCA['status'] == '2')
                            echo'<td><span class="badge bg-danger">Pending</span></td>';
                        else{
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        }
                    echo'</tr>';
                }
            }
            //Direct TE
            $stmt4 = $conn->prepare("SELECT DISTINCT corporate_agency_id,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM corporate_agency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bdm_id]);
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td><p><span class="badge bg-secondary lable-width">' . strtoupper('te') . '</span>&nbsp;'.$userCA['corporate_agency_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td><p>'.$userCA['amount'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
            //Direct F
            $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bdm_id,$bdm_id]);
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td><p>'.$userCA['amount'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>';
                    }
                echo'</tr>';
            }
            //SF/MF->F
            $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' 
                                    UNION
                                    SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30' ");
            $stmt2->execute([$bdm_id,$bdm_id]);
            $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($userBMS as $userBM) {
                $bm_id = $userBM['id'];
                
                $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')");
                $stmt4->execute([$bm_id,$bm_id]);
                $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userCAs as $userCA) {
                    $userBC = $userCA['id'];
                    $bd= new DateTime($userCA['date_of_birth']);
                    $bdate= $bd->format('d-m-Y');
                    $dt= new DateTime($userCA['register_date']);
                    $datev= $dt->format('d-m-Y'); 
                    echo'<tr>
                        <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                        <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                        <td><p>'.$userCA['amount'].'</p></td>
                        <td>'.$userCA['contact_no'].'</td>
                        <td>'.$datev.'</td>';
                        if($userCA['status'] == '1')
                            echo'<td><span class="badge bg-success">Active</span></td>';
                        else{
                            echo'<td><span class="badge bg-danger">Deactive</span></td>';
                        }
                    echo'</tr>';
                }
            }
        }
        
    }
    else if($userType == "25"){
                
        //Direct F/I/TE
        $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                UNION ALL
                                SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')
                                UNION ALL
                                SELECT DISTINCT corporate_agency_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM corporate_agency WHERE reference_no = ? AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId,$userId,$userId]);
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['register_date']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td><p>'.$userCA['amount'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                    
                                </ul>
                            </div>
                        </td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                }
            echo'</tr>';
        }
        //SF/MF/BM->F/I/TE
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '28' 
                                UNION ALL
                                SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '30'
                                UNION ALL
                                SELECT DISTINCT business_mentor_id AS id FROM business_mentor WHERE reference_no = ? AND user_type = '30' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT corporate_angency_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM corporate_angency WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id,$bm_id]);
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td><p>'.$userCA['amount'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                    </ul>
                                </div>
                            </td>';
                    }
                echo'</tr>';
            }
        }
        if (!$userCA && !$userBM) {
            echo'<tr><tr>';
        }
    }
    else if($userType == "26"){
        
        //Direct F/I/TE
        $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                UNION ALL
                                SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')
                                UNION ALL
                                SELECT DISTINCT corporate_agency_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM corporate_agency WHERE reference_no = ? AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId,$userId,$userId]);
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['register_date']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td><p>'.$userCA['amount'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                    
                                </ul>
                            </div>
                        </td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                }
            echo'</tr>';
        }
        if (!$userCA) {
            echo'<tr><tr>';
        }
        
    }
    else if($userType == "28" || $userTYpe == "30"){
        
        //Direct F
        $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                UNION ALL
                                SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId,$userId]);
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['register_date']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td><p>'.$userCA['amount'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                }
            echo'</tr>';
        }
        if (!$userCA && !$userBM) {
            echo'<tr><tr>';
        }
        
    }
    else if($userType == "31"){
        //Direct F
        $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')");
        $stmt4->execute([$userId,$userId]);
        $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userCAs as $userCA) {
            $userBC = $userCA['id'];
            $bd= new DateTime($userCA['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($userCA['register_date']);
            $datev= $dt->format('d-m-Y'); 
            echo'<tr>
                <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                <td><p>'.$userCA['amount'].'</p></td>
                <td>'.$userCA['contact_no'].'</td>
                <td>'.$datev.'</td>';
                if($userCA['status'] == '1')
                    echo'<td><span class="badge bg-success">Active</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                    <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                    
                                </ul>
                            </div>
                        </td>';
                else{
                    echo'<td><span class="badge bg-danger">Deactive</span></td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["sub_franchisee_id"].'","'.$userCA["sub_franchisee_id"].'","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                </ul>
                            </div>
                        </td>';
                }
            echo'</tr>';
        }
        //SF/MF->F
        $stmt2 = $conn->prepare("SELECT DISTINCT master_franchisee_id AS id FROM master_franchisee WHERE reference_no = ? AND user_type = '26' 
                                UNION
                                SELECT DISTINCT sponsor_franchisee_id AS id FROM sponsor_franchisee WHERE reference_no = ? AND user_type = '26' ");
        $stmt2->execute([$userId,$userId]);
        $userBMS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($userBMS as $userBM) {
            $bm_id = $userBM['id'];
            
            $stmt4 = $conn->prepare("SELECT DISTINCT sub_franchisee_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM sub_franchisee WHERE reference_no = ? AND (status = '1' OR status = '3')
                                     UNION ALL
                                     SELECT DISTINCT institution_id,user_type,id,date_of_birth,country,state,city,user_type, firstname, lastname, reference_no, registrant, amount, contact_no, register_date, status,register_by FROM institution WHERE reference_no = ? AND (status = '1' OR status = '3')");
            $stmt4->execute([$bm_id,$bm_id]);
            $userCAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            foreach ($userCAs as $userCA) {
                $userBC = $userCA['id'];
                $bd= new DateTime($userCA['date_of_birth']);
                $bdate= $bd->format('d-m-Y');
                $dt= new DateTime($userCA['register_date']);
                $datev= $dt->format('d-m-Y'); 
                echo'<tr>
                    <td><p><span class="badge bg-secondary lable-width">' . strtoupper($userCA['user_type'] == '29'?'f':($userCA['user_type'] == '32'?'i':'')) . '</span>&nbsp;'.$userCA['sub_franchisee_id'].'</p><p>'.$userCA['firstname'].' '.$userCA['lastname'].'</p></td>
                    <td><p>'.$userCA['reference_no'].'</p><p>'.$userCA['registrant'].'</p></td>
                    <td><p>'.$userCA['amount'].'</p></td>
                    <td>'.$userCA['contact_no'].'</td>
                    <td>'.$datev.'</td>';
                    if($userCA['status'] == '1')
                        echo'<td><span class="badge bg-success">Active</span></td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$userCA["sub_franchisee_id"]. '","' .$userCA["reference_no"]. '","' .$userCA["country"]. '","' .$userCA["state"]. '","' .$userCA["city"]. '","sub_franchisee")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                        <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' . $userCA["sub_franchisee_id"] . '","' . $userCA["reference_no"] . '","' . $userCA["register_by"] . '","' . $userCA["country"] . '","' . $userCA["state"] . '","' . $userCA["city"] . '","registered","' . $userCA["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","registered","'.$userId.'","'.$userCA['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>';
                    else{
                        echo'<td><span class="badge bg-danger">Deactive</span></td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$userCA["id"].'","'.$userCA["sub_franchisee_id"].'","' . $userCA["reference_no"] . '","deactivate","'.$userId.'","'.$userCA['user_type'].'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                                    </ul>
                                </div>
                            </td>';
                    }
                echo'</tr>';
            }
        }  
    }
?>