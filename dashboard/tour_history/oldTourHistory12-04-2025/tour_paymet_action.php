<?php
require '../../connect.php';
// get Row data
$data = stripslashes(file_get_contents("php://input"));
// json Decoding, true -> for getting data in associative manner
$mydata = json_decode($data, true);
// print_r($mydata);

$booking_id = $mydata['bookingId'];
$pay_id = $mydata['payID'];
$pay_amt = $mydata['payAmt'];
$pay_type = $mydata['payType'];
$part_pay_status = $mydata['partPayStatus'];
$part_pay_count = $mydata['partPayCount'];
$overall_status = $mydata['overallStatus'];

//getting ta_id
$bookings_data = $conn->prepare("SELECT ta_id FROM bookings WHERE id=:id");
$bookings_data->execute([
    ':id'=>$booking_id
]);
$user_cust_id = $bookings_data->fetch(PDO::FETCH_ASSOC); 
$ta_id = $user_cust_id['ta_id'] ?? null;

// for 2nd part of 3-part payment
if ($pay_type == 3 && $part_pay_count == 2) {
    $sql2 = 'UPDATE booking_direct_bill 
                SET part_pay_2_status = :part_pay_2_status 
                WHERE bookings_id = :bookings_id';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':bookings_id' => $booking_id,
        ':part_pay_2_status' => $part_pay_status
    ]);
} 
// for 3rd part of 3-part payment
else if ($pay_type == 3 && $part_pay_count == 3) {
    $sql2 = 'UPDATE booking_direct_bill 
                SET part_pay_3_status = :part_pay_3_status, status = :status 
                WHERE bookings_id = :bookings_id';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':bookings_id' => $booking_id,
        ':part_pay_3_status' => $part_pay_status,
        ':status' => $overall_status
    ]);
}
// if 2-part payment type
else if ($pay_type == 2 && $part_pay_count == 2) {
    $sql2 = 'UPDATE booking_direct_bill 
                SET part_pay_2_status = :part_pay_2_status, status = :status 
                WHERE bookings_id = :bookings_id';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':bookings_id' => $booking_id,
        ':part_pay_2_status' => $part_pay_status,
        ':status' => $overall_status
    ]);
}


//updating wallet balance after insert in booking_direct_bill


if ($result2) {
    // Insert the new credited amount into ta_top_up_utilisation
    $stmt = $conn->prepare("INSERT INTO ta_top_up_utilisation (ta_id, ta_top_up_amt_id, amount_deposited,top_up_message) VALUES (:ta_id, :ta_top_up_amt_id, :amount_deposited,:top_up_message)");
    $result3 = $stmt->execute(array(
        ':ta_id' => $ta_id,
        ':ta_top_up_amt_id' => $pay_id,
        ':amount_deposited' => $pay_amt,
        ':top_up_message' => 'TopUp used for booking id:' . $booking_id . ''
    ));
    // Fetch the latest available balance for the given ta_id
    $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1 OFFSET 1");
    $stmt2->execute(array(':ta_id' => $ta_id));
    $result4 = $stmt2->fetch(PDO::FETCH_ASSOC);
    // If no second last entry exists, fetch the latest entry
    if (!$result4) {
        $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
        $stmt2->execute(array(':ta_id' => $user_cust_id));
        $result4 = $stmt2->fetch(PDO::FETCH_ASSOC);
    }

    if ($result4) {
        // Calculate the new available balance
        $available_bal = (double)$result4['available_balance'] - (double)$pay_amt;


        // // Update the available balance in ta_top_up_utilisation
        $stmt3 = $conn->prepare("UPDATE ta_top_up_utilisation SET available_balance = :available_balance WHERE ta_id = :ta_id AND ta_top_up_amt_id = :ta_top_up_amt_id");
        $result5 = $stmt3->execute(array(
            ':ta_id' => $ta_id,
            ':ta_top_up_amt_id' => $pay_id,
            ':available_balance' => (double)$available_bal
        ));

        if ($result5) {
            echo '1';
        }else{
            echo '0';
        }
    }else{
        echo '0';
    }
}else{
    echo '0';
}
