<?php
// API to get pending customers based on user type

// Set header for JSON response
header('Content-Type: application/json');

// Include database connection
require '../../../connect.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get POST data
$postData = json_decode(file_get_contents('php://input'), true);

// Get input parameters
$userId = $postData['userId'];
$userType = $postData['userType'];

// Validate inputs
if (empty($userId) || empty($userType)) {
    echo json_encode([
        'success' => false,
        'message' => 'User ID and User Type are required',
        'data' => []
    ]);
    exit;
}

// Initialize response array
$response = [
    'success' => false,
    'count' => 0,
    'data' => [],
];

try {
    // Check if user type is 16 or 29
    if ($userType == "16" || $userType == "29") { 
        
        // Get travel agencies for the user
        $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
        $stmt4->execute([$userId]);
        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($userCATAs) > 0) {
            $allRegistedCustomers = [];
            
            foreach ($userCATAs as $userCATA) {
                // Get pending customers for this travel agency
                $stmt5 = $conn->prepare("SELECT * FROM ca_customer WHERE ta_reference_no = ? AND (status='1' OR status = '3')");
                $stmt5->execute([$userCATA['ca_travelagency_id']]);
                $userCACUs = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                
                // Directly add all rows from the query
                $allRegistedCustomers = array_merge($allRegistedCustomers, $userCACUs);
            }
            
            $response['success'] = true;
            $response['count'] = count($allRegistedCustomers);
            $response['data'] = $allRegistedCustomers;

            
        }else{
            $response = [
                'success' => true,
                'count' => 0,
                'data' => [],
            ];
        }
    }else {
        echo json_encode(['success' => false, 'message' => 'Invalid user type']);
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    $response['error'] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
?>