<!-- line chart -->
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card rounded-4 mb-3">
        <div class="card-body pt-2">
            <div class="d-flex justify-content-between">
                <h3 class="text-dark pt-2">Customer Chart</h3>
                <select id="customer_years_id" onchange="customerLineChart()" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
            </div>
            <div id="line-chart" data-colors='["--bs-success"]' class="e-charts"></div>
            <div class="d-flex justify-content-between mt-3">
                <select id="customer_month_id" onchange="customerLineChart()" class="mb-2 rounded-2 px-3 border border-secondary-subtle"></select>
                <p class="mb-2 rounded-2 px-3 border border-secondary-subtle text-black fw-bold">Count: <span class="text-primary fw-normal" id="count"></span></p>
                <p class="mb-2 rounded-2 px-3 border border-secondary-subtle text-black fw-bold">Revenue: <span class="text-success fw-normal" id="revenue">&#8377; </span></p>
            </div>
        </div>
    </div>
</div>