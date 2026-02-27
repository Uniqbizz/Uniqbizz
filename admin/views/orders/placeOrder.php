<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
}
$date = date('Y'); 
//travel Date
$travel = date('m-d');
require '../../connect.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Place Order</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets/images/fav.png">
        <!-- custom css file -->
        <!-- <link href="../../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
        <!-- Bootstrap Css -->
        <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Css-->
        <link href="../../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> -->
        <!-- DataTables -->
        <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Date Range Picker CSS Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!-- Date Range Picker CSS End -->
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../../header.php';

                // sidebar navigation menu 
                include_once '../../sidebar.php';

            ?>
            <div class="layout-wrapper">
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="card rounded-4 p-3">
                                <div class="row">
                                    <h5 class="my-2">Place Order</h5>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Customer ID<span class="text-danger">*</span></label>
                                            <select id="customerId" class="form-select">
                                                <option selected disabled>--Select Customer ID--</option>
                                                <?php
                                                     $stmt2 = $conn->prepare("SELECT * FROM ca_customer WHERE status='1' ");
                                                     $stmt2->execute();
                                                     $cuS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                     $result='';
                                                     foreach ($cuS as $cuVal) {
                                                        $result.='<option value="'.$cuVal["ca_customer_id"].'">'.$cuVal["firstname"]. ' '.$cuVal["lastname"].'('.$cuVal["ca_customer_id"].')</option>';
                                                     }
                                                     echo $result;
                                                ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Customer Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="customer_name" placeholder="Enter Customer Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Email Address<span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" id="email" placeholder="Enter Email Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="phone_no" placeholder="Enter Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <label class="col-form-label">Members<span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="form-group col-sm-4 col-12">
                                                <div class="input-box mb-1">
                                                    <input type="number" class="form-control fs-6 w-100" name="b_no_adult" id="b_no_adult" value="1" placeholder="Adults (12+ Yrs)" min="1" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 col-12">
                                                <div class="input-box mb-1">
                                                    <input type="number" class="form-control fs-6" name="b_no_child" id="b_no_child" value="" placeholder="Children (3-11 Yrs)" min="0" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 col-12">
                                                <div class="input-box mb-1">
                                                    <input type="number" class="form-control fs-6" name="b_no_infants" id="b_no_infants" placeholder="Infants (Under 2 Yrs)" value="" min="0" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- readymade packages -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Package<span class="text-danger">*</span></label>
                                            <select id="packageList" class="form-select">
                                                <option selected disabled>--Select Package--</option>
                                                <?php
                                                     $stmt2 = $conn->prepare("SELECT * FROM package WHERE status='1' ");
                                                     $stmt2->execute();
                                                     $pcS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                     $result='';
                                                     foreach ($pcS as $pcVal) {
                                                        $result.='<option value="'.$pcVal["id"].'">'.$pcVal["name"].'('.$pcVal["unique_code"].')</option>';
                                                     }
                                                     echo $result;
                                                ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                                        <label class="col-form-label">Package Image</label>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-lg-9 col-md-9 col-sm-12 col-12">
                                                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-inner rounded-4">
                                                        <div class="carousel-item active">
                                                            <img src="../../../uploading/packages/Amritsar-Dalhousie-Dharamshala1725538644-1.jpg" class="d-block w-100" height="400px" alt="...">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="../../../uploading/packages/Andhra-Pradesh-Z1646117736-1.jpg" class="d-block w-100" height="400px" alt="...">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="../../../uploading/packages/Bangalore-Mysore1725535571-1.jpg" class="d-block w-100" height="400px" alt="...">
                                                        </div>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-0">Member Details</h5>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div id="members_details" class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 adult-1-block">
                                                <div class="input-block mb-2">
                                                    <label class="col-form-label">Adult 1 Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control member_name" name="member_name[]" id="first_adult_name" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 adult-1-block">
                                                <div class="input-block mb-2">
                                                    <label class="col-form-label">Adult 1 Age <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control member_age" name="member_age[]" id="first_adult_age" min="12" max="100" placeholder="Age">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 adult-1-block">
                                                <div class="input-block mb-2">
                                                    <label class="col-form-label">Adult 1 Gender <span class="text-danger">*</span></label>
                                                    <select name="member_gender[]" id="first_adult_gender" class="form-select member_gender">
                                                        <option disabled selected>--Select Gender--</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Travel Date<span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" id="travel_date" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class=""> 
                                                        <label class="col-form-label" for="apackage_price ">Adult Price/pax</label>
                                                        <input type="text" class="form-control" id="apackage_price" placeholder="Adult Package Price" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="">
                                                        <label class="col-form-label" for="cpackage_price ">Child Price/pax</label>
                                                        <input type="text" class="form-control" id="cpackage_price" placeholder="Child Package Price" readonly>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="gst" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                            <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                <label for="cashPayment" class="mb-0"><input type="radio" id="cashPayment" class="form-check-input payment me-2" name="payment" value="cash">Cash</label>
                                                <label for="chequePayment" class="mb-0"><input type="radio" id="chequePayment" class="form-check-input payment me-2" name="payment" value="cheque">Cheque</label>
                                                <label for="onlinePayment" class="mb-0"><input type="radio" id="onlinePayment" class="form-check-input payment me-2" name="payment" value="online">UPI/NEFT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-2" id="paymentFields">
                                        <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-4 py-1">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 py-1">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 py-1">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Payable Amount<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="payable_amount" placeholder="Enter Package Price">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div id='payTypeDiv'>
                                            <!-- <p class="fs-6 fw-bolder" style="color: var(--pure-black);">Pay Type</p> -->
                                            <label class="col-form-label">Pay Type<span class="text-danger">*</span></label>
                                            <div class="form-check form-check-inline ms-3">
                                                <input class="form-check-input" type="radio" name="payTypeSelect" id="payTypeSelect1" value="full" checked>
                                                <label class="form-check-label" for="payTypeSelect1" style="color: var(--pure-black);">Full</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payTypeSelect" id="payTypeSelect2" value="part">
                                                <label class="form-check-label" for="payTypeSelect2">Part</label>
                                            </div>
                                            <div id="toggleDiv" >
                                                <select class="form-select" id="partPayTypeSelect" aria-label="Default select example" disabled>
                                                    <option disabled selected value="--Select the Pay Type">--Select the Pay Type</option>
                                                    <option value="2">2 Parts</option>
                                                    <option value="3">3 Parts</option>
                                                </select>
                                            </div>
                                            <!-- <div class="py-3">
                                                <p class="fw-bolder fs-5 d-flex" style="color: var(--pure-black);">Amount:
                                                    <span><input class="form-control" type="text" id="amountInput" value="" aria-label="readonly input example" readonly></span>
                                                </p>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Payment ID<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="amountInput" placeholder="Enter Amount" value="" aria-label="readonly input example">
                                        </div>
                                    </div>
                                    <!-- for part payment -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-none" id="partPayDiv">

                                    </div>
                                    <div class="coupon_divs col-lg-6 col-md-6 col-sm-6 col-12 d-none">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Available Coupons</label>
                                            <select id="coupons" class="form-select" multiple>
                                                <option selected value="">--Select Coupon--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="coupon_divs col-lg-6 col-md-6 col-sm-6 col-12 d-none">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Coupon Amount</label>
                                            <input class="form-control" type="text" id="coupon_amount" placeholder="Enter Coupon Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">GST Amount<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="gst_amount" placeholder="Enter GST Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Total Amount<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="total_amount" placeholder="Enter Total Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center my-3">
                                        <button type="submit" class="btn btn-primary px-5 py-2" id="place_order">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once "../../footer.php" ?>
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
        <script src="../../assets/libs/jquery/jquery.min.js"></script>
        <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../../assets/libs/node-waves/waves.min.js"></script>
        <!-- Required datatable js -->
        <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
      
        <!-- App js -->
        <script src="../../assets/js/app.js"></script>
        <!-- file upload code js file -->
	    <script src="../../../uploading/upload.js"></script>
        <script src="../../resources/orders/place_order_custom.js"></script>
        <script src="../../resources/common_resources/top_function.js"></script>
    </body>
</html>