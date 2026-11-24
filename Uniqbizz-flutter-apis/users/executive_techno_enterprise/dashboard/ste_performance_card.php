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

        $userId = trim($requestData['userId']);

        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE DATA
        |--------------------------------------------------------------------------
        */

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    ca.corporate_agency_id AS te_id,

                    CONCAT(
                        COALESCE(ca.firstname,''),
                        ' ',
                        COALESCE(ca.lastname,'')
                    ) AS te_name,

                    COUNT(DISTINCT ta.ca_travelagency_id) AS tc_count,

                    COUNT(DISTINCT cu.ca_customer_id) AS cu_count

                FROM corporate_agency ca

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = ca.corporate_agency_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                GROUP BY
                    ca.corporate_agency_id,
                    ca.firstname,
                    ca.lastname

            ) AS combined

            ORDER BY
                cu_count DESC,
                tc_count DESC

            LIMIT 12
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'message' => 'Performance data fetched successfully',
            'data' => $data
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