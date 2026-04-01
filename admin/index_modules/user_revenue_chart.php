<!-- doughnut chart  -->
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card rounded-4 mb-3">
        <div class="card-body pt-2">
            <div class="d-flex justify-content-between">
                <h3 class="text-dark pt-2">Revenue Chart</h3>
                <select id="revenue_years_id" onchange="getAllUserRevenue(this.value)" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
            </div>
            <h2 class="fw-bold pt-2 pb-3 text-dark ">&#8377;<span class=" fw-normal" id="revenueAllUsers">  </span></h2>
            <div id="doughnut-chart"  class="e-charts"></div>
        </div>
    </div>
</div>