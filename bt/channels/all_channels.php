<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../index";</script>';
}
$date = date('Y');
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from rn53themes.net/themes/demo/travelz/admin/user-all.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Apr 2021 08:21:19 GMT -->

<head>
    <title>Channels | Admin Dashboard</title>
    <!--== META TAGS ==-->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    == FAV ICON ==-->
    <!-- <link rel="shortcut icon" href="../images/fav.ico"> -->

    <!-- GOOGLE FONTS -->
    <!-- <link href="../../../../../fonts.googleapis.com/cssbcc5.css?family=Open+Sans:300,400,600|Quicksand:300,400,500" rel="stylesheet"> -->

    <!-- FONT-AWESOME ICON CSS -->
    <!-- <link rel="stylesheet" href="../css/font-awesome.min.css"> -->

    <!--== ALL CSS FILES ==-->
    <!--<link rel="stylesheet" href="../css/mob.css">
    <link rel="stylesheet" href="../css/bootstrap.css">-->
    <link rel="stylesheet" href="../assets/css/materialize.css" />
    <!-- <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styles2.css"> -->
    <link rel="stylesheet" href="../assets/css/level-accordian.css"> 
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- bootstrap-datepicker css -->
    <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="../assets/js/plugin.js"></script> -->

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* dataTable, action col, dropdown align right  */
        @media screen and (max-width: 992px) and (min-width: 914px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1256px) and (min-width: 1176px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1345px) and (min-width: 1264px) {
            .dropdown-menu-end-2[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }
    </style>

</head>

<body data-sidebar="dark">
    <!--== MAIN CONTRAINER ==-->
    <?php include '../sidebar.php'; ?>

    <!--== BODY CONTNAINER ==-->
    <!--       <div class="container-fluid sb2">
        <div class="row"> -->
    <?php include '../header.php'; ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Channels</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="search-box me-2 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <h4>Pending Customers List</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="text-dark fs-5"> Designation</label>
                                        <select id="designation" class="selectdesign">
                                            <option value="">--Select Designation--</option>
                                            <option value="bcm">Business Channel manager</option>
                                            <option value="bdm">Business Development manager</option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                            <option value="ca_travelagency">Travel Agent</option>
                                            <option value="ca_customer">Customer</option>
                                            <!-- <option value="business_trainee">Business Trainee</option> -->
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="text-dark fs-5">User ID & Name</label>
                                        <select id="user_id_name" class="selectdesign">
                                            <option value="">--Select Designation First--</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <!-- accordian starts -->
                                <div id="accordian_container">
                                    <span id="display-accordian"></span>
                                </div>
                                <!-- accordian ends -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $date; ?> © Uniqbizz.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by MirthCon.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- loading screen -->
    <div id="loading-overlay">
        <div class="loading-icon"></div>
    </div>
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->  

    <!-- <div class="sb2-2">
        <div class="sb2-2-2">
            <ul>
                <li><a href="../"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li class="active-bre"><a href="#"> Channels</a></li>
                <li class="page-back"><a href="../"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
            </ul>
        </div>
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>Channels</h4>
                        </div>
                        <div class="tab-inn">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label> Designation</label>
                                        <select id="designation" class="selectdesign">
                                            <option value="">--Select Designation--</option>
                                            <option value="travel_agent">Business Consultant</option>
                                            <option value="customer">Customer</option>
                                            <option value="business_trainee">Business Trainee</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label>User ID & Name</label>
                                        <select id="user_id_name" class="selectdesign">
                                            <option value="">--Select Designation First--</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                            <div class="row"> -->
                                <!-- accordian starts -->
                                <!-- <div id="accordian_container">
                                    <span id="display-accordian"></span>
                                </div> -->
                                <!-- accordian ends -->
                            <!--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!--======== SCRIPT FILES =========-->
    <!-- <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/custom.js"></script> -->
    <!-- JAVASCRIPT -->
    <script src="../assets/js/materialize.min.js"></script>
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <!-- bootstrap-datepicker js -->
    <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- ecommerce-customer-list init -->
    <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <!-- <script type="text/javascript" src="../payout/forms/payout_details.js"></script> -->

    <script>
        var mybutton = document.getElementById("back-to-top");
        function scrollFunction() {
            100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
        }
        function topFunction() {
            document.body.scrollTop = 0,
            document.documentElement.scrollTop = 0
        }
        mybutton && (window.onscroll = function() {
            scrollFunction()
        }
        );

    </script>
    <script type="text/javascript">
        //accordian
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }

        //to close accordian
        function closeBtn() {
            document.getElementById("display-accordian").style.display = "none";
        }

        var designation = '';
        var user_id = '';

        // get Users
        $('#designation').on('change', function() {
            designation = $('#designation').val();
            document.getElementById("display-accordian").style.display = "none";

            $.ajax({
                type: 'POST',
                url: '../payout/forms/get_users',
                data: "designation=" + designation,
                success: function(e) {
                    // console.log(e);
                    $('.user_row').remove();
                    if (e == "no_users") {
                        alert("No Users Found !!");
                        $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No Records Found</td></tr>');
                    } else {
                        $('#user_id_name').html(e);
                        $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No User Selected</td></tr>');
                    }
                },
                error: function(err) {
                    console.log(err);
                },
            });
        });

        //get levels
        $('#user_id_name').on('change', function() {
            designation = $('#designation').val();
            var user_type='';
            if (designation == 'bcm'){
                user_type=24;
            }
            if (designation == 'bdm'){
                user_type=25;
            }
            if (designation == 'business_mentor'){
                user_type=26;
            }
            if (designation == 'corporate_agency'){
                user_type=16;
            }
            if (designation == 'ca_travelagency'){
                user_type=11;
            }
            if (designation == 'ca_customer'){
                user_type=10;
            }
            user_id = $('#user_id_name').val();
            console.log(user_id);

            $.ajax({
                type: 'POST',
                url: 'get_channels',
                data: {
                    user_id: user_id,
                    user_role: designation,
                    user_type:user_type
                },
                success: function(res) {
                    $("#accordian_container").html(res);
                },
                error: function(err) {
                    console.log(err);
                },
            });
            
        });

        //-------------------- accordian start --------------------
        function showPannel(e) {
            // console.log(e);
            var accordian = e;
            accordian.classList.toggle("active");

            var panel = e.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }

        // close accordian
        function closeBtn() {
            document.getElementById("display-accordian").style.display = "none";
        }
        // makes tr elements active on select
        function selectedRow() {
            var index,
                table = document.getElementById("userTable");

            for (var i = 1; i < table.rows.length; i++) {
                table.rows[i].onclick = function() {
                    // remove the background from the previous selected row
                    if (typeof index !== "undefined") {
                        table.rows[index].classList.toggle("selected");
                    }
                    index = this.rowIndex; // get the selected row index
                    this.classList.toggle("selected"); // add class selected to the row
                    // console.log(typeof index);

                    // get referrals customer ID
                    var cell_month = this.getElementsByTagName("td")[0];
                    var cell_year = this.getElementsByTagName("td")[1];
                    var month = cell_month.innerHTML;
                    var year = cell_year.innerHTML;

                    // set data
                    var data = {
                        beneficiary: beneficiary,
                        user_id: user_id
                    }
                    data.dataType = 'accordian_list';
                    data.business_scheme_name_id = month;
                    data.userType = year;

                    // get accordian data
                    // $.ajax({
                    //     type: "POST",
                    //     url: "forms/get_data",
                    //     data: JSON.stringify(data),
                    //     success: function (res) {
                    //         $("#accordian_container").html(res);
                    //     },
                    // });
                }
            }
        }
        //-------------------- accordian end --------------------
    </script>
</body>


<!-- Mirrored from rn53themes.net/themes/demo/travelz/admin/user-all.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Apr 2021 08:21:20 GMT -->

</html>