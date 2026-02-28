<div class="tab-pane fade card px-3 rounded-4" id="s_p" role="tabpanel">
    <div class="row">
        <div class="d-flex justify-content-start">
            <div class="pt-3 pb-2 col-md-6">
                <h5>Upgarde History</h5>
            </div>
            <?php
                $sql101= "SELECT old_investment_amt,new_investment_amt,upgrade_amt as upgrade_amt  FROM sub_franchisee_upgrade
                                    WHERE sub_franchisee_id='".$id."' and upgrade_status=1
                                    ORDER BY upgrade_approval_date DESC limit 1";
                $stmt101 = $conn->prepare($sql101);
                // print_r($stmt101);
                $stmt101->execute();
                $stmt101->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt101->rowCount() > 0) {
                        foreach (($stmt101->fetchAll()) as $key => $row) {
                        $tamount = $row['upgrade_amt'];
                        }
                }else{
                    $tamount = $initial_inv;
                }
            ?>
            <div class="pt-3 pb-2 col-md-6">
                <div class="row justify-content-end">
                    <div class="col-md-6 d-flex gap-2">
                        <span class="fw-semibold">Total Investment:</span>
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <?= htmlspecialchars($tamount, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="table-responsive table-desi pb-2" id="filterTable1">
        <!-- table roe limit -->
        <table class="table table-hover" id="upgardeHistoryTable">
            <thead>
                <tr>
                    <th class="ceterText fw-semibold fs-6">Investment Date</th>
                    <th class="ceterText fw-semibold fs-6">Invested Amount</th>
                    <th class="ceterText fw-semibold fs-6">Commission Percentage</th>
                    <th class="ceterText fw-semibold fs-6">Incentive Percentage</th>
                    <th class="ceterText fw-semibold fs-6">Payment mode</th>
                    <th class="ceterText fw-semibold fs-6">Note</th>
                    <th class="ceterText fw-semibold fs-6">Approved date</th>
                    <th class="ceterText fw-semibold fs-6">Remark</th>
                    <th class="ceterText fw-semibold fs-6">Status</th>
                    <th class="ceterText fw-semibold fs-6">Action</th>
                </tr>
            </thead>
            <tbody id="upgardeHistory">
                <?php
                
                $sqlUnion = "SELECT id,new_investment_amt,upgrade_amt,upgrade_request_date,upgrade_approval_date,new_commission_per,new_incentive_per,
                                    payment_mode,cheque_no,cheque_date,bank_name,transaction_no,payment_proof,rejection_reason,
                                    approved_by,note,upgrade_status 
                                    FROM sub_franchisee_upgrade
                                    WHERE sub_franchisee_id='".$id."'
                                    ORDER BY upgrade_request_date ASC ";
                $stmtUnion = $conn->prepare($sqlUnion);
                $stmtUnion->execute();
                $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmtUnion->rowCount() > 0) {
                    foreach (($stmtUnion->fetchAll()) as $key => $row) {
                        $ud = new DateTime($row['upgrade_request_date']);
                        $udate = $ud->format('d-m-Y');
                        $ad = new DateTime($row['upgrade_approval_date']);
                        $adate = $ad->format('d-m-Y');

                        $tamount = $row['upgrade_amt'];
                        $amount = $row['new_investment_amt'];
                        $comm = $row['new_commission_per'];
                        $inc = $row['new_incentive_per'];
                        $pay_mode = $row['payment_mode'];
                        $aproved_by = $row['approved_by'];
                        $note = $row['note'];
                        $row_id=$row['id'];
                        $rejection_reason = trim($row['rejection_reason'] ?? '');

                        if ($rejection_reason === '') {
                            $rejection_reason = 'NA';
                        }
                        $status = $row['upgrade_status'];
                        echo '<tr>
                                    <td>' . $udate . '</td>
                                    <td>' . $amount . '</td>
                                    <td>' . $comm . '</td>
                                    <td>' . $inc . '</td>
                                    <td>' . $pay_mode . '</td>
                                    <td style="width: 350px;">' . $note . '</td>
                                    <td>' . $adate . '</td>
                                    <td>' . $rejection_reason . '</td>
                                    <td>';
                        if ($status == 0) {
                            echo '<span class="badge badge-pill badge-soft-info font-size-10 fw-bold ms-4">Requested</span>';
                        }
                        if ($status == 1) {
                            echo '<span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Approved</span>';
                        }
                        if ($status == 2) {
                            echo '<span class="badge badge-pill badge-soft-danger font-size-10 fw-bold ms-4">Rejected</span>';
                        }
                        echo '  </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" onclick=\'upgradeHistoryPage("' . $row_id . '","' .$id. '")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i>View Details</a></li>
                                            <li><a href="#" onclick=\'upgradePage("' . $id . '","' .$reference_no. '")\'  class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-arrow-up-bold text-success me-1"></i> Upgrade Franchisee</a></li>
                                        </ul>
                                    </div>
                                </td>
                                </tr>
                                ';
                    }
                }
                
                ?>
            </tbody>
        </table>
    </div>
    
</div>