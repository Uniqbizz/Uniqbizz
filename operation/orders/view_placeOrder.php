<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}
$date = date('Y'); 

$id = $_GET['id'];

require '../connect.php';

// Get Booking Data
$bookings = $conn->prepare("SELECT * FROM bookings WHERE id = :id");
$bookings->bindParam(':id', $id, PDO::PARAM_INT);
$bookings->execute();
$booking = $bookings->fetch(PDO::FETCH_ASSOC); // ✅ Use fetch(), not fetchAll()

if (!$booking) {
    die("Booking not found!"); // Handle case where no booking is found
}

// Get Customer
$customers = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = :ca_customer_id");
$customers->execute([':ca_customer_id' => $booking['customer_id']]);
$customer = $customers->fetch(PDO::FETCH_ASSOC);

// Get Booking Members
$members = $conn->prepare("SELECT * FROM booking_member_details WHERE bookings_id = :bookings_id");
$members->execute([':bookings_id' => $booking['id']]);
$member = $members->fetchAll(PDO::FETCH_ASSOC);


// Format Dates
$booked_on = date('d-M-Y', strtotime($booking['created_date']));
$tour_on = date('d-M-Y', strtotime($booking['date']));


// Get Package
$packages = $conn->prepare("SELECT * FROM package WHERE id = :package_id");
$packages->execute([':package_id' => $booking['package_id']]);
$package = $packages->fetch(PDO::FETCH_ASSOC);

// Get Package Pictures (Only 1 Picture)
// $package_pictures = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = :package_id ORDER BY id ASC LIMIT 1");
// $package_pictures->execute([':package_id' => $booking['package_id']]);
// $pictures = $package_pictures->fetchAll(PDO::FETCH_ASSOC);

// Get GST Bill
$price_gst = $conn->prepare("SELECT * FROM booking_gst_bill WHERE bookings_id = :bookings_id");
$price_gst->execute([':bookings_id' => $booking['id']]);
$total_gst = $price_gst->fetch(PDO::FETCH_ASSOC);

// Get Direct Bill
$price_direct = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = :bookings_id");
$price_direct->execute([':bookings_id' => $booking['id']]);
$total_direct = $price_direct->fetch(PDO::FETCH_ASSOC);


// Get all direct payment records
$direct_customer_booking = $conn->prepare("SELECT * FROM direct_customer_booking WHERE booking_id = :booking_id ORDER BY created_date ASC");
$direct_customer_booking->execute([':booking_id' => $booking['id']]);
$total_direct_cust = $direct_customer_booking->fetchAll(PDO::FETCH_ASSOC); // FIXED: fetchAll

$pay_type = (int)($total_direct['pay_type'] ?? 0);
$partPayData = [];

if ($pay_type === 1) {
    // Full Payment
    $partPayData[] = [
        'part' => 1,
        'amount' => (float)($total_direct['full_pay_amount'] ?? $total_direct['total_amount'] ?? 0),
        'status' => 1,
        'payment_id' => $total_direct_cust[0]['payment_id'] ?? '',
        'created_date' => $total_direct_cust[0]['created_date'] ?? '',
        'payment_mode' => $total_direct_cust[0]['payment_mode']
    ];
} else {
    $paymentIndex = 0;

    for ($i = 1; $i <= 3; $i++) {
        $status = (int)($total_direct["part_pay_{$i}_status"] ?? 0);
        $amount = (float)($total_direct["part_pay_{$i}"] ?? 0);

        $paymentRow = null;
        if ($status === 1 && isset($total_direct_cust[$paymentIndex])) {
            $paymentRow = $total_direct_cust[$paymentIndex];
            $paymentIndex++;
        }

        $partPayData[] = [
            'part' => $i,
            'amount' => $amount,
            'status' => $status,
            'payment_id' => $paymentRow['payment_id'] ?? '',
            'created_date' => $paymentRow['created_date'] ?? '',
            'payment_mode' => $paymentRow['payment_mode'] ?? ''
            
        ];
    }
}

