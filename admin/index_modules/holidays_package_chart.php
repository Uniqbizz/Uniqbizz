<!-- doughnut Holidays packages chart  -->
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card rounded-4 mb-3">
        <div class="card-body pt-2">
            <div class="d-flex justify-content-between">
                <h3 class="text-dark pt-2">Holiday Packages</h3>
                <select id="holiday_years_id" onchange="getHolidayRevenue(this.value)" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
            </div>
            <h3 class="fw-bold pt-2 pb-3">&#8377;<span class=" fw-normal" id="holiday_revenue">  </span></h3>
            <div id="doughnut-chart-2" class="e-charts"></div>
        </div>
    </div>
</div>