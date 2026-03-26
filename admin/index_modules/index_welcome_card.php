<!-- welcome banner with last login -->
<div class="col-xl-12">
    <div class="card overflow-hidden rounded-4 mb-3">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-8 col-12 pe-0">
                <div class="p-3 pb-4">
                    <h3 class="px-4 py-2 text-dark"><span style='font-size:30px;'>&#128075;</span>&nbsp;&nbsp;Welcome back, Admin</h3>
                    <p class="px-4 pt-3">Here's a quick overview of business performance. Track revenue, commissions, memberships, and network activity across all roles from one dashboard.</p> 
                    <div class="row px-4 pt-2">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 border-end border-2 dayField">
                            <div class="rounded-2 bg-primary-subtle text-center" style="width: 20px";>
                                <i class="fa-regular fa-calendar fa-sm" style="color: rgba(85, 110, 230, 1.00);"></i>
                            </div>
                            <p class="peraAdmin text-dark fw-bold">Today: <span><?php echo $formatted_date ?></span></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-4 timeField">
                            <div class="rounded-2 bg-primary-subtle text-center" style="width: 20px";>
                                <i class="fa-regular fa-clock fa-sm" style="color: rgba(85, 110, 230, 1.00);"></i>
                            </div>
                            <p class="peraAdmin1 text-dark fw-bold">Last Login: <span><?php echo $lastLogin ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 col-12 align-self-end d-flex justify-content-center">
                <div class="dotlottie-player" style="width: 200px;">
                    <dotlottie-player
                        src="assets/images/Service.lottie"
                        background="transparent"
                        speed="1"
                        style="width: 100%; height: auto;"
                        loop
                        autoplay>
                    </dotlottie-player>
                </div>
            </div>
        </div>
    </div>
</div>