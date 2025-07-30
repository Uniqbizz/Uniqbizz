<?php
session_start();

if(!isset($_SESSION['username'])){
    echo '<script>location.href = "../login.php";</script>';
}

$id = $_GET['vkvbvjfgfikix'];

require '../../connect.php';

// get data
$bookings = $conn->prepare("SELECT * FROM bookings where id='".$id."' AND status='1' ");
$bookings->execute();
$bookings->setFetchMode(PDO::FETCH_ASSOC);
$booking = $bookings->fetch();
    // get Customer
    $customers = $conn->prepare("SELECT * FROM customer WHERE cust_id='".$booking['customer_id']."' ");
    $customers->execute();
    $customers->setFetchMode(PDO::FETCH_ASSOC);
    $customer = $customers->fetch();

    $members = $conn->prepare("SELECT * FROM booking_member_details WHERE bookings_id='".$booking['id']."' ");
    $members->execute();
    $members->setFetchMode(PDO::FETCH_ASSOC);
    $member = $members->fetchAll();

    // booking date format
    $booking_date = new DateTime($booking['created_date']);
    $booked_on = $booking_date->format('d-M-Y'); 
    // Tour date format
    $tour_date = new DateTime($booking['date']);
    $tour_on = $tour_date->format('d-M-Y'); 
    // Status
    $pay_status = $booking['status'] == 0 ? 'Pending' : 'Successfull';

    // package
    $packages = $conn->prepare("SELECT * FROM package WHERE id='".$booking['package_id']."' ");
    $packages->execute();
    $packages->setFetchMode(PDO::FETCH_ASSOC);
    $package = $packages->fetch();        
    // pictures
    $package_pictures = $conn->prepare("SELECT * FROM package_pictures WHERE package_id='".$booking['package_id']."' ORDER BY id ASC LIMIT 1 ");
    $package_pictures->execute();
    $package_pictures->setFetchMode(PDO::FETCH_ASSOC);
    $pictures = $package_pictures->fetchAll();
    
    // GST bill
    $price_gst = $conn->prepare("SELECT * FROM booking_gst_bill WHERE bookings_id='".$booking['id']."' ");
    $price_gst->execute();
    $price_gst->setFetchMode(PDO::FETCH_ASSOC);
    $total_gst = $price_gst->fetch();
    // Direct bill
    $price_direct = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id='".$booking['id']."' ");
    $price_direct->execute();
    $price_direct->setFetchMode(PDO::FETCH_ASSOC);
    $total_direct = $price_direct->fetch();       

