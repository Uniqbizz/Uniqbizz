<?php 
    date_default_timezone_set('Asia/Calcutta');
    $today = date('Y-m-d H:i:s');

    require "../connect.php";

    $id = $_POST["id"];
    $usrtype = $_POST['usertype'];

    // Map user_type to internal user_type_id
    $user_type = $usrtype == 'te' ? "16" : ($usrtype == 'sf' ? "29" : ($usrtype == 'in' ? "32":''));

    $status = '';
    $action = $_POST["action"];

    if ($action == 'pending') {
        $ta_id = ""; // clear the corporate_agency/sub_franchisee id
        $identifier_name = 'id=';
        $status = '0';
    } else if ($action == 'registered') {
        $ta_id = $_POST["refid"]; // assign corporate_agency/sub_franchisee id
        $identifier_name =  'institution_id';
        $status = '3';
    } else if ($action == 'deactivate') {
        $ta_id = $_POST["refid"];
        $identifier_name = 'institution_id';
        $status = '1';
        $today = null;
    } else if ($action == 'deleted') {
        $ta_id = "";
        $identifier_name = 'institution_id';
        $status = '2';
        $today = null;
    }

    // Set title/message dynamically based on type
    $title = "Institution";

    if ($ta_id == '') {
        $message = "Deleted $title from $action list";
        $message2 = $message;
    } else {
        $message = "Deleted $title ($ta_id) from $action list";
        $message2 = $message;
    }

    $fromWhom = "1";
    $register_by = "1"; 
    $operation = "Delete";

    // Update main table (corporate_agency or sub_franchisee)
    $table_name = "institution";
    $sql1 = "UPDATE $table_name SET status = :status, deleted_date = :deleted_date WHERE id = :id";
    $stmt = $conn->prepare($sql1);
    $result = $stmt->execute([
        ':status' => $status,
        ':deleted_date' => $today,
        ':id' => $id
    ]);

    // Update login table and log if refid exists
    if (isset($_POST["refid"])) {
        $travel_agent_id = $_POST["refid"];

        $sql2 = "UPDATE login SET status = :status WHERE user_id = :travel_agent_id AND user_type_id = :user_type";
        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':status' => $status,
            ':user_type' => $user_type,
            ':travel_agent_id' => $travel_agent_id
        ]);

        if ($result2) {
            $sql3 = "INSERT INTO logs (user_id,title, message, message2, reference_no, register_by, from_whom, operation) 
                    VALUES (:user_id,:title, :message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt3 = $conn->prepare($sql3);
            $result3 = $stmt3->execute([
                ':user_id' => $travel_agent_id, 
                ':title' => $title,
                ':message' => $message,
                ':message2' => $message2,
                ':reference_no' => $travel_agent_id,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
                ':operation' => $operation
            ]);

            echo $status;
        } else {
            echo $status;
        }
    } else if ($result) {
        echo $status;
    } else {
        echo $status;
    }
?>
