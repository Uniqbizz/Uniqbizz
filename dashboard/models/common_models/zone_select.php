<?php
    require '../../connect.php';
    $sql = "SELECT * FROM `zone` WHERE status ='1' ";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt-> rowCount()>0 ){
        foreach( ($stmt -> fetchAll()) as $key => $row ){
            echo'
                <option value="'.$row['id'].'">'.$row['zone_name'].'</option>
            ';
        }
    }else{
        echo '<option value="">Zone not available</option>'; 
    }
?>