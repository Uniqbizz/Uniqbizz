<?php
header('Content-Type: application/json');
// Include the connection file
require '../../../connect.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

// Get inputs
$userType = $input['userType'] ?? null;
$userId = $input['userId'] ?? null;

// Check required inputs
if (!$userType || !$userId) {
    echo json_encode(['error' => 'Both userType and userId are required']);
    exit;
}

// Main logic - only for userType "10"
if ($userType == "11") {
    $sql = "SELECT * FROM `ca_customer` WHERE ta_reference_no = :userId AND (status = '2' OR status = '0')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    $result = [];
    
    if ($stmt->rowCount() > 0) {
        // Create single response object with array of data
        $response = [
            'status' => 'success',
            'data' => []
        ];
        
        foreach ($stmt->fetchAll() as $row) {
            // Format dates exactly as in your code
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');
            $dt = new DateTime($row['register_date']);
            $datev = $dt->format('d-m-Y');
            
            // Get status exactly as in your code
            $statusText = '';
            if ($row['status'] == '2') {
                $statusText = 'Pending';
            } else {
                $statusText = 'Deleted';
            }
            
            // Add each customer to the data array
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

        // Output JSON
        echo json_encode($response);
        
    } else {
        // No results found
        echo json_encode([
            'status' => 'success',
            'message' => 'No Pending Customers',
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