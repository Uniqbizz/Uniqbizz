<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
    exit;
}

include '../connect.php';

$current_year = date('Y'); 

$name           = $_POST['name'];
$birth_date     = $_POST['birth_date'];
$country_cd     = $_POST['country_cd'];
$contact        = $_POST['contact'];
$email          = $_POST['email'];
$address        = $_POST['address'];
$gender         = $_POST['gender'];
$profile_pic    = $_POST['profile_pic'];
$pan_card       = $_POST['pancard'];
$aadhar_card    = $_POST['addar'];
$bank_details   = $_POST['bank_details'];
$note           = $_POST['note'];

$editfor = $_POST["editfor"];

if ($editfor == 'pending') {
    $identifier_id = $_POST["id"];
    $identifier_name = 'id'; // ✅ Fix: No equal sign
    $title = "Zonal";
    $message = "Updated Zonal details from " . $editfor . " list";
    $message2 = "Updated Zonal details from " . $editfor . " list";
} else if ($editfor == 'registered') {
    $identifier_id = $_POST["id"];
    $identifier_name = 'zonal_manager_id'; // ✅ Fix: No equal sign
    $title = "Zonal";
    $message = $identifier_id . " Details has been updated from " . $editfor . " list";
    $message2 = $identifier_id . " Details has been updated from " . $editfor . " list";
}

$register_by = '1'; // admin

// Get age (if needed elsewhere)
$birth_year = substr($birth_date, 0, 4);
$age = $current_year - intval($birth_year);

// Log info
$title      = "Zonal Manager";
$message    = "Zonal Manager has been Added";
$message2   = "Zonal Manager has been Added By Admin";
$operation  = "Add";
$fromWhom   = "1";

// UPDATE SQL
$sql = "UPDATE zonal_manager SET
            name = :name,
            date_of_birth = :date_of_birth,
            country_code = :country_code,
            contact = :contact,
            email = :email,
            address = :address,
            gender = :gender,
            note = :note,
            profile_pic = :profile_pic,
            pan_card = :pan_card,
            aadhar_card = :aadhar_card,
            bank_passbook = :bank_passbook,
            register_by = :register_by
        WHERE $identifier_name = :identifier_id";

$stmt = $conn->prepare($sql);

$result = $stmt->execute([
    ':name'           => $name,
    ':date_of_birth'  => $birth_date,
    ':country_code'   => $country_cd,
    ':contact'        => $contact,
    ':email'          => $email,
    ':address'        => $address,
    ':gender'         => $gender,
    ':note'           => $note,
    ':profile_pic'    => $profile_pic,
    ':pan_card'       => $pan_card,
    ':aadhar_card'    => $aadhar_card,
    ':bank_passbook'  => $bank_details,
    ':register_by'    => $register_by,
    ':identifier_id'  => $identifier_id
]);

if ($result) {
    // Log the operation
    $sqlLog = "INSERT INTO logs (
                    title, message, message2, register_by, from_whom, operation
                ) VALUES (
                    :title, :message, :message2, :register_by, :from_whom, :operation
                )";

    $stmtLog = $conn->prepare($sqlLog);
    $logResult = $stmtLog->execute([
        ':title'       => $title,
        ':message'     => $message,
        ':message2'    => $message2,
        ':register_by' => $register_by,
        ':from_whom'   => $fromWhom,
        ':operation'   => $operation
    ]);

    echo $logResult ? 1 : 0;
} else {
    echo 0;
}
?>
