<?php
require '../../connect.php';
header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
    'data' => null
];

try {
    if (!isset($_POST['userId']) || !isset($_POST['userType'])) {
        throw new Exception('Missing required parameters');
    }

    $userId = $_POST['userId'];
    $userType = $_POST['userType'];

    $counts = [
        'pendingIBR' => 0,
        'registeredIBR' => 0,
        'deletedIBR' => 0,
        'pendingI' => 0,
        'registeredI' => 0,
        'deletedI' => 0,
        'pendingF' => 0,
        'registeredF' => 0,
        'deletedF' => 0,
        'pendingMF' => 0,
        'registeredMF' => 0,
        'deletedMF' => 0,
        'pendingSF' => 0,
        'registeredSF' => 0,
        'deletedSF' => 0,
        'pendingBM' => 0,
        'registeredBM' => 0,
        'deletedBM' => 0,
        'pendingTE' => 0,
        'registeredTE' => 0,
        'deletedTE' => 0,
        'pendingTC' => 0,
        'registeredTC' => 0,
        'deletedTC' => 0,
        'pendingCU' => 0,
        'registeredCU' => 0,
        'deletedCU' => 0
    ];
    //no active user for 24->bcm 07-04-2026
    if ($userType == '24') {
            $bdmId = $userId;

            /* =========================
            BDM -> BM
            ========================= */
            $counts['pendingBM']     += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredBM']  += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedBM']     += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            $sqlbms = "SELECT * FROM business_mentor WHERE reference_no = ?";
            $bms = $conn->prepare($sqlbms);
            $bms->execute([$bdmId]);

            foreach ($bms->fetchAll(PDO::FETCH_ASSOC) as $bm) {
                $bmId = $bm['business_mentor_id'];

                // BM -> TC
                $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$bmId]);
                $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$bmId]);
                $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

                $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                $tcs = $conn->prepare($sqltcs);
                $tcs->execute([$bmId]);
                foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                    $tcId = $tc['ca_travelagency_id'];
                    fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                }
                //BM->TE->TC
                $counts['pendingTE']     += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '2'", [$bdmId]);
                $counts['registeredTE']  += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '1'", [$bdmId]);
                $counts['deletedTE']     += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);
                $sqltcs = "SELECT * FROM corporate_agency WHERE reference_no = ?";
                $tes = $conn->prepare($sqltcs);
                $tes->execute([$bmId]);
                foreach ($tes->fetchAll(PDO::FETCH_ASSOC) as $te) {
                    $teId=$te['corporate_agency_id'];
                    $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$teId]);
                    $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$teId]);
                    $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$teId]);
    
                    $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                    $tcs = $conn->prepare($sqltcs);
                    $tcs->execute([$teId]);
                    foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                    }
                }
            }

            /* =========================
            BDM -> TE
            ========================= */
            $counts['pendingTE']     += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredTE']  += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedTE']     += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            $sqltes = "SELECT * FROM corporate_agency WHERE reference_no = ?";
            $tes = $conn->prepare($sqltes);
            $tes->execute([$bdmId]);

            foreach ($tes->fetchAll(PDO::FETCH_ASSOC) as $te) {
                $teId = $te['corporate_agency_id'];

                // TE -> TC
                $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$teId]);
                $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$teId]);
                $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$teId]);

                $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                $tcs = $conn->prepare($sqltcs);
                $tcs->execute([$teId]);
                foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                    $tcId = $tc['ca_travelagency_id'];
                    fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                }
            }

            /* =========================
            BDM -> MF
            ========================= */
            $counts['pendingMF']     += getCount($conn, "SELECT count(*) as cnt FROM master_franchisee WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredMF']  += getCount($conn, "SELECT count(*) as cnt FROM master_franchisee WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedMF']     += getCount($conn, "SELECT count(*) as cnt FROM master_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            $sqlmfs = "SELECT * FROM master_franchisee WHERE reference_no = ?";
            $mfs = $conn->prepare($sqlmfs);
            $mfs->execute([$bdmId]);

            foreach ($mfs->fetchAll(PDO::FETCH_ASSOC) as $mf) {
                $mfId = $mf['master_franchisee_id'];

                // MF -> TC
                $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$mfId]);
                $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$mfId]);
                $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$mfId]);

                // MF -> F
                $counts['pendingF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '2'", [$mfId]);
                $counts['registeredF']  += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '1'", [$mfId]);
                $counts['deletedF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$mfId]);

                $sqlfs = "SELECT * FROM sub_franchisee WHERE reference_no = ?";
                $fs = $conn->prepare($sqlfs);
                $fs->execute([$mfId]);
                foreach ($fs->fetchAll(PDO::FETCH_ASSOC) as $f) {
                    $fId = $f['sub_franchisee_id'];

                    // F -> TC
                    $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$fId]);
                    $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$fId]);
                    $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$fId]);

                    $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                    $tcs = $conn->prepare($sqltcs);
                    $tcs->execute([$fId]);
                    foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                    }
                }
            }

            /* =========================
            BDM -> SF
            ========================= */
            $counts['pendingSF']     += getCount($conn, "SELECT count(*) as cnt FROM sponsor_franchisee WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredSF']  += getCount($conn, "SELECT count(*) as cnt FROM sponsor_franchisee WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedSF']     += getCount($conn, "SELECT count(*) as cnt FROM sponsor_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            $sqlsfs = "SELECT * FROM sponsor_franchisee WHERE reference_no = ?";
            $sfs = $conn->prepare($sqlsfs);
            $sfs->execute([$bdmId]);

            foreach ($sfs->fetchAll(PDO::FETCH_ASSOC) as $sf) {
                $sfId = $sf['sponsor_franchisee_id'];

                // SF -> F
                $counts['pendingF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '2'", [$sfId]);
                $counts['registeredF']  += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '1'", [$sfId]);
                $counts['deletedF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$sfId]);

                $sqlfs = "SELECT * FROM sub_franchisee WHERE reference_no = ?";
                $fs = $conn->prepare($sqlfs);
                $fs->execute([$sfId]);
                foreach ($fs->fetchAll(PDO::FETCH_ASSOC) as $f) {
                    $fId = $f['sub_franchisee_id'];

                    // F -> TC
                    $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$fId]);
                    $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$fId]);
                    $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$fId]);

                    $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                    $tcs = $conn->prepare($sqltcs);
                    $tcs->execute([$fId]);
                    foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                        $tcId = $tc['ca_travelagency_id'];
                        fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                    }
                }
            }

            /* =========================
            BDM -> F
            ========================= */
            $counts['pendingF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredF']  += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedF']     += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            $sqlfs = "SELECT * FROM sub_franchisee WHERE reference_no = ?";
            $fs = $conn->prepare($sqlfs);
            $fs->execute([$bdmId]);
            foreach ($fs->fetchAll(PDO::FETCH_ASSOC) as $f) {
                $fId = $f['sub_franchisee_id'];

                // F -> TC
                $counts['pendingTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$fId]);
                $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$fId]);
                $counts['deletedTC']    += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$fId]);

                $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                $tcs = $conn->prepare($sqltcs);
                $tcs->execute([$fId]);
                foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                    $tcId = $tc['ca_travelagency_id'];
                    fetchCustomerCounts($conn, $tcId, $counts); // TC -> CU
                }
            }

    }

    elseif ($userType == '25') {
            $bmId = $userId;

            // ---- TC counts (under BM) ----
            $counts['pendingTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredTC']+= getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

            $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            $tcs = $conn->prepare($sqltcs);
            $tcs->execute([$bmId]);
            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                // TC -> CU
                fetchCustomerCounts($conn, $tcId, $counts);
            }

            // ---- TE counts (under BM) ----
            $counts['pendingTE']   += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredTE']+= getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedTE']   += getCount($conn, "SELECT count(*) as cnt FROM corporate_agency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

            $sqltes = "SELECT * FROM corporate_agency WHERE reference_no = ?";
            $tes = $conn->prepare($sqltes);
            $tes->execute([$bmId]);
            foreach ($tes->fetchAll(PDO::FETCH_ASSOC) as $te) {
                $teId = $te['corporate_agency_id'];
                // TE -> CU
                fetchCustomerCounts($conn, $teId, $counts);
            }

            // ---- F counts (under BM) ----
            $counts['pendingF']   += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredF']+= getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedF']   += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

            $sqlfs = "SELECT * FROM sub_franchisee WHERE reference_no = ?";
            $fs = $conn->prepare($sqlfs);
            $fs->execute([$bmId]);
            foreach ($fs->fetchAll(PDO::FETCH_ASSOC) as $f) {
                $fId = $f['sub_franchisee_id'];
                // F -> CU
                fetchCustomerCounts($conn, $fId, $counts);
            }

    }

    elseif ($userType == '26') {
        $prefix=(substr($userId,0,1) == 'F' || substr($userId,0,1) == 'I') ? substr($userId,0,1) : substr($userId,0,2);
        if ($prefix == 'F' || $prefix == 'TE' || $prefix == 'CA') {
            // ---- TC counts (under BM) ----
            $counts['pendingTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredTC']+= getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);

            // F -> TC
            $tcs = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ?");
            $tcs->execute([$userId]);

            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                fetchCustomerCounts($conn, $tc['ca_travelagency_id'], $counts);
            }
        }elseif ($prefix == 'I') {
            // =====================================
            //  I -> IBR
            // =====================================

            $counts['pendingIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredIBR']+= getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);

            $ibrs = $conn->prepare("SELECT * FROM institution_branch_manager WHERE reference_no = ?");
            $ibrs->execute([$userId]);

            foreach ($ibrs->fetchAll(PDO::FETCH_ASSOC) as $ibr) {
                $ibrId = $ibr['institution_branch_manager_id'];

                // IBR -> CU
                fetchCustomerCounts($conn, $ibrId, $counts);
            }
        }elseif ($prefix == 'TA') {
            fetchCustomerCounts($conn, $userId, $counts);
        }
    }elseif ($userType == '16' || $userType == '32' || $userType == '29') {
        fetchCustomerCounts($conn, $userId, $counts);
    }
    else if($userType == '28'){
        $prefix=substr($userId,0,1)=='I' || substr($userId,0,1)=='F' ? substr($userId,0,1) : substr($userId,0,2);
        if ($prefix == 'TA') {
            // TC -> CU
            fetchCustomerCounts($conn, $userId, $counts);
        }elseif ($prefix == 'F') {
            //TC count
            $counts['pendingTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);
            // BM -> TC
            $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            $tcs = $conn->prepare($sqltcs);
            $tcs->execute([$userId]);
            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                // TC -> CU
                fetchCustomerCounts($conn, $tcId, $counts);
            }
        }elseif ($prefix == 'I') {
            // =====================================
            //  I -> IBR
            // =====================================

            $counts['pendingIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredIBR']+= getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);

            $ibrs = $conn->prepare("SELECT * FROM institution_branch_manager WHERE reference_no = ?");
            $ibrs->execute([$userId]);

            foreach ($ibrs->fetchAll(PDO::FETCH_ASSOC) as $ibr) {
                $ibrId = $ibr['institution_branch_manager_id'];

                // IBR -> CU
                fetchCustomerCounts($conn, $ibrId, $counts);
            }
        }
    }else if($userType == '30'){
        $prefix=substr($userId,0,1);

        if ($prefix == 'F') {
            //TC count
            $counts['pendingTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);
            // BM -> TC
            $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            $tcs = $conn->prepare($sqltcs);
            $tcs->execute([$userId]);
            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                // TC -> CU
                fetchCustomerCounts($conn, $tcId, $counts);
            }
        }elseif ($prefix == 'I') {
            // =====================================
            //  I -> IBR
            // =====================================

            $counts['pendingIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '2'", [$userId]);
            $counts['registeredIBR']+= getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND status = '1'", [$userId]);
            $counts['deletedIBR']   += getCount($conn, "SELECT count(*) as cnt FROM institution_branch_manager WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);

            $ibrs = $conn->prepare("SELECT * FROM institution_branch_manager WHERE reference_no = ?");
            $ibrs->execute([$userId]);

            foreach ($ibrs->fetchAll(PDO::FETCH_ASSOC) as $ibr) {
                $ibrId = $ibr['institution_branch_manager_id'];

                // IBR -> CU
                fetchCustomerCounts($conn, $ibrId, $counts);
            }
        }
    }
    //no active user for 31->RM 07-04-2026
    elseif ($userType == '31') {
            $bmId = $userId;

            // ---- TC counts (under MF/SF) ----
            $counts['pendingTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredTC']+= getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedTC']   += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

            $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            $tcs = $conn->prepare($sqltcs);
            $tcs->execute([$bmId]);
            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                // TC -> CU
                fetchCustomerCounts($conn, $tcId, $counts);
            }

            // ---- F counts (under MF/SF) ----
            $counts['pendingF']   += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredF']+= getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedF']   += getCount($conn, "SELECT count(*) as cnt FROM sub_franchisee WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);

            $sqlfs = "SELECT * FROM sub_franchisee WHERE reference_no = ?";
            $fs = $conn->prepare($sqlfs);
            $fs->execute([$bmId]);
            foreach ($fs->fetchAll(PDO::FETCH_ASSOC) as $f) {
                $fId = $f['sub_franchisee_id'];
                // F -> CU
                fetchCustomerCounts($conn, $fId, $counts);
            }

            // ---- Direct role-specific counts (when logged user is TE, TC, F, CU, etc.) ----
            $userPrefix = substr($userId, 0, 1) == 'F' ? substr($userId, 0, 1) : substr($userId, 0, 2);

            if ($userPrefix == 'TA') {
                // Direct TC
                fetchCustomerCounts($conn, $userId, $counts);
            }
            
            elseif ($userPrefix == 'F') { // adjust if sub_franchisee prefix differs
                // Direct F
                fetchCustomerCounts($conn, $userId, $counts);
            }
            elseif ($userPrefix == 'CU') {
                // Direct customer
                $counts['registeredCU']++;
            }

    }

    $response = [
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'data' => $counts
    ];

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    echo json_encode($response);
}


