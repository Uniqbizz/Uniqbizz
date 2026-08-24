

<!DOCTYPE html>
<html lang="zxx" dir="lrt">

    <!-- Mirrored from travelloo.vercel.app/template/tour-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:53:04 GMT -->
    <!-- Added by HTTrack -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

    <head>
        <!-- <script>
        const setTheme = (theme) => {
            theme ?? = localStorage.theme || "light";
            document.documentElement.dataset.theme = theme;
            localStorage.theme = theme;
        };
        setTheme();
        </script> -->

        <script>
            const setTheme = (theme) => {
                // If theme is undefined or null, set it to localStorage.theme or "light"
                theme = theme || localStorage.theme || "light";
                document.documentElement.dataset.theme = theme;
                localStorage.theme = theme;
            };
            setTheme();
        </script>
        <meta logo="assets/images/logo/logo.png">
        <meta white-logo="assets/images/logo/logo-white.png">

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description"
            content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
        <meta name="keywords"
            content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
        <meta name="author" content="inittheme">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- added code for share model start 30-07-2026-->
        <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
        <meta property="og:url" content="<?php echo htmlspecialchars($url); ?>">
        <meta property="og:image" content="<?php echo htmlspecialchars($image); ?>">
        <meta property="og:site_name" content="<?php echo htmlspecialchars($siteName); ?>">
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
        <meta name="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
        <meta name="twitter:image" content="<?php echo htmlspecialchars($image); ?>">
        <!-- added code for share model  end-->

        <!-- Title -->
        <title>Bizzmirth Holidays Pvt Ltd</title>
        <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
        <!-- Fonts & icon -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css"> -->
        <!-- Plugin -->
        <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
        <!-- Main CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
        <!-- Tour Details CSS 18/7/2026 -->
        <link rel="stylesheet" type="text/css" href="assets/css/tour-details.css">
        <!-- share model css file 30-07-2026 -->
        <link rel="stylesheet" type="text/css" href="assets/css/tour_details_share.css">
        <!-- User Profile CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/user-profile.css">
        <!-- Request Details CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/request-details.css">
        <!-- RTL CSS::When Need RTL Uncomments File -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
        <!-- Swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    
    <body>
        <?php include_once "header.php" ?>
        <main>
            <!-- Breadcrumbs S t a r t -->
            <div class="container">
                <nav aria-label="breadcrumb" class="mt-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php //echo $package['name'] ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <!--/ End-of Breadcrumbs-->
            <!-- Request Details Page Start -->
            <section>
                <div class="request-details-container">
                    <div class="container">
                        <div class="title-section mb-3">
                            <div>
                                <h3 class="fw-bolder" id="pack_name">Request Best Quote</h3>
                                <p class="fw-bolder text-black" id="pack_name">Varanasi A Spiritual Journey Awaits</p>
                            </div>
                            <div class="d-flex gap-4">
                                <div class="openShare" onclick="openShare()">
                                    <i class="ri-share-line"></i>
                                </div>
                                <div class="wishlist-icon">
                                    <i class="ri-heart-line"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 1 -->
                        <div class="row">
                            <div class="col-xl-8 col-lg-9 mb-3">
                                <div class="card cardShadow">
                                    <div class="d-flex tabDisplayBlock">
                                        <div>
                                            <img src="assets/images/package/package-7.jpg" alt="" class="requestQuotePackageImg">
                                        </div>
                                        <div class="p-3 widthStretch">
                                            <p class="fw-bolder text-black mb-1 fs-5" id="pack_name">Varanasi A Spiritual Journey Awaits</p>
                                            <div class="d-flex justify-content-between mobileDisplayBlock">
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-map-pin-line destination-title fs-6"></i>
                                                    Varanasi, Uttar Pradesh
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-time-line destination-title fs-6"></i>
                                                    4 Nights / 5 Days
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-restaurant-line destination-title fs-6"></i>
                                                    Meals: Breakfast & Dinner
                                                </p>
                                            </div>
                                            <p class="fontSize10 mb-3">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. At inventore adipisci, fugiat 
                                                sunt nemo quidem hic reiciendis! Neque velit sint maiores facilis iste quas iure vero, 
                                                deleniti culpa, alias iusto?
                                            </p>
                                            <div class="p-2 priceGreenBtn">
                                                <p class="text-center">Starting from <span class="priceTextGreen">&#8377;13,754 /-</span> per adult</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Traveller & Trip Details -->
                                <div class="card cardShadow p-3 mt-3">
                                    <div class="d-flex gap-2 mb-3">
                                        <p class="travellerTittleNum">1</p>
                                        <h5 class="mb-0 fw-bold">Traveller & Trip Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="travelStartDate" class="form-label fontSize10">Travel Start Date</label>
                                                <input type="date" class="form-control fontSize10" id="travelStartDate">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="travelEndDate" class="form-label fontSize10">Travel End Date</label>
                                                <input type="date" class="form-control fontSize10" id="travelEndDate">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="dayInput" class="form-label fontSize10">Nights / Days</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-moon-line iconPosition iconRed"></i>
                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Default select example">
                                                        <option selected>Select Days</option>
                                                        <option value="1">4 Nights / 5 Days</option>
                                                        <option value="2">2 Nights / 3 Days</option>
                                                        <option value="3">5Nights / 6 Days</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="pickupLocation" class="fontSize10 form-label">Pickup</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-map-pin-line iconPosition iconRed"></i>
                                                    <input type="email" class="fontSize10 form-control paddingLeft" id="pickupLocation" placeholder="Varanasi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="dropLocation" class="fontSize10 form-label">Drop</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-map-pin-line iconPosition iconRed"></i>
                                                    <input type="email" class="fontSize10 form-control paddingLeft" id="dropLocation" placeholder="Mumbai">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Adults (12+ yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" name="adults" class="counter-value" value="2" min="1">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Children (2-11 yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" name="children" class="counter-value" value="0" min="0">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Infants (0-1 yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" name="infants" class="counter-value" value="0" min="0">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card cardRoom mt-3 p-3">
                                        <p class="fontSize10 fw-bold">Room 1</p>
                                        <div class="row">
                                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                                                <div class="d-flex justify-content-between mobileDisplayBlock">
                                                    <div>
                                                        <p class="fontSize10 fw-bold"><i class="ri-hotel-bed-fill destination-title fs-6"></i> 1 Double Bed + 1 Extra Mattress</p>
                                                        <p class="fontSize10">3 Pax will be accommendated in 1 room with extra mattress.</p>
                                                    </div>
                                                    <div class="py-1 px-2 text-center text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 recommendedBtn fw-bold fontSize10">
                                                        Recommended
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                                                <button class="btn modifyBtn" type="submit">Modify Rooms</button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn addRoomBtn" type="submit">Add Room (If more travellers)</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Preferences Details -->
                                <div class="card cardShadow p-3 mt-3">
                                    <div class="d-flex gap-2 mb-3">
                                        <p class="travellerTittleNum">2</p>
                                        <h5 class="mb-0 fw-bold">Preferences (Optional)</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="hotelCategory" class="form-label fontSize10">Hotel Category</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-hotel-line iconPosition iconRed"></i>
                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Default select example">
                                                        <option selected>Select Hotel</option>
                                                        <option value="1">5 Star</option>
                                                        <option value="2">4 Star</option>
                                                        <option value="3">3 Star</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="mealPreference" class="form-label fontSize10">Meal Preference</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-restaurant-line iconPosition iconRed"></i>
                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Default select example">
                                                        <option selected>Select Meal</option>
                                                        <option value="1">Breakfast & Dinner</option>
                                                        <option value="2">Dinner</option>
                                                        <option value="3">Breakfast</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="transportPreference" class="form-label fontSize10">Transport Preference</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-car-line iconPosition iconRed"></i>
                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Default select example">
                                                        <option selected>Select Vehicle</option>
                                                        <option value="1">AC Vehicle</option>
                                                        <option value="2">Non Ac Vehicle</option>
                                                        <option value="3">Bus</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="mb-0">
                                                <label for="specialRequirement" class="form-label fontSize10">Special Requirements (Optional)</label>
                                                <textarea class="form-control fontSize10" id="specialRequirement" placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pricing Section -->
                            <div class="col-xl-4 col-lg-3 mb-3 pricing-sidebar" id="pricingSidebar">
                                <div class="card cardShadow">
                                    <div class="pricing-header">
                                        <h5 class="fw-bold mb-0">Package Price Calculation</h5>
                                        <button type="button" class="pricing-close-btn" id="closePricing">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Base Price (Per Person)</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Adult (12+ yrs)</p>
                                                <p class="fontSize10">Child (5-11 yrs)</p>
                                                <p class="fontSize10">Infant (0-4 yrs)</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">&#8377; 13,754</p>
                                                <p class="fontSize10 text-end">&#8377; 11,004</p>
                                                <p class="fontSize10 text-end">FREE</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Price Based on Travelers</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Adult: <span class="">2 x &#8377; 13,754</span></p>
                                                <p class="fontSize10">Children: <span class="">1 x &#8377; 11,004</span></p>
                                                <p class="fontSize10">Infant: <span class="">0 x FREE</span></p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">&#8377; 27,508</p>
                                                <p class="fontSize10 text-end">&#8377; 11,004</p>
                                                <p class="fontSize10 text-end">&#8377; 0</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold">Subtotal</p>
                                            <p class="fontSize13 fw-bold">&#8377; 38,512</p>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Room & Extra Mattress</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Room 1 (1 Double Bed)</p>
                                                <p class="fontSize10">Extra Mattress (1) x &#8377; 1,500</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">Included</p>
                                                <p class="fontSize10 text-end">&#8377; 1,500</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Transport</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">4 Seater AC Vehicle (For 3 Pax)</p>
                                                <a href="#" class="fontSize10 text-primary">Change Vehicle</a>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">Included</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Other Charges</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Convenience Fee</p>
                                                <p class="fontSize10">GST (18%)</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">&#8377; 499</p>
                                                <p class="fontSize10 text-end">&#8377; 7,840</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3 pb-0">
                                        <p class="fontSize10 fw-bold mb-2">Apply Coupons <span class="text-muted fw-normal">(One coupon per passanger) <i class="ri-error-warning-line"></i></span></p>
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="d-flex gap-3 largeDisplay">
                                                <p class="fontSize10 align-content-end">Adult 1</p>
                                                <p>
                                                    <select class="form-select fontSize10 selectPadding" aria-label="Default select example">
                                                        <option selected>Select </option>
                                                        <option value="1">Rs-3000</option>
                                                        <option value="2">Rs-3000</option>
                                                        <option value="3">Rs-1500</option>
                                                    </select>
                                                </p>
                                            </div>
                                            <p class="fontSize10 discountGreen fw-bold text-end align-content-end">- &#8377; 3,000</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="d-flex gap-3 largeDisplay">
                                                <p class="fontSize10 align-content-end">Adult 2</p>
                                                <p>
                                                    <select class="form-select fontSize10 selectPadding" aria-label="Default select example">
                                                        <option selected>Select </option>
                                                        <option value="1">Rs-3000</option>
                                                        <option value="2">Rs-3000</option>
                                                        <option value="3">Rs-1500</option>
                                                    </select>
                                                </p>
                                            </div>
                                            <p class="fontSize10 discountGreen fw-bold text-end align-content-end">- &#8377; 3,000</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="d-flex gap-3 largeDisplay">
                                                <p class="fontSize10 align-content-end">Child 1</p>
                                                <p>
                                                    <select class="form-select fontSize10 selectPadding" aria-label="Default select example">
                                                        <option selected>Select </option>
                                                        <option value="1">Rs-3000</option>
                                                        <option value="2">Rs-3000</option>
                                                        <option value="3">Rs-1500</option>
                                                    </select>
                                                </p>
                                            </div>
                                            <p class="fontSize10 discountGreen fw-bold text-end align-content-end">- &#8377; 1,500</p>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="d-flex justify-content-between px-3">
                                        <p class="fontSize10 discountGreen fw-bold">Discounts (Coupons)</p>
                                        <p class="fontSize10 discountGreen fw-bold text-end">- &#8377; 7,500</p>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fs-6">Total Estimated Price</p>
                                                <p class="fontSize10">Per Person</p>
                                            </div>
                                            <div>
                                                <p class="fs-5 text-danger fw-bolder text-end">&#8377; 40,851</p>
                                                <p class="fontSize10 text-end">&#8377; 13,617</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Request Details Page End -->
            <button id="openPricingBtn" class="floating-price-btn">
                <p class="fs-6 text-white fw-bold">Total Estimated Price:</p>
                <p class="fs-6 text-white fw-bold">&#8377; 40,851 /-</p>
            </button>

            <div class="pricing-overlay" id="pricingOverlay"></div>
        </main>
        
        <!-- share model 30-07-2026 start-->
        <div class="overlay" id="shareModal">
            <div class="shareBox">
                <div class="header">
                    <h2>Share this page</h2>
                    <div class="close" onclick="closeShare()">
                        ×
                    </div>
                </div>
                <div class="icons">

                    <a class="social" target="_blank"  href="https://wa.me/?text=<?php echo urlencode("🎬 ".$title."\n\n".$description."\n\n".$url); ?>">
                        <div class="shareIcon">
                            <svg xmlns="http://w3.org" viewBox="0 0 448 512" width="60" height="60" fill="#25D366" class="social">
                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                            </svg>
                        </div>
                        <span>WhatsApp</span>
                    </a>

                    <a class="social" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>">
                        <div class="shareIcon">
                            <svg xmlns="http://w3.org" viewBox="0 0 512 512" width="60" height="60" fill="#1877F2">
                                <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.8 90.7 226.4 209.3 245V327.7h-63V256h63v-54.6c0-62.2 37-96.5 93.7-96.5 27.1 0 55.5 4.8 55.5 4.8v61h-31.3c-30.8 0-40.4 19.1-40.4 38.7V256h68.8l-11 71.7h-57.8V501C413.3 482.4 504 379.8 504 256z"/>
                            </svg>

                        </div>
                        <span>Facebook</span>
                    </a>

                    <a class="social" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($title); ?>&url=<?php echo urlencode($url); ?>">
                        <div class="shareIcon">
                            <svg xmlns="http://w3.org" viewBox="0 0 512 512" width="60" height="60" fill="#000000">
                                <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                            </svg>
                        </div>
                        <span>X</span>
                    </a>

                    <a class="social" target="_blank" href="https://t.me/share/url?url=<?php echo urlencode($url); ?>&text=<?php echo urlencode($title."\n".$description); ?>">
                        <div class="shareIcon">
                            <svg xmlns="http://w3.org" viewBox="0 0 496 512" width="60" height="60" fill="#24A1DE">
                                <path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 18.3z"/>
                            </svg>
                        </div>
                        <span>Telegram</span>
                    </a>

                    <a class="social" href="mailto:?subject=<?php echo urlencode($title); ?>&body=<?php echo urlencode($description."\n\n".$url); ?>">
                        <div class="shareIcon">
                            <svg xmlns="http://w3.org" viewBox="0 0 512 512" width="60" height="60" fill="#e03d42">
                                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                            </svg>
                        </div>
                        <span>Email</span>
                    </a>

                </div>
                <div class="line"></div>
                    <div class="linkArea">
                        <input id="shareLink" readonly value="<?php echo htmlspecialchars($url); ?>">
                        <button class="copy" onclick="copyLink()">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="toast">
            ✓ Link copied
        </div>
        <!-- share model 30-07-2026 end-->

        <!-- Footer S t a r t -->
        <?php include_once "footer.php" ?>
        <!--/ End-of Footer -->

        <!-- Scroll Up  -->
        <div class="progressParent" id="back-top">
            <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- Add an search-overlay element -->
        <div class="search-overlay"></div>
        <!-- jquery-->
        <script src="assets/js/jquery-3.7.0.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap-5.3.0.min.js"></script>
        <!-- Plugin -->
        <script src="assets/js/plugin.js"></script>
        <!-- Main js-->
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="logout/logout.js"></script>

        <!-- New Design 17/7/26 -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            new Swiper(".myGallery", {
                slidesPerView: 1,
                spaceBetween: 15,
                loop: true,

                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const thumbnails = document.querySelectorAll(".thumbnail");
                const mainImage = document.getElementById("mainImage");

                if (!thumbnails.length || !mainImage) return;

                let currentIndex = 0;

                function updateGallery(index) {

                    currentIndex = index;

                    mainImage.src = thumbnails[index].src;

                    thumbnails.forEach(item => {
                        item.classList.remove("active-thumb");
                    });

                    thumbnails[index].classList.add("active-thumb");
                }

                thumbnails.forEach((thumb, index) => {

                    thumb.addEventListener("click", function () {
                        updateGallery(index);
                    });

                });

                document.querySelector(".gallery-next")?.addEventListener("click", function () {

                    currentIndex++;

                    if (currentIndex >= thumbnails.length) {
                        currentIndex = 0;
                    }

                    updateGallery(currentIndex);
                });

                document.querySelector(".gallery-prev")?.addEventListener("click", function () {

                    currentIndex--;

                    if (currentIndex < 0) {
                        currentIndex = thumbnails.length - 1;
                    }

                    updateGallery(currentIndex);
                });

            });
        </script>
        <script>
            $(document).ready(function () {

                const $nav = $(".borderColor1");
                const $placeholder = $(".nav-placeholder");
                const $content = $(".content-sections");

                let navTop = $nav.offset().top;

                function updateStickyNav() {
                    if ($(window).width() < 992) {
                        $placeholder.hide();
                        $nav.removeClass("nav-fixed").css("width", "");
                        return;
                    }

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;

                    const contentTop = $content.offset().top;
                    const contentBottom = contentTop + $content.outerHeight();

                    const scrollTop = $(window).scrollTop();

                    if (
                        scrollTop >= navTop - headerHeight &&
                        scrollTop < contentBottom - headerHeight - $nav.outerHeight()
                    ) {

                        $placeholder.show();

                        $nav.addClass("nav-fixed");

                        $nav.css({
                            width: $(".col-xl-8").width() + "px"
                        });

                    } else {

                        $placeholder.hide();

                        $nav.removeClass("nav-fixed");

                        $nav.css("width", "");

                    }
                }

                function updatePricingSticky() {

                    const $pricing = $(".pricingSection");
                    const $wrapper = $(".pricing-wrapper");

                    if ($(window).width() < 992) {
                        $pricing
                            .removeClass("pricing-fixed pricing-bottom")
                            .css({
                                width: "",
                                top: "",
                                left: ""
                            });
                        return;
                    }

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $(".borderColor1").outerHeight() || 76;

                    const fixedTop = 90;

                    const pricingHeight = $pricing.outerHeight();

                    const startSticky =
                        $(".sticky-nav-wrapper").offset().top - headerHeight;

                    const contentBottom =
                        $(".content-sections").offset().top +
                        $(".content-sections").outerHeight();

                    const stopSticky =
                        contentBottom -
                        pricingHeight -
                        fixedTop;

                    const scrollTop = $(window).scrollTop();
                    const pricingWidth = $pricing[0].getBoundingClientRect().width;

                    // Before sticky
                    if (scrollTop < startSticky) {

                        $pricing
                            .removeClass("pricing-fixed pricing-bottom")
                            .css({
                                width: "",
                                top: "",
                                left: ""
                            });
                    }

                    // Sticky state
                    else if (scrollTop < stopSticky) {

                        $pricing
                            .removeClass("pricing-bottom")
                            .addClass("pricing-fixed")
                            .css({
                                top: "90px",
                                left: $wrapper.offset().left + "px",
                                width: pricingWidth + "px"
                            });
                    }

                    // Stop at bottom of left content
                    else {

                        const absoluteTop =
                            contentBottom -
                            $wrapper.offset().top -
                            pricingHeight;

                        $pricing
                            .removeClass("pricing-fixed")
                            .addClass("pricing-bottom")
                            .css({
                                top: absoluteTop + "px",
                                width: "96%",
                                left: ""
                            });
                    }
                }

                updateStickyNav();
                updatePricingSticky();

                $(window).on("scroll resize", function () {

                    updateStickyNav();
                    updatePricingSticky();

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $nav.outerHeight() || 76;

                    let scrollPos =
                        $(window).scrollTop() +
                        headerHeight +
                        navHeight +
                        50;

                    $(".section-block").each(function () {

                        let top = $(this).offset().top;
                        let bottom = top + $(this).outerHeight();
                        let id = $(this).attr("id");

                        if (scrollPos >= top && scrollPos < bottom) {

                            $(".nav-link").removeClass("active");

                            $('.nav-link[href="#' + id + '"]').addClass("active");
                        }
                    });

                });

                $(".nav-link").on("click", function (e) {

                    e.preventDefault();

                    $(".nav-link").removeClass("active");
                    $(this).addClass("active");

                    const target = $(this).attr("href");

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $nav.outerHeight() || 76;

                    $("html, body").animate({
                        scrollTop:
                            $(target).offset().top -
                            headerHeight -
                            navHeight +
                            20
                    }, 500);

                });

            });
        </script>
        <script>
            $(document).ready(function () {

                $(".faq-header").click(function () {

                    const currentItem = $(this).closest(".faq-item");

                    $(".faq-item").not(currentItem).removeClass("active");

                    $(".faq-item").not(currentItem)
                        .find(".faq-icon")
                        .removeClass("ri-eye-line")
                        .addClass("ri-eye-off-line");

                    currentItem.toggleClass("active");

                    if (currentItem.hasClass("active")) {

                        currentItem.find(".faq-icon")
                            .removeClass("ri-eye-off-line")
                            .addClass("ri-eye-line");

                    } else {

                        currentItem.find(".faq-icon")
                            .removeClass("ri-eye-line")
                            .addClass("ri-eye-off-line");
                    }
                });

            });
        </script>
        <script>
            // const packages = [
            //     {
            //         title: "Phuket Getaway",
            //         duration: "4 Nights / 5 Days",
            //         price: "22,999",
            //         image: "assets/images/package/package-11.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Bali Bliss",
            //         duration: "5 Nights / 6 Days",
            //         price: "28,999",
            //         image: "assets/images/package/package-2.png",
            //         link: "#"
            //     },
            //     {
            //         title: "Singapore Explorer",
            //         duration: "4 Nights / 5 Days",
            //         price: "39,999",
            //         image: "assets/images/package/package-3.png",
            //         link: "#"
            //     },
            //     {
            //         title: "Dubai Dazzle",
            //         duration: "5 Nights / 6 Days",
            //         price: "42,999",
            //         image: "assets/images/package/package-4.png",
            //         link: "#"
            //     },
            //     {
            //         title: "Thailand Escape",
            //         duration: "5 Nights / 6 Days",
            //         price: "24,999",
            //         image: "assets/images/package/package-5.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Maldives Luxury",
            //         duration: "4 Nights / 5 Days",
            //         price: "55,999",
            //         image: "assets/images/package/package-6.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Vietnam Discovery",
            //         duration: "6 Nights / 7 Days",
            //         price: "34,999",
            //         image: "assets/images/package/package-7.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Japan Highlights",
            //         duration: "7 Nights / 8 Days",
            //         price: "89,999",
            //         image: "assets/images/package/package-8.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Europe Delight",
            //         duration: "8 Nights / 9 Days",
            //         price: "1,19,999",
            //         image: "assets/images/package/package-9.jpg",
            //         link: "#"
            //     },
            //     {
            //         title: "Swiss Adventure",
            //         duration: "6 Nights / 7 Days",
            //         price: "99,999",
            //         image: "assets/images/package/package-10.jpg",
            //         link: "#"
            //     }
            // ];
            const packages = <?= json_encode(
                $package_array,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            ) ?>;
            // console.log(packages);
            
            const track = document.getElementById("packageTrack");

            packages.forEach(pkg => {
                track.innerHTML += `
                    <div class="package-item">
                        <a href="${pkg.link}" class="text-decoration-none">
                            <div class="package-card">
                                <img src="${pkg.image}" alt="${pkg.title}">
                                <div class="package-body">
                                    <h5>${pkg.title}</h5>
                                    <p>${pkg.duration}</p>
                                    <div class="package-price">
                                        ₹${pkg.price} <span>/ Person</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            });


            let currentIndex = 0;


            function getVisibleCards() {

                if (window.innerWidth < 576) {
                    return 1;
                }

                if (window.innerWidth < 992) {
                    return 2;
                }

                return 4;
            }


            function moveSlider() {

                const card = track.querySelector(".package-item");

                if (!card) return;

                const gap = parseInt(
                    getComputedStyle(track).gap
                ) || 20;

                const cardWidth = card.offsetWidth + gap;

                const visibleCards = getVisibleCards();

                const maxIndex = Math.max(
                    0,
                    packages.length - visibleCards
                );

                // Prevent going beyond the last card
                currentIndex = Math.min(
                    currentIndex,
                    maxIndex
                );

                track.style.transform =
                    `translateX(-${currentIndex * cardWidth}px)`;
            }


            // NEXT
            document.querySelector(".next-btn").addEventListener("click", function () {
                // console.log('clicked next');
                
                const visibleCards = getVisibleCards();

                const maxIndex = Math.max(
                    0,
                    packages.length - visibleCards
                );

                if (currentIndex < maxIndex) {

                    currentIndex++;

                    moveSlider();
                }
            });


            // PREVIOUS
            document.querySelector(".prev-btn").addEventListener("click", function () {
                // console.log('clicked prev');
                if (currentIndex > 0) {

                    currentIndex--;

                    moveSlider();
                }
            });


            // Resize
            window.addEventListener("resize", function () {

                updateSliderControls();

            });
            function updateSliderControls() {

                const visibleCards = getVisibleCards();

                const prevBtn = document.querySelector(".prev-btn");
                const nextBtn = document.querySelector(".next-btn");

                if (packages.length <= visibleCards) {

                    prevBtn.style.display = "none";
                    nextBtn.style.display = "none";

                    // Reset slider position
                    currentIndex = 0;
                    track.style.transform = "translateX(0)";

                } else {

                    prevBtn.style.display = "flex";
                    nextBtn.style.display = "flex";

                    moveSlider();
                }
            }
        </script>
        <!-- New Design 1/8/26 -->

        <!-- share option js 30-07-2026 -->
        <script>

            const modal = document.getElementById("shareModal");
            const link = document.getElementById("shareLink");
            const toast = document.getElementById("toast");

            let timer;

            function openShare(){
                modal.style.display="flex";
                setTimeout(()=>{
                    link.focus();
                    link.select();
                },200);
            }

            function closeShare(){
                modal.style.display="none";
                toast.classList.remove("show");
            }

            function copyLink(){
                navigator.clipboard.writeText(link.value)
                .then(()=>{
                    showToast();
                })

                .catch(()=>{
                    link.select();
                    document.execCommand("copy");
                    showToast();
                });
            }

            function showToast(){
                toast.classList.add("show");
                clearTimeout(timer);
                timer = setTimeout(()=>{
                    toast.classList.remove("show");
                },2500);
            }

            window.onclick = function(e){
                if(e.target===modal){
                    closeShare();
                }
            }

            document.addEventListener("keydown", function(e){
                if(e.key==="Escape"){
                    closeShare();
                }
            });

            let visibleFaqs = 3;

            $("#viewMoreFaq").on("click", function () {

                let hiddenFaqs = $(".faq-item").filter(function () {
                    return $(this).css("display") === "none";
                });

                if (hiddenFaqs.length > 0) {

                    hiddenFaqs.slideDown();

                    $(this).text("View Less");

                } else {

                    $(".faq-item").each(function(index) {

                        if (index >= 3) {
                            $(this).slideUp();
                        }

                    });

                    $(this).text("View More");

                }

            });
        </script>
        <!-- Request Details Age Incrementer And Decrementer Start -->
        <script>
            document.querySelectorAll('.guest-counter').forEach(counter => {
                const minusBtn = counter.querySelector('.minus');
                const plusBtn = counter.querySelector('.plus');
                const input = counter.querySelector('.counter-value');

                minusBtn.addEventListener('click', () => {
                    let value = parseInt(input.value) || 0;

                    // Adults minimum 1, Children/Infants minimum 0
                    const minValue = counter.querySelector('.guest-label')
                        .textContent.includes('Adults') ? 1 : 0;

                    if (value > minValue) {
                        input.value = value - 1;
                    }
                });

                plusBtn.addEventListener('click', () => {
                    let value = parseInt(input.value) || 0;
                    input.value = value + 1;
                });
            });
        </script>
        <!-- Pricing Section -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const pricingSidebar = document.getElementById("pricingSidebar");
                const openBtn = document.getElementById("openPricingBtn");
                const closeBtn = document.getElementById("closePricing");
                const overlay = document.getElementById("pricingOverlay");

                function openPricing() {
                    pricingSidebar.classList.add("show");
                    overlay.classList.add("show");
                    document.body.style.overflow = "hidden";
                }

                function closePricing() {
                    pricingSidebar.classList.remove("show");
                    overlay.classList.remove("show");
                    document.body.style.overflow = "";
                }

                openBtn.addEventListener("click", openPricing);

                closeBtn.addEventListener("click", closePricing);

                overlay.addEventListener("click", closePricing);

                window.addEventListener("resize", function () {
                    if (window.innerWidth > 991) {
                        closePricing();
                    }
                });

            });
        </script>
        <!-- Request Details Age Incrementer And Decrementer End -->
    </body>

</html>