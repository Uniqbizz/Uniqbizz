<div class="tab-pane fade card px-3 rounded-4" id="editLogs" role="tabpanel">
    <div class="row">
        <div class="d-flex justify-content-end">
            <div class="pt-3 pb-2 col-md-7">
                <h5>Edit History</h5>

            </div>
            <div class="pt-3 pb-2 col-md-5">
                <div class="row d-flex justify-content-end">
                    <input type="text" id="editrangeDate" class="bg-light rounded-3 border-0 p-2" placeholder="Select Date Range"/>
                    <div class="ms-3 col-md-3">
                        <button id="downloadBtn" class="bg-success text-white border-0 rounded-3 px-3">
                            Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TABLE -->
    <div class="table-responsive table-desi pb-2">
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