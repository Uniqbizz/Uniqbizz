<?php
require '../connect.php'; // Ensure this sets up a PDO connection
header('Content-Type: application/json');

$order_id = $_POST['order_id'] ?? null;
$status = $_POST['status'] ?? null;

if ($order_id && in_array($status, ['confirm', 'cancel'])) {
    $confirm_status = $status === 'confirm' ? 1 : 0;

    $sql = "UPDATE bookings SET confirm_status = :status WHERE order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':status' => $confirm_status,
        ':order_id' => $order_id
    ]);

    if ($stmt->rowCount()) {
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
