<?php
require "../connect.php";

/* =========================
   INPUTS (safe defaults)
========================= */
$designation = $_POST['designation'] ?? '';
$package     = $_POST['package'] ?? '';
$startFrom   = $_POST['StartFrom'] ?? '';
$endFrom     = $_POST['EndFrom'] ?? '';

$conditions = [];
$params = [];

/* =========================
   FILTER CONDITIONS
========================= */
if (!empty($package)) {
    $conditions[] = "amount = :package";
    $params[':package'] = $package;
}

if (!empty($startFrom)) {
    $conditions[] = "DATE(register_date) >= :startFrom";
    $params[':startFrom'] = $startFrom;
}

if (!empty($endFrom)) {
    $conditions[] = "DATE(register_date) <= :endFrom";
    $params[':endFrom'] = $endFrom;
}

$filterSql = '';
if (!empty($conditions)) {
    $filterSql = ' AND ' . implode(' AND ', $conditions);
}

/* =========================
   BASE QUERIES
========================= */

// Techno Enterprise
$teQuery = "
    SELECT 
        'te' AS user_type,
        id,
        corporate_agency_id AS user_id,
        firstname, lastname,
        reference_no, registrant,
        country_code, contact_no, email,
        amount,
        date_of_birth,
        register_date,
        status,
        register_by,
        country, state, city,
        no_tc_alloted,
        tc_assign_status,
        'NA' AS upgrade_pack
    FROM corporate_agency
    WHERE status = '1' $filterSql
";

// Franchisee
$sfQuery = "
    SELECT 
        'sf' AS user_type,
        id,
        sub_franchisee_id AS user_id,
        firstname, lastname,
        reference_no, registrant,
        country_code, contact_no, email,
        amount,
        date_of_birth,
        register_date,
        status,
        register_by,
        country, state, city,
        no_tc_alloted,
        tc_assign_status,
        upgrade_status AS upgrade_pack
    FROM sub_franchisee
    WHERE status = '1' $filterSql
";

/* =========================
   FINAL QUERY PICK
========================= */
if ($designation === 'TE') {
    $finalQuery = $teQuery . " ORDER BY register_date ASC";
} elseif ($designation === 'F') {
    $finalQuery = $sfQuery . " ORDER BY register_date ASC";
} elseif ($designation === 'All') {
    $finalQuery = "($teQuery) UNION ALL ($sfQuery) ORDER BY register_date ASC";
} else {
    exit; // safety
}

$stmt = $conn->prepare($finalQuery);

foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   TABLE OUTPUT (SAME ID)
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick=\'overviewPage("' . $row["user_id"] . '","' .$row["reference_no"] . '","' .$row["country"] . '","' .$row["state"] . '","' .$row["city"] . '","' .(strtolower($row['user_type']) == 'sf' ? 'sub_franchisee' : (strtolower($row['user_type']) == 'te' ? 'corporate_agency' : '')) .'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>';
                        if($row['user_type'] == 'sf'){
                            echo'<li><a href="#" onclick=\'upgradePage("' . $row["user_id"] . '","' .$row["reference_no"] . '")\'  class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-arrow-up-bold text-success me-1"></i> Upgrade Franchisee</a></li>';
                        }
                        if ($row['user_type'] == 'te' && $row["tc_assign_status"] == 2) {
                            echo '<li>
                                    <a href="#" 
                                    class="dropdown-item" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#tcAllotmentModal" 
                                    data-bs-assign="' . htmlspecialchars($row["tc_assign_status"]) . '"
                                    data-bs-tcnum="' . htmlspecialchars($row["no_tc_alloted"]??0) . '"
                                    data-bs-teid="' . htmlspecialchars($row["user_id"]) . '"
                                    >
                                        <i class="mdi mdi-account-group font-size-16 text-info me-1"></i> Allocate TC
                                    </a>
                                </li>';
                        }else if($row['user_type'] == 'te' && $row["tc_assign_status"] == 1){
                            echo '<li>
                                    <a href="#" 
                                    class="dropdown-item" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#allottedTCModal" 
                                    data-bs-assign="' . htmlspecialchars($row["tc_assign_status"]) . '"
                                    data-bs-tcnum="' . htmlspecialchars($row["no_tc_alloted"]??0) . '"
                                    data-bs-teid="' . htmlspecialchars($row["user_id"]) . '"
                                    >
                                        <i class="mdi mdi-account-group font-size-16 text-info me-1"></i> Show Allocated TC
                                    </a>
                                </li>'; 
                        }
        echo'           <li><a href="#" onclick=\'editfuncCust("' . $row["user_id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","registered","' . $row["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                        <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","registered","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                    </ul>
                </div>
            </td>';
    } else {
        echo '<td><span class="badge text-bg-danger">Deactive</span></td>
            <td>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","deactivate","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                    </ul>
                </div>
            </td>';
    }

    echo '</tr>';
}

echo '</tbody></table>';
