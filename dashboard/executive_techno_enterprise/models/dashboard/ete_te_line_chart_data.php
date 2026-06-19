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
                FROM corporate_agency ca
                INNER JOIN super_techno_enterprise st
                    ON ca.reference_no = st.super_techno_enterprise_id
                WHERE st.reference_no = :user_id
                AND ca.status IN (1,3)
                AND st.status IN (1,3)

                UNION

                SELECT YEAR(sf.register_date) AS year
                FROM sub_franchisee sf
                INNER JOIN super_techno_enterprise st
                    ON sf.reference_no = st.super_techno_enterprise_id
                WHERE st.reference_no = :user_id
                AND sf.status IN (1,3)
                AND st.status IN (1,3)
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
                MONTH(ca.register_date) AS month_no,
                COUNT(*) AS te_count
            FROM corporate_agency ca
            INNER JOIN super_techno_enterprise st
                ON ca.reference_no = st.super_techno_enterprise_id
            WHERE st.reference_no = :user_id
            AND YEAR(ca.register_date) = :year
            AND ca.status IN (1,3)
            AND st.status IN (1,3)
            GROUP BY MONTH(ca.register_date)
            ORDER BY MONTH(ca.register_date)
        ");

        $sqlTrend->execute([
            ':user_id' => $userId,
            ':year'    => $selectedYear
        ]);

        $teTrend = $sqlTrend->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | SF Trend
        |--------------------------------------------------------------------------
        */

        $sqlSFTrend = $conn->prepare("
            SELECT
                MONTH(ca.register_date) AS month_no,
                COUNT(*) AS sf_count
            FROM sub_franchisee ca
            INNER JOIN super_techno_enterprise st
                ON ca.reference_no = st.super_techno_enterprise_id
            WHERE st.reference_no = :user_id
            AND YEAR(ca.register_date) = :year
            AND ca.status IN (1,3)
            AND st.status IN (1,3)
            GROUP BY MONTH(ca.register_date)
            ORDER BY MONTH(ca.register_date)
        ");

        $sqlSFTrend->execute([
            ':user_id' => $userId,
            ':year'    => $selectedYear
        ]);

        $sfTrend = $sqlSFTrend->fetchAll(PDO::FETCH_ASSOC);
        /*
        |--------------------------------------------------------------------------
        | I Trend
        |--------------------------------------------------------------------------
        */

        $sqlITrend = $conn->prepare("
            SELECT
                MONTH(register_date) AS month_no,
                COUNT(*) AS i_count
            FROM institution 
            WHERE reference_no = :user_id
            AND YEAR(register_date) = :year
            AND status IN (1,3)
            GROUP BY MONTH(register_date)
            ORDER BY MONTH(register_date)
        ");

        $sqlITrend->execute([
            ':user_id' => $userId,
            ':year'    => $selectedYear
        ]);

        $iTrend = $sqlITrend->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'message' => 'TE / SF / I trend fetched successfully',
            'data' => [
                'years'         => $years,
                'selected_year' => $selectedYear,
                'te_trend'      => $teTrend,
                'sf_trend'      => $sfTrend,
                'i_trend'       => $iTrend
            ]
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage()
        ]);
    }