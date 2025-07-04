<?php
// session_start();
require '../../connect.php';

date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

// get Row data
    $data = stripslashes(file_get_contents("php://input"));
// json Decoding, true -> for getting data in associative manner
    $mydata = json_decode($data, true);
// declare variables
    $result_4 = '';
    $get_itinerary_id = 0;
    $get_id;


// insert package data
    $sql = 'INSERT INTO package (category_id,sub_category_id,club_id,package_type,category_hotel_id,category_meal_id,name,unique_code,description, package_keywords,
                destination,location,travel_from,travel_to,sightseeing_type,validity,tour_days) 
            VALUES (:category_id,:sub_category_id,:club_id,:package_type,:category_hotel_id,:category_meal_id,:name,:unique_code,:description, :package_keywords,:destination,:location,:travel_from,:travel_to,:sightseeing_type,:validity,:tour_days)';
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
                ':category_id' => $mydata['category_id'],
                ':sub_category_id' => $mydata['sub_category_id'],
                ':club_id' => $mydata['club_id']??0,
                ':package_type' => $mydata['package_type'],
                ':category_hotel_id' => $mydata['category_hotel_id'],
                ':category_meal_id' => $mydata['category_meal_id'],
                ':name' => $mydata['name'],
                ':unique_code' => $mydata['unique_code'],
                ':description' => $mydata['description'],
                ':destination' => $mydata['destination'],
                ':package_keywords' => $mydata['package_keywords'],
                ':location' => $mydata['location'],
                ':travel_from' => $mydata['travel_from'],
                ':travel_to' => $mydata['travel_to'],
                ':sightseeing_type' => $mydata['sightseeing_type'],
                ':validity' => $mydata['pac_validity'],
                ':tour_days' => $mydata['tour_days']
            ]);
    if ( $result ) {
        $package_query = $conn->prepare("SELECT id FROM package ORDER BY id DESC LIMIT 1");
        $package_query->execute();
        $get_package_id = $package_query->fetch();
        // echo $get_package_id["id"];
        $get_id = $get_package_id["id"];
    }
    
