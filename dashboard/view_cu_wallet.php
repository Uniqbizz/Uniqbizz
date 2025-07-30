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
    <title>Dashboard | Customer</title>
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
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card rounded-4 pt-3 pb-2 px-4 cardBg1">
                                    <div>
                                        <p class="text-white fw-bold">Redeemable Count</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <?php
                                            $sql3 = "SELECT COUNT(id) as id FROM customer_reference_payout WHERE customer_id = '" . $userId . "' AND referral_amount IS NOT NULL";
                                            $stmt3 = $conn->prepare($sql3);
                                            $stmt3->execute();
                                            $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                            if ($stmt3->rowCount() > 0) {
                                                foreach (($stmt3->fetchAll()) as $key => $row) {
                                                    $id = $row['id'];
                                                    echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <?php
                                        $sql3 = "SELECT COUNT(id) as id FROM customer_reference_payout WHERE customer_id='" . $userId . "' AND referral_amount IS NOT NULL AND YEAR(created_date) = '" . $DateYear . "' AND MONTH(created_date) = '" . $DateMonth . "'";
                                        $stmt3 = $conn->prepare($sql3);
                                        $stmt3->execute();
                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt3->rowCount() > 0) {
                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                $id2 = $row['id'];
                                                echo '<p class="text-white">' . $id2 . '</p>';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 <?=in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">
                                <div class="card rounded-4 pt-3 pb-2 px-4 cardBg2">
                                    <div>
                                        <p class="text-white fw-bold">Booking Points Count</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <?php
                                            $stmt = $conn->prepare("SELECT COUNT(id) as id FROM customer_reference_payout WHERE customer_id = '" . $userId . "'AND booking_points IS NOT NULL ");
                                            $stmt->execute();
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            if ($stmt->rowCount() > 0) {
                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                    $completedTour = $row['id'];
                                                    echo '<h1 class="mb-0 text-white">' . $completedTour . '</h1>';
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <?php
                                        $stmt = $conn->prepare("SELECT COUNT(id) as id FROM customer_reference_payout WHERE customer_id='" . $userId . "' AND booking_points IS NOT NULL AND YEAR(created_date) = '" . $DateYear . "' AND MONTH(created_date) = '" . $DateMonth . "'");
                                        $stmt->execute();
                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt->rowCount() > 0) {
                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                $completedTourThisMonth = $row['id'];
                                                echo '<p class="text-white">' . $completedTourThisMonth . '</p>';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php if ($customer_type!='Free' || $customer_type!='Premium' || $customer_type!='Prime'){?>
                        <div class="row <?= in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">
                            <div class="col">

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
                                                                    <td>' . $first_part . '</br>'.$second_part.'</td>
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

                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col">

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

                        </div>

                        <!-- <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                            <a href="add_ta_top_up.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                            </a>
                        </div> -->
                    <?php } ?>

                    </div> <!-- container-fluid -->
                    <!-- show rejection message start -->
                    <div class="modal fade" id="rejectTopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Rejection Reason</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating">
                                        <p id="floatingTextarea" ></p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- show rejection message end -->

                </div><!-- End Page-content -->

                <footer class="footer"> <!-- footer start -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Mirthcon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> <!-- footer end -->

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

    <!-- <script src="assets/js/pages/datatables.init.js"></script> -->

    <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
    <!-- <script src="assets/js/plugins.js"></script> -->

    <!-- !-- materialdesign icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>

    <!-- apexcharts -->
    <!-- <script src="assets/libs/apexcharts/apexcharts.min.js"></script> -->
    <!--  -->
    <!-- Vector map-->
    <!-- <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script> -->
    <!-- <script src="assets/libs/jsvectormap/maps/world-merc.js"></script> -->

    <!--Swiper slider js-->
    <!-- <script src="assets/libs/swiper/swiper-bundle.min.js"></script> -->

    <!-- Dashboard init -->
    <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <!-- Chart JS -->
    <!-- <script src="assets/libs/chart.js/chart.umd.js"></script>// -->

    <!-- chartjs init -->
    <!-- <script src="assets/js/pages/chartjs.init.js"></script>// -->

    <!-- Dashboard init -->
    <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->

    <script>
        
        $(document).ready(function() {
            $("#example-dataTable").DataTable();
            $("#example-dataTable1").DataTable();
            $('.rejectMess').click(function () {
                var createdDate=$(this).data("created-date");
                var usersId=$(this).data("user-id");
                $.ajax({
                   url:"travel_agent/getRejectReason.php",
                   type:"POST",
                   data:{createdDate:createdDate,usersId:usersId},
                   success:function(response){
                    $('#floatingTextarea').text(response);
                    $("#rejectTopup").modal("show");
                   } 
                });
                
            });
        });

        function editfunc(id, cut, st, ct, editfor) {
            window.location.href = 'edit_customer.php?vkvbvjfgfikix=' + id + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function addRefFunc(id, taID, cut, st, ct, editfor) {
            window.location.href = 'add_customer.php?vkvbvjfgfikix=' + id + '&taId=' + taID + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function deletefunc(id, fid, action) {
            var dataString = 'id=' + id + '&fid=' + fid + '&action=' + action;

            $.ajax({
                type: "POST",
                url: "customer/delete_customer_data.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        alert("Deleted Succesfully");
                        window.location.reload();
                    } else if (data == 1) {
                        alert("User Activated Succesfully");
                        window.location.reload();
                    } else if (data == 2) {
                        alert("User Restored Succesfully");
                        window.location.reload();
                    } else if (data == 3) {
                        alert("User Deactivated Succesfully");
                        window.location.reload();
                    } else {
                        alert("Request Failed !!");
                    }
                }
            });
        };

        function confirmfunc(id, email) {
            var dataString = 'id=' + id + '&uname=' + email;

            $.ajax({
                type: "POST",
                url: "customer/confirm_customer.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    if (data == 1) {
                        alert("Email and Password sent via sms and email");
                        window.location.reload();
                    } else {

                        alert("Failed to confirm");
                    }
                }
            });

        };

        function overviewPage(id, ref, cut, st, ct, message) {
            var designation = 'Customer';
            window.location.href = 'overview.php?id=' + id + '&ref=' + ref + '&cut=' + cut + '&st=' + st + '&ct=' + ct + '&message=' + message + '&designation=' + designation;
        }
    </script>
</body>

</html>