<?php
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Next_Payout_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$tds_percentage = 2 / 100;
$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F');
$userType = $_GET['userType'];

if ($payoutmessage == 'PreviousPayout' || $payoutmessage == 'TotalPayout') {
    $output = "";

    if ($userType == 25) {
        $stmt2 = $conn->prepare("SELECT * FROM bdm_payout_history WHERE bdm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ? AND payout_status IN (2,3)");
    } else if ($userType == 24) {
        $stmt2 = $conn->prepare("SELECT * FROM bcm_payout_history WHERE bcm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ? AND payout_status IN (2,3)");
    }

    $stmt2->execute([$user_id, $payoutYear, $payoutMonth]);
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt2->rowCount() > 0) {
        $output .= '<h2 style="text-align:center">' . ($payoutmessage == 'PreviousPayout' ? 'Previous Payout List' : 'Total Payout List') . ' as of ' . $monthName . ', ' . $payoutYear . '</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th>Date</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . '</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . ' Name</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Mentor' : 'Business Development Manager') . '</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Mentor' : 'Business Development Manager') . ' Name</th>
                <th><span class="long-name">Payout Message</span></th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view">TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';

        foreach ($stmt2->fetchAll() as $row2) {
            $dt = new DateTime($row2['payout_status'] == 2 || $row2['payout_status'] == 3 ? $row2['release_date'] : $row2['payout_date']);
            $dt = $dt->format('Y-m-d');

            $Commi = (int)$row2['payout_amount'];
            $Commi_TDS = $Commi * $tds_percentage;
            $Commi_Total = $Commi - $Commi_TDS;

            
            
            if ($userType == 25) {
                $message1 = $row2['message_bdm'] ?? '';
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 25");
                $sql1->execute([$row2['bdm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bm_user_id FROM bdm_payout_history WHERE bdm_user_id = ?");
                $sql2->execute([$row2['bdm_user_id']]);
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
                    $message1 .= ' Active BMs: ' . implode(', ', $bm_names);
                } else {
                    $message1 .= ' Active BMs: Not found';
                }
            } else if ($userType == 24) {
                $message1 = $row2['message_bcm'] ?? '';
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 24");
                $sql1->execute([$row2['bcm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bdm_user_id FROM bcm_payout_history WHERE bcm_user_id = ?");
                $sql2->execute([$row2['bcm_user_id']]);
                $bdm_ids = $sql2->fetchColumn(); // Get the JSON string directly

                $bdm_names = [];
                if (!empty($bdm_ids)) {
                    $bdm_ids_array = is_array($bdm_ids) ? $bdm_ids : json_decode($bdm_ids, true);

                    if (is_array($bdm_ids_array) && count($bdm_ids_array) > 0) {
                        $placeholders = implode(',', array_fill(0, count($bdm_ids_array), '?')); // Generate ?,?,?
                        $sql3 = $conn->prepare("SELECT employee_id, name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");

                        $sql3->execute(array_values($bdm_ids_array));

                        //assigning names
                        $bdmMap = [];
                        foreach ($sql3->fetchAll(PDO::FETCH_ASSOC) as $bdmRow) {
                            $bdmMap[$bdmRow['employee_id']] = $bdmRow['name'];
                        }
                        //maintainig order
                        foreach ($bdm_ids_array as $bdm_id) {
                            if (isset($bdmMap[$bdm_id])) {
                                $bdm_names[] = $bdmMap[$bdm_id] . " ($bdm_id)";
                            }
                        }
                    }
                }

                if (!empty($bdm_names)) {
                    $message1 .= ' Active BDMs: ' . implode(', ', $bdm_names);
                }else {
                    $message1 .= ' Active BDMs: Not found';
                }
            }
            $output .= '<tr>
                    <td>' . $dt . '</td>
                    <td>' . ($userType == 25 ? $row2['bdm_user_id'] : $row2['bcm_user_id']) . '</td>
                    <td>' . $ta_name . '</td>
                    <td>' . ($userType == 25 ? implode(', ', $bm_names) : implode(', ', $bdm_names)) . '</td>
                    <td class="message">' . $message1 . '</td>
                    <td style="text-align:center;">' . $Commi . '/-</td>
                    <td style="text-align:center;">' . $Commi_TDS . '/-</td>
                    <td style="text-align:center;">' . $Commi_Total . '/-</td>
                    <td style="text-align:center;">' . ($row2['payout_status'] == 1 ? 'Pending' : ($row2['payout_status'] == 2 ? 'Paid' : 'Blocked')) . '</td>
                </tr>';
        }

        $output .= '</table>';
        echo $output;
    } else {
        echo '<script>alert("No ' . ($payoutmessage == 'PreviousPayout' ? 'Previous' : 'Total') . ' Payout Data");window.history.back();</script>';
        
    }
}


if ($payoutmessage == 'NextPayout') {
    $output = "";

    // Prepare SQL query using placeholders
    if ($userType == 25) {
        $stmt2 = $conn->prepare("SELECT * FROM bdm_payout_history WHERE bdm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ?");
    } else if ($userType == 24) {
        $stmt2 = $conn->prepare("SELECT * FROM bcm_payout_history WHERE bcm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ?");
    }

    if (!$stmt2->execute([$user_id, $payoutYear, $payoutMonth])) {
        print_r($stmt2->errorInfo()); // Debugging: Print SQL errors
    }

    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt2->rowCount() > 0) {
        $output .= '<h2 style="text-align:center">Next Payout List as of ' . $monthName . ', ' . $payoutYear . '</h2>
        <table border="1" style="text-align:center">
            <tr>
                <th>Date</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . '</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . ' Name</th>
                <th class="mobile_view">' . ($userType == 25 ? 'Business Mentor Name and ID' : 'Business Development Manager Name and ID') . '</th>
                <th><span class="long-name">Payout Message</span></th>
                <th class="mobile_view tab_view">Amount</th>
                <th class="mobile_view">TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Status</th>
            </tr>';

        foreach ($stmt2->fetchAll() as $row2) {


            $dt = new DateTime($row2['payout_status'] == 2 || $row2['payout_status'] == 3 ? $row2['release_date'] : $row2['payout_date']);
            $dt = $dt->format('Y-m-d');

            $Commi = (int)$row2['payout_amount'];
            $Commi_TDS = $Commi * $tds_percentage;
            $Commi_Total = $Commi - $Commi_TDS;

            
            if ($userType == 25) {
                $message1 = $row2['message_bdm'] ?? '';
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 25");
                $sql1->execute([$row2['bdm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bm_user_id FROM bdm_payout_history WHERE bdm_user_id = ?");
                $sql2->execute([$row2['bdm_user_id']]);
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
                    $message1 .= ' Active BMs: ' . implode(', ', $bm_names);
                } else {
                    $message1 .= ' Active BMs: Not found';
                }
            } else if ($userType == 24) {
                $message1 = $row2['message_bdm'] ?? '';
                $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 24");
                $sql1->execute([$row2['bcm_user_id']]);
                $ta_name = $sql1->fetchColumn() ?: 'N/A';

                $sql2 = $conn->prepare("SELECT bdm_user_id FROM bcm_payout_history WHERE bcm_user_id = ?");
                $sql2->execute([$row2['bcm_user_id']]);
                $bdm_ids = $sql2->fetchColumn(); // Get the JSON string directly

                $bdm_names = [];
                if (!empty($bdm_ids)) {
                    $bdm_ids_array = is_array($bdm_ids) ? $bdm_ids : json_decode($bdm_ids, true);

                    if (is_array($bdm_ids_array) && count($bdm_ids_array) > 0) {
                        $placeholders = implode(',', array_fill(0, count($bdm_ids_array), '?')); // Generate ?,?,?
                        $sql3 = $conn->prepare("SELECT employee_id, name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");

                        $sql3->execute(array_values($bdm_ids_array));

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
                    $message1 .= ' Active BDMs: ' . implode(', ', $bdm_names);
                }else {
                    $message1 .= ' Active BDMs: Not found';
                }
            }

            $output .= '<tr>
                    <td>' .  $dt . '</td>
                    <td>' . ($userType == 25 ? $row2['bdm_user_id'] : $row2['bcm_user_id']) . '</td>
                    <td>' . $ta_name . '</td>
                    <td>' . implode(', ', $userType == 25 ? $bm_names : $bdm_names) . '</td>
                    <td class="message">' . $message1 . '</td>
                    <td style="text-align:center;">' . $Commi . '/-</td>
                    <td style="text-align:center;">' . $Commi_TDS . '/-</td>
                    <td style="text-align:center;">' . $Commi_Total . '/-</td>
                    <td style="text-align:center;">' . ($row2['payout_status'] == 1 ? 'Pending' : ($row2['payout_status'] == 2 ? 'Paid' : 'Blocked')) . '</td>
                </tr>';
        }

        $output .= '</table>';
        echo $output;
    } else {
         echo '<script>alert("No ' . ($payoutmessage == 'PreviousPayout' ? 'Previous' : 'Total') . ' Payout Data");window.history.back();</script>';
    }
}


//commeted on 1 march 2025
// if ($payoutmessage == 'PreviousPayout' || $payoutmessage == 'TotalPayout') {
//     $output = "";

//     if ($userType == 25) {
//         $stmt2 = $conn->prepare("SELECT * FROM bdm_payout_history WHERE bdm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ? AND payout_status IN (2,3)");
//     } else if ($userType == 24) {
//         $stmt2 = $conn->prepare("SELECT * FROM bcm_payout_history WHERE bcm_user_id = ? AND YEAR(payout_date) = ? AND MONTH(payout_date) = ? AND payout_status IN (2,3)");
//     }

//     $stmt2->execute([$user_id, $payoutYear, $payoutMonth]);
//     $stmt2->setFetchMode(PDO::FETCH_ASSOC);

//     if ($stmt2->rowCount() > 0) {
//         $output .= '<h2 style="text-align:center">' . ($payoutmessage == 'PreviousPayout' ? 'Previous Payout List' : 'Total Payout List') . ' as of ' . $monthName . ', ' . $payoutYear . '</h2>
//         <table border="1" style="text-align:center">
//             <tr>
//                 <th>Date</th>
//                 <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . '</th>
//                 <th class="mobile_view">' . ($userType == 25 ? 'Business Development Manager' : 'Business Channel Manager') . ' Name</th>
//                 <th class="mobile_view">' . ($userType == 25 ? 'Business Mentor' : 'Business Development Manager') . '</th>
//                 <th class="mobile_view">' . ($userType == 25 ? 'Business Mentor' : 'Business Development Manager') . ' Name</th>
//                 <th><span class="long-name">Payout Message</span></th>
//                 <th class="mobile_view tab_view">Amount</th>
//                 <th class="mobile_view">TDS</th>
//                 <th style="text-align:center;">Total Payable</th>
//                 <th style="text-align:center;">Status</th>
//             </tr>';

//         foreach ($stmt2->fetchAll() as $row2) {
//             // Determine correct payout date
//             $dt = new DateTime($row2['payout_status'] == 2 || $row2['payout_status'] == 3 ? $row2['release_date'] : $row2['payout_date']);
//             $dt = $dt->format('Y-m-d');

//             $Commi = (int)$row2['payout_amount'];
//             $Commi_TDS = $Commi * $tds_percentage;
//             $Commi_Total = $Commi - $Commi_TDS;

//             $message1 = $row2['message_bdm'] ?? '';

//             if ($userType == 25) {
//                 $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 25");
//                 $sql1->execute([$row2['bdm_user_id']]);
//                 $ta_name = $sql1->fetchColumn() ?: 'N/A';

//                 $sql2 = $conn->prepare("SELECT firstname, lastname FROM business_mentor WHERE business_mentor_id = ?");
//                 $sql2->execute([$row2['bm_user_id']]);
//                 $bmRow = $sql2->fetch(PDO::FETCH_ASSOC);
//                 $ca_name = $bmRow ? $bmRow['firstname'] . ' ' . $bmRow['lastname'] : 'N/A';
//             } else if ($userType == 24) {
//                 $sql1 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 24");
//                 $sql1->execute([$row2['bcm_user_id']]);
//                 $ta_name = $sql1->fetchColumn() ?: 'N/A';

//                 $sql2 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ? AND user_type = 24");
//                 $sql2->execute([$row2['bdm_user_id']]);
//                 $ca_name = $sql2->fetchColumn() ?: 'N/A';
//             }

//             $output .= '<tr>
//                     <td>' . $dt . '</td>
//                     <td>' . $row2['bm_user_id'] . '</td>
//                     <td>' . $ta_name . '</td>
//                     <td>' . $row2['ca_user_id'] . '</td>
//                     <td>' . $ca_name . '</td>
//                     <td class="message">' . $message1 . '</td>
//                     <td style="text-align:center;">' . $Commi . '/-</td>
//                     <td style="text-align:center;">' . $Commi_TDS . '/-</td>
//                     <td style="text-align:center;">' . $Commi_Total . '/-</td>
//                     <td style="text-align:center;">' . ($row2['payout_status'] == 2 ? 'Paid' : 'Blocked') . '</td>
//                 </tr>';
//         }

//         $output .= '</table>';
//         echo $output;
//     } else {
//         echo '<script>alert("No ' . ($payoutmessage == 'PreviousPayout' ? 'Previous' : 'Total') . ' Payout Data");</script>';
//     }
// }


// if($payoutmessage == 'allPayout'){
//     if($designation == 'travel_agent'){
//         $stmt2 = " SELECT * FROM ca_payout WHERE business_consultant = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     }else if($designation == 'corporate_agency'){
//         $stmt2 = " SELECT * FROM ca_payout WHERE corporate_agency = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     }
//     $output="";
//     $stmt2 = $conn -> prepare($stmt2);
//     $stmt2 -> execute();
//     $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
//     if($stmt2 -> rowCount()>0){
//     	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
//         <table border="1" style="text-align:center">
//             <tr>
//                 <th >Date</th>
//                 <th class="mobile_view">Business Consultant</th>
//                 <th class="mobile_view">Business Consultant Name</th>
//                 <th class="mobile_view">Corporate Agency</th>
//                 <th class="mobile_view">Corporate Agency Name</th>
//                 <th ><span class="long-name">Payout Message</th>
//                 <th ><span class="long-name">Payout Details</th>
//                 <th class="mobile_view tab_view">Amount</th>
//                 <th class="mobile_view" >TDS</th>
//                 <th style="text-align:center;">Total Payable</th>
//                 <th style="text-align:center;">Status</th>
//             </tr>';
//             foreach($stmt2->fetchAll() as $key => $row2){
//                 $rd= new DateTime($row2['created_date']);
//                 $newDate= $rd->format('d-m-Y');
//                 $id = $row2['id'];

//                 // get the commission amount of BA's
//                 $Commi = $row2['comm_amt'];

//                 (int)$Commi_TDS = (int)$Commi*5/100;
//                 (int)$Commi_Total = (int)$Commi-(int)$Commi_TDS; 


//                 // date in proper formate
//                 $dt = new DateTime($row2['created_date']);
//                 $dt = $dt->format('Y-m-d');

//                 // replace dot at end of the line with break statement
//                 $message1 = $row2['message'];
//                 $message1 =  str_replace('.','<br>',$message1); 
//                 $message2 = $row2['message_details'];
//                 $message2 =  str_replace('.','<br>',$message2); 

//                 $sql1= $conn->prepare("SELECT firstname,lastname FROM `travel_agent` where travel_agent_id='".$row2['business_consultant']."'");
//                 $sql1->execute();
//                 $sql1->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql1->rowCount()>0){
//                     foreach (($sql1->fetchAll()) as $key => $row1) {
//                         $ta_name = $row1['firstname']. ' ' .$row1['lastname'];
//                     }
//                 } 

//                 $sql2= $conn->prepare("SELECT firstname,lastname FROM `corporate_agency` where corporate_agency_id='".$row2['corporate_agency']."'");
//                 $sql2->execute();
//                 $sql2->setFetchMode(PDO::FETCH_ASSOC);
//                 if($sql2->rowCount()>0){
//                     foreach (($sql2->fetchAll()) as $key => $row3) {
//                         $ca_name = $row3['firstname']. ' ' .$row3['lastname'];
//                     }
//                 } 

//                 $output .= '<tr>
//                     <td >'.$newDate.'</td>
//                     <td>'.$row2['business_consultant'].'</td>
//                     <td>'.$ta_name.'</td>
//                     <td>'.$row2['corporate_agency'].'</td>
//                     <td>'.$ca_name.'</td>
//                     <td class="message">'.$message1.'</td>
//                     <td class="message">'.$message2.'</td>
//                     <td style="text-align:center;">'.$Commi.'/-</td>
//                     <td style="text-align:center;">'.$Commi_TDS.'/-</td>
//                     <td style="text-align:center;">'.$Commi_Total.'/-</td>';
//                     if($row2['status'] == 0){
//                         $output .='<td style="text-align:center;">Pending</td>';
//                     }else{
//                         $output .='<td style="text-align:center;">Paid</td>';
//                     }
//                 $output .='</tr>';

//             }
//         $output .= '</table>';
//         header("Content-Type: application/xls");
//         header("Content-Disposition: attachment;filename=All_Payout_List.xls");
//         echo $output;
//     }else{
//         echo 'No All Payout Data';                                                    
//     }
// }
