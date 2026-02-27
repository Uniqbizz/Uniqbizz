<?php
    $sql = "SELECT * FROM `employees` WHERE reporting_manager = '".$userId."' AND (status = '0' OR status = '2')";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach(($stmt -> fetchAll()) as $key => $row){
            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y');
            $dt= new DateTime($row['added_on']);
            $datev= $dt->format('d-m-Y'); 
            $reporting_manager_id = $row['reporting_manager'];

            $stmt2 = $conn->prepare( "SELECT name FROM employees WHERE employee_id = ? AND status = '1' " );
            $stmt2 -> execute([$reporting_manager_id]);
            $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($stmt2-> rowCount()>0){
                foreach( ($stmt2->fetchAll()) as $key2 => $row2 ){
                    $reporting_manager_name = $row2['name'];
                }
            }
            echo'<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['name'].'</td>
                <td>
                    <p>'.$reporting_manager_id.'</p>
                    <p>'.$reporting_manager_name.'</p>
                </td>
                <td>'.$row['contact'].'</td>
                <td>'.$datev.'</td>';
                if($row['status'] == '2')
                    echo'<td><span class="badge bg-warning">Pending</span></td>';
                else{
                    echo'<td><span class="badge bg-danger">Deleted</span></td>';
                }
            echo'</tr>';
        }
    }
?>