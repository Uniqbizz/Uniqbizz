<?php
require "../../connect.php";

/* =========================
   INPUTS (safe defaults)
========================= */
$designation = $_POST['designation'] ?? 'All';
$package     = $_POST['package'] ?? '';
$startFrom   = $_POST['StartFrom'] ?? '';
$endFrom     = $_POST['EndFrom'] ?? '';

$conditions = [];
$params = [];

/* =========================
   FILTER CONDITIONS
========================= */
if (!empty($package) && $package !== '500000_above' && $package !== 'all') {
    $conditions[] = "amount = :package";
    $params[':package'] = (int)$package;
} elseif ($package === '500000_above') {
    $conditions[] = "amount > :min_amount";
    $params[':min_amount'] = 500000;
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

//institution
$instQuery = "
    SELECT 
        'in' AS user_type,
        id,
        institution_id AS user_id,
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
    FROM institution
    WHERE status = '1' $filterSql
";

/* =========================
   FINAL QUERY PICK
========================= */
if ($designation === 'TE') {
    $finalQuery = $teQuery . " ORDER BY register_date ASC";
} elseif ($designation === 'F') {
    $finalQuery = $sfQuery . " ORDER BY register_date ASC";
}elseif ($designation === 'IN') {
    $finalQuery = $instQuery . " ORDER BY register_date ASC";
} elseif ($designation === 'All') {
    $finalQuery = "($teQuery) UNION ALL ($sfQuery) UNION ALL ($instQuery) ORDER BY register_date ASC";
} else {
    exit; // safety
}

$stmt = $conn->prepare($finalQuery);

foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

/* ========================= 
   TABLE OUTPUT */
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $row) {
        $bd = new DateTime($row['date_of_birth']);
        $bdate = $bd->format('d-m-Y');

        $rd = new DateTime($row['register_date']);
        $rdate = $rd->format('d-m-Y');
        if ($row["tc_assign_status"] == 1) {
            $rowClass = 'bg-success'; // TC allotted = green
            // $hoverText = 'TC Allotted';
        } else {
            $rowClass = 'bg-secondary'; // TC not allotted = no background
            // $hoverText = '';
        }
        $isoDate   = date('Y-m-d', strtotime($rdate));   // for sorting
        $humanDate = date('d-m-Y', strtotime($rdate));  // for display
        $new_reg= new DateTime('2026-01-01');
        $new_regdate = $new_reg->format('d-m-Y');
        $isNew = ($rd >= $new_reg);
        $color = $isNew ? 'green' : 'black';
        $msg = $isNew ? 'Registered to new regime of terms and conditions' : 'Registered to old regime of terms and conditions';


        echo '<tr>
                <td class="tooltip-cell" style="color: '.$color .';">
                    '. $row['user_id'].' 
                    <span class="tooltip-msg">'.$msg .'</span>
                </td>
                <td> 
                    <span class="badge '.$rowClass.' lable-width">'
                        . strtoupper($row['user_type'] == 'sf' ? 'f' : ($row['user_type'] == 'te' ? 'te' :($row['user_type'] == 'in'?'i':''))) . 
                    '</span>&nbsp;' . $row['firstname'] . ' ' . $row['lastname'] ;
                    if($row["tc_assign_status"] == 1){
                        echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">
                                TC Allotted
                                </small>';
                    } 
                    if($row["upgrade_pack"] == 2){
                        echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">
                                Upgraded
                                </small>';
                    }
        echo'   </td>
                <td>
                    <p class="mb-1">' . $row['reference_no'] . '</p>
                    <p class="mb-0">' . $row['registrant'] . '</p>
                </td>
                <td>
                    <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                    <p class="mb-0">' . $row['email'] . '</p>
                </td>';
        if($row["upgrade_pack"] == 2 && $row['user_type'] == 'sf'){
            $sql2 = "SELECT upgrade_amt 
                    FROM sub_franchisee_upgrade 
                    WHERE sub_franchisee_id = :id and upgrade_status=1 ORDER BY id DESC limit 1";

            $stmt = $conn->prepare($sql2);

            $stmt->bindParam(':id', $row['user_id'], PDO::PARAM_STR);  // $id must have the value before execute

            $stmt->execute();

            $franchisee_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($franchisee_upgrade) {
                echo'<td>' . $franchisee_upgrade['upgrade_amt'] . '</td>';
            } 
        }else if($row["upgrade_pack"] == 2 && $row['user_type'] == 'in'){
            $sql2 = "SELECT upgrade_amt 
                    FROM institution_upgrade 
                    WHERE institution_id = :id and upgrade_status=1 ORDER BY id DESC limit 1";

            $stmt = $conn->prepare($sql2);

            $stmt->bindParam(':id', $row['user_id'], PDO::PARAM_STR);  // $id must have the value before execute

            $stmt->execute();

            $institution_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($institution_upgrade) {
                echo'<td>' . $institution_upgrade['upgrade_amt'] . '</td>';
            } 
        }else{
            echo'<td>' . $row['amount'] . '</td>';    
        }
        echo '<td data-order="' . $isoDate . '">' . $humanDate . '</td>';
        if ($row['status'] == '1') {
            echo'<td><span class="badge text-bg-success">Active</span></td>
                <td><div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick=\'overviewPage("' . $row["user_id"] . '","' .$row["reference_no"] . '","' .$row["country"] . '","' .$row["state"] . '","' .$row["city"] . '","' .(strtolower($row['user_type']) == 'sf' ? 'sub_franchisee' : (strtolower($row['user_type']) == 'te' ? 'corporate_agency' : (strtolower($row['user_type']) == 'in' ? 'institution' : ''))) .'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>';
                        if($row['user_type'] == 'sf' || $row['user_type'] == 'in'){
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
}
echo '</tbody></table>';