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

    $sql = $conn->prepare("
        SELECT
            ste.id,
            ste.firstname,
            ste.lastname,
            ste.contact_no,
            ste.country_code,
            ste.email,
            ste.added_on,
            ste.status,
            ste.user_type,
            'STE' AS user_type_str,
            DATE_FORMAT(ste.deleted_date, '%d %b %Y') AS deleted_date,
            ete.firstname AS ref_firstname,
            ete.lastname AS ref_lastname,
            ete.executive_techno_enterprise_id,

            'super_techno_enterprise' AS source_table

        FROM super_techno_enterprise ste

        INNER JOIN executive_techno_enterprise ete
            ON ste.reference_no = ete.executive_techno_enterprise_id

        WHERE ste.reference_no = :user_id
        AND ste.status IN (0,2,4)

        ORDER BY id DESC
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

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

/*
|--------------------------------------------------------------------------
| UNION ALL - SUB FRANCHISEE (UNCHANGED / INACTIVE)
|--------------------------------------------------------------------------
*/

// UNION ALL

// SELECT
//     sf.id,
//     sf.firstname,
//     sf.lastname,
//     sf.contact_no,
//     sf.email,
//     sf.added_on,
//     sf.status,
//     sf.user_type,
//     'SF' AS userTypeStr,
//
//     ste.firstname AS ref_firstname,
//     ste.lastname AS ref_lastname,
//     ste.super_techno_enterprise_id,
//
//     'sub_franchisee' AS source_table
//
// FROM sub_franchisee sf
//
// INNER JOIN super_techno_enterprise ste
//     ON sf.reference_no = ste.super_techno_enterprise_id
//
// WHERE sf.reference_no = :user_id
// AND sf.status IN (0,2,4)

?>
