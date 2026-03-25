<?php
header("Content-Type: application/json");

require '../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
    exit;
}

$request = json_decode(file_get_contents('php://input'), true);
$id = $request['id'] ?? $id;

// Get Booking Data
$bookings = $conn->prepare("SELECT id,order_id,invoice_no,customer_id,created_date,package_id,status,coupons_code,name,coupons_code,date,adults,children,infants FROM bookings WHERE id = :id");
$bookings->bindParam(':id', $id, PDO::PARAM_INT);
$bookings->execute();
$booking = $bookings->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Booking not found"]);
    exit;
}

// Get Customer
$customers = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = :cust_id");
$customers->execute([':cust_id' => $booking['customer_id']]);
$customer = $customers->fetch(PDO::FETCH_ASSOC);

// Get Booking Members
$members = $conn->prepare("SELECT * FROM booking_member_details WHERE bookings_id = :bookings_id");
$members->execute([':bookings_id' => $booking['id']]);
$memberList = $members->fetchAll(PDO::FETCH_ASSOC);

// Format Dates
$booked_on = date('d-M-Y', strtotime($booking['created_date']));
$tour_on = date('d-M-Y', strtotime($booking['date']));

// Get Package
$packages = $conn->prepare("SELECT * FROM package WHERE id = :package_id");
$packages->execute([':package_id' => $booking['package_id']]);
$package = $packages->fetch(PDO::FETCH_ASSOC);

// Get Package Pictures (Only 1 Picture)
$package_pictures = $conn->prepare("SELECT image FROM package_pictures WHERE package_id = :package_id ORDER BY id ASC LIMIT 1");
$package_pictures->execute([':package_id' => $booking['package_id']]);
$pictures = $package_pictures->fetch(PDO::FETCH_ASSOC);

// Get GST Bill
$price_gst = $conn->prepare("SELECT * FROM booking_gst_bill WHERE bookings_id = :bookings_id");
$price_gst->execute([':bookings_id' => $booking['id']]);
$total_gst = $price_gst->fetchAll(PDO::FETCH_ASSOC);

// Get Direct Bill
$price_direct = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = :bookings_id");
$price_direct->execute([':bookings_id' => $booking['id']]);
$total_direct = $price_direct->fetchAll(PDO::FETCH_ASSOC);
$transaction_id = $total_amount = $discounted_amount = $coupon_amount = 0;
// Status
if (!empty($total_direct)) {

    $isPending = false;
    foreach ($total_direct as $bill) {
        $transaction_id = $bill["paymentid"];
        $total_amount = $bill["final_price"];
        $discounted_amount = $bill["total_net_payable"];
        $coupon_amount = $bill["coupon_discount"];
        if ($bill['status'] == '0') {
            $isPending = true;
            break;
        }
    }
    $pay_status = $isPending ? 'Pending' : 'Successful';
    $pay_status_color = $isPending ? 'orange' : 'green';
} else {
    $pay_status = 'No Bill';
    $pay_status_color = 'gray';
}

// Booking status calculation
$startDate = new DateTime($booking['date']);
$tourDays = !empty($package['tour_days']) ? (int)$package['tour_days'] : 0;
$endDate = clone $startDate;
$endDate->modify("+$tourDays days");

$today = new DateTime();
$today->setTime(0, 0);

if ($today > $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
    $book_status = 'Completed';
} elseif ($today >= $startDate && $today <= $endDate && $booking['status'] != '2' && $booking['status'] != '3') {
    $book_status = 'Traveling';
} else {
    $book_status = 'Upcoming';
}


// Final JSON Response
$response = [
    "status" => "success",
    "booking" => [
        "id" => $booking['id'],
        "invoice_id" => $booking['invoice_no'],
        "booking_no" => $booking['order_id'],
        "booked_on" => $booked_on,
        "tour_on" => $tour_on,
        "status" => $book_status,
        "payment_status" => $pay_status,
        "payment_status_color" => $pay_status_color,
        "transaction_id" => $transaction_id,
        "invoice_date" => $booking['created_date']
    ],
    "customer_id" => $booking["customer_id"],
    "customer_name" => $booking["name"],
    "customer_email" => $customer["email"],
    "customer_address" => $customer["address"],
    "customer_phoneNo" => $customer["contact_no"],
    "members" => $memberList,
    "package" => [
        "name" => $package["name"],
        "destination" => $package["destination"],
        "departure_date" => $booking["date"],
        "member_count" => "Adults-" . $booking["adults"] .", ". "Child-" . $booking["children"] .", ". "Infants-" . $booking["infants"]
        ],
    "package_picture" => $pictures["image"],
    "total_price" => $total_amount,
    "coupon_code" => $booking["coupons_code"] ?? 0,
    "coupon_amount" => $coupon_amount ?? 0,
    "discounted_price" => $discounted_amount ?? 0
];

echo json_encode($response, JSON_PRETTY_PRINT);
