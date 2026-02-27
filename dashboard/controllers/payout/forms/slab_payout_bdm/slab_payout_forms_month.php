<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$userID = $_POST['userID'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$tds_percentage = 2 / 100;
$userType = $_POST['userType'];

if ($userType == 25) {
    if ($totalAmountMessage) {
        $stmt = " SELECT SUM(payout_amount) as TotalPayout FROM bdm_payout_history WHERE bdm_user_id = '" . $userID . "' AND YEAR(payout_date) = '" . $TotalYear . "' AND MONTH(payout_date) = '" . $TotalMonth . "' ";
        $stmt = $conn->prepare($stmt);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $key => $row) {
                $TotalPayout = $row['TotalPayout'];
                $tds = $TotalPayout * $tds_percentage;
                $TotalPayout = $TotalPayout - $tds;
                if ($TotalPayout == null) {
                    echo 0;
                } else {
                    $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                    echo number_format($truncatedTotalAmount,2);
                }
            }
        }
    }

    if ($totalTableMessage) {
        echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
            <thead>
                <tr>
                    <th class="mobile_view">Date</th>
                    <th >Payout Message</th>
                    <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                    <th style="text-align:center;" class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                  
                </tr>
            </thead>
            <tbody >';

        $model2 = "SELECT * FROM bdm_payout_history WHERE bdm_user_id = '" . $userID . "' AND YEAR(payout_date) = '" . $TotalYear . "' AND MONTH(payout_date) = '" . $TotalMonth . "' ";
        $model2 = $conn->prepare($model2);
        $model2->execute();
        $model2->setFetchMode(PDO::FETCH_ASSOC);
        if ($model2->rowCount() > 0) {
            foreach ($model2->fetchAll() as $key => $row) {

                // date in proper formate
                $dt = new DateTime($row['payout_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message = $row['message_bdm'];
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 25");
                $sql1->execute([$row['bdm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bm_user_id FROM bdm_payout_history WHERE bdm_user_id = ?");
                $sql2->execute([$row['bdm_user_id']]);
                $bm_ids = $sql2->fetchColumn(); // Get the JSON string directly

                $bm_names = [];
                if (!empty($bm_ids)) {
                    // If already an array, use it directly; otherwise, decode
                    $bm_ids_array = is_array($bm_ids) ? $bm_ids : json_decode($bm_ids, true);

                    if (is_array($bm_ids_array) && count($bm_ids_array) > 0) {
                        $placeholders = implode(',', array_fill(0, count($bm_ids_array), '?')); // Generate ?,?,?
                        $sql3 = $conn->prepare("SELECT business_mentor_id, firstname, lastname FROM business_mentor WHERE business_mentor_id IN ($placeholders) AND status = 1");

                        $sql3->execute(array_values($bm_ids_array));

                        $bmMap = [];
                        foreach ($sql3->fetchAll(PDO::FETCH_ASSOC) as $bmRow) {
                            $bmMap[$bmRow['business_mentor_id']] = $bmRow['firstname'] . ' ' . $bmRow['lastname'];
                        }

                        foreach ($bm_ids_array as $bm_id) {
                            if (isset($bmMap[$bm_id])) {
                                $bm_names[] = $bmMap[$bm_id] . " ($bm_id)";
                            }
                        }
                    }
                }

                if (!empty($bm_names)) {
                    $message .= ' Active BMs: ' . implode(', ', $bm_names);
                } else {
                    $message .= ' Active BMs: Not found';
                }

                // total Amt Cal for BDM 
                $CommAmt = $row['payout_amount'];
                $tds = $CommAmt * $tds_percentage;
                $totalAmt = $CommAmt - $tds;

                echo '<tr>
                            <td>' . $dt . '</td>
                            <td >' . $message . '</td>
                            <td style="text-align:center;">' . $CommAmt . '</td>
                            <td style="text-align:center;">' . $tds . '</td>
                            <td style="text-align:center;">' . $totalAmt . '</td>';
                echo '<td style="text-align:center;">';
                if ($row['payout_status'] == 1) {
                    echo '<span class="badge bg-warning">Pending</span>';
                }else if ($row['payout_status'] == 2) {
                    echo '<span class="badge bg-success">Paid</span>';
                } else if ($row['payout_status'] == 3){
                    echo '<span class="badge bg-danger">Blocked</span>';
                }
                echo'</td>
                        </tr>';
            }
        }
        echo '</tbody>
        </table>';
    }
} else if ($userType == 24) {
    if ($totalAmountMessage) {
        $stmt = " SELECT SUM(payout_amount) as TotalPayout FROM bcm_payout_history WHERE bcm_user_id = '" . $userID . "' AND YEAR(payout_date) = '" . $TotalYear . "' AND MONTH(payout_date) = '" . $TotalMonth . "'  ";
        $stmt = $conn->prepare($stmt);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $key => $row) {
                $CommAmt = $row['TotalPayout'];
                $tds = $CommAmt * $tds_percentage;
                $TotalPayout = $CommAmt - $tds;
                if ($TotalPayout == null) {
                    echo 0;
                } else {
                    $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                    echo number_format($truncatedTotalAmount,2);
                }
            }
        }
    }

    if ($totalTableMessage) {
        echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
            <thead>
                <tr>
                    <th class="mobile_view">Date</th>
                    <th >Payout Message</th>
                    <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                    <th style="text-align:center;" class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                  
                </tr>
            </thead>
            <tbody >';

        $model2 = "SELECT * FROM bcm_payout_history WHERE bcm_user_id = '" . $userID . "' AND YEAR(payout_date) = '" . $TotalYear . "' AND MONTH(payout_date) = '" . $TotalMonth . "'";
        $model2 = $conn->prepare($model2);
        $model2->execute();
        $model2->setFetchMode(PDO::FETCH_ASSOC);
        if ($model2->rowCount() > 0) {
            foreach ($model2->fetchAll() as $key => $row) {

                // date in proper formate
                $dt = new DateTime($row['payout_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message = $row['message_bcm'];
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 24");
                $sql1->execute([$row['bcm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bdm_user_id FROM bcm_payout_history WHERE bcm_user_id = ?");
                $sql2->execute([$row['bcm_user_id']]);
                $bdm_ids = $sql2->fetchColumn(); // Get the JSON string directly
                
                if (!empty($bdm_ids)) {
                    $bdm_ids_array = is_array($bdm_ids) ? $bdm_ids : json_decode($bdm_ids, true);
                   
                    if (is_array($bdm_ids_array) && count($bdm_ids_array) > 0) {
                        $placeholders = implode(',', array_fill(0, count($bdm_ids_array), '?')); // Generate ?,?,?
                        $sql3 = $conn->prepare("SELECT employee_id, name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");
                        
                        $sql3->execute($bdm_ids_array);
                        // print_r($sql3);

                        $bdmMap = [];
                        foreach ($sql3->fetchAll(PDO::FETCH_ASSOC) as $bdmRow) {
                            $bdmMap[$bdmRow['employee_id']] = $bdmRow['name'];
                        }

                        foreach ($bdm_ids_array as $bdm_id) {
                            if (isset($bdmMap[$bdm_id])) {
                                $bdm_names[] = $bdmMap[$bdm_id] . " ($bdm_id)";
                            }
                        }
                    }
                }

                if (!empty($bdm_names)) {
                    $message .= ' Active BDMs: ' . implode(', ', $bdm_names);
                } else {
                    $message .= ' Active BDMs: Not found';
                }

                // total Amt Cal for BCM 
                $CommAmt = $row['payout_amount'];
                $tds = $CommAmt * $tds_percentage;
                $totalAmt = $CommAmt - $tds;

                echo '<tr>
                            <td>' . $dt . '</td>
                            <td >' . $message . '</td>
                            <td style="text-align:center;">' . $CommAmt . '</td>
                            <td style="text-align:center;">' . $tds . '</td>
                            <td style="text-align:center;">' . $totalAmt . '</td>';
                            echo '<td style="text-align:center;">';
                            if ($row['payout_status'] == 1) {
                                echo '<span class="badge bg-warning">Pending</span>';
                            }else if ($row['payout_status'] == 2) {
                                echo '<span class="badge bg-success">Paid</span>';
                            } else if ($row['payout_status'] == 3){
                                echo '<span class="badge bg-danger">Blocked</span>';
                            }
                            echo'</td>
                        </tr>';
                       
            }
        }
        echo '</tbody>
        </table>';
    }
}



?>