<?php
    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $id = $_POST['id'] ?? '';
    $edittype = $_POST['edittype'] ?? '';

    if (empty($id) || empty($edittype)) {
        echo json_encode([
            'status' => false,
            'message' => 'Missing parameters'
        ]);
        exit;
    }

    switch ($edittype) {

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

    $field = preg_match('/^(TE|F|I)/i', $id)
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

    $response['data'] = [
        'id' => $row['id'],
        'institution_id' => $row['institution_id'],
        'name' => $row['name'],
        'no_of_branches' => $row['no_of_branches'],
        'types_of_institution' => $row['types_of_institution'],
        'incorporation_date' => $row['incorporation_date'],
        'institution_pan' => $row['institution_pan'],
        'email' => $row['email'],
        'contact_no' => $row['contact_no'],
        'country' => $row['country'],
        'country_name' => $countryname,
        'state' => $row['state'],
        'state_name' => $statename,
        'city' => $row['city'],
        'city_name' => $cityname,
        'pincode' => $row['pincode'],
        'address' => $row['address'],

        'account_name' => $row['account_name'],
        'account_number' => $row['account_number'],
        'ifsc_code' => $row['ifsc_code'],
        'bank_and_branch_name' => $row['bank_and_branch_name'],

        'amount' => $row['amount'],
        'current_commission_per' => $row['current_commission_per'],
        'current_incentive_per' => $row['current_incentive_per'],

        'payment_mode' => $row['payment_mode'],
        'cheque_no' => $row['cheque_no'],
        'cheque_date' => $row['cheque_date'],
        'bank_name' => $row['bank_name'],
        'transaction_no' => $row['transaction_no'],

        'certificate_of_incorporation' => $row['certificate_of_incorporation'],
        'gstin' => $row['gstin'],
        'pan_card' => $row['pan_card'],
        'address_proof' => $row['address_proof'],
        'board_resolution' => $row['board_resolution'],
        'bank_passbook' => $row['bank_passbook'],
        'payment_proof' => $row['payment_proof'],

        'reference_no' => $row['reference_no'],
        'status' => $row['status']
    ];

    

    echo json_encode($response);
    exit;