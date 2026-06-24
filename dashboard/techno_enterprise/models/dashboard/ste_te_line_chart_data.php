<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $selectedYear = !empty($_POST['year'])
            ? (int)$_POST['year']
            : date('Y');

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

        if (!in_array($currentYear, $years)) {
            $years[] = $currentYear;
        }

        $years = array_unique($years);
        rsort($years);

        /*
        |--------------------------------------------------------------------------
        | TE Trend
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

        $tcTrend = $sqlTrend->fetchAll(PDO::FETCH_ASSOC);

        

        echo json_encode([
            'status' => true,
            'message' => 'TC trend fetched successfully',
            'data' => [
                'years'         => $years,
                'selected_year' => $selectedYear,
                'tc_trend'      => $tcTrend
            ]
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage()
        ]);
    }