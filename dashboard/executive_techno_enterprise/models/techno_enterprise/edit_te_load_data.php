<?php
    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $id = $_GET['id'] ?? '';
    $edittype = $_GET['edittype'] ?? '';

    if (empty($id) || empty($edittype)) {
        echo json_encode([
            'status' => false,
            'message' => 'Missing parameters'
        ]);
        exit;
    }

    switch ($edittype) {

        case '16':
            $table = 'corporate_agency';
            $customField = 'corporate_agency_id';
            break;

        case '29':
            $table = 'sub_franchisee';
            $customField = 'sub_franchisee_id';
            break;
        case '32':
            $table = 'institution';
            $customField = 'institution_id';
            break;

        default:
            echo json_encode([
                'status' => false,
                'message' => 'Invalid edit type'
            ]);
            exit;
    }

    $field = preg_match('/^(TE|F|I|CA)/i', $id)
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

    /* Country */
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

    /* State */
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

    /* City */
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

    $response = [
        'status' => true,
        'data' => [
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'nominee_name' => $row['nominee_name'],
            'nominee_relation' => $row['nominee_relation'],
            'email' => $row['email'],
            'contact_no' => $row['contact_no'],
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
        ]
    ];

    echo json_encode($response);
    exit;