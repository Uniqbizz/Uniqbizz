<?php
    $sql = "
        SELECT 'te' AS user_type, id, corporate_agency_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, register_date, status, register_by, country, state, city,no_tc_alloted,tc_assign_status 
        FROM corporate_agency 
        WHERE status IN ('3') 
        UNION ALL 
        SELECT 'sf' AS user_type, id, sub_franchisee_id AS user_id, firstname, lastname, reference_no, registrant, country_code, contact_no, email, amount, date_of_birth, register_date, status, register_by, country, state, city,no_tc_alloted,tc_assign_status 
        FROM sub_franchisee 
        WHERE status IN ('3') 
        ORDER BY register_date ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $bd = new DateTime($row['date_of_birth']);
            $bdate = $bd->format('d-m-Y');

            $rd = new DateTime($row['register_date']);
            $rdate = $rd->format('d-m-Y');
            if ($row["tc_assign_status"] == 1) {
                $rowClass = 'bg-success'; // TC allotted = green
                // $hoverText = 'TC Allotted';
            } else {
                $rowClass = 'bg-secondary'; // TC not allotted = no background
                // $hoverText = '';
            }

            echo '<tr>
                    <td>' . $row['user_id'] . '</td>
                    <td> 
                        <span class="badge '.$rowClass.' lable-width">'
                            . strtoupper($row['user_type'] == 'sf' ? 'f' : ($row['user_type'] == 'te' ? 'te' : '')) . 
                        '</span>&nbsp;' . $row['firstname'] . ' ' . $row['lastname'] ;
                        if($row["tc_assign_status"] == 1){
                            echo '<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">
                                    TC Allotted
                                    </small>';
                        } 
            echo'   </td>
                    <td>
                        <p class="mb-1">' . $row['reference_no'] . '</p>
                        <p class="mb-0">' . $row['registrant'] . '</p>
                    </td>
                    <td>
                        <p class="mb-1">+' . $row['country_code'] . ' ' . $row['contact_no'] . '</p>
                        <p class="mb-0">' . $row['email'] . '</p>
                    </td>
                    <td>' . $row['amount'] . '</td>
                    <td>' . $rdate . '</td>';
            echo '  <td><span class="badge text-bg-danger">Deactive</span></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["user_id"] . '","deactivate","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                            </ul>
                        </div>
                    </td>';
            echo '</tr>';
        }
    }
?>