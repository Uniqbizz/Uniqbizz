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
    if ( $mydata['itinerary']['inclusions'] && $mydata['itinerary']['exclusions'] 
        && $mydata['itinerary']['remarks'] && $mydata['itinerary']['thingsToKnow'] && 
        $mydata['itinerary']['thingsToKnow'] && $mydata['itinerary']['highlights']) 
    {
        $sql_2 = 'INSERT INTO package_itinerary_details (package_id,inclusion,exclusion,remark,travel_info,highlights)
                VALUES(:package_id,:inclusion,:exclusion,:remark,:travel_info,:highlights)';
        $statement_2 = $conn->prepare($sql_2);
        $result_2 = $statement_2->execute([
                ':package_id' => $get_id,
                ':inclusion' => json_encode($mydata['itinerary']['inclusions']),
                ':exclusion' => json_encode($mydata['itinerary']['exclusions']),
                ':remark' => json_encode($mydata['itinerary']['remarks']),
                ":travel_info" => json_encode($mydata['itinerary']['thingsToKnow']),
                ":highlights" => json_encode($mydata['itinerary']['highlights'])
            ]);

    }


    if (!empty($mydata['itinerary']['days'])) {
        // Debugging: Log the details_of_day array in the browser console
        //echo '<script>console.log(' . json_encode($mydata['details_of_day']) . ');</script>';
    
        $sql_3 = 'INSERT INTO package_trip_days (package_id,day_id, title, day_details, meal_plan, day_tansport, stay) 
                  VALUES (:package_id,:day_id, :title, :day_details, :meal_plan, :day_tansport, stay)';
        $statement_3 = $conn->prepare($sql_3);
    
        foreach ($mydata['itinerary']['days'] as $day) { // Single loop (flat array)
            $statement_3->bindValue(':package_id', $get_id, PDO::PARAM_INT);
            $statement_3->bindValue(':day_id', json_encode($day['day']), PDO::PARAM_INT);
            $statement_3->bindValue(':title', $day['title'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':day_details', $day['description'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':meal_plan', $day['meals'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':day_tansport', $day['transport'] ?? '', PDO::PARAM_STR);
            $statement_3->bindValue(':stay', $day['stay'] ?? '', PDO::PARAM_STR);
            $statement_3->execute();
        }
    }
    
// insert package pricing data
    if ( $mydata['pricing']['netPriceAdult'] &&  $mydata['pricing']['netPriceChild'] &&
         $mydata['pricing']['mrpPerAdult'] &&  $mydata['pricing']['mrpPerChild'] &&
         $mydata['pricing']['mrpPerAdultGst'] &&  $mydata['pricing']['mrpPerChildGst'] ) 
    {
        $sql_4 = 'INSERT INTO package_pricing (
                    package_id,
                    net_price_adult,
                    net_price_child,
                    net_price_adult_with_GST,
                    net_price_child_with_GST,
                    total_package_price_per_adult,
                    total_package_price_per_child)
                VALUES(
                    :package_id,
                    :net_price_adult,
                    :net_price_child,
                    :net_price_adult_with_GST,
                    :net_price_child_with_GST,
                    :total_package_price_per_adult,
                    :total_package_price_per_child)';
        $statement_4 = $conn->prepare($sql_4);
        $result_4 = $statement_4->execute([
                ':package_id' => $get_id,
                ':net_price_adult' => $mydata['pricing']['netPriceAdult'], //15000
                ':net_price_child' => $mydata['pricing']['netPriceChild'], //8000
                ':net_price_adult_with_GST' => $mydata['pricing']['mrpPerAdult'],
                ':net_price_child_with_GST' => $mydata['pricing']['mrpPerChild'],
                ':total_package_price_per_adult'=>$mydata['pricing']['mrpPerAdultGst'],//19083.5
                ':total_package_price_per_child'=>$mydata['pricing']['mrpPerChildGst']
                
            ]);

    }
// insert package pictures / images //need changes
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
    

//updated markup distribution 29-07-2026 by sv
    if ( $mydata['price']['travelConsultant'] )
    {
        $sql_8 = 'INSERT INTO package_pricing_markup (
            package_id, 
            company, 
            customer, 
            ta_markup, 
            ca_mark_up_total, 
            ca_direct_commission, 
            ca_incentive,
            bm_mark_up_total, 
            bm_direct_commission, 
            bm_incentive,  
            prime_customer, 
            L1_customer, 
            L2_customer, 
            total_mark_up,
            total_commission_amount,
            total_insentive_amount,
            coupon_amount,
            suspence
        ) VALUES (
            :package_id, 
            :company, 
            :customer, 
            :ta_markup, 
            :ca_mark_up_total, 
            :ca_direct_commission, 
            :ca_incentive,
            :bm_mark_up_total, 
            :bm_direct_commission, 
            :bm_incentive, 
            :prime_customer, 
            :L1_customer, 
            :L2_customer, 
            :total_mark_up,
            :total_commission_amount,
            :total_insentive_amount,
            :coupon_amount,
            :suspence
        )';
    
        $statement_8 = $conn->prepare($sql_8);
    
        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['price']['componyMarkup'],
            ':customer' => $mydata['price']['totalCustomerShare'],
            ':ta_markup' => $mydata['price']['travelConsultant'],
            ':ca_mark_up_total' => $mydata['price']['teBmComInsTotal'],
            ':ca_direct_commission' => $mydata['price']['teBmComm'],
            ':ca_incentive' => $mydata['price']['teBmIns'],
            ':bm_mark_up_total' => $mydata['price']['bmTeComInstotal'],
            ':bm_direct_commission' => $mydata['price']['bmTeComm'],
            ':bm_incentive' => $mydata['price']['bmTeIns'],
            ':prime_customer' => $mydata['price']['customer1'],
            ':L1_customer' => $mydata['price']['customer2'],
            ':L2_customer' => $mydata['price']['customer3'],
            ':total_mark_up'=>$mydata['price']['bmTeChainCommInsTotal'],
            ':total_commission_amount' => $mydata['price']['bmTeChainCommTotal'],
            ':total_insentive_amount' => $mydata['price']['bmTeChainInsTotal'],
            ':coupon_amount' => $mydata['price']['couponAdjustment'],
            ':suspence' => $mydata['price']['bmSuspence']
        ]);
       
    }
