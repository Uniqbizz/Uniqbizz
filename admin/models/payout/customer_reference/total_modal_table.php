<?php

    $sql = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM `customer_reference_payout` WHERE status = '1'
            order by created_date desc ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        foreach( ($stmt -> fetchALL()) as $key => $row ){

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['message1']?$row['message1']:$row['message2'];
            $message1 =  str_replace('.','<br>',$message1);  

            // replace dot at end of the line with break statement
            $message2 = $row['message_details']??'NA';
            $message2 =  str_replace('.','<br>',$message2);  

            // total Amt Cal for BC 
            if(!$row['comm_amt1']){
                $CommAmt = $row['comm_amt2'];
                $tds = "NA";
                $totalAmt = $CommAmt;
            }else{
                $CommAmt = $row['comm_amt1'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }
            
            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message1.'</td>
                    <td>'.$message2.'</td>
                    <td class="text-end">'.$CommAmt.'</td>
                    <td class="text-end">'.$tds.'</td>
                    <td class="text-end">'.$totalAmt;
                    if ($row['status'] !='3') {
                        echo'
                            <a href="../../controllers/payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$CommAmt.'">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                    </td>';
                    }
                    if($row['status'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else if($row['status'] == '3'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","'.$row['userId'].'","'.$message1.'","'.$CommAmt.'","'.$row['status'].'"\'>Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>