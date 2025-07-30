<?php
include_once 'dashboard_user_details.php';

// $id = $_GET['vkvbvjfgfikix'] ?? '';
// $taId = $_GET['taId'] ?? '';
// $country_id = $_GET['ncy'] ?? '';
// $state_id = $_GET['mst'] ?? '';
// $city_id = $_GET['hct'] ?? '';
// $editfor = $_GET['editfor'] ?? '';

// if($editfor == 'addreff'){
//     $stmt1 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$id."' ");
//     $stmt1 -> execute();
//     $cu_name = $stmt1 -> fetch();
//     $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];
// }
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
    <link href="assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <style>
        .message {
            color: gray;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
            /* Hide the message by default */
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once 'header.php'; ?>

        <!-- removeNotificationModal -->
        <!-- ========== App Menu ========== -->

        <?php include_once 'sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div id="testpho"></div>
            <div id="testemails"></div>

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-12"> <!-- Page title -->
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Add TopUp Balance</h4>
                                </div>
                            </div> <!-- page title end -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="h-100">
                                        <form>
                                            <div class="row g-3">

                                                <?php if ($userType == '11') { ?>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                                            <label for="user_id_name">TA Reference ID</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $userFname . ' ' . $userLname; ?>" readonly>
                                                            <label for="reference_name">TA Reference Name</label>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control" id="ta_amt" placeholder="Enter your firstname">
                                                        <label for="ta_amt">Top Up amount</label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12" id="paymentMode">
                                                        <p>Payment Mode</p>
                                                        <input type="radio" id="cashPayment" class="form-check-input payment" name="payment" value="cash">
                                                        <label for="cashPayment">Cash</label>
                                                        <input type="radio" id="chequePayment" class="form-check-input payment ms-2" name="payment" value="cheque" onclick="resetChequeInput()">
                                                        <label for="chequePayment">Cheque</label>
                                                        <input type="radio" id="onlinePayment" class="form-check-input payment ms-2" name="payment" value="online" onclick="resetChequeInput()">
                                                        <label for="onlinePayment">UPI/NEFT</label>
                                                    </div>
                                                </div>
                                                <div class="d-none" id="chequeOpt">
                                                    <div class="row d-flex justify-content-center align-itmes-center">
                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-2">
                                                                <input type="text" class="form-control required" id="chequeNo" placeholder="Enter Cheque Number">
                                                                <label for="chequeNo">Cheque No</label>
                                                            </div>
                                                            <div id="chequeMes" class="message">Enter 6-10 numeric digits only</div>
                                                        </div>

                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-2">
                                                                <input type="text" class="form-control" id="chequeDate" placeholder="yyyy-mm-dd">
                                                                <label for="chequeDate">Cheque Date</label>
                                                            </div>
                                                            <div id="specificMessage" class="message">Please enter the date in yyyy-mm-dd format.</div>

                                                        </div>

                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-2">
                                                                <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                                <label for="bankName">Bank Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- check reseting part -->
                                                </div>
                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt" style="display:flex; justify-content: space-evenly;">
                                                    <div class="col-md-8">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                            <label for="transactionNo">Transaction No.</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-8 d-none" id="cheque_upl">
                                                    <div class="mb-8">
                                                        <label for="file1"><b>Payment Image</b></label><br />
                                                        <input type="file" name="upload_cheque" id="upload_cheque">
                                                    </div>
                                                    <div id="feedbackcheque" class="error"></div>
                                                    <input type="hidden" id="previewcheque2" value="">
                                                    <div id="previewcheque" style="display: none;">
                                                        <div id="previewcheque3">
                                                            <img alt="Preview" id="previewcheque1" style="width: 200px; height: 150px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="testValue" name="testValue" value="10"> <!-- customer -->
                                                <input type="hidden" id="register_by" name="register_by" value="<?php echo $userType; ?>"> <!-- User type for table col register_by -->

                                                <div class="col-lg-12">
                                                    <div class="text-start">
                                                        <button type="submit" class="btn btn-primary" id="add-ta-topup">Submit</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
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

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
    <!-- <script src="assets/js/plugins.js"></script> -->

    <script src="assets/js/submitdata.js"></script>

    <!-- file upload code js file -->
    <script src="../uploading/uploadUser.js"></script>

    <!-- !-- materialdesign icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="../uploading/upload.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script>
        //reset file input
        function resetChequeInput() {
            // Reset file input
            const fileInput = document.getElementById('upload_cheque');
            fileInput.value = ""; // Clear the file input

            // Reset hidden input
            document.getElementById('previewcheque2').value = "";

            // Hide the preview div and remove the image source
            const previewDiv = document.getElementById('previewcheque');
            const previewImg = document.getElementById('previewcheque1');
            previewDiv.style.display = "none";
            previewImg.src = "";
        }
        // Select the input and feedback elements
        const chequeNumberInput = document.getElementById("chequeNo");
        const feedback = document.getElementById("chequeMes");

        // Validation function for the cheque number
        function isValidChequeNumber(chequeNumber) {
            const regex = /^\d{6,10}$/; // Match 6 to 10 digits
            return regex.test(chequeNumber);
        }

        // Add an event listener for dynamic validation
        chequeNumberInput.addEventListener("blur", function() {

            const chequeNumber = chequeNumberInput.value;

            if (!isValidChequeNumber(chequeNumber)) {
                feedback.style.display = "block"; // Show the message
                feedback.className = "message error"; // Apply error styling
            } else {
                feedback.style.display = "none"; // Hide the message
            }
        });


        //for valid cheque date
        // Target the specific input and message
        const specificInput = document.getElementById("chequeDate");
        const specificMessage = document.getElementById("specificMessage");
        // Show message only for this input on focus
        specificInput.addEventListener("focus", () => {
            specificMessage.style.display = "block"; // Show the message
        });

        // Hide message on blur
        specificInput.addEventListener("blur", () => {
            specificMessage.style.display = "none"; // Hide the message
        });
        document.getElementById("chequeDate").addEventListener("input", function(e) {
            const value = e.target.value;

            // Allow only digits and hyphens, and restrict length
            e.target.value = value
                .replace(/[^0-9\-]/g, '') // Remove invalid characters
                .slice(0, 10); // Restrict to 10 characters

            // Optional: Automatically insert hyphens
            if (/^\d{4}$/.test(value)) {
                e.target.value = value + "-";
            } else if (/^\d{4}-\d{2}$/.test(value)) {
                e.target.value = value + "-";
            }
        });
        // fetch User based on selected designation
        $('#paymentMode').on('click', function() {
            var paymentMode = $(".payment:checked").val();
            // console.log(paymentMode);
            if (paymentMode == "cheque") {
                $("#chequeOpt").removeClass("d-none");
                $('#cheque_upl').removeClass("d-none");
                $("#onlineOpt").addClass("d-none");
                $('#cheque_upl').find('input[type="file"]').val('');

                //check validation
                function isValidChequeNumber(chequeNumber) {
                    // Ensure the cheque number is a string of digits only
                    const isNumeric = /^\d+$/.test(chequeNumber);

                    // Ensure the length of the cheque number is between 6 and 10 digits
                    const lengthIsValid = chequeNumber.length >= 6 && chequeNumber.length <= 10;

                    return isNumeric && lengthIsValid;
                }
                //reseting
                $('#transactionNo').val('');
                $('#previewcheque2').val('');
            } else if (paymentMode == "online") {
                $("#onlineOpt").removeClass("d-none");
                $("#chequeOpt").addClass("d-none");
                $('#cheque_upl').removeClass("d-none");
                $('#cheque_upl').find('input[type="file"]').val('');
                //reseting
                $('#bankName').val('')
                $('#chequeDate').val('')
                $('#chequeNo').val('')
                $('#previewcheque2').val('');

            } else if (paymentMode == "cash") {
                console.log('hi');

                $("#chequeOpt").addClass("d-none");
                $("#onlineOpt").addClass("d-none");
                $('#cheque_upl').removeClass("d-none");
                $('#cheque_upl').find('input[type="file"]').val('');
                //reseting
                $('#bankName').val('')
                $('#chequeDate').val('')
                $('#chequeNo').val('')
                $('#previewcheque2').val('');
                $('#transactionNo').val('');
            }
        });
    </script>
</body>

</html>