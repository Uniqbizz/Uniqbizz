<?php
include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

$id       = $_GET['id'] ?? '';
$edittype = $_GET['edittype'] ?? '';

if (empty($id) || empty($edittype)) {
    echo json_encode([
        'status' => false,
        'message' => 'Missing parameters'
    ]);
    exit;
}

/*------------------------------------
| Table Selection
-------------------------------------*/
switch ($edittype) {

    case '26':
        $table = "business_mentor";
        $customField = "business_mentor_id";
        break;

    default:
        echo json_encode([
            'status' => false,
            'message' => 'Invalid Edit Type'
        ]);
        exit;
}

/*------------------------------------
| Search by ID or Business Mentor ID
-------------------------------------*/

$field = preg_match('/^(BM)/i', $id)
    ? $customField
    : 'id';

$stmt = $conn->prepare("
    SELECT *
    FROM {$table}
    WHERE {$field} = ?
    LIMIT 1
");

$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {

    echo json_encode([
        'status' => false,
        'message' => 'Record not found'
    ]);

    exit;
}


/*------------------------------------
| Country
-------------------------------------*/

$country_name = "";

if (!empty($row['country'])) {

    $stmtCountry = $conn->prepare("
        SELECT country_name
        FROM countries
        WHERE id=?
        LIMIT 1
    ");

    $stmtCountry->execute([$row['country']]);

    $country = $stmtCountry->fetch(PDO::FETCH_ASSOC);

    $country_name = $country['country_name'] ?? "";
}


/*------------------------------------
| State
-------------------------------------*/

$state_name = "";

if (!empty($row['state'])) {

    $stmtState = $conn->prepare("
        SELECT state_name
        FROM states
        WHERE id=?
        LIMIT 1
    ");

    $stmtState->execute([$row['state']]);

    $state = $stmtState->fetch(PDO::FETCH_ASSOC);

    $state_name = $state['state_name'] ?? "";
}


/*------------------------------------
| City
-------------------------------------*/

$city_name = "";

if (!empty($row['city'])) {

    $stmtCity = $conn->prepare("
        SELECT city_name
        FROM cities
        WHERE id=?
        LIMIT 1
    ");

    $stmtCity->execute([$row['city']]);

    $city = $stmtCity->fetch(PDO::FETCH_ASSOC);

    $city_name = $city['city_name'] ?? "";
}


/*------------------------------------
| Response
-------------------------------------*/

$response = [

    "status" => true,

    "data" => [

        "id" => $row['id'],
        "application_id" => $row['application_id'] ?? '',
        "business_mentor_id" => $row['business_mentor_id'] ?? '',

        "firstname" => $row['firstname'],
        "lastname" => $row['lastname'],

        "nominee_name" => $row['nominee_name'],
        "nominee_relation" => $row['nominee_relation'],

        "email" => $row['email'],

        "country_code" => $row['country_code'],
        "contact_no" => $row['contact_no'],

        "date_of_birth" => $row['date_of_birth'],
        "age" => $row['age'],
        "gender" => $row['gender'],

        "country" => $row['country'],
        "country_name" => $country_name,

        "state" => $row['state'],
        "state_name" => $state_name,

        "city" => $row['city'],
        "city_name" => $city_name,

        "pincode" => $row['pincode'],
        "address" => $row['address'],

        "zone" => $row['zone'],
        "branch" => $row['branch'],

        "profile_pic" => $row['profile_pic'],

        "pan_card" => $row['pan_card'],
        "aadhar_card" => $row['aadhar_card'],
        "voting_card" => $row['voting_card'],
        "bank_passbook" => $row['bank_passbook'],

        "reference_no" => $row['reference_no'],
        "registrant" => $row['registrant'],
        "register_by" => $row['register_by'],

        "user_type" => $row['user_type'],
        "status" => $row['status'],

        "created_at" => $row['created_at'] ?? '',
        "updated_at" => $row['updated_at'] ?? ''
    ]

];

echo json_encode($response);
exit;