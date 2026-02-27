<?php
    $sql = "SELECT * FROM `ca_ta_payout`  ORDER BY `ca_ta_payout`.`id` DESC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        foreach( ($stmt -> fetchALL()) as $key => $row ){

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message_bm'];
            $message1 =  str_replace('.','<br>',$message1); 

            // replace dot at end of the line with break statement
            $message2 = $row['message_te'];
            $message2 =  str_replace('.','<br>',$message2);  

            // total Amt Cal for Bm
            $bm_id = $row['business_mentor'];
            $CommAmtBc = $row['commision_bm'] ? $row['commision_bm'] : 0;
            $tdsBc = $CommAmtBc * $tdsPer;
            $totalAmtBc = $CommAmtBc - $tdsBc;

            // total Amt Cal for te
            $te_id = $row['techno_enterprise'];
            $CommAmtCa = $row['commision_te'] ? $row['commision_te'] : 0;
            $tdsCa = $CommAmtCa * $tdsPer;
            $totalAmtCa = $CommAmtCa - $tdsCa;

            if($bm_id){
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
            }

            if($te_id){
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
    }
?>