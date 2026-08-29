<?php
/**
 * Only God and i knew whats in the code and how its works
 * Now on God knows
 * once ur done wasting your time
 * please update the hours wasted
 * Total Hours: 2 
 */

session_start();
header('Content-Type: application/json');
require_once("../../connect.php");
try {
    // =====================================================
    // VALIDATE PACKAGE
    // =====================================================
    if (!isset($_POST['package_id']) ||empty($_POST['package_id'])) {
        echo json_encode([
            "status" => 0,
            "message" => "Invalid package."
        ]);
        exit;
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
    $packageId = (int)($_POST['package_id'] ?? 0);
    // =====================================================
    // TRAVEL DETAILS
    // =====================================================
    $travelStartDate =$_POST['travel_start_date'] ?? null;
    $travelEndDate =$_POST['travel_end_date'] ?? null;
    $customerPickup =trim($_POST['pickup_location'] ?? '');
    $customerDrop =trim($_POST['drop_location'] ?? '');
    $guestFullName =trim($_POST['guestFullName'] ?? '');
    $guestPhone =trim($_POST['guestPhone'] ?? '');
    $guestEmail =trim($_POST['guestEmail'] ?? '');
    $userId = $_POST['userId'] ?? '';
    $userTypeIdValue =trim($_POST['userTypeIdValue'] ?? '');
    if (!in_array($userTypeIdValue, [15, 17, 1]) && $userTypeIdValue != 'null') {
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
        $table = $user_role_table[$userTypeIdValue];
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
    // =====================================================
    // TRAVELLERS
    // =====================================================
    $adultCount =(int)($_POST['adults'] ?? $_POST['adult_count'] ?? 0);
    $childCount =(int)($_POST['children'] ?? $_POST['child_count'] ?? 0);
    $infantCount =(int)($_POST['infants'] ?? $_POST['infant_count'] ?? 0);
    // =====================================================
    // PRICES
    // =====================================================
    $adultPrice =(float)($_POST['adult_price'] ?? 0);
    $childPrice =(float)($_POST['child_price'] ?? 0);
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
    $days = max(0, $calendarDays - 2);

    $noOfNightsDays =$nights . " Nights / " . $days . " Days";
    // =====================================================
    // PREFERENCES
    // =====================================================
    $hotelCategory =trim($_POST['hotel_category'] ?? '');
    $mealPreference =trim($_POST['meal_preference'] ?? '');
    $transportPreference =trim($_POST['transport_preference'] ?? '');
    $specialRequirement =trim($_POST['special_requirement'] ?? '');
    // =====================================================
    // TRANSPORT
    // =====================================================
    $transportType =trim($_POST['transport_type'] ?? '');
    $transportAmt =(float)($_POST['transport_amt'] ?? 0);
    // =====================================================
    // ROOM DETAILS
    // =====================================================
    $rooms = [];
    if (!empty($_POST['rooms'])) {
        $rooms = json_decode($_POST['rooms'],true);
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
    $mattressCount =(int)($_POST['mattress_count'] ?? 0);
    // =====================================================
    // COUPON DETAILS
    // =====================================================
    $coupons = [];
    if (!empty($_POST['coupons'])) {
        $coupons = json_decode(
            $_POST['coupons'],
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
    $adultTotal =(float)($_POST['adult_total'] ?? 0);
    $childrenTotal =(float)($_POST['children_total'] ?? 0);
    $subtotal =(float)($_POST['subtotal'] ?? 0);
    $convenienceFee =(float)($_POST['convenience_fee'] ?? 0);
    $gstPercentage =(float)($_POST['gst_percentage'] ?? 0);
    $gst =(float)($_POST['gst_value'] ?? 0);
    $couponDiscount =(float)($_POST['coupon_discount'] ?? 0);
    $finalPrice =(float)($_POST['final_package_price'] ?? 0);
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
            rooms
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
            :rooms
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
        'rooms'   => $roomsJson
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