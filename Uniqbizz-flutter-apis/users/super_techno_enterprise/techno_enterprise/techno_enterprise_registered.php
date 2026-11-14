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
    | FETCH DATA
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT
            ca.corporate_agency_id AS teuser_id,
            ca.firstname,
            ca.lastname,
            ca.contact_no,
            ca.email,
            ca.register_date,
            ca.status,
            ca.amount,
            ca.user_type,
            DATE_FORMAT(ca.deleted_date, '%d %b %Y') AS deleted_date,
            ste.firstname AS ref_firstname,
            ste.lastname AS ref_lastname,
            ste.super_techno_enterprise_id

        FROM corporate_agency ca

        INNER JOIN super_techno_enterprise ste
            ON ca.reference_no = ste.super_techno_enterprise_id

        WHERE ca.reference_no = :user_id
        AND ca.status IN (1,3)

        ORDER BY register_date DESC
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',
        'data' => $data
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);

}

exit;

?>
