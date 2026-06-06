<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">   
    <div class="card2 border border-2 rounded-4 p-3">    
        <div class="d-flex gap-3 align-items-center mt-3">
            <i class="fa-solid fa-wallet fa-2xl" style="color: #056649;"></i>
            <p class="custID mb-0 fw-bold textColor fs-5">Wallet Balance</h5>
        </div>
        <div class="d-flex justify-content-around gap-3 mt-3">
            <div class="mt-3">
                <p class="fs-4 mb-0 fw-bolder textColor">₹<?= (($refWalletData['ref_total_earning'] ?? '0') + ($refWalletCurBalData['ref_booking_total'] ?? '0' ) + ($disWalletData['balance'] ?? '0')) ?></p>
            </div>
            
        </div>
        <div class="d-flex justify-content-center mt-3 mb-4">
            <a href="<?= $base_url_cust.$folder_map[$customer['customer_type']]?>customer_wallet.php">
                <div class="linkBtn p-2 px-3 border border-primary border-2">
                    <p class="fs-6 mb-0 fw-bolder"> View Wallets</p>
                </div>
            </a>
        </div>
    </div>
</div>