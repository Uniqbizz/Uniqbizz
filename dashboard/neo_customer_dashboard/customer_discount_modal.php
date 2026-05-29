<!-- =========================================================
     DISCOUNT WALLET MODAL
========================================================= -->

<div class="neoxdw-overlay-wrap" id="neoxdwModalOverlay">

    <div class="neoxdw-main-container">

        <!-- CLOSE BUTTON -->
        <button class="neoxdw-close-action"
                id="neoxdwCloseModalBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>


        <!-- =========================================================
             HEADER
        ========================================================= -->

        <div class="neoxdw-top-flex">

            <!-- LEFT GRAPHIC -->
            <div class="neoxdw-visual-side">

                <div class="neoxdw-floating-money">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>

                <div class="neoxdw-wallet-shape">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div class="neoxdw-floating-coin">
                    <i class="fa-solid fa-coins"></i>
                </div>

            </div>


            <!-- RIGHT CONTENT -->
            <div class="neoxdw-header-copy">

                <h2>
                    How Discount Wallet Works?
                </h2>

                <p>
                    Your Discount Wallet grows when your referred customer
                    travels with us again!
                </p>

            </div>

        </div>


        <!-- =========================================================
             PROCESS FLOW
        ========================================================= -->

        <div class="neoxdw-flow-layout">

            <!-- STEP 1 -->
            <div class="neoxdw-single-step">

                <div class="neoxdw-circle-icon neoxdw-purple-tone">
                    <i class="fa-solid fa-users"></i>
                </div>

                <h4>
                    You refer <br>
                    a customer
                </h4>

            </div>


            <div class="neoxdw-arrow-flow">
                <i class="fa-solid fa-arrow-right"></i>
            </div>


            <!-- STEP 2 -->
            <div class="neoxdw-single-step">

                <div class="neoxdw-circle-icon neoxdw-purple-tone">
                    <i class="fa-solid fa-suitcase"></i>
                </div>

                <h4>
                    They travel <br>
                    with us
                </h4>

            </div>


            <div class="neoxdw-arrow-flow">
                <i class="fa-solid fa-arrow-right"></i>
            </div>


            <!-- STEP 3 -->
            <div class="neoxdw-single-step">

                <div class="neoxdw-circle-icon neoxdw-purple-tone">
                    <i class="fa-solid fa-plane"></i>
                </div>

                <h4>
                    They travel <br>
                    again
                </h4>

            </div>


            <div class="neoxdw-arrow-flow">
                <i class="fa-solid fa-arrow-right"></i>
            </div>


            <!-- STEP 4 -->
            <div class="neoxdw-single-step">

                <div class="neoxdw-circle-icon neoxdw-green-tone">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <h4>
                    You earn <br>
                    commission
                </h4>

            </div>

        </div>


        <!-- =========================================================
             WHAT YOU EARN
        ========================================================= -->

        <div class="neoxdw-reward-box">

            <div class="neoxdw-reward-icon">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>

            <div class="neoxdw-reward-copy">

                <h3>What you earn?</h3>

                <p>
                    You earn a commission when your referred customer
                    completes their second eligible trip (repeat booking).
                    This amount is added to your Discount Wallet.
                </p>

            </div>

        </div>


        <!-- =========================================================
             IMPORTANT POINTS
        ========================================================= -->

        <div class="neoxdw-points-shell">

            <h3>Important Points</h3>

            <div class="neoxdw-points-grid">

                <!-- COLUMN 1 -->
                <div class="neoxdw-points-column">

                    <div class="neoxdw-bullet-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>
                            Earnings are added after the trip is completed.
                        </span>
                    </div>

                    <div class="neoxdw-bullet-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>
                            Only repeat bookings are eligible.
                        </span>
                    </div>

                    <div class="neoxdw-bullet-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>
                            Amount varies based on package,
                            destination & passengers.
                        </span>
                    </div>

                </div>


                <!-- COLUMN 2 -->
                <div class="neoxdw-points-column">

                    <div class="neoxdw-bullet-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>
                            You can use this balance on future bookings.
                        </span>
                    </div>

                    <div class="neoxdw-bullet-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>
                            Cannot be withdrawn or transferred.
                        </span>
                    </div>

                    <!--<div class="neoxdw-bullet-row">-->
                    <!--    <i class="fa-regular fa-circle-check"></i>-->
                    <!--    <span>-->
                    <!--        Valid for 12 months from the date of credit.-->
                    <!--    </span>-->
                    <!--</div>-->

                </div>

            </div>

        </div>


        <!-- =========================================================
             FOOTER NOTE
        ========================================================= -->

        <div class="neoxdw-footer-highlight">

            <div class="neoxdw-footer-icon">
                <i class="fa-regular fa-lightbulb"></i>
            </div>

            <div class="neoxdw-footer-content">

                <h4>
                    The more your friends travel again,
                    the more you earn!
                </h4>

                <p>
                    Keep referring and keep earning.
                </p>

            </div>

        </div>

    </div>

</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

const neoxdwOpenBtn =
    document.getElementById('neoxdwOpenModalBtn');

const neoxdwCloseBtn =
    document.getElementById('neoxdwCloseModalBtn');

const neoxdwModal =
    document.getElementById('neoxdwModalOverlay');


// OPEN MODAL
neoxdwOpenBtn.addEventListener('click', function(e){

    e.preventDefault();

    neoxdwModal.classList.add('neoxdw-show');

    document.body.style.overflow = 'hidden';

});


// CLOSE BUTTON
neoxdwCloseBtn.addEventListener('click', function(){

    neoxdwModal.classList.remove('neoxdw-show');

    document.body.style.overflow = '';

});


// CLICK OUTSIDE TO CLOSE
neoxdwModal.addEventListener('click', function(e){

    if(e.target === neoxdwModal){

        neoxdwModal.classList.remove('neoxdw-show');

        document.body.style.overflow = '';
    }

});


// ESC KEY CLOSE
document.addEventListener('keydown', function(e){

    if(e.key === 'Escape'){

        neoxdwModal.classList.remove('neoxdw-show');

        document.body.style.overflow = '';
    }

});

</script>