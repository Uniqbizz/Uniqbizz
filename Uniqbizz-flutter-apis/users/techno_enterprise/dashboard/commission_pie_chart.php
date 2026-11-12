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

    /*
    |--------------------------------------------------------------------------
    | Read JSON Request
    |--------------------------------------------------------------------------
    */

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    /*
    |--------------------------------------------------------------------------
    | Validate User ID
    |--------------------------------------------------------------------------
    */

    if (!isset($data['userId']) || empty(trim($data['userId']))) {
        throw new Exception("User ID is required.");
    }

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | Validate Selected Year
    |--------------------------------------------------------------------------
    */

    if (!isset($data['selectedYear']) || $data['selectedYear'] === '') {
        throw new Exception("Selected year is required.");
    }

    $selectedYear = (int)$data['selectedYear'];

    /*
    |--------------------------------------------------------------------------
    | Selected Year
    |--------------------------------------------------------------------------
    */

    $currentYear = $selectedYear;
    $previousYear = $selectedYear - 1;

    /*
    |--------------------------------------------------------------------------
    | Current Year Earnings
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT

            /* Neo Select Commission */
            (
                SELECT COALESCE(SUM(commision_te), 0)
                FROM ca_cu_payout
                WHERE techno_enterprise = :user_id
                AND YEAR(created_date) = :current_year
            ) AS neo_select,

            /* Booking Commission */
            (
                SELECT COALESCE(SUM(te_amt), 0)
                FROM product_payout
                WHERE te_id = :user_id
                AND YEAR(created_date) = :current_year
            ) AS booking
    ");

    $sql->execute([
        ':user_id'      => $userId,
        ':current_year' => $currentYear
    ]);

    $current = $sql->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Previous Year Earnings
    |--------------------------------------------------------------------------
    */

    $sqlPrev = $conn->prepare("
        SELECT

            /* Neo Select Commission */
            (
                SELECT COALESCE(SUM(commision_te), 0)
                FROM ca_cu_payout
                WHERE techno_enterprise = :user_id
                AND YEAR(created_date) = :previous_year
            ) AS neo_select,

            /* Booking Commission */
            (
                SELECT COALESCE(SUM(te_amt), 0)
                FROM product_payout
                WHERE te_id = :user_id
                AND YEAR(created_date) = :previous_year
            ) AS booking
    ");

    $sqlPrev->execute([
        ':user_id'       => $userId,
        ':previous_year' => $previousYear
    ]);

    $previous = $sqlPrev->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    $neoCurrent = (float)$current['neo_select'];
    $bookingCurrent = (float)$current['booking'];

    $neoPrevious = (float)$previous['neo_select'];
    $bookingPrevious = (float)$previous['booking'];

    $currentTotal =
        $neoCurrent +
        $bookingCurrent;

    $previousTotal =
        $neoPrevious +
        $bookingPrevious;

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
    | Year-over-Year Growth
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

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        "status" => true,
        "message" => "Commission data fetched successfully.",
        "data" => [

            "holiday_account_activation_commission" => [
                "amount" => $neoCurrent,
                "percentage" => $neoPercent
            ],

            "tour_booking_commission" => [
                "amount" => $bookingCurrent,
                "percentage" => $bookingPercent
            ],

            "total_earnings" => $currentTotal,

            // "month_comparison" => [
            //     "current_month" => $currentTotal,
            //     "previous_month" => $previousTotal,
            //     "growth_percentage" => $growth,
            //     "current_year" => $currentYear,
            //     "previous_year" => $previousYear
            // ]
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}

?>