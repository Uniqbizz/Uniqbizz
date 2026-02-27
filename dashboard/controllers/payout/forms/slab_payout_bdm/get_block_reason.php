<?php
require '../../../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userType = $_GET['userType'];

    if ($userType == 25) {
        $stmt = $conn->prepare("SELECT payment_message FROM bdm_payout_history WHERE id = ? and payout_status=3");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo $row ? $row['payment_message'] : 'No reason provided';
    } else if ($userType == 24) {
        $stmt = $conn->prepare("SELECT payment_message FROM bcm_payout_history WHERE id = ? and payout_status=3");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo $row ? $row['payment_message'] : 'No reason provided';
    }
}
