<?php
include_once 'dashboard_user_details.php';
$tamount='';
$initial_inv='';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard | Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="assets/css/custom.css" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    <style>
        /* Accordion */
        .accordion {
            cursor: pointer;
            width: 100%;
            border: none;
        }
        /* Card Wrapper */
        .upgrade-table-wrapper {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        /* Table header */
        #upgardeHistoryTable thead th {
            background: #f8f9fb;
            font-weight: 600;
            font-size: 14px;
            padding: 14px;
            border-bottom: none;
        }

        /* Table rows */
        #upgardeHistoryTable tbody tr {
            background: #fff;
            transition: all 0.25s ease;
        }

        #upgardeHistoryTable tbody tr:hover {
            background: #f9fbfd;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        /* Table cells */
        #upgardeHistoryTable tbody td {
            padding: 14px;
            vertical-align: middle;
            font-size: 14px;
        }

        /* Modern Badges */
        .badge-soft-info {
            background: #e7f3ff;
            color: #007bff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-soft-success {
            background: #e6f9f0;
            color: #00a86b;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-soft-danger {
            background: #fdecea;
            color: #dc3545;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Dropdown */
        .card-drop {
            color: #6c757d;
            transition: 0.2s;
        }

        .card-drop:hover {
            color: #000;
        }

    </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once 'header.php'; ?>

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

        <?php include_once 'sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                     <?php
                        $sql100= "SELECT amount,reference_no FROM sub_franchisee WHERE sub_franchisee_id='".$userId."' and status=1";
                        $stmt100 = $conn->prepare($sql100);
                        $stmt100->execute();
                        $stmt100->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt100->rowCount() > 0) {
                            foreach (($stmt100->fetchAll()) as $key => $row) {
                                $initial_inv = $row['amount'];
                                $reference_no = $row['reference_no'];
                            }
                        }
                        $sql101= "SELECT old_investment_amt,new_investment_amt,upgrade_amt as upgrade_amt  FROM sub_franchisee_upgrade
                                            WHERE sub_franchisee_id='".$userId."' and upgrade_status=1
                                            ORDER BY upgrade_approval_date DESC limit 1";
                        $stmt101 = $conn->prepare($sql101);
                        // print_r($stmt101);
                        $stmt101->execute();
                        $stmt101->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt101->rowCount() > 0) {
                            foreach (($stmt101->fetchAll()) as $key => $row) {
                                $tamount = $row['upgrade_amt'];
                            }
                        }else{
                            $tamount = $initial_inv;
                        }
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Upgarde History</h4>
                                
                                <div class="pt-3 pb-2 col-md-6">
                                    <div class="row justify-content-end">
                                        <div class="col-md-6 d-flex gap-2">
                                            <span class="fw-semibold">Total Investment:</span>
                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                <?= htmlspecialchars($tamount, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col">

                            <div class="h-100">

                                <div class="table-responsive p-3 upgrade-table-wrapper" id="filterTable1">

                                    <table class="table align-middle mb-0" id="upgardeHistoryTable">

                                        <thead>
                                            <tr>
                                                <th>Investment Date</th>
                                                <th style="width:250px;">Invested Amount</th>
                                                <th>Commission %</th>
                                                <th>Incentive %</th>
                                                <th>Payment Mode</th>
                                                <th style="width:250px;">Note</th>
                                                <th>Approved Date</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="upgardeHistory">

                                        <?php

                                        $sqlUnion = "SELECT id,new_investment_amt,upgrade_amt,upgrade_request_date,
                                                            upgrade_approval_date,new_commission_per,new_incentive_per,
                                                            payment_mode,rejection_reason,note,upgrade_status
                                                    FROM sub_franchisee_upgrade
                                                    WHERE sub_franchisee_id='".$userId."'
                                                    ORDER BY upgrade_request_date ASC";

                                        $stmtUnion = $conn->prepare($sqlUnion);
                                        $stmtUnion->execute();
                                        $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);

                                        if ($stmtUnion->rowCount() > 0) {

                                            foreach ($stmtUnion->fetchAll() as $row) {

                                                $udate = !empty($row['upgrade_request_date']) 
                                                    ? date("d-m-Y", strtotime($row['upgrade_request_date'])) : '-';

                                                $adate = !empty($row['upgrade_approval_date']) 
                                                    ? date("d-m-Y", strtotime($row['upgrade_approval_date'])) : '-';

                                                $amount = number_format($row['new_investment_amt']);
                                                $comm = $row['new_commission_per'];
                                                $inc = $row['new_incentive_per'];
                                                $pay_mode = ucfirst($row['payment_mode']);
                                                $note = $row['note'] ?? '-';
                                                $row_id = $row['id'];
                                                $rejection_reason = trim($row['rejection_reason'] ?? '');
                                                $status = $row['upgrade_status'];

                                                if ($rejection_reason === '') {
                                                    $rejection_reason = '-';
                                                }

                                                echo "<tr>

                                                    <td>$udate</td>

                                                    <td><strong class='text-dark'>₹ $amount</strong></td>

                                                    <td><span class='text-primary fw-semibold'>$comm%</span></td>

                                                    <td><span class='text-success fw-semibold'>$inc%</span></td>

                                                    <td>$pay_mode</td>

                                                    <td>$note</td>

                                                    <td>$adate</td>

                                                    <td>$rejection_reason</td>

                                                    <td>";

                                                    if ($status == 0) {
                                                        echo "<span class='badge badge-soft-info'>Requested</span>";
                                                    } elseif ($status == 1) {
                                                        echo "<span class='badge badge-soft-success'>Approved</span>";
                                                    } elseif ($status == 2) {
                                                        echo "<span class='badge badge-soft-danger'>Rejected</span>";
                                                    }

                                                echo "</td>

                                                    <td class='text-center'>
                                                        <div class='dropdown'>
                                                            <a href='#' class='dropdown-toggle card-drop'
                                                            data-bs-toggle='dropdown'>
                                                            <i class='mdi mdi-dots-horizontal font-size-18'></i>
                                                            </a>
                                                            <ul class='dropdown-menu'>
                                                                <li>
                                                                    <a href='#'
                                                                    onclick='upgradeHistoryPage(\"$row_id\",\"$userId\")'
                                                                    class='dropdown-item'>
                                                                    <i class='mdi mdi-eye text-info me-1'></i>
                                                                    View Details
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>

                                                </tr>";
                                            }

                                        } else {
                                            echo "<tr>
                                                    <td colspan='10' class='text-center text-muted py-4'>
                                                        No upgrade history found.
                                                    </td>
                                                </tr>";
                                        }

                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                        </div>


                    </div>

                </div>

            </div>

            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                <a href="add_ta_top_up.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                </a>
            </div>

        </div> <!-- container-fluid -->
    </div><!-- End Page-content -->

                <?php include_once "footer.php" ?>

