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
    
    if ($stmt->rowCount() > 0) {
        $response = [
            'status' => 'success',
            'data' => []
        ];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $statusText = ($row['status'] == '3') ? 'Pending' : 'Active';
            
            $response['data'][] = [
                'id' => $row['id'],
                'profile_pic' => $row['profile_pic'],
                'ca_customer_id' => $row['ca_customer_id'],
                'name' => $row['firstname'] . ' ' . $row['lastname'],
                'ta_reference' => $row['ta_reference_no'] . ' ' . $row['ta_reference_name'],
                'reference' => $row['reference_no'] . ' ' . $row['registrant'],
                'customer_type' => $row['customer_type'],
                'contact_no' => $row['contact_no'],
                'register_date' => $row['register_date'],
                'status' => $statusText,
                'status_code' => $row['status']
            ];
        }
        
        echo json_encode($response);
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