// Helper: get count from query
function getCount($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['cnt'];
}

// Recursive CU fetch
function fetchCustomerCounts($conn, $refCuId, &$counts) {
    // TC -> CU
    $sql = "SELECT * FROM ca_customer WHERE ta_reference_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$refCuId]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $cu) {
        $cuId = $cu['ca_customer_id'];
        $status = $cu['status'];
        if ($status == '1') $counts['registeredCU']++;
        elseif ($status == '2') $counts['pendingCU']++;
        elseif ($status == '0' || $status == '3') $counts['deletedCU']++;

        // Recursive: CU -> CU
        fetchRecursiveCustomers($conn, $cuId, $counts);
    }
}

function fetchRecursiveCustomers($conn, $refId, &$counts) {
    $sql = "SELECT * FROM ca_customer WHERE reference_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$refId]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $cu) {
        $cuId = $cu['ca_customer_id'];
        $status = $cu['status'];
        if ($status == '1') $counts['registeredCU']++;
        elseif ($status == '2') $counts['pendingCU']++;
        elseif ($status == '0' || $status == '3') $counts['deletedCU']++;

        // Recursive step
        fetchRecursiveCustomers($conn, $cuId, $counts);
    }
}
/*
    Last upadted on 07-04-2026 by SV
    changes in usertype 25,26,28,30 to incorporate new usertype 32-I,33-IBR
    Please upadate this section before pushing to code to git if code is eddited
*/