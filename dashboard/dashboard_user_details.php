<?php

    require 'connect.php';
    session_start();
    if(!isset($_SESSION['username2']) || !isset($_SESSION['user_type_id_value']) || !isset($_SESSION['user_id']) ){
        echo '<script>location.href = "../login.php";</script>';
    }

    // if($_SESSION['user_type_id_value'] == '24' || $_SESSION['user_type_id_value'] == '25' || $_SESSION['user_type_id_value'] == '26'){ 
    //     echo '<script>location.href = "../index.php";</script>';
    // }

     $userFname = $_SESSION['username2']; //first name of user 'Ryam'.
     $userLname = $_SESSION['lname']; //last name of user 'Cardoso'.
     $userType = $_SESSION['user_type_id_value']; //user type id value '3'.
     $userId = $_SESSION['user_id']; // user id 'TA230030'.

    $date = date('Y');

    $sql = "SELECT * FROM `user_type` WHERE id = '$userType' ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach(($stmt -> fetchAll()) as $key => $value){
            $designation = $value['name']; //get designation of user 'Business Consultant'.
        }
    }

    // get profile pic based on user loged in
    if($userType == '3'){
        $sql2 = "SELECT * FROM `business_consultant` WHERE business_consultant_id = '$userId' ";
    }else if($userType == '10'){
        $sql2 = "SELECT * FROM `ca_customer` WHERE ca_customer_id = '$userId' ";
    }else if($userType == '11'){
        $sql2 = "SELECT * FROM `ca_travelagency` WHERE ca_travelagency_id = '$userId' ";
    }else if($userType == '15'){
        $sql2 = "SELECT * FROM `business_trainee` WHERE business_trainee_id = '$userId' ";
    }else if($userType == '16'){
        $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '$userId' ";
    }else if($userType == '18'){
        $sql2 = "SELECT * FROM `channel_business_director` WHERE channel_business_director_id = '$userId' ";
    }else if($userType == '19'){
        $sql2 = "SELECT * FROM `ca_franchisee` WHERE ca_franchisee_id = '$userId' ";
    }else if($userType == '20'){
        $sql2 = "SELECT * FROM `business_operation_executive` WHERE business_operation_executive_id = '$userId' ";
    }else if($userType == '21'){
        $sql2 = "SELECT * FROM `training_manager` WHERE training_manager_id = '$userId' ";
    }else if($userType == '22'){
        $sql2 = "SELECT * FROM `sales_executive` WHERE sales_executive_id = '$userId' ";
    }else if($userType == '24'){
        $sql2 = "SELECT * FROM `employees` WHERE employee_id = '$userId' ";
    }else if($userType == '25'){
        $sql2 = "SELECT * FROM `employees` WHERE employee_id = '$userId' ";
    }else if($userType == '26'){
        $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '$userId' ";
    }

    $stmt = $conn -> prepare($sql2);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach(($stmt -> fetchAll()) as $key => $value){
            if($userType == '24' || $userType == '25'){
                $firstname = $value['name'];
                $lastname = '';
            }else{   
                $firstname = $value['firstname'];
                $lastname = $value['lastname'];
            }
            $profile_pic = $value['profile_pic']; //get profile pic of user.
        }
    }

    // sidebar menu highlight when u r on that page 
    $directoryURI = $_SERVER['REQUEST_URI'];
    $path = parse_url($directoryURI, PHP_URL_PATH);
    $components = explode('/', $path);
    $first_part = $components[3];

    //data use for line chart
    if($userType == '3'){ //Business Consultant
        $directNext = "Techno Enterprise";
    }else if($userType == '10'){ //Customer
       $directNext = "Customer";
    }else if($userType == '11'){ //Travel Consultant
        $directNext = "Customer";
    }else if($userType == '15'){ //Business Trainee
        $directNext = "Techno Enterprise";
    }else if($userType == '16'){ //Corporate Agency
        $directNext = "Travel Consultant";
    }else if($userType == '18'){ //Channel Business Director
        $directNext = "Business Consultant";
    }else if($userType == '19'){ //CA Franchisee
        $directNext = "Business Operative Executive";
    }else if($userType == '20'){ //Business Operative Executive
        $directNext = "Training Manager";
    }else if($userType == '21'){ //Training Manager
        $directNext = "Sales Manager / Executive";
    }else if($userType == '24'){ //BCH/BCM
        $directNext = "Business Development Manager";
    }else if($userType == '25'){ //BDM/BDH
        $directNext = "Business Mentor";
    }else if($userType == '26'){ //BM
        $directNext = "Techno Enterprice";
    }

    $tdsPercentage=2/100;

    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
    
    // //get profile col data (img link) to display in header
    // $stmt = $conn -> prepare($sql2);
    // $stmt -> execute();
    // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    // if($stmt -> rowCount()>0){
    //     foreach(($stmt -> fetchAll()) as $key => $value){
    //         $profile_pic = $value['profile_pic']; //get profile pic of user.
    //         $pan_card = $value['pan_card'];
    //         $aadhar_card = $value['aadhar_card'];
    //         $voting_card = $value['voting_card'];
    //         if($userType == '10' || $userType == '11'){
    //             $bank_passbook = $value['passbook'];
    //         }else{
    //             $bank_passbook = $value['bank_passbook'];
    //         }
            
    //         $country= $value['country'];
    //         $state= $value['state'];
    //         $city= $value['city'];

    //         //get country
    //         $countries = $conn->prepare("SELECT country_name FROM countries where id='".$country."' and status='1' ");
    //         $countries->execute();
    //         $countries->setFetchMode(PDO::FETCH_ASSOC);
    //         if($countries->rowCount()>0){
    //             $country = $countries->fetch();
    //             $countryname = $country['country_name'];
    //         }

    //         //get state
    //         $states = $conn->prepare("SELECT state_name FROM states where id='".$state."' and status='1' ");
    //         $states->execute();
    //         $states->setFetchMode(PDO::FETCH_ASSOC);
    //         if($states->rowCount()>0){
    //             $state = $states->fetch();
    //             $statename = $state['state_name'];
    //         }
    //         //get city
    //         $cities = $conn->prepare("SELECT city_name FROM cities where id='".$city."' and status='1' ");
    //         $cities->execute();
    //         $cities->setFetchMode(PDO::FETCH_ASSOC);
    //         if($cities->rowCount()>0){
    //             $city = $cities->fetch();
    //             $cityname = $city['city_name'];
    //         }
    //     }
    // }

    // $directoryURI = $_SERVER['REQUEST_URI'];
    // $path = parse_url($directoryURI, PHP_URL_PATH);
    // $components = explode('/', $path);
    // $first_part = $components[3];

?>