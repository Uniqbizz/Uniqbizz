<?php
require '../connect.php';
// include '../send_sms_helper.php';
// include '../../admin/assets/generate_invoice_number.php';
header('Content-Type:application/json');
// get Row data
// $data = stripslashes(file_get_contents("php://input"));
// // json Decoding, true -> for getting data in associative manner
// $_POST = json_decode($data, true);
// print_r($_POST);

date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');
$today_date = date('j') . '-' . date('n') . '-' . date('Y');

function logToConsole($msg, $isError = false) {
    $type = $isError ? 'error' : 'log';
    echo "<script>console.$type(" . json_encode($msg) . ");</script>";
}

$y = date("Y");
$m = date('n');
$coupon_id = 0;
$booking_id = 0;
$order_id1 = 0;

$coupon_code = '';
$payment_mode=$_POST['payment'];
$markup_payout_customer_id = 0;
$cust_id = $_POST['customerId'];
$user_cust_id = 'TAadmin';
$payment_id = $_POST['payment_id'];
$pay_type = $_POST['pay_type'];
$payment_type=$pay_type == 1 ? 'Full':'Part';
$part_type = isset($_POST['part_type']) && $_POST['part_type'] !== '' ? $_POST['part_type'] : 1;
$book_status = ($pay_type == 1) ?  1 : 0;


$chequeNo=$_POST["chequeNo"]??'';
$chequeDate=$_POST["chequeDate"]??'';
$bankName=$_POST["bankName"]??'';
$transactionNo=$_POST["transactionNo"]??'';

$coupon_code = $_POST['coupons']??['NA'];
$coupon_discount = isset($_POST['coupon_amount']) ? (float)$_POST['coupon_amount'] : 0.0;

// total payment
$gst_total = isset($_POST['payable_amount']) ? (float)$_POST['payable_amount'] : 0.0;


// Get TA Price
$ta_markup = 0;
$discount_price = $_POST['payable_amount'];
$final_price = $gst_total + $coupon_discount;
$amount = $payment_type=='Full'?$final_price:$_POST['paid_amount'];

// $payType = 'Online Payment';

// register customer
$status = '';
$fullname = $_POST['customer_name'];
$todaysDate = date('d/m/Y');
$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0, 8);


// Email Send
$from = "support@uniqbizz.com";          // Company Sender
$cc = "support@uniqbizz.com";            // admin 

$ta_firstname = '';
$ta_lastname = '';



// check if customer is registered -------------------------------------------------------------------------------------------------------------------------------
$customer = $conn->prepare("SELECT email,address,state,country_code,contact_no,status,ta_reference FROM customer where cust_id='" . $cust_id . "' ");
$customer->execute();
$customer->setFetchMode(PDO::FETCH_ASSOC);
if ($customer->rowCount() > 0) {
    $cust_status = $customer->fetch();

    $status = $cust_status['status'];
    $email = $cust_status["email"];
    $address = $cust_status["address"];
    $state = $cust_status["state"];
    $country_code = $cust_status['country_code'];
    $contact_no = $cust_status['contact_no'];
    $ta_reference = 'TAadmin';

    // register lead customer
    if ($status == 2) {
        $sql4 = "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
        $stmt4 = $conn->prepare($sql4);
        $result4 = $stmt4->execute(array(
            ':uname' => $email,
            ':password' => $password,
            ':user_id' => $cust_id,
            ':user_type_id' => 2,
            ':status' => 1
        ));

        $sql1 = "UPDATE customer SET package=:package,status=:status WHERE cust_id=:cust_id";
        $stmt = $conn->prepare($sql1);
        $result =  $stmt->execute(array(
            ':package' => 1,
            ':status' => 1,
            ':cust_id' => $cust_id
        ));

        $sql9 = $conn->prepare("SELECT firstname,lastname,email from travel_agent where travel_agent_id='" . $ta_reference . "'");
        $sql9->execute();
        $sql9->setFetchMode(PDO::FETCH_ASSOC);
        if ($sql9->rowCount() > 0) {
            $row9 = $sql9->fetch();
            $taEmail = $row9["email"];
            $ta_firstname = $row9["firstname"];
            $ta_lastname = $row9["lastname"];
        }

        //message
        // sms to new login register 
        //sendMessage($country_code,$contact_no,1,$email,$password,$cust_id,'','','');
        // return null;
        // sendMail("cust",$fullname,$address,$email,$email,$password,$todaysDate,$cust_id,"","");
        // sendMail("admin",$fullname,$address,"support@uniqbizz.com",$email,$password,$todaysDate,$cust_id,"","");
        // sendMail("ta",$fullname,$address,$taEmail,"","",$todaysDate,$cust_id,$ta_firstname,$ta_lastname);
    }
}
//-------------------------------------------------------------------------------------------------------------------------------

