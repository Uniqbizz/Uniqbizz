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
        <title>Latest Transaction| Admin Dashboard </title>
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
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

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
                        <div class="row">
                            <div class="card">
                                <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                    <h5 class="mt-3 fw-bold fs-3">Latest Transaction</h5>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive table-desi p-2">
                                        <table class="table table-hover" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-16">Name</th>
                                                    <th class="ceterText fw-bolder font-size-16">Designation</th>
                                                    <th class="ceterText fw-bolder font-size-16">Statement</th>
                                                    <th class="ceterText fw-bolder font-size-16">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $SrNo = 1;
                                                    $sql1 ="SELECT corporate_agency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM corporate_agency UNION ALL 
                                                            SELECT ca_travelagency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM ca_travelagency UNION ALL 
                                                            SELECT ca_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM ca_franchisee 
                                                            WHERE status='1' order by date ";
                                                    $stmt1 = $conn -> prepare($sql1);
                                                    $stmt1 -> execute();
                                                    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt1 -> rowCount()>0){
                                                        foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                            if($row['user_type'] == "16"){
                                                                $designation = "Corporate Agency";
                                                            }else if($row['user_type'] == "19"){
                                                                $designation = "Franchisee";
                                                            }else if($row['user_type'] == "11"){
                                                                $designation = "Travel Agency";
                                                            }
                                                            $rd= new DateTime($row['date']);
                                                            $rdate= $rd->format('d-m-Y');
                                                            $TAmt = $row['amount'];
                                                            $CATAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
                                                            echo'
                                                                <tr>
                                                                    <td>'.$SrNo.'</td>
                                                                    <td>
                                                                        <div class="name">
                                                                            <span class="profile-pic pb-1 me-2">
                                                                                <img src="../../uploading/'.$row['profile_pic'].'" alt="profile pic" class="rounded-circle" style="width: 30px;">
                                                                            </span>
                                                                            <span class="name">'.$row['id'].' '.$row['firstname'].' '.$row['lastname'].'</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="designation">'.$designation.'</div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="para ps-3 pb-2">
                                                                            <p>Transfered <span class="amount">'.$CATAmt.'/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">'.$row['payment_mode'].'</span>.</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dateSection">'.$rdate.'</div>
                                                                    </td>
                                                                </tr>
                                                            ';
                                                            $SrNo++;
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
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
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->

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

        <script>
            $(document).ready(function(){
                $("#user_table").DataTable();
            });
            
        </script>
        
    </body>

</html>
