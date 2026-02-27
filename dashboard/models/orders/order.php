<?php
    $id = $_GET['id'];

    // Get Booking Data
    $bookings = $conn->prepare("SELECT * FROM bookings WHERE id = :id");
    $bookings->bindParam(':id', $id, PDO::PARAM_INT);
    $bookings->execute();
    $booking = $bookings->fetch(PDO::FETCH_ASSOC); // ✅ Use fetch(), not fetchAll()

    if (!$booking) {
        die("Booking not found!"); // Handle case where no booking is found
    }

    // Get Customer
    $customers = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = :cust_id");
    $customers->execute([':cust_id' => $booking['customer_id']]);
    $customer = $customers->fetch(PDO::FETCH_ASSOC);

    // Get Booking Members
    $members = $conn->prepare("SELECT * FROM booking_member_details WHERE bookings_id = :bookings_id");
    $members->execute([':bookings_id' => $booking['id']]);
    $member = $members->fetchAll(PDO::FETCH_ASSOC);

    // Format Dates
    $booked_on = date('d-M-Y', strtotime($booking['created_date']));
    $tour_on = date('d-M-Y', strtotime($booking['date']));


    // Get Package
    $packages = $conn->prepare("SELECT * FROM package WHERE id = :package_id");
    $packages->execute([':package_id' => $booking['package_id']]);
    $package = $packages->fetch(PDO::FETCH_ASSOC);

    // Get Package Pictures (Only 1 Picture)
    $package_pictures = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = :package_id ORDER BY id ASC LIMIT 1");
    $package_pictures->execute([':package_id' => $booking['package_id']]);
    $pictures = $package_pictures->fetchAll(PDO::FETCH_ASSOC);

    // Get GST Bill
    $price_gst = $conn->prepare("SELECT * FROM booking_gst_bill WHERE bookings_id = :bookings_id");
    $price_gst->execute([':bookings_id' => $booking['id']]);
    $total_gst = $price_gst->fetch(PDO::FETCH_ASSOC);

    // Get Direct Bill
    $price_direct = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = :bookings_id");
    $price_direct->execute([':bookings_id' => $booking['id']]);
    $total_direct = $price_direct->fetch(PDO::FETCH_ASSOC);

    // Status
    $pay_status = ($total_direct['status'] == '0') ? 'Pending' : 'Successful';
    $pay_status_color = ($total_direct['status'] == '0') ? 'orange' : 'green';

    // Get Payment Details
    $payments = $conn->prepare("SELECT * FROM payment WHERE id = :payment_id");
    $payments->execute([':payment_id' => $booking['payment_id']]);
    $payment = $payments->fetch(PDO::FETCH_ASSOC);

    $count_mem = 1;
    // booking date format
    $startDate = new DateTime($booking['date']); // Convert to DateTime object

    $tourDays = !empty($package['tour_days']) ? (int)$package['tour_days'] : 0; // Ensure it's an integer

    $endDate = clone $startDate; // Clone to avoid modifying original date
    $endDate->modify("+$tourDays days"); // Add tour days

    $today = new DateTime(); // Get the current date
    $today->setTime(0, 0); // Reset time for accurate comparison
    if ($today > $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
        $book_status = 'Completed';
    } else if ($today >= $startDate && $today <= $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
        $book_status = 'In Progress';
    }else {
        $book_status = 'Upcoming';
    }
?>