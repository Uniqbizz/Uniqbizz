<?php
// get detailes of users to show month wise in table(below chart)
    require '../../connect.php';     

    $get_month_year = $_POST['month_year'];
    $start_from = $_POST['startfrom'];
    $limitCount = $_POST['limitCount'];
    $userId = $_POST['userId'];
    $orderByColumn = $_POST['column_name'] ?? 'id';
    $orderByType = $_POST['order_by'] ?? 'ASC';

    $year = substr($get_month_year,0,4);
    $month = substr($get_month_year,5,7);
    $userType = $_POST['userType'];
    $reference_no_check ="";
    $reference_name="";
    $user_id="";
    $user_name="";
    $user_reference="";
    $joining_date="";
    $jdate="";
    $sql="";
    function getCustomerRow( $level, $row,  $ref_name ) {
        echo '<tr class="user_row">
            <td>Level '.$level.'</td>
            <td>'.$row['cust_id'].'</td>
            <td>'.strtok($row['firstname'],' ').' '.$row['lastname'].'</td>
            <td>'.$ref_name.'</td>
            <td>'.date("d-m-Y", strtotime($row['register_date'])).'</td>
        </tr>';
    }
    
    //for dashboard 
    if($userType=='referral_2'){
        $stmt1 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                        where reference_no='".$userId."' AND status='1' ");
        $stmt1->execute();
        $stmt1->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt1->rowCount()>0){
            foreach ($stmt1->fetchAll() as $key => $row1) {
                $sql1 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row1['reference_no']."'  AND status='1' ");
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    $ref_row1 = $sql1->fetch();
                    $reference_level1 = $ref_row1['firstname']. ' ' . $ref_row1['lastname'];
                }
                if($row1['currentMonth']==$month && $row1['currentYear']==$year){
                    getCustomerRow( '1', $row1,  $reference_level1 );
                }
                
                //fetch level 2 data
                $stmt5 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                        where reference_no='".$row1['cust_id']."' AND status='1' ");
                $stmt5->execute();
                $stmt5->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt5->rowCount()>0){
                    foreach (($stmt5->fetchAll()) as $key => $row2) {
                        $sql2 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row2['reference_no']."'  AND status='1' ");
                        $sql2->execute();
                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql2->rowCount()>0){
                            $ref_row2 = $sql2->fetch();
                            $reference_level2 = $ref_row2['firstname']. ' ' . $ref_row2['lastname'];
                        }
                        if($row2['currentMonth']==$month && $row2['currentYear']==$year){
                            getCustomerRow( '2', $row2,  $reference_level2 );
                        }
                        
                        //fetch level 3 data
                        $stmt6 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                where reference_no='".$row2['cust_id']."' AND status='1' ");
                        $stmt6->execute();
                        $stmt6->setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt6->rowCount()>0){
                            foreach (($stmt6->fetchAll()) as $key => $row3) {
                                $sql3 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row3['reference_no']."'  AND status='1' ");
                                $sql3->execute();
                                $sql3->setFetchMode(PDO::FETCH_ASSOC);
                                if($sql3->rowCount()>0){
                                    $ref_row3 = $sql3->fetch();
                                    $reference_level3 = $ref_row3['firstname']. ' ' . $ref_row3['lastname'];
                                }
                                if($row3['currentMonth']==$month && $row3['currentYear']==$year){
                                    getCustomerRow( '3', $row3,  $reference_level3 );
                                }
                                
                                //fetch level 4 data
                                $stmt7 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                        where reference_no='".$row3['cust_id']."' AND status='1' ");
                                $stmt7->execute();
                                $stmt7->setFetchMode(PDO::FETCH_ASSOC);
                                if($stmt7->rowCount()>0){
                                    foreach (($stmt7->fetchAll()) as $key => $row4) {
                                        $sql4 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row4['reference_no']."'  AND status='1' ");
                                        $sql4->execute();
                                        $sql4->setFetchMode(PDO::FETCH_ASSOC);
                                        if($sql4->rowCount()>0){
                                            $ref_row4 = $sql4->fetch();
                                            $reference_level4 = $ref_row4['firstname']. ' ' . $ref_row4['lastname'];
                                        }
                                        if($row4['currentMonth']==$month && $row4['currentYear']==$year){
                                            getCustomerRow( '4', $row4,  $reference_level4 );
                                        }
                                        
                                        //fetch level 5 data
                                        $stmt8 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                                 where reference_no='".$row4['cust_id']."' AND status='1' ");
                                        $stmt8->execute();
                                        $stmt8->setFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt8->rowCount()>0){
                                            foreach (($stmt8->fetchAll()) as $key => $row5) {
                                                $sql5 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row5['reference_no']."'  AND status='1' ");
                                                $sql5->execute();
                                                $sql5->setFetchMode(PDO::FETCH_ASSOC);
                                                if($sql5->rowCount()>0){
                                                    $ref_row5 = $sql5->fetch();
                                                    $reference_level5 = $ref_row5['firstname']. ' ' . $ref_row5['lastname'];
                                                }
                                                if($row5['currentMonth']==$month && $row5['currentYear']==$year){
                                                    getCustomerRow( '5', $row5, $reference_level5 );
                                                }
                                                
                                                //fetch level 6 data
                                                $stmt9 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                                         where reference_no='".$row5['cust_id']."' AND status='1' ");
                                                $stmt9->execute();
                                                $stmt9->setFetchMode(PDO::FETCH_ASSOC);
                                                if($stmt9->rowCount()>0){
                                                    foreach (($stmt9->fetchAll()) as $key => $row6) {
                                                        $sql6 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row6['reference_no']."'  AND status='1' ");
                                                        $sql6->execute();
                                                        $sql6->setFetchMode(PDO::FETCH_ASSOC);
                                                        if($sql6->rowCount()>0){
                                                            $ref_row6 = $sql6->fetch();
                                                            $reference_level6 = $ref_row6['firstname']. ' ' . $ref_row6['lastname'];
                                                        }
                                                        if($row6['currentMonth']==$month && $row6['currentYear']==$year){
                                                            getCustomerRow( '6', $row6,  $reference_level6 );
                                                        }
                                                        
                                                    }
                                                } //else {    echo 'no_users';    }
                                            }
                                        } //else {    echo 'no_users';    }
                                    }
                                }//else {    echo 'no_users';    }
                            }
                        } //else {    echo 'no_users';    }
                    }
                } //else {    echo 'no_users';    }
            }
        }else {
            echo '<tr class="user_row"><td class="ceterText" colspan="4">No Reference Customer</td></tr>';
        }
    }else if($userType=='referral_3'){
        $sql = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                        where reference_no='".$userId."'  AND status='1' ORDER BY register_date ASC");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount()>0){
            foreach ($sql->fetchAll() as $key => $row1) {
                // get referrence name
                $sql11 = $conn->prepare("SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id='".$row1['reference_no']."'  AND status='1' ");
                $sql11->execute();
                $sql11->setFetchMode(PDO::FETCH_ASSOC);
                if($sql11->rowCount()>0){
                    $rowreff = $sql11->fetch();
                    $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                }
                if($row1['currentMonth']==$month && $row1['currentYear']==$year){
                    getCustomerRow( '1', $row1, $reference_name);
                }
                
                //fetch level 2 data
                $stmt5 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                        where reference_no='".$row1['cust_id']."' AND status='1' ");
                $stmt5->execute();
                $stmt5->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt5->rowCount()>0){
                    foreach (($stmt5->fetchAll()) as $key => $row2) {
                        // get referrence name
                        $sql12 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row2['reference_no']."'  AND status='1' ");
                        $sql12->execute();
                        $sql12->setFetchMode(PDO::FETCH_ASSOC);
                        if($sql12->rowCount()>0){
                            $rowreff = $sql12->fetch();
                            $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                        }
                        if($row2['currentMonth']==$month && $row2['currentYear']==$year){
                            getCustomerRow( '2', $row2, $reference_name);
                        }
                        //fetch level 3 data
                        $stmt6 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                where reference_no='".$row2['cust_id']."' AND status='1' ");
                        $stmt6->execute();
                        $stmt6->setFetchMode(PDO::FETCH_ASSOC);
                        if($stmt6->rowCount()>0){
                            foreach (($stmt6->fetchAll()) as $key => $row3) {
                                // get referrence name
                                $sql13 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row3['reference_no']."'  AND status='1' ");
                                $sql13->execute();
                                $sql13->setFetchMode(PDO::FETCH_ASSOC);
                                if($sql13->rowCount()>0){
                                    $rowreff = $sql13->fetch();
                                    $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                                }
                                if($row3['currentMonth']==$month && $row3['currentYear']==$year){
                                    getCustomerRow( '3', $row3, $reference_name);
                                }
                                //fetch level 4 data
                                $stmt7 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                        where reference_no='".$row3['cust_id']."' AND status='1' ");
                                $stmt7->execute();
                                $stmt7->setFetchMode(PDO::FETCH_ASSOC);
                                if($stmt7->rowCount()>0){
                                    foreach (($stmt7->fetchAll()) as $key => $row4) {
                                        // get referrence name
                                        $sql14 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row4['reference_no']."'  AND status='1' ");
                                        $sql14->execute();
                                        $sql14->setFetchMode(PDO::FETCH_ASSOC);
                                        if($sql14->rowCount()>0){
                                            $rowreff = $sql14->fetch();
                                            $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                                        }
                                        if($row4['currentMonth']==$month && $row4['currentYear']==$year){
                                            getCustomerRow( '4', $row4, $reference_name);
                                        }
                                        //fetch level 5 data
                                        $stmt8 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                                 where reference_no='".$row4['cust_id']."' AND status='1' ");
                                        $stmt8->execute();
                                        $stmt8->setFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt8->rowCount()>0){
                                            foreach (($stmt8->fetchAll()) as $key => $row5) {
                                                // get referrence name
                                                $sql15 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row5['reference_no']."'  AND status='1' ");
                                                $sql15->execute();
                                                $sql15->setFetchMode(PDO::FETCH_ASSOC);
                                                if($sql15->rowCount()>0){
                                                    $rowreff = $sql15->fetch();
                                                    $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                                                }
                                                if($row5['currentMonth']==$month && $row5['currentYear']==$year){
                                                    getCustomerRow( '5', $row5, $reference_name);
                                                }
                                                //fetch level 6 data
                                                $stmt9 = $conn->prepare("SELECT *,MONTH(register_date) as currentMonth ,YEAR(register_date) as currentYear FROM customer 
                                                                         where reference_no='".$row5['cust_id']."' AND status='1' ");
                                                $stmt9->execute();
                                                $stmt9->setFetchMode(PDO::FETCH_ASSOC);
                                                if($stmt9->rowCount()>0){
                                                    foreach (($stmt9->fetchAll()) as $key => $row6) {
                                                        // get referrence name
                                                        $sql16 = $conn->prepare("SELECT firstname, lastname FROM customer WHERE cust_id='".$row6['reference_no']."'  AND status='1' ");
                                                        $sql16->execute();
                                                        $sql16->setFetchMode(PDO::FETCH_ASSOC);
                                                        if($sql16->rowCount()>0){
                                                            $rowreff = $sql16->fetch();
                                                            $reference_name = $rowreff['firstname']. ' ' . $rowreff['lastname'];
                                                        }
                                                        if($row6['currentMonth']==$month && $row6['currentYear']==$year){
                                                            getCustomerRow( '6', $row6, $reference_name);
                                                        }
                                                        
                                                    }
                                                } //else {    echo 'no_users';    }
                                            }
                                        } //else {    echo 'no_users';    }
                                    }
                                }//else {    echo 'no_users';    }
                            }
                        } //else {    echo 'no_users';    }
                    }
                } //else {    echo 'no_users';    }
            }
        }else {
            echo '<tr class="user_row"><td class="ceterText" colspan="4">No User Found</td></tr>';
        }
    }else{
         // *****************admin********************
        // for admin
        if($userType=='customer'){
            $sql = "SELECT cust_id as user_id, firstname, lastname, reference_no, register_date FROM customer 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' 
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='consultant'){
            $sql = "SELECT business_consultant_id as user_id, firstname, lastname, reference_no, register_date FROM business_consultant 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='partner'){
            $sql = "SELECT franchisee_id as user_id, firstname, lastname, reference_no, register_date FROM franchisee 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='corporate_partner'){
            $sql = "SELECT super_franchisee_id as user_id, firstname, lastname, reference_no, register_date FROM super_franchisee 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='business_trainee'){
            $sql = "SELECT business_trainee_id as user_id, firstname, lastname, reference_no, register_date FROM business_trainee 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='corporate_agency'){
            $sql = "SELECT corporate_agency_id as user_id, firstname, lastname, reference_no, register_date FROM corporate_agency 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='ca_travelagency'){
            $sql = "SELECT ca_travelagency_id as user_id, firstname, lastname, reference_no, register_date FROM ca_travelagency 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='ca_customer'){
            $sql = "SELECT ca_customer_id as user_id, firstname, lastname, reference_no, ta_reference_no, register_date FROM ca_customer 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }else if($userType=='cbd'){
            $sql = "SELECT channel_business_director_id as user_id, firstname, lastname, reference_no, register_date FROM channel_business_director 
                                            WHERE MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1'
                                            ORDER BY ".$orderByColumn." ".$orderByType." LIMIT ".$start_from.",".$limitCount;
        }
        $sql = $conn->prepare($sql);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        if($sql->rowCount()>0){
            foreach ($sql->fetchAll() as $key => $row) {
                $user_id = $row['user_id'];
                $user_name = $row['firstname'].' '.$row['lastname'];

                if($userType=='ca_customer'){
                    $user_reference1 = $row['reference_no'];
                    $user_reference2 = $row['ta_reference_no'];
                    if($user_reference1){
                        $user_reference = $user_reference1;
                    }else{
                        $user_reference = $user_reference2;
                    }

                }else{
                    $user_reference = $row['reference_no'];
                }
                
                $joining_date = new DateTime($row['register_date']);
                $jdate = $joining_date->format('d-m-Y');
                
                if($userType=='customer'){
                    // triming first 2 letters of reference id to check if referral is consultant or customer
                    $reference_no_check = substr($user_reference,0,2);
                    if($reference_no_check == "TA"){
                        $sql1 = "SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id='".$user_reference."'  AND status='1' ";
                    }else{
                        $sql1 = "SELECT firstname, lastname FROM customer WHERE cust_id='".$user_reference."'  AND status='1' ";
                    }
                }else if($userType=='consultant'){
                    // triming first 2 letters of reference id to check if referral is sales manager(TA) or cbd
                    $reference_no_check = substr($user_reference,0,2);
                    if($reference_no_check =='CB'){
                        $sql1 = "SELECT firstname, lastname FROM channel_business_director WHERE channel_business_director_id='".$user_reference."'  AND status='1' ";
                    }else{
                        $sql1 = "SELECT firstname, lastname FROM sales_manager WHERE sales_manager_id='".$user_reference."'  AND status='1' ";
                    }
                }else if($userType=='partner'){
                    $sql1 = "SELECT firstname, lastname FROM sales_manager WHERE sales_manager_id='".$user_reference."'  AND status='1' ";
                }else if($userType=='corporate_partner'){
                    // triming first 2 letters of reference id to check if referral is consultant(TA) or Business Trainee
                    $reference_no_check = substr($user_reference,0,2);
                    if($reference_no_check == "TA"){
                        $sql1 = "SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id='".$user_reference."'  AND status='1' ";
                    }else{
                        $sql1 = "SELECT firstname, lastname FROM business_trainee WHERE business_trainee_id='".$user_reference."'  AND status='1' ";
                    }
                }else if($userType=='business_trainee'){
                    $sql1 = "SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id='".$user_reference."'  AND status='1' ";
                }else if($userType=='corporate_agency'){
                    $sql1 = "SELECT firstname, lastname FROM business_consultant WHERE business_consultant_id='".$user_reference."'  AND status='1' ";
                }else if($userType=='ca_travelagency'){
                    $sql1 = "SELECT firstname, lastname FROM corporate_agency WHERE corporate_agency_id='".$user_reference."'  AND status='1' ";
                }else if($userType=='ca_customer'){
                    $sql1 = "SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id='".$user_reference."'  AND status='1' ";
                    // triming first 2 letters of reference id to check if referral is caTA(TA) or Customer
                    // $reference_no_check = substr($user_reference,0,2);
                    // if($reference_no_check == "TA"){
                    //     $sql1 = "SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id='".$user_reference."'  AND status='1' ";
                    // }else{
                    //     $sql1 = "SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id='".$user_reference."'  AND status='1' ";
                    // }
                }else if($userType=='cbd'){
                    $sql1 = "SELECT firstname, lastname FROM admin WHERE admin_id = '".$user_reference."' AND status='1' ";
                }
                $sql1 = $conn->prepare($sql1);
                $sql1->execute();
                $sql1->setFetchMode(PDO::FETCH_ASSOC);
                if($sql1->rowCount()>0){
                    foreach ($sql1->fetchAll() as $key => $row) {
                        $reference_name = $row['firstname'].' '. $row['lastname'];

                        echo '<tr class="user_row">
                            <td class="ceterText">'.$user_id.'</td>
                            <td class="ceterText">'.$user_name .'</td>
                            <td class="ceterText">'.$reference_name.'</td>
                            <td class="ceterText">'.$jdate.'</td>
                        </tr>';
                    }
                }
            }
        } else {
            echo '<tr class="user_row"><td class="ceterText" colspan="4">No User Found</td></tr>';
        }
    }

    





   

?>