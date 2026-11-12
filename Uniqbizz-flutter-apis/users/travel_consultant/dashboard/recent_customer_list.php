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
    | Customer Details
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
    ca_customer.*,

    CONCAT(firstname, ' ', lastname) AS cust_name,

    CONCAT('+', country_code, contact_no) AS phone,

    CASE
        WHEN status = 2 THEN added_on
        ELSE register_date
    END AS display_register_date,

    CASE
        WHEN status = 0 THEN 'Deleted'
        WHEN status = 1 THEN 'Active'
        WHEN status = 2 THEN 'Pending'
        WHEN status = 3 THEN 'Deactive'
        ELSE 'Unknown'
    END AS display_status

    FROM ca_customer

    WHERE ta_reference_no = :userId

    ORDER BY
        CASE
            WHEN status = 2 THEN added_on
            ELSE register_date
        END DESC

    LIMIT 3;
    ");

    $sql->execute([
        ':userId' => $userId
    ]);

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "message" => "Customer details fetched successfully.",
        "data" => $result
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}