//get coupon details and update it by SV
if (!empty($coupon_code) && is_array($coupon_code)) {
    $coupon_sql = 'UPDATE cu_coupons SET usage_status = 1 WHERE code = :code';
    $coupon_stmt = $conn->prepare($coupon_sql);

    foreach ($coupon_code as $code) {
        $coupon_stmt->execute([':code' => $code]);
    }
}

//generate invoice id
function getInvoice()
{
    $prefix = 'BH';
    $date = date('YmdHis'); // Format: YYYYMMDDHHMMSS
    return $prefix . $date;
}

// insert package data
if (is_array($coupon_code) && $coupon_code[0] !== 'NA') {
    $sql = 'INSERT INTO bookings (package_id,payment_id,ta_id,customer_id,name,email,phone,date,adults,children,infants,status,created_date,coupons_code,invoice_no,confirm_status) 
                VALUES (:package_id,:payment_id,:ta_id,:customer_id,:name,:email,:phone,:date,:adults,:children,:infants,:status,:created_date,:coupons_code,:invoice_no,:confirm_status)';
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
        ':invoice_no' => getInvoice(),
        ':package_id' => $_POST['package_id'],
        ':payment_id' => '',
        ':ta_id' => $user_cust_id,
        ':customer_id' => $cust_id,
        ':name' => $_POST['customer_name'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone_no'],
        ':date' => $_POST['date'],
        ':adults' => $_POST['adults'],
        ':children' => $_POST['child'],
        ':infants' => $_POST['infants'],
        ':status' => $book_status,
        ':created_date' => $today,
        ':coupons_code' => implode(',',$coupon_code),
        ':confirm_status' => '0'
    ]);
} else {
    $sql = 'INSERT INTO bookings (package_id,payment_id,ta_id,customer_id,name,email,phone,date,adults,children,infants,status,created_date,invoice_no,confirm_status) 
                  VALUES (:package_id,:payment_id,:ta_id,:customer_id,:name,:email,:phone,:date,:adults,:children,:infants,:status,:created_date,:invoice_no,:confirm_status)';
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
        ':invoice_no' => getInvoice(),
        ':package_id' => $_POST['package_id'],
        ':payment_id' => '',
        ':ta_id' => $user_cust_id,
        ':customer_id' => $cust_id,
        ':name' => $_POST['customer_name'],
        ':email' => $_POST['email'],
        ':phone' => $_POST['phone_no'],
        ':date' => $_POST['date'],
        ':adults' => $_POST['adults'],
        ':children' => $_POST['child'],
        ':infants' => $_POST['infants'],
        ':status' => $book_status,
        ':created_date' => $today,
        ':confirm_status' => '0'
    ]);
}

