<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';
$date = date('Y');

//product payout commission
$data7 = $conn->prepare("SELECT * FROM `product_commission` WHERE status = 1");
$data7->execute();
$data7->setFetchMode(PDO::FETCH_ASSOC);
$product_payout_data = $data7->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Packages</title>
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
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-between">
                        <div class="breadcrumb">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data</li> -->
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
                                    <h4 id="package_form_general_title">Add New Package - General Information</h4>
                                    <!-- p2 -->
                                    <h4 id="package_form_extra_title" style="display: none">Add New Package - Package Extra Information</h4>
                                    <!-- p3 -->
                                    <h4 id="package_form_itinerary_title" style="display: none">Add New Package - Itinerary Details</h4>
                                    <!-- p4 -->
                                    <h4 id="package_form_pricing_title" style="display: none">Add New Package - Pricing</h4>
                                    <!-- p5 -->
                                    <h4 id="package_form_picture_title" style="display: none">Add New Package - Picture</h4>
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
                                                                echo '<option value="">--Select Category--</option>';
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
                                                        <select id="sub_category_id" name="sub_category_id" class="form-select">
                                                            <option value="">--Select Category First--</option>
                                                        </select>
                                                        <label>Select Sub-Category Type</label>
                                                    </div>
                                                    <select id="sub_category_data" name="sub_category_data" class="form-select" style="display: none"></select>
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

                                                <div class="col-lg-6 col-md-6 col-sm-6 ps-4 pt-4 pb-3">
                                                    <label>Package applicable for</label>
                                                    <span class="required"></span>
                                                    <br />
                                                    <div class="select">
                                                        <span id="stag_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="stag" id="stag_id"><label style="padding-right: 15px; padding-left: 5px;" for="stag_id"> Stag</label></span>
                                                        <span id="couple_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="couple" id="couple_id"><label style="padding-right: 15px; padding-left: 5px;" for="couple_id"> Couple</label></span>
                                                        <span id="family_id_field"><input type="radio" onclick="packageTypeOnClick(this);" name="package_type" value="family" id="family_id"><label style="padding-right: 15px; padding-left: 5px;" for="family_id"> Family</label></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Package Name">
                                                        <label for="name" class="required">Package Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="Unique Code">
                                                        <label for="unique_code" class="required">Unique Code</label>

                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="tour_days" name="tour_days" placeholder="Unique Code">
                                                        <label for="tour_days" class="required">Tour Days</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-floating mb-3">
                                                        <input type="date" class="form-control" id="pac_validity" name="pac_validity" placeholder="Package Validity">
                                                        <label for="pac_validity" class="required">Validity Upto</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input id="description" class="form-control" type="text" name="description" placeholder="Description">
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
                                        <div id="package_form_extra" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mt-3 mb-3">
                                                        <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control">
                                                        <label for="destination" class="required">Destination</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="location" name="location" value="" placeholder="Location" class="form-control">
                                                        <label for="location" class="required">Location</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="travel_from" name="travel_from" value="" placeholder="Transfer From" class="form-control">
                                                        <label for="travel_from" class="required">Transfer From</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="travel_to" name="travel_to" value="" placeholder="Transfer To" class="form-control">
                                                        <label for="travel_to" class="required">Transfer To</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" id="sightseeing_type" name="sightseeing_type" value="" placeholder="Sightseeing Type" class="form-control">
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
                                                        <input type="text" id="package_keywords" name="package_keywords" value="" placeholder="Package Keywords" class="form-control">
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
                                        <div id="package_form_itinerary" style="display: none;">
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
                                                    <textarea id="inclusion" name="inclusion" class="textarea ms-2" rows="2" cols="50"></textarea>
                                                </div>
                                                <div class="row">
                                                    <label for="exclusion" class="required">Exclusion</label>
                                                    <textarea id="exclusion" name="exclusion" class="myTextEditor ms-2" rows="2" cols="50"></textarea>
                                                </div>

                                                <div class="row">
                                                    <label for="remark">Remark</label>
                                                    <textarea id="remark" name="remark" class="myTextEditor ms-2" rows="2" cols="50"></textarea>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_itinerary_nxtBtn">
                                                    <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fourth Box Pricing -->
                                        <div id="package_form_pricing" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" onkeyup="getNetPrice()" id="netPriceAdult" name="net_price_adult" value="" placeholder="NET Price for 1 Adult:" class="form-control">
                                                            <label for="netPriceAdult" class="required">NET Price for 1 Adult:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3" id="netPriceChildData">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" onkeyup="getNetPrice()" id="netPriceChild" name="netPriceChild" value="" placeholder="NET Price for 1 Child" class="form-control" value='0'>
                                                            <label for="netPriceChild" class="required">NET Price for 1 Child:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" onkeyup="getNetPrice()" id="nGst" name="nGst" value="" placeholder="Net GST Title" class="form-control">
                                                            <label id="net_gst_title" for="nGst">Net GST Title :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="totalNetPriceAdult" name="totalNetPriceAdult" value="" placeholder="Net Total for Adult" class="form-control" readonly>
                                                            <label id="totalNetPriceAdult" for="nGst">Net Total for Adult :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 mt-3" id="totalNetPriceChildData">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="totalNetPriceChild" name="totalNetPriceChild" value="" placeholder="Net Total for Child" class="form-control" readonly>
                                                            <label id="totalNetPriceChild" for="nGst">Net Total for Child :</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12 " style="padding:20px 0px 0px 0px">
                                                <div class="col-md-6 col-sm-6 mt-3">
                                                    <div class="form-floating mb-3"><!-- added on 23 Jan 2025 SV-->
                                                        <input type="number" value="" id="mrp_per_adult" placeholder="Total Price Per Adult" class="form-control" readOnly>
                                                        <label for="mrp_per_adult">Total Price Per Adult</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="number" id="add_adult_price" name="add_adult_price" value="" class="form-control">
                                                        <label for="add_adult_price">Additional Adult Price</label>
                                                    </div>
                                                    <div class="form-floating mb-3" id="total_child_price">
                                                        <input type="number" value="" id="mrp_per_child" placeholder="Total Price Per Child" class="form-control" readOnly>
                                                        <label for="mrp_per_child">Total Price Per Child</label>
                                                    </div>
                                                </div><!-- added on 23 Jan 2025 SV-->
                                            </div>
                                            <!-- updatde markuplogic in 23 Jan 2025 by SV -->
                                            <div class="col-md-12 " style="padding:20px 0px 0px 0px">
                                                <div class="row">
                                                    <h4 class="p-3 fw-bolder">Mark-Up Price Distribution</h4>

                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-3 mt-3">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_company" name="company_share" value="" placeholder="Company Share" class="form-control" onchange="finalfill()">
                                                                <label for="mp_company" class="required">Company </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 mt-3">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_ca_ta" name="ca_ta_share" value="" placeholder="Travel Agency share" class="form-control" onchange='getMarkUpDistribution(<?= json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' />
                                                                <label for="mp_franchise">Travel Consultant</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 mt-3">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_customer" name="customer_share" value="" placeholder="Customer Share" class="form-control" onchange="finalfill()" readonly>
                                                                <label for="mp_customer" class="required">Customer</label>
                                                                <input type="hidden" id="l1_cust_comm" value="" />
                                                                <input type="hidden" id="l2_cust_comm" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-3 mt-3">
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="prime_cust_comm" name="prime_cust_comm" value="" placeholder="L1 Customer" class="form-control" onchange="finalfill()">
                                                                <label for="prime_cust_comm" class="required">L1 Customer</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-2 mt-3" id="ca_div">
                                                            <label id="ca_label" for="ca_div">Techno Enterprise</label>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_ca_comm" name="ca_share_comm" value="" placeholder="Commision" class="form-control" readOnly>
                                                                <label for="mp_ca_comm">Commision </label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_ca_ins" name="ca_share_ins" value="" placeholder="Incentive" class="form-control" readOnly>
                                                                <label for="mp_ca_ins">Incentive </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-2 mt-3" id="bm_div">
                                                            <label id="bm_label" for="bm_div">Business Consultant/Mentor</label>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_bm_comm" name="bm_share_comm" value="" placeholder="Commision" class="form-control" readOnly>
                                                                <label for="mp_bm_comm">Commision </label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_bm_ins" name="bm_share_ins" value="" placeholder="Incentive" class="form-control" readOnly>
                                                                <label for="mp_bcm_ins">Incentive </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-2 mt-3">
                                                            <label for="bm_div">Adult Price After Markup</label>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_adult" name="mp_adult" value="" placeholder="Adult Price" class="form-control" readOnly>
                                                                <label for="mp_adult">Adult Price </label>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-6 col-sm-2 mt-3">
                                                            <label for="bm_div">Child Price After Markup</label>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" id="mp_child" name="mp_child" value="" placeholder="Child Price" class="form-control" readOnly>
                                                                <label for="mp_child">Child Price </label>
                                                            </div>
                                                            
                                                        </div>
                                                        <!--<div class="col-md-6 col-sm-2 mt-3" id="bdm_div">-->
                                                        <!--    <label for="bdm_div">Business Development Manager</label>-->
                                                        <!--    <div class="form-floating mb-3">-->
                                                        <!--        <input type="number" id="mp_bdm_comm" name="bdm_share_comm" value="" placeholder="Commision" class="form-control" readOnly>-->
                                                        <!--        <label for="mp_bdm_comm">Commision </label>-->
                                                        <!--    </div>-->
                                                        <!--    <div class="form-floating mb-3">-->
                                                        <!--        <input type="number" id="mp_bdm_ins" name="bdm_share_ins" value="" placeholder="Incentive" class="form-control" readOnly>-->
                                                        <!--        <label for="mp_bdm_ins">Incentive </label>-->
                                                        <!--    </div>-->
                                                        <!--</div>-->
                                                        <!--<div class="col-md-6 col-sm-2 mt-3" id="bcm_div">-->
                                                        <!--    <label for="bcm_div">Business Channel Manager</label>-->
                                                        <!--    <div class="form-floating mb-3">-->
                                                        <!--        <input type="number" id="mp_bcm_comm" name="bcm_share_comm" value="" placeholder="Commision" class="form-control" readOnly>-->
                                                        <!--        <label for="mp_bcm_comm">Commision </label>-->
                                                        <!--    </div>-->
                                                        <!--    <div class="form-floating mb-3">-->
                                                        <!--        <input type="number" id="mp_bcm_ins" name="bcm_share_ins" value="" placeholder="Incentive" class="form-control" readOnly>-->
                                                        <!--        <label for="mp_bcm_ins">Incentive </label>-->
                                                        <!--    </div>-->
                                                        <!--</div>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- cancelation policy 23 jan 2025 SV-->
                                            <div class="row">
                                                <h4 class="p-3 fw-bolder">Cancellation Policy</h4>
                                                <div class="form-group row">
                                                    <div class="col-md-5 col-sm-5 mt-3">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="can_per_1" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                            <label for="can_per_1" class="required">30+ Days Before Travel (%) </label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="can_per_2" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                            <label for="can_per_1" class="required">15-30 Days Before Travel (%) </label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="can_per_3" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                            <label for="can_per_1" class="required">less then 15 Days Before Travel (%)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end added on 23 Jan SV-->
                                                <div class="row">
                                                    <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_pricing_nextBtn">
                                                        <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fifth Box Package Picture  -->
                                        <div id="package_form_picture" style="display: none;">
                                            <div class="col-md-6 col-sm-12">
                                                <label style="margin-top: -34px;font-size: 0.8rem;">Picture</label>
                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <!-- <span>Upload</span> -->
                                                        <input type="file" id="gallery-photo-add" accept=".jpg,.png,.jpeg" multiple>
                                                    </div>
                                                    <!-- <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text">
                                                        <input type="hidden" id="picture" disabled>
                                                    </div> -->
                                                    <div class="gallery"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 m-3">
                                                    <button><a href="#" id="submit_form" class="placeholder-wave bg-primary border rounded-3 text-white p-2">SUBMIT</a></button>
                                                    <a href="#" id="update_form" style="display:none"></a>
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
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->
    <!-- JAVASCRIPT -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <!-- custom js -->
    <script src="forms/product_packages.js"></script>
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
    <!-- <script>
            $(document).ready(function(){
                $("#user_table").DataTable();
            });
        </script> -->
</body>

</html>