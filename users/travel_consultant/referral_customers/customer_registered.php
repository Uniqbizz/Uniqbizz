<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'api_status' => 'error',
        'error' => 'Only POST requests allowed'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$userType = $input['userType'] ?? null;
$userId = $input['userId'] ?? null;

if (!$userType || !$userId) {
    echo json_encode([
        'api_status' => 'error',
        'error' => 'userType and userId required'
    ]);
    exit;
}

if ($userType == "11") {
    $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = :userId AND (status = '1' OR status = '3')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $userCACUs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $allRegistedCustomers = [];
    
    if ($stmt->rowCount() > 0) {
        $allRegistedCustomers = array_merge($allRegistedCustomers, $userCACUs);
        
       echo json_encode([
            'status' => 'success',
            'data' => $allRegistedCustomers
        ]);
    } else {
        echo json_encode([
            'status' => 'success',
            'message' => 'No registered customers found',
            'data' => []
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'error' => 'Invalid userType'
    ]);
}
?>