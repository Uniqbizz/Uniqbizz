<?php
require '../../connect.php';

$design = $_POST['designation'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$response = [];

// Define mapping of designations to tables and columns
$mapping = [
    'bm'  => [
        'table'       => 'business_mentor',
        'user_col'    => 'business_mentor_id',
        'firstname'   => 'firstname',
        'lastname'    => 'lastname',
        'email'       => 'email',
        'contact_no'  => 'contact_no',
        'address'     => 'address'
    ],
    'bdm' => [
        'table'    => 'employees',
        'user_col' => 'employee_id',
        'name'     => 'name',
        'email'    => 'email',
        'contact'  => 'contact',
        'address'  => 'address'
    ],
    'bcm' => [
        'table'    => 'employees',
        'user_col' => 'employee_id',
        'name'     => 'name',
        'email'    => 'email',
        'contact'  => 'contact',
        'address'  => 'address'
    ]
];

if (isset($mapping[$design]) && !empty($user_id)) {
    $map = $mapping[$design];

    // Build dynamic column selection
    $columns = array_filter([
        $map['user_col'],
        $map['firstname'] ?? '',
        $map['lastname'] ?? '',
        $map['name'] ?? '',
        $map['email'] ?? '',
        $map['contact_no'] ?? '',
        $map['contact'] ?? '',
        $map['address'] ?? ''
    ]);

    $columnList = implode(', ', $columns);

    // Prepare SQL query
    $sql = "SELECT $columnList FROM {$map['table']} WHERE {$map['user_col']} = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    $response = $stmt->fetch(PDO::FETCH_ASSOC);
}
// Return user details in JSON format
echo json_encode($response);
?>
