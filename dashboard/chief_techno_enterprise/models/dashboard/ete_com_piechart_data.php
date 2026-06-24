<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $currentMonth = date('m');
        $currentYear  = date('Y');

        $previousMonth = date('m', strtotime('-1 month'));
        $previousYear  = date('Y', strtotime('-1 month'));

        /*
        |--------------------------------------------------------------------------
        | CURRENT MONTH
        |--------------------------------------------------------------------------
        */

        $sql = $conn->prepare("

            SELECT

                /* Recruitment Commission */
                (
                    (
                        SELECT COALESCE(SUM(ete_amount),0)
                        FROM techno_enterprise_payout
                        WHERE cte_id = :user_id
                        AND MONTH(created_date)=:current_month
                        AND YEAR(created_date)=:current_year
                    )
                    +
                    (
                        SELECT COALESCE(SUM(commission_cte),0)
                        FROM sub_franchisee_payout
                        WHERE cte_id = :user_id
                        AND MONTH(created_date)=:current_month
                        AND YEAR(created_date)=:current_year
                    )
                    +
                    (
                        SELECT COALESCE(SUM(commission_emp),0)
                        FROM institution_payout
                        WHERE employees = :user_id
                        AND MONTH(created_date)=:current_month
                        AND YEAR(created_date)=:current_year
                    )
                ) AS recruitment,

                /* Neo Select Commission */
                (
                    SELECT COALESCE(SUM(commision_bdm),0)
                    FROM ca_cu_payout
                    WHERE business_development_manager = :user_id
                    AND MONTH(created_date)=:current_month
                    AND YEAR(created_date)=:current_year
                ) AS neo_select,

                /* Booking Commission */
                (
                    SELECT COALESCE(SUM(bdm_amt),0)
                    FROM product_payout
                    WHERE bdm_id = :user_id
                    AND MONTH(created_date)=:current_month
                    AND YEAR(created_date)=:current_year
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
        | PREVIOUS MONTH
        |--------------------------------------------------------------------------
        */

        $sqlPrev = $conn->prepare("

            SELECT

                (
                    (
                        SELECT COALESCE(SUM(ete_amount),0)
                        FROM techno_enterprise_payout
                        WHERE cte_id = :user_id
                        AND MONTH(created_date)=:prev_month
                        AND YEAR(created_date)=:prev_year
                    )
                    +
                    (
                        SELECT COALESCE(SUM(commission_cte),0)
                        FROM sub_franchisee_payout
                        WHERE cte_id = :user_id
                        AND MONTH(created_date)=:prev_month
                        AND YEAR(created_date)=:prev_year
                    )
                    +
                    (
                        SELECT COALESCE(SUM(commission_emp),0)
                        FROM institution_payout
                        WHERE employees = :user_id
                        AND MONTH(created_date)=:prev_month
                        AND YEAR(created_date)=:prev_year
                    )
                ) AS recruitment,

                (
                    SELECT COALESCE(SUM(commision_bdm),0)
                    FROM ca_cu_payout
                    WHERE business_development_manager = :user_id
                    AND MONTH(created_date)=:prev_month
                    AND YEAR(created_date)=:prev_year
                ) AS neo_select,

                (
                    SELECT COALESCE(SUM(bdm_amt),0)
                    FROM product_payout
                    WHERE bdm_id = :user_id
                    AND MONTH(created_date)=:prev_month
                    AND YEAR(created_date)=:prev_year
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
        | TOTALS
        |--------------------------------------------------------------------------
        */

        $recruitmentCurrent = (float)$current['recruitment'];
        $neoCurrent         = (float)$current['neo_select'];
        $bookingCurrent     = (float)$current['booking'];

        $recruitmentPrev = (float)$previous['recruitment'];
        $neoPrev         = (float)$previous['neo_select'];
        $bookingPrev     = (float)$previous['booking'];

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
        | PERCENTAGES FOR DONUT CHART
        |--------------------------------------------------------------------------
        */

        $recruitmentPercent = $currentTotal > 0
            ? round(($recruitmentCurrent / $currentTotal) * 100, 1)
            : 0;

        $neoPercent = $currentTotal > 0
            ? round(($neoCurrent / $currentTotal) * 100, 1)
            : 0;

        $bookingPercent = $currentTotal > 0
            ? round(($bookingCurrent / $currentTotal) * 100, 1)
            : 0;



        /*
        |--------------------------------------------------------------------------
        | MONTH OVER MONTH GROWTH
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
                    'current_month' => $currentTotal,
                    'previous_month' => $previousTotal,
                    'growth_percentage' => $growth
                ]

            ]
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>