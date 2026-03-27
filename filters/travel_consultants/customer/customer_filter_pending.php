<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST allowed']);
    exit;
}

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

// ✅ Base query
$query = "SELECT * FROM ca_customer 
          WHERE ta_reference_no = :userId 
          AND (status = '2' OR status = '0')";

$params = [':userId' => $userId];


// Only FROM date
if (!empty($fromDate) && empty($toDate)) {
    $query .= " AND DATE(added_on) >= :fromDate";
    $params[':fromDate'] = $fromDate;
}

// Only TO date
elseif (empty($fromDate) && !empty($toDate)) {
    $query .= " AND DATE(added_on) <= :toDate";
    $params[':toDate'] = $toDate;
}

// BOTH dates
elseif (!empty($fromDate) && !empty($toDate)) {
    $query .= " AND DATE(added_on) BETWEEN :fromDate AND :toDate";
    $params[':fromDate'] = $fromDate;
    $params[':toDate'] = $toDate;
}


// 🔹 3. Search filter (FUZZY)
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

$response = [
    'status' => 'success',
    'data' => []
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $dt = new DateTime($row['added_on']);
    $datev = $dt->format('Y-m-d');

    $statusText = ($row['status'] == '2') ? 'Pending' : 'Deleted';

    $response['data'][] = [
        'id' => $row['id'],
        'profile_pic' => $row['profile_pic'],
        'name' => $row['firstname'] . ' ' . $row['lastname'],
        'ta_reference' => $row['ta_reference_no'] . ' ' . $row['ta_reference_name'],
        'reference' => $row['reference_no'] . ' ' . $row['registrant'],
        'customer_type' => $row['customer_type'],
        'contact_no' => $row['contact_no'],
        'register_date' => $datev,
        'status' => $statusText,
        'status_code' => $row['status']
    ];
}

echo json_encode($response);