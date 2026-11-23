<?php
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');
    include (__DIR__ .'/customer_model.php');
    include (__DIR__ .'/customer_mapping.php'); 
    $request_id = $_POST['request_id'] ?? '';

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Enquiries</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $base_url ?>assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="<?= $base_url ?>assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="<?= $base_url ?>assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="<?= $base_url ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= $base_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="<?= $base_url ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= $base_url ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $base_url ?>assets/css/prepareQuotation.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/customer_dashboard.css" />
        <?php if($customer_type== 'Premium') {?>
        <link rel="stylesheet" href="css/com_progress_card.css">
        <?php }?>
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <style>
            .custom-history-accordion .accordion-item {
                border: 1px solid #E5E7EB;
                border-radius: 10px;
                margin-bottom: 12px;
                overflow: hidden;
            }

            .custom-history-accordion .accordion-button {
                padding: 16px 20px;
                background: #fff;
                box-shadow: none;
                gap: 15px;
            }

            .custom-history-accordion .accordion-button:not(.collapsed) {
                background: #F8FAFC;
                color: #111827;
            }

            .accordion-heading-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                width: 100%;
                padding-right: 8px;
            }

            .accordion-heading-title {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 15px;
                font-weight: 600;
                color: #1F2937;
            }

            .accordion-heading-title > i {
                color: #2F6BFF;
                font-size: 17px;
            }

            .history-status {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 600;
                white-space: nowrap;
            }

            .edit-status {
                color: #2F6BFF;
            }

            .sent-status {
                color: #00A65A;
            }

            .custom-history-accordion .accordion-body {
                padding: 22px;
                border-top: 1px solid #E5E7EB;
            }

            .custom-history-accordion .form-label {
                font-size: 13px;
                font-weight: 600;
                color: #374151;
            }
            /* ==========================================
            UNIQBIZZ DATE TIME PICKER
            ========================================== */

            .ubx-datetime-wrapper {
                position: relative;
                width: 100%;
            }

            .ubx-datetime-input {
                width: 100%;
                padding: 12px 42px 12px 14px;
                border: 1px solid #dfe3eb;
                border-radius: 8px;
                font-size: 13px;
                color: #252b36;
                background: #fff;
                cursor: pointer;
                outline: none;
            }

            .ubx-datetime-input:focus {
                border-color: #635bff;
                box-shadow: 0 0 0 3px rgba(99, 91, 255, .10);
            }

            .ubx-datetime-icon {
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #635bff;
                pointer-events: none;
            }

            .ubx-picker {
                position: fixed !important;
                z-index: 999999 !important;
                display: none;

                width: 320px;
                max-width: calc(100vw - 24px);

                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                padding: 16px;

                box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);

                max-height: calc(100vh - 20px);
                overflow-y: auto;
            }

            .ubx-picker.ubx-picker-visible {
                display: block;
            }

            .ubx-month-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .ubx-month-nav {
                background: #f1f0ff;
                color: #635bff;
                border: none;
                border-radius: 7px;
                padding: 8px 12px;
                cursor: pointer;
            }

            .ubx-month-title {
                font-size: 14px;
                font-weight: 700;
                color: #252b36;
            }

            .ubx-weekdays,
            .ubx-calendar {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 5px;
                text-align: center;
            }

            .ubx-weekdays span {
                font-size: 11px;
                color: #9298a4;
                padding: 8px 0;
            }

            .ubx-day {
                border: none;
                background: transparent;
                border-radius: 8px;
                padding: 9px 0;
                cursor: pointer;
                font-size: 12px;
                color: #333;
            }

            .ubx-day:hover {
                background: #f0efff;
            }

            .ubx-day.ubx-selected {
                background: #635bff;
                color: #fff;
            }

            .ubx-day.ubx-today {
                border: 1px solid #635bff;
            }

            .ubx-day.ubx-empty {
                visibility: hidden;
            }

            .ubx-time-section {
                margin-top: 20px;
                border-top: 1px solid #eee;
                padding-top: 15px;
            }

            .ubx-time-title {
                font-size: 13px;
                font-weight: 700;
                margin-bottom: 12px;
            }

            .ubx-time-controls {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .ubx-time-controls input {
                width: 100%;
                padding: 10px 5px;
                border: 1px solid #dfe3eb;
                border-radius: 8px;
                text-align: center;
                font-size: 15px;
                outline: none;
            }

            .ubx-time-controls input:focus {
                border-color: #635bff;
            }

            .ubx-time-labels {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                text-align: center;
                font-size: 10px;
                color: #89909c;
                margin-top: 6px;
            }

            .ubx-picker-actions {
                display: flex;
                gap: 10px;
                margin-top: 18px;
            }

            .ubx-picker-actions button {
                flex: 1;
                padding: 10px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 700;
            }

            .ubx-apply {
                background: #635bff;
                color: #fff;
            }

            .ubx-cancel {
                background: #edf0f5;
                color: #424956;
            }


            .ubx-response-actions {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 15px;
                margin: 20px 0;
            }

            .ubx-action-card {
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
                min-height: 100px;
                padding: 16px;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                background: #fff;
                text-align: left;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .ubx-action-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                width: 44px;
                height: 44px;
                border-radius: 10px;
                font-size: 25px;
            }

            .ubx-action-content {
                display: flex;
                flex-direction: column;
                gap: 5px;
                flex: 1;
            }

            .ubx-action-content strong {
                font-size: 14px;
                font-weight: 700;
                color: #252b36;
            }

            .ubx-action-content small {
                font-size: 12px;
                line-height: 1.5;
                color: #6b7280;
            }

            .ubx-action-arrow {
                font-size: 20px;
                color: #9ca3af;
                flex-shrink: 0;
            }

            /* Approve */
            .ubx-action-approve .ubx-action-icon {
                background: #dcfce7;
                color: #15803d;
            }

            .ubx-action-approve:hover,
            .ubx-action-approve.active {
                border-color: #16a34a;
                background: #f0fdf4;
            }

            /* Reject */
            .ubx-action-reject .ubx-action-icon {
                background: #fee2e2;
                color: #dc2626;
            }

            .ubx-action-reject:hover,
            .ubx-action-reject.active {
                border-color: #dc2626;
                background: #fef2f2;
            }

            /* Request Changes */
            .ubx-action-changes .ubx-action-icon {
                background: #fef3c7;
                color: #b7791f;
            }

            .ubx-action-changes:hover,
            .ubx-action-changes.active {
                border-color: #d69e36;
                background: #fffbeb;
            }

            /* Selected card */
            .ubx-action-card.active {
                box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.04);
            }

            .ubx-action-card.active .ubx-action-arrow {
                color: #374151;
            }
            .ubx-other-reason {
                display: none;
            }

            /* Responsive */
            @media (max-width: 767px) {
                .ubx-response-actions {
                    grid-template-columns: 1fr;
                    gap: 10px;
                }

                .ubx-action-card {
                    min-height: 85px;
                    padding: 13px;
                }
            }

            @media (max-width: 400px) {
                .ubx-picker {
                    padding: 13px;
                }

                .ubx-day {
                    padding: 8px 0;
                }
            }
        </style>
    </head>
    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "customer_header.php" ?>
            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="$home_url $home_url cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->

            <?php include_once "customer_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        Enquirie<!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Enquiry</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?= $base_url_cust ?>enquiries_list.php">Enquiries List</a></li>
                                            <li class="breadcrumb-item active">Enquiry</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 End -->
                        <div class="row">
                            <div class="col-12">
                    <?php 
                        $stmt = $conn->prepare("
                            SELECT *
                            FROM request_details
                            WHERE request_id = :request_id
                            LIMIT 1
                        ");

                        $stmt->execute([
                            ':request_id' => $request_id
                        ]);

                        $requestData = $stmt->fetch(PDO::FETCH_ASSOC);
                        // ==========================================
                        // 1. FETCH MAIN REQUEST STATUS
                        // ==========================================

                        $mainStmt = $conn->prepare("
                            SELECT status
                            FROM request_details
                            WHERE request_id = :request_id
                            LIMIT 1
                        ");

                        $mainStmt->execute([
                            ':request_id' => $request_id
                        ]);

                        $mainRequestStatus = $mainStmt->fetchColumn();


                        // ==========================================
                        // 2. FETCH ALL REPLY RECORDS
                        // ==========================================

                        $replyStmt = $conn->prepare("
                            SELECT *
                            FROM request_details_reply
                            WHERE request_id = :request_id
                            ORDER BY id DESC
                        ");

                        $replyStmt->execute([
                            ':request_id' => $request_id
                        ]);
                        $replyRecords = $replyStmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (!$requestData) { ?>
                                <!-- No Enquiries Found -->
                                <div class="card border-0 shadow-sm rounded-4 text-center p-4 p-md-5">

                                    <div class="mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 75px; height: 75px; background: #eef5ff;">

                                            <i class="ri-inbox-archive-line"
                                            style="font-size: 36px; color: #3b82f6;"></i>

                                        </div>
                                    </div>

                                    <h5 class="fw-bold mb-2">No Enquiries Yet!</h5>

                                    <p class="text-muted mb-0 mx-auto" style="max-width: 430px; font-size: 14px; line-height: 1.7;">
                                        You haven't made any travel enquiries yet.
                                        Explore our exciting travel packages and send us an enquiry.
                                        Your enquiry details and updates will appear here.
                                    </p>

                                </div>
                    <?php }else{ 
                        // Get package_id from the latest record
                        $package_id = $requestData['package_id'] ?? 0;
                        $reply_id = $requestData['id'] ?? 0;

                        include(__DIR__ . '/ajax/tour_details_data.php');
                    ?>
                                <div class="accordion custom-history-accordion" id="formHistoryAccordion">
                                <!-- Section 1 -->
                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="headingCustomer">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseCustomer"
                                            aria-expanded="false"
                                            aria-controls="collapseCustomer">

                                            <div class="accordion-heading-content">
                                                <div class="accordion-heading-title">
                                                    <i class="fa-solid fa-user-pen"></i>
                                                    Quotation Sent
                                                </div>

                                                <!-- No history -->
                                                <!-- <span class="history-status edit-status">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    Edit
                                                </span> -->

                                                <!-- Show this instead when history exists -->
                                                
                                                <span class="history-status sent-status">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Sent by <?= $requestData['guestFullName'] ?> · <?= !empty($requestData['created_date'])
                                                                ? date('d M Y, h:i A', strtotime($requestData['created_date']))
                                                                : 'N/A'; ?>
                                                </span>
                                                

                                            </div>

                                        </button>
                                    </h2>
                                    <div
                                        id="collapseCustomer"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="headingCustomer"
                                        data-bs-parent="#formHistoryAccordion">

                                        <div class="accordion-body">
                                            <!-- start page title -->
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="pb-2 px-2">
                                                        <h4 class="mb-sm-0 font-size-18">Quotation Sent</h4>
                                                        <p class="fontSize12">Track your submitted travel request and check the quotation status and updates from our team.</p>
                                                    </div>
                                                </div>
                                                <div class="col-3 d-flex justify-content-end gap-3 pe-4">
                                                    <div class="shareLinksBtn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </div>
                                                    <div class="shareLinksBtn">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </div>
                                                    <div class="shareLinksBtn">
                                                        <i class="fa-solid fa-print"></i>
                                                    </div>
                                                    <div class="shareLinksBtn2">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end page title -->
                                            <!-- Card Section 1 Start -->
                                            <div class="row rowAlignment">
                                                <div class="col-12">
                                                    <div class="card cardShadow">
                                                        <div class="d-flex tabDisplayBlock">
                                                            <div class="p-2 imageWrapper">
                                                                <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="prepareQuotationImg">
                                                            </div>
                                                            <div class="p-3 widthStretch">
                                                                <div class="packageIDBtn">
                                                                    <?= $package['unique_code'] ?>
                                                                </div>
                                                                <p class="fw-bolder textDarkBlue mb-1 fs-4" id=""><?= $package['name'] ?></p>
                                                                <p class="fw-bold textDarkBlue mb-1 fs-5" id="">
                                                                    <?= $package['description'] ?>
                                                                </p>
                                                                <div class="d-flex gap-4 redIcons laptopDisplay">
                                                                    <p class="fontSize12 mb-3">
                                                                        <i class="fa-solid fa-location-dot me-2"></i>
                                                                        <?= $package['destination'] ?>
                                                                    </p>
                                                                    <p class="fontSize12 mb-3">
                                                                        <i class="fa-regular fa-calendar me-2"></i>
                                                                        <?= $tour_nights ?> Nights / <?= $tour_days ?> Days
                                                                    </p>
                                                                    <p class="fontSize12 mb-3">
                                                                        <i class="fa-solid fa-utensils me-2"></i>
                                                                        Meals: <?= $meal_cat['name'] ?>
                                                                    </p>
                                                                </div>
                                                                <p class="fontSize12 mb-3">
                                                                    <?= $package['detailed_description'] ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Section 1 End -->
                                            <!-- Card Section 2 Start -->
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <!-- Card Section 2 subsection 1 Start -->
                                                    <div class="card p-3">
                                                        <h5 class="fw-bold textDarkBlue">
                                                            <i class="fa-solid fa-clipboard-list fa-xl me-3"></i>
                                                            Enquiry Information
                                                        </h5>
                                                        <div class="row">
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-0">Enquiry ID :</p>
                                                                <p class="fs-6 mb-0 fw-bold"><?= $request_id ?></p>
                                                            </div>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-0">Received On :</p>
                                                                <p class="fs-6 mb-0 fw-bold">
                                                                    <?= !empty($requestData['created_date'])
                                                                        ? date('d M Y, h:i A', strtotime($requestData['created_date']))
                                                                        : 'N/A'; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Card Section 2 subsection 1 End -->
                                                    <!-- Card Section 2 subsection 2 Start -->
                                                    <div class="card p-3">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <h5 class="fw-bold textDarkBlue">
                                                                <i class="fa-solid fa-user fa-xl me-3"></i>
                                                                Customer Information
                                                            </h5>
                                                            <!-- <a class="editCustomerBtn">
                                                                <i class="fa-solid fa-pen me-1"></i>
                                                                Edit
                                                            </a> -->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Full Name :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestFullName'] ?></p>
                                                            </div>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Mobile :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestPhone'] ?></p>
                                                            </div>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Email :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $requestData['guestEmail'] ?></p>
                                                            </div>
                                                            <!-- <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Address :</p>
                                                                <p class="fs-6 mb-2 fw-bold">Mumbai, Maharashtra</p>
                                                            </div> -->
                                                            <?php if($requestData['userId'] != 'null'){
                                                            ?>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Customer Type :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                                            </div>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Member Id :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $requestData['userId'] ?></p>
                                                            </div>
                                                            <!-- <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Travel Consultant :</p>
                                                                <p class="fs-6 mb-2 fw-bold">-</p>
                                                            </div> -->
                                                            <?php }else{ ?>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Customer Type :</p>
                                                                <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                                            </div>
                                                            <div class="col-xl-6 d-flex gap-2">
                                                                <p class="fs-6 mb-2">Member Id :</p>
                                                                <p class="fs-6 mb-2 fw-bold">NA</p>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <!-- Card Section 2 subsection 2 End -->
                                                    <!-- Card Section 2 subsection 3 Start -->
                                                    <div class="card p-3">
                                                        <h5 class="fw-bold textDarkBlue">
                                                            <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                                            Trip Request <span class="fw-normal">(Submitted by Customer)</span>
                                                        </h5>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Travel Start Date</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput1" value="<?= $requestData['travel_start_date'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput2" class="form-label">Travel End Date</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput2" value="<?= $requestData['travel_end_date'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput3" class="form-label">Nights / Days</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput3" value="<?= $requestData['no_of_nights_days'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput4" class="form-label">Pickup</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput4" value="<?= $requestData['customer_pickup'] != '' ? $requestData['customer_pickup']: $requestData['pickup_point'] ?>" readonly>
                                                                    <?php
                                                                        $oldPickup = !empty($requestData['customer_pickup'])
                                                                        ? $requestData['pickup_point']
                                                                        : '';
                                                                    ?>

                                                                    <?php if ($oldPickup !== ''): ?>
                                                                        <small class="old-value-text text-muted"
                                                                            id="pickupOldValue">
                                                                            Previous Pickup: </br> 
                                                                            <?= htmlspecialchars($oldPickup, ENT_QUOTES, 'UTF-8') ?>
                                                                        </small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput5" class="form-label">Drop</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput5" value="<?= $requestData['customer_drop'] != '' ? $requestData['customer_drop']: $requestData['drop_point'] ?>" readonly>
                                                                    <?php
                                                                        $olddrop = !empty($requestData['customer_drop'])
                                                                        ? $requestData['drop_point']
                                                                        : '';
                                                                    ?>

                                                                    <?php if ($olddrop !== ''): ?>
                                                                        <small class="old-value-text text-muted"
                                                                            id="dropOldValue">
                                                                            Previous Drop: </br> 
                                                                            <?= htmlspecialchars($olddrop, ENT_QUOTES, 'UTF-8') ?>
                                                                        </small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row paxRow">
                                                            <div class="col-xl-3 paxCol">
                                                                <div class="mb-3">
                                                                    <label for="adultCount" class="form-label">Adults (12+ yrs)</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="adultCount" value="<?= $requestData['adult_count'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 paxCol">
                                                                <div class="mb-3">
                                                                    <label for="childcount" class="form-label">Children (2-11 yrs)</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="childcount" value="<?= $requestData['child_count'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 paxCol">
                                                                <div class="mb-3">
                                                                    <label for="infantCount" class="form-label">Infants (0-1 yrs)</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="infantCount" value="<?= $requestData['infant_count'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 paxCol">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput9" class="form-label">Total Pax</label>
                                                                    <input type="text" class="form-control fw-bold textDarkBlue" id="exampleFormControlInput9" value="<?= $requestData['adult_count'] + $requestData['child_count'] + $requestData['infant_count'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Card Section 2 subsection 3 End -->
                                                    <!-- Card Section 2 subsection 4 Start -->
                                                    <div class="card p-3">
                                                        <h5 class="fw-bold textDarkBlue">
                                                            <i class="fa-solid fa-bed fa-xl me-3"></i>
                                                            Room Allocation <span class="fw-normal">(Requested by Customer)</span>
                                                        </h5>
                                                        
                                                        <?php
                                                            $rooms = json_decode($requestData['rooms'] ?? '[]', true);

                                                            if (!is_array($rooms)) {
                                                                $rooms = [];
                                                            }

                                                            $totalRooms = count($rooms);

                                                            $adultCount  = (int)($requestData['adult_count'] ?? 0);
                                                            $childCount  = (int)($requestData['child_count'] ?? 0);
                                                            $infantCount = (int)($requestData['infant_count'] ?? 0);

                                                            $totalTravellers = $adultCount + $childCount + $infantCount;

                                                            $bedCounts = [];
                                                            $totalExtraMattresses = 0;
                                                            $recommendations = [];

                                                            foreach ($rooms as $room) {
                                                                $description = trim($room['description'] ?? '');

                                                                // Count extra mattresses separately.
                                                                if (preg_match_all(
                                                                    '/(\d+)\s*Extra\s*Mattress(?:es)?/i',
                                                                    $description,
                                                                    $mattressMatches
                                                                )) {
                                                                    foreach ($mattressMatches[1] as $quantity) {
                                                                        $totalExtraMattresses += (int)$quantity;
                                                                    }
                                                                }

                                                                // Remove the entire extra mattress phrase from the room description.
                                                                $description = preg_replace(
                                                                    '/\s*\+?\s*\d+\s*Extra\s*Mattress(?:es)?/i',
                                                                    '',
                                                                    $description
                                                                );

                                                                // Clean up leftover separators and spaces.
                                                                $description = trim($description, " \t\n\r\0\x0B,+-");

                                                                // Process only bed types now.
                                                                $bedItems = preg_split('/\s*\+\s*|\s*,\s*/', $description);

                                                                foreach ($bedItems as $item) {

                                                                    $item = trim($item);

                                                                    if ($item === '') {
                                                                        continue;
                                                                    }

                                                                    $quantity = 1;

                                                                    if (preg_match('/^(\d+)\s+(.+)$/i', $item, $matches)) {
                                                                        $quantity = (int)$matches[1];
                                                                        $item = trim($matches[2]);
                                                                    }

                                                                    // Safety check: never allow a mattress into the bed summary.
                                                                    if (stripos($item, 'mattress') !== false) {
                                                                        continue;
                                                                    }

                                                                    if ($quantity <= 0 || $item === '') {
                                                                        continue;
                                                                    }

                                                                    $item = preg_replace('/\bBeds\b/i', 'Bed', $item);
                                                                    $key = strtolower(trim($item));

                                                                    if (!isset($bedCounts[$key])) {
                                                                        $bedCounts[$key] = [
                                                                            'name' => trim($item),
                                                                            'count' => 0
                                                                        ];
                                                                    }

                                                                    $bedCounts[$key]['count'] += $quantity;
                                                                }

                                                                // Keep recommendations unique.
                                                                $recommendation = trim($room['recommendation'] ?? '');

                                                                if (
                                                                    $recommendation !== '' &&
                                                                    !in_array($recommendation, $recommendations, true)
                                                                ) {
                                                                    $recommendations[] = $recommendation;
                                                                }
                                                            }

                                                            /*
                                                            * 5. Build the combined room type summary.
                                                            */
                                                            $roomTypeSummary = [];

                                                            foreach ($bedCounts as $bed) {

                                                                $count = $bed['count'];
                                                                $name = $bed['name'];

                                                                if (preg_match('/\bBed\b/i', $name)) {
                                                                    $name = preg_replace(
                                                                        '/\bBed\b/i',
                                                                        $count === 1 ? 'Bed' : 'Beds',
                                                                        $name
                                                                    );
                                                                }

                                                                $roomTypeSummary[] = $count . ' ' . $name;
                                                            }

                                                            $roomTypeText = implode(', ', $roomTypeSummary);
                                                        ?>

                                                        <div class="row">
                                                            <div class="col-xl-12">

                                                                <table class="table table-bordered mb-0 fs-6">
                                                                    <thead>
                                                                        <tr class="table-active">
                                                                            <th scope="col">Room Count</th>
                                                                            <th scope="col">Travellers</th>
                                                                            <th scope="col">Room Type</th>
                                                                            <th scope="col">Extra Mattress</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody class="fs-6">
                                                                        <?php if (!empty($rooms)): ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?= $totalRooms ?>
                                                                                    <?= $totalRooms === 1 ? 'Room' : 'Rooms' ?>
                                                                                </td>

                                                                                <td>
                                                                                    <?= $totalTravellers ?>
                                                                                    (<?= $adultCount ?> Adults +
                                                                                    <?= $childCount ?> Children +
                                                                                    <?= $infantCount ?> Infants)
                                                                                </td>

                                                                                <td>
                                                                                    <?= htmlspecialchars(
                                                                                        $roomTypeText !== '' ? $roomTypeText : 'N/A',
                                                                                        ENT_QUOTES,
                                                                                        'UTF-8'
                                                                                    ) ?>
                                                                                </td>

                                                                                <td>
                                                                                    <?php if ($totalExtraMattresses > 0): ?>
                                                                                        <?= $totalExtraMattresses ?>
                                                                                        <?= $totalExtraMattresses === 1
                                                                                            ? 'Extra Mattress'
                                                                                            : 'Extra Mattresses' ?>
                                                                                    <?php else: ?>
                                                                                        N/A
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php else: ?>
                                                                            <tr>
                                                                                <td colspan="4" class="text-center">
                                                                                    No room details available.
                                                                                </td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    </tbody>
                                                                </table>

                                                                <?php if (!empty($rooms)): ?>
                                                                    <div class="paxDescriptionBtn d-flex">
                                                                        <i class="fa-solid fa-circle-user paxColor fa-lg align-content-center me-2"></i>

                                                                        <span>
                                                                            <?= $totalTravellers ?>
                                                                            <?= $totalTravellers === 1 ? 'traveller' : 'travellers' ?>
                                                                            will be accommodated in
                                                                            <?= $totalRooms ?>
                                                                            <?= $totalRooms === 1 ? 'room' : 'rooms' ?>.

                                                                            <?php if (!empty($recommendations)): ?>
                                                                                <br>
                                                                                <?= htmlspecialchars(
                                                                                    implode(', ', $recommendations),
                                                                                    ENT_QUOTES,
                                                                                    'UTF-8'
                                                                                ) ?>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                <?php endif; ?>

                                                            </div>
                                                        </div>



                                                    </div>
                                                    <!-- Card Section 2 subsection 4 End -->
                                                    <!-- Card Section 2 subsection 5 Start -->
                                                    <div class="card p-3">
                                                        <h5 class="fw-bold textDarkBlue">
                                                            <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                                            Customer Preferences <span class="fw-normal">(Submitted by Customer)</span>
                                                        </h5>
                                                        <div class="row">
                                                            <!-- HOTEL CATEGORY -->
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="hotelCategory" class="form-label fontSize10">
                                                                        Hotel Category
                                                                    </label>
                                                                    <div class="icon-select-wrapper">
                                                                        <i class="ri-hotel-line iconPosition iconRed"></i>
                                                                        <?php
                                                                        $sql = $conn->prepare("
                                                                            SELECT id, name
                                                                            FROM category_hotel
                                                                            WHERE status = 1
                                                                            ORDER BY id DESC
                                                                        ");
                                                                        $sql->execute();
                                                                        $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                        ?>
                                                                        <select id="hotelCategory" class="form-select fontSize10 paddingLeft" name="hotel_category" disabled>
                                                                            <option value="">Select Hotel</option>

                                                                            <?php foreach ($hotelCategories as $hotel): ?>
                                                                                <option
                                                                                    value="<?= htmlspecialchars($hotel['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                                                    <?= ((string)$hotel['id'] === (string)($requestData['hotel_category'] ?? '')) ? 'selected' : '' ?>
                                                                                >
                                                                                    <?= htmlspecialchars($hotel['name'], ENT_QUOTES, 'UTF-8') ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <!-- OLD VALUE -->
                                                                    <div id="oldHotelCategory" class="text-muted fontSize10 d-none mt-2"></div>
                                                                </div>
                                                            </div>
                                                            <!-- MEAL PREFERENCE -->
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="mealPreference" class="form-label fontSize10">
                                                                        Meal Preference
                                                                    </label>
                                                                    <div class="icon-select-wrapper">
                                                                        <i class="ri-restaurant-line iconPosition iconRed"></i>
                                                                        <?php
                                                                        $sql = $conn->prepare("
                                                                            SELECT id, name
                                                                            FROM category_meal
                                                                            WHERE status = 1
                                                                            ORDER BY id DESC
                                                                        ");
                                                                        $sql->execute();
                                                                        $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                        ?>
                                                                        <select id="mealPreference" class="form-select fontSize10 paddingLeft" name="meal_preference" disabled>
                                                                            <option value="">Select Meal</option>
                                                                            <?php foreach ($mealCategories as $meal_cat): ?>
                                                                                <option value="<?= htmlspecialchars($meal_cat['id']) ?>" 
                                                                                <?= ($requestData['meal_preference'] == $meal_cat['id']) ? 'selected' : '' ?>>
                                                                                    <?= htmlspecialchars($meal_cat['name']) ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <!-- OLD VALUE -->
                                                                    <div id="oldMealPreference" class="text-muted fontSize10 d-none mt-2"></div>
                                                                </div>
                                                            </div>
                                                            <!-- TRANSPORT -->
                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="transportPreference" class="form-label fontSize10">
                                                                        Transport Preference
                                                                    </label>
                                                                    <div class="icon-select-wrapper">
                                                                        <i class="ri-car-line iconPosition iconRed"></i>
                                                                        <?php
                                                                        $sql = $conn->prepare("
                                                                            SELECT id, name
                                                                            FROM category_vehicle
                                                                            WHERE status = 1
                                                                            ORDER BY id DESC
                                                                        ");
                                                                        $sql->execute();
                                                                        $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                        ?>
                                                                        <select id="transportPreference" class="form-select fontSize10 paddingLeft" name="transport_preference" disabled>
                                                                            <option value="">Select Vehicle</option>
                                                                            <?php foreach ($vehicleCategories as $vehicle_cat): ?>
                                                                                <option value="<?= htmlspecialchars($vehicle_cat['id']) ?>" 
                                                                                <?= ($requestData['transport_preference'] == $vehicle_cat['id']) ? 'selected' : '' ?>>
                                                                                    <?= htmlspecialchars($vehicle_cat['name']) ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <!-- OLD VALUE -->
                                                                    <div id="oldTransportPreference" class="text-muted fontSize10 d-none mt-2"></div>
                                                                </div>
                                                            </div>
                                                            <!-- SPECIAL REQUIREMENT -->
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="mb-0">
                                                                    <label for="specialRequirement" class="form-label fontSize10">Special Requirements (Optional)</label>
                                                                    <textarea
                                                                        class="form-control fontSize10"
                                                                        id="specialRequirement"
                                                                        name="special_requirement"
                                                                        placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."
                                                                        style="text-align: left;"
                                                                        readonly
                                                                    ><?= htmlspecialchars(trim($requestData['special_requirement'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Card Section 2 subsection 5 End -->
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="card cardShadow">
                                                        <div class="quick-header p-3">
                                                            <div class="d-flex gap-2">
                                                                <i class="fa-solid fa-location-dot fa-xl align-content-center quickIcon"></i>
                                                                <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Quick Action</h5>
                                                            </div>
                                                        </div>
                                                        <div class="px-3">
                                                            <p class="mb-2 fw-bold blueDiv">Base Price (Per Person)</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <p class="mb-1">Adult (12+ yrs)</p>
                                                                    <p class="mb-1">Child (2-11 yrs)</p>
                                                                    <p class="mb-1">Infant (0-1 yrs)</p>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1 text-end">&#8377; <?= number_format($adultDisplayPriceRD, 2) ?></p>
                                                                    <p class="mb-1 text-end">&#8377; <?= number_format($childDisplayPriceRD, 2) ?></p>
                                                                    <p class="mb-1 text-end">FREE</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="p-3 pb-0">
                                                            <p class="mb-2 fw-bold blueDiv">Price Based on Travelers</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <p class="mb-1">Adult: <span class="" id="totalAdultCount"><?= $requestData['adult_count'] ?></span> x &#8377; <?= number_format($adultDisplayPriceRD, 2) ?></p>
                                                                    <p class="mb-1">Children: <span class="" id="totalChildrenCount"><?= $requestData['child_count'] ?></span> x &#8377; <?= number_format($childDisplayPriceRD, 2) ?></p>
                                                                    <p class="mb-1">Infant: <span class="" id="totalInfantCount"><?= $requestData['infant_count'] ?></span> x FREE</p>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1 text-end" id="adultTotal">&#8377; <?= number_format($requestData['adult_total'], 2) ?></p>
                                                                    <p class="mb-1 text-end" id="childrenTotal">&#8377; <?= number_format($requestData['children_total'], 2) ?></p>
                                                                    <p class="mb-1 text-end">&#8377; 0.00</p>
                                                                </div>
                                                            </div>
                                                            <hr class="my-1 border border-2 mx-0">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                                                <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">&#8377; <?= number_format($requestData['subtotal'], 2) ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <div class="p-3">
                                                            <p class="fw-bold">Transport</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <p class="fontSize10" id=""><?= $requestData['transport_type'] ?></p>
                                                                    <!-- <a href="#" class="fontSize10 text-primary" id="changeVehicle">Change Vehicle</a> -->
                                                                </div>
                                                                <div>
                                                                    <!-- <p class="fontSize10 text-end">Included</p> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <?php if($Requester_type  == 'Neo Select'){  ?>
                                                        <!-- <hr class="my-1 border border-2 mx-3"> -->
                                                        <div class="p-3 pb-0">
                                                            <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                                                Apply Coupons
                                                                <span class="text-muted fw-normal fontSize12">
                                                                    (One coupon per passenger)
                                                                    <i class="ri-error-warning-line"></i>
                                                                </span>
                                                            </p>
                                                            <div id="couponPassengerContainer0" class="coupon-passenger-container">
                                                                    <div class="saved-coupon-display">

                                                                        <?php
                                                                        $couponsToLoad0 = json_decode($requestData['coupons'] ?? '[]', true) ?: [];

                                                                        foreach ($couponsToLoad0 as $coupon) {

                                                                            // Exclude CU coupons
                                                                            if (strtoupper(trim($coupon['type'] ?? '')) === 'CU') {
                                                                                continue;
                                                                            }

                                                                            $couponCode = trim($coupon['code'] ?? '');

                                                                            if ($couponCode === '') {
                                                                                continue;
                                                                            }

                                                                            $passenger = $coupon['passenger'] ?? 'Coupon';
                                                                            $amount = (float) ($coupon['amount'] ?? 0);
                                                                        ?>

                                                                            <div class="d-flex justify-content-between mb-2 coupon-passenger-row">

                                                                                <div class="d-flex gap-3 largeDisplay">

                                                                                    <p class="fontSize10 align-content-end mb-0 coupon-passenger">
                                                                                        <?= htmlspecialchars($passenger) ?>
                                                                                    </p>

                                                                                    <p class="mb-0">
                                                                                        <select class="form-select fontSize10 selectPadding coupon-select" disabled>
                                                                                            <option value="<?= htmlspecialchars($couponCode) ?>" selected>
                                                                                                <?= htmlspecialchars($couponCode) ?>
                                                                                            </option>
                                                                                        </select>
                                                                                    </p>

                                                                                </div>

                                                                                <p class="fontSize10 discountGreen fw-bold text-end align-content-end mb-0 coupon-discount">
                                                                                    - ₹ <?= $amount ?>
                                                                                </p>

                                                                            </div>

                                                                        <?php } ?>

                                                                    </div>

                                                                </div>
                                                            
                                                        </div>
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <div class="d-flex justify-content-between px-3">
                                                            <p class="fontSize10 discountGreen fw-bold">
                                                                Discounts (Coupons)
                                                            </p>
                                                            <p class="fontSize10 discountGreen fw-bold text-end"
                                                            id="totalCouponDiscount0">
                                                                - ₹ <?= $requestData['coupon_discount'] ?>
                                                            </p>
                                                        </div>
                                                        <?php
                                                        $referralWalletBalance = $referralBalance ?? 0;
                                                        $discountWalletBalance = $discountBalance ?? 0;
                                                        ?>

                                                        <!-- <hr class="my-1 border border-2 mx-3"> -->

                                                        <div class="d-flex justify-content-between align-items-center px-3">

                                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                Referral Wallet
                                                            </p>

                                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                                            id="referralWalletBalance">
                                                                ₹ <?= number_format($referralWalletBalance, 2) ?>
                                                            </p>

                                                            <div class="d-flex align-items-center">
                                                                <span class="fontSize10 discountGreen fw-bold me-1">
                                                                    - ₹
                                                                </span>
                                                                <input type="number" class="form-control form-control-sm walletInput" id="appliedReferralWallet" value="<?= $requestData['referral_wallet_amount'] ?>" min="0" step="1" disabled style="width: 80px;">
                                                            </div>
                                                        </div>
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <div class="d-flex justify-content-between align-items-center px-3">
                                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                Discount Wallet
                                                            </p>
                                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                                            id="discountWalletBalance">
                                                                ₹ <?= number_format($discountWalletBalance, 2) ?>
                                                            </p>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fontSize10 discountGreen fw-bold me-1">
                                                                    - ₹
                                                                </span>
                                                                <input type="number" class="form-control form-control-sm walletInput" id="appliedDiscountWallet" value="0" min="0" step="1" disabled style="width: 80px;">
                                                            </div>
                                                        </div>
                                                        <?php } elseif ($Requester_type != 'Neo Select') {?>
                                                        <!-- <hr class="my-2 border border-2 mx-3"> -->
                                                        <div class="p-3 pb-0">
                                                            <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                                                Apply Coupons
                                                                <span class="text-muted fw-normal fontSize12">
                                                                    Only one coupon can be applied per package
                                                                    <i class="ri-error-warning-line"></i>
                                                                </span>
                                                            </p>
                                                            <div id="couponPassengerContainer0" class="coupon-passenger-container"></div>
                                                        </div>
                                                        <!-- TOTAL -->
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                                            <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                <i class="ri-price-tag-3-line"></i>
                                                                Discounts (Coupon)
                                                            </p>
                                                            <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="totalCouponDiscount0">- ₹ <?= $requestData['coupon_discount'] ?></p>
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <hr class="my-2 border border-2 mx-3">
                                                        <div class="p-3">
                                                            <p class="fw-bold blueDiv">Adjustments</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <p class="mb-1">Extra Mattress (1 x &#8377; <?= $pricing['extra_mattress'] ?>)</p>
                                                                    <p class="mb-1">GST (<?= $requestData['gst_percentage'] ?>%) </p>
                                                                    <p class="mb-1">Convenience Fee </p>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-1 text-end" id="#">&#8377; <?= $totalExtraMattresses * $pricing['extra_mattress'] ?></p>
                                                                    <p class="mb-1 text-end">&#8377; <?= $requestData['gst'] ?></p>
                                                                    <p class="mb-1 text-end" id="#">&#8377; <?= $requestData['convenience_fee'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="my-1 border border-2 mx-3">
                                                        <div class="p-3 pb-0">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <p class="fs-5 textDarkBlue fw-bold">Total Estimated Price</p>
                                                                </div>
                                                                <div>
                                                                    <p class="fs-5 text-danger fw-bolder text-end" id="">&#8377; <?= number_format($requestData['final_price'], 2) ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Section 2 subsection 6 Start -->
                                            <div class="card p-3">
                                                <h5 class="fw-bold textDarkBlue">
                                                    <i class="fa-solid fa-file-lines fa-xl me-3"></i>
                                                    Package Information <span class="fw-normal">(From Package Master)</span>
                                                </h5>
                                                <div class="row paxRow mt-1 mb-2">
                                                    <div class="col-xl-2 paxCol">
                                                        <p class="fs-6 mb-1">Package ID</p>
                                                        <p class="fs-6 fw-bold mb-2"><?= $package['unique_code'] ?></p>
                                                    </div>
                                                    <div class="col-xl-10">
                                                        <div class="row paxRow">
                                                            <div class="col-xl-4 paxCol">
                                                                <p class="fs-6 mb-1">Destination</p>
                                                                <p class="fs-6 fw-bold mb-2"><?= $package['name'] ?></p>
                                                            </div>
                                                            <div class="col-xl-4 paxCol">
                                                                <p class="fs-6 mb-1">Duration</p>
                                                                <p class="fs-6 fw-bold mb-2"><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</p>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <p class="fs-6 mb-1">Package Type</p>
                                                                <p class="fs-6 fw-bold mb-2"><?= $package['category_id'] == 2 ? 'Domestic':($package['category_id'] == 1 ?'International':'NA') ?></p>
                                                            </div>
                                                            <div class="col-xl-6 paxCol">
                                                                <p class="fs-6 mb-1">Pacakge Category</p>
                                                                <p class="fs-6 fw-bold mb-2"><?= $package['package_type'] ?></p>
                                                            </div>
                                                            <div class="col-xl-6 paxCol">
                                                                <p class="fs-6 mb-1">Valid Travel Period</p>
                                                                <p class="fs-6 fw-bold mb-2">
                                                                    Valid Till <?= date('d-m-Y', strtotime($package['validity'])) ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nav-placeholder"></div>
                                                <div class="sticky-nav-wrapper">
                                                    <div class="borderColor1 cardShadow p-2">
                                                        <ul class="nav nav-underline justify-content-between">
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0 active" aria-current="page" href="#overview">
                                                                    <div class="text-center">
                                                                        <i class="ri-dashboard-line"></i>
                                                                    </div>
                                                                    Overview
                                                                </a>
                                                            </li>
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0" href="#itinerary">
                                                                    <div class="text-center">
                                                                        <i class="ri-route-line"></i>
                                                                    </div>
                                                                    Itinerary
                                                                </a>
                                                            </li>
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0" href="#inclusion">
                                                                    <div class="text-center">
                                                                        <i class="ri-dashboard-line"></i>
                                                                    </div>
                                                                    Inclusions
                                                                </a>
                                                            </li>
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0" href="#inclusion">
                                                                    <div class="text-center">
                                                                        <i class="ri-dashboard-line"></i>
                                                                    </div>
                                                                    Exclusions
                                                                </a>
                                                            </li>
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0" href="#policies">
                                                                    <div class="text-center">
                                                                        <i class="ri-dashboard-line"></i>
                                                                    </div>
                                                                    Policies
                                                                </a>
                                                            </li>
                                                            <li class="nav-item navItem">
                                                                <a class="nav-link pt-0" href="#faqs">
                                                                    <div class="text-center">
                                                                        <i class="ri-question-answer-line"></i>
                                                                    </div>
                                                                    Cancellation Policy
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="content-sections">
                                                    <div id="overview" class="section-block">
                                                        <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                                            <h5 class="fw-bolder textDarkBlue">Overview</h5>
                                                            <div class="d-flex gap-3">
                                                                <div class="overviewImageWrapper">
                                                                    <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="overviewImg">
                                                                </div>
                                                                <div class="fontSize1">
                                                                    <p class="fw-normal fontSize12"><?= $package['detailed_description'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="itinerary" class="section-block">
                                                        <div class="card cardBackgroundColor rounded-3 p-3 pb-4 cardShadow">
                                                            <h5 class="fw-bolder textDarkBlue">Itinerary</h5>
                                                            <div class="tour-details-content">
                                                                <div class="destination-accordion mt-2">
                                                                    <div class="accordion" id="accordionItinerary">
                                                                        <?php
                                                                        $count = 1;

                                                                        $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $package_id");
                                                                        $data4->execute();
                                                                        $data4->setFetchMode(PDO::FETCH_ASSOC);

                                                                        if ($data4->rowCount() > 0) {
                                                                            foreach ($data4->fetchAll() as $key_3 => $day) {

                                                                                $decription = $day['day_details'];
                                                                                // $decription_1 = explode(".", $decription);
                                                                                // $decription_2 = implode(".<br>", $decription_1);
                                                                        ?>      <div class="timeline-number">
                                                                                    <?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="panelsStayOpen-heading<?= $count; ?>">
                                                                                        <button class="accordion-button <?= ($count != 1) ? 'collapsed' : ''; ?>"
                                                                                                type="button"
                                                                                                data-bs-toggle="collapse"
                                                                                                data-bs-target="#panelsStayOpen-collapse<?= $count; ?>"
                                                                                                aria-expanded="<?= ($count == 1) ? 'true' : 'false'; ?>"
                                                                                                aria-controls="panelsStayOpen-collapse<?= $count; ?>">

                                                                                            Day <?= $key_3 + 1; ?> - <?= $day['title']; ?>

                                                                                        </button>
                                                                                    </h2>

                                                                                    <div id="panelsStayOpen-collapse<?= $count; ?>"
                                                                                        class="accordion-collapse collapse <?= ($count == 1) ? 'show' : ''; ?>"
                                                                                        aria-labelledby="panelsStayOpen-heading<?= $count; ?>"
                                                                                        data-bs-parent="#accordionItinerary">

                                                                                        <div class="accordion-body">

                                                                                            <ul class="listing">
                                                                                                <li class="list">
                                                                                                    <?= $decription; ?>
                                                                                                </li>
                                                                                            </ul>

                                                                                            <hr class="my-3" style="border-top:1px solid #4b5051;">

                                                                                            <div class="d-flex justify-content-evenly displayMeal">
                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">Meal:&nbsp;</h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0"><?= $day['meal_plan']; ?></p>
                                                                                                </div>

                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">Transport:&nbsp;</h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0"><?= $day['day_tansport']; ?></p>
                                                                                                </div>

                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">Stay:&nbsp;</h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0"><?= $day['stay']; ?></p>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                                $count++;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="inclusion" class="section-block">
                                                        <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                                            <h5 class="fw-bolder textDarkBlue">Inclusion & Exclusion</h5>
                                                            
                                                            <div class="row">
                                                                <?php
                                                                    $inclusions = safeJsonDecode($itinery['inclusion'] ?? '');
                                                                    $exclusions = safeJsonDecode($itinery['exclusion'] ?? '');
                                                                ?>
                                                                <!-- Inclusions -->
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                    <?php if (!empty($inclusions)): ?>
                                                                        <?php foreach ($inclusions as $inclusion): ?>
                                                                            <div class="d-flex gap-3 mt-2">
                                                                                <div class="checkIcon">
                                                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                                                </div>
                                                                                <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                    <?= htmlspecialchars($inclusion) ?>
                                                                                </p>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="text-muted mt-2 mb-0">No inclusions available.</p>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <!-- Exclusions -->
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                    <?php if (!empty($exclusions)): ?>
                                                                        <?php foreach ($exclusions as $exclusion): ?>
                                                                            <div class="d-flex gap-3 mt-2">
                                                                                <div class="closeIcon">
                                                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                                                </div>
                                                                                <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                    <?= htmlspecialchars($exclusion) ?>
                                                                                </p>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <p class="text-muted mt-2 mb-0">No exclusions available.</p>
                                                                    <?php endif; ?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="policies" class="section-block">
                                                        <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                                            <h5 class="fw-bolder mb-3 textDarkBlue">Policies</h5>
                                                            <?php
                                                                $hasPolicies = false;
                                                            ?>

                                                            <?php foreach ($policies as $policy): ?>

                                                                <?php if (strcasecmp(trim($policy['title']), 'FAQ') === 0): ?>
                                                                    <?php continue; ?>
                                                                <?php endif; ?>

                                                                <?php $hasPolicies = true; ?>

                                                                <div class="policyItem">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="highlightIcon" style="background-color: #b2e0b1;">
                                                                            <i class="ri-file-pdf-line text-success"></i>
                                                                        </div>

                                                                        <p class="mb-0">
                                                                            <?= htmlspecialchars($policy['title']) ?>
                                                                        </p>
                                                                    </div>

                                                                    <a href="uploading/package_policy_attachments/<?= urlencode($policy['file_name']) ?>"
                                                                    download
                                                                    class="downloadBtn">
                                                                        <i class="ri-download-line"></i>
                                                                    </a>
                                                                </div>

                                                            <?php endforeach; ?>

                                                            <?php if (!$hasPolicies): ?>
                                                                <p class="text-muted mb-0">
                                                                    No policy documents available.
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div id="faqs" class="section-block">
                                                        <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">
                                                            <h5 class="fw-bolder textDarkBlue">Cancellation Policy</h5>
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
                                                                            <input type="number" class="form-control" id="" name="cancellationPercentage1" placeholder="0" value="<?= $cancel_policy['policy_1']??0 ?>" readonly>
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage1_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="" name="cancellationPercentage2" placeholder="0" value="<?= $cancel_policy['policy_2']??0 ?>" readlink>
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage2_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="" name="cancellationPercentage3" placeholder="0" value="<?= $cancel_policy['policy_3']??0 ?>" readonly>
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage3_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="" name="cancellationPercentage4" placeholder="0" value="<?= $cancel_policy['policy_4']??0 ?>" readonly>
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage4_error"></small>
                                                                        </div>
                                                                        <div class="input-group inputWidth">
                                                                            <input type="number" class="form-control" id="" name="cancellationPercentage5" placeholder="0" value="<?= $cancel_policy['policy_5']??0 ?>" readonly>
                                                                            <span class="input-group-text">%</span>
                                                                            <small class="error-message" id="cancellationPercentage5_error"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Section 2 subsection 6 End -->
                                        </div>
                                    </div>

                                </div>
                    <?php if($replyRecords){
                     foreach ($replyRecords as $index => $replyData): 

                        $accordionNumber = $index + 1;

                        $collapseId = 'collapseReply' . $accordionNumber;
                        $headingId  = 'headingReply' . $accordionNumber;

                        // Individual reply editing permission
                        $canEditReply = (
                            isset($replyData['status']) &&
                            (int) $replyData['status'] === 1
                        ); 
                    ?>
                                    <div class="accordion-item">

                                        <h2 class="accordion-header"
                                            id="<?= htmlspecialchars($headingId) ?>">

                                            <button class="accordion-button collapsed"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#<?= htmlspecialchars($collapseId) ?>"
                                                    aria-expanded="false"
                                                    aria-controls="<?= htmlspecialchars($collapseId) ?>">

                                                <div class="accordion-heading-content">

                                                    <div class="accordion-heading-title">
                                                        <i class="fa-solid fa-user-pen"></i>
                                                        Quotation #<?= $accordionNumber ?>
                                                    </div>

                                                    <span class="history-status sent-status">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Replied by Admin · <?= !empty($replyData['created'])
                                                                    ? date('d M Y, h:i A', strtotime($replyData['created']))
                                                                    : 'N/A'; ?>
                                                    </span>

                                                </div>

                                            </button>

                                        </h2>
                                        <div id="<?= $collapseId ?>"
                                            class="accordion-collapse collapse <?= !$canEditReply ? 'quotation-locked' : '' ?>"
                                            aria-labelledby="<?= $headingId ?>"
                                            data-bs-parent="#formHistoryAccordion">

                                            <div class="accordion-body">

                                                <?php if (!$canEditReply): ?>

                                                    <div class="alert alert-warning">
                                                        <i class="fa-solid fa-lock me-2"></i>
                                                        This quotation reply is locked.
                                                    </div>

                                                <?php endif; ?>

                                                <!-- YOUR EXISTING REPLY ACCORDION CONTENT -->
                                                <!-- Card Section 1 Start -->
                                                <div class="row rowAlignment">
                                                    <div class="col-12">
                                                        <div class="card cardShadow">
                                                            <div class="d-flex tabDisplayBlock">
                                                                <div class="p-2 imageWrapper">
                                                                    <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="prepareQuotationImg">
                                                                </div>
                                                                <div class="p-3 widthStretch">
                                                                    <div class="packageIDBtn">
                                                                        <?= $package['unique_code'] ?>
                                                                    </div>
                                                                    <p class="fw-bolder textDarkBlue mb-1 fs-4" id=""><?= $package['name'] ?></p>
                                                                    <p class="fw-bold textDarkBlue mb-1 fs-5" id="">
                                                                        <?= $package['description'] ?>
                                                                    </p>
                                                                    <div class="d-flex gap-4 redIcons laptopDisplay">
                                                                        <p class="fontSize12 mb-3">
                                                                            <i class="fa-solid fa-location-dot me-2"></i>
                                                                            <?= $package['destination'] ?>
                                                                        </p>
                                                                        <p class="fontSize12 mb-3">
                                                                            <i class="fa-regular fa-calendar me-2"></i>
                                                                            <?= $tour_nights ?> Nights / <?= $tour_days ?> Days
                                                                        </p>
                                                                        <p class="fontSize12 mb-3">
                                                                            <i class="fa-solid fa-utensils me-2"></i>
                                                                            Meals: <?= $meal_cat['name'] ?>
                                                                        </p>
                                                                    </div>
                                                                    <p class="fontSize12 mb-3">
                                                                        <?= $package['detailed_description'] ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Card Section 1 End -->
                                                <div class="row">
                                                    <div class="col-xl-8">
                                                        <!-- Card Section 2 subsection 1 Start -->
                                                        <div class="card p-3">
                                                            <h5 class="fw-bold textDarkBlue">
                                                                <i class="fa-solid fa-clipboard-list fa-xl me-3"></i>
                                                                Enquiry Information
                                                            </h5>
                                                            <div class="row">
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-0">Enquiry ID :</p>
                                                                    <p class="fs-6 mb-0 fw-bold"><?= $replyData['request_id'] ?></p>
                                                                </div>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-0">Received On :</p>
                                                                    <p class="fs-6 mb-0 fw-bold">
                                                                        <?= !empty($replyData['created'])
                                                                            ? date('d M Y, h:i A', strtotime($replyData['created']))
                                                                            : 'N/A'; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Card Section 2 subsection 1 End -->
                                                        <!-- Card Section 2 subsection 2 Start -->
                                                        <div class="card p-3">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h5 class="fw-bold textDarkBlue">
                                                                    <i class="fa-solid fa-user fa-xl me-3"></i>
                                                                    Customer Information
                                                                </h5>
                                                                <!-- <a class="editCustomerBtn">
                                                                    <i class="fa-solid fa-pen me-1"></i>
                                                                    Edit
                                                                </a> -->
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Full Name :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['guestFullname'] ?></p>
                                                                </div>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Mobile :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['gusetPhone'] ?></p>
                                                                </div>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Email :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['guestEmail'] ?></p>
                                                                </div>
                                                                <!-- <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Address :</p>
                                                                    <p class="fs-6 mb-2 fw-bold">Mumbai, Maharashtra</p>
                                                                </div> -->
                                                                <?php if($replyData['userId'] != 'null'){
                                                                ?>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Customer Type :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                                                </div>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Member Id :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $replyData['userId'] ?></p>
                                                                </div>
                                                                <!-- <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Travel Consultant :</p>
                                                                    <p class="fs-6 mb-2 fw-bold">-</p>
                                                                </div> -->
                                                                <?php }else{ ?>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Customer Type :</p>
                                                                    <p class="fs-6 mb-2 fw-bold"><?= $Requester_type ?></p>
                                                                </div>
                                                                <div class="col-xl-6 d-flex gap-2">
                                                                    <p class="fs-6 mb-2">Member Id :</p>
                                                                    <p class="fs-6 mb-2 fw-bold">NA</p>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <!-- Card Section 2 subsection 2 End -->
                                                        <div class="card p-3">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h5 class="fw-bold textDarkBlue">
                                                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                                                    Trip Request <span class="fw-normal">(Submitted by Customer)</span>
                                                                </h5>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Travel Start Date</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['travel_start_date'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Travel End Date</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['travel_end_date'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Nights / Days</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['no_of_nights_days'] ?>" readonly >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Pickup</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['customer_pickup'] != '' ? $replyData['customer_pickup']: $replyData['pickup_point'] ?>" readonly >
                                                                        <?php
                                                                            $oldPickup = !empty($replyData['customer_pickup'])
                                                                            ? $replyData['pickup_point']
                                                                            : '';
                                                                        ?>

                                                                        <?php if ($oldPickup !== ''): ?>
                                                                            <small class="old-value-text text-muted"
                                                                                id="">
                                                                                Previous Pickup: </br> 
                                                                                <?= htmlspecialchars($oldPickup, ENT_QUOTES, 'UTF-8') ?>
                                                                            </small>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Drop</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['customer_drop'] != '' ? $replyData['customer_drop']: $replyData['drop_point'] ?>" readonly>
                                                                        <?php
                                                                            $olddrop = !empty($replyData['customer_drop'])
                                                                            ? $replyData['drop_point']
                                                                            : '';
                                                                        ?>

                                                                        <?php if ($olddrop !== ''): ?>
                                                                            <small class="old-value-text text-muted"
                                                                                id="">
                                                                                Previous Drop: </br> 
                                                                                <?= htmlspecialchars($olddrop, ENT_QUOTES, 'UTF-8') ?>
                                                                            </small>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row paxRow">
                                                                <div class="col-xl-3 paxCol">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Adults (12+ yrs)</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['adult_count'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 paxCol">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Children (2-11 yrs)</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['child_count'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 paxCol">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Infants (0-1 yrs)</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['infant_count'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 paxCol">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Total Pax</label>
                                                                        <input type="text" class="form-control fw-bold textDarkBlue" id="" value="<?= $replyData['adult_count'] + $replyData['child_count'] + $replyData['infant_count'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Card Section 2 subsection 3 End -->
                                                        <!-- Card Section 2 subsection 4 Start -->
                                                        <div class="card p-3">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h5 class="fw-bold textDarkBlue">
                                                                    <i class="fa-solid fa-bed fa-xl me-3"></i>
                                                                    Room Allocation <span class="fw-normal">(Requested by Customer)</span>
                                                                </h5>
                                                            </div>
                                                            
                                                            <?php
                                                                $rooms = json_decode($replyData['rooms'] ?? '[]', true);

                                                                if (!is_array($rooms)) {
                                                                    $rooms = [];
                                                                }

                                                                $totalRooms = count($rooms);

                                                                $adultCount  = (int)($replyData['adult_count'] ?? 0);
                                                                $childCount  = (int)($replyData['child_count'] ?? 0);
                                                                $infantCount = (int)($replyData['infant_count'] ?? 0);

                                                                $totalTravellers = $adultCount + $childCount + $infantCount;

                                                                $bedCounts = [];
                                                                $totalExtraMattresses = 0;
                                                                $recommendations = [];

                                                                foreach ($rooms as $room) {
                                                                    $description = trim($room['description'] ?? '');

                                                                    // Count extra mattresses separately.
                                                                    if (preg_match_all(
                                                                        '/(\d+)\s*Extra\s*Mattress(?:es)?/i',
                                                                        $description,
                                                                        $mattressMatches
                                                                    )) {
                                                                        foreach ($mattressMatches[1] as $quantity) {
                                                                            $totalExtraMattresses += (int)$quantity;
                                                                        }
                                                                    }

                                                                    // Remove the entire extra mattress phrase from the room description.
                                                                    $description = preg_replace(
                                                                        '/\s*\+?\s*\d+\s*Extra\s*Mattress(?:es)?/i',
                                                                        '',
                                                                        $description
                                                                    );

                                                                    // Clean up leftover separators and spaces.
                                                                    $description = trim($description, " \t\n\r\0\x0B,+-");

                                                                    // Process only bed types now.
                                                                    $bedItems = preg_split('/\s*\+\s*|\s*,\s*/', $description);

                                                                    foreach ($bedItems as $item) {

                                                                        $item = trim($item);

                                                                        if ($item === '') {
                                                                            continue;
                                                                        }

                                                                        $quantity = 1;

                                                                        if (preg_match('/^(\d+)\s+(.+)$/i', $item, $matches)) {
                                                                            $quantity = (int)$matches[1];
                                                                            $item = trim($matches[2]);
                                                                        }

                                                                        // Safety check: never allow a mattress into the bed summary.
                                                                        if (stripos($item, 'mattress') !== false) {
                                                                            continue;
                                                                        }

                                                                        if ($quantity <= 0 || $item === '') {
                                                                            continue;
                                                                        }

                                                                        $item = preg_replace('/\bBeds\b/i', 'Bed', $item);
                                                                        $key = strtolower(trim($item));

                                                                        if (!isset($bedCounts[$key])) {
                                                                            $bedCounts[$key] = [
                                                                                'name' => trim($item),
                                                                                'count' => 0
                                                                            ];
                                                                        }

                                                                        $bedCounts[$key]['count'] += $quantity;
                                                                    }

                                                                    // Keep recommendations unique.
                                                                    $recommendation = trim($room['recommendation'] ?? '');

                                                                    if (
                                                                        $recommendation !== '' &&
                                                                        !in_array($recommendation, $recommendations, true)
                                                                    ) {
                                                                        $recommendations[] = $recommendation;
                                                                    }
                                                                }

                                                                /*
                                                                * 5. Build the combined room type summary.
                                                                */
                                                                $roomTypeSummary = [];

                                                                foreach ($bedCounts as $bed) {

                                                                    $count = $bed['count'];
                                                                    $name = $bed['name'];

                                                                    if (preg_match('/\bBed\b/i', $name)) {
                                                                        $name = preg_replace(
                                                                            '/\bBed\b/i',
                                                                            $count === 1 ? 'Bed' : 'Beds',
                                                                            $name
                                                                        );
                                                                    }

                                                                    $roomTypeSummary[] = $count . ' ' . $name;
                                                                }

                                                                $roomTypeText = implode(', ', $roomTypeSummary);
                                                            ?>

                                                            <div class="row">
                                                                <div class="col-xl-12">

                                                                    <table class="table table-bordered mb-0 fs-6">
                                                                        <thead>
                                                                            <tr class="table-active">
                                                                                <th scope="col">Room Count</th>
                                                                                <th scope="col">Travellers</th>
                                                                                <th scope="col">Room Type</th>
                                                                                <th scope="col">Extra Mattress</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody id="" class="fs-6">
                                                                            <?php if (!empty($rooms)): ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?= $totalRooms ?>
                                                                                        <?= $totalRooms === 1 ? 'Room' : 'Rooms' ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?= $totalTravellers ?>
                                                                                        (<?= $adultCount ?> Adults +
                                                                                        <?= $childCount ?> Children +
                                                                                        <?= $infantCount ?> Infants)
                                                                                    </td>

                                                                                    <td>
                                                                                        <?= htmlspecialchars(
                                                                                            $roomTypeText !== '' ? $roomTypeText : 'N/A',
                                                                                            ENT_QUOTES,
                                                                                            'UTF-8'
                                                                                        ) ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?php if ($totalExtraMattresses > 0): ?>
                                                                                            <?= $totalExtraMattresses ?>
                                                                                            <?= $totalExtraMattresses === 1
                                                                                                ? 'Extra Mattress'
                                                                                                : 'Extra Mattresses' ?>
                                                                                        <?php else: ?>
                                                                                            N/A
                                                                                        <?php endif; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php else: ?>
                                                                                <tr>
                                                                                    <td colspan="4" class="text-center">
                                                                                        No room details available.
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endif; ?>
                                                                        </tbody>
                                                                    </table>

                                                                    <?php if (!empty($rooms)): ?>
                                                                        <div class="paxDescriptionBtn d-flex">
                                                                            <i class="fa-solid fa-circle-user paxColor fa-lg align-content-center me-2"></i>

                                                                            <span>
                                                                                <?= $totalTravellers ?>
                                                                                <?= $totalTravellers === 1 ? 'traveller' : 'travellers' ?>
                                                                                will be accommodated in
                                                                                <?= $totalRooms ?>
                                                                                <?= $totalRooms === 1 ? 'room' : 'rooms' ?>.

                                                                                <?php if (!empty($recommendations)): ?>
                                                                                    <br>
                                                                                    <?= htmlspecialchars(
                                                                                        implode(', ', $recommendations),
                                                                                        ENT_QUOTES,
                                                                                        'UTF-8'
                                                                                    ) ?>
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>



                                                        </div>
                                                        <!-- Card Section 2 subsection 4 End -->
                                                        <!-- Card Section 2 subsection 5 Start -->
                                                        <div class="card p-3">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h5 class="fw-bold textDarkBlue">
                                                                    <i class="fa-solid fa-calendar-days fa-xl me-3"></i>
                                                                    Customer Preferences <span class="fw-normal">(Submitted by Customer)</span>
                                                                </h5>
                                                                
                                                            </div>
                                                            <div class="row">
                                                                <!-- HOTEL CATEGORY -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label fontSize10">
                                                                            Hotel Category
                                                                        </label>
                                                                        <div class="icon-select-wrapper">
                                                                            <i class="ri-hotel-line iconPosition iconRed"></i>
                                                                            <?php
                                                                            $sql = $conn->prepare("
                                                                                SELECT id, name
                                                                                FROM category_hotel
                                                                                WHERE status = 1
                                                                                ORDER BY id DESC
                                                                            ");
                                                                            $sql->execute();
                                                                            $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                            ?>
                                                                            <select id="" class="form-select fontSize10 paddingLeft" name="hotel_category" disabled>
                                                                                <option value="">Select Hotel</option>

                                                                                <?php foreach ($hotelCategories as $hotel): ?>
                                                                                    <option
                                                                                        value="<?= htmlspecialchars($hotel['id'], ENT_QUOTES, 'UTF-8') ?>"
                                                                                        <?= ((string)$hotel['id'] === (string)($replyData['hotel_category'] ?? '')) ? 'selected' : '' ?>
                                                                                    >
                                                                                        <?= htmlspecialchars($hotel['name'], ENT_QUOTES, 'UTF-8') ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <!-- OLD VALUE -->
                                                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                                                    </div>
                                                                </div>
                                                                <!-- MEAL PREFERENCE -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label fontSize10">
                                                                            Meal Preference
                                                                        </label>
                                                                        <div class="icon-select-wrapper">
                                                                            <i class="ri-restaurant-line iconPosition iconRed"></i>
                                                                            <?php
                                                                            $sql = $conn->prepare("
                                                                                SELECT id, name
                                                                                FROM category_meal
                                                                                WHERE status = 1
                                                                                ORDER BY id DESC
                                                                            ");
                                                                            $sql->execute();
                                                                            $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                            ?>
                                                                            <select id="" class="form-select fontSize10 paddingLeft" name="meal_preference" disabled>
                                                                                <option value="">Select Meal</option>
                                                                                <?php foreach ($mealCategories as $meal_cat): ?>
                                                                                    <option value="<?= htmlspecialchars($meal_cat['id']) ?>" 
                                                                                    <?= ($replyData['meal_preference'] == $meal_cat['id']) ? 'selected' : '' ?>>
                                                                                        <?= htmlspecialchars($meal_cat['name']) ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <!-- OLD VALUE -->
                                                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                                                    </div>
                                                                </div>
                                                                <!-- TRANSPORT -->
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label fontSize10">
                                                                            Transport Preference
                                                                        </label>
                                                                        <div class="icon-select-wrapper">
                                                                            <i class="ri-car-line iconPosition iconRed"></i>
                                                                            <?php
                                                                            $sql = $conn->prepare("
                                                                                SELECT id, name
                                                                                FROM category_vehicle
                                                                                WHERE status = 1
                                                                                ORDER BY id DESC
                                                                            ");
                                                                            $sql->execute();
                                                                            $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                                            ?>
                                                                            <select id="" class="form-select fontSize10 paddingLeft" name="transport_preference" disabled>
                                                                                <option value="">Select Vehicle</option>
                                                                                <?php foreach ($vehicleCategories as $vehicle_cat): ?>
                                                                                    <option value="<?= htmlspecialchars($vehicle_cat['id']) ?>" 
                                                                                    <?= ($replyData['transport_preference'] == $vehicle_cat['id']) ? 'selected' : '' ?>>
                                                                                        <?= htmlspecialchars($vehicle_cat['name']) ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <!-- OLD VALUE -->
                                                                        <div id="" class="text-muted fontSize10 d-none mt-2"></div>
                                                                    </div>
                                                                </div>
                                                                <!-- SPECIAL REQUIREMENT -->
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <div class="mb-0">
                                                                        <label for="" class="form-label fontSize10">Special Requirements (Optional)</label>
                                                                        <textarea
                                                                            class="form-control fontSize10"
                                                                            id=""
                                                                            name="special_requirement"
                                                                            placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."
                                                                            style="text-align: left;"
                                                                            readonly
                                                                        ><?= htmlspecialchars(trim($replyData['special_requirement'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Card Section 2 subsection 5 End -->
                                                        
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="card cardShadow">
                                                            <div class="quick-header p-3">
                                                                <div class="d-flex gap-2">
                                                                    <i class="fa-solid fa-location-dot fa-xl align-content-center quickIcon"></i>
                                                                    <h5 class="fw-bold mb-0 textDarkBlue align-content-center">Quick Action</h5>
                                                                </div>
                                                                <!-- <button type="button" class="recalculate-btn" id="#">
                                                                    <i class="fa-solid fa-rotate-right"></i>
                                                                    Recalculate
                                                                </button> -->
                                                            </div>
                                                            <div class="px-3">
                                                                <p class="mb-2 fw-bold blueDiv">Base Price (Per Person)</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="mb-1">Adult (12+ yrs)</p>
                                                                        <p class="mb-1">Child (2-11 yrs)</p>
                                                                        <p class="mb-1">Infant (0-1 yrs)</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-1 text-end">&#8377; <?= number_format($replyData['adult_price'], 2) ?></p>
                                                                        <p class="mb-1 text-end">&#8377; <?= number_format($replyData['child_price'], 2) ?></p>
                                                                        <p class="mb-1 text-end">FREE</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-3 pb-0">
                                                                <p class="mb-2 fw-bold blueDiv">Price Based on Travelers</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="mb-1">Adult: <span class="" id=""><?= $replyData['adult_count'] ?></span> x &#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                                        <p class="mb-1">Children: <span class="" id=""><?= $replyData['child_count'] ?></span> x &#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                                                        <p class="mb-1">Infant: <span class="" id=""><?= $replyData['infant_count'] ?></span> x FREE</p>
                                                                        <p class="mb-1">Extra Mattress (1 x &#8377; <?= $pricing['extra_mattress'] ?>)</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-1 text-end" id="">&#8377; <?= number_format($replyData['adult_total'], 2) ?></p>
                                                                        <p class="mb-1 text-end" id="">&#8377; <?= number_format($replyData['children_total'], 2) ?></p>
                                                                        <p class="mb-1 text-end">&#8377; 0.00</p>
                                                                        <p class="mb-1 text-end" id="#">&#8377; <?= $totalExtraMattresses * $pricing['extra_mattress'] ?></p>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <hr class="my-1 border border-2 mx-0">
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="fw-bold fs-5 textDarkBlue mb-0">Subtotal</p>
                                                                    <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="">&#8377; <?= number_format($replyData['subtotal'], 2) ?></p>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="p-3">
                                                                <p class="fw-bold">Transport</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="fontSize10" id=""><?= $replyData['transport_type'] ?></p>
                                                                        <!-- <a href="#" class="fontSize10 text-primary" id="">Change Vehicle</a> -->
                                                                    </div>
                                                                    <div>
                                                                        <!-- <p class="fontSize10 text-end">Included</p> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <?php
                                                            $savedCoupons = json_decode($replyData['coupons'] ?? '[]', true) ?: [];

                                                            $totalCouponDiscount = 0;
                                                            ?>

                                                            <div class="p-3 pb-0">

                                                                <p class="fw-bold mb-2 textDarkBlue blueDiv">
                                                                    Applied Coupons
                                                                    <span class="text-muted fw-normal fontSize12">
                                                                        
                                                                        <i class="ri-error-warning-line"></i>
                                                                    </span>
                                                                </p>

                                                                <?php
                                                                    $customerCoupons = json_decode($requestData['coupons'] ?? '[]', true) ?: [];

                                                                    $adminCouponsJson = $replyData['admin_coupons'] ?? '[]';

                                                                    $adminCoupons = json_decode($adminCouponsJson, true) ?: [];

                                                                    $savedCoupons = array_merge(
                                                                        $customerCoupons,
                                                                        array_map(function ($coupon) {
                                                                            return [
                                                                                'code' => $coupon['code'] ?? '',
                                                                                'amount' => $coupon['amount'] ?? 0,
                                                                                'passenger' => ''
                                                                            ];
                                                                        }, $adminCoupons)
                                                                    );
                                                                ?>
                                                                <div class="coupon-passenger-container">

                                                                <?php if (!empty($savedCoupons)): ?>

                                                                    <?php foreach ($savedCoupons as $coupon): ?>

                                                                        <?php
                                                                        $couponCode = trim($coupon['code'] ?? '');
                                                                        $passenger = trim($coupon['passenger'] ?? '');
                                                                        $amount = (float) ($coupon['amount'] ?? 0);

                                                                        if ($couponCode === '') {
                                                                            continue;
                                                                        }

                                                                        $displayPassenger = ($passenger !== '')
                                                                            ? $passenger
                                                                            : 'Coupon';

                                                                        $totalCouponDiscount += $amount;
                                                                        ?>

                                                                        <div class="d-flex justify-content-between mb-2 saved-coupon-row">

                                                                            <div class="d-flex gap-3 largeDisplay">

                                                                                <p class="fontSize10 align-content-end mb-0">
                                                                                    <?= htmlspecialchars($displayPassenger) ?>
                                                                                </p>

                                                                                <p class="mb-0">
                                                                                    <select class="form-select fontSize10 selectPadding" disabled>
                                                                                        <option value="<?= htmlspecialchars($couponCode) ?>" selected>
                                                                                            <?= htmlspecialchars($couponCode) ?>
                                                                                        </option>
                                                                                    </select>
                                                                                </p>

                                                                            </div>

                                                                            <p class="fontSize10 discountGreen fw-bold text-end align-content-end mb-0">
                                                                                - ₹ <?= number_format($amount, 0, '.', ',') ?>
                                                                            </p>

                                                                        </div>

                                                                    <?php endforeach; ?>

                                                                <?php else: ?>

                                                                    <p class="fontSize10 text-muted mb-2">
                                                                        No coupons applied.
                                                                    </p>

                                                                <?php endif; ?>

                                                            </div>


                                                            </div>

                                                            <hr class="my-1 border border-2 mx-3">

                                                            <div class="d-flex justify-content-between px-3">

                                                                <p class="fontSize10 discountGreen fw-bold">
                                                                    Discounts (Coupons)
                                                                </p>

                                                                <p class="fontSize10 discountGreen fw-bold text-end">
                                                                    - ₹ <?= number_format($totalCouponDiscount, 0, '.', ',') ?>
                                                                </p>

                                                            </div>
                                                            <?php
                                                            $referralWalletBalance = $referralBalance ?? 0;
                                                            $discountWalletBalance = $discountBalance ?? 0;
                                                            $extendedWalletBalance = $extendedBalance ?? 0;
                                                            ?>

                                                            <!-- <hr class="my-1 border border-2 mx-3"> -->

                                                            <div class="d-flex justify-content-between align-items-center px-3">

                                                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                    Referral Wallet
                                                                </p>

                                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                                                id="">
                                                                    ₹ <?= number_format($referralWalletBalance, 2) ?>
                                                                </p>

                                                                <div class="d-flex align-items-center">
                                                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                                                        - ₹
                                                                    </span>
                                                                    <input type="number" class="form-control form-control-sm walletInput" id="" value="<?= $requestData['referral_wallet_amount'] ?>" min="0" step="1" disabled style="width: 80px;">
                                                                </div>
                                                            </div>
                                                            <?php if ($Requester_type == 'Neo Select'){
                                                            ?>
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="d-flex justify-content-between align-items-center px-3">
                                                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                    Discount Wallet
                                                                </p>
                                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                                                id="">
                                                                    ₹ <?= number_format($discountWalletBalance, 2) ?>
                                                                </p>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                                                        - ₹
                                                                    </span>
                                                                    <input type="number" class="form-control form-control-sm walletInput" id="" value="<?= $replyData['discount_wallet_amount'] ?>" min="0" step="1" disabled style="width: 80px;">
                                                                </div>
                                                            </div>
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="d-flex justify-content-between align-items-center px-3">
                                                                <p class="fontSize10 discountGreen fw-bold mb-0">
                                                                    Extended Wallet
                                                                </p>
                                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0"
                                                                id="">
                                                                    ₹ <?= number_format($extendedWalletBalance, 2) ?>
                                                                </p>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fontSize10 discountGreen fw-bold me-1">
                                                                        - ₹
                                                                    </span>
                                                                    <input type="number" class="form-control form-control-sm walletInput" id="" value="0" min="0" step="1" disabled style="width: 80px;">
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            
                                                            <hr class="my-2 border border-2 mx-3">
                                                            <div class="p-3">
                                                                <p class="fw-bold blueDiv">Adjustments</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        
                                                                        <p class="mb-1">GST (<?= $replyData['gst_percentage'] ?>%) </p>
                                                                        <p class="mb-1">Convenience Fee </p>
                                                                    </div>
                                                                    <div>
                                                                        
                                                                        <p class="mb-1 text-end">&#8377; <?= $replyData['gst'] ?></p>
                                                                        <p class="mb-1 text-end" id="#">&#8377; <?= $replyData['convenience_fee'] ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="p-3 pb-0">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="fs-5 textDarkBlue fw-bold">Total Estimated </br> Price</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="fs-5 text-danger fw-bolder text-end" id="">&#8377; <?= number_format($replyData['final_price'], 2) ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Card Section 2 subsection 6 Start -->
                                                <div class="card p-3">
                                                    <h5 class="fw-bold textDarkBlue">
                                                        <i class="fa-solid fa-file-lines fa-xl me-3"></i>
                                                        Package Information <span class="fw-normal">(From Package Master)</span>
                                                    </h5>
                                                    <div class="row paxRow mt-1 mb-2">
                                                        <div class="col-xl-2 paxCol">
                                                            <p class="fs-6 mb-1">Package ID</p>
                                                            <p class="fs-6 fw-bold mb-2"><?= $package['unique_code'] ?></p>
                                                        </div>
                                                        <div class="col-xl-10">
                                                            <div class="row paxRow">
                                                                <div class="col-xl-4 paxCol">
                                                                    <p class="fs-6 mb-1">Destination</p>
                                                                    <p class="fs-6 fw-bold mb-2"><?= $package['name'] ?></p>
                                                                </div>
                                                                <div class="col-xl-4 paxCol">
                                                                    <p class="fs-6 mb-1">Duration</p>
                                                                    <p class="fs-6 fw-bold mb-2"><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</p>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <p class="fs-6 mb-1">Package Type</p>
                                                                    <p class="fs-6 fw-bold mb-2"><?= $package['category_id'] == 2 ? 'Domestic':($package['category_id'] == 1 ?'International':'NA') ?></p>
                                                                </div>
                                                                <div class="col-xl-6 paxCol">
                                                                    <p class="fs-6 mb-1">Pacakge Category</p>
                                                                    <p class="fs-6 fw-bold mb-2"><?= $package['package_type'] ?></p>
                                                                </div>
                                                                <div class="col-xl-6 paxCol">
                                                                    <p class="fs-6 mb-1">Valid Travel Period</p>
                                                                    <p class="fs-6 fw-bold mb-2">
                                                                        Valid Till <?= date('d-m-Y', strtotime($package['validity'])) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nav-placeholder"></div>
                                                    <div class="sticky-nav-wrapper">
                                                        <div class="borderColor1 cardShadow p-2">
                                                            <ul class="nav nav-underline justify-content-between">
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0 active" aria-current="page" href="#overview1">
                                                                        <div class="text-center">
                                                                            <i class="ri-dashboard-line"></i>
                                                                        </div>
                                                                        Overview
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0" href="#itinerary1">
                                                                        <div class="text-center">
                                                                            <i class="ri-route-line"></i>
                                                                        </div>
                                                                        Itinerary
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0" href="#inclusion1">
                                                                        <div class="text-center">
                                                                            <i class="ri-dashboard-line"></i>
                                                                        </div>
                                                                        Inclusions
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0" href="#inclusion1">
                                                                        <div class="text-center">
                                                                            <i class="ri-dashboard-line"></i>
                                                                        </div>
                                                                        Exclusions
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0" href="#policies1">
                                                                        <div class="text-center">
                                                                            <i class="ri-dashboard-line"></i>
                                                                        </div>
                                                                        Policies
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item navItem">
                                                                    <a class="nav-link pt-0" href="#faqs1">
                                                                        <div class="text-center">
                                                                            <i class="ri-question-answer-line"></i>
                                                                        </div>
                                                                        Cancellation Policy
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="content-sections">
                                                        <div id="overview1" class="section-block">
                                                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                                                <h5 class="fw-bolder textDarkBlue">Overview</h5>
                                                                <div class="d-flex gap-3">
                                                                    <div class="overviewImageWrapper">
                                                                        <img src="<?= '../../'.$galleryImages[0]['image'] ?>" alt="" class="overviewImg">
                                                                    </div>
                                                                    <div class="fontSize1">
                                                                        <p class="fw-normal fontSize12"><?= $package['detailed_description'] ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="itinerary1" class="section-block">
                                                            <div class="card cardBackgroundColor rounded-3 p-3 pb-4 cardShadow">
                                                                <h5 class="fw-bolder textDarkBlue">Itinerary</h5>

                                                                <div class="tour-details-content">

                                                                    <div class="destination-accordion mt-2">

                                                                        <div class="accordion" id="accordionItinerary<?= (int)$accordionNumber ?>">

                                                                            <?php
                                                                            $count = 1;

                                                                            // Fetch saved itinerary days for this request and package
                                                                            $data4 = $conn->prepare("
                                                                                SELECT *
                                                                                FROM request_details_trip_days
                                                                                WHERE request_id = :request_id
                                                                                AND reply_id=:reply_id
                                                                                ORDER BY id ASC
                                                                            ");

                                                                            $data4->execute([
                                                                                ':request_id' => $requestData['request_id'],
                                                                                ':reply_id' => $replyData['id']
                                                                            ]);

                                                                            $days = $data4->fetchAll(PDO::FETCH_ASSOC);

                                                                            foreach ($days as $key_3 => $day):

                                                                                $description = $day['day_details'] ?? '';
                                                                                $mealPlan = $day['meal_plan'] ?? '';
                                                                                $dayTransport = $day['day_transport'] ?? '';
                                                                                $stay = $day['stay'] ?? '';

                                                                                $headingId = 'itinerary-heading-' . $accordionNumber . '-' . $count;
                                                                                $collapseId = 'itinerary-collapse-' . $accordionNumber . '-' . $count;
                                                                            ?>

                                                                                <div class="timeline-number">
                                                                                    <?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                                                                                </div>

                                                                                <div class="accordion-item">

                                                                                    <h2 class="accordion-header"
                                                                                        id="<?= $headingId ?>">

                                                                                        <button
                                                                                            class="accordion-button <?= ($count != 1) ? 'collapsed' : '' ?>"
                                                                                            type="button"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#<?= $collapseId ?>"
                                                                                            aria-expanded="<?= ($count == 1) ? 'true' : 'false' ?>"
                                                                                            aria-controls="<?= $collapseId ?>">

                                                                                            Day <?= $key_3 + 1 ?> -
                                                                                            <?= htmlspecialchars($day['title'] ?? '') ?>

                                                                                        </button>

                                                                                    </h2>

                                                                                    <div
                                                                                        id="<?= $collapseId ?>"
                                                                                        class="accordion-collapse collapse <?= ($count == 1) ? 'show' : '' ?>"
                                                                                        aria-labelledby="<?= $headingId ?>"
                                                                                        data-bs-parent="#accordionItinerary<?= (int)$accordionNumber ?>">

                                                                                        <div class="accordion-body">

                                                                                            <!-- DAY DESCRIPTION -->
                                                                                            <ul class="listing">
                                                                                                <li class="list">
                                                                                                    <?= nl2br(htmlspecialchars($description)) ?>
                                                                                                </li>
                                                                                            </ul>

                                                                                            <hr class="my-3"
                                                                                                style="border-top:1px solid #4b5051;">

                                                                                            <!-- MEAL / TRANSPORT / STAY -->
                                                                                            <div class="d-flex justify-content-evenly displayMeal">

                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">
                                                                                                        Meal:&nbsp;
                                                                                                    </h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                                        <?= htmlspecialchars($mealPlan ?: 'N/A') ?>
                                                                                                    </p>
                                                                                                </div>

                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">
                                                                                                        Transport:&nbsp;
                                                                                                    </h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                                        <?= htmlspecialchars($dayTransport ?: 'N/A') ?>
                                                                                                    </p>
                                                                                                </div>

                                                                                                <div class="gap-1 d-flex">
                                                                                                    <h6 class="fw-bold align-content-center mb-0">
                                                                                                        Stay:&nbsp;
                                                                                                    </h6>
                                                                                                    <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                                        <?= htmlspecialchars($stay ?: 'N/A') ?>
                                                                                                    </p>
                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                            <?php
                                                                                $count++;
                                                                            endforeach;
                                                                            ?>

                                                                            <?php if (empty($days)): ?>
                                                                                <p class="text-muted fontSize10">
                                                                                    No itinerary details available.
                                                                                </p>
                                                                            <?php endif; ?>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div id="inclusion1" class="section-block">
                                                            <?php

                                                                // Fetch inclusion and exclusion from request_details_itinerary
                                                                $itineraryStmt = $conn->prepare("
                                                                    SELECT inclusion, exclusion
                                                                    FROM request_details_itinerary
                                                                    WHERE request_id = :request_id
                                                                    AND reply_id=:reply_id
                                                                    LIMIT 1
                                                                ");

                                                                $itineraryStmt->execute([
                                                                    ':request_id' => $requestData['request_id'],
                                                                    ':reply_id' => $replyData['id']
                                                                ]);

                                                                $itinery1 = $itineraryStmt->fetch(PDO::FETCH_ASSOC) ?: [];

                                                                // Decode JSON data
                                                                $inclusions1 = safeJsonDecode($itinery1['inclusion'] ?? '');
                                                                $exclusions1 = safeJsonDecode($itinery1['exclusion'] ?? '');

                                                            ?>

                                                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">
                                                                <h5 class="fw-bolder textDarkBlue">Inclusion & Exclusion</h5>

                                                                <div class="row">

                                                                    <!-- Inclusions -->
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                        <?php if (!empty($inclusions1)): ?>
                                                                            <?php foreach ($inclusions1 as $inclusion): ?>
                                                                                <div class="d-flex gap-3 mt-2">
                                                                                    <div class="checkIcon">
                                                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                                                    </div>
                                                                                    <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                        <?= htmlspecialchars($inclusion) ?>
                                                                                    </p>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <p class="text-muted mt-2 mb-0">No inclusions available.</p>
                                                                        <?php endif; ?>
                                                                    </div>

                                                                    <!-- Exclusions -->
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                        <?php if (!empty($exclusions1)): ?>
                                                                            <?php foreach ($exclusions1 as $exclusion): ?>
                                                                                <div class="d-flex gap-3 mt-2">
                                                                                    <div class="closeIcon">
                                                                                        <i class="ri-close-circle-fill text-danger"></i>
                                                                                    </div>
                                                                                    <p class="text-muted fontSize3 align-content-center mb-0">
                                                                                        <?= htmlspecialchars($exclusion) ?>
                                                                                    </p>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <p class="text-muted mt-2 mb-0">No exclusions available.</p>
                                                                        <?php endif; ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="policies1" class="section-block">
                                                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow">

                                                                <h5 class="fw-bolder mb-3 textDarkBlue">Policies</h5>

                                                                <!-- <p class="text-muted fontSize3 mb-3">
                                                                    Upload brochures, itinerary PDFs or any other important documents for reference.
                                                                </p> -->

                                                                <div id="">
                                                                    <?php
                                                                        $newPolicyStmt = $conn->prepare("
                                                                            SELECT *
                                                                            FROM request_details_policy_document
                                                                            WHERE request_id = :request_id
                                                                            AND reply_id=:reply_id
                                                                            ORDER BY id ASC
                                                                        ");

                                                                        $newPolicyStmt->execute([
                                                                            ':request_id' => $requestData['request_id'],
                                                                            ':reply_id' => $replyData['id']
                                                                        ]);

                                                                        $newPolicies = $newPolicyStmt->fetchAll(PDO::FETCH_ASSOC);

                                                                        // Merge existing and newly added policies
                                                                        $allPolicies = array_merge(
                                                                            $policies ?? [],
                                                                            $newPolicies ?? []
                                                                        );
                                                                        $hasPolicies = false;

                                                                        foreach ($allPolicies as $doc):

                                                                            if (strcasecmp(trim($doc['title'] ?? ''), 'FAQ') === 0) {
                                                                                continue;
                                                                            }

                                                                            $hasPolicies = true;
                                                                    ?>

                                                                        <div class="policyItem"
                                                                            data-id="<?= (int)$doc['id'] ?>"
                                                                            data-existing="1">

                                                                            <div class="d-flex align-items-center gap-3">

                                                                                <div class="highlightIcon" style="background-color: #b2e0b1;">
                                                                                    <i class="ri-file-pdf-line text-success"></i>
                                                                                </div>

                                                                                <div>
                                                                                    <p class="mb-0 fw-semibold">
                                                                                        <?= htmlspecialchars($doc['title'] ?? '') ?>
                                                                                    </p>

                                                                                    <small class="text-muted">
                                                                                        <?= htmlspecialchars($doc['file_name'] ?? '') ?>
                                                                                    </small>
                                                                                </div>

                                                                            </div>

                                                                            <div class="d-flex align-items-center gap-2">

                                                                                <a
                                                                                    href="../../uploading/package_policy_attachments/<?= rawurlencode($doc['file_name']) ?>"
                                                                                    download
                                                                                    class="downloadBtn"
                                                                                    title="Download document">
                                                                                    <i class="ri-download-line"></i>
                                                                                </a>

                                                                                <!-- <button
                                                                                    type="button"
                                                                                    class="btn btn-link text-danger p-1 remove-file"
                                                                                    data-id="<?= (int)$doc['id'] ?>"
                                                                                    title="Remove document">
                                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                                </button> -->

                                                                            </div>
                                                                        </div>

                                                                    <?php endforeach; ?>

                                                                    <?php if (!$hasPolicies): ?>
                                                                        <p class="text-muted mb-0" id="noOtherPolicy">
                                                                            No other policy documents available.
                                                                        </p>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <hr class="my-3">

                                                                <!-- Upload Area -->
                                                                <!-- <div class="upload-form-row">

                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        id="documentTitle"
                                                                        placeholder="Enter Title">

                                                                    <div class="mini-drop-zone" id="dropZone">
                                                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>

                                                                        <span id="selectedFileText">
                                                                            Drag &amp; Drop or Click to Upload
                                                                        </span>

                                                                        <input
                                                                            type="file"
                                                                            id="fileInput"
                                                                            class="hidden-input"
                                                                            accept=".pdf,.doc,.docx">
                                                                    </div>

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-primary px-4"
                                                                        id="addDocumentBtn">
                                                                        Submit
                                                                    </button>

                                                                </div> -->

                                                                <small class="error-message" id="otherPolicy_error"></small>

                                                            </div>
                                                        </div>
                                                        <div id="faqs1" class="section-block">
                                                            <div class="card cardBackgroundColor rounded-3 p-3 cardShadow mb-0">
                                                                <h5 class="fw-bolder textDarkBlue">Cancellation Policy</h5>
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
                                                                        <?php

                                                                            $stmt = $conn->prepare("
                                                                                SELECT *
                                                                                FROM request_details_cancellation_policy
                                                                                WHERE request_id = :request_id
                                                                                AND reply_id = :reply_id
                                                                                LIMIT 1
                                                                            ");

                                                                            $stmt->execute([
                                                                                ':request_id' => $requestData['request_id'],
                                                                                ':reply_id' => $replyData['id']
                                                                            ]);

                                                                            $request_details_cancellation_policy = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

                                                                        ?>
                                                                        <div class="inputFieldAlignment">
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="" name="cancellationPercentage1" placeholder="0" value="<?= $request_details_cancellation_policy['policy_1']??0 ?>" readonly>
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage1_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="" name="cancellationPercentage2" placeholder="0" value="<?= $request_details_cancellation_policy['policy_2']??0 ?>" readonly>
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage2_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="" name="cancellationPercentage3" placeholder="0" value="<?= $request_details_cancellation_policy['policy_3']??0 ?>" readonly>
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage3_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="" name="cancellationPercentage4" placeholder="0" value="<?= $request_details_cancellation_policy['policy_4']??0 ?>" readonly>
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage4_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="" name="cancellationPercentage5" placeholder="0" value="<?= $request_details_cancellation_policy['policy_5']??0 ?>" readonly>
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage5_error"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ubx-datetime-wrapper mt-3">
                                                                <?php
                                                                    $quotValidity = $replyData['quot_validity'] ?? '';

                                                                    $displayValidity = '';

                                                                    if (!empty($quotValidity) && $quotValidity !== '0000-00-00 00:00:00') {
                                                                        $displayValidity = date('d/m/Y h:i:s A', strtotime($quotValidity));
                                                                    }
                                                                ?>
                                                                <div class="ubx-datetime-wrapper">

                                                                    <label for="ubxDatetime" class="form-label fw-semibold">
                                                                        Quotation Validity Date & Time
                                                                    </label>

                                                                    <div class="position-relative">

                                                                        <input
                                                                            type="text"
                                                                            id="ubxDatetime"
                                                                            name="datetime"
                                                                            class="ubx-datetime-input"
                                                                            placeholder="DD/MM/YYYY HH:MM:SS"
                                                                            value="<?= htmlspecialchars($displayValidity, ENT_QUOTES, 'UTF-8') ?>"
                                                                            readonly
                                                                        >

                                                                        <i class="ri-calendar-event-line ubx-datetime-icon"></i>

                                                                    </div>

                                                                    <input
                                                                        type="hidden"
                                                                        id="ubxMysqlDatetime"
                                                                        name="mysql_datetime"
                                                                        value="<?= htmlspecialchars($quotValidity, ENT_QUOTES, 'UTF-8') ?>"
                                                                    >
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                            <?php
                                                                $adultCount  = (int)($replyData['adult_count'] ?? 0);
                                                                $childCount  = (int)($replyData['child_count'] ?? 0);
                                                                $infantCount = (int)($replyData['infant_count'] ?? 0);

                                                                $memberGroups = [
                                                                    'Adult'  => $adultCount,
                                                                    'Child'  => $childCount,
                                                                    'Infant' => $infantCount
                                                                ];

                                                                $totalMembers = $adultCount + $childCount + $infantCount;
                                                            ?>
                                                            <?php

                                                                // ==========================================
                                                                // CHECK CUSTOMER RESPONSE FOR THIS QUOTATION
                                                                // ==========================================

                                                                $existingCustomerReply = null;
                                                                $existingCustomerMembers = [];

                                                                $hasCustomerReplied = false;

                                                                try {

                                                                    $stmt = $conn->prepare("
                                                                        SELECT
                                                                            id,
                                                                            request_id,
                                                                            package_id,
                                                                            reply_id,
                                                                            title,
                                                                            message,
                                                                            status,
                                                                            uploaded_on
                                                                        FROM request_details_customer_reply
                                                                        WHERE request_id = :request_id
                                                                        AND package_id = :package_id
                                                                        AND reply_id = :reply_id
                                                                        ORDER BY id DESC
                                                                        LIMIT 1
                                                                    ");

                                                                    $stmt->execute([
                                                                        ':request_id' => $request_id,
                                                                        ':package_id' => $package_id,
                                                                        ':reply_id'   => $reply_id
                                                                    ]);

                                                                    $existingCustomerReply = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                    $hasCustomerReplied = !empty($existingCustomerReply);


                                                                    // ==========================================
                                                                    // FETCH SUBMITTED TRAVELLER DETAILS
                                                                    // ==========================================

                                                                    if (
                                                                        $hasCustomerReplied &&
                                                                        (int)$existingCustomerReply['status'] === 1
                                                                    ) {

                                                                        $memberStmt = $conn->prepare("
                                                                            SELECT
                                                                                id,
                                                                                member_type,
                                                                                name,
                                                                                age,
                                                                                gender
                                                                            FROM request_details_member_details
                                                                            WHERE request_id = :request_id
                                                                            AND package_id = :package_id
                                                                            AND reply_id = :customer_reply_id
                                                                            ORDER BY id ASC
                                                                        ");

                                                                        $memberStmt->execute([
                                                                            ':request_id'        => $request_id,
                                                                            ':package_id'        => $package_id,
                                                                            ':customer_reply_id' => $existingCustomerReply['id']
                                                                        ]);

                                                                        $existingCustomerMembers = $memberStmt->fetchAll(PDO::FETCH_ASSOC);
                                                                    }

                                                                } catch (PDOException $e) {

                                                                    error_log('Customer response check error: ' . $e->getMessage());

                                                                    $hasCustomerReplied = false;
                                                                }

                                                                if ($hasCustomerReplied) {

                                                                    $statusMap = [
                                                                        1 => [
                                                                            'label' => 'Quotation Approved',
                                                                            'icon' => 'ri-checkbox-circle-fill',
                                                                            'class' => 'response-approved',
                                                                            'message' => 'You have successfully approved this quotation.'
                                                                        ],
                                                                        0 => [
                                                                            'label' => 'Quotation Rejected',
                                                                            'icon' => 'ri-close-circle-fill',
                                                                            'class' => 'response-rejected',
                                                                            'message' => 'You have rejected this quotation.'
                                                                        ],
                                                                        2 => [
                                                                            'label' => 'Changes Requested',
                                                                            'icon' => 'ri-edit-circle-fill',
                                                                            'class' => 'response-change-request',
                                                                            'message' => 'You have requested changes to this quotation.'
                                                                        ]
                                                                    ];

                                                                    $submittedStatus = (int)$existingCustomerReply['status'];

                                                                    $submittedResponse = $statusMap[$submittedStatus]
                                                                        ?? $statusMap[2];
                                                            ?>

                                                            <div class="ubx-customer-response mt-3">

                                                                <div class="card cardBackgroundColor rounded-3 p-3 p-md-4 cardShadow">

                                                                    <div class="d-flex align-items-center gap-2 mb-3">

                                                                        <div class="ubx-response-icon">
                                                                            <i class="ri-chat-check-line"></i>
                                                                        </div>

                                                                        <div>
                                                                            <h5 class="fw-bolder textDarkBlue mb-0">
                                                                                Your Quotation Response
                                                                            </h5>

                                                                            <small class="text-muted">
                                                                                You have already submitted your response.
                                                                            </small>
                                                                        </div>

                                                                    </div>

                                                                    <div class="customerResponseMessage <?= $submittedResponse['class'] ?> mb-3">

                                                                        <div class="d-flex align-items-start gap-2">

                                                                            <i class="<?= $submittedResponse['icon'] ?> customerResponseStatusIcon"></i>

                                                                            <div>

                                                                                <p class="fw-bold fontSize12 mb-1">
                                                                                    <?= htmlspecialchars($submittedResponse['label'], ENT_QUOTES, 'UTF-8') ?>
                                                                                </p>

                                                                                <p class="fontSize11 mb-0">
                                                                                    <?= htmlspecialchars($submittedResponse['message'], ENT_QUOTES, 'UTF-8') ?>
                                                                                </p>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <!-- Submitted Remarks -->
                                                                    <div class="customerCommentBox mb-3">

                                                                        <p class="fontSize10 fw-bold textDarkBlue mb-2">
                                                                            <i class="ri-message-2-line me-1"></i>
                                                                            Your Submitted Remarks
                                                                        </p>

                                                                        <p class="fontSize11 text-secondary mb-0">
                                                                            <?= !empty($existingCustomerReply['message'])
                                                                                ? nl2br(htmlspecialchars($existingCustomerReply['message'], ENT_QUOTES, 'UTF-8'))
                                                                                : 'No remarks provided.' ?>
                                                                        </p>

                                                                    </div>

                                                                    <?php if ($submittedStatus === 1) { ?>

                                                                        <!-- Submitted Traveller Details -->
                                                                        <div class="customerCommentBox mb-3">

                                                                            <div class="d-flex justify-content-between align-items-center mb-3">

                                                                                <p class="fontSize10 fw-bold textDarkBlue mb-0">
                                                                                    <i class="ri-group-line me-1"></i>
                                                                                    Submitted Traveller Details
                                                                                </p>

                                                                                <span class="badge bg-light text-dark">
                                                                                    <?= count($existingCustomerMembers) ?> Members
                                                                                </span>

                                                                            </div>

                                                                            <?php if (!empty($existingCustomerMembers)) { ?>

                                                                                <div class="table-responsive">

                                                                                    <table class="table table-bordered table-hover align-middle mb-0">

                                                                                        <thead class="table-light">
                                                                                            <tr>
                                                                                                <th class="fontSize10 text-center">#</th>
                                                                                                <th class="fontSize10">Member Type</th>
                                                                                                <th class="fontSize10">Full Name</th>
                                                                                                <th class="fontSize10">Age</th>
                                                                                                <th class="fontSize10">Gender</th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            <?php foreach ($existingCustomerMembers as $index => $member) { ?>

                                                                                                <tr>

                                                                                                    <td class="fontSize11 text-center">
                                                                                                        <?= $index + 1 ?>
                                                                                                    </td>

                                                                                                    <td class="fontSize11">
                                                                                                        <?= htmlspecialchars($member['member_type'], ENT_QUOTES, 'UTF-8') ?>
                                                                                                    </td>

                                                                                                    <td class="fontSize11 fw-semibold textDarkBlue">
                                                                                                        <?= htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8') ?>
                                                                                                    </td>

                                                                                                    <td class="fontSize11">
                                                                                                        <?= htmlspecialchars($member['age'], ENT_QUOTES, 'UTF-8') ?>
                                                                                                    </td>

                                                                                                    <td class="fontSize11">
                                                                                                        <?= htmlspecialchars($member['gender'], ENT_QUOTES, 'UTF-8') ?>
                                                                                                    </td>

                                                                                                </tr>

                                                                                            <?php } ?>

                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>

                                                                            <?php } else { ?>

                                                                                <p class="fontSize11 text-muted mb-0">
                                                                                    No traveller details were found.
                                                                                </p>

                                                                            <?php } ?>

                                                                        </div>

                                                                    <?php } ?>

                                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

                                                                        <small class="text-muted fontSize10">
                                                                            <i class="ri-calendar-line me-1"></i>
                                                                            Submitted:
                                                                            <?= htmlspecialchars($existingCustomerReply['uploaded_on'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                                        </small>

                                                                        <span class="badge bg-light text-dark">
                                                                            Response Already Submitted
                                                                        </span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            
                                                            <?php } else { ?>
                                                            <div class="ubx-customer-response mt-3">

                                                                <div class="card cardBackgroundColor rounded-3 p-3 p-md-4 cardShadow">

                                                                    <!-- Header -->
                                                                    <div class="d-flex align-items-center gap-2 mb-3">

                                                                        <div class="ubx-response-icon">
                                                                            <i class="ri-chat-check-line"></i>
                                                                        </div>

                                                                        <div>
                                                                            <h5 class="fw-bolder textDarkBlue mb-0">
                                                                                Your Quotation Response
                                                                            </h5>

                                                                            <small class="text-muted">
                                                                                Please review your quotation and select how you would like to proceed.
                                                                            </small>
                                                                        </div>

                                                                    </div>

                                                                    <div class="ubx-response-info mb-4">
                                                                        <i class="ri-information-line me-1"></i>
                                                                        You can approve the quotation, reject it or request changes before proceeding.
                                                                    </div>

                                                                    <!-- Action Selection -->
                                                                    
                                                                    <div class="ubx-response-actions">

                                                                        <button type="button"
                                                                            class="ubx-action-card ubx-action-approve"
                                                                            data-action="approved">

                                                                            <span class="ubx-action-icon">
                                                                                <i class="ri-checkbox-circle-line"></i>
                                                                            </span>

                                                                            <span class="ubx-action-content">
                                                                                <strong>Approve Quotation</strong>
                                                                                <small>I'm happy with this quotation.</small>
                                                                            </span>

                                                                            <i class="ri-arrow-right-s-line ubx-action-arrow"></i>
                                                                        </button>

                                                                        <button type="button"
                                                                            class="ubx-action-card ubx-action-reject"
                                                                            data-action="rejected">

                                                                            <span class="ubx-action-icon">
                                                                                <i class="ri-close-circle-line"></i>
                                                                            </span>

                                                                            <span class="ubx-action-content">
                                                                                <strong>Reject Quotation</strong>
                                                                                <small>I don't wish to proceed with this quotation.</small>
                                                                            </span>

                                                                            <i class="ri-arrow-right-s-line ubx-action-arrow"></i>
                                                                        </button>

                                                                        <button type="button"
                                                                            class="ubx-action-card ubx-action-changes"
                                                                            data-action="change_request">

                                                                            <span class="ubx-action-icon">
                                                                                <i class="ri-edit-circle-line"></i>
                                                                            </span>

                                                                            <span class="ubx-action-content">
                                                                                <strong>Request Changes</strong>
                                                                                <small>I'd like to make some changes before approving.</small>
                                                                            </span>

                                                                            <i class="ri-arrow-right-s-line ubx-action-arrow"></i>
                                                                        </button>

                                                                    </div>


                                                                    <form id="ubxCustomerResponseForm" method="POST">

                                                                        
                                                                        <!-- ================================== -->
                                                                        <!-- APPROVAL SECTION -->
                                                                        <!-- ================================== -->

                                                                        <fieldset class="ubx-response-panel" id="ubxApprovePanel" disabled>

                                                                            <div class="ubx-panel-heading">

                                                                                <h6 class="fw-bold text-success mb-1">
                                                                                    <i class="ri-checkbox-circle-fill me-1"></i>
                                                                                    Confirm Your Quotation
                                                                                </h6>

                                                                                <p class="fontSize11 text-muted mb-3">
                                                                                    Please provide the details of all travellers to continue.
                                                                                </p>

                                                                            </div>

                                                                            <div class="ubx-member-heading mb-3">

                                                                                <strong class="fontSize12 textDarkBlue">
                                                                                    Traveller Details
                                                                                </strong>

                                                                                <span class="badge bg-light text-dark">
                                                                                    <?= $totalMembers ?> Members
                                                                                </span>

                                                                            </div>

                                                                            <?php if ($totalMembers > 0) { ?>

                                                                                <div class="table-responsive">

                                                                                    <table class="table table-bordered align-middle ubx-member-table">

                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Member Type</th>
                                                                                                <th>Full Name</th>
                                                                                                <th>Age</th>
                                                                                                <th>Gender</th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            <?php
                                                                                                $memberNumber = 0;

                                                                                                foreach ($memberGroups as $memberType => $count) {
                                                                                                    for ($i = 1; $i <= $count; $i++) {

                                                                                                        $memberNumber++;
                                                                                            ?>

                                                                                                <tr class="ubx-member-row">

                                                                                                    <td class="text-center">
                                                                                                        <?= $memberNumber ?>
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <span class="badge bg-light text-dark">
                                                                                                            <?= htmlspecialchars($memberType) ?>
                                                                                                        </span>
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            class="form-control form-control-sm"
                                                                                                            name="members[<?= $memberNumber ?>][full_name]"
                                                                                                            placeholder="Enter full name"
                                                                                                            maxlength="150"
                                                                                                            required
                                                                                                        >

                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            class="ubx-member-type"
                                                                                                            name="members[<?= $memberNumber ?>][member_type]"
                                                                                                            value="<?= htmlspecialchars($memberType) ?>"
                                                                                                        >
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            class="form-control form-control-sm ubx-member-age"
                                                                                                            name="members[<?= $memberNumber ?>][age]"
                                                                                                            placeholder="Age"
                                                                                                            min="0"
                                                                                                            max="120"
                                                                                                            step="1"
                                                                                                            required
                                                                                                        >
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <select
                                                                                                            class="form-select form-select-sm"
                                                                                                            name="members[<?= $memberNumber ?>][gender]"
                                                                                                            required
                                                                                                        >
                                                                                                            <option value="">Select</option>
                                                                                                            <option value="Male">Male</option>
                                                                                                            <option value="Female">Female</option>
                                                                                                            <option value="Other">Other</option>
                                                                                                        </select>
                                                                                                    </td>

                                                                                                </tr>

                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>

                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>

                                                                            <?php } else { ?>

                                                                                <p class="text-muted fontSize12">
                                                                                    No traveller details are available for this quotation.
                                                                                </p>

                                                                            <?php } ?>

                                                                            <div class="ubx-approval-note mb-3">
                                                                                <i class="ri-shield-check-line me-1"></i>
                                                                                Please ensure all traveller details are correct before confirming.
                                                                            </div>

                                                                            <div class="d-flex justify-content-end">
                                                                                <!-- Approve -->
                                                                                <button type="submit"
                                                                                        id="ubxApproveSubmit"
                                                                                        class="btn btn-success btn-sm ubx-submit-response">
                                                                                    <i class="ri-check-double-line me-1"></i>
                                                                                    Confirm & Approve Quotation
                                                                                </button>

                                                                            </div>

                                                                        </fieldset>


                                                                        <!-- ================================== -->
                                                                        <!-- REJECTION SECTION -->
                                                                        <!-- ================================== -->

                                                                        <fieldset class="ubx-response-panel" id="ubxRejectPanel" disabled>

                                                                            <h6 class="fw-bold text-danger mb-1">
                                                                                <i class="ri-close-circle-fill me-1"></i>
                                                                                Why are you rejecting this quotation?
                                                                            </h6>

                                                                            <p class="fontSize11 text-muted mb-3">
                                                                                Please select the reason that best describes your decision.
                                                                            </p>

                                                                            <div class="ubx-reason-list">

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="The quotation is too expensive" required>
                                                                                    <span>The quotation is too expensive</span>
                                                                                </label>

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="I found a better offer">
                                                                                    <span>I found a better offer elsewhere</span>
                                                                                </label>

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="Travel plans have changed">
                                                                                    <span>My travel plans have changed</span>
                                                                                </label>

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="I have booked with another provider">
                                                                                    <span>I've booked with another provider</span>
                                                                                </label>

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="The itinerary does not meet my requirements">
                                                                                    <span>The itinerary does not meet my requirements</span>
                                                                                </label>

                                                                                <label class="ubx-reason-option">
                                                                                    <input type="radio" name="rejection_reason"
                                                                                        value="Other" id="ubxOtherReason">
                                                                                    <span>Other</span>
                                                                                </label>

                                                                            </div>

                                                                            <div class="ubx-other-reason mt-3" id="ubxOtherReasonBox">

                                                                                <label class="form-label fontSize11 fw-semibold">
                                                                                    Please specify your reason
                                                                                </label>

                                                                                <textarea
                                                                                    class="form-control"
                                                                                    name="rejection_other_reason"
                                                                                    id="ubxOtherReasonText"
                                                                                    rows="3"
                                                                                    maxlength="1000"
                                                                                    placeholder="Tell us why you are rejecting this quotation..."
                                                                                    disabled
                                                                                ></textarea>

                                                                            </div>

                                                                            <div class="d-flex justify-content-end mt-3">
                                                                                <!-- Reject -->
                                                                                <button type="submit"
                                                                                        id="ubxRejectSubmit"
                                                                                        class="btn btn-danger btn-sm ubx-submit-response">
                                                                                    <i class="ri-close-circle-line me-1"></i>
                                                                                    Reject Quotation
                                                                                </button>

                                                                            </div>

                                                                        </fieldset>


                                                                        <!-- ================================== -->
                                                                        <!-- CHANGE REQUEST SECTION -->
                                                                        <!-- ================================== -->

                                                                        <fieldset class="ubx-response-panel" id="ubxChangePanel" disabled>

                                                                            <h6 class="fw-bold text-warning mb-1">
                                                                                <i class="ri-edit-circle-fill me-1"></i>
                                                                                Request Changes to Your Quotation
                                                                            </h6>

                                                                            <p class="fontSize11 text-muted mb-3">
                                                                                Let us know what you'd like to change. Our team will review your request and update the quotation.
                                                                            </p>

                                                                            <label class="form-label fontSize11 fw-semibold">
                                                                                Describe the changes you require
                                                                            </label>

                                                                            <textarea
                                                                                class="form-control"
                                                                                name="change_request_reason"
                                                                                id="ubxChangeReason"
                                                                                rows="4"
                                                                                maxlength="2000"
                                                                                placeholder="For example: Change the hotel category, modify travel dates, update the vehicle, adjust the itinerary or revise the budget..."
                                                                                required
                                                                            ></textarea>

                                                                            <div class="d-flex justify-content-end mt-3">
                                                                                <!-- Change Request -->
                                                                                <button type="submit"
                                                                                        id="ubxChangeSubmit"
                                                                                        class="btn btn-warning btn-sm text-dark ubx-submit-response">

                                                                                    <i class="ri-send-plane-line me-1"></i>
                                                                                    Send Change Request
                                                                                </button>

                                                                            </div>

                                                                        </fieldset>
                                                                        <input type="hidden" name="request_id"
                                                                            value="<?= htmlspecialchars($request_id, ENT_QUOTES, 'UTF-8') ?>">

                                                                        <input type="hidden" name="package_id"
                                                                            value="<?= (int)$package_id ?>">

                                                                        <input type="hidden" name="reply_id"
                                                                            value="<?= (int)$reply_id ?>">

                                                                        <input type="hidden" name="response_action" id="ubxResponseAction">
                                                                    </form>

                                                                </div>

                                                            </div>
                                                            <?php } ?>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                                <!-- Card Section 2 subsection 6 End -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                    <?php endforeach;
                        }
                        }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "customer_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Customer Dashboard here -->
            <!-- ============================================================== -->
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        <?php include (__DIR__ .'/../contact_modal.php') ?>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="<?= $base_url ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?= $base_url ?>assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="<?= $base_url ?>assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="<?= $base_url ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="<?= $base_url ?>assets/js/app.js"></script>
        <!-- Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="assets/libs/chart.js/Chart-2.5.0.min.js"></script> -->


        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>

        <script>
            function toggleWishlist(button) {

                button.classList.toggle("active");

                const icon = button.querySelector("i");

                if (button.classList.contains("active")) {
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                } else {
                    icon.classList.remove("fa-solid");
                    icon.classList.add("fa-regular");
                }
            }
        </script>
        
        <!-- dialer logic -->
        <!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <script>  
            
            // ==========================================
            // PHP VARIABLES
            // ==========================================

            const requestId = <?= json_encode((string)$request_id) ?>;
            const packageId = <?= (int)$package_id ?>;
            const replyId = <?= (int)$reply_id ?>;


            // ==========================================
            // CUSTOMER RESPONSE HANDLER
            // ==========================================

            document.addEventListener('DOMContentLoaded', function () {

                // ==========================================
                // ELEMENTS
                // ==========================================

                const actionCards = document.querySelectorAll('.ubx-action-card');

                const responseForm = document.getElementById('ubxCustomerResponseForm');
                const responseAction = document.getElementById('ubxResponseAction');

                const approvePanel = document.getElementById('ubxApprovePanel');
                const rejectPanel = document.getElementById('ubxRejectPanel');
                const changePanel = document.getElementById('ubxChangePanel');

                const otherReasonRadio = document.getElementById('ubxOtherReason');
                const otherReasonBox = document.getElementById('ubxOtherReasonBox');
                const otherReasonText = document.getElementById('ubxOtherReasonText');

                const panels = {
                    approved: approvePanel,
                    rejected: rejectPanel,
                    change_request: changePanel
                };

                let isSubmitting = false;

                const responseUrl = 'ajax/save_customer_reply.php';


                // ==========================================
                // CHECK FORM
                // ==========================================

                if (!responseForm) {
                    console.error('Customer response form not found.');
                    return;
                }
                

                // ==========================================
                // CHECK REQUIRED ELEMENTS
                // ==========================================

                if (!responseAction) {
                    console.error('Response action hidden input not found.');
                    return;
                }


                // ==========================================
                // COMMON SWEETALERT VALIDATION
                // ==========================================

                function showValidation(title, message, field = null) {

                    Swal.fire({
                        icon: 'warning',
                        title: title,
                        text: message,
                        confirmButtonText: 'Okay',
                        confirmButtonColor: '#2563eb'
                    }).then(function () {

                        if (field && typeof field.focus === 'function') {

                            field.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            field.focus();

                        }

                    });

                }


                // ==========================================
                // AGE LIMITS
                // ==========================================

                const ageLimits = {

                    adult: {
                        min: 12,
                        max: 120
                    },

                    child: {
                        min: 2,
                        max: 11
                    },

                    infant: {
                        min: 0,
                        max: 1
                    }

                };


                function getAgeRange(memberType) {

                    return ageLimits[
                        String(memberType).trim().toLowerCase()
                    ] || null;

                }
                // ==========================================
                // INITIALIZE TRAVELLER AGE LIMITS
                // ==========================================

                document.querySelectorAll('.ubx-member-row').forEach(function (memberRow) {

                    const memberType = memberRow.querySelector('.ubx-member-type');
                    const ageInput = memberRow.querySelector('.ubx-member-age');

                    if (!memberType || !ageInput) {
                        return;
                    }

                    const range = getAgeRange(memberType.value);

                    if (range) {

                        ageInput.min = range.min;
                        ageInput.max = range.max;
                        ageInput.placeholder = `${range.min} - ${range.max} Years`;

                    }

                });

                // ==========================================
                // UPDATE AGE RANGE ON MEMBER TYPE CHANGE
                // ==========================================

                document.addEventListener('change', function (e) {

                    if (!e.target.classList.contains('ubx-member-type')) {
                        return;
                    }

                    const memberRow = e.target.closest('.ubx-member-row');

                    if (!memberRow) {
                        return;
                    }

                    const ageInput = memberRow.querySelector('.ubx-member-age');

                    if (!ageInput) {
                        return;
                    }

                    const range = getAgeRange(e.target.value);

                    if (!range) {

                        ageInput.min = 0;
                        ageInput.max = 120;
                        ageInput.placeholder = 'Age';
                        ageInput.value = '';

                        return;
                    }

                    ageInput.min = range.min;
                    ageInput.max = range.max;
                    ageInput.placeholder = `${range.min} - ${range.max} Years`;

                    const currentAge = ageInput.value.trim();

                    if (
                        currentAge !== '' &&
                        (
                            !Number.isInteger(Number(currentAge)) ||
                            Number(currentAge) < range.min ||
                            Number(currentAge) > range.max
                        )
                    ) {

                        ageInput.value = '';

                        showValidation(
                            'Age Range Updated',
                            `${e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1)} age must be between ${range.min} and ${range.max} years.`,
                            ageInput
                        );

                    }

                });


                // ==========================================
                // VALIDATE MEMBER AGE
                // ==========================================

                function validateMemberAge(ageInput) {

                    const memberRow = ageInput.closest('.ubx-member-row');

                    if (!memberRow) {
                        return false;
                    }

                    const memberTypeInput = memberRow.querySelector('.ubx-member-type');

                    if (!memberTypeInput || !memberTypeInput.value) {
                        return false;
                    }

                    const range = getAgeRange(memberTypeInput.value);

                    if (!range) {
                        return false;
                    }

                    const ageValue = ageInput.value.trim();

                    if (ageValue === '') {
                        return false;
                    }

                    const age = Number(ageValue);

                    return (
                        Number.isInteger(age) &&
                        age >= range.min &&
                        age <= range.max
                    );

                }


                // ==========================================
                // VALIDATE ALL MEMBER DETAILS
                // ==========================================

                function validateMemberDetails() {

                    if (!approvePanel) {

                        showValidation(
                            'Member Details Missing',
                            'The traveller details section could not be found.'
                        );

                        return false;
                    }

                    const memberRows = approvePanel.querySelectorAll('.ubx-member-row');

                    if (memberRows.length === 0) {

                        showValidation(
                            'Traveller Details Missing',
                            'No traveller details were found. Please contact our team.'
                        );

                        return false;
                    }

                    for (let i = 0; i < memberRows.length; i++) {

                        const memberRow = memberRows[i];

                        const memberName = memberRow.querySelector('[name$="[full_name]"]');
                        const memberType = memberRow.querySelector('.ubx-member-type');
                        const memberAge = memberRow.querySelector('.ubx-member-age');

                        const memberGenderFields = memberRow.querySelectorAll(
                            '[name$="[gender]"]'
                        );

                        const memberNumber = i + 1;


                        // ==================================
                        // FULL NAME
                        // ==================================

                        if (!memberName || !memberName.value.trim()) {

                            showValidation(
                                'Member Name Required',
                                `Please enter the full name of Traveller ${memberNumber}.`,
                                memberName
                            );

                            return false;
                        }


                        // ==================================
                        // MEMBER TYPE
                        // ==================================

                        if (!memberType || !memberType.value.trim()) {

                            showValidation(
                                'Member Type Required',
                                `Please select the member type for Traveller ${memberNumber}.`,
                                memberType
                            );

                            return false;
                        }


                        // ==================================
                        // AGE
                        // ==================================

                        if (!memberAge || !memberAge.value.trim()) {

                            showValidation(
                                'Age Required',
                                `Please enter the age of Traveller ${memberNumber}.`,
                                memberAge
                            );

                            return false;
                        }

                        const range = getAgeRange(memberType.value);

                        if (!range) {

                            showValidation(
                                'Invalid Member Type',
                                `Please select a valid member type for Traveller ${memberNumber}.`,
                                memberType
                            );

                            return false;
                        }

                        if (!validateMemberAge(memberAge)) {

                            showValidation(
                                'Invalid Member Age',
                                `${memberType.value.charAt(0).toUpperCase() + memberType.value.slice(1)} age must be between ${range.min} and ${range.max} years.`,
                                memberAge
                            );

                            return false;
                        }


                        // ==================================
                        // GENDER
                        // ==================================

                        if (memberGenderFields.length === 0) {

                            showValidation(
                                'Gender Field Missing',
                                `Gender field is missing for Traveller ${memberNumber}.`
                            );

                            return false;
                        }

                        const firstGenderField = memberGenderFields[0];

                        let genderValue = '';

                        if (
                            firstGenderField.type === 'radio' ||
                            firstGenderField.type === 'checkbox'
                        ) {

                            const checkedGender = memberRow.querySelector(
                                '[name$="[gender]"]:checked'
                            );

                            genderValue = checkedGender
                                ? checkedGender.value.trim()
                                : '';

                        } else {

                            genderValue = firstGenderField.value.trim();

                        }

                        if (!genderValue) {

                            showValidation(
                                'Gender Required',
                                `Please select the gender of Traveller ${memberNumber}.`,
                                firstGenderField
                            );

                            return false;
                        }

                    }

                    return true;

                }


                // ==========================================
                // OTHER REJECTION REASON
                // ==========================================

                function toggleOtherReason() {

                    const selectedReason = rejectPanel
                        ? rejectPanel.querySelector('input[name="rejection_reason"]:checked')
                        : null;

                    const isOther = selectedReason &&
                        selectedReason.value.trim().toLowerCase() === 'other';

                    if (otherReasonBox) {
                        otherReasonBox.style.display = isOther ? 'block' : 'none';
                    }

                    if (otherReasonText) {

                        otherReasonText.disabled = !isOther;
                        otherReasonText.required = !!isOther;
                        otherReasonText.maxLength = 999;

                        if (!isOther) {
                            otherReasonText.value = '';
                        }

                    }

                }


                // ==========================================
                // REJECTION REASON CHANGE EVENT
                // ==========================================

                if (rejectPanel) {

                    rejectPanel.querySelectorAll(
                        'input[name="rejection_reason"]'
                    ).forEach(function (radio) {

                        radio.addEventListener('change', toggleOtherReason);

                    });

                }

                toggleOtherReason();


                // ==========================================
                // CHANGE REQUEST TEXTAREA
                // ==========================================

                const changeReasonInput = changePanel
                    ? changePanel.querySelector('[name="change_request_reason"]') ||
                    changePanel.querySelector('textarea')
                    : null;

                if (changeReasonInput) {

                    changeReasonInput.required = true;
                    changeReasonInput.maxLength = 999;

                }


                // ==========================================
                // TEXTAREA VALIDATION
                // ==========================================

                function validateTextLength(input, fieldName) {

                    if (!input) {
                        return false;
                    }

                    const value = input.value.trim();

                    if (!value) {

                        showValidation(
                            `${fieldName} Required`,
                            `Please enter your ${fieldName.toLowerCase()}.`,
                            input
                        );

                        return false;
                    }

                    if (input.value.length > 999) {

                        showValidation(
                            'Character Limit Exceeded',
                            `${fieldName} cannot exceed 999 characters.`,
                            input
                        );

                        return false;
                    }

                    return true;

                }


                // ==========================================
                // INITIALLY HIDE AND DISABLE ALL PANELS
                // ==========================================

                Object.values(panels).forEach(function (panel) {

                    if (!panel) {
                        return;
                    }

                    panel.disabled = true;
                    panel.style.display = 'none';

                });


                // ==========================================
                // SELECT RESPONSE ACTION
                // ==========================================

                actionCards.forEach(function (card) {

                    card.addEventListener('click', function () {

                        const selectedAction = this.dataset.action;

                        if (!panels[selectedAction]) {
                            return;
                        }


                        // ==================================
                        // REMOVE ACTIVE CLASS
                        // ==================================

                        actionCards.forEach(function (item) {
                            item.classList.remove('active');
                        });


                        // ==================================
                        // ACTIVATE SELECTED CARD
                        // ==================================

                        this.classList.add('active');


                        // ==================================
                        // UPDATE HIDDEN ACTION INPUT
                        // ==================================

                        responseAction.value = selectedAction;


                        // ==================================
                        // HIDE AND DISABLE ALL PANELS
                        // ==================================

                        Object.values(panels).forEach(function (panel) {

                            if (!panel) {
                                return;
                            }

                            panel.disabled = true;
                            panel.style.display = 'none';

                        });


                        // ==================================
                        // ENABLE SELECTED PANEL
                        // ==================================

                        const selectedPanel = panels[selectedAction];

                        selectedPanel.disabled = false;
                        selectedPanel.style.display = 'block';


                        // ==================================
                        // SCROLL TO SELECTED PANEL
                        // ==================================

                        setTimeout(function () {

                            selectedPanel.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });

                        }, 100);


                        // ==================================
                        // REFRESH REJECTION REASON
                        // ==================================

                        if (selectedAction === 'rejected') {
                            toggleOtherReason();
                        }

                    });

                });


                // ==========================================
                // FORM SUBMISSION - AJAX
                // ==========================================

                responseForm.addEventListener('submit', function (event) {

                    event.preventDefault();

                    if (isSubmitting) {
                        return;
                    }

                    const selectedAction = responseAction.value;


                    // ==================================
                    // ACTION REQUIRED
                    // ==================================

                    if (!selectedAction || !panels[selectedAction]) {

                        showValidation(
                            'Select an Option',
                            'Please select Approve, Reject, or Request Changes.'
                        );

                        return;
                    }


                    // ==================================
                    // APPROVAL VALIDATION
                    // ==================================

                    if (selectedAction === 'approved') {

                        if (!validateMemberDetails()) {
                            return;
                        }

                    }


                    // ==================================
                    // REJECTION VALIDATION
                    // ==================================

                    if (selectedAction === 'rejected') {

                        if (!rejectPanel) {

                            showValidation(
                                'Rejection Panel Missing',
                                'The rejection section could not be found.'
                            );

                            return;
                        }

                        const selectedReason = rejectPanel.querySelector(
                            'input[name="rejection_reason"]:checked'
                        );

                        if (!selectedReason) {

                            showValidation(
                                'Rejection Reason Required',
                                'Please select a reason for rejecting this quotation.'
                            );

                            return;
                        }

                        const isOther = selectedReason.value.trim().toLowerCase() === 'other';

                        if (isOther) {

                            if (!otherReasonText || !validateTextLength(
                                otherReasonText,
                                'Rejection Reason'
                            )) {
                                return;
                            }

                        }

                    }


                    // ==================================
                    // CHANGE REQUEST VALIDATION
                    // ==================================

                    if (selectedAction === 'change_request') {

                        if (!changeReasonInput) {

                            showValidation(
                                'Change Request Field Missing',
                                'The change request reason field could not be found.'
                            );

                            return;
                        }

                        if (!validateTextLength(
                            changeReasonInput,
                            'Change Request Reason'
                        )) {
                            return;
                        }

                    }


                    // ==================================
                    // GENERAL HTML VALIDATION
                    // ==================================

                    const activePanel = panels[selectedAction];

                    if (!activePanel.checkValidity()) {

                        const invalidField = activePanel.querySelector(':invalid');

                        showValidation(
                            'Incomplete Information',
                            'Please fill in all required fields before submitting.',
                            invalidField
                        );

                        return;
                    }


                    // ==================================
                    // CONFIRMATION MESSAGES
                    // ==================================

                    const confirmation = {

                        approved: {
                            title: 'Approve Quotation?',
                            text: 'Are you sure you want to approve this quotation and submit all traveller details?',
                            icon: 'success',
                            confirmButtonText: 'Yes, Approve',
                            confirmButtonColor: '#16a34a'
                        },

                        rejected: {
                            title: 'Reject Quotation?',
                            text: 'Are you sure you want to reject this quotation?',
                            icon: 'warning',
                            confirmButtonText: 'Yes, Reject',
                            confirmButtonColor: '#dc2626'
                        },

                        change_request: {
                            title: 'Request Changes?',
                            text: 'Are you sure you want to send your change request?',
                            icon: 'info',
                            confirmButtonText: 'Yes, Send Request',
                            confirmButtonColor: '#d69e36'
                        }

                    };


                    // ==================================
                    // SWEETALERT CONFIRMATION
                    // ==================================

                    Swal.fire({

                        ...confirmation[selectedAction],

                        showCancelButton: true,
                        cancelButtonText: 'Go Back',
                        reverseButtons: true

                    }).then(function (result) {

                        if (!result.isConfirmed) {
                            return;
                        }


                        // ==================================
                        // PREPARE FORM DATA
                        // ==================================

                        const formData = new FormData(responseForm);

                        formData.set('request_id', requestId);
                        formData.set('package_id', packageId);
                        formData.set('reply_id', replyId);
                        formData.set('response_action', selectedAction);


                        // ==================================
                        // DISABLE SUBMIT BUTTONS
                        // ==================================

                        isSubmitting = true;

                        const submitButtons = responseForm.querySelectorAll(
                            '[type="submit"]'
                        );

                        const originalButtonContents = [];

                        submitButtons.forEach(function (button, index) {

                            originalButtonContents[index] = button.innerHTML;

                            button.disabled = true;

                            button.innerHTML =
                                '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';

                        });


                        // ==================================
                        // AJAX REQUEST
                        // ==================================
                        console.log('Form Data:');

                        for (const [key, value] of formData.entries()) {
                            console.log(key, value);
                        }
                        
                        $.ajax({

                            url: responseUrl,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json',

                            success: function (response) {

                                if (response.status === true) {

                                    Swal.fire({

                                        icon: 'success',
                                        title: 'Response Submitted Successfully',
                                        text: response.message,
                                        confirmButtonText: 'Okay',
                                        confirmButtonColor: '#198754',
                                        allowOutsideClick: false

                                    }).then(function () {

                                        if (response.redirect_url) {

                                            window.location.href = response.redirect_url;

                                        } else {

                                            window.location.reload();

                                        }

                                    });

                                } else {

                                    // Allow retry.
                                    isSubmitting = false;

                                    submitButtons.forEach(function (button, index) {

                                        button.disabled = false;
                                        button.innerHTML = originalButtonContents[index];

                                    });

                                    Swal.fire({

                                        icon: 'error',
                                        title: 'Unable to Submit',
                                        text: response.message ||
                                            'Something went wrong. Please try again.'

                                    });

                                }

                            },

                            error: function (xhr) {

                                // Allow retry.
                                isSubmitting = false;

                                submitButtons.forEach(function (button, index) {

                                    button.disabled = false;
                                    button.innerHTML = originalButtonContents[index];

                                });

                                let errorMessage =
                                    'A server error occurred. Please try again.';

                                if (
                                    xhr.responseJSON &&
                                    xhr.responseJSON.message
                                ) {

                                    errorMessage = xhr.responseJSON.message;

                                }

                                Swal.fire({

                                    icon: 'error',
                                    title: 'Submission Failed',
                                    text: errorMessage

                                });

                                console.error(
                                    'Customer reply AJAX error:',
                                    xhr.responseText
                                );

                            }

                        });

                    });

                });

            });


        </script>
        <!-- Sidebar End -->
    </body>
</html>