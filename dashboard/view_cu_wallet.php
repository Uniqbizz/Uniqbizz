<?php
include_once 'dashboard_user_details.php';
$date = date('F,Y'); //month and year. 'F' - month in Text form
$DateMonth = date('m'); //month in number form
$DateYear = date('Y'); //year
if ($userType == 10){
    $sqlcust = 'SELECT customer_type FROM ca_customer WHERE ca_customer_id = :user';
    $stmt = $conn->prepare($sqlcust);
    $stmt->execute([':user' => $userId]);

    $customer_type = $stmt->fetchColumn();

}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard | Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="assets/css/custom.css" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    <style>
        .wallet-tab {
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .wallet-tab:hover {
            background-color: #3f5866; /* optional */
        }

        .selected-tab {
            box-shadow: 0 6px 12px rgba(63, 88, 102, 0.9); /* stronger bottom shadow */
        }
    </style>





</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once 'header.php'; ?>

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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

        <?php include_once 'sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <?php if ($userType == "10") { ?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">View Customer Wallets</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Customer Wallets</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div id='redeemable_wallet_div' class="card rounded-4 pt-3 pb-2 px-4 cardBg1 wallet-tab selected-tab">
                                    <div>
                                        <p class="text-white fw-bold">Redeemable Amount</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT
                                                    SUM(COALESCE(earned_amount, 0)) AS credit_amt,
                                                    SUM(COALESCE(used_amount, 0)) AS debit_amt,
                                                    (SUM(COALESCE(earned_amount, 0)) - SUM(COALESCE(used_amount, 0))) AS net_balance
                                                FROM customer_reference_wallet_utilization
                                                WHERE customer_id = :userId");
                                                $stmt->execute(['userId' => $userId]);
                                                $redeemableTotal = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
                                                echo '<h1 class="mb-0 text-white">' . $redeemableTotal . '</h1>';                                           
                                            ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <?php
                                            $stmt = $conn->prepare("SELECT
                                                SUM(COALESCE(earned_amount, 0)) AS credit_amt,
                                                SUM(COALESCE(used_amount, 0)) AS debit_amt,
                                                (SUM(COALESCE(earned_amount, 0)) - SUM(COALESCE(used_amount, 0))) AS net_balance
                                            FROM customer_reference_wallet_utilization
                                            WHERE customer_id = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month");
                                            $stmt->execute(['userId' => $userId, 'year' => $DateYear, 'month' => $DateMonth]);
                                            $redeemableMonth = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
                                             echo '<p class="text-white">' . $redeemableMonth . '</p>';
                                        
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 <?=in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">
                                <div id='booking_wallet_div' class="card rounded-4 pt-3 pb-2 px-4 cardBg2 wallet-tab">
                                    <div>
                                        <p class="text-white fw-bold">Booking Points</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT
                                                    SUM(COALESCE(credit_amount, 0)) AS credit_amt,
                                                    SUM(COALESCE(debit_amount, 0)) AS debit_amt,
                                                    (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance FROM customer_reference_booking_points_utilization WHERE customer_id = :userId");
                                                $stmt->execute(['userId' => $userId]);
                                                $bookingTotal = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
                                                echo '<h1 class="mb-0 text-white">' . $bookingTotal . '</h1>';
                                            
                                            ?>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <?php
                                            $stmt = $conn->prepare("SELECT
                                                SUM(COALESCE(credit_amount, 0)) AS credit_amt,
                                                SUM(COALESCE(debit_amount, 0)) AS debit_amt,
                                                (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance FROM customer_reference_booking_points_utilization WHERE customer_id = :userId  AND YEAR(created_date) = :year AND MONTH(created_date) = :month");
                                            $stmt->execute(['userId' => $userId, 'year' => $DateYear, 'month' => $DateMonth]);
                                            $bookingMonth = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
                                            echo '<p class="text-white">' . $bookingMonth . '</p>';
                                        
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php if ($customer_type!='Free' || $customer_type!='Premium' || $customer_type!='Prime'){?>
                        <div class="row ">
                            <!-- booking wallet table -->
                            <div id ='booking_ponits_table_div' class="col <?= in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Booking Points Wallet History</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Points Message</th>
                                                                <th data-ordering="false">Points Value</th>
                                                                <th data-ordering="false">Added On</th>
                                                                <th data-ordering="false">Status</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $stmt = $conn->prepare("SELECT * FROM `customer_reference_payout` WHERE customer_id = '" . $userId . "' AND booking_points IS NOT NULL ORDER BY ID DESC");
                                                            $stmt->execute();
                                                            $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                            $i = 0;
                                                            
                                                            if (!empty($referrals)) {

                                                                foreach ($referrals as $referral) {
                                                                    $referral_text = $referral['booking_message']; // Original string
                                                                    $formatted_date = date('d-m-Y', strtotime($referral['created_date']));
                                                                    $formatted_text = '';

                                                                    $split = explode('points', $referral_text, 2);
                                                                    if (count($split) == 2) {
                                                                        $first_part = trim($split[0]) . ' points'; // e.g. "Harsh... 500 booking points"
                                                                        $after_points = trim($split[1]); // e.g. "as a Level 1 referrer for referring Tukaram..."

                                                                        // Check for "through"
                                                                        if (stripos($after_points, 'through') !== false) {
                                                                            $through_split = explode('through', $after_points, 2);
                                                                            $before_through = trim($through_split[0]); // e.g. "as a Level 2 referrer for referring Brijesh..."
                                                                            $through_clause = 'through ' . trim($through_split[1]);
                                                                            $formatted_text = $first_part . '<br>' . $before_through . '<br>' . $through_clause;
                                                                        } else {
                                                                            $formatted_text = $first_part . '<br>' . $after_points;
                                                                        }
                                                                    } else {
                                                                        $formatted_text = $referral_text;
                                                                    }
                                                                    echo '<tr>
                                                                    <td>' . ++$i . '</td>
                                                                    <td>' . $formatted_text.'</td>
                                                                    <td>' . $referral['booking_points'] . '</td>
                                                                    <td>' . $formatted_date . '</td>';
                                                                    if ($referral['status'] == '3')
                                                                        echo '<td><span class="badge bg-success">Credited</span></td>';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <!-- end booking wallet table -->
                            <!-- redeemable wallet table -->
                            <div id="redeemable_amount_table_div" class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Redeemable Wallet History</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Payout Message</th>
                                                                <th data-ordering="false">Payout Amount</th>
                                                                <th data-ordering="false">Earned ON</th>
                                                                <th data-ordering="false">Status</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $stmt = $conn->prepare("SELECT * FROM `customer_reference_payout` WHERE customer_id = '" . $userId . "' AND referral_amount IS NOT NULL ORDER BY ID DESC");
                                                            $stmt->execute();
                                                            $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                            $i = 0;
                                                            

                                                            foreach ($referrals as $referral) {
                                                                $referral_text = $referral['referral_message']; // Original string
                                                                $formatted_date = date('d-m-Y', strtotime($referral['created_date']));
                                                                $split = explode('referring', $referral_text, 2);
                                                                $formatted_text = '';

                                                                if (count($split) == 2) {
                                                                    $first_part = trim($split[0]) . ' referring';
                                                                    $after_referring = trim($split[1]);

                                                                    if (strpos($after_referring, 'through') !== false) {
                                                                        $split2 = explode('through', $after_referring, 2);
                                                                        $second_part = trim($split2[0]);
                                                                        $third_part = trim($split2[1]);
                                                                        $formatted_text = $first_part . '<br>' . $second_part . '<br>' . $third_part;
                                                                    } else {
                                                                        $second_part = $after_referring;
                                                                        $formatted_text = $first_part . '<br>' . $second_part;
                                                                    }
                                                                } else {
                                                                    // If "referring" not found, use full text
                                                                    $formatted_text = $referral_text;
                                                                }
                                                                echo '<tr>
                                                                  <td>' . ++$i . '</td>
                                                                  <td>' . $formatted_text.'</td>
                                                                  <td>' . $referral['referral_amount'] . '</td>
                                                                  <td>' . $formatted_date . '</td>';
                                                                if ($referral['status'] == '1')
                                                                    echo '<td><span class="badge bg-success">Paid</span></td>';
                                                                else if ($referral['status'] == '2')
                                                                    echo '<td><span class="badge bg-warning">Pending</span></td>';
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <!-- end redeemable wallet table -->


                        </div>
                        <?php } 
                     } ?>

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->

                <?php include_once "footer.php" ?>

        </div><!-- end main content-->

    </div><!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- !-- materialdesign icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
        
        $(document).ready(function() {
            $("#example-dataTable").DataTable();
            $("#example-dataTable1").DataTable();
            // Hide both tables initially
            $('#booking_ponits_table_div').hide();
            $('#redeemable_amount_table_div').show();

            // Click event for Booking Wallet Card
            $('#booking_wallet_div').on('click', function () {
                $('#booking_ponits_table_div').show();
                $('#redeemable_amount_table_div').hide();
                // Highlight selected tab
                $('.wallet-tab').removeClass('selected-tab');
                $(this).addClass('selected-tab');
            });

            // Click event for Redeemable Wallet Card
            $('#redeemable_wallet_div').on('click', function () {
                $('#redeemable_amount_table_div').show();
                $('#booking_ponits_table_div').hide();
                // Highlight selected tab
                $('.wallet-tab').removeClass('selected-tab');
                $(this).addClass('selected-tab');
            });
            
        });
    </script>
</body>

</html>