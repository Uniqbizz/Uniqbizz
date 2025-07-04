<?php
require '../connect.php';

$stateFilter = $_POST['state'] ?? null;
$userId = $_POST['userId'] ?? '';
$designation = $_POST['designation'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';

function fetchReferrerInfo($conn, $refNo) {
    $refType = substr($refNo, 0, 2);
    $info = ['id' => '', 'name' => ''];

    if (in_array($refType, ['TE', 'CA'])) {
        $sql = "SELECT reference_no, registrant FROM corporate_agency WHERE corporate_agency_id = :refNo AND (status = '1' OR status = '3')";
    } else if ($refType === "BM") {
        $sql = "SELECT reference_no, registrant FROM business_mentor WHERE business_mentor_id = :refNo AND (status = '1' OR status = '3')";
    } else {
        return $info;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':refNo', $refNo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $info['id'] = $row['reference_no'];
        $info['name'] = $row['registrant'];
    }
    return $info;
}

$whereClause = "WHERE (status = '1' OR status = '3')";
$params = [];

if (!empty($stateFilter) && $stateFilter !== '0') {
    $whereClause .= " AND state = ?";
    $params[] = $stateFilter;
}

if (!empty($fromDate) && !empty($toDate)) {
    $whereClause .= " AND DATE(register_date) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
}

$refIds = [];

if (!empty($userId) && !empty($designation)) {
    if ($designation == '26') { // BM
        $refIds[] = $userId;
        $stmt = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
        $stmt->execute([':bm' => $userId]);
        $teList = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $refIds = array_merge($refIds, $teList);
    } elseif ($designation == '25') { // BDM
        $stmt = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = :bdm AND (status = '1' OR status = '3')");
        $stmt->execute([':bdm' => $userId]);
        $bmList = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $refIds = array_merge($refIds, $bmList);

        foreach ($bmList as $bmId) {
            $stmt = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
            $stmt->execute([':bm' => $bmId]);
            $teList = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $refIds = array_merge($refIds, $teList);
        }
    }
}

if (!empty($refIds)) {
    $placeholders = implode(',', array_fill(0, count($refIds), '?'));
    $whereClause .= " AND reference_no IN ($placeholders)";
    $params = array_merge($params, $refIds);
}

$sql = "SELECT * FROM ca_travelagency $whereClause ORDER BY ca_travelagency_id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-tableFilter">
    <thead class="table-light">
        <tr>
            <th>Travel Consultant Id</th>
            <th>Full Name</th>
            <th>Reference ID / Name</th>
            <th>Referal Ref ID/ Name</th>
            <th>Phone / Email</th>
            <th>Address</th>
            <th>Joining Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row):
        $rdate = (new DateTime($row['register_date']))->format('d-m-Y');
        $refInfo = fetchReferrerInfo($conn, $row['reference_no']);
    ?>
        <tr>
            <td><?= $row['ca_travelagency_id'] ?></td>
            <td><?= $row['firstname'] . ' ' . $row['lastname'] ?></td>
            <td><p class="mb-1"><?= $row['reference_no'] ?></p><p class="mb-0"><?= $row['registrant'] ?></p></td>
            <td><p class="mb-1"><?= $refInfo['id'] ?></p><p class="mb-0"><?= $refInfo['name'] ?></p></td>
            <td><p class="mb-1">+<?= $row['country_code'] . ' ' . $row['contact_no'] ?></p><p class="mb-0"><?= $row['email'] ?></p></td>
            <td><?= $row['address'] ?></td>
            <td><?= $rdate ?></td>
            <td>
                <?php if ($row['status'] == '1'): ?>
                    <span class="badge text-bg-success">Active</span>
                <?php else: ?>
                    <span class="badge text-bg-danger">Deactive</span>
                <?php endif; ?>
            </td>
            <td>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if ($row['status'] == '1'): ?>
                            <li><a href="#" onclick='overviewPage("<?= $row["ca_travelagency_id"] ?>", "<?= $row["reference_no"] ?>", "<?= $row["country"] ?>", "<?= $row["state"] ?>", "<?= $row["city"] ?>", "ca_travelagency")' class="dropdown-item"><i class="mdi mdi-eye text-info me-1"></i> View</a></li>
                            <li><a href="#" onclick='editfuncCust("<?= $row["ca_travelagency_id"] ?>", "<?= $row["reference_no"] ?>", "<?= $row["register_by"] ?>", "<?= $row["country"] ?>", "<?= $row["state"] ?>", "<?= $row["city"] ?>", "registered")' class="dropdown-item"><i class="mdi mdi-pencil text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick='deletefunc("<?= $row["id"] ?>", "<?= $row["ca_travelagency_id"] ?>", "registered")' class="dropdown-item"><i class="mdi mdi-trash-can text-danger me-1"></i> Delete</a></li>
                        <?php else: ?>
                            <li><a href="#" onclick='deletefunc("<?= $row["id"] ?>", "<?= $row["ca_travelagency_id"] ?>", "deactivate")' class="dropdown-item"><i class="mdi mdi-file-restore text-success me-1"></i> Restore</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
