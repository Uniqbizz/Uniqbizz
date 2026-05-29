<!-- EARN COUPON MODAL -->
<div class="earn-coupon-overlay" id="earnCouponModal">

    <div class="earn-coupon-modal">

        <!-- CLOSE BUTTON -->
        <button class="earn-close-btn" id="closeEarnCouponModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- HEADER -->

        <div class="earn-modal-header">

            <div class="earn-header-left">

                <h1>
                    How to Earn <br>
                    <span>Coupons?</span>
                </h1>

                <p>
                    Multiple ways to earn coupons and
                    save more on your next trips!
                </p>

            </div>

            <div class="earn-header-right">

                <div class="earn-wallet-box">

                    <i class="fa-solid fa-wallet"></i>

                    <div class="coin coin-1">
                        <i class="fa-solid fa-coins"></i>
                    </div>

                    <div class="coin coin-2">
                        <i class="fa-solid fa-coins"></i>
                    </div>

                </div>

            </div>

        </div>

        <!-- TITLE -->

        <div class="earn-section-title">

            <span></span>

            <h2>Ways to Earn Coupons</h2>

            <span></span>

        </div>

        <!-- EARNING CARDS -->

        <div class="earn-method-list">

            <!-- CARD 1 -->

            <div class="earn-method-card purple-card">

                <div class="earn-method-left">

                    <div class="earn-method-icon purple-light">
                        <i class="fa-solid fa-ticket"></i>
                    </div>

                    <div class="earn-method-content">

                        <h3>Complete a Trip</h3>

                        <p>
                            Earn coupons after your trip is completed successfully.
                        </p>

                    </div>

                </div>

                <div class="earn-divider"></div>

                <div class="earn-method-right">

                    <small>Earn</small>

                    <h4>1 Coupon</h4>

                    <p>(₹500)</p>

                </div>

            </div>

            <!-- CARD 2 -->

            <div class="earn-method-card green-card">

                <div class="earn-method-left">

                    <div class="earn-method-icon green-light">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div class="earn-method-content">

                        <h3>Group Booking</h3>

                        <p>
                            Travel with friends or family. Earn more coupons on group bookings.
                        </p>

                    </div>

                </div>

                <div class="earn-divider"></div>

                <div class="earn-method-right">

                    <small>Earn</small>

                    <h4>1 Coupon</h4>

                    <p>Per Passenger</p>

                </div>

            </div>

            <!-- CARD 3 -->

            <div class="earn-method-card orange-card">

                <div class="earn-method-left">

                    <div class="earn-method-icon orange-light">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div class="earn-method-content">

                        <h3>Weekend Escapes & Events</h3>

                        <p>
                            Earn coupons when you book eligible weekend escapes or events.
                        </p>

                    </div>

                </div>

                <div class="earn-divider"></div>

                <div class="earn-method-right">

                    <small>Earn</small>

                    <h4>1 Coupon</h4>

                    <p>Per Booking</p>

                </div>

            </div>

            <!-- CARD 4 -->

            
            <!-- CARD 5 -->

            <div class="earn-method-card pink-card">

                <div class="earn-method-left">

                    <div class="earn-method-icon pink-light">
                        <i class="fa-solid fa-gift"></i>
                    </div>

                    <div class="earn-method-content">

                        <h3>Special Offers & Campaigns</h3>

                        <p>
                            Participate in exclusive offers, contests and promotional campaigns.
                        </p>

                    </div>

                </div>

                <div class="earn-divider"></div>

                <div class="earn-method-right">

                    <small>Earn</small>

                    <h4>Coupons</h4>

                    <p>As per campaign</p>

                </div>

            </div>

        </div>

        <!-- IMPORTANT SECTION -->

        <div class="earn-important-box">

            <div class="earn-important-title">

                <i class="fa-solid fa-circle-info"></i>

                <h3>Important to Know</h3>

            </div>

            <ul>
                <li>Earned coupons will be credited to your Coupon Wallet.</li>
                <li>Coupons are valid for 12 months from the date of credit.</li>
                <li>Coupons can be used on eligible bookings only.</li>
            </ul>

        </div>

        <!-- SUPPORT -->

        <div class="earn-support-box">

            <div class="earn-support-left">

                <div class="earn-support-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>

                <div>

                    <h3>Need Help?</h3>

                    <p>
                        For any queries on earning or using coupons,
                        connect with your Travel Consultant or Support Team.
                    </p>

                </div>

            </div>

            <button class="earn-support-btn">
                Contact Support
            </button>

        </div>

    </div>

</div>
<script>

// ELEMENTS

const earnCouponModal = document.getElementById("earnCouponModal");

const openEarnCouponModal =
document.getElementById("openEarnCouponModal");

const closeEarnCouponModal =
document.getElementById("closeEarnCouponModal");

// OPEN MODAL

openEarnCouponModal.addEventListener("click", function(e){

    e.preventDefault();

    earnCouponModal.classList.add("active");

    document.body.style.overflow = "hidden";

});

// CLOSE BUTTON

closeEarnCouponModal.addEventListener("click", function(){

    earnCouponModal.classList.remove("active");

    document.body.style.overflow = "auto";

});

// CLOSE OUTSIDE

earnCouponModal.addEventListener("click", function(e){

    if(e.target === earnCouponModal){

        earnCouponModal.classList.remove("active");

        document.body.style.overflow = "auto";

    }

});

// ESC CLOSE

document.addEventListener("keydown", function(e){

    if(e.key === "Escape"){

        earnCouponModal.classList.remove("active");

        document.body.style.overflow = "auto";

    }

});

// SUPPORT BUTTON

document.querySelector(".earn-support-btn")
.addEventListener("click", function(){

    alert("Redirecting to Support Team");

});

</script>