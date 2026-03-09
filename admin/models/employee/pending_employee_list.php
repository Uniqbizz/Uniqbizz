<?php
    // 1. Fetch employees (BCM, BDM)
    $sql = "SELECT * FROM `employees` WHERE (status = '2' OR status = '0') ORDER BY employee_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $employees = $stmt->fetchAll();

    // 2. Fetch zonal managers
    $sql_zm = "SELECT * FROM `zonal_manager` WHERE (status = '2' OR status = '0') ORDER BY zonal_manager_id ASC";
    $stmt_zm = $conn->prepare($sql_zm);
    $stmt_zm->execute();
    $stmt_zm->setFetchMode(PDO::FETCH_ASSOC);
    $zonalManagers = $stmt_zm->fetchAll();

    // 3. Merge and normalize
    $allUsers = [];

    foreach ($zonalManagers as $zm) {
        $zm['user_type'] = '27';
        //$zm['id'] = $zm['zonal_manager_id']; // unify key
        $zm['added_on'] = $zm['added_on'] ?? null;
        $allUsers[] = $zm;
    }

    foreach ($employees as $emp) {
        $allUsers[] = $emp;
    }
    //var_dump($allUsers);
    //exit;
    // 4. Display all users
    $i=1;
    foreach ($allUsers as $row) {
        
        $rdate = isset($row['added_on']) ? (new DateTime($row['added_on']))->format('d-m-Y') : 'N/A';

        // Prefix badge
        $prefixBadge = '';
        if ($row['user_type'] == '27') {
            $prefixBadge = '<span class="badge bg-primary me-1">ZM</span>';
        } elseif ($row['user_type'] == '25') {
            $prefixBadge = '<span class="badge bg-info text-dark me-1">BDM</span>';
        } elseif ($row['user_type'] == '24') {
            $prefixBadge = '<span class="badge bg-success me-1">BCM</span>';
        }elseif ($row['user_type'] == '31') {
            $prefixBadge = '<span class="badge bg-secondary me-1">RM</span>';
        }

        // Final display name
        $displayName = $prefixBadge . htmlspecialchars($row['name']);

        echo '<tr>
            <td>' . $i. '</td>
            <td>' . $displayName . '</td>
            <td>
                <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact'] . '</p>
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
                        <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-1">
                            <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . ($row["reporting_manager"] ?? '') . '","' . ($row["register_by"] ?? '') . '","' . ($row["department"] ?? '') . '","' . ($row["designation"] ?? '') . '","' . ($row["zone"] ?? '') . '"," ' . ($row['branch'] ?? '') . ' ","pending","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","","pending","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                            <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
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
                        <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-1">
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","","deleted","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                        </ul>
                    </div>
                </td>';
        }

        echo '</tr>';
        $i++;
    }
?>