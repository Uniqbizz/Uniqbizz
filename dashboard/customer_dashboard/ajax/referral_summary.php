<?php

include_once(__DIR__ . '/../../dashboard_user_details.php');


// =====================================================
// GET ALL REFERRAL DATA
// =====================================================

$sqlRef = $conn->prepare("
    SELECT
        YEAR(created_date) AS year,
        MONTH(created_date) AS month_number,
        MONTHNAME(created_date) AS month_name,
        COALESCE(SUM(referral_amount), 0) AS total_amount

    FROM customer_reference_payout

    WHERE customer_id = :user_id
        AND referral_level = 'Level1'

    GROUP BY
        YEAR(created_date),
        MONTH(created_date),
        MONTHNAME(created_date)

    ORDER BY
        YEAR(created_date) ASC,
        MONTH(created_date) ASC
");


$sqlRef->execute([
    ':user_id' => $userId
]);


$refArray = $sqlRef->fetchAll(PDO::FETCH_ASSOC);


// =====================================================
// IF NO DATA
// =====================================================

if (empty($refArray)) {

    $currentYear = date('Y');

    $refArray = [];

    for ($month = 1; $month <= 12; $month++) {

        $refArray[] = [
            'year'         => $currentYear,
            'month_number' => $month,
            'month_name'   => date(
                'F',
                mktime(0, 0, 0, $month, 1)
            ),
            'total_amount' => 0
        ];
    }
}


// =====================================================
// RESPONSE
// =====================================================

header('Content-Type: application/json');

echo json_encode([
    'status' => true,
    'data'   => $refArray
]);