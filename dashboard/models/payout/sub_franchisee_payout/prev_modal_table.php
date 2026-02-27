<?php

    if($userType == '28'||$userType == '30'){
        $sql = "SELECT * FROM `sub_franchisee_payout` WHERE  master_franchisee = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
    }
    
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        foreach( ($stmt -> fetchALL()) as $key => $row ){
            
            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');
            
            if($userType == '28' || $userType=='30'){
                $id = $row['master_franchisee'];
                $message = $row['message_mf'];
                $amt = $row['commision_mf'];
                $status = $row['status_mf'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }

            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message.'</td>
                    <td >'.$amt.'</td>
                    <td >'.$tds.'</td>
                    <td >'.$total.'
                    <a href="../controllers/payout/forms/sub_franchisee_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$id.'&ca='.$row['sub_franchisee'].'&designation='.$columnDesignation.'&date='.$dt.'&message='.$message.'&message_status='.$status.'&commission='.$amt.'">
                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                    </a>
                    </td>';
                    if($status == '1'){
                        echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>