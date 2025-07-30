<?php
require "../connect.php";
$current_year = date('Y');

// Read JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

$fid = $data["ref_id"];
$editfor = $data["editfor"];

if ($editfor == 'pending') {
    $identifier_id = $data["id"];
    $identifier_name = 'id=';
    $message = "Updated Business Mentor details from pending list";
    $message2 = "Updated Business Mentor details from pending list";
} else if ($editfor == 'registered') {
    $identifier_id = $data["id"];
    $identifier_name = 'business_mentor_id=';
    $message = "$identifier_id Details has been updated from registered list";
    $message2 = "$identifier_id Details has been updated from registered list";
}

// Extract data
$firstname = $data['firstname'];
$lastname = $data['lastname'];
$nominee_name = $data['nominee_name'];
$nominee_relation = $data['nominee_relation'];
$email = $data['email'];
$gender = $data['gender'];
$country_code = $data['country_code'];
$phone = $data['phone'];
$dob = $data['dob'];
$birth_year = substr($dob, 0, 4);
$age = $current_year - $birth_year;

$profile_pic = $data['profile_pic'];
$pan_card = $data['pan_card'];
$aadhar_card = $data['aadhar_card'];
$voting_card = $data['voting_card'];
$bank_passbook = $data['passbook'];
$address = $data['address'];
$pincode = $data['pincode'];
$country = $data['country'];
$state = $data['state'];
$city = $data['city'];
$zone = $data['zone'];
$branch = $data['branch'];

$user_type_id = '26';
$title="Business Mentor";

$fromWhom="1";
$register_by="1";
$operation = 'Update';

if ($firstname || $lastname || $phone || $email || $gender || $dob || $address || $profile_pic) {
    $sql1 = "UPDATE business_mentor SET firstname=:firstname, lastname=:lastname, nominee_name=:nominee_name, nominee_relation=:nominee_relation, country_code=:country_code, contact_no=:contact_no, email=:email, gender=:gender, date_of_birth=:date_of_birth, age=:age, country=:country, state=:state, city=:city, pincode=:pincode, address=:address, zone=:zone, branch=:branch, profile_pic=:profile_pic, pan_card=:pan_card, aadhar_card=:aadhar_card, voting_card=:voting_card, bank_passbook=:passbook WHERE $identifier_name:identifier_id";
    
    $stmt = $conn->prepare($sql1);
    $result = $stmt->execute([
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
        ':zone' => $zone,
        ':branch' => $branch,
        ':profile_pic' => $profile_pic,
        ':age' => $age,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':passbook' => $bank_passbook,
        ':identifier_id' => $identifier_id
    ]);

    if ($result) {
        $sql = "UPDATE login SET username=:email WHERE user_id=:user_id AND user_type_id=:user_type_id";
        $stmt2 = $conn->prepare($sql);
        $result2 = $stmt2->execute([
            ':email' => $email,
            ':user_type_id' => $user_type_id,
            ':user_id' => $identifier_id
        ]);

        if ($result2) {
            $sql3 = "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt3 = $conn->prepare($sql3);
            $result3 = $stmt3->execute([
            ':user_id' => $identifier_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $fid,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
            ]);

            echo json_encode(["status" => "success", "message" => "Business mentor edited successfully!"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
}
?>
