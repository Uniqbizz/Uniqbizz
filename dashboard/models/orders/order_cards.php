<?php
    $pending_booking_count = 0;
    $completed_booking_count = 0;
    $pending_payment_amt = 0;
    $in_transit_booking_count=0;
    $canceled_booking_count=0;
    $completed_payment_amt = 0;

    $sql = "SELECT
                b.id,
                b.order_id,
                b.package_id,
                b.date,
                b.customer_id,
                b.name,
                b.status,
                p.name AS package_name,
                p.tour_days,
                bd.final_price,
                bd.amount,
                COALESCE(bd.part_pay_1, 0) AS part_pay_1,
                COALESCE(bd.part_pay_2, 0) AS part_pay_2,
                COALESCE(bd.part_pay_3, 0) AS part_pay_3,
                bd.part_pay_1_status,
                bd.part_pay_2_status,
                bd.part_pay_3_status,
                bd.status AS bd_status,
                b.confirm_status,
                b.ta_id,
                agg.max_b_date,
                agg.min_b_date
            FROM bookings b
            LEFT JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
            ";
        

            if ($userType == '24') { // BCM
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- 1. BCM -> BDM -> BM -> TE -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN corporate_agency co
                                        ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                                    INNER JOIN business_mentor bm
                                        ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 2. BCM -> BDM -> BM -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN business_mentor bm
                                        ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 3. BCM -> BDM -> MF -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 4. BCM -> BDM -> MF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 5. BCM -> BDM -> SF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN sponsor_franchisee sf
                                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 6. BCM -> BDM -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                                    INNER JOIN employees bcm
                                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                    -- 1. BCM -> BDM -> BM -> TE -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN corporate_agency co
                        ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN business_mentor bm
                        ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                
                    UNION
                
                    -- 2. BCM -> BDM -> BM -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN business_mentor bm
                        ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                
                    UNION
                
                    -- 3. BCM -> BDM -> MF -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                
                    UNION
                
                    -- 4. BCM -> BDM -> MF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                
                    UNION
                
                    -- 5. BCM -> BDM -> SF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN sponsor_franchisee sf
                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                
                    UNION
                
                    -- 6. BCM -> BDM -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN employees bdm
                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                    INNER JOIN employees bcm
                        ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                    WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                )";
            } elseif ($userType == '25') { // BDM
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- 1. BDM -> BM -> TE -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN corporate_agency co
                                        ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                                    INNER JOIN business_mentor bm
                                        ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 2. BDM -> BM -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN business_mentor bm
                                        ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 3. BDM -> MF -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 4. BDM -> MF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 5. BDM -> SF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN sponsor_franchisee sf
                                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 6. BDM -> TC (direct)
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                    -- 1. BDM -> BM -> TE -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN corporate_agency co
                        ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                    INNER JOIN business_mentor bm
                        ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 2. BDM -> BM -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN business_mentor bm
                        ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 3. BDM -> MF -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 4. BDM -> MF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 5. BDM -> SF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN sponsor_franchisee sf
                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 6. BDM -> TC (direct)
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN employees bdm
                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                )";
            } elseif ($userType == '26') { // BM
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- TA via corporate_agency
                                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                                    INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                                    INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                                    WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'
            
                                    UNION
            
                                    -- Direct TC under BM
                                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                                    WHERE ca.status = 1 AND ca.reference_no = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                        -- TA via corporate_agency
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                        INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                        WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'

                        UNION

                        -- Direct TC under BM
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        WHERE ca.status = 1 AND ca.reference_no = '$userId'
                    )";
            } elseif ($userType == '28') { // MF
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- TA via Franchisee
                                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                                    INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                                    WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                        -- TA via Franchisee
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                        INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                        WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'

                        UNION

                        -- Direct TC under MF
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        WHERE ca.status = 1 AND ca.reference_no = '$userId'
                    )";
            } elseif ($userType == '30') { // SF
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- TA via Franchisee
                                    SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                                    INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                                    WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                        -- TA via Franchisee
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                        INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                        WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'
                    )";
            } elseif ($userType == '16' || $userType == '29') { // TE/F
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    WHERE ca.status = 1
                                    AND ca.reference_no = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                        SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                        WHERE ca.status = 1 AND ca.reference_no = '$userId'
                    )";
            } elseif ($userType == '11') { // TC
                $filter = " CROSS JOIN (
                                SELECT
                                    MAX(date) AS max_b_date,
                                    MIN(date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id = '$userId'
                            ) agg
                            WHERE 1=1 AND b.ta_id = '$userId'";
            } elseif ($userType == '10') { // Customer
                $filter = " CROSS JOIN (
                                SELECT
                                    MAX(date) AS max_b_date,
                                    MIN(date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.customer_id = '$userId'
                            ) agg
                            WHERE 1=1 AND b.customer_id = '$userId'";
            } elseif ($userType == '31') { // RM
                $filter = "CROSS JOIN (
                                SELECT
                                    MAX(b2.date) AS max_b_date,
                                    MIN(b2.date) AS min_b_date
                                FROM bookings b2
                                WHERE b2.ta_id IN (
                                    -- 1. RM -> MF -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 2. RM -> MF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN master_franchisee mf
                                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 3. RM -> SF -> F -> TC
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN sub_franchisee f
                                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                                    INNER JOIN sponsor_franchisee sf
                                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                
                                    UNION
                                
                                    -- 6. RM -> TC (direct)
                                    SELECT ca.ca_travelagency_id
                                    FROM ca_travelagency ca
                                    INNER JOIN employees bdm
                                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                                )
                            ) agg
                        WHERE 1=1 AND b.ta_id IN (
                                
                    -- 1. RM -> MF -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 2. RM -> MF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN master_franchisee mf
                        ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 3. RM -> SF -> F -> TC
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN sub_franchisee f
                        ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                    INNER JOIN sponsor_franchisee sf
                        ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                    INNER JOIN employees bdm
                        ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                
                    UNION
                
                    -- 6. RM -> TC (direct)
                    SELECT ca.ca_travelagency_id
                    FROM ca_travelagency ca
                    INNER JOIN employees bdm
                        ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                    WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                )";
            }

            $sql .= $filter;
            //hirarchy filter logic // no longer required
            // $sql .=" GROUP BY
            //             b.id,
            //             b.order_id,
            //             b.package_id,
            //             b.customer_id,
            //             b.name,
            //             b.status,
            //             p.name,
            //             p.tour_days,
            //             bd.final_price,
            //             bd.amount,
            //             bd.part_pay_1,
            //             bd.part_pay_2,
            //             bd.part_pay_3,
            //             bd.part_pay_1_status,
            //             bd.part_pay_2_status,
            //             bd.part_pay_3_status,
            //             bd.status,
            //             b.confirm_status,
            //             b.ta_id";
            $stmt = $conn->prepare($sql);
            // print_r($stmt);
            // exit;
            $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $today = date('Y-m-d'); // Get today's date as a string

    $mindate= "01-01-2022";
    $maxdate=$today;
    foreach ($bookings as $booking) {
        $maxdate=$booking['max_b_date'] ?? $today;
        // Ensure 'date' exists in booking data
        if (!isset($booking['date']) || empty($booking['date'])) {
            continue; // Skip if date is not set
        }

        $startDate = date('Y-m-d', strtotime($booking['date'])); // Convert start date to string format
        $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0; // Ensure it's an integer
        $endDate = date('Y-m-d', strtotime("$startDate +$tourDays days")); // Calculate end date as string
        if ($booking['part_pay_2_status'] == 0) {
            $pending_payment_amt += floatval(number_format($booking['part_pay_2'], 2, '.', '')); // Convert NULL to 0

        }
        if ($booking['part_pay_3_status'] == 0) {
            $pending_payment_amt += floatval(number_format($booking['part_pay_3'], 2, '.', '')); // Convert NULL to 0
        }
        if ($booking['status'] == '1' && $booking['bd_status'] == 1) {
            $completed_payment_amt += floatval(number_format($booking['final_price'], 2, '.', '')); // Convert NULL to 0
        }
        if ($booking['status'] == '2') {
            $canceled_booking_count++;
        }
        if ($today > $endDate) {
            $completed_booking_count++;
        } else if ($booking['confirm_status'] == '0') {
            $pending_booking_count++;
        } else if ($booking['confirm_status'] == '1') {
            $in_transit_booking_count++;
        }
    }
?>