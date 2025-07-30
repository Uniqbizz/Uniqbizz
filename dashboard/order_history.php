<?php
    include_once 'dashboard_user_details.php';

    // get current date to show next payout amount  and pass it in sql @ line 129
    $date = date('F,Y'); //month and year. 'F' - month in Text form
    $nextDateMonth = date('m'); //month in number form
    $nextDateYear = date('Y'); //year
    // echo "Next Date ".$date .' ;' ;
    // echo "Next Month ".$nextDateMonth.' ;';
    // echo "Next Year ".$nextDateYear.' ;';
    // echo '<br>';

    // get Previous date to show Previous payout amount  and pass it in sql @ line 111
    $prevdate = date(" F,Y", strtotime("-1 months")); //month and year. 'F' - month in Text form. '-1' to get prev month
    $prevDateMonth = date('m', strtotime("-1 months")); //month in number form. '-1' to get prev month
    $prevDateYear = date('Y');  //Year in number form. 
    // echo "prev Date ".$prevdate.' ;';
    // echo "prev Month ".$prevDateMonth.' ;';
    // echo "prev year ".$prevDateYear.' ;';
?>

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="assets/css/custom.css" />
    <!-- Css-->
    <link href="assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->

    <style>
        .selected-date {
            background-color: #dfeaff !important;
            /* Light blue highlight */
            border: 2px solid #007bff !important;
            /* Blue border */
            border-radius: 5px;
        }

        .cardHover:hover {
            background-color: #556ee6 !important;
            border-radius: 6px !important;
            /* padding: 4px !important; */
            border: none !important;
        }

        .faIcon {
            padding: 21px 17px 21px 17px !important;
        }

        .faIcon:hover {
            color: #fff !important
        }

        .pera {
            font-size: 10px !important;
            font-weight: 500 !important;
        }

        .dateRange {
            border-radius: 14px !important;
        }

        @media screen and (min-width: 993px) and (max-width: 1180px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }

        }

        @media screen and (min-width: 768px) and (max-width: 960px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }
        }

        @media screen and (min-width: 320px) and (max-width: 485px) {
            .cardText {
                font-size: 11px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 65px !important;
                height: 50px !important;
            }
        }

        @media only screen and (max-width: 1180px) {
            .rowAlign {
                display: block !important;
            }

            .dateRangeAlign {
                display: flex !important;
                justify-content: left !important;
            }

        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        <?php
            // top header logo, hamberger menu, fullscreen icon, profile
            include_once 'header.php';

            // sidebar navigation menu 
            include_once 'sidebar.php';

            require 'connect.php';

            $pending_booking_count = 0;
            $completed_booking_count = 0;
            $pending_payment_amt = 0;
            $completed_payment_amt = 0;

            $sql = "SELECT 
                        b.id, 
                        b.order_id, 
                        b.package_id, 
                        b.date, 
                        b.customer_id, 
                        b.name, 
                        b.status, 
                        p.name AS package_name, 
                        p.tour_days,
                        bd.final_price,
                        bd.amount,
                        COALESCE(bd.part_pay_1, 0) AS part_pay_1,
                        COALESCE(bd.part_pay_2, 0) AS part_pay_2,
                        COALESCE(bd.part_pay_3, 0) AS part_pay_3,
                        bd.part_pay_1_status,
                        bd.part_pay_2_status,
                        bd.part_pay_3_status,
                        bd.status AS bd_status,
                        b.ta_id
                    FROM bookings b
                    LEFT JOIN package p ON b.package_id = p.id
                    LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
                    WHERE 1=1";
            //hirarchy filter logic
            $filter = "";

            if ($userType == '24') { // BCM
                $filter = " AND b.ta_id IN (
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                    INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                )";
            }

            elseif ($userType == '25') { // BDM
                $filter = " AND b.ta_id IN (
                    -- TA via BM under this BDM
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                    INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                    UNION

                    -- TA via TE directly under this BDM
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN employees te ON co.corporate_agency_id = te.employee_id AND te.status = 1
                    WHERE ca.status = 1 AND te.reporting_manager = '$userId'
                )";
            }

            elseif ($userType == '26') { // BM
                $filter = " AND b.ta_id IN (
                    -- TA via corporate_agency
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                    WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'

                    UNION

                    -- Direct TC under BM
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    WHERE ca.status = 1 AND ca.reference_no = '$userId'
                )";
            }

            elseif ($userType == '16') { // TE
                $filter = " AND b.ta_id IN (
                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                    WHERE ca.status = 1 AND ca.reference_no = '$userId'
                )";
            }

            elseif ($userType == '11') { // TC
                $filter = " AND b.ta_id = '$userId'";
            }

            elseif ($userType == '10') { // Customer
                $filter = " AND b.customer_id = '$userId'";
            }

            $sql .= $filter;

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $today = date('Y-m-d'); // Get today's date as a string

            foreach ($bookings as $booking) {
                // Ensure 'date' exists in booking data
                if (!isset($booking['date']) || empty($booking['date'])) {
                    continue; // Skip if date is not set
                }

                $startDate = date('Y-m-d', strtotime($booking['date'])); // Convert start date to string format
                $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0; // Ensure it's an integer
                $endDate = date('Y-m-d', strtotime("$startDate +$tourDays days")); // Calculate end date as string
                if ($booking['part_pay_2_status'] == 0) {
                    $pending_payment_amt += floatval(number_format($booking['part_pay_2'], 2, '.', '')); // Convert NULL to 0

                }
                if ($booking['part_pay_3_status'] == 0) {
                    $pending_payment_amt += floatval(number_format($booking['part_pay_3'], 2, '.', '')); // Convert NULL to 0
                }
                if ($booking['status'] == '1' && $booking['bd_status'] == 1) {
                    $completed_payment_amt += floatval(number_format($booking['final_price'], 2, '.', '')); // Convert NULL to 0
                }
                if ($today > $endDate) {
                    $completed_booking_count++;
                } elseif ($today >= $startDate && $today <= $endDate) {
                    $pending_booking_count++;
                } else {
                    $pending_booking_count++;
                }
            }


        ?>
        <div>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-hourglass-end fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $pending_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">Pending Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-check fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0"><?= $completed_booking_count ?></h3>
                                            <p class="text-muted mb-0 pera">Completed Booking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-hourglass-half fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0">&#8377;<?= $pending_payment_amt ?></h3>
                                            <p class="text-muted mb-0 pera">Pending Payment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="bg-primary-subtle text-primary-emphasis rounded-3 cardHover">
                                            <i class="fa-solid fa-check fa-xl faIcon" style="color: #222c5c;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <h3 class="mb-0">&#8377;<?= $completed_payment_amt ?></h3>
                                            <p class="text-muted mb-0 pera">Completed Payment</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Calender Start -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" id="eventCalender">
                                <div class="card rounded-4 d-grid p-3">
                                    <div id="btn-new-event"></div>
                                    <div id='locale-selector' class="d-none"></div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 p-3 pt-2" id="bookingCardData">

                                </div>
                            </div>
                        </div>

                        <!-- Calender End -->

                        <!-- Order History Start -->
                        <div class="row rowAlign">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                                <nav role="navigation">
                                    <ul class="nav nav-underline border-bottom border-1 border-secondary-subtle d-flex justify-content-around" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#allHistory">All</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#pendingHistory">Pending</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#bookedHistory">Booked</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#canceledHistory">Canceled</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#refundHistory">Refund</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                                <div class="d-flex justify-content-end dateRangeAlign">
                                    <div id="reportrange" class="bg-primary text-white px-3 py-2 w-75 text-center dateRange">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span id='selectedDate'></span> <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Order History end -->
                        <div class="tab-content" id='tableList'>
                            <div class="tab-pane fade card show active px-3 rounded-4 tabslist" id="allHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover" id="user_table1">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                                                    <th class="ceterText fw-bolder font-size-13">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer</th>
                                                    <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                                                    <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                    require 'connect.php';
                                                    $customer_fil='';
                                                    //check which user logged in based on user type
                                                    if ($userType == '24') {
                                                        //bcm's lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1 
                                                        INNER JOIN employees as bcm on bcm.employee_id=employees.reporting_manager AND bcm.status=1 
                                                        WHERE ca_travelagency.status=1 and bcm.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '25') {
                                                        //bdm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1  
                                                        WHERE ca_travelagency.status=1 and employees.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '26'){
                                                        //bm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status                                                          
                                                        WHERE ca_travelagency.status=1 and business_mentor.business_mentor_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '16'){
                                                        //TE and lower hirachy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
                                                        WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '11'){
                                                        //TC
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
                                                        WHERE ca_travelagency.status=1 and ca_travelagency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '10'){
                                                        //Customer
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
                                                        INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                                                        WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                        $customer_fil=" AND b.customer_id='".$userId."'";
                                                    }
                                                    
                                                    // Check if travel agencies exist
                                                    if (empty($ta_list)) {
                                                        echo'<tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Travel Agencies Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                        
                                                        // exit; // Stop further execution
                                                    }else{

                                                        // Create an array mapping travel agency IDs to their details
                                                        $ta_details = [];
                                                        $ta_ids = [];
    
    
                                                        foreach ($ta_list as $ta) {
                                                            $ta_ids[] = $ta['ca_travelagency_id']; // Collecting IDs for SQL query
                                                            $ta_details[$ta['ca_travelagency_id']] = [
                                                                'firstname' => $ta['firstname'],
                                                                'lastname' => $ta['lastname'],
                                                                'email' => $ta['email'],
                                                                'phone' => $ta['contact_no']
                                                            ];
                                                        }
    
                                                        if (!empty($ta_list)) {
                                                            $ta_ids_str = "'" . implode("','", $ta_ids) . "'"; // Convert array to comma-separated string
                                                            $sql = "
                                                                    SELECT b.id,
                                                                    b.order_id, 
                                                                    b.customer_id, 
                                                                    b.package_id, 
                                                                    p.name AS package_name,
                                                                    p.tour_days,
                                                                    b.name AS c_name,
                                                                    b.phone,
                                                                    b.email,
                                                                    b.date,
                                                                    b.ta_id,
                                                                    b.status 
                                                                    FROM bookings b
                                                                    JOIN package p ON b.package_id = p.id
                                                                    WHERE b.ta_id IN ($ta_ids_str) $customer_fil"; // Use IN clause to match multiple IDs
                                                        }
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
                                                        // Check if bookings exist
                                                        if (empty($bookings)) {
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Bookings Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                            } else
        
                                                            {
                                                                $i = 0;
        
                                                                foreach ($bookings as $booking) {
                                                                    $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                                                                    $stmt3 = $conn->prepare($sql3);
                                                                    $stmt3->execute();
                                                                    $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                                    $formattedDate = date("d-m-Y", strtotime($booking['date']));
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= ++$i ?></td>
                                                                        <td><?= $booking['order_id'] ?></td>
                                                                        <td><?= $formattedDate ?></td>
                                                                        <td><?= $booking['package_name'] ?></td>
                                                                        <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                                                        <?php
                                                                            $ta_id = $booking['ta_id']; // Get the agency ID from booking
        
                                                                            // Retrieve travel agency details safely
                                                                            $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
        
                                                                        ?>
                                                                        <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                                                        <?php
                                                                            if ($booking_bill['pay_type'] == 2) {
                                                                                # code...
                                                                                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                                    # code...
                                                                                    $perecent_fill = 50;
                                                                                    $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                                    # code...
                                                                                    $perecent_fill = 100;
                                                                                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                                }
                                                                            } else if ($booking_bill['pay_type'] == 3) {
                                                                                # code...
                                                                                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                    # code...
                                                                                    $perecent_fill = 40;
                                                                                    $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                    # code...
                                                                                    $perecent_fill = 70;
                                                                                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                                    # code...
                                                                                    $perecent_fill = 100;
                                                                                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                                    $booking_full_amt = $booking_bill['final_price'];
                                                                                }
                                                                            } else {
                                                                                $perecent_fill = 100;
                                                                                $booking_paid_amt = $booking_bill['amount'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            }
        
                                                                            if ($perecent_fill == 100) {
                                                                                $load_modal = '';
                                                                                $border = 'border-success';
                                                                                $bg_color = 'bg-success';
                                                                                $cursor = '';
                                                                            } else {
                                                                                $load_modal = '';
                                                                                $border = 'border-primary';
                                                                                $bg_color = '';
                                                                                $cursor = 'cursor: pointer';
                                                                            }
                                                                        ?>
                                                                        <td>
                                                                            <div class="progress border  <?= $border ?>" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100" <?= $load_modal ?> data-bs-target="#paymentModal" data-booking-id="<?= $booking['id'] ?>" data-booking-fullamt="<?= $booking_full_amt ?>" data-booking-paytype="<?= $booking_bill['pay_type'] ?>" data-booking-fill="<?= $perecent_fill ?>"
                                                                                <?php
        
                                                                                    if ($perecent_fill == 40) {
                                                                                        echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                    } else if ($perecent_fill == 70) {
                                                                                        echo ' data-remaining-amt="' . $booking_bill['part_pay_3'] . '"data-pending-amt="' . $booking_bill['part_pay_3'] . '"';
                                                                                    } else if ($perecent_fill == 50) {
                                                                                        echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                    }
        
                                                                                ?>
                                                                            >
                                                                                <div class="progress-bar <?= $bg_color ?>" style="width: <?= $perecent_fill ?>%; height:10px; <?= $cursor ?>"><?= $perecent_fill ?>%</div>
                                                                            </div>
                                                                            <div id="" class="my-2 text-center">Paid Rs.<?= $booking_paid_amt ?> of Rs.<?= $booking_full_amt ?></div>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                $startDate = new DateTime($booking['date']); // Convert to DateTime object
        
                                                                                $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0; // Ensure it's an integer
        
                                                                                $endDate = clone $startDate; // Clone to avoid modifying original date
                                                                                $endDate->modify("+$tourDays days"); // Add tour days
        
                                                                                $today = new DateTime(); // Get the current date
                                                                                $today->setTime(0, 0); // Reset time for accurate comparison
        
                                                                                if ($booking['status'] === '2') { // Canceled
                                                                            ?>
                                                                                <div class="d-block">
                                                                                    <a href="#">
                                                                                        <button type="button" class="btn text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder show-cancel-msg" data-id="<?= $booking['id'] ?>">
                                                                                            Canceled
                                                                                        </button>
                                                                                    </a>
                                                                                </div>
                                                                            <?php
                                                                                } else if ($booking['status'] === '3') { // Refunded
                                                                            ?>
                                                                                <div class="d-block">
                                                                                    <a href="#">
                                                                                        <button type="button" class="btn text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-3 fw-bolder">
                                                                                            Refunded
                                                                                        </button>
                                                                                    </a>
                                                                                </div>
                                                                            <?php
                                                                                } else if ($today > $endDate) { // Completed
                                                                            ?>
                                                                                <div class="d-block">
                                                                                    <a href="#">
                                                                                        <button type="button" class="btn text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder">
                                                                                            Completed
                                                                                        </button>
                                                                                    </a>
                                                                                </div>
                                                                            <?php
                                                                                } else if ($today >= $startDate && $today <= $endDate) { // In Progress
                                                                            ?>
                                                                                <div class="d-block">
                                                                                    <a href="#">
                                                                                        <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">
                                                                                            In Progress
                                                                                        </button>
                                                                                    </a>
                                                                                </div>
                                                                            <?php
                                                                                } else { // Upcoming
                                                                            ?>
                                                                                <div class="d-block">
                                                                                    <a href="#">
                                                                                        <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">
                                                                                            Upcoming
                                                                                        </button>
                                                                                    </a>
                                                                                </div>
                                                                            <?php } ?>
        
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="dropdown">
                                                                                <a id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="fa-solid fa-ellipsis pe-3" style="color: grey;"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>">
                                                                                        <i class="fa-solid fa-eye"></i> View
                                                                                    </a>
                                                                                    <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF">
                                                                                        <i class="fa-solid fa-arrow-down"></i> Download Details
                                                                                    </a>
                                                                                    <?php 
                                                                                        if ($booking['status'] === '2') {
                                                                                    ?>
                                                                                    <a class="dropdown-item" href="#" id="refundAction" data-order-id=<?= $booking["id"] ?>>
                                                                                        <i class="fa-solid fa-money-bill-transfer"></i> Initiate Refund
                                                                                    </a>
                                                                                    <?php 
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                        }
                                                    } ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4 tabslist" id="pendingHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover" id="user_table2">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                                                    <th class="ceterText fw-bolder font-size-13">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer</th>
                                                    <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                                                    <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require 'connect.php';
                                                    $customer_fil='';
                                                    //check which user logged in based on user type
                                                    if ($userType == '24') {
                                                        //bcm's lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1 
                                                        INNER JOIN employees as bcm on bcm.employee_id=employees.reporting_manager AND bcm.status=1 
                                                        WHERE ca_travelagency.status=1 and bcm.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '25') {
                                                        //bdm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1  
                                                        WHERE ca_travelagency.status=1 and employees.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '26'){
                                                        //bm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status                                                          
                                                        WHERE ca_travelagency.status=1 and business_mentor.business_mentor_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '16'){
                                                        //TE and lower hirachy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
                                                        WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '11'){
                                                        //TC
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
                                                        WHERE ca_travelagency.status=1 and ca_travelagency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '10'){
                                                        //Customer
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
                                                        INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                                                        WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                        $customer_fil=" AND b.customer_id='".$userId."'";
                                                    }

                                                    // Check if travel agencies exist
                                                    if (empty($ta_list)) {
                                                         echo'<tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Travel Agencies Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                        // exit; // Stop further execution
                                                    } else {

                                                        // Travel Agency Mapping
                                                        $ta_details = [];
                                                        $ta_ids = [];
                                                        foreach ($ta_list as $ta) {
                                                            $ta_ids[] = $ta['ca_travelagency_id'];
                                                            $ta_details[$ta['ca_travelagency_id']] = [
                                                                'firstname' => $ta['firstname'],
                                                                'lastname' => $ta['lastname'],
                                                                'email' => $ta['email'],
                                                                'phone' => $ta['contact_no']
                                                            ];
                                                        }
    
                                                        // Convert IDs to SQL format
                                                        $ta_ids_str = "'" . implode("','", $ta_ids) . "'";
    
                                                        // Fetch Bookings
                                                        $sql = "
                                                                SELECT b.id, b.order_id, b.customer_id, b.package_id, p.name AS package_name, 
                                                                p.tour_days, b.name AS c_name, b.phone, b.email, b.date, b.ta_id 
                                                                FROM bookings b
                                                                JOIN package p ON b.package_id = p.id
                                                                WHERE b.ta_id IN ($ta_ids_str) AND b.status != '2' AND b.status != '3' $customer_fil
                                                                ";
    
                                                        // Debugging: Log SQL query and TA IDs
                                                        // echo "<script>console.log('TA List: " . json_encode($ta_list) . "');</script>";
                                                        // echo "<script>console.log('🔍 SQL Query: " . addslashes($sql) . "');</script>";
                                                        // echo "<script>console.log('🆔 TA IDs: " . addslashes($ta_ids_str) . "');</script>";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    
                                                        // Check if bookings exist
                                                        if (empty($bookings)) {
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Bookings Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php } else
        
                                                            {
                                                                $i = 0;
                                                                //$data_found = false;
                                                                foreach ($bookings as $booking) {
                                                                    $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'];
                                                                    $stmt3 = $conn->prepare($sql3);
                                                                    $stmt3->execute();
                                                                    $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                                    $formattedDate = date("d-m-Y", strtotime($booking['date']));
        
                                                                    // Tour Status Calculation
                                                                    $startDate = new DateTime($booking['date']);
                                                                    $tourDays = (int)$booking['tour_days'];
                                                                    $endDate = clone $startDate;
                                                                    $endDate->modify("+$tourDays days");
        
                                                                    $today = new DateTime();
                                                                    $today->setTime(0, 0);
                                                                    $endDate->setTime(0, 0);
        
                                                                    if ($today > $endDate) {
                                                                        continue;
                                                                    }
        
                                                                    //$data_found = true;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= ++$i ?></td>
                                                                        <td><?= $booking['order_id'] ?></td>
                                                                        <td><?= $formattedDate ?></td>
                                                                        <td><?= $booking['package_name'] ?></td>
                                                                        <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
        
                                                                        <?php
                                                                            $ta_id = $booking['ta_id'];
                                                                            $agency_info = $ta_details[$ta_id] ?? ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
        
                                                                        ?>
                                                                        <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                                                        <?php
                                                                            // Payment Progress Calculation
                                                                            $perecent_fill = 0;
                                                                            $booking_paid_amt = 0;
                                                                            $booking_full_amt = 0;
        
                                                                            if ($booking_bill) {
                                                                                $pay_type = $booking_bill['pay_type'];
                                                                                $final_price = $booking_bill['final_price'];
        
                                                                                if ($pay_type == 2) {
                                                                                    if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                                        $perecent_fill = 50;
                                                                                        $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                                        $perecent_fill = 100;
                                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                    }
                                                                                } elseif ($pay_type == 3) {
                                                                                    if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                        $perecent_fill = 40;
                                                                                        $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                        $perecent_fill = 70;
                                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                    } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                                        $perecent_fill = 100;
                                                                                        $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                                    }
                                                                                } else {
                                                                                    $perecent_fill = 100;
                                                                                    $booking_paid_amt = $booking_bill['amount'];
                                                                                }
        
                                                                                $booking_full_amt = $final_price;
                                                                            }
        
                                                                        ?>
                                                                        <td>
                                                                            <div class="progress border <?= ($perecent_fill == 100 ? 'border-success' : 'border-primary') ?>" role="progressbar"
                                                                                aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100">
                                                                                <div class="progress-bar <?= ($perecent_fill == 100 ? 'bg-success' : '') ?>" style="width: <?= $perecent_fill ?>%;">
                                                                                    <?= $perecent_fill ?>%
                                                                                </div>
                                                                            </div>
                                                                            <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                                                                        </td>
        
                                                                        <?php if ($today >= $startDate && $today <= $endDate) { ?>
                                                                        <td>
                                                                            <div class="d-block">
                                                                                <a href="#">
                                                                                    <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Progress</button>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <?php } else { ?>
                                                                        <td><button class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Upcoming</button></td>
                                                                        <?php } ?>
        
                                                                        <td class="text-center">
                                                                            <div class="dropdown mt-">
                                                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                                                                <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                                                                    <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                        <?php  }
                                                        } 
                                                    }?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4 tabslist" id="bookedHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover" id="user_table3">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                                                    <th class="ceterText fw-bolder font-size-13">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer</th>
                                                    <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                                                    <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require 'connect.php';
                                                    $customer_fil='';
                                                    //check which user logged in based on user type
                                                    if ($userType == '24') {
                                                        //bcm's lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1 
                                                        INNER JOIN employees as bcm on bcm.employee_id=employees.reporting_manager AND bcm.status=1 
                                                        WHERE ca_travelagency.status=1 and bcm.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '25') {
                                                        //bdm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1  
                                                        WHERE ca_travelagency.status=1 and employees.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '26'){
                                                        //bm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status                                                          
                                                        WHERE ca_travelagency.status=1 and business_mentor.business_mentor_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '16'){
                                                        //TE and lower hirachy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
                                                        WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '11'){
                                                        //TC
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
                                                        WHERE ca_travelagency.status=1 and ca_travelagency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '10'){
                                                        //Customer
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
                                                        INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                                                        WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                        $customer_fil=" AND b.customer_id='".$userId."'";
                                                    }

                                                    
                                                    // Check if travel agencies exist
                                                    if (empty($ta_list)) {
                                                         echo'<tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Travel Agencies Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                        // exit; // Stop further execution
                                                    }else{

                                                        // Create an array mapping travel agency IDs to their details
                                                        $ta_details = [];
                                                        $ta_ids = [];
    
                                                        foreach ($ta_list as $ta) {
                                                            $ta_ids[] = $ta['ca_travelagency_id']; // Collecting IDs for SQL query
                                                            $ta_details[$ta['ca_travelagency_id']] = [
                                                                'firstname' => $ta['firstname'],
                                                                'lastname' => $ta['lastname'],
                                                                'email' => $ta['email'],
                                                                'phone' => $ta['contact_no']
                                                            ];
                                                        }
    
                                                        if (!empty($ta_list)) {
                                                            $ta_ids_str = "'" . implode("','", $ta_ids) . "'"; // Convert array to comma-separated string
                                                            $sql = "
                                                                    SELECT b.id,
                                                                        b.order_id, 
                                                                        b.customer_id, 
                                                                        b.package_id, 
                                                                        p.name AS package_name,
                                                                        p.tour_days,
                                                                        b.name AS c_name,
                                                                        b.phone,
                                                                        b.email,
                                                                        b.date,
                                                                        b.ta_id, 
                                                                        b.status
                                                                    FROM bookings b
                                                                    JOIN package p ON b.package_id = p.id
                                                                    WHERE b.ta_id IN ($ta_ids_str) AND b.status='1' $customer_fil"; // Use IN clause to match multiple IDs
                                                        }
    
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
                                                        // Check if bookings exist
                                                        if (empty($bookings)) {
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Bookings Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                            } else
                                                            {
                                                                $i = 0;
                                                                foreach ($bookings as $booking) {
                                                                    $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'];
                                                                    $stmt3 = $conn->prepare($sql3);
                                                                    $stmt3->execute();
                                                                    $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
        
                                                                    $formattedDate = date("d-m-Y", strtotime($booking['date']));
        
                                                                    // Travel agency details
                                                                    $ta_id = $booking['ta_id'];
                                                                    $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
        
                                                                    // Payment calculations
                                                                    if ($booking_bill['pay_type'] == 2) {
                                                                        if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                            continue; // Skip if not fully paid
                                                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                            $perecent_fill = 100;
                                                                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                            $booking_full_amt = $booking_bill['final_price'];
                                                                        }
                                                                    } else if ($booking_bill['pay_type'] == 3) {
                                                                        if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                            continue;
                                                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                            continue;
                                                                        } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                            $perecent_fill = 100;
                                                                            $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                            $booking_full_amt = $booking_bill['final_price'];
                                                                        }
                                                                    } else {
                                                                        $perecent_fill = 100;
                                                                        $booking_paid_amt = $booking_bill['amount'];
                                                                        $booking_full_amt = $booking_bill['final_price'];
                                                                    }
        
                                                                    // **Skip entry if `$perecent_fill` is not 100**
                                                                    if ($perecent_fill !== 100) {
                                                                        continue;
                                                                    }
        
                                                                    // Display the booking details
                                                                ?>
                                                                <tr>
                                                                    <td><?= ++$i ?></td>
                                                                    <td><?= $booking['order_id'] ?></td>
                                                                    <td><?= $formattedDate ?></td>
                                                                    <td><?= $booking['package_name'] ?></td>
                                                                    <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                                                    <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
        
                                                                    <td>
                                                                        <div class="progress border border-success" role="progressbar" aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100">
                                                                            <div class="progress-bar bg-success" style="width: <?= $perecent_fill ?>%; height:10px;"><?= $perecent_fill ?>%</div>
                                                                        </div>
                                                                        <div class="my-2 text-center">Paid Rs.<?= $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                                                                    </td>
                                                                    <?php
                                                                        // Tour completion status
                                                                        $startDate = new DateTime($booking['date']);
                                                                        $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0;
                                                                        $endDate = clone $startDate;
                                                                        $endDate->modify("+$tourDays days");
                                                                        $today = new DateTime();
                                                                        $today->setTime(0, 0);
        
                                                                        if ($today > $endDate) {
                                                                    ?>
                                                                    <td>
                                                                        <div class="d-block">
                                                                            <a href="#">
                                                                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Progress</button>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                    <?php } else if ($today >= $startDate && $today <= $endDate  && ($booking['status'] === '0' || $booking['status'] === '1')) { ?>
                                                                    <td>
                                                                        <div class="d-block">
                                                                            <a href="#">
                                                                                <button type="button" class="btn text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 fw-bolder">In Progress</button>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                    <?php } else { ?>
                                                                    <td>
                                                                        <div class="d-block">
                                                                            <a href="#">
                                                                                <button type="button" class="btn text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder">Upcoming</button>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                    <?php } ?>
        
                                                                    <td class="text-center">
                                                                        <div class="dropdown mt-">
                                                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                                                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                                                                <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                                }
                                                            }
                                                    } ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4 tabslist" id="canceledHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover" id="user_table4">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                                                    <th class="ceterText fw-bolder font-size-13">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer</th>
                                                    <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                                                    <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require 'connect.php';
                                                    $customer_fil='';
                                                    //check which user logged in based on user type
                                                    if ($userType == '24') {
                                                        //bcm's lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1 
                                                        INNER JOIN employees as bcm on bcm.employee_id=employees.reporting_manager AND bcm.status=1 
                                                        WHERE ca_travelagency.status=1 and bcm.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '25') {
                                                        //bdm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1  
                                                        WHERE ca_travelagency.status=1 and employees.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '26'){
                                                        //bm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status                                                          
                                                        WHERE ca_travelagency.status=1 and business_mentor.business_mentor_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '16'){
                                                        //TE and lower hirachy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
                                                        WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '11'){
                                                        //TC
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
                                                        WHERE ca_travelagency.status=1 and ca_travelagency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '10'){
                                                        //Customer
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
                                                        INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                                                        WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                        $customer_fil=" AND b.customer_id='".$userId."'";
                                                    }

                                                    
                                                    // Check if travel agencies exist
                                                    if (empty($ta_list)) {
                                                         echo'<tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Travel Agencies Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                        // exit; // Stop further execution
                                                    } else {

                                                        // Create an array mapping travel agency IDs to their details
                                                        $ta_details = [];
                                                        $ta_ids = [];
    
                                                        foreach ($ta_list as $ta) {
                                                            $ta_ids[] = $ta['ca_travelagency_id']; // Collecting IDs for SQL query
                                                            $ta_details[$ta['ca_travelagency_id']] = [
                                                                'firstname' => $ta['firstname'],
                                                                'lastname' => $ta['lastname'],
                                                                'email' => $ta['email'],
                                                                'phone' => $ta['contact_no']
                                                            ];
                                                        }
    
                                                        if (!empty($ta_list)) {
                                                            $ta_ids_str = "'" . implode("','", $ta_ids) . "'"; // Convert array to comma-separated string
                                                            $sql = "
                                                                    SELECT b.id,
                                                                        b.order_id, 
                                                                        b.customer_id, 
                                                                        b.package_id, 
                                                                        p.name AS package_name,
                                                                        p.tour_days,
                                                                        b.name AS c_name,
                                                                        b.phone,
                                                                        b.email,
                                                                        b.date,
                                                                        b.ta_id,
                                                                        b.status
                                                                    FROM bookings b
                                                                    JOIN package p ON b.package_id = p.id
                                                                    WHERE b.ta_id IN ($ta_ids_str) AND b.status='2' $customer_fil"; // Use IN clause to match multiple IDs
                                                        }
    
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
                                                        // Check if bookings exist
                                                        if (empty($bookings)) {
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Bookings Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                            } else 
                                                            {
                                                                $i = 0;
                                                                foreach ($bookings as $booking) {
                                                                    $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                                                                    $stmt3 = $conn->prepare($sql3);
                                                                    $stmt3->execute();
                                                                    $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                                    //echo $booking['id'];
                                                                    if (!$booking_bill) {
                                                                        continue; // Skip this booking if no matching record is found
                                                                    }
                                                                    $formattedDate = date("d-m-Y", strtotime($booking['date']));
                                                                ?>
                                                                <tr>
                                                                    <td><?= ++$i ?></td>
                                                                    <td><?= $booking['order_id'] ?></td>
                                                                    <td><?= $formattedDate ?></td>
                                                                    <td><?= $booking['package_name'] ?></td>
                                                                    <td><? $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
                                                                    <?php
                                                                        $ta_id = $booking['ta_id']; // Get the agency ID from booking
        
                                                                        // Retrieve travel agency details safely
                                                                        $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
                                                                    ?>
                                                                    <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                                                    <?php
                                                                        if ($booking_bill['pay_type'] == 2) {
                                                                            # code...
                                                                            if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 50;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                                # code...
                                                                                $perecent_fill = 100;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            }
                                                                        } else if ($booking_bill['pay_type'] == 3) {
                                                                            # code...
                                                                            if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 40;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 70;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                                # code...
                                                                                $perecent_fill = 100;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            }
                                                                        } else {
                                                                            $perecent_fill = 100;
                                                                            $booking_paid_amt = $booking_bill['amount'];
                                                                            $booking_full_amt = $booking_bill['final_price'];
                                                                        }
        
                                                                        if ($perecent_fill == 100) {
                                                                            $load_modal = '';
                                                                            $border = 'border-success';
                                                                            $bg_color = 'bg-success';
                                                                            $cursor = '';
                                                                        } else {
                                                                            $load_modal = '';
                                                                            $border = 'border-primary';
                                                                            $bg_color = '';
                                                                            $cursor = 'cursor: pointer';
                                                                        }
                                                                    ?>
                                                                    <td>
                                                                        <div class="progress border  <?= $border ?>" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $perecent_fill ?>" aria-valuemin="0" aria-valuemax="100" <?= $load_modal ?> data-bs-target="#paymentModal" data-booking-id="<?= $booking['id'] ?>" data-booking-fullamt="<?= $booking_full_amt ?>" data-booking-paytype="<?= $booking_bill['pay_type'] ?>" data-booking-fill="<?= $perecent_fill ?>"
                                                                            <?php
                                                                                if ($perecent_fill == 40) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                } else if ($perecent_fill == 70) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_3'] . '"data-pending-amt="' . $booking_bill['part_pay_3'] . '"';
                                                                                } else if ($perecent_fill == 50) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                }
                                                                            ?>>
                                                                            <div class="progress-bar <?= $bg_color . '" style="width: ' . $perecent_fill . '%; height:10px; ' . $cursor ?>"><?= $perecent_fill ?>%</div>
                                                                        </div>
                                                                        <div id="" class="my-2 text-center">Paid Rs.<? $booking_paid_amt . ' of Rs.' . $booking_full_amt ?></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-block">
                                                                            <a href="#">
                                                                                <button type="button" class="btn text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder show-cancel-msg" data-id="<?= $booking['id'] ?>">Canceled</button>
                                                                            </a>
                                                                        </div>
                                                                    <td class="text-center">
                                                                        <div class="dropdown mt-">
                                                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                                                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                                                                <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                                                                <a class="dropdown-item refundAction" href="#" data-order-id=<?= $booking["id"] ?>><i class="fa-solid fa-money-bill-transfer"></i> Initiate Refund</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php 
                                                                } 
                                                            }
                                                    } ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade card show px-3 rounded-4 tabslist" id="refundHistory" role="tabpanel">
                                <div class="col-lg-12 py-3">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover" id="user_table5">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                                                    <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                                                    <th class="ceterText fw-bolder font-size-13">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-13">Customer</th>
                                                    <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                                                    <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Status</th>
                                                    <th class="ceterText fw-bolder font-size-13">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require 'connect.php';
                                                    $customer_fil='';
                                                    
                                                    //check which user logged in based on user type
                                                    if ($userType == '24') {
                                                        //bcm's lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1 
                                                        INNER JOIN employees as bcm on bcm.employee_id=employees.reporting_manager AND bcm.status=1 
                                                        WHERE ca_travelagency.status=1 and bcm.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '25') {
                                                        //bdm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status 
                                                        INNER JOIN employees on employees.employee_id=business_mentor.reference_no AND employees.status=1  
                                                        WHERE ca_travelagency.status=1 and employees.employee_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '26'){
                                                        //bm and lower hirarchy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1 
                                                        INNER JOIN business_mentor on corporate_agency.reference_no=business_mentor.business_mentor_id and business_mentor.status                                                          
                                                        WHERE ca_travelagency.status=1 and business_mentor.business_mentor_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '16'){
                                                        //TE and lower hirachy
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                                                        INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
                                                        WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '11'){
                                                        //TC
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
                                                        WHERE ca_travelagency.status=1 and ca_travelagency_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                    } else if ($userType == '10'){
                                                        //Customer
                                                        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency 
                                                        INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                                                        WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id='".$userId."'";
                                                        $stmt0 = $conn->prepare($sql0);
                                                        $stmt0->execute();
                                                        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
                                                        $customer_fil=" AND b.customer_id='".$userId."'";
                                                    }
                                                    
                                                    
                                                    // Check if travel agencies exist
                                                    if (empty($ta_list)) {
                                                         echo'<tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Travel Agencies Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                        // exit; // Stop further execution
                                                    } else {

                                                        // Create an array mapping travel agency IDs to their details
                                                        $ta_details = [];
                                                        $ta_ids = [];
    
                                                        foreach ($ta_list as $ta) {
                                                            $ta_ids[] = $ta['ca_travelagency_id']; // Collecting IDs for SQL query
                                                            $ta_details[$ta['ca_travelagency_id']] = [
                                                                'firstname' => $ta['firstname'],
                                                                'lastname' => $ta['lastname'],
                                                                'email' => $ta['email'],
                                                                'phone' => $ta['contact_no']
                                                            ];
                                                        }
    
                                                        if (!empty($ta_list)) {
                                                            $ta_ids_str = "'" . implode("','", $ta_ids) . "'"; // Convert array to comma-separated string
                                                            $sql = "
                                                                    SELECT b.id,
                                                                        b.order_id, 
                                                                        b.customer_id, 
                                                                        b.package_id, 
                                                                        p.name AS package_name,
                                                                        p.tour_days,
                                                                        b.name AS c_name,
                                                                        b.phone,
                                                                        b.email,
                                                                        b.date,
                                                                        b.ta_id,
                                                                        b.status
                                                                    FROM bookings b
                                                                    JOIN package p ON b.package_id = p.id
                                                                    WHERE b.ta_id IN ($ta_ids_str) AND b.status='3' $customer_fil"; // Use IN clause to match multiple IDs
                                                        }
    
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        // Check if bookings exist
                                                        if (empty($bookings)) {
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">No Bookings Found</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                            }
                                                            {
                                                                $i = 0;
                                                                foreach ($bookings as $booking) {
                                                                    $sql3 = "SELECT * FROM booking_direct_bill WHERE bookings_id = " . $booking['id'] . "";
                                                                    $stmt3 = $conn->prepare($sql3);
                                                                    $stmt3->execute();
                                                                    $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                                    $formattedDate = date("d-m-Y", strtotime($booking['date']));
                                                                ?>
                                                                <tr>
                                                                    <td><?= ++$i ?></td>
                                                                    <td><?= $booking['order_id'] ?></td>
                                                                    <td><?= $formattedDate ?></td>
                                                                    <td><?= $booking['package_name'] ?></td>
                                                                    <td><?= $booking['c_name'] . '(' . $booking['customer_id'] . ')<br>' . $booking['phone'] . '<br>' . $booking['email'] ?></td>
        
                                                                    <?php
                                                                        $ta_id = $booking['ta_id']; // Get the agency ID from booking
        
                                                                        // Retrieve travel agency details safely
                                                                        $agency_info = isset($ta_details[$ta_id]) ? $ta_details[$ta_id] : ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];
                                                                    ?>
                                                                    <td><?= $agency_info['firstname'] . ' ' . $agency_info['lastname'] . '<br>' . $agency_info['phone'] . '<br>' . $agency_info['email'] ?></td>
                                                                    <?php
                                                                        if ($booking_bill['pay_type'] == 2) {
                                                                            # code...
                                                                            if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 50;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                                                                                # code...
                                                                                $perecent_fill = 100;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            }
                                                                        } else if ($booking_bill['pay_type'] == 3) {
                                                                            # code...
                                                                            if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 40;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                                                                                # code...
                                                                                $perecent_fill = 70;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                                                                                # code...
                                                                                $perecent_fill = 100;
                                                                                $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                                                                                $booking_full_amt = $booking_bill['final_price'];
                                                                            }
                                                                        } else {
                                                                            $perecent_fill = 100;
                                                                            $booking_paid_amt = $booking_bill['amount'];
                                                                            $booking_full_amt = $booking_bill['final_price'];
                                                                        }
        
                                                                        if ($perecent_fill == 100) {
                                                                            $load_modal = '';
                                                                            $border = 'border-success';
                                                                            $bg_color = 'bg-success';
                                                                            $cursor = '';
                                                                        } else {
                                                                            $load_modal = '';
                                                                            $border = 'border-primary';
                                                                            $bg_color = '';
                                                                            $cursor = '';
                                                                        }
                                                                    ?>
        
        
                                                                    <td>
                                                                        <div class="progress border  <?= $border . '" role="progressbar" aria-label="Example with label" aria-valuenow="' . $perecent_fill . '" aria-valuemin="0" aria-valuemax="100" ' . $load_modal . '" data-bs-target="#paymentModal" data-booking-id="' . $booking['id'] . '" data-booking-fullamt="' . $booking_full_amt . '" data-booking-paytype="' . $booking_bill['pay_type'] . '" data-booking-fill="' . $perecent_fill ?>"
        
                                                                            <?php
                                                                                if ($perecent_fill == 40) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                } else if ($perecent_fill == 70) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_3'] . '"data-pending-amt="' . $booking_bill['part_pay_3'] . '"';
                                                                                } else if ($perecent_fill == 50) {
                                                                                    echo ' data-remaining-amt="' . $booking_bill['part_pay_2'] . '" data-pending-amt="' . $booking_bill['part_pay_2'] . '"';
                                                                                }
                                                                            ?>>
                                                                            <div class="progress-bar <?= $bg_color . '" style="width: ' . $perecent_fill . '%; height:10px; ' . $cursor ?>"><?= $perecent_fill ?>%</div>
                                                                        </div>
                                                                        <div id="" class="my-2 text-center">Paid Rs.' . $booking_paid_amt . ' of Rs.' . $booking_full_amt . '</div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-block">
                                                                            <a href="#">
                                                                                <button type="button" class="btn text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle rounded-3 fw-bolder">Refunded</button>
                                                                            </a>
                                                                        </div>
                                                                    <td class="text-center">
                                                                        <div class="dropdown mt-">
                                                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa solid fa-ellipsis pe-3" style="color: grey;"></i></a>
                                                                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="order_details.php?id=<?= urlencode($booking["id"]) ?>"><i class="fa-solid fa-eye"></i> View</a>
                                                                                <a class="dropdown-item" href="dowload_pack_details.php?id=<?= urldecode($booking["package_id"]) ?>" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        } 
                                                    } ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                    <div class="row d-flex justify-content-center d-none" id="refundAmt">
                                        <div class="col-md-8 col-sm-10">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-6 col-sm-6">
                                                    <h5 class="fw-bolder">Paid Refund: <span>&#8377; 10000</span></h5>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <h5 class="fw-bolder">Pending Refund: <span>&#8377; 10000</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Refund Modal -->
        <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refundModalLabel">Initiate Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="refundForm" data-order-id="">
                            <div class="mb-3">
                                <label class="form-label d-block">Is Refund Amount Applicable?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input refund-applicable" type="radio" name="isRefundApplicable" id="refundYes" value="yes" checked>
                                    <label class="form-check-label" for="refundYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input refund-applicable" type="radio" name="isRefundApplicable" id="refundNo" value="no">
                                    <label class="form-check-label" for="refundNo">No</label>
                                </div>
                            </div>

                            <div class="mb-3" id="refundAmountGroup">
                                <label for="refundAmount" class="form-label">Refund Amount</label>
                                <input type="number" class="form-control" id="refundAmount" placeholder="Enter amount">
                            </div>

                            <div class="mb-3">
                                <label for="refundReason" class="form-label">Reason</label>
                                <textarea class="form-control" id="refundReason" rows="3" placeholder="Enter refund reason..."></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit Refund</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cancel Message Modal -->
        <div class="modal fade" id="cancelStatusModal" tabindex="-1" aria-labelledby="cancelStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelStatusModalLabel">Booking Canceled</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p id="cancelMessage" class="text-secondary">Loading message...</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->
    <!-- JAVASCRIPT -->
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Calendar init -->
    <script src="assets/libs/fullcalendar/index.global.min.js"></script>

    <!-- Date Range Picker Script Start -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Date Range Picker Script End -->

    <!-- App js -->
    <!-- <script src="assets/js/app.js"></script> -->
    <script>
        var mybutton = document.getElementById("back-to-top");

        function scrollFunction() {
            100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
        }

        function topFunction() {
            document.body.scrollTop = 0,
                document.documentElement.scrollTop = 0
        }
        mybutton && (window.onscroll = function() {
            scrollFunction()
        });
    </script>
    <script>
        //show cancel message
        $(document).on('click', '.show-cancel-msg', function() {
            const bookingId = $(this).data('id');

            // Clear previous message
            $('#cancelMessage').text('Loading message...');

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('cancelStatusModal'));
            modal.show();

            // Fetch cancellation message from server
            $.ajax({
                url: 'get_cancel_message.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    booking_id: bookingId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        //$('#cancelMessage').text(response.message);
                        // If your message includes new lines and you want formatting:
                        console.log('res' + response.message);

                        $('#cancelMessage').html(response.message.replace(/\n/g, '<br>'));
                    } else {
                        $('#cancelMessage').text('No message found.');
                    }
                },
                error: function() {
                    $('#cancelMessage').text('Failed to load message. Please try again.');
                }
            });
        });
        // Show modal on click
        $(document).on('click', '#refundAction', function(e) {
            e.preventDefault();
            const orderId = $(this).data('order-id');
            console.log('Clicked Refund - Order ID:', orderId); // 🔍 Log here

            $('#refundForm').attr('data-order-id', orderId); // ✅ camelCase
            $('#refundModal').modal('show');
        });

        // Toggle refund amount field based on radio
        $(document).on('change', 'input[name="isRefundApplicable"]', function() {
            if ($(this).val() === 'yes') {
                $('#refundAmountGroup').show();
            } else {
                $('#refundAmountGroup').hide();
            }
        });

        // Initially set refund amount visibility
        $(document).ready(function() {
            $('input[name="isRefundApplicable"]:checked').trigger('change');
        });

        // Handle refund submission
        $('#refundForm').on('submit', function(e) {
            e.preventDefault();

            const orderId = $(this).attr('data-order-id');
            const isRefundApplicable = $('input[name="isRefundApplicable"]:checked').val();
            const amount = $('#refundAmount').val().trim();
            const reason = $('#refundReason').val().trim();

            // 🛑 Validation
            if (isRefundApplicable === 'yes') {
                if (!amount || isNaN(amount) || parseFloat(amount) <= 0) {
                    alert('Please enter a valid refund amount.');
                    $('#refundAmount').focus();
                    return;
                }

                if (!reason) {
                    alert('Please enter a reason for the refund.');
                    $('#refundReason').focus();
                    return;
                }
            } else {
                if (!reason) {
                    alert('Please enter a reason for the refund.');
                    $('#refundReason').focus();
                    return;
                }
            }

            console.log('Order ID:', orderId);
            console.log('Is Refund Applicable:', isRefundApplicable);
            console.log('Refund Amount:', isRefundApplicable === 'yes' ? amount : 0);
            console.log('Reason:', reason);

            // Submit the form via AJAX
            $.post('submit_refund.php', {
                order_id: orderId,
                is_refund_applicable: isRefundApplicable,
                amount: isRefundApplicable === 'yes' ? amount : 0,
                reason: reason
            }, function(response) {
                alert('Refund submitted!');
                $('#refundModal').modal('hide');
                $('#refundForm')[0].reset(); // Optional: reset form
                $('#refundAmountGroup').hide(); // Hide amount after reset
            }).fail(function() {
                alert('Error submitting refund.');
            });
        });



        function showOrderDetails(id) {
            window.location.href = 'order_details.php?vkvbvjfgfikix=' + id;
        }

        function downloadInvoice(id) {
            window.location.href = 'download_invoice?vkvbvjfgfikix=' + id;
        }
        //to reload data tables
        // Select the target element
        let targetNode = document.getElementById("selectedDate");

        // Create a MutationObserver instance
        let observer = new MutationObserver(function(mutationsList) {
            for (let mutation of mutationsList) {
                if (mutation.type === "childList") {
                    let selectedDate = $("#selectedDate").text().trim(); // Get selected date
                    if (selectedDate) {
                        reloadTable(selectedDate); // Call function to reload table
                    }
                }
            }
        });

        // Start observing changes in the target element
        observer.observe(targetNode, {
            childList: true
        });

        function reloadTable(selectedDate) {
            //console.log('selectedDate:'+selectedDate);
            // Get currently active tab ID (e.g., "#bookedHistory")
            let activeTabId = $(".tabslist.active").attr("id");
            console.log('active table:'+activeTabId);
            
            $.ajax({
                url: "orders/fetch_bookings.php", // Create a PHP script to fetch filtered data
                type: "POST",
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    $("#tableList").html("");
                    $("#tableList").html(response); // Update table body

                    
                    // After inserting, re-activate the previous tab
                    $(".tabslist").removeClass("show active");
                    $("#" + activeTabId).addClass("show active");

                    // Also restore active class on the tab button
                    $(".nav-link").removeClass("active");
                    $('a[href="#' + activeTabId + '"]').addClass("active");
                },
                error: function() {
                    alert("Failed to load data. Please try again.");
                }
            });
        }
    </script>
    <script type="text/javascript">
        console.log('test');
        document.addEventListener('DOMContentLoaded', function() {


            let classVal;
            let eventCalenderEl = document.getElementById('eventCalender');
            let bookingCardsContainer = document.getElementById('bookingCardData');

            if (!eventCalenderEl || !bookingCardsContainer) {
                console.error("❌ Error: Calendar or Booking Card Container Not Found!");
                //return;
            }

            let calendarEl = document.createElement('div');
            calendarEl.id = 'calendar';
            eventCalenderEl.querySelector('.card').appendChild(calendarEl);

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                navLinks: true,

                // ✅ Calendar navigation buttons
                headerToolbar: {
                    right: 'prev,next today',
                    center: 'title',
                    left: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                // ✅ Handle date clicks
                dateClick: function(info) {
                    let selectedDate = info.dateStr;

                    checkBookingsForDate(selectedDate).then(hasBookings => {
                        if (!hasBookings) return; // Do nothing if no bookings exist
                        loadBookingsForDate(selectedDate);
                        highlightSelectedDate(info.date);
                    });
                },

                // ✅ Fetch events dynamically
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('orders/fetch_events.php')
                        .then(response => response.json())
                        .then(data => {
                            if (!data.bookings || !Array.isArray(data.bookings) || data.bookings.length === 0) {
                                console.log("ℹ️ No bookings found, keeping calendar blank.");
                                successCallback([]); // Send empty array to keep the calendar blank
                                return;
                            }

                            // Convert bookings data to FullCalendar format
                            let events = data.bookings.map(booking => ({
                                // title: booking.package_name,
                                title: "",
                                start: booking.date,
                                extendedProps: {
                                    order_id: booking.order_id,
                                    customer_name: booking.name,
                                    status: booking.status
                                }
                            }));

                            successCallback(events);
                        })
                        .catch(error => {
                            console.error("❌ Failed to fetch events:", error);
                            successCallback([]);
                        });
                },
                eventDidMount: function(info) {
                    info.el.style.display = "none"; // Hides event completely
                },
                // ✅ Render event titles correctly
                eventContent: function(arg) {
                    let eventEl = document.createElement('div');
                    eventEl.innerHTML = arg.event.title;
                    return {
                        domNodes: [eventEl]
                    };
                },

                // ✅ Fix Day Cell Content Handling
                dayCellContent: function(arg) {
                    let container = document.createElement('div');
                    container.innerHTML = arg.dayNumberText;

                    checkBookingsForDate(formatDateToIST(arg.date)).then(hasBookings => {
                        if (hasBookings) {
                            let dotEl = document.createElement('div');
                            dotEl.style.width = '10px';
                            dotEl.style.height = '10px';
                            dotEl.style.backgroundColor = 'blue';
                            dotEl.style.borderRadius = '50%';
                            dotEl.style.position = 'absolute';
                            dotEl.style.top = '7px';
                            dotEl.style.right = '61px';
                            container.appendChild(dotEl);
                        }
                    });

                    return {
                        domNodes: [container]
                    };
                }
            });

            calendar.render();

            function loadBookingsForDate(date) {
                console.log("🔍 Fetching bookings for:", date);
                $.ajax({
                    url: 'orders/fetch_events.php',
                    method: 'GET',
                    data: {
                        selected_date: date,
                        limit: 4
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.bookings && Array.isArray(response.bookings)) {
                            updateBookingCards(response.bookings);
                        } else {
                            console.error("❌ Invalid data format:", response);
                            bookingCardsContainer.innerHTML = '<p class="text-center text-danger">Error: Invalid data format</p>';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("❌ AJAX Error:", error);
                        console.log("❗ Server Response:", xhr.responseText);
                    }
                });
            }

            function updateBookingCards(bookings) {
                bookingCardsContainer.innerHTML = '';

                if (bookings.length === 0) {
                    bookingCardsContainer.innerHTML = '<p class="text-center">No bookings for this date.</p>';
                    return;
                }

                bookings.forEach(booking => {
                    let statusBadge = getStatusBadge(booking);
                    let message = booking.status == '3' ?
                        `<p class="mb-0 cardText"><span class="fw-bold">${booking.name}</span> got a <span class="fw-bold">${statusBadge}</span> towards the package <span class="fw-bold">${booking.package_name}</span> with <span class="fw-bold">Booking ID: ${booking.order_id}</span></p>` :
                        `<p class="mb-0 cardText"><span class="fw-bold">${booking.name}</span> has <span class="fw-bold">${statusBadge}</span> the package for <span class="fw-bold">${booking.package_name}</span> with <span class="fw-bold">Booking ID: ${booking.order_id}</span></p>`;

                    let card = `
                <div class="card ${classVal} border border-primary-subtle rounded-4 p-2 mt-2 mb-0">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-center fs-5 fw-bold cardText ms-3">${booking.package_name}</span>
                        <span class="text-muted text-end m-0 pera">${booking.date}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                            <img src="../${booking.package_image}" alt="" width="100" height="75" class="rounded-4 card-Img1">
                        </div>
                        <div class="col-md-9 col-sm-9 col-9">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-2 d-flex align-items-center">
                                    <img src="../uploading/${booking.customer_profile_pic}" alt="" width="50px" height="50px" class="rounded-circle cardProPic">
                                </div>
                                <div class="col-md-10 col-sm-10 col-10">
                                    ${message}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                    bookingCardsContainer.innerHTML += card;
                });
            }

            function checkBookingsForDate(dateStr) {
                return new Promise((resolve) => {
                    $.ajax({
                        url: 'orders/fetch_events.php',
                        method: 'GET',
                        data: {
                            selected_date: dateStr
                        },
                        dataType: 'json',
                        success: function(response) {
                            resolve(response.bookings && response.bookings.length > 0);
                        },
                        error: function(xhr, status, error) {
                            console.error("❌ Error fetching bookings for the date:", error);
                            resolve(false);
                        }
                    });
                });
            }

            function highlightSelectedDate(date) {
                // Convert selected date to IST
                let istDateStr = formatDateToIST(date);

                // Remove previous highlight
                document.querySelectorAll('.selected-date').forEach(el => {
                    el.classList.remove('selected-date');
                    el.style.backgroundColor = ''; // Reset background
                });

                // Highlight the clicked date in IST
                let selectedDateCell = document.querySelector(`[data-date="${istDateStr}"]`);
                if (selectedDateCell) {
                    selectedDateCell.classList.add('selected-date');
                    selectedDateCell.style.backgroundColor = '#dfeaff'; // Light blue highlight
                }
            }

            function formatDateToIST(date) {
                let istOffset = 5.5 * 60 * 60 * 1000; // Convert 5.5 hours to milliseconds
                let local = new Date(date.getTime() + istOffset);
                return local.toISOString().split('T')[0];
            }

            function getStatusBadge(booking) {
                let startDate = new Date(booking.date);
                let tourDays = booking.tour_days ? parseInt(booking.tour_days) : 0;
                let endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + tourDays);

                let today = new Date();
                today.setHours(0, 0, 0, 0);
                startDate.setHours(0, 0, 0, 0);
                endDate.setHours(0, 0, 0, 0);

                if (today > endDate) {
                    classVal = 'text-success-emphasis bg-success-subtle border border-success-subtle';
                    return `<span class=" text-success-emphasis">Completed</span>`;
                } else if (today >= startDate && today <= endDate) {
                    classVal = 'text-info-emphasis bg-info-subtle border border-info-subtle';
                    return `<span class="text-info-emphasis">In Progress</span>`;
                } else if (booking.status == '2') {
                    classVal = 'text-danger-emphasis bg-danger-subtle border border-danger-subtle';
                    return `<span class="text-danger-emphasis">Canceled</span>`;
                } else if (booking.status == '3') {
                    classVal = 'text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle';
                    return `<span class="text-secondary-emphasis">Refund</span>`;
                } else {
                    classVal = 'text-primary-emphasis bg-primary-subtle border border-primary-subtle';
                    return `<span class="text-primary-emphasis">Upcoming</span>`;
                }
            }

            // ✅ IST Date Conversion Function
            function formatDateToIST(date) {
                let istOffset = 5.5 * 60 * 60 * 1000; // Convert 5.5 hours to milliseconds
                let local = new Date(date.getTime() + istOffset);
                return local.toISOString().split('T')[0];
            }

            loadBookingsForDate(null);
        });
    </script>
    <!-- Date Range Script -->
    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>
    <!-- Date Range Script -->
</body>

</html>