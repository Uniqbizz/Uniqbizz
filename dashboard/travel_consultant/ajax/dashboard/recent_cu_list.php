<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    /*
    |--------------------------------------------------------------------------
    | Customer Details
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
            ca_customer_id,
            CONCAT(firstname, ' ', lastname) AS cust_name,
            CONCAT('+', country_code, contact_no) AS phone,
            CASE
                WHEN status = 2 THEN added_on
                ELSE register_date
            END AS register_date,
            CASE
                WHEN status = 0 THEN 'Deleted'
                WHEN status = 1 THEN 'Active'
                WHEN status = 2 THEN 'Pending'
                WHEN status = 3 THEN 'Deactive'
                ELSE 'Unknown'
            END AS status
        FROM ca_customer
        WHERE ta_reference_no = :userId
        ORDER BY register_date DESC
        LIMIT 3
    ");

    $sql->execute([
        ':userId' => $userId
    ]);

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'data'   => $result
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data'    => []
    ]);

}