// get Booking ID
if ($result) {
    $bookings_data = $conn->prepare("SELECT id FROM bookings ORDER BY id DESC LIMIT 1");
    $bookings_data->execute();
    $booking_id_data = $bookings_data->fetch();
    $booking_id = (int)$booking_id_data["id"];

    //  create order Id 
    $book_id = 100000 * $m + $booking_id;
    $order_id = $y . $book_id;

    // update bokking table with order id
    $order_sql = $conn->prepare("UPDATE bookings SET order_id=:order_id WHERE id = '" . $booking_id . "'");
    $order_sql->execute([
        ':order_id' => $order_id
    ]);
}

// booking Members
$sql1 = 'INSERT INTO booking_member_details (bookings_id,name,age,gender) 
                VALUES (:bookings_id,:name,:age,:gender)';
$stmt1 = $conn->prepare($sql1);
foreach ($_POST['members'] as $member) {
    $stmt1->bindParam(':bookings_id', $booking_id, PDO::PARAM_INT);
    $stmt1->bindParam(':name', $member['name']);
    $stmt1->bindParam(':age', $member['age']);
    $stmt1->bindParam(':gender', $member['gender']);
    $result1 = $stmt1->execute();
}
//payment details
$sql1 = 'INSERT INTO direct_customer_booking (booking_id,payment_id,payment_mode,paid_amount,cheque_no,cheque_date,bank_name,transaction_id,status) 
         VALUES (:booking_id,:payment_id,:payment_mode,:paid_amount,:cheque_no,:cheque_date,:bank_name,:transaction_id,:status)';
