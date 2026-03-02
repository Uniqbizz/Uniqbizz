<?php
    $sql = "
        SELECT 'te' AS user_type, id AS id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status,
        register_by, country, state, city,'NA' AS upgrade_status_val,'NA' AS upgrade_id 
        FROM corporate_agency 
        WHERE status IN ('0', '2') 
        UNION ALL 
        SELECT 'sf' AS user_type, id AS id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, added_on, status, 
        register_by, country, state, city,upgrade_status AS upgrade_status_val, 'NA' AS upgrade_id 
        FROM sub_franchisee 
        WHERE status IN ('0', '2')
        UNION ALL 
        SELECT 'sf' AS user_type, f.sub_franchisee_id AS id, f.firstname, f.lastname, f.reference_no, f.registrant, f.country_code, 
        f.contact_no, f.email, f.amount, f.date_of_birth, f.added_on, f.status, f.register_by, f.country, f.state, f.city, f.upgrade_status AS upgrade_status_val,
        su.id AS upgrade_id
        FROM sub_franchisee f
        LEFT JOIN sub_franchisee_upgrade su 
            ON su.sub_franchisee_id = f.sub_franchisee_id
        WHERE 
            f.status = 1 
            AND f.upgrade_status = 1 
        ORDER BY added_on ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $rd = new DateTime($row['added_on']);
            $rdate = $rd->format('d-m-Y');

            echo '<tr>
                <td>' . $row['id'] . '</td>
                <td><span class="badge bg-secondary lable-width">' . strtoupper($row['user_type']=='sf'?'f':($row['user_type']=='te'?'te':'')) . '</span>&nbsp' . ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']) . '</td>
                <td><p class="mb-1">' . $row['reference_no'] . '</p>
                    <p class="mb-0">' . $row['registrant'] . '</p></td>
                <td>
                    <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                    <p class="mb-0">' . $row['email'] . '</p>
                </td>
                <td>' . $row['amount'] . '</td>
                <td>' . $rdate . '</td>';

            if ($row['status'] == '2') {
                echo '<td><span class="badge text-bg-warning">Pending</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . $row["user_type"] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","pending","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","'.$row['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                            </ul>
                        </div>
                    </td>';
            }else if($row['upgrade_status_val'] == 1){
                echo '<td><span class="badge text-bg-info">Upgrade Requested</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick=\'approvalfunc("' . $row["id"] . '","approve","'.$row["upgrade_id"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-check-circle font-size-16 text-success me-1"></i> approve</a></li>
                                <li><a href="#" onclick=\'approvalfunc("' . $row["id"] . '","reject","'.$row["upgrade_id"].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Reject</a></li>
                            </ul>
                        </div>
                    </td>';
            } else {
                echo '<td><span class="badge text-bg-danger">Deleted</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","deleted","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                            </ul>
                        </div>
                    </td>';
            }

            echo '</tr>';
        }
    }

?>