<?php
require '../../connect.php';

$booking_id = (int)($_POST['booking_id'] ?? 0);

if ($booking_id) {
    $sql = 'SELECT remark FROM bookings WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $booking_id]);

    $remark = $stmt->fetchColumn();

    echo json_encode([
        'status' => 'success',
        'message' => $remark ?: 'No reason available.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid booking ID.'
    ]);
}
?>