<?php
// session_start();

// if (!isset($_SESSION['username2']) || !isset($_SESSION['user_type_id_value']) || !isset($_SESSION['user_id'])) {
//     echo '<script>location.href = "login";</script>';
// }

// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    @session_start(); // Suppress warnings if headers already sent
}

// Define default values for users who are not logged in
$username2 = $_SESSION['username2'] ?? null;
$user_type_id_value = $_SESSION['user_type_id_value'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

// Now you can use these variables safely
// Example usage:
// if ($username2 && $user_type_id_value && $user_id) {
//     // Logged-in user
//     echo "Welcome, $username2!";
// } else {
//     // Guest user
//     echo "Welcome, Guest!";
// }

$id = $_GET['pacId']; //package_id '156'

// echo $userFname = $_SESSION['username2']; //first name of user 'Ryam'.
// echo $userLname = $_SESSION['lname']; //last name of user 'Cardoso'.
// echo $userType = $_SESSION['user_type_id_value']; //user type id value '3'.
// echo $userId = $_SESSION['user_id']; // user id 'TA230030'.
$userId = $_SESSION['user_id']??'0';

require 'connect.php';
// package
$stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
$stmt->execute();
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];
$validity = $package['validity'] ?? 0;

// itinery 
$data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
$data2->execute();
$itinery = $data2->fetch();

// package_pricing 
$data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
$data3->execute();
$amount = $data3->fetch();

// category 
$data5 = $conn->prepare("SELECT * FROM category WHERE id = $cat_id");
$data5->execute();
$category = $data5->fetch();

// sub_cat 
$data6 = $conn->prepare("SELECT * FROM subcategory WHERE id = $sub_cat_id");
$data6->execute();
$sub_cat = $data6->fetch();

// cat hotel 
$data7 = $conn->prepare("SELECT * FROM category_hotel WHERE id = $hotel_cat_id");
$data7->execute();
if ($data7->rowCount() > 0) {
    $hotel_cat = $data7->fetch();
} else {
    $hotel_cat = "null";
}

// cat meal 
$data8 = $conn->prepare("SELECT * FROM category_meal WHERE id = $meal_cat_id");
$data8->execute();
if ($data8->rowCount() > 0) {
    $meal_cat = $data8->fetch();
} else {
    $meal_cat = "null";
}

// Fetch occupancy types for a given package_id
$data9 = $conn->prepare("SELECT * FROM `package_to_category_occupancy` WHERE package_id = :id");
$data9->bindParam(':id', $id, PDO::PARAM_INT);
$data9->execute();
$occu_type = $data9->rowCount() > 0 ? $data9->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch all occupancy categories
$data10 = $conn->prepare("SELECT id, name FROM `category_occupancy`");
$data10->execute();
$occu_type_id = $data10->rowCount() > 0 ? $data10->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("SELECT * FROM `package_to_category_vehicle` WHERE package_id = :id");
$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();
$vehicle_type = $data11->rowCount() > 0 ? $data11->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

// Fetch all vehicle categories
$data12 = $conn->prepare("SELECT id, name FROM `category_vehicle`");
$data12->execute();
$vehicle_type_id = $data12->rowCount() > 0 ? $data12->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

//cancellation policy
$data9 = $conn->prepare("SELECT * FROM cancel_policy WHERE package_id = $id");
$data9->execute();
if ($data9->rowCount() > 0) {
    $cancel_policy = $data9->fetch();
} else {
    $cancel_policy['policy_1'] = 0;
    $cancel_policy['policy_2'] = 0;
    $cancel_policy['policy_3'] = 0;
}
$customer_labels = [
    'Prime' => 'Prime Customer',
    'Premium' => 'Premium Customer',
];

?>

<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<!-- Mirrored from travelloo.vercel.app/template/tour-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:53:04 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <!-- <script>
    const setTheme = (theme) => {
        theme ?? = localStorage.theme || "light";
        document.documentElement.dataset.theme = theme;
        localStorage.theme = theme;
    };
    setTheme();
    </script> -->

    <script>
        const setTheme = (theme) => {
            // If theme is undefined or null, set it to localStorage.theme or "light"
            theme = theme || localStorage.theme || "light";
            document.documentElement.dataset.theme = theme;
            localStorage.theme = theme;
        };
        setTheme();
    </script>
    <meta logo="assets/images/logo/logo.png">
    <meta white-logo="assets/images/logo/logo-white.png">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
    <meta name="keywords"
        content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
    <meta name="author" content="inittheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Multipurpose travel and tour booking">
    <meta property="og:site_name" content="Mirthcon">
    <meta property="og:url" content="https://inittheme.com">
    <meta property="og:image" content="https://inittheme.com/images/selfie.jpg">
    <meta property="og:description" content="Multipurpose travel and tour booking, multipurpose template">
    <meta name="twitter:title" content="Multipurpose travel and tour booking">
    <meta name="twitter:description" content="Multipurpose travel and tour booking, multipurpose template">
    <meta name="twitter:image" content="https://twitter.com/inittheme/photo">
    <meta name="twitter:card" content="summary">
    <!-- Google site verification -->
    <meta name="google-site-verification" content="...">
    <meta name="facebook-domain-verification" content="...">
    <meta name="csrf-token" content="...">
    <meta name="currency" content="$">
    <!-- Title -->
    <title>Book Tour </title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
    <!-- Fonts & icon -->
    <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
    <!-- RTL CSS::When Need RTL Uncomments File -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
</head>

