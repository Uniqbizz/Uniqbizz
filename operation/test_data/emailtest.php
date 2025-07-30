<?php
require '../connect.php';

$email = $_POST["email"];
$tablename = $_POST["tablename"];

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
}else if($tablename == 10){
    $tname='ca_customer';
}else if($tablename == 11){
    $tname='ca_travelagency';
}else if($tablename == 12){
    $tname='head_office';
}else if($tablename == 13){
    $tname='trainee_manager';
}else if($tablename == 14){
    $tname='zonal_manager';
}else if($tablename == 16){
    $tname='corporate_agency';
}else if($tablename == 18){
    $tname='channel_business_director';
}else if($tablename == 19){
    $tname='ca_franchisee';
}else if($tablename == 20){
    $tname='business_operation_executive';
}else if($tablename == 21){
    $tname='training_manager';
}else if($tablename == 22){
    $tname='sales_executive';
}else if($tablename == 2425){
    $tname='employees';
}else if($tablename == 26){
    $tname='business_mentors';
}else{
    
}

if(!empty($_POST["email"])){ 

    $stmt2 = $conn->prepare("SELECT * FROM ".$tname." WHERE email = '".$email."'");
    $stmt2->execute();                                                                                   
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

     if($stmt2->rowCount()>0){
        	echo 1;
   
    }else{
        echo 0;
    }
}

?>