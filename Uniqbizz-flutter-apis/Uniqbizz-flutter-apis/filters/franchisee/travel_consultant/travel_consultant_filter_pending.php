<?php
header("Content-Type: application/json");
require '../../../connect.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['status' => false, 'message' => 'Method not allowed']);
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

    $search = isset($postData['search']) ? trim($postData['search']) : '';
    $userReference = isset($postData['id']) ? trim($postData['id']) : '';
    $fromDate = isset($postData['fromDate']) ? trim($postData['fromDate']) : '';
    $toDate = isset($postData['toDate']) ? trim($postData['toDate']) : '';

    if ($userReference === '') {
        echo json_encode([
            "status" => false,
            "message" => "franchise id is required"
        ]);
        exit;
    }

    $checkStmt = $conn->prepare("
        SELECT 1 
        FROM ca_travelagency 
        WHERE reference_no = :user_ref 
        LIMIT 1
    ");
    $checkStmt->bindValue(':user_ref', $userReference, PDO::PARAM_STR);
    $checkStmt->execute();

    if (!$checkStmt->fetchColumn()) {
        echo json_encode([
            "status" => false,
            "message" => "franchisee id invalid"
        ]);
        exit;
    }

    $isNumeric = ctype_digit($search);
    $idSearch = $isNumeric ? (int)$search : -1;
    $likeSearch = "%$search%";

    $sql = "
        SELECT *
        FROM ca_travelagency
        WHERE 
            (
                id = :id
                OR firstname LIKE :search
                OR lastname LIKE :search
                OR CONCAT(firstname, ' ', lastname) LIKE :search
                OR reference_no LIKE :search
                OR registrant LIKE :search
                OR contact_no LIKE :search
                OR added_on LIKE :search
            )
            AND reference_no = :user_ref
            AND status IN ('0','2')
    ";

    // Add date range filters if provided
    if (!empty($fromDate) && !empty($toDate)) {
        $sql .= " AND DATE(added_on) BETWEEN :from_date AND :to_date";
    } elseif (!empty($fromDate)) {
        $sql .= " AND DATE(added_on) >= :from_date";
    } elseif (!empty($toDate)) {
        $sql .= " AND DATE(added_on) <= :to_date";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $idSearch, PDO::PARAM_INT);
    $stmt->bindValue(':search', $likeSearch, PDO::PARAM_STR);
    $stmt->bindValue(':user_ref', $userReference, PDO::PARAM_STR);

    // Bind date parameters if provided
    if (!empty($fromDate)) {
        $stmt->bindValue(':from_date', $fromDate, PDO::PARAM_STR);
    }
    if (!empty($toDate)) {
        $stmt->bindValue(':to_date', $toDate, PDO::PARAM_STR);
    }

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as &$row) {
        $row['fullname'] = trim($row['firstname'] . ' ' . $row['lastname']);
    }

    if (count($data) === 0) {
    echo json_encode([
        "status" => true,
        "count" => 0,
        "data" => [],
        "message" => "No matching results"
    ], JSON_PRETTY_PRINT);
    exit;
}

echo json_encode([
    "status" => true,
    "count" => count($data),
    "data" => $data,
    "message" => "Records found"
], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "DB Error",
        "error" => $e->getMessage()
    ]);
}