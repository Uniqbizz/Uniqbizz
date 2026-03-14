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
                max(date) as max_b_date,
                min(date) as min_b_date
            FROM bookings b
            LEFT JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id";
            
    $sql .=" GROUP BY
            b.id,
            b.order_id,
            b.package_id,
            b.customer_id,
            b.name,
            b.status,
            p.name,
            p.tour_days,
            bd.final_price,
            bd.amount,
            bd.part_pay_1,
            bd.part_pay_2,
            bd.part_pay_3,
            bd.part_pay_1_status,
            bd.part_pay_2_status,
            bd.part_pay_3_status,
            bd.status,
            b.confirm_status,
            b.ta_id";

    $stmt = $conn->prepare($sql);
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