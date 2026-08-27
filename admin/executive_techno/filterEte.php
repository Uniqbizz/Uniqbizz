<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-tableFilter">
    <thead class="table-light">
        <tr>
            <th>STE Id</th>
            <th>Full Name</th>
            <th>Reference ID / Name</th>
            <th>Phone / Email</th>
            <th>Amt</th>
            <th>Joining Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    <?php
        require '../connect.php';

        $branchFilter = $_POST['branch'] ?? '';
        $from=$_POST['fromDate']??'';
        $to=$_POST['toDate']??'';
        $conditions = [];
        $params = [];

        // Apply branch filter if provided
        if (!empty($branchFilter)) {
            $conditions[] = "branch = :branch";
            $params[':branch'] = $branchFilter;
        }

        // Date filter
        if (!empty($from) && !empty($to)) {
            $fromDateObj = DateTime::createFromFormat('d-m-Y', $from);
            $toDateObj   = DateTime::createFromFormat('d-m-Y', $to);

            //changed on 28-05-2026 by SV 
            if ($fromDateObj && $toDateObj) {

                // Same date
                if ($fromDateObj->format('Y-m-d') == $toDateObj->format('Y-m-d')) {

                    $conditions[] = "register_date >= :from_start 
                                    AND register_date < :from_end";

                    $params[':from_start'] = $fromDateObj->format('Y-m-d') . ' 00:00:00';

                    $nextDay = clone $fromDateObj;
                    $nextDay->modify('+1 day');

                    $params[':from_end'] = $nextDay->format('Y-m-d') . ' 00:00:00';

                } 
                // Different dates
                else {

                    $conditions[] = "register_date BETWEEN :from AND :to";

                    $params[':from'] = $fromDateObj->format('Y-m-d') . ' 00:00:00';
                    $params[':to']   = $toDateObj->format('Y-m-d') . ' 23:59:59';
                }
            }
        }

        // Build WHERE conditions
        $filter = '';
        if (!empty($conditions)) {
            $filter = " AND " . implode(" AND ", $conditions);
        }


        // Base queries
        $bmQuery = "
            SELECT executive_techno_enterprise_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,register_date,date_of_birth,country,state,city,contact_no,register_by,id, 'ETE' AS user_type 
            FROM executive_techno_enterprise 
            WHERE status = '1' $filter
        ";


        // Build final query based on designation
        
        $sql = "
            ($bmQuery)
            ORDER BY id ASC
        ";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $key => $row) {
                $bd = new DateTime($row['date_of_birth']);
                $bdate = $bd->format('d-m-Y');

                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');

               

                $label = $row['user_type'] == 'ETE'
                    ? '<span class="badge bg-primary me-1">ETE</span>':'NA';

            echo '<tr>
                    <td>' . $row['user_id'] . '</td>
                    <td>' . $label . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                    <td><p class="mb-1">' . $row['reference_no'] . '</p>
                        <p class="mb-0">' . $row['registrant'] . '</p>
                    </td>
                    <td>
                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                        <p class="mb-0">' . $row['email'] . '</p>
                    </td>
                    <td>' . $row['paid_amount'] . '</td>
                    <td>' . $rdate . '</td>';

                echo'<td><span class="badge text-bg-success">Active</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                <li>
                                    <a href="#" 
                                        onclick=\'overviewPage(
                                            "' . $row["user_id"] . '",
                                            "' . $row["reference_no"] . '",
                                            "' . $row["country"] . '",
                                            "' . $row["state"] . '",
                                            "' . $row["city"] . '",
                                            "' . (strtolower($row["user_type"]) == "STE" 
                                                    ? "executive_techno_enterprise" 
                                                    : "NA") . '"
                                        )\' 
                                        class="dropdown-item" 
                                        data-bs-toggle="modal">
                                            <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a href="#" 
                                        onclick=\'editfuncCust(
                                                                "' . $row["user_id"] . '",
                                                                "' . $row["reference_no"] . '",
                                                                "' . $row["register_by"] . '",
                                                                "' . $row["country"] . '",
                                                                "' . $row["state"] . '",
                                                                "' . $row["city"] . '",
                                                                "registered",
                                                                "' . strtolower($row['user_type']) . '")\' 
                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                    <i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="#" 
                                        onclick=\'deletefunc(
                                                                "' . $row["id"] . '",
                                                                "' . $row["user_id"] . '",
                                                                "registered",
                                                                "' . strtolower($row['user_type']) . '")\' 
                                                                class="dropdown-item" data-bs-toggle="modal" >
                                                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>';

            echo '</tr>';
            }
        }
                                                       
    ?> 

    </tbody>
</table>