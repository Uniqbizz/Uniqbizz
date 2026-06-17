<?php

include(__DIR__ . '/../../connect.php');
require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$customerId = $_POST['customer_id'];

$startDate = $_POST['start_date'] ?? date('Y-m-01');
$endDate   = $_POST['end_date'] ?? date('Y-m-d');

$conditions = [];
$params = [];

if (!empty($startDate) && !empty($endDate))
{
    $fromDateObj = new DateTime($startDate);
    $toDateObj   = new DateTime($endDate);

    if ($fromDateObj->format('Y-m-d') === $toDateObj->format('Y-m-d'))
    {
        $conditions[] = "
            ru.created_date >= :from_start
            AND ru.created_date < :from_end
        ";

        $params[':from_start'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $nextDay = clone $fromDateObj;
        $nextDay->modify('+1 day');

        $params[':from_end'] =
            $nextDay->format('Y-m-d') . ' 00:00:00';
    }
    else
    {
        $conditions[] = "
            ru.created_date BETWEEN :from AND :to
        ";

        $params[':from'] =
            $fromDateObj->format('Y-m-d') . ' 00:00:00';

        $params[':to'] =
            $toDateObj->format('Y-m-d') . ' 23:59:59';
    }
}

$dateCondition = !empty($conditions)
    ? ' AND ' . implode(' AND ', $conditions)
    : '';

$params[':user_id'] = $customerId;

$sql = $conn->prepare("

    SELECT
        MAX(ru.created_date) AS created_date,

        MAX(
            CASE
                WHEN ru.used_on IS NULL
                    OR ru.used_on = ''
                THEN ru.earned_on
                ELSE ru.used_on
            END
        ) AS message,

        MAX(
            CASE
                WHEN ru.used_amount IS NULL
                THEN ru.earned_amount
                ELSE ru.used_amount
            END
        ) AS amount,

        ru.transaction_id,

        MAX(ru.balance) AS balance,

        MAX(
            CASE
                WHEN SUBSTRING(ru.transaction_id,1,2)='CU'
                THEN 'Membership Activation Bonus'

                WHEN SUBSTRING(ru.transaction_id,1,2)='WD'
                THEN 'Withdrawal Request'

                ELSE 'Trip Completed Bonus'
            END
        ) AS entry_type,

        MAX(b.id) AS booking_id,

        MAX(
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
            END
        ) AS status,

        MAX(
            CASE
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                (
                    SELECT earned_on
                    FROM customer_reference_wallet_utilization crwu
                    WHERE crwu.transaction_id = ru.transaction_id
                    LIMIT 1
                )

                WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                (
                    SELECT used_on
                    FROM customer_reference_wallet_utilization crwu
                    WHERE crwu.transaction_id = ru.transaction_id
                    LIMIT 1
                )

                ELSE NULL
            END
        ) AS referral_message,

        MAX(b.created_date) AS booking_date,
        MAX(pg.name) AS trip_name,
        MAX(pg.destination) AS trip_destination,
        MAX(b.date) AS trip_start_date

    FROM customer_reference_wallet_utilization ru

    LEFT JOIN bookings b
        ON ru.transaction_id = b.order_id

    LEFT JOIN package pg
        ON b.package_id = pg.id

    WHERE ru.customer_id = :user_id
    $dateCondition

    GROUP BY ru.transaction_id

    ORDER BY MAX(ru.created_date) DESC

");

$sql->execute($params);

$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Summary Totals
|--------------------------------------------------------------------------
*/

$totalCredit = 0;
$totalDebit = 0;
$currentBalance = 0;

foreach ($rows as $row)
{
    $currentBalance = $row['balance'];

    if ($row['entry_type'] == 'Withdrawal Request')
    {
        $totalDebit += (float)$row['amount'];
    }
    else
    {
        $totalCredit += (float)$row['amount'];
    }
}

/*
|--------------------------------------------------------------------------
| Spreadsheet
|--------------------------------------------------------------------------
*/

$spreadsheet = new Spreadsheet();

/*
|--------------------------------------------------------------------------
| Sheet 1 - Summary
|--------------------------------------------------------------------------
*/

$summarySheet = $spreadsheet->getActiveSheet();

$summarySheet->setTitle('Summary');

$summarySheet->setCellValue('A1', 'Referral Wallet Summary');

$summarySheet->setCellValue('A3', 'From');
$summarySheet->setCellValue('B3', $startDate);

$summarySheet->setCellValue('A4', 'To');
$summarySheet->setCellValue('B4', $endDate);

$summarySheet->setCellValue('A6', 'Metric');
$summarySheet->setCellValue('B6', 'Value');

$summarySheet->setCellValue('A7', 'Total Transactions');
$summarySheet->setCellValue('B7', count($rows));

$summarySheet->setCellValue('A8', 'Total Credit');
$summarySheet->setCellValue('B8', $totalCredit);

$summarySheet->setCellValue('A9', 'Total Debit');
$summarySheet->setCellValue('B9', $totalDebit);

$summarySheet->setCellValue('A10', 'Current Balance');
$summarySheet->setCellValue('B10', $currentBalance);

$summarySheet->getStyle('A1:B10')
    ->getFont()
    ->setBold(true);

/*
|--------------------------------------------------------------------------
| Sheet 2 - Transactions
|--------------------------------------------------------------------------
*/

$transactionSheet = $spreadsheet->createSheet();

$transactionSheet->setTitle('Transactions');

$transactionSheet->fromArray([
    [
        'Date',
        'Type',
        'Message',
        'Credit',
        'Debit',
        'Balance',
        'Reference ID',
        'Status'
    ]
], NULL, 'A1');

$rowNum = 2;

/*
|--------------------------------------------------------------------------
| Sheet 3 - Passenger Details
|--------------------------------------------------------------------------
*/

$passengerSheet = $spreadsheet->createSheet();

$passengerSheet->setTitle('Passenger Details');

$passengerSheet->fromArray([
    [
        'Reference ID',
        'Passenger Name',
        'Age',
        'Gender'
    ]
], NULL, 'A1');

$passengerRow = 2;
/*
|--------------------------------------------------------------------------
| Sheet 4 - Trip Details
|--------------------------------------------------------------------------
*/

$tripSheet = $spreadsheet->createSheet();

$tripSheet->setTitle('Trip Details');

$tripSheet->fromArray([
    [
        'Booking ID',
        'Tour Name',
        'Destination',
        'Travel Date',
        'Booking Date'
    ]
], NULL, 'A1');

$tripRow = 2;

/*
|--------------------------------------------------------------------------
| Sheet 5 - Membership Bonus
|--------------------------------------------------------------------------
*/

$membershipSheet = $spreadsheet->createSheet();

$membershipSheet->setTitle('Membership Bonus');

$membershipSheet->fromArray([
    [
        'Reference ID',
        'Reference Message',
        'Bonus Amount'
    ]
], NULL, 'A1');

$membershipRow = 2;

/*
|--------------------------------------------------------------------------
| Sheet 6 - Withdrawal Details
|--------------------------------------------------------------------------
*/

$withdrawSheet = $spreadsheet->createSheet();

$withdrawSheet->setTitle('Withdrawals');

$withdrawSheet->fromArray([
    [
        'Transaction ID',
        'Transaction Details',
        'Amount',
        'Status'
    ]
], NULL, 'A1');

$withdrawRow = 2;

foreach ($rows as $row)
{
    $credit = '';
    $debit = '';

    if ($row['entry_type'] == 'Withdrawal Request')
    {
        $debit = $row['amount'];
    }
    else
    {
        $credit = $row['amount'];
    }

    $transactionSheet->fromArray([
        [
            $row['created_date'],
            $row['entry_type'],
            $row['message'],
            $credit,
            $debit,
            $row['balance'],
            $row['transaction_id'],
            $row['status']
        ]
    ], NULL, 'A' . $rowNum);

    $rowNum++;

    if (!empty($row['booking_id']))
    {
        $memberQry = $conn->prepare("
            SELECT
                name,
                age,
                gender
            FROM booking_member_details
            WHERE bookings_id = :booking_id
        ");

        $memberQry->execute([
            ':booking_id' => $row['booking_id']
        ]);

        $members = $memberQry->fetchAll(PDO::FETCH_ASSOC);

        foreach ($members as $member)
        {
            $passengerSheet->fromArray([
                [
                    $row['transaction_id'],
                    $member['name'],
                    $member['age'],
                    $member['gender']
                ]
            ], NULL, 'A' . $passengerRow);

            $passengerRow++;
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Trip Child Details
    |--------------------------------------------------------------------------
    */

    if ($row['entry_type'] == 'Trip Completed Bonus')
    {
        $tripSheet->fromArray([
            [
                $row['transaction_id'],
                $row['trip_name'],
                $row['trip_destination'],
                $row['trip_start_date'],
                $row['booking_date']
            ]
        ], NULL, 'A' . $tripRow);

        $tripRow++;
    }

    /*
    |--------------------------------------------------------------------------
    | Membership Child Details
    |--------------------------------------------------------------------------
    */

    if ($row['entry_type'] == 'Membership Activation Bonus')
    {
        $membershipSheet->fromArray([
            [
                $row['transaction_id'],
                $row['referral_message'],
                $row['amount']
            ]
        ], NULL, 'A' . $membershipRow);

        $membershipRow++;
    }

    /*
    |--------------------------------------------------------------------------
    | Withdrawal Child Details
    |--------------------------------------------------------------------------
    */

    if ($row['entry_type'] == 'Withdrawal Request')
    {
        $withdrawSheet->fromArray([
            [
                $row['transaction_id'],
                $row['referral_message'],
                $row['amount'],
                $row['status']
            ]
        ], NULL, 'A' . $withdrawRow);

        $withdrawRow++;
    }
}


/*
|--------------------------------------------------------------------------
| Auto Size
|--------------------------------------------------------------------------
*/

foreach ($spreadsheet->getWorksheetIterator() as $worksheet)
{
    foreach (range('A', $worksheet->getHighestColumn()) as $col)
    {
        $worksheet
            ->getColumnDimension($col)
            ->setAutoSize(true);
    }
}

/*
|--------------------------------------------------------------------------
| Download
|--------------------------------------------------------------------------
*/

$fileName =
    'Referral_Wallet_Summary_' .
    date('Ymd_His') .
    '.xlsx';

header(
    'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
);

header(
    'Content-Disposition: attachment;filename="' .
    $fileName .
    '"'
);

header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

$writer->save('php://output');

exit;