<?php

require '../../connect.php';

    $cust_id = $_POST['cust_id'];
    $user_type = $_POST['user_type'];


    if ( $user_type == '2' ) {
        // get customer data
        $stmt = $conn->prepare("SELECT * FROM customer where cust_id='".$cust_id."' ");
    } else if ( $user_type == '3' ) {
        // get Travel Agent data
        $stmt = $conn->prepare("SELECT firstname,lastname,email,contact_no FROM travel_agent where travel_agent_id='".$cust_id."' ");
    } else if ( $user_type == '11' ) {
        // get Travel Agent data
        $stmt = $conn->prepare("SELECT firstname,lastname,email,contact_no FROM ca_travelagency where ca_travelagency_id='".$cust_id."' ");
    } else if ( $user_type == '10' ) {
        // get Travel Agent data
        $stmt = $conn->prepare("SELECT firstname,lastname,email,contact_no,age FROM ca_customer where ca_customer_id='".$cust_id."' ");
    }
    
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetch();
    if($data){
        echo json_encode($data);
    }else{
        echo "fail";
    }
    

?>