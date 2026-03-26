<!-- Top performer   -->
<div class="col-lg-12 col-md-12">
    <div class="card rounded-4 shadow mb-3">
        <div class="card-body pt-2">
            <div class="card-title pb-1 d-flex justify-content-between ps-3 pe-3">
                <div>
                    <h3 class="text-dark pt-2">Top Performer</h3>
                </div>
                <div class="text-end d-flex align-items-center">
                    <span class="fs-6">
                        <p>Select Month & Year</p>
                        <input type="month" id="topPerformerDate" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle">
                    </span>
                </div>
            </div>
            <hr>
            <div class="mb-2">
                <ul class="nav nav-pills d-flex justify-content-between" id="navMenu">
                    <li class="nav-item">
                        <a class="nav-link top_p active" aria-current="page" href="#" value="bm">Business Mentor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="mf">Master Franchisees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="sf">Sponsor Franchisees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="te">Techno Enterprise</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="sub_f">Franchisees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="ins">Institute</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="tc">Travel Consultants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link top_p" href="#" value="cu">Customers</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 table-responsive text-center">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="bg-dark-subtle fs-6">ID</th>
                            <th class="bg-dark-subtle">Name</th>
                            <th class="bg-dark-subtle text-end">Total Count</th>
                            <th class="bg-dark-subtle text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="topPerformer">
                        <!-- gets data from ajax call. File name - index_ajax/top_performer.php -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>