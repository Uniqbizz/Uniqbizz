
<?php
/*
Last updated by SV on 12-11-2026
payload example
{
  "id": "TE260136",
  "edittype": "16"
}
*/
require '../../../../connect.php';

header('Content-Type: application/json');

// ==========================================
// 1. REQUEST METHOD VALIDATION
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        'status' => false,
        'message' => 'Invalid request method.',
        'data' => []
    ]);

    exit;
}

try {

    // Read JSON request body
    $json = file_get_contents('php://input');
    $input = json_decode($json, true);

    // Fallback to POST form-data
    if (!is_array($input)) {
        $input = $_POST;
    }

    if (!is_array($input) || empty($input)) {
        throw new Exception('Invalid or empty request data.');
    }

    $id = trim($input['id'] ?? '');
    $edittype = trim($input['edittype'] ?? '');

    if ($id === '' || $edittype === '') {
        throw new Exception('Missing parameters.');
    }

    // ==========================================
    // 3. DETERMINE SOURCE TABLE
    // ==========================================

    switch ($edittype) {

        case '16':
            $table = 'corporate_agency';
            $customField = 'corporate_agency_id';
            break;

        case '29':
            $table = 'sub_franchisee';
            $customField = 'sub_franchisee_id';
            break;

        default:
            throw new Exception('Invalid edit type.');
    }

    // ==========================================
    // 4. DETERMINE SEARCH FIELD
    // ==========================================

    $field = preg_match('/^(TE|F|CA)/i', $id)
        ? $customField
        : 'id';

    // ==========================================
    // 5. FETCH USER DETAILS
    // ==========================================

    $sql = $conn->prepare("
        SELECT *
        FROM {$table}
        WHERE {$field} = :id
        LIMIT 1
    ");

    $sql->execute([
        ':id' => $id
    ]);

    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception('Record not found.');
    }

    // ==========================================
    // 6. FETCH COUNTRY NAME
    // ==========================================

    $countryname = '';

    if (!empty($row['country'])) {

        $countryStmt = $conn->prepare("
            SELECT country_name
            FROM countries
            WHERE id = :id
            AND status = '1'
            LIMIT 1
        ");

        $countryStmt->execute([
            ':id' => $row['country']
        ]);

        $country = $countryStmt->fetch(PDO::FETCH_ASSOC);

        if ($country) {
            $countryname = $country['country_name'];
        }
    }

    // ==========================================
    // 7. FETCH STATE NAME
    // ==========================================

    $statename = '';

    if (!empty($row['state'])) {

        $stateStmt = $conn->prepare("
            SELECT state_name
            FROM states
            WHERE id = :id
            AND status = '1'
            LIMIT 1
        ");

        $stateStmt->execute([
            ':id' => $row['state']
        ]);

        $state = $stateStmt->fetch(PDO::FETCH_ASSOC);

        if ($state) {
            $statename = $state['state_name'];
        }
    }

    // ==========================================
    // 8. FETCH CITY NAME
    // ==========================================

    $cityname = '';

    if (!empty($row['city'])) {

        $cityStmt = $conn->prepare("
            SELECT city_name
            FROM cities
            WHERE id = :id
            AND status = '1'
            LIMIT 1
        ");

        $cityStmt->execute([
            ':id' => $row['city']
        ]);

        $city = $cityStmt->fetch(PDO::FETCH_ASSOC);

        if ($city) {
            $cityname = $city['city_name'];
        }
    }

    // ==========================================
    // 9. PREPARE RESPONSE DATA
    // ==========================================

    $responseData = [

        'id' => $row['id'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'nominee_name' => $row['nominee_name'],
        'nominee_relation' => $row['nominee_relation'],
        'email' => $row['email'],
        'contact_no' => $row['contact_no'],
        'contact_code' => $row['country_code'],
        'amount' => $row['amount'],
        'reference_no' => $row['reference_no'],
        'registrant' => $row['registrant'],
        'gst_no' => $row['gst_no'],
        'date_of_birth' => $row['date_of_birth'],
        'gender' => $row['gender'],

        'country' => $row['country'],
        'country_name' => $countryname,

        'state' => $row['state'],
        'state_name' => $statename,

        'city' => $row['city'],
        'city_name' => $cityname,

        'address' => $row['address'],
        'pincode' => $row['pincode'],

        'payment_mode' => $row['payment_mode'],
        'cheque_no' => $row['cheque_no'],
        'cheque_date' => $row['cheque_date'],
        'bank_name' => $row['bank_name'],
        'transaction_no' => $row['transaction_no'],

        'profile_pic' => $row['profile_pic'],
        'pan_card' => $row['pan_card'],
        'aadhar_card' => $row['aadhar_card'],
        'voting_card' => $row['voting_card'],
        'bank_passbook' => $row['bank_passbook'],
        'payment_proof' => $row['payment_proof'],

        'note' => $row['note']

    ];

    // ==========================================
    // 10. SUCCESS RESPONSE
    // ==========================================

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully.',
        'data' => $responseData
    ]);

} catch (PDOException $e) {

    // Log actual database error
    error_log('Edit Details API PDO Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred.',
        'data' => []
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);

}

exit;

?>