<?php
        $sql = "SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.business_mentor,
                    ca.message_bm,
                    ca.commision_bm,
                    ca.status_bm,
                    ca.techno_enterprise,
                    ca.message_te,
                    ca.commision_te,
                    ca.status_te,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_ta_payout ca
                LEFT JOIN ca_ta_payout_paid cap 
                    ON cap.$columnDesignation = ca.$columnDesignation
                    AND cap.techno_enterprise = ca.techno_enterprise
                WHERE ca.$columnDesignation = '".$userId."' ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if( $stmt -> rowCount()>0 ){
            foreach( ($stmt -> fetchALL()) as $key => $row ){

                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row[$columnMessage];
                $message1 =  str_replace('.','<br>',$message1);  

                // total Amt Cal for BC 
                $CommAmt = $row[$columnCommision];
                $tds = $CommAmt * $tdsPercentage;
                $totalAmt = $CommAmt - $tds;

                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="../controllers/payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$row[$columnDesignation].'&date='.$dt.'&message='.$message1.'&message_status='.$row[$columnStatus].'&commission='.$row[$columnCommision].'">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                        </td>';
                        if($row[$columnStatus] == '1'){
                            echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
                        }
                echo'</tr>';

            }
        }
    ?>