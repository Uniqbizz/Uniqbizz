<?php
header('Content-Type: application/json');
require '../../../../connect.php';

// =====================================================
// INPUTS
// =====================================================
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Reject malformed JSON before validating individual fields.
if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
    echo json_encode([
        "status" => 0,
        "message" => "Invalid JSON request."
    ]);
    exit;
}

try {
    // =====================================================
    // VALIDATE PACKAGE
    // =====================================================

    $packageIdInput = trim((string)($data['package_id'] ?? ''));

    if ($packageIdInput === '' || !ctype_digit($packageIdInput) || (int)$packageIdInput < 1) {
        echo json_encode([
            "status" => 0,
            "message" => "Invalid package."
        ]);
        exit;
    }

    // =====================================================
    // VALIDATE USER / GUEST DETAILS
    // If either user field is missing/blank, require all
    // three guest fields.
    // =====================================================

    $inputUserId = trim((string)($data['userId'] ?? ''));
    $inputUserTypeIdValue = trim((string)($data['userTypeIdValue'] ?? ''));

    if ($inputUserId === '' || $inputUserTypeIdValue === '') {
        $inputGuestFullName = trim((string)($data['guestFullName'] ?? ''));
        $inputGuestPhone = trim((string)($data['guestPhone'] ?? ''));
        $inputGuestEmail = trim((string)($data['guestEmail'] ?? ''));

        if (
            $inputGuestFullName === '' ||
            $inputGuestPhone === '' ||
            $inputGuestEmail === ''
        ) {
            echo json_encode([
                "status" => 0,
                "message" => "guestFullName, guestPhone, and guestEmail are required."
            ]);
            exit;
        }
    }

    // =====================================================
    // REQUEST ID
    // =====================================================
    function generateRequestId($conn)
    {
        do {
            // 4-bit randomness
            $requestId =
            "RQ" .
            date("ymdHis") .
            strtoupper(bin2hex(random_bytes(4)));
            $stmt = $conn->prepare("
                SELECT id
                FROM request_details
                WHERE request_id = :request_id
                LIMIT 1
            ");
            $stmt->execute([
                ":request_id" => $requestId
            ]);
        } while ($stmt->fetch());
        return $requestId;
    }
    $requestId = generateRequestId($conn);
    // =====================================================
    // BASIC DETAILS
    // =====================================================
    $packageId = (int)($data['package_id'] ?? 0);
    // =====================================================
    // TRAVEL DETAILS
    // =====================================================
    $travelStartDate =$data['travel_start_date'] ?? null;
    $travelEndDate =$data['travel_end_date'] ?? null;
    $customerPickup =trim($data['pickup_location'] ?? '');
    $customerDrop =trim($data['drop_location'] ?? '');
    $guestFullName =trim($data['guestFullName'] ?? '');
    $guestPhone =trim($data['guestPhone'] ?? '');
    $guestEmail =trim($data['guestEmail'] ?? '');
    $userId = trim((string)($data['userId'] ?? ''));
    $userTypeIdValue = trim((string)($data['userTypeIdValue'] ?? ''));

    // Only fetch account details when BOTH user fields are provided.
    // Guest requests skip the database lookup and keep the supplied guest details.
    if ($userId !== '' && $userTypeIdValue !== '') {
        $userTypeId = (int)$userTypeIdValue;

        // These user types do not use the role-table lookup.
        if (!in_array($userTypeId, [15, 17, 1], true)) {
            $user_role_table = [
                10 => "ca_customer",
                11 => "ca_travelagency",
                16 => "corporate_agency",
                24 => "emplyees",
                25 => "emplyees",
                26 => "business_mentor",
                28 => "master_franchisee",
                29 => "sub_franchisee",
                30 => "sponsor_franchisee",
                32 => "institution",
                33 => "institution_banch_manager",
                34 => "executive_techno_enterprise",
                35 => "super_techno_enterprise",
                36 => "chief_techno_enterprise",
            ];

            // Prevent undefined array keys and invalid SQL for unsupported types.
            if (!isset($user_role_table[$userTypeId])) {
                echo json_encode([
                    "status" => 0,
                    "message" => "Unsupported userTypeIdValue."
                ]);
                exit;
            }

            $table = $user_role_table[$userTypeId];
        // =====================================================
        // DETERMINE COLUMNS
        // =====================================================
        if (in_array($userTypeIdValue, [24, 25])) {
            $columns = "name, email, contact";
            $user_column = "employee_id";
        } elseif ($userTypeIdValue == 32) {
            $columns = "name, email, contact_no";
            $user_column = $table . "_id";
        } else {
            $columns = "CONCAT(firstname, ' ', lastname) AS name, email, contact_no";
            $user_column = $table . "_id";
        }
        // =====================================================
        // GET USER DETAILS FROM DB
        // =====================================================
        $stmt = $conn->prepare("
            SELECT $columns
            FROM $table
            WHERE $user_column = :user_id
            LIMIT 1
        ");
        $stmt->execute([
            'user_id' => $userId
        ]);
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        // =====================================================
        // REPLACE GUEST VALUES WITH DB VALUES
        // =====================================================
        if ($userDetails) {
            $guestFullName = trim($userDetails['name'] ?? '');
            if (in_array($userTypeIdValue, [24, 25])) {
                $guestPhone = trim($userDetails['contact'] ?? '');
            } else {
                $guestPhone = trim($userDetails['contact_no'] ?? '');
            }
            $guestEmail = trim($userDetails['email'] ?? '');
            }
        }
    }
    // =====================================================
    // TRAVELLERS
    // =====================================================
    $adultCount =(int)($data['adults'] ?? $data['adult_count'] ?? 0);
    $childCount =(int)($data['children'] ?? $data['child_count'] ?? 0);
    $infantCount =(int)($data['infants'] ?? $data['infant_count'] ?? 0);
    // =====================================================
    // PRICES
    // =====================================================
    $adultPrice =(float)($data['adult_price'] ?? 0);
    $childPrice =(float)($data['child_price'] ?? 0);
    // =====================================================
    // VALIDATION
    // =====================================================
    if ($adultCount < 1) {
        echo json_encode([
            "status" => 0,
            "message" => "At least one adult is required."
        ]);
        exit;
    }
    if (empty($travelStartDate)) {
        echo json_encode([
            "status" => 0,
            "message" => "Please select travel start date."
        ]);
        exit;
    }
    if (empty($travelEndDate)) {
        echo json_encode([
            "status" => 0,
            "message" => "Please select travel end date."
        ]);
        exit;
    }
    // =====================================================
    // PACKAGE DETAILS
    // =====================================================
    $packageStmt = $conn->prepare("
        SELECT
            id,
            travel_from,
            travel_to,
            tour_days
        FROM package
        WHERE id = :package_id
        LIMIT 1
    ");
    $packageStmt->execute([
        ":package_id" => $packageId
    ]);
    $package =$packageStmt->fetch(PDO::FETCH_ASSOC);
    if (!$package) {
        echo json_encode([
            "status" => 0,
            "message" => "Package not found."
        ]);
        exit;
    }
    // =====================================================
    // PACKAGE PICKUP / DROP
    // =====================================================
    $pickupPoint =$package['travel_from'] ?? '';
    $dropPoint =$package['travel_to'] ?? '';
    // =====================================================
    // NIGHTS / DAYS
    // =====================================================
    $startDate = new DateTime($travelStartDate);
    $endDate   = new DateTime($travelEndDate);

    $calendarDays = $startDate->diff($endDate)->days + 1;

    // Nights = calendar days - 1
    $nights = max(0, $calendarDays - 1);

    // Your business rule:
    // 5 calendar days = 4 Nights / 3 Days
    $days = max(0, $calendarDays);

    $noOfNightsDays =$nights . " Nights / " . $days . " Days";
    // =====================================================
    // PREFERENCES
    // =====================================================
    $hotelCategory =trim($data['hotel_category'] ?? '');
    $mealPreference =trim($data['meal_preference'] ?? '');
    $transportPreference =trim($data['transport_preference'] ?? '');
    $specialRequirement =trim($data['special_requirement'] ?? '');
    $old_hotel_category=trim($data['old_hotel_category']??'');
    $old_meal_preference=trim($data['old_meal_preference']??'');
    $old_transport_preference=trim($data['old_transport_preference']??'');
    // =====================================================
    // TRANSPORT
    // =====================================================
    $transportType =trim($data['transport_type'] ?? '');
    $transportAmt =(float)($data['transport_amt'] ?? 0);
    // =====================================================
    // ROOM DETAILS
    // =====================================================
    $rooms = [];
    if (!empty($data['rooms'])) {
        $rooms = is_array($data['rooms'])
            ? $data['rooms']
            : json_decode($data['rooms'],true);
        if (!is_array($rooms)) {
            $rooms = [];
        }
    }
    $roomCount = count($rooms);
    if ($roomCount < 1) {
        $roomCount = 1;
    }
    // =====================================================
    // MATTRESS COUNT
    // =====================================================
    $mattressCount =(int)($data['mattress_count'] ?? 0);
    // =====================================================
    // COUPON DETAILS
    // =====================================================
    $coupons = [];
    if (!empty($data['coupons'])) {
        $coupons = is_array($data['coupons'])
            ? $data['coupons']
            : json_decode(
                $data['coupons'],
                true
            );
        if (!is_array($coupons)) {
            $coupons = [];
        }
    }
    $couponAppliedCount =count($coupons);
    // =====================================================
    // PRICE DETAILS
    // =====================================================
    $adultTotal =(float)($data['adult_total'] ?? 0);
    $childrenTotal =(float)($data['children_total'] ?? 0);
    $subtotal =(float)($data['subtotal'] ?? 0);
    $convenienceFee =(float)($data['convenience_fee'] ?? 0);
    $gstPercentage =(float)($data['gst_percentage'] ?? 0);
    $gst =(float)($data['gst_value'] ?? 0);
    $couponDiscount =(float)($data['coupon_discount'] ?? 0);
    $referralWallet = (float)($data['referral_wallet_amount'] ?? 0);
    $discountWallet = (float)($data['discount_wallet_amount'] ?? 0);
    $finalPrice =(float)($data['final_package_price'] ?? 0);
    // =====================================================
    // GROSS PRICE
    // Before coupon discount
    // =====================================================
    $grossPrice =$subtotal +$convenienceFee +$gst;
    // =====================================================
    // JSON DATA
    // =====================================================
    $couponsJson =
        !empty($coupons)
            ? json_encode($coupons, JSON_UNESCAPED_UNICODE)
            : null;
    $roomsJson =
        !empty($rooms)
            ? json_encode($rooms, JSON_UNESCAPED_UNICODE)
            : null;

    // =====================================================
    // INSERT REQUEST
    // =====================================================
    $stmt = $conn->prepare("
        INSERT INTO request_details
        (
            request_id,
            package_id,
            userId,
            guestFullName,
            guestPhone,
            guestEmail,
            travel_start_date,
            travel_end_date,
            pickup_point,
            customer_pickup,
            drop_point,
            customer_drop,
            adult_count,
            child_count,
            infant_count,
            adult_price,
            child_price,
            adult_total,
            children_total,
            transport_type,
            transport_amt,
            no_of_nights_days,
            room_count,
            mattress_count,
            hotel_category,
            meal_preference,
            transport_preference,
            special_requirement,
            subtotal,
            convenience_fee,
            gst_percentage,
            gst,
            coupons_applied_count,
            coupon_discount,
            base_price,
            gross_price,
            final_price,
            coupons,
            rooms,
            discount_wallet_amount,
            referral_wallet_amount,
            old_hotel_category,
            old_meal_preference,
            old_transport_preference
        )

        VALUES
        (
            :request_id,
            :package_id,
            :userId,
            :guestFullName,
            :guestPhone,
            :guestEmail,
            :travel_start_date,
            :travel_end_date,
            :pickup_point,
            :customer_pickup,
            :drop_point,
            :customer_drop,
            :adult_count,
            :child_count,
            :infant_count,
            :adult_price,
            :child_price,
            :adult_total,
            :children_total,
            :transport_type,
            :transport_amt,
            :no_of_nights_days,
            :room_count,
            :mattress_count,
            :hotel_category,
            :meal_preference,
            :transport_preference,
            :special_requirement,
            :subtotal,
            :convenience_fee,
            :gst_percentage,
            :gst,
            :coupon_applied_count,
            :coupon_discount,
            :base_price,
            :gross_price,
            :final_price,
            :coupons,
            :rooms,
            :discount_wallet_amount,
            :referral_wallet_amount,
            :old_hotel_category,
            :old_meal_preference,
            :old_transport_preference
        )

    ");

    // =====================================================
    // EXECUTE INSERT
    // =====================================================

    $stmt->execute([
        // -------------------------------------------------
        // REQUEST
        // -------------------------------------------------
        'request_id' => $requestId,
        'package_id' => $packageId,
        // -------------------------------------------------
        // USER / GUEST
        // -------------------------------------------------
        'userId'       => $userId,
        'guestFullName' => $guestFullName,
        'guestPhone'    => $guestPhone,
        'guestEmail'    => $guestEmail,
        // -------------------------------------------------
        // TRAVEL
        // -------------------------------------------------
        'travel_start_date' => $travelStartDate,
        'travel_end_date'   => $travelEndDate,
        // -------------------------------------------------
        // PICKUP / DROP
        // -------------------------------------------------
        'pickup_point'    => $pickupPoint,
        'customer_pickup' => $customerPickup,
        'drop_point'      => $dropPoint,
        'customer_drop'   => $customerDrop,
        // -------------------------------------------------
        // TRAVELLERS
        // -------------------------------------------------
        'adult_count'  => $adultCount,
        'child_count'  => $childCount,
        'infant_count' => $infantCount,
        // -------------------------------------------------
        // PRICES
        // -------------------------------------------------
        'adult_price'    => $adultPrice,
        'child_price'    => $childPrice,
        'adult_total'    => $adultTotal,
        'children_total' => $childrenTotal,
        // -------------------------------------------------
        // TRANSPORT
        // -------------------------------------------------
        'transport_type' => $transportType,
        'transport_amt'  => $transportAmt,
        // -------------------------------------------------
        // DURATION
        // -------------------------------------------------
        'no_of_nights_days' => $noOfNightsDays,
        // -------------------------------------------------
        // ROOMS
        // -------------------------------------------------
        'room_count'     => $roomCount,
        'mattress_count' => $mattressCount,
        // -------------------------------------------------
        // PREFERENCES
        // -------------------------------------------------
        'hotel_category'       => $hotelCategory,
        'meal_preference'     => $mealPreference,
        'transport_preference' => $transportPreference,
        'special_requirement' => $specialRequirement,
        ':old_hotel_category' =>$old_hotel_category,
        ':old_meal_preference' =>$old_meal_preference,
        ':old_transport_preference'=>$old_transport_preference,
        // -------------------------------------------------
        // PRICING
        // -------------------------------------------------
        'subtotal'        => $subtotal,
        'convenience_fee' => $convenienceFee,
        'gst_percentage'  => $gstPercentage,
        'gst'             => $gst,
        // -------------------------------------------------
        // COUPONS
        // -------------------------------------------------
        'coupon_applied_count' => $couponAppliedCount,
        'coupon_discount'      => $couponDiscount,
        // -------------------------------------------------
        // FINAL PRICING
        // -------------------------------------------------
        'base_price'  => $subtotal,
        'gross_price' => $grossPrice,
        'final_price' => $finalPrice,
        // -------------------------------------------------
        // JSON
        // -------------------------------------------------
        'coupons' => $couponsJson,
        'rooms'   => $roomsJson,
        'discount_wallet_amount' => $discountWallet,
        'referral_wallet_amount' => $referralWallet
    ]);
    // =====================================================
    // SUCCESS
    // =====================================================
    echo json_encode([
        "status" => 1,
        "message" =>
            "Your travel enquiry has been submitted successfully.",
        "enquiry_no" =>
            $requestId,
        "request_id" =>
            $requestId
    ]);
    exit;
} catch (Throwable $e) {
    error_log(
        "Submit Request Quote Error: " .
        $e->getMessage()
    );
    // DEVELOPMENT ONLY
    echo json_encode([
        "status" => 0,
        "message" =>
            "Unable to submit your request. Please try again.",
        "error" =>
            $e->getMessage()
    ]);
    exit;
}