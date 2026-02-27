<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
        <!-- Chart Section  all commission -->
        <div class="card p-3 rounded-4">
            <div class="row">
                <!-- Type Selector -->
                <div class="col-md-4">
                    <select id="dataTypeSelect" class="form-control">
                        <option value="all" selected>All</option>
                        <option value="tc">TC</option>
                        <option value="te">TE</option>
                        <option value="customer">Customer</option>
                        <option value="bm">BM</option>
                        <option value="sf">SF</option>
                        <option value="mf">MF</option>
                        <option value="f">F</option>
                    </select>
                </div>

                <!-- Month-Year Selector -->
                <div class="col-md-4">
                    <input type="month" id="monthSelector" class="form-control">
                </div>

                <!-- Download Button (initially hidden) -->
                <div class="col-md-4">
                    <button id="downloadChartBtn" class="btn btn-primary w-100" onclick="downloadChartData()" style="display: none;">
                        Download Data
                    </button>
                </div>
                <!-- Chart Summary and Canvas -->
                <div class="col-md-12 mt-4 text-center" id="payout_chart_box">
                    <h5 class="fw-bolder" id="ca_total_count1"></h5>
                    <h6 class="fw-bolder" id="ca_total_price1"></h6>
                    <canvas id="myCAChart1" height="115%" weight="115%"></canvas>
                </div>
            </div>
        </div>

        <!-- No Data Message -->
        <div class="card" id="payout_no_chart_box" style="display: none;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-inn text-center">
                            <h3>No Data Found</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
        <!-- Chart Section customer membership-->
        <div class="card p-3 rounded-4" >
            <div class="row">
                <!-- Type Selector -->
                <div class="col-md-4">
                    <select id="dataTypeSelect1" class="form-control">
                        <option value="all" selected>All</option>
                        <option value="Prime">Prime</option>
                        <option value="Premium">Premium</option>
                        <option value="Premium Plus">Premium Plus</option>
                        <option value="Premium Select">Premium Select</option>
                        <option value="Premium Select Lite">Premium Select Lite</option>
                        <option value="Neo Select">Neo Select</option>
                        <option value="Neo Select Ultra">Neo Select Ultra</option>
                    </select>
                </div>

                <!-- Month-Year Selector -->
                <div class="col-md-4">
                    <input type="month" id="monthSelector1" class="form-control">
                </div>

                <!-- Download Button (initially hidden) -->
                <div class="col-md-4">
                    <button id="downloadChartBtn1" class="btn btn-primary w-100" onclick="downloadChartData1()" style="display: none;">
                        Download Data
                    </button>
                </div>
                <!-- Chart Summary and Canvas -->
                <div class="col-md-12 mt-4 text-center" id="ca_chart_box1">
                    <h5 class="fw-bolder">Customer Membership</h5>
                    <h6 class="fw-bolder mb-0" id="ca_total_count2"></h6>
                    <h6 class="fw-bolder" id="ca_total_price2"></h6>
                    <canvas id="myCAChart2" height="115%" weight="115%"></canvas>
                </div>
            </div>
        </div>

        <!-- No Data Message -->
        <div class="card" id="ca_no_chart_box1" style="display: none;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-inn text-center">
                            <h3>No Data Found</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>