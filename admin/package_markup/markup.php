<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';
$date = date('Y');
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>MarkUp | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- bootstrap-datepicker css -->
    <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->

    <style>
        /* dataTable, action col, dropdown align right  */
        @media screen and (max-width: 992px) and (min-width: 914px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1256px) and (min-width: 1176px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1345px) and (min-width: 1264px) {
            .dropdown-menu-end-2[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }
    </style>

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../header.php';

        // sidebar navigation menu 
        include_once '../sidebar.php';
        ?>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Package MarkUp</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3" style="background-color: #0036A2;">
                                            <h4 class="text-white">Pending Markup</h4>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingMarkup-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Package Id</th>
                                                    <th>Package Name</th>
                                                    <th>Name of TA</th>
                                                    <th>Actual Price (Adult)</th>
                                                    <th>Actual Price (Child)</th>
                                                    <th>Company</th>
                                                    <th>Markup Added</th>
                                                    <th>Selling Price(Adult)</th>
                                                    <th>Selling Price(Child)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../connect.php';

                                                $stmt1 = $conn->prepare(" SELECT * FROM package_markup_travelagent WHERE status = '2' order by id ASC");
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {

                                                        $PMTid = $row['id'];
                                                        $packageId = $row['package_id'];
                                                        $TAId = $row['travelagent_id'];
                                                        $markup = $row['markup'];
                                                        $sellPriceAdult = $row['selling_price_adult'];
                                                        $sellPriceChild = $row['selling_price_child'];

                                                        $stmt2 = $conn->prepare(" SELECT name FROM package WHERE id = '" . $packageId . "'  ");
                                                        $stmt2->execute();
                                                        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                                                        $packageNames = $stmt2->fetch();
                                                        $packageName = $packageNames['name'];

                                                        $stmt3 = $conn->prepare(" SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id = '" . $TAId . "' AND status = '1' ");
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        $TANames = $stmt3->fetch();
                                                        $TA_Fname = $TANames['firstname'] ?? '';
                                                        $TA_Lname = $TANames['lastname'] ?? '';

                                                        $stmt4 = $conn->prepare(" SELECT net_price_adult_with_GST,net_price_child_with_GST, markup_price FROM package_pricing WHERE package_id = '" . $packageId . "'  ");
                                                        $stmt4->execute();
                                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                        //get the company markup from package_pricing_markup 
                                                        $stmt5 = $conn->prepare(" SELECT * FROM `package_pricing_markup` WHERE package_id = '" . $packageId . "'  ");
                                                        $stmt5->execute();
                                                        $stmt5->setFetchMode(PDO::FETCH_ASSOC);
                                                        //--------------
                                                        $packagePricings = $stmt4->fetch();
                                                        $packagePricingsComp = $stmt5->fetch();
                                                        $packagePricingAdult = $packagePricings['net_price_adult_with_GST'];
                                                        $packagePricingChild = $packagePricings['net_price_child_with_GST'];
                                                        $markup_price = $packagePricingsComp['company']??0;

                                                        echo '<tr>
                                                                    <td>' . $PMTid . '</td>
                                                                    <td>' . $packageId . '</td>
                                                                    <td>' . $packageName . '</td>
                                                                    <td>' . $TAId . ' ' . $TA_Fname . ' ' . $TA_Lname . '</td>
                                                                    <td>' . $packagePricingAdult . '</td>
                                                                    <td>' . $packagePricingChild . '</td>
                                                                    <td>' . $markup_price . '</td>
                                                                    <td>' . $markup . '</td>
                                                                    <td>' . $sellPriceAdult . '</td>
                                                                    <td>' . $sellPriceChild . '</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="#" class="dropdown-item" onclick=\'actionMarkup("' . $PMTid . '","' . $packageId . '","' . $TAId . '","1")\' ><i class="mdi mdi-check-bold font-size-16 text-success me-1"></i> Approve</a></li>
                                                                                <li><a href="#" class="dropdown-item" onclick=\'actionMarkup("' . $PMTid . '","' . $packageId . '","' . $TAId . '","3")\' ><i class="mdi mdi-close-circle font-size-16 text-danger me-1"></i> Reject</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                    <!-- end table responsive -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3" style="background-color: #0036A2;">
                                            <h4 class="text-white">Approved Markup</h4>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="approvedMarkup-table">
                                            <thead class="table-light">
                                                <tr>
                                                <th>Id</th>
                                                    <th>Package Id</th>
                                                    <th>Package Name</th>
                                                    <th>Name of TA</th>
                                                    <th>Actual Price (Adult)</th>
                                                    <th>Actual Price (Child)</th>
                                                    <th>Company</th>
                                                    <th>Markup Added</th>
                                                    <th>Selling Price(Adult)</th>
                                                    <th>Selling Price(Child)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../connect.php';

                                                $stmt1 = $conn->prepare(" SELECT * FROM package_markup_travelagent WHERE status = '1' order by id ASC");
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {

                                                        $packageId = $row['package_id'];
                                                        $TAId = $row['travelagent_id'];
                                                        $markup = $row['markup'];
                                                        $sellPriceAdult = $row['selling_price_adult'];
                                                        $sellPriceChild = $row['selling_price_child'];

                                                        $stmt2 = $conn->prepare(" SELECT name FROM package WHERE id = '" . $packageId . "'  ");
                                                        $stmt2->execute();
                                                        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                                                        $packageNames = $stmt2->fetch();
                                                        $packageName = $packageNames['name'];

                                                        $stmt3 = $conn->prepare(" SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id = '" . $TAId . "' AND status = '1' ");
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        $TANames = $stmt3->fetch();
                                                        $TA_Fname = $TANames['firstname'] ?? '';
                                                        $TA_Lname = $TANames['lastname'] ?? '';

                                                        $stmt4 = $conn->prepare(" SELECT net_price_adult_with_GST,net_price_child_with_GST, markup_price FROM package_pricing WHERE package_id = '" . $packageId . "'  ");
                                                        $stmt4->execute();
                                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                        //get the company markup from package_pricing_markup 
                                                        $stmt5 = $conn->prepare(" SELECT * FROM `package_pricing_markup` WHERE package_id = " . $packageId . "  ");
                                                        $stmt5->execute();
                                                        $stmt5->setFetchMode(PDO::FETCH_ASSOC);
                                                        //--------------
                                                        $packagePricings = $stmt4->fetch();
                                                        $packagePricingsComp = $stmt5->fetch();
            
                                                        $packagePricingadult = $packagePricings['net_price_adult_with_GST'];
                                                        $packagePricingchild = $packagePricings['net_price_child_with_GST'];
                                                        $markup_price = $packagePricingsComp['company']??0;

                                                        echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td>' . $packageId . '</td>
                                                                    <td>' . $packageName . '</td>
                                                                    <td>' . $TAId . ' ' . $TA_Fname . ' ' . $TA_Lname . '</td>
                                                                    <td>' . $packagePricingadult . '</td>
                                                                    <td>' . $packagePricingchild . '</td>
                                                                    <td>' . $markup_price . '</td>
                                                                    <td>' . $markup . '</td>
                                                                    <td>' . $sellPriceAdult . '</td>
                                                                    <td>'.$sellPriceChild.'</td>
                                                                    <td class="text-center">
                                                                        <a class="dropdown-item" href="#"><i class="mdi mdi-check-decagram font-size-16 text-success me-1"></i>Approved</a>
                                                                    </td>
                                                                </tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                    <!-- end table responsive -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $date; ?> © Uniqbizz.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by MirthCon.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <!-- bootstrap-datepicker js -->
    <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- ecommerce-customer-list init -->
    <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <!-- dataTable -->
    <script>
        $(document).ready(function() {
            $("#pendingMarkup-table").DataTable({
                scrollX: true,
                autoWidth: false, // Ensures columns don't shrink unexpectedly
                paging: true,
                searching: true,
                ordering: true
            });

            $("#approvedMarkup-table").DataTable();
        });

        function actionMarkup(id, pid, taid, status) {
            var dataString = 'id=' + id + '&pid=' + pid + '&taid=' + taid + '&status=' + status;

            $.ajax({
                type: "POST",
                url: "package_markup_action.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    // console.log('data'+data);
                    if (data == '1') {
                        alert("Markup Status Update");
                        window.location.reload();
                    } else {
                        alert("Request Failed !!");
                        window.location.reload();
                    }
                }
            });

        };
    </script>
</body>

</html>