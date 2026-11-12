
<?php

header('Content-Type: application/json');

include(__DIR__ . '/../../connect.php');

try {

    // ==========================================
    // 1. CHECK REQUEST METHOD
    // ==========================================

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // ==========================================
    // 2. RECEIVE QUOTATION PAYLOAD
    // ==========================================

    if (empty($_POST['quotationPayload'])) {
        throw new Exception('Quotation data is missing.');
    }

    $quotationPayload = json_decode(
        $_POST['quotationPayload'],
        true
    );

    if (
        json_last_error() !== JSON_ERROR_NONE ||
        !is_array($quotationPayload)
    ) {
        throw new Exception('Invalid quotation JSON data.');
    }

    // ==========================================
    // 3. ACCESS MAIN DETAILS
    // ==========================================

    $requestId = $quotationPayload['request_id'] ?? null;
    $packageId = $quotationPayload['package_id'] ?? null;

    $guestDetails = $quotationPayload['guest_details'] ?? [];
    $tripRequest = $quotationPayload['trip_request'] ?? [];
    $customerPreferences = $quotationPayload['customer_preferences'] ?? [];
    $quickAction = $quotationPayload['quick_action'] ?? [];

    $couponWalletDetails = $quotationPayload['coupon_wallet_details'] ?? [];
    $priceAdjustments = $quotationPayload['price_adjustments'] ?? [];
    $finalPackageDetails = $quotationPayload['final_package_details'] ?? [];

    // ==========================================
    // 4. ACCESS OTHER JSON SECTIONS
    // ==========================================

    $itinerary = $quotationPayload['itinerary'] ?? [];

    $packageInclusionExclusion =
        $quotationPayload['package_inclusion_exclusion'] ?? [];

    $newPolicyDocuments =
        $quotationPayload['new_policy_documents'] ?? [];

    $cancellationCharges =
        $quotationPayload['cancellation_charges'] ?? [];

    $commissionIncentive =
        $quotationPayload['commission_incentive'] ?? [];

    $markupCalculation =
        $quotationPayload['markup_calculation'] ?? [];

    $customerDiscountPriceDetails =
        $quotationPayload['customer_discount_price_details'] ?? [];

    $discountedPriceDetails =
        $quotationPayload['discounted_price_details'] ?? [];

    $additionalPriceDetails =
        $quotationPayload['additional_price_details'] ?? [];

    $finalQuotationDetails =
        $quotationPayload['final_quotation_details'] ?? [];
    // ==========================================
    // 5. PREPARE REQUEST DETAILS REPLY VALUES
    // ==========================================

    $rooms = $tripRequest['rooms'] ?? [];
    $coupons = $couponWalletDetails['coupons'] ?? [];

    $adultCount = (int)($tripRequest['adult_count'] ?? 0);
    $childCount = (int)($tripRequest['child_count'] ?? 0);
    $infantCount = (int)($tripRequest['infant_count'] ?? 0);

    $roomCount = count($rooms);

    $mattressCount = 0;

    foreach ($rooms as $room) {
        $mattressCount += (int)($room['extra_mattress'] ?? 0);
    }

    $gst = $finalQuotationDetails['gst_amount']
        ?? $priceAdjustments['gst_amount']
        ?? 0;

    $gstPercentage = $finalQuotationDetails['gst_percentage']
        ?? $priceAdjustments['gst_percentage']
        ?? 0;

    $grossPrice = $finalQuotationDetails['final_quoted_price'] ?? 0;

    $basePrice = $finalPackageDetails['final_package_price'] ?? 0;

    $convenienceFee = $finalQuotationDetails['convenience_fee']
        ?? $priceAdjustments['convenience_fee']
        ?? 0;

    $finalPrice = $finalQuotationDetails['estimated_final_package_price'] ?? 0;

    // Convert date to MySQL format
    $travelStartDate = !empty($tripRequest['travel_start_date'])
        ? date('Y-m-d', strtotime(str_replace('/', '-', $tripRequest['travel_start_date'])))
        : null;

    $travelEndDate = !empty($tripRequest['travel_end_date'])
        ? date('Y-m-d', strtotime(str_replace('/', '-', $tripRequest['travel_end_date'])))
        : null;

    // ==========================================
    // 6. RECEIVE POLICY FILES
    // ==========================================

    // ==========================================
    // POLICY DOCUMENT UPLOAD AND DATABASE INSERT in request_details_policy_document
    // ==========================================

    $uploadedFiles = [];

    if (
        isset($_FILES['policy_files']) &&
        !empty($_FILES['policy_files']['name'][0]) &&
        !empty($newPolicyDocuments)
    ) {

        // Upload directory
        $uploadDir = __DIR__ . '/../../../uploading/package_policy_attachments/';

        if (!is_dir($uploadDir)) {

            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception('Unable to create policy document upload directory.');
            }
        }

        $sql = "
            INSERT INTO request_details_policy_document
            (
                request_id,
                package_id,
                title,
                file_name,
                type,
                size,
                uploaded_on
            )
            VALUES
            (
                :request_id,
                :package_id,
                :title,
                :file_name,
                :type,
                :size,
                :uploaded_on
            )
        ";

        $stmt = $conn->prepare($sql);

        foreach ($_FILES['policy_files']['name'] as $i => $originalName) {

            if ($_FILES['policy_files']['error'][$i] !== UPLOAD_ERR_OK) {
                throw new Exception(
                    'Document upload failed: ' . $originalName
                );
            }

            if (!isset($newPolicyDocuments[$i])) {
                throw new Exception('Document payload mismatch.');
            }

            $doc = $newPolicyDocuments[$i];

            // Get extension
            $extension = strtolower(
                pathinfo($originalName, PATHINFO_EXTENSION)
            );

            // Generate unique filename
            $newFileName = uniqid('DOC_', true) . '.' . $extension;

            $destination = $uploadDir . $newFileName;

            // Move uploaded file
            if (!move_uploaded_file(
                $_FILES['policy_files']['tmp_name'][$i],
                $destination
            )) {
                throw new Exception(
                    'Unable to move uploaded file: ' . $originalName
                );
            }

            // Keep path for rollback
            $uploadedFiles[] = $destination;

            // Convert uploaded date
            // Your current JavaScript payload does not include uploadedOn,
            // so use today's date unless you add that property.
            $uploadedOn = new DateTime();

            if (!empty($doc['uploadedOn'])) {

                $parsedDate = DateTime::createFromFormat(
                    'd/m/Y',
                    $doc['uploadedOn']
                );

                if ($parsedDate) {
                    $uploadedOn = $parsedDate;
                }
            }

            // Insert document details
            $stmt->execute([
                ':request_id' => $requestId,
                ':package_id' => $packageId,
                ':title' => $doc['title'] ?? '',
                ':file_name' => $newFileName,
                ':type' => $doc['type'] ?? strtoupper($extension),
                ':size' => $doc['size'] ?? '',
                ':uploaded_on' => $uploadedOn->format('Y-m-d')
            ]);
        }
    }

    // // ==========================================
    // // 7. INSERT INTO request_details_reply
    // // ==========================================
    // // Prepare INSERT query
    // $request_details_reply_sql = "
    //     INSERT INTO request_details_reply
    //     (
    //         request_id,
    //         package_id,
    //         adult_count,
    //         child_count,
    //         infant_count,
    //         adult_price,
    //         child_price,
    //         adult_total,
    //         children_total,
    //         subtotal,
    //         transport_type,
    //         transport_amt,
    //         travel_start_date,
    //         travel_end_date,
    //         no_of_nights_days,
    //         pickup_point,
    //         customer_pickup,
    //         drop_point,
    //         customer_drop,
    //         room_count,
    //         mattress_count,
    //         hotel_category,
    //         meal_preference,
    //         transport_preference,
    //         special_requirement,
    //         coupons_applied_count,
    //         coupon_discount,
    //         coupons,
    //         rooms,
    //         gst,
    //         gst_percentage,
    //         convenience_fee,
    //         final_price,
    //         userId,
    //         guestFullname,
    //         gusetPhone,
    //         guestEmail,
    //         created,
    //         updated_on,
    //         status,
    //         discount_wallet_amount,
    //         referral_wallet_amount
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :adult_count,
    //         :child_count,
    //         :infant_count,
    //         :adult_price,
    //         :child_price,
    //         :adult_total,
    //         :children_total,
    //         :subtotal,
    //         :transport_type,
    //         :transport_amt,
    //         :travel_start_date,
    //         :travel_end_date,
    //         :no_of_nights_days,
    //         :pickup_point,
    //         :customer_pickup,
    //         :drop_point,
    //         :customer_drop,
    //         :room_count,
    //         :mattress_count,
    //         :hotel_category,
    //         :meal_preference,
    //         :transport_preference,
    //         :special_requirement,
    //         :coupons_applied_count,
    //         :coupon_discount,
    //         :coupons,
    //         :rooms,
    //         :gst,
    //         :gst_percentage,
    //         :convenience_fee,
    //         :final_price,
    //         :userId,
    //         :guestFullname,
    //         :gusetPhone,
    //         :guestEmail,
    //         CURRENT_TIMESTAMP(),
    //         NULL,
    //         :status,
    //         :discount_wallet_amount,
    //         :referral_wallet_amount
    //     )
    // ";

    // $stmt = $conn->prepare($request_details_reply_sql);

    // $stmt->execute([

    //     ':request_id' => $requestId,
    //     ':package_id' => $packageId,

    //     ':adult_count' => $adultCount,
    //     ':child_count' => $childCount,
    //     ':infant_count' => $infantCount,

    //     ':adult_price' => $markupCalculation['net_price_adult'] ?? 0,
    //     ':child_price' => $markupCalculation['net_price_child'] ?? 0,

    //     ':adult_total' => $tripRequest['adult_total'] ?? 0,
    //     ':children_total' => $tripRequest['children_total'] ?? 0,
    //     ':subtotal' => $finalQuotationDetails['final_quoted_price'] ?? 0,

    //     ':transport_type' => $quickAction['selected_vehicle'] ?? '',
    //     ':transport_amt' => 0,

    //     ':travel_start_date' => $travelStartDate,
    //     ':travel_end_date' => $travelEndDate,
    //     ':no_of_nights_days' => $tripRequest['duration'] ?? '',

    //     ':pickup_point' => $tripRequest['pickup'] ?? '',
    //     ':customer_pickup' => $tripRequest['old_pickup'] ?? '',

    //     ':drop_point' => $tripRequest['drop'] ?? '',
    //     ':customer_drop' => $tripRequest['old_drop'] ?? '',

    //     ':room_count' => $roomCount,
    //     ':mattress_count' => $mattressCount,

    //     ':hotel_category' => $customerPreferences['hotel'] ?? '',
    //     ':meal_preference' => $customerPreferences['meal'] ?? '',
    //     ':transport_preference' => $customerPreferences['transport'] ?? '',
    //     ':special_requirement' => $customerPreferences['special_requirement'] ?? '',

    //     ':coupons_applied_count' => count($coupons),
    //     ':coupon_discount' => $couponWalletDetails['total_coupon_discount'] ?? 0,

    //     ':coupons' => json_encode($coupons, JSON_UNESCAPED_UNICODE),
    //     ':rooms' => json_encode($rooms, JSON_UNESCAPED_UNICODE),
    //     ':gst' => $gst,
    //     ':gst_percentage' => $gstPercentage,
    //     ':convenience_fee' => $convenienceFee,
    //     ':final_price' => $finalPrice,

    //     ':userId' => $guestDetails['user_id'] ?? null,
    //     ':guestFullname' => $guestDetails['full_name'] ?? '',
    //     ':gusetPhone' => $guestDetails['mobile'] ?? '',
    //     ':guestEmail' => $guestDetails['email'] ?? '',

    //     ':status' => 1,

    //     ':discount_wallet_amount' => $couponWalletDetails['applied_discount_wallet'] ?? 0,
    //     ':referral_wallet_amount' => $couponWalletDetails['applied_referral_wallet'] ?? 0

    // ]);

    // // $replyId = $conn->lastInsertId();

    // // ==========================================
    // // 8. INSERT INTO request_details_cancellation_policy
    // // ==========================================

    // $cancellationPolicies = $cancellationCharges['policies'] ?? [];

    // $sql = "
    //     INSERT INTO request_details_cancellation_policy
    //     (
    //         request_id,
    //         package_id,
    //         policy_1,
    //         policy_2,
    //         policy_3,
    //         policy_4,
    //         policy_5
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :policy_1,
    //         :policy_2,
    //         :policy_3,
    //         :policy_4,
    //         :policy_5
    //     )
    // ";

    // $stmt = $conn->prepare($sql);

    // $stmt->execute([
    //     ':request_id' => $requestId,
    //     ':package_id' => $packageId,
    //     ':policy_1'   => $cancellationPolicies[0] ?? null,
    //     ':policy_2'   => $cancellationPolicies[1] ?? null,
    //     ':policy_3'   => $cancellationPolicies[2] ?? null,
    //     ':policy_4'   => $cancellationPolicies[3] ?? null,
    //     ':policy_5'   => $cancellationPolicies[4] ?? null
    // ]);

    // // ==========================================
    // // 9. INSERT INTO request_details_itinerary
    // // ==========================================

    // // INCLUSION / EXCLUSION
    // $inclusion = $packageInclusionExclusion['inclusion'] ?? [];
    // $exclusion = $packageInclusionExclusion['exclusion'] ?? [];

    // // ITINERARY
    // $travelInfo = $itinerary ?? [];

    // $sql = "
    //     INSERT INTO request_details_itinerary
    //     (
    //         request_id,
    //         package_id,
    //         inclusion,
    //         exclusion,
    //         remark,
    //         travel_info,
    //         highlights
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :inclusion,
    //         :exclusion,
    //         :remark,
    //         :travel_info,
    //         :highlights
    //     )
    // ";

    // $stmt = $conn->prepare($sql);

    // $stmt->execute([
    //     ':request_id' => $requestId,
    //     ':package_id' => $packageId,

    //     ':inclusion' => json_encode(
    //         $inclusion,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':exclusion' => json_encode(
    //         $exclusion,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':remark' => null,

    //     ':travel_info' => json_encode(
    //         $travelInfo,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':highlights' => null
    // ]);

    // // ==========================================
    // // 10. INSERT INTO request_details_markup
    // // ==========================================

    // $markup = $markupCalculation ?? [];
    // $commission = $commissionIncentive ?? [];
    // $adjustments = $priceAdjustments ?? [];

    // $sql = "
    //     INSERT INTO request_details_markup
    //     (
    //         request_id,
    //         package_id,
    //         original_adult_price,
    //         original_child_price,
    //         alt_adult_price,
    //         alt_child_price,
    //         coupon_adjustment,
    //         company_commission,
    //         suspense,
    //         l1_customer,
    //         l2_customer,
    //         l3_customer,
    //         cte_bcm_commi,
    //         cte_bcm_incen,
    //         cte_bcm_id,
    //         cte_bcm_name,
    //         ete_bdm_commi,
    //         ete_bdm_incen,
    //         ete_bdm_id,
    //         ete_bdm_name,
    //         ste_bm_mf_sf_commi,
    //         ste_bm_mf_sf_incen,
    //         ste_bm_mf_sf_id,
    //         ste_bm_name,
    //         te_f_i_commi,
    //         te_f_i_incen,
    //         te_f_i_id,
    //         te_f_i_name,
    //         tc_ibr
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :original_adult_price,
    //         :original_child_price,
    //         :alt_adult_price,
    //         :alt_child_price,
    //         :coupon_adjustment,
    //         :company_commission,
    //         :suspense,
    //         :l1_customer,
    //         :l2_customer,
    //         :l3_customer,
    //         :cte_bcm_commi,
    //         :cte_bcm_incen,
    //         :cte_bcm_id,
    //         :cte_bcm_name,
    //         :ete_bdm_commi,
    //         :ete_bdm_incen,
    //         :ete_bdm_id,
    //         :ete_bdm_name,
    //         :ste_bm_mf_sf_commi,
    //         :ste_bm_mf_sf_incen,
    //         :ste_bm_mf_sf_id,
    //         :ste_bm_name,
    //         :te_f_i_commi,
    //         :te_f_i_incen,
    //         :te_f_i_id,
    //         :te_f_i_name,
    //         :tc_ibr
    //     )
    // ";

    // $stmt = $conn->prepare($sql);

    // $stmt->execute([
    //     ':request_id' => $requestId,
    //     ':package_id' => $packageId,

    //     ':original_adult_price' => $markup['net_price_adult_original'] ?? null,
    //     ':original_child_price' => $markup['net_price_child_difference'] ?? null,

    //     ':alt_adult_price' => $markup['alt_adult_price'] ?? null,
    //     ':alt_child_price' => $markup['alt_child_price'] ?? null,

    //     ':coupon_adjustment' => $adjustments['coupon_adjustment'] ?? null,
    //     ':company_commission' => $markup['company_commission'] ?? null,
    //     ':suspense' => $markup['suspense'] ?? null,

    //     ':l1_customer' => $markup['l1_customer'] ?? null,
    //     ':l2_customer' => $markup['l2_customer'] ?? null,
    //     ':l3_customer' => $markup['l3_customer'] ?? null,

    //     ':cte_bcm_commi' => $commission['cte_bcm_commi'] ?? null,
    //     ':cte_bcm_incen' => $commission['cte_bcm_incen'] ?? null,
    //     ':cte_bcm_id' => $commission['cte_bcm_id'] ?? null,
    //     ':cte_bcm_name' => $commission['cte_bcm_name'] ?? null,

    //     ':ete_bdm_commi' => $commission['ete_bdm_commi'] ?? null,
    //     ':ete_bdm_incen' => $commission['ete_bdm_incen'] ?? null,
    //     ':ete_bdm_id' => $commission['ete_bdm_id'] ?? null,
    //     ':ete_bdm_name' => $commission['ete_bdm_name'] ?? null,

    //     ':ste_bm_mf_sf_commi' => $commission['ste_bm_mf_sf_commi'] ?? null,
    //     ':ste_bm_mf_sf_incen' => $commission['ste_bm_mf_sf_incen'] ?? null,
    //     ':ste_bm_mf_sf_id' => $commission['ste_bm_mf_sf_id'] ?? null,
    //     ':ste_bm_name' => $commission['ste_bm_name'] ?? null,

    //     ':te_f_i_commi' => $commission['te_f_i_commi'] ?? null,
    //     ':te_f_i_incen' => $commission['te_f_i_incen'] ?? null,
    //     ':te_f_i_id' => $commission['te_f_i_id'] ?? null,
    //     ':te_f_i_name' => $commission['te_f_i_name'] ?? null,

    //     ':tc_ibr' => $commission['tc_ibr'] ?? null
    // ]);

    // // ==========================================
    // // 11. INSERT INTO request_details_revised_quote
    // // ==========================================

    // $customerDiscountDetails = $customerDiscountPriceDetails ?? [];
    // $discountDetails = $discountedPriceDetails ?? [];
    // $additionalDetails = $additionalPriceDetails ?? [];
    // $finalQuote = $finalQuotationDetails ?? [];

    // $sql = "
    //     INSERT INTO request_details_revised_quote
    //     (
    //         request_id,
    //         package_id,
    //         cust_dis_details,
    //         cust_dis_details_total,
    //         dis_details,
    //         dis_details_total,
    //         additional_details,
    //         additional_details_total,
    //         final_quot_price,
    //         gst_amount,
    //         gst_percentage,
    //         convenience_fee,
    //         total_estimated_price
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :cust_dis_details,
    //         :cust_dis_details_total,
    //         :dis_details,
    //         :dis_details_total,
    //         :additional_details,
    //         :additional_details_total,
    //         :final_quot_price,
    //         :gst_amount,
    //         :gst_percentage,
    //         :convenience_fee,
    //         :total_estimated_price
    //     )
    // ";

    // $stmt = $conn->prepare($sql);

    // $stmt->execute([
    //     ':request_id' => $requestId,
    //     ':package_id' => $packageId,

    //     ':cust_dis_details' => json_encode(
    //         $customerDiscountDetails,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':cust_dis_details_total' =>
    //         $customerDiscountPriceDetails['total'] ?? 0,

    //     ':dis_details' => json_encode(
    //         $discountDetails,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':dis_details_total' =>
    //         $discountedPriceDetails['total'] ?? 0,

    //     ':additional_details' => json_encode(
    //         $additionalDetails,
    //         JSON_UNESCAPED_UNICODE
    //     ),

    //     ':additional_details_total' =>
    //         $additionalPriceDetails['total'] ?? 0,

    //     ':final_quot_price' =>
    //         $finalQuote['final_quoted_price'] ?? 0,

    //     ':gst_amount' =>
    //         $finalQuote['gst_amount'] ?? 0,

    //     ':gst_percentage' =>
    //         $finalQuote['gst_percentage'] ?? 0,

    //     ':convenience_fee' =>
    //         $finalQuote['convenience_fee'] ?? 0,

    //     ':total_estimated_price' =>
    //         $finalQuote['estimated_final_package_price'] ?? 0
    // ]);

    // // ==========================================
    // // 12. INSERT INTO request_details_trip_days
    // // ==========================================

    // $itineraryDays = $itinerary ?? [];

    // $sql = "
    //     INSERT INTO request_details_trip_days
    //     (
    //         request_id,
    //         package_id,
    //         day_id,
    //         title,
    //         day_details,
    //         day_transport,
    //         meal_plan,
    //         stay
    //     )
    //     VALUES
    //     (
    //         :request_id,
    //         :package_id,
    //         :day_id,
    //         :title,
    //         :day_details,
    //         :day_transport,
    //         :meal_plan,
    //         :stay
    //     )
    // ";

    // $stmt = $conn->prepare($sql);

    // foreach ($itineraryDays as $day) {

    //     $stmt->execute([
    //         ':request_id'   => $requestId,
    //         ':package_id'   => $packageId,

    //         ':day_id'       => $day['day_id'] ?? null,
    //         ':title'        => $day['title'] ?? null,
    //         ':day_details'  => $day['day_details'] ?? null,
    //         ':day_transport'=> $day['day_transport'] ?? null,
    //         ':meal_plan'    => $day['meal_plan'] ?? null,
    //         ':stay'         => $day['stay'] ?? null
    //     ]);
    // }
    // ==========================================
    // . TEMPORARY DEBUG OUTPUT
    // REMOVE AFTER TESTING
    // ==========================================

    echo json_encode([
        'success' => true,
        'message' => 'Quotation Sent Successfully.',
        'request_id' => $requestId,
        'package_id' => $packageId,
        'uploaded_files_count' => count($uploadedFiles)
    ]);

    exit;

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

    exit;
}