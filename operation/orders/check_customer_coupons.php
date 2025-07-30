<?php
// check_customer_coupons.php
require '../connect.php';

if(isset($_POST['cust_id'])) {
    $cust_id = $_POST['cust_id'];
    
    $sql = "SELECT * FROM `cu_coupons` 
            WHERE user_id = :user_id 
            AND confirm_status = :confirm_status 
            AND usage_status = :usage_status";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $cust_id,
        ':confirm_status' => 1,
        ':usage_status' => 0
    ]);
    $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['coupons' => $coupons]);
}
?>