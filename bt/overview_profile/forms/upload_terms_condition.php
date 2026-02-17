<?php
    require '../../connect.php';

    $cust_id = $_POST['cust_id'];
    $terms_condition_img = $_POST['termsAndConditionImg'];

    $sql = "UPDATE ca_customer SET terms_condition = :terms_condition WHERE ca_customer_id = :ca_customer_id ";
    $stmt = $conn->prepare($sql);
	$result =  $stmt->execute([
		':terms_condition' => $terms_condition_img,
		':ca_customer_id' => $cust_id
    ]);

    if($result){
        echo 1 ;
    }
?>