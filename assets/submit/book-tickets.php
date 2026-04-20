<?php
//last chaged on 04-09-2025
//added logic for F->SF/MF and BM->TC/MF-TC
//F == TE/CA
require '../../connect.php';
// include '../send_sms_helper.php';
// include '../../admin/assets/generate_invoice_number.php';
header('Content-Type:application/json');
// get Row data
$data = stripslashes(file_get_contents("php://input"));
// json Decoding, true -> for getting data in associative manner
$mydata = json_decode($data, true);
// print_r($mydata);

date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');
$today_date= date('j').'-'.date('n').'-'.date('Y');

$y = date("Y");
$m = date('n');
$coupon_id = 0;
$booking_id = 0;
$order_id1 = 0;
//$payment_id;
$coupon_code = '';
// $coupon_status = $mydata['coupon_status'] ?? 0;
$markup_payout_customer_id = 0;
$cust_id = $mydata['cust_id'];
$user_cust_id = $mydata['user_cust_id'];
$payment_id=$mydata['payment_id'];
$pay_type=$mydata['pay_type'];
$book_status = ($pay_type == 1) ?  1: 0 ;
$amount=$mydata['paid_amount'];
// $gst_status = $mydata['gst_status'];
// $gst_number = $mydata['gst_number'];
$coupon_code = $mydata['couponCode'];
$coupon_discount = $mydata['couponDiscount'];

// total payment
$gst_total = $mydata['total_price'];
// $gst_net_payable = $mydata['total_net_payable'];
//   if ( $gst_net_payable == 0 ) {
//     $gst_net_payable = $gst_total;
//   }

// Get TA Price
$ta_markup = $mydata['ta_markup'];
$discount_price=$mydata['discounted_price'] - $coupon_discount;
$final_price = $gst_total - $ta_markup; //without additional markup

$payType = 'Online Payment';

// register customer
$status = '';
$fullname = $mydata['name'];
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
  $ta_reference = $cust_status['ta_reference'];

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

//generate invoice id
function getInvoice() {
  $prefix = 'BH';
  $date = date('YmdHis'); // Format: YYYYMMDDHHMMSS
  return $prefix . $date;
}
//----------------
// get Coupon Details -------------------------------------------------------------------------------------------------------------------------------
// if ( $coupon_status == "1" ) {
//   // echo $coupon_status;
//   $coupon_data = $conn->prepare("SELECT * FROM coupons WHERE code = '".$coupon_code."'");
//   $coupon_data->execute();
//   $coupons = $coupon_data->fetch();
//   if ( $coupons ) {
//     $c_status = $coupons['status'];
//       if ( $c_status == "1" || $c_status == "2"  ) {
//           $coupon_id = $coupons['id'];
//           $coupon_data1 = $conn->prepare("UPDATE coupons SET status=:status,deleted_date=:deleted_date WHERE id = '".$coupon_id."'");
//           $coupon_data1->execute([
//               ':status' => $c_status == "2" ? "1" : "0",
//               ':deleted_date' => $today
//           ]);
//       }
//   }
// }
// echo 'coupon_id = '.$coupon_id;
// -------------------------------------------------------------------------------------------------------------------------------
// generate invoice number
//$invoice_no = getInvoiceNo($conn,'',$state);

// payment table -------------------------------------------------------------------------------------------------------------------------------
// $sql8 = "INSERT INTO payment (invoice_no,user_id,name,amount, payment_id, payment_status,payment_type,message) 
//                       VALUES (:invoice_no,:user_id,:name, :amount, :payment_id, :payment_status,:payment_type,:message)";
// $stmt8 = $conn->prepare($sql8);
// $result8 = $stmt8->execute(array(
//     ':invoice_no' => $invoice_no,
//     ':user_id' => $mydata['payee_id'],
//     ':name' => $mydata['payee_name'],
//     ':amount' => $gst_net_payable,
//     ':payment_id' => $mydata['payment_id'],
//     ':payment_status' => "Completed",
//     ':payment_type' => $payType,
//     ':message' => 'Holidays Booking'
// ));
//   if( $result8 ){
//     //  get payment ID
//     $payment_query = $conn->prepare("SELECT id FROM payment ORDER BY id DESC LIMIT 1");
//     $payment_query->execute();
//     $get_payment_id = $payment_query->fetch();
//     $payment_id = $get_payment_id["id"];
//   }
//-------------------------------------------------------------------------------------------------------------------------------





