<?php
    $sql = "SELECT * FROM `ca_customer` WHERE status = '2' OR status = '0' ORDER BY id ASC ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        foreach(($stmt->fetchAll()) as $key => $row) {
            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y');

            $rd= new DateTime($row['register_date']);
            $rdate= $rd->format('d-m-Y');

            echo'<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                if($row['reference_no']){
                        echo'<td><p class="mb-1">'.$row['reference_no'].'</p>
                        <p class="mb-0">'.$row['registrant'].'</p>
                    </td>';
                }else{
                    echo'<td><p class="mb-1">'.$row['ta_reference_no'].'</p>
                        <p class="mb-0">'.$row['ta_reference_name'].'</p>
                    </td>';
                }
                echo'<td>
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
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-left-1">
                                <li><a href="#" onclick=\'editfuncCust("' .$row["id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","pending")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","pending")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                <li><a href="#" onclick=\'confirmfunc("' .$row["id"]. '","' .$row["email"]. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
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
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-left-1">
                                <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","deleted")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                            </ul>
                        </div>
                    </td>';
                }
            echo'</tr>';
        }
    }
?>