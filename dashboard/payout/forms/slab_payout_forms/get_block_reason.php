<?php
require '../../../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT payment_message FROM bm_payout_history WHERE id = ? and payout_status=3");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $row ? $row['payment_message'] : 'No reason provided';
}
?>