// insert package data
if ($coupon_code) {
  $sql = 'INSERT INTO bookings (package_id,payment_id,ta_id,customer_id,name,email,phone,date,adults,children,infants,status,created_date,coupons_code,invoice_no,confirm_status) 
                VALUES (:package_id,:payment_id,:ta_id,:customer_id,:name,:email,:phone,:date,:adults,:children,:infants,:status,:created_date,:coupons_code,:invoice_no,:confirm_status)';
  $statement = $conn->prepare($sql);
  $result = $statement->execute([
    ':invoice_no' =>getInvoice(),
    ':package_id' => $mydata['package_id'],
    ':payment_id' => '',
    ':ta_id' => $user_cust_id,
    ':customer_id' => $cust_id,
    ':name' => $mydata['name'],
    ':email' => $mydata['email'],
    ':phone' => $mydata['phone'],
    ':date' => $mydata['date'],
    ':adults' => $mydata['adults'],
    ':children' => $mydata['child'],
    ':infants' => $mydata['infants'],
    ':status' => $book_status,
    ':created_date' => $today,
    ':coupons_code' => $coupon_code,
    ':confirm_status' => '0'
  ]);
} else {
  $sql = 'INSERT INTO bookings (package_id,payment_id,ta_id,customer_id,name,email,phone,date,adults,children,infants,status,created_date,invoice_no,confirm_status) 
                  VALUES (:package_id,:payment_id,:ta_id,:customer_id,:name,:email,:phone,:date,:adults,:children,:infants,:status,:created_date,:invoice_no,:confirm_status)';
  $statement = $conn->prepare($sql);
  $result = $statement->execute([
    ':invoice_no' =>getInvoice(),
    ':package_id' => $mydata['package_id'],
    ':payment_id' => '',
    ':ta_id' => $user_cust_id,
    ':customer_id' => $cust_id,
    ':name' => $mydata['name'],
    ':email' => $mydata['email'],
    ':phone' => $mydata['phone'],
    ':date' => $mydata['date'],
    ':adults' => $mydata['adults'],
    ':children' => $mydata['child'],
    ':infants' => $mydata['infants'],
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
foreach ($mydata['members'] as $member) {
  $stmt1->bindParam(':bookings_id', $booking_id, PDO::PARAM_INT);
  $stmt1->bindParam(':name', $member['name']);
  $stmt1->bindParam(':age', $member['age']);
  $stmt1->bindParam(':gender', $member['gender']);
  $result1 = $stmt1->execute();
}
// booking DIRECT invoice with wallet amount payment
//full payment
if ($pay_type == 1) {
  # code...
  if ($coupon_code) {
    $gst_total=$gst_total-$coupon_discount;
    $sql2 = 'INSERT INTO booking_direct_bill (bookings_id,total_price,ta_markup,final_price,paymentid,amount,pay_type,status,coupon_discount,total_net_payable) 
    VALUES (:bookings_id,:total_price,:ta_markup,:final_price,:paymentid,:amount,:pay_type,:status,:coupon_discount,:total_net_payable)';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
      ':bookings_id' => $booking_id,
      ':total_price' => $gst_total,
      ':ta_markup' => $ta_markup,
      ':final_price' => $final_price,
      ':paymentid' => $payment_id,
      ':amount' => $amount,
      ':pay_type' => $pay_type,
      ':status' => 1,
      ':coupon_discount'=>$coupon_discount,
      ':total_net_payable'=>$discount_price
    ]);
  } else {

    $sql2 = 'INSERT INTO booking_direct_bill (bookings_id,total_price,ta_markup,final_price,paymentid,amount,pay_type,status) 
                    VALUES (:bookings_id,:total_price,:ta_markup,:final_price,:paymentid,:amount,:pay_type,:status)';
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
      ':bookings_id' => $booking_id,
      ':total_price' => $gst_total,
      ':ta_markup' => $ta_markup,
      ':final_price' => $final_price,
      ':paymentid' => $payment_id,
      ':amount' => $amount,
      ':pay_type' => $pay_type,
      ':status' => 1
    ]);
  }
}
//2 part payment
else if ($pay_type == 2) {
  # code...
  $part_pay_1 = $gst_total / 2;
  $part_pay_1_status = 1;
  $part_pay_2 = $gst_total / 2;
  $part_pay_2_status = 0;
  if ($coupon_code){
    $gst_total=$gst_total-$coupon_discount;
    $sql2 = 'INSERT INTO booking_direct_bill 
                            (bookings_id,
                            total_price,
                            ta_markup,
                            final_price,
                            paymentid,
                            part_pay_1,
                            part_pay_1_status,
                            part_pay_2,
                            part_pay_2_status,
                            pay_type,
                            status,
                            coupon_discount,
                            total_net_payable) 
                    VALUES (:bookings_id,
                            :total_price,
                            :ta_markup,
                            :final_price,
                            :paymentid,
                            :part_pay_1,
                            :part_pay_1_status,
                            :part_pay_2,
                            :part_pay_2_status,
                            :pay_type,
                            :status,
                            :coupon_discount,
                            :total_net_payable)';
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
      ':pay_type' => $pay_type,
      ':status' => 0,
      ':coupon_discount'=>$coupon_discount,
      ':total_net_payable'=>$discount_price
    ]);
  }else{

    $sql2 = 'INSERT INTO booking_direct_bill 
                            (bookings_id,
                            total_price,
                            ta_markup,
                            final_price,
                            paymentid,
                            part_pay_1,
                            part_pay_1_status,
                            part_pay_2,
                            part_pay_2_status,
                            pay_type,
                            status) 
                    VALUES (:bookings_id,
                            :total_price,
                            :ta_markup,
                            :final_price,
                            :paymentid,
                            :part_pay_1,
                            :part_pay_1_status,
                            :part_pay_2,
                            :part_pay_2_status,
                            :pay_type,
                            :status)';
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
      ':pay_type' => $pay_type,
      ':status' => 0
      
    ]);
  }
}
//3 part payment
else if ($pay_type == 3) {
  $gst_total=$gst_total-$coupon_discount;
  # code...
  $part_pay_1 = $gst_total * 0.4;
  $part_pay_1_status = 1;
  $part_pay_2 = $gst_total * 0.3;
  $part_pay_2_status = 0;
  $part_pay_3 = $gst_total * 0.3;
  $part_pay_3_status = 0;
  if ($coupon_code){
    $sql2 = 'INSERT INTO booking_direct_bill 
                            (bookings_id,
                            total_price,
                            ta_markup,
                            final_price,
                            paymentid,
                            part_pay_1,
                            part_pay_1_status,
                            part_pay_2,
                            part_pay_2_status,
                            part_pay_3,
                            part_pay_3_status,
                            pay_type,
                            status,
                            coupon_discount,
                            total_net_payable) 
                    VALUES (:bookings_id,
                    :total_price,
                    :ta_markup,
                    :final_price,
                    :paymentid,
                    :part_pay_1,
                    :part_pay_1_status,
                    :part_pay_2,
                    :part_pay_2_status,
                    :part_pay_3,
                    :part_pay_3_status,
                    :pay_type,
                    :status,
                    :coupon_discount,
                    :total_net_payable)';
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
      ':pay_type' => $pay_type,
      ':status' => 0,
      ':coupon_discount'=>$coupon_discount,
      ':total_net_payable'=>$discount_price
    ]);
  }else{

    $sql2 = 'INSERT INTO booking_direct_bill 
                            (bookings_id,
                            total_price,
                            ta_markup,
                            final_price,
                            paymentid,
                            part_pay_1,
                            part_pay_1_status,
                            part_pay_2,
                            part_pay_2_status,
                            part_pay_3,
                            part_pay_3_status,
                            pay_type,
                            status) 
                    VALUES (:bookings_id,
                    :total_price,
                    :ta_markup,
                    :final_price,
                    :paymentid,
                    :part_pay_1,
                    :part_pay_1_status,
                    :part_pay_2,
                    :part_pay_2_status,
                    :part_pay_3,
                    :part_pay_3_status,
                    :pay_type,
                    :status)';
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
      ':pay_type' => $pay_type,
      ':status' => 0
    ]);
  }
}  # code...

