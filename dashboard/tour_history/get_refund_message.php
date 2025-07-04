<?php
require '../../connect.php';

header('Content-Type: application/json');

$booking_id = (int) ($_POST['booking_id'] ?? 0);

$stmt = $conn->prepare("SELECT refund_remark FROM bookings WHERE id = :id");
$stmt->execute([':id' => $booking_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !empty($row['refund_remark'])) {
    echo json_encode([
        'status' => 'success',
        'message' => $row['refund_remark']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No remark found.'
    ]);
}
?>