</div><!-- end main content-->

    </div><!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Required datatable js -->
     
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- !-- materialdesign icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>


    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
        
        $(document).ready(function() {
            $("#example-dataTable").DataTable();
            $("#example-dataTable-2").DataTable();
            $('.rejectMess').click(function () {
                var createdDate=$(this).data("created-date");
                var usersId=$(this).data("user-id");
                $.ajax({
                   url:"travel_agent/getRejectReason.php",
                   type:"POST",
                   data:{createdDate:createdDate,usersId:usersId},
                   success:function(response){
                    $('#floatingTextarea').text(response);
                    $("#rejectTopup").modal("show");
                   } 
                });
                
            });
        });

        function editfunc(id, cut, st, ct, editfor) {
            window.location.href = 'edit_customer.php?vkvbvjfgfikix=' + id + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function addRefFunc(id, taID, cut, st, ct, editfor) {
            window.location.href = 'add_customer.php?vkvbvjfgfikix=' + id + '&taId=' + taID + '&ncy=' + cut + '&mst=' + st + '&hct=' + ct + '&editfor=' + editfor;
        };

        function deletefunc(id, fid, action) {
            var dataString = 'id=' + id + '&fid=' + fid + '&action=' + action;

            $.ajax({
                type: "POST",
                url: "customer/delete_customer_data.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        alert("Deleted Succesfully");
                        window.location.reload();
                    } else if (data == 1) {
                        alert("User Activated Succesfully");
                        window.location.reload();
                    } else if (data == 2) {
                        alert("User Restored Succesfully");
                        window.location.reload();
                    } else if (data == 3) {
                        alert("User Deactivated Succesfully");
                        window.location.reload();
                    } else {
                        alert("Request Failed !!");
                    }
                }
            });
        };

        function confirmfunc(id, email) {
            var dataString = 'id=' + id + '&uname=' + email;

            $.ajax({
                type: "POST",
                url: "customer/confirm_customer.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    if (data == 1) {
                        alert("Email and Password sent via sms and email");
                        window.location.reload();
                    } else {

                        alert("Failed to confirm");
                    }
                }
            });

        };

        function overviewPage(id, ref, cut, st, ct, message) {
            var designation = 'Customer';
            window.location.href = 'overview.php?id=' + id + '&ref=' + ref + '&cut=' + cut + '&st=' + st + '&ct=' + ct + '&message=' + message + '&designation=' + designation;
        }
    </script>
    <script>
        //franchisee upgrade History Details
        function upgradeHistoryPage(id,ref){
            window.location.href='upgrade_franchisee_history.php?id='+id+'&sub_f_id='+ref;
        }

        $('#upgardeHistoryTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10
        });
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
    </script>
</body>

</html>