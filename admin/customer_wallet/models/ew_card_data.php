<?php
    include(__DIR__ . '/../../connect.php');

    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date   = $_GET['end_date'] ?? date('Y-m-d');

    $fromDateObj = new DateTime($start_date);
    $toDateObj   = new DateTime($end_date);

    /*
    |--------------------------------------------------------------------------
    | Date Range
    |--------------------------------------------------------------------------
    */
    if ($fromDateObj->format('Y-m-d') === $toDateObj->format('Y-m-d')) {

        $dateFrom = $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $nextDay = clone $fromDateObj;
        $nextDay->modify('+1 day');

        $dateTo = $nextDay->format('Y-m-d') . ' 00:00:00';

        $dateCondition = "
            created_date >= :date_from
            AND created_date < :date_to
        ";

    } else {

        $dateFrom = $fromDateObj->format('Y-m-d') . ' 00:00:00';
        $dateTo   = $toDateObj->format('Y-m-d') . ' 23:59:59';

        $dateCondition = "
            created_date BETWEEN :date_from AND :date_to
        ";
    }

    $params = [
        ':date_from' => $dateFrom,
        ':date_to'   => $dateTo
    ];

    /*
    |--------------------------------------------------------------------------
    | Discount Wallet Utilization
    |--------------------------------------------------------------------------
    */
    $sqlExtWalletCurBal = $conn->prepare("
        SELECT
            COALESCE(SUM(earn_amount),0) -
            COALESCE(SUM(used_amount),0) AS balance,

            COALESCE(
                SUM(
                    CASE
                        WHEN transaction_id LIKE 'CU%'
                        OR transaction_id LIKE 'WD%'
                        THEN earn_amount
                        ELSE 0
                    END
                ),
            0) AS ref_booking_total,

            COALESCE(SUM(used_amount),0) AS total_used_amount

        FROM customer_extended_wallet_utilization
        WHERE $dateCondition
    ");

    $sqlExtWalletCurBal->execute($params);
    $extWalletCurBalData = $sqlExtWalletCurBal->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Discount Wallet Statistics
    |--------------------------------------------------------------------------
    */
    $sqlExtWallet = $conn->prepare("
        SELECT
            COUNT(*) AS ref_count,

            COALESCE(SUM(earn_amount),0) AS ref_total_earning

        FROM customer_extended_wallet
        WHERE $dateCondition
    ");

    $sqlExtWallet->execute($params);
    $extWalletData = $sqlExtWallet->fetch(PDO::FETCH_ASSOC);
    /*
    |--------------------------------------------------------------------------
    | Total Customers
    |--------------------------------------------------------------------------
    */
    $sqlcustCount = $conn->prepare("
        SELECT
            COUNT(*) AS total_cust
        FROM ca_customer
        WHERE status=1
    ");

    $sqlcustCount->execute();
    $custCountData = $sqlcustCount->fetch(PDO::FETCH_ASSOC);
    /*
    |--------------------------------------------------------------------------
    | Safe Defaults
    |--------------------------------------------------------------------------
    */
    $extWalletCurBalData = $extWalletCurBalData ?: [
        'total_balance' => 0,
        'ref_booking_total' => 0
    ];

    $extWalletData = $extWalletData ?: [
        'ref_count' => 0,
        'ref_total_earning' => 0,
        'total_used_amount' =>0
    ];

    $custCountData=$custCountData?:[
        'total_cust' => 0
    ];

?>