// insert package itinerary data
    if ( $mydata['inclusion'] || $mydata['exclusion'] || $mydata['remark'] ) 
    {
        $sql_2 = 'INSERT INTO package_itinerary_details (package_id,inclusion,exclusion,remark)
                VALUES(:package_id,:inclusion,:exclusion,:remark)';
        $statement_2 = $conn->prepare($sql_2);
        $result_2 = $statement_2->execute([
                ':package_id' => $get_id,
                ':inclusion' => $mydata['inclusion'],
                ':exclusion' => $mydata['exclusion'],
                ':remark' => $mydata['remark']
            ]);
        if (  $result_2 ) {
            $itinerary_query = $conn->prepare("SELECT id FROM package_itinerary_details ORDER BY id DESC LIMIT 1");
            $itinerary_query->execute();
            $get_itinerary_query_id = $itinerary_query->fetch();
            // echo $get_itinerary_query_id["id"];
            $get_itinerary_id = (int)$get_itinerary_query_id["id"];
        }

    }


    if (!empty($mydata['details_of_day'])) {
        // Debugging: Log the details_of_day array in the browser console
        //echo '<script>console.log(' . json_encode($mydata['details_of_day']) . ');</script>';
    
        $sql_3 = 'INSERT INTO package_trip_days (package_id, title, day_details, meal_plan, day_tansport) 
                  VALUES (:package_id, :title, :day_details, :meal_plan, :day_tansport)';
        $statement_3 = $conn->prepare($sql_3);
    
        foreach ($mydata['details_of_day'] as $day) { // Single loop (flat array)
            $statement_3->bindValue(':package_id', $get_id, PDO::PARAM_INT);
            $statement_3->bindValue(':title', $day['title'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':day_details', $day['description'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':meal_plan', $day['meals'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':day_tansport', $day['transport'] ?? '', PDO::PARAM_STR);
            $statement_3->execute();
        }
    }
    
// insert package pricing data
    if ( $mydata['total_package_price_per_adult'] ||  $mydata['total_package_price_per_child'] ) 
    {
        $sql_4 = 'INSERT INTO package_pricing (package_id,net_price_adult,net_price_child,net_gst,net_price_adult_with_GST,net_price_child_with_GST,total_package_price_per_adult,total_package_price_per_child,price_up_per_adult)
                VALUES(:package_id,:net_price_adult,:net_price_child,:net_gst,:net_price_adult_with_GST,:net_price_child_with_GST,:total_package_price_per_adult,:total_package_price_per_child,:price_up_per_adult)';
        $statement_4 = $conn->prepare($sql_4);
        $result_4 = $statement_4->execute([
                ':package_id' => $get_id,
                ':net_price_adult' => $mydata['net_price_adult'],
                ':net_price_child' => $mydata['net_price_child'],
                ':net_gst' => $mydata['net_gst'],
                ':net_price_adult_with_GST' => $mydata['net_price_adult_with_GST'],
                ':net_price_child_with_GST' => $mydata['net_price_child_with_GST'],
                ':total_package_price_per_adult'=>$mydata['total_package_price_per_adult'],
                ':total_package_price_per_child'=>$mydata['total_package_price_per_child'],
                ':price_up_per_adult'=>$mydata['add_adult_price']
                
            ]);

    }
// insert package pictures / images
    if ( $mydata['images'] )
    {
        $sql_5 = 'INSERT INTO package_pictures (package_id,image) VALUES(:package_id,:image)';
        $statement_5 = $conn->prepare($sql_5);
        
        foreach ( $mydata['images'] as $key => $image) 
        {
            $html_string = str_replace(' ', '-', $mydata['name']); 
            $image_string = preg_replace('/[^A-Za-z0-9\-]/', '', $html_string); 
            $image_name = $image_string.time().'-'.++$key.'.'.'jpg';
            $destination = "../../../uploading/packages/".$image_name;
            $image_path = "uploading/packages/".$image_name;
           
            // save base64 image start
            $data = $image['name'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents($destination, $data);
            // save base64 image end

            $statement_5->bindParam(':package_id', $get_id, PDO::PARAM_INT);
            $statement_5->bindParam(':image', $image_path, PDO::PARAM_STR);
            $statement_5->execute();
        }
    }
// insert package category_occupancy
    if ( $mydata['occupancies'] )
    {
        $sql_6 = 'INSERT INTO package_to_category_occupancy (package_id,occupancy_id) VALUES(:package_id,:occupancy_id)';
        $statement_6 = $conn->prepare($sql_6);
        
        foreach ( $mydata['occupancies'] as $occupancy ) 
        {
            // echo $occupancy['id'];
            $statement_6->bindParam(':package_id', $get_id, PDO::PARAM_INT);
            $statement_6->bindParam(':occupancy_id', $occupancy['id'], PDO::PARAM_INT);
            $result_6 = $statement_6->execute();
        }
    }
// insert package category_vehicle
    if ( $mydata['vehicles'] )
    {
        $sql_7 = 'INSERT INTO package_to_category_vehicle (package_id,vehicle_id) VALUES(:package_id,:vehicle_id)';
        $statement_7 = $conn->prepare($sql_7);
       
        foreach ( $mydata['vehicles'] as $vehicle ) 
        {
            // echo $vehicle['id'];
            $statement_7->bindParam(':package_id', $get_id, PDO::PARAM_INT);
            $statement_7->bindParam(':vehicle_id', $vehicle['id'], PDO::PARAM_INT);
            $result_7 = $statement_7->execute();
        }
    }
    

//updated markup distribution 24-01-2025 by sv
    if ( $mydata['ta_mark_up'] )
    {
        $sql_8 = 'INSERT INTO package_pricing_markup (
            package_id, company, customer, ta_markup, ca_mark_up_total, ca_direct_commission, ca_incentive,
            bm_mark_up_total, bm_direct_commission, bm_incentive, bdm_mark_up_total, bdm_direct_commission,
            bdm_incentive, bcm_mark_up_total, bcm_direct_commission, bcm_incentive, prime_customer, L1_customer, L2_customer,
            total_adult_price_with_markup,total_child_price_with_markup
        ) VALUES (
            :package_id, :company, :customer, :ta_markup, :ca_mark_up_total, :ca_direct_commission, :ca_incentive,
            :bm_mark_up_total, :bm_direct_commission, :bm_incentive, :bdm_mark_up_total, :bdm_direct_commission,
            :bdm_incentive, :bcm_mark_up_total, :bcm_direct_commission, :bcm_incentive , :prime_customer, :L1_customer, :L2_customer,
            :total_adult_price_with_markup,:total_child_price_with_markup
        )';
    
        $statement_8 = $conn->prepare($sql_8);
    
        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['company_share'],
            ':customer' => $mydata['customer_share'],
            ':ta_markup' => $mydata['ta_mark_up'],
            ':ca_mark_up_total' => $mydata['ca_mark_up'],
            ':ca_direct_commission' => $mydata['ca_mark_up_comm'],
            ':ca_incentive' => $mydata['ca_mark_up_ins'],
            ':bm_mark_up_total' => $mydata['bm_mark_up'],
            ':bm_direct_commission' => $mydata['bm_mark_up_comm'],
            ':bm_incentive' => $mydata['bm_mark_up_ins'],
            ':bdm_mark_up_total' => $mydata['bdm_mark_up'] ?? 0,
            ':bdm_direct_commission' => $mydata['bdm_mark_up_comm'] ?? 0,
            ':bdm_incentive' => $mydata['bdm_mark_up_ins'] ?? 0,
            ':bcm_mark_up_total' => $mydata['bcm_mark_up'] ?? 0,
            ':bcm_direct_commission' => $mydata['bcm_mark_up_comm'] ?? 0,
            ':bcm_incentive' => $mydata['bcm_mark_up_ins'] ?? 0,
            ':prime_customer' => $mydata['prime_customer_share'],
            ':L1_customer' => $mydata['L1_customer_share'],
            ':L2_customer' => $mydata['L2_customer_share'],
            ':total_adult_price_with_markup'=>$mydata['total_adult_price_with_markup'],
            ':total_child_price_with_markup'=>$mydata['total_child_price_with_markup']
        ]);
       
    }

//    cancel policy insert added on 24-01-2025 by sv
    if ( $mydata['policy_1'] )
    {
        

        $sql_10 = 'INSERT INTO cancel_policy (package_id, policy_1, policy_2, policy_3) VALUES (:package_id, :policy_1, :policy_2, :policy_3)';
        $statement_10 = $conn->prepare($sql_10);
        $result_10 = $statement_10->execute([
            ':package_id'=>$get_id, 
            ':policy_1'=>$mydata['policy_1'], 
            ':policy_2'=>$mydata['policy_2'], 
            ':policy_3'=>$mydata['policy_3']
            ]);
    }

// check success
    if ( $result && $result_4) {

            $message = "Added ".$mydata['name']." Package";
            
            //new logs update
            $sql12= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
            $stmt =$conn->prepare($sql12);
            $result=$stmt->execute(array(
                ':title' => "Added Package",
                ':message' => $message,
                ':message2' => $message,
                ':reference_no' => "1",
                ':register_by' =>"1",
                ':from_whom' => "1"
            ));


            echo "success";
        }else{
            echo "fail";
    }


?>
