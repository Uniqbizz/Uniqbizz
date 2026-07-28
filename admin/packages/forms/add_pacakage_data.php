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
    $get_id='';


// insert package data
   $sql = "INSERT INTO package
    (
        category_id,
        sub_category_id,
        package_type,
        category_hotel_id,
        category_meal_id,
        name,
        unique_code,
        description,
        detailed_description,
        package_keywords,
        destination,
        location,
        travel_from,
        travel_to,
        sightseeing_type,
        validity,
        tour_days,
        cities,
        best_season,
        highlight_type,
        drop_price_status,
        drop_price_amount,
        language_type,
        visa_required,
        category_vehicle_id

    )
    VALUES
    (
        :category_id,
        :sub_category_id,
        :package_type,
        :category_hotel_id,
        :category_meal_id,
        :name,
        :unique_code,
        :description,
        :detailed_description,
        :package_keywords,
        :destination,
        :location,
        :travel_from,
        :travel_to,
        :sightseeing_type,
        :validity,
        :tour_days,
        :cities,
        :best_season,
        :highlight_type,
        :drop_price_status,
        :drop_price_amount,
        :language_type,
        :visa_required,
        :category_vehicle_id
    )";
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
                ":category_id" => $mydata['general_info']['categoryId'],
                ":sub_category_id" => $mydata['general_info']['subCategoryId'],
                ":package_type" => $mydata['general_info']['travelTheme'],
                ":category_hotel_id" => $mydata['extra_info']['categoryHotelId'],
                ":category_meal_id" => $mydata['extra_info']['categoryMealId'],
                ":name" => $mydata['general_info']['packName'],
                ":unique_code" => $mydata['general_info']['uniqueCode'],
                ":description" => $mydata['general_info']['description'],
                ":detailed_description" => $mydata['general_info']['detailed_description'],
                ":package_keywords" => json_encode($mydata['extra_info']['packageKeywords']),//json object
                ":destination" => $mydata['extra_info']['destination'],
                ":location" => $mydata['general_info']['pacLocation'],
                ":travel_from" => $mydata['extra_info']['travelFrom'],
                ":travel_to" => $mydata['extra_info']['travelTo'],
                ":sightseeing_type" => $mydata['extra_info']['sightseeingType'],
                ":validity" => $mydata['general_info']['pacValidity'],
                ":tour_days" => $mydata['general_info']['tourDays'],
                ":cities" => json_encode($mydata['general_info']['cities']), //json,
                ":best_season" => $mydata['general_info']['season'],
                ":highlight_type" => $mydata['general_info']['packageType'],
                ":drop_price_status" => $mydata['general_info']['dropPriceCheck'],
                ":drop_price_amount" => $mydata['general_info']['dropPrice'],
                ":language_type" => $mydata['extra_info']['languageType'],
                ":visa_required" => $mydata['general_info']['visaType'],
                ":category_vehicle_id" => $mydata['extra_info']['vechicleId']
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
                ':price_up_per_adult'=>$mydata['add_adult_price']??0
                
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
            bdm_incentive, bcm_mark_up_total, bcm_direct_commission, bcm_incentive, prime_customer, L1_customer, L2_customer, total_mark_up
        ) VALUES (
            :package_id, :company, :customer, :ta_markup, :ca_mark_up_total, :ca_direct_commission, :ca_incentive,
            :bm_mark_up_total, :bm_direct_commission, :bm_incentive, :bdm_mark_up_total, :bdm_direct_commission,
            :bdm_incentive, :bcm_mark_up_total, :bcm_direct_commission, :bcm_incentive , :prime_customer, :L1_customer, :L2_customer, :total_mark_up
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
            ':prime_customer' => $mydata['L1_customer_share'],
            ':L1_customer' => $mydata['L2_customer_share'],
            ':L2_customer' => $mydata['L3_customer_share'],
            ':total_mark_up'=>$mydata['total_mark_up']
        ]);
       
    }
