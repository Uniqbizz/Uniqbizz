<?php
require '../connect.php';

$stateFilter = $_POST['state'] ?? null;
$userId = $_POST['userId'] ?? '';
$designation = $_POST['designation'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';

$whereClause = "WHERE (status = '1' OR status = '3')";
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
        if ($designation == '26') { // BM
            if (!empty($userId)) {
                $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
                $stmt->execute([':bm' => $userId]);
                $tcIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            } else {
                $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no LIKE 'BM%' AND (status = '1' OR status = '3')");
                $stmt->execute();
                $tcIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // Optionally include TCs from TEs under BMs
                /*
                $stmt = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no LIKE 'BM%' AND (status = '1' OR status = '3')");
                $stmt->execute();
                $teList = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($teList as $teId) {
                    $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :te AND (status = '1' OR status = '3')");
                    $stmt->execute([':te' => $teId]);
                    $tcFromTE = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $tcIds = array_merge($tcIds, $tcFromTE);
                }
                */
            }
        } elseif ($designation == '16') { // TE
            if (!empty($userId)) {
                $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :te AND (status = '1' OR status = '3')");
                $stmt->execute([':te' => $userId]);
                $tcIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            }else{
                //check if te reference_no prefix in TE or CA
                // the show those tc only
                $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE (reference_no LIKE 'TE%' OR reference_no LIKE 'CA%')  AND (status = '1' OR status = '3')");
                $stmt->execute();
                $tcIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            }
        } elseif ($designation == '25') { // BDM
            $bmList = [];

            if (empty($userId)) {
                $stmt = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE (status = '1' OR status = '3')");
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = :bdm AND (status = '1' OR status = '3')");
                $stmt->execute([':bdm' => $userId]);
            }

            $bmList = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($bmList as $bmId) {
                $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
                $stmt->execute([':bm' => $bmId]);
                $tcList = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $tcIds = array_merge($tcIds, $tcList);

                $stmt = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
                $stmt->execute([':bm' => $bmId]);
                $teList = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($teList as $teId) {
                    $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :te AND (status = '1' OR status = '3')");
                    $stmt->execute([':te' => $teId]);
                    $tcFromTE = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $tcIds = array_merge($tcIds, $tcFromTE);
                }
            }
        } elseif ($designation == '24') { // BCM
            $stm_bcm = empty($userId)
                ? $conn->prepare("SELECT employee_id FROM employees WHERE user_type='25' AND (status = '1' OR status = '3')")
                : $conn->prepare("SELECT employee_id FROM employees WHERE user_type='25' AND (status = '1' OR status = '3') AND reporting_manager = :id");

            empty($userId) ? $stm_bcm->execute() : $stm_bcm->execute([':id' => $userId]);
            $bdmList = $stm_bcm->fetchAll(PDO::FETCH_COLUMN);

            foreach ($bdmList as $bdmId) {
                $stmt = $conn->prepare("SELECT business_mentor_id FROM business_mentor WHERE reference_no = :bdm AND (status = '1' OR status = '3')");
                $stmt->execute([':bdm' => $bdmId]);
                $bmList = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($bmList as $bmId) {
                    $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
                    $stmt->execute([':bm' => $bmId]);
                    $tcList = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $tcIds = array_merge($tcIds, $tcList);

                    $stmt = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = :bm AND (status = '1' OR status = '3')");
                    $stmt->execute([':bm' => $bmId]);
                    $teList = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($teList as $teId) {
                        $stmt = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = :te AND (status = '1' OR status = '3')");
                        $stmt->execute([':te' => $teId]);
                        $tcFromTE = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        $tcIds = array_merge($tcIds, $tcFromTE);
                    }
                }
            }
        }
    }
} catch (PDOException $e) {
    echo '<p class="text-center">Error loading TC hierarchy.</p>';
    exit;
}

// Now fetch and render the final TC table
try {
    if (!empty($tcIds)) {
        $placeholders = implode(',', array_fill(0, count($tcIds), '?'));
        $whereClause .= " AND ca_travelagency_id IN ($placeholders)";
        $params = array_merge($params, $tcIds);
    }

    $sql = "SELECT * FROM ca_travelagency $whereClause ORDER BY ca_travelagency_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {
        echo '<table id="registeredCustomerList-tableFilter" class="table align-middle table-nowrap dt-responsive nowrap w-100">';
        echo '<thead class="table-light"><tr><th>Travel Consultant Id</th><th>Full Name</th><th>Reference ID / Name</th><th>Referal Ref ID/ Name</th><th>Phone / Email</th><th>Address</th><th>Joining Date</th><th>Status</th><th>Action</th></tr></thead><tbody>';

        foreach ($rows as $row) {
            $rdate = (new DateTime($row['register_date']))->format('d-m-Y');
            $reference_no = substr($row['reference_no'], 0, 2);
            $name = $id = '';

            if ($reference_no == 'TE' || $reference_no == 'CA') {
                $stmt2 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = ? AND (status = '1' OR status = '3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }
            } elseif ($reference_no == 'BM') {
                $stmt2 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = ? AND (status = '1' OR status = '3')");
                $stmt2->execute([$row['reference_no']]);
                if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $name = $refData['registrant'];
                    $id = $refData['reference_no'];
                }
            }

            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['ca_travelagency_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . '</td>';
            echo '<td><p class="mb-1">' . htmlspecialchars($row['reference_no']) . '</p><p class="mb-0">' . htmlspecialchars($row['registrant']) . '</p></td>';
            echo '<td><p class="mb-1">' . htmlspecialchars($id) . '</p><p class="mb-0">' . htmlspecialchars($name) . '</p></td>';
            echo '<td><p class="mb-1">+' . htmlspecialchars($row['country_code']) . ' ' . htmlspecialchars($row['contact_no']) . '</p><p class="mb-0">' . htmlspecialchars($row['email']) . '</p></td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . $rdate . '</td>';
            echo '<td><span class="badge text-bg-' . ($row['status'] == '1' ? 'success">Active' : 'danger">Deactive') . '</span></td>';
            echo '<td><div class="dropdown"><a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal font-size-18"></i></a><ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">';
            echo '<li><a href="#" onclick="overviewPage(\'' . $row['ca_travelagency_id'] . '\',\'' . $row['reference_no'] . '\',\'' . $row['country'] . '\',\'' . $row['state'] . '\',\'' . $row['city'] . '\',\'ca_travelagency\')" class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>';
            echo '<li><a href="#" onclick="editfuncCust(\'' . $row['ca_travelagency_id'] . '\',\'' . $row['reference_no'] . '\',\'' . $row['register_by'] . '\',\'' . $row['country'] . '\',\'' . $row['state'] . '\',\'' . $row['city'] . '\',\'registered\')" class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>';
            echo '<li><a href="#" onclick="deletefunc(\'' . $row['id'] . '\',\'' . $row['ca_travelagency_id'] . '\',\'registered\')" class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>';
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