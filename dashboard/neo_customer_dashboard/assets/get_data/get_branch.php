<?php

    require '../../connect.php';

    $zone_id = $_POST['zone_id'];

    $sql = "SELECT * FROM branch WHERE zone_id = '$zone_id'";
    $result = $conn->prepare($sql);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount() > 0){
        echo '<option value="">--Select State--</option>'; 
        foreach (($result->fetchAll()) as $key => $row) {
            echo '<option value="'.$row['id'].'">'.$row['branch_name'].'</option>'; 
        }  
    }else{
        echo '<option value="">No Branch Available For selected Zone</option>'; 
    }

?>