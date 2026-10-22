<?php
require '../../../../connect.php';

$columnDesignation = ['ete_id', 'bdm_id'];
$columnMessage     = ['ete_message', 'message'];
$columnCommision   = ['ete_amount', 'comm_amt'];
$columnStatus      = ['status', 'status'];

$tablename = [
    'techno_enterprise_payout',
    'goa_bdm_payout'
];

$TotalYear  = $_POST['TotalYear'] ?? '';
$TotalMonth = $_POST['TotalMonth'] ?? '';
$userID     = $_POST['userID'] ?? '';

$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage  = $_POST['totalTableMessage'] ?? '';

// Validate scalar values before processing them.
if (
    !is_scalar($TotalYear) ||
    !is_scalar($TotalMonth) ||
    !is_scalar($userID) ||
    !ctype_digit((string)$TotalYear) ||
    !ctype_digit((string)$TotalMonth) ||
    (int)$TotalYear < 1 ||
    (int)$TotalMonth < 1 ||
    (int)$TotalMonth > 12 ||
    trim((string)$userID) === ''
) {
    http_response_code(400);
    exit('Invalid payout request. Please check TotalYear, TotalMonth and userID.');
}

$TotalYear  = (int)$TotalYear;
$TotalMonth = (int)$TotalMonth;
$userID     = trim((string)$userID);


/* =========================================================
   TOTAL PAYOUT AMOUNT
   Combines both payout tables and deducts 2% TDS once
========================================================= */

if ($totalAmountMessage) {

    $sqlTotal = "
        SELECT COALESCE(SUM(payout_amount), 0) AS TotalPayout
        FROM (
            SELECT ete_amount AS payout_amount
            FROM techno_enterprise_payout
            WHERE ete_id = :userId0
              AND YEAR(created_date) = :year0
              AND MONTH(created_date) = :month0

            UNION ALL

            SELECT comm_amt AS payout_amount
            FROM goa_bdm_payout
            WHERE bdm_id = :userId1
              AND YEAR(created_date) = :year1
              AND MONTH(created_date) = :month1
        ) AS payout_totals
    ";

    $stmt = $conn->prepare($sqlTotal);

    $stmt->execute([
        ':userId0' => $userID,
        ':year0'   => $TotalYear,
        ':month0'  => $TotalMonth,

        ':userId1' => $userID,
        ':year1'   => $TotalYear,
        ':month1'  => $TotalMonth
    ]);

    $totalPayout = (float) $stmt->fetchColumn();

    // Deduct 2% TDS from the combined amount
    $tds = $totalPayout * 0.02;
    $netPayout = $totalPayout - $tds;

    echo number_format($netPayout, 2, '.', '');
}


/* =========================================================
   PAYOUT DETAILS TABLE
   Combines both payout sources
========================================================= */

if ($totalTableMessage) {

    $sqlTable = "
        SELECT *
        FROM (
            SELECT
                id,
                ete_id AS payout_user_id,
                ete_message AS payout_message,
                ete_amount AS commission,
                status,
                created_date,
                te_id
            FROM techno_enterprise_payout
            WHERE ete_id = :userId0
              AND YEAR(created_date) = :year0
              AND MONTH(created_date) = :month0

            UNION ALL

            SELECT
                id,
                bdm_id AS payout_user_id,
                message AS payout_message,
                comm_amt AS commission,
                status,
                created_date,
                '' AS te_id
            FROM goa_bdm_payout
            WHERE bdm_id = :userId1
              AND YEAR(created_date) = :year1
              AND MONTH(created_date) = :month1
        ) AS payout_data
        ORDER BY created_date DESC
    ";

    $model2 = $conn->prepare($sqlTable);

    $model2->execute([
        ':userId0' => $userID,
        ':year0'   => $TotalYear,
        ':month0'  => $TotalMonth,

        ':userId1' => $userID,
        ':year1'   => $TotalYear,
        ':month1'  => $TotalMonth
    ]);

    $payoutRows = $model2->fetchAll(PDO::FETCH_ASSOC);

    echo '
        <table class="table table-hover table-responsive"
               id="totalPayoutTable">

            <thead>
                <tr>
                    <th class="mobile_view">Date</th>
                    <th>Payout Details</th>
                    <th style="text-align:center;"
                        class="mobile_view tab_view">Amount</th>
                    <th style="text-align:center;"
                        class="mobile_view">TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>

            <tbody>
    ';

    if (!empty($payoutRows)) {

        foreach ($payoutRows as $row) {

            // Format date
            $dt = !empty($row['created_date'])
                ? date('Y-m-d', strtotime($row['created_date']))
                : '';

            // Escape message before displaying
            $rawMessage = (string) ($row['payout_message'] ?? '');

            $message = htmlspecialchars(
                $rawMessage,
                ENT_QUOTES,
                'UTF-8'
            );

            // Preserve your existing dot-to-line-break formatting
            $message = str_replace('.', '.<br>', $message);

            // Calculate commission, TDS and net payable
            $CommAmt = (float) ($row['commission'] ?? 0);
            $tds = $CommAmt * 0.02;
            $totalAmt = $CommAmt - $tds;

            $payoutId = $row['id'];
            $payoutUserId = $row['payout_user_id'];
            $teId = $row['te_id'] ?? '';
            $status = (string) ($row['status'] ?? '');

            // Download URL parameters
            $downloadParams = http_build_query([
                'vkvbvjfgfikix' => $payoutId,
                'bc'             => $payoutUserId,
                'ca'             => $teId,
                'date'           => $dt,
                'message'        => $rawMessage,
                'message_status' => $status,
                'commission'     => $CommAmt
            ]);

            echo '
                <tr>
                    <td>' .
                        htmlspecialchars($dt, ENT_QUOTES, 'UTF-8') .
                    '</td>

                    <td>' . $message . '</td>

                    <td style="text-align:center;">' .
                        number_format($CommAmt, 2) .
                    '</td>

                    <td style="text-align:center;">' .
                        number_format($tds, 2) .
                    '</td>

                    <td style="text-align:center;">' .
                        number_format($totalAmt, 2) . '

                        <a href="payout/forms/contracting_payout/download_ca_payout.php?' .
                            htmlspecialchars(
                                $downloadParams,
                                ENT_QUOTES,
                                'UTF-8'
                            ) . '">

                            <i class="bx bx-download"
                               style="font-size:18px;color:black;padding-left:5px;">
                            </i>
                        </a>
                    </td>
            ';

            if ($status === '1') {

                echo '
                    <td>
                        <span class="badge bg-success font-size-10 fw-bold ms-4">
                            Paid
                        </span>
                    </td>
                ';

            } else {

                echo '
                    <td>
                        <span class="badge bg-warning font-size-10 fw-bold ms-4">
                            Pending
                        </span>
                    </td>
                ';
            }

            echo '</tr>';
        }

    } else {

        echo '
            <tr>
                <td colspan="6" class="text-center">
                    No payout records found for the selected month.
                </td>
            </tr>
        ';
    }

    echo '
            </tbody>
        </table>
    ';
}
?>