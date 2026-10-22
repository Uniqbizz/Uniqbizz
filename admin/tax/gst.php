<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>GST | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- bootstrap-datepicker css -->
        <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

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
        <!-- TAX Css -->
        <link href="../assets/css/tax.css" rel="stylesheet" type="text/css" />
        <style>
            /* dataTable, action col, dropdown align right  */
            @media screen and (max-width: 992px) and (min-width: 914px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            } 
            @media screen and (max-width: 1256px) and (min-width: 1176px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }
            @media screen and (max-width: 1345px) and (min-width: 1264px) {
                .dropdown-menu-end-2[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }
        </style>
    </head>
    <body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
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
                                    <h4 class="mb-sm-0 font-size-18">GST</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card p-3 gstCardHeight">
                                    <h5 class="fw-bolder">Add GST</h5>
                                    <hr class="mb-0 nmx-2">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control border-0 border-bottom border-2" id="floatingInput" placeholder="#">
                                        <label for="floatingInput">GST</label>
                                    </div>
                                    <div>
                                        <button type="button" class="gstBtn">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card p-3 gstCardHeight">
                                    <h5 class="fw-bolder">Club GST</h5>
                                    <p class="text-danger mb-0">Note: Latest recode will be applied for calculating GST!</p>
                                    <hr class="mb-0 nmx-2">
                                    <div class="gstTableScroll">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">SR NO</th>
                                                    <th scope="col">GST</th>
                                                    <th scope="col">DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>5%</td>
                                                    <td>22-Jul-2026</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>18%</td>
                                                    <td>18-Aug-2026</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>18%</td>
                                                    <td>18-Aug-2026</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>18%</td>
                                                    <td>18-Aug-2026</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="search-box me-2 mb-2 d-flex justify-content-between">
                                                    <div class="position-relative">
                                                        <h4>Club Purchase GST List</h4>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical mdi-24px" style="color: grey;"></i></a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item d-flex" href="#" onclick="#">
                                                                <div class="gstDownload">
                                                                    <i class="fa-solid fa-download"></i>
                                                                </div> 
                                                                <p class="mb-0 align-content-center ms-2">
                                                                    Download
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="clubPurchaseGSTList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>DATE</th>
                                                        <th>AMOUNT</th>
                                                        <th>GST</th>
                                                        <th>TOTAL</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-start">CU220151</td>
                                                        <td class="text-start">Maruti Bambolkar</td>
                                                        <td class="text-start">Membership</td>
                                                        <td class="text-start">20-08-2022</td>
                                                        <td class="text-end">&#8377; 10000</td>
                                                        <td class="text-end">&#8377; 1800</td>
                                                        <td class="text-end">&#8377; 11800</td>
                                                        <td class="d-flex justify-content-center">
                                                            <div class="gstDownload">
                                                                <i class="fa-solid fa-download"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-lg-12 col-sm-6">
                                                <div class="search-box me-2 mb-2 d-flex justify-content-between">
                                                    <div class="position-relative">
                                                        <h4>Tour Booking GST</h4>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical mdi-24px" style="color: grey;"></i></a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item d-flex" href="#" onclick="#">
                                                                <div class="gstDownload">
                                                                    <i class="fa-solid fa-download"></i>
                                                                </div> 
                                                                <p class="mb-0 align-content-center ms-2">
                                                                    Download
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" id="cuView">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="tourBookingGSTList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>NAME</th>
                                                        <th>PACKAGE</th>
                                                        <th>DATE</th>
                                                        <th>AMOUNT</th>
                                                        <th>GST</th>
                                                        <th>TOTAL</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- <tr>
                                                        <td class="text-start">CU220151</td>
                                                        <td class="text-start">Maruti Bambolkar</td>
                                                        <td class="text-start">Membership</td>
                                                        <td class="text-start">20-08-2022</td>
                                                        <td class="text-end">&#8377; 10000</td>
                                                        <td class="text-end">&#8377; 1800</td>
                                                        <td class="text-end">&#8377; 11800</td>
                                                        <td class="d-flex justify-content-center">
                                                            <div class="gstDownload">
                                                                <i class="fa-solid fa-download"></i>
                                                            </div>
                                                        </td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        <!-- end table responsive -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->
                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newCustomerModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div>
        <!-- End button icon -->
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->                                                
        <!-- Modal -->
        <div class="modal fade" id="newCustomerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <span class="avatar-title">
                                    <i class="fas fa-user-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Add New User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="add-item"><a href="add_customers.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-newCustomerModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end newCustomerModal -->

        <!-- Modal -->
        <div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                            <button type="button" class="btn btn-secondary" id="close-removeCustomerModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end removeItemModal -->

        <!-- Modal -->
        <div class="modal fade" id="confirmItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Cofirm this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="remove-item">Confirm Now</button>
                            <button type="button" class="btn btn-secondary" id="close-confirmItemModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end confirmItemModal -->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>

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

        <!-- dataTable -->
        <script>
            $(document).ready(function(){
                $("#clubPurchaseGSTList-table").DataTable();
                $("#tourBookingGSTList-table").DataTable();
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addCustRef(id,fullname,taRef,status){ 
                window.location.href='add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
            };

            // function addCustRef(id, fullname, status) {
            //     // Encode fullname to safely pass in URL
            //     const encodedFullname = encodeURIComponent(fullname);
            //     window.location.href = 'add_customers.php?id=' + id + '&fullname=' + encodedFullname + '&status=' + status;
            // }

            function deletefunc(id,fid,action){ 
                var dataString = 'id='+id+'&refid='+fid+'&action='+action;

                $.ajax({
                type: "POST",
                url: "delete_customers.php",
                data: dataString,
                cache: false,
                    success:function(data){
                        console.log('data'+data);
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
                $("#loading-overlay").show(); //loading screen
                $.ajax({
                    type: "POST",
                    url: "confirm_customers.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        if(data == 1){
                            $("#loading-overlay").hide(); //loading screen
                            alert("Email and Password sent via sms and email");
                            window.location.reload();
                        }
                        else{
                            $("#loading-overlay").hide(); //loading screen
                            alert("Failed to confirm");
                        }
                    }
                });
            };

            $('#filter_state').on('change', function(){
				// e.preventDefault();
				// alert('Hello');
				// let filterEmpID = $('#bmId').val() ;
				// let filterEmpName = $('#bmName').val();
				let filterState = $('#filter_state').val();
				// console.log(filterEmpID +' '+ filterEmpName +' '+ filterState);

                if(!filterState){
                    alert("Select State First");
                }else{

                    let dataString = 'state='+filterState;

                    $.ajax({
                        type: 'POST',
                        url: 'filterCU.php',
                        data: dataString,
                        cache: false,
                        success: function(data){
                            if(data){
                                console.log('success'+' '+data);
                                $('#cuView').html(data);
                                $("#registeredCustomerList-tableFilter").DataTable();
                                var totalRows = $("#registeredCustomerList-tableFilter").DataTable().rows().count();
                                $('#filterCount').val(totalRows);
                                // console.log("Total DataTable rows:", totalRows);
                            }else{
                                console.log('unsuccess'+' '+data);
                                $('#tcView').html(data);
                            }
                        }
                    });
                }
			});

            function regCuDownload(){
                const filterState = $('#filter_state').val();
                const stateText = $('#filter_state option:selected').text();
                window.location.href='download_list?filterState='+filterState+'&stateText='+stateText;
            }

            
            function overviewPage(id,ref,cut,st,ct,message){
                var designation = 'Customer';
                window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
        </script>
    </body> 
</html>