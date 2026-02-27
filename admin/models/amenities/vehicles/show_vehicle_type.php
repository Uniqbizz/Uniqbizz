<?php
    require '../../../connect.php';
    $stmt = $conn->prepare("SELECT * FROM category_vehicle where status='1' ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {
            $id= $row['id'];
            $name= $row['name'];
            echo '<tr>
                    <td><span class="fw-bold">'.++$key.'</span></td>
                    <td><span class="fw-bold">'.$name.'</span></td>
                    <td>
                        <a href="#" onclick=\'editfuncVehicle("' .$id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <a href="#" onclick=\'deletefuncVehicle("' .$id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                    </td>
                </tr>';
        }
    }else{
        echo '<tr>
        <td colspan="4">No Category Avaiable
        </td>
        <tr>';
    }
?>