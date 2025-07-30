<?php
require '../../connect.php';

$booking_id = $_POST['bookingId'];
$reason = $_POST['reason'];
$orderId = $_POST['orderId']; // correct spelling

$currentDate = new DateTime();
$updated_date = $currentDate->format('d/m/Y H:i');

// Get ta_id
$bookings_data = $conn->prepare("SELECT ta_id FROM bookings WHERE id = :id");
$bookings_data->execute([':id' => $booking_id]);
$user_cust_id = $bookings_data->fetch(PDO::FETCH_ASSOC);
$ta_id = $user_cust_id['ta_id'] ?? null;

// Update bookings table
$sql1 = 'UPDATE bookings
         SET cancel_date = :cancel_date, remark = :remark, status = :status
         WHERE id = :id';
$stmt1 = $conn->prepare($sql1);
$result1 = $stmt1->execute([
    ':id' => $booking_id,
    ':cancel_date' => $updated_date,
    ':remark' => $reason,
    ':status' => '2'
]);

if ($result1) {
    // Update direct bill table
    $sql2 = 'UPDATE booking_direct_bill 
             SET status = :status 
             WHERE bookings_id = :id';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':id' => $booking_id,
        ':status' => '2'
    ]);

    echo $result2 ? 1 : 0;
} else {
    echo 0;
}
