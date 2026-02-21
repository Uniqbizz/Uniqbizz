<table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-tableFilter">
    <thead class="table-light">
        <tr>
            <th>Business Mentor Id</th>
            <th>Full Name</th>
            <th>Reference ID / Name</th>
            <th>Phone / Email</th>
            <th>Branch</th>
            <th>Amt</th>
            <th>Joining Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    <?php
        require '../../connect.php';

        $branchFilter = $_POST['branch'] ?? '';
        $designation  = $_POST['designation'] ?? '';
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

            if ($fromDateObj && $toDateObj) {
                $conditions[] = "register_date BETWEEN :from AND :to";
                $params[':from'] = $fromDateObj->format('Y-m-d');
                $params[':to']   = $toDateObj->format('Y-m-d');
            }
        }

        // Build WHERE conditions
        $filter = '';
        if (!empty($conditions)) {
            $filter = " AND " . implode(" AND ", $conditions);
        }


        // Base queries
        $bmQuery = "
            SELECT business_mentor_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,branch,register_date,date_of_birth,country,state,city,zone,contact_no,register_by,id, 'BM' AS user_type 
            FROM business_mentor 
            WHERE status = '1' $filter
        ";

        $mfQuery = "
            SELECT master_franchisee_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,branch,register_date,date_of_birth,country,state,city,zone,contact_no,register_by,id, 'MF' AS user_type 
            FROM master_franchisee 
            WHERE status = '1' $filter
        ";

        $sfQuery = "
            SELECT sponsor_franchisee_id as user_id,firstname,lastname,reference_no,registrant,country_code,email,paid_amount,branch,register_date,date_of_birth,country,state,city,zone,contact_no,register_by,id, 'SF' AS user_type 
            FROM sponsor_franchisee 
            WHERE status = '1' $filter
        ";

        // Build final query based on designation
        if ($designation == "BM") {
            $sql = $bmQuery . " ORDER BY register_date ASC";
        } elseif ($designation == "MF") {
            $sql = $mfQuery . " ORDER BY register_date ASC";
        } elseif ($designation == "SF") {
            $sql = $sfQuery . " ORDER BY register_date ASC";
        } elseif ($designation == "All") {
            $sql = "
                ($bmQuery)
                UNION
                ($mfQuery)
                UNION
                ($sfQuery)
                ORDER BY register_date ASC
            ";
        } else {
            die("Invalid designation");
        }

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
                    <td>' . $row['user_id'] . '</td>
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

                echo'<td><span class="badge text-bg-success">Active</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end-2">
                                <li><a href="#" onclick=\'overviewPage("' . $row["user_id"] . '","' .$row["reference_no"] . '","' .$row["country"] . '","' .$row["state"] . '","' .$row["city"] . '","' .(strtolower($row['user_type']) == 'MF' ? 'master_franchisee' : (strtolower($row['user_type']) == 'BM' ? 'business_mentor' : (strtolower($row['user_type']) == 'SF' ? 'sponsor_franchisee' : ''))) .'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                <li><a href="#" onclick=\'editfuncCust("' . $row["user_id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","' . $row["zone"] . '","' . $row["branch"] . '","registered","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","registered","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>';

            echo '</tr>';
            }
        }
                                                       
    ?> 

    </tbody>
</table>