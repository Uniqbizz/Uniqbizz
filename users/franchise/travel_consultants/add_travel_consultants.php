<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require '../../../connect.php';

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
    $user_id_name = $input['user_id_name'];
    $registrant = $input['reference_name'] ?? '';
    $firstname = $input['firstname'];
    $lastname = $input['lastname'];
    $nominee_name = $input['nominee_name'] ?? '';
    $nominee_relation = $input['nominee_relation'] ?? '';
    $email = $input['email'];
    $gender = $input['gender'] ?? '';
    $country_code = $input['country_code'] ?? '';
    $phone_no = $input['phone'];
    $bdate = $input['dob'];
    $profile_pic = $input['profile_pic'] ?? '';
    $pan_card = $input['pan_card'] ?? '';
    $aadhar_card = $input['aadhar_card'] ?? '';
    $voting_card = $input['voting_card'] ?? '';
    $passbook = $input['passbook'] ?? '';
    $payment_proof = $input['payment_proof'] ?? '';
    $payment_fee = $input['amount'] ?? 0;
    $paymentMode = $input['payment_mode'] ?? '';
    $chequeNo = $input['cheque_no'] ?? '';
    $chequeDate = $input['cheque_date'] ?? '';
    $bankName = $input['bank_name'] ?? '';
    $transactionNo = $input['transaction_no'] ?? '';
    $address = $input['address'] ?? '';
    $pincode = $input['pincode'] ?? '';
    $country = $input['country'] ?? '';
    $state = $input['state'] ?? '';
    $city = $input['city'] ?? '';
    $userId = $input['userId'];
    $userType = $input['register_by'];
    
    if($paymentMode == "free"){
        $paymentMode = "Free";
    }

    // Set constants
    $status = "2";
    $user_type = "29";
    $register_by = $userType;
    $current_year = date('Y');

    // Calculate age
    $birthYear = substr($bdate, 0, 4);
    $age = $current_year - (int)$birthYear;

    // Insert into main table
    $sql = "INSERT INTO `ca_travelagency` (
        firstname, lastname, nominee_name, nominee_relation, email, 
        country_code, contact_no, date_of_birth, age, gender, country, 
        state, city, pincode, address, profile_pic, pan_card, aadhar_card, 
        voting_card, passbook, payment_proof, amount, payment_mode, 
        cheque_no, cheque_date, bank_name, transaction_no, user_type, 
        registrant, reference_no, register_by, status
    ) VALUES (
        :firstname, :lastname, :nominee_name, :nominee_relation, :email, 
        :country_code, :contact_no, :bdate, :age, :gender, :country, 
        :state, :city, :pincode, :address, :profile_pic, :pan_card, 
        :aadhar_card, :voting_card, :passbook, :payment_proof, :amount, 
        :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, 
        :user_type, :registrant, :reference_no, :register_by, :status
    )";

    $stmt = $conn->prepare($sql);
    
    $result = $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':email' => $email,
        ':country_code' => $country_code,
        ':contact_no' => $phone_no,
        ':bdate' => $bdate,
        ':age' => $age,
        ':gender' => $gender,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,
        ':profile_pic' => $profile_pic,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':passbook' => $passbook,
        ':payment_proof' => $payment_proof,
        ':amount' => $payment_fee,
        ':payment_mode' => $paymentMode,
        ':cheque_no' => $chequeNo,
        ':cheque_date' => $chequeDate,
        ':bank_name' => $bankName,
        ':transaction_no' => $transactionNo,
        ':user_type' => $user_type,
        ':registrant' => $registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ]);

    if ($result) {
        // Get last inserted ID
        $last_id = $conn->lastInsertId();
        
        // Prepare log data
        $title = "Travel Consultant";
        $message = "Added new Travel Consultant. TC name - $firstname $lastname";
        $message2 = "Added new Travel Consultant. By - $userId";
        $fromWhom = $userType;
        $operation = "Add";
        
        // Insert into logs
        $sql3 = "INSERT INTO logs (user_id, title, message, message2, reference_no, register_by, from_whom, operation) 
                 VALUES (:user_id, :title, :message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        
        $stmt3 = $conn->prepare($sql3);
        $result3 = $stmt3->execute([
            ':user_id' => $last_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' => $message2,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ]);

        if ($result3) {
            $response['success'] = true;
            $response['message'] = 'Travel Consultant added successfully';
            $response['data'] = [
                'id' => $last_id,
                'name' => "$firstname $lastname",
                'reference_no' => $user_id_name,
                'email' => $email
            ];
        } else {
            $response['success'] = true;
            $response['message'] = 'Travel Consultant added but logs not created';
            $response['data'] = ['id' => $last_id];
        }
    } else {
        $response['message'] = 'Failed to add Travel Consultant';
    }

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>