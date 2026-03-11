<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
    exit;
}

include '../../connect.php';
$current_year = date('Y');

$name          = $_POST['name'];
$birth_date    = $_POST['birth_date'];
$country_cd    = $_POST['country_cd'];
$contact       = $_POST['contact'];
$email         = $_POST['email'];
$address       = $_POST['address'];
$gender        = $_POST['gender'];
$country       = $_POST['country'];
$state         = $_POST['state'];
$city          = $_POST['city'];
$pincode       = $_POST['pin'];
$zone          = $_POST['zonal'];
$profile_pic   = $_POST['profile_pic'];
$pan_card      = $_POST['pancard'];
$aadhar_card   = $_POST['addar'];
$bank_details  = $_POST['bank_details'];
$note          = $_POST['note'];
$register_by   = '1'; // Admin
$status        = '2';
$user_type     = '27'; // Assuming user_type 26 = Zonal Manager

// Get age from birth year
$birth_year    = substr($birth_date, 0, 4);
$age           = $current_year - (int)$birth_year;

// Log file data
$title         = "Zonal Manager";
$message       = "Zonal Manager has been added";
$message2      = "Zonal Manager has been added by Admin";
$operation     = "Add";
$fromWhom      = "1";

// Insert query (only required fields)
$sql = "INSERT INTO zonal_manager (
            name, date_of_birth, country_code, contact, email, address,
            gender, country, state, city, pincode, zone, note,
            profile_pic, pan_card, aadhar_card, bank_passbook,
            register_by, user_type, status
        ) VALUES (
            :name, :date_of_birth, :country_code, :contact, :email, :address,
            :gender, :country, :state, :city, :pincode, :zone, :note,
            :profile_pic, :pan_card, :aadhar_card, :bank_passbook,
            :register_by, :user_type, :status
        )";


$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':name' => $name,
    ':date_of_birth' => $birth_date,
    ':country_code' => $country_cd,
    ':contact' => $contact,
    ':email' => $email,
    ':address' => $address,
    ':gender' => $gender,
    ':country' =>$country,
    ':state' =>$state,
    ':city' =>$city,
    ':pincode' =>$pincode,
    ':zone' =>$zone,
    ':note' => $note,
    ':profile_pic' => $profile_pic,
    ':pan_card' => $pan_card,
    ':aadhar_card' => $aadhar_card,
    ':bank_passbook' => $bank_details,
    ':register_by' => $register_by,
    ':user_type' => $user_type,
    ':status' => $status
]);

if ($result) {
    $sql3 = "INSERT INTO logs (title, message, message2, register_by, from_whom, operation)
             VALUES (:title, :message, :message2, :register_by, :from_whom, :operation)";
    $stmt = $conn->prepare($sql3);
    $result3 = $stmt->execute([
        ':title' => $title,
        ':message' => $message,
        ':message2' => $message2,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
        ':operation' => $operation
    ]);

    echo $result3 ? 1 : 0;
} else {
    echo 0;
}
?>
