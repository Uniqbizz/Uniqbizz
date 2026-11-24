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

$sql = $conn->prepare("
        SELECT
            nd.nominee_name,
            nd.nominee_relation,
            nd.nominee_contact_cd,
            nd.nominee_contact_no,
            nd.nominee_date_of_birth,
            nd.nominee_address
        FROM nominee_details nd
        INNER JOIN super_techno_enterprise ste
            ON ste.application_id = nd.application_id
        WHERE ste.super_techno_enterprise_id = :user_id
        LIMIT 1
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    if ($data) {

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Nominee details not found'
        ]);
    }

} catch(PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}

catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data' => null
    ]);

}

exit;

?>
