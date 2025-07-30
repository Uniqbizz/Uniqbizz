<?php
    // session_start();
    // if(!isset($_SESSION['username'])){
    //     echo '<script>location.href = "login.php";</script>';
    // }

    require '../connect.php';
    $date = date('Y'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Packages</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> --> 
    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
    <!-- Loading Screen and Images size css  -->
    <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        .table{
           
        }
    </style>
</head>
<body data-sidebar="dark">
    <div class="layout-wrapper">
        <?php 
            // top header logo, hamberger menu, fullscreen icon, profile
            include_once '../header.php';

            // sidebar navigation menu 
            include_once '../sidebar.php';
        ?>
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                                <li class="breadcrumb-item">Packages</li>
                            </ol>
                        </nav> -->
                        <div class="row">
                            <div class="card">
                                <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                    <h5 style="margin-top: 10px;">Packages</h5>
                                    <!-- <div class="dropdown">
                                        <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="add_packages.php">Add New</a>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive table-desi">
                                        <!-- table roe limit -->
                                    
                                        <table class="table table-hover" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">Sr. No.</th>
                                                    <th class="ceterText fw-bolder font-size-16">Unique Code</th>
                                                    <th class="ceterText fw-bolder font-size-16">Package Name</th>
                                                    <th class="ceterText fw-bolder font-size-16">Total Price</th>
                                                    <th class="ceterText fw-bolder font-size-16">Product Type</th>
                                                    <th class="ceterText fw-bolder font-size-16">Action</th>
                                                    <!-- <th class="ceterText fw-bolder font-size-16">Delete</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require '../connect.php';
                                                    
                                                    $stmt = $conn->prepare("SELECT p.id, name, unique_code, category_name, total_package_price_per_adult,total_package_price_per_child FROM package p, package_pricing t, category c WHERE p.id = t.package_id AND p.category_id = c.id AND p.status = '1' ORDER BY p.id DESC ");
                                                    $stmt->execute();
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($stmt->rowCount()>0){
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            echo '<tr>
                                                                    <td style="text-align:center"><span class="list-img text-black">'.++$key.'</span></td>
                                                                    <td style="text-align:center"><a href="#" class="text-black"><span class="list-end-name">'.$row['unique_code'].'</span></a></td>
                                                                    <td><a href="#" class="text-black"><span class="list-end-name">'.$row['name'].'</span></a></td>
                                                                    <td style="text-align:right" class="text-black"> Adult: ₹ '.$row['total_package_price_per_adult'].'<br> Child: ₹ '.$row['total_package_price_per_child'].'</td>
                                                                    <td style="text-align:center" class="text-black">'.$row['category_name'].'</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;"></i></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="edit_packages.php?vkvbvjfgfikix='.$row['id'].'"><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i>Edit</a>
                                                                                <a class="dropdown-item" href="#" onclick=\'deleteData("' .$row['id']. '")\'><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>';
                                                        }
                                                    } else{
                                                        echo '<tr><td colspan="6">No Data Avaiable</td><tr>';
                                                    }
                                                ?>  
                                               
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>   
        </div>    
    </div>
    <!-- Add button icon -->
    <div class="btn" role="button" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
        <a href="add_packages.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
            <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
        </a>
    </div>
    <!--start back-to-top-->
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
    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <script>
        $(document).ready(function(){
            $("#user_table").DataTable();
        });

        function deleteData(id)
        { 
            // delete function
            var dataString = 'id='+ id;
            // console.log(dataString);
            var r = confirm("Do you want to delete Package Details ?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: "forms/delete.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        if(data == "success"){
                            alert("Delete Succesfully");
                            window.location.reload();
                        }else{
                            alert("Deletion Failed");
                        }
                    }
                }); 
            }   
        }
    </script>
</body>
</html>