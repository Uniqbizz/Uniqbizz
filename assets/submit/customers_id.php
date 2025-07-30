<?php
    require '../../connect.php';
    
    //data comes from tour-details.php when Travel associate selected Registered or lead customer type In Book this tour form
    $user_cust_id = $_POST['user_cust_id']; // Travel associate Id
    $status = $_POST['status']; // status of customer to verify if customer is registered or lead

    // important -: all customers must have Travel associate reference name and id wheather customer is added by TA or customer added another customer.

    $customer = $conn->prepare("SELECT * FROM ca_customer where ta_reference_no='".$user_cust_id."' AND status='".$status."' ");
    $customer->execute();
    $customer->setFetchMode(PDO::FETCH_ASSOC);
    if($customer->rowCount()>0){
        echo '<option>--Select Customer ID--</option>';
        foreach (($customer->fetchAll()) as $key => $row) {
            echo '<option value="'.$row['ca_customer_id'].'">';
        }
    }else {
        echo '<option> No Customer to Show </option>';
    }
?>