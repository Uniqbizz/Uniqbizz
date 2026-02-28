<div class="tab-pane fade card px-3 rounded-4" id="payout" role="tabpanel">
    <div class="row">
        <div class="d-flex justify-content-end">
            <div class="pt-3 pb-2 col-md-7">
                <h5>Payout</h5>
            </div>
            <div class="pt-3 pb-2 col-md-5">
                <div class="row d-flex justify-content-end">
                    <input type="text" id="rangeDate" name="daterange" value="" class="col-md-6 bg-secondary-subtle rounded-3 border-0" />
                    <div class="ms-3 col-md-3">
                        <a href="">
                            <button class="bg-success text-white border-0 rounded-3 fw-bold">Download</button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="table-responsive table-desi pb-2" id="filterTable">
        <!-- table roe limit -->
        <table class="table table-hover" id="payoutDetailsTable">
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
            </thead>
            <tbody id="payoutDetails">
                <!-- BCM payout = slab payout / employee payout , users = BCM -->
                <!-- BDM payout = slab payout / employee payout , users = BDM -->
                <!-- Product payout = Packages sold to customer , users = BCM-BDM-BM-TE-TA-CU -->
                <!-- TC payout = When Travel Consultant joins by paying 10k , users = BM-TE-TA -->
                <!-- CU payout = When Customer joins by paying 10k , users = TE-TA-CU -->
                <?php
                // if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') {
                //     if ($user_type == 24) {
                //         $sqlUnion = "SELECT 'BCM Payout' as title, bcm_user_id, message_bcm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bcm_payout_history` 
                //                         WHERE bcm_user_id = '" . $id . "' UNION 

                //                         SELECT 'Product Payout' as title, bch_id, bch_mess as message, bch_amt as amount, created_date as date, bch_status as status FROM `product_payout`
                //                         WHERE bch_id = '" . $id . "' ORDER BY date DESC ";
                //     } else if ($user_type == 25) {
                //         $sqlUnion = "SELECT 'BDM Payout' as title, bdm_user_id, message_bdm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bdm_payout_history` 
                //                         WHERE bdm_user_id = '" . $id . "' UNION 

                //                         SELECT 'Product Payout' as title, bdm_id, bdm_mess as message, bdm_amt as amount, created_date as date, bdm_status as status FROM `product_payout`
                //                         WHERE bdm_id = '" . $id . "' ORDER BY date DESC ";
                //     }
                // } else if ($DBtable == 'business_mentor') {
                //     $sqlUnion = "SELECT 'BM Payout' as title, bm_user_id, message_bm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bm_payout_history` 
                //                         WHERE bm_user_id = '" . $id . "' UNION 

                //                         SELECT 'TC Payout' as title, business_consultant, message_bc as message, commision_bc as amount, created_date as date, status_bc as status FROM `ca_ta_payout` 
                //                         WHERE business_consultant = '" . $id . "' UNION 
                

                //                         SELECT 'Product Payout' as title, bm_id, bm_mess as message, bm_amt as amount, created_date as date, bm_status as status FROM `product_payout`
                //                         WHERE bm_id = '" . $id . "' ORDER BY date DESC ";
                // } else if ($DBtable == 'corporate_agency') { // techno enterprise
                //     $sqlUnion = "SELECT 'TC Payout' as title, corporate_agency, message_ca as message, commision_ca as amount, created_date as date, status_ca as status FROM `ca_ta_payout` 
                //                         WHERE corporate_agency = '" . $id . "' UNION 

                //                         SELECT 'CU Payout' as title, techno_enterprise, message_te as message, commision_te as amount, created_date as date, status_te as status FROM `ca_cu_payout` 
                //                         WHERE techno_enterprise = '" . $id . "' UNION 
                

                //                         SELECT 'Product Payout' as title, te_id, te_mess as message, te_amt as amount, created_date as date, te_status as status FROM `product_payout`
                //                         WHERE te_id = '" . $id . "' ORDER BY date DESC ";
                // } else if ($DBtable == 'ca_travelagency') {
                //     $sqlUnion = "SELECT 'CU Payout' as title, travel_consultant, message_tc as message, commision_tc as amount, created_date as date, status_tc as status FROM `ca_cu_payout` 
                //                         WHERE travel_consultant = '" . $id . "' UNION 

                //                         SELECT 'Product Payout' as title, ta_id, ta_mess as message, ta_amt as amount, created_date as date, ta_status as status FROM `product_payout`
                //                         WHERE ta_id = '" . $id . "' ORDER BY date DESC ";
                // } else if ($DBtable == 'ca_customer') {
                //     $sqlUnion = "SELECT 'Product Payout cu1 col' as title, cu1_id, cu1_mess as message, cu1_amt as amount, created_date as date, cu1_status as status FROM `product_payout`
                //                         WHERE cu1_id = '" . $id . "' UNION
                                        
                //                         SELECT 'Product Payout cu2 col' as title, cu2_id, cu2_mess as message, cu2_amt as amount, created_date as date, cu2_status as status FROM `product_payout`
                //                         WHERE cu2_id = '" . $id . "' UNION
                                        
                //                         SELECT 'Product Payout cu3 col' as title, cu3_id, cu3_mess as message, cu3_amt as amount, created_date as date, cu3_status as status FROM `product_payout`
                //                         WHERE cu3_id = '" . $id . "'  ORDER BY date DESC ";
                // }
                //  if ($sqlUnion) {
                //     $stmtUnion = $conn->prepare($sqlUnion);
                //     $stmtUnion->execute();
                //     $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);
                //     if ($stmtUnion->rowCount() > 0) {
                //         foreach (($stmtUnion->fetchAll()) as $key => $row) {
                //             $cd = new DateTime($row['date']);
                //             $cdate = $cd->format('d-m-Y');

                //             // replace dot at end of the line with break statement
                //             $message = $row['message'];
                //             // $message1 =  str_replace('.','<br>',$message1); 

                //             $amount = $row['amount'];

                //             if ($amount ==  'null') {
                //                 $tds = '0';
                //                 $total = '0';
                //             } else {
                //                 $tds = $amount * 2 / 100;
                //                 $total = $amount - $tds;
                //             }

                //             $status = $row['status'];
                //             $title = $row['title'];
                //             echo '<tr>
                //                         <td>' . $cdate . '</td>
                //                         <td>' . $title . '</td>
                //                         <td style="width: 350px;">' . $message . '</td>
                //                         <td>' . $amount . '</td>
                //                         <td>' . $tds . '</td>
                //                         <td>
                //                             <span>' . $total . '</span>
                //                             <a href="">
                //                                 <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                //                             </a>
                //                         </td>
                //                         <td>';
                //             if ($status == 1) {
                //                 echo '<span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span>';
                //             } else if ($status == 2) {
                //                 echo '<span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span>';
                //             } else if ($status == 3) {
                //                 echo '<span class="badge badge-pill badge-soft-danger font-size-10 fw-bold ms-4">Rejected</span>';
                //             }
                //             echo '</td>
                //                     </tr>
                //                     ';
                //         }
                //     }
                // }
                ?>
            </tbody>
        </table>
    </div>
    
</div>