<?php 
// Include the database config file 
require '../connect.php';
 
if(!empty($_POST["country_id"])){ 
    // Fetch state data based on the specific country 

    $stmt = $conn->prepare("SELECT * FROM states WHERE country_id = '".$_POST['country_id']."' AND status = 1 ORDER BY state_name ASC");
    $stmt->execute();                                                                                   
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of state options list 

    if($stmt->rowCount()>0){
         echo '<option value="">--Select State--</option>'; 
        foreach (($stmt->fetchAll()) as $key => $row) {
            echo '<option value="'.$row['id'].'">'.$row['state_name'].'</option>'; 
        }  
    }else{ 
        echo '<option value="">State not available</option>'; 
    } 
}elseif(!empty($_POST["state_id"])){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM cities WHERE state_id = '".$_POST['state_id']."' AND status = 1 ORDER BY city_name ASC");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
         echo '<option value="">--Select city--</option>'; 
        foreach (($stmt2->fetchAll()) as $key => $row2) {
           echo '<option value="'.$row2['id'].'">'.$row2['city_name'].'</option>'; 
        }   
    }else{ 
        echo '<option value="">City not available</option>'; 
    } 
} 
?>