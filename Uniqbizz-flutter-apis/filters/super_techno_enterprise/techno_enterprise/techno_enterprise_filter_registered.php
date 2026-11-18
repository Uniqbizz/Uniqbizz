<?php
header("Content-Type: application/json");
require '../../../../connect.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'status' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    $postData = json_decode(file_get_contents('php://input'), true);

    if (!is_array($postData)) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid JSON body'
        ]);
        exit;
    }

    $search   = isset($postData['search']) ? trim($postData['search']) : '';
    $steId    = isset($postData['id']) ? trim($postData['id']) : '';
    $fromDate = isset($postData['fromDate']) ? trim($postData['fromDate']) : '';
    $toDate   = isset($postData['toDate']) ? trim($postData['toDate']) : '';

    // ==========================================
    // VALIDATE STE ID
    // ==========================================
    if ($steId === '') {
        echo json_encode([
            'status' => false,
            'message' => 'Valid STE id is required'
        ]);
        exit;
    }

    // ==========================================
    // SEARCH PARAMETERS
    // ==========================================
    $idSearch = ctype_digit($search) ? (int)$search : -1;
    $likeSearch = '%' . $search . '%';

    // ==========================================
    // STE -> TE
    // ==========================================
    $sql = "
        SELECT te.*
        FROM corporate_agency te
        WHERE te.reference_no = :ste_id
            AND te.status IN ('1','3')
            AND (
                te.id = :id_search
                OR te.firstname LIKE :search_firstname
                OR te.lastname LIKE :search_lastname
                OR CONCAT(te.firstname, ' ', te.lastname) LIKE :search_fullname
                OR te.reference_no LIKE :search_reference
                OR te.registrant LIKE :search_registrant
                OR te.contact_no LIKE :search_contact
                OR te.register_date LIKE :search_register_date
            )
    ";

    // ==========================================
    // DATE FILTERS
    // ==========================================
    if (!empty($fromDate) && !empty($toDate)) {
        $sql .= " AND DATE(te.register_date) BETWEEN :from_date AND :to_date";
    } elseif (!empty($fromDate)) {
        $sql .= " AND DATE(te.register_date) >= :from_date";
    } elseif (!empty($toDate)) {
        $sql .= " AND DATE(te.register_date) <= :to_date";
    }

    $sql .= " ORDER BY te.register_date DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':ste_id', $steId, PDO::PARAM_INT);
    $stmt->bindValue(':id_search', $idSearch, PDO::PARAM_INT);
    $stmt->bindValue(':search_firstname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_lastname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_fullname', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_reference', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_registrant', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_contact', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':search_register_date', $likeSearch, PDO::PARAM_STR);

    if (!empty($fromDate)) {
        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }

    if (!empty($toDate)) {
        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as &$row) {
        $row['fullname'] = trim(
            $row['firstname'] . ' ' . $row['lastname']
        );
    }

    unset($row);

    echo json_encode([
        'status' => true,
        'count' => count($data),
        'data' => $data,
        'message' => count($data) ? 'Records found' : 'No matching results'
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {

    error_log("STE TE Search API Error: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'DB Error',
        'error' => $e->getMessage()
    ]);
}
?>