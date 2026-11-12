<?php

require '../../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method.",
        "data" => []
    ]);
    exit;
}

try {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    if (!isset($data['userId']) || empty(trim($data['userId']))) {
        throw new Exception("User ID is required.");
    }

    if (!isset($data['year']) || empty(trim((string)$data['year']))) {
        throw new Exception("Year is required.");
    }

    $userId = trim($data['userId']);
    $selectedYear = (int)$data['year'];

    /*
    |--------------------------------------------------------------------------
    | Available Years
    |--------------------------------------------------------------------------
    */

    $sqlYears = $conn->prepare("
        SELECT DISTINCT YEAR(cu.register_date) AS year
        FROM ca_customer cu
        INNER JOIN ca_travelagency ta
            ON cu.ta_reference_no = ta.ca_travelagency_id
        WHERE ta.reference_no = :user_id
        AND cu.status IN (1,3)
        AND ta.status IN (1,3)
        ORDER BY year DESC
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
            WHERE ta.reference_no = :user_id
            AND YEAR(cu.register_date) = :selected_year
            AND cu.status IN (1,3)
            AND ta.status IN (1,3)
        ) x
        GROUP BY MONTH(register_date)
        ORDER BY MONTH(register_date)
    ");

    $sqlCustomerTrend->execute([
        ':user_id' => $userId,
        ':selected_year' => $selectedYear
    ]);

   $customerTrendData = $sqlCustomerTrend->fetchAll(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Always Include Current Year
    |--------------------------------------------------------------------------
    */

    $currentYear = (int)date('Y');

    $years = array_map('intval', $years);

    if (!in_array($currentYear, $years)) {
        $years[] = $currentYear;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Duplicates & Sort Descending
    |--------------------------------------------------------------------------
    */

    $years = array_unique($years);
    rsort($years);

    /*
    |--------------------------------------------------------------------------
    | Type Casting
    |--------------------------------------------------------------------------
    */

    // Initialise all 12 months with 0
    $customerTrend = array_fill(0, 12, 0);

    // Fill the months that have data
    foreach ($customerTrendData as $item) {
        $month = (int)$item['month']; // 1-12
        $customerTrend[$month - 1] = (int)$item['total'];
    }

    echo json_encode([
        "status" => true,
        "message" => "Customer trend fetched successfully.",
        "data" => [
            "selectedYear" => $selectedYear,
            "chartData" => $customerTrend
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}

exit;