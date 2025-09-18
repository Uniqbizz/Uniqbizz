<?php    
require '../connect.php';

$formdata = stripslashes(file_get_contents("php://input"));
$get_data = json_decode($formdata, true);

$get_year = $get_data['year'];
$current_year = $get_data['current_year'];
$current_month = $get_data['current_month'];
$user_id = $get_data['user_id'];
$user_type = $get_data['user_type'];

function monthlyChartData($conn, $reference_no, $get_year, $current_year, $current_month, $user_type,$user_id){
    $data = array_fill(0, 12, 0);

    $tableMap = [
        '3'  => 'corporate_agency',
        '10' => 'ca_customer',
        '11' => 'ca_customer',
        '15' => 'ca_travelagency',
        '16' => 'ca_travelagency',
        '18' => 'business_consultant',
        '19' => 'business_operation_executive',
        '20' => 'training_manager',
        '21' => 'sales_executive'
    ];

    $columnMap = [
        '11' => 'ta_reference_no'
    ];

    if (array_key_exists($user_type, $tableMap)) {
        $table = $tableMap[$user_type];
        $refCol = $columnMap[$user_type] ?? 'reference_no';
        if($user_type == '16'){
            $sql = "SELECT MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
                FROM $table 
                LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = '" . $user_id . "'
                WHERE ($refCol = :reference_no OR tm.te_id = '" . $user_id . "') AND status = '1'";
        }else{
            $sql = "SELECT MONTH(register_date) AS start_month, YEAR(register_date) AS start_year 
                    FROM $table 
                    WHERE $refCol = :reference_no AND status = '1'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute([':reference_no' => $reference_no]);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if ($row['start_year'] == $get_year) {
                $data[$row['start_month'] - 1] += 1;
            }
        }

        if ($current_year == $get_year) {
            array_splice($data, $current_month);
        }
    }

    return $data;
}

