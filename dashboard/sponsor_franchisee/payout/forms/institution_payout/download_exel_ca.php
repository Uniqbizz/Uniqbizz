<?php
require '../../../../connect.php';
require '../../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

// --------------------------------------------------
// Configuration
// --------------------------------------------------

$columnDesignation = ['bm_SF_sf'];
$columnMessage = ['message_bm_SF_sf'];
$columnCommision = ['commission_bm_SF_sf'];
$columnStatus = ['status_bm_SF_sf'];

$tablename = [
    'institution_payout'
];

// --------------------------------------------------
// Request parameters
// --------------------------------------------------

$payoutYear    = $_GET['payoutYear'] ?? '';
$payoutMonth   = $_GET['payoutMonth'] ?? '';
$payoutmessage = $_GET['payoutmessage'] ?? '';
$designation   = $_GET['designation'] ?? '';
$user_id       = trim((string)($_GET['user_id'] ?? ''));

// Validate the year and month as digit strings first.
if (
    !ctype_digit((string)$payoutYear) ||
    !ctype_digit((string)$payoutMonth) ||
    (int)$payoutYear < 1 ||
    (int)$payoutMonth < 1 ||
    (int)$payoutMonth > 12 ||
    $user_id === '' ||
    !in_array(
        $payoutmessage,
        ['PreviousPayout', 'NextPayout', 'TotalPayout'],
        true
    )
) {
    http_response_code(400);
    exit('Invalid payout export request.');
}

// Convert validated values to integers.
$payoutYear  = (int)$payoutYear;
$payoutMonth = (int)$payoutMonth;

// Get the month name safely.
$dateObj = DateTime::createFroSFormat(
    '!m',
    (string)$payoutMonth
);

if ($dateObj === false) {
    http_response_code(400);
    exit('Invalid payout month.');
}

$monthName = $dateObj->format('F');

// --------------------------------------------------
// Export configuration
// --------------------------------------------------

$exportTitles = [
    'PreviousPayout' => 'Previous Payout List',
    'NextPayout'     => 'Next Payout List',
    'TotalPayout'    => 'Total Payout List'
];

$fileNames = [
    'PreviousPayout' => 'Previous_Payout_List.xlsx',
    'NextPayout'     => 'Next_Payout_List.xlsx',
    'TotalPayout'    => 'Total_Payout_List.xlsx'
];

// --------------------------------------------------
// Fetch both payout sources
// --------------------------------------------------

$sql = "
    SELECT *
    FROM (
        SELECT
            id,
            'SF' AS payout_source,
            $columnDesignation[0] AS payout_user_id,
            $columnMessage[0] AS payout_message,
            $columnCommision[0] AS commission,
            $columnStatus[0] AS payout_status,
            created_date,
            te_id
        FROM $tablename[0]
        WHERE $columnDesignation[0] = :eteUserId
          AND YEAR(created_date) = :eteYear
          AND MONTH(created_date) = :eteMonth
    ) AS payout_records
    ORDER BY created_date DESC
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':eteUserId' => $user_id,
    ':eteYear'   => $payoutYear,
    ':eteMonth'  => $payoutMonth
]);

$payoutRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --------------------------------------------------
// Handle empty results
// --------------------------------------------------

if (empty($payoutRows)) {
    http_response_code(404);
    exit('No payout data found for the selected month.');
}

// --------------------------------------------------
// Create spreadsheet
// --------------------------------------------------

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Payout List');

$sheet->mergeCells('A1:J1');

$sheet->setCellValue(
    'A1',
    $exportTitles[$payoutmessage] .
    ' as of ' . $monthName . ', ' . $payoutYear
);

$headers = [
    'Date',
    'Sponsor Franchisee ID',
    'Sponsor Franchisee Name',
    'Institution ID',
    'Institution Name',
    'Payout Details',
    'Amount',
    'TDS',
    'Total Payable',
    'Status'
];

$headerRow = 3;

foreach ($headers as $index => $header) {
    $column = chr(65 + $index);

    $sheet->setCellValue(
        $column . $headerRow,
        $header
    );
}

$rowNo = 4;

