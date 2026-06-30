<?php
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');
    include (__DIR__ .'/customer_model.php');
    include (__DIR__ .'/customer_mapping.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard | Customer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- font-awesome -->
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/customer_dashboard.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once(__DIR__ . '/customer_header.php');
            ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->
            <?php
                include_once(__DIR__ . '/customer_sidebar.php');
            ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Refer & Earn</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?= $base_url_cust ?>customer_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Refer & Earn</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <!-- Card section 1 -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon1">
                                                <i class="fa-solid fa-user fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Total Referrals</p>
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-0 fs-5 fw-bolder" id="total_cu">0</p>
                                                <p class="mb-0"><i class="fa-solid fa-user-group fa-lg" style="color: #35239a;"></i></p>
                                            </div>
                                            <p class="mb-0 text-muted fs-6">All time</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon2">
                                                <i class="fa-solid fa-clock fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Pending Referrals</p>
                                            <p class="mb-0 fs-5 fw-bolder" id="pending_cu">0</p>
                                            <p class="mb-0 text-muted fs-6">Awaiting registration</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon3">
                                                <i class="fa-solid fa-user-check fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Registered Referrals</p>
                                            <p class="mb-0 fs-5 fw-bolder" id="registered_cu">0</p>
                                            <p class="mb-0 text-muted fs-6">Successfully joined</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 align-content-center">
                                            <div class="referIcon referIcon4">
                                                <i class="fa-solid fa-gift fa-xl"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                            <p class="mb-0 fw-bolder">Rewards Earned</p>
                                            <p class="mb-0 fs-5 fw-bolder textViolet" id="rewards_earned">&#8377;0</p>
                                            <p class="mb-0 text-muted fs-6">Total cashback</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 2 -->
                        <div class="card rounded-4 border-1 p-3 referalCard">
                            <div class="referalSize">
                                <div class="">
                                    <h3 class="textViolet fw-bolder">Why Referrals Matter?</h3>
                                    <p class="mb-2 fs-5 text-muted">Share the joy of travel and earn rewards while doing it!</p>
                                    <div class="d-flex gap-2">
                                        <p class="mb-2 align-content-center"><i class="fa-regular fa-circle-check text-muted"></i></p>
                                        <p class="mb-2 fs-5 text-muted">Earn cashback for every friend who joins and travels.</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <p class="mb-2 align-content-center"><i class="fa-regular fa-circle-check text-muted"></i></p>
                                        <p class="mb-2 fs-5 text-muted">More referrals = More savings on your trips.</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <p class="mb-2 align-content-center"><i class="fa-regular fa-circle-check text-muted"></i></p>
                                        <p class="mb-2 fs-5 text-muted">Easy to share, easy to earn!</p>
                                    </div>
                                    <p class="mb-2 fs-5 fw-bolder textViolet">Your friends get great travel deals, and you get rewards. It's a win-win!</p>
                                </div>
                                <div>
                                    <img src="../assets/images/referalImage.png" alt="Package" class="referalImageWidth img-fluid w-100">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Pending List</h5>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>   
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Name</th>
                                                                <th data-ordering="false">Reference ID and Name</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Registered List</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">Customer ID & Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Type/Complemetory</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <?php if( $userType == "11" || $userType == "10" || $userType == '33'){ ?>
                                                                    <th data-ordering="false">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                        </div>
                        <?php if($userType == "10" || $userType == "11" ||$userType == "3" || $userType == "33" ){ ?>
                            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                                <a href="add_customer.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                                </a>
                            </div>
                        <?php } ?> 

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->
                <?php 
                    include_once(__DIR__ . '/customer_footer.php');
                ?>
                
            </div><!-- end main content-->
        
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <?php include (__DIR__ .'/../contact_modal.php') ?>
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>
        
        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>
        

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            $(document).ready(function(){
                //$("#example-dataTable").DataTable();
                $("#example-dataTable-2").DataTable();
            });

            function editfunc(id,cut,st,ct,editfor){
                window.location.href='edit_customer.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addRefFunc(id,taID,cut,st,ct,editfor){
                window.location.href='add_customer.php?vkvbvjfgfikix='+id+'&taId='+taID+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };
            
            function deletefunc(id,refid,action,userId,userType){
                var dataString = 'id='+id+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType

                $.ajax({
                    type: "POST",
                    url: "customer/delete_customer_data.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        console.log(data);
                        if( data == 0 ){
                            alert("Deleted Succesfully");
                            window.location.reload();
                        }else if( data == 1 ){
                            alert("User Activated Succesfully");
                            window.location.reload();
                        }else if( data == 2 ){
                            alert("User Restored Succesfully");
                            window.location.reload();
                        }else if( data == 3 ){
                            alert("User Deactivated Succesfully");
                            window.location.reload();
                        } else {
                            alert("Request Failed !!");
                        }
                    }
                });
            };

            function confirmfunc(id,email){ 
                var dataString = 'id='+ id+'&uname='+email;

                $.ajax({
                    type: "POST",
                    url: "customer/confirm_customer.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        if(data == 1){
                            alert("Email and Password sent via sms and email");
                        window.location.reload();
                    }
                    else{

                    alert("Failed to confirm");
                    }
                }
                });
                
            };

            function overviewPage(id,ref,cut,st,ct,message){
                var designation = 'ca_customer';
                window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
            //pending cu list
            $('#example-dataTable').DataTable({

                processing: true,

                ajax:{
                    url:'customer/pending_cu_list.php',
                    dataSrc:'data'
                },

                columnDefs:[
                    {
                        targets:[2,5],
                        orderable:false
                    }
                ],

                language:{

                    emptyTable: `
                        <div class="d-flex justify-content-center">
                            <div>
                                <img src="../assets/images/pendingData.png" alt="Package" class="pendingData img-fluid w-100">
                                <p class="fw-bolder fs-5 text-center mb-1">No pending referrals yet</p>
                                <p class="fw-muted fs-6 text-center">When someone uses your referral link, they'll appear here.</p>
                            </div>
                        </div>
                    `

                }

            });
            //regiterd cu list
            const columns = [
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false },
                { orderable:false }
            ];
            const userType=<?= $userType ?> ;
            if(userType == '10' || userType == '11' || userType == '33'){
                columns.push({orderable:false});
            }

            $('#example-dataTable-2').DataTable({

                destroy:true,

                processing:true,

                ajax:{
                    url:'customer/registered_cu_list.php',
                    dataSrc:'data'
                },

                columns:columns,

                language:{
                    emptyTable:`
                    <div class="d-flex justify-content-center py-1">
                        <div>
                            <img src="../assets/images/registerData.png"
                                class="registerData img-fluid w-100">

                            <p class="fw-bolder fs-5 mb-1">
                                No registered referrals yet
                            </p>

                            <p class="fw-muted fs-6">
                                Registered referrals will appear here.
                            </p>
                        </div>
                    </div>`
                }

            });
            //cards ajax
            $.ajax({
                url: 'customer/view_cu_card_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(res){

                    if(!res.status) return;

                    $('#pending_cu').text(res.data.pending_cu);
                    $('#registered_cu').text(res.data.registered_cu);
                    $('#total_cu').text(res.data.total_cu);
                    $('#rewards_earned').text('\u20B9 ' + res.data.rewards_earned);

                }
            });

        </script>
        <!-- dialer logic scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>
        <!-- end dialer logic scripts -->
    </body>
</html>