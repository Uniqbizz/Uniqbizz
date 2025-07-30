<?php
    // Include the database connection file
    include '../../connect.php';

    $table_name = $_POST['table_update'];
    $Month = $_POST['month']; 
    $Year = $_POST['year'];

    if($table_name == 'bch_top_performer'){
       
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
            AND MONTH(e2.register_date) = '".$Month."' 
            AND YEAR(e2.register_date) = '".$Year."'
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

        if( $sql1 -> rowCount()>0){
        // Loop through the results and display the BCH user details
        foreach ($sql1->fetchAll() as $bch_id) {
            echo '<tr>
                    <td>
                        <div class="profile-pic pb-1">
                            <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                        </div>
                    </td>
                    <td>
                        <div class="profile-pic pb-1">
                            <img src="../uploading/' . htmlspecialchars($bch_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                        </div>
                    </td>
                    <td class="align-content-center"><p>' . htmlspecialchars($bch_id['BCH_user_id']). '</p> <p>'. htmlspecialchars($bch_id['BCH_user_name']) .'</p></td>
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
        }else{
        echo '<tr>
                <td colspan="5" class="align-content-center">No data found</td>
            </tr>';
        }
                                                    
    }else if($table_name == 'bdm_top_performer'){
        
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
            AND MONTH(e2.register_date) = '".$Month."' 
            AND YEAR(e2.register_date) = '".$Year."' 
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

                $sql2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$bdm_id['reporting_manager']."'");
                $sql2->execute();
                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                $reporting_manager = $sql2->fetch();
                $reporting_manager_name = $reporting_manager['name'];

                echo '<tr>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="../uploading/' . htmlspecialchars($bdm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td class="align-content-center"><p>' . htmlspecialchars($bdm_id['BDM_user_id']) . '</p> <p> ' . htmlspecialchars($bdm_id['BDM_user_name']) . ' </p></td>
                        <td class="align-content-center">' . htmlspecialchars($bdm_id['BM_count']) . '</td>
                        <td class="align-content-center">
                            <p class="mb-1">' . htmlspecialchars($bdm_id['reporting_manager']) . '</p>
                            <p class="mb-1">' . htmlspecialchars($reporting_manager_name) . '</p>
                        </td>
                </tr>';
                $srNo++;
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="align-content-center">No data found</td>
                </tr>';
        }
                                                    
    }else if($table_name == 'bm_top_performer'){
       
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
            AND MONTH(e2.register_date) = '".$Month."'
            AND YEAR(e2.register_date) = '".$Year."' 
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
                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="../uploading/' . htmlspecialchars($bm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td class="align-content-center"><p>' . htmlspecialchars($bm_id['BM_user_id']) . '</p> <p> ' . htmlspecialchars($bm_id['BM_user_fname'].' '.$bm_id['BM_user_lname']) . ' </p></td>
                        <td class="align-content-center">' . htmlspecialchars($bm_id['TE_count']) . '</td>
                        <td class="align-content-center">
                            <p class="mb-1">' . htmlspecialchars($bm_id['reference_no']) . '</p>
                            <p class="mb-0">' . htmlspecialchars($bm_id['registrant']) . '</p>
                        </td>   
                    </tr>';
                $srNo++;
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="align-content-center">No data found</td>
                </tr>';
        }
                                                
                                                
    }else if($table_name == 'te_top_performer'){
        
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
            AND MONTH(e2.register_date) = '".$Month."'
            AND YEAR(e2.register_date) = '".$Year."' 
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
                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="../uploading/' . htmlspecialchars($te_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td class="align-content-center"><p>' . htmlspecialchars($te_id['TE_user_id']) . '</p> <p> ' . htmlspecialchars($te_id['TE_user_fname'].' '.$te_id['TE_user_lname']) . ' </p></td>
                        <td class="align-content-center">' . htmlspecialchars($te_id['TA_count']) . '</td>
                        <td class="align-content-center">
                            <p class="mb-1">' . htmlspecialchars($te_id['reference_no']) . '</p>
                            <p class="mb-0">' . htmlspecialchars($te_id['registrant']) . '</p>
                        </td>
                    </tr>';
                $srNo++;
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="align-content-center">No data found</td>
                </tr>';
        }
                                                
    }else if($table_name == 'ta_top_performer'){
        
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
            AND MONTH(e2.register_date) = '".$Month."'
            AND YEAR(e2.register_date) = '".$Year."' 
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
                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="../uploading/' . htmlspecialchars($ta_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td class="align-content-center"><p>' . htmlspecialchars($ta_id['TA_user_id']) . '</p> <p>' . htmlspecialchars($ta_id['TA_user_fname'].' '.$ta_id['TA_user_lname']) . '</p></td>
                        <td class="align-content-center">' . htmlspecialchars($ta_id['CU_count']) . '</td>
                        <td class="align-content-center">
                            <p class="mb-1">' . htmlspecialchars($ta_id['reference_no']) . '</p>
                            <p class="mb-0">' . htmlspecialchars($ta_id['registrant']) . '</p>
                        </td>
                
                </tr>';
                $srNo++;
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="align-content-center">No data found</td>
                </tr>';
        }
    
                                                   
    }else if($table_name == 'cu_top_performer'){
       
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
            AND MONTH(e2.register_date) = '".$Month."'
            AND YEAR(e2.register_date) = '".$Year."' 
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
                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td>
                            <div class="profile-pic pb-1">
                                <img src="../uploading/' . htmlspecialchars($cu_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                            </div>
                        </td>
                        <td class="align-content-center"><p>' . htmlspecialchars($cu_id['CU_user_id']) . '</p> <p> ' . htmlspecialchars($cu_id['CU_user_fname'].' '.$cu_id['CU_user_lname']) . ' </p></td>
                        <td class="align-content-center">' . htmlspecialchars($cu_id['CUL_count']) . '</td>
                        <td class="align-content-center">
                            <p class="mb-1">' . htmlspecialchars($cu_id['ta_reference_no']) . '</p>
                            <p class="mb-0">' . htmlspecialchars($cu_id['ta_reference_name']) . '</p>
                        </td>

                </tr>';
                $srNo++;
            }
        } else {
            echo '<tr>
                    <td colspan="5" class="align-content-center">No data found</td>
                </tr>';
        }
    
    
    }
?>