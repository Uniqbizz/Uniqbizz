<?php

require '../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method"
    ]);
    exit;
}

$request = json_decode(file_get_contents("php://input"), true);

$userId = $request['userId'] ?? '';

if (empty($userId)) {
    echo json_encode([
        "status" => false,
        "message" => "userId required"
    ]);
    exit;
}

try {

    /* ---------------------------
       Get Initial Investment
    ---------------------------- */

    $initial_inv = 0;

    $sql = "SELECT amount 
            FROM sub_franchisee 
            WHERE sub_franchisee_id = :userId 
            AND status = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':userId' => $userId]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $initial_inv = $row['amount'];
    }


    /* ---------------------------
       Get Total Investment
    ---------------------------- */

    $tamount = $initial_inv;

    $sql = "SELECT upgrade_amt
            FROM sub_franchisee_upgrade
            WHERE sub_franchisee_id = :userId
            AND upgrade_status = 1
            ORDER BY upgrade_approval_date DESC
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':userId' => $userId]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tamount = $row['upgrade_amt'];
    }


    /* ---------------------------
       Get Upgrade History
    ---------------------------- */

    $sql = "SELECT 
                id,
                upgrade_request_date,
                new_investment_amt,
                new_commission_per,
                new_incentive_per,
                payment_mode,
                note,
                upgrade_approval_date,
                rejection_reason,
                upgrade_status
            FROM sub_franchisee_upgrade
            WHERE sub_franchisee_id = :userId
            ORDER BY upgrade_request_date ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':userId' => $userId]);

    $history = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $statusText = '';

        if ($row['upgrade_status'] == 0) {
            $statusText = 'Requested';
        } elseif ($row['upgrade_status'] == 1) {
            $statusText = 'Approved';
        } elseif ($row['upgrade_status'] == 2) {
            $statusText = 'Rejected';
        }

        $history[] = [
            "id" => $row['id'],
            "investment_date" => !empty($row['upgrade_request_date']) 
            ? date("d-m-Y", strtotime($row['upgrade_request_date'])) 
            : '-',
            "invested_amount" => (float)$row['new_investment_amt'],
            "commission_percent" => (float)$row['new_commission_per'],
            "incentive_percent" => (float)$row['new_incentive_per'],
            "payment_mode" => ucfirst($row['payment_mode']),
            "note" => $row['note'] ?? '-',
            "approved_date" => !empty($row['upgrade_approval_date']) 
            ? date("d-m-Y", strtotime($row['upgrade_approval_date'])) 
            : '-',
            "remark" => $row['rejection_reason'] ?: '-',
            "status" => $statusText
        ];
    }


    /* ---------------------------
       Final Response
    ---------------------------- */

    echo json_encode([
        "status" => true,
        "total_investment" => (float)$tamount,
        "upgrade_history" => $history
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}