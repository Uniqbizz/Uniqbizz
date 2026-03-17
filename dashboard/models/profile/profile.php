<?php
    //get profile col data (img link) to display in header
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    function getNameById($conn, $table, $column, $id)
    {
        $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result[$column];
        }
        return '';
    }

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $key => $value) {
            $profile_pic = $value['profile_pic'];

            // Default values
            $n_name = '';
            $n_relation = '';
            $countryname = '';
            $statename = '';
            $cityname = '';
            $country = '';
            $state = '';
            $city = '';
            $pincode = '';
            $middle = '';
            $bank_passbook='';
            if ($userType == '25' || $userType == '24') {
                $id_proof = $value['id_proof'];
                $bank_passbook = $value['bank_details'];
                $phone_no = $value['contact'];

                // Handle name split safely
                $nameParts = explode(' ', trim($value['name']));
                $fname = $nameParts[0] ?? '';
                $lname = end($nameParts) ?? '';
                // Extract middle names (excluding first and last)
                
                if (count($nameParts) > 2) {
                    $middle = implode(' ', array_slice($nameParts, 1, -1));
                }
            } else {
                // Common for userType 10, 11, and others
                $fname = $value['firstname'];
                $lname = $value['lastname'];
                $phone_no = $value['contact_no'];
                $bank_passbook = ($userType == '10' || $userType == '11' || $userType == '33') ? $value['passbook'] : $value['bank_passbook'];
                $pan_card = $value['pan_card'] ?? '';
                $aadhar_card = $value['aadhar_card'] ?? '';
                $voting_card = $value['voting_card'] ?? '';
                $country = $value['country'];
                $state = $value['state'];
                $city = $value['city'];
                $pincode = $value['pincode'];
                $customer_type=$userType == 10?$value['customer_type']:'NA';
                // Get names from IDs
                $countryname = getNameById($conn, 'countries', 'country_name', $country);
                $statename = getNameById($conn, 'states', 'state_name', $state);
                $cityname = getNameById($conn, 'cities', 'city_name', $city);
            }
        }
    }
?>