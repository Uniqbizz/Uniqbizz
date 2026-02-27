<div class="card rounded-4">
    <div class="row p-4 d-flex justify-content-around">
        <div class="col-md-12 col-sm-12 col-12 d-grid align-items-center">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(1, this)" type="button" class="rounded-4 bg-primary-subtle btn fw-bolder fs-5 text-primary-emphasis py-4 w-100 text-center mb-2">
                        Business Mentor<span id="bmCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(2, this)" type="button" class="rounded-4 bg-success-subtle btn fw-bolder fs-5 text-success-emphasis py-4 w-100 text-center mb-2">
                        Employees<span id="empCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(3, this)" type="button" class="rounded-4 bg-warning-subtle btn fw-bolder fs-5 text-warning-emphasis py-4 w-100 text-center mb-2">
                        Techno Enterprise<span id="teCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(4, this)" type="button" class="rounded-4 bg-danger-subtle btn fw-bolder fs-5 text-danger-emphasis py-4 w-100 text-center mb-2">
                        Travel Consultant<span id="tcCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(5, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                        Customer<span id="custCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(6, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                        Master Franchise<span id="mfCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(7, this)" type="button" class="rounded-4 bg-teal-subtle btn fw-bolder fs-5 text-teal-emphasis py-4 w-100 text-center mb-2">
                        Sponsor Franchise<span id="sfCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                    <button onclick="showDivCount(8, this)" type="button" class="rounded-4 bg-orange-subtle btn fw-bolder fs-5 text-orange-emphasis py-4 w-100 text-center mb-2">
                        Franchise<span id="fCount" class="fs-2 ms-3"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-12">
            <div class="text-end d-flex align-items-center justify-content-end pb-2">
                <span class="fs-6">
                    <p class="fw-bolder text-dark">Select Month & Year</p>
                    <input type="month" id="month_year_count" min="2020-01" max="" class="rounded-3" onchange="handleMonthClick()">
                </span>
            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-primary-subtle" id="count1" style="display: block;">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Business Mentor Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable1">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="bm_month_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-success-subtle" id="count2">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Employees Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable2">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="emp_month_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-warning-subtle" id="count3">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Techno Enterprise Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable3">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="te_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-danger-subtle" id="count4">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Travel Consultant Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable4">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="tc_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count5">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Customer Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable5">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="cust_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-secondary-subtle" id="count6">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Customer Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable6">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="mf_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count7">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Customer Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable7">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="sf_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count8">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Monthly Customer Details</h4>
                    </div>
                    
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0" id="datatable8">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Sr.No</th>
                                <th>Name & Id</th>
                                <th>Refered By</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody id="f_monthly_list">
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>