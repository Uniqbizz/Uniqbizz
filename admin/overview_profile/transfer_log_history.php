<div class="tab-pane fade card px-3 rounded-4" id="transferLogs" role="tabpanel">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5>Edit History</h5>

        <div class="d-flex gap-2">
            <input type="text" id="editrangeDate1" class="bg-light rounded-3 border-0 p-2" placeholder="Select Date Range"/>

            <button id="downloadBtn1" class="bg-success text-white border-0 rounded-3 px-3">
                Download
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-hover" id="transferLogTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Previous User</th>
                    <th>Previous User Email</th>
                    <th>Previous DOJ</th>
                    <th>New User</th>
                    <th>New User Email</th>
                    <th>Transfer Reason</th>
                    <th>Transfer Remark</th>
                    <th>Transfer status</th>
                    <th>Approve/Reject Date</th>
                    <th>Transfered By</th>
                </tr>
            </thead>
            <tbody id="transferLogsbody"></tbody>
        </table>
    </div>

</div>