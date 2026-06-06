<!-- Calender   -->
<div class="col-xl-8 col-lg-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12" id="eventCalender">
            <!-- Full Calender Start-->
            <div class="card rounded-4">
                <div id="btn-new-event"></div>
                <div id='locale-selector' class="d-none"></div>
                <div class="card-body">
                    <div id="external-events">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#event-modal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addBusinessTraineemodal"><i class="mdi mdi-plus me-1"></i> Add Event</button>
                    </div>
                    <div id="calendar" class="calendarheight"></div>
                </div>
            </div>
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
                    </div>
                </div>
            </div>
            <!-- Full Calender end -->
        </div>
        <div class="col-xl-12 col-lg-12" id="latestTransaction">
            <!-- Latest Transaction Start-->
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
                            $imgPath = "../uploading/" . $dir . "/" . rawurlencode($file);
                            $CATAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
                            echo '
                                    <div class="row mx-0">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                                            <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                <img src="' . $imgPath . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div class="name fw-bold">' . $row['id'] . ' ' . $row['firstname'] . ' ' . $row['lastname'] . '</br> <span class="fw-normal fontSizeTransaction">(' . $designation . ')</span></div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                                    <div class="name fw-bold">Transfered</br> <span class="fw-normal fontSizeTransaction">' . $rdate . '</span></div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                                    <div class="name fw-bold text-success">&#8377; ' . $CATAmt . '/-</br> <span class="fw-normal text-dark fontSizeTransaction">' . $row['payment_mode'] . '</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                ';
                        }
                    } else {
                        echo '
                                <div><p>No Transaction Found</p></div>
                            ';
                    }
                ?>  
                <div class="col-md-12 col-sm-12 col-12 pb-3 pe-3">
                    <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-end">View More</button></a>
                </div>
            </div>
            <!-- Latest Transaction End-->
        </div>
    </div>
</div>