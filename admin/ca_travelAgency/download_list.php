<?php
    require '../connect.php';

    $state = $_GET['filterState'];
    $stateName = $_GET['stateText'];

    // if($name == 'Pending'){
    //     $status=2;
    //     $srno =1;
    // }else if($name == 'Registered'){
    //     $status=1;
    // }

    $output="";

    if($state == '0'){
        $stmt = $conn->prepare("SELECT * FROM `ca_travelagency` WHERE status='1' ");
    }else{
        $stmt = $conn->prepare("SELECT * FROM `ca_travelagency` WHERE state = '".$state."' AND  status='1' ");
    }
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
    	$output .= '<h2 style="text-align:center">Travel Consultant '.$stateName.' Registered List</h2>
        <table border="1" style="text-align:center">
    	<tr>	
            <th>Travel Consultant ID</th>
    		<th>Name</th>
            <th>Nominee Name</th>
            <th>Nominee Relatione</th>
    		<th>Email</th>
    		<th>Contact No.</th>
    		<th>Date Of Birth</th>
    		<th>Age</th>
    		<th>Gender</th>
    		<th>Country</th>
    		<th>State</th>
    		<th>City</th>
    		<th>Pincode</th>
    		<th>Address</th>
    		<th>Payment Mode</th>
    		<th>Amount</th>
    		<th>Reference No</th>
    		<th>Registrant</th>
    		<th>Register Date</th>
    	</tr>';
        foreach (($stmt->fetchAll()) as $key => $row) {

            $country_name = '';
            $statename = '';
            $city_name = '';

            $bd= new DateTime($row['date_of_birth']);
            $bdate= $bd->format('d-m-Y'); 

            $rd= new DateTime($row['register_date']);
            $rDate= $rd->format('d-m-Y');
            
           //get country
           $countries = $conn->prepare("SELECT country_name FROM countries where id='".$row['country']."' and status='1' ");
           $countries->execute();
           $countries->setFetchMode(PDO::FETCH_ASSOC);
           if($countries->rowCount()>0){
               $country = $countries->fetch();
               $country_name = $country['country_name'];
           }

           //get state
           $states = $conn->prepare("SELECT state_name FROM states where id='".$row['state']."' and status='1' ");
           $states->execute();
           $states->setFetchMode(PDO::FETCH_ASSOC);
           if($states->rowCount()>0){
               $state = $states->fetch();
               $statename = $state['state_name'];
           }
           //get city
           $cities = $conn->prepare("SELECT city_name FROM cities where id='".$row['city']."' and status='1' ");
           $cities->execute();
           $cities->setFetchMode(PDO::FETCH_ASSOC);
           if($cities->rowCount()>0){
               $city = $cities->fetch();
               $city_name = $city['city_name'];
           }

            $output .= '<tr>
                <td>'.$row['ca_travelagency_id'].'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                <td>'.$row['nominee_name'].'</td>
                <td>'.$row['nominee_relation'].'</td>
                <td>'.$row['email'].'</td>
                <td>+'.$row["country_code"].' '.$row['contact_no'].'</td>
                <td>'.$bdate.'</td>
                <td>'.$row['age'].'</td>
                <td>'.$row['gender'].'</td>
                <td>'.$country_name.'</td>
                <td>'.$statename.'</td>
                <td>'.$city_name.'</td>
                <td>'.$row['pincode'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['payment_mode'].'</td>
                <td>'.$row['amount'].'</td>
                <td>'.$row['reference_no'].'</td>
                <td>'.$row['registrant'].'</td>
                <td>'.$rDate.'</td>
            </tr>';
        }

        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename='".$stateName."'_Registered_Travel_Consultant_List.xls");
        echo $output;
    }else{
        if($state == '0'){
            echo 'No All TC Data Found';
        }else{
            echo 'No State wise TC Data Found';
        }                                                  
    }

?>