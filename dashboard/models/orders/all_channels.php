<?php
    //BCM login
    if ($userType == '24') {
        // BCM's lower hierarchy (all TA paths)
        $sql0 = "
            #BCM-BDM-BM-TE-TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            #BCM-BDM-BM-TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            #BCM-BDM-TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            #BCM-BDM-BM-I-IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution co 
                ON co.institution_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            #BDM-I-IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution co 
                ON co.institution_id = ca.reference_no AND co.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = co.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId

            UNION

            #BDM-F-TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee co 
                ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = co.reference_no AND bdm.status = 1
            INNER JOIN employees bcm 
                ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
            WHERE ca.status = 1 AND bcm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    //BDM login
    else if ($userType == '25') {
        // BDM's lower hierarchy (all TA paths)
        $sql0 = "
            -- 1. BDM -> BM -> TE -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 2. BDM -> BM -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 3. BDM -> TC (direct)
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 4. BDM-BM-I-IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution co 
                ON co.institution_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = co.reference_no AND bm.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = bm.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 5. BDM-I-IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution co 
                ON co.institution_id = ca.reference_no AND co.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = co.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 6. BDM-F-TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee co 
                ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = co.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    //BM login
    else if ($userType == '26') {
        // BM and lower hierarchy (all TA paths under BM)
        $sql0 = "
            -- 1. BM -> TE -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN corporate_agency co 
                ON co.corporate_agency_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON co.reference_no = bm.business_mentor_id AND bm.status = 1
            WHERE ca.status = 1 AND bm.business_mentor_id = :userId

            UNION

            -- 2. BM -> TC (direct)
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN business_mentor bm 
                ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
            WHERE ca.status = 1 AND bm.business_mentor_id = :userId

            UNION

            -- 3. BM -> I -> IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution co 
                ON co.institution_id = ca.reference_no AND co.status = 1
            INNER JOIN business_mentor bm 
                ON co.reference_no = bm.business_mentor_id AND bm.status = 1
            WHERE ca.status = 1 AND bm.business_mentor_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    //MF login
    else if ($userType == '28') {
        // MF and lower hierarchy (all TA paths under MF)
        $sql0 = "
            -- 1. MF -> F -> TC 
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            WHERE ca.status = 1 AND mf.master_franchisee_id = :userId

            UNION

            -- 2. MF -> TC (direct under MF)
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN master_franchisee mf
                ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
            WHERE ca.status = 1 AND mf.master_franchisee_id = :userId

            UNION

            -- 3. MF -> F -> TC 
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            WHERE ca.status = 1 AND mf.master_franchisee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    //SF login
    else if ($userType == '30') {
        // SF and lower hierarchy (all TA paths under SF)
        $sql0 = "
            -- 1. SF -> F -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            WHERE ca.status = 1 AND sf.sponsor_franchisee_id = :userId

            UNION

            -- 1. SF -> F -> TC
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            WHERE ca.status = 1 AND sf.sponsor_franchisee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
    //TE login
    else if ($userType == '16') {
        //TE and lower hirachy
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
            INNER join corporate_agency on corporate_agency.corporate_agency_id = ca_travelagency.reference_no and corporate_agency.status=1                                                        
            WHERE ca_travelagency.status=1 and corporate_agency.corporate_agency_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    }
    //I login
    else if ($userType == '32') {
        //I and lower hirachy
        $sql0 = "SELECT institution_branch_manager.institution_branch_manager_id AS tc_id, institution_branch_manager.firstname, institution_branch_manager.lastname, institution_branch_manager.email, institution_branch_manager.contact_no FROM institution_branch_manager
            INNER JOIN institution on institution.institution_id = institution_branch_manager.reference_no and institution.status=1                                                        
            WHERE institution_branch_manager.status=1 and institution.institution_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    }
    //F login
    else if ($userType == '29') {
        // Franchisee (F) and lower hierarchy (all TA under F)
        $sql0 = "
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            WHERE ca.status = 1 AND f.sub_franchisee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    }
    //TC login
    else if ($userType == '11') {
        //TC
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id AS tc_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency                                                        
            WHERE ca_travelagency.status=1 and ca_travelagency_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    } 
    //IBR(TC) login
    else if ($userType == '32') {
        //IBR(TC)
        $sql0 = "SELECT institution_branch_manager.institution_branch_manager_id, institution_branch_manager.firstname, institution_branch_manager.lastname, institution_branch_manager.email, institution_branch_manager.contact_no FROM institution_branch_manager                                                        
            WHERE institution_branch_manager.status=1 and institution_branch_manager_id='" . $userId . "'";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
    } 
    //CU login
    else if ($userType == '10') {
        //Customer
        $sql0 = "SELECT ca_travelagency.ca_travelagency_id AS tc_id, ca_travelagency.firstname, ca_travelagency.lastname, ca_travelagency.email, ca_travelagency.contact_no FROM ca_travelagency
                 INNER JOIN ca_customer on ca_customer.ta_reference_no = ca_travelagency.ca_travelagency_id and ca_customer.status=1
                 WHERE ca_travelagency.status=1 and ca_customer.ca_customer_id=:user_id
                 UNION 
                 SELECT institution_branch_manager.institution_branch_manager_id AS tc_id, institution_branch_manager.firstname, institution_branch_manager.lastname, institution_branch_manager.email, institution_branch_manager.contact_no FROM institution_branch_manager 
                 INNER JOIN ca_customer on ca_customer.ta_reference_no = institution_branch_manager.institution_branch_manager_id and ca_customer.status=1
                 WHERE institution_branch_manager.status=1 and ca_customer.ca_customer_id=:user_id";
        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
        $customer_fil = " AND b.customer_id='" . $userId . "'";
    }
    //RM login
    else if ($userType == '31') {
        // BDM's lower hierarchy (all TA paths)
        $sql0 = "
            -- 1. RM -> MF -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 2. RM -> MF -> F -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 3. RM -> SF -> F -> TC
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN sub_franchisee f 
                ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf 
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = sf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 4. M -> TC (direct)
            SELECT ca.ca_travelagency_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM ca_travelagency ca
            INNER JOIN employees bdm 
                ON bdm.employee_id = ca.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 5. RM -> MF -> I -> IBR
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution f 
                ON f.institution_id = ca.reference_no AND f.status = 1
            INNER JOIN master_franchisee mf 
                ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = mf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId

            UNION

            -- 3. RM -> SF -> F -> TC
            SELECT ca.institution_branch_manager_id AS tc_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
            FROM institution_branch_manager ca
            INNER JOIN institution f 
                ON f.institution_id = ca.reference_no AND f.status = 1
            INNER JOIN sponsor_franchisee sf 
                ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
            INNER JOIN employees bdm 
                ON bdm.employee_id = sf.reference_no AND bdm.status = 1
            WHERE ca.status = 1 AND bdm.employee_id = :userId
        ";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute([':userId' => $userId]);
        $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    }
?>