<?php
// Pending payment model: update payout status and amounts

require '../../../connect.php';

$columnDesignation = ['bm_id', 'ste_id', 'bm_user_id', 'business_mentor'];
$columnMessage     = ['message', 'ste_message', 'message_bm', 'message'];
$columnCommision   = ['comm_amt', 'ste_amount', 'payout_amount', 'comm_amt'];
$columnStatus      = ['status', 'ste_status', 'payout_status', 'status'];

$tablename      = ['goa_bm_payout', 'techno_enterprise_payout', 'bm_payout_history', 'ca_payout'];
$tablename_paid = ['goa_bm_payout', 'techno_enterprise_payout_paid', 'bm_payout_history', 'ca_payout'];

// POST values
$id             = $_POST['id'] ?? '';
$commi          = $_POST['amt'] ?? 0;
$paymentMessage = $_POST['paymentMessage'] ?? '';
$status         = $_POST['status'] ?? '';
$col_update     = $_POST['col_update'] ?? '';

// Status after payment
$col_status = 1;

// Validate input
if (
    $id === '' ||
    !is_numeric($commi) ||
    !in_array((string)$col_update, ['0', '1', '2', '3'], true)
) {
    echo "0";
    exit;
}

// TDS calculation
$commi = (float)$commi;
$tdsAmount = $commi * 2 / 100;
$total = $commi - $tdsAmount;

$tableIndex = (int)$col_update;

// Select the destination table for paid payouts
$tableName = $tablename_paid[$tableIndex];

// Select the corresponding status and message columns
$statusColumn  = $columnStatus[$tableIndex];
$messageColumn = $columnMessage[$tableIndex];

// Validate configured identifiers
if (
    !in_array($tableName, $tablename_paid, true) ||
    !in_array($statusColumn, $columnStatus, true) ||
    !in_array($messageColumn, $columnMessage, true)
) {
    echo "0";
    exit;
}

try {
    $sql = "
        UPDATE `$tableName`
        SET
            `$statusColumn` = :status,
            Message_details = :Message_details,
            comm_amtTDS = :comm_amtTDS,
            comm_amtTotal = :comm_amtTotal
        WHERE id = :id
    ";

    $stmt = $conn->prepare($sql);

    $result = $stmt->execute([
        ':Message_details' => $paymentMessage,
        ':comm_amtTDS'     => $tdsAmount,
        ':comm_amtTotal'   => $total,
        ':status'          => $col_status,
        ':id'              => $id
    ]);

    echo ($result && $stmt->rowCount() >= 0) ? "1" : "0";

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "0";
}
?>