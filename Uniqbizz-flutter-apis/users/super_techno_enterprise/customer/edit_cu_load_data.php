<?php

require '../../../../connect.php';

header('Content-Type: application/json');

try {

    // ==========================================
    // 1. REQUEST METHOD VALIDATION
    // ==========================================

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        http_response_code(405);

        throw new Exception('Method not allowed.');
    }

    // ==========================================
    // 2. GET JSON PARAMETERS
    // ==========================================

    $postData = json_decode(file_get_contents('php://input'), true);

    if (!is_array($postData)) {
        throw new Exception('Invalid JSON data.');
    }

    $id = trim($postData['id'] ?? '');
    $edittype = trim((string)($postData['edittype'] ?? '10'));

    if ($id === '' || $edittype === '') {
        throw new Exception('Missing parameters.');
    }

    // ==========================================
    // 3. EDIT TYPE VALIDATION
    // ==========================================

    switch ($edittype) {

        case '10':

            $table = 'ca_customer';
            $customField = 'ca_customer_id';

            break;

        default:

            throw new Exception('Invalid edit type.');
    }

    // ==========================================
    // 4. IDENTIFY SEARCH FIELD
    // ==========================================

    $field = preg_match('/^CU/i', $id)
        ? $customField
        : 'id';

    // ==========================================
    // 5. FETCH CUSTOMER DETAILS
    // ==========================================

    $stmt = $conn->prepare("
        SELECT *
        FROM {$table}
        WHERE {$field} = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception('Record not found.');
    }

    // ==========================================
    // 6. FETCH COUNTRY
    // ==========================================

    $countryname = '';

    if (!empty($row['country'])) {

        $countryStmt = $conn->prepare("
            SELECT country_name
            FROM countries
            WHERE id = ?
              AND status = '1'
        ");

        $countryStmt->execute([$row['country']]);

        $country = $countryStmt->fetch(PDO::FETCH_ASSOC);

        if ($country) {
            $countryname = $country['country_name'];
        }
    }

    // ==========================================
    // 7. FETCH STATE
    // ==========================================

    $statename = '';

    if (!empty($row['state'])) {

        $stateStmt = $conn->prepare("
            SELECT state_name
            FROM states
            WHERE id = ?
              AND status = '1'
        ");

        $stateStmt->execute([$row['state']]);

        $state = $stateStmt->fetch(PDO::FETCH_ASSOC);

        if ($state) {
            $statename = $state['state_name'];
        }
    }

    // ==========================================
    // 8. FETCH CITY
    // ==========================================

    $cityname = '';

    if (!empty($row['city'])) {

        $cityStmt = $conn->prepare("
            SELECT city_name
            FROM cities
            WHERE id = ?
              AND status = '1'
        ");

        $cityStmt->execute([$row['city']]);

        $city = $cityStmt->fetch(PDO::FETCH_ASSOC);

        if ($city) {
            $cityname = $city['city_name'];
        }
    }

    // ==========================================
    // 9. RESPONSE
    // ==========================================

    $response = [
        'status' => true,
        'message' => 'Customer details fetched successfully',

        'data' => [
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'contact_no' => $row['contact_no'],

            'amount' => $row['paid_amount'],

            'reference_no' => $row['reference_no'],
            'registrant' => $row['registrant'],

            'ta_reference_no' => $row['ta_reference_no'],
            'ta_reference_name' => $row['ta_reference_name'],

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
            'bank_passbook' => $row['passbook'],
            'payment_proof' => $row['payment_proof'],

            'customer_type' => $row['customer_type'],
            'country_code' => $row['country_code']
        ]
    ];

    echo json_encode($response);
    exit;

} catch (PDOException $e) {

    error_log('CU Edit API PDO Error: ' . $e->getMessage());

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