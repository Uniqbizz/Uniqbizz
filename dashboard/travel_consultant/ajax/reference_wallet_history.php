<?php

    include_once(__DIR__ . '/../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        // =========================================
        // MAIN QUERY
        // =========================================

        $sqlRefEntries = $conn->prepare("

            SELECT 
                ru.created_date,

                CASE 
                    WHEN ru.used_on IS NULL 
                        OR ru.used_on = ''
                    THEN ru.earned_on
                    ELSE ru.used_on
                END AS message,

                CASE 
                    WHEN ru.used_amount IS NULL
                    THEN ru.earned_amount
                    ELSE ru.used_amount
                END AS amount,

                ru.transaction_id AS enchased_id,
                ru.balance,

                CASE 
                
                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                        'Membership Activation Bonus'

                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                        'Withdrawal Request'

                    ELSE
                        'Trip Completed Bonus'

                END AS entry_type,

                CASE 
                
                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                        (
                            SELECT status 
                            FROM customer_reference_payout 
                            WHERE ru.transaction_id = refered_customer_id
                            LIMIT 1
                        )

                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                        (
                            SELECT status 
                            FROM customer_reference_wallet_encashed 
                            WHERE ru.transaction_id = transaction_id
                            LIMIT 1
                        )

                    ELSE
                        (
                            SELECT cu1_status 
                            FROM product_payout 
                            WHERE ru.transaction_id = order_id
                            LIMIT 1
                        )

                END AS status,

                b.order_id,
                b.customer_id AS booked_cust_id,
                b.name AS booked_cust_name,

                pg.name AS trip_name,
                pg.destination AS trip_destination,

                b.date AS trip_start_date,

                DATE_ADD(
                    b.date,
                    INTERVAL pg.tour_days DAY
                ) AS trip_end_date,

                b.created_date AS booking_date,
                b.id AS book_ref_id

            FROM customer_reference_wallet_utilization ru

            LEFT JOIN bookings b
                ON ru.transaction_id = b.order_id

            LEFT JOIN package pg
                ON b.package_id = pg.id

            WHERE ru.customer_id = :user_id

            ORDER BY ru.created_date DESC

        ");

        $sqlRefEntries->execute([
            ":user_id" => $userId
        ]);

        $rows = $sqlRefEntries->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        // =========================================
        // LOOP
        // =========================================

        foreach ($rows as $row) {

            // =====================================
            // STATUS TEXT
            // =====================================

            $statusText = 'Pending';

            $transactionPrefix =
                substr(
                    $row['enchased_id'],
                    0,
                    2
                );

            // =========================================
            // WITHDRAWAL REQUEST
            // PREFIX = WD
            // =========================================

            if ($transactionPrefix == 'WD') {

                switch ($row['status']) {

                    case 1:
                        $statusText = 'Paid';
                    break;

                    case 2:
                        $statusText = 'Pending';
                    break;

                    case 3:
                        $statusText = 'Cancelled';
                    break;

                    default:
                        $statusText = 'Pending';
                }
            }

            // =========================================
            // REFERENCE BONUS
            // PREFIX = CU
            // =========================================

            elseif ($transactionPrefix == 'CU') {

                switch ($row['status']) {

                    case 1:
                        $statusText = 'Paid';
                    break;

                    case 2:
                        $statusText = 'Pending';
                    break;

                    default:
                        $statusText = 'Pending';
                }
            }

            // =========================================
            // TRIP COMPLETED BONUS
            // ORDER ID / OTHER PREFIX
            // =========================================

            else {

                switch ($row['status']) {

                    case 0:
                        $statusText = 'Pending';
                    break;

                    case 1:
                        $statusText = 'Success';
                    break;

                    case 2:
                        $statusText = 'Cancelled';
                    break;

                    case 3:
                        $statusText = 'Refunded';
                    break;

                    default:
                        $statusText = 'Pending';
                }
            }

            // =====================================
            // MEMBERS
            // =====================================

            $members = [];

            if (
                !empty($row['book_ref_id'])
            ) {

                $sqlMembers = $conn->prepare("

                    SELECT 
                        name,
                        age,
                        gender

                    FROM booking_member_details

                    WHERE bookings_id = :booking_id

                ");

                $sqlMembers->execute([
                    ":booking_id" => $row['book_ref_id']
                ]);

                $members =
                    $sqlMembers->fetchAll(
                        PDO::FETCH_ASSOC
                    );
            }

            // =====================================
            // RESPONSE ARRAY
            // =====================================

            $data[] = [

                "entry_type" =>
                    $row['entry_type'],

                "created_date" =>
                    date(
                        'd M Y h:i A',
                        strtotime(
                            $row['created_date']
                        )
                    ),

                "raw_date" =>
                    date(
                        'Y-m-d',
                        strtotime(
                            $row['created_date']
                        )
                    ),

                "message" =>
                    $row['message'],

                "amount" =>
                    number_format(
                        (float)$row['amount'],
                        2
                    ),

                "balance" =>
                    number_format(
                        (float)$row['balance'],
                        2
                    ),

                "status" =>
                    $statusText,

                "reference_id" =>
                    $row['enchased_id'] ?? '-',

                "booked_cust_id" =>
                    $row['booked_cust_id'] ?? '-',

                "booked_cust_name" =>
                    $row['booked_cust_name'] ?? '-',

                "trip_name" =>
                    $row['trip_name'] ?? '-',

                "trip_destination" =>
                    $row['trip_destination'] ?? '-',

                "trip_start_date" =>
                    !empty($row['trip_start_date'])
                    ?
                    date(
                        'd M Y',
                        strtotime(
                            $row['trip_start_date']
                        )
                    )
                    :
                    '-',

                "trip_end_date" =>
                    !empty($row['trip_end_date'])
                    ?
                    date(
                        'd M Y',
                        strtotime(
                            $row['trip_end_date']
                        )
                    )
                    :
                    '-',

                "booking_date" =>
                    !empty($row['booking_date'])
                    ?
                    date(
                        'd M Y',
                        strtotime(
                            $row['booking_date']
                        )
                    )
                    :
                    '-',

                "members" =>
                    $members
            ];
        }

        // =========================================
        // FINAL RESPONSE
        // =========================================

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