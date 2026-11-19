<?php

header("Content-Type: application/json");

require '../../../../connect.php';

try {

    // ==========================================
    // 1. METHOD VALIDATION
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
    // 2. READ JSON INPUT
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
    // 3. INPUT PARAMETERS
    // ==========================================

    $search = trim($postData['search'] ?? '');
    $steId = trim($postData['id'] ?? '');

    $fromDate = trim($postData['fromDate'] ?? '');
    $toDate = trim($postData['toDate'] ?? '');

    // ==========================================
    // 4. VALIDATE STE ID
    // ==========================================

    if ($steId === '') {

        echo json_encode([
            'status' => false,
            'message' => 'STE ID is required'
        ]);

        exit;
    }

    // ==========================================
    // 5. SEARCH PARAMETERS
    // ==========================================

    $idSearch = $search;

    $likeSearch = '%' . $search . '%';

    // ==========================================
    // 6. STE -> TE -> TC QUERY
    //
    // STE -> TE:
    // te.reference_no = STE ID
    //
    // TE -> TC:
    // t.reference_no = te.corporate_agency_id
    //
    // RETURN TC RECORDS ONLY
    // ==========================================

    $sql = "
        SELECT
            t.id,t.ca_travelagency_id,t.firstname,t.lastname,t.contact_no,t.country_code,t.email,t.register_date,t.status,t.amount,
            t.deleted_date,te.corporate_agency_id AS reference_id,te.firstname AS ref_firstname, te.lastname AS ref_lastname, 
            'TE' AS ref_type

        FROM corporate_agency te

        INNER JOIN ca_travelagency t
            ON t.reference_no = te.corporate_agency_id

        WHERE te.reference_no = :ste_id

        AND t.status IN ('1', '3')
    ";

    // ==========================================
    // 7. OPTIONAL SEARCH FILTER
    // ==========================================

    if ($search !== '') {

        $sql .= "
            AND (
                t.ca_travelagency_id = :id_search

                OR t.firstname LIKE :search_firstname

                OR t.lastname LIKE :search_lastname

                OR CONCAT(t.firstname, ' ', t.lastname) LIKE :search_fullname

                OR t.reference_no LIKE :search_reference

                OR t.registrant LIKE :search_registrant

                OR t.contact_no LIKE :search_contact

                OR t.added_on LIKE :search_added_on
            )
        ";
    }

    // ==========================================
    // 8. OPTIONAL DATE FILTER
    // ==========================================

    if ($fromDate !== '' && $toDate !== '') {

        $sql .= "
            AND DATE(t.added_on) BETWEEN :from_date AND :to_date
        ";

    } elseif ($fromDate !== '') {

        $sql .= "
            AND DATE(t.added_on) >= :from_date
        ";

    } elseif ($toDate !== '') {

        $sql .= "
            AND DATE(t.added_on) <= :to_date
        ";
    }

    // ==========================================
    // 9. ORDER BY
    // ==========================================

    $sql .= "
        ORDER BY t.added_on DESC
    ";

    // ==========================================
    // 10. PREPARE QUERY
    // ==========================================

    $stmt = $conn->prepare($sql);

    // ==========================================
    // 11. BIND STE ID
    // ==========================================

    $stmt->bindValue(':ste_id', $steId, PDO::PARAM_STR);

    // ==========================================
    // 12. BIND SEARCH PARAMETERS
    // ==========================================

    if ($search !== '') {

        $stmt->bindValue(':id_search', $idSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_firstname', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_lastname', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_fullname', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_reference', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_registrant', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_contact', $likeSearch, PDO::PARAM_STR);

        $stmt->bindValue(':search_added_on', $likeSearch, PDO::PARAM_STR);
    }

    // ==========================================
    // 13. BIND DATE PARAMETERS
    // ==========================================

    if ($fromDate !== '') {

        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }

    if ($toDate !== '') {

        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

    // ==========================================
    // 14. EXECUTE QUERY
    // ==========================================

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================
    // 15. RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'count' => count($data),
        'data' => $data,
        'message' => count($data) > 0
            ? 'TC records fetched successfully'
            : 'No TC records found'
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {

    error_log('STE to TE to TC API Error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => 'Database error'
    ]);
}

?>