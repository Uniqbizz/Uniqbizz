<?php
include_once '../../../../connect.php'; // DB connection

header('Content-Type: application/json');

// Initialize response
$response = [
    "status" => "error",
    "message" => "Something went wrong",
    "data" => null
];

try {
    // Get input data (support both POST and GET)
    $request = $_SERVER['REQUEST_METHOD'] === 'POST'
        ? json_decode(file_get_contents('php://input'), true)
        : $_GET;

    $userId = $request['userId'] ?? null;
    $userType = $request['userType'] ?? null;

    if (!$userId || !$userType) {
        throw new Exception("User ID and Type are required");
    }

    // Flexible name lookup function
    function getNameById($conn, $table, $column, $id)
    {
        if (empty($id)) return '';

        $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() ?: '';
    }

    // Determine table based on user type
    $table = ($userType == '25' || $userType == '24') ? 'partners' : 'ca_customer';
    $idField = ($userType == '25' || $userType == '24') ? 'id' : 'ca_customer_id';

    // Query for user details
    $sql = "SELECT * FROM {$table} WHERE {$idField} = :userId AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = [];

        // Common fields
        $profile_pic = !empty($userData['profile_pic']) ? '../uploading/' . $userData['profile_pic'] : null;
        $bank_passbook = null;

        // Type-specific processing
        if ($userType == '25' || $userType == '24') {
            // Partner fields
            $nameParts = preg_split('/\s+/', trim($userData['name']));
            $fname = $nameParts[0] ?? '';
            $lname = end($nameParts) ?: '';
            $middle = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';

            $bank_passbook = !empty($userData['bank_details']) ? '../uploading/' . $userData['bank_details'] : null;
            $id_proof = !empty($userData['id_proof']) ? '../uploading/' . $userData['id_proof'] : null;
        } else {
            // Customer fields
            $fname = $userData['firstname'];
            $middle = '';
            $lname = $userData['lastname'];

            $bank_passbook_field = ($userType == '10' || $userType == '11') ? 'passbook' : 'bank_passbook';
            $bank_passbook = !empty($userData[$bank_passbook_field]) ? '../uploading/' . $userData[$bank_passbook_field] : null;

            // Document paths
            $pan_card = !empty($userData['pan_card']) ? '../uploading/' . $userData['pan_card'] : null;
            $aadhar_card = !empty($userData['aadhar_card']) ? '../uploading/' . $userData['aadhar_card'] : null;
            $voting_card = !empty($userData['voting_card']) ? '../uploading/' . $userData['voting_card'] : null;

            // Location data
            $countryname = getNameById($conn, 'countries', 'country_name', $userData['country']);
            $statename = getNameById($conn, 'states', 'state_name', $userData['state']);
            $cityname = getNameById($conn, 'cities', 'city_name', $userData['city']);
        }

        // Build response data
        $data = [
            'basic_info' => [
                'full_name' => trim("$fname $middle $lname"),
                'first_name' => $fname,
                'middle_name' => $middle,
                'last_name' => $lname,
                'email' => $userData['email'] ?? null,
                'phone' => $userType == '25' || $userType == '24'
                    ? $userData['contact']
                    : $userData['contact_no'],
                'profile_pic' => $profile_pic,
                'gender' => $userData['gender'] ?? null,
                'dob' => $userData['date_of_birth'] ?? null,
                'address' => $userData['address'] ?? null
            ],
            'documents' => [
                'bank_passbook' => $bank_passbook,
                'pan_card' => $pan_card ?? null,
                'aadhar_card' => $aadhar_card ?? null,
                'voting_card' => $voting_card ?? null,
                'id_proof' => $id_proof ?? null
            ]
        ];

        // Add location info for non-partners
        if ($userType != '25' && $userType != '24') {
            $data['location'] = [
                'country' => [
                    'id' => $userData['country'],
                    'name' => $countryname
                ],
                'state' => [
                    'id' => $userData['state'],
                    'name' => $statename
                ],
                'city' => [
                    'id' => $userData['city'],
                    'name' => $cityname
                ],
                'pincode' => $userData['pincode'] ?? null
            ];

            // Add customer-specific fields
            if ($userType == '10') {
                $data['customer_type'] = $userData['customer_type'] ?? null;
                $data['comp_chek'] = $userData['comp_chek'] ?? null;
            }

            // Add nominee info if available
            if (isset($userData['nominee_name'])) {
                $data['nominee'] = [
                    'name' => $userData['nominee_name'],
                    'relation' => $userData['nominee_relation'] ?? null
                ];
            }
        }

        $response = [
            "status" => "success",
            "message" => "Profile data retrieved successfully",
            "data" => $data
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "No user found with the specified ID"
        ];
    }
} catch (PDOException $e) {
    $response = [
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ];
} catch (Exception $e) {
    $response = [
        "status" => "error",
        "message" => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
