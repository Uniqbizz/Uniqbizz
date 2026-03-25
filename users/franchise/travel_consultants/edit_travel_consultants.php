<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require "../../../connect.php";

$response = ['success' => false, 'message' => '', 'data' => null];

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Only POST method is allowed';
    echo json_encode($response);
    exit();
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

try {
    // Assign input data
    $fid = $input['ref_id'] ?? '';
    $editfor = $input['editfor'];
    $identifier_id = $input['id'];
    $firstname = $input['firstname'];
    $lastname = $input['lastname'];
    $nominee_name = $input['nominee_name'] ?? '';
    $nominee_relation = $input['nominee_relation'] ?? '';
    $email = $input['email'];
    $gender = $input['gender'] ?? '';
    $country_code = $input['country_code'] ?? '';
    $phone = $input['phone'];
    $dob = $input['dob'];
    $profile_pic = $input['profile_pic'] ?? '';
    $pan_card = $input['pan_card'] ?? '';
    $aadhar_card = $input['aadhar_card'] ?? '';
    $voting_card = $input['voting_card'] ?? '';
    $bank_passbook = $input['passbook'] ?? '';
    $payment_proof = $input['payment_proof'] ?? '';
    $payment_fee = $input['payment_fee'] ?? 0;
    $payment_mode = $input['payment_mode'] ?? '';
    $cheque_no = $input['cheque_no'] ?? '';
    $cheque_date = $input['cheque_date'] ?? '';
    $bank_name = $input['bank_name'] ?? '';
    $transaction_no = $input['transaction_no'] ?? '';
    $address = $input['address'] ?? '';
    $pincode = $input['pincode'] ?? '';
    $country = $input['country'] ?? '';
    $state = $input['state'] ?? '';
    $city = $input['city'] ?? '';
    $userId = $input['reference_no'];
    $userType = $input['register_by'];
    
    $user_type_id = $userType;
    $current_year = date('Y');

    // Calculate age
    $birthYear = substr($dob, 0, 4);
    $age = $current_year - (int)$birthYear;

    // Set identifier based on editfor
    if ($editfor == 'pending') {
        $identifier_condition = 'id=:identifier_id';
        $message = "Updated Travel Consultant id details from pending list";
    } else if ($editfor == 'registered') {
        $identifier_condition = 'ca_travelagency_id=:identifier_id';
        $message = $identifier_id . " Details has been updated from registered list";
    }
    
    $title = "Travel Consultant";
    $operation = "Edit";
    $fromWhom = $userType;
    $register_by = $userType;
    $message2 = $message;

    // Update ca_travelagency table
    $sql1 = "UPDATE ca_travelagency SET 
        firstname=:firstname,
        lastname=:lastname,
        nominee_name=:nominee_name,
        nominee_relation=:nominee_relation,
        country_code=:country_code,
        contact_no=:contact_no,
        email=:email,
        gender=:gender,
        date_of_birth=:date_of_birth,
        age=:age,
        country=:country,
        state=:state,
        city=:city,
        pincode=:pincode,
        address=:address,
        payment_mode=:payment_mode,
        cheque_no=:cheque_no,
        cheque_date=:cheque_date,
        bank_name=:bank_name,
        transaction_no=:transaction_no,
        profile_pic=:profile_pic,
        pan_card=:pan_card,
        aadhar_card=:aadhar_card,
        voting_card=:voting_card,
        passbook=:passbook,
        payment_proof=:payment_proof 
        WHERE $identifier_condition";

    $stmt = $conn->prepare($sql1);
    
    $params = [
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':country_code' => $country_code,
        ':contact_no' => $phone,
        ':email' => $email,
        ':gender' => $gender,
        ':date_of_birth' => $dob,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,
        ':profile_pic' => $profile_pic,
        ':age' => $age,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':passbook' => $bank_passbook,
        ':payment_proof' => $payment_proof,
        ':payment_mode' => $payment_mode,
        ':cheque_no' => $cheque_no,
        ':cheque_date' => $cheque_date,
        ':bank_name' => $bank_name,
        ':transaction_no' => $transaction_no,
        ':identifier_id' => $identifier_id
    ];

    $result = $stmt->execute($params);

    if ($result) {
        // Update login table
        $sql2 = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':email' => $email,
            ':user_type_id' => $user_type_id,
            ':user_id' => $identifier_id
        ]);

        if ($result2) {
            // Insert into logs
            $sql3 = "INSERT INTO logs (user_id, title, message, message2, reference_no, register_by, from_whom, operation) 
                     VALUES (:user_id, :title, :message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            
            $stmt3 = $conn->prepare($sql3);
            $result3 = $stmt3->execute([
                ':user_id' => $identifier_id,
                ':title' => $title,
                ':message' => $message,
                ':message2' => $message2,
                ':reference_no' => $userId,
                ':register_by' => $userType,
                ':from_whom' => $fromWhom,
                ':operation' => $operation
            ]);

            if ($result3) {
                $response['success'] = true;
                $response['message'] = 'Travel Consultant updated successfully';
                $response['data'] = [
                    'id' => $identifier_id,
                    'name' => "$firstname $lastname",
                    'email' => $email
                ];
            } else {
                $response['success'] = true;
                $response['message'] = 'Travel Consultant Details updated but log creation failed';
                $response['data'] = ['id' => $identifier_id];
            }
        } else {
            $response['message'] = 'Failed to update login details';
        }
    } else {
        $response['message'] = 'Failed to update Travel Consultant details';
    }

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>