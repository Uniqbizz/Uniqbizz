<?php

    include(__DIR__ . '/../../connect.php');

    header('Content-Type: application/json');

    $conditions = [];
    $params = [];

    $cust_id = $_POST['customer_id'] ?? '';

    $start_date = $_POST['start_date'] ?? date('Y-m-01');
    $end_date   = $_POST['end_date'] ?? date('Y-m-d');

    if (empty($cust_id)) {
        echo json_encode([
            "status" => false,
            "message" => "Customer ID missing"
        ]);
        exit;
    }

    if (!empty($start_date) && !empty($end_date)) {

        $conditions[] = "ru.created_date BETWEEN :from_date AND :to_date";

        $params[':from_date'] = $start_date . ' 00:00:00';
        $params[':to_date']   = $end_date . ' 23:59:59';
    }

    $params[':user_id'] = $cust_id;

    $dateCondition = '';

    if (!empty($conditions)) {
        $dateCondition = ' AND ' . implode(' AND ', $conditions);
    }

    try {

        $sql = $conn->prepare("

            SELECT

                ru.id,
                ru.transaction_id,
                ru.created_date,
                ru.earn_amount,
                ru.used_amount,
                ru.balance,
                ru.earned_on,
                CASE
                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU'
                        THEN 'Secondary Referral'

                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD'
                        THEN 'Package Conversion'

                    ELSE 'Benefit Applied'
                END AS transaction_type,
                ru.used_on,

                b.id AS booking_id,
                b.order_id,
                b.customer_id AS booked_customer_id,
                b.name AS booked_customer_name,
                b.date AS travel_date,

                pg.name AS trip_name,
                pg.destination,

                (
                    SELECT cu1_status
                    FROM product_payout pp
                    WHERE pp.order_id = ru.transaction_id
                    LIMIT 1
                ) AS payout_status

            FROM customer_extended_wallet_utilization ru

            LEFT JOIN bookings b
                ON b.order_id = ru.transaction_id

            LEFT JOIN package pg
                ON pg.id = b.package_id

            WHERE ru.customer_id = :user_id
            $dateCondition

            ORDER BY ru.created_date DESC

        ");

        $sql->execute($params);

        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $row) {

            $isEarned = !empty($row['earn_amount']) && $row['earn_amount'] > 0;

            $amount = $isEarned
                ? $row['earn_amount']
                : $row['used_amount'];

            $message = $isEarned
                ? $row['earned_on']
                : $row['used_on'];

            $entryType = $row['transaction_type'];

            switch ((int)$row['payout_status']) {

                case 1:
                    $status = 'Credited';
                    break;

                case 2:
                    $status = 'Cancelled';
                    break;

                case 3:
                    $status = 'Refunded';
                    break;

                default:
                    $status = 'Pending';
            }

            $members = [];

            if (!empty($row['booking_id'])) {

                $memberSql = $conn->prepare("
                    SELECT
                        name,
                        age,
                        gender
                    FROM booking_member_details
                    WHERE bookings_id = ?
                ");

                $memberSql->execute([
                    $row['booking_id']
                ]);

                $members = $memberSql->fetchAll(PDO::FETCH_ASSOC);
            }

            $data[] = [

                // Main Row
                'created_date' => date(
                    'd M Y h:i A',
                    strtotime($row['created_date'])
                ),

                'entry_type' => $entryType,

                'message' => $message,

                'amount' => (float)$amount,

                'balance' => (float)$row['balance'],

                'status' => $status,

                'trip_name' => $row['trip_name'] ?? '-',

                'trip_destination' => $row['destination'] ?? '-',

                'transaction_id' => $row['transaction_id'],

                // Child Row
                'child' => [

                    'description' => $entryType,

                    'booking_id' => $row['transaction_id'],

                    'created_on' => date(
                        'd M Y h:i A',
                        strtotime($row['created_date'])
                    ),

                    'wallet_balance' => (float)$row['balance'],

                    'transaction_amount' => (float)$amount,

                    'status' => $status,

                    'booked_customer_id' =>
                        $row['booked_customer_id'] ?? '-',

                    'booked_customer_name' =>
                        $row['booked_customer_name'] ?? '-',

                    'trip_name' =>
                        $row['trip_name'] ?? '-',

                    'destination' =>
                        $row['destination'] ?? '-',

                    'members' => $members
                ]
            ];
        }

        echo json_encode([
            "status" => true,
            "data" => $data
        ]);

    } catch (PDOException $e) {

        echo json_encode([
            "status" => false,
            "message" => $e->getMessage()
        ]);
    }
?>