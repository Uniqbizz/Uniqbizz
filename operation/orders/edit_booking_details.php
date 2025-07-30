<?php
require '../connect.php';
// include '../send_sms_helper.php';
// include '../../admin/assets/generate_invoice_number.php';
header('Content-Type:application/json');

date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');
$today_date = date('j') . '-' . date('n') . '-' . date('Y');

$y = date("Y");
$m = date('n');
$coupon_id = 0;
$booking_id = $_POST['id'];
$order_id1 = 0;

$coupon_code = '';
$payment_mode=$_POST['payment'];
$markup_payout_customer_id = 0;
$cust_id = $_POST['customerId'];
$user_cust_id = 'TAadmin';
$partPayments = $_POST['part_payments'] ?? [];

$payment_id = null;
$paid_amount = null;
$status = 0;
$part_type=$_POST['part_type'] ?? 1;
if (!empty($partPayments) && is_array($partPayments)) {
    $lastPart = end($partPayments); // Get the last payment part
    $paid_amount = $_POST['paid_amount'];
    $payment_id = $lastPart['transaction_id'] ?? null;

    if ($part_type == 2) {
        // For 2-part payments, always mark complete
        $status = 1;
    } elseif ($part_type == 3 && isset($lastPart['part']) && $lastPart['part'] == '3') {
        // For 3-part payments, only mark complete if last part is Part 3
        $status = 1;
    }
}
$pay_type = $_POST['pay_type'];
$payment_type=$pay_type == 1 ? 'Full':'Part';

$book_status = ($status == 1) ?  1 : 0;

$chequeNo=$_POST["chequeNo"]??'';
$chequeDate=$_POST["chequeDate"]??'';
$bankName=$_POST["bankName"]??'';
$transactionNo=$_POST["transactionNo"]??'';

$selected = $_POST['selected_coupons'] ?? [];

if (!is_array($selected)) {
    $selected = ($selected == '--Select Coupon...') ? ['NA'] : [$selected];
} elseif (empty($selected)) {
    $selected = ['NA'];
}

$coupon_code = implode(',', $selected);
$coupon_discount = isset($_POST['coupon_amount']) ? (float)$_POST['coupon_amount'] : 0.0;

// total payment
$gst_total = isset($_POST['payable_amount']) ? (float)$_POST['payable_amount'] : 0.0;


// Get TA Price
$ta_markup = 0;
$discount_price = $_POST['payable_amount'];
$final_price = $gst_total + $coupon_discount;
$amount = $payment_type=='Full'?$final_price:$paid_amount;

// $payType = 'Online Payment';

// register customer
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
if (!empty($selected)) {
    $coupon_sql = 'UPDATE cu_coupons SET usage_status = 1 WHERE code = :code';
    $coupon_stmt = $conn->prepare($coupon_sql);

    foreach ($selected as $code) {
        $code = trim($code);
        if (!empty($code) && $code !== 'NA') {
            $coupon_stmt->execute([':code' => $code]);
        }
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
if ($coupon_code) {
    $sql = 'UPDATE bookings SET payment_id=:payment_id,ta_id=:ta_id,customer_id=:customer_id,name=:name,email=:email,phone=:phone,date=:date,
            adults=:adults,children=:children,infants=:infants,status=:status,coupons_code=:coupons_code,confirm_status=:confirm_status
            WHERE id = :id';
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
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
        ':coupons_code' => $coupon_code,
        ':confirm_status' => '0',
        ':id' => $booking_id
    ]);
} else {
    $sql = 'UPDATE bookings SET payment_id=:payment_id,ta_id=:ta_id,customer_id=:customer_id,name=:name,email=:email,phone=:phone,date=:date,
            adults=:adults,children=:children,infants=:infants,status=:status,confirm_status=:confirm_status
            WHERE id = :id';
    $statement = $conn->prepare($sql);
    $result = $statement->execute([
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
        ':confirm_status' => '0',
        ':id' => $booking_id
    ]);
}

// booking Members
$sql1 = 'UPDATE booking_member_details SET name=:name, age=:age,gender=:gender WHERE bookings_id=:bookings_id';
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
// Full Payment
if ($part_type == 1) {
    if ($coupon_code) {
        $gst_total -= $coupon_discount;
        $sql2 = 'UPDATE booking_direct_bill SET total_price=:total_price, ta_markup=:ta_markup, final_price=:final_price,
                 pay_type=:pay_type, status=1, coupon_discount=:coupon_discount, total_net_payable=:total_net_payable 
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':pay_type' => $part_type,
            ':coupon_discount' => $coupon_discount,
            ':total_net_payable' => $discount_price
        ]);
    } else {
        $sql2 = 'UPDATE booking_direct_bill SET total_price=:total_price, ta_markup=:ta_markup, final_price=:final_price,
                 pay_type=:pay_type, status=1 
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':total_price' => $gst_total,
            ':ta_markup' => $ta_markup,
            ':final_price' => $final_price,
            ':pay_type' => $part_type
        ]);
    }
}

// 2-Part Payment
elseif ($part_type == 2) {
    if ($coupon_code) {
        $gst_total -= $coupon_discount;
        $sql2 = 'UPDATE booking_direct_bill SET 
                    part_pay_2_status=:status,
                    status=:status,
                    coupon_discount=:coupon_discount,
                    total_net_payable=:total_net_payable
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':status' => $status,
            ':coupon_discount' => $coupon_discount,
            ':total_net_payable' => $discount_price
        ]);
    } else {
        $sql2 = 'UPDATE booking_direct_bill SET 
                    part_pay_2_status=:status,
                    status=:status
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':status' => $status
        ]);
    }
}

// 3-Part Payment
elseif ($part_type == 3) {
    if ($coupon_code) {
        $gst_total -= $coupon_discount;
        $sql2 = 'UPDATE booking_direct_bill SET 
                    part_pay_2_status=1,
                    part_pay_3_status=:status,
                    status=:status,
                    coupon_discount=:coupon_discount,
                    total_net_payable=:total_net_payable
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':status' => $status,
            ':coupon_discount' => $coupon_discount,
            ':total_net_payable' => $discount_price
        ]);
    } else {
        $sql2 = 'UPDATE booking_direct_bill SET 
                    part_pay_2_status=1,
                    part_pay_3_status=:status,
                    status=:status
                 WHERE bookings_id=:bookings_id';
        $stmt2 = $conn->prepare($sql2);
        $result2->execute([
            ':bookings_id' => $booking_id,
            ':status' => $status
        ]);
    }
}
if ($result2) {
    echo 1;
}else{
    echo 0;
}
?>