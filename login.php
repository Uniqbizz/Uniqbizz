<?php  
    include_once "connect.php";
    $date = date('Y');
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<!-- Mirrored from travelloo.vercel.app/template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:52:53 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <head>
        <script>
            const setTheme = (theme) => {
                theme ??= localStorage.theme || "light";
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
        <meta name="description" content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
        <meta name="keywords" content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
        <meta name="author" content="inittheme">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Multipurpose travel and tour booking">
        <meta property="og:site_name" content="Travello">
        <meta property="og:url" content="https://inittheme.com">
        <meta property="og:image" content="https://inittheme.com/images/selfie.jpg">
        <meta property="og:description" content="Multipurpose travel and tour booking, multipurpose template">
        <meta name="twitter:title" content="Multipurpose travel and tour booking">
        <meta name="twitter:description" content="Multipurpose travel and tour booking, multipurpose template">
        <meta name="twitter:image" content="https://twitter.com/inittheme/photo">
        <meta name="twitter:card" content="summary">
        <!-- Google site verification -->
        <meta name="google-site-verification" content="...">
        <meta name="facebook-domain-verification" content="...">
        <meta name="csrf-token" content="...">
        <meta name="currency" content="$">
        <!-- Title -->
        <title>Bizzmirth Holidays Pvt Ltd</title>
        <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
        <!-- Fonts & icon -->
        <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">
        <!-- Plugin -->
        <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
        <!-- Main CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
        <!-- RTL CSS::When Need RTL Uncomments File -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
        <style>
            .loginImage {
                width: 100% !important;
                height: 800px !important;
                object-fit: fill !important; 
                position: relative !important;
            }
            .loginCard {
                position: absolute !important;
                top: 250px !important;
                width: 100%;
            }
            .loginBackground{
                background:#fff !important;
                border-radius:30px !important;
                padding:30px !important;
                box-shadow:0 10px 30px rgba(0,0,0,.08) !important;
                justify-self: end !important;
            }
            .icon-circle{
                width:50px;
                height:50px;
                margin:auto;
                border-radius:50%;
                background:#f1f3f9;
                display:flex;
                align-items:center;
                justify-content:center;
            }
            .icon-circle i{
                font-size:28px;
                color:#5d6eff;
            }
            .customInput{
                border:1px solid #ddd;
            }
            .customInput .form-control{
                border:none;
                box-shadow:none;
            }
            .customInput .input-group-text{
                background:white;
                border:none;
            }
            .continueBtn{
                width:100%;
                border:none;
                padding:14px;
                background:#586BFF;
                color:white;
                border-radius:10px;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:15px;
                font-size:18px;
            }
            .emailBox{
                border:1px solid #ddd;
                padding:12px;
                display:flex;
                align-items:center;
                justify-content:space-between;
                border-radius:5px;
            }
            .profile-card{
                border:1px solid #ddd;
                padding:1px 10px;
                border-radius:5px;
                margin-bottom:10px;
                display:flex;
                justify-content:space-between;
                align-items:center;
                cursor:pointer;
            }
            .profile-card strong{
                display:block;
            }
            .profile-card small{
                color:#999;
            }
            .activeProfile{
                border:2px solid #586BFF;
                background:#f6f7ff;
            }
            .great-vibes-regular {
                font-family: "Great Vibes", cursive;
                font-weight: 400;
                font-size: 40px;
                font-style: normal;
                align-content: end;
            }
            .aeroplaneImage {
                width: 160px;
                height: 90px;
            }
            .text-blue {
                color: #1151ef !important;
            } 

            @media (max-width: 1142px) and (min-width: 992px){
                .loginBackground {
                    justify-self: center !important;
                    width: 90% !important;
                }
            }
            @media (max-width: 1024px) {
                .loginDetailsDisplay div {
                    width: 75% !important;
                }
            }
            @media (max-width: 992px) {
                .loginCard {
                    position: absolute !important;
                    top: 200px !important;
                    width: 100%;
                }
                .loginDetailsDisplay div {
                    width: 75% !important;
                }
            }
            @media (max-width: 767px) {
                .loginDetailsDisplay {
                    display: none !important;
                }
                .loginBackground {
                    justify-self: center !important;
                    width: 100% !important;
                }
            }
        </style>
    </head>
    <body>
        <?php include_once "header.php" ?>
        <main>
            <!-- Login area S t a r t  -->
            <div class="">
                <img src="assets/images/loginImage.png" alt="" class="loginImage">
                <div class="row d-flex justify-content-center loginCard ms-0">
                    <div class="col-xl-5 col-lg-5 col-md-4 align-content-center loginDetailsDisplay">
                        <div class="w-50">
                            <div class="d-flex gap-3">
                                <h1 class="text-normal text-white great-vibes-regular mb-0">Explore</h1>
                                <img src="assets/images/aeroplane.png" alt="" class="aeroplaneImage">
                            </div>
                            <h1 class="text-bolder text-white">The world with us</h1>
                            <p class="text-normal text-white fs-5">Amazing Destination, Exclusive Deals and Unforgettable Experiences</p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-7 col-sm-9 col-11">
                        <div class="login-card loginBackground w-75">
                            <!-- <form id="loginForm"> -->
                                <!-- STEP 1 -->
                                <div id="step1">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                        <h3 class="fw-bold mt-2">Enter Email</h3>
                                        <p class="text-muted">Login to continue your journey</p>
                                    </div>
                                    <label class="fw-bold mb-2">Enter your email ID</label>
                                    <div class="input-group customInput">
                                        <span class="input-group-text">
                                            <i class="ri-mail-line"></i>
                                        </span>
                                        <input type="email" class="form-control" id="emailInput" placeholder="Enter your email ID">
                                    </div>
                                    <button class="continueBtn mt-4" onclick="goToProfile()">
                                        Continue
                                        <i class="ri-arrow-right-line"></i>
                                    </button>
                                    <div class="d-flex w-100 gap-2">
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                        <p class="align-content-center">OR</p>
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                    </div>
                                    <div class="d-flex justify-content-center gap-2">
                                        <p class="text-black"><i class="ri-customer-service-2-fill me-2 fw-bolder"></i>Need help?</p>
                                        <a href="contact.php" class="text-blue">Contact Support</a>
                                    </div>
                                </div>

                                <!-- STEP 2 -->
                                <div id="step2" style="display:none">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle">
                                            <i class="ri-user-line"></i>
                                        </div>
                                        <h3 class="fw-bold mt-2">Select your Profile</h3>
                                        <p class="text-muted">
                                            Choose your profile you want to login as
                                        </p>
                                    </div>
                                    <div class="emailBox mb-3">
                                        <i class="ri-mail-line"></i>
                                        <span id="selectedEmail"></span>
                                        <a href="javascript:void(0)" onclick="backToEmail()">
                                            Change
                                        </a>
                                    </div>
                                    <label class="fw-bold mb-2">Select profile</label>
                                    <div id="profileContainer"></div>
                                    <!-- <div class="profile-card activeProfile" onclick="selectProfile(this,'Techno Enterprise','TE250111')">
                                        <div>
                                            <strong>Techno Enterprise</strong>
                                            <small>ID : TE25001</small>
                                        </div>
                                    </div>
                                    <div class="profile-card" onclick="selectProfile(this,'Travel Consultant','TC25001')">
                                        <div>
                                            <strong>Travel Consultant</strong>
                                            <small>ID : TC25001</small>
                                        </div>
                                    </div>
                                    <div class="profile-card" onclick="selectProfile(this,'Customer','CU25001')">
                                        <div>
                                            <strong>Customer</strong>
                                            <small>ID : CU25001</small>
                                        </div>
                                    </div> -->
                                    <button class="continueBtn mt-4" onclick="goToPassword()">
                                        Continue
                                        <i class="ri-arrow-right-line"></i>
                                    </button>
                                    <div class="d-flex w-100 gap-2">
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                        <p class="align-content-center">OR</p>
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                    </div>
                                    <div class="d-flex justify-content-center gap-2">
                                        <p class="text-black"><i class="ri-customer-service-2-fill me-2 fw-bolder"></i>Need help?</p>
                                        <a href="contact.php" class="text-blue">Contact Support</a>
                                    </div>
                                </div>

                                <!-- STEP 3 -->
                                <div id="step3" style="display:none">
                                    <div class="text-center mb-3">
                                        <div class="icon-circle">
                                            <i class="ri-lock-line"></i>
                                        </div>
                                        <h3 class="fw-bold mt-2">Enter your Password</h3>
                                        <p class="text-muted">
                                            Login to access your account
                                        </p>
                                    </div>
                                    <div class="emailBox mb-3">
                                        <i class="ri-mail-line"></i>
                                        <span id="finalEmail"></span>
                                        <a href="javascript:void(0)" onclick="backToEmail()">
                                            Change
                                        </a>
                                    </div>
                                    <div class="emailBox mb-3">
                                        <i class="ri-user-line"></i>
                                        <span id="finalProfile"></span>
                                        <a href="javascript:void(0)" onclick="backToProfile()">
                                            Change
                                        </a>
                                    </div>
                                    <label class="fw-bold mb-2">Password</label>
                                    <div class="input-group customInput">
                                        <span class="input-group-text">
                                            <i class="ri-lock-line"></i>
                                        </span>
                                        <input type="password" id="password" class="form-control" placeholder="Enter Password">
                                        <span class="input-group-text togglePassword" style="cursor:pointer;">
                                            <i class="ri-eye-line" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <input type="checkbox" id="rememberMe">
                                            Remember Me
                                        </div>
                                        <a href="#">Forgot Password</a>
                                    </div>
                                    <button id="loginBtn" class="continueBtn mt-4" onclick="userLogin()">
                                        Login
                                        <i class="ri-arrow-right-line"></i>
                                    </button>
                                    <div class="d-flex w-100 gap-2">
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                        <p class="align-content-center">OR</p>
                                        <hr class="border border-secondary border-2 opacity-50 w-50">
                                    </div>
                                    <div class="d-flex justify-content-center gap-2">
                                        <p class="text-black"><i class="ri-customer-service-2-fill me-2 fw-bolder"></i>Need help?</p>
                                        <a href="contact.php" class="text-blue">Contact Support</a>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End-of Login -->
        </main>

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
        <script src="login_data/login.js"></script>
        <script type="text/javascript" src="logout/logout.js"></script>
        <script>
            // let selectedProfile = "Techno Enterprise";
            // let selectedProfileId = "TE25001";

            // function goToProfile(){
            //     let email = $("#emailInput").val();
            //     if(email == ""){
            //         alert("Please enter email");
            //         return;
            //     }
            //     $("#selectedEmail").text(email);
            //     $("#step1").hide();
            //     $("#step2").fadeIn();
            // }

            // function selectProfile(card,name,id){
            //     $(".profile-card").removeClass("activeProfile");
            //     $(card).addClass("activeProfile");
            //     selectedProfile = name;
            //     selectedProfileId = id;
            // }

            // function goToPassword(){
            //     $("#finalEmail").text($("#emailInput").val());
            //     $("#finalProfile").text(
            //         selectedProfile + " (" + selectedProfileId + ")"
            //     );
            //     $("#step2").hide();
            //     $("#step3").fadeIn();
            // }
            let selectedProfile = "";
            let selectedProfileId = "";
            let selectedUserType = "";

            function goToProfile()
            {
                let email = $("#emailInput").val().trim();

                if(email === '')
                {
                    alert("Please enter email");
                    return;
                }

                $.ajax({
                    url: 'login_data/load_profiles.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: email
                    },
                    beforeSend: function()
                    {
                        $("#continueBtn").prop('disabled', true);
                    },
                    success: function(res)
                    {
                        $("#continueBtn").prop('disabled', false);

                        if(!res.status)
                        {
                            alert(res.message);
                            return;
                        }

                        let html = '';

                        $.each(res.profiles, function(index, profile){

                            html += `
                                <div
                                    class="profile-card ${index === 0 ? 'activeProfile' : ''}"
                                    onclick="selectProfile(
                                        this,
                                        '${String(profile.user_type_name).replace(/'/g,"\\'")}',
                                        '${profile.user_id}',
                                        '${profile.user_type_id}'
                                    )"
                                >

                                    <div>

                                        <strong>
                                            ${profile.user_type_name}
                                        </strong>

                                        <small>
                                            ID : ${profile.user_id}
                                        </small>

                                    </div>

                                </div>
                            `;
                        });

                        $("#profileContainer").html(html);

                        selectedProfile = res.profiles[0].user_type_name;
                        selectedProfileId = res.profiles[0].user_id;
                        selectedUserType = res.profiles[0].user_type_id;

                        $("#selectedEmail").text(email);

                        $("#step1").hide();
                        $("#step2").fadeIn();
                    },
                    error: function(xhr)
                    {
                        console.log(xhr.responseText);
                        alert("Something went wrong");
                        $("#continueBtn").prop('disabled', false);
                    }
                });
            }

            function selectProfile(card, name, id, userType)
            {
                $(".profile-card").removeClass("activeProfile");

                $(card).addClass("activeProfile");

                selectedProfile = name;
                selectedProfileId = id;
                selectedUserType = userType;
            }

            function goToPassword()
            {
                $("#finalEmail").text($("#emailInput").val());

                $("#finalProfile").text(
                    selectedProfile + " (" + selectedProfileId + ")"
                );

                $("#step2").hide();
                $("#step3").fadeIn();
            }

            function backToEmail(){
                $("#step2").hide();
                $("#step3").hide();
                $("#step1").fadeIn();
            }

            function backToProfile(){
                $("#step3").hide();
                $("#step2").fadeIn();
            }
            function userLogin()
            {
                let email = $("#emailInput").val().trim();
                var username    = email;
                var user_type   = selectedUserType;
                var password    = $('#password').val();
                var remember_me = $('#rememberMe').prop('checked');

                if(username == '')
                {
                    alert("Please select a profile");
                    return;
                }

                if(password == '')
                {
                    alert("Please enter password");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "login_data/submit_data.php",
                    data: {
                        username: username,
                        password: password,
                        user_type: user_type,
                        remember_me:remember_me
                    },
                    dataType: "json",
                    success: function(res)
                    {
                        console.log(res);

                        if(res.status == 1)
                        {
                            if (res.user_type == "10" &&
                                res.customer_type == "Neo Select")
                            {
                                location.href = "dashboard/customer_dashboard/customer_dashboard.php";
                            }
                            else if (res.user_type == "33" &&
                                    res.user_id == "IBRGA26004")
                            {
                                location.href = "dashboard/institute_branch_manager/index.php";
                            }
                            else if (res.user_type == "35")
                            {
                                location.href = "dashboard/super_techno_enterprise/super_techno_dashboard.php";
                            }else if (res.user_type == "34") {
                                location.href = "dashboard/executive_techno_enterprise/executive_techno_dashboard.php";
                            } 
                            else
                            {
                                location.href = "dashboard/index.php";
                            }
                        }
                        else
                        {
                            alert("Username and password not correct");
                        }
                    },
                    error: function(xhr)
                    {
                        console.log(xhr.responseText);
                    }
                });
            }
        </script>
        <script>
            $(document).on("click", ".togglePassword", function () {
                let passwordField = $("#password");
                let eyeIcon = $("#eyeIcon");
                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");

                    eyeIcon.removeClass("ri-eye-line");
                    eyeIcon.addClass("ri-eye-off-line");
                } else {
                    passwordField.attr("type", "password");

                    eyeIcon.removeClass("ri-eye-off-line");
                    eyeIcon.addClass("ri-eye-line");
                }
            });
        </script>
    </body>
</html>