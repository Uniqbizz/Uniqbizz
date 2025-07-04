<?php  

    require '../../connect.php';

    $id = $_POST['id'];
    $DBtable = $_POST['DBtable'];
    $user_type = $_POST['user_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // // Create an output string with proper formatting
    // $output = '';
    // $output .= 'id = ' . $id . '<br>';
    // $output .= 'DBtable = ' . $DBtable . '<br>';
    // $output .= 'user_type = ' . $user_type . '<br>';
    // $output .= 'start_date = ' . $start_date . '<br>';
    // $output .= 'end_date = ' . $end_date . '<br>';
    // // Echo the output
    // echo $output;

    echo'<table class="table table-hover" id="payoutDetailsTable2">
        <thead>
            <tr>
                <th class="ceterText fw-semibold fs-6">Date</th>
                <th class="ceterText fw-semibold fs-6">Title</th>
                <th class="ceterText fw-semibold fs-6">Payout Details</th>
                <th class="ceterText fw-semibold fs-6">Amount</th>
                <th class="ceterText fw-semibold fs-6">TDS</th>
                <th class="ceterText fw-semibold fs-6">Total Payable</th>
                <th class="ceterText fw-semibold fs-6">Status</th>
            </tr>
        </thead >
        <tbody>';

    if($DBtable == 'employees'){
        if($user_type == 24){
            $sqlUnion ="SELECT 'BCM Payout' as title, bcm_user_id, message_bcm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bcm_payout_history` 
                    WHERE bcm_user_id = '".$id."' AND payout_date BETWEEN '".$start_date."' AND '".$end_date."'  UNION 

                    SELECT 'Product Payout' as title, bch_id, bch_mess as message, bch_amt as amount, created_date as date, bch_status as status FROM `product_payout`
                    WHERE bch_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
        }else if($user_type == 25) {
            $sqlUnion ="SELECT 'BDM Payout' as title, bdm_user_id, message_bdm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bdm_payout_history` 
                    WHERE bdm_user_id = '".$id."' AND payout_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'Product Payout' as title, bdm_id, bdm_mess as message, bdm_amt as amount, created_date as date, bdm_status as status FROM `product_payout`
                    WHERE bdm_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
        }      
    }else if($DBtable == 'business_mentor'){
        $sqlUnion ="SELECT 'BM Payout' as title, bm_user_id, message_bm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bm_payout_history` 
                    WHERE bm_user_id = '".$id."' AND payout_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'TC Payout' as title, business_consultant, message_bc as message, commision_bc as amount, created_date as date, status_bc as status FROM `ca_ta_payout` 
                    WHERE business_consultant = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'Product Payout' as title, bm_id, bm_mess as message, bm_amt as amount, created_date as date, bm_status as status FROM `product_payout`
                    WHERE bm_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
    }else if($DBtable == 'corporate_agency'){ // techno enterprise
        $sqlUnion ="SELECT 'TC Payout' as title, corporate_agency, message_ca as message, commision_ca as amount, created_date as date, status_ca as status FROM `ca_ta_payout` 
                    WHERE corporate_agency = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'CU Payout' as title, techno_enterprise, message_te as message, commision_te as amount, created_date as date, status_te as status FROM `ca_cu_payout` 
                    WHERE techno_enterprise = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'Product Payout' as title, te_id, te_mess as message, te_amt as amount, created_date as date, te_status as status FROM `product_payout`
                    WHERE te_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
    }else if($DBtable == 'ca_travelagency'){
        $sqlUnion ="SELECT 'CU Payout' as title, travel_consultant, message_tc as message, commision_tc as amount, created_date as date, status_tc as status FROM `ca_cu_payout` 
                    WHERE travel_consultant = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION 

                    SELECT 'Product Payout' as title, ta_id, ta_mess as message, ta_amt as amount, created_date as date, ta_status as status FROM `product_payout`
                    WHERE ta_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
    }else if($DBtable == 'ca_customer'){
        $sqlUnion ="SELECT 'Product Payout cu1 col' as title, cu1_id, cu1_mess as message, cu1_amt as amount, created_date as date, cu1_status as status FROM `product_payout`
                    WHERE cu1_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION
                    
                    SELECT 'Product Payout cu2 col' as title, cu2_id, cu2_mess as message, cu2_amt as amount, created_date as date, cu2_status as status FROM `product_payout`
                    WHERE cu2_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' UNION
                    
                    SELECT 'Product Payout cu3 col' as title, cu3_id, cu3_mess as message, cu3_amt as amount, created_date as date, cu3_status as status FROM `product_payout`
                    WHERE cu3_id = '".$id."' AND created_date BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY date DESC ";
    }

    if($sqlUnion){
        $stmtUnion = $conn-> prepare($sqlUnion);
        $stmtUnion -> execute();
        $stmtUnion -> setFetchMode(PDO::FETCH_ASSOC);
        if( $stmtUnion-> rowCount()>0 ){
            foreach( ($stmtUnion->fetchAll()) as $key => $row ){
                $cd= new DateTime($row['date']);
                $cdate= $cd->format('d-m-Y');

                // replace dot at end of the line with break statement
                $message = $row['message'];
                // $message1 =  str_replace('.','<br>',$message1); 
                
                $amount = $row['amount'] ;

                if($amount ==  'null'){
                    $tds = '0';
                    $total = '0';
                }else{
                    $tds = $amount * 2 / 100 ;
                    $total = $amount - $tds ;
                }
            
                $status = $row['status'];
                $title = $row['title'];
                echo'<tr>
                    <td>'.$cdate.'</td>
                    <td>'.$title.'</td>
                    <td style="width: 350px;">'.$message.'</td>
                    <td>'.$amount.'</td>
                    <td>'.$tds.'</td>
                    <td>
                        <span>'.$total.'</span>
                        <a href="">
                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                        </a>
                    </td>
                    <td>';
                        if($status == 1){
                            echo'<span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span>';
                        }else if($status == 2){
                            echo'<span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span>';
                        }else if($status == 3){
                            echo'<span class="badge badge-pill badge-soft-danger font-size-10 fw-bold ms-4">Rejected</span>';
                        }
                    echo'</td>
                </tr>';
            }
        }else{
            echo'<tr> <td colspan="7" class="text-center">No Data Found</td> </tr>';
        }
    }

?>