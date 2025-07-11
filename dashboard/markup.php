<?php
    include_once 'dashboard_user_details.php';

    if($_SESSION["user_type_id_value"] !='3' && $_SESSION["user_type_id_value"] !='11' && $_SESSION["user_type_id_value"] !='16'){
        echo '<script>location.href = "../login";</script>';
    }

    // get current date to show next payout amount  and pass it in sql @ line 129
    $date = date('F,Y'); //month and year. 'F' - month in Text form
    $nextDateMonth = date('m'); //month in number form
    $nextDateYear = date('Y'); //year
    // echo "Next Date ".$date .' ;' ;
    // echo "Next Month ".$nextDateMonth.' ;';
    // echo "Next Year ".$nextDateYear.' ;';
    // echo '<br>';

    // get Previous date to show Previous payout amount  and pass it in sql @ line 111
    $prevdate = date(" F,Y", strtotime("-1 months")); //month and year. 'F' - month in Text form. '-1' to get prev month
    $prevDateMonth = date('m', strtotime("-1 months")); //month in number form. '-1' to get prev month
    $prevDateYear = date('Y');  //Year in number form. 
    // echo "prev Date ".$prevdate.' ;';
    // echo "prev Month ".$prevDateMonth.' ;';
    // echo "prev year ".$prevDateYear.' ;';
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Order History</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">

        <!-- jsvectormap css -->
        <!-- <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" /> -->

        <!--Swiper slider css-->
        <!-- <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" /> -->

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

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "header.php" ?>
            
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
           
            <?php include_once "sidebar.php" ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">  
                        <div class="row">
                            <div class="card">
                                <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 mb-4 mt-2" style="border-bottom: 1px solid #DDDDDD; background-color: #0036A2;">
                                <?php  if($userType == '11'){ ?>
                                    <h5 class="mt-3 ms-3 fw-bold fs-3 text-white">Product MarkUp</h5>
                                <?php }else{ ?>
                                    <h5 class="mt-3 ms-3 fw-bold fs-3 text-white">Packages</h5>
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
                                                        require '../connect.php';
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
                                                    <?php  if($userType == '16'){ ?>
                                                        <th class="ceterText fw-bolder font-size-16">Download Itinerary </th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php
                                                    require '../connect.php';
                                                    $filter = $_GET['travelType'] ?? '';
                                                    $query = "SELECT p.id, p.description, name, t.markup_total, t.total_package_price_per_adult, t.total_package_price_per_child, pt.ca_direct_commission, c.category_name
                                                              FROM package p, package_pricing t, category c, package_pricing_markup pt
                                                              WHERE p.id = t.package_id 
                                                              AND p.category_id = c.id
                                                              AND p.id = pt.package_id
                                                              AND p.status = '1' 
                                                              AND c.status = '1'";

                                                    if (!empty($filter)) {
                                                        $query .= " AND c.category_name = :category";
                                                    }

                                                    $query .= " ORDER BY p.id DESC";

                                                    $stmt = $conn->prepare($query);

                                                    if (!empty($filter)) {
                                                        $stmt->bindParam(':category', $filter);
                                                    }
                                                    $stmt->execute();
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($stmt->rowCount()>0){

                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $package_id = $row['id'];
                                                            $adult_price = (float)$row['total_package_price_per_adult'];
                                                            $child_price = (float)$row['total_package_price_per_child'];
                                                            $te_direct_comm=(float)$row['ca_direct_commission'];
                                                            //$markup_price = (float)$row['markup_total'];
                                                            $Aproduct_price = $adult_price;
                                                            $Cproduct_price = $child_price;
                                                            
                                                            $ta_markups = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id='".$userId."' AND package_id='".$package_id."' ");
                                                            $ta_markups->execute();
                                                            $ta_markups->setFetchMode(PDO::FETCH_ASSOC);
                                                            $ta_markup = $ta_markups->fetch();
                                                                $markup = $ta_markup['markup'] ?? 0;
                                                                $markup_total = $ta_markup['selling_price'] ?? $Aproduct_price;
                                                                $markup_status = $ta_markup['status'] ?? 1;
                                                            // $ta_commission = 0;
                                                            $stmt2 = $conn->prepare("SELECT * FROM package_pricing_markup WHERE package_id='".$package_id."' ");
                                                            $stmt2->execute();
                                                            $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt2->rowCount()>0){
                                                                foreach( ($stmt2->fetchAll()) as $key2 => $row2 ){
                                                                    $ta_commission = $row2['ta_markup'];
                                                                }
                                                            }else{
                                                                $ta_commission = 0;
                                                            }

                                                            echo '<tr style="text-align:left">
                                                                <td> '.++$key.'</td>
                                                                <td>'.$row['name'].'</td>
                                                                <td>'.$row['category_name'].'</a></td>
                                                                <td>Adult Price:₹ '.$Aproduct_price.'/PAX <br/>Child Price:₹ '.$Cproduct_price.'/PAX</td>';
                                                                if ($userType =='11') {
                                                    
                                                                    echo'<td>₹ '.$ta_commission.'/PAX</td>';
                                                                }else if($userType=='16'){
                                                                    echo'<td>₹ '.$te_direct_comm.'/PAX</td>';
                                                                }
                                                                if($userType == '11'){ 
                                                                    echo'<td>₹ <input type="text" id="markup_'.$package_id.'" value="'.$markup.'" onkeyup="validatePrice(this)" style="padding:0px 4px; width:45px;" maxlength="4">/Package</td>';
                                                                    echo'<td>₹ '.$markup_total.'</td>';
                                                                }
                                                                if($userType == '11'){ 
                                                                    echo'<td>';
                                                                        if ( $ta_markup ) {
                                                                            if($markup_status == '3'){
                                                                                echo '<button type="button" onclick=\'addMarkup("'.$userId.'","'.$package_id.'","'.$Aproduct_price.'","1")\' class="btn btn-danger">Rejected</button>';
                                                                            }else if($markup_status == '2'){
                                                                                echo '<button type="button" onclick=\'addMarkup("'.$userId.'","'.$package_id.'","'.$Aproduct_price.'","1")\' class="btn btn-warning">Pending</button>';
                                                                            }else if($markup_status == '1'){
                                                                                echo '<button type="button" onclick=\'addMarkup("'.$userId.'","'.$package_id.'","'.$Aproduct_price.'","1")\' class="btn btn-success">Approved</button>';
                                                                            }
                                                                        } else {
                                                                            echo '<button type="button" onclick=\'addMarkup("'.$userId.'","'.$package_id.'","'.$Aproduct_price.'","0")\' class="btn btn-secondary">Add</button>';
                                                                        }
                                                                    '</td>';
                                                                } else if ($userType == '16') {
                                                                    echo'<td>';
                                                                    echo '<button type="button" class="btn btn-secondary" ><a class="dropdown-item" href="dowload_pack_details.php?id='.urldecode($row["id"]).'" id="generatePDF"><i class="fa-solid fa-arrow-down"></i> Download Details</a></button>';
                                                                     echo'</td>';
                                                                    # code...
                                                                }
                                                            echo'</tr>';
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="7">No Products to Display</td><tr>';
                                                    }
                                                ?>
                                                
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
                <footer class="footer">
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
                </footer>   
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        
        <!-- snack bar -->
        <div id="bottom-snackbar" class="bottom-snackbar" style="display:none">Snack Bar</div>
        <!-- snack bar -->
        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
        <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="assets/js/plugins.js"></script> -->
        <script src="assets/js/submitdata.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(document).ready( function () {
                $('#user_table').DataTable();
                // $('#registeredTable').DataTable();
            });
            
            function validatePrice(e){
                var price = e.value;
                if ( price > 2000 ) {
                    showBottomSnackBar("Mark-Up Price Cannot be more than ₹2000 !!");
                } else {
                    x.style.display = "none";
                }
            }

            function addMarkup(ta_id,package_id,product_price,update){ 

                var markup = document.getElementById('markup_'+package_id).value;
                var data = {
                    ta_id:ta_id,
                    package_id:package_id,
                    product_price:product_price,
                    markup:markup
                }

                if ( markup > 2000 ) {
                    alert('Mark-up Price cannot be more than ₹2000');
                } else if ( update == 0 && markup == 0 ) {
                    alert('Please Add valid Amount !');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "markup_payout/markup_price.php",
                        data: JSON.stringify(data),
                        success:function(e){
                            if (e == 1 ){
                                alert("Added Markup for the Product !!");
                                window.location.reload();
                            } else if (e == 2 ){
                                alert("Updated Markup for the Product !!");
                                window.location.reload();
                            } else{
                                alert("Failed to Create Record !!");
                            }
                        }
                    }); 
                }     
            }

            // success message snack bar
            var x = document.getElementById("bottom-snackbar");
            function showBottomSnackBar(textString) {
                    x.style.display = "block";
                    x.innerText = textString;

                    setTimeout(function(){ 
                        x.style.display = "none";
                    }, 4000);
            }
        </script>
    </body>
</html>