//new markup distribution 29-07-2026 by sv
    if ( $mydata['price']['travelConsultant'] )
    {
        $sql_8 = 'INSERT INTO package_pricing_markup_te_chain (
            package_id, 
            company, 
            customer, 
            ta_markup, 
            te_mark_up_total, 
            te_direct_commission, 
            te_incentive,
            ete_mark_up_total, 
            ete_direct_commission, 
            ete_incentive, 
            ste_mark_up_total, 
            ste_direct_commission,
            ste_incentive, 
            cte_mark_up_total, 
            cte_direct_commission, 
            cte_incentive, 
            prime_customer, 
            L1_customer, 
            L2_customer, 
            total_mark_up,
            total_commission_amount,
            total_insentive_amount,
            coupon_amount,
            suspence
        ) VALUES (
            ":package_id", 
            ":company", 
            ":customer", 
            ":ta_markup", 
            ":te_mark_up_total", 
            ":te_direct_commission", 
            ":te_incentive",
            ":ete_mark_up_total", 
            ":ete_direct_commission", 
            ":ete_incentive", 
            ":ste_mark_up_total", 
            ":ste_direct_commission",
            ":ste_incentive", 
            ":cte_mark_up_total", 
            ":cte_direct_commission", 
            ":cte_incentive", 
            ":prime_customer", 
            ":L1_customer", 
            ":L2_customer", 
            ":total_mark_up",
            ":total_commission_amount",
            ":total_insentive_amount",
            ":coupon_amount",
            ":suspence"
        )';
    
        $statement_8 = $conn->prepare($sql_8);
    
        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['price']['componyMarkup'],
            ':customer' => $mydata['price']['totalCustomerShare'],
            ':ta_markup' => $mydata['price']['travelConsultant'],
            ':te_mark_up_total' => $mydata['price']['cTeFCommInsTotal'],
            ':te_direct_commission' => $mydata['price']['cTeFComm'],
            ':te_incentive' => $mydata['price']['cTeFIns'],
            ':ete_mark_up_total' => $mydata['price']['eteCommInsTotal'],
            ':ete_direct_commission' => $mydata['price']['eteComm'],
            ':ete_incentive' => $mydata['price']['eteIns'],
            ':ste_mark_up_total' => $mydata['price']['steCommInsTotal'],
            ':ste_direct_commission' => $mydata['price']['steComm'],
            ':ste_incentive' => $mydata['price']['steIns'],
            ':cte_mark_up_total' => $mydata['price']['cteCommInsTotal'],
            ':cte_direct_commission' => $mydata['price']['cteComm'],
            ':cte_incentive' => $mydata['price']['cteIns'],
            ':prime_customer' => $mydata['price']['customer1'],
            ':L1_customer' => $mydata['price']['customer2'],
            ':L2_customer' => $mydata['price']['customer3'],
            ':total_mark_up'=>$mydata['price']['cteChainCommInsTotal'],
            ':total_commission_amount' => $mydata['price']['cteChainCommTotal'],
            ':total_insentive_amount' => $mydata['price']['cteChainInsTotal'],
            ':coupon_amount' => $mydata['price']['couponAdjustment'],
            ':suspence' => $mydata['price']['cteSuspence']
        ]);
       
    }
