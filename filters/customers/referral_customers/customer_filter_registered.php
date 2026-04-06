<?php
header('Content-Type: application/json');
require '../../../connect.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Input
$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

// Required fields (keeping original logic intact)
$userId   = $input['id'] ?? null;

// New filters (same request structure as you asked)
$search   = $input['search'] ?? '';
$fromDate = $input['fromDate'] ?? null;
$toDate   = $input['toDate'] ?? null;

if (!$userId) {
    echo json_encode(['error' => 'userId is required']);
    exit;
}

    // Base query (UNCHANGED LOGIC)
    $sql = "SELECT * FROM `ca_customer` 
            WHERE reference_no = :userId 
            AND (status = '1' OR status = '3')";

    // Dynamic filters
    $params = [':userId' => $userId];

    // 🔍 SEARCH FILTER
    if (!empty($search)) {
        $sql .= " AND (
            firstname LIKE :search OR
            lastname LIKE :search OR
            contact_no LIKE :search OR
            reference_no LIKE :search OR
            registrant LIKE :search OR
            ta_reference_no LIKE :search OR
            ta_reference_name LIKE :search
        )";
        $params[':search'] = '%' . $search . '%';
    }

    // 📅 DATE FILTER (on register_date)
    if (!empty($fromDate) && !empty($toDate)) {
        $sql .= " AND DATE(register_date) BETWEEN :fromDate AND :toDate";
        $params[':fromDate'] = $fromDate;
        $params[':toDate']   = $toDate;
    }

    // Prepare & execute
    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    $stmt->execute();

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
?>