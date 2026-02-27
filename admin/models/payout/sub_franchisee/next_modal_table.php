<?php

    $sql = "(SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, sub_franchisee, created_date, status_zm as status FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."')
            UNION ALL
            (SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, sub_franchisee, created_date, status_mf as status FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."')
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

            $user_desig = "NA";
            //to get the prefix charater before first -
            preg_match('/^(.*?)\s*-\s*/', $message1, $match);

            if (!empty($match[1])) {
                $user_desig = trim($match[1]); // Output only the text before the first dash
            } 
            ///-------

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
                        <a href="../../controllers/payout/forms/sub_franchisee/download_ca_payout.php?
                            vkvbvjfgfikix='.urlencode($row['id']).'
                            &userId='.urlencode($row['userId']).'
                            &te='.urlencode($row['sub_franchisee']).'
                            &date='.urlencode($dt).'
                            &message='.urlencode($message1).'
                            &message_status='.urlencode($row['status']).'
                            &commission='.urlencode($row['comm_amt']).'">
                            <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                        </a>
                    </td>';
                    if($row['status'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                            data-bs-toggle="modal" 
                            data-bs-target=".bs-example-modal-center" 
                            onclick=\'paymentId('
                            . json_encode($row['id']) . ','
                            . json_encode($row['userId']) . ','
                            . json_encode($row['sub_franchisee']) . ','
                            . json_encode($message1) . ','
                            . json_encode($row['comm_amt']) . ','
                            . json_encode($row['status']) . ','
                            . json_encode($user_desig) . ')\'>' 
                            . 'Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>