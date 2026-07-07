<?php
    require '../connect.php';
    $disgnation=$_GET['designation'];
    $package=$_GET['package'];
    $from=$_GET['StartFrom'];
    $to=$_GET['EndFrom'];

    $output="";

    $filters = [];
    $params  = [];

    // Package filter
    if (!empty($package)) {
        $filters[] = "amount = :package";
        $params[':package'] = $package;
    }

    // Date filter
    if (!empty($from) && !empty($to)) {
        $filters[] = "register_date BETWEEN :from AND :to";
        $params[':from'] = $from;
        $params[':to']   = $to;
    }

    // Build WHERE extra
    $whereExtra = "";
    if (!empty($filters)) {
        $whereExtra = " AND " . implode(" AND ", $filters);
    }

    if ($disgnation == 'TE') {
        $sql = "SELECT 'te' AS user_type, id, corporate_agency_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status, register_by, country, state, city, register_date, nominee_name, nominee_relation, payment_mode, address, pincode, gender, age
                FROM corporate_agency 
                WHERE status IN ('1') $whereExtra
                ORDER BY added_on ASC";
    } elseif ($disgnation == 'F') {
        $sql = "SELECT 'sf' AS user_type, id, sub_franchisee_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status, register_by, country, state, city, register_date, nominee_name, nominee_relation, payment_mode, address, pincode, gender, age
                FROM sub_franchisee 
                WHERE status IN ('1') $whereExtra
                ORDER BY added_on ASC";
    } elseif ($disgnation == 'All') {
        $sql = "SELECT 'te' AS user_type, id, corporate_agency_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status, register_by, country, state, city, register_date, nominee_name, nominee_relation, payment_mode, address, pincode, gender, age
                FROM corporate_agency 
                WHERE status IN ('1') $whereExtra
                UNION ALL
                SELECT 'sf' AS user_type, id, sub_franchisee_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status, register_by, country, state, city, register_date, nominee_name, nominee_relation, payment_mode, address, pincode, gender, age
                FROM sub_franchisee 
                WHERE status IN ('1') $whereExtra
                ORDER BY added_on ASC";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
    	$label = ($disgnation == "TE")
                ? "Techno Enterprise"
                : (($disgnation == "F")
                    ? "Franchisee"
                    : (($disgnation == "All")
                        ? "Techno Enterprise / Franchisee"
                        : "Unknown"));

        $output .= '<h2 style="text-align:center">' . $label . ' Registered List</h2>
            <table border="1" style="text-align:center">
            <tr>    
                <th>' . $label . ' ID</th>
                <th>Name</th>
                <th>Nominee Name</th>
                <th>Nominee Relation</th>
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
                <td>'.$row['user_id'].'</td>
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
        header("Content-Disposition: attachment;filename=Registered_TE_F_List.xls");
        echo $output;
    }

?>