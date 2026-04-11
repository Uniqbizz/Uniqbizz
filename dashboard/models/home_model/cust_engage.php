<div class="card rounded-4">
    <div class="card-header rounded-bottom rounded-4">
        <div class="d-flex align-items-center">
            <h6 class="card-title mb-0 flex-grow-1">Popular Candidates</h6>
            
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-6">
            <div class="card-body border-end">
                <div class="search-box">
                    <input type="text" class="form-control bg-light border-light" autocomplete="off" id="searchList" placeholder="Search candidate...">
                    <i class="ri-search-line search-icon"></i>
                </div>
                <div data-simplebar style="max-height: 190px" class="px-3 mx-n3">
                    <ul class="list-unstyled mb-0 pt-2" id="candidate-list">
                        <?php
                            // corporate_agency
                            if ($userType == '16') {
                                $tableName = 'ca_travelagency';
                                $tableId = 'ca_travelagency_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableColumn = 'reference_no';
                            }
                            // travel_agent
                            if ($userType == '11') {
                                $tableName = 'ca_customer';
                                $tableId = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableColumn = 'ta_reference_no';
                            }
                            // customer
                            if ($userType == '10') {
                                $tableName = 'ca_customer';
                                $tableId = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableColumn = 'reference_no';
                            }
                            
                            //Business Channel manager
                            if ($userType == '24') {
                                $tableName = 'employees';
                                $tableId = 'employee_id';
                                $tableNameDesignation = 'Business Development Manager';
                                $tableColumn = 'reporting_manager';
                            }
                            //Business Development manager
                            if ($userType == '25') {
                                //for bm
                                $tableName = 'business_mentor'; //TE
                                $tableId = 'business_mentor_id'; //TE ID
                                $tableNameDesignation = 'Business Mentor';
                                $tableName1 = 'corporate_agency';
                                $tableId1 = 'corporate_agency_id';
                                $tableColumn = 'reference_no';
                                $tableColumn1 = 'reference_no';
                                //for direct TC
                                $tableName2 = 'ca_travelagency'; //TC
                                $tableId2 = 'ca_travelagency_id'; //TC ID
                                $tableNameDesignation1 = 'Travel Consultant';
                                $tableName3 = 'ca_customer';
                                $tableId3 = 'ca_customer_id';
                                $tableColumnName2 = 'reference_no';
                                $tableColumnName3 = 'ta_reference_no';
                                //for direct TE
                                $tableName4 = 'corporate_agency'; //TC
                                $tableId4 = 'corporate_agency_id'; //TC ID
                                $tableNameDesignation2 = 'Techno Enterprise';
                                $tableName5 = 'ca_travelagency';
                                $tableId5 = 'ca_travelagency_id';
                                $tableColumnName4 = 'reference_no';
                                $tableColumnName5 = 'reference_no';
                                //for direct F
                                $tableName6 = 'sub_franchisee'; //TC
                                $tableId6 = 'sub_franchisee_id'; //TC ID
                                $tableNameDesignation3 = 'Franchisee';
                                $tableName7 = 'ca_travelagency';
                                $tableId7 = 'ca_travelagency_id';
                                $tableColumnName6 = 'reference_no';
                                $tableColumnName7 = 'reference_no';
                                //for direct MF
                                //MF->F
                                $tableName8 = 'master_franchisee'; //TC
                                $tableId8 = 'master_franchisee_id'; //TC ID
                                $tableNameDesignation4 = 'Master Franchisee';
                                $tableName9 = 'sub_franchisee_id';
                                $tableId9 = 'sub_franchisee_id_id';
                                $tableColumnName8 = 'reference_no';
                                $tableColumnName9 = 'reference_no';
                                //Mf->TC
                                $tableName10 = 'ca_travelagency';
                                $tableId10 = 'ca_travelagency_id';
                                $tableColumnName10 = 'reference_no';
                                //for direct SF
                                $tableName11 = 'sponsor_franchisee'; //TC
                                $tableId11 = 'sponsor_franchisee_id'; //TC ID
                                $tableNameDesignation5 = 'Sponsor Franchisee';
                                $tableName12 = 'sub_franchisee';
                                $tableId12 = 'sub_franchisee_id';
                                $tableColumnName12 = 'reference_no';
                                $tableColumnName11 = 'reference_no';
                                //for direct I
                                $tableName13 = 'institution'; //TC
                                $tableId13 = 'institution_id'; //TC ID
                                $tableNameDesignation6 = 'Institution';
                                $tableName14 = 'institution_branch_manager';
                                $tableId14 = 'institution_branch_manager_id';
                                $tableColumnName13 = 'reference_no';
                                $tableColumnName14 = 'reference_no';
                                //I through BM
                                $tableName15 = 'business_mentor'; //TE
                                $tableId15 = 'business_mentor_id'; //TE ID
                                $tableNameDesignation7 = 'Business Mentor';
                                $tableName16 = 'institution';
                                $tableId16 = 'institution_id';
                                $tableColumn15 = 'reference_no';
                                $tableColumn16 = 'reference_no';
                            }
                            //Business Mentor (BM->TC)
                            if ($userType == '26') {
                                $tableName = 'ca_travelagency';
                                $tableId = 'ca_travelagency_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableColumn = 'reference_no';
                                $tableName1 = 'corporate_agency';
                                $tableId1 = 'corporate_agency_id';
                                $tableNameDesignation1 = 'Techno Enterprise';
                                $tableColumn1 = 'reference_no';
                                $tableName2 = 'sub_franchisee';
                                $tableId2 = 'sub_franchisee_id';
                                $tableNameDesignation2 = 'Franchisee';
                                $tableColumn2 = 'reference_no';
                                $tableName3 = 'institution';
                                $tableId3 = 'institution_id';
                                $tableNameDesignation3 = 'Institution';
                                $tableColumn3 = 'reference_no';
                            }
                            //Master Franchisee (MF->TC/MF->F->TC)
                            if ($userType == '28') {
                                $tableName = 'sub_franchisee';
                                $tableId = 'sub_franchisee_id';
                                $tableNameDesignation = 'Franchisee';
                                $tableColumn = 'reference_no';
                                $tableName1 = 'ca_travelagency';
                                $tableId1 = 'ca_travelagency_id';
                                $tableNameDesignation1 = 'Travel Agency';
                                $tableColumn1 = 'reference_no';
                                //I
                                $tableName2 = 'sub_franchisee';
                                $tableId2 = 'sub_franchisee_id';
                                $tableNameDesignation2 = 'Franchisee';
                                $tableColumn2 = 'reference_no';
                            }
                            //Franchisee (F->TC)
                            if ($userType == '29') {
                                $tableName = 'ca_travelagency';
                                $tableId = 'ca_travelagency_id';
                                $tableNameDesignation = 'Travel Agency';
                                $tableColumn = 'reference_no';
                            }//Sponsor Franchisee (SF->F)
                            if ($userType == '30') {
                                $tableName = 'sub_franchisee';
                                $tableId = 'sub_franchisee_id';
                                $tableNameDesignation = 'Franchisee';
                                $tableColumn = 'reference_no';
                                //I
                                $tableName1 = 'institution';
                                $tableId1 = 'institution_id';
                                $tableNameDesignation1 = 'Institution';
                                $tableColumn1 = 'reference_no';
                            }
                            //Sponsor Franchisee (SF->F)
                            if ($userType == '31') {
                                //for direct MF
                                //MF->F
                                $tableName = 'master_franchisee'; //TC
                                $tableId = 'master_franchisee_id'; //TC ID
                                $tableNameDesignation = 'Master Franchisee';
                                $tableName1 = 'sub_franchisee';
                                $tableId1 = 'sub_franchisee_id';
                                $tableColumnName = 'reference_no';
                                $tableColumnName1 = 'reference_no';
                                $tableNameDesignation1 = 'Franchisee';
                                //Mf->TC
                                $tableName2 = 'ca_travelagency';
                                $tableId2 = 'ca_travelagency_id';
                                $tableColumnName2 = 'reference_no';
                                //for direct SF
                                $tableName3 = 'sponsor_franchisee'; //TC
                                $tableId3 = 'sponsor_franchisee_id'; //TC ID
                                $tableNameDesignation2 = 'Sponsor Franchisee';
                                $tableName4 = 'sub_franchisee';
                                $tableId4 = 'sub_franchisee_id';
                                $tableColumnName3 = 'reference_no';
                                $tableColumnName2 = 'reference_no';
                            }
                            // IBR(travel_agent)
                            if ($userType == '33') {
                                $tableName = 'ca_customer';
                                $tableId = 'ca_customer_id';
                                $tableNameDesignation = 'Customer';
                                $tableColumn = 'ta_reference_no';
                            }
                            //Institution (I->IBR)
                            if ($userType == '32') {
                                $tableName = 'institution_branch_manager';
                                $tableId = 'institution_branch_manager_id';
                                $tableNameDesignation = 'Institution Branch Manager';
                                $tableColumn = 'reference_no';
                            }
                            if ($userType=='28') {
                                //get franchisee
                                $selectSF=$conn->prepare("SELECT COUNT(id) as total FROM sub_franchisee WHERE reference_no=? AND status='1'");
                                $selectSF->execute([$userId]);
                                $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
                                $countSF = $resultSF['total'];
                                //get institution
                                $selectI=$conn->prepare("SELECT COUNT(id) as total FROM institution WHERE reference_no=? AND status='1'");
                                $selectI->execute([$userId]);
                                $resultI = $selectI->fetch(PDO::FETCH_ASSOC);
                                $countI = $resultI['total'];
                                //get TC
                                $selectTC=$conn->prepare("SELECT COUNT(id) as total FROM ca_travelagency WHERE reference_no=? AND status='1'");
                                $selectTC->execute([$userId]);
                                $resultTC = $selectTC->fetch(PDO::FETCH_ASSOC);
                                $countTC = $resultTC['total'];
                                
                                if ($countSF>0 && $countTC>0 && $countI>0) {
                                    $sqlCandidates = "SELECT id, userid, firstname, lastname, profile_pic, desination FROM (
                                                        SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                        FROM $tableName 
                                                        WHERE $tableColumn = '$userId' AND status = '1'

                                                        UNION

                                                        SELECT id, ca_travelagency_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                        FROM $tableName1 
                                                        WHERE $tableColumn1 = '$userId' AND status = '1'

                                                        UNION

                                                        SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation2' AS desination 
                                                        FROM $tableName2 
                                                        WHERE $tableColumn2 = '$userId' AND status = '1'
                                                    ) AS combined
                                                    ORDER BY id DESC
                                                ";

                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else if ($countSF>0){
                                    $sqlCandidates="SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                        FROM $tableName 
                                                        WHERE $tableColumn = '$userId' AND status = '1'";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else if ($countI>0){
                                    $sqlCandidates="SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation2' AS desination 
                                                        FROM $tableName2 
                                                        WHERE $tableColumn2 = '$userId' AND status = '1'";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else if($countTC>0){
                                    $sqlCandidates="SELECT id, ca_travelagency_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                        FROM $tableName1 
                                                        WHERE $tableColumn1 = '$userId' AND status = '1'";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }
                            }else if ($userType=='30') {
                                //get franchisee
                                $selectSF=$conn->prepare("SELECT COUNT(id) as total FROM sub_franchisee WHERE reference_no=? AND status='1'");
                                $selectSF->execute([$userId]);
                                $resultSF = $selectSF->fetch(PDO::FETCH_ASSOC);
                                $countSF = $resultSF['total'];
                                //get institution
                                $selectI=$conn->prepare("SELECT COUNT(id) as total FROM institution WHERE reference_no=? AND status='1'");
                                $selectI->execute([$userId]);
                                $resultI = $selectI->fetch(PDO::FETCH_ASSOC);
                                $countI = $resultI['total'];
                                
                                if ($countSF>0 && $countI>0) {
                                    $sqlCandidates = "SELECT id, userid, firstname, lastname, profile_pic, desination FROM (
                                                        SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                        FROM $tableName 
                                                        WHERE $tableColumn = '$userId' AND status = '1'

                                                        UNION

                                                        SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                        FROM $tableName1 
                                                        WHERE $tableColumn1 = '$userId' AND status = '1'
                                                    ) AS combined
                                                    ORDER BY id DESC
                                                ";

                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else if ($countSF>0){
                                    $sqlCandidates="SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                        FROM $tableName 
                                                        WHERE $tableColumn = '$userId' AND status = '1'";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else if ($countI>0){
                                    $sqlCandidates="SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                        FROM $tableName1 
                                                        WHERE $tableColumn1 = '$userId' AND status = '1'";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }
                            }else if ($userType=='25') {
                                // Check existence in all tables at once
                                $sqlCheck = "
                                    SELECT 'BM' AS type, COUNT(*) AS total FROM business_mentor WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'TE' AS type, COUNT(*) AS total FROM corporate_agency WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'F' AS type, COUNT(*) AS total FROM sub_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'TC' AS type, COUNT(*) AS total FROM ca_travelagency WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'MF' AS type, COUNT(*) AS total FROM master_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'SF'  AS type, COUNT(*) AS total FROM sponsor_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'I'  AS type, COUNT(*) AS total FROM institution WHERE reference_no=? AND status='1'
                                ";
                                $stmtCheck = $conn->prepare($sqlCheck);
                                $stmtCheck->execute([$userId, $userId, $userId, $userId,$userId, $userId, $userId]);
                                

                                $counts = [];
                                while ($row = $stmtCheck->fetch(PDO::FETCH_ASSOC)) {
                                    $counts[$row['type']] = (int)$row['total']; // force integer
                                }

                                // Assign variables
                                $countBM = $counts['BM'] ?? 0;
                                $countMF = $counts['MF'] ?? 0;
                                $countSF = $counts['SF'] ?? 0;
                                $countI = $counts['I'] ?? 0;
                                $countTE = $counts['TE'] ?? 0;
                                $countF  = $counts['F'] ?? 0;
                                $countTC = $counts['TC'] ?? 0;

                                // Now decide query based on availability
                                $queries = [];
                                $params = [];

                                // BM
                                if ($countBM > 0) {
                                    $queries[] = "SELECT id, business_mentor_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                FROM $tableName WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // TC
                                if ($countTC > 0) {
                                    $queries[] = "SELECT id, ca_travelagency_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                FROM $tableName2 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // TE
                                if ($countTE > 0) {
                                    $queries[] = "SELECT id, corporate_agency_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation2' AS desination 
                                                FROM $tableName4 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // F
                                if ($countF > 0) {
                                    $queries[] = "SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation3' AS desination 
                                                FROM $tableName6 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                // MF
                                if ($countMF > 0) {
                                    $queries[] = "SELECT id, master_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation4' AS desination 
                                                FROM $tableName8 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                // SF
                                if ($countSF > 0) {
                                    $queries[] = "SELECT id, sponsor_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation5' AS desination 
                                                FROM $tableName11 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                // I
                                if ($countI > 0) {
                                    $queries[] = "SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation6' AS desination 
                                                FROM $tableName13 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // Execute only if we have something to query
                                
                                if (!empty($queries)) {
                                    $sql = "SELECT * FROM (" . implode(" UNION ALL ", $queries) . ") AS combined
                                            ORDER BY id DESC 
                                            LIMIT 5";
                                    $candidates = $conn->prepare($sql);
                                    $candidates->execute($params);
                                    
                                }
                            }else if ($userType=='31') {
                                // Check existence in all tables at once
                                $sqlCheck = "
                                    SELECT 'MF' AS type, COUNT(*) AS total FROM master_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'SF' AS type, COUNT(*) AS total FROM sponsor_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'F' AS type, COUNT(*) AS total FROM sub_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'I' AS type, COUNT(*) AS total FROM institution WHERE reference_no=? AND status='1'
                                ";
                                $stmtCheck = $conn->prepare($sqlCheck);
                                $stmtCheck->execute([$userId, $userId, $userId]);
                                

                                $counts = [];
                                while ($row = $stmtCheck->fetch(PDO::FETCH_ASSOC)) {
                                    $counts[$row['type']] = (int)$row['total']; // force integer
                                }

                                // Assign variables                                                                
                                $countMF = $counts['MF'] ?? 0;
                                $countSF = $counts['SF'] ?? 0;
                                $countF = $counts['F'] ?? 0;
                                $countI = $counts['I'] ?? 0;

                                // Now decide query based on availability
                                $queries = [];
                                $params = [];

                                
                                // MF
                                if ($countMF > 0) {
                                    $queries[] = "SELECT id, master_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                FROM $tableName WHERE reference_no=? AND status='1'";
                                                
                                    $params[] = $userId;
                                }
                                // SF
                                if ($countSF > 0) {
                                    $queries[] = "SELECT id, sponsor_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation2' AS desination 
                                                FROM $tableName3 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                // F
                                if ($countF > 0) {
                                    $queries[] = "SELECT id, sub_franchisee_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                FROM $tableName1 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                //I
                                if ($countI > 0) {
                                    $queries[] = "SELECT id, institution_id AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                FROM $tableName1 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // Execute only if we have something to query
                                
                                if (!empty($queries)) {
                                    $sql = "SELECT * FROM (" . implode(" UNION ALL ", $queries) . ") AS combined
                                            ORDER BY id DESC 
                                            LIMIT 5";
                                    $candidates = $conn->prepare($sql);
                                    $candidates->execute($params);
                                    
                                }
                            }else if ($userType=='26') {
                                // Check existence in all tables at once
                                $sqlCheck = "
                                    SELECT 'F' AS type, COUNT(*) AS total FROM sub_franchisee WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'TE' AS type, COUNT(*) AS total FROM corporate_agency WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'I' AS type, COUNT(*) AS total FROM institution WHERE reference_no=? AND status='1'
                                    UNION
                                    SELECT 'TC' AS type, COUNT(*) AS total FROM ca_travelagency WHERE reference_no=? AND status='1'
                                ";
                                $stmtCheck = $conn->prepare($sqlCheck);
                                $stmtCheck->execute([$userId, $userId, $userId, $userId]);
                                

                                $counts = [];
                                while ($row = $stmtCheck->fetch(PDO::FETCH_ASSOC)) {
                                    $counts[$row['type']] = (int)$row['total']; // force integer
                                }

                                // Assign variables                                                                
                                $countF = $counts['F'] ?? 0;
                                $countTE = $counts['TE'] ?? 0;
                                $countI = $counts['I'] ?? 0;
                                $countTC = $counts['TC'] ?? 0;

                                // Now decide query based on availability
                                $queries = [];
                                $params = [];

                                
                                // TC
                                if ($countTC > 0) {
                                    $queries[] = "SELECT id, $tableId AS userid, firstname, lastname, profile_pic, '$tableNameDesignation' AS desination 
                                                FROM $tableName WHERE reference_no=? AND status='1'";
                                                
                                    $params[] = $userId;
                                }
                                // TE
                                if ($countTE > 0) {
                                    $queries[] = "SELECT id, $tableId1 AS userid, firstname, lastname, profile_pic, '$tableNameDesignation1' AS desination 
                                                FROM $tableName1 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                // F
                                if ($countF > 0) {
                                    $queries[] = "SELECT id, $tableId2 AS userid, firstname, lastname, profile_pic, '$tableNameDesignation2' AS desination 
                                                FROM $tableName2 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }
                                //I
                                if ($countI > 0) {
                                    $queries[] = "SELECT id, $tableId3 AS userid, firstname, lastname, profile_pic, '$tableNameDesignation3' AS desination 
                                                FROM $tableName3 WHERE reference_no=? AND status='1'";
                                    $params[] = $userId;
                                }

                                // Execute only if we have something to query
                                
                                if (!empty($queries)) {
                                    $sql = "SELECT * FROM (" . implode(" UNION ALL ", $queries) . ") AS combined
                                            ORDER BY id DESC 
                                            LIMIT 5";
                                    $candidates = $conn->prepare($sql);
                                    $candidates->execute($params);
                                    
                                }
                            }else{
                                if($userType =='16'){
                                    $sqlCandidates = "SELECT *, CASE WHEN tm.te_id IS NOT NULL THEN 1 ELSE 0 END AS alloted_check
                                                        FROM $tableName
                                                        LEFT JOIN tc_mapping tm on tc_id=ca_travelagency_id and te_id = '" . $userId . "' 
                                                        WHERE ($tableColumn = '$userId' OR tm.te_id = '" . $userId . "') AND status = '1' ";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }else{
                                    $sqlCandidates = "SELECT * FROM $tableName WHERE $tableColumn = '$userId' AND status = '1' ";
                                    $candidates = $conn->prepare($sqlCandidates);
                                    $candidates->execute();
                                }
                            }
                            // print_r($sqlCandidates);
                            $candidates->setFetchMode(PDO::FETCH_ASSOC);
                            if ($candidates->rowCount() > 0) {
                                foreach (($candidates->fetchAll()) as $key => $row) {
                                if ($userType == '28' || $userType =='25' || $userType =='31' || $userType == '26' || $userType == '28' || $userType == '30') {
                                    $selected_user =$row['userid'];
                                }else{
                                    $map = [
                                                '24' => 'employee_id',
                                                '16' => 'ca_travelagency_id',
                                                '32' => 'institution_branch_manager_id',
                                                '29' => 'ca_travelagency_id'
                                            ];

                                    $selected_user = isset($map[$userType]) 
                                        ? ($row[$map[$userType]] ?? '') 
                                        : '';
                                }
                                    if ($userType == '24') {
                                        $fname = $row['name'];
                                        $lname = '';
                                    }else {
                                        $fname = $row['firstname'];
                                        $lname = $row['lastname'];
                                        if($userType =='16'){
                                            if($row['alloted_check'] == 1){
                                                $lname.='<small class="d-flex justify-content-center d-inline-block fw-bold text-success px-2 py-1 rounded" style="font-size: 12px; background-color: #e6f4ea; width: fit-content;">
                                                            Allotted TC
                                                            </small>';
                                            }
                                        }
                                    }
                                    $tableNameDesignation=($userType == '28' || $userType == '25' || $userType == '31' || $userType == '26' || $userType == '28' || $userType == '30' )?$row['desination']:$tableNameDesignation;
                                    if ($userType == '24' || $userType == '25' || $userType == '26' || $userType == '28' || $userType == '29' || $userType == '16' || $userType == '30' || $userType == '31' || $userType == '32') {
                                        # code...
                                        echo '
                                                <li id="list-item-' . $selected_user . '">
                                                    <a class="d-flex align-items-center py-2 candidate-item" 
                                                    style="cursor: grab;" 
                                                    onclick="showCountlist(\'' . $userType . '\',\'' . $selected_user . '\'); highlightSelected(\'list-item-' . $selected_user . '\')">

                                                        <div class="flex-shrink-0 me-2">
                                                            <div class="avatar-xs">
                                                                <img src="../../uploading/' . $row['profile_pic'] . '" 
                                                                    alt="" 
                                                                    class="img-fluid rounded-circle candidate-img" 
                                                                    style="height: 35px; width: 35px;">
                                                            </div>
                                                        </div>

                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-1 text-truncate">
                                                                <span class="candidate-name">' . $fname . ' ' . $lname . '</span>
                                                            </h5>

                                                            <div class="candidate-position">
                                                                ' . $tableNameDesignation . '
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            ';

                                    }else{

                                        echo '
                                                <li>
                                                    <a href="javascript:void(0);" class="d-flex align-items-center py-2 candidate-item">
                                                        <div class="flex-shrink-0 me-2">
                                                            <div class="avatar-xs">
                                                                <img src="../../uploading/'.$row['profile_pic'].'" 
                                                                    class="img-fluid rounded-circle candidate-img"
                                                                    style="height: 35px; width: 35px;">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-1 text-truncate">
                                                                <span class="candidate-name">'. $fname . ' ' . $lname.'</span>
                                                            </h5>
                                                            <div class="candidate-position">
                                                                '.$tableNameDesignation.'
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            ';
                                    }
                                    
                                }
                            }
                        ?>


                    </ul>
                </div>
            </div>
        </div>
        <?php
            if ($userType =='24' || $userType =='25' || $userType =='26' || $userType == '28' || $userType =='29' || $userType =='16' || $userType =='30' || $userType =='32') {
        ?>
        <!-- show table only for user type 25,24,26 -->
        
        <div class="col-lg-6">
            <div class="card-body">
                <div data-simplebar style="max-height: 225px" class="px-3 mx-n3">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Pending</th>
                            <th scope="col">Registered</th>
                            <th scope="col">deleted</th>
                            </tr>
                        </thead>
                        <tbody id="countTableBody" >
                            <?php
                                if($userType=='24'){
                            ?>
                                <tr>
                                    <th scope="row">Business Mentor</th>
                                    <td><?=$pendingBM??0?></td>
                                    <td><?=$registeredBM??0?></td>
                                    <td><?=$deletedBM??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Master Franchisee</th>
                                    <td><?=$pendingMF??0?></td>
                                    <td><?=$registeredMF??0?></td>
                                    <td><?=$deletedMF??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Sponsor Franchisee</th>
                                    <td><?=$pendingBM??0?></td>
                                    <td><?=$registeredBM??0?></td>
                                    <td><?=$deletedBM??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Techno Enterprise</th>
                                    <td><?=$pendingTE??0?></td>
                                    <td><?=$registeredTE??0?></td>
                                    <td><?=$deletedTE??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Franchisee</th>
                                    <td><?=$pendingF??0?></td>
                                    <td><?=$registeredF??0?></td>
                                    <td><?=$deletedF??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Institution</th>
                                    <td><?=$pendingI??0?></td>
                                    <td><?=$registeredI??0?></td>
                                    <td><?=$deletedI??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Travel Consultant</th>
                                    <td><?=$pendingTC??0?></td>
                                    <td><?=$registeredTC??0?></td>
                                    <td><?=$deletedTC??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Customer</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            <?php
                                if($userType=='25'){
                            ?>
                                <tr>
                                    <th scope="row">Techno Enterprise</th>
                                    <td><?=$pendingTE??0?></td>
                                    <td><?=$registeredTE??0?></td>
                                    <td><?=$deletedTE??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Franchisee</th>
                                    <td><?=$pendingF??0?></td>
                                    <td><?=$registeredF??0?></td>
                                    <td><?=$deletedF??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Institution</th>
                                    <td><?=$pendingI??0?></td>
                                    <td><?=$registeredI??0?></td>
                                    <td><?=$deletedI??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Travel Consultant</th>
                                    <td><?=$pendingTC??0?></td>
                                    <td><?=$registeredTC??0?></td>
                                    <td><?=$deletedTC??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Customer</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            <?php
                                if($userType=='26'){
                            ?>
                                <tr>
                                    <th scope="row">Travel Agency</th>
                                    <td><?=$pendingTC??0?></td>
                                    <td><?=$registeredTC??0?></td>
                                    <td><?=$deletedTC??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Institution Branch Manager</th>
                                    <td><?=$pendingIBR??0?></td>
                                    <td><?=$registeredIBR??0?></td>
                                    <td><?=$deletedIBR??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">CU</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }if($userType=='16'){
                            ?>
                                <tr>
                                    <th scope="row">CU</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }
                                if($userType=='28'){
                            ?>
                                <tr>
                                    <th scope="row">Franchisee</th>
                                    <td><?=$pendingF??0?></td>
                                    <td><?=$registeredF??0?></td>
                                    <td><?=$deletedF??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Travel Consultant</th>
                                    <td><?=$pendingTC??0?></td>
                                    <td><?=$registeredTC??0?></td>
                                    <td><?=$deletedTC??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Customer</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }if($userType=='29'){
                            ?>
                                <tr>
                                    <th scope="row">Customer</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }if($userType=='30'){
                            ?>
                                <tr>
                                    <th scope="row">Franchisee</th>
                                    <td><?=$pendingF??0?></td>
                                    <td><?=$registeredF??0?></td>
                                    <td><?=$deletedF??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Travel Consultant</th>
                                    <td><?=$pendingTC??0?></td>
                                    <td><?=$registeredTC??0?></td>
                                    <td><?=$deletedTC??0?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Customer</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }if($userType=='32'){
                            ?>
                                <tr>
                                    <th scope="row">CU</th>
                                    <td><?=$pendingCU??0?></td>
                                    <td><?=$registeredCU??0?></td>
                                    <td><?=$deletedCU??0?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="col-lg-6">
            <div class="card-body text-center">
                <div class="avatar-md mb-4 mx-auto">
                    <img src="../../uploading/select-user.png" alt="" id="candidate-img" class="img-thumbnail rounded-4 shadow-none" style="height: 80px; width: 80px;">
                </div>

                <h5 id="candidate-name" class="mt-2">----</h5>
                <p id="candidate-position" class="text-muted">----</p>
                
            </div>
        </div>
        <?php
            }
        ?>
        
        
    </div>
</div>