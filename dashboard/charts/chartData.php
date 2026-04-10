<?php    
require '../connect.php';

$formdata = stripslashes(file_get_contents("php://input"));
$get_data = json_decode($formdata, true);

$get_year = $get_data['year'];
$current_year = $get_data['current_year'];
$current_month = $get_data['current_month'];
$user_id = $get_data['user_id'];
$user_type = $get_data['user_type'];

function monthlyChartData($conn, $reference_no, $get_year, $current_year, $current_month, $user_type, $user_id){
    $data = array_fill(0, 12, 0);

    try {

        // =========================
        // 🎯 TC (11) → CU
        // =========================
        if ($user_type == '11') {

            $sql = "
                SELECT 
                    MONTH(register_date) AS m,
                    COUNT(*) AS total
                FROM ca_customer
                WHERE ta_reference_no = :user_id
                AND status = '1'
                AND YEAR(register_date) = :get_year
                GROUP BY MONTH(register_date)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':get_year' => $get_year
            ]);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $data[$row['m'] - 1] = (int)$row['total'];
            }

            return [$data];
        }

        // =========================
        // 🎯 TE (16) → TC → CU
        // =========================
        elseif ($user_type == '16') {

            $sql = "
                SELECT 
                    MONTH(c.register_date) AS m,
                    COUNT(*) AS total
                FROM ca_customer c

                INNER JOIN ca_travelagency tc 
                    ON c.ta_reference_no = tc.ca_travelagency_id
                    AND tc.status = '1'

                INNER JOIN tc_mapping tm 
                    ON tm.tc_id = tc.ca_travelagency_id
                    AND tm.te_id = :user_id

                WHERE c.status = '1'
                AND YEAR(c.register_date) = :get_year
                GROUP BY MONTH(c.register_date)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':get_year' => $get_year
            ]);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $data[$row['m'] - 1] = (int)$row['total'];
            }

            return [$data]; // only CU for TE chart (as per your labelMap)
        }

        // =========================
        // 🎯 IBR (33) → CU
        // =========================
        elseif ($user_type == '33') {

            $sql = "
                SELECT 
                    MONTH(register_date) AS m,
                    COUNT(*) AS total
                FROM ca_customer
                WHERE ta_reference_no = :user_id
                AND status = '1'
                AND YEAR(register_date) = :get_year
                GROUP BY MONTH(register_date)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':get_year' => $get_year
            ]);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $data[$row['m'] - 1] = (int)$row['total'];
            }

            return [$data];
        }

        // =========================
        // 🎯 DEFAULT (fallback)
        // =========================
        else {

            $tableMap = [
                '10' => 'ca_customer',
                '11' => 'ca_travelagency',
                '16' => 'corporate_agency',
                '33' => 'institution_branch_manager'
            ];

            if (!isset($tableMap[$user_type])) {
                return [$data];
            }

            $table = $tableMap[$user_type];

            $sql = "
                SELECT 
                    MONTH(register_date) AS m,
                    COUNT(*) AS total
                FROM $table
                WHERE status = '1'
                AND YEAR(register_date) = :get_year
                GROUP BY MONTH(register_date)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':get_year' => $get_year
            ]);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $data[$row['m'] - 1] = (int)$row['total'];
            }

            return [$data];
        }

    } catch (Exception $e) {
        error_log("Chart Error: " . $e->getMessage());
        return [$data];
    }
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

    echo json_encode([$bdm, $bm, $mf, $sf, $te, $f, $tc, $cu]);
} else if ($user_type == '25') {
    $months = 12;
    // Initialize arrays
    $bm = $te = $f = $tc = $cu = $mf = $sf = $i = $ibr = array_fill(0, $months, 0);

    $sql = " SELECT user_type, y, m, SUM(cnt) AS cnt
                FROM (
                    -- 1. BM under BDM
                    SELECT 'BM' AS user_type, YEAR(bm.register_date) AS y, MONTH(bm.register_date) AS m, COUNT(DISTINCT bm.id) AS cnt
                    FROM business_mentor AS bm
                    WHERE bm.reference_no = :ref 
                    AND bm.user_type = 26 AND bm.status = '1'
                    AND YEAR(bm.register_date) = :get_year
                    GROUP BY YEAR(bm.register_date), MONTH(bm.register_date)

                    UNION ALL

                    -- 2. TE under BDM or BM
                    SELECT 'TE' AS user_type, YEAR(te.register_date) AS y, MONTH(te.register_date) AS m, COUNT(DISTINCT te.id) AS cnt
                    FROM corporate_agency AS te
                    WHERE te.status = '1'
                    AND YEAR(te.register_date) = :get_year
                    AND (
                        te.reference_no = :ref
                        OR te.reference_no IN (
                            SELECT bm.business_mentor_id 
                            FROM business_mentor bm 
                            WHERE bm.reference_no = :ref AND bm.status='1' AND bm.user_type=26
                        )
                    )
                    GROUP BY YEAR(te.register_date), MONTH(te.register_date)

                    UNION ALL

                    -- 3. Sub-Franchisees (F) via BDM → F, MF → F, SF → F, BM -> F
                    SELECT 'F' AS user_type, YEAR(f.register_date) AS y, MONTH(f.register_date) AS m, COUNT(DISTINCT f.sub_franchisee_id) AS cnt
                    FROM sub_franchisee f
                    WHERE f.status='1'
                    AND YEAR(f.register_date)=:get_year
                    AND (
                        f.reference_no = :ref
                        OR f.reference_no IN (
                            SELECT mf.master_franchisee_id 
                            FROM master_franchisee mf 
                            WHERE mf.reference_no=:ref AND mf.status='1'
                        )
                        OR f.reference_no IN (
                            SELECT sf.sponsor_franchisee_id 
                            FROM sponsor_franchisee sf 
                            WHERE sf.reference_no=:ref AND sf.status='1'
                        )
                        OR f.reference_no IN (
                            SELECT bm.business_mentor_id 
                            FROM business_mentor bm 
                            WHERE bm.reference_no=:ref AND bm.status='1'
                        )
                    )
                    GROUP BY YEAR(f.register_date), MONTH(f.register_date)

                    UNION ALL

                    -- 4. Master Franchisee (MF)
                    SELECT 'I' AS user_type, YEAR(i.register_date) AS y, MONTH(i.register_date) AS m, COUNT(DISTINCT i.institution_id) AS cnt
                    FROM institution i
                    WHERE i.reference_no=:ref AND i.status='1'
                    AND YEAR(i.register_date)=:get_year
                    GROUP BY YEAR(i.register_date), MONTH(i.register_date)

                    UNION ALL

                    -- 5. Sponsor Franchisee (SF)
                    SELECT 'SF' AS user_type, YEAR(sf.register_date) AS y, MONTH(sf.register_date) AS m, COUNT(DISTINCT sf.sponsor_franchisee_id) AS cnt
                    FROM sponsor_franchisee sf
                    WHERE sf.reference_no=:ref AND sf.status='1'
                    AND YEAR(sf.register_date)=:get_year
                    GROUP BY YEAR(sf.register_date), MONTH(sf.register_date)

                    UNION ALL

                    -- 6. INSTITUTION (I)
                    SELECT 'I' AS user_type, YEAR(i.register_date) AS y, MONTH(i.register_date) AS m, COUNT(DISTINCT i.institution_id) AS cnt
                    FROM institution i
                    WHERE i.reference_no=:ref AND i.status='1'
                    AND YEAR(i.register_date)=:get_year
                    GROUP BY YEAR(i.register_date), MONTH(i.register_date)

                    UNION ALL

                    -- 5. TC from all paths
                    SELECT 'TC' AS user_type, YEAR(tc.register_date) AS y, MONTH(tc.register_date) AS m, COUNT(DISTINCT tc.ca_travelagency_id) AS cnt
                    FROM ca_travelagency tc
                    WHERE tc.status='1'
                    AND YEAR(tc.register_date)=:get_year
                    AND (
                        tc.reference_no = :ref
                        OR tc.reference_no IN (
                            SELECT bm.business_mentor_id 
                            FROM business_mentor bm 
                            WHERE bm.reference_no=:ref AND bm.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT te.corporate_agency_id 
                            FROM corporate_agency te 
                            WHERE te.reference_no=:ref AND te.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT te.corporate_agency_id 
                            FROM corporate_agency te 
                            WHERE te.reference_no IN (
                                SELECT bm.business_mentor_id 
                                FROM business_mentor bm 
                                WHERE bm.reference_no=:ref AND bm.status='1'
                            ) AND te.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT mf.master_franchisee_id 
                            FROM master_franchisee mf 
                            WHERE mf.reference_no=:ref AND mf.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            WHERE f.reference_no=:ref AND f.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            JOIN master_franchisee mf 
                              ON f.reference_no=mf.master_franchisee_id 
                            WHERE mf.reference_no=:ref AND mf.status='1' AND f.status='1'
                        )
                        OR tc.reference_no IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            JOIN sponsor_franchisee sf 
                              ON f.reference_no=sf.sponsor_franchisee_id 
                            WHERE sf.reference_no=:ref AND sf.status='1' AND f.status='1'
                        )
                    )
                    GROUP BY YEAR(tc.register_date), MONTH(tc.register_date)

                    UNION ALL

                    -- 7. IBR from I
                    SELECT 'IBR' AS user_type, YEAR(ibr.register_date) AS y, MONTH(ibr.register_date) AS m, COUNT(DISTINCT ibr.institution_branch_manager_id) AS cnt
                    FROM institution_branch_manager ibr
                    WHERE ibr.status='1'
                    AND YEAR(ibr.register_date)=:get_year
                    AND (
                        ibr.reference_no = :ref
                        OR ibr.reference_no IN (
                            SELECT i.institution_id 
                            FROM institution i 
                            WHERE i.reference_no=:ref AND i.status='1'
                        )
                        
                    )
                    GROUP BY YEAR(ibr.register_date), MONTH(ibr.register_date)

                    UNION ALL

                    -- 8. CU via all TCs
                    SELECT 'CU' AS user_type, YEAR(c.register_date) AS y, MONTH(c.register_date) AS m, COUNT(DISTINCT c.ca_customer_id) AS cnt
                    FROM ca_customer c
                    LEFT JOIN ca_travelagency tc 
                    ON c.ta_reference_no = tc.ca_travelagency_id

                    LEFT JOIN institution_branch_manager ibm
                    ON c.ta_reference_no = ibm.institution_branch_manager_id
                    WHERE c.status='1' AND ((tc.status = '1') OR (ibm.status = '1'))
                    AND YEAR(c.register_date)=:get_year
                    AND (
                        COALESCE(tc.reference_no, ibm.reference_no) = :ref
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT bm.business_mentor_id 
                            FROM business_mentor bm 
                            WHERE bm.reference_no=:ref AND bm.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT te.corporate_agency_id 
                            FROM corporate_agency te 
                            WHERE te.reference_no=:ref AND te.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT te.corporate_agency_id 
                            FROM corporate_agency te 
                            WHERE te.reference_no IN (
                                SELECT bm.business_mentor_id 
                                FROM business_mentor bm 
                                WHERE bm.reference_no=:ref AND bm.status='1'
                            ) AND te.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT mf.master_franchisee_id 
                            FROM master_franchisee mf 
                            WHERE mf.reference_no=:ref AND mf.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            WHERE f.reference_no=:ref AND f.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            JOIN master_franchisee mf 
                              ON f.reference_no=mf.master_franchisee_id 
                            WHERE mf.reference_no=:ref AND mf.status='1' AND f.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT f.sub_franchisee_id 
                            FROM sub_franchisee f 
                            JOIN sponsor_franchisee sf 
                              ON f.reference_no=sf.sponsor_franchisee_id 
                            WHERE sf.reference_no=:ref AND sf.status='1' AND f.status='1'
                        )
                        OR COALESCE(tc.reference_no, ibm.reference_no) IN (
                            SELECT ibm.institution_branch_manager_id
                            FROM institution_branch_manager ibm
                            WHERE ibm.reference_no IN (
                                SELECT i.institution_id
                                FROM institution i
                                WHERE i.reference_no = :ref
                                AND i.status = '1'
                            )
                            AND ibm.status = '1'
                        )
                    )
                    GROUP BY YEAR(c.register_date), MONTH(c.register_date)
                ) AS t
                GROUP BY user_type, y, m
                ORDER BY user_type, y, m";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':ref' => $user_id,
        ':get_year' => $get_year
    ]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        switch($row['user_type']){
            case 'BM': $bm[$row['m']-1] = (int)$row['cnt']; break;
            case 'TE': $te[$row['m']-1] = (int)$row['cnt']; break;
            case 'F':  $f[$row['m']-1]  = (int)$row['cnt']; break;
            case 'MF': $mf[$row['m']-1] = (int)$row['cnt']; break;
            case 'SF': $sf[$row['m']-1] = (int)$row['cnt']; break;
            case 'I': $i[$row['m']-1] = (int)$row['cnt']; break;
            case 'IBR': $ibr[$row['m']-1] = (int)$row['cnt']; break;
            case 'TC': $tc[$row['m']-1] = (int)$row['cnt']; break;
            case 'CU': $cu[$row['m']-1] = (int)$row['cnt']; break;
        }
    }

    if ($current_year == $get_year) {
        array_splice($bm, $current_month);
        array_splice($te, $current_month);
        array_splice($f, $current_month);
        array_splice($mf, $current_month);
        array_splice($sf, $current_month);
        array_splice($tc, $current_month);
        array_splice($i, $current_month);
        array_splice($ibr, $current_month);
        array_splice($cu, $current_month);
    }

    echo json_encode([$bm, $mf, $sf, $te, $f, $i, $tc, $ibr, $cu]);
} else if ($user_type == '26') {
    // For BM->TC->CU / BM->TE->TC-CU
    $te = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);
    $f = array_fill(0, 12, 0);
    $i = array_fill(0, 12, 0);
    $ibr = array_fill(0, 12, 0);

    //for BM -> TE only
    $sql = "SELECT corporate_agency_id, register_date FROM corporate_agency 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $fRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $te[$month - 1]++;
        }
    }

    // Get TCs under those TEs
    $fIds = array_column($fRows, 'corporate_agency_id');
    if (!empty($fIds)) {
        $inClause = implode(',', array_fill(0, count($fIds), '?'));
        $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($fIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['ca_travelagency_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
                WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    //For BM->TC->CU direct TC by BM
    $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $tc_id=$row['ca_travelagency_id'];
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
        $sql1 = "SELECT register_date FROM ca_customer 
                WHERE ta_reference_no = :ref AND status = '1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([':ref' => $tc_id]);
        foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $cu[$month - 1]++;
            }
        }
    }

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
    $IIds = array_column($IRows, 'sub_franchisee_id');
    if (!empty($IIds)) {
        $inClause = implode(',', array_fill(0, count($IIds), '?'));
        $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($IIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['ca_travelagency_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    //for I -> IBR only
    $sql = "SELECT institution_id, register_date FROM institution 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $ibrRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($ibrRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $i[$month - 1]++;
        }
    }
    // Get IBRs under those Is
    $ibrIds = array_column($ibrRows, 'institution_id');
    if (!empty($ibrIds)) {
        $inClause = implode(',', array_fill(0, count($ibrIds), '?'));
        $sql = "SELECT institution_branch_manager_id,register_date FROM institution_branch_manager 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ibrIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['institution_branch_manager_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $ibr[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    if ($current_year == $get_year) {
        array_splice($te, $current_month);
        array_splice($tc, $current_month);
        array_splice($cu, $current_month);
        array_splice($f, $current_month);
        array_splice($i, $current_month);
        array_splice($ibr, $current_month);
    }

    echo json_encode([ $te, $f, $i, $tc, $ibr,$cu ]);
} else if($user_type == '28'){
    $f = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);
    $i = array_fill(0, 12, 0);
    $ibr = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);

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
        $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($fIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['ca_travelagency_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
                WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    
    // For MF → TC only

    $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $tc_id=$row['ca_travelagency_id'];
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
        $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([':ref' => $tc_id]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $cu[$month - 1]++;
            }
        }
    }
    //for I -> IBR only
    $sql = "SELECT institution_id, register_date FROM institution 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $ibrRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($ibrRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $i[$month - 1]++;
        }
    }
    // Get IBRs under those Is
    $ibrIds = array_column($ibrRows, 'institution_id');
    if (!empty($ibrIds)) {
        $inClause = implode(',', array_fill(0, count($ibrIds), '?'));
        $sql = "SELECT institution_branch_manager_id,register_date FROM institution_branch_manager 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ibrIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['institution_branch_manager_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $ibr[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }

    if ($current_year == $get_year) {
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
        array_splice($i, $current_month);
        array_splice($ibr, $current_month);
        array_splice($cu, $current_month);
    }
    echo json_encode([ $f, $i, $tc, $ibr, $cu ]);
}else if($user_type == '30'){
    $f = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);
    $i = array_fill(0, 12, 0);
    $ibr = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);

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
        $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($fIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['ca_travelagency_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $tc[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    //for I -> IBR only
    $sql = "SELECT institution_id, register_date FROM institution 
            WHERE reference_no = :ref AND user_type = 29 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $iRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($iRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $i[$month - 1]++;
        }
    }
    // Get IBRs under those Is
    $iIds = array_column($iRows, 'institution_id');
    if (!empty($iIds)) {
        $inClause = implode(',', array_fill(0, count($ibrIds), '?'));
        $sql = "SELECT institution_branch_manager_id,register_date FROM institution_branch_manager 
                WHERE reference_no IN ($inClause) AND status = '1'";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ibrIds);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tc_id=$row['institution_branch_manager_id'];
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $ibr[$month - 1]++;
            }
            $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([':ref' => $tc_id]);
            foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $cu[$month - 1]++;
                }
            }
        }
    }
    if ($current_year == $get_year) {
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
        array_splice($i, $current_month);
        array_splice($ibr, $current_month);
        array_splice($cu, $current_month);
    }
    echo json_encode([ $f, $i, $tc, $ibr, $cu ]);
}else if ($user_type == '31') {
    // For RM → MF/SF → F-> TC
    $mf = array_fill(0, 12, 0);
    $sf = array_fill(0, 12, 0);
    $f = array_fill(0, 12, 0);
    $tc = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);

    // Get direct MFs
    $sql = "SELECT master_franchisee_id AS id, register_date FROM master_franchisee 
            WHERE reference_no = :ref AND user_type = 28 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $mfRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($mfRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $mf[$month - 1]++;
        }
    }
    // Get direct SFs
    $sql = "SELECT sponsor_franchisee_id AS id, register_date FROM sponsor_franchisee 
            WHERE reference_no = :ref AND user_type = 30 AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    $sfRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sfRows as $row) {
        $date = $row['register_date'];
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)); // 1-based
        if ($year == $get_year) {
            $sf[$month - 1]++;
        }
    }
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
                $f[$month - 1]++;

            }
            $fIds = array_column($rows, 'id');
            $inClause = implode(',', array_fill(0, count($fIds), '?'));
            $sql = "SELECT register_date,ca_travelagency_id as id FROM ca_travelagency 
                    WHERE reference_no IN ($inClause) AND status = '1'";
            $stmt = $conn->prepare($sql);
            $stmt->execute($fIds);

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $year = date('Y', strtotime($row['register_date']));
                $month = date('n', strtotime($row['register_date']));
                if ($year == $get_year) {
                    $tc[$month - 1]++;
                }
                //get customers for the TC's
                $tcids = array_column($rows, 'id');
                $inClause = implode(',', array_fill(0, count($tcids), '?'));
                $sql = "SELECT register_date FROM ca_customer
                        WHERE reference_no IN ($inClause) AND status = '1'";
                $stmt = $conn->prepare($sql);
                $stmt->execute($tcids);

                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $year = date('Y', strtotime($row['register_date']));
                    $month = date('n', strtotime($row['register_date']));
                    if ($year == $get_year) {
                        $cu[$month - 1]++;
                    }
                }
            }
        }
    }

    if ($current_year == $get_year) {
        array_splice($mf, $current_month);
        array_splice($sf, $current_month);
        array_splice($f, $current_month);
        array_splice($tc, $current_month);
        array_splice($cu, $current_month);
    }

    echo json_encode([ $mf,$sf,$tc,$cu]);

} else if($user_type == '29' || $user_type == '16'){ //Franchisee/Techno Enterprise
    $tc = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);
    
    $sql = "SELECT ca_travelagency_id,register_date FROM ca_travelagency 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $tc_id=$row['ca_travelagency_id'];
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $tc[$month - 1]++;
        }
        $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([':ref' => $tc_id]);
        foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $cu[$month - 1]++;
            }
        }
    }

    if ($current_year == $get_year) {
        array_splice($tc, $current_month);
        array_splice($cu, $current_month);
    }
    echo json_encode([ $tc, $cu ]);
}else if($user_type == '32'){ //Institution
    $ibr = array_fill(0, 12, 0);
    $cu = array_fill(0, 12, 0);
    
    $sql = "SELECT institution_branch_manager_id,register_date FROM institution_branch_manager 
            WHERE reference_no = :ref AND status = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ref' => $user_id]);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $tc_id=$row['institution_branch_manager_id'];
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $ibr[$month - 1]++;
        }
        $sql1 = "SELECT register_date FROM ca_customer 
            WHERE ta_reference_no = :ref AND status = '1'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([':ref' => $tc_id]);
        foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $year = date('Y', strtotime($row['register_date']));
            $month = date('n', strtotime($row['register_date']));
            if ($year == $get_year) {
                $cu[$month - 1]++;
            }
        }
    }

    if ($current_year == $get_year) {
        array_splice($ibr, $current_month);
        array_splice($cu, $current_month);
    }
    echo json_encode([ $ibr, $cu ]);
}else if($user_type == '33'){ //Institution Branch Manager
    $cu = array_fill(0, 12, 0);
        
    $sql1 = "SELECT register_date FROM ca_customer 
        WHERE ta_reference_no = :ref AND status = '1'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([':ref' => $user_id]);
    foreach ($stmt1->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $year = date('Y', strtotime($row['register_date']));
        $month = date('n', strtotime($row['register_date']));
        if ($year == $get_year) {
            $cu[$month - 1]++;
        }
    }

    if ($current_year == $get_year) {
        array_splice($cu, $current_month);
    }
    echo json_encode([ $cu ]);
}  else {
    // fallback for other users
    $data = monthlyChartData($conn, $user_id, $get_year, $current_year, $current_month, $user_type,$user_id);
    echo json_encode([$data]);
}
?>
