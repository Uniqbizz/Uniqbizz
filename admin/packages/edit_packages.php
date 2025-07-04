<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

$id = $_GET['vkvbvjfgfikix'];
require '../connect.php';
// package
$stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
$stmt->execute();
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$club_id = $package['club_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];

// itinery 
$data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
$data2->execute();
$itinery = $data2->fetch();

// package_pricing 
$data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
$data3->execute();
$amount = $data3->fetch();

//commented on 25-Jan-2025 by sv
// // markup pricing 
// $data5 = $conn->prepare("SELECT * FROM markup_distribution WHERE package_id = $id");
// $data5->execute();
// $markup_dist_price = $data5->fetch();

//new markup distribution price
$data5 = $conn->prepare("SELECT * FROM `package_pricing_markup` WHERE package_id = $id");
$data5->execute();
$markup_dist_price = $data5->fetch();
if (!$markup_dist_price) {
    $markup_dist_price = array(
        'company' => 0,
        'ta_markup' => 0,
        'customer' => 0,
        'ca_direct_commission' => 0,
        'ca_incentive' => 0,
        'bm_direct_commission' => 0,
        'bm_incentive' => 0,
        'bdm_direct_commission' => 0,
        'bdm_incentive' => 0,
        'ca_mark_up_total' => 0,
        'bm_mark_up_total' => 0,
        'bdm_mark_up_total' => 0,
        'bcm_mark_up_total' => 0,
        'bcm_incentive' => 0,
        'bcm_direct_commission' => 0,
        'prime_customer' =>0,
        'L1_customer' => 0,
        'L2_customer' => 0
    );
}

//new cancelation policy on 25-Jan-2025 by sv
$data6 = $conn->prepare("SELECT * FROM `cancel_policy` WHERE package_id = $id");
$data6->execute();
$cancel_policy = $data6->fetch();

// package_to_category_occupancy 
$pkg_to_cat_occupancy;
$data10 = $conn->prepare("SELECT occupancy_id FROM package_to_category_occupancy WHERE package_id = $id");
$data10->execute();
$data10->setFetchMode(PDO::FETCH_ASSOC);
if ($data10->rowCount() > 0) {
    $pkg_to_cat_occupancy = $data10->fetchAll();
} else {
    $pkg_to_cat_occupancy = "null";
}

//  package_to_category_vehicle
$pkg_to_cat_vehicle;
$data9 = $conn->prepare("SELECT vehicle_id FROM package_to_category_vehicle WHERE package_id = $id");
$data9->execute();
$data9->setFetchMode(PDO::FETCH_ASSOC);
if ($data9->rowCount() > 0) {
    $pkg_to_cat_vehicle = $data9->fetchAll();
} else {
    $pkg_to_cat_vehicle = "null";
}

// package_trip_days 
$dayData;
$data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
$data4->execute();
$data4->setFetchMode(PDO::FETCH_ASSOC);
if ($data4->rowCount() > 0) {
    $dayData = $data4->fetchAll();
} else {
    $dayData = "null";
}

//product payout commission
// $data7 = $conn->prepare("SELECT * FROM `product_commission` WHERE status = 1");
// $data7->execute();
// $data7->setFetchMode(PDO::FETCH_ASSOC);
// $product_payout_data = $data7->fetchAll();
// $ta_value = (float)$markup_dist_price['ta_markup'];
// $prime_ovr_per = 0;

// foreach ($product_payout_data as $entry) {
//     if ($entry['role'] === 'Prime') {
//         $prime_ovr_per = (float)$entry['overall_percentage'];
//         break;
//     }
//     if ($entry['role'] === 'L1') {
//         $l1_ovr_per = (float)$entry['overall_percentage'];
//         break;
//     }
//     if ($entry['role'] === 'L2') {
//         $l2_ovr_per = (float)$entry['overall_percentage'];
//         break;
//     }
// }

// $prime_value = $ta_value * $prime_ovr_per;
// $l1_value = $ta_value * $prime_ovr_per;
// $l2_value = $ta_value * $prime_ovr_per;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Packages</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />

    <!-- <link href="forms/product_packages.css" rel="stylesheet" type="text/css" />  -->

    <style>
        .page-back {
            padding: 1rem;
        }

        /* required class for text fields */
        .required:after {
            content: " *";
            color: red;
        }

        /* .custom_btn {
                border: none;
                color: white;
                padding: 10px 19px;
                text-align: center;
                text-decoration: none;
                display: inline-flex;
                font-size: 13px;
                cursor: pointer;
                width: 100px !important;
                border-radius: 5px;
            }
            .btn1 {
                background-color: #21a827; Green
            }
            .btn2 {
                background-color: #cd0101; red
                margin-left: 26px !important;
            }
            input::file-selector-button {
                background-color: #556ee6;
                background-size: 150%;
                border: 0;
                border-radius: 8px;
                color: #fff;
                padding: 1rem 1.25rem;
                text-shadow: 0 1px 1px #333;
                transition: all 0.25s;
                color: white;
                content: "Upload";
            }
            input::file-selector-button:hover {
                background-color: #556ee6;
            }
            button{
                border-radius: 8px !important;
                padding: 15px 10px !important;
            } */
        .gallery img {
            width: 30%;
            display: inline-flex;
        }

        /* For Edit Page */
        /* preview images */
        .preview-existing-images-zone {
            position: relative;
            overflow: auto;
        }

        .preview-existing-images-zone>.preview-existing-image:child {
            height: 125px;
            width: 125px;
            position: relative;
            margin-right: 1px;
        }

        .preview-existing-images-zone>.preview-existing-image {
            height: 125px;
            width: 125px;
            position: relative;
            margin-right: 5px;
            float: left;
            margin-bottom: 0px;
        }

        .preview-existing-images-zone>.preview-existing-image>.image-zone {
            width: 100%;
            height: 100%;
        }

        .preview-existing-images-zone>.preview-existing-image>.image-zone>img {
            width: 100%;
            height: 100%;
        }

        .preview-existing-images-zone>.preview-existing-image>.image-delete {
            font-size: 18px;
            position: absolute;
            top: 0;
            right: 0;
            font-weight: bold;
            margin-right: 10px;
            cursor: pointer;
            display: none;
            z-index: 100;
        }

        .preview-existing-image:hover>.tools-edit-image,
        .preview-existing-image:hover>.image-delete {
            display: block;
        }
    </style>
</head>

<body data-sidebar="dark" id="page_body">
    <div id="testpho"></div>
    <div id="testemails"></div>

    <div class="layout-wrapper">
        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../header.php';

        // sidebar navigation menu 
        include_once '../sidebar.php';
        ?>

        <!-- get product data -->
        <input type="hidden" id="package_id" value="<?php echo $id ?>">
        <input type="hidden" id="selected_cat_id" value="<?php echo $cat_id ?>">
        <input type="hidden" id="selected_club_id" value="<?php echo $club_id ?>">
        <input type="hidden" id="selected_package_type" value="<?php echo $package['package_type'] ?>">
        <input type="hidden" id="selected_sub_cat_id" value="<?php echo $sub_cat_id ?>">
        <input type="hidden" id="selected_hotel_cat_id" value="<?php echo $hotel_cat_id ?>">
        <input type="hidden" id="selected_meal_cat_id" value="<?php echo $meal_cat_id ?>">
        <!-- get product data -->


        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-between">
                        <div class="breadcrumb">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="all_packages.php">Package</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Package</li> -->
                        </div>
                        <div>
                            <!-- return previous page link -->
                            <li class="page-back" id="return_to_views_btn" style="display:block"><a href="all_packages.php"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                            <li class="page-back" id="return_to_general_btn" style="display:none"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                            <li class="page-back" id="return_to_extraInfo_btn" style="display:none"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                            <li class="page-back" id="return_to_itinerary_btn" style="display:none"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                            <li class="page-back" id="return_to_pricing_btn" style="display:none"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                            <!-- return previous page link -->
                        </div>
                    </nav>
                    <div class="row">
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="p-4" style="border-bottom: 1px solid #DDDDDD;">
                                    <!-- p1 -->
                                    <h4 id="package_form_general_title">Edit <?php echo $package['name'] ?> - General Information</h4>
                                    <!-- p2 -->
                                    <h4 id="package_form_extra_title" style="display:none">Edit <?php echo $package['name'] ?> - Package Extra Information</h4>
                                    <!-- p3 -->
                                    <h4 id="package_form_itinerary_title" style="display:none">Edit <?php echo $package['name'] ?> - Itinerary Details</h4>
                                    <!-- p4 -->
                                    <h4 id="package_form_pricing_title" style="display:none">Edit <?php echo $package['name'] ?> - Pricing</h4>
                                    <!-- p5 -->
                                    <h4 id="package_form_picture_title" style="display:none">Edit <?php echo $package['name'] ?> - Picture</h4>
                                </div>
                                <div class="col-lg-12">
                                    <form id="package_form" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                        <!-- First Box General details-->
                                        <div id="package_form_general">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-floating mt-3 mb-3">
                                                        <span class="required"></span>
                                                        <select class="form-select" id="category_id" name="category_id" aria-label="Floating label select example">
                                                            <?php
                                                            $cat_data = $conn->prepare("SELECT * FROM category where status='1' ");
                                                            $cat_data->execute();
                                                            // set the resulting array to associative
                                                            $cat_data->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($cat_data->rowCount() > 0) {
                                                                foreach (($cat_data->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value=""> No Category Avaiable </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label>Select Category Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-floating mt-3 mb-3">
                                                        <span class="required"></span>
                                                        <select id="sub_category_id" name="sub_category_id" class="form-select" style="display: none"></select>

                                                        <select id="sub_category_data" name="sub_category_data" class="form-select">
                                                            <?php
                                                            $sub_cat_data = $conn->prepare("SELECT * FROM subcategory where category_id='" . $cat_id . "' ");
                                                            $sub_cat_data->execute();
                                                            // set the resulting array to associative
                                                            $sub_cat_data->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($sub_cat_data->rowCount() > 0) {
                                                                foreach (($sub_cat_data->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['sub_category_name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value=""> No Category Avaiable </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label>Select Sub-Category Type</label>
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-sm-12" id="club_class_display" style="display: none">
                                                    <div class="form-floating mb-3">
                                                        <span class="required"></span>
                                                        <select id="club_id" name="club_id" class="form-select">
                                                            <?php
                                                            $club_data = $conn->prepare("SELECT * FROM club");
                                                            $club_data->execute();
                                                            // set the resulting array to associative
                                                            $club_data->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($club_data->rowCount() > 0) {
                                                                echo '<option value="0">--Select Club--</option>';
                                                                foreach (($club_data->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value=""> No Clubs Avaiable </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label>Select Club</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 ps-4 pt-3 pb-3">
                                                    <label>Package applicable for</label><br />
                                                    <div class="select">
                                                        <span id="stag_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="stag" id="stag_id"><label style="padding-right:15px; padding-left: 5px;" for="stag_id">Stag</label></span>
                                                        <span id="couple_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="couple" id="couple_id"><label style="padding-right:15px; padding-left: 5px;" for="couple_id">Couple</label></span>
                                                        <span id="family_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="family" id="family_id"><label style="padding-right:15px; padding-left: 5px;" for="family_id">Family</label></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $package['name'] ?>" placeholder="Package Name">
                                                        <label for="name" class="required">Package Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="unique_code" name="unique_code" value="<?php echo $package['unique_code'] ?>" placeholder="Unique Code">
                                                        <label for="unique_code" class="required">Unique Code</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="tour_days" name="tour_days" value="<?php echo $package['tour_days'] ?>" placeholder="Tour Days">
                                                        <label for="tour_days" class="required">Tour Days</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" class="form-control" id="pac_validity" name="pac_validity" placeholder="Package Validity" value="<?php echo $package['validity'] ?>">
                                                        <label for="unique_code" class="required">Validity Upto</label>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input id="description" class="form-control" type="text" name="description" value="<?php echo $package['description'] ?>" placeholder="Description">
                                                        <label for="description" class="required" for="description">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_general_nextBtn">
                                                    <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second Box Extra Details -->
                                        <div id="package_form_extra" style="display: none">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mt-3 mb-3">
                                                        <input type="text" id="destination" name="destination" value="<?php echo $package['destination'] ?>" placeholder="Destination" class="form-control">
                                                        <label for="destination" class="required">Destination</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="location" name="location" value="<?php echo $package['location'] ?>" placeholder="Location" class="form-control">
                                                        <label for="location" class="required">Location</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="travel_from" name="travel_from" value="<?php echo $package['travel_from'] ?>" placeholder="Transfer From" class="form-control">
                                                        <label for="travel_from" class="required">From</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="travel_to" name="travel_to" value="<?php echo $package['travel_to'] ?>" placeholder="Transfer To" class="form-control">
                                                        <label for="travel_to" class="required">To</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="sightseeing_type" name="sightseeing_type" value="<?php echo $package['sightseeing_type'] ?>" placeholder="Sightseeing Type" class="form-control">
                                                        <label for="sightseeing_type" class="required">Sightseeing Type</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <select id="category_hotel_id" name="category_hotel_id" class="selectdesign form-select">
                                                            <?php
                                                            $cat_data_hotel = $conn->prepare("SELECT * FROM category_hotel");
                                                            $cat_data_hotel->execute();
                                                            // set the resulting array to associative
                                                            $cat_data_hotel->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($cat_data_hotel->rowCount() > 0) {
                                                                echo '<option value="0">--Select Hotel Ratings--</option>';
                                                                foreach (($cat_data_hotel->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="0"> No Hotels Available </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="required">Hotel Category</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3 form">
                                                        <select id="occupancy_id" name="occupancy_id" class="form-select">
                                                            <?php
                                                            $cat_data_occupancy = $conn->prepare("SELECT * FROM category_occupancy");
                                                            $cat_data_occupancy->execute();
                                                            // set the resulting array to associative
                                                            $cat_data_occupancy->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($cat_data_occupancy->rowCount() > 0) {
                                                                echo '<option value="0">--Select Occupancy Type--</option>';
                                                                foreach (($cat_data_occupancy->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="0"> No Occupancy Available </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="required">Occupancy Category</label>
                                                        <div id="occupancy_data"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <select id="category_meal_id" name="category_meal_id" class="form-select">
                                                            <?php
                                                            $cat_data_meal = $conn->prepare("SELECT * FROM category_meal");
                                                            $cat_data_meal->execute();
                                                            // set the resulting array to associative
                                                            $cat_data_meal->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($cat_data_meal->rowCount() > 0) {
                                                                echo '<option value="0">--Select Meal Type--</option>';
                                                                foreach (($cat_data_meal->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="0"> No Meal Available </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="required">Meal Category</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <select id="vehicle_id" name="vehicle_id" class="form-select">
                                                            <?php
                                                            $cat_data_vehicle = $conn->prepare("SELECT * FROM category_vehicle");
                                                            $cat_data_vehicle->execute();
                                                            // set the resulting array to associative
                                                            $cat_data_vehicle->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($cat_data_vehicle->rowCount() > 0) {
                                                                echo '<option value="0">--Select Vehicle Type--</option>';
                                                                foreach (($cat_data_vehicle->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="0"> No Vehicle Available </option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="required">Vehicle Category</label>
                                                        <div id="vehicle_data"></div>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="package_keywords" name="package_keywords" value="<?php echo $package['package_keywords'] ?>" placeholder="Package Keywords" class="form-control">
                                                        <label for="package_keywords" class="required">Package Keywords</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_extra_nextBtn">
                                                    <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Third Box itinery Details -->
                                        <div id="package_form_itinerary" style="display: none">
                                            <div class="row">
                                                <label for="w3review">This section will contain the information about the package that this product is offering.</label>
                                                <label for="" style="color: #ff4b4b; font-weight: 600; display:block">NOTE : Number Of Days may look different on deletion of previous "DAY", but Days will be listed from first to last in increasing order .</label>
                                                <!-- <div class="row">
                                                    <div class="input-field col-sm-12" style="margin-top: 20px;">
                                                        <div id="add_day" class="custom_btn btn1">Add Day</div>
                                                        <div id="remove_day" class="custom_btn btn2">Remove Day</div>
                                                    </div>
                                                </div>
                                                <div id="wrapper"></div> -->

                                                <!-- add days -->
                                                <div class="col-md-2 col-sm-2 col-12 d-flex justify-content-center align-items-center">
                                                    <button class="add_field_button custom_btn btn1 mt-2 ms-3 mb-3 addButton btn btn-success px-3">
                                                        Add Days
                                                    </button>
                                                </div>
                                                <div class="input_fields_wrap"></div> <!-- Show Added Days -->
                                                <!-- add days -->
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <label for="inclusion" class="required">Inclusion</label>
                                                    <textarea id="inclusion" name="inclusion" class="textarea ms-2" rows="2" cols="50"><?php echo $itinery['inclusion'] ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <label for="exclusion" class="required">Exclusion</label>
                                                    <textarea id="exclusion" name="exclusion" class="myTextEditor ms-2" rows="2" cols="50"><?php echo $itinery['exclusion'] ?></textarea>
                                                </div>

                                                <div class="row">
                                                    <label for="remark">Remark</label>
                                                    <textarea id="remark" name="remark" class="myTextEditor ms-2" rows="2" cols="50"><?php echo $itinery['remark'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_itinerary_nxtBtn">
                                                    <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fourth Box Pricing -->
                                        <div id="package_form_pricing" style="display: none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" onkeyup="getNetPrice()" id="netPriceAdult" name="net_price_adult" value="<?php echo (float)$amount['net_price_adult'] ?>" placeholder="NET Price for 1 Adult:" class="form-control">
                                                            <label for="netPriceAdult" class="required">NET Price for 1 Adult:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3" id="netPriceChildData">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" onkeyup="getNetPrice()" id="netPriceChild" name="net_price_child" value="<?php echo (float)$amount['net_price_child'] ?>" placeholder="NET Price for 1 Child" class="form-control">
                                                            <label for="netPriceChild" class="required">NET Price for 1 Child:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" onkeyup="getNetPrice()" id="nGst" name="net_gst" value="<?php echo (float)$amount['net_gst'] ?>" placeholder="Net GST Title" class="form-control">
                                                            <label id="net_gst_title" for="nGst">Net GST Title :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" onchange="getFinalPrice()" id="totalNetPriceAdult" name="net_price_adult_with_GST" value="<?php echo (float)$amount['net_price_adult_with_GST'] ?>" placeholder="Net Total for Adult" class="form-control" readonly>
                                                            <label id="totalNetPriceAdult" for="nGst">Net Total for Adult :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3" id="totalNetPriceChildData">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" onchange="getFinalPrice()" id="totalNetPriceChild" name="net_price_child_with_GST" value="<?php echo (float)$amount['net_price_child_with_GST'] ?>" placeholder="Net Total for Child" class="form-control" readonly>
                                                            <label id="totalNetPriceChild" for="nGst">Net Total for Child :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 " style="padding:20px 0px 0px 0px"><!-- added on 23 Jan SV-->
                                                        <div class="col-md-6 col-sm-6 mt-3">

                                                            <div class="form-floating mb-3">
                                                                <input type="number" value="<?php echo (float)$amount['total_package_price_per_adult'] ?>" id="mrp_per_adult" placeholder="Total Price Per Adult" class="form-control" readOnly>
                                                                <label for="mrp_per_adult">Total Price Per Adult</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="add_adult_price" name="add_adult_price" value="<?php echo (float)$amount['price_up_per_adult'] ?>" class="form-control">
                                                                <label for="add_adult_price">Additional Adult Price</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" value="<?php echo (float)$amount['total_package_price_per_child'] ?>" id="mrp_per_child" placeholder="Total Price Per Child" class="form-control" readOnly>
                                                                <label for="mrp_per_child">Total Price Per Child</label>
                                                            </div>
                                                        </div>
                                                    </div><!-- added on 25 Jan SV-->
                                                </div>

                                                <!-- updatde markuplogic in 23 Jan 2025 by SV -->
                                                <div class="col-md-12 ms-2 ps-1" style="padding:20px 0px 0px 0px">
                                                    <div class="row">
                                                        <h4 class="p-3 fw-bolder">Mark-Up Price Distribution</h4>

                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-3 mt-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_company" name="company_share" value="<?php echo (float)$markup_dist_price['company'] ?>" placeholder="Company Share" class="form-control" onchange="finalfill()">
                                                                    <label for="mp_company" class="required">Company </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 mt-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_ca_ta" name="ca_ta_share" value="<?php echo (float)$markup_dist_price['ta_markup'] ?>" placeholder="Travel Agency share" class="form-control" onchange='getMarkUpDistribution(<?= json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' />
                                                                    <label for="mp_franchise">Travel Consultant</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 mt-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_customer" name="customer_share" value="<?php echo (float)$markup_dist_price['customer'] ?>" placeholder="Customer Share" class="form-control" onchange="finalfill()" readonly>
                                                                    <label for="mp_customer" class="required">Customer</label>
                                                                    <input type="hidden" id="l1_cust_comm" value="<?=$markup_dist_price['L1_customer']?>"/>
                                                                    <input type="hidden" id="l2_cust_comm" value="<?=$markup_dist_price['L2_customer']?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 mt-3">
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="prime_cust_comm" name="prime_cust_comm" value="<?=$markup_dist_price['prime_customer']?>" placeholder="L1 Customer" class="form-control" onchange="finalfill()">
                                                                    <label for="prime_cust_comm" class="required">L1 Customer</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-2 mt-3" id="ca_div">
                                                                <label id="ca_label" for="ca_div">Techno Enterprise <?php echo '(Total:' . (float)$markup_dist_price['ca_mark_up_total'] . ')' ?></label>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_ca_comm" name="ca_share_comm" value="<?php echo (float)$markup_dist_price['ca_direct_commission'] ?>" placeholder="Commision" class="form-control" readOnly>
                                                                    <label for="mp_ca_comm">Commision </label>
                                                                </div>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_ca_ins" name="ca_share_ins" value="<?php echo (float)$markup_dist_price['ca_incentive'] ?>" placeholder="Incentive" class="form-control" readOnly>
                                                                    <label for="mp_ca_ins">Incentive </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-2 mt-3" id="bm_div">
                                                                <label id="bm_label" for="bm_div">Business Consultant/Mentor <?php echo '(Total:' . (float)$markup_dist_price['bm_mark_up_total'] . ')' ?></label>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_bm_comm" name="bm_share_comm" value="<?php echo (float)$markup_dist_price['bm_direct_commission'] ?>" placeholder="Commision" class="form-control" readOnly>
                                                                    <label for="mp_bm_comm">Commision </label>
                                                                </div>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_bm_ins" name="bm_share_ins" value="<?php echo (float)$markup_dist_price['bm_incentive'] ?>" placeholder="Incentive" class="form-control" readOnly>
                                                                    <label for="mp_bcm_ins">Incentive </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-2 mt-3" id="mpa_div">
                                                                <label >Adult Price After Markup</label>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_adult" name="mp_adult" value="<?php echo (float)$markup_dist_price['total_adult_price_with_markup'] ?>" placeholder="Adult Price" class="form-control" readOnly>
                                                                    <label for="mp_adult">Adult Price </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-2 mt-3" id="mpc_div">
                                                                <label >Child Price After Markup</label>
                                                                <div class="form-floating mb-3">
                                                                    <input type="number" id="mp_child" name="mp_child" value="<?php echo (float)$markup_dist_price['total_child_price_with_markup'] ?>" placeholder="Child Price" class="form-control" readOnly>
                                                                    <label for="mp_child">Child Price </label>
                                                                </div>
                                                            </div>
                                                            <!--<div class="col-md-6 col-sm-2 mt-3" id="bdm_div">-->
                                                            <!--    <label for="bdm_div">Business Development Manager<?php //echo '(Total:' . (float)$markup_dist_price['bdm_mark_up_total'] . ')' ?></label>-->
                                                            <!--    <div class="form-floating mb-3">-->
                                                            <!--        <input type="number" id="mp_bdm_comm" name="bdm_share_comm" value="<?php //echo (float)$markup_dist_price['bdm_direct_commission'] ?>" placeholder="Commision" class="form-control" readOnly>-->
                                                            <!--        <label for="mp_bdm_comm">Commision </label>-->
                                                            <!--    </div>-->
                                                            <!--    <div class="form-floating mb-3">-->
                                                            <!--        <input type="number" id="mp_bdm_ins" name="bdm_share_ins" value="<?php //echo (float)$markup_dist_price['bdm_incentive'] ?>" placeholder="Incentive" class="form-control" readOnly>-->
                                                            <!--        <label for="mp_bdm_ins">Incentive </label>-->
                                                            <!--    </div>-->
                                                            <!--</div>-->
                                                            <!--<div class="col-md-6 col-sm-2 mt-3" id="bcm_div">-->
                                                            <!--    <label for="bcm_div">Business Channel Manager<?php //echo '(Total:' . (float)$markup_dist_price['bcm_mark_up_total'] . ')' ?></label>-->
                                                            <!--    <div class="form-floating mb-3">-->
                                                            <!--        <input type="number" id="mp_bcm_comm" name="bcm_share_comm" value="<?php //echo (float)$markup_dist_price['bcm_direct_commission'] ?>" placeholder="Commision" class="form-control" readOnly>-->
                                                            <!--        <label for="mp_bcm_comm">Commision </label>-->
                                                            <!--    </div>-->
                                                            <!--    <div class="form-floating mb-3">-->
                                                            <!--        <input type="number" id="mp_bcm_ins" name="bcm_share_ins" value="<?php //echo (float)$markup_dist_price['bcm_incentive'] ?>" placeholder="Incentive" class="form-control" readOnly>-->
                                                            <!--        <label for="mp_bcm_ins">Incentive </label>-->
                                                            <!--    </div>-->
                                                            <!--</div>-->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <h4 class="p-3 fw-bolder">Cancellation Policy</h4>
                                                    <div class="form-group row">
                                                        <div class="col-md-5 col-sm-5 mt-3">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="can_per_1" name="cancel_per_1" value="<?php echo (float)$cancel_policy['policy_1'] ?>" class="form-control" maxlength="3">
                                                                <label for="can_per_1" class="required">30+ Days Before Travel (%) </label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="can_per_2" name="cancel_per_1" value="<?php echo (float)$cancel_policy['policy_2'] ?>" class="form-control" maxlength="3">
                                                                <label for="can_per_1" class="required">15-30 Days Before Travel (%) </label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="can_per_3" name="cancel_per_1" value="<?php echo (float)$cancel_policy['policy_3'] ?>" class="form-control" maxlength="3">
                                                                <label for="can_per_1" class="required">less then 15 Days Before Travel (%)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_pricing_nextBtn">
                                                        <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fifth Box Package Picture  -->
                                        <div id="package_form_picture" style="display: none">
                                            <div class="col-md-6 col-sm-12">
                                                <label style="margin-top: -34px;font-size: 0.8rem;">Picture</label>
                                                <?php
                                                // package_pictures 
                                                $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = $id");
                                                $data->execute();
                                                $data->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($data->rowCount() > 0) {
                                                    foreach (($data->fetchAll()) as $key_1 => $image) {
                                                        echo '<div class="preview-existing-images-zone item-content" style="display: inline-block;">
                                                                        <div class="preview-existing-image preview-existing-show-" id="image_' . $image['id'] . '">
                                                                        <a href="#" class="image-delete" onclick="deleteImageFunction(event, ' . $image['id'] . ')" ><i class="fa fa-trash" aria-hidden="true" style="color: red;margin-top: 10px;"></i></a>
                                                                            <div class="image-zone">
                                                                                <img src="../../' . $image['image'] . '" style="object-fit:cover">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    ';
                                                    }
                                                }
                                                ?>
                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <!-- <span>Upload</span> -->
                                                        <input type="file" id="gallery-photo-add" accept=".jpg,.png,.jpeg" multiple>
                                                    </div>

                                                    <div class="gallery"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 m-3">
                                                    <button><a href="#" id="update_form" class="placeholder-wave bg-primary border rounded-3 text-white p-2">UPDATE</a></button>
                                                    <a href="#" id="submit_form" style="display:none"></a>
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

    <!-- loader -->
    <div id="loading-loader" class="loader" style="display:none"></div>
    <!-- snack bar -->
    <div id="bottom-snackbar" class="bottom-snackbar" style="display:none">Snack Bar</div>

    <!--start back-to-top-->
    <button class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <!-- custom js -->
    <script src="forms/product_packages.js"></script>
    <!-- <script>
            $(document).ready(function(){
                $("#user_table").DataTable();
            });
        </script> -->
    <script>
        var mybutton = document.getElementById("back-to-top");

        function scrollFunction() {
            100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
        }
        // function topFunction() {
        //     document.body.scrollTop = 0,
        //     document.documentElement.scrollTop = 0
        // }
        mybutton && (window.onscroll = function() {
            scrollFunction()
        });
    </script>

    <script>
        var selected_cat_id = document.getElementById("selected_cat_id");
        var selected_sub_cat_id = document.getElementById("selected_sub_cat_id");
        var selected_club_id = document.getElementById("selected_club_id");
        var selected_package_type = document.getElementById("selected_package_type");
        var selected_hotel_cat_id = document.getElementById("selected_hotel_cat_id");
        var selected_meal_cat_id = document.getElementById("selected_meal_cat_id");

        // get previousdata
        $(document).ready(function() {


            // Set Regex Validation to true
            isValid_a1 = true, isValid_a2 = true;
            isValid_b1 = true, isValid_b2 = true, isValid_b3 = true;
            isValid_c1 = true, isValid_c2 = true, isValid_c3 = true, isValid_c4 = true, isValid_c5 = true, isValid_c6 = true;
            isValid_d1 = true, isValid_d2 = true;



            $("#category_id").val(selected_cat_id.value);
            $("#sub_category_data").val(selected_sub_cat_id.value);
            $("#club_id").val(selected_club_id.value);
            $('input:radio[name=package_type]').val([selected_package_type.value]);
            packageTypeOnClick(selected_package_type);
            $("#category_hotel_id").val(selected_hotel_cat_id.value);
            $("#category_meal_id").val(selected_meal_cat_id.value);

            var product_amount = <?php echo json_encode($amount); ?>;
            finalNetPriceWithGST = product_amount['net_total'];
            Product_PriceTotal = product_amount['net_markup_price_total'];
            GST_PriceTotal = product_amount['net_markup_gst_total'];

            getClubData();

            // occupancy data
            occupancies = [];
            var occupanciesJSON = <?php echo json_encode($pkg_to_cat_occupancy); ?>;
            if (occupanciesJSON == "null") {} else {
                occupanciesJSON.forEach(occupancy => {
                    $.ajax({
                        type: 'POST',
                        url: 'forms/get_occupancy_categories.php',
                        data: 'ocup_id=' + occupancy['occupancy_id'],
                        success: function(e) {
                            // console.log(e);
                            var data = {
                                id: occupancy['occupancy_id'],
                                name: e
                            };
                            occupancies.push(data); // push data into array
                            showOccupancy(); // show data
                        },
                        error: function(err) {
                            console.log(err);
                        },
                    });
                });
            }

            // Vehicles data
            vehicles = [];
            var vehicleJSON = <?php echo json_encode($pkg_to_cat_vehicle); ?>;
            if (vehicleJSON == "null") {} else {
                vehicleJSON.forEach(vehicle => {
                    $.ajax({
                        type: 'POST',
                        url: 'forms/get_vehicles_categories.php',
                        data: 'vehicle_id=' + vehicle['vehicle_id'],
                        success: function(e) {
                            // console.log(e);
                            var data = {
                                id: vehicle['vehicle_id'],
                                name: e
                            };
                            vehicles.push(data); // push data into array
                            showVehicle(); // show Data
                            // $('#vehicle_data').html(vehicles.name);
                        },
                        error: function(err) {
                            console.log(err);
                        },
                    });
                });
            }

            // days data
            var daysJSON = <?php echo json_encode($dayData); ?>;
            var max_fields = 16;
            var dayCount = 0;
            var wrapper = $(".input_fields_wrap"); // 🔹 Make sure this exists in your HTML
            var x = 1;

            console.log(daysJSON);

            if (daysJSON !== null) {
                daysJSON.forEach(day => {
                    dayCount += 1;
                    if (x < max_fields) { // Max input box allowed
                        x++; // Increment text box count

                        $(wrapper).append(`
                <div class="row day-container" id="removeDiv">
                    <div class="col-md-2 col-sm-2 col-12 d-flex justify-content-center align-items-center">
                        <div class="">
                            <a type="button" class="btn btn-success px-3 ms-4 dayval">Day: ` + dayCount + `</a>
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-10 col-12">
                        <div class="row">
                            <div class="card rounded-5 box" draggable="true">
                                <div class="row px-4 pt-2 d-flex justify-content-between">
                                    <div class="col-md-9 col-sm-8 col-8">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Title</span>
                                            <input type="text" class="form-control title" value="` + (day.title || '') + `" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4 col-4">
                                        <button type="button" class="remove_field btn btn-danger px-3">Remove</button>
                                    </div>
                                </div>
                                <div class="col-md-12 px-4 pb-2">
                                    <div class="input-group">
                                        <span class="input-group-text">Description</span>
                                        <textarea class="form-control description">` + (day.day_details || '') + `</textarea>
                                    </div>
                                </div>
                                <div class="row px-4 py-2 pb-0">
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Meals Included</span>
                                            <input type="text" class="form-control meals" value="` + (day.meal_plan || '') + `" placeholder="Meals">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Transport</span>
                                            <input type="text" class="form-control transport" value="` + (day.day_tansport || '') + `" placeholder="Transport">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`); // Append input box with pre-filled data
                    }
                });
            }

            // ✅ Fixed Remove Button (More Specific Selector)
            $(document).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).closest('.day-container').remove(); // Remove the closest .day-container
                updateDayNumbers(); // Re-number days after removing
            });

            // ✅ Function to update day numbers
            function updateDayNumbers() {
                $(".dayval").each(function(index) {
                    $(this).text("Day: " + (index + 1)); // Re-assign correct day numbers
                });
            }
            // $(document).on("click", ".remove_field", function(e) {
            //     e.preventDefault();
            //     e.preventDefault();
            //     $(this).parent('div').remove();
            //     e.target.parentElement.getElementById("removeDiv").remove()
            //     x--;
            // });




            // delete images
            function deleteImageFunction(e, id) {
                e.preventDefault();

                // console.log(id);
                var r = confirm("Do you want to delete this image ?");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "forms/deleteImages.php",
                        data: 'id=' + id,
                        cache: false,
                        success: function(data) {
                            if (data == "success") {
                                document.getElementById("image_" + id).style.display = "none";
                                alert("Deleted Succesfully");
                            } else {
                                alert("Failed to Delete");
                            }
                        }
                    });
                }
            }
        });
    </script>
</body>

</html>