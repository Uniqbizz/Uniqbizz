<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
    $date_range = $_POST['date'];
    // Split the date range using ' - ' as the separator
    list($start_date, $end_date) = explode(" - ", $date_range);

    // Convert both dates to Y-m-d format
    $start_date_formatted = date("Y-m-d", strtotime($start_date));
    $end_date_formatted = date("Y-m-d", strtotime($end_date));

?>
<div class="tab-content" id='tableList'>
    <div class="tab-pane fade card show active px-3 rounded-4" id="allHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table1">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $customer_fil = '';
                            //check which user logged in based on user type
                            //data load from models file
                            include '../all_channels.php';

                            // Check if travel agencies exist
                            include 'all_booking_custom.php';
                        ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="pendingHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table2">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $customer_fil = '';
                            //check which user logged in based on user type
                            //data load from models file
                            include '../all_channels.php';

                            // Check if travel agencies exist
                            include 'pending_booking_custom.php';
                        ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="bookedHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table3">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $customer_fil = '';
                            //check which user logged in based on user type
                            //data load from models file
                            include '../all_channels.php';

                            // Check if travel agencies exist
                            include 'booked_booking_custom.php';
                        ?>
                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="canceledHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table4">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $customer_fil = '';
                            //check which user logged in based on user type
                            //data load from models file
                            include '../all_channels.php';

                            // Check if travel agencies exist
                            include 'cancled_booking_custom.php';
                        ?>

                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade card show px-3 rounded-4" id="refundHistory" role="tabpanel">
        <div class="col-lg-12 py-3">
            <div class="table-responsive table-desi">
                <table class="table table-hover" id="user_table5">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-13">Sr. No.</th>
                            <th class="ceterText fw-bolder font-size-13">Booking ID</th>
                            <th class="ceterText fw-bolder font-size-13">Tour Date</th>
                            <th class="ceterText fw-bolder font-size-13">Package Name</th>
                            <th class="ceterText fw-bolder font-size-13">Customer</th>
                            <th class="ceterText fw-bolder font-size-13">Travel Consultant</th>
                            <th class="ceterText fw-bolder font-size-13">Payment Status</th>
                            <th class="ceterText fw-bolder font-size-13">Status</th>
                            <th class="ceterText fw-bolder font-size-13">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $customer_fil = '';
                            //check which user logged in based on user type
                            //data load from models file
                            include '../all_channels.php';

                            // Check if travel agencies exist
                            include 'refunded_booking_custom.php';
                        ?>

                    </tbody>
                </table>
                <!-- pegination start -->
                <div class="center text-center" id="pagination_row"></div>
            </div>
            <div class="row d-flex justify-content-center d-none" id="refundAmt">
                <div class="col-md-8 col-sm-10">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 col-sm-6">
                            <h5 class="fw-bolder">Paid Refund: <span>&#8377; 10000</span></h5>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h5 class="fw-bolder">Pending Refund: <span>&#8377; 10000</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $("#user_table1").DataTable();
    $("#user_table2").DataTable();
    $("#user_table3").DataTable();
    $("#user_table4").DataTable();
    $("#user_table5").DataTable();
</script>