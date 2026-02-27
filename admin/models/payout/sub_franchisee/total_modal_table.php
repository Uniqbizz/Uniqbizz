<?php
                                                    
    $sql="SELECT * FROM sub_franchisee_payout_paid  order by created_date desc";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        foreach( ($stmt -> fetchALL()) as $key => $row ){

            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // replace dot at end of the line with break statement
            $message1 = $row['payout_message'];
            $message1 =  str_replace('.','<br>',$message1);  

            $user_desig = "NA";
            //to get the prefix charater before first -
            preg_match('/^(.*?)\s*-\s*/', $message1, $match);

            if (!empty($match[1])) {
                $user_desig = trim($match[1]); // Output only the text before the first dash
            } 
            ///-------

            // replace dot at end of the line with break statement
            $message2 = $row['payout_details'];
            $message2 =  str_replace('.','<br>',$message2);  

            
            
            echo '<tr>
                    <td>'.$dt.'</td>
                    <td>'.$message1.'</td>
                    <td>'.$message2.'</td>
                    <td>'.$row['amount'].'</td>
                    <td>'.$row['tds'].'</td>
                    <td>'.$row['total_payable'].'
                        <a href="../../controllers/payout/forms/sub_franchisee/download_ca_payout.php?
                            vkvbvjfgfikix='.urlencode($row['id']).'
                            &userId='.urlencode($row['user_id']).'
                            &te='.urlencode($row['sub_franchisee']).'
                            &date='.urlencode($dt).'
                            &message='.urlencode($message1).'
                            &message_status='.urlencode($row['status']).'
                            &commission='.urlencode($row['amount']).'">
                            <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                        </a>
                    </td>';
                    if($row['status'] == '1'){
                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>