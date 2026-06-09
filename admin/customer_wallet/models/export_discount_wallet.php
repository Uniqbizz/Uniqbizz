<?php

    require_once __DIR__ . '/../../../vendor/autoload.php';
    include(__DIR__ . '/../../connect.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $cust_id = $_GET['customer_id'] ?? '';

    if (empty($cust_id)) {
        die('Customer ID missing');
    }

    $conditions = [];
    $params = [];

    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date   = $_GET['end_date'] ?? date('Y-m-d');

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

    $sql = $conn->prepare("

        SELECT

            ru.id,
            ru.transaction_id,
            ru.created_date,
            ru.earned_amount,
            ru.used_amount,
            ru.balance,
            ru.earned_on,
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

        FROM customer_discount_wallet_utilization ru

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

    /*
    |--------------------------------------------------------------------------
    | Spreadsheet
    |--------------------------------------------------------------------------
    */

    $spreadsheet = new Spreadsheet();

    /*
    |--------------------------------------------------------------------------
    | Sheet 1 : Transactions
    |--------------------------------------------------------------------------
    */

    $transactionsSheet = $spreadsheet->getActiveSheet();
    $transactionsSheet->setTitle('Transactions');

    $headers = [
        'Date & Time',
        'Type',
        'Message',
        'Amount',
        'Balance',
        'Status',
        'Transaction ID',
        'Trip Name',
        'Destination',
        'Booked Customer ID',
        'Booked Customer Name'
    ];

    $col = 'A';

    foreach ($headers as $header) {

        $transactionsSheet->setCellValue($col . '1', $header);
        $transactionsSheet->getStyle($col . '1')->getFont()->setBold(true);

        $col++;
    }

    /*
    |--------------------------------------------------------------------------
    | Sheet 2 : Members
    |--------------------------------------------------------------------------
    */

    $membersSheet = $spreadsheet->createSheet();
    $membersSheet->setTitle('Members');

    $memberHeaders = [
        'Transaction ID',
        'Trip Name',
        'Member Name',
        'Age',
        'Gender'
    ];

    $col = 'A';

    foreach ($memberHeaders as $header) {

        $membersSheet->setCellValue($col . '1', $header);
        $membersSheet->getStyle($col . '1')->getFont()->setBold(true);

        $col++;
    }

    $transactionRow = 2;
    $memberRow = 2;

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    foreach ($rows as $row) {

        $isEarned =
            !empty($row['earned_amount'])
            && $row['earned_amount'] > 0;

        $amount = $isEarned
            ? $row['earned_amount']
            : $row['used_amount'];

        $message = $isEarned
            ? $row['earned_on']
            : $row['used_on'];

        $entryType = $isEarned
            ? 'Discount Earned'
            : 'Discount Used';

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

        /*
        |--------------------------------------------------------------------------
        | Transactions Sheet
        |--------------------------------------------------------------------------
        */

        $transactionsSheet->setCellValue(
            'A' . $transactionRow,
            date('d M Y h:i A', strtotime($row['created_date']))
        );

        $transactionsSheet->setCellValue(
            'B' . $transactionRow,
            $entryType
        );

        $transactionsSheet->setCellValue(
            'C' . $transactionRow,
            $message
        );

        $transactionsSheet->setCellValue(
            'D' . $transactionRow,
            $amount
        );

        $transactionsSheet->setCellValue(
            'E' . $transactionRow,
            $row['balance']
        );

        $transactionsSheet->setCellValue(
            'F' . $transactionRow,
            $status
        );

        $transactionsSheet->setCellValue(
            'G' . $transactionRow,
            $row['transaction_id']
        );

        $transactionsSheet->setCellValue(
            'H' . $transactionRow,
            $row['trip_name'] ?? '-'
        );

        $transactionsSheet->setCellValue(
            'I' . $transactionRow,
            $row['destination'] ?? '-'
        );

        $transactionsSheet->setCellValue(
            'J' . $transactionRow,
            $row['booked_customer_id'] ?? '-'
        );

        $transactionsSheet->setCellValue(
            'K' . $transactionRow,
            $row['booked_customer_name'] ?? '-'
        );

        $transactionRow++;

        /*
        |--------------------------------------------------------------------------
        | Members Sheet
        |--------------------------------------------------------------------------
        */

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

            foreach ($members as $member) {

                $membersSheet->setCellValue(
                    'A' . $memberRow,
                    $row['transaction_id']
                );

                $membersSheet->setCellValue(
                    'B' . $memberRow,
                    $row['trip_name'] ?? '-'
                );

                $membersSheet->setCellValue(
                    'C' . $memberRow,
                    $member['name']
                );

                $membersSheet->setCellValue(
                    'D' . $memberRow,
                    $member['age']
                );

                $membersSheet->setCellValue(
                    'E' . $memberRow,
                    $member['gender']
                );

                $memberRow++;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Size Columns
    |--------------------------------------------------------------------------
    */

    foreach (range('A', 'K') as $column) {

        $transactionsSheet
            ->getColumnDimension($column)
            ->setAutoSize(true);
    }

    foreach (range('A', 'E') as $column) {

        $membersSheet
            ->getColumnDimension($column)
            ->setAutoSize(true);
    }

    /*
    |--------------------------------------------------------------------------
    | Download
    |--------------------------------------------------------------------------
    */

    $fileName =
        'Discount_Wallet_' .
        $cust_id .
        '_' .
        date('Ymd_His') .
        '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>