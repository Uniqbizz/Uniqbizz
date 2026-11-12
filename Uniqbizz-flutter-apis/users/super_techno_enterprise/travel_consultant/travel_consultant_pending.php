
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
    | FETCH TC DATA
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT *
        FROM (

            SELECT
                ta.id,
                ta.ca_travelagency_id,
                ta.firstname,
                ta.lastname,
                ta.contact_no,
                ta.email,
                ta.added_on,
                ta.status,
                DATE_FORMAT(ta.deleted_date, '%d %b %Y') AS deleted_date,
                ca.corporate_agency_id AS reference_id,
                ca.firstname AS ref_firstname,
                ca.lastname AS ref_lastname

            FROM ca_travelagency ta

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ca.reference_no = :user_id
            AND ta.status IN (0,2,4)

        ) AS combined

        ORDER BY id DESC
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'TC data fetched successfully',
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

/*
|--------------------------------------------------------------------------
| UNION ALL - SUB FRANCHISEE (UNCHANGED / INACTIVE)
|--------------------------------------------------------------------------
*/

// UNION ALL

// SELECT
//     ta.id,
//     ta.ca_travelagency_id,
//     ta.firstname,
//     ta.lastname,
//     ta.contact_no,
//     ta.email,
//     ta.added_on,
//     ta.status,
//
//     ca.sub_franchisee_id AS reference_id,
//     ca.firstname AS ref_firstname,
//     ca.lastname AS ref_lastname
//
// FROM ca_travelagency ta
//
// INNER JOIN sub_franchisee ca
//     ON ta.reference_no = ca.sub_franchisee_id
//
// WHERE ca.reference_no = :user_id
// AND ta.status IN (0,2,4)

?>