//print_r($partPayData);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Place Order</title>
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
        <!-- Date Range Picker CSS End -->
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';


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
                                                    $stmt2 = $conn->prepare("SELECT * FROM ca_customer WHERE status='1'");
                                                    $stmt2->execute();
                                                    $cuS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                    $result = '';

                                                    foreach ($cuS as $cuVal) {
                                                        $selected = ($cuVal["ca_customer_id"] == $customer["ca_customer_id"]) ? ' selected' : '';
                                                        $result .= '<option value="' . $cuVal["ca_customer_id"] . '"' . $selected . '>'
                                                                . $cuVal["firstname"] . ' ' . $cuVal["lastname"] . ' (' . $cuVal["ca_customer_id"] . ')</option>';
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
                                                    <input type="number" class="form-control fs-6 w-100" name="b_no_adult" id="b_no_adult" value="<?=$booking['adults']??0?>" placeholder="Adults (12+ Yrs)" min="1" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 col-12">
                                                <div class="input-box mb-1">
                                                    <input type="number" class="form-control fs-6" name="b_no_child" id="b_no_child" value="<?=$booking['children']??0?>" placeholder="Children (3-11 Yrs)" min="0" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 col-12">
                                                <div class="input-box mb-1">
                                                    <input type="number" class="form-control fs-6" name="b_no_infants" id="b_no_infants" placeholder="Infants (Under 2 Yrs)" value="<?=$booking['infants']??0?>" min="0" max="99" oninput="memberLimit()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- readymade packages -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Package<span class="text-danger">*</span></label>
                                            <select id="packageList" class="form-select">
                                                <option disabled>--Select Package--</option>
                                                <?php
                                                    $stmt2 = $conn->prepare("SELECT * FROM package WHERE status='1'");
                                                    $stmt2->execute();
                                                    $pcS = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                    $result = '';

                                                    foreach ($pcS as $pcVal) {
                                                        $selected = ($pcVal["id"] == $booking['package_id']) ? 'selected' : '';
                                                        $result .= '<option value="' . $pcVal["id"] . '" ' . $selected . '>' . 
                                                                    $pcVal["name"] . ' (' . $pcVal["unique_code"] . ')' . 
                                                                '</option>';
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
                                                            <img src="../../uploading/packages/Amritsar-Dalhousie-Dharamshala1725538644-1.jpg" class="d-block w-100" height="400px" alt="...">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="../../uploading/packages/Andhra-Pradesh-Z1646117736-1.jpg" class="d-block w-100" height="400px" alt="...">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img src="../../uploading/packages/Bangalore-Mysore1725535571-1.jpg" class="d-block w-100" height="400px" alt="...">
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
                                        <div id="members_details">
                                            <?php
                                                $index = 1;
                                                foreach ($member as $m) {
                                                    $label = ($m['age'] >= 12) ? "Adult $index" : (($m['age'] >= 3) ? "Child $index" : "Infant $index");
                                                    $ageNote = ($m['age'] >= 12) ? '12 and above' : (($m['age'] >= 3) ? '3 - 11' : 'Below 3');
                                                    $minAge = ($m['age'] >= 12) ? 12 : (($m['age'] >= 3) ? 3 : 0);
                                                    $maxAge = ($m['age'] >= 12) ? 100 : (($m['age'] >= 3) ? 11 : 2);
                                                ?>
                                            <div class="member-block prefilled-member row">
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="input-block mb-2">
                                                        <label class="col-form-label"><?= $label ?> Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="member_name[]" value="<?= htmlspecialchars($m['name']) ?>" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="input-block mb-2">
                                                        <label class="col-form-label"><?= $label ?> Age <span class="text-danger">*</span> <small class="text-muted">(<?= $ageNote ?>)</small></label>
                                                        <input type="number" class="form-control" name="member_age[]" value="<?= htmlspecialchars($m['age']) ?>" min="<?= $minAge ?>" max="<?= $maxAge ?>" placeholder="Age">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="input-block mb-2">
                                                        <div class="d-flex justify-content-between pb-0">
                                                            <label class="col-form-label"><?= $label ?> Gender <span class="text-danger">*</span></label>
                                                            <span class="p-0"><button type="button" class="btn btn-sm btn-danger remove-member-btn" title="Remove Member">&times;</button></span>
                                                        </div>
                                                        <select name="member_gender[]" class="form-select">
                                                            <option disabled>--Select Gender--</option>
                                                            <option value="male" <?= $m['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                                                            <option value="female" <?= $m['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                                                            <option value="others" <?= $m['gender'] == 'others' ? 'selected' : '' ?>>Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-lg-1 col-md-1 col-sm-1 col-1 text-end mt-4 pt-3">
                                                    <button type="button" class="btn btn-sm btn-danger remove-member-btn" title="Remove Member">&times;</button>
                                                </div> -->
                                            </div>
                                                <?php
                                                    $index++;
                                                }
                                                ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Travel Date <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" id="travel_date" value="<?= date('Y-m-d', strtotime($booking['date'])) ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2"> 
                                            <label class="col-form-label" for="apackage_price ">
                                                Adult Price/pax
                                            </label>
                                            <input type="text" class="form-control " id="apackage_price" placeholder="Adult Package Price" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class=" input-block mb-2">
                                            <label class="col-form-label" for="cpackage_price ">
                                                Child Price/pax
                                            </label>
                                            <input type="text" class="form-control " id="cpackage_price" placeholder="Child Package Price" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" id="gst" value=""/>
                                                                        
                                    <!-- part type -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div id='payTypeDiv'>
                                            <!-- <p class="fs-6 fw-bolder" style="color: var(--pure-black);">Pay Type</p> -->
                                            <label class="col-form-label">Pay Type<span class="text-danger">*</span></label>
                                            <div class="form-check form-check-inline ms-3">
                                                <input class="form-check-input" type="radio" name="payTypeSelect" id="payTypeSelect1" value="full" <?=$total_direct['pay_type']==1?'checked disabled':'disabled'?>>
                                                <label class="form-check-label" for="payTypeSelect1" style="color: var(--pure-black);">Full</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payTypeSelect" id="payTypeSelect2" value="part" <?=$total_direct['pay_type']!=1?'checked disabled':'disabled'?>>
                                                <label class="form-check-label" for="payTypeSelect2">Part</label>
                                            </div>
                                            <div id="toggleDiv" >
                                                <select class="form-select" id="partPayTypeSelect" aria-label="Default select example" disabled>
                                                    <option value="--Select the Pay Type">--Select the Pay Type</option>
                                                    <option value="2" <?=$total_direct['pay_type']==2?'selected':''?>>2 Parts</option>
                                                    <option value="3" <?=$total_direct['pay_type']==3?'selected':''?>>3 Parts</option>
                                                </select>
                                            </div>
                                            <!-- <div class="py-3">
                                                <p class="fw-bolder fs-5 d-flex" style="color: var(--pure-black);">Amount:
                                                    <span><input class="form-control" type="text" id="amountInput" value="" aria-label="readonly input example" readonly></span>
                                                </p>
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- without deduction amount -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Payable Amount<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="payable_amount" placeholder="Enter Amount" value="0" readonly aria-label="readonly input example">
                                        </div>
                                    </div>
                                    <!-- paid amount -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Paid Amount<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="amountInput" placeholder="Enter Amount" value="0" readonly aria-label="readonly input example">
                                        </div>
                                    </div>

                                    
                                    
                                    <!-- for part payment -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-none mt-2" id="partPayDiv">

                                    </div>
                                    <div class="coupon_divs col-lg-6 col-md-6 col-sm-6 col-12 d-none">
                                        <div class="input-block mb-2">
                                            <label class="col-form-label">Available Coupons</label>
                                            <select id="coupons" class="form-select" multiple>
                                                <option value='' selected>--Select Coupon--</option>
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
      
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <!-- file upload code js file -->
	    <script src="../../uploading/upload.js"></script>
        <script>
            let payable_amount=0;
            var totalMembers=0
            var adults = 0;
            var children = 0;
            var infants = 0;

            const partPayData = <?= json_encode($partPayData) ?>;

            function truncateToTwoDecimals(num) {
                return Math.floor(num * 100) / 100;
            }
            //on load
            $(document).ready(function () {
                $('#coupons').removeAttr('multiple');
                $('#coupons').val(null);
                $('#coupon_amount').val('');
                $('#coupons').css('min-height', ''); // Remove min-height
            });
            //age limit
            function memberLimit() {
                var noOfAdults = document.getElementById("b_no_adult").value.trim();
                noOfAdults = parseInt(noOfAdults); 
                var noOfChild = document.getElementById("b_no_child").value.trim();
                noOfChild = parseInt(noOfChild); 
                var noOfInfants = document.getElementById("b_no_infants").value.trim();
                noOfInfants = parseInt(noOfInfants); 
                totalMembers=noOfAdults+noOfChild+noOfInfants

                if (noOfAdults || noOfChild || noOfInfants) {
                   if (noOfAdults > 99) {
                        alert("Adults cannot be more then 99")
                        document.getElementById("b_no_adult").value=""
                    } 
                   if (noOfChild > 99) {
                        alert("Children cannot be more then 99")
                        document.getElementById("b_no_child").value=""
                    } 
                   if (noOfInfants > 99) {
                        alert("Infants cannot be more then 99")
                        document.getElementById("b_no_infants").value=""
                    } 
                }
            }
            //min adult validation
            // $('#b_no_adult').on('change', function () {
            //     let val = parseInt($(this).val()) || 0;
                
            //     if (val > 1) {
            //         $('#coupons').attr('multiple', true);
            //         $('#coupons').css('min-height', '80px'); // Apply min-height
            //     } else {
            //         $('#coupons').removeAttr('multiple');
            //         $('#coupons').val(null); // Reset selection
            //         $('#coupon_amount').val('');
            //         $('#coupons').css('min-height', ''); // Remove min-height
            //     }
            // });
            //onchange 
            $('#b_no_adult, #b_no_child, #b_no_infants').on('input', function () {
                adults = parseInt($('#b_no_adult').val()) || 1;
                children = parseInt($('#b_no_child').val()) || 0;
                infants = parseInt($('#b_no_infants').val()) || 0;

                var container = $('#members_details');
                // Remove only blocks not marked as prefilled
                container.find('.member-block:not(.prefilled-member)').remove();

                // Count how many members are already loaded
                let existingCount = container.find('.prefilled-member').length;

                // Generate new member blocks if more are needed
                function createMemberBlock(label, ageNote, minAge, maxAge) {
                    return `
                        <div class="member-block row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="input-block mb-2">
                                    <label class="col-form-label">${label} Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="member_name[]" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="input-block mb-2">
                                    <label class="col-form-label">${label} Age <span class="text-danger">*</span> <small class="text-muted">(${ageNote})</small></label>
                                    <input type="number" class="form-control" name="member_age[]" min="${minAge}" max="${maxAge}" placeholder="Age">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="input-block mb-2">
                                    <label class="col-form-label">${label} Gender <span class="text-danger">*</span></label>
                                    <select name="member_gender[]" class="form-select">
                                        <option disabled selected>--Select Gender--</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-2 text-end">
                                <button type="button" class="btn btn-sm btn-danger remove-member-btn" title="Remove Member">&times;</button>
                            </div>
                        </div>`;
                }

                // Add extra adults
                for (let i = existingCount + 1; i <= adults; i++) {
                    container.append(createMemberBlock(`Adult ${i}`, '12 and above', 12, 100));
                }

                // Add children
                for (let i = 1; i <= children; i++) {
                    container.append(createMemberBlock(`Child ${i}`, '3 - 11', 3, 11));
                }

                // Add infants
                for (let i = 1; i <= infants; i++) {
                    container.append(createMemberBlock(`Infant ${i}`, 'Below 3', 0, 2));
                }
                var aprice=truncateToTwoDecimals(parseFloat($('#apackage_price').val())) || 0
                var cprice=truncateToTwoDecimals(parseFloat($('#cpackage_price').val())) || 0
                $('#apackage_price').val()
                payable_amount=parseFloat((aprice*adults)+(cprice*children));
                payable_amount=truncateToTwoDecimals(payable_amount);
                // console.log('payable_amount:'+payable_amount);
                // console.log('a:'+adults);
                // console.log('c:'+children);
                // console.log('i:'+infants);
                
                $('#payable_amount').val(payable_amount);
                let gst=$('#gst').val();
                let gstAmt=0;
                if (gst>0) {
                    gstAmt=(aprice*gst/100)+(cprice*gst/100);
                    gstAmt=truncateToTwoDecimals(gstAmt);
                }
                $('#gst_amount').val(gstAmt);
                $('#total_amount').val(payable_amount);
                let cAmt=$('#coupon_amount').val();
                let totalAmt=$('#total_amount').val();
                totalAmt=totalAmt-cAmt;
                totalAmt=truncateToTwoDecimals(totalAmt);
                $('#total_amount').val(totalAmt);
                //$('#amountInput').val(payable_amount);

            });
            //age validation
            $(document).on('input', '.member-age', function () {
                const age = parseInt($(this).val()) || 0;
                const minAge = parseInt($(this).data('min'));
                const maxAge = parseInt($(this).data('max'));

                if (age < minAge || age > maxAge) {
                    const label = $(this).closest('.row').find('.col-form-label').first().text().split(' ')[0]; // e.g., "Adult", "Child"
                    alert(`${label} age must be between ${minAge} and ${maxAge} years.`);
                    $(this).val(''); // Reset the invalid age
                }
            });
            //tour date valiadtions
            document.addEventListener("DOMContentLoaded", function () {
                const travelInput = document.getElementById('travel_date');
                const today = new Date();
                today.setDate(today.getDate() + 2); // Add 2 days

                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const minDate = `${year}-${month}-${day}`;

                travelInput.setAttribute('min', minDate);
            });
            //package details
            $('#packageList').on('input', function () {
                let packageId = $(this).val();
                adults = parseInt($('#b_no_adult').val()) || 0;
                children = parseInt($('#b_no_child').val()) || 0;
                $.ajax({
                    type: 'POST',
                    url: 'get_package_details.php',
                    data: { package_id: packageId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            // Set package price
                            $('#apackage_price').val(truncateToTwoDecimals(parseFloat(response.aprice)));
                            $('#cpackage_price').val(truncateToTwoDecimals(parseFloat(response.cprice)));
                            let aprice=$('#apackage_price').val();
                            let cprice=$('#cpackage_price').val();
                            $('#gst').val(response.gst);
                            payable_amount=parseFloat((response.aprice*adults)+(response.cprice*children));
                            payable_amount=truncateToTwoDecimals(payable_amount);
                            
                            $('#payable_amount').val(payable_amount);
                            let gst=$('#gst').val();
                            let gstAmt=0;
                            if (gst>0) {
                                gstAmt=(aprice*gst/100)+(cprice*gst/100);
                                gstAmt=truncateToTwoDecimals(gstAmt);
                            }
                            $('#gst_amount').val(gstAmt);
                            $('#total_amount').val(payable_amount);
                            let cAmt=$('#coupon_amount').val();
                            let totalAmt=$('#total_amount').val();
                            totalAmt=totalAmt-cAmt;
                            totalAmt=truncateToTwoDecimals(totalAmt);
                            $('#total_amount').val(totalAmt);
                            //$('#amountInput').val(payable_amount)

                            // Rebuild carousel items
                            let carouselInner = $('.carousel-inner');
                            let indicatorsHtml = '';
                            let imagesHtml = '';

                            response.images.forEach((img, index) => {
                                imagesHtml += `
                                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                        <img src="${img}" class="d-block w-100" height="400px" alt="Package Image ${index + 1}">
                                    </div>`;
                            });

                            carouselInner.html(imagesHtml);
                        } else {
                            alert('Failed to load package details.');
                        }
                    },
                    error: function () {
                        alert('Error retrieving package details.');
                    }
                });
            });
            //payment 
            
            $('input[name="payTypeSelect"]').on('change', function () {
                let selectedValue = $(this).val(); // 'full' or 'part'
                let payableAmount=truncateToTwoDecimals(parseFloat($('#payable_amount').val()));
                if (selectedValue === 'full') {
                    $('#partPayTypeSelect').val('--Select the Pay Type');
                    $('#partPayTypeSelect').prop('disabled', true);  // Hide and disable
                    //$('#amountInput').val(payableAmount);
                    $('#partPayDiv').addClass('d-none');

                } else if (selectedValue === 'part') {
                    $('#partPayTypeSelect').prop('disabled', false); // Show and enable
                    //$('#partPayDiv').removeClass('d-none');
                }
            });
            //onload
            $(document).ready(function () {
                // If there's a selected customer, trigger the change manually
                const selectedCustomerId = $('#customerId').val();
                if (selectedCustomerId) {
                    $('#customerId').trigger('input');
                }
                const seletedPackageId = $('#packageList').val();
                if (seletedPackageId){
                    $('#packageList').trigger('input');
                }

                // Set default value if needed
                const defaultPayType = $('#partPayTypeSelect').val();
                if (defaultPayType !== '2' && defaultPayType !== '3') {
                    $('#partPayTypeSelect').val('2'); // or '3' depending on your logic
                }

                $('#partPayTypeSelect').prop('disabled', false); // enable

                updatePayableAmountField(); // if this function is defined

                $('#partPayTypeSelect').trigger('change'); // trigger manually

                $('#partPayTypeSelect').prop('disabled', true); // disable again
                
            });

            $(document).on('click', '.remove-member-btn', function () {
                $(this).closest('.member-block').remove();

                // Recalculate counts
                let adults = 0, children = 0, infants = 0;

                $('.member-block').each(function () {
                    let ageInput = $(this).find('input[name="member_age[]"]');
                    let age = parseInt(ageInput.val());

                    if (!isNaN(age)) {
                        if (age >= 12) adults++;
                        else if (age >= 3) children++;
                        else infants++;
                    }
                });

                $('#b_no_adult').val(adults);
                $('#b_no_child').val(children);
                $('#b_no_infants').val(infants);

                $('#b_no_adult, #b_no_child, #b_no_infants').trigger('input'); // trigger recalculation if needed
            });


            //on change customer id
            $('#customerId').on('input', function () {
                var custId = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'get_customer_details.php',
                    data: { user_id: custId },
                    dataType: 'json',
                    success(response) {
                        if (response.status === 'success') {
                            $('#customer_name').val(response.custName);
                            $('#email').val(response.custEmail);
                            $('#phone_no').val(response.custPhone);
                            $('#customer_age').val(response.custAge);
                            $('#customer_gender').val(response.custGender);

                            // Populate first adult block
                            $('#first_adult_name').val(response.custName);
                            $('#first_adult_age').val(response.custAge);
                            $('#first_adult_gender').val(response.custGender);

                            // Clear previous coupon options
                            $('#coupons').empty().append('<option selected>--Select Coupon--</option>');

                            // Make sure coupons exist
                            if (response.couponCodes.length > 0) {
                                // Create a map of code → amount
                                window.couponMap = {};

                                for (let i = 0; i < response.couponCodes.length; i++) {
                                    let code = response.couponCodes[i];
                                    let amount = response.couponAmts[i];
                                    window.couponMap[code] = amount;

                                    // Format: CODE (Rs. AMOUNT)
                                    $('#coupons').append(
                                        `<option value="${code}">${code} (Rs. ${amount})</option>`
                                    );
                                }

                                $('.coupon_divs').removeClass('d-none');
                            } else {
                                // No coupons: reset and hide amount
                                $('#coupons').empty().append('<option value="" selected>--No Coupons--</option>');
                                $('#coupon_amount').val('');
                                $('.coupon_divs').addClass('d-none');
                            }

                        } else {
                            alert('Customer not found.');
                        }
                    },
                    error() {
                        alert('Error retrieving customer details.');
                    }
                });
            });
            //const partPayData = <?= json_encode($partPayData) ?>;

            $('#partPayTypeSelect').on('change', function () {
                const paytype = parseInt($(this).val());
                const container = $('#partPayDiv');
                container.empty().addClass('d-none');

                if (paytype !== 2 && paytype !== 3) return;

                container.removeClass('d-none');
                let totalPaidAmount = 0;
                partPayData.forEach(part => {
                    const partNo = part.part;
                    const amount = parseFloat(part.amount) || 0;
                    const status = parseInt(part.status) || 0;
                    const mode = part.payment_mode || '';
                    const paymentId = part.payment_id || ''; // ✅ FIXED: correct key
                    const createdDate = (part.created_date || '').split(' ')[0]; // ✅ FIXED: correct key
                    const chequeNo = part.cheque_no || '';
                    const chequeDate = part.cheque_date || '';
                    const bankName = part.bank_name || '';
                    if (status === 1) {
                        totalPaidAmount += amount; // ✅ Add to total paid if marked Paid
                    }
                    $("#amountInput").val(totalPaidAmount)//update this based on how much is paid
                    if (amount === 0) return;
                    if (paytype === 2 && partNo > 2) return;

                    const disabledAttr = status === 1 ? 'disabled' : '';
                    const statusBadge = status === 1
                        ? '<span class="bg-success-subtle text-success-emphasis px-2 py-1 rounded">Paid</span>'
                        : '<span class="bg-warning-subtle text-warning-emphasis px-2 py-1 rounded">Pending</span>';

                    const isCheque = mode === 'cheque' ? '' : 'd-none';
                    const isOnline = mode === 'online' ? '' : 'd-none';

                    const block = `
                        <div class="card mb-3 shadow-sm border-success">
                            <div class="card-header text-dark fw-bold d-flex justify-content-between">
                                <span>Part ${partNo} Payment</span>
                                ${statusBadge}
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 py-1">
                                    <label class="col-form-label">Payment Mode <span class="text-danger">*</span></label>
                                    <div class="form-control d-flex justify-content-around" id="paymentMode_${partNo}">
                                        <label class="mb-0">
                                            <input type="radio" class="form-check-input me-2 payment" name="payment_mode_${partNo}" value="cash" ${mode === 'cash' ? 'checked' : ''} ${disabledAttr}>Cash
                                        </label>
                                        <label class="mb-0">
                                            <input type="radio" class="form-check-input me-2 payment" name="payment_mode_${partNo}" value="cheque" ${mode === 'cheque' ? 'checked' : ''} ${disabledAttr}>Cheque
                                        </label>
                                        <label class="mb-0">
                                            <input type="radio" class="form-check-input me-2 payment" name="payment_mode_${partNo}" value="online" ${mode === 'online' ? 'checked' : ''} ${disabledAttr}>UPI/NEFT
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 py-1">
                                    <label class="col-form-label">Paid Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="paid_amount[]" placeholder="Enter Paid Amount" value="${amount}" ${disabledAttr}>
                                </div>

                                <div class="col-md-6 py-1">
                                    <label class="col-form-label">Transaction ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="transaction_id[]" placeholder="Enter Transaction ID" value="${paymentId}" ${disabledAttr}>
                                </div>

                                <div class="col-md-6 py-1">
                                    <label class="col-form-label">Transaction Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="transaction_date[]" value="${createdDate}" ${disabledAttr}>
                                </div>

                                <!-- Cheque Fields -->
                                <div class="col-12">
                                    <div class="row mt-2 ${isCheque}" id="chequeOpt_${partNo}">
                                        <div class="col-md-4 py-1">
                                            <label class="col-form-label">Cheque No<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="cheque_no_${partNo}" value="${chequeNo}" ${disabledAttr}>
                                        </div>
                                        <div class="col-md-4 py-1">
                                            <label class="col-form-label">Cheque Date<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="cheque_date_${partNo}" value="${chequeDate}" ${disabledAttr}>
                                        </div>
                                        <div class="col-md-4 py-1">
                                            <label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="bank_name_${partNo}" value="${bankName}" ${disabledAttr}>
                                        </div>
                                    </div>
                                </div>

                                <!-- Online Fields -->
                                <div class="col-12">
                                    <div class="row mt-2 ${isOnline} d-flex justify-content-center" id="onlineOpt_${partNo}">
                                        <div class="col-md-8 py-1">
                                            <label class="col-form-label">Transaction No<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="upi_ref_id_${partNo}" value="${paymentId}" ${disabledAttr}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    container.append(block);
                });
            });






            //on coupon selection
            $('#coupons').on('change', function () {
                let selectedOptions = $('#coupons option:selected');

                // Limit to max 2 selected coupons
                if (selectedOptions.length > 2) {
                    alert("You can select a maximum of 2 coupons.");

                    // Deselect the last one
                    selectedOptions.last().prop('selected', false);

                    // Refresh selection to only the first 2
                    selectedOptions = $('#coupons option:selected');
                }

                // Update coupon amount field
                let couponAmt = updateCouponAmount(selectedOptions);

                // Get values from form
                let aprice = parseFloat($('#apackage_price').val()) || 0;
                let cprice = parseFloat($('#cpackage_price').val()) || 0;
                let adults = parseInt($('#b_no_adult').val()) || 0;
                let children = parseInt($('#b_no_child').val()) || 0;
                let gst = parseFloat($('#gst').val()) || 0;

                // Calculate payable amount
                let payable_amount = parseFloat((aprice * adults) + (cprice * children));
                payable_amount = truncateToTwoDecimals(payable_amount);
                $('#payable_amount').val(payable_amount);

                // GST calculation
                let gstAmt = 0;
                if (gst > 0) {
                    gstAmt = (aprice * gst / 100) + (cprice * gst / 100);
                    gstAmt = truncateToTwoDecimals(gstAmt);
                }
                $('#gst_amount').val(gstAmt);

                // Final total after coupon
                let totalAmt = payable_amount + gstAmt - couponAmt;
                totalAmt = truncateToTwoDecimals(totalAmt);
                $('#total_amount').val(totalAmt);
            });

            // Truncate and sum selected coupons
            function updateCouponAmount(selectedOptions) {
                let total = 0;

                selectedOptions.each(function () {
                    const text = $(this).text(); // e.g. "SAVE10 (Rs. 10.89)"
                    const match = text.match(/\(Rs\. ([\d.]+)\)/);
                    if (match && match[1]) {
                        total += parseFloat(match[1]);
                    }
                });

                let truncated = truncateToTwoDecimals(total);
                $('#coupon_amount').val(truncated);
                return truncated;
            }

           function validatePartPayments() {
                let isValid = true;

                $('[id^="paymentMode_"]').each(function () {
                    const partNo = this.id.split('_')[1];
                    const selected = $(`input[name="payment_mode_${partNo}"]:checked`).val();

                    if (!selected) {
                        alert(`Please select a payment mode for Part ${partNo}.`);
                        isValid = false;
                        return false; // break the loop
                    }
                });

                return isValid;
            }

            $('#place_order').on('click', function () {
                // Collect static form fields
                const id=<?=$id?>;
                const travelDate = $('#travel_date').val();
                const customerId = $('#customerId').val();
                const customerName = $('#customer_name').val();
                const amountInput = $('#amountInput').val();
                const partPayTypeSelect = $('#partPayTypeSelect').val();
                const payTypeSelect1 = $('#payTypeSelect1').val();
                const payTypeSelect2 = $('#payTypeSelect2').val();
                const payableAmount = $('#payable_amount').val();
                const payment = $('.payment:checked').val();
                let selected = $('#coupons').val() || [];

                if (!Array.isArray(selected)) {
                    selected = (selected === '--Select Coupon...') ? ['NA'] : [selected];
                } else if (selected.length === 0) {
                    selected = ['NA'];
                }

                const pay_type = partPayTypeSelect !== '' && partPayTypeSelect !== null ? 0 : 1;
                const part_type = partPayTypeSelect === '2' ? '2' : (partPayTypeSelect === '3' ? '3' : '');

                const formData = {
                    id:id,
                    date: travelDate,
                    customerId: customerId,
                    customer_name: customerName,
                    pay_type: pay_type,
                    part_type: part_type,
                    payment: payment,
                    email: $('#email').val(),
                    phone_no: $('#phone_no').val(),
                    adults: $('#b_no_adult').val(),
                    child: $('#b_no_child').val(),
                    infants: $('#b_no_infants').val(),
                    package_id: $('#packageList').val(),
                    apackage_price: $('#apackage_price').val(),
                    cpackage_price: $('#cpackage_price').val(),
                    gst: $('#gst').val(),
                    gst_amount: $('#gst_amount').val(),
                    payable_amount: payableAmount,
                    coupon_amount: $('#coupon_amount').val(),
                    total_amount: $('#total_amount').val(),
                    selected_coupons: selected,
                    chequeNo: $('#chequeNo').val(),
                    chequeDate: $('#chequeDate').val(),
                    bankName: $('#bankName').val(),
                    transactionNo: $('#transactionNo').val(),
                    members: []
                };

                // Member data
                $('.member-block').each(function () {
                    const name = $(this).find('[name="member_name[]"]').val();
                    const age = $(this).find('[name="member_age[]"]').val();
                    const gender = $(this).find('[name="member_gender[]"]').val();
                    if (name && age && gender) {
                        formData.members.push({ name, age, gender });
                    }
                });

                // Handle part payments
                const partPayments = [];

                // Update: Handle dynamically generated parts (e.g., payment_mode_1, transaction_id_1, etc.)
                $("[id^='paymentMode_']").each(function () {
                    const partIndex = this.id.split('_')[1];
                    const selectedMode = $(`input[name="payment_mode_${partIndex}"]:checked`).val();

                    const txnId = $(`input[name="transaction_id[]"]`).eq(partIndex - 1).val(); // <-- Always use this
                    let txnDate = '';

                    // Determine the correct date field
                    if (selectedMode === 'cheque') {
                        txnDate = $(`input[name="cheque_date_${partIndex}"]`).val();
                    } else {
                        txnDate = $(`input[name="transaction_date[]"]`).eq(partIndex - 1).val();
                    }

                    const isValid = txnId && txnDate;

                    const status = $(`#payable_amount_${partIndex}`).prop('disabled') ? 1 : 0;
                    const paidAmount = parseFloat($(`input[name='paid_amount[]']`).eq(partIndex - 1).val()) || 0;

                    if (isValid && !status) {
                        partPayments.push({
                            part: partIndex,
                            transaction_id: txnId,
                            transaction_date: txnDate,
                            paid_amount: paidAmount
                        });
                    }
                });


                formData.part_payments = partPayments;
                // Calculate payment_id and paid_amount
                // Ensure part payments are entered
                if (!validatePartPayments()) {
                    e.preventDefault();
                    return false;
                }
                if (partPayments.length === 0) {
                    alert("Please provide at least one part payment.");
                    return;
                }

                // Get the most recent transaction details
                const lastPart = partPayments[partPayments.length - 1];
                formData.payment_id = lastPart.transaction_id;
                formData.transactionDate1 = lastPart.transaction_date;

                // Calculate total paid amount from all parts
                let totalPaid = 0;
                partPayments.forEach(p => {
                    const amt = parseFloat(p.paid_amount);
                    if (!isNaN(amt)) {
                        totalPaid += amt;
                    }
                });

                formData.paid_amount = totalPaid;
                console.log("Sending Booking Data:", formData);

                // === Validations ===
                if (!formData.customerId) return alert('Please select customer ID');
                if (!formData.customer_name) return alert('Please enter customer name');
                if (!formData.email || !/^[\w.-]+@[\w.-]+\.\w+$/.test(formData.email)) return alert('Enter valid email');
                if (!formData.phone_no || !/^\d{10}$/.test(formData.phone_no)) return alert('Enter valid 10-digit phone number');
                if (!formData.package_id) return alert('Please select package');
                if (!formData.date) return alert('Please select travel date');
                if (!formData.payment) return alert('Please select payment mode');
                if (formData.payment === 'cheque' && (!formData.chequeNo || !formData.chequeDate || !formData.bankName)) return alert('Fill all cheque details');
                if (formData.payment === 'online' && !formData.transactionNo) return alert('Please enter transaction ID');
                if (!formData.payment_id) return alert('Please enter payment ID');
                if (!formData.paid_amount) return alert('Please enter paid amount');
                if (!formData.payable_amount) return alert('Please enter payable amount');
                if (!formData.apackage_price) return alert('Please enter adult package price');
                if (!formData.cpackage_price) return alert('Please enter child package price');
                if (!formData.total_amount) return alert('Please enter total amount');
                if (formData.members.length === 0 && !confirm("No members added. Continue?")) return;

                console.log("Sending Booking Data:", formData);

                

                // AJAX
                $.ajax({
                    url: 'edit_booking_details.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response == 1) {
                            alert('Order Updated successfully!');
                            window.location.href = 'order_history.php';
                        } else {
                            alert('Failed to place order!');
                        }
                    },
                    error: function () {
                        alert('Error sending request.');
                    }
                });
            });
            
        </script>
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

            //payment details
            $(document).on('change', '.payment', function () {
                const inputName = $(this).attr('name'); // e.g., payment_mode_1
                const partIndex = inputName.split('_')[2]; // Extract index like '1', '2'...

                const selectedMode = $(`input[name="payment_mode_${partIndex}"]:checked`).val();

                // Reset all
                $(`#chequeOpt_${partIndex}, #onlineOpt_${partIndex}`).addClass('d-none');
                $(`#chequeNo_${partIndex}, #chequeDate_${partIndex}, #bankName_${partIndex}, #transactionNo_${partIndex}`).val('');

                if (selectedMode === 'cheque') {
                    $(`#chequeOpt_${partIndex}`).removeClass('d-none');
                } else if (selectedMode === 'online') {
                    $(`#onlineOpt_${partIndex}`).removeClass('d-none');
                }
            });
            // $('#paymentMode').on('click', function() {
            //     var paymentMode = $(".payment:checked").val();
            //     // console.log(paymentMode);
            //     if (paymentMode == "cheque") {
            //         $("#chequeOpt").removeClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //         $("#transactionNo").val("");
            //     } else if (paymentMode == "online") {
            //         $("#onlineOpt").removeClass("d-none");
            //         $("#chequeOpt").addClass("d-none");
            //         $("#chequeNo").val("");
            //         $("#chequeDate").val("");
            //         $("#bankName").val("");
            //     } else {
            //         $("#chequeOpt").addClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //         $("#chequeNo").val("");
            //         $("#chequeDate").val("");
            //         $("#bankName").val("");
            //         $("#transactionNo").val("");
            //     }
            // });

            function updatePayableAmountField() {
                let remainingAmount = 0;

                if (partPayData.part_pay_1_status !== 1) {
                    remainingAmount += partPayData.part_pay_1 || 0;
                }
                if (partPayData.part_pay_2_status !== 1) {
                    remainingAmount += partPayData.part_pay_2 || 0;
                }
                if (partPayData.part_pay_3_status !== 1) {
                    remainingAmount += partPayData.part_pay_3 || 0;
                }

                // Truncate to 2 decimals
                remainingAmount = Math.round(remainingAmount * 100) / 100;

                $('#amountInput').val(remainingAmount.toFixed(2));
            }
        </script>
    </body>
</html>