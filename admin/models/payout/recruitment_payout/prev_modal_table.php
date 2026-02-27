<?php
    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
    $stmt2 = $conn -> prepare($stmt2);
    $stmt2 -> execute();
    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        foreach($stmt2->fetchAll() as $key2 => $row){
            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message_bm'];
            $message1 =  str_replace('.','<br>',$message1); 

            // replace dot at end of the line with break statement
            $message2 = $row['message_te'];
            $message2 =  str_replace('.','<br>',$message2);  

            // total Amt Cal for BC 
            $CommAmtBc = $row['commision_bm'] ? $row['commision_bm'] : 0;
            $tdsBc = $CommAmtBc * 5/100;
            $totalAmtBc = $CommAmtBc - $tdsBc;

            // total Amt Cal for CA
            $CommAmtCa = $row['commision_te'] ? $row['commision_te'] : 0;
            $tdsCa = $CommAmtCa * 5/100;
            $totalAmtCa = $CommAmtCa - $tdsCa;

            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message1.'</td>
                    <td class="text-end">'.$CommAmtBc.'</td>
                    <td class="text-end">'.$tdsBc.'</td>
                    <td class="text-end">'.$totalAmtBc.'
                        <a href="../../controllers/payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bm'].'&commission='.$row['commision_bm'].'">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                        </a>
                    </td>';
                    if($row['status_bm'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row['business_mentor']. '","'.$row["message_bm"]. '","'.$CommAmtBc. '","'.$row["status_bm"].'","messageBC")\'>Pending</span></td>';
                    }
            echo'</tr>';

            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message2.'</td>
                    <td class="text-end">'.$CommAmtCa.'</td>
                    <td class="text-end">'.$tdsCa.'</td>
                    <td class="text-end">'.$totalAmtCa.'
                        <a href="../../controllers/payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_te'].'&commission='.$row['commision_te'].'">
                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                        </a>
                    </td>';
                    if($row['status_te'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["techno_enterprise"]. '","'.$row["message_te"]. '","'.$CommAmtCa. '","'.$row["status_te"].'","messageCA")\'>Pending</span></td>';
                    }
            echo'</tr>';
        }
    }
?>