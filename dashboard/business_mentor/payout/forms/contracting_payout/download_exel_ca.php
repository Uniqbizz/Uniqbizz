<?php

require '../../../../connect.php';
require '../../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$columnDesignation = [
    'bm_id',
    'ste_id',
    'bm_user_id',
    'business_mentor'
];

$columnMessage = [
    'message',
    'ste_message',
    'message_bm',
    'message'
];

$columnCommision = [
    'comm_amt',
    'ste_amount',
    'payout_amount',
    'comm_amt'
];

$columnStatus = [
    'status',
    'ste_status',
    'payout_status',
    'status'
];

$tablename = [
    'goa_bm_payout',
    'techno_enterprise_payout',
    'bm_payout_history',
    'ca_payout'
];

$tablename_paid = [
    'goa_bm_payout',
    'techno_enterprise_payout_paid',
    'bm_payout_history',
    'ca_payout'
];

// =====================================================
// GET PARAMETERS
// =====================================================

$payoutYear    = filter_input(INPUT_GET, 'payoutYear', FILTER_VALIDATE_INT);
$payoutMonth   = filter_input(INPUT_GET, 'payoutMonth', FILTER_VALIDATE_INT);
$payoutmessage = $_GET['payoutmessage'] ?? '';
$designation   = $_GET['designation'] ?? '';
$user_id       = $_GET['user_id'] ?? '';

$allowedTypes = [
    'PreviousPayout',
    'NextPayout',
    'TotalPayout'
];

if (
    !$payoutYear ||
    !$payoutMonth ||
    $payoutMonth < 1 ||
    $payoutMonth > 12 ||
    $user_id === '' ||
    !in_array($payoutmessage, $allowedTypes, true)
) {
    exit('Invalid payout request.');
}

$monthName = DateTime::createFromFormat(
    '!m',
    (string)$payoutMonth
)->format('F');

// =====================================================
// BUILD QUERY FOR ALL FOUR TABLES
// =====================================================

$sqlParts = [];
$params = [];

for ($i = 0; $i < 4; $i++) {

    $dateColumn = ($i === 2) ? 'payout_date' : 'created_date';

    // Enterprise ID mapping from your existing payout structure
    $enterpriseColumn = match ($i) {
        0 => 'techno_enterprise',
        1 => 'te_id',
        2 => 'ca_user_id',
        3 => 'techno_enterprise'
    };

    $sqlParts[] = "
        SELECT
            id,
            {$columnDesignation[$i]} AS designation_id,
            {$enterpriseColumn} AS enterprise_id,
            {$columnMessage[$i]} AS payout_message,
            {$columnCommision[$i]} AS commission,
            {$columnStatus[$i]} AS payout_status,
            {$dateColumn} AS payout_date
        FROM {$tablename[$i]}
        WHERE {$columnDesignation[$i]} = :user{$i}
          AND YEAR({$dateColumn}) = :year{$i}
          AND MONTH({$dateColumn}) = :month{$i}
    ";

    $params[":user{$i}"] = $user_id;
    $params[":year{$i}"] = $payoutYear;
    $params[":month{$i}"] = $payoutMonth;
}

$sql = implode(' UNION ALL ', $sqlParts);
$sql = "SELECT * FROM ($sql) AS payout_data ORDER BY payout_date DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo '<script>alert("No Payout Data"); window.history.back();</script>';
        exit;
    }

    // =================================================
    // CREATE EXCEL
    // =================================================

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $titles = [
        'PreviousPayout' => 'Previous Payout List',
        'NextPayout'     => 'Next Payout List',
        'TotalPayout'    => 'Total Payout List'
    ];

    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue(
        'A1',
        $titles[$payoutmessage] . ' as of ' .
        $monthName . ', ' . $payoutYear
    );

    $headers = [
        'Date',
        'Designation ID',
        'Enterprise ID',
        'Payout Details',
        'Amount',
        'TDS',
        'Total Payable',
        'Status'
    ];

    $col = 'A';

    foreach ($headers as $header) {
        $sheet->setCellValue($col . '3', $header);
        $col++;
    }

    $rowNo = 4;

    foreach ($rows as $row) {

        $date = !empty($row['payout_date'])
            ? date('d-m-Y', strtotime($row['payout_date']))
            : '';

        $commission = is_numeric($row['commission'])
            ? (float)$row['commission']
            : 0;

        $tds = $commission * 2 / 100;
        $total = $commission - $tds;

        $message = str_replace(
            '.',
            '.' . PHP_EOL,
            (string)($row['payout_message'] ?? '')
        );

        $statusText = ((string)$row['payout_status'] === '1')
            ? 'Paid'
            : 'Pending';

        $sheet->setCellValue('A' . $rowNo, $date);
        $sheet->setCellValueExplicit(
            'B' . $rowNo,
            (string)$row['designation_id'],
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
        );
        $sheet->setCellValueExplicit(
            'C' . $rowNo,
            (string)($row['enterprise_id'] ?? ''),
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
        );
        $sheet->setCellValue('D' . $rowNo, $message);
        $sheet->setCellValue('E' . $rowNo, $commission);
        $sheet->setCellValue('F' . $rowNo, $tds);
        $sheet->setCellValue('G' . $rowNo, $total);
        $sheet->setCellValue('H' . $rowNo, $statusText);

        $rowNo++;
    }

    // =================================================
    // EXCEL FORMATTING
    // =================================================

    $sheet->getStyle('A1:H1')
        ->getFont()
        ->setBold(true)
        ->setSize(14);

    $sheet->getStyle('A3:H3')
        ->getFont()
        ->setBold(true);

    $sheet->getStyle('E4:G' . ($rowNo - 1))
        ->getNumberFormat()
        ->setFormatCode('#,##0.00');

    $sheet->getStyle('A3:H' . ($rowNo - 1))
        ->getAlignment()
        ->setVertical(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
        );

    $sheet->getStyle('D4:D' . ($rowNo - 1))
        ->getAlignment()
        ->setWrapText(true);

    foreach (range('A', 'H') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // =================================================
    // DOWNLOAD
    // =================================================

    $filename = $payoutmessage . '_List.xlsx';

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    header(
        'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );
    header(
        'Content-Disposition: attachment; filename="' . $filename . '"'
    );
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Unable to export payout data. Please check the payout table columns.');
}
?>