<?php
    $sql = "
        SELECT *, 'BM' AS user_type FROM business_mentor WHERE status IN ('3')
        UNION ALL
        SELECT *, 'MF' AS user_type FROM master_franchisee WHERE status IN ('3')
        UNION ALL
        SELECT *, 'SF' AS user_type FROM sponsor_franchisee WHERE status IN ('3')
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $key => $row) {
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $rd = new DateTime($row['register_date']);
            $rdate = $rd->format('d-m-Y');

            $branchID = $row['branch'];
            $branch = '';

            $sqlBranch = "SELECT branch_name FROM branch WHERE id = ?";
            $stmtId = $conn->prepare($sqlBranch);
            $stmtId->execute([$branchID]);
            if ($stmtId->rowCount() > 0) {
                $branchData = $stmtId->fetch(PDO::FETCH_ASSOC);
                $branch = $branchData['branch_name'];
            }

            $label = $row['user_type'] === 'BM'
                ? '<span class="badge bg-primary me-1">BM</span>'
                : ($row['user_type'] === 'MF' ? '<span class="badge bg-success me-1">MF</span>'
                : ($row['user_type'] === 'SF' ? '<span class="badge bg-info me-1">SF</span>' : ''));

        echo '<tr>
                <td>' . $row['business_mentor_id'] . '</td>
                <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                <td><p class="mb-1">' . $row['reference_no'] . '</p>
                    <p class="mb-0">' . $row['registrant'] . '</p>
                </td>
                <td>
                    <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                    <p class="mb-0">' . $row['email'] . '</p>
                </td>
                <td>' . $branch . '</td>
                <td>' . $row['paid_amount'] . '</td>
                <td>' . $rdate . '</td>';

            echo'<td><span class="badge text-bg-danger">Deactive</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["business_mentor_id"] . '","deactivate","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                        </ul>
                    </div>
                </td>';

        echo '</tr>';
        }
    }
?>