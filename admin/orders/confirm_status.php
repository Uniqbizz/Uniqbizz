<?php
require '../connect.php';
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
$order_id = $_POST['order_id'] ?? null;
$status = $_POST['status'] ?? null;
$date=date('Y-m-d H:i:s');
if ($order_id && in_array($status, ['confirm', 'cancel'])) {
    $confirm_status = $status === 'confirm' ? 1 : 0;

    $sql = "UPDATE bookings SET confirm_status = :status,confirm_date = :confirm_date WHERE order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':status' => $confirm_status,
        ':confirm_date' =>$date,
        ':order_id' => $order_id
    ]);

    if ($stmt->rowCount()) {

        // ✅ Step 1: Get single coupon_code from bookings
        $couponFetch = $conn->prepare("SELECT coupons_code FROM bookings WHERE order_id = :order_id");
        $couponFetch->execute([':order_id' => $order_id]);
        $couponRow = $couponFetch->fetch(PDO::FETCH_ASSOC);

        $couponCode = trim($couponRow['coupons_code'] ?? '');

        // ✅ Step 2: If confirming and coupon exists, mark as used
        if ($confirm_status === 1 && $couponCode !== '') {
            $updateSQL = "UPDATE cu_coupons 
                          SET usage_status = 1, used_date = :used_date 
                          WHERE code = :code";
            $updateStmt = $conn->prepare($updateSQL);
            $updateStmt->execute([
                ':used_date' => $date,
                ':code' => $couponCode
            ]);
        }

        echo json_encode([
            'success' => true,
            'message' => "Order ID $order_id status updated to $status."
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "No changes made or order not found."
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request: missing or incorrect status/order ID."
    ]);
}
?>
