<?php

    include(__DIR__ . '/../../connect.php');
    require_once __DIR__ . '/../../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $cust_id = $_GET['customer_id'] ?? '';
    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date   = $_GET['end_date'] ?? date('Y-m-d');

    if (empty($cust_id)) {
        exit('Customer ID Missing');
    }

    $sql = $conn->prepare("

        SELECT

            ru.id,
            ru.transaction_id,
            ru.created_date,
            ru.earn_amount,
            ru.used_amount,
            ru.balance,
            ru.earned_on,
            ru.used_on,

            CASE
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU'
                    THEN 'Secondary Referral'

                WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD'
                    THEN 'Package Conversion'

                ELSE 'Benefit Applied'
            END AS transaction_type,

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

        WHERE ru.customer_id = :customer_id

        AND ru.created_date BETWEEN :from_date AND :to_date

        ORDER BY ru.created_date DESC

    ");

    $sql->execute([
        ':customer_id' => $cust_id,
        ':from_date'   => $start_date . ' 00:00:00',
        ':to_date'     => $end_date . ' 23:59:59'
    ]);

    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();

    /* ========================================
    SHEET 1 - WALLET TRANSACTIONS
    ======================================== */

    $sheet1 = $spreadsheet->getActiveSheet();
    $sheet1->setTitle('Wallet Transactions');

    $headers = [
        'Date & Time',
        'Source Type',
        'Description',
        'Credit',
        'Debit',
        'Balance',
        'Transaction ID',
        'Status',
        'Booking ID',
        'Customer ID',
        'Customer Name',
        'Trip Name',
        'Destination'
    ];

    $col = 'A';

    foreach ($headers as $header) {
        $sheet1->setCellValue($col . '1', $header);
        $sheet1->getStyle($col . '1')->getFont()->setBold(true);
        $col++;
    }

    $rowNo = 2;

    /* ========================================
    PASSENGER DATA STORAGE
    ======================================== */

    $passengerRows = [];

    foreach ($rows as $row) {

        $isCredit = in_array(
            $row['transaction_type'],
            [
                'Package Conversion',
                'Secondary Referral'
            ]
        );

        $amount = !empty($row['earn_amount'])
            ? $row['earn_amount']
            : $row['used_amount'];

        $description = !empty($row['earned_on'])
            ? $row['earned_on']
            : $row['used_on'];

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

        $sheet1->setCellValue('A' . $rowNo,
            date('d M Y h:i A', strtotime($row['created_date']))
        );

        $sheet1->setCellValue('B' . $rowNo,
            $row['transaction_type']
        );

        $sheet1->setCellValue('C' . $rowNo,
            $description
        );

        $sheet1->setCellValue('D' . $rowNo,
            $isCredit ? $amount : ''
        );

        $sheet1->setCellValue('E' . $rowNo,
            !$isCredit ? $amount : ''
        );

        $sheet1->setCellValue('F' . $rowNo,
            $row['balance']
        );

        $sheet1->setCellValue('G' . $rowNo,
            $row['transaction_id']
        );

        $sheet1->setCellValue('H' . $rowNo,
            $status
        );

        $sheet1->setCellValue('I' . $rowNo,
            $row['booking_id']
        );

        $sheet1->setCellValue('J' . $rowNo,
            $row['booked_customer_id']
        );

        $sheet1->setCellValue('K' . $rowNo,
            $row['booked_customer_name']
        );

        $sheet1->setCellValue('L' . $rowNo,
            $row['trip_name']
        );

        $sheet1->setCellValue('M' . $rowNo,
            $row['destination']
        );

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

            foreach ($memberSql->fetchAll(PDO::FETCH_ASSOC) as $member) {

                $passengerRows[] = [
                    $row['transaction_id'],
                    $row['booking_id'],
                    $member['name'],
                    $member['age'],
                    $member['gender']
                ];
            }
        }

        $rowNo++;
    }

    /* ========================================
    AUTO SIZE SHEET 1
    ======================================== */

    foreach (range('A', 'M') as $column) {
        $sheet1->getColumnDimension($column)
            ->setAutoSize(true);
    }

    /* ========================================
    SHEET 2 - PASSENGERS
    ======================================== */

    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('Passenger Details');

    $sheet2->fromArray([
        [
            'Transaction ID',
            'Booking ID',
            'Passenger Name',
            'Age',
            'Gender'
        ]
    ], null, 'A1');

    $sheet2->getStyle('A1:E1')
        ->getFont()
        ->setBold(true);

    $rowNum = 2;

    foreach ($passengerRows as $passenger) {

        $sheet2->fromArray(
            [$passenger],
            null,
            'A' . $rowNum
        );

        $rowNum++;
    }

    foreach (range('A', 'E') as $column) {
        $sheet2->getColumnDimension($column)
            ->setAutoSize(true);
    }

    /* ========================================
    DOWNLOAD
    ======================================== */

    $fileName =
        'Extended_Wallet_Statement_' .
        date('Ymd_His') .
        '.xlsx';

    header(
        'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    header(
        'Content-Disposition: attachment; filename="' .
        $fileName .
        '"'
    );

    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>