<?php
    require '../../connect.php';
    require 'config.php';
    
    date_default_timezone_set('Asia/Calcutta');
    
    $today = date('Y-m-d H:i:s');
    $today_date = date('j') . '-' . date('n') . '-' . date('Y');
    
    header('Content-Type: application/json');
    
    // Get raw JSON
    $secondData = stripslashes(file_get_contents("php://input"));
    $mydata = json_decode($secondData, true);
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Input values
    // $customer_id        = (string)($mydata['cuID'] ?? '');
    // $fullname           = (string)($mydata['name'] ?? '');
    // $travel_agenct_id   = (string)($mydata['userID'] ?? '');
    // $packageID          = (string)($mydata['packageID'] ?? '');
    // $no_of_adult        = (string)($mydata['no_of_adult'] ?? '0');
    // $no_of_child        = (string)($mydata['no_of_child'] ?? '0');
    // $start_date         = (string)($mydata['tour_start_date'] ?? '');
    // $total_passenger    = (string)((int)($mydata['no_of_adult'] ?? 0) + (int)($mydata['no_of_child'] ?? 0));
    // $payment_id         = (string)($mydata['payment_id'] ?? '');
    // $pay_type           = (string)($mydata['pay_type'] ?? '');
    // $gst_total          = (string)($mydata['total_price'] ?? '0');
    // $amount             = (string)($mydata['paid_amount'] ?? '0');
    // $ta_markup          = (string)($mydata['ta_markup'] ?? '0');
    $invoice_no         = (string)($mydata['invoice_no'] ?? '');
    $booking_id         = (string)($mydata['booking_id'] ?? '');
    // $phone              = (string)($mydata['phone'] ?? '');
    // $email              = (string)($mydata['email'] ?? '');
    
    // Validate
    if (!$invoice_no || !$booking_id) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required"
        ]);
        exit;
    }
    
    // Convert amount
    // $amount = (float)$amount;
    
    // Generate Order ID
    // $order_id = "ORD_" . time() . "_" . rand(1000, 9999);
    
    // Insert into DB
    // try {
    //     $stmt = $conn->prepare("
    //         INSERT INTO pg_bookings (
    //             order_id,
    //             booking_id,
    //             invoice_no,
    //             pay_type,
    //             package_id,
    //             travel_consultant_id,
    //             customer_id,
    //             name,
    //             email,
    //             phone,
    //             amount,
    //             status
    //         ) VALUES (
    //             :order_id,
    //             :booking_id,
    //             :invoice_no,
    //             :pay_type,
    //             :package_id,
    //             :travel_consultant_id,
    //             :customer_id,
    //             :name,
    //             :email,
    //             :phone,
    //             :amount,
    //             'PENDING'
    //         )
    //     ");
    
    //     $stmt->execute([
    //         ':order_id' => $order_id,
    //         ':booking_id' => $booking_id,
    //         ':invoice_no' => $invoice_no,
    //         ':pay_type' => $pay_type,
    //         ':package_id' => $packageID,
    //         ':travel_consultant_id' => $travel_agenct_id,
    //         ':customer_id' => $customer_id,
    //         ':name' => $fullname,
    //         ':email' => $email,
    //         ':phone' => $phone,
    //         ':amount' => $amount
    //     ]);
    
    // } catch (PDOException $e) {
    //     echo json_encode([
    //         "status" => "error",
    //         "message" => "Database error while creating booking"
    //     ]);
    //     exit;
    // }

    $stmt = $conn -> prepare("SELECT * FROM pg_bookings WHERE bookings_id = :bookings_id ");
    $stmt -> execute([':bookings_id' => $booking_id]);
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    $order_id              = (string)($result['order_id']);
    $booking_id_pg         = (string)($result['bookings_id']);
    $invoice_no            = (string)($result['invoice_no']);
    $pay_type              = (string)($result['pay_type']);
    $package_id            = (string)($result['package_id']);
    $travel_consultant_id  = (string)($result['travel_consultant_id']);
    $customer_id           = (string)($result['customer_id']);
    $fullname              = (string)($result['name']);
    $email                 = (string)($result['email']);
    $phone                 = (string)($result['phone']);
    $amount_pg             = (string)($result['amount']);
    $status                = (string)($result['status']);

    $stmt2 = $conn -> prepare("SELECT total_net_payable, bookings_id FROM booking_direct_bill WHERE bookings_id = :bookings_id ");
    $stmt2 -> execute([':bookings_id' => $booking_id]);
    $result2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
    $amount_booking    = (string)($result2['total_net_payable']);
    $booking_id_bill    = (string)($result2['bookings_id']);

    if($booking_id_pg == $booking_id_bill){

        // HDFC payload
        $data = [
            "order_id" => $order_id,
            "amount" => $amount_pg,
            "customer_id" => $customer_id,
            "customer_email" => $email,
            "customer_phone" => $phone,
            "payment_page_client_id" => HDFC_CLIENT_ID,
            "action" => "paymentPage",
            "currency" => "INR",
            "return_url" => "http://localhost/uniqbizz-main/payment-success.php",
            "description" => "Tour Booking Payment",
            "first_name" => $fullname,
            "last_name" => "",
            "udf1" => $booking_id,
            "udf2" => $invoice_no,
            "udf3" => $pay_type,
            "udf4" => $package_id,
            "udf5" => $travel_consultant_id,
            "udf6" => $customer_id
        ];
        
        // Headers
        $headers = [
            "Authorization: Basic " . HDFC_API_KEY,
            "Content-Type: application/json",
            "x-merchantid: " . HDFC_MERCHANT_ID,
            "x-customerid: " . $customer_id
        ];
        
        // cURL request
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, HDFC_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response   = curl_exec($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError  = curl_error($ch);
        
        curl_close($ch);
        
        // Handle error
        if ($curlError) {
            echo json_encode([
                "status" => "error",
                "message" => "Connection error: " . $curlError
            ]);
            exit;
        }
        
        // Parse response
        $result = json_decode($response, true);
        
        // Success
        if (isset($result['payment_links']['web'])) {
        
            $stmt = $conn->prepare("
                UPDATE pg_bookings 
                SET gateway_response = :response 
                WHERE order_id = :order_id
            ");
        
            $stmt->execute([
                ':order_id' => $order_id,
                ':response' => json_encode($result)
            ]);
        
            echo json_encode([
                "status" => "success",
                "payment_url" => $result['payment_links']['web'],
                "order_id" => $order_id,
                "session_id" => $result['id'] ?? null,
                "booking_status" => "1"
            ]);
        
        } else {
        
            $stmt = $conn->prepare("
                UPDATE pg_bookings 
                SET status = 'FAILED', gateway_response = :response 
                WHERE order_id = :order_id
            ");
        
            $stmt->execute([
                ':order_id' => $order_id,
                ':response' => json_encode($result)
            ]);
        
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create payment session",
                "response" => $result,
                "http_code" => $httpCode
            ]);
        }
    }else{
        echo json_encode([
            "status" => "error",
            "message" => "Amount Does not Match"
        ]);
    }
?>