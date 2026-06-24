<?php
require '../../connect.php';

$booking_id = $_POST['order_id'];
$reason = $_POST['reason'];
$amount = $_POST['amount']; // correct spelling
echo 1;

$currentDate = new DateTime();
$updated_date = $currentDate->format('d/m/Y H:i');

// Update bookings table
$sql1 = 'UPDATE bookings
         SET refund_date = :refund_date, refund_remark = :refund_remark, refund_amt=:refund_amt, status = :status
         WHERE id = :id';
$stmt1 = $conn->prepare($sql1);
$result1 = $stmt1->execute([
    ':id' => $booking_id,
    ':refund_date' => $updated_date,
    ':refund_amt'=>$amount,
    ':refund_remark' => $reason,
    ':status' => '3'
]);

if ($result1) {
    // Update direct bill table
    $sql2 = 'UPDATE booking_direct_bill 
             SET status = :status 
             WHERE bookings_id = :id';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':id' => $booking_id,
        ':status' => '3'
    ]);

    echo $result2 ? 1 : 0;
} else {
    echo 0;
}
