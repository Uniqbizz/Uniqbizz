<?php
require 'connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!isset($data['username']) || !isset($data['password']) || !isset($data['user_type_id'])) {
        echo json_encode(["status" => false, "message" => "Missing username, password, or user_type_id"]);
        exit;
    }

    $username = $data['username'];
    $password = $data['password'];
    $user_type_id = $data['user_type_id'];

    // Query to check if username exists
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = :username AND password = :password AND user_type_id = :user_type_id AND status = '1'");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':user_type_id', $user_type_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        session_start(); // Start session
        $_SESSION["user_type_id_value"] = $row['user_type_id'];
        $_SESSION["user_id"] = $row['user_id'];

        $tables = [
            '2' => 'customer',
            '3' => 'business_consultant',
            '4' => 'franchisee',
            '5' => 'sales_manager',
            '6' => 'branch_manager',
            '7' => 'regional_manager',
            '8' => 'super_franchisee',
            '9' => 'employees',
            '10' => 'ca_customer',
            '11' => 'ca_travelagency',
            '12' => 'base_agency',
            '13' => 'primary_agency',
            '14' => 'premium_agency',
            '15' => 'business_trainee',
            '16' => 'corporate_agency',
            '18' => 'channel_business_director',
            '19' => 'ca_franchisee',
            '24' => 'employees',
            '25' => 'employees',
            '26' => 'business_mentor'
        ];

        if (isset($tables[$_SESSION["user_type_id_value"]])) {
            $table = $tables[$_SESSION["user_type_id_value"]];
            $stmt = $conn->prepare("SELECT * FROM $table WHERE email = :email AND status = '1'");
            $stmt->bindParam(':email', $username);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                $_SESSION["username2"] = $row['firstname'] ?? $row['name'];
                $_SESSION["lname"] = $row['lastname'] ?? '';
            }
        } elseif ($_SESSION["user_type_id_value"] == '17') {
            $_SESSION["username2"] = $username;
            $_SESSION["lname"] = "Sub Admin";
        }

        $stmt2 = $conn->prepare("SELECT * FROM user_type WHERE id = :user_type_id AND status = '1'");
        $stmt2->bindParam(':user_type_id', $_SESSION["user_type_id_value"]);
        $stmt2->execute();
        $stmt2->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt2->rowCount() > 0) {
            $row2 = $stmt2->fetch();
            $_SESSION["user_type_name"] = $row2['name'];
        }

        echo json_encode(["status" => 1, "message" => "Login successful", "user_type" => $_SESSION["user_type_name"]]);
    } else {
        echo json_encode(["status" => 0, "message" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Invalid request method"]);
}
?>
