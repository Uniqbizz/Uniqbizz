<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo '<script>location.href = "../../login.php";</script>';
        exit;
    }

    include '../../connect.php';

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
    $edit_reason    = $_POST['edit_reason'];

    $editfor = $_POST["editfor"];

    if ($editfor == 'pending') {
        $identifier_id = $_POST["id"];
        $identifier_name = 'id';
    } 
    else if ($editfor == 'registered') {
        $identifier_id = $_POST["id"];
        $identifier_name = 'zonal_manager_id';
    }

    $register_by = '1'; // admin
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // --------------------------------------------------
    // 1️⃣ GET OLD DATA
    // --------------------------------------------------

    $oldStmt = $conn->prepare("SELECT * FROM zonal_manager WHERE $identifier_name = :id");
    $oldStmt->execute([':id'=>$identifier_id]);
    $oldData = $oldStmt->fetch(PDO::FETCH_ASSOC);


    // --------------------------------------------------
    // 2️⃣ UPDATE QUERY
    // --------------------------------------------------

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


    // --------------------------------------------------
    // 3️⃣ FIELD CHANGE DETECTION
    // --------------------------------------------------

    if($result){

        $newData = [
            'name' => $name,
            'date_of_birth' => $birth_date,
            'country_code' => $country_cd,
            'contact' => $contact,
            'email' => $email,
            'address' => $address,
            'gender' => $gender,
            'note' => $note,
            'profile_pic' => $profile_pic,
            'pan_card' => $pan_card,
            'aadhar_card' => $aadhar_card,
            'bank_passbook' => $bank_details
        ];

        $stmtLog=$conn->prepare("
            INSERT INTO field_edit_logs
            (table_name,record_id,column_name,old_value,new_value,change_reason,changed_by,changed_role,ip_address)
            VALUES
            (:table_name,:record_id,:column_name,:old_value,:new_value,:change_reason,:changed_by,:changed_role,:ip_address)
        ");

        foreach($newData as $column=>$newValue){

            $oldValue = $oldData[$column] ?? '';

            if($oldValue != $newValue){

                $stmtLog->execute([
                    ':table_name'    => 'zonal_manager',
                    ':record_id'     => $identifier_id,
                    ':column_name'   => $column,
                    ':old_value'     => $oldValue,
                    ':new_value'     => $newValue,
                    ':change_reason' => $edit_reason,
                    ':changed_by'    => $register_by,
                    ':changed_role'  => 'admin',
                    ':ip_address'    => $ip_address
                ]);

            }

        }

        // --------------------------------------------------
        // 4️⃣ MAIN SYSTEM LOG
        // --------------------------------------------------

        $title = "Zonal Manager";
        $message = "Zonal Manager details updated";
        $message2 = "Updated by Admin";
        $operation = "Update";
        $fromWhom = "1";

        $sqlLog = "INSERT INTO logs (
                        title, message, message2, register_by, from_whom, operation
                    ) VALUES (
                        :title, :message, :message2, :register_by, :from_whom, :operation
                    )";

        $stmtLog2 = $conn->prepare($sqlLog);
        $logResult = $stmtLog2->execute([
            ':title'       => $title,
            ':message'     => $message,
            ':message2'    => $message2,
            ':register_by' => $register_by,
            ':from_whom'   => $fromWhom,
            ':operation'   => $operation
        ]);

        echo $logResult ? 1 : 0;

    }
    else{
        echo 0;
    }
?>