<div class="tab-pane fade card px-2 rounded-4" id="activities" role="tabpanel">
    <?php
        // Fetch logs where user is either actor or target
        $stmt = $conn->prepare("SELECT * FROM `logs` WHERE reference_no = :id ORDER BY `id` DESC");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Function to determine user type and fetch user name + ID + profile pic
        function getUserDetails($conn, $title, $ref_id) {
            $table = '';
            $condition = '';
            $selectField = 'firstname, lastname, profile_pic';
            $idField = '';

            switch (true) {
                case strpos($title, 'Business Mentor') !== false:
                    $table = 'business_mentor';
                    $condition = 'reference_no = :ref_id';
                    $selectField .= ', business_mentor_id';
                    $idField = 'business_mentor_id';
                    break;
                case strpos($title, 'Travel Consultant') !== false:
                    $table = 'ca_travelagency';
                    $condition = 'reference_no = :ref_id';
                    $selectField .= ', ca_travelagency_id';
                    $idField = 'ca_travelagency_id';
                    break;
                case strpos($title, 'Customer') !== false:
                    $table = 'ca_customer';
                    // Use COALESCE to select either reference_no or ta_reference_no based on which is NOT NULL
                    $condition = 'COALESCE(reference_no, ta_reference_no) = :ref_id';
                    $selectField .= ', ca_customer_id';
                    $idField = 'ca_customer_id';
                    break;
                case strpos($title, 'Business Consultant') !== false:
                    $table = 'business_consultant';
                    $condition = 'reference_no = :ref_id';
                    $selectField .= ', business_consultant_id';
                    $idField = 'business_consultant_id';
                    break;
                case strpos($title, 'Techno Enterprise') !== false:
                    $table = 'corporate_agency';
                    $condition = 'reference_no = :ref_id';
                    $selectField .= ', corporate_agency_id';
                    $idField = 'corporate_agency_id';
                    break;
                case strpos($title, 'Business Development Manager') !== false:
                    $table = 'employees';
                    $condition = 'reference_no = :ref_id AND user_type = 25';
                    $selectField = 'name, employee_id, profile_pic';
                    $idField = 'employee_id';
                    break;
                default:
                    return ['name' => 'Unknown User', 'profile_pic' => 'not_uploaded.png'];
            }

            $stmtUser = $conn->prepare("SELECT $selectField FROM $table WHERE $condition");
            $stmtUser->execute(['ref_id' => $ref_id]);
            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if (!$user || !isset($user[$idField])) {
                return ['name' => 'Unknown User', 'profile_pic' => 'not_uploaded.png'];
            }

            // Compose user name
            $name = ($table === 'employees')
                ? $user['name'] . ' (' . $user[$idField] . ')'
                : trim($user['firstname'] . ' ' . $user['lastname']) . ' (' . $user[$idField] . ')';

            $profilePic = (!empty($user['profile_pic']) && file_exists("../../uploading/" . $user['profile_pic']))
                ? $user['profile_pic']
                : 'not_uploaded.png';

            return ['name' => $name, 'profile_pic' => $profilePic];
        }

        // Display logs
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');

                // Get user details
                $user = getUserDetails($conn, $row['title'], $row['reference_no']);

                echo '<div class="row pt-3">
                        <div class="col-md-2">
                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                <img src="../../uploading/' . htmlspecialchars($user['profile_pic']) . '" width="50" height="50" class="rounded-circle ms-3" />
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="">
                                <div class="card bg-light p-2 mt-2">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="">' . htmlspecialchars($row['title']) . ' - ' . htmlspecialchars($user['name']) . '</h4>
                                        <p class="d-inline">' . $rdate . '</p>
                                    </div>
                                    <p class="my-0 cardText">' . htmlspecialchars($row['message']) . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="row pt-3">
                    <div class="col-md-2">
                        <div class="d-flex align-items-center justify-content-center p-3 position">
                            <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="">
                            <div class="card bg-light p-2 mt-2">
                                <div class="d-flex justify-content-between">
                                    <h4 class="">-----</h4>
                                    <p class="d-inline">--/--/----</p>
                                </div>
                                <p class="my-0 cardText">No Activities Found</p>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    ?>
</div>