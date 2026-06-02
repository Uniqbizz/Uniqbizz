<?php

    include(__DIR__ . '/../../connect.php');

    require_once __DIR__ . '/../../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $customer_id = $_POST['customer_id'] ?? '';
    $status      = $_POST['status'] ?? 'all';
    $start_date  = $_POST['start_date'] ?? '';
    $end_date    = $_POST['end_date'] ?? '';

    $where = [
        "lc.confirm_status = 1",
        "lc.user_id = :user_id"
    ];

    $params = [
        ':user_id' => $customer_id
    ];

    /* Status Filter */
    switch(strtolower($status))
    {
        case 'available':

            $where[] = "
                lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND NOT EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
            ";

        break;

        case 'used':

            $where[] = "lc.usage_status = 1";

        break;

        case 'expired':

            $where[] = "
                lc.usage_status = 0
                AND lc.expiry_date < NOW()
            ";

        break;

        case 'locked':

            $where[] = "
                lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
            ";

        break;
    }

    /* Date Filter */
    if(!empty($start_date) && !empty($end_date))
    {
        $where[] = "
            DATE(lc.created_date)
            BETWEEN :start_date AND :end_date
        ";

        $params[':start_date'] = $start_date;
        $params[':end_date']   = $end_date;
    }

    $sql = "
    SELECT
        lc.code,
        lc.coupon_amt,
        lc.created_date AS earned_date,
        lc.expiry_date,

        bt.order_id,
        bt.date AS travel_date,
        bt.created_date AS booking_date,

        p.name AS package_name,
        p.destination,

        bm.name AS traveller_name,
        bm.age,
        bm.gender,

        CASE

            WHEN lc.usage_status = 1
            THEN 'Used'

            WHEN lc.usage_status = 0
            AND lc.expiry_date < NOW()
            THEN 'Expired'

            WHEN lc.usage_status = 0
            AND EXISTS (
                SELECT 1
                FROM cu_coupons cc
                WHERE cc.user_id = lc.user_id
                AND cc.confirm_status = 1
                AND cc.usage_status = 0
            )
            THEN 'Locked'

            ELSE 'Available'

        END AS coupon_status

    FROM loyalty_coupon lc

    LEFT JOIN bookings bt
        ON bt.order_id = lc.payment_id

    LEFT JOIN package p
        ON p.id = bt.package_id

    LEFT JOIN booking_member_details bm
        ON bm.bookings_id = bt.id

    WHERE ".implode(' AND ', $where)."

    ORDER BY lc.created_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* Excel */

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setTitle('Loyalty Coupon Details');

    /* Headers */

    $headers = [
        'A1' => 'Earned Date',
        'B1' => 'Coupon Code',
        'C1' => 'Coupon Value',
        'D1' => 'Status',
        'E1' => 'Expiry Date',
        'F1' => 'Order ID',
        'G1' => 'Package Name',
        'H1' => 'Destination',
        'I1' => 'Travel Date',
        'J1' => 'Booking Date',
        'K1' => 'Traveller Name',
        'L1' => 'Age',
        'M1' => 'Gender'
    ];

    foreach($headers as $cell => $value)
    {
        $sheet->setCellValue($cell, $value);
    }

    $sheet->getStyle('A1:M1')->getFont()->setBold(true);

    $rowNo = 2;

    foreach($rows as $row)
    {
        $sheet->setCellValue('A'.$rowNo, $row['earned_date']);
        $sheet->setCellValue('B'.$rowNo, $row['code']);
        $sheet->setCellValue('C'.$rowNo, $row['coupon_amt']);
        $sheet->setCellValue('D'.$rowNo, $row['coupon_status']);
        $sheet->setCellValue('E'.$rowNo, $row['expiry_date']);

        $sheet->setCellValue('F'.$rowNo, $row['order_id']);
        $sheet->setCellValue('G'.$rowNo, $row['package_name']);
        $sheet->setCellValue('H'.$rowNo, $row['destination']);

        $sheet->setCellValue('I'.$rowNo, $row['travel_date']);
        $sheet->setCellValue('J'.$rowNo, $row['booking_date']);

        $sheet->setCellValue('K'.$rowNo, $row['traveller_name']);
        $sheet->setCellValue('L'.$rowNo, $row['age']);
        $sheet->setCellValue('M'.$rowNo, $row['gender']);

        $rowNo++;
    }

    /* Auto Width */

    foreach(range('A', 'M') as $column)
    {
        $sheet->getColumnDimension($column)
            ->setAutoSize(true);
    }

    /* Filename */

    $fileName =
        'Loyalty_Coupon_Report_' .
        date('Ymd_His') .
        '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    header(
        'Content-Disposition: attachment; filename="'.$fileName.'"'
    );

    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
?>