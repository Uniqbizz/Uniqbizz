<?php

require '../../../connect.php';

$id = $_GET['vkvbvjfgfikix'];
$bc = $_GET['bc'];
$ca = $_GET['ca'];
// $ta_ca = $_GET['ta_ca'];
$dateCA = $_GET['date'];
$message = $_GET['message'];
$message_status = $_GET['message_status'];
$commission = $_GET['commission'];

if ($commission == "null") {
    //TDS calculation on commission Amount 
    $tds = 2;
    $commissionTDS = '0';
    $totalAmt = '0';
} else {
    //TDS calculation on commission Amount 
    $tds = 2;
    $commissionTDS = $commission * $tds / 100;
    $totalAmt = $commission - $commissionTDS;
}

$date = date('F,Y', strtotime($dateCA));

$bcNames = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '" . $bc . "' AND status = 1");
$bcNames->execute();
$bcNames->setFetchMode(PDO::FETCH_ASSOC);
if ($bcNames->rowCount() > 0) {
    foreach (($bcNames->fetchAll()) as $key => $row) {
        $bcfirstname = $row['firstname'];
        $bclastname = $row['lastname'];
    }
}

$caNames = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $ca . "' AND status = 1");
$caNames->execute();
$caNames->setFetchMode(PDO::FETCH_ASSOC);
if ($caNames->rowCount() > 0) {
    foreach (($caNames->fetchAll()) as $key => $row) {
        $cafirstname = $row['firstname'];
        $calastname = $row['lastname'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download payout</title>
    <!--== FAV ICON ==-->
    <link rel="shortcut icon" href="../../../assets/images/fav.png">

    <!--== ALL CSS FILES ==-->
    <!-- Bootstrap Css -->
    <link href="../../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .go-back {
            margin: 10px 30px 20px;
            padding: 10px;
            background-color: red;
            color: white;
            border-radius: 5px;
            float: left;
        }

        .download-btn {
            margin: 10px 30px 20px;
            padding: 10px;
            background-color: green;
            color: white;
            border-radius: 5px;
            float: right;
        }

        .background {
            height: 750px;
            background: #fff;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="container cont-btn d-flex justify-content-around pt-3 pb-4">
            <a href="../../../bm_recruitment_payout_slab.php" class="go-back"> Go Back</a>

            <a href="#" id="generatePDF" class="download-btn">
                <i class="fa fa-download " aria-hidden="true" style="color: white;"></i>
                Download Monthly Statement
            </a>
        </div>

        <div class="d-flex justify-content-center main-box" id="htmlContent">
            <div class="row rounded-4" style="width:650px; border:1px solid #417482;">
                <div class="col-md-12 col-sm-12 col-12 ps-3 pe-3" style=" ">
                    <div class="row">
                        <table class="col-md-12 col-sm-12" style="border-bottom: 2px solid #417482;">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <img class="ms-2" style="height: 15px; " src="../../../assets/images/uniqbizz_logo.png" alt="" />
                                    </td>
                                    <td class="center">
                                        <h4 class="fw-bolder lh-lg"> Statement Of The Month</h4>
                                    </td>
                                    <td class="right">
                                        <img class="me-2" style="height: 28px; " src="../../../assets/images/bizz_logo.png" alt="" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="col-md-12 col-sm-12">
                            <tbody>
                                <tr>
                                    <td class="col-md-7 col-sm-7 left pt-3">
                                        <h6 style="padding:2px 10px; font-weight: 700;">Name : <?php echo $bcfirstname . ' ' . $bclastname; ?></h6>
                                        <h6 style="padding:2px 10px; font-weight: 700;">User ID : <?php echo $bc; ?></h6>
                                        <h6 style="padding:2px 10px; font-weight: 700;">Month : <?php echo $date; ?></h6>
                                    </td>
                                    <td class="col-md-5 col-sm-5 pt-3">
                                        <h6 style="padding:2px 0; font-weight: 700;">Pay For : Techno Enterprise</h6>
                                        <h6 style="padding:2px 0; font-weight: 700;">Designation : Business Mentor</h6>
                                        <h6 style="padding:2px 0; font-weight: 700;">Payout status : <?php echo match ((int) $message_status) {
                                                                                                            1 => 'Pending',
                                                                                                            2 => 'Paid',
                                                                                                            3 => 'Blocked'
                                                                                                        }; ?></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-md-12 col-sm-12" style="">
                            <h5 style="padding: 10px 5px;  margin:0px; font-weight: 700; ">Corpoarte Agency Payout</h5>
                            <div class="col-md-12 col-sm-12" style="text-align: left; margin-bottom:20px">
                                <table class="orderTable text-center" style="padding-bottom:5px; margin:0px; border:1px solid #DDDDDD;">
                                    <thead>
                                        <tr class="tableHead" style="border-bottom: 1px solid #DDDDDD">
                                            <th style="font-size:12px; height: 100%; padding:5px; text-align:center;" class="rowHeading">Date</th>
                                            <th style="font-size:12px; height: 100%; padding:5px;" class="rowHeading">Payout Details</th>
                                            <th style="font-size:12px; height: 100%; padding:5px; text-align:center;" class="rowHeading">Amount</th>
                                            <th style="font-size:12px; height: 100%; padding:5px; text-align:center;" class="rowHeading">TDS</th>
                                            <th style="font-size:12px; height: 100%; padding:5px; text-align:center;" class="rowHeading">Total Payable</th>
                                            <th style="font-size:12px; height: 100%; padding:5px; text-align:center;" class="rowHeading">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fw-normal">
                                            <td class="ps-2 pe-2 pt-3 pb-3"><?php echo $date; ?></td>
                                            </td>
                                            <td class="ps-4 pe-4 text-start pt-3 pb-3"><?php echo $message; ?></td>
                                            <td class="ps-2 pe-2 pt-3 pb-3">₹<?php echo $commission; ?>/-</td>
                                            <td class="ps-2 pe-2 pt-3 pb-3">₹<?php echo $commissionTDS; ?>/-</td>
                                            <td class="ps-2 pe-2 pt-3 pb-3">₹<?php echo $totalAmt; ?>/-</td>
                                            <td class="ps-2 pe-2 pt-3 pb-3"><?php echo match ((int) $message_status) {
                                                                                1 => 'Pending',
                                                                                2 => 'Paid',
                                                                                3 => 'Blocked'
                                                                            }; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <table class="col-md-12 col-sm-12" style="padding:5px; border-bottom: 2px solid #417482;">
                            <tbody>
                                <tr>
                                    <td class="col-md-7 col-sm-7" style="padding:5px 20px; font-size:14px;"></td>
                                    <td class="col-md-3 col-sm-3" style="padding:5px 20px; font-size:14px; text-align: right; font-weight:bold; white-space: nowrap;">Sub Total</td>
                                    <td class="col-md-2 col-sm-2" style="padding:5px 20px; font-size:14px; text-align: right; font-weight:bold"> ₹<?php echo $commission; ?>/-</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ced1d6;">
                                    <td class="col-md-7 col-sm-7" style="padding:5px 20px; font-size:14px;"></td>
                                    <td class="col-md-3 col-sm-3" style="padding:5px 20px; font-size:14px; text-align: right; font-weight:bold;">TDS</td>
                                    <td class="col-md-2 col-sm-2" style="padding:5px 20px; font-size:14px; text-align: right; font-weight:bold">- ₹<?php echo $commissionTDS; ?>/-</td>
                                </tr>
                                <tr>
                                    <td class="col-md-7 col-sm-7" style="padding:5px 0px;"></td>
                                    <td class="col-md-3 col-sm-3" style="padding:5px 20px; text-align: right; font-size:16px; font-weight:bold;">Total</td>
                                    <td class="col-md-2 col-sm-2" style="padding:5px 20px; text-align: right; font-size:16px; font-weight:bold"> ₹<?php echo $totalAmt; ?>/-</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-center pt-2">This is computer generated Receipt</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script src="../../../assets/js/jquery/jquery-3.7.1.min.js"></script>
    <script src="../../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        $("#generatePDF").click(function() {
            // $(document).ready(function() {
            var divToPrint = document.getElementById('htmlContent');
            newWin = window.open("");
            newWin.document.write('<html><head><link rel="stylesheet" href="../../../assets/css/bootstrap.min.css"><link rel="stylesheet" href="../../../assets/css/icons.min.css"><link rel="stylesheet" href="../../../assets/css/app.min.css"></head><body style="margin-top: 20px;" onload="window.print()">' + divToPrint.outerHTML + '</body></html>');
            newWin.print();
            newWin.close();

            // reoad back to history page
            window.history.back();
        });
    </script>
</body>

</html>