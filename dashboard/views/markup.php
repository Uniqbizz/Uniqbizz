<?php
    include_once '../dashboard_user_details.php';

    // get current date to show next payout amount  and pass it in sql @ line 129
    $date = date('F,Y'); //month and year. 'F' - month in Text form
    $nextDateMonth = date('m'); //month in number form
    $nextDateYear = date('Y'); //year

    // get Previous date to show Previous payout amount  and pass it in sql @ line 111
    $prevdate = date(" F,Y", strtotime("-1 months")); //month and year. 'F' - month in Text form. '-1' to get prev month
    $prevDateMonth = date('m', strtotime("-1 months")); //month in number form. '-1' to get prev month
    $prevDateYear = date('Y');  //Year in number form. 
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Order History</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "../header.php" ?>
            
            <?php include '../notification_card.php'?>
            <!-- ========== App Menu ========== -->
           
            <?php include_once "../sidebar.php" ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">  
                        <div class="row">
                            <div class="card">
                                <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 mb-4 mt-2" style="border-bottom: 1px solid #DDDDDD;">
                                <?php  if($userType == '11'){ ?>
                                    <h5 class="mt-3 ms-3 fw-bold fs-3 text-dark">Product MarkUp</h5>
                                <?php }else{ ?>
                                    <h5 class="mt-3 ms-3 fw-bold fs-3 text-dark">Packages</h5>
                                <?php } ?>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive table-desi">
                                        <!-- table roe limit -->
                                        <form method="GET">
                                            <div class="col-md-4 col-sm-12 col-12 pb-2 d-flex align-items-center">
                                                <label for="travelType" class="form-label mb-0 me-2" style="white-space: nowrap; min-width: 130px;">Select Travel Type:</label>
                                                <select class="form-select" id="travelType" name="travelType" onchange="this.form.submit()">
                                                    <option value="">ALL</option>
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT c.category_name FROM category c WHERE c.status = 1");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        $selectedCategory = $_GET['travelType'] ?? '';

                                                        while ($row = $stmt->fetch()) {
                                                            $categoryName = htmlspecialchars($row['category_name']);
                                                            $selected = ($selectedCategory === $categoryName) ? 'selected' : '';
                                                            echo "<option value=\"$categoryName\" $selected>$categoryName</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </form>

                                        <table class="table table-hover" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">#</th>
                                                    <th class="ceterText fw-bolder font-size-16">Package</th>
                                                    <th class="ceterText fw-bolder font-size-16">Package Type</th>
                                                    <th class="ceterText fw-bolder font-size-16">Price</th>
                                                    <th class="ceterText fw-bolder font-size-16">Commission</th>
                                                    <?php  if($userType == '11'){ ?>
                                                        <th class="ceterText fw-bolder font-size-16">Markup</th>
                                                    <?php } ?>
                                                    <?php  if($userType == '11'){ ?>
                                                        <th class="ceterText fw-bolder font-size-16">Selling Price</th>
                                                        <th class="ceterText fw-bolder font-size-16">Action</th>
                                                    <?php } ?>
                                                    <?php  if($userType == '16' || $userType == '29'){ ?>
                                                        <th class="ceterText fw-bolder font-size-16">Download Itinerary </th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <!-- data load from models file -->
                                                <?php include '../models/markup/markup_list.php' ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php include_once "../footer.php" ?>  
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        
        <!-- snack bar -->
        <div id="bottom-snackbar" class="bottom-snackbar" style="display:none">Snack Bar</div>
        <!-- snack bar -->
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/submitdata.js"></script>
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="../resources/markup/markup_custom.js"></script>
    </body>
</html>