<?php
header("Content-Type: application/json");
require '../../../../connect.php'; // PDO $conn

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
    // CHECK WHETHER TE EXISTS UNDER THIS STE
    // corporate_agency.reference_no = STE ID
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
    $idSearch  = ctype_digit($search) ? (int)$search : -1;
    $likeSearch = '%' . $search . '%';

    // ==========================================
    // STE -> TE -> TA -> CU
    // ==========================================
    $sql = "
        SELECT c.*
        FROM corporate_agency te

        INNER JOIN ca_travelagency t
            ON t.reference_no = te.reference_no

        INNER JOIN ca_customer c
            ON c.ta_reference_no = t.ca_travelagency_id

        WHERE te.reference_no = :ste_id
            AND c.status IN ('0', '2', '4')
            AND (
                c.id = :id_search
                OR c.firstname LIKE :search_firstname
                OR c.lastname LIKE :search_lastname
                OR CONCAT(c.firstname, ' ', c.lastname) LIKE :search_fullname
                OR c.reference_no LIKE :search_reference
                OR c.registrant LIKE :search_registrant
                OR c.contact_no LIKE :search_contact
                OR c.added_on LIKE :search_added_on
            )
    ";

    // ==========================================
    // DATE FILTERS
    // ==========================================
    if (!empty($fromDate) && !empty($toDate)) {

        $sql .= "
            AND DATE(c.added_on) BETWEEN :from_date AND :to_date
        ";

    } elseif (!empty($fromDate)) {

        $sql .= "
            AND DATE(c.added_on) >= :from_date
        ";

    } elseif (!empty($toDate)) {

        $sql .= "
            AND DATE(c.added_on) <= :to_date
        ";
    }

    $sql .= "
        ORDER BY c.added_on DESC
    ";

    // ==========================================
    // PREPARE & EXECUTE
    // ==========================================
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':ste_id', $steId, PDO::PARAM_INT);
    $stmt->bindValue(':id_search', $idSearch, PDO::PARAM_INT);

    $stmt->bindValue(':search_firstname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_lastname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_fullname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_reference', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_registrant', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_contact', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_added_on', $likeSearch, PDO::PARAM_STR);

    // Bind date parameters
    if (!empty($fromDate)) {
        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }

    if (!empty($toDate)) {
        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

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
    // EMPTY RESPONSE
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

    error_log("STE Customer Search API Error: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'DB Error',
        'error' => $e->getMessage()
    ]);
}
?>