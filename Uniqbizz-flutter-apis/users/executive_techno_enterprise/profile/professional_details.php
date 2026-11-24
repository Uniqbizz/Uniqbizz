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

$sqlUserDetails = $conn->prepare("
        SELECT
            pro.current_occupation,
            pro.current_experience,
            pro.current_income
        FROM professional_and_educational pro
        INNER JOIN super_techno_enterprise ste
            ON pro.application_id = ste.application_id
        WHERE ste.super_techno_enterprise_id = :user_id
        LIMIT 1
    ");

    $sqlUserDetails->execute([
        ':user_id' => $userId
    ]);

    $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

    if ($userDetails) {

        echo json_encode([
            'status' => true,
            'data'   => [
                'current_occupation' => $userDetails['current_occupation'] ?? '',
                'current_experience' => $userDetails['current_experience'] ?? '',
                'current_income'     => $userDetails['current_income'] ?? ''
            ]
        ]);

    } else {

        echo json_encode([
            'status'  => false,
            'message' => 'User not found'
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        'status'  => false,
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
