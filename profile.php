<?php
header("Content-Type: application/json; charset=UTF-8");
require 'connect.php';
$response = ["status" => false, "message" => "Invalid request", "data" => null];


$request = json_decode(file_get_contents('php://input'), true);
$userId = $request['userId'] ?? $userId;
$userType = $request['userType'] ?? $userType;

// Map userType to table and ID column
$tableMap = [
    '3'  => ['table' => 'business_consultant', 'id' => 'business_consultant_id'],
    '10' => ['table' => 'ca_customer', 'id' => 'ca_customer_id'],
    '11' => ['table' => 'ca_travelagency', 'id' => 'ca_travelagency_id'],
    '15' => ['table' => 'business_trainee', 'id' => 'business_trainee_id'],
    '16' => ['table' => 'corporate_agency', 'id' => 'corporate_agency_id'],
    '18' => ['table' => 'channel_business_director', 'id' => 'channel_business_director_id'],
    '19' => ['table' => 'ca_franchisee', 'id' => 'ca_franchisee_id'],
    '20' => ['table' => 'business_operation_executive', 'id' => 'business_operation_executive_id'],
    '21' => ['table' => 'training_manager', 'id' => 'training_manager_id'],
    '22' => ['table' => 'sales_executive', 'id' => 'sales_executive_id'],
    '24' => ['table' => 'employees', 'id' => 'employee_id'],
    '25' => ['table' => 'employees', 'id' => 'employee_id'],
    '26' => ['table' => 'business_mentor', 'id' => 'business_mentor_id'],
    '27' => ['table' => 'zonal_manager', 'id' => 'zonal_manager_id'],
    '28' => ['table' => 'master_franchisee', 'id' => 'master_franchisee_id'],
    '29' => ['table' => 'sub_franchisee', 'id' => 'sub_franchisee_id'],
    '30' => ['table' => 'sponsor_franchisee', 'id' => 'sponsor_franchisee_id'],
    '31' => ['table' => 'relationship_manager', 'id' => 'relationship_manager_id'] //Table not yet made in DB
];

if (array_key_exists($userType, $tableMap)) {
    $tableInfo = $tableMap[$userType];
    $table = $tableInfo['table'];
    $idCol = $tableInfo['id'];

    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `$idCol` = ?");
    $stmt->execute([$userId]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $value = $stmt->fetch();

        // Default response fields
        $profile_pic = $value['profile_pic'] ?? '';
        $bank_passbook = '';
        $n_name = '';
        $n_relation = '';
        $countryname = '';
        $statename = '';
        $cityname = '';
        $pincode = '';
        $fname = '';
        $lname = '';
        $email = '';
        $gender = '';
        $dob = '';
        $address = '';

        // Helper function to get names from IDs
        function getNameById($conn, $table, $column, $id)
        {
            $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result[$column];
            }
            return '';
        }

        // Handle employee types
        if ($userType == '24' || $userType == '25') {
            $id_proof = $value['id_proof'] ?? '';
            $bank_passbook = $value['bank_details'] ?? '';
            $phone_no = $value['contact'] ?? '';

            // Handle name parts safely
            $nameParts = explode(' ', trim($value['name'] ?? ''));
            $fname = $nameParts[0] ?? '';
            $lname = end($nameParts) ?? '';
        } else {
            $fname = $value['firstname'] ?? '';
            $lname = $value['lastname'] ?? '';
            $n_name = $value['nominee_name'] ?? '';
            $n_relation = $value['nominee_relation'] ?? '';
            $phone_no = $value['contact_no'] ?? '';
            $email = $value['email'] ?? '';
            $gender = $value['gender'] ?? '';
            $dob = $value['date_of_birth'] ?? '';
            $bank_passbook = ($userType == '10' || $userType == '11') ? ($value['passbook'] ?? '') : ($value['bank_passbook'] ?? '');
            $pan_card = $value['pan_card'] ?? '';
            $aadhar_card = $value['aadhar_card'] ?? '';
            $voting_card = $value['voting_card'] ?? '';
            $address = $value['address'] ?? '';
            $country = $value['country'] ?? '';
            $state = $value['state'] ?? '';
            $city = $value['city'] ?? '';
            $pincode = $value['pincode'] ?? '';

            // Get readable names
            $countryname = getNameById($conn, 'countries', 'country_name', $country);
            $statename = getNameById($conn, 'states', 'state_name', $state);
            $cityname = getNameById($conn, 'cities', 'city_name', $city);
        }

        $response = [
            "status" => true,
            "message" => "Profile fetched successfully",
            "data" => [
                "firstname" => $fname,
                "lastname" => $lname,
                "nominee_name" => $n_name,
                "nominee_relation" => $n_relation,
                "phone_no" => $phone_no,
                "email" => $email,
                "gender" => $gender,
                "dob" => $dob,
                "pan_card" => $pan_card,
                "aadhar_card" => $aadhar_card,
                "voting_card" => $voting_card,
                "profile_pic" => $profile_pic,
                "bank_passbook" => $bank_passbook,
                "address" => $address,
                "country" => $countryname,
                "state" => $statename,
                "city" => $cityname,
                "pincode" => $pincode
            ]
        ];
    } else {
        $response["message"] = "No record found";
    }
} else {
    $response["message"] = "Invalid user type";
}

echo json_encode($response, JSON_PRETTY_PRINT);
