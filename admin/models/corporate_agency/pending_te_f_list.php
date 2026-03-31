<?php
    $sql = "
        /* ---------------------------------------------------
        CORPORATE AGENCY (TE)
        - Shows pending / rejected users
        - Also shows approved users who have a transfer request
        --------------------------------------------------- */
            SELECT 
                'te' AS user_type,ca.id AS id,ca.corporate_agency_id AS user_id_str,ca.firstname,ca.lastname,ca.reference_no,ca.registrant,ca.country_code,
                ca.contact_no,ca.email,ca.amount,ca.date_of_birth,ca.added_on,ca.status,ca.register_by,ca.country,
                ca.state,ca.city,'NA' AS upgrade_status_val,'NA' AS upgrade_id,IFNULL(tu.id,'NA') AS transfer_id,
                ca.transfer_check AS transfer_check,ca.user_type AS user_type_val
            FROM corporate_agency ca
            /* Transfer request table */
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = ca.corporate_agency_id
                AND tu.transfer_status = 1
            /* Show:
                - Pending users
                - Rejected users
                - Approved users that have transfer request */
            WHERE ca.status IN ('0','2')
            OR (ca.status='1' AND ca.transfer_check='1' AND tu.id IS NOT NULL)

            UNION ALL
            /* ---------------------------------------------------
                SUB FRANCHISEE (SF) NORMAL REGISTRATION
            --------------------------------------------------- */

            SELECT 
                'sf' AS user_type,sf.id AS id,sf.sub_franchisee_id AS user_id_str,sf.firstname,sf.lastname,sf.reference_no,sf.registrant,sf.country_code,
                sf.contact_no,sf.email,sf.amount,sf.date_of_birth,sf.added_on,sf.status,sf.register_by,sf.country,
                sf.state,sf.city,sf.upgrade_status AS upgrade_status_val,'NA' AS upgrade_id,IFNULL(tu.id,'NA') AS transfer_id,
                sf.transfer_check AS transfer_check,sf.user_type AS user_type_val
            FROM sub_franchisee sf
            /* Transfer request join */
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = sf.sub_franchisee_id
                AND tu.transfer_status = 1
            WHERE sf.status IN ('0','2')
            OR (sf.status='1' AND sf.transfer_check='1' AND tu.id IS NOT NULL)

            UNION ALL

            /* ---------------------------------------------------
                INSTITUTION (IN) NORMAL REGISTRATION
            --------------------------------------------------- */
            SELECT 
                'in' AS user_type,ins.id AS id,ins.institution_id AS user_id_str,ins.firstname,ins.lastname,ins.reference_no,ins.registrant,ins.country_code,
                ins.contact_no,ins.email,ins.amount,ins.date_of_birth,ins.added_on,ins.status,ins.register_by,ins.country,
                ins.state,ins.city,ins.upgrade_status AS upgrade_status_val,'NA' AS upgrade_id,IFNULL(tu.id,'NA') AS transfer_id,
                ins.transfer_check AS transfer_check,ins.user_type AS user_type_val
            FROM institution ins
            /* Transfer request join */
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = ins.institution_id
                AND tu.transfer_status = 1
            WHERE ins.status IN ('0','2')
            OR (ins.status='1' AND ins.transfer_check='1' AND tu.id IS NOT NULL)

            UNION ALL

            /* ---------------------------------------------------
                INSTITUTION UPGRADE REQUEST
                - Only approved institutions
                - Upgrade request exists
            --------------------------------------------------- */
            SELECT 
                'in' AS user_type,i.institution_id AS id, 'NA' AS user_id_str,i.firstname,i.lastname,i.reference_no,i.registrant,i.country_code,
                i.contact_no,i.email,i.amount,i.date_of_birth,i.added_on,i.status,i.register_by,i.country,i.state,i.city,
                i.upgrade_status AS upgrade_status_val,iu.id AS upgrade_id,IFNULL(tu.id,'NA') AS transfer_id,
                i.transfer_check AS transfer_check,i.user_type AS user_type_val
            FROM institution i
            /* Upgrade table */
            LEFT JOIN institution_upgrade iu 
                ON iu.institution_id = i.institution_id
            /* Transfer request table */
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = i.institution_id
                AND tu.transfer_status = 1
            /* Only upgrade requests */
            WHERE 
            (i.status = 1 AND i.upgrade_status = 1)

            UNION ALL

            /* ---------------------------------------------------
                SUB FRANCHISEE UPGRADE REQUEST
            --------------------------------------------------- */
            SELECT 
                'sf' AS user_type,f.sub_franchisee_id AS id,'NA' AS user_id_str,f.firstname,f.lastname,f.reference_no,f.registrant,f.country_code,
                f.contact_no,f.email,f.amount,f.date_of_birth,f.added_on,f.status,f.register_by,f.country,f.state,f.city,
                f.upgrade_status AS upgrade_status_val,su.id AS upgrade_id,IFNULL(tu.id,'NA') AS transfer_id,
                f.transfer_check AS transfer_check,f.user_type AS user_type_val
            FROM sub_franchisee f
            /* Upgrade table */
            LEFT JOIN sub_franchisee_upgrade su 
                ON su.sub_franchisee_id = f.sub_franchisee_id
            /* Transfer request table */
            LEFT JOIN transfered_users tu
                ON tu.transfer_user_id = f.sub_franchisee_id
                AND tu.transfer_status = 1
            /* Only upgrade requests */
            WHERE 
            (f.status = 1 AND f.upgrade_status = 1)
            /* ---------------------------------------------------
                FINAL SORTING
            --------------------------------------------------- */
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
                                <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . $row["user_type_val"] . '")\' class="dropdown-item" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","' . $row["id"] . '","pending","'.strtolower($row['user_type']).'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","'.$row['user_type'].'")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                            </ul>
                        </div>
                    </td>';
            }else if ($row['transfer_check'] == '1')  {
                $user_id_str =$row['user_id_str'];
                echo '<td><span class="badge text-bg-info">Transfer Requested</span></td>
                        <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 2, \''.$row['user_type_val'].'\')" class="dropdown-item">
                                        <i class="mdi mdi-check-circle text-success me-1"></i> Approve
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="openTransferModal(\''.$user_id_str.'\', \''.$row['transfer_id'].'\', 3, \''.$row['user_type_val'].'\')" class="dropdown-item">
                                        <i class="mdi mdi-trash-can text-danger me-1"></i> Reject
                                    </a>
                                </li>

                                <li>
                                    <a href="#" 
                                        onclick=\'editfuncCust("' . $user_id_str . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","pending","' . $row['user_type_val'] . '")\'
                                        
                                        class="dropdown-item">
                                        <i class="mdi mdi-eye font-size-16 text-info me-1"></i> View Request
                                    </a>
                                </li>
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