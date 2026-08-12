<?php
    include (__DIR__ .'/customer_model.php');
    include (__DIR__ .'/customer_mapping.php');
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');
?>
<header id="page-topbar" class="rounded-4" style="left: 0 !important;">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <!-- LOGO -->
                <div class="navbar-brand-box ms-5" class="rounded-4">
                    <!-- Light Logo-->
                    <a href="<?= $base_url_cust?>customer_dashboard.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?= $base_url ?>assets/images/fav.png" alt="" height="25">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= $base_url ?>assets/images/bizz_logo.png" alt="" height="50">
                        </span>
                    </a>
                </div>
                <!-- logo for mobile view  -->
                <div class="com_logo">
                    <a href="<?= $base_url_cust?>customer_dashboard.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?= $base_url ?>assets/images/bizz_logo.png" alt="" height="50">
                        </span>
                    </a>
                </div>

                <!-- App Search-->

            </div>
            <div class="searchBar d-none d-md-block ms-5">
                <input class="form-control pe-5" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                <i class="fa-solid fa-magnifying-glass searchIcon"></i>
            </div>

            <div class="d-flex align-items-center">

                <!-- added by SV on 29 jan 2025  -->
                <div class="ms-1 header-item d-none d-sm-flex">
                    <?php
                        // Function to format number in Indian style
                        function formatIndianNumber($num) {
                            $decimalPart = "";
                        
                            // Convert number to string and handle decimal part
                            $num = (string) $num;
                            if (strpos($num, '.') !== false) {
                                list($num, $decimalPart) = explode('.', $num);
                                $decimalPart = '.' . $decimalPart;
                            }
                        
                            // Handle the first three digits separately
                            $lastThree = substr($num, -3);
                            $rest = substr($num, 0, -3); // Get remaining digits
                        
                            if ($rest != '') {
                                $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest); // Add commas every 2 digits
                                $num = $rest . ',' . $lastThree; // Combine with last 3 digits
                            }
                        
                            return $num . $decimalPart;
                        }

                        // Check if user exists
                        $stmt1 = $conn->prepare("SELECT * FROM `login` WHERE status = '1' AND `user_id` = ? AND `user_type_id` = '11'");
                        $stmt1->execute([$userId]);

                        // Fetch the latest available balance for the given ta_id
                        $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
                        $stmt2->execute(array(':ta_id' => $userId));
                        $result3 = $stmt2->fetch(PDO::FETCH_ASSOC);

                        $available_bal = ($result3['available_balance'] ?? 0);
                        $available_bal = formatIndianNumber($available_bal);

                        if ($stmt1->rowCount() > 0) {
                            echo '<button type="button" class="btn shadow-none">
                                    <a class="dropdown-item" href="view_ta_topup.php">
                                        <i class="bx bx-wallet font-size-16 align-middle me-1 shadow-none"></i> 
                                            <span id="ta_wallent1">TopUp Wallet</span>
                                    </a>
                                </button>';

                            // JavaScript for updating wallet balance dynamically
                            echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
                            echo '<script>
                                    $(document).ready(function() {
                                    console.log("ta_amt:", ' . json_encode($available_bal) . ');
                                    // Ensure the element exists before updating
                                    if ($("#ta_wallent1").length) {
                                        var taTopAmt = ' . json_encode($available_bal) . '; // PHP into JS variable
                                        // Update HTML content with balance information
                                        $("#ta_wallent1").html("TopUp Wallet <br> <b>Balance: " + taTopAmt + "<b>");
                                    }
                                    });
                                </script>';
                        }
                    ?>


                </div>
                <!-- Customer -->
                <?php if ($userType == '10'){?> 
                <button type="button" class="btn shadow-none d-none d-md-inline-block">
                    <a class="dropdown-item" href="<?= $base_url_cust. $folder_map[$customer['customer_type']] ?>customer_wallet.php">
                        <div class="d-flex gap-3">
                            <i class="bx bx-wallet walletIcon"></i> 
                            <p class="mb-0">
                                Wallet Balance <br>
                                <span class="walletAmount">₹<?= (($refWalletData['ref_total_earning'] ?? '0') + ($refWalletCurBalData['ref_booking_total'] ?? '0' ) + ($disWalletData['balance'] ?? '0')) ?></span>
                            </p>
                        </div>
                    </a>
                </button>
                <?php } ?>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                    <!-- <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button> -->
                </div>


                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                            All
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    
                                </div>

                            </div>

                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show p-4" id="all-noti-tab" role="tabpanel">
                                <div class="empty-notification-elem">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="<?= $base_url ?>assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade p-4" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                <div class="empty-notification-elem">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="<?= $base_url ?>assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab">
                                <div class="empty-notification-elem">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="<?= $base_url ?>assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user bg-white">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php echo $home_url.'uploading/' . $profile_pic; ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $userFname . ' ' . $userLname; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php echo $designation; ?></span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end px-3">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?php echo $userFname; ?>!</h6>
                        <?php
                        

                        // Check if user exists
                        $stmt1 = $conn->prepare("SELECT * FROM `login` WHERE status = '1' AND `user_id` = ? AND `user_type_id` = '11'");
                        $stmt1->execute([$userId]);

                        // Fetch the latest available balance for the given ta_id
                        $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
                        $stmt2->execute(array(':ta_id' => $userId));
                        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $ta_top_amt = $row['available_balance'] ?? '';
                        $ta_top_amt = formatIndianNumber($ta_top_amt);

                        if ($stmt1->rowCount() > 0) {
                            // Button visible only on mobile screens (small screens)
                            echo '<a class="dropdown-item d-block d-sm-none" href="view_ta_topup.php">
                                  <i class="bx bx-wallet font-size-12 align-middle me-1 shadow-none"></i> 
                                  <span id="ta_wallent">TopUp Wallet</span>
                                  </a>';

                            // JavaScript for updating wallet balance dynamically
                            echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
                            echo '<script>
                                  $(document).ready(function() {
                                    console.log("ta_amt:", ' . json_encode($ta_top_amt) . ');
                                    // Ensure the element exists before updating
                                    if ($("#ta_wallent").length) {
                                      var taTopAmt = ' . json_encode($ta_top_amt) . '; // PHP into JS variable
                                      $("#ta_wallent").html("TopUp Wallet <br> <b>Balance: " + taTopAmt + "<b>"); // Update HTML content
                                    }
                                  });
                                  </script>';
                        }
                        ?>
                        <!-- Mobile Search + Wallet -->
                        <div class="d-block d-md-none">
                            <!-- Mobile Search -->
                            <div class="searchBar mb-3">
                                <input class="form-control pe-5" list="datalistOptions" id="mobileSearch" placeholder="Type to search...">
                                <i class="fa-solid fa-magnifying-glass searchIcon"></i>
                            </div>

                            <!-- Customer Wallet -->
                            <a class="dropdown-item mb-2" href="view_cu_wallet.php">
                                <div class="d-flex gap-3 align-items-center">
                                    <i class="bx bx-wallet walletIcon"></i>
                                    <p class="mb-0">
                                        Wallet Balance <br>
                                        <span class="walletAmount">&#8377; 3,200</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <a class="dropdown-item" href="<?= $base_url_cust ?>profile.php"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= $base_url ?>logout.php" class="mylogout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>