<body>
    <?php include_once "header.php" ?>
    <main>
        <!-- Breadcrumbs S t a r t -->
        <section class="breadcrumbs-area breadcrumb-bg">
            <div class="container">
                <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Tour Details</h1>
                <div class="breadcrumb-text">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                            <li class="breadcrumb-item single-list" aria-current="page">
                                <a href="javascript:void(0)" class="single active">Tour Details</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <!--/ End-of Breadcrumbs-->

        <!-- Destination area S t a r t -->
        <section class="tour-details-section section-padding2">
            <div class="tour-details-area">
                <!-- Details Banner Slider -->
                <div class="tour-details-banner">
                    <div class="swiper tourSwiper-active">
                        <div class="swiper-wrapper">
                            <?php
                            require 'connect.php';
                            $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = $id");
                            $data->execute();
                            $data->setFetchMode(PDO::FETCH_ASSOC);
                            if ($data->rowCount() > 0) {
                                $counterimage = 0;
                                foreach (($data->fetchAll()) as $key_1 => $image) {
                                    echo '<div class="swiper-slide">
                                            <img src="' . $image['image'] . '" alt="BizzMirth" >
                                        </div>';
                                }
                            }
                            ?>

                        </div>
                        <div class="swiper-button-next"><i class="ri-arrow-right-s-line"></i></div>
                        <div class="swiper-button-prev"><i class="ri-arrow-left-s-line"></i></div>
                    </div>
                </div>
                <!-- / Slider-->
                <div class="tour-details-container">
                    <div class="container">

                        <!-- Details Heading -->
                        <div class="details-heading">
                            <div class="d-flex flex-column">
                                <h4 class="title" id="pack_name"><?php echo $package['name'] ?></h4>
                                <div class="d-flex flex-wrap align-items-center gap-30 mt-16">
                                    <div class="location">
                                        <i class="ri-map-pin-line"></i>
                                        <div class="name"><?php echo $package['destination'] ?></div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="d-flex align-items-center flex-wrap gap-20">
                                        <div class="count">
                                            <!-- <i class="ri-time-line"></i>
                                            <p class="pera"><?php echo $package['description'] ?> </p> -->
                                            <i class="ri-map-pin-line"></i>
                                            <p class="pera"><?php echo $package['location'] ?></p>
                                        </div>
                                        <div class="count">
                                            <i class="ri-landscape-line"></i>
                                            <p class="pera"><?php echo $package['sightseeing_type'] ?></p>
                                        </div>
                                        <div class="count">
                                            <i class="ri-roadster-line"></i>
                                            <?php
                                            $veh_names = []; // Initialize an array to store vehicle names

                                            foreach ($vehicle_type as $value) { // Corrected variable name
                                                foreach ($vehicle_type_id as $idvalue) { // Corrected variable name
                                                    if ($idvalue['id'] == $value['vehicle_id']) { // Corrected key reference
                                                        $veh_names[] = $idvalue['name']; // Store vehicle names in an array
                                                    }
                                                }
                                            }

                                            echo '<p class="pera">' . implode(', ', $veh_names) . '</p>'; // Join array values with commas
                                            ?>
                                        </div>
                                        <div class="count">
                                            <i class="ri-hotel-bed-line"></i>
                                            <?php
                                            $occu_names = []; // Initialize an array to store occupancy names

                                            foreach ($occu_type as $value) {
                                                foreach ($occu_type_id as $idvalue) {
                                                    if ($idvalue['id'] == $value['occupancy_id']) { // Ensure proper key reference
                                                        $occu_names[] = $idvalue['name']; // Store occupancy names in an array
                                                    }
                                                }
                                            }

                                            echo '<p class="pera">' . implode(', ', $occu_names) . '</p>';
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="price-review">
                                <div class="d-flex gap-10 align-items-end">
                                    <p class="light-pera">Starting From</p>
                                    <p class="pera">
                                        <span>&#8377</span><?php echo $amount['total_package_price_per_adult'] + $amount['price_up_per_adult'] ?>/-
                                    </p>
                                    <!-- <p class="light-pera">exclusive of Tax</p> -->
                                </div>
                                <!-- <div class="rating">
                                    <i class="ri-star-s-fill"></i>
                                    <p class="pera">4.7 (20 Reviews)</p>
                                </div> -->
                            </div>
                        </div>
                        <!-- / Details Heading -->

                        <div class="mt-30">
                            <div class="row g-4">
                                <!-- Left content -->
                                <div class="col-xl-8 col-lg-7">

                                    <!-- About tour -->
                                    <div class="tour-details-content">
                                        <h4 class="title">About</h4>
                                        <p class="pera"><?php echo $package['description'] ?></p>
                                    </div>
                                    <!-- / About tour -->

                                    <!-- Tour Include Exclude -->
                                    <div class="tour-include-exclude radius-6">
                                        <div class="row">
                                            <div class="includ-exclude-point col-md-5">
                                                <h4 class="title">Included</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['inclusion'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="divider border-1 p-0"></div>
                                            <div class="includ-exclude-point col-md-5">
                                                <h4 class="title">Exclude</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['exclusion'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / Tour Include Exclude -->

                                    <!-- Tour Plan accordion-->
                                    <div class="tour-details-content mb-30">
                                        <h4 class="title">Tour Plan</h4>
                                        <div class="destination-accordion">
                                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                                <?php
                                                // package_trip_days 
                                                $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
                                                $data4->execute();
                                                $data4->setFetchMode(PDO::FETCH_ASSOC);

                                                if ($data4->rowCount() > 0) {
                                                    foreach (($data4->fetchAll()) as $key_3 => $day) {
                                                        $decription = $day['day_details'];
                                                        $decription_1 = explode(".", $decription);
                                                        $decription_2 = implode(".<br>", $decription_1);
                                                        echo '<div class="accordion-item">
                                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                                    <button class="accordion-button" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#panelsStayOpen-collapseOne"
                                                                        aria-expanded="true"
                                                                        aria-controls="panelsStayOpen-collapseOne">
                                                                        Day ' . ++$key_3 . ' - ' . $day['title'] . '
                                                                    </button>
                                                                </h2>
                                                                <div id="panelsStayOpen-collapseOne"
                                                                    class="accordion-collapse collapse show"
                                                                    aria-labelledby="panelsStayOpen-headingOne">
                                                                    <div class="accordion-body">
                                                                        <ul class="listing">
                                                                            <li class="list">
                                                                                ' . $decription_2 . '
                                                                            </li>
                                                                        </ul>
                                                                        <hr style="border-top: 1px solid #4b5051" />
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                                <h6>Meal:&nbsp;</h6>
                                                                                <p>' . $day['meal_plan'] . '</p>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                                <h6>Transport:&nbsp;</h6>
                                                                                <p>' . $day['day_tansport'] . '</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>';
                                                    }
                                                }
                                                ?>

                                                <!-- <div class="accordion-item">
                                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#panelsStayOpen-collapseTwo"
                                                            aria-expanded="false"
                                                            aria-controls="panelsStayOpen-collapseTwo">
                                                            Edit 
                                                        </button>
                                                    </h2>
                                                    <div id="panelsStayOpen-collapseTwo"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="panelsStayOpen-headingTwo">
                                                        <div class="accordion-body">
                                                            <p class="pera mb-16">Lorem ipsum dolor sit amet,
                                                                consectetur adipiscing elit, sed do
                                                                eiusmod tempor incididunt ut labore et dolore magna
                                                                aliqua. Ut enim ad minim veniam,
                                                                quis nostrud exercitation ullamco laboris nisi ut
                                                                aliquip ex ea commodo consequat. Duis
                                                                aute irure dolor in reprehenderit in voluptate velit
                                                                esse cillum dolore eu fugiat nulla
                                                                pariatur. Excepteur sint occaecat cupidatat non
                                                                proident, sunt in culpa qui officia
                                                                deserunt mollit anim id est laborum."</p>
                                                            <ul class="listing">
                                                                <li class="list">
                                                                    “Life is either a daring adventure or nothing at
                                                                    all.” ...
                                                                </li>
                                                                <li class="list">
                                                                    “Travel far enough, you meet yourself.” ...
                                                                </li>
                                                                <li class="list">
                                                                    “Wherever you go becomes a part of you somehow.” ...
                                                                </li>
                                                                <li class="list">
                                                                    “Once a year, go someplace you've never been
                                                                    before.”
                                                                </li>
                                                            </ul>
                                                            <hr style="border-top: 1px solid #4b5051" />
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                    <h6>Meal:&nbsp;</h6>
                                                                    <p>Breakfast</p>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 col-12 d-flex">
                                                                    <h6>Transport:&nbsp;</h6>
                                                                    <p>Car</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tour-include-exclude radius-6">
                                        <div class="row">
                                            <div class="includ-exclude-point col-md-12 col-sm-12 col-12">
                                                <h4 class="title">Remark</h4>
                                                <ul class="expect-list">
                                                    <?php
                                                    $decription = $itinery['remark'];
                                                    $decription_1 = explode('.', $decription);
                                                    foreach ($decription_1 as $desc) {
                                                        echo ' <li class="list">' . $desc . '</li> ';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- / Tour Plan accordion-->

                                    <!-- Tour Privacy Policy -->
                                    <!-- <div class="tour-details-content">
                                        <h4 class="title">Policy</h4>
                                        <p class="pera">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                            eiusmod tempor
                                            incididunt
                                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                            exercitation ullamco
                                            laboris
                                            nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                            reprehenderit in voluptate velit
                                            esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                            non proident, sunt in
                                            culpa
                                            qui officia deserunt mollit anim id est laborum."</p>
                                        <p class="pera">Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                            accusantium
                                            doloremque
                                            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis
                                            et quasi architecto
                                            beatae
                                            vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit
                                            aspernatur aut odit aut
                                            fugit,
                                            sed quia consequuntur magni dolores eos qui ratione voluptatem sequi
                                            nesciunt. Neque porro
                                            quisquam est,
                                            qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia
                                            non numquam eius modi
                                            tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut
                                            enim ad minima veniam,
                                            quis
                                            nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid
                                            ex ea commodi
                                            consequatur?
                                            Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam
                                            nihil molestiae
                                            consequatur,
                                            vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>
                                        <ol class="policy-point">
                                            <li class="list">Neque porro quisquam est, qui dolorem ipsum quia dolor sit
                                                amet, consectetur,
                                                adipisci velit.</li>
                                            <li class="list">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
                                                odit aut fugit.</li>
                                            <li class="list">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                                sed do eiusmod.</li>
                                        </ol>
                                    </div> -->
                                    <!-- / Tour Privacy Policy -->
                                </div>
                                <div class="col-xl-4 col-lg-5" id="sidebar-sticky">
                                    <!-- added on 30 Jan 2025 by N-->
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 mb-3" id="sidebar-sticky">
                                            <aside class="date-travel-card position-sticky top-0 pt-3 pb-1">
                                                <div class="sidebar-item sidebar-item-dark">
                                                    <div class="detail-title mb-3">
                                                        <p class="fs-6 text-muted">Per Adult Price: <b>₹
                                                                <?php echo $amount['total_package_price_per_adult'] + $amount['price_up_per_adult']; ?>/-</b>
                                                        </p>
                                                        <p class="fs-6 text-muted">Per Child Price: <b>₹
                                                                <?php echo $amount['total_package_price_per_child']; ?>/-</b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </aside>
                                        </div>
                                        <div class="detail-title mb-3 d-flex justify-content-between bookBtn">
                                            <?php if($userId !='0'){ ?>
                                            <button class="send-btn toggle-btn p-2 bookBtn1" id="button1">Book This Tour</button>
                                            <?php  } ?>
                                            <button class="send-btn toggle-btn p-2" id="button2">Request Quotation</button>
                                        </div>
                                        <div id="sidebar-sticky">
                                            <div class="sidebar-item sidebar-item-dark">
                                                <?php if($userId !='0'){ ?>
                                                <div class="form-container date-travel-card position-sticky top-0" id="form1">
                                                    <form>
                                                        <h5 class="fw-bolder my-2">Book Tour</h5>
                                                        <input type="hidden" name="_token" id="csrf-token"
                                                            value="{{ Session::token() }}" />
                                                        <input type="hidden" name="package_id" id="package_id"
                                                            value="<?php echo $id ?>" />
                                                        <div class="row">
                                                            <?php
                                                            $user_type = $_SESSION['user_type_id_value'];

                                                            $fname = '';
                                                            $lname = '';
                                                            $email = '';
                                                            $phone = '';
                                                            $dob = '';
                                                            $customer_id = '';
                                                            $user_cust_id = "0";
                                                            $ta_markup_price = 0;
                                                            $ta_id = '';

                                                            // For Travel Agent Reference Customers 
                                                            if ($_SESSION['user_id']) {
                                                                $user_cust_id = $_SESSION['user_id'];
                                                            }

                                                            //  If Customer then
                                                            if ($user_type == "10") {
                                                                $stmt = $conn->prepare("SELECT * FROM customer where cust_id='" . $user_cust_id . "' ");
                                                                $stmt->execute();
                                                                $data = $stmt->fetch();
                                                                if ($data) {
                                                                    $fname = $data['firstname'];
                                                                    $lname = $data['lastname'];
                                                                    $email = $data['email'];
                                                                    $phone = $data['contact_no'];
                                                                    $dob = $data['age'];
                                                                    $customer_id = $data['cust_id'];

                                                                    $ta_id = $data['ta_reference'];
                                                                }

                                                            ?>
                                                                <input type="hidden" id="cust_id"
                                                                    value="<?php echo $customer_id ?>" />
                                                                <!-- // Else If Travel Agent -->
                                                            <?php } else if ($user_type == "11") {
                                                                $ta_id = $user_cust_id;
                                                            ?>
                                                                <input type="hidden" id="user_id"
                                                                    value="<?php echo $ta_id ?>" />
                                                                <!-- get Customer Type -->
                                                                <div class="form-group col-sm-12 mb-3">
                                                                    <label class="b_label" for="b_cust_type">Customer Type</label>
                                                                    <div class="selectdesign mt-2">
                                                                        <span>
                                                                            <input type="radio" name="cust_type" value="1"
                                                                                id="registered" class="radio_label"
                                                                                checked="checked">
                                                                            <label class="radio_label b_label"
                                                                                for="registered">Registered</label>
                                                                        </span>
                                                                        <span class="ms-5">
                                                                            <input type="radio" name="cust_type" value="2"
                                                                                id="lead" class="radio_label">
                                                                            <label class="radio_label b_label"
                                                                                for="lead">Lead</label>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- TA -->
                                                                <div class="input-box col-sm-12 customersID">
                                                                    <input type="text" class="border-0 fs-6 bg-transparent"
                                                                        list="customer_suggestion" id="cust_id"
                                                                        placeholder="Select Customer ID" />
                                                                    <datalist id="customer_suggestion" class="selectdesign">
                                                                        <?php echo '<option> No Customer to Show </option>'; ?>
                                                                    </datalist>
                                                                </div>
                                                                <!--  TA End -->
                                                            <?php } else { ?>
                                                                <input type="hidden" id="cust_id" value="0" />
                                                            <?php }

                                                            // get TA Mark up Price
                                                            if ($ta_id) {
                                                                $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $id . "' LIMIT 1");
                                                                $ta_markup_data->execute();
                                                                $ta_markup = $ta_markup_data->fetch();
                                                                if ($ta_markup) {
                                                                    $ta_markup_price = $ta_markup['markup'] ?? 0;
                                                                } else {
                                                                    $ta_markup_price = 0;
                                                                }
                                                            } else {
                                                                $ta_markup_price = 0;
                                                            }
                                                            ?>
                                                            <input type="hidden" name="dob" id="dob"
                                                                value="<?php echo $dob ?>" />
                                                            <!-- payee details -->
                                                            <input type="hidden" id="payee_name" value="" />
                                                            <input type="hidden" id="payee_email" value="" />
                                                            <input type="hidden" id="payee_contact" value="" />
                                                            <input type="hidden" id="book_id" value="" />
                                                            <!-- payee details -->

                                                            <label class="b_label d-flex justify-content-between pe-0" for="b_name">Name
                                                                <span id="primeCustomer_span" class="mb-2 d-none">
                                                                    <span id="specCust" class="py-1 px-2 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 border-0 fontSize">
                                                                        
                                                                    </span>
                                                                </span>
                                                            </label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="text"
                                                                    class=" border-0 fs-6 bg-transparent w-100"
                                                                    name="b_name" id="b_name" placeholder="Name"
                                                                    value="<?php echo $fname . ' ' . $lname ?>">
                                                            </div>

                                                            <label class="b_label" for="b_email">Email </label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="email"
                                                                    class=" border-0 fs-6 bg-transparent w-100"
                                                                    name="b_email" id="b_email" placeholder="Email"
                                                                    value="<?php echo $email ?>">
                                                            </div>
                                                            <label class="b_label" for="b_phn_no">Mobile </label>
                                                            <div class="input-box col-sm-12 ">
                                                                <input type="tel"
                                                                    class=" border-0 fs-6 bg-transparent w-100"
                                                                    name="b_phn_no" id="b_phn_no"
                                                                    placeholder="Phone Number"
                                                                    value="<?php echo $phone ?>">
                                                            </div>
                                                            <label class="b_label" for="b_date">Tour Date </label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="date"
                                                                    class=" border-0 fs-6 bg-transparent w-100"
                                                                    name="b_date" id="b_date" value="">
                                                            </div>

                                                            <div class="form-group col-sm-12 px-0">
                                                                <div class="row">
                                                                    <?php if (!empty($amount['total_package_price_per_child'])) { ?>
                                                                        <div class="form-group col-sm-4 col-6">
                                                                        <?php } else { ?>
                                                                            <div class="form-group col-sm-4 col-6">
                                                                            <?php } ?>
                                                                            <label class="b_label ps-3" for="b_no_adult">Adults</label>
                                                                            <div class="input-box p-2 mb-1">
                                                                                <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="b_no_adult" id="b_no_adult" value="" placeholder="Adults" min="1">
                                                                            </div>
                                                                            <span class="label_txt ps-3 fontSize"> (12+ Yrs) </span>
                                                                            </div>
                                                                            <?php if (!empty($amount['total_package_price_per_child'])) { ?>
                                                                                <div class="form-group col-sm-4 col-6">
                                                                                    <label class="b_label ps-3"
                                                                                        for="b_no_child">Children </label>
                                                                                    <div class="input-box p-2 mb-1">
                                                                                        <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="b_no_child" id="b_no_child" value="0" placeholder="Children" min="0">
                                                                                    </div>
                                                                                    <span class="label_txt ps-3 fontSize"> (3-11 Yrs) </span>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <input type="number" class="form-control" name="b_no_child" id="b_no_child" value="0" placeholder="Children" min="0" style="display:none">
                                                                            <?php } ?>
                                                                            <?php if (!empty($amount['total_package_price_per_child'])) { ?>
                                                                                <div class="form-group col-sm-4 col-6">
                                                                                <?php } else { ?>
                                                                                    <div class="form-group col-sm-6 pe-0">
                                                                                    <?php } ?>
                                                                                    <label class="b_label ps-3"
                                                                                        for="b_no_infants">Infants </label>
                                                                                    <div class="input-box p-2 mb-1">
                                                                                        <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="b_no_infants" id="b_no_infants" placeholder="Infants" value="0" min="0">
                                                                                    </div>
                                                                                    <span class="label_txt ps-3 fontSize"> (Under 2 Yrs)</span>
                                                                                    </div>
                                                                                </div>
                                                                        </div>

                                                                        <div id="discount_price_box" class="px-0 d-none">
                                                                            <h5 class="fw-bold fs-6 my-2">Available Coupons</h5>
                                                                            <select class="form-select" id="coupon_select" onchange="applySelectedCoupon()">
                                                                                <option value="" disabled>Select a coupon</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-12" id="primeCustomer" style="display: none;">
                                                                            <div class="row">
                                                                                <div class="col-12 col-sm-12 text-end text-color t1 mt-3">
                                                                                    <h5 class="fw-bold"><del style="font-size: 14px;">₹ <span id="get_total_package_price">0</span></del>
                                                                                </div>
                                                                                <div class="col-6 col-sm-6 text-color t1 pe-0">
                                                                                    <h5 class="fw-bold">Total Amount</h5>
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-6 text-color text-end t2 d-none">
                                                                                    ₹ <span id="get_single_adult_package_price">0</span>
                                                                                </div>
                                                                                <div class="col-6 col-sm-6 text-color text-end t2 ps-0">
                                                                                    <h5 class="fw-bold">₹ <span id="get_total_package_price_actual">0</span></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 d-none" id="nonprimeCustomer">
                                                                            <div class="row">
                                                                                <div class="col-7 col-sm-7 text-color t1 mt-3">
                                                                                    <h5 class="fw-bold">Total Amount</h5>
                                                                                </div>
                                                                                <div class="col-xs-5 col-sm-6 text-color text-end t2 d-none">
                                                                                    ₹ <span id="get_single_adult_package_price_np">0</span>
                                                                                </div>
                                                                                <div class="col-5 col-sm-5 text-color text-end t2 mt-3">
                                                                                    <h5 class="fw-bold">₹ <span id="get_total_package_price_np">0</span></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div id="discount_price_box_amt" class="d-none">
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-6 col-6">
                                                                                    <h5 class="fw-bold fs-6">Coupon Discount</h5>
                                                                                </div>
                                                                                <div class="col-sm-6 col-6 text-end">
                                                                                    <h5 class="fw-bold fs-6"><span> - </span>₹ <span id="get_total_discount_price">0</span></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div id="offer_price_box" class="d-none">
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-7 col-7">
                                                                                    <h5 class="fw-bold">Total Net Payable</h5>
                                                                                </div>
                                                                                <div class="col-sm-5 col-5 text-end">
                                                                                    <h5 class="fw-bold">₹ <span id="get_total_offer_price">0</span></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-12 text-color t1 pt-2">
                                                                            <!-- <h5 class="fw-bold fs-6">Convenience Fee @3%</h5> -->
                                                                            <h5 class="fw-bold fs-6">Cancellation Policy before travel date:</h5>
                                                                        </div>
                                                                        <div class="col-7 col-sm-7 text-color t1 pt-2">
                                                                            <!-- <h5 class="fw-bold fs-6">Convenience Fee @3%</h5> -->
                                                                            <!-- <h5 class="fw-bold">Cancellation Policy before travel date:</h5> -->
                                                                            <h5 class=" fs-6">30+ days:</h5>
                                                                            <h5 class=" fs-6">15-30 days:</h5>
                                                                            <h5 class=" fs-6">Less then 15 days:</h5>
                                                                        </div>
                                                                        <div class="col-5 col-sm-5 text-color t2 pt-2">
                                                                            <h5 class="fw-bold fs-6"></h5>
                                                                            <h5 class="fw-bold fs-6">
                                                                                <?php echo $cancel_policy['policy_1'] . "% Refund";
                                                                                ?> </h5>
                                                                            <h5 class="fw-bold fs-6">
                                                                                <?php echo $cancel_policy['policy_2'] . "% Refund";
                                                                                ?> </h5>
                                                                            <h5 class="fw-bold fs-6">
                                                                                <?php echo $cancel_policy['policy_3'] . "% Refund";
                                                                                ?> </h5>
                                                                        </div>
                                                                        <div class="col-12 col-sm-12 text-color t1 pt-2">
                                                                            <h5>Please Note:<p class="fst-italic text-muted"> Cancellation (%) will be applicable to only to the amount paid and not on remaining balance in case of part payment</p>
                                                                            </h5>
                                                                        </div>
                                                                        <!-- <div class="col-7 col-sm-8 text-color t1 pt-2">
                                                                <h5 class="fw-bold fs-6">Convenience Fee @3%
                                                                </h5>
                                                            </div>
                                                            <div class="col-5 col-sm-4 text-color t2 pt-2">
                                                                <h5 class="fw-bold fs-6">₹ <span
                                                                        id="convenience_fee">3</span></h5>
                                                            </div> -->
                                                                        <?php
                                                                        // require 'connect.php';
                                                                        // $dissql = "SELECT * FROM `cu_coupons` WHERE user_id:user_id AND confirm_status=:confirm_status AND usage_status";
                                                                        // $disstmt = $conn->prepare($dissql);
                                                                        // $disstmt->execute([
                                                                        //     ':user_id' => 'tetes',
                                                                        //     ':confirm_status' => 1,
                                                                        //     ':usage_status' => 0
                                                                        // ]);
                                                                        // $disres = $disstmt->fetchAll();

                                                                        ?>


                                                                        <div class="checkbox-outer checkBox-align pt-3">
                                                                            <input type="checkbox" name="product_terms" id="terms_condtion">
                                                                            <label for="terms_condtion" style="cursor: pointer"> I agree to the terms and condition</label><br>
                                                                            <!-- <a id="view_terms" href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"> View Terms and Conditions</a> -->
                                                                        </div>
                                                                        <div class="mt-3 px-0">
                                                                            <!-- <div class=""> -->
                                                                            <!-- <a href="#" class="text-white" id="book_tour"></a> -->
                                                                            <button type="button" class="send-btn w-100 d-flex justify-content-center" id="book_tour" class="text-white">
                                                                                Book Now
                                                                            </button>
                                                                            <!-- </div> -->
                                                                        </div>
                                                                </div>
                                                    </form>
                                                </div>
                                                <?php  } ?>
                                                <div class="form-container date-travel-card position-sticky top-0" id="form2">
                                                    <form>
                                                        <h5 class="fw-bolder my-2">Enquiry / Quotation Form</h5>
                                                        <div class="row">
                                                            <label class="q_label" for="q_name">Name <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="text" class="form-control border-0 fs-6 bg-transparent w-100" name="q_name" id="q_name" placeholder="Full Name" value="">
                                                            </div>
                                                            <label class="q_label" for="q_phn_no">Mobile <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12 ">
                                                                <input type="tel" class="form-control border-0 fs-6 bg-transparent w-100" name="q_phn_no" id="q_phn_no" placeholder="Phone Number" value="">
                                                            </div>
                                                            <label class="q_label" for="q_email">Email <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="email" class="form-control border-0 fs-6 bg-transparent w-100" name="q_email" id="q_email" placeholder="Email" value="">
                                                            </div>
                                                            <label class="q_label" for="q_duration">Trip Duration <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_duration" id="q_duration" placeholder="Trip Duration" value="">
                                                            </div>
                                                            <label class="q_label" for="q_date">Travel Date <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="date" class="form-control border-0 fs-6 bg-transparent w-100" name="q_date" id="q_date" value="">
                                                            </div>

                                                            <div class="form-group col-sm-12 px-0">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-4 col-6">
                                                                        <label class="q_label ps-3" for="q_no_adult">Adults<span class="text-danger">*</span></label>
                                                                        <div class="input-box p-2 mb-1">
                                                                            <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_adult" id="q_no_adult" value="1" placeholder="Adults" min="1">
                                                                        </div>
                                                                        <span class="label_txt ps-3 fontSize"> (12+ Yrs) </span>
                                                                    </div>
                                                                    <div class="form-group col-sm-4 col-6">
                                                                        <label class="q_label ps-3" for="q_no_child">Children </label>
                                                                        <div class="input-box p-2 mb-1">
                                                                            <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_child" id="q_no_child" value="0" placeholder="Children" min="0">
                                                                        </div>
                                                                        <span class="label_txt ps-3 fontSize"> (3-11 Yrs) </span>
                                                                    </div>
                                                                    <div class="form-group col-sm-4 col-6">
                                                                        <label class="q_label ps-3"
                                                                            for="q_no_infants">Infants </label>
                                                                        <div class="input-box p-2 mb-1">
                                                                            <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_infants" id="q_no_infants" min="0" value="0">
                                                                        </div>
                                                                        <span class="label_txt ps-3 fontSize"> (Under 2 Yrs)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label class="q_label" for="q_budget">Approx. Budget (&#8377;) <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12">
                                                                <input type="text" class="form-control border-0 fs-6 bg-transparent w-100" name="q_budget" id="q_budget" placeholder="Approx Budget" value="">
                                                            </div>
                                                            <label class="q_label" for="q_meals">Meals Required <span class="text-danger">*</span></label>
                                                            <div class="input-box col-sm-12 d-flex justify-content-around">
                                                                <div class="form-check form-check-inline fs-6 me-0">
                                                                    <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox1" value="breakfast">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
                                                                </div>
                                                                <div class="form-check form-check-inline fs-6 me-0">
                                                                    <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox2" value="lunch">
                                                                    <label class="form-check-label" for="inlineCheckbox2">Lunch</label>
                                                                </div>
                                                                <div class="form-check form-check-inline fs-6 me-0">
                                                                    <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox3" value="dinner">
                                                                    <label class="form-check-label" for="inlineCheckbox3">Dinner</label>
                                                                </div>
                                                            </div>
                                                            <label class="q_label" for="q_comment">Additional Remarks(If Any)</label>
                                                            <div class="form-floating px-0">
                                                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                                <!-- <label for="floatingTextarea2">Comments</label> -->
                                                            </div>
                                                            <input type="hidden" value="<?= $userId ?>" id="q_user_id">
                                                            <div class="mt-3 px-0">
                                                                <button type="button" class="send-btn w-100 d-flex justify-content-center" id="submit_quotations" class="text-white">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
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
        </section>

        <!-- pop booking members -->
        <!-- <div id="show_ticket_book_box" > -->
        <div class="modal fade" id="show_ticket_book_box" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tour Members:</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-between member-details p-3">
                            <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                <label for="m_name">Adult</label>
                                <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                            </div>

                            <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="m_age_1"></label>
                                <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                            </div>

                            <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="m_gender"></label>
                                <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <!-- adding additional member function -->
                        <div class="input_fields_wrap_members"></div>
                        <button class="add_field_button_member custom_btn btn1 w-25 border-0 py-3 rounded-3 mt-3 ms-2" id="add_field_button_member">
                            <span id="hide_add_member">
                                No Member to Add
                            </span>
                            <span id="show_add_member" style="display:none">
                                <span id="show_add_remove_member">Add/Remove</span> &nbsp; <span id="member_count"></span> &nbsp; Member
                            </span>
                        </button>
                        <!-- adding additional member function -->
                        <!-- error msg -->
                        <!-- <label for="error" id="member_validation" class="error_msg" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label> -->
                        <label for="error" id="members_error" class="error_msg" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px"></label>
                        <label for="error" id="member_validationAdult" class="error_msg text-danger-emphasis bg-danger-subtle border border-danger-subtle fs-6 rounded-2 py-1 ms-1" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label>
                        <label for="error" id="member_validationChild" class="error_msg text-danger-emphasis bg-danger-subtle border border-danger-subtle fs-6 rounded-2 py-1 ms-1" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label>
                        <label for="error" id="member_validationInfant" class="error_msg text-danger-emphasis bg-danger-subtle border border-danger-subtle fs-6 rounded-2 py-1 ms-1" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label>
                        <label for="error" id="member_validationName" class="error_msg text-danger-emphasis bg-danger-subtle border border-danger-subtle fs-6 rounded-2 py-1 ms-1" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label>
                        <label for="error" id="member_validation" class="error_msg text-danger-emphasis bg-danger-subtle border border-danger-subtle fs-6 rounded-2 py-1 ms-1" style="padding: 1px 5px; margin: 10px 0px; font-size: 12px; display: none">Error</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel_order" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.reload()">Close</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#paymentModal" class="btn btn-primary">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- </div>  -->

        <!-- Payment Screen start -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-12">
                                <p class="fw-bold text-muted fs-6">Amount to be Paid: <span class="fw-bolder" id="amountToBePaid" style="color: var(--pure-black);"></span></p>
                                <p class="fw-bold text-muted fs-6">Available TopUp Balance:
                                    <span class="fw-bolder" style="color: var(--pure-black);" id="avalableBalance">
                                        <?php
                                        // Only for TA login
                                        require 'connect.php';
                                        // Check if user exists
                                        $stmt1 = $conn->prepare("SELECT * FROM `login` WHERE status = '1' AND `user_id` = ? AND `user_type_id` = '11'");
                                        $stmt1->execute([$userId]);
                                        // Fetch the latest available balance for the given ta_id
                                        $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
                                        $stmt2->execute(array(':ta_id' => $userId));
                                        $result3 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                        $available_bal = ($result3['available_balance'] ?? 0);
                                        echo $available_bal
                                        ?>
                                    </span>
                                    <i class="ri-refresh-line fs-5" style="color: red;"></i>
                                </p>
                                <span class="bg-danger-subtle text-danger py-1 px-2 mt-2 rounded-2 lowBal d-none" id="low_bal">
                                    Low Balance for full payment
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4 col-12 text-end">
                                <a href="dashboard/view_ta_topup.php" target="_blank">
                                    <button type="button" class="btn text-dark-emphasis bg-dark-subtle border border-dark-subtle fw-bold">
                                        <i class="ri-wallet-2-line" style="color: #615a5a;"></i>
                                        Add TopUp
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div id='payTypeDiv'>
                            <p class="fs-6 fw-bolder py-3" style="color: var(--pure-black);">Pay Type</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                <label class="form-check-label" for="inlineRadio1" style="color: var(--pure-black);">Full</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">Part</label>
                            </div>
                            <div id="toggleDiv">
                                <select class="form-select w-50" id="payTypeSelect" aria-label="Default select example">
                                    <option selected value="--Select the Pay Type">--Select the Pay Type</option>
                                    <option value="2">2 Parts</option>
                                    <option value="3">3 Parts</option>
                                </select>
                            </div>
                            <div class="py-3">
                                <p class="fw-bolder fs-5 d-flex" style="color: var(--pure-black);">Amount:
                                    <span><input class="form-control" type="text" id="amountInput" value="" aria-label="readonly input example" readonly></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="place_order">Pay</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.location.reload()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payment Screen end -->

        <!-- pop booking tickets -->

        <!--/ End-of Destination -->
    </main>

    <!-- Footer S t a r t -->
    <?php include_once "footer.php" ?>
    <!--/ End-of Footer -->

    <!-- Scroll Up  -->
    <div class="progressParent" id="back-top">
        <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Add an search-overlay element -->
    <div class="search-overlay"></div>
    <!-- jquery-->
    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap-5.3.0.min.js"></script>
    <!-- Plugin -->
    <script src="assets/js/plugin.js"></script>
    <!-- Main js-->
    <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="logout/logout.js"></script>

    <script>
        // $(window).on('load', function() {
        //     $('#show_ticket_book_box').modal('show');
        // });
        function checkCustomerCoupons(cust_id) {
            if (cust_id) {
                $.ajax({
                    type: "POST",
                    url: "assets/submit/check_customer_coupons.php",
                    data: {
                        cust_id: cust_id
                    },
                    dataType: "json",
                    success: function(response) {
                        const couponSelect = $('#coupon_select');
                        couponSelect.empty().append('<option value="">Select a coupon</option>');

                        if (response.coupons && response.coupons.length > 0) {
                            couponSelect.empty().append('<option value="" disabled>Select a coupon</option>');

                            response.coupons.forEach(coupon => {
                                couponSelect.append(
                                    `<option value="${coupon.code}" data-discount="${coupon.coupon_amt}">
                                        ${coupon.code} (₹${coupon.coupon_amt} off)
                                    </option>`
                                );
                            });

                            const customerType = $('#specCust').text().toLowerCase();
                            const isPremium = customerType.includes('premium');
                            const total_adults_val = $("#b_no_adult").val()||1;
                            const total_child_val = $("#b_no_child").val()||0;
                            const totalMembers = total_adults_val + total_child_val;

                            //const totalMembers = parseInt($('#total_members').val() || 1); // Add this input in your form if not present

                            // Allow multiple coupon selection if Premium and more than 1 member
                            // if (isPremium && totalMembers > 1) {
                            //     couponSelect.attr('multiple', true);
                            // } else {
                            //     couponSelect.removeAttr('multiple');
                            // }
                            console.log('test');
                            
                            $('#discount_price_box').removeClass('d-none');
                            $('#offer_price_box').removeClass('d-none');
                            $('#primeCustomer').show();
                            $('#primeCustomer_span').removeClass('d-none');
                            $('#nonprimeCustomer').addClass('d-none');
                        } else {
                            $('#discount_price_box, #discount_price_box_amt, #offer_price_box').addClass('d-none');
                            $('#primeCustomer').hide();
                            $('#primeCustomer_span').addClass('d-none');
                            $('#nonprimeCustomer').removeClass('d-none');
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        }

        // Add this function to handle coupon selection
        // function applySelectedCoupon() {
        //     const selectedOption = $('#coupon_select option:selected');
        //     if (selectedOption.val()) {
        //         const discountAmount = selectedOption.data('discount');
        //         $('#get_total_discount_price').text(discountAmount);

        //         // Calculate and update the offer price
        //         const totalPrice = parseFloat($('#get_total_package_price_actual').text());
        //         const offerPrice = totalPrice - discountAmount;
        //         $('#get_total_package_price_actual').text(offerPrice.toFixed(2));

        //         // Store the selected coupon code for later use
        //         $('#coupon_code').val(selectedOption.val());
        //         $('#get_coupon_price').val(discountAmount);
        //     } else {
        //         // No coupon selected
        //         $('#get_total_discount_price').text('0');
        //         const totalPrice = parseFloat($('#get_total_package_price_actual').text());
        //         $('#get_total_package_price_actual').text(totalPrice.toFixed(2));
        //         $('#coupon_code').val('');
        //         $('#get_coupon_price').val('0');
        //     }
        // }
        function applySelectedCoupon() {
            const selectedOptions = $('#coupon_select option:selected');

            if (selectedOptions.length > 1) {
                alert("Only one coupon can be applied.");
                $('#coupon_select').val('').trigger('change');
                return;
            }

            let totalDiscount = 0;
            let selectedCoupons = [];

            selectedOptions.each(function () {
                const discount = parseFloat($(this).data('discount')) || 0;
                totalDiscount += discount;
                selectedCoupons.push($(this).val());
            });

            // Apply coupon discount
            $('#get_total_discount_price').text(totalDiscount.toFixed(2));

            const totalPrice = parseFloat($('#get_total_package_price').text()) || 0;
            const offerPrice = totalPrice - totalDiscount;

            $('#get_total_package_price_actual').text(offerPrice.toFixed(2));
            $('#coupon_code').val(selectedCoupons.join(','));
            $('#get_coupon_price').val(totalDiscount.toFixed(2));
        }




        // date function
        $(function() {
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate() + 2;
            // console.log(day);

            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var minDate = year + '-' + month + '-' + day;

            var maxToday = new Date(<?php echo json_encode($validity); ?>);
            var month = maxToday.getMonth() + 1;
            var day = maxToday.getDate();
            var year = maxToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);
            // alert(maxDate);
            $('#b_date').attr('min', minDate);
            $('#b_date').attr('max', maxDate);
            $('#b_date').attr('value', '');
        });
        // date function

        // let allowedAdults = parseInt($("#b_no_adult").val()) || 0;
        // let allowedChildren = parseInt($("#b_no_child").val()) || 0;
        // let allowedInfants = parseInt($("#b_no_infants").val()) || 0;
        // set package price

        // Initialize variables after DOM is loaded
        var adult_price, child_price, net_total, markup_total, coupon_offer = 0,
            total_offer_price = 0;
        let total_adults = 0,
            total_children = 0,
            total_infants = 0;
        let count_members = 0,
            no_adult, no_child;
        let cust_type, user_cust_id, user_type;
        let ta_markup_price;

        // DOM elements
        var adult_count = document.getElementById('b_no_adult');
        var child_count = document.getElementById('b_no_child');
        var infant_count = document.getElementById('b_no_infants');
        var package_price = document.getElementById('get_total_package_price');
        var package_price_np = document.getElementById('get_total_package_price_np');
        var single_package_price = document.getElementById('get_single_adult_package_price');
        var single_package_price_np = document.getElementById('get_single_adult_package_price_np');
        var coupon_error = document.getElementById('coupon_error');
        var invalid_coupon_error = document.getElementById('invalid_coupon_error');
        var used_coupon_error = document.getElementById('used_coupon_error');
        var added_adult_price = 0;
        var prime_pack_price;

        $(document).ready(function() {
            //initialization
            $('#nonprimeCustomer').removeClass('d-none');
            // Parse price data
            const price_data = <?php echo json_encode($amount); ?>;
            added_adult_price = parseFloat(price_data['price_up_per_adult']);
            adult_price = parseFloat(price_data['total_package_price_per_adult']);
            child_price = parseFloat(price_data['total_package_price_per_child']);
            ta_markup_price = parseFloat(<?php echo $ta_markup_price; ?>);
            $('input[name="cust_type"]').on('change', function() {
                const selectedValue = $(this).val();
                handleCustomerType(selectedValue);
            });

            // Call once on load if you want to run the function based on default selection
            handleCustomerType($('input[name="cust_type"]:checked').val());

            function handleCustomerType(value) {
                if (value === "1") {
                    $('#discount_price_box').addClass('d-none');
                    $('#discount_price_box_amt').addClass('d-none');
                    $('#offer_price_box').addClass('d-none');
                    $('#primeCustomer').hide();
                    $('#primeCustomer_span').addClass('d-none');
                    $('#nonprimeCustomer').removeClass('d-none');
                    $('#b_no_adult').val(1);
                    $('#b_no_child').val(0);
                    $('#b_no_infants').val(0);
                    var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                    if (package_price_np) package_price_np.innerText = total1;
                    if (single_package_price_np) single_package_price_np.innerText = total1;

                    // Your code for registered
                } else if (value === "2") {
                    $('#discount_price_box').addClass('d-none');
                    $('#discount_price_box_amt').addClass('d-none');
                    $('#offer_price_box').addClass('d-none');
                    $('#primeCustomer').hide();
                    $('#primeCustomer_span').addClass('d-none');
                    $('#nonprimeCustomer').removeClass('d-none');
                    $('#b_no_adult').val(1);
                    $('#b_no_child').val(0);
                    $('#b_no_infants').val(0);
                    var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                    if (package_price_np) package_price_np.innerText = total1;
                    if (single_package_price_np) single_package_price_np.innerText = total1;
                }
            }

            // Set initial values
            if (adult_count) adult_count.value = 1;

            var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
            if (package_price) package_price.innerText = total1;
            if (single_package_price) single_package_price.innerText = total1;

            //incase of prime customer
            var total = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
            if (package_price_np) package_price_np.innerText = total;
            if (single_package_price_np) single_package_price_np.innerText = total;
            prime_pack_price = parseFloat(adult_price + ta_markup_price).toFixed(2);
            $('#get_total_package_price_actual').text(prime_pack_price);
            var initialTotal = prime_pack_price;
            $('#get_total_offer_price').text(initialTotal);

            console.log('Initial price:', total);
            console.log('Initial offer price:', initialTotal);
            console.log('adult added price:', added_adult_price);

            // Update total on count change
            $('#b_no_adult, #b_no_child, #b_no_infants').on('change', function() {
                getTotalPrice();
            });

            // Customer setup
            cust_type = $("input[name='cust_type']:checked").val();
            user_cust_id = <?php echo json_encode($user_cust_id, JSON_HEX_TAG); ?>;
            getCustomersID(user_cust_id, cust_type);

            $("input[name='cust_type']").on('click', function() {
                cust_type = $(this).val();
                getCustomersID(user_cust_id, cust_type);
                $("#cust_id, #b_name, #b_email, #b_phn_no, #dob, #coupon_code").val('');
            });

            // Travel Agent data setup
            user_type = <?php echo $user_type; ?>;
            if (user_type === 11) {
                $.ajax({
                    type: "POST",
                    url: 'assets/submit/get_customer_details',
                    data: {
                        cust_id: user_cust_id,
                        user_type: 11
                    },
                    success: function(res) {
                        if (res !== "fail") {
                            const travelAgentData = JSON.parse(res);
                            $("#payee_name").val(travelAgentData.firstname + ' ' + travelAgentData.lastname);
                            $("#payee_email").val(travelAgentData.email);
                            $("#payee_contact").val(travelAgentData.contact_no);
                        }
                    },
                    error: function(err) {
                        console.error("AJAX error:", err);
                    }
                });
            }
        });



        // get reference customer for thet perticular travel agent
        function getCustomersID(user_cust_id, cust_type) {
            $.ajax({
                type: "POST",
                url: 'assets/submit/customers_id',
                data: 'user_cust_id=' + user_cust_id + '&status=' + cust_type,
                success: function(e) {
                    $("#customer_suggestion").html(e);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        // get Customer ID - when Travel agent selects Customer Id from dropdown get details of selected Customer and place them in book tour table.
        var cust_id = 0;
        var showButton = document.getElementById("book_tour");
        $("#cust_id").keyup(function() {
            var customerData;
            cust_id = $("#cust_id").val();

            if (cust_id) {
                $.ajax({
                    type: "POST",
                    url: 'assets/submit/get_customer_details',
                    data: 'cust_id=' + cust_id + '&user_type=10',
                    success: function(res) {
                        if (res == "fail") {
                            console.log("No Customer Data Found");
                        } else {
                            customerData = JSON.parse(res);
                            // console.log(customerData);
                            $("#b_name").val(customerData.firstname + ' ' + customerData.lastname);
                            $("#b_email").val(customerData.email);
                            $("#b_phn_no").val(customerData.contact_no);
                            $("#dob").val(customerData.age);
                            $("#coupon_code").val('');
                            let customerTypeRaw = customerData.customer_type.trim().toLowerCase(); // e.g., "premium"
                            let formattedCustomerType = customerTypeRaw.charAt(0).toUpperCase() + customerTypeRaw.slice(1); // "Premium"

                            $("#specCust").text(formattedCustomerType + ' Customer');
                            
                            // Check for customer coupons
                            checkCustomerCoupons(cust_id);
                            // check for customer details
                            // if ( customerData.date_of_birth == "0000-00-00" || customerData.kyc == "" || customerData.pan_card == "" || customerData.aadhar_card == "" || customerData.voting_card == "" || customerData.bank_passbook == "" ) {
                            //     alert("Incomplete Customer Information !");
                            //     showButton.classList.add('disable_clickablea_area');
                            // } else {
                            //     showButton.classList.remove('disable_clickablea_area');
                            // }
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            } else {
                $("#cust_id").val('');
                $("#b_name").val('');
                $("#b_email").val('');
                $("#b_phn_no").val('');
                $("#dob").val('');

                $("#coupon_code").val('');
            }
        });

        $('#b_no_adult').on('change', function() {
            var adults = adult_count.value;
            adults = parseInt(adults, 10);

            total_adults = (adult_price) * adults;
            getTotalPrice();
            //getCouponStatus();
            // console.log(adults+ '---'+ total_adults);
        });

        $('#b_no_child').on('change', function() {
            var children = child_count.value;
            children = parseInt(children, 10);

            total_children = child_price * children;
            getTotalPrice();
            //getCouponStatus();
            // console.log(children+ '---'+ total_children);
        });

        // function getCouponStatus() {
        //     var adults = adult_count.value;
        //     adults = parseInt(adults, 10);
        //     var child = child_count.value
        //     if (child) {
        //         child = parseInt(child, 10);
        //     } else {
        //         child = 0;
        //     }
        //     count_members = adults + child

        //     if (count_members < 2) {
        //         if (checkbox_status_coupon.checked) {
        //             checkbox_status_coupon.checked = false;
        //             document.getElementById('coupon_code_box').style.display = "none";
        //             // hide offer price
        //             discount_price_box.style.display = "none";
        //             offer_price_box.style.display = "none";
        //             // nullable offer value 
        //             get_total_discount_price.innerText = 0;
        //             total_offer_price = 0;

        //             coupon_error.style.display = "block";
        //         }
        //     } else {
        //         coupon_error.style.display = "none";
        //         if (coupon_applied_status == 'true') {
        //             // get coupon applied
        //             getCouponPrice();
        //         }
        //     }
        // }

        function getTotalPrice() {
            var adults = adult_count.value;
            var total_added_adult_price = added_adult_price * adults;
            var total = total_adults + total_children + ta_markup_price;
            var total1 = total_adults + total_added_adult_price + total_children + ta_markup_price;
            package_price.innerText = parseFloat(total).toFixed(2);
            package_price_np.innerText = parseFloat(total1).toFixed(2);
            $('#get_total_offer_price').text(parseFloat(total).toFixed(2));
            console.log('total:' + total + '--- tptal1:' + total1);
        }

        var coupon_applied_status = 'false';
        var discount_price_box = document.getElementById('discount_price_box');
        var offer_price_box = document.getElementById('offer_price_box');
        var get_total_discount_price = document.getElementById('get_total_discount_price');
        var get_total_offer_price = document.getElementById('get_total_offer_price');
        // 

        // get coupon code apply
        // $('#apply_coupon_btn').on('click', function(e) {
        //     e.preventDefault();

        //     var coupon_code = $("#coupon_code").val();
        //     $.ajax({
        //         type: 'POST',
        //         url: 'assets/submit/coupons',
        //         data: 'coupon_code=' + coupon_code,
        //         success: function(e) {
        //             // console.log(e);
        //             if (e == "invalid") {
        //                 // console.log('Please Enter valid code');
        //                 invalid_coupon_error.style.display = "block";
        //                 used_coupon_error.style.display = "none";

        //                 hideOfferValue();

        //             } else if (e == "used") {
        //                 // console.log('This code is already been used');
        //                 used_coupon_error.style.display = "block";
        //                 invalid_coupon_error.style.display = "none";

        //                 hideOfferValue();
        //             } else {
        //                 // console.log('valid code');
        //                 $('#get_coupon_price').val(e);
        //                 getCouponPrice();
        //                 // show offer price
        //                 discount_price_box.style.display = "block";
        //                 offer_price_box.style.display = "block";
        //                 // hide errors
        //                 invalid_coupon_error.style.display = "none";
        //                 used_coupon_error.style.display = "none";

        //                 coupon_applied_status = 'true';
        //             }
        //         },
        //         error: function(err) {
        //             console.log(err);
        //         },
        //     });
        // });

        // function getCouponPrice() {
        //     var adults = adult_count.value;
        //     adults = parseInt(adults, 10);
        //     var total_adults = adult_price * adults;

        //     var children = child_count.value;
        //     var total_children = 0;
        //     children = parseInt(children, 10);
        //     if (children >= 1) {
        //         total_children = child_price * children;
        //     }

        //     total = total_adults + total_children + ta_markup_price; // markup price removed from final package and added to per person

        //     coupon_offer = $('#get_coupon_price').val();
        //     coupon_offer = parseInt(coupon_offer, 10);

        //     total_offer_price = total - coupon_offer;
        //     // offer price
        //     get_total_discount_price.innerText = coupon_offer;
        //     get_total_offer_price.innerText = total_offer_price;

        //     // SM542174
        //     // console.log('total = '+total+'coupon_offer = '+coupon_offer+ '--- total_offer_price = '+total_offer_price );
        // }

        // hide offer section
        // function hideOfferValue() {
        //     // hide offer price
        //     discount_price_box.style.display = "none";
        //     offer_price_box.style.display = "none";
        //     // nullable offer value 
        //     get_total_discount_price.innerText = 0;
        //     total_offer_price = 0;
        // }


        // check Box
        const gst_check = $("#get_gst");
        const coupons_check = $("#get_coupon");
        var gst_status = 'false';
        var coupon_status = 'false';
        var checkbox_status_coupon;

        gst_check.change(function(event) {
            var checkbox_status = event.target;
            if (checkbox_status.checked) {
                gst_status = 'true';
                document.getElementById('gst_number').style.display = "block";
                // console.log('gst_status'+gst_status);
            } else {
                gst_status = 'false';
                document.getElementById('gst_number').style.display = "none";
                // console.log('gst_status'+gst_status);
            }
        });
        // coupons_check.change(function(event) {
        //     checkbox_status_coupon = event.target;
        //     if (checkbox_status_coupon.checked) {
        //         var adults = adult_count.value
        //         adults = parseInt(adults, 10);
        //         var child = child_count.value
        //         if (child) {
        //             child = parseInt(child, 10);
        //         } else {
        //             child = 0;
        //         }
        //         count_members = adults + child
        //         // console.log('count_members = ' + count_members);

        //         if (count_members > 1) {
        //             coupon_status = 'true';
        //             document.getElementById('coupon_code_box').style.display = "flex";
        //             // console.log('coupon_status'+coupon_status);
        //         } else {
        //             checkbox_status_coupon.checked = false;
        //             document.getElementById('coupon_error').style.display = "block";
        //             console.log('Coupon cannot be applied on Single Member, Minimum 2 members required !!');
        //         }
        //     } else {
        //         coupon_status = 'false';
        //         document.getElementById('coupon_code_box').style.display = "none";
        //         // console.log('coupon_status'+coupon_status);

        //         hideOfferValue();
        //         // console.log( ' set Couopn Code to null !');
        //         coupon_code = '';
        //         $("#coupon_code").val('');
        //     }
        // });
        // document.addEventListener('DOMContentLoaded', function() {
        //     const bookNowBtn = document.getElementById('book_tour');
        //     const modal = document.getElementById('myModal');
        //     const addMemberButton = document.getElementById('addMemberButton');

        //     // Show the modal when "Book Now" is clicked
        //     bookNowBtn.addEventListener('click', function() {
        //         modal.style.display = 'block'; // Show the modal
        //         attachEventListeners(); // Attach event listeners after modal is shown
        //     });

        //     // Function to attach event listeners dynamically
        //     function attachEventListeners() {
        //         const mAgeInputs = modal.querySelectorAll('input[name="m_age[]"]');

        //         // Add event listener to each age input in the modal
        //         mAgeInputs.forEach(function(input) {
        //             input.addEventListener('input', function(e) {
        //                 validateAge(e.target);
        //             });
        //         });

        //         // Example for adding member button functionality
        //         addMemberButton.addEventListener('click', function() {
        //             console.log("Add Member button clicked");
        //             // Add functionality to add members
        //         });
        //     }

        //     // Age validation logic
        //     function validateAge(input) {
        //         let age = parseInt(input.value, 10);
        //         if (isNaN(age) || age < 0) {
        //             // Show error for invalid age
        //             input.classList.add('invalid_input');
        //         } else {
        //             // Hide error if age is valid
        //             input.classList.remove('invalid_input');
        //         }
        //     }
        // });

        // Add members
        var max_fields = 10,
            memberCount = 0;
        var wrapper = $(".input_fields_wrap_members"); // Fields wrapper
        var add_button = $(".add_field_button_member"); // Add button ID
        var x = 1; // Initial text box count

        $(document).ready(function() {
            $(add_button).click(function(e) { // On add input button click
                e.preventDefault();
                memberCount += 1;
                if (x < max_fields) {
                    if (x < no_adult) { // Check for adults
                        x++; // Increment the counter
                        $(wrapper).append(`
                            <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                    <label for="m_name">Adult</label>
                                    <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_age_1"></label>
                                    <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_gender"></label>
                                    <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                            </div>`);
                        //members_error.style.display = "none";
                    } else if (x < no_adult + no_child) { // Check for children
                        x++; // Increment the counter
                        $(wrapper).append(`
                            <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                    <label for="m_name">Child</label>
                                    <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_age_1"></label>
                                    <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_gender"></label>
                                    <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                            </div>`);
                        //members_error.style.display = "none";
                    } else if (x < no_adult + no_child + total_infants) { // Check for infants
                        x++; // Increment the counter
                        $(wrapper).append(`
                            <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                    <label for="m_name">Infant</label>
                                    <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_age_1"></label>
                                    <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                </div>
                                <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <label for="m_gender"></label>
                                    <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                            </div>`);
                        //members_error.style.display = "none";
                    }
                }
                // Reduce add member count onClick
                reduceMemberCount();
            });

            // User clicks on remove text
            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;

                // Reduce add member count onClick
                reduceMemberCount();
            });
        });

        // Function to reduce the member count
        function reduceMemberCount() {
            show_count = max_fields - x;
            member_count.innerText = Math.abs(show_count);

            if (show_count == 0) {
                show_add_button.style.display = "none";
            } else if (show_count < 0) {
                show_add_button.style.display = "block";
                show_add_remove_member.innerText = "Remove";
                show_add_button.style.backgroundColor = "#96a701";
            } else {
                show_add_button.style.display = "block";
                show_add_remove_member.innerText = "Add";
                show_add_button.style.backgroundColor = "#21a827";
            }
        }
        var show_count;
        var show_add_button = document.getElementById("add_field_button_member");
        var show_add_remove_member = document.getElementById("show_add_remove_member");


        $("#cancel_order").click(function(e) {
            e.preventDefault();
            hideTourMemberForm();
        });

        function hideTourMemberForm() {
            $(".page_body").removeClass("parent_disable");
            $(".page_footer").removeClass("parent_footer_disable");
            document.getElementById("show_ticket_book_box").style.display = "none";
        }


        // Booking tickets
        $('#book_tour').click(function(e) {
            e.preventDefault();
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            // alert("Sorry, Booking are not opend yet !.");
            // return null;
            //----comment
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------
            //--------------------------------------------------------------------------------------------

            if (user_type == '11' || user_type == '10') {
                var name = $("#b_name").val();
                var email = $("#b_email").val();
                var phone = $("#b_phn_no").val();
                var date = $("#b_date").val();
                var no_adult = $("#b_no_adult").val();
                var gst_number = $("#gst_number").val();
                var coupon_code = $("#coupon_code").val();

                if (name == "" || name == " " || email == "" || phone == "" || date == "" || no_adult == "" || gst_status == "true" || coupon_status == "true" || package_terms_status == 'false') {
                    if (name == "" || name == " ") {
                        alert("Please Enter Name !");
                    } else if (email == "") {
                        alert("Please Enter Email !");
                    } else if (phone == "") {
                        alert("Please Enter Phone Number !");
                    } else if (date == "") {
                        alert("Please Select Tour Date !");
                    } else if (no_adult == "") {
                        alert("Please Enter Number of Adults !");
                    } else if (package_terms_status == 'false') {
                        alert("Please, Read and accept terms and condition!!");
                    } else if (gst_status == "true" && gst_number == "") {
                        alert("PLease Enter Valid GST Number, or Uncheck the Check-Box");
                    } else if (coupon_status == "true" && coupon_code == "") {
                        alert("PLease Enter Valid Coupon Code, or Uncheck the Check-Box");
                    } else {
                        if (emailValidation(email)) {
                            getMemberCount();
                            reduceMemberCount();
                        } else {
                            alert('Please, enter valid Email Id !!');
                        }
                    }
                } else {
                    if (emailValidation(email)) {
                        getMemberCount();
                        reduceMemberCount();
                    } else {
                        alert('Please, enter valid Email Id !!');
                    }
                }
            } else {
                alert("Sorry, you are not allowed to Book Tour !! Only Travel Consultant can Book Tour.");
            }
        });

        //accept terms for booking package
        const terms_check = $("#terms_condtion");
        var package_terms_status = 'false';

        terms_check.change(function(event) {
            var terms = event.target;
            if (terms.checked) {
                package_terms_status = 'true';
            } else {
                package_terms_status = 'false';
            }
        });

        const member_count = document.getElementById("member_count");

        function getMemberCount() {
            $(".page_body").addClass("parent_disable");
            $(".page_footer").addClass("parent_footer_disable");

            var dob = $("#dob").val();
             // miliseconds from epoch
            //var dob_years;
            if (dob == '') {
                dob_years = '';
                adult_age_count = 0;
            } else {
                adult_age_count = 1;
               //dob_years = Math.abs(age_date.getUTCFullYear() - 1970);
            }
            // document.getElementById("show_ticket_book_box").style.display = "block";
            $('#show_ticket_book_box').modal('show');
            document.getElementById("m_name_1").value = $("#b_name").val();
            document.getElementById("m_age_1").value = dob;

            no_adult = $("#b_no_adult").val();
            no_child = $("#b_no_child").val();
            // get member count
            no_adult = parseInt(no_adult, 10);
            if (no_child) {
                no_child = parseInt(no_child, 10);
            } else {
                no_child = 0;
            }
            total_infants = infant_count.value
            if (total_infants) {
                total_infants = parseInt(total_infants, 10);
            } else {
                total_infants = 0;
            }
            max_fields = no_adult + no_child + total_infants
            member_count.innerText = max_fields - 1;
            if (max_fields > 1) {
                document.getElementById("show_add_member").style.display = "block";
                document.getElementById("hide_add_member").style.display = "none";
            } else {
                document.getElementById("show_add_member").style.display = "none";
                document.getElementById("hide_add_member").style.display = "block";
            }
        }

        var members = [];
        var names = document.getElementsByName('m_name[]');
        var ages = document.getElementsByName('m_age[]');
        var genders = document.getElementsByName('m_gender[]');
        var members_error = document.getElementById('members_error');

        var member_validationAdult = document.getElementById('member_validationAdult');
        var member_validationChild = document.getElementById('member_validationChild');
        var member_validationInfant = document.getElementById('member_validationInfant');
        var member_validationName = document.getElementById('member_validationName');
        var member_validation = document.getElementById('member_validation');

        var adult_age_min = 12,
            child_age_max = 11,
            child_age_min = 3,
            infant_age_max = 2;
        var adult_age_count = 0,
            child_age_count = 0,
            infant_age_count = 0;

        function validateTourMemberName(e) {
            if (regexExp.test(e.value)) {
                e.classList.add('invalid_input');
                member_validationName.style.display = "block";
                member_validationName.innerText = "Please Enter valid Name !!";
            } else {
                e.classList.remove('invalid_input');
                member_validationName.style.display = "none";
            }
        }


        // Replace the validateAge function with this version
        function validateAge(input) {
            let age = parseInt(input.value, 10);
            let parentDiv = input.closest('.row');
            let labelElement = parentDiv.querySelector('label[for="m_name"]');
            let memberType = labelElement.innerText.trim(); // Get the fixed label (Adult/Child/Infant)

            // Check if the input is a valid number
            if (isNaN(age) || age < 0) {
                showError(document.getElementById('member_validation'), "Please enter a valid age.");
                return false;
            }

            // Validate age based on the fixed label
            if (memberType === "Adult" && age < 12) {
                showError(document.getElementById('member_validationAdult'), "Adult must be 12 years or older");
                return false;
            } else if (memberType === "Child" && (age < 3 || age > 11)) {
                showError(document.getElementById('member_validationChild'), "Child must be between 3-11 years");
                return false;
            } else if (memberType === "Infant" && age > 2) {
                showError(document.getElementById('member_validationInfant'), "Infant must be 2 years or younger");
                return false;
            }

            // If validation passed, hide any error messages
            hideError(document.getElementById('member_validation'));
            hideError(document.getElementById('member_validationAdult'));
            hideError(document.getElementById('member_validationChild'));
            hideError(document.getElementById('member_validationInfant'));

            // Validate counts against the allowed numbers
            validateMemberCounts();
            return true;
        }

        // Keep the validateMemberCounts function but modify it to check fixed labels
        function validateMemberCounts() {
            let adultCount = 0;
            let childCount = 0;
            let infantCount = 0;

            // Get all member rows and count based on fixed labels
            $(".row.d-flex.justify-content-between").each(function() {
                let label = $(this).find('label[for="m_name"]').text().trim();
                let ageInput = $(this).find('input[name="m_age[]"]');
                let age = parseInt(ageInput.val(), 10);

                if (!isNaN(age)) {
                    if (label === "Adult") adultCount++;
                    else if (label === "Child") childCount++;
                    else if (label === "Infant") infantCount++;
                }
            });

            // Get allowed counts from the form
            let allowedAdults = parseInt($("#b_no_adult").val()) || 0;
            let allowedChildren = parseInt($("#b_no_child").val()) || 0;
            let allowedInfants = parseInt($("#b_no_infants").val()) || 0;

            // Validate counts
            if (adultCount > allowedAdults) {
                showError(document.getElementById('member_validationAdult'), "Too many adults! Maximum allowed: " + allowedAdults);
            } else {
                hideError(document.getElementById('member_validationAdult'));
            }

            if (childCount > allowedChildren) {
                showError(document.getElementById('member_validationChild'), "Too many children! Maximum allowed: " + allowedChildren);
            } else {
                hideError(document.getElementById('member_validationChild'));
            }

            if (infantCount > allowedInfants) {
                showError(document.getElementById('member_validationInfant'), "Too many infants! Maximum allowed: " + allowedInfants);
            } else {
                hideError(document.getElementById('member_validationInfant'));
            }
        }

        // Function to show error messages
        function showError(element, message) {
            element.style.display = 'block';
            element.innerText = message;
        }

        // Function to hide error messages
        function hideError(element) {
            element.style.display = 'none';
        }

        // Function to count members by age range (used for adults, children, infants)
        function countMembersByAge(minAge, maxAge) {
            let ageInputs = document.querySelectorAll("input[name='m_age[]']");
            let count = 0;

            // Loop through the age inputs and count those that match the age range
            ageInputs.forEach(input => {
                let age = parseInt(input.value, 10);
                if (!isNaN(age) && age >= minAge && (maxAge ? age <= maxAge : true)) {
                    count++;
                }
            });

            return count;
        }
        $('#cancel_order').click(function(e) {
            e.preventDefault();
            setTimeout(() => {
                location.reload();
            }, 2000);
        });

        const fullRadio = document.getElementById('inlineRadio1');
        const partRadio = document.getElementById('inlineRadio2');
        const payTypeSelect = document.getElementById('payTypeSelect');
        const amountInput = document.getElementById('amountInput');
        const divToToggle = document.getElementById('toggleDiv');

        $('#paymentModal').on('show.bs.modal', function() {
            // Part Payment Modal Start
            // Fetch the total amount dynamically from the "Amount to be Paid" section
            const amountToBePaidElement = document.getElementById('amountToBePaid');
            var np_total=$('#get_total_package_price_np').text().trim();
            var p_total=$('#get_total_package_price_actual').text().trim();
            var final_pack_amount = $('#offer_price_box').is(':visible')
            ? $('#get_total_offer_price').text().trim()
            : $('#nonprimeCustomer').is(':visible')
                ? np_total
                : p_total
            var bal_amt;
            let totalAmount
            $('#amountToBePaid').text(final_pack_amount);
            setTimeout(function() {

                var bal_amt = $.trim($('#avalableBalance').text());

                var amountToBePaidVal = $('#amountToBePaid').text();
                totalAmount = parseFloat(amountToBePaidElement.textContent.replace('₹', '').trim()); // Get amount without '₹' symbol
                bal_amt = parseFloat(bal_amt);
                amountToBePaidVal = parseFloat(amountToBePaidVal);
                // Ensure the values are numbers (NaN check)
                if (isNaN(bal_amt) || isNaN(amountToBePaidVal)) {
                    console.log('Error: One of the values is not a valid number');
                    return; // Exit if either is NaN
                }

                console.log('Available Balance:', typeof bal_amt);
                console.log('amountToBePaidVal:', typeof amountToBePaidVal);
                console.log('Available Balance:', bal_amt);
                console.log('amountToBePaidVal:', amountToBePaidVal);

                if (bal_amt < amountToBePaidVal) {
                    console.log('bal:' + bal_amt);
                    console.log('amt:' + amountToBePaidVal);
                    $('#low_bal').removeClass('d-none');
                    partRadio.checked = true;
                    fullRadio.checked = false;
                    fullRadio.disabled = true; // Disable full payment option
                    divToToggle.style.display = 'block'; // Show part payment dropdown
                    updateAmount();
                    var part1 = totalAmount * 0.4;
                    var partAmount = totalAmount / 2;
                    console.log('part1:' + part1 + ' partAmount:' + partAmount);

                    if (bal_amt < part1 && bal_amt < partAmount) {
                        $('#low_bal').text('Low balance! Please TopUp');
                        $('#payTypeDiv').addClass('d-none');
                        $('#place_order').addClass('d-none');
                    } else {
                        $('#payTypeDiv').removeClass('d-none');
                        $('#place_order').removeClass('d-none');
                    }

                } else {
                    updateAmount();
                    $('#low_bal').addClass('d-none');
                    // $('#payTypeDiv').removeClass('d-none');
                    // $('#place_order').removeClass('d-none');
                }
            }, 500);
            console.log('Final price:', final_pack_amount);
            console.log('avl bal:', bal_amt);
            // const totalAmount = document.getElementById('amountPaying');  // Amount to be Paid

            // Initially, hide the "Part" selection
            divToToggle.style.display = 'none';
            amountInput.value = totalAmount;

            //if(bal_amt<)



            // Event listener for the 'Part' radio button
            partRadio.addEventListener('change', function() {
                if (this.checked) {
                    divToToggle.style.display = 'block'; // Show the select dropdown

                    updateAmount(); // Update amount based on selection
                }
            });

            // Event listener for the 'Full' radio button
            fullRadio.addEventListener('change', function() {
                if (this.checked) {
                    divToToggle.style.display = 'none'; // Hide the select dropdown
                    amountInput.value = totalAmount; // Set the amount back to full amount
                }
            });

            // Event listener for the Pay Type dropdown (2 parts or 3 parts)
            payTypeSelect.addEventListener('change', function() {
                updateAmount(); // Update amount when Pay Type is selected
            });

            // Function to update amount in the input field based on the Pay Type selection
            function updateAmount() {
                const selectedValue = payTypeSelect.value;

                if (selectedValue === '2') {
                    // 2 parts: 50% each
                    const partAmount = totalAmount / 2;
                    amountInput.value = `${partAmount}`; // (First part)
                } else if (selectedValue === '3') {
                    // 3 parts: 40%, 30%, 30%
                    const part1 = totalAmount * 0.4;
                    const part2 = totalAmount * 0.3;
                    const part3 = totalAmount * 0.3;
                    amountInput.value = `${part1}`; //(First part - 40%)
                } else {
                    amountInput.value = totalAmount; // Default full amount
                }
            }
            // Part Payment Modal end
        });

        $('#place_order').click(async function(e) {
            e.preventDefault();
            console.log("in place order");
            //product_package_payout();
            //valiadtions

            var status = false;
            names = $("input[name='m_name[]']").map(function() {
                return $(this).val().trim();
            }).get();

            ages = $("input[name='m_age[]']").map(function() {
                return $(this).val().trim();
            }).get();
            genders = $("select[name='m_gender[]']").map(function() {
                return $(this).val();
            }).get();
            for (let i = 0; i < names.length; i++) {
                if (names[i] === "" && ages[i] === "") {
                    alert("Both Name and Age Cannot be Empty!");
                    status = false;
                    break; // Stop checking further since we found an error
                } else if (names[i] === "") {
                    alert("Name Cannot be Empty!");
                    status = false;
                    break;
                } else if (ages[i] === "") {
                    alert("Age Cannot be Empty!");
                    status = false;
                    break;
                } else {
                    status = true;
                }
            }

            //console.log("status:"+status);

            // get data
            if (status == true) {

                if (names.length == max_fields) {
                    //members_error.style.display = "none";
                    members = [];
                    //
                    try {
                        // Wait for getTourData to complete first
                        const tourData = await getTourData();
                        console.log('Tour Data:', tourData);

                        // // Now, proceed to call product_package_payout
                        // const payoutResult = await product_package_payout();
                        // console.log('Payout Result:', payoutResult);

                        console.log("Both AJAX calls have completed successfully.");
                        $("#b_name").val('');
                        $("#b_email").val('');
                        $("#b_phn_no").val('');
                        $("#b_date").val('');
                        $("#b_no_adult").val('');
                        $("#b_no_child").val('');
                        $("#b_no_infants").val('');

                        names.forEach(function(data, i) {
                            data.value = "";
                        });
                        ages.forEach(function(data, i) {
                            data.value = "";
                        });
                        genders.forEach(function(data, i) {
                            data.value = "male";
                        });
                        location.reload();
                    } catch (error) {
                        console.error("An error occurred:", error);
                    }

                    // console.log('place order');
                } else if (names.length > max_fields) {
                    members_error.style.display = "block";
                    members_error.innerText = "Please remove extra members !!";
                    // console.log( names.length +' more than total = '+max_fields);
                } else {
                    members_error.style.display = "block";
                    members_error.innerText = "Please add remaining members !!";
                    // console.log( names.length +' Remaing / of '+max_fields);
                }
            }
        });

        function product_package_payout() {
            return new Promise((resolve, reject) => {
                var packageID = $('#package_id').val();
                var userID = $('#user_id').val();
                var cuID = $('#cust_id').val();
                var no_of_adult = $('#b_no_adult').val();
                var no_of_child = $('#b_no_child').val();
                var ta_markup = ta_markup_price ?? 0;
                var book_id = $('#book_id').val();
                var tour_start_date = $('#b_date').val();
                // console.log(packageID + ' ' + userID + ' ' + cuID +' '+ no_of_adult + ' ' + ta_markup+ ' '+book_id+' '+tour_start_date);
                dataString = {
                    packageID: packageID,
                    userID: userID,
                    cuID: cuID,
                    no_of_adult: no_of_adult,
                    no_of_child: no_of_child,
                    ta_markup: ta_markup,
                    book_id: book_id,
                    tour_start_date: tour_start_date,
                };
                let data = JSON.stringify(dataString);
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "assets/submit/product_package_payout.php",
                    data: data,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                    },
                    success: function(res) {
                        // console.log(res);
                        if (res == '1') {
                            alert("SUCCESS");
                            console.log(res);
                            // setTimeout(() => {
                            //     location.reload();
                            // }, 2000);
                            resolve(res); // Resolve the promise on success
                        } else {
                            alert("UNSUCCESS");
                            console.log(res);
                            // setTimeout(() => {
                            //     location.reload();
                            // }, 2000);
                            resolve(res); // Resolve with unsuccessful result
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        reject(err); // Reject the promise on error
                    }
                });
            });
        }

        function getTourData() {
            return new Promise((resolve, reject) => {
                var cust_id = $("#cust_id").val();
                var package_id = $("#package_id").val();
                var name = $("#b_name").val();
                var email = $("#b_email").val();
                var phone = $("#b_phn_no").val();
                var date = $("#b_date").val();
                // will generate current time stamp payment id 
                var payment_id = makepayid(25)
                var paid_amount = $('#amountInput').val()
                var selectedValue = $("input[name='inlineRadioOptions']:checked").val();
                var paytype
                //coupon details
                var selectedOption = $('#coupon_select option:selected');
                var couponDiscount = selectedOption.data('discount') || 0;
                var couponCode = $('#coupon_select').val();
                //payouts part
                var packageID = $('#package_id').val();
                var userID = $('#user_id').val();
                var cuID = $('#cust_id').val();
                var no_of_adult = $('#b_no_adult').val();
                var no_of_child = $('#b_no_child').val();
                var ta_markup = ta_markup_price ?? 0;
                //var book_id = $('#book_id').val();
                var tour_start_date = $('#b_date').val();
                var discounted_price = $('#get_total_offer_price').text();

                if (selectedValue == 'option1') {
                    pay_type = 1 //full payment
                } //if part payment is seleted
                else if (selectedValue == 'option2') {
                    pay_type = $("#payTypeSelect").val(); // 2 for 2 parts and 3 for 2 parts
                }
                if (partRadio.checked && (payTypeSelect.value === "" || payTypeSelect.value === "--Select the Pay Type")) {
                    alert("Please select a valid payment type.");
                    event.preventDefault(); // Prevent form submission
                    return false;
                } else {
                    // get payers details for travel agent
                    if (user_type == 11) {
                        payee_id = user_cust_id;
                        payee_name = $("#payee_name").val();
                        payee_email = $("#payee_email").val();
                        payee_contact = $("#payee_contact").val();
                    }
                    var formdata = {
                        user_cust_id: user_cust_id,
                        cust_id: cust_id,
                        package_id: package_id,
                        name: name,
                        email: email,
                        phone: phone,
                        date: date,
                        adults: no_adult,
                        child: no_child,
                        infants: total_infants,
                        total_price: package_price.innerText,
                        ta_markup: ta_markup_price,
                        members: [],
                        payee_name: payee_name,
                        payee_id: payee_id,
                        payment_id: payment_id,
                        paid_amount: paid_amount,
                        pay_type: pay_type,
                        couponCode: couponCode,
                        couponDiscount: couponDiscount,
                        packageID: packageID,
                        userID: userID,
                        cuID: cuID,
                        no_of_adult: no_of_adult,
                        no_of_child: no_of_child,
                        ta_markup: ta_markup,
                        tour_start_date: tour_start_date,
                        discounted_price: discounted_price,
                    };
                    names.forEach(function(name, i) {
                        formdata.members.push({
                            'name': name,
                            'age': ages[i],
                            'gender': genders[i]
                        });
                    });
                    console.log("formdata");
                    console.log(formdata);
                    //resolve(formdata)
                    // Book Package
                    let data = JSON.stringify(formdata);
                    $.ajax({
                        type: "POST",
                        url: "assets/submit/book-tickets",
                        data: data,
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                        },
                        success: function(res) {

                            //$('#book_id').val(res.bookid);
                            if (res == 1) {
                                console.log("success payment");
                                hideTourMemberForm();
                                // empty fields
                                // $("#b_name").val('');
                                // $("#b_email").val('');
                                // $("#b_phn_no").val('');
                                // $("#b_date").val('');
                                // $("#b_no_adult").val('');
                                // $("#b_no_child").val('');
                                // $("#b_no_infants").val('');

                                // names.forEach(function(data, i) {
                                //     data.value = "";
                                // });
                                // ages.forEach(function(data, i) {
                                //     data.value = "";
                                // });
                                // genders.forEach(function(data, i) {
                                //     data.value = "male";
                                // });

                                alert('Booking is successful')
                                resolve(res); // Resolve the promise on success
                                // location.reload();
                                //make new snackbar
                                // showBottomSnackBar("Success !! Order placed for Booking ");
                                // setTimeout(function() {
                                //     location.reload();
                                // }, 4000);
                            } else {
                                alert("failed to book");
                                resolve(res); // Resolve with unsuccessful result
                            }
                        },
                        error: function(err) {
                            console.log(err);
                            reject(err); // Reject the promise on error
                        }
                    });
                }
                //console.log('paytype:' + paytype);
            });
        }

        // generate order id

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }

        function makepayid(length) {
            var result = 'Paid_';
            const timestamp = Date.now();
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            result += timestamp;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }


        var currentdate = new Date();
        var year = currentdate.getFullYear() + "" + "_" + currentdate.getHours();
        var order_id = 'order_' + year + "" + makeid(10); // generate order id


        // comments
        $('#put_comment').click(function(e) {
            e.preventDefault();

            var package_id = $("#package_id").val();
            var name = $("#c_name").val();
            var email = $("#c_email").val();
            var website = $("#c_website").val();
            var message = $("#c_message").val();

            if (name == "" || email == "" || message == "") {
                if (name == "") {
                    alert("Please Enter Name !");
                } else if (email == "") {
                    alert("Please Enter Email !");
                } else if (message == "") {
                    alert("Comment cannot be empty !");
                }
            } else {
                // console.log('comments');

                var formdata = {
                    package_id: package_id,
                    name: name,
                    email: email,
                    website: website,
                    message: message
                };

                let data = JSON.stringify(formdata);
                // console.log(data);
                $.ajax({
                    type: "POST",
                    url: "assets/submit/comments",
                    data: data,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                    },
                    success: function(res) {
                        if (res.toString() == "success") {
                            // console.log("success");
                            // empty fields
                            $("#c_name").val('')
                            $("#c_email").val('')
                            $("#c_website").val('')
                            $("#c_message").val('')

                            location.reload();
                        } else {
                            console.log("failed to comment");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });

        // show reply comment box
        var comm_id;

        function replyCommentFunction(e, comment_id) {
            e.preventDefault();

            // console.log(comment_id);
            comm_id = comment_id;
            document.getElementById("show_reply_box").style.display = "block";
        }

        $('#cancel_comment').click(function(e) {
            e.preventDefault();
            document.getElementById("show_reply_box").style.display = "none";
        });
        // reply comments
        $('#reply_comment').click(function(e) {
            e.preventDefault();

            var name = $("#r_name").val();
            var email = $("#r_email").val();
            var message = $("#r_message").val();

            if (name == "" || email == "" || message == "") {
                if (name == "") {
                    alert("Please Enter Name !");
                } else if (email == "") {
                    alert("Please Enter Email !");
                } else if (message == "") {
                    alert("Comment Reply cannot be empty !");
                }
            } else {
                // console.log('Reply comments');

                var formdata = {
                    comment_id: comm_id,
                    name: name,
                    email: email,
                    message: message
                };

                let data = JSON.stringify(formdata);
                // console.log(data);
                $.ajax({
                    type: "POST",
                    url: "assets/submit/comments_reply",
                    data: data,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                    },
                    success: function(res) {
                        if (res.toString() == "success") {
                            // console.log("success");
                            // empty fields
                            $("#r_name").val('');
                            $("#r_email").val('');
                            $("#r_message").val('');
                            document.getElementById("show_reply_box").style.display = "none";

                            location.reload();
                        } else {
                            console.log("failed to comment");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        });

        // success message snack bar
        function showBottomSnackBar(textString) {
            var x = document.getElementById("bottom-snackbar");
            x.style.display = "block";
            x.innerText = textString;

            setTimeout(function() {
                x.style.display = "none";
            }, 4000);
        }

        function emailValidation(email) {
            filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (filter.test(email)) {
                return true;
            } else {
                return false;
            }
        }

        var regexExp = /[^a-zA-Z ]/; // letters, space
        var regexExpNum = /[^0-9]/; // nu,ber
    </script>
    <!-- Book tour form -->
    <script>
        // Get buttons and form containers
        const button1 = document.getElementById('button1');
        const button2 = document.getElementById('button2');
        const form1 = document.getElementById('form1');
        const form2 = document.getElementById('form2');

        // Ensure form1 is always visible initially
        form1.style.display = 'block';
        form2.style.display = 'none';

        // Toggle forms when the buttons are clicked
        button1.addEventListener('click', () => toggleForm('form1', 'form2'));
        button2.addEventListener('click', () => toggleForm('form2', 'form1'));

        function toggleForm(formToShow, formToHide) {
            // Show the selected form and hide the other one
            const form1Visible = formToShow === 'form1' && form1.style.display === 'block';
            const form2Visible = formToShow === 'form2' && form2.style.display === 'block';

            if (!form1Visible && !form2Visible) {
                document.getElementById(formToShow).style.display = 'block';
                document.getElementById(formToHide).style.display = 'none';
            }
        }
        //quotation submit action with validation
        $('#submit_quotations').click(function() {
            var enName = $('#q_name').val().trim();
            var enPhone = $('#q_phn_no').val().trim();
            var enEmail = $('#q_email').val().trim();
            var enDuration = $('#q_duration').val().trim();
            var enTDate = $('#q_date').val().trim();
            var enNadults = $('#q_no_adult').val().trim();
            var enNChild = $('#q_no_child').val().trim();
            var enNInfants = $('#q_no_infants').val().trim();
            var enBudget = $('#q_budget').val().trim();
            var enDestination = $('#pack_name').text();
            var enUserId = $('#q_user_id').val();
            let selectedMeals = [];
            document.querySelectorAll(".meal-checkbox:checked").forEach((checkbox) => {
                selectedMeals.push(checkbox.value);
            });
            var enRemarks = $('#floatingTextarea2').val().trim();

            //validation
            const phoneRegex = /^[0-9]{10}$/;
            const alphabetRegex = /^[A-Za-z]+(?:\s[A-Za-z]+)*$/;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (enName == '') {
                alert('Please enter your name');
            } else if (!alphabetRegex.test(enName)) {
                alert('Please enter alphabets only (minimum 3 characters long)');
            } else if (enPhone == '') {
                alert('Please enter your phone number');
            } else if (!phoneRegex.test(enPhone)) {
                alert("Invalid phone number");
            } else if (enEmail == '') {
                alert("Please enter your email");
            } else if (!emailRegex.test(enEmail)) {
                alert("Invalid email");
            } else if (enDuration == '') {
                alert("Please enter duratuion days");
            } else if (enDuration == 0) {
                alert("Duratuion days cannot be 0");
            } else if (enTDate == '') {
                alert("Please select Travel date");
            } else if (enNadults == 0) {
                alert("Number of adults cannot be 0");
            } else if (enBudget == '') {
                alert("Please enter your budget");
            } else if (enBudget == 0) {
                alert("Budget cannot be 0");
            } else if (enDuration == '') {
                alert("Please enter your travel duration days");
            } else if (enDuration == 0) {
                alert("Travel duration days cannot be 0");
            } else if (selectedMeals.length === 0) {
                alert("Select at least one required meal");
            } else {
                var formdata = {
                    enName: enName,
                    enPhone: enPhone,
                    enEmail: enEmail,
                    enDuration: enDuration,
                    enTDate: enTDate,
                    enNadults: enNadults,
                    enNChild: enNChild,
                    enNInfants: enNInfants,
                    enBudget: enBudget,
                    meals: selectedMeals,
                    enDestination: enDestination,
                    enUserId: enUserId,
                    enRemarks:enRemarks
                }

                console.log('formdata:');
                console.log(formdata);
                $.ajax({
                    url: "assets/submit/create_quotations.php",
                    type: "POST",
                    data: formdata,
                    success: function(res) {
                        if (res == 1) {
                            alert("Quotation will be sent to your email!");
                        } else {
                            alert("Server Error: " + res);
                        }
                    }
                });
            }

        });
    </script>
</body>

</html>