//get coupon details and update it by SV
if ($coupon_code) {
  $coupon_sql = 'UPDATE cu_coupons SET usage_status=1 WHERE code=:code';
  $coupon_stmt = $conn->prepare($coupon_sql);
  $coupon_result = $coupon_stmt->execute([
    ':code' => $coupon_code
  ]);
}

//updating wallet balance after insert in booking_direct_bill
if ($result2) {
  // Insert the new credited amount into ta_top_up_utilisation
  $stmt = $conn->prepare("INSERT INTO ta_top_up_utilisation (ta_id, ta_top_up_amt_id, amount_deposited,top_up_message) VALUES (:ta_id, :ta_top_up_amt_id, :amount_deposited,:top_up_message)");
  $result3 = $stmt->execute(array(
    ':ta_id' => $user_cust_id,
    ':ta_top_up_amt_id' => $payment_id,
    ':amount_deposited' => $amount,
    ':top_up_message' => 'TopUp used for booking id:' . $booking_id . ''
  ));
  // Fetch the latest available balance for the given ta_id
  $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1 OFFSET 1");
  $stmt2->execute(array(':ta_id' => $user_cust_id));
  $result4 = $stmt2->fetch(PDO::FETCH_ASSOC);
  // If no second last entry exists, fetch the latest entry
  if (!$result4) {
    $stmt2 = $conn->prepare("SELECT available_balance FROM ta_top_up_utilisation WHERE ta_id = :ta_id ORDER BY id DESC LIMIT 1");
    $stmt2->execute(array(':ta_id' => $user_cust_id));
    $result4 = $stmt2->fetch(PDO::FETCH_ASSOC);
  }

  if ($result4) {
    // Calculate the new available balance
    $available_bal = $result4['available_balance'] - (float)$amount;


    // // Update the available balance in ta_top_up_utilisation
    $stmt3 = $conn->prepare("UPDATE ta_top_up_utilisation SET available_balance = :available_balance WHERE ta_id = :ta_id AND ta_top_up_amt_id = :ta_top_up_amt_id");
    $result5 = $stmt3->execute(array(
      ':ta_id' => $user_cust_id,
      ':ta_top_up_amt_id' => $payment_id,
      ':available_balance' => (float)$available_bal
    ));

    if ($result5) {
      // echo 1;

      // Product Payout start ****

      $customer_id = $mydata['cuID'];
      $travel_agenct_id = $mydata['userID'];
      $packageID = $mydata['packageID'];
      $no_of_adult = $mydata['no_of_adult'];
      $no_of_child = !empty($mydata['no_of_child']) ? $mydata['no_of_child'] : 0;
      $start_date = $mydata['tour_start_date'];
      // $order_id = $mydata['book_id'];
      //$order_id = 10;
      // $ta_markup = $mydata['$ta_markup'] ?? 0;
      $total_passenger = $no_of_adult + $no_of_child;
      $cuIds = [];
      $cuName = [];
      
      //new
      $sql1 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$customer_id."' AND status= '1' ");
      $sql1 -> execute();
      $sql1 -> setFetchMode(PDO::FETCH_ASSOC);
      if( $sql1 -> rowCount()>0 ){
          foreach( ($sql1 -> fetchAll()) as $key => $row ){
              $cu_ref1 = $row['reference_no'];
              $cu_ref1_name = $row['registrant'];
              $cuIds[] = $cu_ref1;
              $cuName[] = $cu_ref1_name;

              if(!$cu_ref1){
                  $ca_ta_ref = $row['ta_reference_no'];
                  $ca_ta_ref_name = $row['ta_reference_name'];
                  levelConti($ca_ta_ref,$ca_ta_ref_name);
              }else{
                  // corporate_agency customer level 1
                  $sql2 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref1."' AND status= '1' ");
                  $sql2 -> execute();
                  $sql2 -> setFetchMode(PDO::FETCH_ASSOC);
                  if( $sql2 -> rowCount()>0 ){
                      foreach( ($sql2 -> fetchAll()) as $key => $row ){
                          $cu_ref2 = $row['reference_no'];
                          $cu_ref2_name = $row['registrant'];
                          $cuIds[] = $cu_ref2;
                          $cuName[] = $cu_ref2_name;

                          if(!$cu_ref2){
                              $ca_ta_ref = $row['ta_reference_no'];
                              $ca_ta_ref_name = $row['ta_reference_name'];
                              levelConti($ca_ta_ref,$ca_ta_ref_name);
                          }else{
                              // corporate_agency customer level 2
                              $sql3 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref2."' AND status= '1' ");
                              $sql3 -> execute();
                              $sql3 -> setFetchMode(PDO::FETCH_ASSOC);
                              if( $sql3 -> rowCount()>0 ){
                                  foreach( ($sql3 -> fetchAll()) as $key => $row ){
                                      $cu_ref3 = $row['reference_no'];
                                      $cu_ref3_name = $row['registrant'];
                                      $cuIds[] = $cu_ref3; 
                                      $cuName[] = $cu_ref3_name;

                                      if(!$cu_ref3){
                                          $ca_ta_ref = $row['ta_reference_no'];
                                          $ca_ta_ref_name = $row['ta_reference_name'];
                                          levelConti($ca_ta_ref,$ca_ta_ref_name);

                                      }else{
                                          $ca_ta_ref = $row['ta_reference_no'];
                                          $ca_ta_ref_name = $row['ta_reference_name'];
                                          levelConti($ca_ta_ref,$ca_ta_ref_name);

                                          // corporate_agency customer level 3
                                          // $sql4 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref3."' AND status= '1' ");
                                          // $sql4 -> execute();
                                          // $sql4 -> setFetchMode(PDO::FETCH_ASSOC);
                                          // if( $sql4 -> rowCount()>0 ){
                                          //     foreach( ($sql4 -> fetchAll()) as $key => $row ){
                                          //         $cu_ref4 = $row['reference_no'];

                                          //         if(!$cu_ref4){
                                          //             $ca_ta_ref = $row['ta_reference_no'];
                                          //             levelConti($ca_ta_ref);
                                          //         }else{
                                          //             $ca_ta_ref = $row['ta_reference_no'];
                                          //             levelConti($ca_ta_ref);
                                          //         }
                                          //     }
                                          // }
                                          
                                      }
                                  }
                              }
                          }
                      }
                  }
              }
          }
      }

      function levelConti($ca_ta_ref,$ca_ta_ref_name){
          
          global $conn;

          $cuIds2 = [];
          $cuName2 = [];

          $cuIds2[] = $ca_ta_ref; 
          $cuName2[] = $ca_ta_ref_name; // value not pushing in array

          // corporate_agency travel_agent
          //chaged on 18-04-2026 by PN
          $sql4 = $conn -> prepare("SELECT reference_no,registrant FROM ca_travelagency WHERE ca_travelagency_id = '".$ca_ta_ref."' AND status= '1'
                                    UNION ALL
                                    SELECT reference_no,registrant FROM institution_branch_manager WHERE institution_branch_manager_id = '".$ca_ta_ref."' AND status='1'");
          $sql4 -> execute();
          $sql4 -> setFetchMode(PDO::FETCH_ASSOC);
          if( $sql4 -> rowCount()>0 ){
              foreach( ($sql4 -> fetchAll()) as $key => $row ){
                  $ca_ref = $row['reference_no'];
                  $ca_name = $row['registrant'];
                  $cuIds2[] = $ca_ref; 
                  $cuName2[] = $ca_name;
              }
          }
          
          // sub string and identify user TE/CA/F/MF 
          $ca_ref_id =  substr($ca_ref, 0,1) == 'F' || substr($ca_ref, 0,1) == 'I'? substr($ca_ref,0,1)
                        : substr($ca_ref,0,2);
          // corporate_agency / Techno Enterprise / Franchisee / Master Franchisee
          if ($ca_ref_id == 'F') {
              $sql5 = $conn -> prepare("SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '".$ca_ref."' AND status= '1' ");
          }
          //added on 18-04-2026 by PN
          if ($ca_ref_id == 'I') {
              $sql5 = $conn -> prepare("SELECT * FROM institution WHERE institution_id = '".$ca_ref."' AND status= '1' ");
          }elseif ($ca_ref_id == 'TE' || $ca_ref_id == 'CA') {
              $sql5 = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ca_ref."' AND status= '1' ");
          }elseif ($ca_ref_id == 'MF') {
              $sql5 = $conn -> prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$ca_ref."' AND status= '1' ");
          }elseif ($ca_ref_id == 'BM') {
              $sql5 = $conn -> prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$ca_ref."' AND status= '1' ");
          }
          //added on 18-04-2026 by PN
          elseif ($ca_ref_id == 'BH') {
              $sql5 = $conn -> prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$ca_ref."' AND status= '1' ");
          }
          //chaged on 18-04-2026 by PN
          if ($ca_ref_id == 'F' || $ca_ref_id == 'I' || $ca_ref_id == 'TE' || $ca_ref_id == 'CA' || $ca_ref_id == 'MF' || $ca_ref_id == 'BM' || $ca_ref_id == 'BH') {
              $sql5 -> execute();
              $sql5 -> setFetchMode(PDO::FETCH_ASSOC);
              if( $sql5 -> rowCount()>0 ){
                  foreach( ($sql5 -> fetchAll()) as $key => $row ){
                      $bm_ref = $row['reference_no'];
                      $bm_name = $row['registrant'];
                      $cuIds2[] = $bm_ref; 
                      $cuName2[] = $bm_name;
                  }
              }
          }else{
              $bm_ref = 'NA';
              $bm_name = 'NA';
              $cuIds2[] = $bm_ref; 
              $cuName2[] = $bm_name;
          }
          
          
          // sub string and identify user MF/SF/BM
          $bm_ref_id=substr($bm_ref,0,2);
          // Business Mentor / Master Franchisee / Sponsor Franchisee
          if($bm_ref_id == 'MF'){
              $sql6 = $conn -> prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$bm_ref."' AND status= '1' ");
          }elseif ($bm_ref_id == 'SF') {
              $sql6 = $conn -> prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$bm_ref."' AND status= '1' ");
          }elseif ($bm_ref_id == 'BM') {
              $sql6 = $conn -> prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$bm_ref."' AND status= '1' ");
          }
          //added on 18-04-2026 by PN BDM->TE->TC-CU
          elseif ($bm_ref_id == 'BH') {
              $sql6 = $conn -> prepare("SELECT * FROM emplyoyees WHERE employee_id = '".$bm_ref."' AND status= '1' AND user_type='25'");
          }
          if ($bm_ref_id == 'MF' || $bm_ref_id == 'SF'|| $bm_ref_id == 'BM' || $bm_ref_id == 'BH') {
              $sql6 -> execute();
              $sql6 -> setFetchMode(PDO::FETCH_ASSOC);
              if( $sql6 -> rowCount()>0 ){
                  foreach( ($sql6 -> fetchAll()) as $key => $row ){
                      $bdm_ref = $row['reference_no'];
                      $bdm_name = $row['registrant'];
                      $cuIds2[] = $bdm_ref; 
                      $cuName2[] = $bdm_name;
                  }
              }
          }else{
              $bdm_ref=$bdm_name='NA';
              $cuIds2[] = $bdm_ref; 
              $cuName2[] = $bdm_name; 
          }
          //added on 18-04-2026 by PN BM level if BH (BDM) is found BDM->TE/F/I->TC/IBR->CU
          if ($bm_ref_id == 'BH') {
              $sql7 = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bm_ref_id."' AND user_type = '25' AND status= '1' ");
              $sql7 -> execute();
              $sql7 -> setFetchMode(PDO::FETCH_ASSOC);
              if( $sql7 -> rowCount()>0 ){
                  foreach( ($sql7 -> fetchAll()) as $key => $row ){
                      $bcm_ref = $row['reporting_manager'];

                      $bcm_name ='';
                      $sqlBchName = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bcm_ref."' AND user_type = '24' AND status= '1' ");
                      $sqlBchName -> execute();
                      $sqlBchName -> setFetchMode(PDO::FETCH_ASSOC);  
                      if( $sqlBchName -> rowCount()>0 ){
                          foreach( ($sqlBchName -> fetchAll()) as $key => $row ){
                              $bcm_name = $row['name'];
                          }
                      }

                      $cuIds2[] = $bcm_ref; 
                      $cuName2[] = $bcm_name;
                  }
              }
          }else{
              // Business Development manager
              $sql7 = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bdm_ref."' AND user_type = '25' AND status= '1' ");
              $sql7 -> execute();
              $sql7 -> setFetchMode(PDO::FETCH_ASSOC);
              if( $sql7 -> rowCount()>0 ){
                  foreach( ($sql7 -> fetchAll()) as $key => $row ){
                      $bcm_ref = $row['reporting_manager'];
      
                      $bcm_name ='';
                      $sqlBchName = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bcm_ref."' AND user_type = '24' AND status= '1' ");
                      $sqlBchName -> execute();
                      $sqlBchName -> setFetchMode(PDO::FETCH_ASSOC);  
                      if( $sqlBchName -> rowCount()>0 ){
                          foreach( ($sqlBchName -> fetchAll()) as $key => $row ){
                              $bcm_name = $row['name'];
                          }
                      }
      
                      $cuIds2[] = $bcm_ref; 
                      $cuName2[] = $bcm_name;
                  }
              }
          }

          // return $cuIds2 ;
          // return $cuName2 ;
          return array($cuIds2,$cuName2);
      }

      list($cuIds2,$cuName2) = levelConti($ca_ta_ref,$ca_ta_ref_name);

      // Now you can access $cuIds2 and $cuName2 separately
      // echo "Customer IDs: ";
      // print_r($cuIds2);

      // echo "Customer Names: ";
      // print_r($cuName2);

      $CU_l1 = $cuIds[0] ?? '';
      $CU_l2 = $cuIds[1] ?? '';
      $CU_l3 = $cuIds[2] ?? '';

      $CU_l1_name = $cuName[0] ?? '';
      $CU_l2_name = $cuName[1] ?? '';
      $CU_l3_name = $cuName[2] ?? '';


      if($CU_l1){
          $cu_level_1 = $CU_l1;
          $cu_level_1_message = 'Customer '. $CU_l1_name.' ('.$CU_l1.') Has Earned Rs.500 X '.$total_passenger.' = '.$total_passenger*500;
          $cu_level_1_amt = $total_passenger*500;
      }

      if($CU_l2){
          $cu_level_2 = $CU_l2;
          $cu_level_2_message = 'Customer '. $CU_l2_name.' ('.$CU_l2.') Has Earned Rs.250 X '.$total_passenger.' = '.$total_passenger*250;
          $cu_level_2_amt = $total_passenger*250;
      }

      if($CU_l3){
          $cu_level_3 = $CU_l3;
          $cu_level_3_message = 'Customer '. $CU_l3_name.' ('.$CU_l3.') Has Earned Rs.125 X '.$total_passenger.' = '.$total_passenger*125;
          $cu_level_3_amt = $total_passenger*125;
      }

      $sql8 = $conn -> prepare("SELECT * FROM package_pricing_markup WHERE package_id = '".$packageID."'  ");
      $sql8 -> execute();
      $sql8 -> setFetchMode(PDO::FETCH_ASSOC);
      if( $sql8 -> rowCount()>0 ){
          foreach( ($sql8 -> fetchAll()) as $key => $row ){
              $te_commi = $row['ca_direct_commission'];
              $bm_commi = $row['bm_direct_commission'];
              $bdm_commi = $row['bdm_direct_commission'];
              $bcm_commi = $row['bcm_direct_commission'];
              $ta_commi = $row['ta_markup'];
          }
      }

      $sql9 = $conn -> prepare("SELECT tour_days FROM package WHERE id = '".$packageID."'  ");
      $sql9 -> execute();
      $sql9 -> setFetchMode(PDO::FETCH_ASSOC);
      if( $sql9 -> rowCount()>0 ){
          foreach( ($sql9 -> fetchAll()) as $key => $row ){
              $tour_days = $row['tour_days'];
              $end_date = date('Y-m-d', strtotime("$start_date +$tour_days days"));
          }
      }

      $ta = $cuIds2[0];
      $ta_str=substr($ta,0,2);
      //chaged on 18-04-2026 by PN added IBR logic
      $ta_role=[
          'TA' => 'Travel Consultant ',
          'IB' => 'Institution Branch Manager '
      ];
      $ta_mess_title_name=$ta_role[$ta_str];
      if($ta_str == 'TA'){
          $ta_message = $ta_mess_title_name. $cuIds2[0].' ('.$cuName2[0].') Has Earned Rs.'.$ta_commi.' X '.$total_passenger.' =  '.$total_passenger*$ta_commi.'/-';
          $ta_amt = $total_passenger*$ta_commi;
      }elseif ($ta_str == 'IBR') {
          $ta_message = "Not Applicable";
          $ta_amt = 0;
      }
      

      $te = $cuIds2[1];
      //added on 18-04-2026 by PN
      //find te level user if F->franchisee is te/ca->Techno Enterprise if I-> Institution
      $te_str=substr($te,0,1) == 'F' || substr($te,0,1) == 'I' ? substr($te,0,1) : substr($te,0,2);
      $te_roles=[
          'TE' => 'Techno Enterprise ',
          'CA' => 'Techno Enterprise ',
          'F'  => 'Franchisee ',
          'I'  => 'Institution ',
          'BH'  => 'Business Development Manager '
      ];
      $te_mess_title_name=$te_roles[$te_str];
      //variable percetange for new regime franchisee (registraion after 2026-01-01), also check for upgarde status and get the latest approved entries commission 
      if ($te_str == 'F') {
          $stmtf = $conn->prepare("SELECT register_date,sub_franchisee_id,current_commission_per,upgrade_status FROM sub_franchisee WHERE sub_franchisee_id='".$te."' AND status=1");
          $stmtf = $conn->exicute();
          $sqlf -> setFetchMode(PDO::FETCH_ASSOC);
          if ($sqlf ->rowCount()>0) {
              foreach ($sqlf as $key => $row) {
                  // Convert VARCHAR date to proper date for comparison
                  if (strtotime($row['register_date']) >= strtotime('2026-01-01')) {
                      if ($row['upgrade_status'] == 2) {
                          $stmtfup=$conn->prepare("SELECT new_commission_per FROM sub_franchisee_upgrade WHERE sub_franchisee_id ='".$te."' AND  upgrade_status='1'
                                                  ORDER BY id DESC LIMIT 1");
                          $stmtfup = $conn->exicute();
                          $sqlfup -> setFetchMode(PDO::FETCH_ASSOC);
                          if ($sqlf ->rowCount()>0) {
                              foreach ($sqlf as $key => $row) {
                                  $te_commi=$ta_commi*(int($row['new_commission_per'])/100);
                              }
                          }else{
                              $te_commi=$ta_commi*(int($row['current_commission_per'])/100);
                          }
                      }else{
                              $te_commi=$ta_commi*(int($row['current_commission_per'])/100);
                      }
                  } 
              }
          }
          $bm_commi=$te_commi*0.3;
          $te_message = $te_mess_title_name. $cuIds2[1].' ('.$cuName2[1].') Has Earned Rs.'.$te_commi.' X '.$total_passenger.' =  '.$total_passenger*$te_commi.'/-';
          $te_amt = $total_passenger*$te_commi;
      }
      //added 0n 18-04-2026 by PN if BH (BDM) is found for TE level the entry show be Not Applicable and commission should be 0
      elseif ($te_str == 'BH') {
          $te_message = 'Not Applicable';
          $te_amt = $total_passenger*$te_commi;
      }else{
          $te_message = $te_mess_title_name. $cuIds2[1].' ('.$cuName2[1].') Has Earned Rs.'.$te_commi.' X '.$total_passenger.' =  '.$total_passenger*$te_commi.'/-';
          $te_amt = $total_passenger*$te_commi;
      }

      $bm = $cuIds2[2];
      //added on 18-04-2026 by PN all BM level user maping and payout correction
      $bm_str = substr($bm,0,2);
      $bm_role=[
          'BM' => 'Business Mentor ',
          'MF' => 'Master Franchisee ',
          'SF' => 'Sponsor Franchisee ',
          'BH' => 'Business Development Manager '
      ];
      $bm_mess_title_name= $bm_role[$bm_str]; 
      $bm_message = $bm_mess_title_name. $cuIds2[2].' ('.$cuName2[2].') Has Earned Rs.'.$bm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bm_commi.'/-';
      $bm_amt = $total_passenger*$bm_commi;

      //no entries in product payout for bdm/bcm as ther are salaried employees
      // $bdm = '';
      // $bdm_message = '';
      // $bdm_amt = '';

      // $bcm = '';
      // $bcm_message = '';
      // $bcm_amt = '';
      
      // $bdm = $cuIds2[3];
      // $bdm_message = 'Business Development Manager '. $cuIds2[3].' ('.$cuName2[3].') Has Earned Rs.'.$bdm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bdm_commi.'/-';
      // $bdm_amt = $total_passenger*$bdm_commi;

      // $bcm = $cuIds2[4];
      // $bcm_message = 'Business Channel Manager '. $cuIds2[4].' ('.$cuName2[4].') Has Earned Rs.'.$bcm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bcm_commi.'/-';
      // $bcm_amt = $total_passenger*$bcm_commi;

      // Create an associative array with all the messages
      // $messages = [
      //     'cu_level_1_message' => $cu_level_1_message ?? '',
      //     'cu_level_2_message' => $cu_level_2_message ?? '',
      //     'cu_level_3_message' => $cu_level_3_message ?? '',
      //     'CA_Travel_agency_message' => $CA_Travel_agency_message ?? '',
      //     'techno_enterprise_message' => $techno_enterprise_message ?? '',
      //     'business_mentor_message' => $business_mentor_message ?? '',
      //     'business_development_manager_message' => $business_development_manager_message ?? '',
      //     'business_channel_manager_message' => $business_channel_manager_message ?? '',
      // ];
      // Encode the messages array as JSON
      // echo json_encode($messages);
      //cu = "customer", ta = "travel associate", te = "techno enterprise", bm = "business mentor", bdm = "business development manager", bcm = "business channel manager"
      $sql = "INSERT INTO product_payout (order_id, package_id, no_of_adult, no_of_child, ta_markup, cu_id, ta_id, ta_mess, ta_amt, te_id, te_mess, te_amt, bm_id, bm_mess, bm_amt, bdm_id, bdm_mess, bdm_amt, bch_id, bch_mess, bch_amt, cu1_id, cu1_mess, cu1_amt, cu2_id, cu2_mess, cu2_amt, cu3_id, cu3_mess, cu3_amt, start_date, end_date) VALUES (:order_id, :package_id, :no_of_adult, :no_of_child, :ta_markup, :cu_id, :ta_id, :ta_mess, :ta_amt,  :te_id, :te_mess, :te_amt,  :bm_id, :bm_mess, :bm_amt, :bdm_id, :bdm_mess, :bdm_amt, :bch_id, :bch_mess, :bch_amt, :cu1_id, :cu1_mess, :cu1_amt,  :cu2_id, :cu2_mess, :cu2_amt,  :cu3_id, :cu3_mess, :cu3_amt, :start_date, :end_date)";
      $stmt = $conn -> prepare($sql);
      $resultFinal = $stmt -> execute(array(
          ':order_id' => $booking_id,
          ':package_id' => $packageID, 
          ':no_of_adult' => $no_of_adult,
          ':no_of_child' => $no_of_child,
          ':ta_markup' => $ta_markup,
          ':cu_id' => $customer_id,
          ':ta_id' => $ta,
          ':ta_mess' => $ta_message,
          ':ta_amt' => $ta_amt, 
          ':te_id' => $te, 
          ':te_mess' => $te_message, 
          ':te_amt' => $te_amt, 
          ':bm_id' => $bm,
          ':bm_mess' => $bm_message,
          ':bm_amt' => $bm_amt,
          ':bdm_id' => $bdm ?? '',
          ':bdm_mess' => $bdm_message ?? '',
          ':bdm_amt' => $bdm_amt ?? 0.0,
          ':bch_id' => $bcm ?? '',
          ':bch_mess' => $bcm_message ?? '',
          ':bch_amt' => $bcm_amt ?? 0.0,
          ':cu1_id' => $cu_level_1 ?? '',
          ':cu1_mess' => $cu_level_1_message ?? '',
          ':cu1_amt' => $cu_level_1_amt ?? 0.0,
          ':cu2_id' => $cu_level_2 ?? '',
          ':cu2_mess' => $cu_level_2_message ?? '',
          ':cu2_amt' => $cu_level_2_amt ?? 0.0,
          ':cu3_id' => $cu_level_3 ?? '',
          ':cu3_mess' => $cu_level_3_message ?? '',
          ':cu3_amt' => $cu_level_3_amt ?? 0.0,
          ':start_date' => $start_date,
          ':end_date' => $end_date
      ));

      if($resultFinal){
          echo 1;
      }else{
          echo 0;
      }
    }else{
      echo 0;
    }
  }

}

// Product Payout end ****
?>