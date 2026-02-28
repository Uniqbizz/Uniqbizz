<div class="tab-pane fade show" id="Coupon" role="tabpanel">
    <div class="card rounded-4">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <?php
                        require '../../connect.php';
                        $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([':fid' => $id]);
                        $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if(count($coupons) > 0){   
                    ?>
                    <div class="pt-3 pb-2 col-md-7">
                        <h5>Available Coupons</h5>
                    </div>
                    <?php }else{?>
                    <div class="pt-3 pb-2 col-md-7">
                        <h5>No Coupons Available </h5>
                    </div>
                    <div class="pt-3 pb-2 col-md-5">
                        <div class="row">
                            <!-- Generate Coupons Button -->
                            <div class="col-12 d-flex align-items-end justify-content-end">
                                <button type="button" class="bg-success text-white border-0 rounded-3 fw-bold px-3 py-2" id="generate_coupons">
                                    Generate Coupons
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php
                require '../../connect.php';
                $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                $stmt = $conn->prepare($sql);
                $stmt->execute([':fid' => $id]);
                $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($coupons) == 0){   
            ?>
            <div class="row">
                <div class="col-md-6 col-sm-6" id="couponFee">
                    <div class="input-block mb-3">
                        <label for="payment_fee" class="col-form-label">Payment Fee<span class="text-danger">*</span></label>
                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                            <option value="null" selected disabled>--Select Payment Fee--</option>
                            <option value="10000">Prime: <span>&#8377 </span>10,000/-</option>
                            <option value="30000">Premium: <span>&#8377 </span>30,000/-</option>
                            <option value="35000">Premium Plus: <span>&#8377 </span>35,000/-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="input-block mb-3">
                        <label for="comp_chek" class="col-form-label">Complementary Type<span class="text-danger">*</span></label>
                        <select class="form-select" id="comp_chek" aria-label="Floating label select example">
                            <option value="null" selected disabled>--Select Complementary Tpe--</option>
                            <option value="2">Non Complementary</option>
                            <option value="1">Complementary</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 col-sm-12 d-none" id="paymentMode1">
                <div class="input-block mb-3">
                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                    <div class="form-control radioBtn d-flex justify-content-around">
                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment1 me-3" name="payment" value="cash">Cash</label>
                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment1 me-3" name="payment" value="cheque">Cheque</label>
                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment1 me-3" name="payment" value="online">UPI/NEFT</label>
                    </div>
                </div>
            </div>
            <div class="pb-3 d-none" id="payOpt">
                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt1">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <div class="input-block">
                                <label class="col-form-label" for="chequeNo1">Cheque No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="chequeNo1" placeholder="Enter Cheque Number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-block">
                                <label class="col-form-label" for="chequeDate1">Cheque Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="chequeDate1" placeholder="Enter Date On Cheque">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-block">
                                <label class="col-form-label" for="bankName1">Bank Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bankName1" placeholder="Enter your Bank Name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt1">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="input-block">
                                <label class="col-form-label" for="transactionNo1">Transaction No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="transactionNo1" placeholder="Enter your Transaction No.">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 d-none" id="payProof">
                    <div class="mb-3">
                        <label class="col-form-label" for="file6">Payment Proof</label><br />
                        <input class="form-control" type="file" name="file6" id="upload_file61">
                    </div>
                    <input type="hidden" id="img_path61" value="">
                    <div id="preview61" style="display: none;">
                        <div id="image_preview61">
                            <img alt="Preview" id="img_pre61">
                        </div>
                    </div>
                </div>
                
            </div>
            <?php
                }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="couponsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Coupon Code</th>
                            <th>Coupon</th>
                            <th>Coupon Value</th>
                            <th>Date</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($coupons as $coupon): ?>
                        
                        <tr>
                            <td><?= htmlspecialchars($coupon['code']) ?></td>
                            <td><?= $customer_type?></td>
                            <td>&#8377;<?= $coupon['coupon_amt']?></td>
                            <td><?= date('d-m-Y', strtotime($coupon['created_date'])) ?></td>
                            <td><?= date('d-m-Y', strtotime($coupon['expiry_date'])) ?></td>
                            <td>
                                <?php
                                    $created_ts = strtotime($coupon['created_date']);
                                    $expiry_ts = strtotime($coupon['expiry_date']);
                                    $used_ts = isset($coupon['used_date']) ? strtotime($coupon['used_date']) : null;
                                    
                                    if ($coupon['usage_status'] == 1 && $used_ts) {
                                        echo '<span class="badge bg-danger">Used</span> on ' . date('d-m-Y', $used_ts);
                                    } elseif ($expiry_ts < time()) {
                                        echo '<span class="badge bg-secondary">Expired</span> on ' . date('d-m-Y', $expiry_ts);
                                    } else {
                                        echo '<span class="badge bg-success">Unused</span>';
                                    }
                                ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>