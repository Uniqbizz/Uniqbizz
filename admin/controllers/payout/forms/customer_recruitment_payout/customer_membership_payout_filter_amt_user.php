 <!-- // next & prev model name & amount section replace  -->
 <?php
    require "../../../../connect.php";

    $cap_id = $_POST['cap_id'];
    $designation = $_POST['designation'];
    $cap_year = $_POST['year_split'] ?? '';
    $cap_month = $_POST['month_split'] ?? '';
    $identify = $_POST['identify'] ?? '';

    $fullName = "";
    $AmtFilter = "";

    if ($identify == "prev&next") {
        // get Full name of selected user start 
        if ($designation == 'business_mentor') {
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '" . $cap_id . "' AND status = '1'";
        } else if ($designation == 'corporate_agency') {
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $cap_id . "' AND status = '1'";
        } else if ($designation == 'ca_travelagency') {
            $sqlId = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '" . $cap_id . "' AND status = '1'";
        }
        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            foreach (($stmt->fetchALL()) as $key => $row) {
                $fullName = $row['firstname'] . ' ' . $row['lastname'] ?? '';

                // get amount of selected user form ca_ta_payout table start 
                if ($designation == 'business_mentor') {
                    $sqlIdAmt = "SELECT SUM(commision_bm) as prevPayoutAmt FROM ca_cu_payout WHERE business_mentor = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
                } else if ($designation == 'corporate_agency') {
                    $sqlIdAmt = "SELECT SUM(commision_te) as prevPayoutAmt FROM ca_cu_payout WHERE techno_enterprise = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
                } else if ($designation == 'ca_travelagency') {
                    $sqlIdAmt = "SELECT SUM(commision_tc) as prevPayoutAmt FROM ca_cu_payout WHERE travel_consultant = '" . $cap_id . "' AND YEAR(created_date) = '" . $cap_year . "' AND MONTH(created_date) = '" . $cap_month . "' order by id DESC";
                }
                $stmt2 = $conn->prepare($sqlIdAmt);
                // print_r($stmt2);
                $stmt2->execute();
                $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt2->rowCount() > 0) {
                    foreach (($stmt2->fetchALL()) as $key2 => $row2) {
                        $AmtFilter = $row2['prevPayoutAmt'];
                        $AmtFilterTds = $AmtFilter * 2 / 100;
                        $AmtFilterFinal = $AmtFilter - $AmtFilterTds;
                        echo '
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>' . $fullName . '</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. ' . $AmtFilterFinal . '/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    } else {
        // get Full name of selected user start 
        if ($designation == 'business_mentor') {
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '" . $cap_id . "' AND status = '1'";
        } else if ($designation == 'corporate_agency') {
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $cap_id . "' AND status = '1'";
        } else if ($designation == 'ca_travelagency') {
            $sqlId = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '" . $cap_id . "' AND status = '1'";
        }
        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            foreach (($stmt->fetchALL()) as $key => $row) {
                $fullName = $row['firstname'] . ' ' . $row['lastname'];

                // get amount of selected user form ca_ta_payout table start 
                if ($designation == 'business_mentor') {
                    $sqlIdAmt = "SELECT SUM(total_payable) as PayoutAmt FROM ca_cu_payout_paid WHERE business_mentor = '" . $cap_id . "'  order by id DESC";
                } else if ($designation == 'corporate_agency') {
                    $sqlIdAmt = "SELECT SUM(total_payable) as PayoutAmt FROM ca_cu_payout_paid WHERE techno_enterprise = '" . $cap_id . "'  order by id DESC";
                } else if ($designation == 'ca_travelagency') {
                    $sqlIdAmt = "SELECT SUM(total_payable) as PayoutAmt FROM ca_cu_payout_paid WHERE travel_consultant = '" . $cap_id . "'  order by id DESC";
                }
                $stmt2 = $conn->prepare($sqlIdAmt);
                $stmt2->execute();
                $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt2->rowCount() > 0) {
                    foreach (($stmt2->fetchALL()) as $key2 => $row2) {
                        $AmtFilter = $row2['PayoutAmt'];

                        echo '
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>' . $fullName . '</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. ' . $AmtFilter . '/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }



    ?>