<!-- user count with revenue and commission paid and pending -->
<div class="col-xl-12">
    <div class="card rounded-4 shadow mb-3">
        <div class="card-body pt-1">
            <div class="card-title pb-1 d-flex justify-content-between ps-3 pe-3">
                <div>
                    <h3 class="text-dark pt-2">User Count Details</h3>
                </div>
                <div class="text-end d-flex align-items-center">
                    <span class="fs-6">
                        <p>Select Month & Year</p>
                        <input type="month" id="userCountCommissionDate" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle">
                    </span>
                </div>
            </div>
            <hr>
            <div class="col-12 table-responsive text-center">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="bg-dark-subtle fs-6">Users</th>
                            <th class="bg-dark-subtle">Total</th>
                            <th class="bg-dark-subtle text-end">Revenue</th>
                            <th class="bg-dark-subtle text-end">Commissions</th>
                        </tr>
                    </thead>
                    <tbody id="userCountCommission">
                        <!-- gets data from ajax call. File name - index_ajax/user_count_commission.php -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>