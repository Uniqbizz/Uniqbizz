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
========================= */
echo '
<table class="table align-middle table-nowrap dt-responsive nowrap w-100"
       id="registeredCustomerList-table">
<thead class="table-light">
<tr>
    <th>TE/F Id</th>
    <th>Full Name</th>
    <th>Reference ID / Name</th>
    <th>Phone / Email</th>
    <th>Amount</th>
    <th>Joining Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
';

foreach ($rows as $row) {

    $rdate = (new DateTime($row['register_date']))->format('d-m-Y');

    /* TC badge color */
    $rowClass = ($row['tc_assign_status'] == 1) ? 'bg-success' : 'bg-secondary';

    echo '<tr>';

    /* TE/F ID */
    echo '<td>' . htmlspecialchars($row['user_id']) . '</td>';

    /* Full Name + badges */
    echo '<td>
            <span class="badge ' . $rowClass . '">'
            . strtoupper($row['user_type'] == 'sf'?'f':'te') .
            '</span>&nbsp;'
            . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);

    if ($row['tc_assign_status'] == 1) {
        echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">TC Allotted</small>';
    }

    if ($row['upgrade_pack'] == 2) {
        echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">Upgraded</small>';
    }

    echo '</td>';

    /* Reference */
    echo '<td>
            <p class="mb-1">' . htmlspecialchars($row['reference_no']) . '</p>
            <p class="mb-0">' . htmlspecialchars($row['registrant']) . '</p>
          </td>';

    /* Phone / Email */
    echo '<td>
            <p class="mb-1">+' . htmlspecialchars($row['country_code']) . ' ' . htmlspecialchars($row['contact_no']) . '</p>
            <p class="mb-0">' . htmlspecialchars($row['email']) . '</p>
          </td>';

    /* Amount (upgrade override) */
    if ($row['upgrade_pack'] == 2 && $row['user_type'] === 'sf') {
        $upStmt = $conn->prepare("
            SELECT upgrade_amt
            FROM sub_franchisee_upgrade
            WHERE sub_franchisee_id = :id
              AND upgrade_status = 1
            ORDER BY id DESC LIMIT 1
        ");
        $upStmt->bindValue(':id', $row['user_id']);
        $upStmt->execute();
        $up = $upStmt->fetch(PDO::FETCH_ASSOC);

        echo '<td>' . htmlspecialchars($up['upgrade_amt'] ?? $row['amount']) . '</td>';
    } else {
        echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
    }

    /* Date */
    echo '<td>' . $rdate . '</td>';

    /* Action */
    if ($row['status'] == '1') {
        echo '<td><span class="badge text-bg-success">Active</span></td>
            <td>
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
