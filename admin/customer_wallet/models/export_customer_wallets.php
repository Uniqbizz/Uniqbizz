<?php

    require_once __DIR__ . '/../../../vendor/autoload.php';
    include (__DIR__.'/../../connect.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $membership_type = $_GET['membership_type'] ?? 'all';
    $start_date      = $_GET['start_date'] ?? '';
    $end_date        = $_GET['end_date'] ?? '';

    $where = ["c.status = 1"];
    $params = [];

    if(!empty($membership_type) && $membership_type != 'all')
    {
        $where[] = "c.customer_type = :membership_type";
        $params[':membership_type'] = $membership_type;
    }

    if(!empty($start_date) && !empty($end_date))
    {
        $where[] = "DATE(c.register_date) BETWEEN :start_date AND :end_date";

        $params[':start_date'] = $start_date;
        $params[':end_date']   = $end_date;
    }

    $sql = "
    SELECT
        CONCAT(c.firstname,' ',c.lastname) AS customer_name,
        c.ca_customer_id,
        c.customer_type,
        c.contact_no,

        COALESCE(cp.coupon_total,0) coupon_total,
        COALESCE(cp.coupon_count,0) coupon_count,

        COALESCE(lp.loyalty_coupon_total,0) loyalty_coupon_total,
        COALESCE(lp.loyalty_count,0) loyalty_count,

        COALESCE(rp.ref_total,0) ref_total,
        COALESCE(rp.ref_count,0) ref_count,

        COALESCE(dp.dis_total,0) dis_total,
        COALESCE(dp.dis_count,0) dis_count,

        c.register_date

    FROM ca_customer c

    LEFT JOIN (
        SELECT user_id,
            SUM(coupon_amt) coupon_total,
            COUNT(*) coupon_count
        FROM cu_coupons
        GROUP BY user_id
    ) cp ON cp.user_id = c.ca_customer_id

    LEFT JOIN (
        SELECT user_id,
            SUM(coupon_amt) loyalty_coupon_total,
            COUNT(*) loyalty_count
        FROM loyalty_coupon
        GROUP BY user_id
    ) lp ON lp.user_id = c.ca_customer_id

    LEFT JOIN (
        SELECT customer_id,
            SUM(earned_amount) ref_total,
            COUNT(*) ref_count
        FROM customer_reference_wallet_utilization
        GROUP BY customer_id
    ) rp ON rp.customer_id = c.ca_customer_id

    LEFT JOIN (
        SELECT customer_id,
            SUM(earn_amount) dis_total,
            COUNT(*) dis_count
        FROM customer_discount_wallet
        GROUP BY customer_id
    ) dp ON dp.customer_id = c.ca_customer_id

    WHERE ".implode(' AND ',$where)."

    ORDER BY c.id DESC
    ";

    $stmt = $conn->prepare($sql);

    foreach($params as $key => $value)
    {
        $stmt->bindValue($key,$value);
    }

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'Customer Name',
        'Customer ID',
        'Membership',
        'Mobile',
        'Coupon Count',
        'Coupon Amount',
        'Loyalty Count',
        'Loyalty Amount',
        'Referral Count',
        'Referral Amount',
        'Discount Count',
        'Discount Amount',
        'Register Date'
    ];

    $column = 'A';

    foreach($headers as $header)
    {
        $sheet->setCellValue($column.'1', $header);
        $column++;
    }

    $rowNo = 2;

    foreach($rows as $row)
    {
        $sheet->setCellValue('A'.$rowNo, $row['customer_name']);
        $sheet->setCellValue('B'.$rowNo, $row['ca_customer_id']);
        $sheet->setCellValue('C'.$rowNo, $row['customer_type']);
        $sheet->setCellValue('D'.$rowNo, $row['contact_no']);

        $sheet->setCellValue('E'.$rowNo, $row['coupon_count']);
        $sheet->setCellValue('F'.$rowNo, $row['coupon_total']);

        $sheet->setCellValue('G'.$rowNo, $row['loyalty_count']);
        $sheet->setCellValue('H'.$rowNo, $row['loyalty_coupon_total']);

        $sheet->setCellValue('I'.$rowNo, $row['ref_count']);
        $sheet->setCellValue('J'.$rowNo, $row['ref_total']);

        $sheet->setCellValue('K'.$rowNo, $row['dis_count']);
        $sheet->setCellValue('L'.$rowNo, $row['dis_total']);

        $sheet->setCellValue(
            'M'.$rowNo,
            date('d M Y', strtotime($row['register_date']))
        );

        $rowNo++;
    }

    foreach(range('A','M') as $col)
    {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->getStyle('A1:M1')->getFont()->setBold(true);

    $fileName = 'Customer_Wallet_Report_'.date('Ymd_His').'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$fileName.'"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
exit;