//new markup distribution 09-05-2026 by sv
    if ( $mydata['newta_mark_up'] )
    {
        $sql_8 = 'INSERT INTO package_pricing_markup_te_chain (
            package_id, company, customer, ta_markup, te_mark_up_total, te_direct_commission, te_incentive,
            ete_mark_up_total, ete_direct_commission, ete_incentive, ste_mark_up_total, ste_direct_commission,
            ste_incentive, cte_mark_up_total, cte_direct_commission, cte_incentive, prime_customer, L1_customer, L2_customer, total_mark_up
        ) VALUES (
            :package_id, :company, :customer, :ta_markup, :te_mark_up_total, :te_direct_commission, :te_incentive,
            :ete_mark_up_total, :ete_direct_commission, :ete_incentive, :ste_mark_up_total, :ste_direct_commission,
            :ste_incentive, :cte_mark_up_total, :cte_direct_commission, :bcm_incentive , :prime_customer, :L1_customer, :L2_customer, :total_mark_up
        )';
    
        $statement_8 = $conn->prepare($sql_8);
    
        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['newcompany_share'],
            ':customer' => $mydata['newcustomer_share'],
            ':ta_markup' => $mydata['newta_mark_up'],
            ':te_mark_up_total' => $mydata['te_mark_up'],
            ':te_direct_commission' => $mydata['te_mark_up_comm'],
            ':te_incentive' => $mydata['te_mark_up_ins'],
            ':ete_mark_up_total' => $mydata['ete_mark_up'],
            ':ete_direct_commission' => $mydata['ete_mark_up_comm'],
            ':ete_incentive' => $mydata['ete_mark_up_ins'],
            ':ste_mark_up_total' => $mydata['ste_mark_up'] ?? 0,
            ':ste_direct_commission' => $mydata['ste_mark_up_comm'] ?? 0,
            ':ste_incentive' => $mydata['ste_mark_up_ins'] ?? 0,
            ':cte_mark_up_total' => $mydata['cte_mark_up'] ?? 0,
            ':cte_direct_commission' => $mydata['cte_mark_up_comm'] ?? 0,
            ':cte_incentive' => $mydata['cte_mark_up_ins'] ?? 0,
            ':prime_customer' => $mydata['L1_customer_share'],
            ':L1_customer' => $mydata['L2_customer_share'],
            ':L2_customer' => $mydata['L3_customer_share'],
            ':total_mark_up'=>$mydata['total_mark_up']
        ]);
       
    }
//new institution markup distribution 09-05-2026 by sv
    if ($mydata['ins_mp_ca_ta'])
    {
        $sql_9 = 'SELECT * FROM package_pricing_markup_institution WHERE package_id=:package_id';
        $statement_9 = $conn->prepare($sql_9);
        $statement_9->execute([':package_id' => $get_id]);
        $result_9 = $statement_9->fetch(PDO::FETCH_ASSOC);

        if($result_9 == null){

            // INSERT  package_pricing_markup_institution
            $sql_8 = 'INSERT INTO package_pricing_markup_institution (
                package_id, company, customer, ins_markup, bm_mark_up_total,
                bm_direct_commission, bm_incentive, prime_customer,
                L1_customer, total_mark_up, coupon_amount
            ) VALUES (
                :package_id, :company, :customer, :ins_markup,
                :bm_mark_up_total, :bm_direct_commission, :bm_incentive,
                :prime_customer, :L1_customer, :total_mark_up, :coupon_amount
            )';

        } else {

            // UPDATE  package_pricing_markup_institution
            $sql_8 = 'UPDATE package_pricing_markup_institution SET
                company=:company,
                customer=:customer,
                ins_markup=:ins_markup,
                bm_mark_up_total=:bm_mark_up_total,
                bm_direct_commission=:bm_direct_commission,
                bm_incentive=:bm_incentive,
                prime_customer=:prime_customer,
                L1_customer=:L1_customer,
                total_mark_up=:total_mark_up,
                coupon_amount=:coupon_amount
                WHERE package_id=:package_id';
        }

        $statement_8 = $conn->prepare($sql_8);

        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['ins_mp_company'],
            ':customer' => $mydata['ins_mp_customer'],
            ':ins_markup' => $mydata['ins_mp_ca_ta'],
            ':bm_mark_up_total' => $mydata['ins_bm_mf_sf_total'],
            ':bm_direct_commission' => $mydata['ins_bm_mf_sf_comm'],
            ':bm_incentive' => $mydata['ins_bm_mf_sf_ins'],
            ':prime_customer' => $mydata['ins_l1_cust_comm'],
            ':L1_customer' => $mydata['ins_l2_cust_comm'],
            ':total_mark_up' => $mydata['insmark_up_title'],
            ':coupon_amount'=> $mydata['inscoupon_title']
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
