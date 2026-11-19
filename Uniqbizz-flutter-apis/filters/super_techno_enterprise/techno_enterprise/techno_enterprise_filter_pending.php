<?php
header("Content-Type: application/json");
require '../../../../connect.php';

try {

    // ==========================================
    // VALIDATE REQUEST METHOD
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
    // GET POST DATA
    // ==========================================
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
        SELECT te.id,te.firstname,te.lastname,te.contact_no,te.country_code,te.email,te.added_on,te.status,te.user_type,
        'te' AS user_type_str,te.deleted_date,ste.firstname AS ref_firstname, ste.lastname AS ref_lastname, ste.super_techno_enterprise_id, 
        'corporate_agency' AS  source_table
        FROM corporate_agency te
        INNER JOIN super_techno_enterprise ste ON ste.super_techno_enterprise_id =:ste_id 
        WHERE te.reference_no = :ste_id
        AND te.status IN ('0', '2', '4')
    ";

    // ==========================================
    // SEARCH FILTER (ONLY WHEN NOT BLANK)
    // ==========================================
    if ($search !== '') {

        $sql .= "
            AND (
                te.id = :id_search
                OR te.firstname LIKE :search_firstname
                OR te.lastname LIKE :search_lastname
                OR CONCAT(te.firstname, ' ', te.lastname) LIKE :search_fullname
                OR te.reference_no LIKE :search_reference
                OR te.registrant LIKE :search_registrant
                OR te.contact_no LIKE :search_contact
                OR te.added_on LIKE :search_added_on
            )
        ";
    }

    // ==========================================
    // DATE FILTERS
    // ==========================================
    if ($fromDate !== '' && $toDate !== '') {

        $sql .= "
            AND DATE(te.added_on) BETWEEN :from_date AND :to_date
        ";

    } elseif ($fromDate !== '') {

        $sql .= "
            AND DATE(te.added_on) >= :from_date
        ";

    } elseif ($toDate !== '') {

        $sql .= "
            AND DATE(te.added_on) <= :to_date
        ";
    }

    // ==========================================
    // ORDER BY
    // ==========================================
    $sql .= " ORDER BY te.added_on DESC";

    // ==========================================
    // PREPARE QUERY
    // ==========================================
    $stmt = $conn->prepare($sql);

    // ==========================================
    // BIND STE ID
    // ==========================================
    $stmt->bindValue(':ste_id', $steId, PDO::PARAM_STR);

    // ==========================================
    // BIND SEARCH PARAMETERS ONLY WHEN SEARCH
    // IS NOT BLANK
    // ==========================================
    if ($search !== '') {

        $stmt->bindValue(':id_search', $idSearch, PDO::PARAM_INT);

        $stmt->bindValue(':search_firstname', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_lastname', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_fullname', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_reference', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_registrant', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_contact', $likeSearch, PDO::PARAM_STR);
        $stmt->bindValue(':search_added_on', $likeSearch, PDO::PARAM_STR);
    }

    // ==========================================
    // BIND DATE PARAMETERS
    // ==========================================
    if ($fromDate !== '') {
        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }

    if ($toDate !== '') {
        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

    // ==========================================
    // EXECUTE QUERY
    // ==========================================
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================
    // ADD FULLNAME
    // ==========================================
    foreach ($data as &$row) {
        $row['fullname'] = trim(
            $row['firstname'] . ' ' . $row['lastname']
        );
    }

    unset($row);

    // ==========================================
    // JSON RESPONSE
    // ==========================================
    echo json_encode([
        'status' => true,
        'count' => count($data),
        'data' => $data,
        'message' => count($data) > 0
            ? 'Records found'
            : 'No matching results'
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {

    error_log("STE TE Search API Error: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'DB Error'
    ]);
}
?>