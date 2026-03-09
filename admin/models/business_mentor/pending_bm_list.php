<?php
    $sql = "
        SELECT id,firstname,lastname,reference_no,registrant,country_code,email,address,state,city,zone,date_of_birth,added_on,contact_no,status,register_by,country,branch, 'BM' AS user_type FROM business_mentor WHERE status IN ('0', '2')
        UNION ALL
        SELECT id,firstname,lastname,reference_no,registrant,country_code,email,address,state,city,zone,date_of_birth,added_on,contact_no,status,register_by,country,branch, 'MF' AS user_type FROM master_franchisee WHERE status IN ('0', '2')
        UNION ALL
        SELECT id,firstname,lastname,reference_no,registrant,country_code,email,address,state,city,zone,date_of_birth,added_on,contact_no,status,register_by,country,branch, 'SF' AS user_type FROM sponsor_franchisee WHERE status IN ('0', '2')
        ORDER BY id ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $key => $row) {
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $rd = new DateTime($row['added_on']);
            $rdate = $rd->format('d-m-Y');

            // $label = $row['user_type'] == 'BM' ? '<span class="badge bg-primary me-1">BM</span>' : '<span class="badge bg-success me-1">MF</span>';
            switch ($row['user_type']) {
                case 'BM':
                    $label = '<span class="badge bg-primary me-1">BM</span>';
                    break;
                case 'MF':
                    $label = '<span class="badge bg-success me-1">MF</span>';
                    break;
                case 'SF':
                    $label = '<span class="badge bg-info me-1">SF</span>';
                    break;
                default:
                    $label = '';
            }

            echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                <td><p class="mb-1">' . $row['reference_no'] . '</p>
                    <p class="mb-0">' . $row['registrant'] . '</p>
                </td>
                <td>
                    <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                    <p class="mb-0">' . $row['email'] . '</p>
                </td>
                <td>' . $row['address'] . '</td>
                <td>' . $rdate . '</td>';

            if ($row['status'] == '2') {
                echo '<td><span class="badge text-bg-warning">Pending</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-1">
                            <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","' . $row["zone"] . '","' . $row["branch"] . '","pending","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","","pending","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                            <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                        </ul>
                    </div>
                </td>';
            } else {
                echo '<td><span class="badge text-bg-danger">Delete</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-1">
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","","deleted","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                        </ul>
                    </div>
                </td>';
            }

            echo '</tr>';
        }
    }
?>