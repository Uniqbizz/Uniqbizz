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
        | JSON INPUT VALIDATION
        |--------------------------------------------------------------------------
        */

        $json = file_get_contents("php://input");
        $requestData = json_decode($json, true);

        if (!$requestData || !is_array($requestData)) {
            throw new Exception("Invalid JSON data.");
        }

        if (
            !isset($requestData['userId']) ||
            !is_string($requestData['userId']) ||
            trim($requestData['userId']) === ''
        ) {
            throw new Exception("User ID is required.");
        }

        if (
            !isset($requestData['year']) ||
            $requestData['year'] === ''
        ) {
            throw new Exception("Year is required.");
        }

        if (
            !is_numeric($requestData['year']) ||
            (int)$requestData['year'] <= 0 ||
            (string)(int)$requestData['year'] !== (string)$requestData['year']
        ) {
            throw new Exception("Invalid year.");
        }

        $userId = trim($requestData['userId']);
        $selectedYear = (int)$requestData['year'];

        $currentYear = (int)date('Y');

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER AVAILABLE YEARS
        |--------------------------------------------------------------------------
        */

        $sqlCustomerYears = $conn->prepare("
            SELECT YEAR(cu.register_date) AS year
            FROM ca_customer cu
            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id
            INNER JOIN corporate_agency corp
                ON ta.reference_no = corp.corporate_agency_id
            WHERE corp.reference_no = :user_id
            AND cu.status IN (1,3)
            AND ta.status IN (1,3)
            AND corp.status IN (1,3)

            UNION

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

            ORDER BY year DESC
        ");

        $sqlCustomerYears->execute([
            ':user_id' => $userId
        ]);

        $customerYears = $sqlCustomerYears->fetchAll(PDO::FETCH_COLUMN);

        /*
        |--------------------------------------------------------------------------
        | TE / SF AVAILABLE YEARS
        |--------------------------------------------------------------------------
        */

        $sqlYears = $conn->prepare("
            SELECT DISTINCT year
            FROM (
                SELECT YEAR(ca.register_date) AS year
                FROM corporate_agency ca
                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                UNION

                SELECT YEAR(sf.register_date) AS year
                FROM sub_franchisee sf
                WHERE sf.reference_no = :user_id
                AND sf.status IN (1,3)
            ) years_data
            ORDER BY year DESC
        ");

        $sqlYears->execute([
            ':user_id' => $userId
        ]);

        $teSfYears = $sqlYears->fetchAll(PDO::FETCH_COLUMN);

        /*
        |--------------------------------------------------------------------------
        | COMBINED AVAILABLE YEARS
        |--------------------------------------------------------------------------
        */

        $years = array_map(
            'intval',
            array_merge($customerYears, $teSfYears)
        );

        if (!in_array($currentYear, $years)) {
            $years[] = $currentYear;
        }

        $years = array_values(array_unique($years));
        rsort($years);

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER TREND FOR SELECTED YEAR
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
                INNER JOIN corporate_agency corp
                    ON ta.reference_no = corp.corporate_agency_id
                WHERE corp.reference_no = :user_id
                AND YEAR(cu.register_date) = :selected_year
                AND cu.status IN (1,3)
                AND ta.status IN (1,3)
                AND corp.status IN (1,3)

                UNION ALL

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

        /*
        |--------------------------------------------------------------------------
        | TE TREND
        |--------------------------------------------------------------------------
        */

        $sqlTrend = $conn->prepare("
            SELECT
                MONTH(register_date) AS month_no,
                COUNT(*) AS te_count
            FROM corporate_agency
            WHERE reference_no = :user_id
            AND YEAR(register_date) = :year
            AND status IN (1,3)
            GROUP BY MONTH(register_date)
            ORDER BY MONTH(register_date)
        ");

        $sqlTrend->execute([
            ':user_id' => $userId,
            ':year' => $selectedYear
        ]);

        $teTrend = $sqlTrend->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | SF TREND
        |--------------------------------------------------------------------------
        */

        $sqlSFTrend = $conn->prepare("
            SELECT
                MONTH(register_date) AS month_no,
                COUNT(*) AS sf_count
            FROM sub_franchisee
            WHERE reference_no = :user_id
            AND YEAR(register_date) = :year
            AND status IN (1,3)
            GROUP BY MONTH(register_date)
            ORDER BY MONTH(register_date)
        ");

        $sqlSFTrend->execute([
            ':user_id' => $userId,
            ':year' => $selectedYear
        ]);

        $sfTrend = $sqlSFTrend->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | COMBINED RESPONSE
        |--------------------------------------------------------------------------
        */

        echo json_encode([
            'status' => true,
            'message' => 'Customer and TE / SF trends fetched successfully',
            'data' => [
                'years' => $years,
                'selected_year' => $selectedYear,
                'customer_trend' => $customerTrend,
                'te_trend' => $teTrend,
                'sf_trend' => $sfTrend
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