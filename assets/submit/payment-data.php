<?php        
// making page separate for TA package part payment 


    // if ($resultFinal) {

    //     $response = [
    //         "status"      => 1,
    //         "invoice_no"  => $invoice_no,
    //         "booking_id"  => $booking_id,
    //         "order_id"    => $pg_order_id
    //     ];
    //     echo json_encode($response);

    // }else{
    //     $response = [
    //         "status" => 0,
    //         "message" => "Failed to create payment booking"
    //     ];
    //     echo json_encode($response);
    // }

    // NEVER trust frontend amount
    $pg_amount = (float)$amount;

    // Input values
    $pg_customer_id       = (string)($mydata['cuID'] ?? '');
    $pg_fullname          = (string)($mydata['name'] ?? '');
    $pg_travel_agency_id  = (string)($mydata['userID'] ?? '');
    $pg_packageID         = (string)($mydata['packageID'] ?? '');
    $pg_pay_type          = (string)($mydata['pay_type'] ?? '');
    $pg_invoice_no        = $invoice_no;
    $pg_booking_id        = $booking_id;
    $pg_phone             = (string)($mydata['phone'] ?? '');
    $pg_email             = (string)($mydata['email'] ?? '');

    // Validation
    if (
        empty($pg_booking_id) ||
        empty($pg_customer_id) ||
        empty($pg_amount)
    ) {

        $response = [
            "status" => 0,
            "message" => "Required payment data missing"
        ];

    } else {

        // Generate Order ID
        $pg_order_id = uniqid('ORD_');

        try {

            $stmt_pg = $conn->prepare("
                INSERT INTO pg_bookings (
                    order_id,
                    bookings_id,
                    invoice_no,
                    pay_type,
                    package_id,
                    travel_consultant_id,
                    customer_id,
                    name,
                    email,
                    phone,
                    amount,
                    status
                ) VALUES (
                    :order_id,
                    :bookings_id,
                    :invoice_no,
                    :pay_type,
                    :package_id,
                    :travel_consultant_id,
                    :customer_id,
                    :name,
                    :email,
                    :phone,
                    :amount,
                    'PENDING'
                )
            ");

            $pgInsert = $stmt_pg->execute([

                ':order_id'             => $pg_order_id,
                ':bookings_id'          => $pg_booking_id,
                ':invoice_no'           => $pg_invoice_no,
                ':pay_type'             => $pg_pay_type,
                ':package_id'           => $pg_packageID,
                ':travel_consultant_id' => $pg_travel_agency_id,
                ':customer_id'          => $pg_customer_id,
                ':name'                 => $pg_fullname,
                ':email'                => $pg_email,
                ':phone'                => $pg_phone,
                ':amount'               => $pg_amount
            ]);

            if ($pgInsert) {

                $response = [
                    "status"      => 1,
                    "invoice_no"  => $invoice_no,
                    "booking_id"  => $booking_id,
                    // "order_id"    => $pg_order_id
                ];
                echo json_encode($response);
            } else {

                $response = [
                    "status" => 0,
                    "message" => "Failed to create payment booking"
                ];
                echo json_encode($response);
            }

        } catch (PDOException $e) {

            $response = [
                "status" => 0,
                "message" => "Database error while creating payment booking",
                "error" => $e->getMessage()
            ];
            echo json_encode($response);
        }
    }
?>