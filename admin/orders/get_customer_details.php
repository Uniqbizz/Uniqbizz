<?php
require '../connect.php';

header('Content-Type: application/json');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch customer info
    $stmt2 = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = ? AND status = '1'");
    $stmt2->execute([$user_id]);
    $cuS = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Fetch all unused & confirmed coupons for the customer
    $sql = "SELECT code, coupon_amt FROM cu_coupons 
            WHERE user_id = :user_id 
            AND confirm_status = :confirm_status 
            AND usage_status = :usage_status";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':confirm_status' => 1,
        ':usage_status' => 0
    ]);
    $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Separate code and amount into separate arrays
    $couponCodes = [];
    $couponAmts = [];
    foreach ($coupons as $coupon) {
        $couponCodes[] = $coupon['code'];
        $couponAmts[]  = $coupon['coupon_amt'];
    }

    if ($cuS || !empty($couponCodes)) {
        $result = [
            'status'      => 'success',
            'custName'    => $cuS['firstname'] . ' ' . $cuS['lastname'],
            'custEmail'   => $cuS['email'],
            'custPhone'   => $cuS['contact_no'],
            'custAge'     => $cuS['age'],
            'custGender'  => strtolower($cuS['gender']),
            'couponCodes' => $couponCodes,
            'couponAmts'  => $couponAmts
        ];
    } else {
        $result = [
            'status'      => 'fail',
            'custName'    => '',
            'custEmail'   => '',
            'custPhone'   => '',
            'custAge'     => '',
            'custGender'  => '',
            'couponCodes' => [],
            'couponAmts'  => []
        ];
    }

    echo json_encode($result);
}
?>
