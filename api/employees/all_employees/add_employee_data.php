<?php
session_start();

// if (!isset($_SESSION['username'])) {
//     header('Content-Type: application/json');
//     echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
//     exit();
// }

require "../../connect.php";

header('Content-Type: application/json');

$current_year = date('Y');

// Validate request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

// Function to sanitize input
function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is valid JSON
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format']);
    exit();
}

// Required fields
$required_fields = [
    'name', 'birth_date', 'country_cd', 'contact', 'email', 'address',
    'gender', 'joining_date', 'department', 'designation', 'zone', 'branch',
    'reporting_manager', 'profile_pic', 'id_proof', 'bank_details'
];

// Check for missing fields
foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        echo json_encode(['status' => 'error', 'message' => "Missing field: $field"]);
        exit();
    }
}

// Sanitize and validate input
$name = clean_input($data['name']);
$birth_date = clean_input($data['birth_date']);
$country_cd = clean_input($data['country_cd']);
$contact = clean_input($data['contact']);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$address = clean_input($data['address']);
$gender = clean_input($data['gender']);
$joining_date = clean_input($data['joining_date']);
$department = clean_input($data['department']);
$designation = clean_input($data['designation']);
$zone = clean_input($data['zone']);
$branch = clean_input($data['branch']);
$reporting_manager = clean_input($data['reporting_manager']);
$profile_pic = clean_input($data['profile_pic']);
$id_proof = clean_input($data['id_proof']);
$bank_details = clean_input($data['bank_details']); // Consider encrypting
$register_by = '1'; // Admin
$status = '2';

// Assign user type dynamically (assuming you have a user_types table)
$user_type_map = [
    '1' => '24', // BCM
    '2' => '25'  // BDM
];

$user_type = $user_type_map[$designation] ?? '26'; // Default user type

// Calculate age
$birth_year = substr($birth_date, 0, 4);
$age = $current_year - intval($birth_year);

// Insert employee data
$sql = "INSERT INTO employees 
        (name, date_of_birth, country_code, contact, email, address, gender, date_of_joining, department, designation, zone, branch, reporting_manager, profile_pic, id_proof, bank_details, register_by, user_type, status) 
        VALUES (:name, :date_of_birth, :country_code, :contact, :email, :address, :gender, :date_of_joining, :department, :designation, :zone, :branch, :reporting_manager, :profile_pic, :id_proof, :bank_details, :register_by, :user_type, :status)";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':name' => $name,
    ':date_of_birth' => $birth_date,
    ':country_code' => $country_cd,
    ':contact' => $contact,
    ':email' => $email,
    ':address' => $address,
    ':gender' => $gender,
    ':date_of_joining' => $joining_date,
    ':department' => $department,
    ':designation' => $designation,
    ':zone' => $zone,
    ':branch' => $branch,
    ':reporting_manager' => $reporting_manager,
    ':profile_pic' => $profile_pic,
    ':id_proof' => $id_proof,
    ':bank_details' => $bank_details,
    ':register_by' => $register_by,
    ':user_type' => $user_type,
    ':status' => $status
]);

if ($result) {
    // Log entry
    $title="Employee ";
    $message= "Employee has been Added";
    $message2= "Employee has been Added By Admin";
	$operation = "Add";
    $fromWhom="1";

    $sql3= "INSERT INTO logs ( title,message,message2, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :register_by, :from_whom, :operation)";
    $stmt = $conn->prepare($sql3);
    $stmt->execute([
        ':title' => $title,
        ':message' => $message,
        ':message2' =>$message2,
        // ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
		':operation' => $operation
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Employee added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error adding employee']);
}
?>
