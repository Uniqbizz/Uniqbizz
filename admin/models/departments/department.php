<?php
    require '../../connect.php';
    $srno = 1;
    $sql = "SELECT * FROM `department` WHERE status = '1' ";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach( ($stmt -> fetchAll()) as $key => $row ){
            echo'
                <tr>
                    <td>'.$srno.'</td>
                    <td>'.$row['dept_name'].'</td>
                    <td class="text-end">
                        <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical fs-4 text-dark"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_department" onclick=\'saveDept(" '.$row['id'].' "," '.$row['dept_name'].' "," edit "," '.$row['status'].' ")\'><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_department" onclick=\'deleteDept(" '.$row['id'].' "," '.$row['dept_name'].' "," delete "," 0 ")\'><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            ';
            $srno++;
        }
    }
?>