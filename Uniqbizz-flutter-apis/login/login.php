<?php
require '../../connect.php';
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

    // Initialize defaults to avoid undefined array warnings
    $_SESSION["username2"] = '';
    $_SESSION["lname"] = '';

    $_SESSION["user_type_id_value"] = $row['user_type_id'];
    $_SESSION["user_id"] = $row['user_id'];
    $_SESSION["customer_type"]= '';

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
        '26' => 'business_mentor',
        '27' => 'zonal_manager',
        '28' => 'master_franchisee',
        '29' => 'sub_franchisee',
        '30' => 'sponsor_franchisee',
        '31' => 'employees',
        '32' => 'institution',
        '33' => 'institution_branch_manager',
        '34' => 'executive_techno_enterprise',
        '35' => 'super_techno_enterprise',
        '36' => 'chief_techno_enterprise'
    ];

    if (isset($tables[$_SESSION["user_type_id_value"]])) {
        $table = $tables[$_SESSION["user_type_id_value"]];
        $stmt = $conn->prepare("SELECT * FROM $table WHERE email = :email AND status = '1'");
        $stmt->bindParam(':email', $username);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $_SESSION["username2"] = $row['firstname'] ?? $row['name'] ?? '';
            $_SESSION["lname"] = $row['lastname'] ?? '';
            
            $country_id = $row['country'];
            $state_id = $row['state'];
            $city_id = $row['city'];
            
            // Get country name
            $countries = $conn->prepare("SELECT country_name FROM countries WHERE id= :country_id AND status='1'");
            $countries->execute([ ":country_id" => $country_id ]);
            if ($countries->rowCount() > 0) {
                $countryname = $countries->fetch()['country_name'];
            }

            // Get state name
            $states = $conn->prepare("SELECT state_name FROM states WHERE id= :state_id AND status='1'");
            $states->execute([ ":state_id" => $state_id ]);
            if ($states->rowCount() > 0) {
                $statename = $states->fetch()['state_name'];
            }

            // Get city name
            $cities = $conn->prepare("SELECT city_name FROM cities WHERE id= :city_id AND status='1'");
            $cities->execute([ ":city_id" => $city_id ]);
            if ($cities->rowCount() > 0) {
                $cityname = $cities->fetch()['city_name'];
            }
            
            if($_SESSION["user_type_id_value"] == '10'){
                $_SESSION["customer_type"]= $row['customer_type'] ?? '';
            }else{
                $_SESSION["customer_type"]= '';
            }
        }
    } elseif ($_SESSION["user_type_id_value"] == '17') {
        $_SESSION["username2"] = $username;
        $_SESSION["lname"] = "Sub Admin";
    }

    // Get user type name
    $stmt2 = $conn->prepare("SELECT * FROM user_type WHERE id = :user_type_id AND status = '1'");
    $stmt2->bindParam(':user_type_id', $_SESSION["user_type_id_value"]);
    $stmt2->execute();
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt2->rowCount() > 0) {
        $row2 = $stmt2->fetch();
        $_SESSION["user_type_name"] = $row2['name'];
    }

    echo json_encode([
        "status" => 1,
        "message" => "Login successful",
        "user_type" => $_SESSION["user_type_name"],
        "customer_type" => $_SESSION["customer_type"]??'',
        "user_id" => $_SESSION["user_id"],
        "user_fname" => $_SESSION["username2"],
        "user_lname" => $_SESSION["lname"],
        "country" => $countryname,
        "state" => $statename,
        "city" => $cityname
    ]);
}
 else {
        echo json_encode(["status" => 0, "message" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Invalid request method"]);
}