//new institution markup distribution 29-07-2026 by sv
    if ($mydata['price']['bmIComm'])
    {
        $sql_9 = 'SELECT * FROM package_pricing_markup_institution WHERE package_id=:package_id';
        $statement_9 = $conn->prepare($sql_9);
        $statement_9->execute([':package_id' => $get_id]);
        $result_9 = $statement_9->fetch(PDO::FETCH_ASSOC);

        if($result_9 == null){

            // INSERT  package_pricing_markup_institution
            $sql_8 = 'INSERT INTO package_pricing_markup_institution (
                package_id, 
                company, 
                customer, 
                ins_markup, 
                bm_mark_up_total,
                bm_direct_commission, 
                bm_incentive, 
                prime_customer,
                L1_customer,
                L2_customer, 
                total_mark_up, 
                coupon_amount,
                suspence
            ) VALUES (
                :package_id, 
                :company, 
                :customer, 
                :ins_markup,
                :bm_mark_up_total, 
                :bm_direct_commission, 
                :bm_incentive,
                :prime_customer, 
                :L1_customer,
                :L2_customer, 
                :total_mark_up, 
                :coupon_amount,
                :suspence
            )';

        } 

        $statement_8 = $conn->prepare($sql_8);

        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['price']['componyMarkup'],
            ':customer' => $mydata['price']['totalCustomerShare'],
            ':ins_markup' => $mydata['price']['bmIComm'],
            ':bm_mark_up_total' => $mydata['price']['iBmCommInsTotal'],
            ':bm_direct_commission' => $mydata['price']['iBmComm'],
            ':bm_incentive' => $mydata['price']['iBmIns'],
            ':prime_customer' => $mydata['price']['customer1'],
            ':L1_customer' => $mydata['price']['customer2'],
            ':L2_customer' => $mydata['price']['customer3'],
            ':total_mark_up'=>$mydata['price']['bmIComInsTotal'],
            ':total_commission_amount' => $mydata['price']['bmIComTotal'],
            ':total_insentive_amount' => $mydata['price']['bmIInsTotal'],
            ':coupon_amount' => $mydata['price']['couponAdjustment'],
            ':suspence' => $mydata['price']['bmISuspence']
        ]);
    }
    //new institution cte chain
    if ($mydata['price']['cteIComm'])
    {
        $sql_9 = 'SELECT * FROM package_pricing_markup_institution WHERE package_id=:package_id';
        $statement_9 = $conn->prepare($sql_9);
        $statement_9->execute([':package_id' => $get_id]);
        $result_9 = $statement_9->fetch(PDO::FETCH_ASSOC);

        if($result_9 == null){

            // INSERT  package_pricing_markup_institution
            $sql_8 = 'INSERT INTO package_pricing_markup_te_chain (
                package_id, 
                company, 
                customer, 
                ins_markup, 
                ete_mark_up_total,
                ete_direct_commission, 
                ete_incentive,
                cte_mark_up_total,
                cte_direct_commission, 
                cte_incentive, 
                prime_customer,
                L1_customer,
                L2_customer, 
                total_mark_up, 
                coupon_amount,
                suspence
            ) VALUES (
                :package_id, 
                :company, 
                :customer, 
                :ins_markup,
                :ete_mark_up_total, 
                :ete_direct_commission, 
                :ete_incentive,
                :cte_mark_up_total, 
                :cte_direct_commission, 
                :cte_incentive,
                :prime_customer, 
                :L1_customer,
                :L2_customer, 
                :total_mark_up, 
                :coupon_amount,
                :suspence
            )';

        } 

        $statement_8 = $conn->prepare($sql_8);

        $result_8 = $statement_8->execute([
            ':package_id' => $get_id,
            ':company' => $mydata['price']['componyMarkup'],
            ':customer' => $mydata['price']['totalCustomerShare'],
            ':ins_markup' => $mydata['price']['cteIComm'],
            ':ete_mark_up_total' => $mydata['price']['iEteCommInsTotal'],
            ':ete_direct_commission' => $mydata['price']['iEteComm'],
            ':ete_incentive' => $mydata['price']['iEteIns'],
            ':cte_mark_up_total' => $mydata['price']['iCteCommInsTotal'],
            ':cte_direct_commission' => $mydata['price']['iCteComm'],
            ':cte_incentive' => $mydata['price']['iCteComm'],
            ':prime_customer' => $mydata['price']['customer1'],
            ':L1_customer' => $mydata['price']['customer2'],
            ':L2_customer' => $mydata['price']['customer3'],
            ':total_mark_up'=>$mydata['price']['iCteComInsTotal'],
            ':total_commission_amount' => $mydata['price']['iCteComTotal'],
            ':total_insentive_amount' => $mydata['price']['iCteInsTotal'],
            ':coupon_amount' => $mydata['price']['couponAdjustment'],
            ':suspence' => $mydata['price']['cteISuspence']
        ]);
    }
