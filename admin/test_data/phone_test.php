<?php
require '../connect.php';

$tablename = $_POST["tablename"];
$countrycode = $_POST["countrycode"];
$phoneTenDegit = $_POST["phone"];
$phone=$countrycode."".$phoneTenDegit;

if($tablename == 2){
    $tname='customer';
}else if($tablename == 3 ){
    $tname='business_consultant';

}else if($tablename == 4){
    $tname='franchisee';
}else if($tablename == 5){
    $tname='sales_manager';
}else if($tablename == 6){
    $tname='branch_manager';
}else if($tablename == 7){
    $tname='regional_manager';
}

if((!empty($_POST["countrycode"]))|| (!empty($_POST["phoneTenDegit"]))){ 
    // Fetch city data based on the specific state

    $stmt2 = $conn->prepare("SELECT * FROM ".$tname." WHERE contact_no = '".$phoneTenDegit."' AND country_code = '".$countrycode."'");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
     
    // Generate HTML of city options list

     if($stmt2->rowCount()>0){
            echo 1;
   
    }else{
        echo 0;
    }
}

?>