<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-xl-8" id="eventCalender">
                <div class="card rounded-4">
                    <div id="btn-new-event"></div>
                    <div id='locale-selector' class="d-none"></div>
                    <div class="card-body">
                        <div id="external-events">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#event-modal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addBusinessTraineemodal"><i class="mdi mdi-plus me-1"></i> Add Event</button>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div> <!-- end col -->

            <!-- Latest Transaction -->
            <div class="col-xl-4 ps-0" id="latestTransaction">
                <div class="card rounded-4">
                    <h2 class="fs-4 p-3">Latest Transaction</h2>
                    <?php
                    $sql1 = "SELECT corporate_agency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM corporate_agency UNION ALL 
                                    SELECT ca_travelagency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM ca_travelagency UNION ALL 
                                    SELECT sub_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM sub_franchisee UNION ALL
                                    SELECT master_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, paid_amount as amount, payment_mode, status FROM master_franchisee UNION ALL
                                    SELECT sponsor_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, paid_amount as amount, payment_mode, status FROM sponsor_franchisee 
                                    WHERE status='1' order by date desc limit 5";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->execute();
                    $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt1->rowCount() > 0) {
                        foreach (($stmt1->fetchAll()) as $key => $row) {
                            if ($row['user_type'] == "16") {
                                $designation = "Techno Enterprise";
                            } else if ($row['user_type'] == "29") {
                                $designation = "Franchisee";
                            } else if ($row['user_type'] == "11") {
                                $designation = "Travel Consultant";
                            }else if ($row['user_type'] == "28") {
                                $designation = "Master Franchisee";
                            }else if ($row['user_type'] == "30") {
                                $designation = "Sponsor Franchisee";
                            }
                            $rd = new DateTime($row['date']);
                            $rdate = $rd->format('d-m-Y');
                            $TAmt = $row['amount'];
                            $pathFromDB=$row['profile_pic'];
                            $dir  = dirname($pathFromDB);   // profile_pic
                            $file = basename($pathFromDB);
                            $imgPath = "uploading/" . $dir . "/" . rawurlencode($file);
                            $CATAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
                            echo '
                                        <div class="card pt-3">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-1 col-md-1 col-sm-2 col-2">
                                                    <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                        <img src="../../../' . $imgPath . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-9 col-lg-11 col-md-11 col-sm-10 col-10 d-flex justify-content-between align-items-center">
                                                    <div class="name fw-bold">' . $row['id'] . ' ' . $row['firstname'] . ' ' . $row['lastname'] . '</br> <span class="fw-normal">(' . $designation . ')</span></div>
                                                </div>
                                                <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">' . $rdate . '</div>
                                            </div>
                                            
                                            <div class="para ps-3 pb-2">
                                                <p>Transfered <span class="amount">' . $CATAmt . '/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">' . $row['payment_mode'] . '</span>.</p>
                                            </div>
                                        </div>
                                    ';
                        }
                    } else {
                        echo '
                                    <div><p>No Transaction Found</p></div>
                                ';
                    }
                    ?>
                            
                    <div class="col-md-6 col-sm-6 col-6 pb-3 ps-2">
                        <a href="../../latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-start">View More</button></a>
                    </div>
                </div>

            </div>
        </div>
    
        <!-- Add New Event MODAL -->
        <div class="modal fade" id="event-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-3 px-4 border-bottom-0">
                        <h5 class="modal-title" id="modal-title">Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" name="event-form" id="form-event" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Event Name</label>
                                        <input class="form-control" placeholder="Insert Event Name"
                                            type="text" name="title" id="event-title" required value="" />

                                        <label class="form-label">Add Event Date</label>
                                        <input class="form-control" placeholder="Insert Event Data"
                                            type="date" name="title" id="event-date" required value="" />
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class=" text-end">
                                    <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- end modal-content-->
            </div> <!-- end modal dialog-->
        </div>
        <!-- end modal-->
    </div>
</div>