//    cancel policy insert added on 29-07-2026 by sv
    if ( $mydata['price']['policy_1'] && $mydata['price']['policy_2']
         && $mydata['price']['policy_3'] && $mydata['price']['policy_4']
         && $mydata['price']['policy_5'] )
    {
        

        $sql_10 = 'INSERT INTO cancel_policy (
                    package_id,     
                    policy_1, 
                    policy_2, 
                    policy_3, 
                    policy_4, 
                    policy_5) 
                VALUES (
                    :package_id, 
                    :policy_1, 
                    :policy_2, 
                    :policy_3,
                    :policy_4,
                    :policy_5)
                    ';
        $statement_10 = $conn->prepare($sql_10);
        $result_10 = $statement_10->execute([
            ':package_id'=>$get_id, 
            ':policy_1'=>$mydata['price']['policy_1'], 
            ':policy_2'=>$mydata['price']['policy_2'], 
            ':policy_3'=>$mydata['price']['policy_3'],
            ':policy_4'=>$mydata['price']['policy_4'],
            ':policy_5'=>$mydata['price']['policy_5']
            ]);
    }
    // policy tab
    if ( $mydata['policy']['couponRule'] && $mydata['policy']['booking']
         && $mydata['policy']['documents'] )
    {
        

        $sql_10 = 'INSERT INTO package_policy (
                    package_id,     
                    coupon_allowed, 
                    combine_with_other_offers, 
                    minimum_advance_payment, 
                    full_payment_before_travel) 
                VALUES (
                    :package_id, 
                    :coupon_allowed, 
                    :combine_with_other_offers, 
                    :minimum_advance_payment,
                    :full_payment_before_travel)
                    ';
        $statement_10 = $conn->prepare($sql_10);
        $result_10 = $statement_10->execute([
            ':package_id'=>$get_id, 
            ':coupon_allowed'=>$mydata['policy_1'], 
            ':combine_with_other_offers'=>$mydata['policy_2'], 
            ':minimum_advance_payment'=>$mydata['policy_3'],
            ':full_payment_before_travel'=>$mydata['policy_4']
            ]);
        $payload = json_decode($_POST['payload'], true);

        // print_r($payload);

        if (isset($_FILES['documents']) && !empty($_FILES['documents']['name'][0])) {

            $uploadDir = "../../uploading/package_documents/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['documents']['name'] as $i => $originalName) {

                if ($_FILES['documents']['error'][$i] != UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpName = $_FILES['documents']['tmp_name'][$i];

                $extension = pathinfo($originalName, PATHINFO_EXTENSION);

                $newFileName = uniqid("DOC_") . "." . $extension;

                if (move_uploaded_file($tmpName, $uploadDir . $newFileName)) {

                    $title = $_POST['document_titles'][$i];
                    $documentId = $_POST['document_ids'][$i];

                    // Example insert
                    $stmt = $conn->prepare("
                        INSERT INTO package_documents
                        (
                            package_id,
                            title,
                            file_name,
                            original_name
                        )
                        VALUES
                        (
                            :package_id,
                            :title,
                            :file_name,
                            :original_name
                        )
                    ");

                    $stmt->execute([
                        ':package_id'    => $packageId, // Your inserted package id
                        ':title'         => $title,
                        ':file_name'     => $newFileName,
                        ':original_name' => $originalName
                    ]);
                }
            }
        }
        //documents
        $sql_10 = 'INSERT INTO cancel_policy (
                    package_id,     
                    policy_1, 
                    policy_2, 
                    policy_3, 
                    policy_4, 
                    policy_5) 
                VALUES (
                    :package_id, 
                    :policy_1, 
                    :policy_2, 
                    :policy_3,
                    :policy_4,
                    :policy_5)
                    ';
        $statement_10 = $conn->prepare($sql_10);
        $result_10 = $statement_10->execute([
            ':package_id'=>$get_id, 
            ':policy_1'=>$mydata['policy_1'], 
            ':policy_2'=>$mydata['policy_2'], 
            ':policy_3'=>$mydata['policy_3'],
            ':policy_4'=>$mydata['policy_4'],
            ':policy_5'=>$mydata['policy_5']
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
