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
        SELECT DISTINCT year
        FROM (
            SELECT YEAR(ca.register_date) AS year
            FROM ca_travelagency ca
            WHERE ca.reference_no = :user_id
            AND ca.status IN (1,3)
        ) years_data
        ORDER BY year DESC
    ");

    $sqlYears->execute([
        ':user_id' => $userId
    ]);

    $years = $sqlYears->fetchAll(PDO::FETCH_COLUMN);

    $currentYear = (int)date('Y');

    $years = array_map('intval', $years);

    if (!in_array($currentYear, $years)) {
        $years[] = $currentYear;
    }

    $years = array_unique($years);
    rsort($years);

    /*
    |--------------------------------------------------------------------------
    | TC Trend
    |--------------------------------------------------------------------------
    */

    $sqlTrend = $conn->prepare("
        SELECT
            MONTH(register_date) AS month_no,
            COUNT(*) AS tc_count
        FROM ca_travelagency
        WHERE reference_no = :user_id
        AND YEAR(register_date) = :year
        AND status IN (1,3)
        GROUP BY MONTH(register_date)
        ORDER BY MONTH(register_date)
    ");

    $sqlTrend->execute([
        ':user_id' => $userId,
        ':year'    => $selectedYear
    ]);

    $tcTrendData = $sqlTrend->fetchAll(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Monthly Trend (Jan-Dec)
    |--------------------------------------------------------------------------
    */

    $tcTrend = array_fill(0, 12, 0);

    foreach ($tcTrendData as $item) {
        $month = (int)$item['month_no']; // 1-12
        $tcTrend[$month - 1] = (int)$item['tc_count'];
    }

    echo json_encode([
        "status" => true,
        "message" => "TC trend fetched successfully.",
        "data" => [
            "selectedYear" => $selectedYear,
            "chartData" => $tcTrend
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