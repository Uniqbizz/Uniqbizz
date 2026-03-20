<div class="tab-pane fade card px-3 rounded-4" id="editLogs" role="tabpanel">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <h5>Edit History</h5>

        <div class="d-flex gap-2">
            <input type="text" id="editrangeDate" class="bg-light rounded-3 border-0 p-2" placeholder="Select Date Range"/>

            <button id="downloadBtn" class="bg-success text-white border-0 rounded-3 px-3">
                Download
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-hover" id="editLogTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Column</th>
                    <th>Old</th>
                    <th>New</th>
                    <th>Changed By</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody id="editLogsbody"></tbody>
        </table>
    </div>

</div>