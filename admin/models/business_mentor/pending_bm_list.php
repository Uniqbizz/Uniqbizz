<?php
    $sql = "
        SELECT 
            bm.id,bm.business_mentor_id AS user_id_str,bm.firstname,bm.lastname,
            bm.reference_no,bm.registrant,bm.country_code,bm.email,bm.address,
            bm.state,bm.city,bm.zone,bm.date_of_birth,bm.added_on,bm.contact_no,
            bm.status,bm.register_by,bm.country,bm.branch,'BM' AS user_type, bm.user_type AS user_type_val,
            bm.transfer_check,IFNULL(tu.id,'NA') AS transfer_id
        FROM business_mentor bm
        LEFT JOIN transfered_users tu
            ON tu.transfer_user_id = bm.business_mentor_id
            AND tu.transfer_status = 1
        WHERE bm.status IN ('0','2')
        OR (bm.status='1' AND bm.transfer_check='1' AND tu.id IS NOT NULL)
        UNION ALL
        SELECT 
            mf.id,mf.master_franchisee_id AS user_id_str,mf.firstname,mf.lastname,
            mf.reference_no,mf.registrant,mf.country_code,mf.email,mf.address,
            mf.state,mf.city,mf.zone,mf.date_of_birth,mf.added_on,mf.contact_no,
            mf.status,mf.register_by,mf.country,mf.branch,'MF' AS user_type,mf.user_type AS user_type_val,
            mf.transfer_check,IFNULL(tu.id,'NA') AS transfer_id
        FROM master_franchisee mf
        LEFT JOIN transfered_users tu
            ON tu.transfer_user_id = mf.master_franchisee_id
            AND tu.transfer_status = 1
        WHERE mf.status IN ('0','2')
        OR (mf.status='1' AND mf.transfer_check='1' AND tu.id IS NOT NULL)
        UNION ALL
        SELECT 
            sf.id,sf.sponsor_franchisee_id AS user_id_str,sf.firstname,sf.lastname,
            sf.reference_no,sf.registrant,sf.country_code,sf.email,sf.address,
            sf.state,sf.city,sf.zone,sf.date_of_birth,sf.added_on,sf.contact_no,
            sf.status,sf.register_by,sf.country,sf.branch,'SF' AS user_type,sf.user_type AS user_type_val,
            sf.transfer_check,IFNULL(tu.id,'NA') AS transfer_id
        FROM sponsor_franchisee sf
        LEFT JOIN transfered_users tu
            ON tu.transfer_user_id = sf.sponsor_franchisee_id
            AND tu.transfer_status = 1
        WHERE sf.status IN ('0','2')
        OR (sf.status='1' AND sf.transfer_check='1' AND tu.id IS NOT NULL)
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
                            <li><a href="#" onclick=\'editfuncCust("' . $row["id"] . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","' . $row["zone"] . '","' . $row["branch"] . '","pending","' . $row['user_type_val'] . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                            <li><a href="#" onclick=\'deletefunc("' . $row["id"] . '","","pending","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                            <li><a href="#" onclick=\'confirmfunc("' . $row["id"] . '","' . $row["email"] . '","' . strtolower($row['user_type']) . '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
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
                                    onclick=\'editfuncCust("' . $user_id_str . '","' . $row["reference_no"] . '","' . $row["register_by"] . '","' . $row["country"] . '","' . $row["state"] . '","' . $row["city"] . '","' . $row["zone"] . '","' . $row["branch"] . '","pending","' . strtolower($row['user_type']) . '")\'
                                     
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