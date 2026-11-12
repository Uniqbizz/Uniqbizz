<?php

header('Content-Type: application/json');
require '../../../../../connect.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $userId = $data['userId'] ?? '';

    if (empty($userId)) {
        throw new Exception("userId is required");
    }

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
        ':user_id' => $userId
    ]);

    $coupons = $sqlAllCoupons->fetchAll(PDO::FETCH_ASSOC);

    $responseData = [];

    foreach ($coupons as $row) {

        $responseData[] = [
            'code'         => $row['code'],
            'coupon_amt'   => $row['coupon_amt'],
            'status'       => ($row['usage_status'] == 1 ? 'Used' : 'Available'),
            'created_date' => !empty($row['created_date'])
                                ? date('d M Y h:i A', strtotime($row['created_date']))
                                : '-',
            'used_date'    => !empty($row['used_date'])
                                ? date('d M Y h:i A', strtotime($row['used_date']))
                                : '-',
            'used_on'      => !empty($row['used_on']) ? $row['used_on'] : '-',
            'booking_id'   => $row['transaction_id'] ?? null
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $responseData
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}
?>