// Special case for BCM → return 3 separate arrays
if ($user_type == '24') {
    $months = 12;
    // Initialize arrays for all levels
    $bdm = $bm = $te = $f = $tc = $cu = $mf = $sf = array_fill(0, $months, 0);

    // 1. Count BDMs under BCM
    $sql = "
        SELECT YEAR(register_date) AS y, MONTH(register_date) AS m, COUNT(*) AS cnt
        FROM employees
        WHERE reporting_manager = :ref
          AND status = '1'
          AND user_type = 25
          AND YEAR(register_date) = :get_year
        GROUP BY YEAR(register_date), MONTH(register_date)
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref'=>$user_id, ':get_year'=>$get_year]);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $bdm[$row['m']-1] = (int)$row['cnt'];
    }

    // 2. Aggregate all entities across paths
    $sql = " SELECT user_type, y, m, SUM(cnt) AS cnt
                FROM (
                    -- 1. BDMs under BCM
                    SELECT 'BDM' AS user_type, YEAR(bdm.register_date) AS y, MONTH(bdm.register_date) AS m, COUNT(*) AS cnt
                    FROM employees AS bdm
                    WHERE bdm.reporting_manager = :ref 
                    AND bdm.user_type = 25 
                    AND bdm.status = '1'
                    AND YEAR(bdm.register_date) = :get_year
                    GROUP BY YEAR(bdm.register_date), MONTH(bdm.register_date)

                    UNION ALL

                    -- 2. BM under BDM
                    SELECT 'BM', YEAR(bm.register_date), MONTH(bm.register_date), COUNT(DISTINCT bm.id)
                    FROM employees AS bdm
                    JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
                    WHERE bdm.reporting_manager = :ref 
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND bm.user_type = 26 AND bm.status = '1'
                    AND YEAR(bm.register_date) = :get_year
                    GROUP BY YEAR(bm.register_date), MONTH(bm.register_date)

                    UNION ALL

                    -- 3. TE under BDM or BM
                    SELECT 'TE', YEAR(te.register_date), MONTH(te.register_date), COUNT(DISTINCT te.id)
                    FROM employees AS bdm
                    LEFT JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
                    LEFT JOIN corporate_agency AS te ON te.reference_no IN (bdm.employee_id, bm.business_mentor_id)
                    WHERE bdm.reporting_manager = :ref
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND te.status = '1'
                    AND YEAR(te.register_date) = :get_year
                    GROUP BY YEAR(te.register_date), MONTH(te.register_date)

                    UNION ALL

                    -- 4. Sub-Franchisees (F) under all paths: BDM→F, MF→F, SF→F
                    SELECT 'F' AS user_type, YEAR(f_date) AS y, MONTH(f_date) AS m, COUNT(DISTINCT f_id) AS cnt
                    FROM (
                        SELECT f_bdm.sub_franchisee_id AS f_id, f_bdm.register_date AS f_date
                        FROM employees AS bdm
                        JOIN sub_franchisee AS f_bdm ON f_bdm.reference_no = bdm.employee_id
                        WHERE bdm.reporting_manager = :ref AND bdm.user_type = 25 AND bdm.status = '1' AND f_bdm.status = '1' AND YEAR(f_bdm.register_date) = :get_year

                        UNION ALL

                        SELECT f_mf.sub_franchisee_id AS f_id, f_mf.register_date AS f_date
                        FROM employees AS bdm
                        JOIN master_franchisee AS mf ON mf.reference_no = bdm.employee_id
                        JOIN sub_franchisee AS f_mf ON f_mf.reference_no = mf.master_franchisee_id
                        WHERE bdm.reporting_manager = :ref AND bdm.user_type = 25 AND bdm.status = '1' AND mf.status = '1' AND f_mf.status = '1' AND YEAR(f_mf.register_date) = :get_year

                        UNION ALL

                        SELECT f_sf.sub_franchisee_id AS f_id, f_sf.register_date AS f_date
                        FROM employees AS bdm
                        JOIN sponsor_franchisee AS sf ON sf.reference_no = bdm.employee_id
                        JOIN sub_franchisee AS f_sf ON f_sf.reference_no = sf.sponsor_franchisee_id
                        WHERE bdm.reporting_manager = :ref AND bdm.user_type = 25 AND bdm.status = '1' AND sf.status = '1' AND f_sf.status = '1' AND YEAR(f_sf.register_date) = :get_year
                    ) AS all_f
                    GROUP BY YEAR(f_date), MONTH(f_date)

                    UNION ALL

                    -- 5. Master Franchisee (MF)
                    SELECT 'MF', YEAR(mf.register_date), MONTH(mf.register_date), COUNT(DISTINCT mf.master_franchisee_id)
                    FROM employees AS bdm
                    JOIN master_franchisee AS mf ON mf.reference_no = bdm.employee_id
                    WHERE bdm.reporting_manager = :ref
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND mf.status = '1'
                    AND YEAR(mf.register_date) = :get_year
                    GROUP BY YEAR(mf.register_date), MONTH(mf.register_date)

                    UNION ALL

                    -- 6. Sponsor Franchisee (SF)
                    SELECT 'SF', YEAR(sf.register_date), MONTH(sf.register_date), COUNT(DISTINCT sf.sponsor_franchisee_id)
                    FROM employees AS bdm
                    JOIN sponsor_franchisee AS sf ON sf.reference_no = bdm.employee_id
                    WHERE bdm.reporting_manager = :ref
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND sf.status = '1'
                    AND YEAR(sf.register_date) = :get_year
                    GROUP BY YEAR(sf.register_date), MONTH(sf.register_date)

                    UNION ALL

                    -- 7. TC from all paths
                    SELECT 'TC', YEAR(tc.register_date), MONTH(tc.register_date), COUNT(DISTINCT tc.ca_travelagency_id)
                    FROM employees AS bdm
                    LEFT JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
                    LEFT JOIN corporate_agency AS te ON te.reference_no = bm.business_mentor_id
                    LEFT JOIN sub_franchisee AS f ON f.reference_no = bdm.employee_id
                    LEFT JOIN master_franchisee AS mf ON mf.reference_no = bdm.employee_id
                    LEFT JOIN sponsor_franchisee AS sf ON sf.reference_no = bdm.employee_id
                    LEFT JOIN sub_franchisee AS f2 ON sf.sponsor_franchisee_id = f2.sub_franchisee_id -- SF → F path
                    JOIN ca_travelagency AS tc 
                    ON tc.reference_no IN (
                            bdm.employee_id, 
                            bm.business_mentor_id, 
                            te.corporate_agency_id, 
                            f.sub_franchisee_id, 
                            mf.master_franchisee_id, 
                            sf.sponsor_franchisee_id,
                            f2.sub_franchisee_id
                        )
                    WHERE bdm.reporting_manager = :ref
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND tc.status = '1'
                    AND YEAR(tc.register_date) = :get_year
                    GROUP BY YEAR(tc.register_date), MONTH(tc.register_date)

                    UNION ALL

                    -- 8. CU via all TCs from all paths
                    SELECT 'CU', YEAR(c.register_date), MONTH(c.register_date), COUNT(DISTINCT c.ca_customer_id)
                    FROM employees AS bdm
                    LEFT JOIN business_mentor AS bm ON bm.reference_no = bdm.employee_id
                    LEFT JOIN corporate_agency AS te ON te.reference_no = bm.business_mentor_id
                    LEFT JOIN sub_franchisee AS f ON f.reference_no = bdm.employee_id
                    LEFT JOIN master_franchisee AS mf ON mf.reference_no = bdm.employee_id
                    LEFT JOIN sponsor_franchisee AS sf ON sf.reference_no = bdm.employee_id
                    LEFT JOIN sub_franchisee AS f2 ON sf.sponsor_franchisee_id = f2.sub_franchisee_id -- SF → F path
                    LEFT JOIN ca_travelagency AS tc 
                    ON tc.reference_no IN (
                            bdm.employee_id, 
                            bm.business_mentor_id, 
                            te.corporate_agency_id, 
                            f.sub_franchisee_id, 
                            mf.master_franchisee_id, 
                            sf.sponsor_franchisee_id,
                            f2.sub_franchisee_id
                        )
                    LEFT JOIN ca_customer AS c ON c.ta_reference_no = tc.ca_travelagency_id
                    WHERE bdm.reporting_manager = :ref
                    AND bdm.user_type = 25 AND bdm.status = '1'
                    AND tc.status = '1'
                    AND c.status = '1'
                    AND YEAR(c.register_date) = :get_year
                    GROUP BY YEAR(c.register_date), MONTH(c.register_date)

                ) AS t
                GROUP BY user_type, y, m
                ORDER BY user_type, y, m";


    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':ref' => $user_id,
        ':get_year' => $get_year
    ]);
