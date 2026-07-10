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
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            /* 7/7/2026 */
            .textColor {
                color: #7c7c7c !important;
                text-decoration: none;
            }

            .textColor.active {
                color: blue !important;
                font-weight: 600;
            }

            .roundedCircle {
                background-color: #e9e9e9;
                color: #7c7c7c;
                border-radius: 50%;
                width: 32px;
                height: 32px;
                min-width: 32px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .roundedCircle.active {
                background-color: blue;
                color: #fff;
            }

            .hrRotate {
                display: flex;
                align-items: center;
            }

            .hrRotate hr {
                width: 40px;
                margin: 0;
            }

            /* Desktop */
            .stepper-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .btn-check:checked+.btn {
                color: #636bbd !important;
                background-color: #dedff1 !important;
                border: 2px solid #636bbd !important;
            }
            .btn-check+.btn {
                border: 2px solid #afafaf !important;
            }
            .borderHighlight {
                border: 1px solid #ced4da;
                border-radius: 5px;
            }
            .highlights-section {
                max-width: 100%;
                font-family: "Poppins", sans-serif;
                border: 1px solid #ced4da;
                border-radius: 5px;
            }
            .highlight-label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #4a4a4a;
                margin-bottom: 15px;
            }

            .highlight-container {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }

            .highlight-tag {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: #f3f4f8;
                color: #333;
                padding: 14px 18px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 500;
            }

            .remove-btn {
                cursor: pointer;
                color: #666;
                font-size: 20px;
                line-height: 1;
                transition: 0.3s;
            }

            .remove-btn:hover {
                color: #ff4d4f;
            }

            .add-highlight {
                margin-top: 20px;
            }

            .add-highlight a {
                color: #6366f1;
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
            }

            .add-highlight a:hover {
                text-decoration: underline;
            }
            /* Upload Icon Section */
            .upload-card{
                position:relative;
                min-height:170px;
                border:2px dashed #d7dff3;
                border-radius:12px;
                background:#fff;
                cursor:pointer;
                overflow:hidden;
                transition:.3s;
            }
            .upload-card:hover{
                border-color:#7c5cff;
            }
            .file-input{
                position:absolute;
                inset:0;
                opacity:0;
                cursor:pointer;
                z-index:5;
            }
            .upload-content{
                height:100%;
                padding:15px;
                text-align:center;
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:center;
            }
            .upload-content h6{
                font-weight:700;
                margin-bottom:5px;
            }
            .upload-content p{
                color:#6c757d;
                font-size:13px;
                margin-bottom:5px;
            }
            .upload-content small{
                color:#999;
            }
            .preview-wrapper{
                position:absolute;
                inset:0;
            }
            .preview-wrapper img{
                width:100%;
                height:100%;
                object-fit:cover;
            }
            .file-title{
                position:absolute;
                left:0;
                right:0;
                bottom:0;
                background:rgba(0,0,0,.75);
                color:#fff;
                padding:8px;
                font-size:13px;
                font-weight:600;
            }
            .pdf-preview{
                height:100%;
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:center;
            }
            .pdf-preview i{
                font-size:55px;
                color:#dc3545;
            }
            .upload-icon {
                width: 70px;
                height: 70px;
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .upload-icon i {
                font-size: 35px;
                color: #7c5cff;
            }

            .upload-icon img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                border-radius: 8px;
            }
            .titleCard {
                background-color: #d9ffd3;
                border-radius: 10px 10px 0px 0px;
                padding: 8px;
            }
            .inclusionTitle {
                color: #1b8a0a;
                font-size: 14px;
                font-weight: 900;
            }
            .exclusionTitleCard {
                background-color: #ffd3d3;
                border-radius: 10px 10px 0px 0px;
                padding: 8px;
            }
            .exclusionTitle {
                color: #8a0a0a;
                font-size: 14px;
                font-weight: 900;
            }
            .remarkTitleCard {
                background-color: #d3e3ff;
                border-radius: 10px 10px 0px 0px;
                padding: 8px;
            }
            .remarkTitle {
                color: #0a1f8a;
                font-size: 14px;
                font-weight: 900;
            }
            /* Price Visibility & Guest User Premium */
            .inputWidth {
                width: 200px !important;
            }
            .borderHighlight {
                transition: all 0.3s ease;
            }

            .borderHighlight.locked {
                opacity: 0.6;
            }
            .infoCardPrice {
                background-color: #d3d6ff;
                color: #2a0a8a;
                font-size: 14px;
                font-weight: 600;
                border-radius: 8px;
                padding: 10px;
            }
            /* Tablet & Mobile */
            @media (max-width: 1070px) {
                .stepper-nav {
                    justify-content: flex-start;
                    overflow-x: auto;
                    flex-wrap: nowrap;
                    gap: 15px;
                    padding-bottom: 10px;

                    /* Hide scrollbar if desired */
                    scrollbar-width: thin;
                }

                .stepper-nav .nav-link {
                    white-space: nowrap;
                    flex-shrink: 0;
                }

                .hrRotate {
                    flex-shrink: 0;
                }

                .hrRotate hr {
                    width: 30px;
                }
            }
            
            @media (max-width: 768px) {
                .highlight-tag {
                    font-size: 15px;
                    padding: 10px 14px;
                }
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
                                        <h4 id="package_form_picture_title" style="display: none">Add New Package - Pictures</h4>
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

                                                <a class="nav-link textColor step-link d-flex align-items-center gap-1" href="#">
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
                                                                        <input type="text" class="form-control" id="tour_days" name="tour_days" placeholder="Unique Code">
                                                                        <label for="tour_days" class="required">Location / Destination</label>
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
                                                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                                        <div class="form-floating">
                                                            <div class="form-control">
                                                                <input type="radio" name="package_type" value="trending" id="trending" checked>
                                                                <label style="padding-right:15px; padding-left: 5px;" for="trending">Trending</label>
                                                                <input type="radio" name="package_type" value="popular" id="popular">
                                                                <label style="padding-right:15px; padding-left: 5px;" for="popular">Popular</label>
                                                                <input type="radio" name="package_type" value="most-selling" id="most_selling">
                                                                <label style="padding-right:15px; padding-left: 5px;" for="most_selling">Most Selling</label>
                                                                <input type="radio" name="package_type" value="new-arrival" id="new_arrival">
                                                                <label style="padding-right:15px; padding-left: 5px;" for="new_arrival">New Arrival</label>
                                                            </div>
                                                            <label class="">Highlight Type <span class="required"></span></label>
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
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" id="package_keywords" name="package_keywords" value="" placeholder="Package Keywords" class="form-control">
                                                                <label for="package_keywords" class="required">Package Keywords</label>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="highlights-section p-3">
                                                                <label class="highlight-label">Package Keyword</label>
                                                                <div class="highlight-container" id="packageKeybord">
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
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>ETE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>STE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>TE | Franchisee</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                            <td>BDM | RM</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>BM | SF | MF</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>TE | Franchisee</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Institute</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>ETE</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Institute</td>
                                                                            <td class="text-end">1.25%</td>
                                                                            <td class="text-end">&#8377; 50,000</td>
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
                                                        <div class="col-lg-6">
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
                                                        
                                                        <!-- cancelation policy 23 jan 2025 SV-->
                                                        <div class="col-md-12">
                                                            <h4 class="pt-3 ps-3 fw-bolder">Cancellation Policy</h4>
                                                            <div class="form-group row">
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="can_per_1" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                                        <label for="can_per_1" class="required">30+ Days Before Travel (%) </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="can_per_2" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                                        <label for="can_per_1" class="required">15-30 Days Before Travel (%) </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 mt-3">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" id="can_per_3" name="cancel_per_1" value="" class="form-control" maxlength="3">
                                                                        <label for="can_per_1" class="required">less then 15 Days Before Travel (%)</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end added on 23 Jan SV-->
                                                            <div class="btn bg-primary col-sm-1 col-2 m-4 ms-3" id="package_form_pricing_nextBtn">
                                                                <a href="#" class="waves-effect waves-light btn-large" style=" color: white;">Next</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fifth Box Package Picture  -->
                                                <div id="package_form_picture" style="display: none;">
                                                    <div class="col-md-6 col-sm-12">
                                                        <label style="margin-top: -34px;font-size: 0.8rem;">Pictures:</label>
                                                        <div class="file-field input-field">
                                                            <div class="btn">
                                                                <!-- <span>Upload</span> -->
                                                                <input class="form-control" type="file" id="gallery-photo-add" accept=".jpg,.png,.jpeg" multiple>
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
                    "#package_form_picture"
                ];

                function showSection(target) {

                    // Hide all sections
                    sections.forEach(function (section) {
                        $(section).hide();
                    });

                    // Show selected section
                    $(target).show();

                    // Update active tab
                    $(".step-link").removeClass("active");
                    $(".roundedCircle").removeClass("active");

                    $('.step-link[href="' + target + '"]').addClass("active");
                    $('.step-link[href="' + target + '"] .roundedCircle').addClass("active");
                }

                // Initial load
                showSection("#package_form_general");

                // Nav click
                $(".step-link").on("click", function (e) {
                    e.preventDefault();

                    let target = $(this).attr("href");
                    showSection(target);
                });

                // Next buttons
                $("#package_form_general_nextBtn").click(function (e) {
                    e.preventDefault();
                    showSection("#package_form_extra");
                });

                $("#package_form_extra_nextBtn").click(function (e) {
                    e.preventDefault();
                    showSection("#package_form_itinerary");
                });

                $("#package_form_itinerary_nxtBtn").click(function (e) {
                    e.preventDefault();
                    showSection("#package_form_pricing");
                });

                $("#package_form_pricing_nextBtn").click(function (e) {
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

                let highlight = prompt("Enter Highlight");

                if (highlight && highlight.trim() !== "") {
                    let tag = document.createElement("div");
                    tag.className = "highlight-tag";

                    tag.innerHTML = `
                        ${highlight}
                        <span class="remove-btn">&times;</span>
                    `;

                    document.getElementById("highlightContainer").appendChild(tag);
                }
            });
            // Add New Package Keyword
            document.getElementById("addPackageKeywordBtn").addEventListener("click", function (e) {
                e.preventDefault();

                let keyword = prompt("Enter Package Keyword");

                if (keyword && keyword.trim() !== "") {
                    let tag = document.createElement("div");
                    tag.className = "highlight-tag";

                    tag.innerHTML = `
                        ${keyword}
                        <span class="remove-btn">&times;</span>
                    `;

                    document.getElementById("packageKeybord").appendChild(tag);
                }
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

                    let text = prompt(`Enter ${label}`);

                    if (text && text.trim() !== "") {

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

                $(document).on("click",
                    ".edit-inclusion, .edit-exclusion, .edit-remark, .edit-things",
                    function (e) {

                        e.preventDefault();

                        let textElement = $(this)
                            .closest("[class*='item']")
                            .find("p");

                        let currentText = textElement.text();

                        let updatedText = prompt("Edit Item", currentText);

                        if (updatedText && updatedText.trim() !== "") {
                            textElement.text(updatedText);
                        }
                    });

                // ====================
                // Delete
                // ====================

                $(document).on("click",
                    ".delete-inclusion, .delete-exclusion, .delete-remark, .delete-things",
                    function (e) {

                        e.preventDefault();

                        if (confirm("Delete this item?")) {
                            $(this)
                                .closest("[class*='item']")
                                .remove();
                        }
                    });
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
    </body>
</html>