<?php
require "../connect.php";

$package = $_POST['package'] ?? '';
$startFrom = $_POST['StartFrom'] ?? '';
$endFrom = $_POST['EndFrom'] ?? '';

$conditions = [];
$params = [];

// Common conditions
if ($package) {
    $conditions[] = "amount = :package";
    $params[':package'] = $package;
}
if ($startFrom) {
    $conditions[] = "register_date >= :startFrom";
    $params[':startFrom'] = $startFrom;
}
if ($endFrom) {
    $conditions[] = "register_date <= :endFrom";
    $params[':endFrom'] = $endFrom;
}

$filter = '';
if (!empty($conditions)) {
    $filter = ' AND ' . implode(' AND ', $conditions);
}

// corporate_agency query
$baseQuery = "
    SELECT 
        'te' AS user_type,
        id,
        corporate_agency_id,
        firstname,
        lastname,
        reference_no,
        registrant,
        country_code,
        contact_no,
        email,
        amount,
        date_of_birth,
        register_date,
        deleted_date,
        pan_card,
        aadhar_card,
        voting_card,
        bank_passbook,
        status,
        register_by,
        country,
        state,
        city,
        SUBSTRING(corporate_agency_id, 3, 6) AS ca_id 
    FROM corporate_agency 
    WHERE status = '1' $filter
";

// sub_franchisee query
$subQuery = "
    SELECT 
        'sf' AS user_type,
        id,
        sub_franchisee_id AS corporate_agency_id,
        firstname,
        lastname,
        reference_no,
        registrant,
        country_code,
        contact_no,
        email,
        amount,
        date_of_birth,
        register_date,
        deleted_date,
        pan_card,
        aadhar_card,
        voting_card,
        bank_passbook,
        status,
        register_by,
        country,
        state,
        city,
        SUBSTRING(sub_franchisee_id, 3, 6) AS ca_id 
    FROM sub_franchisee 
    WHERE status = '1' $filter
";

// Final combined query
$finalQuery = "
    ($baseQuery)
    UNION ALL
    ($subQuery)
    ORDER BY ca_id ASC
";

$stmt = $conn->prepare($finalQuery);

// Bind values
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}

$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

// Table display
echo ' 
<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="filterTable">
    <thead class="table-light">
        <tr>
            <th>Corporate Agency Id</th>
            <th>Full Name</th>
            <th>Reference ID / Name</th>
            <th>Phone / Email</th>
            <th>Amount</th>
            <th>Joining Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>';

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $row) {
        $datev = (new DateTime($row['register_date']))->format('d-m-Y');
        $bdate = ($row['date_of_birth'] != '0000-00-00') ? (new DateTime($row['date_of_birth']))->format('d-m-Y') : '';
        $ddate = ($row['deleted_date'] && $row['deleted_date'] != '0000-00-00') ? (new DateTime($row['deleted_date']))->format('d-m-Y') : '';

        // KYC Check
        $kyc = false;
        if (
            $bdate !== "0000-00-00" &&
            $row['pan_card'] !== "" &&
            $row['bank_passbook'] !== "" &&
            (
                ($row['aadhar_card'] !== "" && $row['voting_card'] == "") ||
                ($row['aadhar_card'] == "" && $row['voting_card'] !== "")
            )
        ) {
            $kyc = true;
        }

        echo '<tr>
            <td>
                <span class="badge bg-secondary">' . strtoupper($row['user_type']) . '</span>&nbsp;
                ' . $row['corporate_agency_id'] . '
            </td>
            <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
            <td>
                <p class="mb-1">' . $row['reference_no'] . '</p>
                <p class="mb-0">' . $row['registrant'] . '</p>
            </td>
            <td>
                <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                <p class="mb-0">' . $row['email'] . '</p>
            </td>
            <td>' . $row['amount'] . '</td>
            <td>' . $datev . '</td>';

        if ($row['status'] == '1') {
            echo '<td>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                        <li><a href="#" onclick=\'overviewPage("' . $row["corporate_agency_id"] . '","' . $row["reference_no"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","corporate_agency")\' class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                        <li><a href="#" onclick=\'editfuncCust("' . $row["corporate_agency_id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","registered")\' class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                        <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["corporate_agency_id"] . '","registered")\' class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                    </ul>
                </div>
            </td>';
        } else {
            echo '<td>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-2">
                        <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["corporate_agency_id"] . '","deactivate")\' class="dropdown-item"><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                    </ul>
                </div>
            </td>';
        }

        echo '</tr>';
    }
} else {
    echo '<tr><td></td><td></td><td></td><td style="text-align:center">No Registered Techno Enterprise or Franchisee</td><td></td><td></td><td></td></tr>';
}

echo '</tbody></table></div>';
?>
