<?php
require '../connect.php';

$userId = $_POST["user_id"];
$user_type = $_POST['user_type'];

function date_ddmmyy($date) {
    return ($date == '0000-00-00' || empty($date)) ? 'Not Defined' : date("d-M-Y", strtotime($date));
}

function fetchReferrals($conn, $table, $refColumn, $userId) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $refColumn = ? AND status = '1'");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserdetails($conn, $table, $idColumn, $userId) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $idColumn = ? AND status = '1'");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchReferralCount($conn, $table, $refColumn, $userId) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE $refColumn = ? AND status = '1'");
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}

function fetchCustomerReferrals($conn, $userId) {
    $byRef = fetchReferrals($conn, 'ca_customer', 'reference_no', $userId);
    $byTA  = fetchReferrals($conn, 'ca_customer', 'ta_reference_no', $userId);

    $unique = [];
    foreach (array_merge($byRef, $byTA) as $cu) {
        $unique[$cu['ca_customer_id']] = $cu;
    }
    return array_values($unique);
}

function renderAccordionItemFull($label, $row, $idField, $count = 0, $isEmployee = false) {
    // echo($idField);
    // exit;
    if ($isEmployee) {
        $name = isset($row['name']) ? $row['name'] : (isset($row[$idField]) ? $row[$idField] : 'No Name');
    } else {
        $firstname = $row['firstname'] ?? '';
        $lastname = $row['lastname'] ?? '';
        $name = trim($firstname . ' ' . $lastname);
        if (empty($name)) $name = $row[$idField] ?? 'No Name';
    }
    $date = date_ddmmyy($row['register_date'] ?? '');

    echo "<button class='accordion sup-level' onclick='showPannel(this); return false;'>
            <div class='flex-container'>
                <div>$label - ($row[$idField]) $name ($count)</div>
                <div>$date</div>
            </div>
          </button>
          <div class='panel'>";
}

function noReferralsFoundMessage() {
    echo "<button class='accordion sup-level' onclick='return false;'>
            <div class='flex-container'><div>No Referrals Found</div></div>
          </button>";
}

function renderCustomerReferrals($conn, $userId, $level) {
    $referrals = fetchCustomerReferrals($conn, $userId);
    if (empty($referrals)) {
        noReferralsFoundMessage();
        return;
    }

    foreach ($referrals as $cu) {
        $subCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $cu['ca_customer_id']) +
                    fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $cu['ca_customer_id']);
        renderAccordionItemFull("CU", $cu, 'ca_customer_id', $subCount);
        renderCustomerReferrals($conn, $cu['ca_customer_id'], $level + 1);
        echo "</div>";
    }
}

echo "<div class='accordion-box' id='display-accordian' style='padding-bottom:30px'>
        <h5 class='gray sticky-h'>Referrals <a id='closee' href='#' onclick='closeBtn()' style='color:white; float:right; font-weight:600;'>X</a></h5>";

