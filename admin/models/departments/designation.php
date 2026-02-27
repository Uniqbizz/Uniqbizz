<?php
    require '../../connect.php';
    $srno = '1';
    $stmt2 = $conn->prepare(" SELECT * FROM `designation` WHERE status='1' ");
    $stmt2 -> execute();
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt2 -> rowCount()>0 ){
        foreach( ( $stmt2 -> fetchALL() ) as $key2 => $row2 ){
            echo'
                <tr>
                    <td>'.$srno.'</td>
                    <td>'.$row2['designation_name'].'</td>
                    <td>'.$row2['dept_name'].'</td>
                    <td class="text-end">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical fs-4 text-dark"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_designation" onclick=\'saveDesig(" '.$row2['id'].' "," '.$row2['designation_name'].' "," '.$row2['dept_id'].' "," '.$row2['dept_name'].' "," edit "," '.$row2['status'].' ")\'><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_designation" onclick=\'deleteDesig(" '.$row2['id'].' "," '.$row2['designation_name'].' "," '.$row2['dept_id'].' "," '.$row2['dept_name'].' "," delete "," 0 ")\'><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            ';
            $srno++;
        }
    }
?>