
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

    // ==========================================
    // 1. JSON INPUT VALIDATION
    // ==========================================

    $json = file_get_contents("php://input");
    $requestData = json_decode($json, true);

    if (!is_array($requestData)) {
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

    // ==========================================
    // 2. FETCH TC COUNTS
    // ==========================================

    $sql = "

        SELECT

            COUNT(
                CASE
                    WHEN combined.status IN (0, 2, 4) THEN 1
                END
            ) AS pending_count,

            COUNT(
                CASE
                    WHEN combined.status IN (1, 3) THEN 1
                END
            ) AS registered_count,

            COUNT(*) AS total_count

        FROM (

            /* ==========================================
               CORPORATE AGENCY -> TRAVEL CONSULTANT
            ========================================== */

            SELECT
                ta.id,
                ta.status

            FROM ca_travelagency ta

            INNER JOIN corporate_agency ca
                ON ta.reference_no = ca.corporate_agency_id

            WHERE ta.reference_no = :user_id
              AND ta.status IN (0, 1, 2, 3, 4)

        ) AS combined

    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==========================================
    // 3. JSON RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'message' => 'TC counts fetched successfully',
        'data' => [
            'pending_count' => (int) ($data['pending_count'] ?? 0),
            'registered_count' => (int) ($data['registered_count'] ?? 0),
            'total_count' => (int) ($data['total_count'] ?? 0)
        ]
    ]);

} catch (PDOException $e) {

    error_log('TC Count API PDO Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred.',
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