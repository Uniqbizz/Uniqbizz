<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../index";</script>';
    }
        require '../connect.php';
        $date1 = date('Y'); 


        $id = $_GET['vkvbvjfgfikix'];
        $name ="";
        $phone_no = "";
        $email = "";
        $destination = "";
        $days = "";
        $budget = "";
        $date = "";
        $pax = "";
        $package_suggetion = "";
        $status="";
        
        $stmt = $conn->prepare("SELECT * FROM quotations WHERE id='".$id."' ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->rowCount()>0){
            foreach (($stmt->fetchAll()) as $key => $row) {

                $name = $row['name'];
                $phone_no = $row['phone_no'];
                $email = $row['email'];
                $destination = $row['destination'];
                $days = $row['days'];
                $budget = $row['budget'];

                $sdate = new DateTime($row['date']);
                $date = $sdate->format('d-M-Y');
                $pax = $row['pax'];
                $package_suggetion = $row['package_suggetion'];

                if($row['status']=="1"){
                    $status="Complete";
                }else{
                    $status="Pending";
                }
            }
    }else{
            echo "no data found";
        }
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>View Quotation | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

        <!-- Plugins css -->
        <!-- <link href="../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

        <style>
            .waves-button-input{
            padding: 20px 29px;
            }
            .btn-large{
                padding:0px;
            }
            #status {
                width: 100% !important;
                height: 40px !important;
                position: relative !important;
                left: 0% !important;
                top: 0% !important;
                margin: auto !important;
                display: block !important;
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

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="search-box me-2 mb-2 d-inline-block">
                                                <div class="position-relative">
                                                    <h4>Quotation Details</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <form>

                                                    <div class="row"> 
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="name"  name="Name" value="<?php echo $name; ?> " readonly>
                                                                <label for="name">Name:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="phnumber" name="phone_no" placeholder="phone number" value="<?php  echo $phone_no; ?> " readonly>
                                                                <label for="phnumber">Phone no:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="status" name="status" placeholder="Status" value="<?php  echo $status; ?> " readonly>
                                                                <label for="status">Status:</label>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php  echo $email; ?> " readonly>
                                                                <label for="email">Email:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="tdate" name="date" placeholder="Travel Date" value="<?php  echo $date; ?> " readonly>
                                                                <label for="tdate">Travel Date:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="day_num" name="days_no" placeholder="No of Days" value="<?php  echo $days; ?> " readonly>
                                                                <label for="day_num">No of Days:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="destination" name="Destination" placeholder="Destination" value="<?php  echo $destination; ?> " readonly>
                                                                <label for="destination">Destination:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="pax_num" name="pax_no" placeholder="No of Pax" value="<?php  echo $pax; ?> " readonly>
                                                                <label for="pax_num">No of Pax:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="person_budget" name="budget" placeholder="Approx Budget per head" value="₹ <?php  echo $budget; ?> " readonly>
                                                                <label for="person_budget">Approx Budget per head:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" name="package_suggetion" placeholder="Package Suggestion" value="<?php  echo $package_suggetion; ?> " readonly>
                                                                <label>Package Suggestion:</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12" style="margin-top: 20px;">
                                                            <!-- <a href="#" class="waves-effect waves-light btn-large" name="addTds" >SAVE</a>  -->
                                                            <!-- <input type="submit" name="addTds" class="waves-effect waves-light btn-large" id="submit" value="SAVE">                                               -->
                                                            </div>
                                                        </div>
                                                        <div class="mt-5">
                                                            <!-- <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i> Log Activity :</h5> -->
                                                            
                                                            <div>
                                                                <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i>Quotation Raised</h5>
                                                                <div class="d-flex py-3">
                                                                    <div class="flex-shrink-0 me-3">
                                                                        <div class="avatar-xs">
                                                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                                                <i class="bx bxs-user"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="font-size-14 mb-1"><?php echo $name; ?> <small class="text-muted float-end"><?php echo $date; ?></small></h5>
                                                                        <p class="text-muted"><?php echo $name.'has raised Quotation Request' ?></p>
                                                                        <!-- <div>
                                                                            <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                                        </div> -->
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="d-flex py-3 border-top">
                                                                    <div class="flex-shrink-0 me-3">
                                                                        <div class="avatar-xs">
                                                                            <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="font-size-14 mb-1">Clarence Smith <small class="text-muted float-end">2 hrs Ago</small></h5>
                                                                        <p class="text-muted">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</p>
                                                                        <div>
                                                                            <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                                        </div>
                    
                                                                        <div class="d-flex pt-3">
                                                                            <div class="flex-shrink-0 me-3">
                                                                                <div class="avatar-xs">
                                                                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                                                                        <i class="bx bxs-user"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="flex-grow-1">
                                                                                <h5 class="font-size-14 mb-1">Silvia Martinez <small class="text-muted float-end">2 hrs Ago</small></h5>
                                                                                <p class="text-muted">To take a trivial example, which of us ever undertakes laborious physical exercise</p>
                                                                                <div>
                                                                                    <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                            <div>
                                                                <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i>Quotation Viewed</h5>
                                                                <div class="d-flex py-3 border-top">
                                                                    <div class="flex-shrink-0 me-3">
                                                                        <div class="avatar-xs">
                                                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                                                <i class="bx bxs-user"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="font-size-14 mb-1">Admin <small class="text-muted float-end"><?php echo $date; ?></small></h5>
                                                                        <p class="text-muted">Quotation view by Admin</p>
                                                                        <!-- <div>
                                                                            <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                                        </div> -->
                                                                    </div>
                                                                </div>
                    
                                                            </div>

                                                        </div>
                                                        <div>
                                                            <h5 class="font-size-15"><i class="bx bx-message-dots text-muted align-middle me-1"></i>Quotation In Process</h5>
                                                            <div class="d-flex py-3 border-top">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            <i class="bx bxs-user"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="flex-grow-1">
                                                                    <h5 class="font-size-14 mb-1">Admin<small class="text-muted float-end"><?php echo $date;  ?></small></h5>
                                                                    <?php
                                                                        $sql = "SELECT * FROM `quotations_info` WHERE quotation_id ='$id' AND status = '1' ";
                                                                        $stmt2 = $conn -> prepare($sql);
                                                                        $stmt2 -> execute();
                                                                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $stmt2 -> rowCount()>0 ){
                                                                            foreach( ($stmt2 -> fetchAll()) as $key => $row ){
                                                                                $date= new DateTime($row['created_date']);
                                                                                $cdate= $date->format('d-m-Y');
                                                                                echo'<p class="text-muted  mt-4 mb-0" id="statement">'.$cdate.'</p>
                                                                                     <p class="text-muted mb-4" id="statement">'.$row['message'].'</p>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                
                                                        </div>
            
                                                        <div class="mt-4">
                                                            <h5 class="font-size-16 mb-3">Leave a Message</h5>
                                                            <form>
                                                                <div class="mb-3 d-none" >
                                                                    <label for="id" class="form-label">ID</label>
                                                                    <input type="text" class="form-control" id="id" placeholder="" value="<?php echo $id; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message" class="form-label">Message</label>
                                                                    <textarea class="form-control" id="message" placeholder="Your message..." rows="3"></textarea>
                                                                </div>
            
                                                                <div class="text-end">
                                                                    <button type="button" id="quotation_message" value="Submit" class="btn btn-success w-sm">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date1; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Mirthcon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <!-- <script type="text/javascript" src="../assets/js/submitdata.js"></script> -->

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

       <!-- <script src="../../uploading/upload.js"></script> -->

       <script>
            $('#quotation_message').on('click', function(e){
                e.preventDefault();
                var id = $('#id').val();
                var message = $('#message').val();
                var dataString = {id, message}
                if(message){
                    $.ajax({
                        type: 'POST',
                        url: 'quotation_message.php',
                        data: dataString,
                        cache: false,
                        success: function(data){
                            if(data == '1'){
                                window.location.reload();
                                // console.log(data);
                            }else{
                                alert('Error');
                                // console.log(data);
                            }
                        }
                    });
                }else{
                    alert('Enter Proper message');
                }
            });
       </script>
    </body>

</html>