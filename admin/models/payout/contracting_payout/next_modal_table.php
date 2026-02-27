<?php

    $sql = "SELECT id, bdm_id as userId, message,  comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' UNION ALL
            SELECT id, bm_id as userId, message,  comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' UNION ALL
            SELECT id, business_mentor as userId, message,  comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' UNION ALL
            SELECT id, bm_user_id as userId, message_bm as message, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$nextDateYear."' AND MONTH(payout_date) = '".$nextDateMonth."'
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
            $message1 = $row['message'];
            $message1 =  str_replace('.','<br>',$message1);  

            // total Amt Cal for BC 
            if($row['comm_amt'] == "null"){
                $CommAmt = "null";
                $tds = "null";
                $totalAmt = "null";
            }else{
                $CommAmt = $row['comm_amt'];
                $tds = $CommAmt * $tdsPer;
                $totalAmt = $CommAmt - $tds;
            }
            
            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message1.'</td>
                    <td class="text-end">'.$CommAmt.'</td>
                    <td class="text-end">'.$tds.'</td>
                    <td class="text-end">'.$totalAmt.'
                        <a href="../../controllers/payout/forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['techno_enterprise'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                        </a>
                    </td>';
                    if($row['status'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","'.$row['userId'].'","'.$message1.'","'.$row['comm_amt'].'","'.$row['status'].'","'.$row['identity'].'")\'>Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>