
<?php
//For Multiple designation add form get name ref:corporate partner 
require '../connect.php';

$user_id = $_POST["user_id_name"]; 
$userType = $_POST["designation"]; 

if($userType == "sales_manager"){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM sales_manager WHERE sales_manager_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of firstname and lastname 

    if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 
}

if($userType == "channel_business_director"){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM channel_business_director WHERE channel_business_director_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of firstname and lastname 

    if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 
}

if($userType == "travel_agent"){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM travel_agent WHERE travel_agent_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of firstname and lastname 

    if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 
}

if($userType = "business_trainee"){

    $stmt2 = $conn->prepare("SELECT * FROM business_trainee WHERE business_trainee_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "branch_manager"){

    $stmt2 = $conn->prepare("SELECT * FROM branch_manager WHERE branch_manager_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "corporate_agency"){

    $stmt2 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "ca_travelagency"){

    $stmt2 = $conn->prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "base_agency"){

    $stmt2 = $conn->prepare("SELECT * FROM base_agency WHERE base_agency_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "franchisee"){

    $stmt2 = $conn->prepare("SELECT * FROM franchisee WHERE franchisee_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "regional_manager"){

    $stmt2 = $conn->prepare("SELECT * FROM regional_manager WHERE regional_manager_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "head_office"){

    $stmt2 = $conn->prepare("SELECT * FROM head_office WHERE head_office_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "zonal_manager"){

    $stmt2 = $conn->prepare("SELECT * FROM zonal_manager WHERE zonal_manager_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "ca_franchisee"){

    $stmt2 = $conn->prepare("SELECT * FROM ca_franchisee WHERE ca_franchisee_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "business_operation_executive"){

    $stmt2 = $conn->prepare("SELECT * FROM business_operation_executive WHERE business_operation_executive_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "training_manager"){

    $stmt2 = $conn->prepare("SELECT * FROM training_manager WHERE training_manager_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "business_consultant"){

    $stmt2 = $conn->prepare("SELECT * FROM business_consultant WHERE business_consultant_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "business_mentor"){

    $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '$user_id' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['firstname'].' '. $row2['lastname'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}

if($userType = "business_development_manager"){

    $stmt2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '$user_id' AND user_type = '25' AND status = 1");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
        foreach (($stmt2->fetchAll()) as $key => $row2) {
        	echo $row2['name'];
        	// echo '<script>document.getElementById("pin").value ="'.$row2['pincode'].'"</script>';
        	// echo '<script>'$('#pin').val(.$row2['pincode'].)'</script>';
            
        }  
    }else{
            echo '';
    } 

}



?>