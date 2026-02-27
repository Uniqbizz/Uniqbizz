<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="mb-sm-0 font-size-18">Top Performer</h4>
        </div>
    </div>
</div>

<div class="card rounded-4">
    <div class="row p-4 d-flex justify-content-around">
        <div class="col-md-12 col-sm-12 col-12 d-grid align-items-center mb-3">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(1, this)" type="button" class="rounded-4 bg-primary-subtle btn fw-bolder fs-5 text-primary-emphasis py-4 w-100 text-center mb-2">
                        Top 5 BCH
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(2, this)" type="button" class="rounded-4 bg-success-subtle btn fw-bolder fs-5 text-success-emphasis py-4 w-100 text-center mb-2">
                        Top 5 BDM
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(3, this)" type="button" class="rounded-4 bg-warning-subtle btn fw-bolder fs-5 text-warning-emphasis py-4 w-100 text-center mb-2">
                        Top 5 BM
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(4, this)" type="button" class="rounded-4 bg-danger-subtle btn fw-bolder fs-5 text-danger-emphasis py-4 w-100 text-center mb-2">
                        Top 5 TE
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(5, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                        Top 5 TC
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(6, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                        Top 5 Customer
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(7, this)" type="button" class="rounded-4 bg-indigo-subtle btn fw-bolder fs-5 text-indigo-emphasis py-4 w-100 text-center mb-2">
                        Top 5 MF
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(8, this)" type="button" class="rounded-4 bg-teal-subtle btn fw-bolder fs-5 text-teal-emphasis py-4 w-100 text-center mb-2">
                        Top 5 SF
                    </button>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <button onclick="showDiv(9, this)" type="button" class="rounded-4 bg-orange-subtle btn fw-bolder fs-5 text-orange-emphasis py-4 w-100 text-center mb-2">
                        Top 5 Franchisee
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-12">
            <div class="card-body contentDiv rounded-4 border border-5 border-primary-subtle" id="div1" style="display: block;">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer BCH</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_BCH" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>ID - Name</th>
                                <th>BDM Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="bch_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query
                            $sql1 = $conn->prepare("
                                            SELECT e1.employee_id AS BCH_user_id,
                                                e1.name AS BCH_user_name,
                                                e1.profile_pic,
                                                e1.status,
                                                COUNT(e2.employee_id) AS BDM_count
                                            FROM employees e1
                                            LEFT JOIN employees e2 ON e1.employee_id = e2.reporting_manager
                                            WHERE e1.user_type = 24 
                                            AND e2.user_type = 25 
                                            AND MONTH(e2.register_date) = '" . $Month . "' 
                                            AND YEAR(e2.register_date) = '" . $Year . "'
                                            AND e1.status = 1
                                            AND e2.status = 1
                                            GROUP BY e1.employee_id, e1.name, e1.profile_pic, e1.status
                                            ORDER BY BDM_count DESC
                                            LIMIT 5
                                        ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BCH user details
                                foreach ($sql1->fetchAll() as $bch_id) {
                                    echo '<tr>
                                            <td>
                                                <div class="profile-pic pb-1">
                                                    <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="profile-pic pb-1">
                                                    <img src="../../../uploading/' . htmlspecialchars($bch_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                </div>
                                            </td>
                                            <td class="align-content-center">
                                                <p class="fw-bold text-dark">' . htmlspecialchars($bch_id['BCH_user_name']) . '</p>
                                                <p class="text-dark">' . htmlspecialchars($bch_id['BCH_user_id']) . '</p> 
                                            </td>
                                            <td class="align-content-center">' . htmlspecialchars($bch_id['BDM_count']) . '</td>';

                                    // Display status based on the 'status' field value
                                    if ($bch_id['status'] == '1') {
                                        echo '<td class="align-content-center"><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                    } else {
                                        echo '<td class="align-content-center"><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                    }
                                    echo '</tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-success-subtle" id="div2">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer BDM</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_BDM" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>ID - Name</th>
                                <th>BM Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="bdm_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the BDM user who brought the highest number of BM
                            $sql1 = $conn->prepare("
                                        SELECT e1.employee_id AS BDM_user_id,
                                            e1.name AS BDM_user_name,
                                            e1.reporting_manager,
                                            e1.profile_pic,
                                            e1.status,
                                            COUNT(e2.business_mentor_id) AS BM_count
                                        FROM employees e1
                                        LEFT JOIN business_mentor e2 ON e1.employee_id = e2.reference_no
                                        WHERE e1.user_type = 25 
                                        AND e2.user_type = 26 
                                        AND MONTH(e2.register_date) = '" . $Month . "' 
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.employee_id, e1.name, e1.profile_pic, e1.reporting_manager, e1.status
                                        ORDER BY BM_count DESC
                                        LIMIT 5 
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $bdm_id) {

                                    $sql2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $bdm_id['reporting_manager'] . "'");
                                    $sql2->execute();
                                    $sql2->setFetchMode(PDO::FETCH_ASSOC);
                                    $reporting_manager = $sql2->fetch();
                                    $reporting_manager_name = $reporting_manager['name'];

                                    echo '<tr>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../../uploading/' . htmlspecialchars($bdm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td class="align-content-center">
                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bdm_id['BDM_user_name']) . ' </p>
                                            <p class="text-dark">' . htmlspecialchars($bdm_id['BDM_user_id']) . '</p> 
                                        </td>
                                        <td class="align-content-center">' . htmlspecialchars($bdm_id['BM_count']) . '</td>
                                        <td class="align-content-center">
                                            <p class="mb-1 fw-bold text-dark">' . htmlspecialchars($reporting_manager_name) . '</p>
                                            <p class="mb-1 text-dark">' . htmlspecialchars($bdm_id['reporting_manager']) . '</p>
                                        </td>
                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div3">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer BM</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_BM" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>TE Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="bm_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the BDM user who brought the highest number of BM
                            $sql1 = $conn->prepare("
                                        SELECT e1.business_mentor_id AS BM_user_id,
                                            e1.firstname AS BM_user_fname,
                                            e1.lastname AS BM_user_lname,
                                            e1.reference_no,
                                            e1.registrant,
                                            e1.profile_pic,
                                            e1.status,
                                            COUNT(e2.corporate_agency_id) AS TE_count
                                        FROM business_mentor e1
                                        LEFT JOIN corporate_agency e2 ON e1.business_mentor_id = e2.reference_no
                                        WHERE e1.user_type = 26 -- BDM users
                                        AND e2.user_type = 16 -- BM users
                                        AND MONTH(e2.register_date) = '" . $Month . "'
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.business_mentor_id, e1.firstname, e1.lastname, e1.reference_no, e1.registrant, e1.profile_pic, e1.status
                                        ORDER BY TE_count DESC
                                        LIMIT 5 -- Limit to top 5 BDM users who brought the most BM;;
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $bm_id) {
                                    echo '<tr>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../../uploading/' . htmlspecialchars($bm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td class="align-content-center">
                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bm_id['BM_user_fname'] . ' ' . $bm_id['BM_user_lname']) . ' </p>
                                            <p class="text-dark">' . htmlspecialchars($bm_id['BM_user_id']) . '</p> 
                                        </td>
                                        <td class="align-content-center">' . htmlspecialchars($bm_id['TE_count']) . '</td>
                                        <td class="align-content-center">
                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($bm_id['registrant']) . '</p>
                                            <p class="mb-1 text-dark">' . htmlspecialchars($bm_id['reference_no']) . '</p>
                                        </td>   
                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-danger-subtle" id="div4">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer TE</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_TE" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>TA Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="te_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the BDM user who brought the highest number of BM
                            $sql1 = $conn->prepare("
                                        SELECT e1.corporate_agency_id AS TE_user_id,
                                            e1.firstname AS TE_user_fname,
                                            e1.lastname AS TE_user_lname,
                                            e1.reference_no,
                                            e1.registrant,
                                            e1.profile_pic,
                                            e1.status,
                                            COUNT(e2.ca_travelagency_id) AS TA_count
                                        FROM corporate_agency e1
                                        LEFT JOIN ca_travelagency e2 ON e1.corporate_agency_id = e2.reference_no
                                        WHERE e1.user_type = 16 
                                        AND e2.user_type = 11 
                                        AND MONTH(e2.register_date) = '" . $Month . "'
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.corporate_agency_id, e1.firstname, e1.lastname, e1.reference_no, e1.registrant, e1.profile_pic, e1.status
                                        ORDER BY TA_count DESC
                                        LIMIT 5 
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $te_id) {
                                    echo '<tr>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../../uploading/' . htmlspecialchars($te_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td class="align-content-center">
                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($te_id['TE_user_fname'] . ' ' . $te_id['TE_user_lname']) . ' </p>
                                            <p class="text-dark">' . htmlspecialchars($te_id['TE_user_id']) . '</p> 
                                        </td>
                                        <td class="align-content-center">' . htmlspecialchars($te_id['TA_count']) . '</td>
                                        <td class="align-content-center">
                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($te_id['registrant']) . '</p>
                                            <p class="mb-1 text-dark">' . htmlspecialchars($te_id['reference_no']) . '</p>
                                        </td>
                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-info-subtle" id="div5">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer TC</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_TA" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>CU Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="ta_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the BDM user who brought the highest number of BM
                            $sql1 = $conn->prepare("
                                        SELECT e1.ca_travelagency_id AS TA_user_id,
                                            e1.firstname AS TA_user_fname,
                                            e1.lastname AS TA_user_lname,
                                            e1.profile_pic,
                                            e1.reference_no,
                                            e1.registrant,
                                            e1.status,
                                            COUNT(e2.ca_customer_id) AS CU_count
                                        FROM ca_travelagency e1
                                        LEFT JOIN ca_customer e2 ON e1.ca_travelagency_id = e2.ta_reference_no
                                        WHERE e1.user_type = 11 
                                        AND e2.user_type = 10 
                                        AND MONTH(e2.register_date) = '" . $Month . "'
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.ca_travelagency_id, e1.firstname, e1.lastname, e1.profile_pic,  e1.reference_no, e1.registrant, e1.status
                                        ORDER BY CU_count DESC
                                        LIMIT 5 
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $ta_id) {
                                    echo '<tr>
                                            <td>
                                                <div class="profile-pic pb-1">
                                                    <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="profile-pic pb-1">
                                                    <img src="../../../uploading/' . htmlspecialchars($ta_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                </div>
                                            </td>
                                            <td class="align-content-center">
                                                <p class="fw-bold text-dark">' . htmlspecialchars($ta_id['TA_user_fname'] . ' ' . $ta_id['TA_user_lname']) . '</p>
                                                <p class="fw-bold text-dark">' . htmlspecialchars($ta_id['TA_user_id']) . '</p> 
                                            </td>
                                            <td class="align-content-center">' . htmlspecialchars($ta_id['CU_count']) . '</td>
                                            <td class="align-content-center">
                                                <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($ta_id['registrant']) . '</p>
                                                <p class="mb-1 text-dark">' . htmlspecialchars($ta_id['reference_no']) . '</p>
                                            </td>
                                    
                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-secondary-subtle" id="div6">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer Customer</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_CU" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>CU Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="cu_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the BDM user who brought the highest number of BM
                            $sql1 = $conn->prepare("
                                        SELECT e1.ca_customer_id AS CU_user_id,
                                            e1.firstname AS CU_user_fname,
                                            e1.lastname AS CU_user_lname,
                                            e1.ta_reference_no,
                                            e1.ta_reference_name,
                                            e1.profile_pic,
                                            e1.status,
                                            COUNT(e2.ca_customer_id) AS CUL_count
                                        FROM ca_customer e1
                                        LEFT JOIN ca_customer e2 ON e1.ca_customer_id = e2.reference_no
                                        WHERE e1.user_type = 10 
                                        AND e2.user_type = 10 
                                        AND MONTH(e2.register_date) = '" . $Month . "'
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.ca_customer_id, e1.firstname, e1.lastname, e1.ta_reference_no, e1.ta_reference_name, e1.profile_pic, e1.status
                                        ORDER BY CUL_count DESC
                                        LIMIT 5 
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $cu_id) {
                                    echo '<tr>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../../uploading/' . htmlspecialchars($cu_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td class="align-content-center">
                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($cu_id['CU_user_fname'] . ' ' . $cu_id['CU_user_lname']) . ' </p>
                                            <p class="text-dark">' . htmlspecialchars($cu_id['CU_user_id']) . '</p> 
                                        </td>
                                        <td class="align-content-center">' . htmlspecialchars($cu_id['CUL_count']) . '</td>
                                        <td class="align-content-center">
                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($cu_id['ta_reference_name']) . '</p>
                                            <p class="mb-1 text-dark">' . htmlspecialchars($cu_id['ta_reference_no']) . '</p>
                                        </td>

                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div7">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer MF</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_MF" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>TE Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="mf_top_performer">
                            <?php
                                $srNo = 1;
                                // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                $sql1 = $conn->prepare("
                                    SELECT 
                                        e1.master_franchisee_id AS MF_user_id,
                                        e1.firstname AS MF_user_fname,
                                        e1.lastname AS MF_user_lname,
                                        e1.reference_no,
                                        e1.registrant,
                                        e1.profile_pic,
                                        e1.status,
                                        COUNT(all_users.user_id) AS TE_count
                                    FROM master_franchisee e1
                                    LEFT JOIN (
                                        SELECT reference_no, corporate_agency_id AS user_id, register_date 
                                        FROM corporate_agency 
                                        WHERE user_type = 16
                                        UNION ALL
                                        SELECT reference_no, sub_franchisee_id AS user_id, register_date 
                                        FROM sub_franchisee
                                        WHERE user_type = 29
                                    ) AS all_users
                                    ON all_users.reference_no = e1.master_franchisee_id
                                    WHERE e1.user_type = 28
                                    AND MONTH(all_users.register_date) = :month
                                    AND YEAR(all_users.register_date) = :year
                                    GROUP BY 
                                        e1.master_franchisee_id, 
                                        e1.firstname, 
                                        e1.lastname, 
                                        e1.reference_no, 
                                        e1.registrant, 
                                        e1.profile_pic, 
                                        e1.status
                                    HAVING TE_count > 0 
                                    ORDER BY TE_count DESC
                                    LIMIT 5;
                                ");

                                $sql1->execute([
                                    ':month' => $Month,
                                    ':year'  => $Year
                                ]);

                                // Set the fetch mode to associative array
                                $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                if ($sql1->rowCount() > 0) {
                                    // Loop through the results and display the BDM user details
                                    foreach ($sql1->fetchAll() as $mf_id) {
                                        echo '<tr>
                                                <td>
                                                    <div class="profile-pic pb-1">
                                                        <img src="../../assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="profile-pic pb-1">
                                                        <img src="../../../uploading/' . htmlspecialchars($mf_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                    </div>
                                                </td>
                                                <td class="align-content-center"><p>' . htmlspecialchars($mf_id['MF_user_id']) . '</p> <p> ' . htmlspecialchars($mf_id['MF_user_fname'].' '.$mf_id['MF_user_lname']) . ' </p></td>
                                                <td class="align-content-center">' . htmlspecialchars($mf_id['TE_count']) . '</td>
                                                <td class="align-content-center">
                                                    <p class="mb-1">' . htmlspecialchars($mf_id['reference_no']) . '</p>
                                                    <p class="mb-0">' . htmlspecialchars($mf_id['registrant']) . '</p>
                                                </td>

                                        </tr>';
                                        $srNo++;
                                    }
                                } else {
                                    echo '<tr>
                                            <td colspan="5" class="align-content-center">No data found</td>
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div8">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer SF</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_SF" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>TE Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="sf_top_performer">
                            <?php
                                $srNo = 1;
                                // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                $sql1 = $conn->prepare("
                                    SELECT 
                                        e1.sponsor_franchisee_id AS SF_user_id,
                                        e1.firstname AS SF_user_fname,
                                        e1.lastname AS SF_user_lname,
                                        e1.reference_no,
                                        e1.registrant,
                                        e1.profile_pic,
                                        e1.status,
                                        COUNT(all_users.user_id) AS TE_count
                                    FROM sponsor_franchisee e1
                                    LEFT JOIN (
                                        SELECT reference_no, corporate_agency_id AS user_id, register_date 
                                        FROM corporate_agency 
                                        WHERE user_type = 16
                                        UNION ALL
                                        SELECT reference_no, sub_franchisee_id AS user_id, register_date 
                                        FROM sub_franchisee
                                        WHERE user_type = 29
                                    ) AS all_users
                                    ON all_users.reference_no = e1.sponsor_franchisee_id
                                    WHERE e1.user_type = 30
                                    AND MONTH(all_users.register_date) = :month
                                    AND YEAR(all_users.register_date) = :year
                                    GROUP BY 
                                        e1.sponsor_franchisee_id, 
                                        e1.firstname, 
                                        e1.lastname, 
                                        e1.reference_no, 
                                        e1.registrant, 
                                        e1.profile_pic, 
                                        e1.status
                                    HAVING TE_count > 0 
                                    ORDER BY TE_count DESC
                                    LIMIT 5;
                                ");

                                $sql1->execute([
                                    ':month' => $Month,
                                    ':year'  => $Year
                                ]);

                                // Set the fetch mode to associative array
                                $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                if ($sql1->rowCount() > 0) {
                                    // Loop through the results and display the BDM user details
                                    foreach ($sql1->fetchAll() as $sf_id) {
                                        echo '<tr>
                                                <td>
                                                    <div class="profile-pic pb-1">
                                                        <img src="../../assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="profile-pic pb-1">
                                                        <img src="../../../uploading/' . htmlspecialchars($sf_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                    </div>
                                                </td>
                                                <td class="align-content-center"><p>' . htmlspecialchars($sf_id['SF_user_id']) . '</p> <p> ' . htmlspecialchars($sf_id['SF_user_fname'].' '.$sf_id['SF_user_lname']) . ' </p></td>
                                                <td class="align-content-center">' . htmlspecialchars($sf_id['TE_count']) . '</td>
                                                <td class="align-content-center">
                                                    <p class="mb-1">' . htmlspecialchars($sf_id['reference_no']) . '</p>
                                                    <p class="mb-0">' . htmlspecialchars($sf_id['registrant']) . '</p>
                                                </td>

                                        </tr>';
                                        $srNo++;
                                    }
                                } else {
                                    echo '<tr>
                                            <td colspan="5" class="align-content-center">No data found</td>
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div9">
                <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                    <div class="heading">
                        <h4>Top 5 Performer Franchisee</h4>
                    </div>
                    <div class="text-end d-flex align-items-center">
                        <span class="fs-6">
                            <p>Select Month & Year</p>
                            <input type="month" id="month_year_FR" value="" min="2020-01" max="">
                        </span>
                    </div>
                </div>
                <hr>
                <div class="col-12 table-responsive text-center">
                    <table class="table mb-0">
                        <thead class="bg-primary-subtle">
                            <tr class="bg-primary-subtle">
                                <th>Ranks</th>
                                <th>Profile Pic</th>
                                <th>Name</th>
                                <th>TC Count</th>
                                <th>Referral</th>
                            </tr>
                        </thead>
                        <tbody id="fr_top_performer">
                            <?php
                            $srNo = 1;
                            // Prepare the SQL query to get the Franchisee fr user who brought the highest number of TC
                            $sql1 = $conn->prepare("
                                        SELECT e1.sub_franchisee_id AS FR_user_id,
                                            e1.firstname AS FR_user_fname,
                                            e1.lastname AS FR_user_lname,
                                            e1.reference_no,
                                            e1.registrant,
                                            e1.profile_pic,
                                            e1.status,
                                            COUNT(e2.ca_travelagency_id) AS TC_count
                                        FROM sub_franchisee e1
                                        LEFT JOIN ca_travelagency e2 ON e1.sub_franchisee_id = e2.reference_no
                                        WHERE e1.user_type = 29 
                                        AND e2.user_type = 11
                                        AND MONTH(e2.register_date) = '" . $Month . "'
                                        AND YEAR(e2.register_date) = '" . $Year . "' 
                                        GROUP BY e1.sub_franchisee_id, e1.firstname, e1.lastname, e1.reference_no, e1.registrant, e1.profile_pic, e1.status
                                        ORDER BY TC_count DESC
                                        LIMIT 5;
                                    ");

                            // Execute the query
                            $sql1->execute();

                            // Set the fetch mode to associative array
                            $sql1->setFetchMode(PDO::FETCH_ASSOC);

                            if ($sql1->rowCount() > 0) {
                                // Loop through the results and display the BDM user details
                                foreach ($sql1->fetchAll() as $fr_id) {
                                    echo '<tr>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="profile-pic pb-1">
                                                <img src="../../../uploading/' . htmlspecialchars($fr_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                            </div>
                                        </td>
                                        <td class="align-content-center">
                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($fr_id['FR_user_fname'] . ' ' . $fr_id['FR_user_lname']) . ' </p>
                                            <p class="text-dark">' . htmlspecialchars($fr_id['FR_user_id']) . '</p> 
                                        </td>
                                        <td class="align-content-center">' . htmlspecialchars($fr_id['TC_count']) . '</td>
                                        <td class="align-content-center">
                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($fr_id['registrant']) . '</p>
                                            <p class="mb-1 text-dark">' . htmlspecialchars($fr_id['reference_no']) . '</p>
                                        </td>   
                                    </tr>';
                                    $srNo++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="5" class="align-content-center">No data found</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>