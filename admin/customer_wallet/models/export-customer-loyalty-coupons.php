<?php

    require_once __DIR__ . '/../../../vendor/autoload.php';
    include(__DIR__.'/../../connect.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $conditions = [];
    $having = [];
    $params = [];

    $status = $_GET['status'] ?? '';
    $month  = $_GET['month'] ?? '';

    if (!empty($month))
    {
        $conditions[] = "DATE_FORMAT(c.register_date,'%Y-%m') = :month";
        $params[':month'] = $month;
    }

    $sql = "
    SELECT
        c.ca_customer_id,
        CONCAT(c.firstname,' ',c.lastname) AS cust_name,
        c.customer_type,

        COUNT(lc.id) AS total_coupons,
        COALESCE(SUM(lc.coupon_amt),0) AS total_amt,

        COUNT(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND NOT EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
                THEN 1
            END
        ) AS available_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND NOT EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS available_amt,

        COUNT(
            CASE
                WHEN lc.usage_status = 1
                THEN 1
            END
        ) AS used_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 1
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS used_amt,

        COUNT(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date < NOW()
                THEN 1
            END
        ) AS expired_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date < NOW()
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS expired_amt,

        COUNT(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
                THEN 1
            END
        ) AS locked_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS locked_amt,

        CASE
            WHEN COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND EXISTS (
                        SELECT 1
                        FROM cu_coupons cc
                        WHERE cc.user_id = lc.user_id
                        AND cc.confirm_status = 1
                        AND cc.usage_status = 0
                    )
                    THEN 1
                END
            ) > 0
            THEN 'Locked'

            WHEN COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    THEN 1
                END
            ) > 0
            THEN 'Eligible / Unlocked'

            WHEN COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date < NOW()
                    THEN 1
                END
            ) > 0
            THEN 'Expired'

            ELSE 'Used'
        END AS coupon_status

    FROM loyalty_coupon lc

    INNER JOIN ca_customer c
        ON c.ca_customer_id = lc.user_id
        AND c.status = 1

    WHERE lc.confirm_status = 1
    ";

    if (!empty($conditions))
    {
        $sql .= " AND ".implode(' AND ', $conditions);
    }

    $sql .= "
    GROUP BY
        c.ca_customer_id,
        c.firstname,
        c.lastname,
        c.customer_type
    ";

    switch ($status)
    {
        case 'available':
            $having[] = "available_coupons > 0";
        break;

        case 'used':
            $having[] = "used_coupons > 0";
        break;

        case 'expired':
            $having[] = "expired_coupons > 0";
        break;

        case 'locked':
            $having[] = "locked_coupons > 0";
        break;
    }

    if (!empty($having))
    {
        $sql .= " HAVING ".implode(' AND ', $having);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'Customer ID',
        'Customer Name',
        'Membership',
        'Total Coupons',
        'Total Amount',
        'Available Coupons',
        'Available Amount',
        'Used Coupons',
        'Used Amount',
        'Expired Coupons',
        'Expired Amount',
        'Locked Coupons',
        'Locked Amount',
        'Status'
    ];

    $column = 'A';

    foreach ($headers as $header)
    {
        $sheet->setCellValue($column.'1', $header);
        $column++;
    }

    $rowNum = 2;

    foreach ($rows as $row)
    {
        $sheet->setCellValue('A'.$rowNum, $row['ca_customer_id']);
        $sheet->setCellValue('B'.$rowNum, $row['cust_name']);
        $sheet->setCellValue('C'.$rowNum, $row['customer_type']);

        $sheet->setCellValue('D'.$rowNum, $row['total_coupons']);
        $sheet->setCellValue('E'.$rowNum, $row['total_amt']);

        $sheet->setCellValue('F'.$rowNum, $row['available_coupons']);
        $sheet->setCellValue('G'.$rowNum, $row['available_amt']);

        $sheet->setCellValue('H'.$rowNum, $row['used_coupons']);
        $sheet->setCellValue('I'.$rowNum, $row['used_amt']);

        $sheet->setCellValue('J'.$rowNum, $row['expired_coupons']);
        $sheet->setCellValue('K'.$rowNum, $row['expired_amt']);

        $sheet->setCellValue('L'.$rowNum, $row['locked_coupons']);
        $sheet->setCellValue('M'.$rowNum, $row['locked_amt']);

        $sheet->setCellValue('N'.$rowNum, $row['coupon_status']);

        $rowNum++;
    }
    $fileName = 'Customer_Loyalty_Coupons_'.date('Ymd_His').'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$fileName.'"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>