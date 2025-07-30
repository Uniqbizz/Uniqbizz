<?php
require '../connect.php';

if(!empty($_POST["city_id"])){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM cities WHERE id = '".$_POST['city_id']."' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['pincode'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }   
    }
}

?>