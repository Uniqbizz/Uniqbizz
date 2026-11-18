<?php
header("Content-Type: application/json");
require '../../../../connect.php';

try {

    // ==========================================
    // METHOD VALIDATION
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'status' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    // ==========================================
    // READ JSON BODY
    // ==========================================
    $postData = json_decode(file_get_contents('php://input'), true);

    if (!is_array($postData)) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid JSON body'
        ]);
        exit;
    }

    // ==========================================
    // INPUT PARAMETERS
    // ==========================================
    $search   = isset($postData['search']) ? trim($postData['search']) : '';
    $steId    = isset($postData['id']) ? trim($postData['id']) : '';
    $fromDate = isset($postData['fromDate']) ? trim($postData['fromDate']) : '';
    $toDate   = isset($postData['toDate']) ? trim($postData['toDate']) : '';

    // ==========================================
    // STE ID VALIDATION
    // ==========================================
    if ($steId === '') {
        echo json_encode([
            'status' => false,
            'message' => 'Valid STE id is required'
        ]);
        exit;
    }

    // ==========================================
    // CHECK TE UNDER STE
    // ==========================================
    $checkStmt = $conn->prepare("
        SELECT 1
        FROM corporate_agency
        WHERE reference_no = :ste_id
        LIMIT 1
    ");

    $checkStmt->bindValue(':ste_id', $steId, PDO::PARAM_INT);
    $checkStmt->execute();

    if (!$checkStmt->fetchColumn()) {
        echo json_encode([
            'status' => true,
            'count' => 0,
            'data' => [],
            'message' => 'No Techno Enterprises found under this STE'
        ]);
        exit;
    }

    // ==========================================
    // SEARCH PARAMETERS
    // ==========================================
    $isNumeric  = ctype_digit($search);
    $idSearch   = $isNumeric ? (int)$search : -1;
    $likeSearch = '%' . $search . '%';

    // ==========================================
    // STE -> TE -> TA
    // ==========================================
    $sql = "
        SELECT t.*
        FROM corporate_agency te

        INNER JOIN ca_travelagency t
            ON t.reference_no = te.reference_no

        WHERE te.reference_no = :ste_id
            AND t.status IN ('0', '2')
            AND (
                t.id = :id_search
                OR t.firstname LIKE :search_firstname
                OR t.lastname LIKE :search_lastname
                OR CONCAT(t.firstname, ' ', t.lastname) LIKE :search_fullname
                OR t.reference_no LIKE :search_reference
                OR t.registrant LIKE :search_registrant
                OR t.contact_no LIKE :search_contact
                OR t.added_on LIKE :search_added_on
            )
    ";

    // ==========================================
    // DATE RANGE FILTERS
    // ==========================================
    if (!empty($fromDate) && !empty($toDate)) {

        $sql .= "
            AND DATE(t.added_on) BETWEEN :from_date AND :to_date
        ";

    } elseif (!empty($fromDate)) {

        $sql .= "
            AND DATE(t.added_on) >= :from_date
        ";

    } elseif (!empty($toDate)) {

        $sql .= "
            AND DATE(t.added_on) <= :to_date
        ";
    }

    $sql .= "
        ORDER BY t.added_on DESC
    ";

    // ==========================================
    // PREPARE QUERY
    // ==========================================
    $stmt = $conn->prepare($sql);

    // ==========================================
    // BIND PARAMETERS
    // ==========================================
    $stmt->bindValue(':ste_id', $steId, PDO::PARAM_INT);
    $stmt->bindValue(':id_search', $idSearch, PDO::PARAM_INT);

    $stmt->bindValue(':search_firstname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_lastname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_fullname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_reference', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_registrant', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_contact', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_added_on', $likeSearch, PDO::PARAM_STR);

    // ==========================================
    // BIND DATE PARAMETERS
    // ==========================================
    if (!empty($fromDate)) {
        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }

    if (!empty($toDate)) {
        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

    // ==========================================
    // EXECUTE QUERY
    // ==========================================
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================
    // ADD FULL NAME
    // ==========================================
    foreach ($data as &$row) {
        $row['fullname'] = trim(
            $row['firstname'] . ' ' . $row['lastname']
        );
    }

    unset($row);

    // ==========================================
    // NO RECORDS
    // ==========================================
    if (count($data) === 0) {
        echo json_encode([
            'status' => true,
            'count' => 0,
            'data' => [],
            'message' => 'No matching results'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ==========================================
    // SUCCESS RESPONSE
    // ==========================================
    echo json_encode([
        'status' => true,
        'count' => count($data),
        'data' => $data,
        'message' => 'Records found'
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {

    error_log("STE Travel Agency Search API Error: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'DB Error',
        'error' => $e->getMessage()
    ]);
}
?>