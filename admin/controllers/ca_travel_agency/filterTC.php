<?php
require '../../connect.php';

$stateFilter = $_POST['state'] ?? 'All';
$userId = $_POST['userId'] ?? '';
$designation = $_POST['designation'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';
$reporting_manager='';

$whereClause = "WHERE status = '1'";
$params = [];

if (!empty($stateFilter) && $stateFilter !== '0') {
    $whereClause .= " AND state = ?";
    $params[] = $stateFilter;
}

if (!empty($fromDate) && !empty($toDate)) {
    try {
        $from = (new DateTime($fromDate))->format('Y-m-d');
        $to = (new DateTime($toDate))->format('Y-m-d');
        $whereClause .= " AND DATE(register_date) BETWEEN ? AND ?";
        $params[] = $from;
        $params[] = $to;
    } catch (Exception $e) {
        // silently ignore
    }
}

$tcIds = [];

try {
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
        
    }else{
        
    }
} catch (PDOException $e) {
    
    echo '<p class="text-center">Error loading TC hierarchy.</p>';
    exit;
}

// Now fetch and render the final TC table
$isFilterApplied = isset($_POST['designation']) && $_POST['designation'] != '';
try 
{
    $whereConditions = [];
    $params = [];

    /*
    Logic:
    - If filter applied → use tcIds
    - If filter applied AND tcIds empty → show no data
    - If no filter applied → show all TC (do nothing)
    */

    if ($isFilterApplied) {

        if (!empty($tcIds)) {

            $placeholders = implode(',', array_fill(0, count($tcIds), '?'));
            $whereConditions[] = "user_id IN ($placeholders)";
            $params = array_merge($params, $tcIds);

        } else {

            // Filter applied but no TC found
            $whereConditions[] = "1 = 0";
        }
    }

    if (!empty($whereConditions)) {
        $whereClause .= " AND " . implode(" AND ", $whereConditions);
    }
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
                    register_by
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
                    register_by
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
                register_by
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
                register_by
            FROM institution_branch_manager
        ";
    }

    $query = "SELECT * FROM ( $innerQuery ) AS final_table $whereClause ORDER BY user_id ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {
        echo '<table id="registeredCustomerList-tableFilter" class="table align-middle table-nowrap dt-responsive nowrap w-100">';
        echo '<thead class="table-light"><tr><th>TC Id / Full Name</th><th>Reference ID / Name</th><th>Referal Ref ID/ Name</th><th>Paid Amount</th><th>Phone / Email</th><th>Address</th><th>Joining Date</th><th>Status</th><th>Action</th></tr></thead><tbody>';

        foreach ($rows as $row) {
            $rdate = (new DateTime($row['register_date']))->format('d-m-Y');
            $reference_no = substr($row['reference_no'],0,2);
            $name = '';
            $id = '';
            $reporting_manager = '';

            if ($reference_no == 'TE' || $reference_no == 'CA') {

                $stmt2 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = ? AND (status='1' OR status='3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }

            } elseif ($reference_no == 'BM') {

                $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = ? AND (status='1' OR status='3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }

            } elseif ($reference_no == 'BH') {

                $stmt2 = $conn->prepare("SELECT reporting_manager FROM employees WHERE employee_id = ? AND (status='1' OR status='3')");
                $stmt2->execute([$row['reference_no']]);
                $reporting_manager = $stmt2->fetchColumn();

                if (!empty($reporting_manager)) {
                    $stmt3 = $conn->prepare("SELECT employee_id,name FROM employees WHERE employee_id = ? AND (status='1' OR status='3')");
                    $stmt3->execute([$reporting_manager]);
                    if ($refData2 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        $id = $refData2['employee_id'];
                        $name = $refData2['name'];
                    }
                }

            } elseif (substr($row['reference_no'],0,1) == 'F') {

                $stmt2 = $conn->prepare("SELECT * FROM sub_franchisee WHERE sub_franchisee_id = ? AND (status='1' OR status='3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }

            } elseif (substr($row['reference_no'],0,1) == 'I') {

                $stmt2 = $conn->prepare("SELECT * FROM institution WHERE institution_id = ? AND (status='1' OR status='3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }
            }

            echo '<tr>';
            echo '<td><p class="mb-1">' . htmlspecialchars($row['user_id']) . '</p><p class="mb-0"> ' . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . ' </p></td>';
            echo '<td><p class="mb-1">' . htmlspecialchars($row['reference_no']) . '</p><p class="mb-0">' . htmlspecialchars($row['registrant']) . '</p></td>';
            echo '<td><p class="mb-1">' . htmlspecialchars($id) . '</p><p class="mb-0">' . htmlspecialchars($name) . '</p></td>';
            echo '<td>' . htmlspecialchars(trim($row['amount']) !== '' ? $row['amount'] : 0) .'</td>';
            echo '<td><p class="mb-1">+' . htmlspecialchars($row['country_code']) . ' ' . htmlspecialchars($row['contact_no']) . '</p><p class="mb-0">' . htmlspecialchars($row['email']) . '</p></td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . $rdate . '</td>';
            echo '<td><span class="badge text-bg-' . ($row['status'] == '1' ? 'success">Active' : 'danger">Deactive') . '</span></td>';
            echo '<td><div class="dropdown"><a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal font-size-18"></i></a><ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">';
            echo '<li><a href="#" onclick="overviewPage(\'' 
                    . $row['user_id'] . '\',\''
                    . $row['reference_no'] . '\',\''
                    . $row['country'] . '\',\''
                    . $row['state'] . '\',\''
                    . $row['city'] . '\',\''
                    . ($row['user_type'] == 'tc' ? 'ca_travelagency' : ($row['user_type'] == 'ibr' ? 'institution_branch_manager' : ''))
                    . '\')" 
                    class="dropdown-item" data-bs-toggle="modal">
                    <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a>
                  </li>';
            echo '<li><a href="#" onclick="editfuncCust(\'' . $row['user_id'] . '\',\'' . $row['reference_no'] . '\',\'' . $row['register_by'] . '\',\'' . $row['country'] . '\',\'' . $row['state'] . '\',\'' . $row['city'] . '\',\'registered\',\''.$row['user_type'].'\')" class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>';
            echo '<li><a href="#" onclick="deletefunc(\'' . $row['id'] . '\',\'' . $row['user_id'] . '\',\'registered\',\''.$row['user_type'].'\')" class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
            echo '</ul></div></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No TC data found.</p>';
    }
} catch (PDOException $e) {
    echo '<p class="text-center">Error loading TC data.</p>';
}
?>