?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from rn53themes.net/themes/demo/travelz/admin/user-all.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Apr 2021 08:21:19 GMT -->
<head>
    <title>Bizzmirth Holidays</title>
    <!--== META TAGS ==-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--== FAV ICON ==-->
    <link rel="shortcut icon" href="../images/fav.ico">
    <!-- GOOGLE FONTS -->
    <link href="../../../../../fonts.googleapis.com/cssbcc5.css?family=Open+Sans:300,400,600|Quicksand:300,400,500" rel="stylesheet">
    <!-- FONT-AWESOME ICON CSS -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!--== ALL CSS FILES ==-->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mob.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/materialize.css" />

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="sb2-2">
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        
                        <div class="tab-inn">
                            <div class="container" id="htmlContent" style="width:650px">
                                <div class="col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 brandSection" style="background-color:#275267; border:1px solid #417482;">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 header" style="border-bottom: 2px solid #417482;padding: 10px;">
                                            <div class="col-md-3 col-sm-3 headerLeft">
                                                <h1 style="color:#fff; margin: 0px; font-size:28px;"><a href="#"><img class="logo1" style="height: 26px; margin-left: 0%; background-color: white;" src="../images/uniqbizz_logo.png" alt="" /></h1>
                                            </div>
                                            <div class="col-md-9 col-sm-9 headerRight">
                                                <p style="margin: 0px; font-size:10px; color:white; text-align: right;">www.uniqbizz.com</p>
                                                <p style="margin: 0px; font-size:10px; color:white; text-align: right;">support@uniqbizz.com</p>
                                                <p style="margin: 0px; font-size:10px; color:white; text-align: right;">0832 2438500 / 8080785714</p>
                                                <p style="margin: 0px; font-size:10px; color:white; text-align: right;">306 Ambrosia Corporate Park EDC Patto Plaza Panjim Goa 403001</p>
                                            </div>
                                        </div>
                                        
                                        <table class="col-md-12 col-sm-12" style="background-color:#fff; padding:20px 10px;">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-7 col-sm-7 left" style="background-color:#fff; padding:15px 20px;">
                                                        <h1 style="font-size:18px;margin:0px 0px 5px 0px;color: #275267;">Invoice No.<strong> <?php echo $booking['order_id'] ?></strong></h1>
                                                        <h1 style="font-size:18px;margin:0px 0px 5px 0px;color: #275267;">Payment <strong style="color:green"><?php echo $pay_status; ?></strong></h1>
                                                        <h4 style="font-size: 14px;color:#275267;margin:0px 0px 5px 0px;"> Transaction ID #<strong><?php echo $booking['payment_id'] ?></strong></h4>
                                                        <p style="margin:0px 0px 5px 0px; font-size: 14px; color:#473e3e; " class="textColor">Invoice Date <?php echo $booked_on ?></p style="background-color:#fff; padding:20px 10px;">
                                                    </td>
                                                    <td class="col-md-5 col-sm-5 right" style="background-color:#fff; padding:15px 20px;">
                                                        <h4 style="font-size: 20px;color:#275267;text-align: right;">₹ <strong> <?php echo number_format((float)$total_gst['total_net_payable'], 2, '.', '') ?></strong></h4>
                                                        <?php
                                                            if ( $booking['gst_status'] == "1" ){
                                                                echo '<p class="textColor" style="text-align: right; padding:5px 0px; color:#473e3e; ">GSTIN - '.$total_gst['gst_number'].'</p>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                            
                                        <div class="col-md-12 col-sm-12 tableSection" style="background-color: #fff;">
                                            <div class="col-md-12 col-sm-12" style="text-align: left; padding-right:5px; padding-left:5px; margin-bottom:20px">
                                                <table class="orderTable text-center" style="padding-bottom:5px; margin:0px; border:1px solid #DDDDDD;">
                                                    <thead>
                                                        <tr class="tableHead">
                                                            <th class="rowHeading" style="width:80px; text-align:center; background-color:#275267; color:#fff; padding: 5px 5px; border-radius: 0px; ">Destination</th>
                                                            <th class="rowHeading" style="width:80px; text-align:center; background-color:#275267; color:#fff; padding: 5px 5px; border-radius: 0px; " colspan="2">Customer Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="rowData textColor" style="color:#473e3e; ">
                                                            <td class="col-md-4 col-sm-4" style="height: 100%; padding:0px 5px 0px 5px">
                                                                <?php
                                                                foreach ( $pictures as $key => $picture) {  
                                                                    echo '<div class="preview-images-zone" style="height:150px; width:100%; position:relative; margin-right:1px; display:inline-flex;">
                                                                            <img src="../../'.$picture['image'].'" style="width: 200px; height: 100%; padding: 5px;object-fit:cover">
                                                                        </div>
                                                                        ';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="col-md-3 col-sm-3" style="padding:5px; text-align:left;">
                                                                <div style="padding:0px">
                                                                    <ul>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Order ID </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Customer ID </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Name </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Email </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Phone No. </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Package </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> Departure Date </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td class="col-md-4 col-sm-4" style="padding:5px; text-align:left;">
                                                                <div style="padding:0px">
                                                                    <ul>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> #<?php echo $booking['order_id']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo $customer['cust_id']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo $customer['firstname'].' '.$customer['lastname']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo $customer['email']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo '+'.$customer['country_code'].' '.$customer['contact_no']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo $package['name']; ?> </li>
                                                                        <li class="textColor" style="list-style: none; color:#473e3e; "> <?php echo $tour_on; ?> </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                                
                                        <div class="col-md-12 col-sm-12 tableSection" style="background-color: #fff;" >
                                            <h1 class="textColor" style="padding: 0px 5px; color:#473e3e; font-size:18px; margin:0px; ">Tour Members</h1>
                                            <div class="col-md-12 col-sm-12" style="text-align: left; padding-right:5px; padding-left:5px; margin-bottom:20px">
                                                <table class="orderTable text-center" style="padding-bottom:5px; margin:0px; border:1px solid #DDDDDD;">
                                                    <thead>
                                                        <tr class="tableHead">
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; width:80px; background-color: #275267;color:#fff;" class="rowHeading">Sr. No.</th>
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; background-color: #275267;color:#fff;" class="rowHeading">Name</th>
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; width:80px; background-color: #275267;color:#fff;" class="rowHeading">Gender</th>
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; width:80px; background-color: #275267;color:#fff;" class="rowHeading">AGE</th>
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; width:20px; background-color: #275267;color:#fff;" class="rowHeading"></th>
                                                            <th style="padding: 5px 5px; border-radius: 0px; text-align:center; width:120px; background-color: #275267;color:#fff;" class="rowHeading">Member Count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $count_mem = 1;
                                                            foreach ( $member as $key => $person) {
                                                                if ( $person['gender'] == 'male') {
                                                                    $gender = 'Male';
                                                                } else if ( $person['gender'] == 'female') {
                                                                    $gender = 'Female'; 
                                                                } else {
                                                                    $gender = 'Other';
                                                                }   
                                                                echo '<tr class="rowData textColor" style="color:#473e3e; ">
                                                                        <td style="height: 100%; padding:5px; text-align:center;">'.++$key.'</td>
                                                                        <td style="height: 100%; padding:5px;">'.$person['name'].'</td>
                                                                        <td style="height: 100%; padding:5px; text-align:center;">'.$gender.'</td>
                                                                        <td style="height: 100%; padding:5px; text-align:center;">'.$person['age'].'</td>
                                                                        <td style="height: 100%; padding:5px; text-align:center;"></td>
                                                                        <td rowspan="3" style="height: 100%; padding:0px; text-align:center; vertical-align: baseline;">';
                                                                            if ( $count_mem == 1 ) {
                                                                                if ( $booking['adults'] ) {
                                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                                    if ( $booking['adults'] > 1 ) {  echo 'Adults '; } else { echo 'Adult '; }
                                                                                    echo $booking['adults'].'</strong>';
                                                                                }
                                                                                if ( $booking['children'] ) {
                                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                                    if ( $booking['children'] > 1 ) {  echo 'Children '; } else { echo 'Child '; }
                                                                                    echo $booking['children'].'</strong>';
                                                                                }
                                                                                if ( $booking['infants'] ) {
                                                                                    echo '<strong class="count_value" style="font-size: 14px; display:block; padding: 5px;"> ';
                                                                                    if ( $booking['infants'] > 1 ) {  echo 'Infants '; } else { echo 'Infant '; }
                                                                                    echo $booking['infants'].'</strong>';
                                                                                }
                                                                                $count_mem = 0;
                                                                            }
                                                                echo '</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 lastSectionleft" style="background-color:#fff; padding:0px 20px 0px 20px;">
                                           <!--  <div class="row">
                                                <div class="col-md-7 col-sm-6 Sectionleft">
                                                    <p><i>Special Notes</i></p>
                                                    <span><i>Lorem ipsum dolor sit amet,ipsum dolor.</i> </span>
                                                </div>
                                                <div class="col-md-5 col-sm-6"> -->
                                                    <div class="panel panel-default">
                                                        <div class="panel-body lastPanel" style="background-color: #275267; color:#fff; padding: 5px; text-align:center;">AMOUNT</div>
                                                            <div class="panel-footer lastFooter" style="background-color:#fff;">
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-7 col-xs-7 panelLastLeft">
                                                                        <?php 
                                                                            echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Price</p>';
                                                                            if ( $booking['coupons_id'] != "0" ) {
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Discount</p>';
                                                                                echo '<hr style="margin: 0px 0px 10px 0px; border: 1px solid white;">';
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">Sub Total</p>';
                                                                            }
                                                                            if ( $booking['gst_status'] == "1" ) {
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600">GST</p>';
                                                                            }
                                                                            echo '<hr style="margin: 0px 0px 10px 0px; border: 1px solid white;">';
                                                                            echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e; font-weight:600 ">TOTAL</p>';
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-5 col-xs-5 panelLastRight">
                                                                        <?php 
                                                                            if ( $booking['gst_status'] == "0" ) {
                                                                            // direct bill
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ '.$total_direct['total_price'].'</p>';
                                                                                if ( $booking['coupons_id'] != "0" ) {
                                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">- ₹ '.$total_direct['coupon_discount'].'</p>';
                                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ '.$total_direct['total_net_payable'].'</strong></p>';
                                                                                } else {
                                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ '.$total_direct['total_price'].'</strong></p>';
                                                                                }
                                                                            } else if ( $booking['gst_status'] == "1" ){
                                                                            // GST Bill
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ '.number_format((float)$total_gst['total_price'], 2, '.', '').'</p>';
                                                                                if ( $booking['coupons_id'] != "0" ) {
                                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">- ₹ '.number_format((float)$total_gst['coupon_discount'], 2, '.', '').'</p>';
                                                                                    echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                                    echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;">₹ '.number_format((float)$total_gst['net_payable'], 2, '.', '').'</p>';
                                                                                }
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>+ ₹ '.number_format((float)$total_gst['total_gst'], 2, '.', '').'</strong></p>';
                                                                                echo '<hr style="margin: 0px 0px 10px 0px; border-top: 1px solid #83a0ae;">';
                                                                                echo '<p class="textColor" style="font-size:11px; padding:5px 2px 5px 10px; color:#473e3e;  text-align:right; font-weight:600;"><strong>₹ '.number_format((float)$total_gst['total_net_payable'], 2, '.', '').'</strong></p>';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--======== SCRIPT FILES =========-->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/materialize.min.js"></script>
    <script src="../js/custom.js"></script>
    
    <script type="text/javascript">
    
        $(document).ready(function() {
            
            var divToPrint=document.getElementById('htmlContent');
                newWin= window.open("");
                newWin.document.write('<html><head><link rel="stylesheet" href="../css/font-awesome.min.css"><link rel="stylesheet" href="../css/style.css"><link rel="stylesheet" href="../css/mob.css"><link rel="stylesheet" href="../css/bootstrap.css"><link rel="stylesheet" href="../css/materialize.css" /></head><body onload="window.print()">'+divToPrint.outerHTML+'</body></html>');
                newWin.print();
                newWin.close();

            // reoad back to history page
            window.history.back();
        });

    </script>
</body>
</html>