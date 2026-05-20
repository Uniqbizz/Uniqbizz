<!-- COUPON WALLET MODAL -->
<div class="coupon-modal-overlay" id="couponModal">

    <div class="coupon-modal">

        <!-- CLOSE BUTTON -->
        <button class="close-modal" id="closeCouponModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- TOP SECTION -->
        <div class="coupon-top">

            <div class="coupon-left">

                <h1>
                    How to Use <br>
                    <span>Coupon Wallet?</span>
                </h1>

                <p>
                    Your Coupon Wallet helps you save instantly on
                    eligible travel bookings made through Bizzmirth Holidays.
                </p>

            </div>

            <div class="coupon-right">

                <div class="coupon-icon-box">
                    <i class="fa-solid fa-ticket"></i>
                </div>

            </div>

        </div>

        <!-- WHERE CAN YOU USE -->

        <div class="coupon-section">

            <h3>Where Can You Use Coupons?</h3>

            <p class="section-subtitle">
                Coupons are applicable on:
            </p>

            <div class="coupon-usage-grid">

                <div class="usage-card">
                    <div class="usage-icon purple-bg">
                        <i class="fa-solid fa-suitcase"></i>
                    </div>

                    <h4>Domestic Holiday Packages</h4>
                </div>

                <div class="usage-card">
                    <div class="usage-icon red-bg">
                        <i class="fa-solid fa-globe"></i>
                    </div>

                    <h4>International Holiday Packages</h4>
                </div>

                <div class="usage-card">
                    <div class="usage-icon green-bg">
                        <i class="fa-solid fa-umbrella-beach"></i>
                    </div>

                    <h4>Weekend Escapes</h4>
                </div>

                <div class="usage-card">
                    <div class="usage-icon orange-bg">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <h4>Group Tours</h4>
                </div>

                <div class="usage-card">
                    <div class="usage-icon blue-bg">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                    <h4>Events by Bizzmirth Holidays</h4>
                </div>

                <div class="usage-card">
                    <div class="usage-icon shield-bg">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h4>Company Approved Experiences</h4>
                </div>

            </div>

        </div>

        <!-- TWO COLUMN -->

        <div class="coupon-double-grid">

            <!-- LEFT -->

            <div class="coupon-section">

                <h3>How Coupon Usage Works?</h3>

                <div class="discount-box">

                    <div class="discount-ticket">
                        <i class="fa-solid fa-ticket"></i>
                    </div>

                    <div>
                        <h4>1 Coupon = ₹500 Discount</h4>

                        <p>
                            Each coupon provides ₹500 discount
                            on eligible bookings.
                        </p>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="coupon-section">

                <h3>Passenger-Based Usage</h3>

                <p class="section-subtitle">
                    Coupon usage depends on the number of passengers travelling.
                </p>

                <div class="passenger-table">

                    <div class="table-head">
                        <span>Number of Passengers</span>
                        <span>Maximum Coupons Allowed</span>
                    </div>

                    <div class="table-row">
                        <span>
                            <i class="fa-solid fa-user"></i>
                            1 Passenger
                        </span>

                        <strong>1 Coupon</strong>
                    </div>

                    <div class="table-row">
                        <span>
                            <i class="fa-solid fa-user-group"></i>
                            2 Passengers
                        </span>

                        <strong>2 Coupons</strong>
                    </div>

                    <div class="table-row">
                        <span>
                            <i class="fa-solid fa-users"></i>
                            4 Passengers
                        </span>

                        <strong>4 Coupons</strong>
                    </div>

                </div>

                <div class="info-line">
                    <i class="fa-solid fa-circle-info"></i>
                    Coupons utilized cannot exceed the number of passengers.
                </div>

            </div>

        </div>

        <!-- APPLY CONDITIONS -->

        <div class="coupon-section">

            <h3>When Can Coupons Be Applied?</h3>

            <div class="condition-grid">

                <div class="condition-card success">

                    <div class="condition-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <h4>Coupons must be applied during booking process only.</h4>
                    </div>

                </div>

                <div class="condition-card danger">

                    <div class="condition-icon">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>

                    <div>
                        <h4>Coupons cannot be:</h4>

                        <ul>
                            <li>Added after booking confirmation</li>
                            <li>Reused after utilization</li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

        <!-- IMPORTANT CONDITIONS -->

        <div class="coupon-section">

            <h3>Important Conditions</h3>

            <div class="important-grid">

                <div class="important-card">
                    <i class="fa-solid fa-user-slash"></i>
                    <p>Coupons are non-transferable</p>
                </div>

                <div class="important-card">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <p>Coupons cannot be withdrawn as cash</p>
                </div>

                <div class="important-card">
                    <i class="fa-solid fa-right-left"></i>
                    <p>Coupons cannot be exchanged into money</p>
                </div>

                <div class="important-card">
                    <i class="fa-solid fa-calendar-days"></i>
                    <p>Coupons are valid only within validity period</p>
                </div>

                <div class="important-card">
                    <i class="fa-solid fa-clock"></i>
                    <p>Expired coupons cannot be reactivated</p>
                </div>

            </div>

        </div>

        <!-- SUPPORT -->

        <div class="support-box">

            <div class="support-icon">
                <i class="fa-solid fa-headset"></i>
            </div>

            <div>
                <h4>Need Assistance?</h4>

                <p>
                    For support regarding Coupon Wallet usage,
                    please contact your Travel Consultant or Customer Support Team.
                </p>
            </div>

        </div>

    </div>

</div>
<script>

    const couponModal = document.getElementById("couponModal");
    const openCouponModal = document.getElementById("openCouponModal");
    const closeCouponModal = document.getElementById("closeCouponModal");

    // OPEN MODAL

    openCouponModal.addEventListener("click", function(e){

        e.preventDefault();

        couponModal.classList.add("active");

        document.body.style.overflow = "hidden";

    });

    // CLOSE MODAL

    closeCouponModal.addEventListener("click", function(){

        couponModal.classList.remove("active");

        document.body.style.overflow = "auto";

    });

    // CLOSE ON OUTSIDE CLICK

    couponModal.addEventListener("click", function(e){

        if(e.target === couponModal){

            couponModal.classList.remove("active");

            document.body.style.overflow = "auto";

        }

    });

    // CLOSE ON ESC KEY

    document.addEventListener("keydown", function(e){

        if(e.key === "Escape"){

            couponModal.classList.remove("active");

            document.body.style.overflow = "auto";

        }

    });

</script>