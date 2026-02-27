<?php
    $stmt2 = "SELECT * FROM ca_ta_payout_paid WHERE status = '1' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        foreach($stmt2->fetchAll() as $key2 => $row){
            // date in proper formate
            $dt = new DateTime($row['date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['payout_message'];
            $message1 =  str_replace('.','<br>',$message1); 

            // replace dot at end of the line with break statement
            $message2 = $row['payout_details'];
            $message2 =  str_replace('.','<br>',$message2);  

            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message1.'</td>
                    <td>'.$message2.'</td>
                    <td class="text-end">'.$row['amount'].'</td>
                    <td class="text-end">'.$row['tds'].'</td>
                    <td class="text-end">'.$row['total_payable'].'
                        <a href="../../controllers/payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_te'].'&commission='.$row['commision_te'].'">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                        </a>
                    </td>';
                    if($row['status'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" >Pending</span></td>';
                    }
            echo '</tr>';
        }
    }
?>