//tc and ci are not coming


    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        switch($row['user_type']){
            case 'BM': $bm[$row['m']-1] = (int)$row['cnt']; break;
            case 'TE': $te[$row['m']-1] = (int)$row['cnt']; break;
            case 'F': $f[$row['m']-1] = (int)$row['cnt']; break;
            case 'MF': $mf[$row['m']-1] = (int)$row['cnt']; break;
            case 'SF': $sf[$row['m']-1] = (int)$row['cnt']; break;
            case 'TC': $tc[$row['m']-1] = (int)$row['cnt']; break;
            case 'CU': $cu[$row['m']-1] = (int)$row['cnt']; break;
        }
    }

    // Trim arrays for current year
    if ($current_year == $get_year) {
        array_splice($bdm, $current_month);
        array_splice($bm, $current_month);
        array_splice($te, $current_month);
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
        array_splice($cu, $current_month);
        array_splice($mf, $current_month);
        array_splice($sf, $current_month);
    }

    echo json_encode([$bdm, $bm, $te, $f, $tc, $cu, $mf, $sf]);
} else if ($user_type == '25') {
    function incrementUnique(&$arr, &$seen, $id, $date, $get_year) {
        if (isset($seen[$id])) return; // Already counted

        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        if ($year == $get_year) {
            $arr[$month - 1]++;
            $seen[$id] = $date; // Mark ID as seen with its date
        }
    }

    function getUniqueTCsByRefs($conn, $ids, $get_year, &$tc, &$seenTCs) {
        if (empty($ids)) return;

        $inClause = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT ca_travelagency_id, register_date 
                FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status='1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ids);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            incrementUnique($tc, $seenTCs, $row['ca_travelagency_id'], $row['register_date'], $get_year);
        }
    }

    // Init arrays
    $bm = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);
    $te = array_fill(0, 12, 0);
    $f = array_fill(0, 12, 0);

    // Seen trackers (associative arrays for uniqueness)
    $seenBMs = [];
    $seenTEs = [];
    $seenFs  = [];
    $seenTCs = [];

    // 1. Direct BMs
    $sql = "SELECT business_mentor_id, register_date 
            FROM business_mentor 
            WHERE reference_no=:ref AND user_type=26 AND status='1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    $bmRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bmRows as $row) {
        incrementUnique($bm, $seenBMs, $row['business_mentor_id'], $row['register_date'], $get_year);
    }
    // BM → TC
    getUniqueTCsByRefs($conn, array_column($bmRows, 'business_mentor_id'), $get_year, $tc, $seenTCs);

    // BM → TE → TC
    if (!empty($bmRows)) {
        $sql = "SELECT corporate_agency_id, register_date 
                FROM corporate_agency 
                WHERE reference_no IN (" . implode(',', array_fill(0, count($bmRows), '?')) . ") 
                AND user_type=16 AND status='1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array_column($bmRows, 'business_mentor_id'));
        $bmTeRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($bmTeRows as $row) {
            incrementUnique($te, $seenTEs, $row['corporate_agency_id'], $row['register_date'], $get_year);
        }
        getUniqueTCsByRefs($conn, array_column($bmTeRows, 'corporate_agency_id'), $get_year, $tc, $seenTCs);
    }

    // 2. Direct TEs
    $sql = "SELECT corporate_agency_id, register_date 
            FROM corporate_agency 
            WHERE reference_no=:ref AND user_type=16 AND status='1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    $teRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($teRows as $row) {
        incrementUnique($te, $seenTEs, $row['corporate_agency_id'], $row['register_date'], $get_year);
    }
    // TE → TC
    getUniqueTCsByRefs($conn, array_column($teRows, 'corporate_agency_id'), $get_year, $tc, $seenTCs);

    // 3. Direct Fs
    $sql = "SELECT sub_franchisee_id, register_date 
            FROM sub_franchisee 
            WHERE reference_no=:ref AND user_type=30 AND status='1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);
    $fRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fRows as $row) {
        incrementUnique($f, $seenFs, $row['sub_franchisee_id'], $row['register_date'], $get_year);
    }
    // F → TC
    getUniqueTCsByRefs($conn, array_column($fRows, 'sub_franchisee_id'), $get_year, $tc, $seenTCs);

    // 4. Direct TCs from BDM
    $sql = "SELECT ca_travelagency_id, register_date 
            FROM ca_travelagency 
            WHERE reference_no=:ref AND status='1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        incrementUnique($tc, $seenTCs, $row['ca_travelagency_id'], $row['register_date'], $get_year);
    }

    // Trim arrays if current year
    if ($current_year == $get_year) {
        array_splice($bm, $current_month);
        array_splice($te, $current_month);
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
    }

    echo json_encode([$bm, $te,$f, $tc]);


} else if ($user_type == '26') {
    // For BM → TC only
    $tc = array_fill(0, 12, 0);

    $sql = "SELECT register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
    }

    if ($current_year == $get_year) {
        array_splice($tc, $current_month);
    }

    echo json_encode([ $tc ]);
} else if($user_type == '28'){
    $f = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);

    //for MF -> F only
    $sql = "SELECT sub_franchisee_id, register_date FROM sub_franchisee 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $fRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $f[$month - 1]++;
        }
    }

    // Get TCs under those Fs
    $fIds = array_column($fRows, 'sub_franchisee_id');
    if (!empty($fIds)) {
        $inClause = implode(',', array_fill(0, count($fIds), '?'));
        $sql = "SELECT register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($fIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
        }
    }
    
    // For MF → TC only
    $tc = array_fill(0, 12, 0);

    $sql = "SELECT register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
    }

    if ($current_year == $get_year) {
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
    }
    echo json_encode([ $f, $tc ]);
}else if($user_type == '30'){
    $f = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);

    //for SF -> F only
    $sql = "SELECT sub_franchisee_id, register_date FROM sub_franchisee 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $fRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $f[$month - 1]++;
        }
    }
    // Get TCs under those Fs
    $fIds = array_column($fRows, 'sub_franchisee_id');
    if (!empty($fIds)) {
        $inClause = implode(',', array_fill(0, count($fIds), '?'));
        $sql = "SELECT register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($fIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
        }
    }
    if ($current_year == $get_year) {
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
    }
    echo json_encode([ $f, $tc ]);
}else if ($user_type == '31') {
    // For RM → MF/SF → F-> TC
    $bm = array_fill(0, 12, 0);
    $te = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);

    // Get direct MFs/SFs
    $sql = "SELECT master_franchisee_id AS id, register_date FROM master_franchisee 
            WHERE reference_no = :ref AND user_type = 28 AND status = '1'
            UNION
            SELECT sponsor_franchisee_id AS id, register_date FROM sponsor_franchisee 
            WHERE reference_no = :ref AND user_type = 30 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $bmRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bmRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $bm[$month - 1]++;
        }
    }

    // Get TCs under those MFs/SFs
    $bmIds = array_column($bmRows, 'id');
    if (!empty($bmIds)) {
        $inClause = implode(',', array_fill(0, count($bmIds), '?'));
        $sql = "SELECT register_date,sub_franchisee_id AS id FROM sub_franchisee 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($bmIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $te[$month - 1]++;

            }
            $fIds = array_column($rows, 'id');
            $inClause = implode(',', array_fill(0, count($fIds), '?'));
            $sql = "SELECT register_date FROM ca_travelagency 
                    WHERE reference_no IN ($inClause) AND status = '1'";
            $stmt = $conn->prepare($sql);
            $stmt->execute($fIds);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $tc[$month - 1]++;
                }
            }
        }
    }
    // // Get TC from BDM
    // $sql = "SELECT register_date FROM ca_travelagency 
    //         WHERE reference_no = :ref AND status = '1'";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute([':ref' => $user_id]);

    // $bmRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // foreach ($bmRows as $row) {
    //     $year = date('Y', strtotime($row['register_date']));
    //     $month = date('n', strtotime($row['register_date']));
    //     if ($year == $get_year) {
    //         $tc[$month - 1]++;
    //     }
    // }

    if ($current_year == $get_year) {
        array_splice($bm, $current_month);
        array_splice($te, $current_month);
        array_splice($tc, $current_month);
    }

    echo json_encode([ $bm,$te, $tc ]);

} else {
    // fallback for other users
    $data = monthlyChartData($conn, $user_id, $get_year, $current_year, $current_month, $user_type,$user_id);
    echo json_encode([$data]);
}
?>
