
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

    $sql = "
        SELECT *
        FROM (

            SELECT
                cu.id,
                cu.ca_customer_id,
                cu.firstname,
                cu.lastname,
                cu.contact_no,
                cu.email,
                cu.register_date,
                cu.status,
                cu.paid_amount AS amount,
                CONCAT(
                    cu.customer_type,
                    ' / ',
                    CASE
                        WHEN cu.comp_chek = '1' THEN 'Complementary'
                        WHEN cu.comp_chek = '2' THEN 'Non Complementary'
                        ELSE '-'
                    END
                ) AS type,

                ta.ca_travelagency_id,
                ta.firstname AS ref_firstname,
                ta.lastname AS ref_lastname,
                DATE_FORMAT(cu.deleted_date, '%d %b %Y') AS deleted_date,
                'TE' AS ref_type

            FROM ca_customer cu

            INNER JOIN ca_travelagency ta
                ON cu.ta_reference_no = ta.ca_travelagency_id

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ca.reference_no = :user_id
            AND cu.status IN (1,3)

        ) x

        ORDER BY x.id DESC
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'Customer data fetched successfully',
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
