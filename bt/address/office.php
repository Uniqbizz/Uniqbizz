<?php 
// Include the database config file 
require '../connect.php';
 
if(!empty($_POST["zone_id"])){ 
    // Fetch region data based on the specific zone 

    $stmt = $conn->prepare("SELECT * FROM region WHERE zone_id = '".$_POST['zone_id']."' AND status = 1 ORDER BY region_name ASC");
    $stmt->execute();                                                                                   
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of region options list 

    if($stmt->rowCount()>0){
         echo '<option value="">--Select Region--</option>'; 
        foreach (($stmt->fetchAll()) as $key => $row) {
            echo '<option value="'.$row['id'].'">'.$row['region_name'].'</option>'; 
        }  
    }else{ 
        echo '<option value="">Region not available</option>'; 
    } 
}elseif(!empty($_POST["region_id"])){ 
    // Fetch branch data based on the specific region

    $stmt2 = $conn->prepare("SELECT * FROM branch WHERE region_id = '".$_POST['region_id']."' AND status = 1 ORDER BY branch_name ASC");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of branch options list

     if($stmt2->rowCount()>0){
         echo '<option value="">--Select Branch--</option>'; 
        foreach (($stmt2->fetchAll()) as $key => $row2) {
           echo '<option value="'.$row2['id'].'">'.$row2['branch_name'].'</option>'; 
        }   
    }else{ 
        echo '<option value="">Branch not available</option>'; 
    } 
} 
?>