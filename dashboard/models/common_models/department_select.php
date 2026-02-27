<?php
    require '../../connect.php';
    $sql = "SELECT * FROM `department` WHERE status ='1' ";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt-> rowCount()>0 ){
        foreach( ($stmt -> fetchAll()) as $key => $row ){
            echo'
                <option value="'.$row['id'].'">'.$row['dept_name'].'</option>
            ';
        }
    }else{
        echo '<option value="">Department not available</option>'; 
    }
?>