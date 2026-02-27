<!-- recent booking full table  -->
<div class="row">
    <div class="col-xxl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Bookings</h4>
                <div class="flex-shrink-0">
                    <!-- <button type="button" class="btn btn-soft-info btn-sm">
                        <i class="ri-file-list-3-line align-bottom"></i> Download
                    </button> -->
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Travel Date</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlBooking = "SELECT * FROM bookings WHERE customer_id = 'CU2200131' ";
                            $booking = $conn->prepare($sqlBooking);
                            $booking->execute();
                            $booking->setFetchMode(PDO::FETCH_ASSOC);
                            if ($booking->rowCount() > 0) {
                                foreach (($booking->fetchAll()) as $key => $row) {
                                    $packageName = $row['package_id'];
                                    echo '
                                            <tr>
                                                <td>' . $row['id'] . '</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="../assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Nicholas Ball</div>
                                                    </div>
                                                </td>
                                                <td>China</td>
                                                <td><span>15-12-2023</span></td>
                                                <td>10-12-2023</td>
                                                <td><span>&#8377 2000</span></td>
                                                <td><h5 class="fs-14 fw-medium mb-0">5.0<span class="text-muted fs-11 ms-1">(245 Rating)</span></h5></td>
                                                <td><span class="badge bg-success-subtle text-success">Completed</span></td>
                                            </tr>
                                        ';
                                }
                            }
                            ?>

                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>
            </div>
        </div> <!-- .card-->

    </div>
</div><!-- end row-->