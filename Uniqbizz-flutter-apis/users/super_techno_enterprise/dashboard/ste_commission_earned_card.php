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
        $requestData = json_decode($json, true);

        if (!$requestData) {
            throw new Exception("Invalid JSON data.");
        }

        if (!isset($requestData['userId']) || empty(trim($requestData['userId']))) {
            throw new Exception("User ID is required.");
        }

        $userId = trim($requestData['userId']);

        $currentYear = date('Y');

        $selectedYear = isset($requestData['selectedYear'])
            ? (int)$requestData['selectedYear']
            : $currentYear;

        /*
        |--------------------------------------------------------------------------
        | SELECTED AND PREVIOUS YEAR
        |--------------------------------------------------------------------------
        */

        $currentYear = $selectedYear;
        $previousYear = $selectedYear - 1;

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
                        SELECT COALESCE(SUM(ste_amount),0)
                        FROM techno_enterprise_payout
                        WHERE ste_id = :user_id
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

                /* Neo Select Commission */
                (
                    SELECT COALESCE(SUM(commision_bm),0)
                    FROM ca_cu_payout
                    WHERE business_mentor = :user_id
                    AND YEAR(created_date)=:current_year
                ) AS neo_select,

                /* Booking Commission */
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
        | PREVIOUS MONTH
        |--------------------------------------------------------------------------
        */

        $sqlPrev = $conn->prepare("

            SELECT

                (
                    (
                        SELECT COALESCE(SUM(ste_amount),0)
                        FROM techno_enterprise_payout
                        WHERE ste_id = :user_id
                        AND YEAR(created_date)=:prev_year
                    )
                    +
                    (
                        SELECT COALESCE(SUM(commission_mf),0)
                        FROM sub_franchisee_payout
                        WHERE master_franchisee = :user_id
                        AND YEAR(created_date)=:prev_year
                    )
                ) AS recruitment,

                (
                    SELECT COALESCE(SUM(commision_bm),0)
                    FROM ca_cu_payout
                    WHERE business_mentor = :user_id
                    AND YEAR(created_date)=:prev_year
                ) AS neo_select,

                (
                    SELECT COALESCE(SUM(bm_amt),0)
                    FROM product_payout
                    WHERE bm_id = :user_id
                    AND YEAR(created_date)=:prev_year
                ) AS booking

        ");

        $sqlPrev->execute([
            ':user_id' => $userId,
            ':prev_year' => $previousYear
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

                'recruitment_commission' => [
                    'amount' => $recruitmentCurrent,
                    // 'percentage' => $recruitmentPercent
                ],

                'holiday_account_activation_commission' => [
                    'amount' => $neoCurrent,
                    // 'percentage' => $neoPercent
                ],

                'tour_booking_commission' => [
                    'amount' => $bookingCurrent,
                    // 'percentage' => $bookingPercent
                ],

                'total_earnings' => $currentTotal,

                // 'month_comparison' => [
                    // Keeping these keys unchanged so your JS doesn't need modification.
                //     'current_month' => $currentTotal,
                //     'previous_month' => $previousTotal,
                //     'growth_percentage' => $growth,
                //     'current_year' => $currentYear,
                //     'previous_year' => $previousYear
                // ]

            ]
        ]);

    } catch (PDOException $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage(),
            'data' => null
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage(),
            'data' => null
        ]);

    }

    exit;
?>