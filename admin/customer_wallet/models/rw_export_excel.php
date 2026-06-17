<?php

    require_once __DIR__ . '/../../../vendor/autoload.php';
    include(__DIR__ . '/../../connect.php');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $start_date = $_GET['start_date'] ?? '';
    $end_date   = $_GET['end_date'] ?? '';

    $where = "";

    $params = [];

    if (!empty($start_date) && !empty($end_date)) {

        $where = " WHERE DATE(crwu.created_date) BETWEEN ? AND ? ";
        $params[] = $start_date;
        $params[] = $end_date;
    }

    $sql = "
        SELECT
            c.ca_customer_id,
            CONCAT(c.firstname,' ',c.lastname) AS customer_name,
            c.customer_type,

            COALESCE(SUM(crwu.earned_amount),0) AS total_earned,

            COALESCE(
                (
                    SELECT balance
                    FROM customer_reference_wallet_utilization crwu2
                    WHERE crwu2.customer_id = c.ca_customer_id
                    ORDER BY crwu2.id DESC
                    LIMIT 1
                ),
                0
            ) AS available_balance,

            COALESCE(SUM(crwu.used_amount),0) AS used_balance,

            (
                SELECT COALESCE(SUM(encashed_amount), 0)
                FROM customer_reference_wallet_encashed cre
                WHERE cre.customer_id = c.ca_customer_id
                AND cre.status = 2
            ) AS pending_withdrawal

        FROM ca_customer c

        LEFT JOIN customer_reference_wallet_utilization crwu
            ON crwu.customer_id = c.ca_customer_id

        {$where}

        GROUP BY c.ca_customer_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Customer ID');
    $sheet->setCellValue('B1', 'Customer Name');
    $sheet->setCellValue('C1', 'Customer Type');
    $sheet->setCellValue('D1', 'Total Earned');
    $sheet->setCellValue('E1', 'Available Balance');
    $sheet->setCellValue('F1', 'Used Balance');
    $sheet->setCellValue('G1', 'Pending Withdrawal');

    $rowNo = 2;

    foreach ($rows as $row) {

        $sheet->setCellValue('A'.$rowNo, $row['ca_customer_id']);
        $sheet->setCellValue('B'.$rowNo, $row['customer_name']);
        $sheet->setCellValue('C'.$rowNo, $row['customer_type']);
        $sheet->setCellValue('D'.$rowNo, $row['total_earned']);
        $sheet->setCellValue('E'.$rowNo, $row['available_balance']);
        $sheet->setCellValue('F'.$rowNo, $row['used_balance']);
        $sheet->setCellValue('G'.$rowNo, $row['pending_withdrawal']);

        $rowNo++;
    }

    foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    $fileName = 'Referral_Wallet_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$fileName.'"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>