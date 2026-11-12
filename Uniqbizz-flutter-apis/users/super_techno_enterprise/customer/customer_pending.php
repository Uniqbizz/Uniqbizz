
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
        SELECT *
        FROM (

            SELECT
                cu.id,
                cu.ca_customer_id,
                cu.firstname,
                cu.lastname,
                cu.contact_no,
                cu.email,
                cu.added_on,
                cu.status,
                DATE_FORMAT(cu.deleted_date, '%d %b %Y') AS deleted_date,
                ta.ca_travelagency_id,
                ta.firstname AS ref_firstname,
                ta.lastname AS ref_lastname,

                'TE' AS ref_type

            FROM ca_customer cu

            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ca.reference_no = :user_id
            AND cu.status IN (0,2,4)

        ) x

        ORDER BY x.id DESC
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'CU data fetched successfully',
        'data'    => $data
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data'    => []
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data'    => []
    ]);
}

exit;
?>
