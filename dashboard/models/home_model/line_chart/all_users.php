<div class="row">
    <!-- Line Chart -->
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="card rounded-4">
            <div class="card-header rounded-top-4">
                <h4 class="card-title mb-0">Line Chart</h4>
            </div>
            <div class="card-body">
                <!-- <canvas id="lineChart" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.2", "--vz-primary", "--vz-success-rgb, 0.2", "--vz-success"]'></canvas> -->
                <div class="row">
                    <div class="col-12">
                        <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                            <span>
                                Select Year
                                <select id="years" onchange="getMonthlyUserData(this.value)"></select>
                            </span>
                        </div>

                        <div class="table-responsive table-desi m-3 mb-4">
                            <canvas id="myChart" style="width:100%;max-width:1000px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div style="display: none">
        <input type="month" id="month_year" value="" min="2020-01" max="">
    </div>
    <!-- Top Customers  Active / Inactive User Count -->
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="card rounded-4">
            <div class="card-header align-items-center d-flex rounded-top-4">
                <?php
                    if ($userType == "16") {
                        $topCustomerTableName = "Travel Agency";
                        $topCustomerTableRefCol = "CU";
                    } else if ($userType == "11" || $userType == '33') {
                        $topCustomerTableName = "Customers";
                        $topCustomerTableRefCol = "CU";
                    } else if ($userType == "10") { //customer can bring customer thay why $topCustomerTableName value is "Customer"
                        $topCustomerTableName = "Customers";
                        $topCustomerTableRefCol = "CU";
                    } else if ($userType == "24") {
                        $topCustomerTableName = "Business Development Manager";
                        $topCustomerTableRefCol = "BDM";
                    } else if ($userType == "25") {
                        $topCustomerTableName = "BM/TE/F/TC";
                        $topCustomerTableRefCol = "BM/TE/F/TC";
                    } else if ($userType == "26") {
                        $topCustomerTableName = "Travel Consultant";
                        $topCustomerTableRefCol = "TC";
                    }else if ($userType == "28") {
                        $topCustomerTableName = "Travel Consultant/Franchisee";
                        $topCustomerTableRefCol = "TC/F";
                    }else if ($userType == "29") {
                        $topCustomerTableName = "Travel Consultant";
                        $topCustomerTableRefCol = "TC";
                    }else if ($userType == "30") {
                        $topCustomerTableName = "Franchisee";
                        $topCustomerTableRefCol = "F";
                    }else if ($userType == "31") {
                        $topCustomerTableName = "(Master/Sponsor) Franchisee/Franchisee";
                        $topCustomerTableRefCol = "MF/SF";
                    }
                ?>
                <h4 class="card-title mb-0 flex-grow-1">Top <?php echo $topCustomerTableName; ?></h4>
            </div><!-- end card header -->

            <div class="card-body pb-2">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0" id="top-users">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date Reg</th>
                                <!-- <th scope="col">Status</th> -->
                                <th scope="col">Total <?php echo $topCustomerTableRefCol; ?> Ref</th>
                                <th scope="col">Active/ Inactive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            // corporate_agency
                            if ($userType == '16') {
                                $tableName1 = 'ca_travelagency';
                                $tableId1 = 'ca_travelagency_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'ta_reference_no';
                            }
                            // travel_agent
                            if ($userType == '11') {
                                $tableName1 = 'ca_customer';
                                $tableId1 = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'ta_reference_no';
                                $tableColumnName2 = 'reference_no';
                            }
                            // customer
                            if ($userType == '10') {
                                $tableName1 = 'ca_customer';
                                $tableId1 = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                            }
                            // Business Channel manager
                            if ($userType == '24') {
                                $tableName1 = 'employees'; //BDM
                                $tableId1 = 'employee_id'; //BDM ID
                                $tableNameDesignation = 'Business Development Manager';
                                $tableName2 = 'business_mentor';
                                $tableId2 = 'business_mentor_id';
                                $tableColumnName = 'reporting_manager';
                                $tableColumnName2 = 'reference_no';
                            }
                            // Business Development manager
                            if ($userType == '25') {
                                $tableName1 = 'business_mentor'; //TE
                                $tableId1 = 'business_mentor_id'; //TE ID
                                $tableNameDesignation = 'Business Development Manager';
                                $tableName2 = 'corporate_agency';
                                $tableId2 = 'corporate_agency_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                                //for direct TC
                                $tableName3 = 'ca_travelagency'; //TC
                                $tableId3 = 'ca_travelagency_id'; //TC ID
                                $tableNameDesignation2 = 'Travel Consultant';
                                $tableName4 = 'ca_customer';
                                $tableId4 = 'ca_customer_id';
                                $tableColumnName3 = 'reference_no';
                                $tableColumnName4 = 'ta_reference_no';
                                //for direct TE
                                $tableName5 = 'corporate_agency'; //TC
                                $tableId5 = 'corporate_agency_id'; //TC ID
                                $tableNameDesignation3 = 'Techno Enterprise';
                                $tableName6 = 'ca_travelagency';
                                $tableId6 = 'ca_travelagency_id';
                                $tableColumnName5 = 'reference_no';
                                $tableColumnName6 = 'reference_no';
                                //for direct F
                                $tableName7 = 'sub_franchisee'; //TC
                                $tableId7 = 'sub_franchisee_id'; //TC ID
                                $tableNameDesignation4 = 'Franchisee';
                                $tableName8 = 'ca_travelagency';
                                $tableId8 = 'ca_travelagency_id';
                                $tableColumnName7 = 'reference_no';
                                $tableColumnName8 = 'reference_no';
                                //for direct MF
                                //MF->F
                                $tableName9 = 'master_franchisee'; //TC
                                $tableId9 = 'master_franchisee_id'; //TC ID
                                $tableNameDesignation5 = 'Master Franchisee';
                                $tableName10 = 'sub_franchisee_id';
                                $tableId10 = 'sub_franchisee_id_id';
                                $tableColumnName9 = 'reference_no';
                                $tableColumnName10 = 'reference_no';
                                //Mf->TC
                                $tableName11 = 'ca_travelagency';
                                $tableId11 = 'ca_travelagency_id';
                                $tableColumnName11 = 'reference_no';
                                //for direct SF
                                $tableName12 = 'sponsor_franchisee'; //TC
                                $tableId12 = 'sponsor_franchisee_id'; //TC ID
                                $tableNameDesignation6 = 'Sponsor Franchisee';
                                $tableName13 = 'sub_franchisee';
                                $tableId13 = 'sub_franchisee_id';
                                $tableColumnName12 = 'reference_no';
                                $tableColumnName13 = 'reference_no';
                                
                            }
                            // Business Mentor
                            if ($userType == '26') {
                                //for TE
                                $tableName1 = 'corporate_agency'; //BDM
                                $tableId1 = 'corporate_agency_id'; //BDM ID
                                $tableNameDesignation = 'Techno Enterprise';
                                $tableName2 = 'ca_travelagency';
                                $tableId2 = 'ca_travelagency_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                                //for direct tc
                                $tableName3 = 'ca_travelagency'; //TC
                                $tableId3 = 'ca_travelagency_id'; //TC ID
                                $tableNameDesignation1 = 'Travel Consultant';
                                $tableName4 = 'ca_customer';
                                $tableId4 = 'ca_customer_id';
                                $tableColumnName1 = 'reference_no';
                                $tableColumnName3 = 'ta_reference_no';
                                
                            }
                            // Master Franchisee
                            if ($userType == '28') {
                                //franchisee
                                $tableName1 = 'sub_franchisee'; //BDM
                                $tableId1 = 'sub_franchisee_id'; //BDM ID
                                $tableNameDesignation = 'Franchisee';
                                $tableName2 = 'ca_travelagency';
                                $tableId2 = 'ca_travelagency_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                                //for direct tc
                                $tableName3 = 'ca_travelagency'; //BDM
                                $tableId3 = 'ca_travelagency_id'; //BDM ID
                                $tableNameDesignation2 = 'Travel Consultant';
                                $tableName4 = 'ca_customer';
                                $tableId4 = 'ca_customer_id';
                                $tableColumnName3 = 'reference_no';
                                $tableColumnName4 = 'ta_reference_no';
                            }
                            // Franchisee(sub_franchisee)
                            if ($userType == '29') {
                                $tableName1 = 'ca_travelagency';
                                $tableId1 = 'ca_travelagency_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'ta_reference_no';
                            }
                            // Sponsor Franchisee(sub_franchisee)
                            if ($userType == '30') {
                                $tableName1 = 'sub_franchisee'; //F
                                $tableId1 = 'sub_franchisee_id'; //F
                                $tableNameDesignation = 'Franchisee';
                                $tableName2 = 'ca_travelagency';
                                $tableId2 = 'ca_travelagency_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                            }
                            // Relationship Manager
                            if ($userType == '31') {
                                //for direct F
                                $tableName1 = 'sub_franchisee'; //TC
                                $tableId1 = 'sub_franchisee_id'; //TC ID
                                $tableNameDesignation = 'Franchisee';
                                $tableName2 = 'ca_travelagency';
                                $tableId2 = 'ca_travelagency_id';
                                $tableColumnName1 = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                                //for direct MF
                                //MF->F
                                $tableName3 = 'master_franchisee'; //TC
                                $tableId3 = 'master_franchisee_id'; //TC ID
                                $tableNameDesignation2 = 'Master Franchisee';
                                $tableName4 = 'sub_franchisee';
                                $tableId4 = 'sub_franchisee_id';
                                $tableColumnName3 = 'reference_no';
                                $tableColumnName4 = 'reference_no';
                                //Mf->TC
                                $tableName5 = 'ca_travelagency';
                                $tableId5 = 'ca_travelagency_id';
                                $tableColumnName5 = 'reference_no';
                                //for direct SF
                                $tableName6 = 'sponsor_franchisee'; //TC
                                $tableId6 = 'sponsor_franchisee_id'; //TC ID
                                $tableNameDesignation3 = 'Sponsor Franchisee';
                                $tableName7 = 'sub_franchisee';
                                $tableId7 = 'sub_franchisee_id';
                                $tableColumnName6 = 'reference_no';
                                $tableColumnName7 = 'reference_no';
                            }
                            // IBR(travel_agent)
                            if ($userType == '33') {
                                $tableName1 = 'ca_customer';
                                $tableId1 = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'ta_reference_no';
                                $tableColumnName2 = 'reference_no';
                            }
                            // Institution
                            if ($userType == '32') {
                                $tableName1 = 'institution_branch_manager';
                                $tableId1 = 'institution_branch_manager_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableName2 = 'ca_customer';
                                $tableId2 = 'ca_customer_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName2 = 'ta_reference_no';
                            }
                            // 21-02-2025 work from here for other 2 users BDM, BM, add user_type for all users - giving problem for BCH and BDM.
                            
                            
                            if($userType == '28'){
                                //get franchisee
                                $selectSF=$conn->prepare("SELECT COUNT(id) as total FROM sub_franchisee WHERE reference_no=? AND status='1'");
                                $selectSF->execute([$userId]);
                                $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
                                $countSF = $resultSF['total'];
                                //get TC
                                $selectTC=$conn->prepare("SELECT COUNT(id) as total FROM ca_travelagency WHERE reference_no=? AND status='1'");
                                $selectTC->execute([$userId]);
                                $resultTC = $selectTC->fetch(PDO::FETCH_ASSOC);
                                $countTC = $resultTC['total'];
                                if($countSF>0 && $countTC>0){
                                    $stmt2 = $conn->prepare("SELECT id,user_id,firstname,lastname,register_date FROM(
                                                                    SELECT id,sub_franchisee_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1'
                                                                    UNION
                                                                    SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1'
                                                                    )AS combined
                                                                    ORDER BY id DESC
                                                                    limit 5");
                                    $stmt2->execute([$userId, $userId]);
                                }else if($countSF>0){
                                    $stmt2=$conn->prepare("SELECT id,sub_franchisee_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
                                    $stmt2->execute([$userId]);
                                }else if($countTC>0){
                                    $stmt2=$conn->prepare("SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
                                    $stmt2->execute([$userId]);
                                }
                            }
                            else if($userType == '26'){
                                //get techno enterprise
                                $selectSF=$conn->prepare("SELECT COUNT(id) as total FROM corporate_agency WHERE reference_no=? AND status='1'");
                                $selectSF->execute([$userId]);
                                $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
                                $countSF = $resultSF['total'];
                                //get TC
                                $selectTC=$conn->prepare("SELECT COUNT(id) as total FROM ca_travelagency WHERE reference_no=? AND status='1'");
                                $selectTC->execute([$userId]);
                                $resultTC = $selectTC->fetch(PDO::FETCH_ASSOC);
                                $countTC = $resultTC['total'];
                                if($countSF>0 && $countTC>0){
                                    $stmt2 = $conn->prepare("SELECT id,user_id,firstname,lastname,register_date FROM(
                                                                    SELECT id,corporate_agency_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1'
                                                                    UNION
                                                                    SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1'
                                                                    )AS combined
                                                                    ORDER BY id DESC
                                                                    limit 5");
                                    $stmt2->execute([$userId, $userId]);
                                }else if($countSF>0){
                                    $stmt2=$conn->prepare("SELECT id,corporate_agency_id as user_id,firstname,lastname,register_date FROM $tableName1 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
                                    $stmt2->execute([$userId]);
                                }else if($countTC>0){
                                    $stmt2=$conn->prepare("SELECT id,ca_travelagency_id as user_id,firstname,lastname,register_date FROM $tableName3 WHERE reference_no=? AND status='1' ORDER BY id DESC limit 5");
                                    $stmt2->execute([$userId]);
                                }
                            }else if($userType == '25'){
                                $sql = "SELECT combined.id,
                                            combined.user_id,
                                            combined.firstname,
                                            combined.lastname,
                                            combined.register_date,
                                            combined.type
                                        FROM (
                                            -- BM
                                            SELECT bm.id,
                                                bm.business_mentor_id AS user_id,
                                                bm.firstname,
                                                bm.lastname,
                                                bm.register_date,
                                                'BM' AS type
                                            FROM business_mentor bm
                                            WHERE bm.reference_no = :userId AND bm.status = '1'

                                            UNION ALL

                                            -- TC
                                            SELECT tc.id,
                                                tc.ca_travelagency_id AS user_id,
                                                tc.firstname,
                                                tc.lastname,
                                                tc.register_date,
                                                'TC' AS type
                                            FROM ca_travelagency tc
                                            WHERE tc.reference_no = :userId AND tc.status = '1'

                                            UNION ALL

                                            -- TE
                                            SELECT te.id,
                                                te.corporate_agency_id AS user_id,
                                                te.firstname,
                                                te.lastname,
                                                te.register_date,
                                                'TE' AS type
                                            FROM corporate_agency te
                                            WHERE te.reference_no = :userId AND te.status = '1'

                                            UNION ALL

                                            -- F
                                            SELECT f.id,
                                                f.sub_franchisee_id AS user_id,
                                                f.firstname,
                                                f.lastname,
                                                f.register_date,
                                                'F' AS type
                                            FROM sub_franchisee f
                                            WHERE f.reference_no = :userId AND f.status = '1'

                                            UNION ALL

                                            -- MF
                                            SELECT mf.id,
                                                mf.master_franchisee_id AS user_id,
                                                mf.firstname,
                                                mf.lastname,
                                                mf.register_date,
                                                'MF' AS type
                                            FROM master_franchisee mf
                                            WHERE mf.reference_no = :userId AND mf.status = '1'

                                            UNION ALL

                                            -- SF
                                            SELECT sf.id,
                                                sf.sponsor_franchisee_id AS user_id,
                                                sf.firstname,
                                                sf.lastname,
                                                sf.register_date,
                                                'SF' AS type
                                            FROM sponsor_franchisee sf
                                            WHERE sf.reference_no = :userId AND sf.status = '1'

                                            UNION ALL

                                            -- I
                                            SELECT te.id,
                                                te.institution_id AS user_id,
                                                te.firstname,
                                                te.lastname,
                                                te.register_date,
                                                'TE' AS type
                                            FROM institution te
                                            WHERE te.reference_no = :userId AND te.status = '1'
                                        ) AS combined
                                        ORDER BY combined.id DESC
                                        LIMIT 5
                                    ";

                                    $stmt2 = $conn->prepare($sql);
                                    
                                    $stmt2->execute(['userId' => $userId]); 
                            }else if($userType == '31'){
                                                                                                    
                                $sql = "SELECT combined.id,
                                            combined.user_id,
                                            combined.firstname,
                                            combined.lastname,
                                            combined.register_date,
                                            combined.type
                                        FROM (
                                            -- F
                                            SELECT f.id,
                                                f.sub_franchisee_id AS user_id,
                                                f.firstname,
                                                f.lastname,
                                                f.register_date,
                                                'F' AS type
                                            FROM sub_franchisee f
                                            WHERE f.reference_no = :userId AND f.status = '1'
                                            
                                            UNION ALL
                                            
                                            -- MF
                                            SELECT mf.id,
                                                mf.master_franchisee_id AS user_id,
                                                mf.firstname,
                                                mf.lastname,
                                                mf.register_date,
                                                'MF' AS type
                                            FROM master_franchisee mf
                                            WHERE mf.reference_no = :userId AND mf.status = '1'
                                            
                                            UNION ALL
                                            
                                            -- SF
                                            SELECT sf.id,
                                                sf.sponsor_franchisee_id AS user_id,
                                                sf.firstname,
                                                sf.lastname,
                                                sf.register_date,
                                                'SF' AS type
                                            FROM sponsor_franchisee sf
                                            WHERE sf.reference_no = :userId AND sf.status = '1'
                                            
                                            UNION ALL
                                            
                                            -- TC
                                            SELECT tc.id,
                                                tc.ca_travelagency_id AS user_id,
                                                tc.firstname,
                                                tc.lastname,
                                                tc.register_date,
                                                'TC' AS type
                                            FROM ca_travelagency tc
                                            WHERE tc.reference_no = :userId AND tc.status = '1'

                                            UNION ALL
                                            
                                             -- I
                                            SELECT te.id,
                                                te.institution_id AS user_id,
                                                te.firstname,
                                                te.lastname,
                                                te.register_date,
                                                'TE' AS type
                                            FROM institution te
                                            WHERE te.reference_no = :userId AND te.status = '1'
                                        ) AS combined
                                        ORDER BY combined.id DESC
                                        LIMIT 5
                                    ";

                                $stmt2 = $conn->prepare($sql);
                                $stmt2->execute(['userId' => $userId]);

                                
                            }else{
                                if($userType == '24'){
                                    $name_colum=',name,';
                                }else{
                                    $name_colum=',firstname,lastname,';  
                                }
                                if($userType == '16'){
                                    $stmt2 = $conn->prepare("SELECT $tableId1 as user_id $name_colum register_date,
                                                                CASE WHEN tm.te_id IS NOT NULL THEN 1 ELSE 0 END AS alloted_check
                                                                FROM $tableName1 
                                                                LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = '" . $userId . "'
                                                                WHERE ($tableColumnName = ? OR tm.te_id = '" . $userId . "') AND status='1' 
                                                                order by $tableId1 desc limit 5");
                                }else{
                                    $stmt2 = $conn->prepare("SELECT $tableId1 as user_id $name_colum register_date FROM $tableName1 WHERE $tableColumnName = ? AND status='1' order by $tableId1 desc limit 5");
                                }
                                $stmt2->execute([$userId]);
                                
                            }
                            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            $count = 0; // Initialize count
                            $activeCount = 0; // Initialize count
                            $inactiveCount = 0; // Initialize count

                            foreach ($referrals as $referral) {

                                $rd = new DateTime($referral['register_date']);
                                $rdate = $rd->format('d-m-Y');
                                $id = $referral['user_id'];
                                if ($userType == '24') {
                                    $firstName = $referral['name'];
                                    $lastName = ' ';
                                } else {
                                    $firstName = $referral['firstname'];
                                    $lastName = $referral['lastname'];
                                    if($userType =='16'){
                                        if($referral['alloted_check'] == 1){
                                            $lastName.='<small class=" d-flex justify-content-center d-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea;">
                                                    Allotted TC
                                                    </small>';
                                        }
                                    }
                                }


                                //$status = $referral['status'];

                                if ($userType == '28') {
                                    if (substr($id,0,1)== 'F') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }else if (substr($id,0,2)== 'TA') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }

                                }else if ($userType == '26') {
                                    if (substr($id,0,2)== 'TE' || substr($id,0,2)== 'CA') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }else if (substr($id,0,2)== 'TA') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName3 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }

                                }else if ($userType == '25') {
                                    if (substr($id,0,2)== 'BM') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }else if (substr($id,0,2)== 'TA') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if (substr($id,0,2)== 'CA' ||substr($id,0,2)== 'TE') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId6 FROM $tableName6 WHERE $tableColumnName6 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId6 FROM $tableName6 WHERE $tableColumnName6 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId6 FROM $tableName6 WHERE $tableColumnName6 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if (substr($id,0,1)== 'F') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId8 FROM $tableName8 WHERE $tableColumnName8 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId8 FROM $tableName8 WHERE $tableColumnName8 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId8 FROM $tableName8 WHERE $tableColumnName8 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if(substr($id,0,1)== 'MF'){
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId10 FROM $tableName10 WHERE $tableColumnName10 = ? AND status='1'
                                                                    UNION
                                                                    SELECT $tableId11 FROM $tableName11 WHERE $tableColumnName11 = ? AND status='1'
                                                                ");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId10 FROM $tableName10 WHERE $tableColumnName10 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())
                                                                    UNION
                                                                    SELECT $tableId11 FROM $tableName11 WHERE $tableColumnName11 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId10 FROM $tableName10 WHERE $tableColumnName10 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))
                                                                    UNION
                                                                    SELECT $tableId11 FROM $tableName11 WHERE $tableColumnName10 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if(substr($id,0,1)== 'SF'){
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId13 FROM $tableName13 WHERE $tableColumnName13 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId13 FROM $tableName13 WHERE $tableColumnName13 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId13 FROM $tableName13 WHERE $tableColumnName13 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                }else if ($userType == '31') {
                                    if (substr($id,0,1)== 'F') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if (substr($id,0,2)== 'TC') {
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if(substr($id,0,1)== 'MF'){
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1'
                                                                    UNION
                                                                    SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1'
                                                                ");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())
                                                                    UNION
                                                                    SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId4 FROM $tableName4 WHERE $tableColumnName4 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))
                                                                    UNION
                                                                    SELECT $tableId5 FROM $tableName5 WHERE $tableColumnName5 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                    else if(substr($id,0,1)== 'SF'){
                                        // Total Count Loop End $count
                                        $stmt4 = $conn->prepare("SELECT $tableId7 FROM $tableName7 WHERE $tableColumnName7 = ? AND status='1'");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $count++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                        // Active Count Loop End $activeCount
                                        $stmt4 = $conn->prepare("SELECT $tableId7 FROM $tableName7 WHERE $tableColumnName7 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $activeCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends

                                        // Inactive Count Loop End $inactiveCount
                                        $stmt4 = $conn->prepare("SELECT $tableId7 FROM $tableName7 WHERE $tableColumnName7 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                        $stmt4->execute([$id]);
                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4->rowCount() > 0) {
                                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                $inactiveCount++; // Increment count for each ca_travelagency_id
                                            } //CATA foreach ends
                                        } //CATA if loop ends
                                    }
                                }else{
                                    // Total Count Loop End $count
                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1'");
                                    $stmt4->execute([$id]);
                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt4->rowCount() > 0) {
                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                            $count++; // Increment count for each ca_travelagency_id
                                        } //CATA foreach ends
                                    }
                                    // Active Count Loop End $activeCount
                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND MONTH(register_date) = MONTH(CURDATE()) AND YEAR(register_date) = YEAR(CURDATE())");
                                    $stmt4->execute([$id]);
                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt4->rowCount() > 0) {
                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                            $activeCount++; // Increment count for each ca_travelagency_id
                                        } //CATA foreach ends
                                    } //CATA if loop ends

                                    // Inactive Count Loop End $inactiveCount
                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' AND NOT (MONTH(register_date) = MONTH(CURDATE())AND YEAR(register_date) = YEAR(CURDATE()))");
                                    $stmt4->execute([$id]);
                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt4->rowCount() > 0) {
                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                            $inactiveCount++; // Increment count for each ca_travelagency_id
                                        } //CATA foreach ends
                                    } //CATA if loop ends
                                }
                                

                                echo '<tr>
                                            <td>' . $id . '</td>
                                            <td>' . $firstName . ' ' . $lastName . '</td>
                                            <td>' . $rdate . '</td>';
                                // if ($status == "1") {
                                //     echo '<td><span class="badge bg-success-subtle text-success">Acive</span></td>';
                                // } else {
                                //     echo '<td><span class="badge bg-danger-subtle text-danger">Inacive</span></td>';
                                // }
                                echo '<td class="text-center">' . $count . '</td>
                                            <td class="text-center">
                                                <span class="badge bg-success-subtle text-success">' . $activeCount . '</span> /
                                                <span class="badge bg-danger-subtle text-danger">' . $inactiveCount . '</span>
                                            </td>
                                        </tr>';

                                $count = 0; // reInitialize count
                                $activeCount = 0; // reInitialize count
                                $inactiveCount = 0; // reInitialize count

                            } //CA foreach ends 
                            ?>
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>
            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div><!-- end row-->