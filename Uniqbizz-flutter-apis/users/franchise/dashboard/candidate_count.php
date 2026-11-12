<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Include your connection file
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use POST method.'
    ]);
    exit;
}
    
// Get parameters from POST request
$input = json_decode(file_get_contents('php://input'), true);

// If no JSON input, check form-data
if (empty($input)) {
    $input = $_POST;
}

$userType = $input['userType'] ?? null;
$userId = $input['userId'] ?? null;

// Validate required parameters
if (!$userType || !$userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters: userType and userId are required'
    ]);
    exit;
}

// Initialize all variables
$pendingBM = $registeredBM = $deletedBM = 0;
$pendingMF = $registeredMF = $deletedMF = 0;
$pendingTE = $registeredTE = $deletedTE = 0;
$pendingF = $registeredF = $deletedF = 0;
$pendingTC = $registeredTC = $deletedTC = 0;
$pendingCU = $registeredCU = $deletedCU = 0;

// Function to get users under specific user based on hierarchy
function getUsersUnderUser($parentId, $userType, $con) {
    $result = ['pending' => 0, 'registered' => 0, 'deleted' => 0];
    
    // This query structure depends on your database design
    // You need to adjust based on how your user hierarchy is stored
    switch($userType) {
        case 'business_mentor':
            // Business Mentor can see all users under them
            $query = $con->prepare("SELECT 
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as registered,
                SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) as deleted
                FROM users WHERE referred_by = ? OR created_by = ?");
            $query->execute([$parentId, $parentId]);
            break;
            
        case 'master_franchisee':
            // Master Franchisee can see users under them
            $query = $con->prepare("SELECT 
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as registered,
                SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) as deleted
                FROM users WHERE master_franchisee_id = ?");
            $query->execute([$parentId]);
            break;
            
        case 'techno_enterprise':
            // Techno Enterprise can see users under them
            $query = $con->prepare("SELECT 
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as registered,
                SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) as deleted
                FROM users WHERE techno_enterprise_id = ?");
            $query->execute([$parentId]);
            break;
            
        case 'franchisee':
            // Franchisee can see users under them
            $query = $con->prepare("SELECT 
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as registered,
                SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) as deleted
                FROM users WHERE franchisee_id = ?");
            $query->execute([$parentId]);
            break;
            
        default:
            return $result;
    }
    
    $data = $query->fetch(PDO::FETCH_ASSOC);
    return [
        'pending' => $data['pending'] ?? 0,
        'registered' => $data['registered'] ?? 0,
        'deleted' => $data['deleted'] ?? 0
    ];
}

// Fetch counts based on user type and user ID
switch($userType) {
    case '24': // Business Mentor
        // Business Mentor can see Business Mentors, Master Franchisees, etc. under them
        $bmCounts = getUsersUnderUser($userId, 'business_mentor', $con);
        $pendingBM = $bmCounts['pending'];
        $registeredBM = $bmCounts['registered'];
        $deletedBM = $bmCounts['deleted'];
        
        // For other types, you might need specific queries
        // Adjust based on your actual database structure
        $queryMF = $con->prepare("SELECT 
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as registered,
            SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) as deleted
            FROM users WHERE user_type = 'master_franchisee' AND referred_by = ?");
        $queryMF->execute([$userId]);
        $resultMF = $queryMF->fetch(PDO::FETCH_ASSOC);
        $pendingMF = $resultMF['pending'] ?? 0;
        $registeredMF = $resultMF['registered'] ?? 0;
        $deletedMF = $resultMF['deleted'] ?? 0;
        
        // Similar queries for other user types...
        break;
        
    case '25': // Master Franchisee
        $teCounts = getUsersUnderUser($userId, 'master_franchisee', $con);
        $pendingTE = $teCounts['pending'];
        $registeredTE = $teCounts['registered'];
        $deletedTE = $teCounts['deleted'];
        
        // Add other queries for Franchisee, Travel Consultant, Customer under this MF
        break;
        
    // Add cases for other user types...
}

// Prepare response based on user type
$response = [];

switch($userType) {
    case '24': // Business Mentor
        $response = [
            ['type' => 'Business Mentor', 'pending' => (int)$pendingBM, 'registered' => (int)$registeredBM, 'deleted' => (int)$deletedBM],
            ['type' => 'Master Franchisee', 'pending' => (int)$pendingMF, 'registered' => (int)$registeredMF, 'deleted' => (int)$deletedMF],
            ['type' => 'Sponsor Franchisee', 'pending' => (int)$pendingBM, 'registered' => (int)$registeredBM, 'deleted' => (int)$deletedBM],
            ['type' => 'Techno Enterprise', 'pending' => (int)$pendingTE, 'registered' => (int)$registeredTE, 'deleted' => (int)$deletedTE],
            ['type' => 'Franchisee', 'pending' => (int)$pendingF, 'registered' => (int)$registeredF, 'deleted' => (int)$deletedF],
            ['type' => 'Travel Consultant', 'pending' => (int)$pendingTC, 'registered' => (int)$registeredTC, 'deleted' => (int)$deletedTC],
            ['type' => 'Customer', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '25': // Master Franchisee
        $response = [
            ['type' => 'Techno Enterprise', 'pending' => (int)$pendingTE, 'registered' => (int)$registeredTE, 'deleted' => (int)$deletedTE],
            ['type' => 'Franchisee', 'pending' => (int)$pendingF, 'registered' => (int)$registeredF, 'deleted' => (int)$deletedF],
            ['type' => 'Travel Consultant', 'pending' => (int)$pendingTC, 'registered' => (int)$registeredTC, 'deleted' => (int)$deletedTC],
            ['type' => 'Customer', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '26': // Techno Enterprise
        $response = [
            ['type' => 'Techno Enterprise', 'pending' => (int)$pendingTE, 'registered' => (int)$registeredTE, 'deleted' => (int)$deletedTE],
            ['type' => 'CU', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '16': // Some other user type
        $response = [
            ['type' => 'CU', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '28': // Another user type
        $response = [
            ['type' => 'Franchisee', 'pending' => (int)$pendingF, 'registered' => (int)$registeredF, 'deleted' => (int)$deletedF],
            ['type' => 'Travel Consultant', 'pending' => (int)$pendingTC, 'registered' => (int)$registeredTC, 'deleted' => (int)$deletedTC],
            ['type' => 'Customer', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '29': // Another user type
        $response = [
            ['type' => 'Customer', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    case '30': // Another user type
        $response = [
            ['type' => 'Franchisee', 'pending' => (int)$pendingF, 'registered' => (int)$registeredF, 'deleted' => (int)$deletedF],
            ['type' => 'Travel Consultant', 'pending' => (int)$pendingTC, 'registered' => (int)$registeredTC, 'deleted' => (int)$deletedTC],
            ['type' => 'Customer', 'pending' => (int)$pendingCU, 'registered' => (int)$registeredCU, 'deleted' => (int)$deletedCU]
        ];
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid user type'
        ]);
        exit;
}

echo json_encode([
    'success' => true,
    'user_type' => $userType,
    'user_id' => $userId,
    'data' => $response
]);
?>