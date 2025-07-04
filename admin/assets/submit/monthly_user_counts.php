<?php
    //get user count for pagination purpose
    require '../../connect.php';     

    
    $formdata = stripslashes(file_get_contents("php://input"));
    $get_data = json_decode($formdata, true);

    $get_month_year = $get_data['month_year'];
    $year = substr($get_month_year,0,4);
    $month = substr($get_month_year,5,7);
    $userType = $get_data['userType'];

    if($userType=='customer'){
        $sql = "SELECT cust_id as user_id, firstname, lastname, reference_no, register_date FROM customer 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='consultant'){
        $sql = "SELECT business_consultant_id as user_id, firstname, lastname, reference_no, register_date FROM business_consultant 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='partner'){
        $sql = "SELECT franchisee_id as user_id, firstname, lastname, reference_no, register_date FROM franchisee 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='corporate_partner'){
        $sql = "SELECT super_franchisee_id as user_id, firstname, lastname, reference_no, register_date FROM super_franchisee 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='business_trainee'){
        $sql = "SELECT business_trainee_id as user_id, firstname, lastname, reference_no, register_date FROM business_trainee 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='corporate_agency'){
        $sql = "SELECT corporate_agency_id as user_id, firstname, lastname, reference_no, register_date FROM corporate_agency 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='ca_travelagency'){
        $sql = "SELECT ca_travelagency_id as user_id, firstname, lastname, reference_no, register_date FROM ca_travelagency 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='ca_customer'){
        $sql = "SELECT ca_customer_id as user_id, firstname, lastname, reference_no, register_date FROM ca_customer 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }else if($userType=='cbd'){
        $sql = "SELECT channel_business_director_id as user_id, firstname, lastname, reference_no, register_date FROM channel_business_director 
                                        WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    echo $count;

    

?>