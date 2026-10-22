<?php
require '../../../../connect.php';

$columnDesignation = ['bm_id','ste_id','bm_user_id','business_mentor'];
$columnMessage = ['message','ste_message','message_bm','message'];
$columnCommision = ['comm_amt','ste_amount','payout_amount','comm_amt'];
$columnStatus = ['status','ste_status','payout_status','status'];
$tablename=['goa_bm_payout','techno_enterprise_payout','bm_payout_history','ca_payout'];
$tablename_paid=['goa_bm_payout','techno_enterprise_payout_paid','bm_payout_history','ca_payout'];

$TotalYear = (int)($_POST['TotalYear'] ?? date('Y'));
$TotalMonth = (int)($_POST['TotalMonth'] ?? date('n'));
$userID = $_POST['userID'] ?? '';

$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if ($userID === '') {
    exit;
}

/*
|--------------------------------------------------------------------------
| TOTAL PAYOUT AMOUNT
|--------------------------------------------------------------------------
*/

if ($totalAmountMessage) {

    $stmt = $conn->prepare("
        SELECT SUM(total_commission) AS TotalPayout
        FROM (
            SELECT SUM($columnCommision[0]) AS total_commission
            FROM $tablename[0]
            WHERE $columnDesignation[0] = :userId0
              AND $columnStatus[0] = '1'
              AND YEAR(created_date) = :year0
              AND MONTH(created_date) = :month0

            UNION ALL

            SELECT SUM($columnCommision[1]) AS total_commission
            FROM $tablename[1]
            WHERE $columnDesignation[1] = :userId1
              AND $columnStatus[1] = '1'
              AND YEAR(created_date) = :year1
              AND MONTH(created_date) = :month1

            UNION ALL

            SELECT SUM($columnCommision[2]) AS total_commission
            FROM $tablename[2]
            WHERE $columnDesignation[2] = :userId2
              AND $columnStatus[2] = '1'
              AND YEAR(payout_date) = :year2
              AND MONTH(payout_date) = :month2

            UNION ALL

            SELECT SUM($columnCommision[3]) AS total_commission
            FROM $tablename[3]
            WHERE $columnDesignation[3] = :userId3
              AND $columnStatus[3] = '1'
              AND YEAR(created_date) = :year3
              AND MONTH(created_date) = :month3
        ) AS payout_data
    ");

    $stmt->execute([
        ':userId0' => $userID,
        ':year0' => $TotalYear,
        ':month0' => $TotalMonth,

        ':userId1' => $userID,
        ':year1' => $TotalYear,
        ':month1' => $TotalMonth,

        ':userId2' => $userID,
        ':year2' => $TotalYear,
        ':month2' => $TotalMonth,

        ':userId3' => $userID,
        ':year3' => $TotalYear,
        ':month3' => $TotalMonth
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $TotalPayout = (float)($row['TotalPayout'] ?? 0);

    $tds = $TotalPayout * 2 / 100;
    $TotalPayout -= $tds;

    echo number_format($TotalPayout, 2, '.', '');
}


/*
|--------------------------------------------------------------------------
| TOTAL PAYOUT TABLE
|--------------------------------------------------------------------------
*/

if ($totalTableMessage) {

    echo '
    <table class="table table-hover table-responsive" id="totalPayoutTable">
        <thead>
            <tr>
                <th class="mobile_view">Date</th>
                <th>Payout Details</th>
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view">TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>
        </thead>
        <tbody>';

    $model2 = $conn->prepare("
        SELECT *
        FROM (
            SELECT
                id,
                $columnDesignation[0] AS bm_id,
                $columnCommision[0] AS commission,
                $columnStatus[0] AS status,
                $columnMessage[0] AS message,
                created_date,
                techno_enterprise
            FROM $tablename[0]
            WHERE $columnDesignation[0] = :userId0
              AND YEAR(created_date) = :year0
              AND MONTH(created_date) = :month0

            UNION ALL

            SELECT
                id,
                $columnDesignation[1] AS bm_id,
                $columnCommision[1] AS commission,
                $columnStatus[1] AS status,
                $columnMessage[1] AS message,
                created_date,
                te_id AS techno_enterprise
            FROM $tablename[1]
            WHERE $columnDesignation[1] = :userId1
              AND YEAR(created_date) = :year1
              AND MONTH(created_date) = :month1

            UNION ALL

            SELECT
                id,
                $columnDesignation[2] AS bm_id,
                $columnCommision[2] AS commission,
                $columnStatus[2] AS status,
                $columnMessage[2] AS message,
                payout_date AS created_date,
                ca_user_id AS techno_enterprise
            FROM $tablename[2]
            WHERE $columnDesignation[2] = :userId2
              AND YEAR(payout_date) = :year2
              AND MONTH(payout_date) = :month2

            UNION ALL

            SELECT
                id,
                $columnDesignation[3] AS bm_id,
                $columnCommision[3] AS commission,
                $columnStatus[3] AS status,
                $columnMessage[3] AS message,
                created_date,
                techno_enterprise
            FROM $tablename[3]
            WHERE $columnDesignation[3] = :userId3
              AND YEAR(created_date) = :year3
              AND MONTH(created_date) = :month3
        ) AS payout_data
        ORDER BY created_date DESC
    ");

    $model2->execute([
        ':userId0' => $userID,
        ':year0' => $TotalYear,
        ':month0' => $TotalMonth,

        ':userId1' => $userID,
        ':year1' => $TotalYear,
        ':month1' => $TotalMonth,

        ':userId2' => $userID,
        ':year2' => $TotalYear,
        ':month2' => $TotalMonth,

        ':userId3' => $userID,
        ':year3' => $TotalYear,
        ':month3' => $TotalMonth
    ]);

    while ($row = $model2->fetch(PDO::FETCH_ASSOC)) {

        $dt = !empty($row['created_date'])
            ? (new DateTime($row['created_date']))->format('Y-m-d')
            : '';

        $CommAmt = is_numeric($row['commission'])
            ? (float)$row['commission']
            : 0;

        $tds = $CommAmt * 2 / 100;
        $totalAmt = $CommAmt - $tds;

        $downloadParams = http_build_query([
            'vkvbvjfgfikix' => $row['id'],
            'bc' => $row['bm_id'],
            'ca' => $row['techno_enterprise'],
            'date' => $dt,
            'message' => $row['message'],
            'message_status' => $row['status'],
            'commission' => $row['commission']
        ]);

        $downloadUrl = 'payout/forms/contracting_payout/download_ca_payout.php?'
            . $downloadParams;

        $message = nl2br(
            htmlspecialchars($row['message'] ?? '', ENT_QUOTES, 'UTF-8')
        );

        echo '
        <tr>
            <td>' . htmlspecialchars($dt, ENT_QUOTES, 'UTF-8') . '</td>
            <td>' . $message . '</td>
            <td style="text-align:center;">' . number_format($CommAmt, 2) . '</td>
            <td style="text-align:center;">' . number_format($tds, 2) . '</td>
            <td style="text-align:center;">
                ' . number_format($totalAmt, 2) . '
                <a href="' . htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') . '">
                    <i class="bx bx-download"
                       style="font-size:18px;color:black;padding-left:5px;"></i>
                </a>
            </td>';

        if ($row['status'] == '1') {
            echo '
            <td>
                <span class="badge bg-success font-size-10 fw-bold ms-4">
                    Paid
                </span>
            </td>';
        } else {
            echo '
            <td>
                <span class="badge bg-warning font-size-10 fw-bold ms-4">
                    Pending
                </span>
            </td>';
        }

        echo '</tr>';
    }

    echo '
        </tbody>
    </table>';
}
?>