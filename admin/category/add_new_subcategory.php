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
        <title>Add Category | Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
        <style>
            .table{
                margin-bottom: 0rem !important;
                vertical-align: bottom !important;
            }
            .table-responsive{
                padding: 25px;
                padding-top: 0px;
            }
            input::file-selector-button {
                background-color: #556ee6;
                background-size: 150%;
                border: 0;
                border-radius: 8px;
                color: #fff;
                padding: 1rem 1.25rem;
                text-shadow: 0 1px 1px #333;
                transition: all 0.25s;
                color: white;
                content: "Upload";
            }
            input::file-selector-button:hover {
                background-color: #556ee6;
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
                        <div class="text-end p-3">
                            <!-- return previous page link -->
                            <li class="badge badge-pill p-2" id="return_to_views_btn" style="width: fit-content; background-color: #0036a2;"><a href="manage_categories.php" class="text-white"><i class="fa fa-backward text-white" aria-hidden="true"></i> Back</a></li>
                        </div> 
                        <div class="row">
                            <div class="col-12 card">
                                <div class="page-title-box d-sm-flex p-4 mb-2" style="border-bottom: 1px solid #ddd">
                                    <h4 class="mb-sm-0">Add New Sub Category</h4>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 p-3">
                                    <form>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                                <label for="name" class="required">Name</label>
                                            </div>
                                        </div> 
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <?php
                                                    require '../connect.php';
                                                    $stmt = $conn->prepare("SELECT * FROM category WHERE status = 1 ORDER BY category_name ASC");
                                                    $stmt->execute();
                                                                                                    
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                ?>
                                                <select id="category" class="selectdesign">
                                                    <option value="">--Select Category--</option>
                                                    <?php 
                                                    if($stmt->rowCount()>0){
                                                         foreach (($stmt->fetchAll()) as $key => $row) {  
                                                            echo '<option value="'.$row['id'].'">'.$row['category_name'].'</option>'; 
                                                        } 
                                                    }else{ 
                                                        echo '<option value="">No Category Available </option>'; 
                                                    } 
                                                    ?>
                                                    
                                                </select>
                                                <label for="name" class="required">Parent Category</label>
                                            </div>
                                        </div> 
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="description" name="description" placeholder="Name">
                                                <label for="description" class="required">Description</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="file1"><b>Picture</b></label><br/>
                                                <input type="file" name="file1" id="upload_file1">
                                            </div>
                                            <input type="hidden" id="img_path1" value="">
                                            <div id="preview1" style="display: none;">
                                                <div id="image_preview1">
                                                    <img  alt="Preview" id="img_pre1" height="100px" width="100px">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="btn bg-primary col-sm-1 m-4 ms-3">
                                                <a href="#" id="addSubCategory" class="placeholder-wave bg-primary text-white">Save</a> 
                                            </div>
                                        </div>
                                    </form>
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

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="../assets/js/product.js"></script>
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
             var uploadUrl = "../../uploading/upload.php"

                // ** Profile Pic upload **
                $('#upload_file1').change(function(){
                    var folder = 'subcategory';
                    
                    var file_data = $('#upload_file1').prop('files')[0];   
                    var form_data = new FormData();                  
                    form_data.append('file', file_data);
                    form_data.append('folder',folder);
                    $.ajax({
                        url: uploadUrl,
                        type: "POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            // console.log(data);
                            $("#preview1").show();
                            $("#img_pre1").attr("src","../../uploading/"+data);
                            $("#img_path1").val(data);
                        }
                    });
                });
        </script>
    </body>
</html>