// Prepare name lookups once
$eteNameStmt = $conn->prepare("
    SELECT firstname,lastname
    FROM sponsor_franchisee
    WHERE sponsor_franchisee_id = :eteId
    LIMIT 1
");

$caNameStmt = $conn->prepare("
    SELECT firstname, lastname
    FROM institution
    WHERE institution_id = :caId
    LIMIT 1
");

// --------------------------------------------------
// Populate spreadsheet
// --------------------------------------------------

foreach ($payoutRows as $row) {

    $newDate = !empty($row['created_date'])
        ? date('d-m-Y', strtotime($row['created_date']))
        : '';

    $source = $row['payout_source'];

    $payoutUserId = $row['payout_user_id'] ?? '';

    $teId = $row['te_id'] ?? '';

    $message = (string)($row['payout_message'] ?? '');

    // Preserve the existing line-break formatting
    $message = str_replace('.', PHP_EOL, $message);

    // Amount and TDS
    $Commi = (float)($row['commission'] ?? 0);

    $Commi_TDS = $Commi * 0.02;

    $Commi_Total = $Commi - $Commi_TDS;

    // --------------------------------------------------
    // SF name
    // --------------------------------------------------

    $ta_name = '';

    if ($source === 'SF' && $payoutUserId !== '') {

        $eteNameStmt->execute([
            ':eteId' => $payoutUserId
        ]);

        $eteData = $eteNameStmt->fetch(PDO::FETCH_ASSOC);

        if ($eteData) {
            $ta_name = trim(
                ($eteData['firstname'] ?? '') . ' ' .
                ($eteData['lastname'] ?? '')
            );
        }
    }

    // --------------------------------------------------
    // Institution name
    // --------------------------------------------------

    $ca_name = '';

    if ($source === 'SF' && $teId !== '') {

        $caNameStmt->execute([
            ':caId' => $teId
        ]);

        $caData = $caNameStmt->fetch(PDO::FETCH_ASSOC);

        if ($caData) {
            $ca_name = trim(
                ($caData['firstname'] ?? '') . ' ' .
                ($caData['lastname'] ?? '')
            );
        }
    }

    // Status: 1 = Paid; other values = Pending
    $status = (string)($row['payout_status'] ?? '');

    $statusText = ($status === '1')
        ? 'Paid'
        : 'Pending';

    // --------------------------------------------------
    // Write spreadsheet cells
    // --------------------------------------------------

    // IDs are written as text to preserve their formatting
    $sheet->setCellValueExplicit(
        'B' . $rowNo,
        (string)$payoutUserId,
        DataType::TYPE_STRING
    );

    $sheet->setCellValue('A' . $rowNo, $newDate);
    $sheet->setCellValue('C' . $rowNo, $ta_name);

    $sheet->setCellValueExplicit(
        'D' . $rowNo,
        (string)$teId,
        DataType::TYPE_STRING
    );

    $sheet->setCellValue('E' . $rowNo, $ca_name);
    $sheet->setCellValue('F' . $rowNo, $message);
    $sheet->setCellValue('G' . $rowNo, $Commi);
    $sheet->setCellValue('H' . $rowNo, $Commi_TDS);
    $sheet->setCellValue('I' . $rowNo, $Commi_Total);
    $sheet->setCellValue('J' . $rowNo, $statusText);

    $rowNo++;
}

// --------------------------------------------------
// Formatting
// --------------------------------------------------

$sheet->getStyle('A1:J1')
    ->getFont()
    ->setBold(true)
    ->setSize(14);

$sheet->getStyle('A1:J1')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->getStyle('A3:J3')
    ->getFont()
    ->setBold(true);

$sheet->getStyle('A3:J3')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->getStyle('G4:I' . ($rowNo - 1))
    ->getNumberFormat()
    ->setFormatCode('#,##0.00');

$sheet->getStyle('F4:F' . ($rowNo - 1))
    ->getAlignment()
    ->setWrapText(true);

foreach (range('A', 'J') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// --------------------------------------------------
// Download Excel file
// --------------------------------------------------

while (ob_get_level() > 0) {
    ob_end_clean();
}

header(
    'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
);

header(
    'Content-Disposition: attachment; filename="' .
    $fileNames[$payoutmessage] . '"'
);

header('Cache-Control: max-age=0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$spreadsheet->disconnectWorksheets();
exit;
?>