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

    if ($userType == '24') {
            $bdmId = $userId;

            // BM count
            $counts['pendingBM'] += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND status = '2'", [$bdmId]);
            $counts['registeredBM'] += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND status = '1'", [$bdmId]);
            $counts['deletedBM'] += getCount($conn, "SELECT count(*) as cnt FROM business_mentor WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);
            // BDM -> BM
            $sqlbms = "SELECT * FROM business_mentor WHERE reference_no = ?";
            $bms = $conn->prepare($sqlbms);
            $bms->execute([$bdmId]);
            foreach ($bms->fetchAll(PDO::FETCH_ASSOC) as $bm) {
                $bmId = $bm['business_mentor_id'];
                //TC count
                $counts['pendingTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$bmId]);
                $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$bmId]);
                $counts['deletedTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);
                // BM -> TC
                $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
                $tcs = $conn->prepare($sqltcs);
                $tcs->execute([$bmId]);
                foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                    $tcId = $tc['ca_travelagency_id'];
                    // TC -> CU
                    fetchCustomerCounts($conn, $tcId, $counts);
                }
            }

            // // BDM -> TE
            // $sqltes = "SELECT * FROM corp WHERE reference_no = ?";
            // $tes = $conn->prepare($sqltes);
            // $tes->execute([$bdmId]);
            // foreach ($tes->fetchAll(PDO::FETCH_ASSOC) as $te) {
            //     $teId = $te['ca_te_id'];

            //     $counts['pendingTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND status = '2'", [$bdmId]);
            //     $counts['registeredTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND status = '1'", [$bdmId]);
            //     $counts['deletedTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bdmId]);

            //     // TE -> TC
            //     $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            //     $tcs = $conn->prepare($sqltcs);
            //     $tcs->execute([$teId]);
            //     foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
            //         $tcId = $tc['ca_travelagency_id'];

            //         $counts['pendingTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$teId]);
            //         $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$teId]);
            //         $counts['deletedTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$teId]);

            //         // TC -> CU
            //         fetchCustomerCounts($conn, $tcId, $counts);
            //     }
            // }
    }

    elseif ($userType == '25') {
            $bmId = $userId;

            //TC count
            $counts['pendingTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '2'", [$bmId]);
            $counts['registeredTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND status = '1'", [$bmId]);
            $counts['deletedTC'] += getCount($conn, "SELECT count(*) as cnt FROM ca_travelagency WHERE reference_no = ? AND (status = '0' OR status = '3')", [$bmId]);
            // BM -> TC
            $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
            $tcs = $conn->prepare($sqltcs);
            $tcs->execute([$bmId]);
            foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
                $tcId = $tc['ca_travelagency_id'];
                // TC -> CU
                fetchCustomerCounts($conn, $tcId, $counts);
            }

        // // BDM -> TE
        // $sqltes = "SELECT * FROM ca_te WHERE reference_no = ?";
        // $tes = $conn->prepare($sqltes);
        // $tes->execute([$userId]);
        // foreach ($tes->fetchAll(PDO::FETCH_ASSOC) as $te) {
        //     $teId = $te['ca_te_id'];

        //     $counts['pendingTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND status = '2'", [$userId]);
        //     $counts['registeredTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND status = '1'", [$userId]);
        //     $counts['deletedTE'] += getCount($conn, "SELECT count(*) as cnt FROM ca_te WHERE reference_no = ? AND (status = '0' OR status = '3')", [$userId]);

        //     $sqltcs = "SELECT * FROM ca_travelagency WHERE reference_no = ?";
        //     $tcs = $conn->prepare($sqltcs);
        //     $tcs->execute([$teId]);
        //     foreach ($tcs->fetchAll(PDO::FETCH_ASSOC) as $tc) {
        //         fetchCustomerCounts($conn, $tc['ca_travelagency_id'], $counts);
        //     }
        // }
    }

    elseif ($userType == '26') {
        fetchCustomerCounts($conn, $userId, $counts);
        
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
