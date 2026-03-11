<?php
    
    // 1. Fetch employees (BCM, BDM)
    $sql = "SELECT e.*, 'NA' AS transfer_id
            FROM employees e
            WHERE e.status IN ('0','2')

            UNION ALL

            SELECT e.*, tu.id AS transfer_id
            FROM employees e
            INNER JOIN transfered_users tu 
                ON tu.transfer_user_id = e.employee_id 
                AND tu.transfer_status = 1
            WHERE e.status = '1'
            AND e.transfer_check = '1'

            ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $employees = $stmt->fetchAll();

    // 2. Fetch zonal managers
    $sql_zm = "SELECT zm.*, 'NA' AS transfer_id
                FROM zonal_manager zm
                WHERE zm.status IN ('0','2')

                UNION ALL

                SELECT zm.*, tu.id AS transfer_id
                FROM zonal_manager zm
                INNER JOIN transfered_users tu 
                    ON tu.transfer_user_id = zm.zonal_manager_id
                    AND tu.transfer_status = 1
                WHERE zm.status = '1'
                AND zm.transfer_check = '1'

                ORDER BY id ASC";
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
        }else if ($row['transfer_check'] == '1')  {
            $user_id_str = ($row['user_type'] == 27) ? $row['zonal_manager_id'] : $row['employee_id'];
            echo '<td><span class="badge text-bg-info">Transfer Requested</span></td>
                    <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu">

                            <li>
                                <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 2, \''.$row['user_type'].'\')" class="dropdown-item">
                                    <i class="mdi mdi-check-circle text-success me-1"></i> Approve
                                </a>
                            </li>

                            <li>
                                <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 3, \''.$row['user_type'].'\')" class="dropdown-item">
                                    <i class="mdi mdi-trash-can text-danger me-1"></i> Reject
                                </a>
                            </li>

                            <li>
                                <a href="#" 
                                    onclick="editfuncCust(
                                        \'' . $user_id_str . '\',
                                        \'' . ($row['reporting_manager'] ?? '') . '\',
                                        \'' . ($row['register_by'] ?? '') . '\',
                                        \'' . ($row['department'] ?? '') . '\',
                                        \'' . ($row['designation'] ?? '') . '\',
                                        \'' . ($row['zone'] ?? '') . '\',
                                        \'' . ($row['branch'] ?? '') . '\',
                                        \'registered\',
                                        \'' . $row['user_type'] . '\'
                                    )" 
                                    class="dropdown-item">
                                    <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View Request
                                </a>
                            </li>
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