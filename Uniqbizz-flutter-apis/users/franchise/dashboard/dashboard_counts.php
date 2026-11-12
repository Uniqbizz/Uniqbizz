<?php
header('Content-Type: application/json');

$date = date('F,Y'); //month and year. 'F' - month in Text form
$DateMonth = date('m'); //month in number form
$DateYear = date('Y'); //year

require '../../../connect.php';

// ---------- READ JSON INPUT ----------
$data = json_decode(file_get_contents("php://input"), true);

$userId   = $data['userId']   ?? null;
$userType = 29;
$month    = $DateMonth;
$year     = $DateYear;

$tdsPercentage = 0.02;

// ---------- VALIDATION ----------
if (!$userId || !$userType || !$month || !$year) {
    echo json_encode([
        "status" => false,
        "message" => "Missing required parameters"
    ]);
    exit;
}

// if ($userType != 29) {
//     echo json_encode([
//         "status" => false,
//         "message" => "Unauthorized user type"
//     ]);
//     exit;
// }

// ---------- 1️⃣ TRAVEL CONSULTANTS ----------
$sqlTC = "
SELECT 
    COUNT(ca_travelagency_id) AS total,
    SUM(
        CASE 
            WHEN YEAR(register_date) = :year 
            AND MONTH(register_date) = :month 
            THEN 1 ELSE 0 
        END
    ) AS this_month
FROM ca_travelagency
WHERE reference_no = :user_id
AND user_type = '11'
AND status = '1'
";

$stmt = $conn->prepare($sqlTC);
$stmt->execute([
    ':user_id' => $userId,
    ':month'   => $month,
    ':year'    => $year
]);
$tc = $stmt->fetch(PDO::FETCH_ASSOC);

// ---------- 2️⃣ CUSTOMERS ----------
$sqlCustomer = "
SELECT 
    COUNT(c.ca_customer_id) AS total,
    SUM(
        CASE 
            WHEN YEAR(c.register_date) = :year 
            AND MONTH(c.register_date) = :month 
            THEN 1 ELSE 0 
        END
    ) AS this_month
FROM ca_customer c
INNER JOIN ca_travelagency ta 
    ON ta.ca_travelagency_id = c.ta_reference_no
WHERE ta.reference_no = :user_id
AND c.status = '1'
";

$stmt = $conn->prepare($sqlCustomer);
$stmt->execute([
    ':user_id' => $userId,
    ':month'   => $month,
    ':year'    => $year
]);
$customers = $stmt->fetch(PDO::FETCH_ASSOC);

// ---------- 3️⃣ COMMISSION ----------
$sqlCommission = "
SELECT
    /* PAID (status = 1) */
    (
        (SELECT IFNULL(SUM(te_amt),0) 
         FROM product_payout 
         WHERE te_id = :user_id 
         AND te_id LIKE 'F%' 
         AND status = 1)

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_ta_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status = 1)

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_cu_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status = 1)
    ) AS commission_paid_amount,

    /* PENDING (status = 2) */
    (
        (SELECT IFNULL(SUM(te_amt),0) 
         FROM product_payout 
         WHERE te_id = :user_id 
         AND te_id LIKE 'F%' 
         AND status = 2)

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_ta_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status = 2)

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_cu_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status = 2)
    ) AS commission_pending_amount,

    /* TOTAL (status 1 + 2) */
    (
        (SELECT IFNULL(SUM(te_amt),0) 
         FROM product_payout 
         WHERE te_id = :user_id 
         AND te_id LIKE 'F%' 
         AND status IN (1,2))

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_ta_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status IN (1,2))

        +

        (SELECT IFNULL(SUM(commision_te),0) 
         FROM ca_cu_payout 
         WHERE techno_enterprise = :user_id 
         AND techno_enterprise LIKE 'F%' 
         AND status IN (1,2))
    ) AS commission_total
";

$stmt = $conn->prepare($sqlCommission);
$stmt->execute([':user_id' => $userId]);
$commission = $stmt->fetch(PDO::FETCH_ASSOC);

// ---------- APPLY TDS ----------
$paidAmount    = $commission['commission_paid_amount'] ?? 0;
$pendingAmount = $commission['commission_pending_amount'] ?? 0;
$totalAmount = $commission['commission_total'] ?? 0;

$confirmedNet = $paidAmount - ($paidAmount * $tdsPercentage);
$pendingNet   = $pendingAmount - ($pendingAmount * $tdsPercentage);
$totalNet = $totalAmount - ($totalAmount * $tdsPercentage);

// ---------- FINAL RESPONSE ----------
echo json_encode([
    "status" => true,
    "data" => [
        "travel_consultants" => [
            "total" => (int)$tc['total'],
            "this_month" => (int)$tc['this_month']
        ],
        "customers" => [
            "total" => (int)$customers['total'],
            "this_month" => (int)$customers['this_month']
        ],
        "commission" => [
        "paid" => number_format($confirmedNet, 2, '.', ''),
        "pending"   => number_format($pendingNet, 2, '.', ''),
        "total"     => number_format($totalNet, 2, '.', '')
        ]
    ]
]);
