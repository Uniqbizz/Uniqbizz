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

//product payout commission new added on 09 may 2026
$data8 = $conn->prepare("SELECT * FROM `product_commission_te_chain` WHERE status = 1");
$data8->execute();
$data8->setFetchMode(PDO::FETCH_ASSOC);
$product_payout_data_new = $data8->fetchAll();

//product payout commission new added on 12 may 2026
$data9 = $conn->prepare("SELECT * FROM `product_commission_institution` WHERE status = 1");
$data9->execute();
$data9->setFetchMode(PDO::FETCH_ASSOC);
$product_payout_data_ins = $data9->fetchAll();
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
        <!-- Packages CSS -->
        <link href="../assets/css/packages.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                        <div class="row">
                            <div class="card">
                                <div class="col-lg-12">
                                    <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                                        <div>
                                            <h4 id="pageTitle" class="mb-0">
                                                Add New Package - General Information
                                            </h4>
                                            <small id="pageSubTitle" class="text-muted">
                                                Return to Package Listing
                                            </small>
                                        </div>
                                        <a href="#" id="dynamicBackBtn" class="btn btn-outline-primary">
                                            <i class="fa fa-arrow-left me-2"></i>Back
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mt-3">
                                            <nav class="stepper-nav">
                                                <a class="nav-link textColor active step-link d-flex align-items-center gap-1" href="#package_form_general">
                                                    <div class="roundedCircle active">1</div>
                                                    <span>General Information</span>
                                                </a>

                                                <div class="hrRotate">
                                                    <hr class="border border-1 border-secondary">
                                                </div>

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#package_form_extra">
                                                    <div class="roundedCircle">2</div>
                                                    <span>Extra Information</span>
                                                </a>

                                                <div class="hrRotate">
                                                    <hr class="border border-1 border-secondary">
                                                </div>

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#package_form_itinerary">
                                                    <div class="roundedCircle">3</div>
                                                    <span>Itinerary & Inclusions</span>
                                                </a>

                                                <div class="hrRotate">
                                                    <hr class="border border-1 border-secondary">
                                                </div>

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#package_form_pricing">
                                                    <div class="roundedCircle">4</div>
                                                    <span>Pricing</span>
                                                </a>

                                                <div class="hrRotate">
                                                    <hr class="border border-1 border-secondary">
                                                </div>

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#package_form_policy">
                                                    <div class="roundedCircle">5</div>
                                                    <span>Policy</span>
                                                </a>

                                                <div class="hrRotate">
                                                    <hr class="border border-1 border-secondary">
                                                </div>

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#package_form_picture">
                                                    <div class="roundedCircle">6</div>
                                                    <span>Pictures & Media</span>
                                                </a>
                                            </nav>
                                        </div>
                                        <div class="col-lg-12">
                                            <form id="package_form" class="tab-form" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                                <!-- First Box General details-->
                                                <div id="package_form_general">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" class="form-control" id="name" name="name" placeholder="Package Name">
                                                                <label for="name" class="required">Package Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="Unique Code">
                                                                <label for="unique_code" class="required">Unique Code</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <select class="form-select" id="category_id" name="category_id" aria-label="Floating label select example" onchange="getSubCategories()">
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
                                                                <label>Select Category Type <span class="required"></span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <select id="sub_category_id" name="sub_category_id" class="form-select">
                                                                    <option value="">--Select Category First--</option>
                                                                </select>
                                                                <label class="required">Select Sub-Category Type <span class="required"></span></label>
                                                            </div>
                                                            <select id="sub_category_data" name="sub_category_data" class="form-select" style="display: none"></select>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 mb-3">
                                                            <div class="borderHighlight px-3 py-2">
                                                                <label>Travel Theme / Type <span class="required"></span></label>
                                                                <div class="d-flex gap-4">
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option1" autocomplete="off" checked>
                                                                        <label class="btn fw-bold" for="option1">
                                                                            <i class="fa-solid fa-mountain-city"></i>
                                                                            Leisure
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option2" autocomplete="off">
                                                                        <label class="btn fw-bold" for="option2">
                                                                            <i class="fa-solid fa-mountain-sun"></i>
                                                                            Adventure
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option3" autocomplete="off">
                                                                        <label class="btn fw-bold" for="option3">
                                                                            <i class="fa-solid fa-place-of-worship"></i>
                                                                            Spiritual
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option4" autocomplete="off">
                                                                        <label class="btn fw-bold" for="option4">
                                                                            <i class="fa-solid fa-umbrella-beach"></i>
                                                                            Beach
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option5" autocomplete="off">
                                                                        <label class="btn fw-bold" for="option5">
                                                                            <i class="fa-solid fa-heart"></i>
                                                                            Honeymoon
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check" name="options-base" id="option6" autocomplete="off">
                                                                        <label class="btn fw-bold" for="option6">
                                                                            <i class="fa-solid fa-crosshairs"></i>
                                                                            Other</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control" id="tour_days" name="tour_days" placeholder="Unique Code">
                                                                        <label for="tour_days" class="required">Tour Days</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="date" class="form-control" id="pac_validity" name="pac_validity" placeholder="Package Validity">
                                                                        <label for="pac_validity" class="required">Validity Upto</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="tour_days" name="tour_days" placeholder="Unique Code">
                                                                        <label for="tour_days">Best Season To Visit</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="pacLocation" name="pacLocation" placeholder="Unique Code">
                                                                        <label for="tour_days" class="required">Location</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="highlights-section p-3">
                                                            <label class="highlight-label">Cities</label>
                                                            <div class="highlight-container" id="highlightContainer">
                                                                <div class="highlight-tag">
                                                                    Delhi
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                                <div class="highlight-tag">
                                                                    Shimla
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                                <div class="highlight-tag">
                                                                    Manali
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                                <div class="highlight-tag">
                                                                    Chandhigarh
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                                <div class="highlight-tag">
                                                                    Goa
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                                <div class="highlight-tag">
                                                                    Keralam
                                                                    <span class="remove-btn">&times;</span>
                                                                </div>
                                                            </div>
                                                            <div class="add-highlight">
                                                                <a href="#" id="addHighlightBtn">+ Add More Cities</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input id="description" class="form-control" type="text" name="description" placeholder="Description">
                                                            <label for="description" class="required">Short Description</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-floating">
                                                            <textarea class="form-control" placeholder="Leave a comment here" id="description1"></textarea>
                                                            <label for="description1" class="required">Detailed Description</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mt-3">
                                                            <div class="form-floating">
                                                                <div class="form-control d-flex justify-content-between">
                                                                    <div>
                                                                        <input type="radio" name="package_type" value="trending" id="trending" checked>
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="trending">Trending</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="package_type" value="popular" id="popular">
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="popular">Popular</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="package_type" value="most-selling" id="most_selling">
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="most_selling">Most Selling</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" name="package_type" value="new-arrival" id="new_arrival">
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="new_arrival">New Arrival</label>
                                                                    </div>
                                                                </div>
                                                                <label class="">Highlight Type <span class="required"></span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3">
                                                            <div class="form-floating">
                                                                <div class="form-control">
                                                                    <input type="radio" name="package_type" value="visaYes" id="visaYes" checked>
                                                                    <label style="padding-right:15px; padding-left: 5px;" for="visaYes">Yes</label>
                                                                    <input type="radio" name="package_type" value="visaNo" id="visaNo">
                                                                    <label style="padding-right:15px; padding-left: 5px;" for="visaNo">No</label>
                                                                </div>
                                                                <label class="">Visa Required <span class="required"></span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-3">
                                                        <div class="row">
                                                            <div class="col-lg-6 pe-0">
                                                                <div class="borderHighlight px-3 py-2">
                                                                    <label>Drop Price (Optional) <span class="required"></span></label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                                                        <label class="form-check-label" for="switchCheckDefault">Enable Drop Price</label>
                                                                    </div>
                                                                    <div class="form-floating my-2">
                                                                        <input id="description" class="form-control" type="text" name="description" placeholder="Description">
                                                                        <label for="description" class="required">Drop Price Per Person (&#8377;)</label>
                                                                    </div>
                                                                    <p class="mb-0">This price will be shown as starting price</p>
                                                                </div>
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
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control">
                                                                <label for="destination" class="required">Destination</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" id="travel_from" name="travel_from" value="" placeholder="Transfer From" class="form-control">
                                                                <label for="travel_from" class="required">Pick Up Point</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" id="travel_to" name="travel_to" value="" placeholder="Transfer To" class="form-control">
                                                                <label for="travel_to" class="required">Drop Point</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="sightseeing_type" name="sightseeing_type" value="" placeholder="Sightseeing Type" class="form-control">
                                                                <label for="sightseeing_type" class="required">Sightseeing Type</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="language_type" name="language_type" value="" placeholder="Language Type" class="form-control">
                                                                <label for="language_type" class="required">Language Type</label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-12 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="package_keywords" name="package_keywords" value="" placeholder="Package Keywords" class="form-control">
                                                                <label for="package_keywords" class="required">Package Keywords</label>
                                                            </div>

                                                        </div> -->
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="highlights-section p-3">
                                                                <label class="highlight-label">Package Keyword</label>
                                                                <div class="highlight-container" id="packageKeybord">
                                                                    <!-- <div class="highlight-tag">
                                                                        Delhi
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div>
                                                                    <div class="highlight-tag">
                                                                        Shimla
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div>
                                                                    <div class="highlight-tag">
                                                                        Manali
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div>
                                                                    <div class="highlight-tag">
                                                                        Chandhigarh
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div>
                                                                    <div class="highlight-tag">
                                                                        Goa
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div>
                                                                    <div class="highlight-tag">
                                                                        Keralam
                                                                        <span class="remove-btn">&times;</span>
                                                                    </div> -->
                                                                </div>
                                                                <div class="add-highlight">
                                                                    <a href="#" id="addPackageKeywordBtn">+ Add More Keyword</a>
                                                                </div>
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
                                                    <div class="row mt-3">
                                                        <label for="w3review">This section will contain the information about the package that this product is offering.</label>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between remarkTitleCard">
                                                                    <p class="title remarkTitle mb-0"><i class="fa-solid fa-book fa-xl me-2"></i>Highlights</p>
                                                                    <a href="#" id="hightlightBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="hightlightList">
                                                                    <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                        <p class="mb-0 remark-text">03 Night accommodation in 3 Star Hotel</p>
                                                                        <div class="d-flex gap-3">
                                                                            <a href="#" class="edit-remark text-primary">
                                                                                <i class="fa-solid fa-pencil"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-remark text-danger">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between titleCard">
                                                                    <p class="title inclusionTitle mb-0"><i class="fa-regular fa-circle-check fa-xl me-2"></i>Inclusions</p>
                                                                    <a href="#" id="addInclusionBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="inclusionList">
                                                                    <div class="inclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                        <p class="mb-0 inclusion-text">03 Night accommodation in 3 Star Hotel</p>
                                                                        <div class="d-flex gap-3">
                                                                            <a href="#" class="edit-inclusion text-primary">
                                                                                <i class="fa-solid fa-pencil"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-inclusion text-danger">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between exclusionTitleCard">
                                                                    <p class="title exclusionTitle mb-0"><i class="fa-regular fa-circle-xmark fa-xl me-2"></i>Exclusions</p>
                                                                    <a href="#" id="addExclutionBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="exclusionList">
                                                                    <div class="exclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                        <p class="mb-0 exclusion-text">03 Night accommodation in 3 Star Hotel</p>
                                                                        <div class="d-flex gap-3">
                                                                            <a href="#" class="edit-exclusion text-primary">
                                                                                <i class="fa-solid fa-pencil"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-exclusion text-danger">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between remarkTitleCard">
                                                                    <p class="title remarkTitle mb-0"><i class="fa-solid fa-book fa-xl me-2"></i>Important Notes / Remarks</p>
                                                                    <a href="#" id="addRemarkBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="remarkList">
                                                                    <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                        <p class="mb-0 remark-text">03 Night accommodation in 3 Star Hotel</p>
                                                                        <div class="d-flex gap-3">
                                                                            <a href="#" class="edit-remark text-primary">
                                                                                <i class="fa-solid fa-pencil"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-remark text-danger">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between remarkTitleCard">
                                                                    <p class="title remarkTitle mb-0"><i class="fa-solid fa-circle-info fa-xl me-2"></i>Things to Know Before You Go</p>
                                                                    <a href="#" id="addThingsBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="thingsList">
                                                                    <div class="things-item d-flex justify-content-between align-items-start mb-2">
                                                                        <p class="mb-0 things-text">03 Night accommodation in 3 Star Hotel</p>
                                                                        <div class="d-flex gap-3">
                                                                            <a href="#" class="edit-things text-primary">
                                                                                <i class="fa-solid fa-pencil"></i>
                                                                            </a>
                                                                            <a href="#" class="delete-things text-danger">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                        <div class="col-md-12">
                                                            <h5 class="mt-3 mb-0 fw-bolder" id="mark_up_title">1. Base Pricing - Vendor Cost</h5>
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" onchange='calculatePackagePrice(<?= json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' id="netPriceAdult" name="net_price_adult" value="" placeholder="NET Price for 1 Adult:" class="form-control">
                                                                        <label for="netPriceAdult" class="required">Base Price for per Adult:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3" id="netPriceChildData">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" onchange='calculatePackagePrice(<?= json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' id="netPriceChild" name="netPriceChild" value="" placeholder="NET Price for 1 Child" class="form-control" value='0'>
                                                                        <label for="netPriceChild" class="required">Base Price for per Child:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" onchange='calculatePackagePrice(<?= json_encode($product_payout_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' id="nGst" name="nGst" value="" placeholder="Net GST Title" class="form-control">
                                                                        <label id="net_gst_title" for="nGst">Extra Mattress</label>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h5 class="mb-0 fw-bolder" id="#">2. Company Markup</h5>
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating my-3">
                                                                        <input type="text" id="companyMarkup" name="companyMarkup" placeholder="Destination" class="form-control">
                                                                        <label for="companyMarkup" class="required">Company Markup</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating my-3">
                                                                        <input type="text" id="couponAdjustment" name="couponAdjustment" placeholder="Destination" class="form-control">
                                                                        <label for="couponAdjustment" class="required">Default Coupon Adjustment</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h5 class="mb-3 fw-bolder" id="#">3. Price Visibility & Guest User Premium</h5>
                                                            <div class="borderHighlight px-3 mb-3">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-check form-switch my-2">
                                                                            <label class="form-check-label" for="switchCheckGuestUser">Guest User Premium (Without Login)</label>
                                                                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckGuestUser">
                                                                        </div>
                                                                        <div>
                                                                            <div class="d-flex gap-4">
                                                                                <div class="form-check align-content-center">
                                                                                    <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault1">
                                                                                    <label class="form-check-label" for="radioDefault1"> Add Fixed Amount</label>
                                                                                </div>
                                                                                <input type="text" id="fixedAmount" name="fixedAmount" class="form-control inputWidth">
                                                                            </div>
                                                                            <div class="d-flex gap-4">
                                                                                <div class="form-check align-content-center">
                                                                                    <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault2">
                                                                                    <label class="form-check-label" for="radioDefault2">Add Percentage</label>
                                                                                </div>
                                                                                <div class="input-group my-3 inputWidth">
                                                                                    <input type="text" class="form-control" id="percentage" name="percentage">
                                                                                    <span class="input-group-text">%</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 align-content-center">
                                                                        <div class="d-flex infoCardPrice gap-3 my-2">
                                                                            <div class="align-content-center">
                                                                                <i class="fa-solid fa-circle-info fa-2xl"></i>
                                                                            </div>
                                                                            <div class="">
                                                                                <p class="mb-0">Guests will see higher price.</p>
                                                                                <p class="mb-0">Logged in users will see actual price.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h5 class="mb-3 fw-bolder" id="#">4. Pricing Modal</h5>
                                                            <div class="borderHighlight px-3 pt-3 mb-3 table-responsive">
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="travelConsultant" name="travelConsultant" placeholder="travelConsultant" class="form-control">
                                                                        <label for="travelConsultant" class="required">Travel Consultant</label>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Role</th>
                                                                            <th scope="col">Commission Percentage</th>
                                                                            <th scope="col">Commission Amount</th>
                                                                            <th scope="col">Incentive Percentage</th>
                                                                            <th scope="col">Incentive Amount</th>
                                                                            <th scope="col">Total</th>
                                                                            <th scope="col">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>CTE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="cteComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="cteIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="cteCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>ETE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="eteComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="eteIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="eteCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>STE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="steComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="steIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="steCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                    
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>TE | Franchisee</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="cTeFComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="cTeFIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="cTeFCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                    <!-- <a href="#" class="delete-price-distribution text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a> -->
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <td class="fw-bolder">Total Distribution</td>
                                                                        <td class="text-end fw-bolder">5%</td>
                                                                        <td class="text-end fw-bolder" id="cteChainCommTotal">&#8377; 2,00,000</td>
                                                                        <td class="text-end fw-bolder">6%</td>
                                                                        <td class="text-end fw-bolder" id="cteChainInsTotal">&#8377; 3,00,000</td>
                                                                        <td class="text-end fw-bolder" id="cteChainCommInsTotal">&#8377; 5,00,000</td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="cteSuspence" name="cteSuspence" placeholder="cteSuspence" class="form-control">
                                                                        <label for="cteSuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Role</th>
                                                                            <th scope="col">Commission Percentage</th>
                                                                            <th scope="col">Commission Amount</th>
                                                                            <th scope="col">Incentive Percentage</th>
                                                                            <th scope="col">Incentive Amount</th>
                                                                            <th scope="col">Total</th>
                                                                            <th scope="col">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- <tr>
                                                                            <td>BDM | RM</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end">&#8377; 75,000</td>
                                                                            <td class="text-end">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                    <a href="#" class="delete-price-distribution text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr> -->
                                                                        <tr>
                                                                            <td>BM | SF | MF</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="teBmComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="teBmComm" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="teBmComInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>TE | Franchisee</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="bmTeComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="bmTeIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="bmTeCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <td class="fw-bolder">Total Distribution</td>
                                                                        <td class="text-end fw-bolder">5%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 2,00,000</td>
                                                                        <td class="text-end fw-bolder">6%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 3,00,000</td>
                                                                        <td class="text-end fw-bolder">&#8377; 5,00,000</td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="bmSuspence" name="bmSuspence" placeholder="bmSuspence" class="form-control">
                                                                        <label for="bmSuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <!-- table dat load from onload ajax -->
                                                                <h5 class="mb-3 fw-bolder" id="#">Institution Slab</h5>
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Range</th>
                                                                            <th scope="col">Commission Amount</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="commissionTableBody">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Role</th>
                                                                            <th scope="col">Commission Percentage</th>
                                                                            <th scope="col">Commission Amount</th>
                                                                            <th scope="col">Incentive Percentage</th>
                                                                            <th scope="col">Incentive Amount</th>
                                                                            <th scope="col">Total</th>
                                                                            <th scope="col">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>BM |SF | MF</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="iBmComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="iBmIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="iBmCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Institute</td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end editable-comm" id="bmIComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end" id="bmIIns">NA</td>
                                                                            <td class="text-end editable-total" id="bmICommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <td class="fw-bolder">Total Distribution</td>
                                                                        <td class="text-end fw-bolder">5%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 2,00,000</td>
                                                                        <td class="text-end fw-bolder">6%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 3,00,000</td>
                                                                        <td class="text-end fw-bolder">&#8377; 5,00,000</td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="bmISuspence" name="bmISuspence" placeholder="bmISuspence" class="form-control">
                                                                        <label for="bmISuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th scope="col">Role</th>
                                                                            <th scope="col">Commission Percentage</th>
                                                                            <th scope="col">Commission Amount</th>
                                                                            <th scope="col">Incentive Percentage</th>
                                                                            <th scope="col">Incentive Amount</th>
                                                                            <th scope="col">Total</th>
                                                                            <th scope="col">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>CTE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="iCteComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="iCteIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="iCteCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>ETE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end editable-comm" id="iEteComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">1.5%</td>
                                                                            <td class="text-end editable-ins" id="iEteIns" data-value="75000">&#8377; 75,000</td>
                                                                            <td class="text-end editable-total" id="iEteCommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Institute</td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end editable-comm" id="cteIComm" data-value="50000">&#8377; 50,000</td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end" id="cteIIns">NA</td>
                                                                            <td class="text-end editable-total" id="cteICommInsTotal">&#8377; 1,25,000</td>
                                                                            <td>
                                                                                <div class="d-flex gap-3 justify-content-center">
                                                                                    <a href="#" class="edit-price-distribution text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <td class="fw-bolder">Total Distribution</td>
                                                                        <td class="text-end fw-bolder">5%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 2,00,000</td>
                                                                        <td class="text-end fw-bolder">6%</td>
                                                                        <td class="text-end fw-bolder">&#8377; 3,00,000</td>
                                                                        <td class="text-end fw-bolder">&#8377; 5,00,000</td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="cteISuspence" name="cteISuspence" placeholder="cteISuspence" class="form-control">
                                                                        <label for="cteISuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" id="customer1" name="customer1" placeholder="Customer1" class="form-control">
                                                                            <label for="customer1" class="required">Customer 1</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" id="customer2" name="customer2" placeholder="Customer2" class="form-control">
                                                                            <label for="customer2" class="required">Customer 2</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="text" id="customer3" name="customer3" placeholder="Customer3" class="form-control">
                                                                            <label for="customer3" class="required">Customer 3</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                                                            <h5 class="mb-3 fw-bolder" id="#">5. Total Pricing</h5>
                                                            <div class="borderHighlight p-3 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4 mb-3">
                                                                            <div class="align-content-center">
                                                                                <label for="mrp_per_adult" class="mb-0">Total Price Per Adult</label>
                                                                            </div>
                                                                            <input type="number" value="" id="mrp_per_adult" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrp_per_child" class="mb-0">Total Price Per Child</label>
                                                                            </div>
                                                                            <input type="number" value="" id="mrp_per_child" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 col-12">
                                                            <h4 class="mb-3 fw-bolder">6. Cancellation Policy</h4>
                                                            <div class="row borderHighlight mx-0">
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                                                    <div class="text-center mb-2">
                                                                        <label for="mrp_per_adult" class="mb-0">Cancellation Before Travel</label>
                                                                    </div>
                                                                    <div class="inputFieldAlignment">
                                                                        <input type="number" value="" id="mrp_per_adult" placeholder="30+ Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrp_per_adult" placeholder="15 - 30 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrp_per_adult" placeholder="7 - 15 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrp_per_adult" placeholder="0 - 7 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrp_per_adult" placeholder="No Show" class="form-control inputWidth" readOnly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                                                    <div class="text-center mb-2">
                                                                        <label for="mrp_per_child" class="mb-0">Cancellation Charges</label>
                                                                    </div>
                                                                    <div class="inputFieldAlignment">
                                                                        <div class="input-group inputWidth">
                                                                            <input type="text" class="form-control" id="cancellationPercentage" name="cancellationPercentage" placeholder="10" readOnly>
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="text" class="form-control" id="cancellationPercentage" name="cancellationPercentage" placeholder="25" readOnly>
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="text" class="form-control" id="cancellationPercentage" name="cancellationPercentage" placeholder="50" readOnly>
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="text" class="form-control" id="cancellationPercentage" name="cancellationPercentage" placeholder="75" readOnly>
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="text" class="form-control" id="cancellationPercentage" name="cancellationPercentage" placeholder="100" readOnly>
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
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
                                                <!-- Fifth Box Package Picture  -->
                                                <div id="package_form_policy" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <h4 class="mt-3 fw-bolder">Coupon Rule</h4>
                                                            <div class="borderHighlight p-3">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <label class="form-check-label" for="switchCoupon">Coupon Allowed</label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="switchCoupon">
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <label class="form-check-label" for="switchCombine">Can Combine With Other Offers</label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="switchCombine">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <h4 class="mt-3 fw-bolder">Booking Policy</h4>
                                                            <div class="borderHighlight p-3">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrp_per_adult" class="mb-3">Minimum Advance Payment</label>
                                                                            </div>
                                                                            <div class="input-group mb-3 inputWidth">
                                                                                <input type="text" class="form-control" id="bookingPercentage" name="bookingPercentage" placeholder="30">
                                                                                <span class="input-group-text">%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrp_per_child" class="mb-0">Full Payment Before Travel</label>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="text" class="form-control" id="bookingDay" name="bookingDay" placeholder="3">
                                                                                <span class="input-group-text">Days</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <h5 class="mb-3 fw-bolder" id="#">Other Policies</h5>
                                                            <div class="borderHighlight p-3 mb-3">
                                                                <div class="container">
                                                                    <p class="upload-description">
                                                                        Upload brochures, itinerary PDFs or any other important documents for reference.
                                                                    </p>
                                                                    <div class="upload-wrapper">
                                                                        <table class="table upload-table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Title</th>
                                                                                    <th>File Name</th>
                                                                                    <th>Type</th>
                                                                                    <th>Size</th>
                                                                                    <th>Uploaded On</th>
                                                                                    <th class="text-center">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="fileTableBody">
                                                                                <tr>
                                                                                    <td>Thailand</td>
                                                                                    <td>
                                                                                        <div class="file-info">
                                                                                            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="file-icon">
                                                                                            Thailand_Brochure.pdf
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>Brochure</td>
                                                                                    <td>2.45 MB</td>
                                                                                    <td>27 May 2025</td>
                                                                                    <td class="text-center">
                                                                                        <i class="fa-solid fa-download action-btn me-3"></i>
                                                                                        <i class="fa-regular fa-trash-can action-btn delete-btn"></i>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Detailed</td>
                                                                                    <td>
                                                                                        <div class="file-info">
                                                                                            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="file-icon">
                                                                                            Detailed_Itinerary.pdf
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>Itinerary</td>
                                                                                    <td>1.85 MB</td>
                                                                                    <td>27 May 2025</td>
                                                                                    <td class="text-center">
                                                                                        <i class="fa-solid fa-download action-btn me-3"></i>
                                                                                        <i class="fa-regular fa-trash-can action-btn delete-btn"></i>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <!-- Upload Area -->
                                                                        <div class="upload-form-row">
                                                                            <input type="text" class="form-control" id="documentTitle" placeholder="Enter Title">
                                                                            <div class="mini-drop-zone" id="dropZone">
                                                                                <i class="fa-solid fa-cloud-arrow-up me-2"></i>
                                                                                <span id="selectedFileText">Drag & Drop or Click to Upload</span>
                                                                                <input type="file" id="fileInput" class="hidden-input" accept=".pdf,.doc,.docx">
                                                                            </div>
                                                                            <button type="button" class="btn btn-primary px-4" id="addDocumentBtn">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_policy_nextBtn">
                                                            <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Sixth Box Package Picture  -->
                                                <div id="package_form_picture" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="borderHighlight p-3 mt-3">
                                                                <h4 class="fw-bolder">1. Package Cover Image</h4>
                                                                <p>This image will be shown as the main thumbnail for the packages across website, app and listings.</p>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="image-preview-wrapper">
                                                                            <img src="https://placehold.co/600x300?text=No+Image" alt="Package Cover" class="packageCoverImage" id="packageCoverImage">
                                                                            <button type="button" class="delete-image-btn" id="deleteImageBtn">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="large-drop-zone" id="dragDropZone">
                                                                            <p><i class="fa-solid fa-cloud-arrow-up fa-xl"></i></p>
                                                                            <p>
                                                                                <span id="selectedFileText">
                                                                                    Drag & Drop image here or Click to browse
                                                                                </span>
                                                                            </p>
                                                                            <p class="my-3 text-center">
                                                                                Recommended Size:1600 x 900px <br>
                                                                                Max Size: 5MB | Format: JPG, PNG, WEBP
                                                                            </p>
                                                                        </div>
                                                                        <input type="file" id="imageUpload" accept="image/png,image/jpeg,image/jpg,image/webp" hidden>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="borderHighlight p-3 mt-3">
                                                                <h4 class="fw-bolder">2. Image Gallery</h4>
                                                                <p>Upload multiple images to highlight attractions, hotels, activities and experiences.</p>
                                                                <!-- Gallery Preview -->
                                                                <div class="row" id="galleryContainer"></div>
                                                                <!-- Upload Area -->
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="small-drop-zone" id="imageGalleryZone">
                                                                            <div>
                                                                                <i class="fa-solid fa-cloud-arrow-up me-2"></i>
                                                                                <span id="galleryText">
                                                                                    Drag & Drop multiple images here or Click to Upload
                                                                                </span>
                                                                            </div>
                                                                            <p class="mb-0 text-muted">
                                                                                You can upload up to 18 images | Max Size: 5MB each | Format: JPG, PNG, WEBP
                                                                            </p>
                                                                            <div id="galleryMessage" class="text-danger mt-2 fw-semibold"></div>
                                                                            <input type="file" id="galleryInput" accept="image/jpeg,image/png,image/webp" multiple hidden>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="borderHighlight p-3 mt-3">
                                                                <h4 class="fw-bolder">3. Video</h4>
                                                                <p>Upload a promotional video to give users a better preview of the destination and package.</p>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="video-preview-wrapper">
                                                                            <div class="video-input-group">
                                                                                <input type="text"
                                                                                    class="video-link-input"
                                                                                    id="videoLinkInput"
                                                                                    placeholder="Paste YouTube or Vimeo link here">

                                                                                <button type="button" class="preview-btn" id="addVideoBtn">
                                                                                    Preview Video
                                                                                </button>
                                                                            </div>

                                                                            <div class="video-example">
                                                                                <i class="ri-play-line"></i>
                                                                                Example: https://www.youtube.com/watch?v=xxxxxxxx
                                                                                or https://vimeo.com/xxxxxxxx
                                                                            </div>

                                                                            <div id="videoPreviewList"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" >
                                                            <a href="#" id="update_form" class="waves-effect waves-light btn-large" style=" color: white;">Submit</a>
                                                            <a href="#" id="update_form" style="display:none"></a>
                                                        </div>
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
                <?php include_once "../footer.php" ?>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            // delete images
            function deleteImageFunction(e, id){
                e.preventDefault();
                // console.log(id);
                var r = confirm("Do you want to delete this image ?");
                if (r == true) {
                    $.ajax({
                    type: "POST",
                    url: "forms/deleteImages",
                    data: 'id='+id,
                    cache: false,
                        success:function(data){
                            if(data == "success"){
                                document.getElementById("image_"+id).style.display = "none";
                                alert("Deleted Succesfully");
                            }else{
                                alert("Failed to Delete");
                            }
                        }
                    }); 
                }            
            }
        </script>
        <!-- <script>
                $(document).ready(function(){
                    $("#user_table").DataTable();
                });
            </script> -->
        <script>
            $(document).ready(function () {

                const sections = [
                    "#package_form_general",
                    "#package_form_extra",
                    "#package_form_itinerary",
                    "#package_form_pricing",
                    "#package_form_policy",
                    "#package_form_picture"
                ];

                const pageData = {
                    "#package_form_general": {
                        title: "Add New Package - General Information",
                        backText: "Return to Package Listing",
                        backLink: "all_packages.php"
                    },
                    "#package_form_extra": {
                        title: "Add New Package - Extra Information",
                        backText: "Return to General Information",
                        backLink: "#package_form_general"
                    },
                    "#package_form_itinerary": {
                        title: "Add New Package - Itinerary & Inclusions",
                        backText: "Return to Extra Information",
                        backLink: "#package_form_extra"
                    },
                    "#package_form_pricing": {
                        title: "Add New Package - Pricing",
                        backText: "Return to Itinerary & Inclusions",
                        backLink: "#package_form_itinerary"
                    },
                    "#package_form_policy": {
                        title: "Add New Package - Policy",
                        backText: "Return to Pricing",
                        backLink: "#package_form_pricing"
                    },
                    "#package_form_picture": {
                        title: "Add New Package - Pictures & Media",
                        backText: "Return to Policy",
                        backLink: "#package_form_policy"
                    }
                };

                function showSection(target) {

                    // Hide all sections
                    sections.forEach(function (section) {
                        $(section).hide();
                    });

                    // Show selected section
                    $(target).show();

                    // Update active step
                    $(".step-link").removeClass("active");
                    $(".roundedCircle").removeClass("active");

                    $('.step-link[href="' + target + '"]').addClass("active");
                    $('.step-link[href="' + target + '"] .roundedCircle').addClass("active");

                    // Update page title
                    $("#pageTitle").text(pageData[target].title);

                    // Update return text
                    $("#pageSubTitle").text(pageData[target].backText);

                    // Update back button target
                    $("#dynamicBackBtn").attr("data-target", pageData[target].backLink);
                }

                // Initial load
                showSection("#package_form_general");

                // Stepper navigation click
                $(".step-link").on("click", function (e) {
                    e.preventDefault();

                    let target = $(this).attr("href");
                    showSection(target);
                });

                // Back button click
                $("#dynamicBackBtn").on("click", function (e) {
                    e.preventDefault();

                    let target = $(this).attr("data-target");

                    if (target === "all_packages.php") {
                        window.location.href = target;
                        return;
                    }

                    showSection(target);
                });

                // Next buttons
                $("#package_form_general_nextBtn").on("click", function (e) {
                    e.preventDefault();
                    showSection("#package_form_extra");
                });

                $("#package_form_extra_nextBtn").on("click", function (e) {
                    e.preventDefault();
                    showSection("#package_form_itinerary");
                });

                $("#package_form_itinerary_nxtBtn").on("click", function (e) {
                    e.preventDefault();
                    showSection("#package_form_pricing");
                });

                $("#package_form_pricing_nextBtn").on("click", function (e) {
                    e.preventDefault();
                    showSection("#package_form_policy");
                });

                $("#package_form_policy_nextBtn").on("click", function (e) {
                    e.preventDefault();
                    showSection("#package_form_picture");
                });

            });
        </script>
        <script>
            // Remove Tag
            document.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-btn")) {
                    e.target.parentElement.remove();
                }
            });

            // Add New Highlight
            document.getElementById("addHighlightBtn").addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Add City",
                    input: "text",
                    inputPlaceholder: "Enter City",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    inputValidator: (value) => {
                        value = value.trim();

                        if (!value) {
                            return "Please enter a City Name.";
                        }

                        if (!/^[a-zA-Z0-9\s_-]+$/.test(value)) {
                            return "Only alphabets, numbers, spaces, hyphens (-), and underscores (_) are allowed.";
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let highlight = result.value.trim();

                        let tag = document.createElement("div");
                        tag.className = "highlight-tag";

                        tag.innerHTML = `
                            ${highlight}
                            <span class="remove-btn">&times;</span>
                        `;

                        document.getElementById("highlightContainer").appendChild(tag);
                    }
                });
            });
            // Add New Package Keyword
            document.getElementById("addPackageKeywordBtn").addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Add Package keyword",
                    input: "text",
                    inputPlaceholder: "Enter Package keyword",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    inputValidator: (value) => {
                        value = value.trim();

                        if (!value) {
                            return "Please enter a Package keyword Name.";
                        }

                        if (!/^[a-zA-Z0-9\s_-]+$/.test(value)) {
                            return "Only alphabets, numbers, spaces, hyphens (-), and underscores (_) are allowed.";
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let highlight = result.value.trim();

                        let tag = document.createElement("div");
                        tag.className = "highlight-tag";

                        tag.innerHTML = `
                            ${highlight}
                            <span class="remove-btn">&times;</span>
                        `;

                        document.getElementById("packageKeybord").appendChild(tag);
                    }
                });
            });
        </script>
        <!-- Upload Icons Section -->
        <script>
            document.addEventListener('change', function (e) {

                if (!e.target.classList.contains('file-input')) return;

                const file = e.target.files[0];
                if (!file) return;

                const card = e.target.closest('.upload-card');
                const title = card.dataset.title;
                const index = card.dataset.index;

                if (file.type.startsWith('image/')) {

                    const reader = new FileReader();

                    reader.onload = function (event) {

                        if (card.classList.contains('icon-upload-card')) {

                            const iconBox = card.querySelector('.upload-icon');

                            iconBox.innerHTML = `
                                <img src="${event.target.result}" alt="Icon">
                            `;

                            const hiddenInput = document.getElementById(`img_path${index}`);

                            if (hiddenInput) {
                                hiddenInput.value = `../../uploading/${file.name}`;
                            }

                        } else {

                            card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();
                            const preview = document.createElement('div');
                            preview.className = 'preview-wrapper';

                            preview.innerHTML = `
                                <img src="${event.target.result}">
                                <div class="file-title">${title}</div>
                            `;
                            card.appendChild(preview);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <!-- Inclusion, Exclution, Remark & Things Section -->
        <script>
            $(document).ready(function () {

                function addItem(listId, itemClass, textClass, editClass, deleteClass, label) {

                    // let text = prompt(`Enter ${label}`);

                    // if (text && text.trim() !== "") {

                    //     $(listId).append(`
                    //         <div class="${itemClass} d-flex justify-content-between align-items-start mb-2">
                    //             <p class="mb-0 ${textClass}">${text}</p>

                    //             <div class="d-flex gap-3">
                    //                 <a href="#" class="${editClass} text-primary">
                    //                     <i class="fa-solid fa-pencil"></i>
                    //                 </a>

                    //                 <a href="#" class="${deleteClass} text-danger">
                    //                     <i class="fa-solid fa-trash-can"></i>
                    //                 </a>
                    //             </div>
                    //         </div>
                    //     `);
                    // }
                    Swal.fire({
                        title: `Enter ${label}`,
                        input: "textarea",
                        inputPlaceholder: `Enter ${label}`,
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: "OK",
                        cancelButtonText: "Cancel",
                        inputValidator: (value) => {
                            value = value.trim();

                            if (!value) {
                                return `Please enter ${label}.`;
                            }

                            if (!/^[a-zA-Z0-9\s_-]+$/.test(value)) {
                                return "Only alphabets, numbers, spaces, hyphens (-), and underscores (_) are allowed.";
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            let text = result.value.trim();

                            $(listId).append(`
                                <div class="${itemClass} d-flex justify-content-between align-items-start mb-2">
                                    <p class="mb-0 ${textClass}">${text}</p>

                                    <div class="d-flex gap-3">
                                        <a href="#" class="${editClass} text-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        <a href="#" class="${deleteClass} text-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </div>
                            `);
                        }
                    });
                }

                // ====================
                // Add Buttons
                // ====================

                $("#addInclusionBtn").click(function (e) {
                    e.preventDefault();

                    addItem(
                        "#inclusionList",
                        "inclusion-item",
                        "inclusion-text",
                        "edit-inclusion",
                        "delete-inclusion",
                        "Inclusion Item"
                    );
                });

                $("#addExclutionBtn").click(function (e) {
                    e.preventDefault();

                    addItem(
                        "#exclusionList",
                        "exclusion-item",
                        "exclusion-text",
                        "edit-exclusion",
                        "delete-exclusion",
                        "Exclusion Item"
                    );
                });

                $("#addRemarkBtn").click(function (e) {
                    e.preventDefault();

                    addItem(
                        "#remarkList",
                        "remark-item",
                        "remark-text",
                        "edit-remark",
                        "delete-remark",
                        "Remark"
                    );
                });

                $("#hightlightBtn").click(function (e) {
                    e.preventDefault();

                    addItem(
                        "#hightlightList",
                        "remark-item",
                        "remark-text",
                        "edit-remark",
                        "delete-remark",
                        "Highlights"
                    );
                });

                $("#addThingsBtn").click(function (e) {
                    e.preventDefault();

                    addItem(
                        "#thingsList",
                        "things-item",
                        "things-text",
                        "edit-things",
                        "delete-things",
                        "Thing to Know"
                    );
                });

                // ====================
                // Edit
                // ====================

                
                $(document).on(
                    "click",
                    ".edit-inclusion, .edit-exclusion, .edit-remark, .edit-things",
                    function (e) {

                        e.preventDefault();

                        let textElement = $(this)
                            .closest("[class*='item']")
                            .find("p");

                        let currentText = textElement.text();

                        Swal.fire({
                            title: "Edit Item",
                            input: "textarea",
                            inputValue: currentText,
                            inputPlaceholder: "Enter item",
                            showCancelButton: true,
                            showCloseButton: true,
                            confirmButtonText: "Update",
                            cancelButtonText: "Cancel",
                            inputValidator: (value) => {
                                value = value.trim();

                                if (!value) {
                                    return "Please enter a value.";
                                }

                                if (!/^[a-zA-Z0-9\s_-]+$/.test(value)) {
                                    return "Only alphabets, numbers, spaces, hyphens (-), and underscores (_) are allowed.";
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                textElement.text(result.value.trim());
                            }
                        });
                    }
                );

                // ====================
                // Delete
                // ====================

                
                $(document).on(
                    "click",
                    ".delete-inclusion, .delete-exclusion, .delete-remark, .delete-things",
                    function (e) {

                        e.preventDefault();

                        const item = $(this).closest("[class*='item']");

                        Swal.fire({
                            title: "Delete Item?",
                            text: "This action cannot be undone.",
                            icon: "warning",
                            showCancelButton: true,
                            showCloseButton: true,
                            confirmButtonText: "Delete",
                            cancelButtonText: "Cancel",
                            confirmButtonColor: "#d33"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                item.remove();

                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: "Item has been deleted.",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                );
            });
        </script>
        <!-- Price Visibility & Guest User Premium -->
        <script>
            $(document).ready(function () {

                function updateSection() {

                    if ($("#switchCheckGuestUser").is(":checked")) {

                        // Enable radios
                        $("#radioDefault1, #radioDefault2").prop("disabled", false);

                    } else {

                        // Disable radios and inputs
                        $("#radioDefault1, #radioDefault2")
                            .prop("disabled", true)
                            .prop("checked", false);

                        $("#fixedAmount, #percentage")
                            .prop("disabled", true)
                            .val("");
                    }
                }

                // Switch
                $("#switchCheckGuestUser").on("change", function () {
                    updateSection();
                });

                // Fixed Amount Radio
                $("#radioDefault1").on("change", function () {
                    if ($(this).is(":checked")) {
                        $("#fixedAmount").prop("disabled", false);
                        $("#percentage").prop("disabled", true).val("");
                    }
                });

                // Percentage Radio
                $("#radioDefault2").on("change", function () {
                    if ($(this).is(":checked")) {
                        $("#percentage").prop("disabled", false);
                        $("#fixedAmount").prop("disabled", true).val("");
                    }
                });

                // Initial state
                $("#radioDefault1, #radioDefault2").prop("disabled", true);
                $("#fixedAmount, #percentage").prop("disabled", true);

            });
        </script>
        <!-- Policy section -->
        <script>
            const dropZone = document.getElementById("dropZone");
            const fileInput = document.getElementById("fileInput");
            const selectedFileText = document.getElementById("selectedFileText");
            const addDocumentBtn = document.getElementById("addDocumentBtn");

            let selectedFile = null;

            // Open file picker
            dropZone.addEventListener("click", () => {
                fileInput.click();
            });

            // File selection
            fileInput.addEventListener("change", function () {
                selectedFile = this.files[0];

                if(selectedFile){
                    selectedFileText.textContent = selectedFile.name;
                }
            });

            // Drag Over
            dropZone.addEventListener("dragover", function(e){
                e.preventDefault();
                dropZone.classList.add("dragover");
            });

            // Drag Leave
            dropZone.addEventListener("dragleave", function(){
                dropZone.classList.remove("dragover");
            });

            // Drop
            dropZone.addEventListener("drop", function(e){
                e.preventDefault();

                dropZone.classList.remove("dragover");

                selectedFile = e.dataTransfer.files[0];

                if(selectedFile){
                    selectedFileText.textContent = selectedFile.name;
                }
            });

            // Submit
            addDocumentBtn.addEventListener("click", function(){

                let title = document.getElementById("documentTitle").value.trim();

                if(title === ""){
                    alert("Please enter title");
                    return;
                }

                if(!selectedFile){
                    alert("Please select a file");
                    return;
                }

                let size = (selectedFile.size / (1024 * 1024)).toFixed(2) + " MB";

                let fileType = selectedFile.name.split('.').pop().toUpperCase();

                let today = new Date().toLocaleDateString("en-GB", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric"
                });

                let row = `
                    <tr>
                        <td>${title}</td>

                        <td>
                            <div class="file-info">
                                <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png"
                                    class="file-icon">
                                ${selectedFile.name}
                            </div>
                        </td>

                        <td>${fileType}</td>

                        <td>${size}</td>

                        <td>${today}</td>

                        <td class="text-center">
                            <i class="fa-solid fa-download action-btn me-3"></i>
                            <i class="fa-regular fa-trash-can action-btn delete-btn remove-file"></i>
                        </td>
                    </tr>
                `;

                document
                    .getElementById("fileTableBody")
                    .insertAdjacentHTML("beforeend", row);

                // Reset
                document.getElementById("documentTitle").value = "";
                fileInput.value = "";
                selectedFile = null;
                selectedFileText.textContent = "Drag & Drop or Click to Upload";
            });

            // Delete row
            $(document).on("click", ".remove-file", function(){
                $(this).closest("tr").remove();
            });
        </script>
        <!-- Picture & Media Section -->
        <!-- Package Cover Image -->
        <script>
            $(document).ready(function () {

                const dropZone = $("#dragDropZone");
                const fileInput = $("#imageUpload");
                const previewImage = $("#packageCoverImage");
                const deleteBtn = $("#deleteImageBtn");
                const fileText = $("#selectedFileText");

                // Click Drop Zone
                dropZone.on("click", function () {
                    fileInput.trigger("click");
                });

                // File Selection
                fileInput.on("change", function () {
                    if (this.files.length) {
                        previewFile(this.files[0]);
                    }
                });

                // Drag Events
                dropZone.on("dragover", function (e) {
                    e.preventDefault();
                    $(this).addClass("dragover");
                });

                dropZone.on("dragleave", function () {
                    $(this).removeClass("dragover");
                });

                dropZone.on("drop", function (e) {
                    e.preventDefault();
                    $(this).removeClass("dragover");

                    const files = e.originalEvent.dataTransfer.files;

                    if (files.length) {
                        fileInput[0].files = files;
                        previewFile(files[0]);
                    }
                });

                function previewFile(file) {

                    const validTypes = [
                        "image/jpeg",
                        "image/jpg",
                        "image/png",
                        "image/webp"
                    ];

                    if (!validTypes.includes(file.type)) {
                        alert("Please upload JPG, PNG or WEBP image.");
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        alert("Maximum file size is 5MB.");
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImage.attr("src", e.target.result);
                        deleteBtn.css("display", "flex");
                        fileText.text(file.name);
                    };

                    reader.readAsDataURL(file);
                }

                // Delete Image
                deleteBtn.on("click", function () {
                    previewImage.attr(
                        "src",
                        "https://placehold.co/600x300?text=No+Image"
                    );

                    fileInput.val("");
                    fileText.text("Drag & Drop image here or Click to browse");
                    $(this).hide();
                });

            });
        </script>
        <!-- Image Gallery  -->
        <script>
            $(document).ready(function () {

                const maxImages = 18;
                let galleryImages = [];

                // Click Upload Area
                $(document).on("click", "#imageGalleryZone", function (e) {

                    if ($(e.target).closest(".delete-image").length) {
                        return;
                    }

                    const input = document.getElementById("galleryInput");

                    if (!input) {
                        console.error("galleryInput not found");
                        return;
                    }

                    try {
                        if (typeof input.showPicker === "function") {
                            input.showPicker();
                        } else {
                            input.click();
                        }
                    } catch (err) {
                        input.click();
                    }
                });

                // File Selection
                $(document).on("change", "#galleryInput", function () {

                    const files = this.files;

                    if (files && files.length) {
                        handleFiles(files);
                    }

                    $(this).val("");
                });

                // Drag Over
                $(document).on("dragover", "#imageGalleryZone", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass("dragover");
                });

                // Drag Leave
                $(document).on("dragleave", "#imageGalleryZone", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass("dragover");
                });

                // Drop Files
                $(document).on("drop", "#imageGalleryZone", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    $(this).removeClass("dragover");

                    const files = e.originalEvent.dataTransfer.files;

                    if (files && files.length) {
                        handleFiles(files);
                    }
                });

                function handleFiles(files) {

                    const remainingSlots = maxImages - galleryImages.length;

                    if (remainingSlots <= 0) {

                        $("#galleryMessage")
                            .removeClass("text-muted text-warning")
                            .addClass("text-danger")
                            .html("Maximum limit of 18 images reached.");

                        return;
                    }

                    if (files.length > remainingSlots) {

                        $("#galleryMessage")
                            .removeClass("text-muted text-danger")
                            .addClass("text-warning")
                            .html(`Only ${remainingSlots} image(s) can be uploaded.`);
                    }

                    Array.from(files)
                        .slice(0, remainingSlots)
                        .forEach(function (file) {

                            const validTypes = [
                                "image/jpeg",
                                "image/png",
                                "image/webp"
                            ];

                            if (!validTypes.includes(file.type)) {
                                return;
                            }

                            if (file.size > 5 * 1024 * 1024) {
                                return;
                            }

                            const reader = new FileReader();

                            reader.onload = function (e) {

                                galleryImages.push({
                                    id: Date.now() + Math.random(),
                                    src: e.target.result
                                });

                                renderGallery();
                            };

                            reader.readAsDataURL(file);
                        });
                }

                function toggleUploadZone() {

                    if (galleryImages.length >= maxImages) {

                        $("#imageGalleryZone").hide();

                        $("#galleryMessage")
                            .removeClass("text-muted text-warning")
                            .addClass("text-danger")
                            .html("Maximum limit of 18 images reached. Delete an image to upload more.");

                    } else {

                        $("#imageGalleryZone").show();

                        $("#galleryMessage")
                            .removeClass("text-danger text-warning")
                            .addClass("text-muted")
                            .html(`${galleryImages.length}/${maxImages} images uploaded`);
                    }
                }

                function renderGallery() {

                    let html = '';
                    const totalImages = galleryImages.length;

                    galleryImages.forEach(function (image) {

                        let colClass = "col-lg-2 col-md-3 col-sm-4 col-6";

                        if (totalImages <= 6) {

                            switch (totalImages) {
                                case 1:
                                    colClass = "col-12";
                                    break;
                                case 2:
                                    colClass = "col-6";
                                    break;
                                case 3:
                                    colClass = "col-4";
                                    break;
                                case 4:
                                    colClass = "col-3";
                                    break;
                                case 5:
                                    colClass = "custom-col-5";
                                    break;
                                case 6:
                                    colClass = "col-2";
                                    break;
                            }
                        }

                        html += `
                            <div class="${colClass} mb-1">
                                <div class="gallery-item position-relative">
                                    <img src="${image.src}" class="w-100" alt="Gallery Image">

                                    <button type="button"
                                            class="gallery-delete delete-image"
                                            data-id="${image.id}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });

                    $("#galleryContainer").html(html);

                    toggleUploadZone();
                }

                // Delete Image
                $(document).on("click", ".delete-image", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    const imageId = $(this).data("id");

                    galleryImages = galleryImages.filter(function (image) {
                        return image.id !== imageId;
                    });

                    renderGallery();
                });

                toggleUploadZone();

            });
        </script>
        <!-- Video -->
        <script>
            $(document).ready(function () {

                // Hide example if videos already exist
                if ($("#videoPreviewList .video-preview-item").length > 0) {
                    $(".video-example").hide();
                }

                function addVideoLink() {

                    let videoUrl = $("#videoLinkInput").val().trim();

                    if (!videoUrl) {
                        alert("Please enter a video link");
                        return;
                    }

                    // Optional: Validate YouTube/Vimeo URL
                    const validVideoUrl =
                        videoUrl.includes("youtube.com") ||
                        videoUrl.includes("youtu.be") ||
                        videoUrl.includes("vimeo.com");

                    if (!validVideoUrl) {
                        alert("Please enter a valid YouTube or Vimeo link.");
                        return;
                    }

                    // Prevent duplicates
                    let exists = false;

                    $(".video-url").each(function () {
                        if ($(this).text().trim() === videoUrl) {
                            exists = true;
                            return false;
                        }
                    });

                    if (exists) {
                        alert("This video link already exists.");
                        return;
                    }

                    let videoItem = `
                        <div class="video-preview-item">
                            <div class="video-link-content">
                                <i class="fa-solid fa-play play-video"
                                data-url="${videoUrl}"
                                title="Play Video"></i>

                                <span class="video-url">${videoUrl}</span>
                            </div>

                            <i class="fa-solid fa-trash-can delete-video"
                            title="Delete"></i>
                        </div>
                    `;

                    $("#videoPreviewList").append(videoItem);

                    $(".video-example").hide();

                    $("#videoLinkInput").val("").focus();
                }

                // Button Click
                $("#addVideoBtn").on("click", function () {
                    addVideoLink();
                });

                // Enter Key
                $("#videoLinkInput").on("keypress", function (e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        addVideoLink();
                    }
                });

                // Play Video
                $(document).on("click", ".play-video", function () {
                    window.open($(this).data("url"), "_blank");
                });

                // Delete Video
                $(document).on("click", ".delete-video", function () {

                    $(this).closest(".video-preview-item").remove();

                    if ($("#videoPreviewList .video-preview-item").length === 0) {
                        $(".video-example").show();
                    }
                });

            });
        </script>
        <!-- package markup editable / save -->
        <script>
            function formatCurrency(amount) {
                return "₹" + Number(amount).toLocaleString("en-IN");
            }
            //edit
            $(document).on("click", ".edit-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const comm = row.find(".editable-comm");
                const ins = row.find(".editable-ins");
                console.log(comm);
                
                comm.data("old", comm.data("value"));
                ins.data("old", ins.data("value"));

                comm.html(`
                    <input type="number"
                        class="form-control form-control-sm comm-input"
                        value="${comm.data("value")}">
                `);

                ins.html(`
                    <input type="number"
                        class="form-control form-control-sm ins-input"
                        value="${ins.data("value")}">
                `);

                row.find("td:last").html(`
                    <div class="d-flex gap-3">
                        <a href="#" class="save-price-distribution text-success">
                            <i class="fa-solid fa-circle-check"></i>
                        </a>

                        <a href="#" class="cancel-price-distribution text-danger">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </a>
                    </div>
                `);

            });

            //save
            $(document).on("click", ".save-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");
                const totalCell = row.find(".editable-total");

                const oldComm = Number(commCell.data("old"));
                const oldIns = Number(insCell.data("old"));

                const newComm = Number(row.find(".comm-input").val());
                const newIns = Number(row.find(".ins-input").val());

                commCell.data("value", newComm);
                insCell.data("value", newIns);

                commCell.html(`
                    <div>${formatCurrency(newComm)}</div>
                    <small class="text-danger text-decoration-line-through">
                        ${formatCurrency(oldComm)}
                    </small>
                `);

                insCell.html(`
                    <div>${formatCurrency(newIns)}</div>
                    <small class="text-danger text-decoration-line-through">
                        ${formatCurrency(oldIns)}
                    </small>
                `);

                totalCell.html(formatCurrency(newComm + newIns));

                row.find("td:last").html(`
                    <div class="d-flex gap-3">
                        <a href="#" class="edit-price-distribution text-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>

                        <a href="#" class="reset-price-distribution text-warning">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                `);

            });

            //cancel
            $(document).on("click", ".cancel-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");

                commCell.html(formatCurrency(commCell.data("old")));
                insCell.html(formatCurrency(insCell.data("old")));

                row.find("td:last").html(`
                    <div class="d-flex gap-3">
                        <a href="#" class="edit-price-distribution text-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                `);

            });

            //reset
            $(document).on("click", ".reset-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");
                const totalCell = row.find(".editable-total");

                const oldComm = Number(commCell.data("old"));
                const oldIns = Number(insCell.data("old"));

                commCell.data("value", oldComm);
                insCell.data("value", oldIns);

                commCell.html(formatCurrency(oldComm));
                insCell.html(formatCurrency(oldIns));
                totalCell.html(formatCurrency(oldComm + oldIns));

                row.find("td:last").html(`
                    <div class="d-flex gap-3">
                        <a href="#" class="edit-price-distribution text-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                `);

            });
        </script>
    </body>
</html>