switch ($user_type) {
    case '24': // BCM
        $bdms = array_filter(fetchReferrals($conn, 'employees', 'reporting_manager', $userId), fn($e) => $e['user_type'] == 25);
        if (empty($bdms)) {
            noReferralsFoundMessage();
        } else {
            foreach ($bdms as $bdm) {
                $bdmCount = fetchReferralCount($conn, 'business_mentor', 'reference_no', $bdm['employee_id']);
                renderAccordionItemFull("BDM", $bdm, 'employee_id', $bdmCount, true);

                $bms = fetchReferrals($conn, 'business_mentor', 'reference_no', $bdm['employee_id']);
                if (empty($bms)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($bms as $bm) {
                        $teReferrals = fetchReferrals($conn, 'corporate_agency', 'reference_no', $bm['business_mentor_id']);
                        $directTCs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $bm['business_mentor_id']);
                        $bmCount = count($teReferrals) + count($directTCs);

                        renderAccordionItemFull("BM", $bm, 'business_mentor_id', $bmCount);

                        if (empty($teReferrals) && empty($directTCs)) {
                            noReferralsFoundMessage();
                        } else {
                            foreach ($teReferrals as $te) {
                                $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                                renderAccordionItemFull("TE", $te, 'corporate_agency_id', $teCount);

                                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                                if (empty($tcs)) {
                                    noReferralsFoundMessage();
                                } else {
                                    foreach ($tcs as $tc) {
                                        $tcId = $tc['ca_travelagency_id'];
                                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                                        renderCustomerReferrals($conn, $tcId, 5);
                                        echo "</div>";
                                    }
                                }
                                echo "</div>";
                            }

                            foreach ($directTCs as $tc) {
                                $tcId = $tc['ca_travelagency_id'];
                                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                                renderCustomerReferrals($conn, $tcId, 4);
                                echo "</div>";
                            }
                        }
                        echo "</div>"; // Close BM
                    }
                }
                echo "</div>"; // Close BDM
            }
        }
        break;

    case '25': // BDM
        $bms = fetchReferrals($conn, 'business_mentor', 'reference_no', $userId);
        $tes = fetchReferrals($conn, 'corporate_agency', 'reference_no', $userId);

        if (empty($bms) && empty($tes)) {
            noReferralsFoundMessage();
        } else {
            foreach ($bms as $bm) {
                $teReferrals = fetchReferrals($conn, 'corporate_agency', 'reference_no', $bm['business_mentor_id']);
                $directTCs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $bm['business_mentor_id']);
                $bmCount = count($teReferrals) + count($directTCs);

                renderAccordionItemFull("BM", $bm, 'business_mentor_id', $bmCount);

                if (empty($teReferrals) && empty($directTCs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($teReferrals as $te) {
                        $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                        renderAccordionItemFull("TE", $te, 'corporate_agency_id', $teCount);

                        $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                        if (empty($tcs)) {
                            noReferralsFoundMessage();
                        } else {
                            foreach ($tcs as $tc) {
                                $tcId = $tc['ca_travelagency_id'];
                                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                                renderCustomerReferrals($conn, $tcId, 4);
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    }

                    foreach ($directTCs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>"; // Close BM
            }

            foreach ($tes as $te) {
                $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                renderAccordionItemFull("TE", $te, 'corporate_agency_id', $teCount);

                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }
        }
        break;

    case '26': // BM
        $tes = fetchReferrals($conn, 'corporate_agency', 'reference_no', $userId);
        $fs = fetchReferrals($conn, 'sub_franchisee', 'reference_no', $userId);
        $is = fetchReferrals($conn, 'institution', 'reference_no', $userId);
        $bm_detials = fetchUserdetails($conn, 'business_mentor', 'business_mentor_id', $userId);
        $directTCs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $userId);
        $bmCount = count($tes) + count($directTCs) + count($fs) +count($is);
        
        renderAccordionItemFull("BM", $bm_detials, 'business_mentor_id', $bmCount);

        if (empty($tes) && empty($directTCs) && empty($fs) && empty($is)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tes as $te) {
                $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                renderAccordionItemFull("TE", $te, 'corporate_agency_id', $teCount);

                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['corporate_agency_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }

            foreach ($directTCs as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
            //f added on 18-04-2026 by PN
            foreach ($fs as $f) {
                $fCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $f['sub_franchisee_id']);
                renderAccordionItemFull("F", $f, 'sub_franchisee_id', $fCount);

                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $f['sub_franchisee_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }
            //I added on 18-04-2026 by PN
            foreach ($is as $i) {
                $iCount = fetchReferralCount($conn, 'institution_branch_manager', 'reference_no', $i['institution_id']);
                renderAccordionItemFull("I", $i, 'institution_id', $iCount);

                $tcs = fetchReferrals($conn, 'institution_branch_manager', 'reference_no', $i['institution_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['institution_branch_manager_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("IBR", $tc, 'institution_branch_manager_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }
        }
        echo "</div>";
        break;

    case '28': // MF
        $tes = fetchReferrals($conn, 'sub_franchisee', 'reference_no', $userId);
        $directTCs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $userId);
        $bmCount = count($tes) + count($directTCs);
        renderAccordionItemFull("MF", ['master_franchisee_id' => $userId], 'master_franchisee_id', $bmCount);

        if (empty($tes) && empty($directTCs)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tes as $te) {
                $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['sub_franchisee_id']);
                renderAccordionItemFull("F", $te, 'sub_franchisee_id', $teCount);

                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['sub_franchisee_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }

            foreach ($directTCs as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
        }
        echo "</div>";
        break;

    case '30': // SF
        $tes = fetchReferrals($conn, 'sub_franchisee', 'reference_no', $userId);
        $directTCs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $userId);
        $bmCount = count($tes) + count($directTCs);
        renderAccordionItemFull("SF", ['sponsor_franchisee_id' => $userId], 'sponsor_franchisee_id', $bmCount);

        if (empty($tes) && empty($directTCs)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tes as $te) {
                $teCount = fetchReferralCount($conn, 'ca_travelagency', 'reference_no', $te['sub_franchisee_id']);
                renderAccordionItemFull("F", $te, 'sub_franchisee_id', $teCount);

                $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $te['sub_franchisee_id']);
                if (empty($tcs)) {
                    noReferralsFoundMessage();
                } else {
                    foreach ($tcs as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                        renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                        renderCustomerReferrals($conn, $tcId, 3);
                        echo "</div>";
                    }
                }
                echo "</div>";
            }

            foreach ($directTCs as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
        }
        echo "</div>";
        break;
    
    case '16': // TE
        $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $userId);
        if (empty($tcs)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tcs as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
        }
        break;

    case '29': // F
        $tcs = fetchReferrals($conn, 'ca_travelagency', 'reference_no', $userId);
        if (empty($tcs)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tcs as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("TC", $tc, 'ca_travelagency_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
        }
        break;
    case '32': // I
        $tcs = fetchReferrals($conn, 'institution_branch_manager', 'reference_no', $userId);
        if (empty($tcs)) {
            noReferralsFoundMessage();
        } else {
            foreach ($tcs as $tc) {
                $tcId = $tc['institution_branch_manager_id'];
                $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                           fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
                renderAccordionItemFull("IBR", $tc, 'institution_branch_manager_id', $tcCount);
                renderCustomerReferrals($conn, $tcId, 2);
                echo "</div>";
            }
        }
        break;
    case '11': // TC
        $tcId = $userId;
        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
        renderAccordionItemFull("TC", ['ca_travelagency_id' => $tcId], 'ca_travelagency_id', $tcCount);
        renderCustomerReferrals($conn, $tcId, 2);
        echo "</div>";
        break;
    case '11': // IBR
        $tcId = $userId;
        $tcCount = fetchReferralCount($conn, 'ca_customer', 'reference_no', $tcId) +
                   fetchReferralCount($conn, 'ca_customer', 'ta_reference_no', $tcId);
        renderAccordionItemFull("IBR", ['institution_branch_manager_id' => $tcId], 'institution_branch_manager_id', $tcCount);
        renderCustomerReferrals($conn, $tcId, 2);
        echo "</div>";
        break;
    case '10': // Customer
        renderAccordionItemFull("CU", ['ca_customer_id' => $userId], 'ca_customer_id');
        renderCustomerReferrals($conn, $userId, 1);
        echo "</div>";
        break;

    default:
        noReferralsFoundMessage();
}

echo "</div>";
?>
