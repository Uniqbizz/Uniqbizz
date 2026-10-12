<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    /*
    |--------------------------------------------------------------------------
    | Get POST Parameters
    |--------------------------------------------------------------------------
    */

    $id = isset($_POST['id'])
        ? trim((string)$_POST['id'])
        : '';

    $edittype = isset($_POST['edittype'])
        ? trim((string)$_POST['edittype'])
        : '';


    /*
    |--------------------------------------------------------------------------
    | Validate Parameters
    |--------------------------------------------------------------------------
    */

    if ($id === '' || $edittype === '') {

        echo json_encode([
            'status' => false,
            'message' => 'Missing parameters',
            'debug' => [
                'received_id' => $id,
                'received_edittype' => $edittype,
                'post' => $_POST
            ]
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Select Table Based On User Type
    |--------------------------------------------------------------------------
    |
    | 11 = Travel Consultant
    | 33 = Institution Branch Manager
    |
    */

    switch ($edittype) {

        case '11':

            $table = 'ca_travelagency';
            $customField = 'ca_travelagency_id';

            break;


        case '33':

            $table = 'institution_branch_manager';
            $customField = 'institution_branch_manager_id';

            break;


        default:

            echo json_encode([
                'status' => false,
                'message' => 'Invalid edit type',
                'received_edittype' => $edittype
            ]);

            exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Determine ID Field
    |--------------------------------------------------------------------------
    |
    | Example:
    | TA00001  -> ca_travelagency_id
    | IBR00001 -> institution_branch_manager_id
    | 1        -> id
    |
    */

    if (preg_match('/^(TA|IBR)/i', $id)) {

        $field = $customField;

    } else {

        $field = 'id';
    }


    /*
    |--------------------------------------------------------------------------
    | Get User Details
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        SELECT *
        FROM {$table}
        WHERE {$field} = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | Record Not Found
    |--------------------------------------------------------------------------
    */

    if (!$row) {

        echo json_encode([
            'status' => false,
            'message' => 'Record not found',
            'table' => $table,
            'field' => $field,
            'id' => $id
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Country
    |--------------------------------------------------------------------------
    */

    $countryname = '';

    if (!empty($row['country'])) {

        $countryStmt = $conn->prepare("
            SELECT country_name
            FROM countries
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $countryStmt->execute([$row['country']]);

        $country = $countryStmt->fetch(PDO::FETCH_ASSOC);

        if ($country) {
            $countryname = $country['country_name'];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    $statename = '';

    if (!empty($row['state'])) {

        $stateStmt = $conn->prepare("
            SELECT state_name
            FROM states
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $stateStmt->execute([$row['state']]);

        $state = $stateStmt->fetch(PDO::FETCH_ASSOC);

        if ($state) {
            $statename = $state['state_name'];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | City
    |--------------------------------------------------------------------------
    */

    $cityname = '';

    if (!empty($row['city'])) {

        $cityStmt = $conn->prepare("
            SELECT city_name
            FROM cities
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $cityStmt->execute([$row['city']]);

        $city = $cityStmt->fetch(PDO::FETCH_ASSOC);

        if ($city) {
            $cityname = $city['city_name'];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'status' => true,
        'data' => [

            'id' => $row['id'],

            'user_type' => $row['user_type'] ?? $edittype,

            'firstname' => $row['firstname'] ?? '',
            'lastname' => $row['lastname'] ?? '',

            'email' => $row['email'] ?? '',
            'contact_no' => $row['contact_no'] ?? '',
            'country_code' => $row['country_code'] ?? '',

            'amount' => $row['amount'] ?? '',

            'nominee_relation' => $row['nominee_relation'] ?? '',
            'nominee_name' => $row['nominee_name'] ?? '',

            'reference_no' => $row['reference_no'] ?? '',
            'registrant' => $row['registrant'] ?? '',

            'date_of_birth' => $row['date_of_birth'] ?? '',
            'gender' => $row['gender'] ?? '',

            'country' => $row['country'] ?? '',
            'country_name' => $countryname,

            'state' => $row['state'] ?? '',
            'state_name' => $statename,

            'city' => $row['city'] ?? '',
            'city_name' => $cityname,

            'address' => $row['address'] ?? '',
            'pincode' => $row['pincode'] ?? '',
            'branch' => $row['branch'] ?? '',

            'payment_mode' => $row['payment_mode'] ?? '',
            'cheque_no' => $row['cheque_no'] ?? '',
            'cheque_date' => $row['cheque_date'] ?? '',

            'bank_name' => $row['bank_name'] ?? '',
            'transaction_no' => $row['transaction_no'] ?? '',

            'profile_pic' => $row['profile_pic'] ?? '',
            'pan_card' => $row['pan_card'] ?? '',
            'aadhar_card' => $row['aadhar_card'] ?? '',
            'voting_card' => $row['voting_card'] ?? '',
            'bank_passbook' => $row['passbook'] ?? '',
            'payment_proof' => $row['payment_proof'] ?? ''
        ]
    ]);

    exit;

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);

    exit;
}