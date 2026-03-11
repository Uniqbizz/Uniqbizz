<!-- transfer modal -->
<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="transferTitle">Transfer Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="transfer_user_id">
                <input type="hidden" id="transfer_id">
                <input type="hidden" id="transfer_status">
                <input type="hidden" id="user_type">

                <label class="form-label" id="reasonLabel"></label>

                <textarea id="transferText"
                        class="form-control"
                        maxlength="999"
                        rows="4"
                        placeholder="Enter reason..."></textarea>

                <small class="text-muted float-end">
                    <span id="charCount">0</span> / 999
                </small>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="submitTransfer()">Submit</button>
            </div>

        </div>
    </div>
</div>
<!-- transfer modal -->