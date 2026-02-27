<?php
    $sql = "SELECT * FROM `employees` WHERE reporting_manager = ? AND (status = '1' OR status = '3')";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([$userId]);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach(($stmt -> fetchAll()) as $key => $row){
            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($row['register_date']);
            $datev= $dt->format('d-m-Y'); 

            $reporting_manager = $row['reporting_manager'];
            $stmt2 = $conn->prepare(' SELECT name FROM employees WHERE employee_id = ? ');
            $stmt2 -> execute([$reporting_manager]);
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2-> rowCount()>0){
                foreach(($stmt2 -> fetchAll()) as $row2 => $key2){
                    $reporting_manager_name = $key2['name'];
                }
            }
            echo'<tr>
                <td>
                    <p>'.$row['employee_id'].'</p>
                    <p>'.$row['name'].'</p>
                </td>
                <td>
                    <p>'.$reporting_manager.'</p>
                    <p>'.$reporting_manager_name.'</p>
                </td>
                <td>'.$row['contact'].'</td>
                <td>'.$datev.'</td>';
                
                if($row['status'] == '3')
                    echo'<td><span class="badge bg-danger">Deactive</span></td>';
                else{
                    echo'<td><span class="badge bg-success">Active</span></td>';
                }
                if($row['status'] == '1'){
                    echo'<td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["employee_id"]. '","' .$row["reporting_manager"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '", "'.$row['branch'].'","business_developement_manager")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["employee_id"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '", "'.$row['branch'].'","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["employee_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
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
                            <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["employee_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
                        </ul>
                    </div>
                    </td>';
                }
            echo'</tr>';
        }
    }
?>