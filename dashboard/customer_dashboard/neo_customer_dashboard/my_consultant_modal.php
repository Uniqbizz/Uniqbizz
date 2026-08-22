<!-- =========================================
     MODAL
========================================= -->

<div class="qxz9-consultant-modal-overlay" id="qxz9ConsultantModal">

    <div class="qxz9-consultant-modal-box">

        <!-- CLOSE -->
        <button class="qxz9-modal-close-btn" id="qxz9CloseConsultantModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- HEADER -->
        <div class="qxz9-modal-header">

            <h2>My <?= $customerTa['user_type'] == '11' ? 'Travel Consultant' : ($customerTa['user_type'] == '33' ? 'Branch Manager' : 'NA' ) ?></h2>

            <p>
                Your dedicated travel expert for all your travel needs.
            </p>

        </div>

        <!-- BODY -->
        <div class="qxz9-consultant-main-grid">

            <!-- LEFT SIDE -->
            <div class="qxz9-consultant-profile-card">

                <div class="qxz9-profile-top-section">

                    <div class="qxz9-profile-image">
                        <img src="<?= $home_url ?>uploading/<?= $customerTa['profile_pic'] ?>" alt="">
                    </div>

                    <div class="qxz9-profile-details">

                        <h3><?= $customerTa['firstname'] .' '. $customerTa['lastname']  ?></h3>

                        <span>
                            <?= $customerTa['user_type'] == '11' ? 'Travel Consultant' : ($customerTa['user_type'] == '33' ? 'Branch Manager' : 'NA' ) ?>
                        </span>

                        <!-- <div class="qxz9-rating-badge">
                            <i class="fa-solid fa-star"></i>
                            4.8 (120 Reviews)
                        </div> -->

                    </div>

                </div>

                <!-- CONTACT -->
                <div class="qxz9-contact-list">

                    <div class="qxz9-contact-item">
                        <i class="fa-solid fa-square-phone"></i>
                        <span>+<?= $customerTa['country_code'].' '. $customerTa['contact_no'] ?></span>
                    </div>

                    <div class="qxz9-contact-item">
                        <i class="fa-regular fa-envelope text-color"></i>
                        <span><?= $customerTa['email'] ?></span>
                    </div>

                    <div class="qxz9-contact-item">
                        <i class="fa-regular fa-clock text-color"></i>
                        <span>Mon - Sat (10:00 AM - 7:00 PM)</span>
                    </div>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="qxz9-consultant-benefit-card">

                <h3>
                    Why Connect with Your Consultant?
                </h3>

                <div class="qxz9-benefit-list">

                    <div class="qxz9-benefit-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Personalized travel recommendations</span>
                    </div>

                    <div class="qxz9-benefit-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Best deals and exclusive offers</span>
                    </div>

                    <div class="qxz9-benefit-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>24x7 support before, during & after your trip</span>
                    </div>

                    <div class="qxz9-benefit-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Hassle-free bookings and changes</span>
                    </div>

                </div>

                <!-- BUTTONS -->
                <div class="qxz9-action-btn-row">

                    <button class="qxz9-whatsapp-btn">
                        <i class="fa-brands fa-whatsapp"></i>
                        Chat on WhatsApp
                    </button>

                    <button class="qxz9-call-btn">
                        <i class="fa-regular fa-calendar text-color"></i>
                        Schedule a Call
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>