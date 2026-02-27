<?php
    // Fetch employees
    $sql = "SELECT * FROM `employees` WHERE status = '1' ORDER BY employee_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch zonal managers
    $sql2 = "SELECT *  FROM `zonal_manager` WHERE status = '1' ORDER BY zonal_manager_id ASC";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $zonal_managers = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // First: Zonal Managers
    foreach ($zonal_managers as $row) {
        $rdate = (new DateTime($row['register_date']))->format('d-m-Y');

        echo '<tr>
            <td>' . $row['zonal_manager_id'] . '</td>
            <td><span class="badge bg-primary me-1">ZM</span>' . $row['name'] . '</td>
            <td>N/A</td>
            <td>
                <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact'] . '</p>
                <p class="mb-0">' . $row['email'] . '</p>
            </td>
            <td>' . $rdate . '</td>';
            
            echo '<td><span class="badge text-bg-success">Active</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                            <li><a href="#" onclick=\'overviewPage("' . $row["zonal_manager_id"] . '","NA","NA","NA","NA","NA","' .$row['user_type'] .'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                            <li><a href="#" onclick=\'editfuncCust("' . $row["zonal_manager_id"] . '","NA","' . $row["register_by"] . '","NA","NA","' . $row["zone"] . '","NA","registered","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["zonal_manager_id"] . '","registered","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>';
            
        echo '</tr>';
    }

    // Then: Employees
    foreach ($employees as $row) {
        $rdate = (new DateTime($row['register_date']))->format('d-m-Y');

        // Get reporting manager name
        $reporting_manager_name = 'N/A';
        if (!empty($row['reporting_manager']) && $row['reporting_manager'] != 'null') {
            $stmt3 = $conn->prepare("SELECT name FROM employees WHERE employee_id = ?");
            $stmt3->execute([$row['reporting_manager']]);
            if ($r = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                $reporting_manager_name = $r['name'];
            }
        }

        // Determine prefix
        $prefix = '';
        if ($row['user_type'] == '25') {
            $prefix = '<span class="badge bg-info text-dark me-1">BDM</span>';
        } elseif ($row['user_type'] == '24') {
            $prefix = '<span class="badge bg-success me-1">BCM</span>';
        }elseif ($row['user_type'] == '31') {
            $prefix = '<span class="badge bg-secondary me-1">RM</span>';
        }

        echo '<tr>
            <td>' . $row['employee_id'] . '</td>
            <td>' . $prefix . ' ' . $row['name'] . '</td>
            <td>
                <p class="mb-1">' . $row['reporting_manager'] . '</p>
                <p class="mb-0">' . $reporting_manager_name . '</p>
            </td>
            <td>
                <p class="mb-1">+' . $row['country_code'] . $row['contact'] . '</p>
                <p class="mb-0">' . $row['email'] . '</p>
            </td>
            <td>' . $rdate . '</td>';
            echo '<td><span class="badge text-bg-success">Active</span></td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                            <li><a href="#" onclick=\'overviewPage("' . $row["employee_id"] . '","' .$row["reporting_manager"] . '","NA","NA","NA","NA","NA","' .$row['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                            <li><a href="#" onclick=\'editfuncCust("' . $row["employee_id"] . '","' . $row["reporting_manager"] . '","' . $row["register_by"] . '","'.$row['department'].'","'.$row['designation'].'","' . $row["zone"] . '","' . $row["branch"] . '","registered","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["employee_id"] . '","registered","' . $row['user_type'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>';
            
        echo '</tr>';
    }
?>