<?php
    require '../connect.php';

    /* ==============================
    GET FILTER VALUES
    ============================== */

    $stateFilter = $_GET['state'] ?? 'All';
    $userId = $_GET['userId'] ?? '';
    $designation = $_GET['designation'] ?? '';
    $fromDate = $_GET['fromDate'] ?? '';
    $toDate = $_GET['toDate'] ?? '';
    $output='';

    $whereClause = "WHERE status = '1'";
    $params = [];

    /* ==============================
    STATE FILTER
    ============================== */

    if (!empty($stateFilter) && $stateFilter !== '0' && $stateFilter !== 'All') {
        $whereClause .= " AND state = ?";
        $params[] = $stateFilter;
    }

    /* ==============================
    DATE FILTER
    ============================== */

    if (!empty($fromDate) && !empty($toDate)) {
        try {
            $from = (new DateTime($fromDate))->format('Y-m-d');
            $to   = (new DateTime($toDate))->format('Y-m-d');

            $whereClause .= " AND DATE(register_date) BETWEEN ? AND ?";
            $params[] = $from;
            $params[] = $to;
        } catch (Exception $e) {}
    }

    $tcIds = [];
    if (!empty($designation)) {
        $tcIds = [];

        function fetchColumn($conn, $sql, $params = []){
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        if ($designation == '26') { // BM
            if (!empty($userId)) {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no = ? AND status = '1'",
                    [$userId]
                );
            } else {

                // Direct TC under BM
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no LIKE 'BM%' AND status = '1'"
                );

                // TEs under BM
                $teList = fetchColumn($conn,
                    "SELECT corporate_agency_id 
                    FROM corporate_agency 
                    WHERE reference_no LIKE 'BM%' 
                    AND (status = '1' OR status = '3')"
                );

                if (!empty($teList)) {
                    $placeholders = implode(',', array_fill(0, count($teList), '?'));
                    $tcFromTE = fetchColumn($conn,
                        "SELECT ca_travelagency_id 
                        FROM ca_travelagency 
                        WHERE reference_no IN ($placeholders) 
                        AND status = '1'",
                        $teList
                    );

                    $tcIds = array_merge($tcIds, $tcFromTE);
                }
            }
        }

        elseif ($designation == '28') { // MF

            if (!empty($userId)) {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no = ? AND status = '1'",
                    [$userId]
                );
            } else {

                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no LIKE 'MF%' AND status = '1'"
                );

                $frList = fetchColumn($conn,
                    "SELECT sub_franchisee_id 
                    FROM sub_franchisee 
                    WHERE reference_no LIKE 'MF%' 
                    AND (status = '1' OR status = '3')"
                );

                if (!empty($frList)) {
                    $placeholders = implode(',', array_fill(0, count($frList), '?'));
                    $tcFromF = fetchColumn($conn,
                        "SELECT ca_travelagency_id 
                        FROM ca_travelagency 
                        WHERE reference_no IN ($placeholders) 
                        AND status = '1'",
                        $frList
                    );

                    $tcIds = array_merge($tcIds, $tcFromF);
                }
            }
        }

        elseif ($designation == '16') { // TE

            if (!empty($userId)) {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no = ? AND status = '1'",
                    [$userId]
                );
            } else {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE (reference_no LIKE 'TE%' OR reference_no LIKE 'CA%') 
                    AND (status = '1' OR status = '3')"
                );
            }
        }

        elseif ($designation == '29') { // F

            if (!empty($userId)) {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no = ? AND status = '1'",
                    [$userId]
                );
            } else {
                $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id 
                    FROM ca_travelagency 
                    WHERE reference_no LIKE 'F%' 
                    AND status = '1'"
                );
            }
        }

        elseif ($designation == '25') { // BDM

            $tcDirectBDM = [];
            $tcFromFR    = [];
            $tcFromBM    = [];
            $tcFromTE    = [];

            /* =========================================
            1️⃣ DIRECT TC UNDER BDM
            ========================================= */

            if (!empty($userId)) {

                $tcDirectBDM = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no = ?
                    AND status='1'",
                    [$userId]
                );
            }

            /* =========================================
            2️⃣ FRANCHISEE UNDER BDM → TC
            ========================================= */

            $frList = fetchColumn($conn,
                empty($userId)
                ? "SELECT sub_franchisee_id
                FROM sub_franchisee
                WHERE (status='1' OR status='3')"
                : "SELECT sub_franchisee_id
                FROM sub_franchisee
                WHERE reference_no=?
                AND (status='1' OR status='3')",
                empty($userId) ? [] : [$userId]
            );

            if (!empty($frList)) {

                $phFR = implode(',', array_fill(0, count($frList), '?'));

                $tcFromFR = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no IN ($phFR)
                    AND status='1'",
                    $frList
                );
            }

            /* =========================================
            3️⃣ BM UNDER BDM
            ========================================= */

            $bmList = fetchColumn($conn,
                empty($userId)
                ? "SELECT business_mentor_id
                FROM business_mentor
                WHERE (status='1' OR status='3')"
                : "SELECT business_mentor_id
                FROM business_mentor
                WHERE reference_no=?
                AND (status='1' OR status='3')",
                empty($userId) ? [] : [$userId]
            );

            if (!empty($bmList)) {

                $phBM = implode(',', array_fill(0, count($bmList), '?'));

                /* ---- TC under BM ---- */

                $tcFromBM = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no IN ($phBM)
                    AND status='1'",
                    $bmList
                );

                /* ---- TE under BM ---- */

                $teList = fetchColumn($conn,
                    "SELECT corporate_agency_id
                    FROM corporate_agency
                    WHERE reference_no IN ($phBM)
                    AND (status='1' OR status='3')",
                    $bmList
                );

                if (!empty($teList)) {

                    $phTE = implode(',', array_fill(0, count($teList), '?'));

                    $tcFromTE = fetchColumn($conn,
                        "SELECT ca_travelagency_id
                        FROM ca_travelagency
                        WHERE reference_no IN ($phTE)
                        AND status='1'",
                        $teList
                    );
                }
            }

            /* =========================================
            FINAL MERGE
            ========================================= */

            $tcIds = array_unique(array_merge(
                $tcDirectBDM,
                $tcFromFR,
                $tcFromBM,
                $tcFromTE
            ));
        }

        elseif ($designation == '24') { // BCM

            $tcDirectBDM = [];
            $tcFromFR    = [];
            $tcFromBM    = [];
            $tcFromTE    = [];

            /* =========================================
            1️⃣ GET BDM UNDER BCM
            ========================================= */

            $bdmList = fetchColumn($conn,
                empty($userId)
                ? "SELECT employee_id 
                FROM employees 
                WHERE user_type='25' 
                AND (status='1' OR status='3')"
                : "SELECT employee_id 
                FROM employees 
                WHERE user_type='25' 
                AND reporting_manager=? 
                AND (status='1' OR status='3')",
                empty($userId) ? [] : [$userId]
            );

            if (!empty($bdmList)) {

                $phBDM = implode(',', array_fill(0, count($bdmList), '?'));

                /* =========================================
                2️⃣ DIRECT TC UNDER BDM
                ========================================= */

                $tcDirectBDM = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no IN ($phBDM)
                    AND status='1'",
                    $bdmList
                );

                /* =========================================
                3️⃣ FRANCHISEE UNDER BDM → TC
                ========================================= */

                $frList = fetchColumn($conn,
                    "SELECT sub_franchisee_id
                    FROM sub_franchisee
                    WHERE reference_no IN ($phBDM)
                    AND (status='1' OR status='3')",
                    $bdmList
                );

                if (!empty($frList)) {

                    $phFR = implode(',', array_fill(0, count($frList), '?'));

                    $tcFromFR = fetchColumn($conn,
                        "SELECT ca_travelagency_id
                        FROM ca_travelagency
                        WHERE reference_no IN ($phFR)
                        AND status='1'",
                        $frList
                    );
                }

                /* =========================================
                4️⃣ BM UNDER BDM
                ========================================= */

                $bmList = fetchColumn($conn,
                    "SELECT business_mentor_id
                    FROM business_mentor
                    WHERE reference_no IN ($phBDM)
                    AND (status='1' OR status='3')",
                    $bdmList
                );

                if (!empty($bmList)) {

                    $phBM = implode(',', array_fill(0, count($bmList), '?'));

                    /* ---- TC under BM ---- */

                    $tcFromBM = fetchColumn($conn,
                        "SELECT ca_travelagency_id
                        FROM ca_travelagency
                        WHERE reference_no IN ($phBM)
                        AND status='1'",
                        $bmList
                    );

                    /* ---- TE under BM ---- */

                    $teList = fetchColumn($conn,
                        "SELECT corporate_agency_id
                        FROM corporate_agency
                        WHERE reference_no IN ($phBM)
                        AND (status='1' OR status='3')",
                        $bmList
                    );

                    if (!empty($teList)) {

                        $phTE = implode(',', array_fill(0, count($teList), '?'));

                        $tcFromTE = fetchColumn($conn,
                            "SELECT ca_travelagency_id
                            FROM ca_travelagency
                            WHERE reference_no IN ($phTE)
                            AND status='1'",
                            $teList
                        );
                    }
                }
            }

            /* =========================================
            FINAL MERGE (REMOVE DUPLICATES)
            ========================================= */

            $tcIds = array_unique(array_merge(
                $tcDirectBDM,
                $tcFromFR,
                $tcFromBM,
                $tcFromTE
            ));
        }

        elseif ($designation == '32') { // Institution (Keep Separate as requested)

            if (!empty($userId)) {
                $tcIds = fetchColumn($conn,
                    "SELECT institution_branch_manager_id 
                    FROM institution_branch_manager 
                    WHERE reference_no = ? AND status='1'",
                    [$userId]
                );
            } else {
                $tcIds = fetchColumn($conn,
                    "SELECT institution_branch_manager_id 
                    FROM institution_branch_manager 
                    WHERE reference_no LIKE 'I%' 
                    AND status='1'"
                );
            }
        }
        
    }

    $isFilterApplied = !empty($designation);

    $whereConditions = [];

    if ($isFilterApplied) {

        if (!empty($tcIds)) {

            $placeholders = implode(',', array_fill(0, count($tcIds), '?'));
            $whereConditions[] = "user_id IN ($placeholders)";
            $params = array_merge($params, $tcIds);

        } else {
            $whereConditions[] = "1 = 0";
        }
    }

    if (!empty($whereConditions)) {
        $whereClause .= " AND " . implode(" AND ", $whereConditions);
    }

    /* =========================
    FINAL QUERY
    ========================= */

    if (!empty($designation)) {

        if (in_array($designation, ['26','28','30','16','29','25','24'])) {

            $innerQuery = "
                SELECT 
                    'tc' AS user_type,
                    id,
                    ca_travelagency_id AS user_id,
                    reference_no,
                    registrant,
                    amount,
                    country_code,
                    contact_no,
                    address,
                    register_date,
                    status,
                    country,
                    state,
                    city,
                    firstname,
                    lastname,
                    email,
                    register_by,
                    date_of_birth,
                    nominee_name,
                    nominee_relation,
                    age,
                    gender,
                    pincode,
                    payment_mode
                FROM ca_travelagency
            ";

        } elseif ($designation == '32') {

            $innerQuery = "
                SELECT 
                    'ibr' AS user_type,
                    id,
                    institution_branch_manager_id AS user_id,
                    reference_no,
                    registrant,
                    amount,
                    country_code,
                    contact_no,
                    address,
                    register_date,
                    status,
                    country,
                    state,
                    city,
                    firstname,
                    lastname,
                    email,
                    register_by,
                    date_of_birth,
                    nominee_name,
                    nominee_relation,
                    age,
                    gender,
                    pincode,
                    payment_mode
                FROM institution_branch_manager
            ";
        }

    } else {

        $innerQuery = "
            SELECT 
                'tc' AS user_type,
                id,
                ca_travelagency_id AS user_id,
                reference_no,
                registrant,
                amount,
                country_code,
                contact_no,
                address,
                register_date,
                status,
                country,
                state,
                city,
                firstname,
                lastname,
                email,
                register_by,
                date_of_birth,
                nominee_name,
                nominee_relation,
                age,
                gender,
                pincode,
                payment_mode
            FROM ca_travelagency

            UNION ALL

            SELECT 
                'ibr' AS user_type,
                id,
                institution_branch_manager_id AS user_id,
                reference_no,
                registrant,
                amount,
                country_code,
                contact_no,
                address,
                register_date,
                status,
                country,
                state,
                city,
                firstname,
                lastname,
                email,
                register_by,
                date_of_birth,
                nominee_name,
                nominee_relation,
                age,
                gender,
                pincode,
                payment_mode
            FROM institution_branch_manager
        ";
    }

    $query = "SELECT * FROM ( $innerQuery ) AS final_table $whereClause ORDER BY user_id ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {

        $output .= '<h2 style="text-align:center">Travel Consultant Registered List</h2>
        <table border="1" style="text-align:center">
        <tr>
            <th>Travel Consultant ID</th>
            <th>Name</th>
            <th>Nominee Name</th>
            <th>Nominee Relatione</th>
            <th>Email</th>
            <th>Contact No.</th>
            <th>Date Of Birth</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Pincode</th>
            <th>Address</th>
            <th>Payment Mode</th>
            <th>Amount</th>
            <th>Reference No</th>
            <th>Registrant</th>
            <th>Register Date</th>
        </tr>';

        foreach ($rows as $row) {

            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $rd = new DateTime($row['register_date']);
            $rDate = $rd->format('d-m-Y');

            /* =========================
            COUNTRY / STATE / CITY
            ========================= */

            $country_name = '';
            $statename = '';
            $city_name = '';

            $cStmt = $conn->prepare("SELECT country_name FROM countries WHERE id=? AND status='1'");
            $cStmt->execute([$row['country']]);
            $country_name = $cStmt->fetchColumn() ?: '';

            $sStmt = $conn->prepare("SELECT state_name FROM states WHERE id=? AND status='1'");
            $sStmt->execute([$row['state']]);
            $statename = $sStmt->fetchColumn() ?: '';

            $ctStmt = $conn->prepare("SELECT city_name FROM cities WHERE id=? AND status='1'");
            $ctStmt->execute([$row['city']]);
            $city_name = $ctStmt->fetchColumn() ?: '';

            $output .= '<tr>
                <td>'.$row['user_id'].'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                <td>'.$row['nominee_name'].'</td>
                <td>'.$row['nominee_relation'].'</td>
                <td>'.$row['email'].'</td>
                <td>+'.$row["country_code"].' '.$row['contact_no'].'</td>
                <td>'.$bdate.'</td>
                <td>'.$row['age'].'</td>
                <td>'.$row['gender'].'</td>
                <td>'.$country_name.'</td>
                <td>'.$statename.'</td>
                <td>'.$city_name.'</td>
                <td>'.$row['pincode'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['payment_mode'].'</td>
                <td>'.$row['amount'].'</td>
                <td>'.$row['reference_no'].'</td>
                <td>'.$row['registrant'].'</td>
                <td>'.$rDate.'</td>
            </tr>';
        }

        $output .= '</table>';

        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=Registered_Travel_Consultant_List.xls");

        echo $output;

    } else {
        echo "No Data Found";
    }
?>