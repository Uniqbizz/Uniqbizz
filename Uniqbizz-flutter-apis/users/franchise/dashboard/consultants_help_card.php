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
    | Inactive Travel Consultants
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT

            ca.ca_travelagency_id AS tc_id,

            CONCAT(
                COALESCE(ca.firstname,''),
                ' ',
                COALESCE(ca.lastname,'')
            ) AS tc_name,

            MAX(cu.register_date) AS last_customer_date,

            DATEDIFF(CURDATE(), MAX(cu.register_date)) AS inactive_days

        FROM ca_travelagency ca

        LEFT JOIN ca_customer cu
            ON cu.ta_reference_no = ca.ca_travelagency_id
            AND cu.status IN (1,3)

        WHERE ca.reference_no = :user_id
        AND ca.status IN (1,3)

        GROUP BY
            ca.ca_travelagency_id,
            ca.firstname,
            ca.lastname

        HAVING
            (
                MAX(cu.register_date) IS NULL
                OR DATEDIFF(CURDATE(), MAX(cu.register_date)) >= 15
            )

        ORDER BY
            inactive_days DESC

        LIMIT 6
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "message" => "Inactive travel consultants fetched successfully.",
        "data" => $result
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}