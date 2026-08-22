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
    $product_payout_data = [];

    while ($row = $data7->fetch(PDO::FETCH_ASSOC)) {
        $product_payout_data[$row['role']] = $row;
    }

    //product payout commission new added on 09 may 2026
    $data8 = $conn->prepare("
        SELECT *
        FROM product_commission_te_chain
        WHERE status = 1
    ");
    $data8->execute();

    $product_payout_data_new = [];

    while ($row = $data8->fetch(PDO::FETCH_ASSOC)) {
        $product_payout_data_new[$row['role']] = $row;
    }

    //product payout commission new added on 12 may 2026
    $data9 = $conn->prepare("
        SELECT *
        FROM product_commission_institution
        WHERE status = 1
    ");
    $data9->execute();

    $institutionData = [];  

    while ($row = $data9->fetch(PDO::FETCH_ASSOC)) {
        $institutionData['roles'][$row['role']] = [
            'overall_percentage' => $row['overall_percentage'],
            'comm_percentage'    => $row['comm_percentage'],
            'ins_percentage'     => $row['ins_percentage']
        ];
    }
    //product payout commission cte cheian
    $data11 = $conn->prepare("SELECT * FROM `product_commission_cte_ins` WHERE status = 1");
    $data11->execute();

    $institutionCteData = [];

    while ($row = $data11->fetch(PDO::FETCH_ASSOC)) {
        $institutionCteData['roles'][$row['role']] = [
            'overall_percentage' => $row['overall_percentage'],
            'comm_percentage'    => $row['comm_percentage'],
            'ins_percentage'     => $row['ins_percentage']
        ];
    }

    //=====================================
    // Institution Slabs
    //=====================================

    $data10 = $conn->prepare("
        SELECT
            institution_commission,
            lower_limit,
            upper_limit
        FROM institution_slab
        WHERE status = 1
        ORDER BY lower_limit
    ");
    $data10->execute();

    $slabs = $data10->fetchAll(PDO::FETCH_ASSOC);

    $institutionData['slabs'] = $slabs;
    $institutionCteData['slabs'] = $slabs;

    //cutomer commission 
    $l2_per=$l3_per=50;
    $stmt = $conn->prepare("
        SELECT gst
        FROM gst
        ORDER BY id DESC
        LIMIT 1
    ");

    $stmt->execute();

    $gst = $stmt->fetch(PDO::FETCH_ASSOC);

    $gstValue = $gst['gst'] ?? 0;
    require __DIR__ . '/forms/edit_package_load.php';
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
        <!-- Packages CSS -->
        <link href="../assets/css/packages.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/validation.css">
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
                                                Edit Package - General Information
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
                                                                <input type="text" class="form-control" id="packName" name="packName" placeholder="Package Name" value="<?= $package['name'] ?>">
                                                                <label for="name" class="required">Package Name</label>
                                                                <small class="error-message" id="packName_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" class="form-control" id="uniqueCode" name="uniqueCode" placeholder="Unique Code" value="<?= $package['unique_code'] ?>">
                                                                <label for="unique_code" class="required">Unique Code</label>
                                                                <small class="error-message" id="uniqueCode_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <select class="form-select"
                                                                    id="categoryId"
                                                                    name="categoryId"
                                                                    aria-label="Floating label select example"
                                                                    onchange="getSubCategories()">

                                                                <option value="">--Select Category--</option>

                                                                <?php
                                                                $cat_data = $conn->prepare("SELECT * FROM category WHERE status='1'");
                                                                $cat_data->execute();
                                                                $categories = $cat_data->fetchAll(PDO::FETCH_ASSOC);

                                                                if (!empty($categories)) {
                                                                    foreach ($categories as $row) {
                                                                        $selected = ($row['id'] == $package['category_id']) ? 'selected' : '';
                                                                        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="">No Category Available</option>';
                                                                }
                                                                ?>

                                                            </select>
                                                                <small class="error-message" id="categoryId_error"></small>
                                                                <label>Select Category Type <span class="required"></span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-floating my-3">
                                                                <select id="subCategoryId" name="subCategoryId" class="form-select">
                                                                    <option value="">--Select Category First--</option>
                                                                </select>
                                                                <small class="error-message" id="subCategoryId_error"></small>
                                                                <label class="required">Select Sub-Category Type <span class="required"></span></label>
                                                            </div>
                                                            <select id="subCategoryData" name="subCategoryData" class="form-select" style="display: none"></select>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 mb-3">
                                                            <div class="borderHighlight px-3 py-2 travelTheme-wrapper" id="travelTheme_wrapper">
                                                                <label>Travel Theme / Type <span class="required"></span></label>
                                                                <div class="d-flex gap-4">
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option1" autocomplete="off" value="Leisure" <?= $package['package_type'] === "Leisure"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option1">
                                                                            <i class="fa-solid fa-mountain-city"></i>
                                                                            Leisure
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option2" autocomplete="off" value="Adventure" <?= $package['package_type'] === "Adventure"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option2">
                                                                            <i class="fa-solid fa-mountain-sun"></i>
                                                                            Adventure
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option3" autocomplete="off" value="Spiritual" <?= $package['package_type'] === "Spiritual"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option3">
                                                                            <i class="fa-solid fa-place-of-worship"></i>
                                                                            Spiritual
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option4" autocomplete="off" value="Beach" <?= $package['package_type'] === "Beach"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option4">
                                                                            <i class="fa-solid fa-umbrella-beach"></i>
                                                                            Beach
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option5" autocomplete="off" value="Honeymoon" <?= $package['package_type'] === "Honeymoon"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option5">
                                                                            <i class="fa-solid fa-heart"></i>
                                                                            Honeymoon
                                                                        </label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="btn-check travelTheme" name="travelTheme" id="option6" autocomplete="off" value="Other" <?= $package['package_type'] === "Other"?'checked':'' ?>>
                                                                        <label class="btn fw-bold" for="option6">
                                                                            <i class="fa-solid fa-crosshairs"></i>
                                                                            Other</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="travelTheme_error"></small>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control" id="tourDays" name="tourDays" placeholder="Unique Code" value="<?= $package['tour_days'] ?>">
                                                                        <label for="tourDays" class="required">Tour Days</label>
                                                                        <small class="error-message" id="tourDays_error"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="date" class="form-control" id="pacValidity" name="pacValidity" placeholder="Package Validity" value="<?= $package['validity']?>">
                                                                        <label for="pacValidity" class="required">Validity Upto</label>
                                                                        <small class="error-message" id="pacValidity_error"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="season" name="season" placeholder="Unique Code" value="<?= $package['best_season'] ?>">
                                                                        <label for="season">Best Season To Visit</label>
                                                                        <small class="error-message" id="season_error"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="pacLocation" name="pacLocation" placeholder="Unique Code" value="<?= $package['location'] ?>">
                                                                        <label for="pacLocation" class="required">Location</label>
                                                                        <small class="error-message" id="pacLocation_error"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="highlights-section p-3 highlightContainer-wrapper" id="highlightContainer_wrapper">
                                                            <label class="highlight-label required">Cities</label>
                                                            <div class="highlight-container" id="highlightContainer">
                                                                <?php
                                                                if (!empty($package['cities'])) {
                                                                    $cities = json_decode($package['cities'], true);
                                                                    // print_r($cities);
                                                                    if (is_array($cities)) {
                                                                        foreach ($cities as $city) {
                                                                            ?>
                                                                            <div class="highlight-tag" data-city="<?= htmlspecialchars($city) ?>">
                                                                                <span class="city-name"><?= htmlspecialchars($city) ?></span>
                                                                                <span class="remove-btn">&times;</span>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            
                                                            <div class="add-highlight">
                                                                <a href="#" id="addHighlightBtn">+ Add Cities</a>
                                                            </div>
                                                        </div>
                                                        <small class="error-message" id="highlightContainer_error"></small>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input id="description" class="form-control" type="text" name="description" placeholder="Description" value="<?= $package['description'] ?>">
                                                            <label for="description" class="required">Short Description</label>
                                                            <small class="error-message" id="description_error"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-floating">
                                                            <textarea class="form-control" placeholder="Leave a comment here" id="descriptionDetail"><?= $package['detailed_description'] ?></textarea>
                                                            <label for="descriptionDetail" class="required">Detailed Description</label>
                                                            <small class="error-message" id="descriptionDetail_error"></small>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mt-3">
                                                            <div class="form-floating">
                                                                <div class="form-control d-flex justify-content-between packageType-wrapper" id="packageType_wrapper">
                                                                    <div>
                                                                        <input type="radio" class="packageType" name="packageType" value="Trending" id="trending" <?= $package['highlight_type'] ==='Trending'?'checked':'' ?>>
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="trending">Trending</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="packageType" name="packageType" value="Popular" id="popular" <?= $package['highlight_type'] ==='Popular'?'checked':'' ?>>
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="popular">Popular</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="packageType" name="packageType" value="Most Selling" id="mostSelling" <?= $package['highlight_type'] ==='Most Selling'?'checked':'' ?>>
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="mostSelling">Most Selling</label>
                                                                    </div>
                                                                    <div>
                                                                        <input type="radio" class="packageType" name="packageType" value="New Arrival" id="newArrival" <?= $package['highlight_type'] ==='New Arrival'?'checked':'' ?>>
                                                                        <label style="padding-right:15px; padding-left: 5px;" for="newArrival">New Arrival</label>
                                                                    </div>
                                                                </div>
                                                                <small class="error-message" id="packageType_error"></small>
                                                                <label class="">Highlight Type <span class="required"></span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3">
                                                            <div class="form-floating">
                                                                <div class="form-control visaType-wrapper" id="visaType_wrapper">
                                                                    <input type="radio" class="visaType" name="visaType" value="visaYes" id="visaYes" <?= $package['visa_required'] == 1?'checked':'' ?>>
                                                                    <label style="padding-right:15px; padding-left: 5px;" for="visaYes">Yes</label>
                                                                    <input type="radio" class="visaType" name="visaType" value="visaNo" id="visaNo" <?= $package['visa_required'] == 0?'checked':'' ?>>
                                                                    <label style="padding-right:15px; padding-left: 5px;" for="visaNo">No</label>
                                                                </div>
                                                                <small class="error-message" id="visaType_error"></small>
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
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="dropPriceCheck" <?= $package['drop_price_status'] == 1?'checked':'' ?>>
                                                                        <label class="form-check-label" for="dropPriceCheck">Enable Drop Price</label>
                                                                    </div>
                                                                    <div class="form-floating my-2">
                                                                        <input id="dropPrice" class="form-control" type="number" name="dropPrice" value="<?= $package['drop_price_amount'] ?>">
                                                                        <label for="dropPrice" class="required">Drop Price Per Person (&#8377;)</label>
                                                                        <small class="error-message" id="dropPrice_error"></small>
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
                                                                <input type="text" id="destination" name="destination" placeholder="Destination" class="form-control" value="<?= $package['destination'] ?>">
                                                                <label for="destination" class="required">Destination</label>
                                                                <small class="error-message" id="destination_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" id="travelFrom" name="travelFrom" value="<?= $package['travel_from'] ?>" placeholder="Transfer From" class="form-control">
                                                                <label for="travelFrom" class="required">Pick Up Point</label>
                                                                <small class="error-message" id="travelFrom_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating my-3">
                                                                <input type="text" id="travelTo" name="travelTo" value="<?= $package['travel_to'] ?>" placeholder="Transfer To" class="form-control">
                                                                <label for="travelTo" class="required">Drop Point</label>
                                                                <small class="error-message" id="travelTo_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="sightseeingType" name="sightseeingType" value="<?= $package['sightseeing_type'] ?>" placeholder="Sightseeing Type" class="form-control">
                                                                <label for="sightseeingType" class="required">Sightseeing Type</label>
                                                                <small class="error-message" id="sightseeingType_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <select id="categoryHotelId" name="categoryHotelId" class="selectdesign form-select">
                                                                    <?php
                                                                    $selected = $package['category_hotel_id'];

                                                                    $cat_data_hotel = $conn->prepare("SELECT * FROM category_hotel");
                                                                    $cat_data_hotel->execute();

                                                                    if ($cat_data_hotel->rowCount() > 0) {

                                                                        echo '<option value="0">--Select Hotel Ratings--</option>';

                                                                        foreach ($cat_data_hotel->fetchAll(PDO::FETCH_ASSOC) as $row) {

                                                                            $isSelected = ($row['id'] == $selected) ? 'selected' : '';

                                                                            echo '<option value="' . $row['id'] . '" ' . $isSelected . '>'
                                                                                    . htmlspecialchars($row['name']) .
                                                                                '</option>';
                                                                        }

                                                                    } else {

                                                                        echo '<option value="0">No Hotels Available</option>';

                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small class="error-message" id="categoryHotelId_error"></small>
                                                                <label class="required">Hotel Category</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3 form">
                                                                <select id="occupancyId" name="occupancyId" class="form-select">
                                                                    <?php
                                                                    $selected = $package['category_occupancy_id'];

                                                                    $cat_data_occupancy = $conn->prepare("SELECT * FROM category_occupancy");
                                                                    $cat_data_occupancy->execute();

                                                                    if ($cat_data_occupancy->rowCount() > 0) {

                                                                        echo '<option value="0">--Select Occupancy Type--</option>';

                                                                        foreach ($cat_data_occupancy->fetchAll(PDO::FETCH_ASSOC) as $row) {

                                                                            $isSelected = ($row['id'] == $selected) ? 'selected' : '';

                                                                            echo '<option value="' . $row['id'] . '" ' . $isSelected . '>'
                                                                                . htmlspecialchars($row['name']) .
                                                                                '</option>';
                                                                        }

                                                                    } else {

                                                                        echo '<option value="0">No Occupancy Available</option>';

                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small class="error-message" id="occupancyId_error"></small>
                                                                <label class="required">Occupancy Category</label>
                                                                <div id="occupancy_data"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <select id="categoryMealId" name="categoryMealId" class="form-select">
                                                                    <?php
                                                                    $selected = $package['category_meal_id'];

                                                                    $cat_data_meal = $conn->prepare("SELECT * FROM category_meal");
                                                                    $cat_data_meal->execute();

                                                                    if ($cat_data_meal->rowCount() > 0) {

                                                                        echo '<option value="0">--Select Meal Type--</option>';

                                                                        foreach ($cat_data_meal->fetchAll(PDO::FETCH_ASSOC) as $row) {

                                                                            $isSelected = ($row['id'] == $selected) ? 'selected' : '';

                                                                            echo '<option value="' . $row['id'] . '" ' . $isSelected . '>'
                                                                                . htmlspecialchars($row['name']) .
                                                                                '</option>';
                                                                        }

                                                                    } else {

                                                                        echo '<option value="0">No Meal Available</option>';

                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small class="error-message" id="categoryMealId_error"></small>
                                                                <label class="required">Meal Category</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <select id="vehicleId" name="vehicleId" class="form-select">
                                                                    <?php
                                                                    $selected = $package['category_vehicle_id'];

                                                                    $cat_data_vehicle = $conn->prepare("SELECT * FROM category_vehicle");
                                                                    $cat_data_vehicle->execute();

                                                                    if ($cat_data_vehicle->rowCount() > 0) {

                                                                        echo '<option value="0">--Select Vehicle Type--</option>';

                                                                        foreach ($cat_data_vehicle->fetchAll(PDO::FETCH_ASSOC) as $row) {

                                                                            $isSelected = ($row['id'] == $selected) ? 'selected' : '';

                                                                            echo '<option value="' . $row['id'] . '" ' . $isSelected . '>'
                                                                                . htmlspecialchars($row['name']) .
                                                                                '</option>';
                                                                        }

                                                                    } else {

                                                                        echo '<option value="0">No Vehicle Available</option>';

                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small class="error-message" id="vehicleId_error"></small>
                                                                <label class="required">Vehicle Category</label>
                                                                <div id="vehicle_data"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="languageType" name="languageType" value="<?= $package['language_type'] ?>" placeholder="Language Type" class="form-control">
                                                                <label for="languageType" class="required">Language Type</label>
                                                                <small class="error-message" id="languageType_error"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="highlights-section p-3 packageKeyWords-wrapper" id="packageKeyWords_wrapper">
                                                                <label class="highlight-label">Package Keyword</label>
                                                                <div class="highlight-container" id="packageKeyWords">
                                                                    <?php
                                                                    if (!empty($package['package_keywords'])) {

                                                                        $keywords = json_decode($package['package_keywords'], true);

                                                                        if (is_array($keywords)) {
                                                                            foreach ($keywords as $keyword) {
                                                                                ?>
                                                                                <div class="highlight-tag package-tag"
                                                                                    data-package-key="<?= htmlspecialchars($keyword) ?>">
                                                                                    <span class="package-name"><?= htmlspecialchars($keyword) ?></span>
                                                                                    <span class="remove-btn">&times;</span>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="add-highlight">
                                                                    <a href="#" id="addPackageKeywordBtn">+ Add Keyword</a>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="packageKeyWords_error"></small>
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
                                                                    <?php
                                                                    $highlights = json_decode($itineraryDetails['highlights'], true);

                                                                    if (is_array($highlights) && !empty($highlights)) {

                                                                        foreach ($highlights as $highlight) {
                                                                            ?>
                                                                            <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 remark-text"><?= htmlspecialchars($highlight) ?></p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-remark text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-remark text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }

                                                                    } else {
                                                                        ?>
                                                                        <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 remark-text">Placeholder Text</p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-remark text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-remark text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <small class="error-message" id="hightlightList_error"></small>
                                                            </div>
                                                        </div>
                                                        <label for="" style="color: #ff4b4b; font-weight: 600; display:block">NOTE : Number Of Days may look different on deletion of previous "DAY", but Days will be listed from first to last in increasing order .</label>
                                                        <!-- add days -->
                                                        <div class="col-md-2 col-sm-2 col-12 d-flex justify-content-center align-items-center">
                                                            <button class="add_field_button custom_btn btn1 mt-2 ms-3 mb-3 addButton btn btn-success px-3">
                                                                Add Days
                                                            </button>
                                                        </div>
                                                        <small class="error-message" id="days_error"></small> 
                                                        <div class="input_fields_wrap">
                                                            <?php if (!empty($packageTripDays)) : ?>
                                                                <script>
                                                                    document.addEventListener("DOMContentLoaded", function () {

                                                                        const wrapper = document.querySelector(".input_fields_wrap");

                                                                        wrapper.innerHTML = "";

                                                                        let dayCount = 0;
                                                                        x = 0;

                                                                        <?php foreach ($packageTripDays as $day) : ?>
                                                                            dayCount++;
                                                                            x++;

                                                                            wrapper.insertAdjacentHTML("beforeend", `
                                                                                <div class="row day-container">
                                                                                    <div class="col-md-12 col-sm-12 col-12">
                                                                                        <div class="card rounded-5 box border border-1 px-3 pt-3" draggable="true">

                                                                                            <input type="hidden" class="trip_day_id" value="<?= $day['id']; ?>">

                                                                                            <div class="row">
                                                                                                <div class="col-md-2 col-sm-3 col-3">
                                                                                                    <a type="button" class="btn btn-success px-3 dayval">
                                                                                                        Day: ${dayCount}
                                                                                                    </a>
                                                                                                </div>

                                                                                                <div class="col-md-8 col-sm-6 col-6">
                                                                                                    <div class="input-group mb-3">
                                                                                                        <span class="input-group-text">Title</span>
                                                                                                        <input type="text"
                                                                                                            class="form-control title"
                                                                                                            placeholder="Title"
                                                                                                            value="<?= htmlspecialchars($day['title']); ?>">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-md-2 col-sm-3 col-3">
                                                                                                    <div class="d-flex justify-content-end">
                                                                                                        <button type="button"
                                                                                                            class="remove_field btn btn-danger px-3 ms-4">
                                                                                                            Remove
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row">

                                                                                                <div class="col-md-12">
                                                                                                    <div class="input-group mb-3">
                                                                                                        <span class="input-group-text">Description</span>
                                                                                                        <textarea class="form-control description"><?= htmlspecialchars($day['day_details']); ?></textarea>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                                                    <div class="input-group mb-3">
                                                                                                        <span class="input-group-text">Meals Included</span>
                                                                                                        <input type="text"
                                                                                                            class="form-control meals"
                                                                                                            placeholder="Meals"
                                                                                                            value="<?= htmlspecialchars($day['meal_plan']); ?>">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                                                    <div class="input-group mb-3">
                                                                                                        <span class="input-group-text">Transport</span>
                                                                                                        <input type="text"
                                                                                                            class="form-control transport"
                                                                                                            placeholder="Transport"
                                                                                                            value="<?= htmlspecialchars($day['day_tansport']); ?>">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                                                    <div class="input-group mb-3">
                                                                                                        <span class="input-group-text">Stay</span>
                                                                                                        <input type="text"
                                                                                                            class="form-control transport"
                                                                                                            placeholder="Stay"
                                                                                                            value="<?= htmlspecialchars($day['stay']); ?>">
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            `);

                                                                        <?php endforeach; ?>

                                                                        updateDayNumbers();
                                                                        dayCount = document.querySelectorAll(".day-container").length;
                                                                        x = dayCount;

                                                                    });

                                                                    function updateDayNumbers() {
                                                                        document.querySelectorAll(".dayval").forEach((el, index) => {
                                                                            el.textContent = `Day: ${index + 1}`;
                                                                        });
                                                                    }
                                                                    </script>
                                                            <?php endif; ?>
                                                        </div><!-- Show Added Days -->
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
                                                                    <?php
                                                                    $inclusions = json_decode($itineraryDetails['inclusion'], true);

                                                                    // If it's not valid JSON, split by "."
                                                                    if (!is_array($inclusions)) {
                                                                        $inclusions = array_filter(array_map('trim', explode('.', $itineraryDetails['inclusion'])));
                                                                    }

                                                                    if (!empty($inclusions)) {
                                                                        foreach ($inclusions as $inclusion) {
                                                                            ?>
                                                                            <div class="inclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 inclusion-text"><?= htmlspecialchars($inclusion) ?></p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-inclusion text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-inclusion text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="inclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                            <p class="mb-0 inclusion-text">Placeholder Text</p>

                                                                            <div class="d-flex gap-3">
                                                                                <a href="#" class="edit-inclusion text-primary">
                                                                                    <i class="fa-solid fa-pencil"></i>
                                                                                </a>

                                                                                <a href="#" class="delete-inclusion text-danger">
                                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="inclusionList_error"></small>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between exclusionTitleCard">
                                                                    <p class="title exclusionTitle mb-0"><i class="fa-regular fa-circle-xmark fa-xl me-2"></i>Exclusions</p>
                                                                    <a href="#" id="addExclutionBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="exclusionList">
                                                                    <?php
                                                                    $exclusions = json_decode($itineraryDetails['exclusion'], true);

                                                                    // If it's not valid JSON, split by "."
                                                                    if (!is_array($exclusions)) {
                                                                        $exclusions = array_filter(array_map('trim', explode('.', $itineraryDetails['exclusion'])));
                                                                    }

                                                                    if (!empty($exclusions)) {
                                                                        foreach ($exclusions as $exclusion) {
                                                                            ?>
                                                                            <div class="exclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 exclusion-text"><?= htmlspecialchars($exclusion) ?></p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-exclusion text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-exclusion text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="exclusion-item d-flex justify-content-between align-items-start mb-2">
                                                                            <p class="mb-0 exclusion-text">Placeholder Text</p>

                                                                            <div class="d-flex gap-3">
                                                                                <a href="#" class="edit-exclusion text-primary">
                                                                                    <i class="fa-solid fa-pencil"></i>
                                                                                </a>

                                                                                <a href="#" class="delete-exclusion text-danger">
                                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="exclusionList_error"></small>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between remarkTitleCard">
                                                                    <p class="title remarkTitle mb-0"><i class="fa-solid fa-book fa-xl me-2"></i>Important Notes / Remarks</p>
                                                                    <a href="#" id="addRemarkBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="remarkList">
                                                                    <?php
                                                                    $remarks = json_decode($itineraryDetails['remark'], true);

                                                                    // If it's not valid JSON, split by "."
                                                                    if (!is_array($remarks)) {
                                                                        $remarks = array_filter(array_map('trim', explode('.', $itineraryDetails['remark'])));
                                                                    }

                                                                    if (!empty($remarks)) {
                                                                        foreach ($remarks as $remark) {
                                                                            ?>
                                                                            <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 remark-text"><?= htmlspecialchars($remark) ?></p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-remark text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-remark text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="remark-item d-flex justify-content-between align-items-start mb-2">
                                                                            <p class="mb-0 remark-text">Placeholder Text</p>

                                                                            <div class="d-flex gap-3">
                                                                                <a href="#" class="edit-remark text-primary">
                                                                                    <i class="fa-solid fa-pencil"></i>
                                                                                </a>

                                                                                <a href="#" class="delete-remark text-danger">
                                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="remarkList_error"></small>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="card rounded-4">
                                                                <div class="d-flex justify-content-between remarkTitleCard">
                                                                    <p class="title remarkTitle mb-0"><i class="fa-solid fa-circle-info fa-xl me-2"></i>Things to Know Before You Go</p>
                                                                    <a href="#" id="addThingsBtn" class="remarkTitle">+ Add Items</a>
                                                                </div>
                                                                <div class="p-3" id="thingsList">
                                                                    <?php
                                                                    $travel_infos = json_decode($itineraryDetails['travel_info'], true);

                                                                    if (is_array($travel_infos) && !empty($travel_infos)) {
                                                                        foreach ($travel_infos as $travel_info) {
                                                                            ?>
                                                                            <div class="things-item d-flex justify-content-between align-items-start mb-2">
                                                                                <p class="mb-0 things-text"><?= htmlspecialchars($travel_info) ?></p>

                                                                                <div class="d-flex gap-3">
                                                                                    <a href="#" class="edit-things text-primary">
                                                                                        <i class="fa-solid fa-pencil"></i>
                                                                                    </a>

                                                                                    <a href="#" class="delete-things text-danger">
                                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="things-item d-flex justify-content-between align-items-start mb-2">
                                                                            <p class="mb-0 things-text">Placeholder Text</p>

                                                                            <div class="d-flex gap-3">
                                                                                <a href="#" class="edit-things text-primary">
                                                                                    <i class="fa-solid fa-pencil"></i>
                                                                                </a>

                                                                                <a href="#" class="delete-things text-danger">
                                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="thingsList_error"></small>
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
                                                                        <input type="number" id="netPriceAdult" name="net_price_adult" value="<?= $packagePricing['net_price_adult'] ?>" placeholder="NET Price for 1 Adult:" class="form-control">
                                                                        <small class="error-message" id="netPriceAdult_error"></small>
                                                                        <label for="netPriceAdult" class="required">Base Price for per Adult:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3" id="netPriceChildData">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="netPriceChild" name="netPriceChild" value="<?= $packagePricing['net_price_child'] ?>" placeholder="NET Price for 1 Child" class="form-control" value='0'>
                                                                        <label for="netPriceChild" class="required">Base Price for per Child:</label>
                                                                        <small class="error-message" id="netPriceChild_error"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="extraMatress" name="extraMatress" value="<?= $packagePricing['extra_mattress'] ?>" placeholder="Extra Mattress" class="form-control">
                                                                        <label class="required" for="extraMatress">Extra Mattress</label>
                                                                        <small class="error-message" id="extraMatress_error"></small>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h5 class="mb-0 fw-bolder" id="#">2. Company Markup</h5>
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating my-3">
                                                                        <input type="number" id="companyMarkup" name="companyMarkup" placeholder="Destination" class="form-control" value="<?= $packagePricingMarkup['company'] ?>">
                                                                        <label for="companyMarkup" class="required">Company Markup</label>
                                                                        <small class="error-message" id="companyMarkup_error"></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating my-3">
                                                                        <input type="number" id="couponAdjustment" name="couponAdjustment" placeholder="Destination" class="form-control" value="<?= $packagePricing['coupon_adjustment'] ?>">
                                                                        <label for="couponAdjustment" class="required">Default Coupon Adjustment</label>
                                                                        <small class="error-message" id="couponAdjustment_error"></small>
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
                                                                            <label class="form-check-label" for="switchCheckGuestUser">
                                                                                Guest User Premium (Without Login)
                                                                            </label>
                                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                                id="switchCheckGuestUser"
                                                                                <?= (!empty($packagePricing['guest_amount']) || !empty($packagePricing['guest_percentage'])) ? 'checked' : '' ?>>
                                                                        </div>

                                                                        <div>
                                                                            <div class="d-flex gap-4">
                                                                                <div class="form-check align-content-center">
                                                                                    <input class="form-check-input" type="radio" name="radioDefault"
                                                                                        id="radioDefault1"
                                                                                        <?= !empty($packagePricing['guest_amount']) ? 'checked' : '' ?>>
                                                                                    <label class="form-check-label" for="radioDefault1">
                                                                                        Add Fixed Amount
                                                                                    </label>
                                                                                </div>

                                                                                <input type="number"
                                                                                    id="guestAmount"
                                                                                    name="guestAmount"
                                                                                    class="form-control inputWidth"
                                                                                    value="<?= !empty($packagePricing['guest_amount']) ? $packagePricing['guest_amount'] : '' ?>">

                                                                                <small class="error-message" id="guestAmount_error"></small>
                                                                            </div>

                                                                            <div class="d-flex gap-4">
                                                                                <div class="form-check align-content-center">
                                                                                    <input class="form-check-input" type="radio" name="radioDefault"
                                                                                        id="radioDefault2"
                                                                                        <?= !empty($packagePricing['guest_percentage']) ? 'checked' : '' ?>>
                                                                                    <label class="form-check-label" for="radioDefault2">
                                                                                        Add Percentage
                                                                                    </label>
                                                                                </div>

                                                                                <div class="input-group my-3 inputWidth">
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        id="guestPercentage"
                                                                                        name="guestPercentage"
                                                                                        value="<?= !empty($packagePricing['guest_percentage']) ? $packagePricing['guest_percentage'] : '' ?>">

                                                                                    <span class="input-group-text">%</span>
                                                                                    <small class="error-message" id="guestPercentage_error"></small>
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
                                                                        <input type="number" id="travelConsultant" name="travelConsultant" placeholder="travelConsultant" class="form-control" value="<?= $packagePricingMarkup['ta_markup'] ?>">
                                                                        <label for="travelConsultant" class="required">Travel Consultant</label>
                                                                        <small class="error-message" id="travelConsultant_error"></small>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered" id="cteChainTable">
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
                                                                            <td class="text-end" id="cteComPer"><?= $product_payout_data_new['CTE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="cteComm" data-value="0">&#8377; <?= $packagePricingTeChain['cte_direct_commission']??0.00 ?></td>
                                                                            <td class="text-end" id="cteInsPer"><?= $product_payout_data_new['CTE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="cteIns" data-value="0">&#8377; <?= $packagePricingTeChain['cte_incentive']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="cteCommInsTotal">&#8377; <?= $packagePricingTeChain['cte_mark_up_total']??0.00 ?></td>
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
                                                                            <td class="text-end" id="eteComPer"><?= $product_payout_data_new['ETE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="eteComm" data-value="0">&#8377; <?= $packagePricingTeChain['ete_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end" id="eteInsPer"><?= $product_payout_data_new['ETE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="eteIns" data-value="0">&#8377; <?= $packagePricingTeChain['ete_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="eteCommInsTotal">&#8377; <?= $packagePricingTeChain['ete_mark_up_total']??0.00 ?></td>
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
                                                                            <td class="text-end" id="steComPer"><?= $product_payout_data_new['STE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="steComm" data-value="0">&#8377; <?= $packagePricingTeChain['ste_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end" id="steInsPer"><?= $product_payout_data_new['STE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="steIns" data-value="0">&#8377; <?= $packagePricingTeChain['ste_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="steCommInsTotal">&#8377; <?= $packagePricingTeChain['ste_mark_up_total']??0.00 ?></td>
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
                                                                            <td class="text-end" id="cTeFComPer"><?= $product_payout_data_new['TE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="cTeFComm" data-value="0">&#8377; <?= $packagePricingTeChain['te_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end" id="cTeFInsPer"><?= $product_payout_data_new['TE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="cTeFIns" data-value="0">&#8377; <?= $packagePricingTeChain['te_mark_up_total']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="cTeFCommInsTotal">&#8377; <?= $packagePricingTeChain['te_mark_up_total']??0.00 ?></td>
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
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="cteChainCommTotal">&#8377; <?= $packagePricingTeChain['total_commission_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="cteChainInsTotal">&#8377; <?= $packagePricingTeChain['total_incentive_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder" id="cteChainCommInsTotal">&#8377; <?= $packagePricingTeChain['total_mark_up']??0.00 ?></td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="cteSuspence" name="cteSuspence" placeholder="cteSuspence" class="form-control" readonly value="<?= $packagePricingTeChain['suspense']??0.00 ?>">
                                                                        <label for="cteSuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered" id="bmTeTable">
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
                                                                            <td>BM | SF | MF</td>
                                                                            <td class="text-end" id="teBmComPer"><?= $product_payout_data['BM']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="teBmComm" data-value="0">&#8377; <?= $packagePricingMarkup['bm_direct_commission']??0.00 ?></td>
                                                                            <td class="text-end" id="teBmInsPer"><?= $product_payout_data['BM']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="teBmIns" data-value="0">&#8377; <?= $packagePricingMarkup['bm_incentive']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="teBmComInsTotal">&#8377; <?= $packagePricingMarkup['bm_mark_up_total']??0.00 ?></td>
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
                                                                            <td class="text-end" id="bmTeComPer"><?= $product_payout_data['TE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="bmTeComm" data-value="0">&#8377; <?= $packagePricingMarkup['ca_direct_commission']??0.00 ?></td>
                                                                            <td class="text-end" id="bmTeInsPer"><?= $product_payout_data['TE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="bmTeIns" data-value="0">&#8377; <?= $packagePricingMarkup['ca_incentive']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="bmTeCommInsTotal">&#8377; <?= $packagePricingMarkup['ca_mark_up_total']??0.00 ?></td>
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
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="bmTeChainCommTotal">&#8377; <?= $packagePricingMarkup['total_commission_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="bmTeChainInsTotal">&#8377; <?= $packagePricingMarkup['total_incentive_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder" id="bmTeChainCommInsTotal">&#8377; <?= $packagePricingMarkup['total_mark_up']??0.00 ?></td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="bmSuspence" name="bmSuspence" placeholder="bmSuspence" class="form-control" readonly value="<?= $packagePricingMarkup['suspense']??0.00 ?>">
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
                                                                <table class="table table-bordered" id="bmITable">
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
                                                                            <td class="text-end" id="iBmComPer"><?= $institutionData['roles']['BM']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="iBmComm" data-value="0">&#8377; <?= $packagePricingInstitution['bm_direct_commission']??0.00 ?></td>
                                                                            <td class="text-end" id="iBmInsPer"><?= $institutionData['roles']['BM']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="iBmIns" data-value="0">&#8377; <?= $packagePricingInstitution['bm_incentive']??0.00 ?></td>
                                                                            <td class="text-end editable-total" id="iBmCommInsTotal">&#8377; <?= $packagePricingInstitution['bm_mark_up_total']??0.00 ?></td>
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
                                                                            <td class="text-end">As Per Slab</td>
                                                                            <td class="text-end editable-comm" id="bmIComm" data-value="0">&#8377; <?= $packagePricingInstitution['ins_markup']??0.00 ?></td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end" id="bmIIns">NA</td>
                                                                            <td class="text-end editable-total" id="bmICommInsTotal">&#8377; <?= $packagePricingInstitution['ins_markup']??0.00 ?></td>
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
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="bmIComTotal">&#8377; <?= $packagePricingInstitution['total_commission_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="bmIInsTotal">&#8377; <?= $packagePricingInstitution['total_incentive_amount']??0.00 ?></td>
                                                                        <td class="text-end fw-bolder" id="bmIComInsTotal">&#8377; <?= $packagePricingInstitution['total_mark_up']??0.00 ?></td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="bmISuspence" name="bmISuspence" placeholder="bmISuspence" class="form-control" readonly value="<?= $packagePricingInstitution['suspense']??0.00 ?>">
                                                                        <label for="bmISuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered" id="iCteTable">
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
                                                                            <td class="text-end" id="iCteComPer"><?= $institutionCteData['roles']['CTE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="iCteComm" data-value="0">&#8377; <?= $packagePricingTechnoInstitution['cte_direct_commission'] ?? 0.00 ?></td>
                                                                            <td class="text-end" id="iCteInsPer"><?= $institutionCteData['roles']['CTE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="iCteIns" data-value="0">&#8377; <?= $packagePricingTechnoInstitution['cte_incentive'] ?? 0.00 ?></td>
                                                                            <td class="text-end editable-total" id="iCteCommInsTotal">&#8377; <?= $packagePricingTechnoInstitution['cte_mark_up_total'] ?? 0.00 ?></td>
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
                                                                            <td class="text-end" id="iEteComPer"><?= $institutionCteData['roles']['ETE']['comm_percentage'] ?>%</td>
                                                                            <td class="text-end editable-comm" id="iEteComm" data-value="0">&#8377; <?= $packagePricingTechnoInstitution['ete_direct_commission'] ?? 0.00 ?></td>
                                                                            <td class="text-end" id="iEteInsPer"><?= $institutionCteData['roles']['ETE']['ins_percentage'] ?>%</td>
                                                                            <td class="text-end editable-ins" id="iEteIns" data-value="0">&#8377; <?= $packagePricingTechnoInstitution['ete_incentive'] ?? 0.00 ?></td>
                                                                            <td class="text-end editable-total" id="iEteCommInsTotal">&#8377; <?= $packagePricingTechnoInstitution['ete_mark_up_total'] ?? 0.00 ?></td>
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
                                                                            <td class="text-end">As Per Slab</td>
                                                                            <td class="text-end editable-comm" id="cteIComm" data-value="0">&#8377; <?= $packagePricingTechnoInstitution['ins_markup'] ?? 0.00 ?></td>
                                                                            <td class="text-end">NA</td>
                                                                            <td class="text-end" id="cteIIns">NA</td>
                                                                            <td class="text-end editable-total" id="cteICommInsTotal">&#8377; <?= $packagePricingTechnoInstitution['ins_markup'] ?? 0.00 ?></td>
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
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="iCteComTotal">&#8377; <?= $packagePricingTechnoInstitution['total_commission_amount'] ?? 0.00 ?></td>
                                                                        <td class="text-end fw-bolder"></td>
                                                                        <td class="text-end fw-bolder" id="iCteInsTotal">&#8377; <?= $packagePricingTechnoInstitution['total_incentive_amount'] ?? 0.00 ?></td>
                                                                        <td class="text-end fw-bolder" id="iCteComInsTotal">&#8377; <?= $packagePricingTechnoInstitution['total_mark_up'] ?? 0.00 ?></td>
                                                                    </tfoot>
                                                                </table>
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="cteISuspence" name="cteISuspence" placeholder="cteISuspence" class="form-control" readonly value="<?= $packagePricingTechnoInstitution['suspense']?? 0.00 ?>">
                                                                        <label for="cteISuspence" class="required">Suspence</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="number" id="customer1" name="customer1" placeholder="Customer1" class="form-control" value="<?= $packagePricingMarkup['prime_customer'] ?>">
                                                                            <label for="customer1" class="required">Customer 1</label>
                                                                            <small class="error-message" id="customer1_error"></small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="number" id="customer2" name="customer2" data-per="<?= $l2_per ?>" placeholder="Customer2" class="form-control" readonly value="<?= $packagePricingMarkup['L1_customer'] ?>">
                                                                            <label for="customer2" class="required">Customer 2</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="number" id="customer3" name="customer3" data-per="<?= $l3_per ?>" placeholder="Customer3" class="form-control" readonly value="<?= $packagePricingMarkup['L2_customer'] ?>">
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
                                                                                <label for="mrpPerAdult" class="mb-0">Total Price Per Adult</label>
                                                                            </div>
                                                                            <input type="number" value="<?= $packagePricing['net_price_adult_with_GST'] ?>" id="mrpPerAdult" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrpPerChild" class="mb-0">Total Price Per Child</label>
                                                                            </div>
                                                                            <input type="number" value="<?= $packagePricing['net_price_child_with_GST'] ?>" id="mrpPerChild" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                                                            <h5 class="mb-3 fw-bolder" id="#">6. Total Pricing with <?= $gstValue ?>% GST</h5>
                                                            <div class="borderHighlight p-3 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-9 col-sm-9">
                                                                        <div class="d-flex gap-4 mb-3">
                                                                            <div class="align-content-center">
                                                                                <label for="mrpPerAdultWithGst" class="mb-0">Total Price Per Adult</label>
                                                                            </div>
                                                                            <input type="number" value="<?= $packagePricing['total_package_price_per_adult'] ?>" id="mrpPerAdultWithGst" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12 px-4">
                                                                        <div class="pt-2">
                                                                            <span>CGST <?= $gstValue * 0.5 ?>%</span>
                                                                            <span>SGST <?= $gstValue * 0.5 ?>%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9 col-sm-9">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrpPerChildWithGst" class="mb-0">Total Price Per Child</label>
                                                                            </div>
                                                                            <input type="number" value="<?= $packagePricing['total_package_price_per_child'] ?>" id="mrpPerChildWithGst" class="form-control inputWidth" readOnly>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 col-12">
                                                            <h4 class="mb-3 fw-bolder">7. Cancellation Policy</h4>
                                                            <div class="row borderHighlight mx-0">
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                                                    <div class="text-center mb-2">
                                                                        <label for="mrpPerAdult" class="mb-0">Cancellation Before Travel</label>
                                                                    </div>
                                                                    <div class="inputFieldAlignment">
                                                                        <input type="number" value="" id="mrpPerAdult" placeholder="30+ Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrpPerAdult" placeholder="15 - 30 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrpPerAdult" placeholder="7 - 15 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrpPerAdult" placeholder="0 - 7 Days" class="form-control inputWidth" readOnly>
                                                                        <input type="number" value="" id="mrpPerAdult" placeholder="No Show" class="form-control inputWidth" readOnly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-3">
                                                                    <div class="text-center mb-2">
                                                                        <label for="mrpPerChild" class="mb-0">Cancellation Charges</label>
                                                                    </div>
                                                                    <div class="inputFieldAlignment">
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="cancellationPercentage1" name="cancellationPercentage1" placeholder="0" value="<?= $CancelPolicy['policy_1']??0 ?>">
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage1_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="cancellationPercentage2" name="cancellationPercentage2" placeholder="0" value="<?= $CancelPolicy['policy_2']??0 ?>">
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage2_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="cancellationPercentage3" name="cancellationPercentage3" placeholder="0" value="<?= $CancelPolicy['policy_3']??0 ?>">
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage3_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="cancellationPercentage4" name="cancellationPercentage4" placeholder="0" value="<?= $CancelPolicy['policy_4']??0 ?>">
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage4_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="cancellationPercentage5" name="cancellationPercentage5" placeholder="0" value="<?= $CancelPolicy['policy_5']??0 ?>">
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage5_error"></small>
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
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 couponRule-wrapper" id="couponRule_wrapper">
                                                            <h4 class="mt-3 fw-bolder">Coupon Rule</h4>
                                                            <div class="borderHighlight p-3">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <label class="form-check-label" for="switchCoupon">Coupon Allowed</label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="switchCoupon" <?= ($packagePolicy['coupon_allowed'] ?? '') ? 'checked' : '' ?>>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <label class="form-check-label" for="switchCombine">Can Combine With Other Offers</label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="switchCombine"
                                                                        <?= ($packagePolicy['combine_with_other_offers'] ?? '') ? 'checked' : '' ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <small class="error-message" id="couponRule_error"></small>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <h4 class="mt-3 fw-bolder">Booking Policy</h4>
                                                            <div class="borderHighlight p-3">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrpPerAdult" class="mb-3">Minimum Advance Payment</label>
                                                                            </div>
                                                                            <div class="input-group mb-3 inputWidth">
                                                                                <input type="number" class="form-control" id="bookingPercentage" name="bookingPercentage" value="<?= htmlspecialchars($packagePolicy['minimum_advance_payment'] ?? '') ?>" >
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="bookingPercentage_error"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="d-flex gap-4">
                                                                            <div class="align-content-center">
                                                                                <label for="mrpPerChild" class="mb-0">Full Payment Before Travel</label>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="bookingDay" name="bookingDay" value="<?= htmlspecialchars($packagePolicy['full_payment_before_travel'] ?? '') ?>">
                                                                                <span class="input-group-text">Days</span>
                                                                                <small class="error-message" id="bookingDay_error"></small>
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
                                                                    <div class="upload-wrapper otherPolicy-wrapper" id="otherPolicy_wrapper">
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
                                                                                <tr id="noAttachmentRow">
                                                                                    <td colspan="6" class="text-center text-muted">
                                                                                        No Attachment found
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
                                                                    <small class="error-message" id="otherPolicy_error"></small>
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
                                                                            <input type="hidden" id="coverImageUrl" value="">
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
                                                                                You can upload up to 18 images | Max Size: 5MB each | Min No. uploads 4 | Format: JPG, PNG, WEBP
                                                                            </p>

                                                                            <div id="galleryMessage" class="text-danger mt-2 fw-semibold"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Hidden Inputs -->
                                                                <input
                                                                    type="file"
                                                                    id="galleryInput"
                                                                    accept="image/jpeg,image/png,image/webp"
                                                                    multiple
                                                                    hidden>

                                                                <input
                                                                    type="hidden"
                                                                    id="galleryImageUrls"
                                                                    value="[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="borderHighlight p-3 mt-3">

                                                                <h4 class="fw-bolder">3. Video</h4>

                                                                <p>
                                                                    Upload a promotional video to give users a better preview
                                                                    of the destination and package.
                                                                </p>

                                                                <div class="row">

                                                                    <div class="col-lg-12">

                                                                        <div class="video-preview-wrapper">

                                                                            <div class="video-input-group">

                                                                                <input
                                                                                    type="file"
                                                                                    class="form-control"
                                                                                    id="videoFileInput"
                                                                                    accept="video/mp4,video/webm,video/mov,video/avi,video/mkv"
                                                                                    multiple
                                                                                >

                                                                                <button
                                                                                    type="button"
                                                                                    class="preview-btn"
                                                                                    id="addVideoBtn"
                                                                                >
                                                                                    Add Video
                                                                                </button>

                                                                            </div>

                                                                            <div class="video-example mt-2">
                                                                                <i class="ri-video-line"></i>
                                                                                Supported formats: MP4, WebM, MOV, AVI, MKV
                                                                            </div>

                                                                            <div id="videoPreviewList"></div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="edit_package">
                                                            <input type="hidden" value="1" id="editFlag"/>
                                                            <input type="hidden" id="package_id" value="<?= $package['id'] ?>">
                                                            <a href="#" class="waves-effect waves-light btn-large" style=" color: white;" >Submit</a>
                                                            <!-- <a href="#" id="update_form" style="display:none"></a> -->
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
        <!-- keep all the folowing scripts on the same page -->
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

                        if (!/^[a-zA-Z0-9\s.,'"():;\/&+\-_@#!%?\r\n]*$/.test(value)) {
                            return "Only letters, numbers, spaces, and common punctuation (. , ' \" ( ) : ; / & + - _ @ # ! % ?) are allowed.";
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let city = result.value.trim();

                        const exists = [...document.querySelectorAll(".highlight-tag")]
                            .some(tag => (tag.dataset.city || "").trim().toLowerCase() === city.toLowerCase());

                        if (exists) {
                            Swal.fire({
                                icon: "warning",
                                title: "City already added"
                            });
                            return;
                        }

                        let tag = document.createElement("div");
                        tag.className = "highlight-tag";
                        tag.dataset.city = city;

                        tag.innerHTML = `
                            <span class="city-name">${city}</span>
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
                    title: "Add Package Keyword",
                    input: "text",
                    inputPlaceholder: "Enter Package Keyword",
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    inputValidator: (value) => {
                        value = value.trim();

                        if (!value) {
                            return "Please enter a Package Keyword.";
                        }

                        if (!/^[a-zA-Z0-9\s.,'"():;\/&+\-_@#!%?\r\n]*$/.test(value)) {
                            return "Only letters, numbers, spaces, and common punctuation (. , ' \" ( ) : ; / & + - _ @ # ! % ?) are allowed.";
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {

                        let keyword = result.value.trim();

                        let tag = document.createElement("div");
                        tag.className = "highlight-tag package-tag";
                        tag.dataset.packageKey = keyword; // Store the keyword

                        tag.innerHTML = `
                            <span class="package-name">${keyword}</span>
                            <span class="remove-btn">&times;</span>
                        `;

                        document.getElementById("packageKeyWords").appendChild(tag);
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
                clearFileError(this.id);
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

                            if (!/^[a-zA-Z0-9\s.,'"():;\/&+\-_@#!%?\r\n]*$/.test(value)) {
                                return "Only letters, numbers, spaces, and common punctuation (. , ' \" ( ) : ; / & + - _ @ # ! % ?) are allowed.";
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            let text = result.value.trim();

                            // Remove placeholder if present
                            const container = $(listId);
                            if (container.text().trim() === "Placeholder Text") {
                                container.empty();
                            }

                            container.append(`
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

                                if (!/^[a-zA-Z0-9\s.,'"():;\/&+\-_@#!%?\r\n]*$/.test(value)) {
                                    return "Only letters, numbers, spaces, and common punctuation (. , ' \" ( ) : ; / & + - _ @ # ! % ?) are allowed.";
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

                        // Enable radio buttons
                        $("#radioDefault1, #radioDefault2").prop("disabled", false);

                        // Enable the corresponding textbox
                        if ($("#radioDefault1").is(":checked")) {
                            $("#guestAmount").prop("disabled", false);
                            $("#guestPercentage").prop("disabled", true).val("");
                        } else if ($("#radioDefault2").is(":checked")) {
                            $("#guestPercentage").prop("disabled", false);
                            $("#guestAmount").prop("disabled", true).val("");
                        } else {
                            // No radio selected yet
                            $("#guestAmount, #guestPercentage").prop("disabled", true);
                        }

                    } else {

                        // Disable everything and clear values
                        $("#radioDefault1, #radioDefault2")
                            .prop("checked", false)
                            .prop("disabled", true);

                        $("#guestAmount, #guestPercentage")
                            .val("")
                            .prop("disabled", true);
                    }
                }

                // Guest User Switch
                $("#switchCheckGuestUser").on("change", function () {
                    updateSection();
                });

                // Fixed Amount
                $("#radioDefault1").on("change", function () {
                    if ($(this).is(":checked")) {
                        $("#guestAmount").prop("disabled", false);
                        $("#guestPercentage").prop("disabled", true).val("");
                    }
                });

                // Percentage
                $("#radioDefault2").on("change", function () {
                    if ($(this).is(":checked")) {
                        $("#guestPercentage").prop("disabled", false);
                        $("#guestAmount").prop("disabled", true).val("");
                    }
                });

                // Initial state
                updateSection();

            });
        </script>
        <!-- Policy section -->
        <script>
            
            const dropZone = document.getElementById("dropZone");
            const fileInput = document.getElementById("fileInput");
            const selectedFileText = document.getElementById("selectedFileText");
            const addDocumentBtn = document.getElementById("addDocumentBtn");

            let selectedFile = null;
            window.attachments = window.attachments || [];
            window.deletedDocuments = window.deletedDocuments || [];
            <?php if (!empty($packagePolicyDocuments)) { ?>
                document.addEventListener("DOMContentLoaded", function () {

                    $("#noAttachmentRow").remove();

                    <?php foreach ($packagePolicyDocuments as $doc) { ?>

                        window.attachments.push({
                            id: <?= $doc['id'] ?>,
                            title: <?= json_encode($doc['title']) ?>,
                            file: null,
                            file_name: <?= json_encode($doc['file_name']) ?>,
                            existing: true
                        });

                        $("#fileTableBody").append(`
                            <tr id="docRow_<?= $doc['id'] ?>" data-id="<?= $doc['id'] ?>" data-existing="1">

                                <td><?= htmlspecialchars($doc['title'], ENT_QUOTES) ?></td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="${getFileIcon('<?= $doc['file_name'] ?>')}"
                                            width="28"
                                            class="me-2">

                                        <?= htmlspecialchars($doc['file_name'], ENT_QUOTES) ?>
                                    </div>
                                </td>

                                <td><?= strtoupper($doc['type']) ?></td>

                                <td><?= $doc['size'] ?></td>

                                <td><?= date('d-M-Y', strtotime($doc['uploaded_on'])) ?></td>

                                <td class="text-center">
                                    <i class="fa-regular fa-trash-can text-danger remove-file"
                                    style="cursor:pointer"></i>
                                </td>

                            </tr>
                        `);

                    <?php } ?>

                });
            <?php } ?>

            // Return icon based on file extension
            function getFileIcon(fileName) {
                const ext = fileName.split(".").pop().toLowerCase();

                switch (ext) {
                    case "pdf":
                        return "https://cdn-icons-png.flaticon.com/512/337/337946.png";

                    case "doc":
                    case "docx":
                        return "https://cdn-icons-png.flaticon.com/512/281/281760.png";

                    case "xls":
                    case "xlsx":
                    case "csv":
                        return "https://cdn-icons-png.flaticon.com/512/732/732220.png";

                    case "ppt":
                    case "pptx":
                        return "https://cdn-icons-png.flaticon.com/512/888/888880.png";

                    case "jpg":
                    case "jpeg":
                    case "png":
                    case "gif":
                    case "bmp":
                    case "webp":
                        return "https://cdn-icons-png.flaticon.com/512/136/136524.png";

                    case "zip":
                    case "rar":
                    case "7z":
                        return "https://cdn-icons-png.flaticon.com/512/2306/2306184.png";

                    case "txt":
                        return "https://cdn-icons-png.flaticon.com/512/3022/3022256.png";

                    default:
                        return "https://cdn-icons-png.flaticon.com/512/833/833524.png";
                }
            }

            // Open picker
            dropZone.addEventListener("click", () => fileInput.click());

            // File picker
            fileInput.addEventListener("change", function () {
                selectedFile = this.files[0];

                if (selectedFile) {
                    selectedFileText.textContent = selectedFile.name;
                }
            });

            // Drag over
            dropZone.addEventListener("dragover", function (e) {
                e.preventDefault();
                dropZone.classList.add("dragover");
            });

            // Drag leave
            dropZone.addEventListener("dragleave", function () {
                dropZone.classList.remove("dragover");
            });

            // Drop
            dropZone.addEventListener("drop", function (e) {

                e.preventDefault();

                dropZone.classList.remove("dragover");

                selectedFile = e.dataTransfer.files[0];

                if (selectedFile) {
                    selectedFileText.textContent = selectedFile.name;
                }

            });

            // Add document
            addDocumentBtn.addEventListener("click", function () {

                $("#noAttachmentRow").remove();

                const title = $("#documentTitle").val().trim();

                if (title === "") {
                    alert("Please enter document title.");
                    return;
                }

                if (!selectedFile) {
                    alert("Please select a file.");
                    return;
                }

                const rowId = Date.now();

                const size = (selectedFile.size / (1024 * 1024)).toFixed(2) + " MB";

                const ext = selectedFile.name.split(".").pop().toUpperCase();

                const uploadedOn = new Date().toLocaleDateString("en-GB", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric"
                });

                // Save actual file object
                window.attachments.push({
                    id: rowId,
                    title: title,
                    file: selectedFile
                });

                const icon = getFileIcon(selectedFile.name);

                $("#fileTableBody").append(`
                    <tr id="docRow_${rowId}" data-id="${rowId}">

                        <td>${title}</td>

                        <td>
                            <div class="d-flex align-items-center">
                                <img src="${icon}"
                                    width="28"
                                    class="me-2">

                                ${selectedFile.name}
                            </div>
                        </td>

                        <td>${ext}</td>

                        <td>${size}</td>

                        <td>${uploadedOn}</td>

                        <td class="text-center">
                            <i class="fa-regular fa-trash-can text-danger remove-file"
                            style="cursor:pointer"></i>
                        </td>

                    </tr>
                `);

                // Reset
                $("#documentTitle").val("");
                fileInput.value = "";
                selectedFile = null;
                selectedFileText.textContent = "Drag & Drop or Click to Upload";

            });

            // Delete
            

            $(document).on("click", ".remove-file", function () {

                const row = $(this).closest("tr");
                const id = Number(row.data("id"));

                if (row.data("existing") == 1) {
                    deletedDocuments.push(id);
                }

                window.attachments = window.attachments.filter(file => file.id !== id);

                row.remove();

                if ($("#fileTableBody tr").length === 0) {
                    $("#fileTableBody").html(`
                        <tr id="noAttachmentRow">
                            <td colspan="6" class="text-center text-muted">
                                No Attachment found
                            </td>
                        </tr>
                    `);
                }
            });

            console.log(attachments);
        </script>
        <!-- Picture & Media Section -->
        <!-- Package Cover Image -->
        <script>
            // ==========================
            // Preview
            // ==========================
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

                    // image is active again
                    coverImageDeleted = false;

                    previewImage
                        .attr("src", e.target.result)
                        .removeClass("d-none");

                    deleteBtn.show();

                    fileText.text(file.name);

                    // Relative URL
                    $("#coverImageUrl").val("uploading/packages/" + file.name);

                    // Base64
                    $("#coverImageUrl").data("base64", e.target.result);

                };

                reader.readAsDataURL(file);

            }
            let coverImageDeleted = false;
            let existingCoverImage = "";
            const dropZone1 = $("#dragDropZone");
            const fileInput1 = $("#imageUpload");
            const previewImage = $("#packageCoverImage");
            const deleteBtn = $("#deleteImageBtn");
            const fileText = $("#selectedFileText");
            $(document).ready(function () {


                // track delete status
                let coverImageDeleted = false;

                // ==========================
                // Click Upload
                // ==========================
                dropZone1.on("click", function () {
                    fileInput1.trigger("click");
                });

                // ==========================
                // Select Image
                // ==========================
                fileInput1.on("change", function () {

                    if (this.files.length) {
                        previewFile(this.files[0]);
                    }

                });

                // ==========================
                // Drag Over
                // ==========================
                dropZone1.on("dragover", function (e) {
                    e.preventDefault();
                    $(this).addClass("dragover");
                });

                dropZone1.on("dragleave", function () {
                    $(this).removeClass("dragover");
                });

                // ==========================
                // Drop Image
                // ==========================
                dropZone1.on("drop", function (e) {

                    e.preventDefault();
                    $(this).removeClass("dragover");

                    const files = e.originalEvent.dataTransfer.files;

                    if (files.length) {
                        fileInput1[0].files = files;
                        previewFile(files[0]);
                    }

                });

                

                // ==========================
                // Delete (Hide only)
                // ==========================
                deleteBtn.on("click", function () {

                    coverImageDeleted = true;

                    previewImage.addClass("d-none");

                    $(this).hide();

                    fileText.text("Drag & Drop image here or Click to browse");

                    // IMPORTANT
                    // Don't clear:
                    // fileInput
                    // #coverImageUrl
                    // base64

                });

                // Make accessible globally
                window.isCoverImageDeleted = function () {
                    return coverImageDeleted;
                };

            });
        </script>
        <!-- Image Gallery  -->
        <script>
            // ==========================
            // Handle Files
            // ==========================
            function handleFiles(files) {

                const activeImages = galleryImages.filter(img => !img.deleted).length;
                const remainingSlots = maxImages - activeImages;

                if (remainingSlots <= 0) {

                    $("#galleryMessage")
                        .removeClass("text-muted text-warning")
                        .addClass("text-danger")
                        .text("Maximum limit of 18 images reached.");

                    return;
                }

                Array.from(files)
                    .slice(0, remainingSlots)
                    .forEach(function (file) {

                        const validTypes = [
                            "image/jpeg",
                            "image/png",
                            "image/webp"
                        ];

                        if (!validTypes.includes(file.type))
                            return;

                        if (file.size > 5 * 1024 * 1024)
                            return;

                        const reader = new FileReader();

                        reader.onload = function (e) {

                            galleryImages.push({

                                id: Date.now() + Math.random(),

                                src: e.target.result,

                                base64: e.target.result,

                                url: "uploading/packages/" + file.name,

                                file: file,

                                deleted: false

                            });

                            updateHiddenField();
                            renderGallery();

                        };

                        reader.readAsDataURL(file);

                    });

            }

            // ==========================
            // Hidden URLs
            // ==========================
            function updateHiddenField() {

                $("#galleryImageUrls").val(

                    JSON.stringify(

                        galleryImages
                            .filter(img => !img.deleted)
                            .map(img => img.url)

                    )

                );

            }

            // ==========================
            // Upload Zone Status
            // ==========================
            function toggleUploadZone() {

                const activeImages =
                    galleryImages.filter(img => !img.deleted).length;

                if (activeImages >= maxImages) {

                    $("#imageGalleryZone").hide();

                    $("#galleryMessage")
                        .removeClass("text-warning text-muted")
                        .addClass("text-danger")
                        .text("Maximum limit of 18 images reached.");

                } else {

                    $("#imageGalleryZone").show();

                    $("#galleryMessage")
                        .removeClass("text-danger text-warning")
                        .addClass("text-muted")
                        .text(activeImages + "/" + maxImages + " images uploaded");

                }

            }

            // ==========================
            // Render Gallery
            // ==========================
            function renderGallery() {

                let html = "";

                // Count only active (not deleted) images for layout
                const activeImages = galleryImages.filter(img => !img.deleted).length;

                galleryImages.forEach(function (image) {

                    let colClass = "col-lg-2 col-md-3 col-sm-4 col-6";

                    if (activeImages <= 6) {

                        switch (activeImages) {

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
                        <div class="${colClass} mb-2 ${image.deleted ? 'd-none' : ''}" data-id="${image.id}">

                            <div class="gallery-item position-relative">

                                <img src="${image.src}" class="w-100" alt="Gallery Image">

                                <button
                                    type="button"
                                    class="gallery-delete delete-image"
                                    data-id="${image.id}"
                                    ${image.deleted ? 'style="display:none;"' : ''}>

                                    <i class="fa-solid fa-trash-can"></i>

                                </button>

                            </div>

                        </div>
                    `;
                });

                $("#galleryContainer").html(html);

                toggleUploadZone();

            }
            const maxImages = 18;
            let existingGalleryImages = [];   // Loaded from DB
            let galleryImages = [];           // Newly uploaded
            let deletedGallery = [];          // Existing images deleted

            $(document).ready(function () {

                // ==========================
                // Upload Zone Click
                // ==========================
                $("#imageGalleryZone").on("click", function (e) {

                    // Don't open chooser when delete button is clicked
                    if ($(e.target).closest(".delete-image").length) {
                        return;
                    }

                    const input = document.getElementById("galleryInput");

                    try {
                        if (typeof input.showPicker === "function") {
                            input.showPicker();
                        } else {
                            input.click(); // Native click (NOT jQuery trigger)
                        }
                    } catch (err) {
                        input.click();
                    }

                });

                // ==========================
                // File Selected
                // ==========================
                $("#galleryInput").on("change", function () {

                    if (this.files.length) {
                        handleFiles(this.files);
                    }

                    this.value = "";

                });

                // ==========================
                // Drag Events
                // ==========================
                $("#imageGalleryZone").on("dragover", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    $(this).addClass("dragover");

                });

                $("#imageGalleryZone").on("dragleave", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    $(this).removeClass("dragover");

                });

                $("#imageGalleryZone").on("drop", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    $(this).removeClass("dragover");

                    const files = e.originalEvent.dataTransfer.files;

                    if (files.length) {
                        handleFiles(files);
                    }

                });

                

                // ==========================
                // Delete Preview Only
                // ==========================
                $(document).on("click", ".delete-image", function (e) {

                    e.preventDefault();
                    e.stopPropagation();

                    const id = $(this).data("id");

                    const index = galleryImages.findIndex(img => img.id == id);

                    if (index !== -1) {

                        const image = galleryImages[index];

                        // Existing image from DB
                        if (image.existing) {
                            deletedGalleryImages.push(image.id); // DB id
                        }

                        // Remove from array completely
                        galleryImages.splice(index, 1);

                        updateHiddenField();
                        renderGallery();
                    }

                });

                toggleUploadZone();

            });
        </script>
        <!-- Video -->
        <script>
            // function addVideoLink() {

            //     let videoUrl = $("#videoLinkInput").val().trim();

            //     if (!videoUrl) {
            //         alert("Please enter a video link");
            //         return;
            //     }

            //     // Optional: Validate YouTube/Vimeo URL
            //     const validVideoUrl =
            //         videoUrl.includes("youtube.com") ||
            //         videoUrl.includes("youtu.be") ||
            //         videoUrl.includes("vimeo.com");

            //     if (!validVideoUrl) {
            //         alert("Please enter a valid YouTube or Vimeo link.");
            //         return;
            //     }

            //     // Prevent duplicates
            //     let exists = false;

            //     $(".video-url").each(function () {
            //         if ($(this).text().trim() === videoUrl) {
            //             exists = true;
            //             return false;
            //         }
            //     });

            //     if (exists) {
            //         alert("This video link already exists.");
            //         return;
            //     }

            //     let videoItem = `
            //         <div class="video-preview-item">
            //             <div class="video-link-content">
            //                 <i class="fa-solid fa-play play-video"
            //                 data-url="${videoUrl}"
            //                 title="Play Video"></i>

            //                 <span class="video-url">${videoUrl}</span>
            //             </div>

            //             <i class="fa-solid fa-trash-can delete-video"
            //             title="Delete"></i>
            //         </div>
            //     `;

            //     $("#videoPreviewList").append(videoItem);

            //     $(".video-example").hide();

            //     $("#videoLinkInput").val("").focus();
            // }
            // function getPackageVideos() {

            //     let videos = [];

            //     $("#videoPreviewList .video-preview-item").each(function () {

            //         let url = $(this)
            //             .find(".play-video")
            //             .attr("data-url");

            //         if (url) {

            //             videos.push({
            //                 url: url.trim(),
            //                 type: "video"
            //             });

            //         }

            //     });

            //     return videos;
            // }
            // $(document).ready(function () {

            //     // Hide example if videos already exist
            //     if ($("#videoPreviewList .video-preview-item").length > 0) {
            //         $(".video-example").hide();
            //     }

                

            //     // Button Click
            //     $("#addVideoBtn").on("click", function () {
            //         addVideoLink();
            //     });

            //     // Enter Key
            //     $("#videoLinkInput").on("keypress", function (e) {
            //         if (e.which === 13) {
            //             e.preventDefault();
            //             addVideoLink();
            //         }
            //     });

            //     // Play Video
            //     $(document).on("click", ".play-video", function () {
            //         window.open($(this).data("url"), "_blank");
            //     });

            //     // Delete Video
            //     $(document).on("click", ".delete-video", function () {

            //         $(this).closest(".video-preview-item").remove();

            //         if ($("#videoPreviewList .video-preview-item").length === 0) {
            //             $(".video-example").show();
            //         }
            //     });

            // });
            // let videoFiles = [];
            window.videoFiles = window.videoFiles || [];


            function addVideoFiles() {

                console.log("addVideoFiles() STARTED");

                const input = $("#videoFileInput")[0];

                console.log("Input:", input);

                if (!input) {

                    console.error("#videoFileInput NOT FOUND");
                    return;

                }

                console.log("Selected files:", input.files);
                console.log("File count:", input.files.length);


                const files = input.files;

                if (!files || files.length === 0) {

                    alert("Please select a video file.");
                    return;

                }


                const allowedExtensions = [
                    "mp4",
                    "webm",
                    "mov",
                    "avi",
                    "mkv",
                    "m4v"
                ];


                for (let file of files) {

                    console.log("Processing file:", file);


                    const extension = file.name
                        .split(".")
                        .pop()
                        .toLowerCase();


                    if (!allowedExtensions.includes(extension)) {

                        alert(
                            `"${file.name}" is not a supported video format.`
                        );

                        continue;
                    }


                    const exists = window.videoFiles.some(function (existingFile) {

                        return (
                            existingFile.name === file.name &&
                            existingFile.size === file.size
                        );

                    });


                    if (exists) {

                        alert(
                            `"${file.name}" has already been added.`
                        );

                        continue;
                    }


                    // IMPORTANT
                    window.videoFiles.push(file);


                    console.log(
                        "FILE PUSHED:",
                        file.name,
                        file.size,
                        file.type
                    );


                    const previewUrl = URL.createObjectURL(file);


                    const videoItem = `
                        <div
                            class="video-preview-item"
                            data-file-name="${file.name}"
                            data-file-size="${file.size}"
                            data-preview-url="${previewUrl}"
                        >

                            <div class="video-link-content">

                                <i
                                    class="fa-solid fa-play play-video"
                                    data-url="${previewUrl}"
                                    title="Play Video">
                                </i>

                                <span class="video-url">
                                    ${file.name}
                                </span>

                            </div>

                            <i
                                class="fa-solid fa-trash-can delete-video"
                                title="Delete">
                            </i>

                        </div>
                    `;


                    $("#videoPreviewList").append(videoItem);

                }


                $(".video-example").hide();

                $("#videoFileInput").val("");


                console.log(
                    "FINAL window.videoFiles:",
                    window.videoFiles
                );
            }


            function getPackageVideos() {

                let videos = [];

                window.videoFiles.forEach(function (file) {

                    videos.push({

                        name: file.name,

                        size: file.size,

                        type: "video"

                    });

                });

                return videos;
            }


            $(document).ready(function () {

                /*
                |--------------------------------------------------------------------------
                | Add Video
                |--------------------------------------------------------------------------
                */

                $(document).on("click", "#addVideoBtn", function () {

                    console.log("ADD VIDEO BUTTON CLICKED");

                    addVideoFiles();

                });


                /*
                |--------------------------------------------------------------------------
                | Play Video
                |--------------------------------------------------------------------------
                */

                $(document).on("click", ".play-video", function () {

                    const url = $(this).attr("data-url");

                    if (url) {

                        window.open(url, "_blank");

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | Delete Video
                |--------------------------------------------------------------------------
                */

                $(document).on("click", ".delete-video", function () {

                    const item = $(this).closest(".video-preview-item");

                    const fileName = item.attr("data-file-name");
                    const fileSize = Number(item.attr("data-file-size"));
                    const previewUrl = item.attr("data-preview-url");

                    /*
                    |--------------------------------------------------------------------------
                    | Remove preview URL from memory
                    |--------------------------------------------------------------------------
                    */

                    if (previewUrl) {

                        URL.revokeObjectURL(previewUrl);

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Remove from window.videoFiles
                    |--------------------------------------------------------------------------
                    */

                    window.videoFiles = window.videoFiles.filter(function (file) {

                        return !(
                            file.name === fileName &&
                            file.size === fileSize
                        );

                    });

                    /*
                    |--------------------------------------------------------------------------
                    | Remove preview
                    |--------------------------------------------------------------------------
                    */

                    item.remove();

                    /*
                    |--------------------------------------------------------------------------
                    | Show example when no videos remain
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $("#videoPreviewList .video-preview-item").length === 0
                    ) {

                        $(".video-example").show();

                    }

                });

            });
        </script>
        <!-- preload picture and media section  -->
        <script>
            let deletedGalleryImages = [];
            $(document).ready(function () {

                <?php foreach($packagePictures as $picture): ?>

                    <?php if($picture['type'] == 'cover_image'): ?>

                        // Cover Image
                        $("#packageCoverImage").attr("src", "../../<?= $picture['image'] ?>").removeClass("d-none");
                        $("#coverImageUrl").val("<?= $picture['image'] ?>");
                        $("#deleteImageBtn").show();

                    <?php elseif($picture['type'] == 'gallery_image'): ?>

                        // Existing Gallery Image
                        galleryImages.push({
                            id: <?= $picture['id'] ?>,          // DB id
                            src: "../../<?= $picture['image'] ?>",
                            url: "<?= $picture['image'] ?>",
                            file: null,
                            deleted: false,
                            existing: true
                        });

                    <?php elseif($picture['type'] == 'video'): ?>

                        // Existing Video
                        $("#videoPreviewList").append(`
                            <div class="video-preview-item">
                                <div class="video-link-content">
                                    <i class="fa-solid fa-play play-video"
                                        data-url="../../<?= $picture['image'] ?>"
                                        title="Play Video"></i>

                                    <span class="video-url"><?= $picture['image'] ?></span>
                                </div>

                                <i class="fa-solid fa-trash-can delete-video"
                                    title="Delete"></i>
                            </div>
                        `);

                        $(".video-example").hide();

                    <?php endif; ?>

                <?php endforeach; ?>

                // Refresh gallery using your existing function
                if (typeof renderGallery === "function") {
                    renderGallery();
                }

            });
        </script>
        <!-- package markup editable / save -->
        <script>
            const payoutDataNew = <?= json_encode($product_payout_data_new); ?>;
            const payoutData = <?= json_encode($product_payout_data); ?>;
            const payoutDataInsBm = <?= json_encode($institutionData); ?>;
            const payoutDataInsCte = <?= json_encode($institutionCteData); ?>;
            function formatCurrency(amount) {
                return "₹" + Number(amount).toLocaleString("en-IN");
            }
            // =========================================
            // EDIT
            // =========================================
            $(document).on("click", ".edit-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const comm = row.find(".editable-comm");
                const ins = row.find(".editable-ins");

                // Store original value only once
                if (comm.data("original") === undefined) {
                    comm.data("original", parseFloat(comm.data("value")) || 0);
                }

                if (ins.data("original") === undefined) {
                    ins.data("original", parseFloat(ins.data("value")) || 0);
                }

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


            // =========================================
            // SAVE
            // =========================================
            $(document).on("click", ".save-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");
                const totalCell = row.find(".editable-total");

                // Original values (saved when Edit is clicked)
                const originalComm = parseFloat(commCell.data("original")) || 0;
                const originalIns = parseFloat(insCell.data("original")) || 0;

                // New values entered by user
                const newComm = parseFloat(row.find(".comm-input").val()) || 0;
                const newIns = parseFloat(row.find(".ins-input").val()) || 0;

                // Save current value
                commCell
                    .data("value", newComm)
                    .data("edited", true)
                    .attr("data-value", newComm);

                insCell
                    .data("value", newIns)
                    .data("edited", true)
                    .attr("data-value", newIns);

                // Commission HTML
                let commHtml = `<div>₹ ${formatNumber(newComm)}</div>`;

                if (Math.abs(newComm - originalComm) > 0.001) {
                    commHtml += `
                        <small class="text-danger text-decoration-line-through">
                            ₹ ${formatNumber(originalComm)}
                        </small>
                    `;
                }

                commCell.html(commHtml);

                // Incentive HTML
                let insHtml = `<div>₹ ${formatNumber(newIns)}</div>`;

                if (Math.abs(newIns - originalIns) > 0.001) {
                    insHtml += `
                        <small class="text-danger text-decoration-line-through">
                            ₹ ${formatNumber(originalIns)}
                        </small>
                    `;
                }

                insCell.html(insHtml);

                // Total
                totalCell.html(`₹ ${formatNumber(newComm + newIns)}`);

                // Restore action buttons
                row.find("td:last").html(`
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="#" class="edit-price-distribution text-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>

                        <a href="#" class="reset-price-distribution text-warning">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                `);
                // CTE -> ETE -> STE -> TE
                updateTableTotals(
                    "#cteChainTable",
                    "#cteChainCommTotal",
                    "#cteChainInsTotal",
                    "#cteChainCommInsTotal"
                );

                // BM -> TE
                updateTableTotals(
                    "#bmTeTable",
                    "#bmTeChainCommTotal",
                    "#bmTeChainInsTotal",
                    "#bmTeChainCommInsTotal"
                );

                // BM Institution
                updateTableTotals(
                    "#bmITable",
                    "#bmIComTotal",
                    "#bmIInsTotal",
                    "#bmIComInsTotal"
                );

                // CTE Institution
                updateTableTotals(
                    "#iCteTable",
                    "#iCteComTotal",
                    "#iCteInsTotal",
                    "#iCteComInsTotal"
                );
                // console.log("Saved Successfully");
                calculateFinalValues();

            });


            // =========================================
            // CANCEL
            // =========================================
            $(document).on("click", ".cancel-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");

                const currentComm = parseFloat(commCell.data("value")) || 0;
                const currentIns = parseFloat(insCell.data("value")) || 0;

                commCell.html(`<div>${formatCurrency(currentComm)}</div>`);
                insCell.html(`<div>${formatCurrency(currentIns)}</div>`);

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
                commCell.removeData("edited");
                insCell.removeData("edited");

            });


            // =========================================
            // RESET
            // =========================================
            $(document).on("click", ".reset-price-distribution", function (e) {

                e.preventDefault();

                const row = $(this).closest("tr");

                const commCell = row.find(".editable-comm");
                const insCell = row.find(".editable-ins");
                const totalCell = row.find(".editable-total");

                const originalComm = parseFloat(commCell.data("original")) || 0;
                const originalIns = parseFloat(insCell.data("original")) || 0;

                commCell.data("value", originalComm);
                insCell.data("value", originalIns);
                
                commCell.html(`<div>${formatCurrency(originalComm)}</div>`);
                insCell.html(`<div>${formatCurrency(originalIns)}</div>`);

                totalCell.html(formatCurrency(originalComm + originalIns));

                row.find("td:last").html(`
                    <div class="d-flex gap-3">
                        <a href="#" class="edit-price-distribution text-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </div>
                `);
                commCell.removeData("edited");
                insCell.removeData("edited");
                calculateEverything();

            });

            //reusabe
            function updateTableTotals(tableSelector, commTotalId, insTotalId, grandTotalId) {

                let totalComm = 0;
                let totalIns = 0;

                $(`${tableSelector} tbody tr`).each(function () {

                    totalComm += Number($(this).find(".editable-comm").data("value")) || 0;
                    totalIns += Number($(this).find(".editable-ins").data("value")) || 0;

                });

                $(commTotalId).text(`₹ ${formatNumber(totalComm)}`);
                $(insTotalId).text(`₹ ${formatNumber(totalIns)}`);
                $(grandTotalId).text(`₹ ${formatNumber(totalComm + totalIns)}`);
            }
            $(document).ready(function () {
                getSubCategories(<?= (int)$package['sub_category_id']; ?>);
            });

            $(document).on('change', '#categoryId', function () {
                getSubCategories();
            });
        </script>
    </body>
</html>