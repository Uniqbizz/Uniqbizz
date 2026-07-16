<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

$currentYear = date('Y');

$selectedYear = isset($_POST['selectedYear'])
    ? (int)$_POST['selectedYear']
    : $currentYear;

try {

    $currentYear = $selectedYear;
    $previousYear = $selectedYear - 1;

    /*
    |--------------------------------------------------------------------------
    | CURRENT YEAR
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("

        SELECT

        (
            (
                SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                FROM institution_payout
                WHERE bm_mf_sf = :user_id
                AND YEAR(created_date)=:current_year
            )

            +

            (
                SELECT COALESCE(SUM(commission_mf),0)
                FROM sub_franchisee_payout
                WHERE master_franchisee = :user_id
                AND YEAR(created_date)=:current_year
            )

        ) AS recruitment,

        (

            SELECT COALESCE(SUM(commision_bm),0)

            FROM ca_cu_payout

            WHERE business_mentor = :user_id

            AND YEAR(created_date)=:current_year

        ) AS neo_select,

        (

            SELECT COALESCE(SUM(bm_amt),0)

            FROM product_payout

            WHERE bm_id = :user_id

            AND YEAR(created_date)=:current_year

        ) AS booking

    ");

    $sql->execute([
        ':user_id' => $userId,
        ':current_year' => $currentYear
    ]);

    $current = $sql->fetch(PDO::FETCH_ASSOC);



    /*
    |--------------------------------------------------------------------------
    | PREVIOUS YEAR
    |--------------------------------------------------------------------------
    */

    $sqlPrev = $conn->prepare("

        SELECT

        (
            (
                SELECT COALESCE(SUM(commission_bm_mf_sf),0)
                FROM institution_payout
                WHERE bm_mf_sf = :user_id
                AND YEAR(created_date)=:previous_year
            )

            +

            (
                SELECT COALESCE(SUM(commission_mf),0)
                FROM sub_franchisee_payout
                WHERE master_franchisee = :user_id
                AND YEAR(created_date)=:previous_year
            )

        ) AS recruitment,

        (

            SELECT COALESCE(SUM(commision_bm),0)

            FROM ca_cu_payout

            WHERE business_mentor = :user_id

            AND YEAR(created_date)=:previous_year

        ) AS neo_select,

        (

            SELECT COALESCE(SUM(bm_amt),0)

            FROM product_payout

            WHERE bm_id = :user_id

            AND YEAR(created_date)=:previous_year

        ) AS booking

    ");

    $sqlPrev->execute([
        ':user_id' => $userId,
        ':previous_year' => $previousYear
    ]);

    $previous = $sqlPrev->fetch(PDO::FETCH_ASSOC);



    /*
    |--------------------------------------------------------------------------
    | TOTALS
    |--------------------------------------------------------------------------
    */

    $recruitmentCurrent = (float)$current['recruitment'];
    $neoCurrent = (float)$current['neo_select'];
    $bookingCurrent = (float)$current['booking'];

    $recruitmentPrev = (float)$previous['recruitment'];
    $neoPrev = (float)$previous['neo_select'];
    $bookingPrev = (float)$previous['booking'];

    $currentTotal =
        $recruitmentCurrent +
        $neoCurrent +
        $bookingCurrent;

    $previousTotal =
        $recruitmentPrev +
        $neoPrev +
        $bookingPrev;



    /*
    |--------------------------------------------------------------------------
    | PERCENTAGES
    |--------------------------------------------------------------------------
    */

    $recruitmentPercent = ($currentTotal > 0)
        ? round(($recruitmentCurrent / $currentTotal) * 100, 1)
        : 0;

    $neoPercent = ($currentTotal > 0)
        ? round(($neoCurrent / $currentTotal) * 100, 1)
        : 0;

    $bookingPercent = ($currentTotal > 0)
        ? round(($bookingCurrent / $currentTotal) * 100, 1)
        : 0;



    /*
    |--------------------------------------------------------------------------
    | YEAR OVER YEAR GROWTH
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

        'status' => true,

        'message' => 'Commission data fetched successfully',

        'data' => [

            'recruitment' => [

                'amount' => $recruitmentCurrent,

                'percentage' => $recruitmentPercent

            ],

            'neo_select' => [

                'amount' => $neoCurrent,

                'percentage' => $neoPercent

            ],

            'booking' => [

                'amount' => $bookingCurrent,

                'percentage' => $bookingPercent

            ],

            'total_earnings' => $currentTotal,

            'month_comparison' => [

                // Keeping these keys unchanged so your JS doesn't need modification.
                'current_month' => $currentTotal,
                'previous_month' => $previousTotal,
                'growth_percentage' => $growth,
                'current_year' => $currentYear,
                'previous_year' => $previousYear

            ]

        ]

    ]);

} catch (Exception $e) {

    echo json_encode([

        'status' => false,

        'message' => $e->getMessage()

    ]);

}