<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'] ?? '';
$designation = $_POST['designation'];
$cap_year = $_POST['year_split'] ?? '';
$cap_month = $_POST['month_split'] ?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter'] ?? '';
$tdsPer = 2 / 100;

if ($TotalPayoutFilter) { // data filter for Total payout pop up card fetch data from ca_cu_payout_paid
    if ($designation == 'business_mentor') {
        $sqlId = "SELECT * FROM ca_cu_payout_paid WHERE business_mentor = '" . $cap_id . "' order by id DESC";
    } else if ($designation == 'corporate_agency') {
        $sqlId = "SELECT * FROM ca_cu_payout_paid WHERE techno_enterprise = '" . $cap_id . "' order by id DESC";
    } else if ($designation == 'ca_travelagency') {
        $sqlId = "SELECT * FROM ca_cu_payout_paid WHERE travel_consultant = '" . $cap_id . "' order by id DESC";
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
                        <th class="ceterText fw-bolder font-size-16">Status</th>
                    </tr>
                </thead>
                <tbody>';

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['payout_message'];
            $message1 =  str_replace('.', '<br>', $message1);

            // replace dot at end of the line with break statement
            $message2 = $row['payout_details'];
            $message2 =  str_replace('.', '<br>', $message2);

            echo '<tr>
                                <td>' . $dt . '</td>
                                <td>' . $message1 . '</td>
                                <td>' . $message2 . '</td>
                                <td class="text-end">' . $row['amount'] . '</td>
                                <td class="text-end">' . $row['tds'] . '</td>
                                <td class="text-end">' . $row['total_payable'] . '</td>';
            if ($row['status'] == '1') {
                echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
            } else {
                echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" >Pending</span></td>';
            }
            echo '</tr>';
        }
    }

    echo '</tbody>
            </table>
        </div>';
} else if (!$cap_id && !$cap_year && !$cap_month && $designation) { // if only designation filter

    $sqlId = "";
    if ($designation == 'business_mentor') {
        $sqlId = "SELECT * FROM ca_cu_payout ORDER BY id DESC";
    } else if ($designation == 'corporate_agency') {
        $sqlId = "SELECT * FROM ca_cu_payout ORDER BY id DESC";
    } else if ($designation == 'ca_travelagency') {
        $sqlId = "SELECT * FROM ca_cu_payout ORDER BY id DESC";
    }

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // print_r($stmt);
    if ($stmt->rowCount() > 0) {
        echo '<div class="table-responsive table-desi" id="filterTable">';
        echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($stmt->fetchAll() as $row) {
            $dt = (new DateTime($row['created_date']))->format('Y-m-d');

            if ($designation == 'business_mentor') {
                $id = $row['business_mentor'];
                $message = str_replace('.', '<br>', $row['message_bm']);
                $amount = $row['commision_bm'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_bm'];
            } else if ($designation == 'corporate_agency') {
                $id = $row['techno_enterprise'];
                $message = str_replace('.', '<br>', $row['message_te']);
                $amount = $row['commision_te'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_te'];
            } else if ($designation == 'ca_travelagency') {
                $id = $row['travel_consultant'];
                $message = str_replace('.', '<br>', $row['message_tc']);
                $amount = $row['commision_tc'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_tc'];
            }
    
            if ($id) {
                echo '<tr>
                            <td class="d-none">' . $row['id'] . '</td>
                            <td>' . $dt . '</td>
                            <td>' . $message . '</td>
                            <td class="text-end">' . $amount . '</td>
                            <td class="text-end">' . $tds . '</td>
                            <td class="text-end">' . $total . '
                                <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message . '&message_status=' . $status . '&commission=' . $amount . '">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                </a>
                            </td>';
    
                if ($status == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $cap_id . '","' . $message . '","' . $amount . '","' . $status . '","message")\'>Pending</span></td>';
                }
    
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    } else {
        echo '<div class="alert alert-info">No payout data available for this designation.</div>';
    }
} else if (!$cap_year && !$cap_month && $designation && $cap_id) { // if only user id and desgnation filter

    $sqlId = "";
    if ($designation == 'business_mentor') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE business_mentor = '" . $cap_id . "' ORDER BY id DESC";
    } else if ($designation == 'corporate_agency') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE techno_enterprise = '" . $cap_id . "' ORDER BY id DESC";
    } else if ($designation == 'ca_travelagency') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE travel_consultant = '" . $cap_id . "' ORDER BY id DESC";
    }

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // print_r($stmt);
    if ($stmt->rowCount() > 0) {
        echo '<div class="table-responsive table-desi" id="filterTable">';
        echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($stmt->fetchAll() as $row) {
            $dt = (new DateTime($row['created_date']))->format('Y-m-d');

            if ($designation == 'business_mentor') {
                $id = $row['business_mentor'];
                $message = str_replace('.', '<br>', $row['message_bm']);
                $amount = $row['commision_bm'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_bm'];
            } else if ($designation == 'corporate_agency') {
                $id = $row['techno_enterprise'];
                $message = str_replace('.', '<br>', $row['message_te']);
                $amount = $row['commision_te'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_te'];
            } else if ($designation == 'ca_travelagency') {
                $id = $row['travel_consultant'];
                $message = str_replace('.', '<br>', $row['message_tc']);
                $amount = $row['commision_tc'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_tc'];
            }
            
            if ($id) {
                echo '<tr>
                            <td class="d-none">' . $row['id'] . '</td>
                            <td>' . $dt . '</td>
                            <td>' . $message . '</td>
                            <td class="text-end">' . $amount . '</td>
                            <td class="text-end">' . $tds . '</td>
                            <td class="text-end">' . $total . '
                                <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message . '&message_status=' . $status . '&commission=' . $amount . '">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                </a>
                            </td>';
    
                if ($status == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $cap_id . '","' . $message . '","' . $amount . '","' . $status . '","message")\'>Pending</span></td>';
                }
    
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    } else {
        echo '<div class="alert alert-info">No payout data available for this designation.</div>';
    }
} else if (!$cap_id && !$designation && $cap_month && $cap_year) { // if only date filter are their 
    // echo'
    //     <script>alert("Date Filter");</script>
    // ';
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

    $stmt = $conn->prepare("SELECT * FROM ca_cu_payout WHERE YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchALL()) as $key => $row) {

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message_bm'];
            $message1 =  str_replace('.', '<br>', $message1);

            // replace dot at end of the line with break statement
            $message2 = $row['message_te'];
            $message2 =  str_replace('.', '<br>', $message2);

            // replace dot at end of the line with break statement
            $message3 = $row['message_tc'];
            $message3 =  str_replace('.', '<br>', $message3);

            // total Amt Cal for Bm 
            $CommAmtBc = $row['commision_bm'];
            $tdsBc = $CommAmtBc * $perTDS;
            $totalAmtBc = $CommAmtBc - $tdsBc;

            // total Amt Cal for te
            $CommAmtCa = $row['commision_te'];
            $tdsCa = $CommAmtCa * $perTDS;
            $totalAmtCa = $CommAmtCa - $tdsCa;

            // total Amt Cal for tc
            $CommAmtTc = $row['commision_tc'];
            $tdsTc = $CommAmtTc * $perTDS;
            $totalAmtTc = $CommAmtTc - $tdsTc;

            if (!$row['business_mentor'] == "") {
                echo '<tr>
                                    <td>' . $dt . '</td>
                                    <td>' . $message1 . '</td>
                                    <td class="text-end">' . $CommAmtBc . '</td>
                                    <td class="text-end">' . $tdsBc . '</td>
                                    <td class="text-end">' . $totalAmtBc . '
                                        <a href="forms/customer_recruitment_payout/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['business_mentor'] . '&ca=' . $row['techno_enterprise'] . '&ta_ca=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['status_bm'] . '&commission=' . $row['commision_bm'] . '">
                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                    </td>';
                if ($row['status_bm'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                }
                echo '</tr>';
            }

            if (!$row['techno_enterprise'] == "") {
                echo '<tr>
                                    <td>' . $dt . '</td>
                                    <td>' . $message2 . '</td>
                                    <td class="text-end">' . $CommAmtCa . '</td>
                                    <td class="text-end">' . $tdsCa . '</td>
                                    <td class="text-end">' . $totalAmtCa . '
                                        <a href="forms/customer_recruitment_payout/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['business_mentor'] . '&ca=' . $row['techno_enterprise'] . '&ta_ca=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message2 . '&message_status=' . $row['status_te'] . '&commission=' . $row['commision_te'] . '">
                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                    </td>';
                if ($row['status_te'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                }
                echo '</tr>';
            }
            
            if (!$row['travel_consultant'] == "") {
                echo '<tr>
                                    <td>' . $dt . '</td>
                                    <td>' . $message3 . '</td>
                                    <td class="text-end">' . $CommAmtTc . '</td>
                                    <td class="text-end">' . $tdsTc . '</td>
                                    <td class="text-end">' . $totalAmtTc . '
                                        <a href="forms/customer_recruitment_payout/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['business_mentor'] . '&ca=' . $row['techno_enterprise'] . '&ta_ca=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message2 . '&message_status=' . $row['status_te'] . '&commission=' . $row['commision_te'] . '">
                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                        </a>
                                    </td>';
                if ($row['status_te'] == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                }
                echo '</tr>';
            }
        }
    }

    echo '</tbody>
            </table>
            <!-- pegination start -->
            <div class="center text-center" id="pagination_row"></div>
        </div>';
} else if (!$cap_id && $designation && $cap_month && $cap_year) { // if only designation and date is their
    $sqlId = "SELECT * FROM ca_cu_payout WHERE YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' ORDER BY id DESC";
    // if ($designation == 'business_mentor') {
    //     $sqlId = "SELECT * FROM ca_cu_payout WHERE business_mentor = '".$cap_id."' ORDER BY id DESC";
    // } else if ($designation == 'corporate_agency') {
    //     $sqlId = "SELECT * FROM ca_cu_payout WHERE techno_enterprise = '".$cap_id."' ORDER BY id DESC";
    // } else if ($designation == 'ca_travelagency') {
    //     $sqlId = "SELECT * FROM ca_cu_payout WHERE travel_consultant = '".$cap_id."' ORDER BY id DESC";
    // }

    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // print_r($stmt);
    if ($stmt->rowCount() > 0) {
        echo '<div class="table-responsive table-desi" id="filterTable">';
        echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($stmt->fetchAll() as $row) {
            $dt = (new DateTime($row['created_date']))->format('Y-m-d');

            if ($designation == 'business_mentor') {
                $id = $row['business_mentor'];
                $message = str_replace('.', '<br>', $row['message_bm']);
                $amount = $row['commision_bm'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_bm'];
            } else if ($designation == 'corporate_agency') {
                $id = $row['techno_enterprise'];
                $message = str_replace('.', '<br>', $row['message_te']);
                $amount = $row['commision_te'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_te'];
            } else if ($designation == 'ca_travelagency') {
                $id = $row['travel_consultant'];
                $message = str_replace('.', '<br>', $row['message_tc']);
                $amount = $row['commision_tc'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_tc'];
            }

            if ($id) {
                echo '<tr>
                            <td class="d-none">' . $row['id'] . '</td>
                            <td>' . $dt . '</td>
                            <td>' . $message . '</td>
                            <td class="text-end">' . $amount . '</td>
                            <td class="text-end">' . $tds . '</td>
                            <td class="text-end">' . $total . '
                                <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message . '&message_status=' . $status . '&commission=' . $amount . '">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                </a>
                            </td>';
    
                if ($status == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $cap_id . '","' . $message . '","' . $amount . '","' . $status . '","message")\'>Pending</span></td>';
                }
    
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    } else {
        echo '<div class="alert alert-info">No payout data available for this designation.</div>';
    }
} else { // if all values are their i.e designation, date, user id

    if ($designation == 'business_mentor') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE business_mentor = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
    } else if ($designation == 'corporate_agency') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE techno_enterprise = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
    } else if ($designation == 'ca_travelagency') {
        $sqlId = "SELECT * FROM ca_cu_payout WHERE travel_consultant = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
    }


    $stmt = $conn->prepare($sqlId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        echo '<div class="table-responsive table-desi" id="filterTable">';
        echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($stmt->fetchAll() as $row) {
            $dt = (new DateTime($row['created_date']))->format('Y-m-d');

            if ($designation == 'business_mentor') {
                $id = $row['business_mentor'];
                $message = str_replace('.', '<br>', $row['message_bm']);
                $amount = $row['commision_bm'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_bm'];
            } else if ($designation == 'corporate_agency') {
                $id = $row['techno_enterprise'];
                $message = str_replace('.', '<br>', $row['message_te']);
                $amount = $row['commision_te'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_te'];
            } else if ($designation == 'ca_travelagency') {
                $id = $row['travel_consultant'];
                $message = str_replace('.', '<br>', $row['message_tc']);
                $amount = $row['commision_tc'] ?: 0;
                $tds = $amount * $tdsPer;
                $total = $amount - $tds;
                $status = $row['status_tc'];
            }

            if ($id) {
                echo '<tr>
                            <td class="d-none">' . $row['id'] . '</td>
                            <td>' . $dt . '</td>
                            <td>' . $message . '</td>
                            <td class="text-end">' . $amount . '</td>
                            <td class="text-end">' . $tds . '</td>
                            <td class="text-end">' . $total . '
                                <a href="forms/customer_recruitment_payout/download_cu_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bm=' . $row['business_mentor'] . '&te=' . $row['techno_enterprise'] . '&tc=' . $row['travel_consultant'] . '&date=' . $dt . '&message=' . $message . '&message_status=' . $status . '&commission=' . $amount . '">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                </a>
                            </td>';
    
                if ($status == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row["id"] . '","' . $cap_id . '","' . $message . '","' . $amount . '","' . $status . '","message")\'>Pending</span></td>';
                }
    
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    } else {
        echo '<div class="alert alert-info">No payout data available for this designation.</div>';
    }
}

//designation and date combination 
?>