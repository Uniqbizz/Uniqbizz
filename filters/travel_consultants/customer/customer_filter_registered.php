<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST allowed']);
    exit;
}

try {
    // Enable PDO exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

    $input = json_decode(file_get_contents('php://input'), true);

    // Inputs
    $userType = $input['user_type'] ?? null;
    $userId   = $input['user_id'] ?? null;
    $search   = trim($input['search'] ?? '');
    $fromDate = $input['from_date'] ?? '';
    $toDate   = $input['to_date'] ?? '';

    if (!$userType || !$userId) {
        echo json_encode(['status' => 'error', 'message' => 'user_type and user_id required']);
        exit;
    }

    if ($userType != "11") {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user_type']);
        exit;
    }

    // Base query
    $query = "SELECT * FROM ca_customer 
              WHERE ta_reference_no = :userId 
              AND (status = '1' OR status = '3')";

    $params = [':userId' => $userId];

    // Date filters
    if (!empty($fromDate) && empty($toDate)) {
        $query .= " AND DATE(register_date) >= :fromDate";
        $params[':fromDate'] = $fromDate;
    } elseif (empty($fromDate) && !empty($toDate)) {
        $query .= " AND DATE(register_date) <= :toDate";
        $params[':toDate'] = $toDate;
    } elseif (!empty($fromDate) && !empty($toDate)) {
        $query .= " AND DATE(register_date) BETWEEN :fromDate AND :toDate";
        $params[':fromDate'] = $fromDate;
        $params[':toDate'] = $toDate;
    }

    // Search filter
    if (!empty($search)) {
        $query .= " AND (
            id LIKE :search OR
            LOWER(firstname) LIKE :search OR
            LOWER(lastname) LIKE :search OR
            LOWER(contact_no) LIKE :search OR
            LOWER(reference_no) LIKE :search OR
            LOWER(registrant) LIKE :search OR
            LOWER(ta_reference_no) LIKE :search OR
            LOWER(ta_reference_name) LIKE :search
        )";

        $params[':search'] = "%" . strtolower($search) . "%";
    }

    $query .= " ORDER BY id ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    $userCACUs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'success',
            'data' => $userCACUs
        ]);
    } else {
        echo json_encode([
            'status' => 'success',
            'message' => 'No registered customers found',
            'data' => []
        ]);
    }

} catch (PDOException $e) {
    // Database error
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error',
        'error' => $e->getMessage() // remove in production
    ]);
} catch (Exception $e) {
    // General error
    echo json_encode([
        'status' => 'error',
        'message' => 'Something went wrong',
        'error' => $e->getMessage()
    ]);
}