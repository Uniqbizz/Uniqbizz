<?php
include(__DIR__ . '/../../connect.php');

$cust_id = $_POST['customer_id'];

$start_date = $_POST['start_date'] ?? date('Y-m-01');
$end_date   = $_POST['end_date'] ?? date('Y-m-d');

$conditions = [];
$params = [];

// =========================================
// DATE CONDITION - UTILIZATION
// =========================================

if (!empty($start_date) && !empty($end_date))
{
    $fromDateObj = new DateTime($start_date);
    $toDateObj   = new DateTime($end_date);

    if ($fromDateObj->format('Y-m-d') === $toDateObj->format('Y-m-d'))
    {
        $conditions[] = "
            ru.created_date >= :from_start_ru
            AND ru.created_date < :from_end_ru
        ";

        $params[':from_start_ru'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $nextDay = clone $fromDateObj;
        $nextDay->modify('+1 day');

        $params[':from_end_ru'] =
            $nextDay->format('Y-m-d') . ' 00:00:00';
    }
    else
    {
        $conditions[] = "
            ru.created_date BETWEEN :from_ru AND :to_ru
        ";

        $params[':from_ru'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $params[':to_ru'] =
            $toDateObj->format('Y-m-d') . ' 23:59:59';
    }
}

$dateCondition = !empty($conditions)
    ? ' AND ' . implode(' AND ', $conditions)
    : '';


// =========================================
// DATE CONDITION - WITHDRAWAL
// =========================================

$withdrawalConditions = [];

if (!empty($start_date) && !empty($end_date))
{
    $fromDateObj = new DateTime($start_date);
    $toDateObj   = new DateTime($end_date);

    if ($fromDateObj->format('Y-m-d') === $toDateObj->format('Y-m-d'))
    {
        $withdrawalConditions[] = "
            cre.created_date >= :from_start_cre
            AND cre.created_date < :from_end_cre
        ";

        $params[':from_start_cre'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $nextDay = clone $fromDateObj;
        $nextDay->modify('+1 day');

        $params[':from_end_cre'] =
            $nextDay->format('Y-m-d') . ' 00:00:00';
    }
    else
    {
        $withdrawalConditions[] = "
            cre.created_date BETWEEN :from_cre AND :to_cre
        ";

        $params[':from_cre'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $params[':to_cre'] =
            $toDateObj->format('Y-m-d') . ' 23:59:59';
    }
}

$dateConditionCre = !empty($withdrawalConditions)
    ? ' AND ' . implode(' AND ', $withdrawalConditions)
    : '';


// =========================================
// USER IDS
// =========================================

$params[':user_id_ru']  = $cust_id;
$params[':user_id_cre'] = $cust_id;

header('Content-Type: application/json');

try {

    // =========================================
    // MAIN QUERY
    // =========================================

    $sqlRefEntries = $conn->prepare("

        (
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
                    WHEN SUBSTRING(ru.transaction_id, 1, 2) = 'CU' THEN
                        'Membership Activation Bonus'

                    WHEN SUBSTRING(ru.transaction_id, 1, 2) = 'WD' THEN
                        'Withdrawal Request'

                    ELSE
                        'Trip Completed Bonus'
                END AS entry_type,

                CASE 

                    WHEN SUBSTRING(ru.transaction_id, 1, 2) = 'CU' THEN
                        (
                            SELECT crp.status
                            FROM customer_reference_payout crp
                            WHERE ru.transaction_id = crp.refered_customer_id
                            LIMIT 1
                        )

                    WHEN SUBSTRING(ru.transaction_id, 1, 2) = 'WD' THEN
                        (
                            SELECT cre2.status
                            FROM customer_reference_wallet_encashed cre2
                            WHERE ru.transaction_id = cre2.enchased_id
                            LIMIT 1
                        )

                    ELSE
                        (
                            SELECT pp.cu1_status
                            FROM product_payout pp
                            WHERE ru.transaction_id = pp.order_id
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

                b.id AS book_ref_id,

                CONCAT(
                    cu.firstname,
                    ' ',
                    cu.lastname
                ) AS cust_name,

                CASE

                    WHEN SUBSTRING(ru.transaction_id, 1, 2) = 'CU' THEN
                        (
                            SELECT crwu.earned_on
                            FROM customer_reference_wallet_utilization crwu
                            WHERE crwu.transaction_id = ru.transaction_id
                            ORDER BY crwu.created_date DESC
                            LIMIT 1
                        )

                    ELSE
                        NULL

                END AS referral_message


            FROM customer_reference_wallet_utilization ru


            LEFT JOIN ca_customer cu
                ON cu.ca_customer_id = ru.transaction_id
                AND SUBSTRING(ru.transaction_id, 1, 2) = 'CU'


            LEFT JOIN bookings b
                ON ru.transaction_id = b.order_id


            LEFT JOIN package pg
                ON b.package_id = pg.id


            WHERE ru.customer_id = :user_id_ru

            -- Do NOT show WD records from utilization
            AND SUBSTRING(ru.transaction_id, 1, 2) <> 'WD'

            $dateCondition
        )


        UNION ALL


        (
            SELECT

                cre.created_date,

                cre.message,

                cre.encashed_amount AS amount,

                cre.enchased_id,


                CASE

                    WHEN cre.status = 1 THEN
                        (
                            SELECT ru2.balance

                            FROM customer_reference_wallet_utilization ru2

                            WHERE ru2.transaction_id = cre.enchased_id

                            AND ru2.customer_id = cre.customer_id

                            ORDER BY ru2.created_date DESC

                            LIMIT 1
                        )

                    ELSE
                        NULL

                END AS balance,


                'Withdrawal Request' AS entry_type,


                cre.status AS status,


                NULL AS order_id,

                NULL AS booked_cust_id,

                NULL AS booked_cust_name,

                NULL AS trip_name,

                NULL AS trip_destination,

                NULL AS trip_start_date,

                NULL AS trip_end_date,

                NULL AS booking_date,

                NULL AS book_ref_id,

                NULL AS cust_name,

                NULL AS referral_message


            FROM customer_reference_wallet_encashed cre


            WHERE cre.customer_id = :user_id_cre

            $dateConditionCre
        )


        ORDER BY created_date DESC

    ");


    $sqlRefEntries->execute($params);

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

        $transactionPrefix = substr(
            $row['enchased_id'],
            0,
            2
        );


        // =========================================
        // WITHDRAWAL REQUEST
        // =========================================

        if ($transactionPrefix == 'WD') {

            switch ((int)$row['status']) {

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
        // =========================================

        elseif ($transactionPrefix == 'CU') {

            switch ((int)$row['status']) {

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
        // =========================================

        else {

            switch ((int)$row['status']) {

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

        if (!empty($row['book_ref_id'])) {

            $sqlMembers = $conn->prepare("

                SELECT 
                    name,
                    age,
                    gender

                FROM booking_member_details

                WHERE bookings_id = :booking_id

            ");

            $sqlMembers->execute([
                ':booking_id' => $row['book_ref_id']
            ]);

            $members = $sqlMembers->fetchAll(
                PDO::FETCH_ASSOC
            );
        }


        // =====================================
        // BALANCE
        // =====================================

        $balance = $row['balance'];

        /*
         * Pending / cancelled withdrawal
         * has NULL balance.
         *
         * Don't display 0.00 for NULL.
         */

        $formattedBalance = $balance !== null
            ? number_format((float)$balance, 2)
            : '-';


        // =====================================
        // RESPONSE ARRAY
        // =====================================

        $data[] = [

            'entry_type' =>
                $row['entry_type'],


            'created_date' =>
                date(
                    'd M Y h:i A',
                    strtotime($row['created_date'])
                ),


            'raw_date' =>
                date(
                    'Y-m-d',
                    strtotime($row['created_date'])
                ),


            'message' =>
                $row['message'],


            'amount' =>
                number_format(
                    (float)$row['amount'],
                    2
                ),


            'balance' =>
                $formattedBalance,


            'status' =>
                $statusText,


            'reference_id' =>
                $row['enchased_id'] ?? '-',


            'booked_cust_id' =>
                $row['booked_cust_id'] ?? '-',


            'booked_cust_name' =>
                $row['booked_cust_name'] ?? '-',


            'trip_name' =>
                $row['trip_name'] ?? '-',


            'trip_destination' =>
                $row['trip_destination'] ?? '-',


            'trip_start_date' =>
                !empty($row['trip_start_date'])
                ?
                date(
                    'd M Y',
                    strtotime($row['trip_start_date'])
                )
                :
                '-',


            'trip_end_date' =>
                !empty($row['trip_end_date'])
                ?
                date(
                    'd M Y',
                    strtotime($row['trip_end_date'])
                )
                :
                '-',


            'booking_date' =>
                !empty($row['booking_date'])
                ?
                date(
                    'd M Y',
                    strtotime($row['booking_date'])
                )
                :
                '-',


            'referral_message' =>
                $row['referral_message'] ?? '-',


            'members' =>
                $members
        ];
    }


    // =========================================
    // FINAL RESPONSE
    // =========================================

    echo json_encode([
        'status' => true,
        'data' => $data
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>