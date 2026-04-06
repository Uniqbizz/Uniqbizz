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
            AND (status = '2' OR status = '0')";

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
        $sql .= " AND DATE(added_on) BETWEEN :fromDate AND :toDate";
        $params[':fromDate'] = $fromDate;
        $params[':toDate']   = $toDate;
    }

    // Prepare & execute
    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Response
    $response = [
        'status' => 'success',
        'data' => []
    ];

    if ($stmt->rowCount() > 0) {

        foreach ($stmt->fetchAll() as $row) {

            // Date formatting (UNCHANGED)
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $dt = new DateTime($row['added_on']);
            $datev = $dt->format('d-m-Y');

            // Status logic (UNCHANGED)
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

    } else {
        // Clean empty response
        $response['message'] = 'No data found';
    }

    echo json_encode($response);
?>