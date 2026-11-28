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
            ste.super_techno_enterprise_id AS teuser_id,
            ste.firstname,
            ste.lastname,
            ste.contact_no,
            ste.country_code,
            ste.email,
            ste.register_date,
            ste.status,
            ste.user_type,
            DATE_FORMAT(ste.deleted_date, '%d %b %Y') AS deleted_date,
            ete.firstname AS ref_firstname,
            ete.lastname AS ref_lastname,
            ete.executive_techno_enterprise_id

        FROM super_techno_enterprise ste

        INNER JOIN executive_techno_enterprise ete
            ON ste.reference_no = ete.executive_techno_enterprise_id

        WHERE ste.reference_no = :user_id
        AND ste.status IN (1,3)

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
