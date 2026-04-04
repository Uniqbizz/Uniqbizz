<?php
    require '../../connect.php';

    $stateFilter = $_POST['state'] ?? 'All';
    $userId = $_POST['userId'] ?? '';
    $designation = $_POST['designation'] ?? '';
    $fromDate = $_POST['fromDate'] ?? '';
    $toDate = $_POST['toDate'] ?? '';

    $reporting_manager = '';

    $whereClause = "WHERE 1=1";
    $params = [];

    /* ================= STATE FILTER ================= */

    if ($stateFilter !== '0' && $stateFilter !== '' && $stateFilter !== 'All') {
        $whereClause .= " AND state = ?";
        $params[] = $stateFilter;
    }

    /* ================= DATE FILTER ================= */

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

    try {

        if (!empty($designation)) {

            function fetchColumn($conn,$sql,$params=[]){
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_COLUMN);
            }

            /* ================= BM ================= */

            if ($designation == '26') {

                if (!empty($userId)) {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no = ?
                    AND status='1'",[$userId]);

                } else {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no LIKE 'BM%'
                    AND status='1'");

                    $teList = fetchColumn($conn,
                    "SELECT corporate_agency_id
                    FROM corporate_agency
                    WHERE reference_no LIKE 'BM%'
                    AND (status='1' OR status='3')");

                    if(!empty($teList)){

                        $ph = implode(',',array_fill(0,count($teList),'?'));

                        $tcFromTE = fetchColumn($conn,
                        "SELECT ca_travelagency_id
                        FROM ca_travelagency
                        WHERE reference_no IN ($ph)
                        AND status='1'",$teList);

                        $tcIds = array_merge($tcIds,$tcFromTE);
                    }
                }
            }

            /* ================= MF ================= */

            elseif ($designation == '28') {

                if (!empty($userId)) {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no = ?
                    AND status='1'",[$userId]);

                } else {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no LIKE 'MF%'
                    AND status='1'");

                    $frList = fetchColumn($conn,
                    "SELECT sub_franchisee_id
                    FROM sub_franchisee
                    WHERE reference_no LIKE 'MF%'
                    AND (status='1' OR status='3')");

                    if(!empty($frList)){

                        $ph = implode(',',array_fill(0,count($frList),'?'));

                        $tcFromF = fetchColumn($conn,
                        "SELECT ca_travelagency_id
                        FROM ca_travelagency
                        WHERE reference_no IN ($ph)
                        AND status='1'",$frList);

                        $tcIds = array_merge($tcIds,$tcFromF);
                    }
                }
            }

            /* ================= TE ================= */

            elseif ($designation == '16') {

                if (!empty($userId)) {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no = ?
                    AND status='1'",[$userId]);

                } else {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE (reference_no LIKE 'TE%' OR reference_no LIKE 'CA%')
                    AND status='1'");
                }
            }

            /* ================= F ================= */

            elseif ($designation == '29') {

                if (!empty($userId)) {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no = ?
                    AND status='1'",[$userId]);

                } else {

                    $tcIds = fetchColumn($conn,
                    "SELECT ca_travelagency_id
                    FROM ca_travelagency
                    WHERE reference_no LIKE 'F%'
                    AND status='1'");
                }
            }

            /* ================= INSTITUTION ================= */

            elseif ($designation == '32') {

                if (!empty($userId)) {

                    $tcIds = fetchColumn($conn,
                    "SELECT institution_branch_manager_id
                    FROM institution_branch_manager
                    WHERE reference_no = ?
                    AND status='1'",[$userId]);

                } else {

                    $tcIds = fetchColumn($conn,
                    "SELECT institution_branch_manager_id
                    FROM institution_branch_manager
                    WHERE reference_no LIKE 'I%'
                    AND status='1'");
                }
            }

        }

    } catch(PDOException $e){
        echo '<p class="text-center">Error loading TC hierarchy.</p>';
        exit;
    }

    /* ================= MAIN QUERY ================= */

    $isFilterApplied = isset($_POST['designation']) && $_POST['designation'] != '';

    $whereConditions = [];
    $queryParams = $params;

    if ($isFilterApplied) {

        if (!empty($tcIds)) {

            $ph = implode(',',array_fill(0,count($tcIds),'?'));

            $whereConditions[] = "user_id IN ($ph)";
            $queryParams = array_merge($queryParams,$tcIds);

        } else {

            $whereConditions[] = "1=0";
        }
    }

    if(!empty($whereConditions)){
        $whereClause .= " AND ".implode(" AND ",$whereConditions);
    }

    $innerQuery = "

        SELECT 'tc' AS user_type,id,ca_travelagency_id AS user_id,reference_no,registrant,amount,country_code,contact_no,
        address,register_date,status,country,state,city,firstname,lastname,email,register_by,user_type AS user_type_val
        FROM ca_travelagency WHERE status = 1

        UNION ALL

        SELECT 'ibr' AS user_type,id,institution_branch_manager_id AS user_id,reference_no,registrant,amount,country_code,contact_no,
        address,register_date,status,country,state,city,firstname,lastname,email,register_by,user_type AS user_type_val
        FROM institution_branch_manager WHERE status = 1
    ";

    /* ================= FINAL QUERY ================= */

    $query = "SELECT * FROM ( $innerQuery ) AS final_table $whereClause";

    $stmt = $conn->prepare($query);
    $stmt->execute($queryParams);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ================= TABLE ================= */

    if(empty($rows)){
        echo '<p class="text-center">No TC data found.</p>';
        exit;
    }

    echo '<table id="registeredCustomerList-table" class="table align-middle table-nowrap dt-responsive nowrap w-100">';

    echo '<thead class="table-light">
    <tr>
    <th>TC Id / Full Name</th>
    <th>Reference ID / Name</th>
    <th>Referal Ref ID/ Name</th>
    <th>Paid Amount</th>
    <th>Phone / Email</th>
    <th>Address</th>
    <th>Joining Date</th>
    <th>Status</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>';

    foreach ($rows as $row){

        $rdate_display = date("d-m-Y", strtotime($row['register_date']));
        $rdate_sort = date("Y-m-d", strtotime($row['register_date']));

        $statusClass = ($row['status'] == '1') ? 'success' : 'danger';
        $statusText  = ($row['status'] == '1') ? 'Active' : 'Deactive';

        $name = $id = '';
        $reference_no=(substr($row['reference_no'],0,1) == 'F' || substr($row['reference_no'],0,1) == 'I') ? substr($row['reference_no'],0,1):
                    substr($row['reference_no'],0,2);

        if ($reference_no == 'TE' || $reference_no == 'CA') {
            $stmt2 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = ? AND (status = '1' OR status = '3')");
            $stmt2->execute([$row['reference_no']]);
            if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $name = $refData['registrant'];
                $id = $refData['reference_no'];
            }
        } elseif ($reference_no == 'I') {
            $stmt2 = $conn->prepare("SELECT * FROM institution WHERE institution_id = ? AND (status = '1' OR status = '3')");
            $stmt2->execute([$row['reference_no']]);
            if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $name = $refData['registrant'];
                $id = $refData['reference_no'];
            }
        } elseif ($reference_no == 'F') {
            $stmt2 = $conn->prepare("SELECT * FROM sub_franchisee WHERE sub_franchisee_id = ? AND (status = '1' OR status = '3')");
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
        } elseif ($reference_no == 'MF') {
            $stmt2 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = ? AND (status = '1' OR status = '3')");
            $stmt2->execute([$row['reference_no']]);
            if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $name = $refData['registrant'];
                $id = $refData['reference_no'];
            }
        } elseif ($reference_no == 'SF') {
            $stmt2 = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = ? AND (status = '1' OR status = '3')");
            $stmt2->execute([$row['reference_no']]);
            if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $name = $refData['registrant'];
                $id = $refData['reference_no'];
            }
        }elseif ($reference_no == 'BH') {
            $stmt2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = ? AND (status = '1' OR status = '3')");
            $stmt2->execute([$row['reference_no']]);
            if ($refData = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $reporting_manager = $refData['reporting_manager'];
            }
            $stmt3 = $conn->prepare("SELECT * FROM employees WHERE employee_id = ? AND (status = '1' OR status = '3')");
            $stmt3->execute([$reporting_manager]);
            if ($refData2 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                $id = $refData2['employee_id'];
                $name = $refData2['name'];
            }
        }

        echo '<tr>';

        echo '<td>
        <p class="mb-1">'.htmlspecialchars($row['user_id']).'</p>
        <p class="mb-0">'.htmlspecialchars($row['firstname'].' '.$row['lastname']).'</p>
        </td>';

        echo '<td>
        <p class="mb-1">'.htmlspecialchars($row['reference_no']).'</p>
        <p class="mb-0">'.htmlspecialchars($row['registrant']).'</p>
        </td>';

        echo '<td>
        <p class="mb-1">'.htmlspecialchars($id).'</p>
        <p class="mb-0">'.htmlspecialchars($name).'</p>
        </td>';

        echo '<td>'.htmlspecialchars($row['amount'] ?: 0).'</td>';

        echo '<td>
        <p class="mb-1">+'.htmlspecialchars($row['country_code']).' '.htmlspecialchars($row['contact_no']).'</p>
        <p class="mb-0">'.htmlspecialchars($row['email']).'</p>
        </td>';

        echo '<td>'.htmlspecialchars($row['address']).'</td>';

        echo '<td data-order="'.$rdate_sort.'">' . $rdate_display . '</td>';

        echo '<td><span class="badge text-bg-'.$statusClass.'">'.$statusText.'</span></td>';

        echo '<td>
        <div class="dropdown">
        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown">
        <i class="mdi mdi-dots-horizontal font-size-18"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">

        <li>
        <a href="#"
        onclick="overviewPage(\''.$row['user_id'].'\',\''.$row['reference_no'].'\',\''.$row['country'].'\',\''.$row['state'].'\',\''.$row['city'].'\',\''.($row['user_type']=='tc'?'ca_travelagency':'institution_branch_manager').'\')"
        class="dropdown-item">
        <i class="mdi mdi-eye text-info me-1"></i> View
        </a>
        </li>

        <li>
        <a href="#"
        onclick="editfuncCust(\''.$row['user_id'].'\',\''.$row['reference_no'].'\',\''.$row['register_by'].'\',\''.$row['country'].'\',\''.$row['state'].'\',\''.$row['city'].'\',\'registered\',\''.$row['user_type_val'].'\')"
        class="dropdown-item">
        <i class="mdi mdi-pencil text-primary me-1"></i> Edit
        </a>
        </li>

        <li>
        <a href="#"
        onclick="deletefunc(\''.$row['id'].'\',\''.$row['user_id'].'\',\'registered\',\''.$row['user_type'].'\')"
        class="dropdown-item">
        <i class="mdi mdi-trash-can text-danger me-1"></i> Delete
        </a>
        </li>

        </ul>
        </div>
        </td>';

        echo '</tr>';
    }

    echo '</tbody></table>';
?>