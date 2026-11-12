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

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | Current & Previous Month
    |--------------------------------------------------------------------------
    */

    $currentMonth = date('m');
    $currentYear  = date('Y');

    $previousMonth = date('m', strtotime('-1 month'));
    $previousYear  = date('Y', strtotime('-1 month'));

    /*
    |--------------------------------------------------------------------------
    | Current Month Earnings
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT

            (
                SELECT COALESCE(SUM(commision_te),0)
                FROM ca_cu_payout
                WHERE techno_enterprise = :user_id
                AND MONTH(created_date) = :current_month
                AND YEAR(created_date) = :current_year
            ) AS neo_select,

            (
                SELECT COALESCE(SUM(te_amt),0)
                FROM product_payout
                WHERE te_id = :user_id
                AND MONTH(created_date) = :current_month
                AND YEAR(created_date) = :current_year
            ) AS booking
    ");

    $sql->execute([
        ':user_id'       => $userId,
        ':current_month' => $currentMonth,
        ':current_year'  => $currentYear
    ]);

    $current = $sql->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Previous Month Earnings
    |--------------------------------------------------------------------------
    */

    $sqlPrev = $conn->prepare("
        SELECT

            (
                SELECT COALESCE(SUM(commision_te),0)
                FROM ca_cu_payout
                WHERE techno_enterprise = :user_id
                AND MONTH(created_date) = :prev_month
                AND YEAR(created_date) = :prev_year
            ) AS neo_select,

            (
                SELECT COALESCE(SUM(te_amt),0)
                FROM product_payout
                WHERE te_id = :user_id
                AND MONTH(created_date) = :prev_month
                AND YEAR(created_date) = :prev_year
            ) AS booking
    ");

    $sqlPrev->execute([
        ':user_id'    => $userId,
        ':prev_month' => $previousMonth,
        ':prev_year'  => $previousYear
    ]);

    $previous = $sqlPrev->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    $neoCurrent     = (float)$current['neo_select'];
    $bookingCurrent = (float)$current['booking'];

    $neoPrev        = (float)$previous['neo_select'];
    $bookingPrev    = (float)$previous['booking'];

    $currentTotal =
        $neoCurrent +
        $bookingCurrent;

    $previousTotal =
        $neoPrev +
        $bookingPrev;

    /*
    |--------------------------------------------------------------------------
    | Donut Chart Percentages
    |--------------------------------------------------------------------------
    */

    $neoPercent = $currentTotal > 0
        ? round(($neoCurrent / $currentTotal) * 100, 1)
        : 0;

    $bookingPercent = $currentTotal > 0
        ? round(($bookingCurrent / $currentTotal) * 100, 1)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Month-over-Month Growth
    |--------------------------------------------------------------------------
    */

    $growth = 0;

    if ($previousTotal > 0) {

        $growth = round(
            (($currentTotal - $previousTotal) / $previousTotal) * 100,
            2
        );

    } elseif ($currentTotal > 0) {

        $growth = 100;
    }

    echo json_encode([
        "status" => true,
        "message" => "Commission data fetched successfully.",
        "data" => [

            "neo_select" => [
                "amount" => $neoCurrent,
                "percentage" => $neoPercent
            ],

            "booking" => [
                "amount" => $bookingCurrent,
                "percentage" => $bookingPercent
            ],

            "total_earnings" => $currentTotal,

            "month_comparison" => [
                "current_month" => $currentTotal,
                "previous_month" => $previousTotal,
                "growth_percentage" => $growth
            ]
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}