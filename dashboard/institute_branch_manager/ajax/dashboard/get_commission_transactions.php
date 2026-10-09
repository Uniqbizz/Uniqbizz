<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json; charset=utf-8');

try {

    $transactions = [];

    /*
    |--------------------------------------------------------------------------
    | 1. Holiday Account Activation Commission
    |--------------------------------------------------------------------------
    */

    $sqlCustomerCommission = $conn->prepare("
        SELECT
            commision_tc AS commission_amount,
            created_date AS commission_date
        FROM ca_cu_payout
        WHERE travel_consultant = :user_id
    ");

    $sqlCustomerCommission->execute([
        'user_id' => $userId
    ]);

    foreach ($sqlCustomerCommission->fetchAll(PDO::FETCH_ASSOC) as $row) {

        $transactions[] = [
            'customer_name' => 'Holiday Account Customer',
            'date'          => $row['commission_date'],
            'membership'    => 'Neo Select',
            'commission'    => (float) $row['commission_amount'],
            'type'           => 'activation'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Holiday Trip Completion Commission
    |--------------------------------------------------------------------------
    */

    $sqlTripCommission = $conn->prepare("
        SELECT
            ta_amt AS commission_amount,
            created_date AS commission_date
        FROM product_payout
        WHERE ta_id = :user_id
    ");

    $sqlTripCommission->execute([
        'user_id' => $userId
    ]);

    foreach ($sqlTripCommission->fetchAll(PDO::FETCH_ASSOC) as $row) {

        $transactions[] = [
            'customer_name' => 'Holiday Trip Customer',
            'date'          => $row['commission_date'],
            'membership'    => 'Holiday Trip',
            'commission'    => (float) $row['commission_amount'],
            'type'           => 'trip'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Sort Newest First
    |--------------------------------------------------------------------------
    */

    usort($transactions, function ($a, $b) {
        return strtotime($b['date']) <=> strtotime($a['date']);
    });

    /*
    |--------------------------------------------------------------------------
    | 4. Latest Six Transactions
    |--------------------------------------------------------------------------
    */

    $latestTransactions = array_slice($transactions, 0, 6);

    /*
    |--------------------------------------------------------------------------
    | 5. Total Commission Earned From Both Sources
    |--------------------------------------------------------------------------
    */

    $sqlTotal = $conn->prepare("
        SELECT
            (
                SELECT COALESCE(SUM(commision_tc), 0)
                FROM ca_cu_payout
                WHERE travel_consultant = :user_id_1
            )
            +
            (
                SELECT COALESCE(SUM(ta_amt), 0)
                FROM product_payout
                WHERE ta_id = :user_id_2
            ) AS total_commission
    ");

    $sqlTotal->execute([
        'user_id_1' => $userId,
        'user_id_2' => $userId
    ]);

    $totalCommission = (float) $sqlTotal->fetchColumn();

    /*
    |--------------------------------------------------------------------------
    | 6. JSON Response
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'status'           => true,
        'data'             => $latestTransactions,
        'total_commission' => $totalCommission
    ]);

} catch (Throwable $e) {

    error_log('Commission transactions error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status'           => false,
        'message'          => 'Unable to load commission transactions.',
        'data'             => [],
        'total_commission' => 0
    ]);
}