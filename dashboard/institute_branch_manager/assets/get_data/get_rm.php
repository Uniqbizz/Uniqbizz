<?php

    require '../../connect.php';

    $branch_id = $_POST['branch_id'];

    $sql = "SELECT * FROM rm WHERE branch_id = '$branch_id'";
    $result = $conn->prepare($sql);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    if($result->rowCount() > 0){
        echo '<option value="">--Select RM--</option>'; 
        foreach (($result->fetchAll()) as $key => $row) {
            echo '<option value="'.$row['id'].'">'.$row['rm_name'].'</option>'; 
        }
    }else{
        echo '<option value="">No RM Available For selected Branch</option>'; 
    }

?>