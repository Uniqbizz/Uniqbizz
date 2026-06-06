<?php
    require '../connect.php';

    $output="";

    // $branchFilter = $_GET['branch'] ?? '';
    $designation  = $_GET['designation'] ?? '';
    $from=$_GET['fromDate']??'';
    $to=$_GET['toDate']??'';

    $conditions = [];
    $params = [];

    // Apply branch filter if provided
    if (!empty($branchFilter)) {
        $conditions[] = "branch = :branch";
        $params[':branch'] = $branchFilter;
    }

    // Date filter
    if (!empty($from) && !empty($to)) {
        $fromDateObj = DateTime::createFromFormat('d-m-Y', $from);
        $toDateObj   = DateTime::createFromFormat('d-m-Y', $to);

        if ($fromDateObj && $toDateObj) {
            $conditions[] = "register_date BETWEEN :from AND :to";
            $params[':from'] = $fromDateObj->format('Y-m-d');
            $params[':to']   = $toDateObj->format('Y-m-d');
        }
    }

    // Build WHERE conditions
    $filter = '';
    if (!empty($conditions)) {
        $filter = " AND " . implode(" AND ", $conditions);
    }


    // Base queries
    $bmQuery = "
        SELECT business_mentor_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id,nominee_name,nominee_relation,age,gender,pincode,address,payment_mode, 'BM' AS user_type 
        FROM business_mentor 
        WHERE status = '1' $filter
    ";

    $mfQuery = "
        SELECT master_franchisee_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id,nominee_name,nominee_relation,age,gender,pincode,address,payment_mode, 'MF' AS user_type 
        FROM master_franchisee 
        WHERE status = '1' $filter
    ";

    $sfQuery = "
        SELECT sponsor_franchisee_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id,nominee_name,nominee_relation,age,gender,pincode,address,payment_mode, 'SF' AS user_type 
        FROM sponsor_franchisee 
        WHERE status = '1' $filter
    ";

    $eteQuery = "
        SELECT chief_techno_enterprise_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id,nominee_name,nominee_relation,age,gender,pincode,address,payment_mode, 'ETE' AS user_type 
        FROM chief_techno_enterprise 
        WHERE status = '1' $filter
    ";

    // Build final query based on designation
    if ($designation == "BM") {
        $sql = $bmQuery . " ORDER BY id ASC";
    } elseif ($designation == "MF") {
        $sql = $mfQuery . " ORDER BY id ASC";
    } elseif ($designation == "SF") {
        $sql = $sfQuery . " ORDER BY id ASC";
    }  elseif ($designation == "ETE") {
        $sql = $eteQuery . " ORDER BY id ASC";
    } elseif ($designation == "All") {
        $sql = "
            ($bmQuery)
            UNION ALL
            ($mfQuery)
            UNION ALL
            ($sfQuery)
            UNION ALL
            ($eteQuery)
            ORDER BY id ASC
        ";
    } else {
        die("Invalid designation");
    }

    $stmt = $conn->prepare($sql);

    // Bind parameters
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
    	$label = ($designation == "BM")
                ? "Business Mentor"
                : (($designation == "MF")
                    ? "Master Franchisee"
                    : (($designation == "SF")
                        ? "Sponsor Franchisee"
                        : (($designation == "ETE")
                        ? "Chief Techno Enterprise"
                            : (($designation == "All")
                                ? "Business Mentor / Master Franchisee / Sponsor Franchisee / Chief Techno Enterprise"
                                : "Unknown"))));

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
                <th>paid_amount</th>
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
                <td>'.$row['paid_amount'].'</td>
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