$stmt1 = $conn->prepare($sql1);
foreach ($_POST['members'] as $member) {
    $stmt1->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt1->bindParam(':payment_id', $payment_id);
    $stmt1->bindParam(':payment_mode', $payment_mode);
    $stmt1->bindParam(':paid_amount', $amount);
    $stmt1->bindParam(':cheque_no', $chequeNo);
    $stmt1->bindParam(':cheque_date', $chequeDate);
    $stmt1->bindParam(':bank_name', $bankName);
    $stmt1->bindParam(':transaction_id', $transactionNo);
    $stmt1->bindValue(':status', 1, PDO::PARAM_INT);
    $result1 = $stmt1->execute();
}
// booking DIRECT invoice with wallet amount payment
if (is_array($coupon_code) && $coupon_code[0] !== 'NA') {
    $gst_total -= $coupon_discount; // Apply coupon discount before any split
}
$result2='';
if ($part_type == 1) {
    // FULL PAYMENT
    if (is_array($coupon_code) && $coupon_code[0] !== 'NA') {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price,
                    paymentid, amount, pay_type, status, coupon_discount, total_net_payable
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price,
                    :paymentid, :amount, :pay_type, :status, :coupon_discount, :total_net_payable
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id??0,
            ':total_price' => $gst_total??0,
            ':ta_markup' => $ta_markup??0,
            ':final_price' => $final_price??0,
            ':paymentid' => $payment_id??0,
            ':amount' => $amount??0,
            ':pay_type' => $part_type??0,
            ':status' => 1,
            ':coupon_discount' => $coupon_discount??0,
            ':total_net_payable' => $discount_price??0
        ]);

    } else {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price,
                    paymentid, amount, pay_type, status
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price,
                    :paymentid, :amount, :pay_type, :status
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id??0,
            ':total_price' => $gst_total??0,
            ':ta_markup' => $ta_markup??0,
            ':final_price' => $final_price??0,
            ':paymentid' => $payment_id??0,
            ':amount' => $amount??0,
            ':pay_type' => $part_type??0,
            ':status' => 1
        ]);

    }

} elseif ($part_type == '2') {
    // 2-PART PAYMENT
    $part_pay_1 = $gst_total / 2;
    $part_pay_1_status = 1;
    $part_pay_2 = $gst_total / 2;
    $part_pay_2_status = 0;

    if (is_array($coupon_code) && $coupon_code[0] !== 'NA') {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price, paymentid,
                    part_pay_1, part_pay_1_status, part_pay_2, part_pay_2_status,
                    pay_type, status, coupon_discount, total_net_payable
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price, :paymentid,
                    :part_pay_1, :part_pay_1_status, :part_pay_2, :part_pay_2_status,
                    :pay_type, :status, :coupon_discount, :total_net_payable
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':paymentid' => $payment_id,
            ':part_pay_1' => $part_pay_1,
            ':part_pay_1_status' => $part_pay_1_status,
            ':part_pay_2' => $part_pay_2,
            ':part_pay_2_status' => $part_pay_2_status,
            ':pay_type' => $part_type,
            ':status' => 0,
            ':coupon_discount' => $coupon_discount,
            ':total_net_payable' => $discount_price
        ]);
    } else {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price, paymentid,
                    part_pay_1, part_pay_1_status, part_pay_2, part_pay_2_status,
                    pay_type, status
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price, :paymentid,
                    :part_pay_1, :part_pay_1_status, :part_pay_2, :part_pay_2_status,
                    :pay_type, :status
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':paymentid' => $payment_id,
            ':part_pay_1' => $part_pay_1,
            ':part_pay_1_status' => $part_pay_1_status,
            ':part_pay_2' => $part_pay_2,
            ':part_pay_2_status' => $part_pay_2_status,
            ':pay_type' => $part_type,
            ':status' => 0
        ]);
    }

} elseif ($part_type == '3') {
    // 3-PART PAYMENT
    $part_pay_1 = $gst_total * 0.4;
    $part_pay_1_status = 1;
    $part_pay_2 = $gst_total * 0.3;
    $part_pay_2_status = 0;
    $part_pay_3 = $gst_total * 0.3;
    $part_pay_3_status = 0;

    if (is_array($coupon_code) && $coupon_code[0] !== 'NA') {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price, paymentid,
                    part_pay_1, part_pay_1_status, part_pay_2, part_pay_2_status,
                    part_pay_3, part_pay_3_status,
                    pay_type, status, coupon_discount, total_net_payable
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price, :paymentid,
                    :part_pay_1, :part_pay_1_status, :part_pay_2, :part_pay_2_status,
                    :part_pay_3, :part_pay_3_status,
                    :pay_type, :status, :coupon_discount, :total_net_payable
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':paymentid' => $payment_id,
            ':part_pay_1' => $part_pay_1,
            ':part_pay_1_status' => $part_pay_1_status,
            ':part_pay_2' => $part_pay_2,
            ':part_pay_2_status' => $part_pay_2_status,
            ':part_pay_3' => $part_pay_3,
            ':part_pay_3_status' => $part_pay_3_status,
            ':pay_type' => $part_type,
            ':status' => 0,
            ':coupon_discount' => $coupon_discount,
            ':total_net_payable' => $discount_price
        ]);
    } else {
        $sql2 = 'INSERT INTO booking_direct_bill (
                    bookings_id, total_price, ta_markup, final_price, paymentid,
                    part_pay_1, part_pay_1_status, part_pay_2, part_pay_2_status,
                    part_pay_3, part_pay_3_status,
                    pay_type, status
                ) VALUES (
                    :bookings_id, :total_price, :ta_markup, :final_price, :paymentid,
                    :part_pay_1, :part_pay_1_status, :part_pay_2, :part_pay_2_status,
                    :part_pay_3, :part_pay_3_status,
                    :pay_type, :status
                )';

        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':paymentid' => $payment_id,
            ':part_pay_1' => $part_pay_1,
            ':part_pay_1_status' => $part_pay_1_status,
            ':part_pay_2' => $part_pay_2,
            ':part_pay_2_status' => $part_pay_2_status,
            ':part_pay_3' => $part_pay_3,
            ':part_pay_3_status' => $part_pay_3_status,
            ':pay_type' => $part_type,
            ':status' => 0
        ]);
    }
}
if ($result2) {
    echo 1;
}else{
    echo 0;
}
?>