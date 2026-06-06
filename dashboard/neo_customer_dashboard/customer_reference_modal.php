<!-- =========================
     REFERRAL MODAL
========================= -->

<div class="neo-referral-modal" id="referralModal">

    <div class="neo-referral-modal-box">

        <!-- CLOSE -->
        <button class="neo-referral-close" id="closeReferralModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- HEADER -->
        <div class="neo-referral-header">

            <div class="neo-referral-header-left">

                <div class="neo-header-illustration">

                    <div class="neo-wallet-icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>

                    <div class="neo-coin-stack">
                        <i class="fa-solid fa-coins"></i>
                    </div>

                </div>

                <div>

                    <p class="neo-mini-title">
                        Travel Referral Program
                    </p>

                    <h1>
                        How the Referral <br>
                        Wallet Works
                    </h1>

                    <p class="neo-header-desc">
                        Invite friends, earn exciting travel rewards,
                        and unlock exclusive benefits every time your
                        referrals book trips with us.
                    </p>

                </div>

            </div>

        </div>

        <!-- STEP 1 -->
        <div class="neo-referral-card">

            <div class="neo-step-badge neo-purple-bg">
                1
            </div>

            <div class="neo-referral-flex">

                <div class="neo-referral-left">

                    <h3>
                        Refer Your Friends
                    </h3>

                    <p>
                        Share your referral code with friends and family.
                        Once they sign up and make a booking, rewards
                        will be credited directly to your wallet.
                    </p>

                    <div class="neo-earn-box neo-purple-soft">

                        <i class="fa-solid fa-gift"></i>

                        <div>
                            <span>Earn up to</span>
                            <h2>₹1,000</h2>
                        </div>

                    </div>

                </div>

                <div class="neo-referral-right neo-purple-soft">

                    <h4>
                        Benefits Included
                    </h4>

                    <ul>

                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Instant referral rewards
                        </li>

                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Cashback on bookings
                        </li>

                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Special seasonal bonuses
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- STEP 2 -->
        <div class="neo-referral-card">

            <div class="neo-step-badge neo-green-bg">
                2
            </div>

            <div class="neo-referral-flex">

                <div class="neo-referral-left">

                    <h3>
                        Unlock Travel Benefits
                    </h3>

                    <p>
                        Your wallet rewards can be used for hotels,
                        flights, tours, holiday packages, and much more.
                    </p>

                    <div class="neo-green-alert">
                        <i class="fa-solid fa-circle-check"></i>
                        Wallet rewards are automatically applied during checkout.
                    </div>

                </div>

                <div class="neo-benefit-icons">

                    <div class="neo-benefit-item">
                        <i class="fa-solid fa-plane"></i>
                        <span>Flights</span>
                    </div>

                    <div class="neo-benefit-item">
                        <i class="fa-solid fa-hotel"></i>
                        <span>Hotels</span>
                    </div>

                    <div class="neo-benefit-item">
                        <i class="fa-solid fa-umbrella-beach"></i>
                        <span>Holidays</span>
                    </div>

                    <div class="neo-benefit-item">
                        <i class="fa-solid fa-passport"></i>
                        <span>Visa</span>
                    </div>

                </div>

            </div>

        </div>

        <!-- STEP 3 -->
        <div class="neo-referral-card">

            <div class="neo-step-badge neo-orange-bg">
                3
            </div>

            <div class="neo-referral-flex">

                <div class="neo-referral-left">

                    <h3>
                        Booking Reward Cycle
                    </h3>

                    <p>
                        Earn travel rewards for every successful
                        booking made through your referral network.
                    </p>

                </div>

                <div class="neo-booking-grid">

                    <div class="neo-booking-box neo-orange-soft">

                        <i class="fa-solid fa-plane-departure"></i>

                        <h4>
                            First Booking
                        </h4>

                        <p>
                            Rewards credited to
                            <strong>Main Wallet</strong>
                        </p>

                    </div>

                    <div class="neo-booking-box neo-pink-soft">

                        <i class="fa-solid fa-rotate"></i>

                        <h4>
                            Subsequent Bookings
                        </h4>

                        <p>
                            Benefits credited to
                            <strong>Discount Wallet</strong>
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- TIPS -->
        <div class="neo-tips-section">

            <div class="neo-tips-title">

                <i class="fa-solid fa-lightbulb"></i>

                <h3>
                    Tips to Maximize Your Earnings
                </h3>

            </div>

            <div class="neo-tips-grid">

                <div class="neo-tip-item">

                    <i class="fa-solid fa-users"></i>

                    <div>

                        <h4>
                            Refer more friends
                        </h4>

                        <p>
                            More referrals, more rewards!
                        </p>

                    </div>

                </div>

                <div class="neo-tip-item">

                    <i class="fa-solid fa-suitcase"></i>

                    <div>

                        <h4>
                            Encourage holiday bookings
                        </h4>

                        <p>
                            Earn higher travel benefits.
                        </p>

                    </div>

                </div>

                <div class="neo-tip-item">

                    <i class="fa-solid fa-bullhorn"></i>

                    <div>

                        <h4>
                            Stay updated on offers
                        </h4>

                        <p>
                            Seasonal campaigns bring extra benefits.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- FOOTER NOTE -->
        <div class="neo-footer-note">

            <i class="fa-regular fa-star"></i>

            Start referring today and turn your network
            into exciting travel rewards!

        </div>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const referralModal =
        document.getElementById('referralModal');

    const openReferralModal =
        document.getElementById('openReferralModal');

    const closeReferralModal =
        document.getElementById('closeReferralModal');

    // OPEN
    openReferralModal.addEventListener('click', function(e){

        e.preventDefault();

        referralModal.classList.add('show');

        document.body.style.overflow = 'hidden';

    });

    // CLOSE BUTTON
    closeReferralModal.addEventListener('click', function(){

        referralModal.classList.remove('show');

        document.body.style.overflow = '';

    });

    // OUTSIDE CLICK
    referralModal.addEventListener('click', function(e){

        if(e.target === referralModal){

            referralModal.classList.remove('show');

            document.body.style.overflow = '';

        }

    });

    // ESC KEY
    document.addEventListener('keydown', function(e){

        if(e.key === 'Escape'){

            referralModal.classList.remove('show');

            document.body.style.overflow = '';

        }

    });

});

</script>