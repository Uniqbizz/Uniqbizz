<div class="modal fade" id="withdrawWalletModal" tabindex="-1" aria-labelledby="withdrawWalletModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content withdrawWalletModal">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="withdrawWalletModalLabel">
                        <i class="ri-hand-coin-line me-2"></i>
                        Withdraw Referral Earnings
                    </h5>
                    <p class="text-muted fontSize11 mb-0 mt-1">
                        Request a withdrawal from your referral wallet.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <!-- Available Balance -->
                <div class="availableWalletBalance mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="walletIcon">
                            <i class="ri-wallet-3-line"></i>
                        </div>
                        <div>
                            <p class="mb-1 fontSize10 text-muted">
                                Available Referral Wallet
                            </p>
                            <h3 class="mb-0 fw-bold">
                                ₹<span id="availableReferralBalance"><?= preg_replace('/(\d)(?=(\d\d)+\d$)/', '$1,', number_format($refWalletCurBalData['balance'] ?? 0, 2, '.', '')) ?></span>
                            </h3>
                        </div>
                    </div>
                    <div class="mt-3 walletInfo">
                        <i class="ri-information-line"></i>
                        <span>
                            You can request a withdrawal using your available
                            wallet balance.
                        </span>
                    </div>
                </div>
                <!-- Withdrawal Amount -->
                <div class="mb-3">
                    <label for="withdrawAmount" class="form-label fontSize11 fw-semibold">Withdrawal Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            ₹
                        </span>
                        <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount" placeholder="Enter amount" min="1" step="0.01">
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted fontSize9">
                            Available:
                            ₹<span id="withdrawAvailableAmount"><?= preg_replace('/(\d)(?=(\d\d)+\d$)/', '$1,', number_format($refWalletCurBalData['balance'] ?? 0, 2, '.', '')) ?></span>
                        </small>
                        <button type="button" class="btn btn-link p-0 fontSize9" id="withdrawMaxBtn">Withdraw Full Balance</button>
                    </div>
                    <div class="text-danger fontSize9 mt-1 d-none" id="withdrawAmountError" ></div>
                </div>
                <!-- Request Summary -->
                <div class="withdrawSummary d-none" id="withdrawSummary" >
                    <div class="d-flex justify-content-between">
                        <span class="fontSize10 text-muted">
                            Withdrawal Amount
                        </span>
                        <strong class="fontSize10">
                            ₹<span id="summaryWithdrawAmount">0.00</span>
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span class="fontSize10 text-muted">
                            Remaining Balance
                        </span>
                        <strong class="fontSize10">
                            ₹<span id="summaryRemainingBalance">0.00</span>
                        </strong>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>
                    Cancel
                </button>
                <button type="button" class="btn withdrawSubmitBtn" id="submitWithdrawalBtn">
                    <i class="ri-secure-payment-line me-1"></i>
                    Request Withdrawal
                </button>
            </div>
        </div>
    </div>
</div>