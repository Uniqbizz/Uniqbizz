<!-- upcoming birthdays -->
<div class="col-xl-4 col-lg-12">
    <div class="card rounded-4">
        <div class="d-flex justify-content-between">
            <h2 class="fs-4 p-3 px-2">Upcoming Birthdays</h2>
            <div class="mt-2 me-2">
                <a href="upcoming_birthday/upcoming_birthday.php"><button class="cpn_btn box-btn">View More</button></a>
            </div>
        </div>
        <div class="row mx-0">
        <?php

            $stmt = $conn->prepare("
                SELECT *
                FROM (
                    SELECT 
                        cte.chief_techno_enterprise_id AS user_id,
                        CONCAT(cte.firstname, ' ', cte.lastname) AS fullname,
                        cte.date_of_birth,
                        d.profile_pic AS profile_pic,
                        cte.status,
                        'Chief Techno Enterprise' AS userName
                    FROM chief_techno_enterprise cte
                    LEFT JOIN documents d 
                        ON d.user_id = cte.chief_techno_enterprise_id

                    UNION ALL

                    SELECT 
                        ete.executive_techno_enterprise_id AS user_id,
                        CONCAT(ete.firstname, ' ', ete.lastname) AS fullname,
                        ete.date_of_birth,
                        d.profile_pic AS profile_pic,
                        ete.status,
                        'executive Techno Enterprise' AS userName
                    FROM executive_techno_enterprise ete
                    LEFT JOIN documents d 
                        ON d.user_id = ete.executive_techno_enterprise_id

                    UNION ALL

                    SELECT 
                        ste.super_techno_enterprise_id AS user_id,
                        CONCAT(ste.firstname, ' ', ste.lastname) AS fullname,
                        ste.date_of_birth,
                        d.profile_pic AS profile_pic,
                        ste.status,
                        'super Techno Enterprise' AS userName
                    FROM super_techno_enterprise ste
                    LEFT JOIN documents d 
                        ON d.user_id = ste.super_techno_enterprise_id

                    UNION ALL

                    SELECT 
                        business_mentor_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Business Mentor' AS userName
                    FROM business_mentor

                    UNION ALL

                    SELECT 
                        master_franchisee_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Master Franchisee' AS userName
                    FROM master_franchisee

                    UNION ALL

                    SELECT 
                        sponsor_franchisee_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Sponsor Franchisee' AS userName
                    FROM sponsor_franchisee

                    UNION ALL

                    SELECT 
                        corporate_agency_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Techno Enterprise' AS userName
                    FROM corporate_agency

                    UNION ALL

                    SELECT 
                        sub_franchisee_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Franchisee' AS userName
                    FROM sub_franchisee

                    UNION ALL

                    SELECT 
                        institution_id AS user_id,
                        name AS fullname,
                        incorporation_date AS date_of_birth,
                        address_proof AS profile_pic,
                        status,
                        'Institution' AS userName
                    FROM institution

                    UNION ALL

                    SELECT 
                        ca_travelagency_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Travel Consultant' AS userName
                    FROM ca_travelagency

                    UNION ALL

                    SELECT 
                        institution_branch_manager_id as user_id, 
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Institution Branch Manager' AS userName
                    FROM institution_branch_manager

                    UNION ALL 

                    SELECT 
                        ca_customer_id AS user_id,
                        CONCAT(firstname, ' ', lastname) AS fullname,
                        date_of_birth,
                        profile_pic,
                        status,
                        'Customer' AS userName
                    FROM ca_customer

                ) users

                WHERE date_add(
                    date_of_birth,
                    INTERVAL YEAR(CURDATE()) - YEAR(date_of_birth)
                    + IF(
                        DAYOFYEAR(CURDATE()) > DAYOFYEAR(date_of_birth),
                        1,
                        0
                    ) YEAR
                ) BETWEEN CURDATE() 
                    AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)

                ORDER BY MONTH(date_of_birth), DAY(date_of_birth)

                LIMIT 12
            ");

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($stmt->rowCount()>0){
                foreach (($stmt->fetchAll()) as $key => $row) {
                    $user_id = $row['user_id'];
                    $fullname =  $row['fullname'];
                    $userName = $row['userName'];

                    $profile_pic = $row['profile_pic'];
                    $imgPath = '../uploading/'.$profile_pic;

                    $today = date("Y-m-d");
                    $dob = $row['date_of_birth'];
                    $birthDate = date("d-m-Y", strtotime($dob));
                    $get_age = date_diff(date_create($birthDate), date_create($today));
                    
                    // find days difference from today
                    $dayMonth = date("d-M", strtotime($dob));
                    $cust_dob = date("Y").'-'.date("m", strtotime($dob)).'-'.date("d", strtotime($dob));
                    $now = time(); 
                    $new_dob = strtotime($cust_dob);
                    $datediff = $new_dob - $now;
                    $daysLeft = round($datediff / (60 * 60 * 24));
                    
                    //get customer details
                    // $user = userDetails($conn,$user_id,$type);
                    // $name = $user[0];
                    // $fullname = $user[1];

                    echo '<div class="col-xl-3 col-lg-3 col-md-2 col-sm-2 col-2 pe-0">
                        <div class="profile-pic pb-1" style="position: relative; left: 5px;">
                            <img src="'.$imgPath.'" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-6 col-sm-6 col-6 px-0">
                        <div class="name fw-bold fs-5">'.$fullname.'</br> <span class="fw-normal fontSizeTransaction">('.$userName.')</span></div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4 px-0">
                        <div class="name fw-bold fs-6 text-primary text-end me-3">'.$dayMonth.' &#127874;</span></div>
                    </div>
                    <hr />';
                }
            }
        ?>
        </div>
    </div>
</div>