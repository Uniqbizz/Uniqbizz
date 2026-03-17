<?php

    if($userType == '10'){
        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')   ";
    }else if($userType == '11'){
        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."' ";
    }else if($userType == '16'){
        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'   ";
    }else if($userType == '26'){
        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'   ";
    }else if($userType == '25' || $userType == '31'){
        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."'   ";
    }else if($userType == '24'){
        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'   ";
    }else if($userType == '29'){//Franchisee
        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'   ";
    }else if($userType == '28'){//Master Franchisee
        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'   ";
    }else if($userType == '30'){//Sponsor Franchisee
        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'   ";
    }else if($userType == '32'){//franchisee
        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'   ";
    }
    
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        foreach( ($stmt -> fetchALL()) as $key => $row ){
            // print_r($stmt);
            // print_r($row);
            // echo '</br>';
            // date in proper formate
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');
            
            //get package Name
            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
            $stmt1 -> execute();
            $pkgName = $stmt1 -> fetch();
            $packageName = $pkgName['name'];

            //get customer Name
            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
            $stmt8 -> execute();
            $cu_name = $stmt8 -> fetch();
            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
            
            $no_of_adult = $row['no_of_adult'] ;
            $no_of_child = $row['no_of_child'] ;

            //customer part remaining
            if($userType == '10'){
                $cu1 = $row['cu1_id'];
                $cu2 = $row['cu2_id'];
                $cu3 = $row['cu3_id'];
                if($cu1 == $userId){
                    $message = $row['cu1_mess']; 
                    $amt = $row['cu1_amt'];
                    $status = $row['cu1_status'];
                }else if($cu2 == $userId){
                    $message = $row['cu2_mess'];
                    $amt = $row['cu2_amt'];
                    $status = $row['cu2_status'];
                }else{
                    $message = $row['cu3_mess'];
                    $amt = $row['cu3_amt'];
                    $status = $row['cu3_status'];
                }
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '11'){
                $id = $row['ta_id'];
                $ta_markup = $row['ta_markup'];
                $message = $row['ta_mess'];
                $amt = $row['ta_amt'];
                $status = $row['ta_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '16'|| $userType == '29' || $userType == '32'){
                $id = $row['te_id'];
                $message = $row['te_mess'];
                $amt = $row['te_amt'];
                $status = $row['te_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '24'){
                $id = $row['bch_id'];
                $message = $row['bch_mess'];
                $amt = $row['bch_amt'];
                $status = $row['bch_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '25' || $userType == '31'){
                $id = $row['bdm_id'];
                $message = $row['bdm_mess'];
                $amt = $row['bdm_amt'];
                $status = $row['bdm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }else if($userType == '26'|| $userType == '28' || $userType=='30'){
                $id = $row['bm_id'];
                $message = $row['bm_mess'];
                $amt = $row['bm_amt'];
                $status = $row['bm_status'];
                $tds = $amt * $tdsPercentage;
                $total = $amt - $tds;
            }

            echo '<tr>
                    <td>'.$dt.'</td>';
                    if($userType == '11'){
                        echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                        <td >'.$ta_markup.'</td>';
                    }else{
                        echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                    }
                    echo'
                    <td >'.$amt.'</td>
                    <td >'.$tds.'</td>
                    <td >'.$total.'</td>';
                    if($status == '1'){
                        echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                    }else{
                        echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
                    }
            echo'</tr>';

        }
    }
?>