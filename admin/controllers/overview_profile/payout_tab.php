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
            </tbody>
        </table>
    </div>
    
</div>