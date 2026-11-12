<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo '<script>location.href = "../login.php";</script>';
    }
    include(__DIR__ . '/../connect.php');
    $date = date('Y'); 
    $request_id = $_POST['request_id'] ?? '';

    if (empty($request_id) || !is_scalar($request_id) || trim((string)$request_id) === '') {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Request ID',
                    text: 'The request ID is missing or invalid.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = 'enquiries.php';
                });
            </script>
        </body>
        </html>
        <?php
        exit;
    }
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

    if (!$requestData) {
        ?>
        
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Request ID',
                text: 'No request details found.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'enquires.php';
            });
        </script>
        <?php
        exit;
    }

    $id = $requestData['package_id'];
    $user_id = $requestData['userId'];
    if ($id === false || $id === null || $id <= 0) {
        ?>
        
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Package ID',
                text: 'The package ID is missing or invalid.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'enquiries.php';
            });
        </script>
        <?php
        exit;
    }
    include __DIR__ . '/ajax/tour_details_data.php';
    $vehicleOptions = [
        [
            'value' => 4,
            'name'  => '4 Seater',
            'type'  => 'Sedan',
            'icon'  => 'ri-car-line'
        ],
        [
            'value' => 6,
            'name'  => '6 Seater',
            'type'  => 'Ertiga / Innova',
            'icon'  => 'ri-car-line'
        ],
        [
            'value' => 12,
            'name'  => '12 Seater',
            'type'  => 'Tempo Traveller',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 16,
            'name'  => '16 Seater',
            'type'  => 'Tempo Traveller',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 18,
            'name'  => '18 Seater',
            'type'  => 'Tempo Traveller',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 22,
            'name'  => '22 Seater',
            'type'  => 'Tempo Traveller',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 26,
            'name'  => '26 Seater',
            'type'  => 'Tempo Traveller',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 35,
            'name'  => '35 Seater',
            'type'  => 'Bus',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 45,
            'name'  => '45 Seater',
            'type'  => 'Bus',
            'icon'  => 'ri-bus-line'
        ],
        [
            'value' => 50,
            'name'  => '50 Seater',
            'type'  => 'Bus',
            'icon'  => 'ri-bus-line'
        ]
    ];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enquiries</title>
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
        <!-- Css-->
        <link href="../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Prepare Quotation Css-->
        <link href="../assets/css/prepareQuotation.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> -->
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Date Range Picker CSS Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Date Range Picker CSS End -->
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
            .modify-room-card {
                border: 1px solid #d8dee6 !important;
                border-radius: 14px !important;
                padding: 18px 22px !important;
                background: #fff;
                transition: all 0.2s ease;
            }


            .modify-room-card:hover {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            }

            .room-content-row {
                display: flex;
                align-items: center;
                gap: 35px;
            }

            /* Room Title */
            .room-title {
                min-width: 130px;
            }

            .room-title p {
                margin: 0;
                font-size: 13px;
                font-weight: 600;
                color: #343a40;
            }

            /* Occupancy Section */
            .occupancy-section {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .occupancy-section label {
                margin: 0;
                white-space: nowrap;
            }

            /* Occupancy Counter */
            .occupancy-control {
                display: flex;
                align-items: center;
            }

            .occupancy-control button {
                width: 42px;
                height: 42px;
                border: 1px solid #c9a57a;
                background: #fff;
                color: #8a6a45;
                font-size: 20px;
            }

            .occupancy-control button:first-child {
                border-radius: 9px 0 0 9px;
            }

            .occupancy-control button:last-child {
                border-radius: 0 9px 9px 0;
            }

            .room-occupancy {
                width: 70px !important;
                height: 42px;
                border-left: 0 !important;
                border-right: 0 !important;
                font-size: 16px;
                background: #fff !important;
            }

            /* Mattress */
            .mattress-section {
                display: flex;
                align-items: center;
            }

            .mattress-section .form-check {
                display: flex;
                align-items: center;
                gap: 8px;
                padding-left: 0;
            }

            .mattress-section .form-check-input {
                position: static;
                float: none;
                margin: 0;
                width: 18px;
                height: 18px;
                flex-shrink: 0;
                opacity: 1;
                cursor: pointer;
            }

            .mattress-section .form-check-input:disabled {
                opacity: 1;
                background-color: #fff;
                border-color: #ced4da;
            }

            .mattress-section .form-check-input:disabled ~ .form-check-label {
                color: #6c757d;
                opacity: 1;
                cursor: not-allowed;
            }

            /* Remove button */
            .removeModifyRoom {
                border: 0;
                background: #fff3f3;
                color: #dc3545;
                border-radius: 7px;
                padding: 6px 12px;
                font-size: 12px;
            }
            .fontSize10 {
                font-size: 12px;
            }
            /* Policy section */
            .upload-description {
                color: #667085;
                margin-bottom: 15px;
            }

            .upload-wrapper {
                background: #fff;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
            }

            .upload-table {
                margin-bottom: 0;
            }

            .upload-table thead {
                background: #f5f6fa;
            }

            .upload-table th {
                font-size: 14px;
                font-weight: 600;
                color: #667085;
                border-bottom: 1px solid #e5e7eb;
            }

            .upload-table td {
                vertical-align: middle;
                color: #344054;
                font-size: 14px;
            }

            .file-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .file-icon {
                width: 34px;
                height: 34px;
            }

            .action-btn {
                cursor: pointer;
                font-size: 18px;
                color: #6C63FF;
                transition: 0.3s;
            }

            .action-btn:hover {
                transform: scale(1.1);
            }

            .delete-btn {
                color: #ff4d4f;
            }

            .hidden-input {
                display: none;
            }

            /* Upload Form Row */

            .upload-form-row {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 15px;
                border-top: 1px solid #e5e7eb;
            }

            .upload-form-row .form-control {
                flex: 1;
                min-width: 180px;
            }

            .mini-drop-zone {
                flex: 2;
                min-height: 45px;
                border: 2px dashed #d9dbe9;
                border-radius: 8px;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #6C63FF;
                font-weight: 500;
                padding: 10px 15px;
                transition: all 0.3s ease;
                text-align: center;
            }

            .mini-drop-zone:hover {
                border-color: #6C63FF;
            }

            .mini-drop-zone.dragover {
                border-color: #6C63FF;
                background: #f7f6ff;
            }

            #selectedFileText {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
            }

            #addDocumentBtn {
                white-space: nowrap;
            }
            @media (max-width: 576px) {
                .accordion-heading-content {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 6px;
                }

                .custom-history-accordion .accordion-button {
                    padding: 14px;
                }
            }
            @media (max-width: 767px) {
                .displayMeal {
                    display: block !important;
                }
            }
        </style>
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';

                $today = date('Y-m-d'); // Get today's date as a string

                $mindate= "01-01-2022";
                $maxdate=$today;
            ?>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        
                        <!-- Card Section 2 End -->
                        <div class="row">
                            <div class="col-12">

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
                                                        Quotation Received
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
                                                        <div class="page-title-box pb-2 px-2">
                                                            <h4 class="mb-sm-0 font-size-18">Quotation Received</h4>
                                                            <p class="fontSize12">Review customer request, customize the package and prepare the best quotation.</p>
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
                                                                        <p class="mb-1 text-end">&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                                        <p class="mb-1 text-end">&#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                                                        <p class="mb-1 text-end">FREE</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-3 pb-0">
                                                                <p class="mb-2 fw-bold blueDiv">Price Based on Travelers</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="mb-1">Adult: <span class="" id="totalAdultCount"><?= $requestData['adult_count'] ?></span> x &#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                                        <p class="mb-1">Children: <span class="" id="totalChildrenCount"><?= $requestData['child_count'] ?></span> x &#8377; <?= number_format($childDisplayPrice, 2) ?></p>
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
                                                                    <p class="fontSize13 fs-5 fw-bold textDarkBlue mb-0" id="subTotal">&#8377; <?= number_format($requestData['subtotal'], 2) ?></p>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="p-3">
                                                                <p class="fw-bold">Transport</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="fontSize10" id="selectedVehicleText"><?= $requestData['transport_type'] ?></p>
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
                                                                <div id="couponPassengerContainer0" class="coupon-passenger-container"></div>
                                                            </div>
                                                            <hr class="my-1 border border-2 mx-3">
                                                            <div class="d-flex justify-content-between px-3">
                                                                <p class="fontSize10 discountGreen fw-bold">
                                                                    Discounts (Coupons)
                                                                </p>
                                                                <p class="fontSize10 discountGreen fw-bold text-end"
                                                                id="totalCouponDiscount0">
                                                                    - ₹ 0
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
                                                                <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="totalCouponDiscount0">- ₹ 0</p>
                                                            </div>
                                                            <?php } ?>
                                                            
                                                            <hr class="my-2 border border-2 mx-3">
                                                            <div class="p-3">
                                                                <p class="fw-bold blueDiv">Adjustments</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="mb-1">Extra Mattress (1 x &#8377; <?= $pricing['extra_mattress'] ?>)</p>
                                                                        <p class="mb-1">Convenience Fee </p>
                                                                        <p class="mb-1">GST (<?= $requestData['gst_percentage'] ?>%) </p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-1 text-end" id="#">&#8377; <?= $totalExtraMattresses * $pricing['extra_mattress'] ?></p>
                                                                        <p class="mb-1 text-end" id="#">&#8377; <?= $requestData['convenience_fee'] ?></p>
                                                                        <p class="mb-1 text-end">&#8377; <?= $requestData['gst'] ?></p>
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
                                                                        <p class="fs-5 text-danger fw-bolder text-end" id="finalPackagePrice1">&#8377; <?= number_format($requestData['final_price'], 2) ?></p>
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

                                                                            $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
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
                                                                                <input type="number" class="form-control" id="cancellationPercentage1" name="cancellationPercentage1" placeholder="0" value="<?= $cancel_policy['policy_1']??0 ?>">
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage1_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="cancellationPercentage2" name="cancellationPercentage2" placeholder="0" value="<?= $cancel_policy['policy_2']??0 ?>">
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage2_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="cancellationPercentage3" name="cancellationPercentage3" placeholder="0" value="<?= $cancel_policy['policy_3']??0 ?>">
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage3_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="cancellationPercentage4" name="cancellationPercentage4" placeholder="0" value="<?= $cancel_policy['policy_4']??0 ?>">
                                                                                <span class="input-group-text">%</span>
                                                                                <small class="error-message" id="cancellationPercentage4_error"></small>
                                                                            </div>
                                                                            <div class="input-group inputWidth">
                                                                                <input type="number" class="form-control" id="cancellationPercentage5" name="cancellationPercentage5" placeholder="0" value="<?= $cancel_policy['policy_5']??0 ?>">
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
                                    <?php include 'prepare_quote_accordian.php' ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "../footer.php" ?>
            </div>
        </div>
        <!-- =========================================================
            MODIFY ROOMS MODAL
        ========================================================= -->
        <div class="modal fade" id="modifyRoomsModal" tabindex="-1" aria-labelledby="modifyRoomsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modifyRoomsModalLabel">Modify Rooms</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 ms-4">
                            <!-- Adults -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Adults(12+ yrs): <span id="totalAdults">1</span>
                                </label>
                            </div>

                            <!-- Children -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Children (2-11 yrs): <span id="totalChildren">0</span>
                                </label>
                            </div>

                            <!-- Infants -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Infants: <span id="totalInfants">0</span>
                                </label>
                            </div>

                        </div>
                        <div id="modifyRoomsContainer">
                            <!-- ROOM 1 -->
                            <div class="modify-room-card mb-3" data-room="1">
                                <div class="room-content-row">
                                    <!-- ROOM TITLE -->
                                    <div class="room-title">
                                        <p class="fontSize10 fw-bold mb-0">
                                            Room 1
                                        </p>
                                    </div>

                                    <!-- ROOM OCCUPANCY -->
                                    <div class="occupancy-section">

                                        <label class="fontSize10 fw-bold mb-0">
                                            Room Occupancy
                                        </label>

                                        <div class="occupancy-control">

                                            <button type="button"
                                                    class="occupancy-minus">
                                                -
                                            </button>

                                            <input type="text"
                                                class="form-control text-center room-occupancy"
                                                value="3"
                                                readonly>

                                            <button type="button"
                                                    class="occupancy-plus">
                                                +
                                            </button>

                                        </div>

                                    </div>

                                    <!-- EXTRA MATTRESS -->
                                    <div class="mattress-section">

                                        <div class="form-check mb-0">

                                            <input class="form-check-input extra-mattress"
                                                type="checkbox"
                                                id="extraMattress1"
                                                checked >

                                            <label class="form-check-label fontSize10"
                                                for="extraMattress1">
                                                With Extra Mattress
                                            </label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- Add Room -->
                        <div class="text-center">
                            <button type="button" class="btn addModifyRoom" id="addModifyRoom">
                                <i class="ri-add-line me-1"></i>
                                Add Room
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-secondary" id="resetRoomModification">
                            <i class="fa-solid fa-rotate-left me-1"></i>
                            Reset
                        </button>
                        <button type="button" class="btn btn-primary" id="applyRoomModification">Apply Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- vehicle modal -->
        <div class="modal fade"
            id="vehicleSelectionModal"
            tabindex="-1"
            aria-labelledby="vehicleSelectionModalLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title fw-bold"
                            id="vehicleSelectionModalLabel">
                            Select Vehicle
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="row g-3">

                            <?php foreach ($vehicleOptions as $vehicle): ?>

                                <div class="col-md-6 col-lg-4">

                                    <div class="vehicle-option border rounded-3 p-3 h-100"
                                        data-value="<?= $vehicle['value'] ?>"
                                        data-name="<?= htmlspecialchars($vehicle['name'] . ' - ' . $vehicle['type']) ?>">

                                        <div class="d-flex align-items-center">

                                            <i class="<?= htmlspecialchars($vehicle['icon']) ?> fs-3 me-3"></i>

                                            <div>

                                                <p class="fontSize10 fw-bold mb-1">
                                                    <?= htmlspecialchars($vehicle['name']) ?>
                                                </p>

                                                <p class="fontSize10 mb-0">
                                                    <?= htmlspecialchars($vehicle['type']) ?>
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button"
                                class="btn btn-primary"
                                id="applyVehicleSelection">
                            Select Vehicle
                        </button>

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
        <!-- Calendar init -->
        <script src="../assets/libs/fullcalendar/index.global.min.js"></script>

        <!-- Date Range Picker Script Start -->
        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Date Range Picker Script End -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
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

            // Price values from PHP
            const perAdultPrice = <?= json_encode((float)($adultDisplayPrice ?? 0)) ?>;
            const perChildPrice = <?= json_encode((float)($childDisplayPrice ?? 0)) ?>;

            // Tour information
            const tourDays = <?= json_encode((int)($tour_days_total ?? 0)) ?>;

            // Coupon counts
            const totalPrimaryCoupons = <?= json_encode(count($cuCoupons ?? [])) ?>;
            const totalLoyaltyCoupons = <?= json_encode(count($loyaltyCoupons ?? [])) ?>;

            // User information
            const userId = <?= json_encode($user_id ?? null) ?>;
            const userTypeIdValue = <?= json_encode($user_type_id_value ?? null) ?>;

            // GST
            const gstPercentage = <?= json_encode((float)($gst['gst'] ?? 0)) ?>;
            // validity
            const packValidity = <?= json_encode($validity) ?>;
            // Original room data saved in PHP.
            const originalPhpRooms = <?= json_encode(
                $rooms,
                JSON_HEX_TAG |
                JSON_HEX_APOS |
                JSON_HEX_QUOT |
                JSON_HEX_AMP
            ) ?>;
            // Prevent mouse wheel from changing number inputs
            $(document).on("wheel", 'input[type="number"]', function (e) {
                if ($(this).is(":focus")) {
                    e.preventDefault();
                    $(this).blur();
                }
            });
            $.ajax({
                url: "../packages/forms/get_institution_slab.php",
                type: "GET",
                dataType: "json",
                success: function (response) {

                    let html = "";

                    if (response.length > 0) {

                        response.forEach(function (row) {

                            html += `
                                <tr>
                                    <td>${Number(row.lower_limit).toLocaleString("en-IN")} - ${Number(row.upper_limit).toLocaleString("en-IN")}</td>
                                    <td class="text-start">${Number(row.institution_commission).toLocaleString("en-IN")}</td>
                                </tr>
                            `;

                        });

                    } else {

                        html = `
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No records found
                                </td>
                            </tr>
                        `;

                    }

                    $("#commissionTableBody").html(html);

                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        </script>
        <script type="text/javascript" src="../assets/js/requestDetails.js"></script>
        <script>
            const savedCoupons = <?= json_encode(
                json_decode($requestData['coupons'] ?? '[]', true) ?: [],
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
            ) ?>;
            
            //coupon row
            function createCouponRow(type, number) {

                return `
                    <div class="d-flex justify-content-between mb-2 coupon-passenger-row">

                        <div class="d-flex gap-3 largeDisplay">

                            <p class="fontSize10 align-content-end mb-0">
                                ${type} ${number}
                            </p>

                            <p class="mb-0">

                                <select
                                    class="form-select fontSize10 selectPadding coupon-select">

                                    <option value="">
                                        Select Coupon
                                    </option>

                                    <?php if (!empty($cuCoupons)): ?>

                                        <optgroup label="Primary Coupons">

                                            <?php foreach ($cuCoupons as $coupon): ?>

                                                <option
                                                    value="<?= htmlspecialchars($coupon['code']) ?>"
                                                    data-type="primary"
                                                    data-amount="<?= htmlspecialchars($coupon['coupon_amt']) ?>">

                                                    <?= htmlspecialchars($coupon['code']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </optgroup>

                                    <?php endif; ?>


                                    <?php if (!empty($loyaltyCoupons)): ?>

                                        <optgroup label="Loyalty Coupons">

                                            <?php foreach ($loyaltyCoupons as $coupon): ?>

                                                <option
                                                    value="<?= htmlspecialchars($coupon['code']) ?>"
                                                    data-type="loyalty"
                                                    data-amount="<?= htmlspecialchars($coupon['coupon_amt']) ?>">

                                                    <?= htmlspecialchars($coupon['code']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </optgroup>

                                    <?php endif; ?>

                                </select>

                            </p>

                        </div>


                        <p class="fontSize10 discountGreen fw-bold text-end align-content-end coupon-discount mb-0">
                            - ₹ 0
                        </p>

                    </div>
                `;
            }
            $(document).ready(function () {

                loadSavedCoupons();

                $(".sticky-nav-wrapper").each(function () {

                    const $wrapper = $(this);
                    const $nav = $wrapper.find(".borderColor1").first();
                    const $placeholder = $wrapper.next(".nav-placeholder");
                    const $content = $placeholder.next(".content-sections");

                    if (!$nav.length || !$placeholder.length || !$content.length) {
                        return;
                    }

                    let navTop = 0;

                    function updateStickyNav() {

                        if ($(window).width() < 992) {
                            $nav.removeClass("nav-fixed").css({
                                width: ""
                            });

                            $placeholder.hide().height(0);
                            return;
                        }

                        const headerHeight = $(".sticky-bar").outerHeight() || 90;

                        const contentTop = $content.offset().top;
                        const contentBottom = contentTop + $content.outerHeight();

                        const scrollTop = $(window).scrollTop();
                        const navHeight = $nav.outerHeight();

                        if (
                            scrollTop >= navTop - headerHeight &&
                            scrollTop <= contentBottom - navHeight - headerHeight
                        ) {

                            $placeholder.height(navHeight).show();

                            $nav.addClass("nav-fixed").css({
                                width: $wrapper.outerWidth() + "px"
                            });

                        } else {

                            $placeholder.hide().height(0);

                            $nav.removeClass("nav-fixed").css({
                                width: ""
                            });
                        }
                    }

                    function refreshNavPosition() {
                        if (!$nav.hasClass("nav-fixed")) {
                            navTop = $wrapper.offset().top;
                        }

                        updateStickyNav();
                    }

                    $(window).on("scroll resize", function () {
                        refreshNavPosition();

                        if (typeof updateActiveNav === "function") {
                            updateActiveNav();
                        }
                    });

                    $(window).on("load", refreshNavPosition);

                    refreshNavPosition();

                });

            });

            function updateActiveNav() {

                const scrollPos = $(window).scrollTop() + 200;

                $(".section-block").each(function () {

                    const id = $(this).attr("id");

                    const top = $(this).offset().top;
                    const bottom = top + $(this).outerHeight();

                    if (scrollPos >= top && scrollPos < bottom) {

                        $(".nav-link").removeClass("active");

                        $('.nav-link[href="#' + id + '"]')
                            .addClass("active");
                    }
                });
            }

            $(".nav-link").on("click", function (e) {

                e.preventDefault();

                const target = $(this).attr("href");

                const headerHeight = $(".sticky-bar").outerHeight() || 90;

                $("html, body").animate({

                    scrollTop: $(target).offset().top - headerHeight - 70

                }, 500);
            });

            
            // function loadSavedCoupons() {
            //     const container = $('#couponPassengerContainer');
            //     container.empty();

            //     savedCoupons.forEach(function (coupon) {
            //         const passenger = coupon.passenger || '';
            //         const couponCode = coupon.code || '';
            //         const couponType = coupon.type || '';
            //         const amount = Number(coupon.amount) || 0;

            //         const row = $(`
            //             <div class="d-flex justify-content-between mb-2 coupon-passenger-row">
            //                 <div class="d-flex gap-3 largeDisplay">
            //                     <p class="fontSize10 align-content-end mb-0 coupon-passenger"></p>
            //                     <p class="mb-0">
            //                         <select class="form-select fontSize10 selectPadding coupon-select" disabled>
            //                             <option value="">Select Coupon</option>
            //                         </select>
            //                     </p>
            //                 </div>
            //                 <p class="fontSize10 discountGreen fw-bold text-end align-content-end coupon-discount mb-0">
            //                     - ₹ 0
            //                 </p>
            //             </div>
            //         `);

            //         row.find('.coupon-passenger').text(passenger);

            //         const select = row.find('.coupon-select');
                    
            //         // Add available primary coupons.
            //         <?php if (!empty($cuCoupons)): ?>
            //             const primaryGroup = $('<optgroup label="Primary Coupons"></optgroup>');

            //             <?php foreach ($cuCoupons as $coupon): ?>
            //                 primaryGroup.append(
            //                     $('<option></option>')
            //                         .val(<?= json_encode($coupon['code']) ?>)
            //                         .attr('data-type', 'primary')
            //                         .attr('data-amount', <?= json_encode($coupon['coupon_amt']) ?>)
            //                         .text(<?= json_encode($coupon['code']) ?>)
            //                 );
            //             <?php endforeach; ?>

            //             select.append(primaryGroup);
            //         <?php endif; ?>

            //         // Add available loyalty coupons.
            //         <?php if (!empty($loyaltyCoupons)): ?>
            //             const loyaltyGroup = $('<optgroup label="Loyalty Coupons"></optgroup>');

            //             <?php foreach ($loyaltyCoupons as $coupon): ?>
            //                 loyaltyGroup.append(
            //                     $('<option></option>')
            //                         .val(<?= json_encode($coupon['code']) ?>)
            //                         .attr('data-type', 'loyalty')
            //                         .attr('data-amount', <?= json_encode($coupon['coupon_amt']) ?>)
            //                         .text(<?= json_encode($coupon['code']) ?>)
            //                 );
            //             <?php endforeach; ?>

            //             select.append(loyaltyGroup);
            //         <?php endif; ?>

            //         // Restore the saved coupon selection.
            //         select.val(couponCode);

            //         // Show the saved discount amount.
            //         row.find('.coupon-discount').text(
            //             '- ₹ ' + amount.toLocaleString('en-IN')
            //         );

            //         container.append(row);
            //     });
            //     updateTotalCouponDiscountApplied();
            // }
            function loadSavedCoupons() {
                if (!Array.isArray(savedCoupons)) {
                    return;
                }

                // ==========================================
                // CONTAINER 0: DISPLAY ALL SAVED COUPONS
                // IN NON-EDITABLE MODE
                // ==========================================
                const container0 = $('#couponPassengerContainer0');

                if (container0.length) {
                    let display = container0.find('.saved-coupon-display').first();

                    if (!display.length) {
                        display = $('<div class="saved-coupon-display"></div>');
                        container0.prepend(display);
                    }

                    // Clear only the saved-coupon display area.
                    display.empty();

                    savedCoupons.forEach(function (coupon) {
                        const couponCode = String(coupon.code || '').trim();

                        if (!couponCode) {
                            return;
                        }

                        const passenger = coupon.passenger || '';
                        const amount = Number(coupon.amount) || 0;

                        const row = $(`
                            <div class="d-flex justify-content-between mb-2 saved-coupon-row">
                                <div class="d-flex gap-3 largeDisplay">
                                    <p class="fontSize10 align-content-end mb-0 saved-coupon-passenger"></p>
                                    <p class="mb-0">
                                        <select class="form-select fontSize10 selectPadding" disabled>
                                            <option></option>
                                        </select>
                                    </p>
                                </div>
                                <p class="fontSize10 discountGreen fw-bold text-end align-content-end mb-0 saved-coupon-discount"></p>
                            </div>
                        `);

                        row.attr('data-coupon-code', couponCode);

                        row.find('.saved-coupon-passenger').text(passenger);

                        const select = row.find('select');
                        select.find('option')
                            .first()
                            .val(couponCode)
                            .text(couponCode);

                        select.val(couponCode);

                        row.find('.saved-coupon-discount').text(
                            '- ₹ ' + amount.toLocaleString('en-IN')
                        );

                        display.append(row);
                    });
                }

                // ==========================================
                // CONTAINERS 1, 2, 3, ETC.:
                // POPULATE EXISTING EDITABLE ROWS
                // ==========================================
                savedCoupons.forEach(function (coupon, index) {
                    const couponCode = String(coupon.code || '').trim();

                    if (!couponCode) {
                        return;
                    }

                    const passenger = coupon.passenger || '';
                    const amount = Number(coupon.amount) || 0;

                    // Use the existing editable container.
                    const container = $('#couponPassengerContainer' + (index + 1));

                    // If a passenger-specific container does not exist,
                    // use container 1 so the coupon is not skipped.
                    const targetContainer = container.length
                        ? container
                        : $('#couponPassengerContainer1');

                    if (!targetContainer.length) {
                        return;
                    }

                    let row = targetContainer.find('.coupon-passenger-row').filter(function () {
                        return $(this).attr('data-coupon-code') === couponCode;
                    }).first();

                    // Create the row only if it does not already exist.
                    if (!row.length) {
                        row = $(`
                            <div class="d-flex justify-content-between mb-2 coupon-passenger-row">
                                <div class="d-flex gap-3 largeDisplay">
                                    <p class="fontSize10 align-content-end mb-0 coupon-passenger"></p>
                                    <p class="mb-0">
                                        <select class="form-select fontSize10 selectPadding coupon-select">
                                            <option value="">Select Coupon</option>
                                        </select>
                                    </p>
                                </div>
                                <p class="fontSize10 discountGreen fw-bold text-end align-content-end mb-0 coupon-discount">
                                    - ₹ 0
                                </p>
                            </div>
                        `);

                        row.attr('data-coupon-code', couponCode);
                        targetContainer.append(row);
                    }

                    row.find('.coupon-passenger').text(passenger);

                    const select = row.find('.coupon-select');

                    let option = select.find('option').filter(function () {
                        return String($(this).val()).trim() === couponCode;
                    }).first();

                    if (!option.length) {
                        option = $('<option>', {
                            value: couponCode,
                            text: couponCode
                        });

                        select.append(option);
                    }

                    option.attr('data-amount', amount);

                    select.prop('disabled', true);
                    select.val(couponCode);

                    row.find('.coupon-discount').text(
                        '- ₹ ' + amount.toLocaleString('en-IN')
                    );
                });

                // Update totals for all existing coupon containers.
                $('[id^="couponPassengerContainer"]').each(function () {
                    const containerId = this.id;
                    const index = containerId.replace('couponPassengerContainer', '');

                    updateTotalCouponDiscountApplied(index);
                });
            }

            function updateTotalCouponDiscountApplied(index) {
                const container = $('#couponPassengerContainer' + index);

                if (!container.length) {
                    return;
                }

                let totalCouponDiscount = 0;
                let totalCoupons = 0;

                // Count saved coupons only for container 0.
                if (String(index) === '0') {
                    container.find('.saved-coupon-row').each(function () {
                        const discountText = $(this).find('.saved-coupon-discount').text();

                        const amount = parseFloat(
                            discountText.replace(/[^0-9.-]/g, '')
                        ) || 0;

                        totalCouponDiscount += Math.abs(amount);
                        totalCoupons++;
                    });
                }

                // Count selected editable coupons in this container only.
                container.find('.coupon-passenger-row').each(function () {
                    const select = $(this).find('.coupon-select');
                    const couponCode = select.val();

                    if (couponCode) {
                        const amount = parseFloat(
                            select.find('option:selected').attr('data-amount')
                        ) || 0;

                        totalCouponDiscount += amount;
                        totalCoupons++;
                    }
                });

                // Update the total corresponding to this container's index.
                $('#totalCouponDiscount' + index).text(
                    '- ₹ ' + totalCouponDiscount.toLocaleString('en-IN') 
                );
            }
        </script>
        <script>
            
            const dropZone = document.getElementById("dropZone");
            const fileInput = document.getElementById("fileInput");
            const selectedFileText = document.getElementById("selectedFileText");
            const addDocumentBtn = document.getElementById("addDocumentBtn");
            const documentTitle = document.getElementById("documentTitle");
            const otherPolicyList = document.getElementById("otherPolicyList");
            const otherPolicyError = document.getElementById("otherPolicy_error");

            let selectedFile = null;

            window.attachments = window.attachments || [];
            window.deletedDocuments = window.deletedDocuments || [];

            // Load existing documents into the JavaScript tracking array.
            <?php if (!empty($policies) && is_array($policies)): ?>
                <?php foreach ($policies as $doc): ?>
                    window.attachments.push({
                        id: <?= (int)($doc['id'] ?? 0) ?>,
                        title: <?= json_encode($doc['title'] ?? '') ?>,
                        file: null,
                        file_name: <?= json_encode($doc['file_name'] ?? '') ?>,
                        existing: true
                    });
                <?php endforeach; ?>
            <?php endif; ?>

            function showPolicyError(message) {
                otherPolicyError.textContent = message;
            }

            function clearPolicyError() {
                otherPolicyError.textContent = "";
            }

            function getFileIcon(fileName) {
                const ext = fileName.split(".").pop().toLowerCase();

                switch (ext) {
                    case "pdf":
                        return "https://cdn-icons-png.flaticon.com/512/337/337946.png";

                    case "doc":
                    case "docx":
                        return "https://cdn-icons-png.flaticon.com/512/281/281760.png";

                    default:
                        return "https://cdn-icons-png.flaticon.com/512/833/833524.png";
                }
            }

            function escapeHtml(value) {
                return String(value).replace(/[&<>"']/g, function (char) {
                    return {
                        "&": "&amp;",
                        "<": "&lt;",
                        ">": "&gt;",
                        '"': "&quot;",
                        "'": "&#039;"
                    }[char];
                });
            }

            function updateEmptyPolicyMessage() {
                const hasDocuments = otherPolicyList.querySelector(".policyItem");

                const emptyMessage = document.getElementById("noOtherPolicy");

                if (!hasDocuments && !emptyMessage) {
                    otherPolicyList.insertAdjacentHTML(
                        "beforeend",
                        '<p class="text-muted mb-0" id="noOtherPolicy">' +
                        'No other policy documents available.</p>'
                    );
                } else if (hasDocuments && emptyMessage) {
                    emptyMessage.remove();
                }
            }

            function renderNewDocument(item) {
                const row = document.createElement("div");
                row.className = "policyItem";
                row.dataset.id = item.id;
                row.dataset.existing = "0";

                const safeTitle = escapeHtml(item.title);
                const safeFileName = escapeHtml(item.file.name);
                const icon = getFileIcon(item.file.name);

                row.innerHTML = `
                    <div class="d-flex align-items-center gap-3">
                        <div class="highlightIcon" style="background-color: #b2e0b1;">
                            <i class="ri-file-pdf-line text-success"></i>
                        </div>

                        <div>
                            <p class="mb-0 fw-semibold">${safeTitle}</p>
                            <small class="text-muted">${safeFileName}</small>
                            <small class="text-primary d-block">Pending upload</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <img src="${icon}" width="28" alt="File type">

                        <button
                            type="button"
                            class="btn btn-link text-danger p-1 remove-file"
                            data-id="${item.id}"
                            title="Remove document">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                `;

                otherPolicyList.appendChild(row);
            }

            // Open file picker.
            dropZone.addEventListener("click", function () {
                fileInput.click();
            });

            // File picker selection.
            fileInput.addEventListener("change", function () {
                selectedFile = this.files[0] || null;

                selectedFileText.textContent = selectedFile
                    ? selectedFile.name
                    : "Drag & Drop or Click to Upload";

                clearPolicyError();
            });

            // Drag over.
            dropZone.addEventListener("dragover", function (event) {
                event.preventDefault();
                dropZone.classList.add("dragover");
            });

            // Drag leave.
            dropZone.addEventListener("dragleave", function () {
                dropZone.classList.remove("dragover");
            });

            // Drop file.
            dropZone.addEventListener("drop", function (event) {
                event.preventDefault();
                dropZone.classList.remove("dragover");

                selectedFile = event.dataTransfer.files[0] || null;

                if (selectedFile) {
                    selectedFileText.textContent = selectedFile.name;

                    // Copy dropped file into the file input so FormData can submit it.
                    const transfer = new DataTransfer();
                    transfer.items.add(selectedFile);
                    fileInput.files = transfer.files;
                }

                clearPolicyError();
            });

            // Add document to the UI and tracking array.
            addDocumentBtn.addEventListener("click", function () {
                const title = documentTitle.value.trim();

                if (!title) {
                    showPolicyError("Please enter document title.");
                    documentTitle.focus();
                    return;
                }

                if (!selectedFile) {
                    showPolicyError("Please select a file.");
                    return;
                }

                const extension = selectedFile.name.split(".").pop().toLowerCase();

                const rowId = Date.now() + Math.floor(Math.random() * 1000);

                const fileExtension = extension;
                
                const item = {
                    id: rowId,
                    title: title,
                    file: selectedFile,
                    existing: false
                };

                window.attachments.push(item);


                const emptyMessage = document.getElementById("noOtherPolicy");
                if (emptyMessage) {
                    emptyMessage.remove();
                }

                renderNewDocument(item);

                documentTitle.value = "";
                fileInput.value = "";
                selectedFile = null;
                selectedFileText.textContent = "Drag & Drop or Click to Upload";

                clearPolicyError();
            });

            // Remove documents using event delegation.
            $(document).on("click", "#otherPolicyList .remove-file", function () {
                const row = $(this).closest(".policyItem");
                const id = Number(row.attr("data-id"));
                const isExisting = row.attr("data-existing") === "1";

                if (isExisting && !window.deletedDocuments.includes(id)) {
                    window.deletedDocuments.push(id);
                }

                window.attachments = window.attachments.filter(function (item) {
                    return Number(item.id) !== id;
                });

                row.remove();
                updateEmptyPolicyMessage();
            });
            $(document).ready(function () {

                // =====================================================
                // ORIGINAL PHP VALUES
                // =====================================================
                const originalSubtotal = <?= json_encode(
                    (float) ($requestData['subtotal'] ?? 0)
                ) ?>;

                const adultCount = <?= json_encode(
                    (int) ($requestData['adult_count'] ?? 0)
                ) ?>;

                const childCount = <?= json_encode(
                    (int) ($requestData['child_count'] ?? 0)
                ) ?>;


                // =====================================================
                // INPUT LABELS
                // =====================================================

                const inputLabels = {
                    couponAdjustment: 'Coupon Adjustment',
                    companyAmount: 'Company',
                    suspenseAmount: 'Suspense',
                    customer1Amount: 'L1 Customer',
                    customer2Amount: 'L2 Customer',
                    customer3Amount: 'L3 Customer',
                    netPriceAdult: 'Net Price - Adult',
                    netPriceChild: 'Net Price - Child'
                };


                // =====================================================
                // ORIGINAL VALUES FROM PHP-RENDERED INPUTS
                // =====================================================

                function getOriginalValue(input) {

                    // defaultValue contains the original value rendered by PHP.
                    // It does not change when the user edits the field.

                    return parseFloat(input.defaultValue) || 0;
                }


                // =====================================================
                // FORMAT CURRENCY
                // =====================================================

                function formatAmount(amount) {

                    return '₹ ' + Math.abs(amount).toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                }


                // =====================================================
                // CHECK VALID USER ID FOR PRICING TABLE INPUTS
                // =====================================================

                function isValidPricingUser(input) {

                    const userId = $(input)
                        .closest('tr')
                        .find('td')
                        .eq(2)
                        .text()
                        .trim();

                    return (
                        userId !== '' &&
                        userId.toUpperCase() !== 'NA' &&
                        userId !== '-'
                    );

                }


                // =====================================================
                // GET PRICING TABLE INPUT LABEL
                // =====================================================

                function getPricingTableLabel(input) {

                    const $input = $(input);
                    const $row = $input.closest('tr');

                    const designation = $row.find('td').eq(0).text().trim();

                    const columnIndex = $input.closest('td').index();

                    const fieldType = columnIndex === 4
                        ? 'Incentive'
                        : 'Commission';

                    return designation + ' - ' + fieldType;

                }


                // =====================================================
                // GET ALL PRICING CHANGES
                // =====================================================

                function collectPricingChanges() {
                    const discounts = [];
                    const increases = [];

                    let totalDiscount = 0;
                    let totalIncrease = 0;

                    // -------------------------------------------------
                    // A. PRICING TABLE INPUTS
                    // -------------------------------------------------

                    $('.pricing-markup-input').each(function () {

                        const input = this;

                        // Ignore invalid IDs
                        if (!isValidPricingUser(input)) {
                            return;
                        }

                        const originalValue = getOriginalValue(input);
                        const currentValue = parseFloat(input.value) || 0;

                        const difference = currentValue - originalValue;

                        const label = getPricingTableLabel(input);

                        // Decrease = Discount
                        if (difference < -0.005) {

                            const amount = Math.abs(difference);

                            discounts.push({
                                label: label,
                                amount: amount
                            });

                            totalDiscount += amount;

                        }

                        // Increase = Additional Price
                        else if (difference > 0.005) {

                            increases.push({
                                label: label,
                                amount: difference
                            });

                            totalIncrease += difference;

                        }

                        // Unchanged = Do nothing

                    });


                    // -------------------------------------------------
                    // B. REMAINING PRICING INPUTS
                    // -------------------------------------------------

                    const remainingSelectors = [
                        '#couponAdjustment',
                        '#companyAmount',
                        '#suspenseAmount',
                        '#customer1Amount',
                        '#customer2Amount',
                        '#customer3Amount',
                        '#netPriceAdult',
                        '#netPriceChild'
                    ];

                    $(remainingSelectors.join(', ')).each(function () {

                        const input = this;

                        const inputId = input.id;

                        const originalValue = getOriginalValue(input);
                        const currentValue = parseFloat(input.value) || 0;

                        const difference = currentValue - originalValue;

                        const label = inputLabels[inputId] || input.name;

                        let adjustmentAmount = difference;

                        // Adult and child prices are per person
                        if (inputId === 'netPriceAdult') {

                            adjustmentAmount = difference * adultCount;

                        } else if (inputId === 'netPriceChild') {

                            adjustmentAmount = difference * childCount;

                        }

                        // Decrease = Discount
                        if (adjustmentAmount < -0.005) {

                            const amount = Math.abs(adjustmentAmount);

                            discounts.push({
                                label: label,
                                amount: amount
                            });

                            totalDiscount += amount;

                        }

                        // Increase = Additional Price
                        else if (adjustmentAmount > 0.005) {

                            increases.push({
                                label: label,
                                amount: adjustmentAmount
                            });

                            totalIncrease += adjustmentAmount;

                        }

                        // Unchanged = Do nothing

                    });


                    return {
                        discounts: discounts,
                        increases: increases,
                        totalDiscount: totalDiscount,
                        totalIncrease: totalIncrease
                    };

                }


                // =====================================================
                // RENDER DISCOUNTS AND ADDITIONAL PRICES
                // =====================================================

                function renderPricingChanges() {

                    const changes = collectPricingChanges();
                    // Update Adult and Child reference price differences
                    updateReferencePriceDifference('netPriceAdult');
                    updateReferencePriceDifference('netPriceChild');
                    const $discountContainer = $('#discountedAdjustmentRows');
                    const $additionalContainer = $('#additionalAdjustmentRows');

                    $discountContainer.empty();
                    $additionalContainer.empty();


                    // -------------------------------------------------
                    // A. DISPLAY DISCOUNTS
                    // -------------------------------------------------

                    changes.discounts.forEach(function (item) {

                        const $row = $('<div>', {
                            class: 'd-flex justify-content-between align-items-center w-100 mb-1'
                        });

                        const $label = $('<p>', {
                            class: 'mb-0 text-success'
                        }).text(item.label + ' (Discount)');

                        const $amount = $('<p>', {
                            class: 'mb-0 text-end text-success'
                        }).text('- ' + formatAmount(item.amount));

                        $row.append($label, $amount);
                        $discountContainer.append($row);

                    });


                    // -------------------------------------------------
                    // B. DISPLAY ADDITIONAL PRICES
                    // -------------------------------------------------

                    changes.increases.forEach(function (item) {

                        const $row = $('<div>', {
                            class: 'd-flex justify-content-between align-items-center w-100 mb-1'
                        });

                        const $label = $('<p>', {
                            class: 'mb-0 text-danger'
                        }).text(item.label + ' (Additional)');

                        const $amount = $('<p>', {
                            class: 'mb-0 text-end text-danger'
                        }).text('+ ' + formatAmount(item.amount));

                        $row.append($label, $amount);
                        $additionalContainer.append($row);

                    });


                    // -------------------------------------------------
                    // C. UPDATE SUBTOTALS
                    // -------------------------------------------------
                    // ==========================================
                    // CUSTOMER APPLIED DISCOUNTS
                    // ==========================================
                    const totalCustomerDiscount = updateCustomerDiscountedSubtotal();

                    // ==========================================
                    // MARKUP DISCOUNTS AND ADDITIONS
                    // ==========================================
                    const discountedSubtotal = changes.totalDiscount;
                    const additionalSubtotal = changes.totalIncrease;

                    $('#discountedPriceDetails #discountedSubTotal')
                        .text(formatAmount(discountedSubtotal));

                    $('#additionalPriceDetails #additionalSubTotal')
                        .text(formatAmount(additionalSubtotal));

                    // -------------------------------------------------
                    // D. LOG RESULTS
                    // -------------------------------------------------

                    // console.log('Discounts:', changes.discounts);
                    // console.log('Additional Prices:', changes.increases);

                    // console.log('Total Discount:', changes.totalDiscount);
                    // console.log('Total Increase:', changes.totalIncrease);

                    // console.log(
                    //     'Final Subtotal:',
                    //     originalSubtotal -
                    //     changes.totalDiscount +
                    //     changes.totalIncrease
                    // );
                    // -------------------------------------------------
                    // E. UPDATE FINAL QUOTED PRICE
                    // -------------------------------------------------

                    // ==========================================
                    // FINAL QUOTED PRICE
                    // ==========================================

                    // Start with the sum of the currently entered pricing values.
                    // Subtract all discounts and add all increases.
                    const finalPrice =
                            originalSubtotal
                            - totalCustomerDiscount
                            - changes.totalDiscount
                            + changes.totalIncrease;

                    // If you have a separate base package price calculated from
                    // the pricing input fields, add it here.

                    const netAdjustment = changes.totalIncrease - changes.totalDiscount;

                    let adjustmentLabel = '';
                    let adjustmentClass = '';

                    const isSameAdjustment =
                        Math.abs(changes.totalDiscount - changes.totalIncrease) < 0.005;

                    if (isSameAdjustment) {

                        if (
                            changes.totalDiscount < 0.005 &&
                            changes.totalIncrease < 0.005
                        ) {
                            adjustmentLabel = 'No Adjustments';
                        } else {
                            adjustmentLabel = 'No Net Price Change';
                        }

                        adjustmentClass = 'text-dark';

                    } else if (netAdjustment < 0) {

                        adjustmentLabel = 'Discounted Amount';
                        adjustmentClass = 'text-success';

                    } else {

                        adjustmentLabel = 'Additional Amount';
                        adjustmentClass = 'text-danger';
                    }

                    // Update label
                    $('#netPriceAdjustmentLabel')
                        .text(adjustmentLabel)
                        .removeClass('text-success text-danger text-dark')
                        .addClass(adjustmentClass);

                    // Update adjustment amount
                    $('#netPriceAdjustment')
                        .text(
                            (netAdjustment > 0.005 ? '+ ' : netAdjustment < -0.005 ? '- ' : '') +
                            formatAmount(Math.abs(netAdjustment))
                        )
                        .removeClass('text-success text-danger text-dark')
                        .addClass(adjustmentClass);

                    // Update final quoted price
                    $('#finalQuotedPrice').text(formatAmount(finalPrice));

                    // -------------------------------------------------
                    // F. UPDATE TOTAL ESTIMATED PRICE
                    // -------------------------------------------------

                    // Convenience Fee = 1% of Final Quoted Price
                    const convenienceFee = finalPrice * 0.01;

                    // GST percentage from PHP
                    const gstPercentage = <?= json_encode((float)($requestData['gst_percentage'] ?? 0)) ?>;

                    // GST calculation (1%? Use the actual GST percentage)
                    const gstAmount = finalPrice * (gstPercentage / 100);

                    // Total Estimated Price
                    const totalEstimatedPrice = finalPrice + convenienceFee + gstAmount;

                    // Update Convenience Fee
                    $('#convenienceFee').text(formatAmount(convenienceFee));

                    // Update GST
                    $('#gstAmount').text(formatAmount(gstAmount));

                    // Update Total Estimated Price
                    $('#estimatedFinalPackagePrice').text(formatAmount(totalEstimatedPrice));

                    // console.log('Final Quoted Price:', finalPrice);
                    // console.log('Convenience Fee (1%):', convenienceFee);
                    // console.log('GST:', gstAmount);
                    // console.log('Total Estimated Price:', totalEstimatedPrice);

                }
                // =====================================================
                // ORIGINAL PRICE AND PRICE DIFFERENCE
                // =====================================================

                function updateReferencePriceDifference(inputId) {

                    const $input = $('#' + inputId);

                    if (!$input.length) {
                        console.warn('Input not found:', inputId);
                        return;
                    }

                    const originalPrice = getOriginalValue($input[0]);
                    const currentPrice = parseFloat($input.val()) || 0;

                    // Show per-person price difference, irrespective of traveller count
                    const difference = currentPrice - originalPrice;

                    const $originalText = $('#' + inputId + '_original');
                    const $differenceText = $('#' + inputId + '_difference');

                    $originalText.text(
                        'Original Price: ' + formatAmount(originalPrice)
                    );

                    if (!$differenceText.length) {
                        console.warn('Difference display element not found:', inputId + '_difference');
                        return;
                    }

                    if (Math.abs(difference) < 0.005) {

                        $differenceText
                            .removeClass('text-success text-danger')
                            .addClass('text-muted')
                            .text('No Price Change');

                    } else if (difference < 0) {

                        $differenceText
                            .removeClass('text-danger text-muted')
                            .addClass('text-success')
                            .text('Decreased by ' + formatAmount(Math.abs(difference)));

                    } else {

                        $differenceText
                            .removeClass('text-success text-muted')
                            .addClass('text-danger')
                            .text('Increased by ' + formatAmount(difference));
                    }
                }
                // =====================================================
                // UPDATE CUSTOMER APPLIED DISCOUNT SUBTOTAL
                // =====================================================

                function updateCustomerDiscountedSubtotal() {
                    function getDiscountAmount(selector) {
                        const $element = $(selector);

                        if (!$element.length) {
                            return 0;
                        }

                        return parseFloat($element.text().replace(/[^\d.]/g, '')) || 0;
                    }

                    const couponDiscount = getDiscountAmount('#CustCouponDiscount');
                    const referenceWallet = getDiscountAmount('#CustReferenceWallet');
                    const discountWallet = getDiscountAmount('#CustDiscountWallet');

                    const totalCustomerDiscount =
                        couponDiscount + referenceWallet + discountWallet;

                    $('#CustDiscountedPriceSubTotal').text(
                        formatAmount(totalCustomerDiscount)
                    );

                    return totalCustomerDiscount;
                }

                // =====================================================
                // EVENT 1: PRICING TABLE INPUTS
                // =====================================================

                $(document).on(
                    'input change',
                    '.pricing-markup-input',
                    function () {

                        if (!isValidPricingUser(this)) {
                            console.log('Invalid ID. Skipping calculation.');
                            return;
                        }

                        console.log('Changed table input:', {
                            userId: $(this)
                                .closest('tr')
                                .find('td')
                                .eq(2)
                                .text()
                                .trim(),

                            inputId: this.id,
                            inputName: this.name,
                            originalValue: getOriginalValue(this),
                            changedValue: parseFloat(this.value) || 0
                        });

                        renderPricingChanges();

                    }
                );


                // =====================================================
                // EVENT 2: REMAINING PRICING INPUTS
                // =====================================================

                $(document).on(
                    'input change',
                    '#couponAdjustment, #companyAmount, #suspenseAmount, #customer1Amount, #customer2Amount, #customer3Amount, #netPriceAdult, #netPriceChild',
                    function () {

                        console.log('Changed pricing input:', {
                            inputId: this.id,
                            inputName: this.name,
                            originalValue: getOriginalValue(this),
                            changedValue: parseFloat(this.value) || 0
                        });

                        renderPricingChanges();

                    }
                );


                // =====================================================
                // INITIAL RENDER
                // =====================================================

                renderPricingChanges();
                updateCustomerDiscountedSubtotal();
            });

            $('#submitQuoteBtn').on('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Submit Quote?',
                    text: 'Are you sure you want to submit this quotation to the customer?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Submit',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        
                        // ==========================================
                        // 1. BASIC REQUEST DETAILS
                        // ==========================================

                        const requestId = <?= json_encode($request_id) ?>;
                        const guestUserId = <?= json_encode($requestData['userId'] != 'null' ? $requestData['userId'] : null) ?>;
                        const guestFullName = <?= json_encode($requestData['guestFullName']) ?>;
                        const guestMobile = <?= json_encode($requestData['guestPhone']) ?>;
                        const guestEmail = <?= json_encode($requestData['guestEmail']) ?>;
                        const packageId = <?= json_encode($id) ?>;

                        // ==========================================
                        // 2. TRIP REQUEST
                        // ==========================================

                        const tripRequest = {
                            travel_start_date: $('#exampleFormControlInput11').val(),
                            travel_end_date: $('#exampleFormControlInput21').val(),
                            duration: $('#exampleFormControlInput31').val(),
                            pickup: $('#exampleFormControlInput41').val(),
                            old_pickup: <?= $oldPickup !== '' ? "$('#pickupOldValue1').text()" : "''" ?>,
                            drop: $('#exampleFormControlInput51').val(),
                            old_drop: <?= $olddrop !== '' ? "$('#dropOldValue1').text()" : "''" ?>,
                            adult_count: $('#adultCount1').val(),
                            child_count: $('#childcount1').val(),
                            infant_count: $('#infantCount1').val(),
                            total_count: $('#exampleFormControlInput91').val(),
                            rooms: <?= json_encode($rooms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
                        };

                        // ==========================================
                        // 3. CUSTOMER PREFERENCES
                        // ==========================================

                        const customerPreferences = {
                            hotel: $('#hotelCategory').val(),
                            meal: $('#mealPreference').val(),
                            transport: $('#transportPreference').val(),
                            old_hotel: $('#oldHotelCategory').text(),
                            old_meal: $('#oldMealPreference').text(),
                            old_transport: $('#oldTransportPreference').text(),
                            special_requirement: $('#specialRequirement').text()
                        };

                        // ==========================================
                        // 4. QUICK ACTION / PRICE BREAKDOWN
                        // ==========================================

                        const quickAction = {
                            per_adult_amount: getAmount('#perAdultAmt'),
                            per_child_amount: getAmount('#perChildAmt'),
                            total_adult_count: getAmount('#totalAdultCount'),
                            total_children_count: getAmount('#totalChildrenCount'),
                            total_infant_count: getAmount('#totalInfantCount'),
                            extra_mattress: getAmount('#extraMatress'),
                            adult_total: getAmount('#adultTotal'),
                            children_total: getAmount('#childrenTotal'),
                            extra_mattress_total: getAmount('#extraMatressTotal'),
                            subtotal: getAmount('#subTotal'),
                            selected_vehicle: $('#selectedVehicleText').text()
                        };

                        // ==========================================
                        // 5. COUPONS AND WALLETS
                        // ==========================================

                        let couponWalletDetails = {
                            coupons: [],
                            total_coupon_discount: '',
                            referral_wallet_balance: '',
                            applied_referral_wallet: '',
                            discount_wallet_balance: '',
                            applied_discount_wallet: ''
                        };

                        <?php
                        if (in_array($Requester_type, [
                            'Prime',
                            'Premium',
                            'Premium Plus',
                            'Premium Select',
                            'Premium Select Lite',
                            'Neo Select',
                            'Neo Select Ultra'
                        ], true)) {
                        ?>

                        couponWalletDetails.coupons = savedCoupons;

                        couponWalletDetails.total_coupon_discount = Math.abs(getAmount('#totalCouponDiscount1'));
                        couponWalletDetails.referral_wallet_balance = getAmount('#referralWalletBalance');
                        couponWalletDetails.applied_referral_wallet = getAmount('#appliedReferralWallet');

                        <?php if ($Requester_type === 'Neo Select') { ?>

                        couponWalletDetails.discount_wallet_balance = getAmount('#discountWalletBalance');
                        couponWalletDetails.applied_discount_wallet = getAmount('#appliedDiscountWallet');

                        <?php } ?>

                        <?php } ?>

                        // ==========================================
                        // 6. GST AND CONVENIENCE FEE
                        // ==========================================

                        const priceAdjustments = {
                            gst_percentage: getAmount('#gstPercentage'),
                            convenience_fee: getAmount('#convenienceFee'),
                            gst_amount: getAmount('#gstAmount')
                        };

                        // ==========================================
                        // 7. FINAL PACKAGE PRICE
                        // ==========================================

                        const finalPackageDetails = {
                            final_package_price: getAmount('#finalPackagePrice')
                        };

                        // ==========================================
                        // 8. ITINERARY
                        // ==========================================

                        let itinerary = [];
                        let dayCounter = 1;

                        $('#accordionItinerary .accordion-item').each(function () {

                            const $item = $(this);

                            const fieldName = $item.find('[name*="[day_details]"]').attr('name');

                            if (!fieldName) return;

                            const match = fieldName.match(/itinerary\[(\d+)\]/);

                            if (!match) return;

                            const dayId = match[1];

                            itinerary.push({
                                day_id: 'Day: '+dayCounter++,

                                title: $item.find('.accordion-button')
                                    .text()
                                    .trim()
                                    .replace(/\s+/g, ' ')
                                    .replace(/^Day\s*\d+\s*-\s*/, ''),

                                day_details: $item.find(`[name="itinerary[${dayId}][day_details]"]`).val() || '',
                                day_transport: $item.find(`[name="itinerary[${dayId}][day_tansport]"]`).val() || '',
                                meal_plan: $item.find(`[name="itinerary[${dayId}][meal_plan]"]`).val() || '',
                                stay: $item.find(`[name="itinerary[${dayId}][stay]"]`).val() || ''
                            });

                        });

                        // console.log('Itinerary:', itinerary);

                        // ==========================================
                        // 9. PACKAGE INCLUSIONS AND EXCLUSIONS
                        // ==========================================

                        let packageInclusionExclusion = {
                            inclusion: [],
                            exclusion: []
                        };

                        $('textarea[name="inclusions[]"]').each(function () {
                            const value = $(this).val().trim();

                            if (value !== '') {
                                packageInclusionExclusion.inclusion.push(value);
                            }
                        });

                        $('textarea[name="exclusions[]"]').each(function () {
                            const value = $(this).val().trim();

                            if (value !== '') {
                                packageInclusionExclusion.exclusion.push(value);
                            }
                        });

                        // ==========================================
                        // 10. NEW POLICY DOCUMENTS
                        // ==========================================

                        // ==========================================
                        // 1. COLLECT NEW FILES FOR UPLOAD
                        // ==========================================
                        const newAttachmentItems = (window.attachments || []).filter(item =>
                            item.existing !== true && item.file && item.file.name
                        );

                        // ==========================================
                        // 2. COLLECT EXISTING FILE DETAILS FROM DOM
                        // ==========================================
                        const existingDocuments = [];

                        document.querySelectorAll('.policyItem[data-existing="1"]').forEach(item => {

                            const id = item.dataset.id;
                            const title = item.querySelector('.fw-semibold')?.textContent.trim() || '';
                            const fileName = item.querySelector('.text-muted')?.textContent.trim() || '';

                            // Skip documents marked for deletion
                            if (
                                !id ||
                                !fileName ||
                                (window.deletedDocuments || []).includes(Number(id))
                            ) {
                                return;
                            }

                            existingDocuments.push({
                                id: Number(id),
                                title: title,
                                name: fileName,
                                size: '',
                                type: fileName.split('.').pop().toUpperCase()
                            });

                        });

                        // ==========================================
                        // 3. COLLECT NEW FILE METADATA
                        // ==========================================
                        const newDocuments = newAttachmentItems.map(item => ({
                            title: item.title,
                            name: item.file.name,
                            size: (item.file.size / (1024 * 1024)).toFixed(2) + ' MB',
                            type: item.file.type
                        }));

                        // ==========================================
                        // 11. CANCELLATION CHARGES
                        // ==========================================

                        const cancellationCharges = {
                            percentage_1: $('#cancellationPercentage1').val(),
                            percentage_2: $('#cancellationPercentage2').val(),
                            percentage_3: $('#cancellationPercentage3').val(),
                            percentage_4: $('#cancellationPercentage4').val(),
                            percentage_5: $('#cancellationPercentage5').val()
                        };

                        // ==========================================
                        // 12. COMMISSION AND INCENTIVE DETAILS
                        // ==========================================

                        let commissionIncentive = [];

                        $('.commission-incentive-table tbody tr').each(function () {

                            const columns = $(this).find('> td');

                            const commissionInput = columns.eq(3).find('input');
                            const incentiveInput = columns.eq(4).find('input');

                            commissionIncentive.push({
                                designation: columns.eq(0).text().trim(),
                                name: columns.eq(1).text().trim(),
                                id: columns.eq(2).text().trim(),

                                commission: commissionInput.length
                                    ? (parseFloat(commissionInput.val()) || 0)
                                    : 0,

                                incentive: incentiveInput.length
                                    ? (parseFloat(incentiveInput.val()) || 0)
                                    : 0
                            });

                        });

                        // ==========================================
                        // 13. MARKUP CALCULATION
                        // ==========================================

                        const markupCalculation = {
                            coupon_adjustment: getAmount('#couponAdjustment'),
                            company_amount: getAmount('#companyAmount'),
                            suspense_amount: getAmount('#suspenseAmount'),
                            customer_1_amount: getAmount('#customer1Amount'),
                            customer_2_amount: getAmount('#customer2Amount'),
                            customer_3_amount: getAmount('#customer3Amount'),

                            net_price_adult: getAmount('#netPriceAdult'),
                            net_price_adult_original: getAmount('#netPriceAdult_original'),
                            net_price_adult_difference: getAmount('#netPriceAdult_difference'),

                            net_price_child: getAmount('#netPriceChild'),
                            net_price_child_original: getAmount('#netPriceChild_original'),
                            net_price_child_difference: getAmount('#netPriceChild_difference')
                        };

                        // ==========================================
                        // 14. CUSTOMER APPLIED DISCOUNT DETAILS
                        // ==========================================

                        let customerDiscountDetails = [];

                        const couponDiscount = getAmount('#CustCouponDiscount')|| 0;

                        customerDiscountDetails.push({
                            type: 'Coupon Discount',
                            amount: Math.abs(couponDiscount)
                        });

                        if ($('#CustReferenceWallet').length) {

                            const referenceWallet = getAmount('#CustReferenceWallet')|| 0;

                            customerDiscountDetails.push({
                                type: 'Reference Wallet',
                                amount: Math.abs(referenceWallet)
                            });
                        }

                        if ($('#CustDiscountWallet').length) {

                            const discountWallet = getAmount('#CustDiscountWallet')|| 0;

                            customerDiscountDetails.push({
                                type: 'Discount Wallet',
                                amount: Math.abs(discountWallet)
                            });
                        }

                        const customerDiscountPriceDetails = {
                            details: customerDiscountDetails,
                            subtotal: getAmount('#CustDiscountedPriceSubTotal')
                        };

                        // ==========================================
                        // 15. DISCOUNTED PRICE DETAILS
                        // ==========================================

                        let discountedPriceDetails = [];

                        $('#discountedAdjustmentRows > div').each(function () {

                            const $row = $(this);

                            const label = $row.find('p').eq(0).text().trim();
                            const amountText = $row.find('p').eq(1).text().trim();

                            const amount = parseFloat(
                                amountText.replace(/[^\d.-]/g, '')
                            ) || 0;

                            discountedPriceDetails.push({
                                title: label,
                                amount: Math.abs(amount)
                            });

                        });

                        const discountedPriceData = {
                            details: discountedPriceDetails,
                            subtotal: getAmount('#discountedSubTotal')
                        };

                        // ==========================================
                        // 16. ADDITIONAL PRICE DETAILS
                        // ==========================================

                        let additionalPriceDetails = [];

                        $('#additionalAdjustmentRows > div').each(function () {

                            const $row = $(this);

                            const label = $row.find('p').eq(0).text().trim();
                            const amountText = $row.find('p').eq(1).text().trim();

                            const amount = parseFloat(
                                amountText.replace(/[^\d.-]/g, '')
                            ) || 0;

                            additionalPriceDetails.push({
                                title: label,
                                amount: Math.abs(amount)
                            });

                        });

                        const additionalPriceData = {
                            details: additionalPriceDetails,
                            subtotal: getAmount('#additionalSubTotal')
                        };

                        // ==========================================
                        // 17. FINAL QUOTATION DETAILS
                        // ==========================================

                        const finalQuotationDetails = {
                            net_price_adjustment: getAmount('#netPriceAdjustment'),
                            final_quoted_price: getAmount('#finalQuotedPrice'),
                            gst_percentage: getAmount('#quoteGst'),
                            convenience_fee: getAmount('#quoteConvenienceFee'),
                            gst_amount: getAmount('#quoteGstAmount'),
                            estimated_final_package_price: getAmount('#estimatedFinalPackagePrice')
                        };

                        // ==========================================
                        // 18. COMPLETE QUOTATION PAYLOAD
                        // ==========================================

                        const quotationPayload = {

                            request_id: requestId,
                            package_id: packageId,

                            guest_details: {
                                user_id: guestUserId,
                                full_name: guestFullName,
                                mobile: guestMobile,
                                email: guestEmail
                            },

                            trip_request: tripRequest,

                            customer_preferences: customerPreferences,

                            quick_action: quickAction,

                            coupon_wallet_details: couponWalletDetails,

                            price_adjustments: priceAdjustments,

                            final_package_details: finalPackageDetails,

                            itinerary: itinerary,

                            package_inclusion_exclusion: packageInclusionExclusion,

                            new_policy_documents:  [
                                                    ...existingDocuments,
                                                    ...newDocuments
                                                   ],

                            cancellation_charges: cancellationCharges,

                            commission_incentive: commissionIncentive,

                            markup_calculation: markupCalculation,

                            customer_discount_price_details: customerDiscountPriceDetails,

                            discounted_price_details: discountedPriceData,

                            additional_price_details: additionalPriceData,

                            final_quotation_details: finalQuotationDetails

                        };

                        // ==========================================
                        // 19. CONSOLE OUTPUT
                        // ==========================================

                        console.log('COMPLETE QUOTATION PAYLOAD:', quotationPayload);

                        console.log(
                            'QUOTATION PAYLOAD JSON:',
                            JSON.stringify(quotationPayload, null, 4)
                        );
                        
                        // ==========================================
                        // 20. SUBMIT QUOTATION USING AJAX
                        // ==========================================

                        const formData = new FormData();

                        // Complete quotation JSON
                        formData.append('quotationPayload', JSON.stringify(quotationPayload));

                        // ==========================================
                        // 6. APPEND ONLY NEW FILES
                        // ==========================================
                        newAttachmentItems.forEach((item, index) => {

                            console.log('Appending file:', {
                                index: index,
                                title: item.title,
                                name: item.file.name,
                                size: item.file.size,
                                type: item.file.type
                            });

                            formData.append(
                                'policy_files[]',
                                item.file,
                                item.file.name
                            );

                        });

                        // Prevent multiple submissions
                        const $submitButton = $('#submitQuoteBtn');

                        $.ajax({
                            url: 'ajax/submit_admin_quote.php',
                            type: 'POST',
                            data: formData,

                            processData: false,
                            contentType: false,
                            dataType: 'json',

                            beforeSend: function () {
                                $submitButton.prop('disabled', true);

                                Swal.fire({
                                    title: 'Submitting Quotation...',
                                    text: 'Please wait while we save the quotation.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    didOpen: function () {
                                        Swal.showLoading();
                                    }
                                });
                            },

                            success: function (response) {

                                if (response.success) {

                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message || 'Quotation submitted successfully.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#0d6efd'
                                    }).then(() => {

                                        // Add your redirect here if required.
                                        // window.location.href = 'enquires.php';

                                    });

                                } else {

                                    Swal.fire({
                                        title: 'Unable to Submit',
                                        text: response.message || 'Something went wrong while submitting the quotation.',
                                        icon: 'error',
                                        confirmButtonColor: '#dc3545'
                                    });

                                }
                            },

                            error: function (xhr, status, error) {

                                console.error('AJAX Error:', error);
                                console.error('Response:', xhr.responseText);

                                Swal.fire({
                                    title: 'Server Error',
                                    text: 'Unable to submit the quotation. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });

                            },

                            complete: function () {
                                $submitButton.prop('disabled', false);
                            }
                        });

                    }

                });
            });
        </script>
    </body>
</html>