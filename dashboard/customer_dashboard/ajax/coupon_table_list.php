<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
    header('Content-Type: application/json');
    $sqlAllCoupons = $conn->prepare("
        SELECT 
            c.code,
            c.coupon_amt,
            c.usage_status,
            c.created_date,
            c.used_date,
            c.user_id,
            cu.used_on,
            cu.transaction_id
        FROM cu_coupons c
        LEFT JOIN coupon_utilization cu 
            ON c.code = cu.coupon_code
        WHERE c.user_id = :user_id
    ");

    $sqlAllCoupons->execute([
        ":user_id" => $userId
    ]);

    $coupons = $sqlAllCoupons->fetchAll(PDO::FETCH_ASSOC);

    $data = [];

    foreach ($coupons as $row) {

        $data[] = [
            "code"          => $row['code'],
            "coupon_amt"    => $row['coupon_amt'],
            "status"        => ($row['usage_status'] == 1 ? "Used" : "Available"),
            "created_date"  => date('d M Y h:i A', strtotime($row['created_date'])),
            "used_date"     => !empty($row['used_date']) 
                                ? date('d M Y h:i A', strtotime($row['used_date'])) 
                                : '-',
            "used_on"       => $row['used_on'] ?? '-',
            "booking_id"    => $row['transaction_id']
        ];
    }

    echo json_encode([
        "data" => $data
    ]);
?>