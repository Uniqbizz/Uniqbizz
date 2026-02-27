<!-- all payout section filter  -->
<?php

require "../../../../connect.php";

$cap_id = $_POST['cap_id'] ?? null;
$designation = $_POST['designation'] ?? null;
$cap_year = $_POST['year_split'] ?? '';
$cap_month = $_POST['month_split'] ?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter'] ?? '';
$tdsPer = 2 / 100;

if ($TotalPayoutFilter) {

    if ($designation == 'Prime') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Prime' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Prime' order by created_date DESC";
        }
    } 
    if ($designation == 'Premium') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium' order by created_date DESC";
        }
    } 
    if ($designation == 'Premium Plus') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Plus' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Plus' order by created_date DESC";
        }
    } 
    if ($designation == 'Premium Select') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Select' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Select' order by created_date DESC";
        }
    } 
    if ($designation == 'Premium Select Lite') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Select Lite' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Select Lite' order by created_date DESC";
        }
    } 
    if ($designation == 'Neo Select') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Neo Select' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Neo Select' order by created_date DESC";
        }
    } 
    if ($designation == 'Neo Select Lite') {
        if ($cap_id) {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Neo Select Lite' order by created_date DESC";
        } else {
            $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Neo Select Lite' order by created_date DESC";
        }
    } 

    echo '<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="filteredTotalTables">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Message</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message1']?$row['message1']:$row['message2'];
            $message1 =  str_replace('.', '<br>', $message1);

            $message_details = $row['message_details']??'NA';
            $message_details =  str_replace('.', '<br>', $message_details);

            // total Amt Cal for BC 
            if (!$row['comm_amt1']) {
                $CommAmt = $row['comm_amt2'];
                $tds = "NA";
                $totalAmt = $CommAmt;
            } else {
                $CommAmt = $row['comm_amt1'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }

            echo '<tr>
                                <td>' . $dt . '</td>
                                <td>' . $message1 . '</td>
                                <td>' . $message_details . '</td>
                                <td class="text-end">' . $CommAmt . '</td>
                                <td class="text-end">' . $tds . '</td>
                                <td class="text-end">' . $totalAmt ; 
                                if($row['status'] != '3'){
                                    echo '
                                        <a href="../../../../controllers/payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&userId=' . $row['userId']. '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['status'] . '&commission=' . $CommAmt. '">
                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                    </td>';
                                }
            if ($row['status'] == '1') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
            }else if($row['status'] ==3) {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Credited</span></td>';
            }else {
                echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['userId'] . '","' . $message1 . '","' . $CommAmt . '","' . $row['status'] . '")\'>Pending</span></td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody>
            </table>
        </div>';
} else if (!$cap_year && !$cap_month) {
    if (!empty($designation)) {
        if ($designation == 'Prime') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Prime' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Prime' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Plus') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Plus' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Plus' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Select') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Select' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Select' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Select Lite') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Premium Select Lite' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Premium Select Lite' order by created_date DESC";
            }
        } 
        if ($designation == 'Neo Select') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Neo Select' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Neo Select' order by created_date DESC";
            }
        } 
        if ($designation == 'Neo Select Lite') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND customer_type='Neo Select Lite' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_type='Neo Select Lite' order by created_date DESC";
            }
        } 
    } else {
        // 🔁 DESIGNATION NOT SET — FETCH EVERYTHING ACROSS ALL PAYOUT TABLES
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout order by created_date DESC";
    }
    echo '<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    // print_r($stmt);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message1']?$row['message1']:$row['message2'];
            $message1 =  str_replace('.', '<br>', $message1);

            // total Amt Cal for BC 
            if (!$row['comm_amt1']) {
                $CommAmt = $row['comm_amt2'];
                $tds = "NA";
                $totalAmt = $CommAmt;
            } else {
                $CommAmt = $row['comm_amt1'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }

            echo '<tr>
                                <td>' . $dt . '</td>
                                <td>' . $message1 . '</td>
                                <td class="text-end">' . $CommAmt . '</td>
                                <td class="text-end">' . $tds . '</td>
                                <td class="text-end">' . $totalAmt ;
                                if($row['status'] !='3'){
                                    echo '
                                        <a href="../../../../controllers/payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&userId=' . $row['userId'] . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['status'] . '&commission=' . $CommAmt . '">
                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                    </td>';
                                }
            if ($row['status'] == '1') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
            }else if($row['status'] == '3'){
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Credited</span></td>';
            } else {
                echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['userId'] . '","' . $message1 . '","' . $CommAmt . '","' . $row['status'] . '")\'>Pending</span></td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody>
            </table>
        </div>';
} else if ($cap_year && $cap_month) {
    if (!empty($designation)) {
        if ($designation == 'Prime') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Prime' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Prime' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Plus') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Plus' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Plus' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Select') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select' order by created_date DESC";
            }
        } 
        if ($designation == 'Premium Select Lite') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select Lite' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select Lite' order by created_date DESC";
            }
        } 
        if ($designation == 'Neo Select') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select' order by created_date DESC";
            }
        } 
        if ($designation == 'Neo Select Lite') {
            if ($cap_id) {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select Lite' order by created_date DESC";
            } else {
                $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select Lite' order by created_date DESC";
            }
        } 
    } else {
        // fallback when designation is not selected
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND  YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by created_date DESC";
    }


    echo '<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    // print_r($sqlId);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message1']?$row['message1']:$row['message2'];
            $message1 =  str_replace('.', '<br>', $message1);

            // total Amt Cal for BC 
            if (!$row['comm_amt1']) {
                $CommAmt = $row['comm_amt2'];
                $tds = "NA";
                $totalAmt = $CommAmt;
            } else {
                $CommAmt = $row['comm_amt1'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }

            echo '<tr>
                    <td>' . $dt . '</td>
                    <td>' . $message1 . '</td>
                    <td class="text-end">' . $CommAmt . '</td>
                    <td class="text-end">' . $tds . '</td>
                    <td class="text-end">' . $totalAmt ;
                    if ($row['status'] =='3') {
                        # code...
                        echo '
                            <a href="../../../../controllers/payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&userId=' . $row['userId'] . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['status'] . '&commission=' . $CommAmt . '">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                        </td>';
                    }
            if ($row['status'] == '1') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
            }else if($row['status'] == '3'){
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Credited</span></td>';
            } else {
                echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['userId'] . '","' . $message1 . '","' . $CommAmt . '","' . $row['status'] . '")\'>Pending</span></td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody>
            </table>
        </div>';
} else {

    if ($designation == 'Prime') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Prime' order by created_date DESC";
    } 
    if ($designation == 'Premium') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium' order by created_date DESC";
    } 
    if ($designation == 'Premium Plus') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Plus' order by created_date DESC";
    } 
    if ($designation == 'Premium Select') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select' order by created_date DESC";
    } 
    if ($designation == 'Premium Select Lite') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Premium Select Lite' order by created_date DESC";
    } 
    if ($designation == 'Neo Select') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select' order by created_date DESC";
    } 
    if ($designation == 'Neo Select Lite') {
        $sqlId = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM customer_reference_payout WHERE customer_id = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' AND customer_type='Neo Select Lite' order by created_date DESC";
    } 

    echo '<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message1']?$row['message1']:$row['message'];
            $message1 =  str_replace('.', '<br>', $message1);

            // total Amt Cal for BC 
            if (!$row['comm_amt1']) {
                $CommAmt = $row['comm_amt2'];
                $tds = "NA";
                $totalAmt = $CommAmt;
            } else {
                $CommAmt = $row['comm_amt1'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }

            echo '<tr>
                                <td>' . $dt . '</td>
                                <td>' . $message1 . '</td>
                                <td class="text-end">' . $CommAmt . '</td>
                                <td class="text-end">' . $tds . '</td>
                                <td class="text-end">' . $totalAmt ;
                                if ($row['status'] != '3') {
                                    echo '
                                        <a href="../../../../controllers/payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&userId=' . $row['userId'] . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['status'] . '&commission=' . $CommAmt . '">
                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                </td>';
                                }
            if ($row['status'] == '1') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
            }else if($row['status'] =='3') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Credited</span></td>';
            }else {
                echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['userId'] . '","' . $message1 . '","' . $CommAmt . '","' . $row['status'] . '")\'>Pending</span></td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody>
            </table>
        </div>';
}


?>