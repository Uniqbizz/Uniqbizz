<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $selectedYear = !empty($_POST['year'])
        ? (int) $_POST['year']
        : date('Y');


    /*
    |--------------------------------------------------------------------------
    | Available Years
    |--------------------------------------------------------------------------
    */

    $sqlYears = $conn->prepare("
        SELECT DISTINCT year
        FROM (

            /* Travel Consultant */
            SELECT YEAR(ca.register_date) AS year
            FROM ca_travelagency ca
            WHERE ca.reference_no = ?
              AND ca.status IN (1, 3)

            UNION ALL

            /* Institution Branch Manager */
            SELECT YEAR(ibr.register_date) AS year
            FROM institution_branch_manager ibr
            WHERE ibr.reference_no = ?
              AND ibr.status IN (1, 3)

        ) years_data

        WHERE year IS NOT NULL

        ORDER BY year DESC
    ");

    $sqlYears->execute([
        $userId,
        $userId
    ]);

    $years = $sqlYears->fetchAll(PDO::FETCH_COLUMN);


    /*
    |--------------------------------------------------------------------------
    | Always Include Current Year
    |--------------------------------------------------------------------------
    */

    $currentYear = (int) date('Y');

    $years = array_map('intval', $years);

    if (!in_array($currentYear, $years)) {
        $years[] = $currentYear;
    }

    $years = array_unique($years);

    rsort($years);


    /*
    |--------------------------------------------------------------------------
    | TC Monthly Trend
    |--------------------------------------------------------------------------
    */

    $sqlTC = $conn->prepare("
        SELECT
            MONTH(register_date) AS month_no,
            COUNT(*) AS tc_count
        FROM ca_travelagency

        WHERE reference_no = ?
          AND YEAR(register_date) = ?
          AND status IN (1, 3)

        GROUP BY MONTH(register_date)

        ORDER BY MONTH(register_date)
    ");

    $sqlTC->execute([
        $userId,
        $selectedYear
    ]);

    $tcTrend = $sqlTC->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | IBR Monthly Trend
    |--------------------------------------------------------------------------
    */

    $sqlIBR = $conn->prepare("
        SELECT
            MONTH(register_date) AS month_no,
            COUNT(*) AS ibr_count
        FROM institution_branch_manager

        WHERE reference_no = ?
          AND YEAR(register_date) = ?
          AND status IN (1, 3)

        GROUP BY MONTH(register_date)

        ORDER BY MONTH(register_date)
    ");

    $sqlIBR->execute([
        $userId,
        $selectedYear
    ]);

    $ibrTrend = $sqlIBR->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'status' => true,

        'message' => 'TC/IBR trend fetched successfully',

        'data' => [

            'years' => $years,

            'selected_year' => $selectedYear,

            'tc_trend' => $tcTrend,

            'ibr_trend' => $ibrTrend

        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);

}

exit;

?>