<?php

include_once(__DIR__.'/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $selectedYear = isset($_POST['year']) && $_POST['year'] != ''
        ? (int)$_POST['year']
        : date('Y');

    /*
    |--------------------------------------------------------------------------
    | Available Years
    |--------------------------------------------------------------------------
    */

    $sqlYears = $conn->prepare("
        
        SELECT YEAR(cu.register_date) AS year
        FROM ca_customer cu
        INNER JOIN ca_travelagency ta
            ON cu.ta_reference_no = ta.ca_travelagency_id
        INNER JOIN sub_franchisee sf
            ON ta.reference_no = sf.sub_franchisee_id
        WHERE sf.reference_no = :user_id
        AND cu.status IN (1,3)
        AND ta.status IN (1,3)
        AND sf.status IN (1,3)

        UNION

        SELECT YEAR(cu.register_date) AS year
        FROM ca_customer cu
        INNER JOIN institution_branch_manager ta
            ON cu.ta_reference_no = ta.institution_branch_manager_id
        INNER JOIN institution sf
            ON ta.reference_no = sf.institution_id
        WHERE sf.reference_no = :user_id
        AND cu.status IN (1,3)
        AND ta.status IN (1,3)
        AND sf.status IN (1,3)

        ORDER BY year DESC;
    ");

    $sqlYears->execute([
        ':user_id' => $userId
    ]);

    $years = $sqlYears->fetchAll(PDO::FETCH_COLUMN);

    /*
    |--------------------------------------------------------------------------
    | Customer Trend For Selected Year
    |--------------------------------------------------------------------------
    */

    $sqlCustomerTrend = $conn->prepare("
        SELECT
        MONTH(register_date) AS month,
        COUNT(*) AS total
        FROM (

            SELECT cu.register_date
            FROM ca_customer cu
            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id
            INNER JOIN sub_franchisee sf
                ON ta.reference_no = sf.sub_franchisee_id
            WHERE sf.reference_no = :user_id
            AND YEAR(cu.register_date) = :selected_year
            AND cu.status IN (1,3)
            AND ta.status IN (1,3)

            UNION ALL

            SELECT cu.register_date
            FROM ca_customer cu
            INNER JOIN institution_branch_manager ta
                ON cu.ta_reference_no = ta.institution_branch_manager_id
            INNER JOIN institution sf
                ON ta.reference_no = sf.institution_id
            WHERE sf.reference_no = :user_id
            AND YEAR(cu.register_date) = :selected_year
            AND cu.status IN (1,3)
            AND ta.status IN (1,3)
            AND sf.status IN (1,3)
        ) x
        GROUP BY MONTH(register_date)
        ORDER BY MONTH(register_date)
    ");

    $sqlCustomerTrend->execute([
        ':user_id' => $userId,
        ':selected_year' => $selectedYear
    ]);

    $customerTrend = $sqlCustomerTrend->fetchAll(PDO::FETCH_ASSOC);
    $currentYear = (int)date('Y');

    /*
    |--------------------------------------------------------------------------
    | Always include current year
    |--------------------------------------------------------------------------
    */

    $years = array_map('intval', $years);

    if (!in_array($currentYear, $years)) {
        $years[] = $currentYear;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove duplicates & sort DESC
    |--------------------------------------------------------------------------
    */

    $years = array_unique($years);

    rsort($years);
    echo json_encode([
        'status' => true,
        'message' => 'Customer trend fetched successfully',
        'data' => [
            'years' => $years,
            'selected_year' => $selectedYear,
            'customer_trend' => $customerTrend
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}

exit;