<?php

require '../../../../connect.php';

header('Content-Type: application/json');

try {

    // ==========================================
    // 1. REQUEST METHOD VALIDATION
    // ==========================================

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        http_response_code(405);

        echo json_encode([
            'status' => false,
            'message' => 'Method not allowed'
        ]);
        exit;
    }

    // ==========================================
    // 2. GET JSON PARAMETERS
    // ==========================================

    $postData = json_decode(file_get_contents('php://input'), true);

    if (!is_array($postData)) {

        echo json_encode([
            'status' => false,
            'message' => 'Invalid JSON data'
        ]);
        exit;
    }

    $id = trim($postData['id'] ?? '');
    $edittype = '11';

    if ($id === '') {

        echo json_encode([
            'status' => false,
            'message' => 'Missing parameters'
        ]);
        exit;
    }

    // ==========================================
    // 3. TABLE MAPPING
    // ==========================================

    switch ($edittype) {

        case '11':
            $table = 'ca_travelagency';
            $customField = 'ca_travelagency_id';
            break;

        default:
            echo json_encode([
                'status' => false,
                'message' => 'Invalid edit type'
            ]);
            exit;
    }

    // ==========================================
    // 4. IDENTIFY ID FIELD
    // ==========================================

    $field = preg_match('/^TA/i', $id)
        ? $customField
        : 'id';

    // ==========================================
    // 5. FETCH TRAVEL AGENCY
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

        echo json_encode([
            'status' => false,
            'message' => 'Record not found'
        ]);
        exit;
    }

    // ==========================================
    // 6. COUNTRY
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

        if ($country = $countryStmt->fetch(PDO::FETCH_ASSOC)) {
            $countryname = $country['country_name'];
        }
    }

    // ==========================================
    // 7. STATE
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

        if ($state = $stateStmt->fetch(PDO::FETCH_ASSOC)) {
            $statename = $state['state_name'];
        }
    }

    // ==========================================
    // 8. CITY
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

        if ($city = $cityStmt->fetch(PDO::FETCH_ASSOC)) {
            $cityname = $city['city_name'];
        }
    }

    // ==========================================
    // 9. RESPONSE
    // ==========================================

    $response = [
        'status' => true,
        'data' => [
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'contact_no' => $row['contact_no'],
            'amount' => $row['amount'],
            'nominee_relation' => $row['nominee_relation'],
            'nominee_name' => $row['nominee_name'],
            'reference_no' => $row['reference_no'],
            'registrant' => $row['registrant'],
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
            'country_code' => $row['country_code']
        ]
    ];

    echo json_encode($response);
    exit;

} catch (PDOException $e) {

    error_log('TA Edit API Database Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => 'Database error occurred'
    ]);
    exit;

} catch (Exception $e) {

    error_log('TA Edit API Error: ' . $e->getMessage());

    echo json_encode([
        'status' => false,
        'message' => 'Something went wrong'
    ]);
    exit;
}

?>