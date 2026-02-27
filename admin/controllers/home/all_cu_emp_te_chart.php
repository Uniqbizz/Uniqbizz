<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
    <div class="card p-3 rounded-4">
        <h4 class="card-title mb-3">Customer Membership Line Chart</h4>
        <hr class="mb-5">
        <div class="row">
            <div class="col-12">
                <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                    <span>
                        Select Year
                        <select id="yearsCustMemb" onchange="getMonthlyUserDataCustMemb(this.value)"></select>
                    </span>
                </div>
                <div class="table-responsive table-desi">
                    <canvas id="myChartCust" style="width:100%; max-width:1000px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
    <div class="card p-3 rounded-4">
        <h4 class="card-title mb-3">Line Chart</h4>
        <hr class="mb-5">
        <div class="row">
            <div class="col-12">
                <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                    <span>
                        Select Year
                        <select id="years" onchange="getMonthlyUserData(this.value)"></select>
                    </span>
                </div>
                <div class="table-responsive table-desi">
                    <canvas id="myChart" style="width:100%; max-width:1000px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 mb-2">
    <div class="card p-3 rounded-4" id="ca_chart_box">
        <div class="row">
            <div class="col-12">
                <div class="tab-inn">
                    <h4 class="card-title mb-4">Techno Enterprise</h4>
                    <div class="table-responsive table-desi">
                        <canvas id="myCAChart" class="myCAChart" height="115%" weight="115%"></canvas>
                    </div>
                    <div class="mt-4">
                        <span class="ca_total_count" id="ca_total_count"></span>
                        <span class="ca_total_price" id="ca_total_price"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="ca_no_chart_box">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="tab-inn">
                        <h3>No Corporat Agency Data Found</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>