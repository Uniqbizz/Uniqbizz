<?php
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
$order_id = 0;
//$payment_id;
$coupon_code = '';
// $coupon_status = $mydata['coupon_status'] ?? 0;
$markup_payout_customer_id = 0;
$cust_id = $mydata['cust_id'];
$user_cust_id = $mydata['user_cust_id'];
$payment_id=$mydata['payment_id'];
$pay_type=$mydata['pay_type'];
$status = ($pay_type == 1) ?  1: 0 ;
$amount=$mydata['paid_amount'];
// $gst_status = $mydata['gst_status'];
// $gst_number = $mydata['gst_number'];
// $coupon_code = $mydata['coupon_code'];

// total payment
$gst_total = $mydata['total_price'];
// $gst_net_payable = $mydata['total_net_payable'];
//   if ( $gst_net_payable == 0 ) {
//     $gst_net_payable = $gst_total;
//   }

// Get TA Price
$ta_markup = $mydata['ta_markup'];
$final_price = $gst_total - $ta_markup; //without additional markup


$payType = 'Online Payment';

// register customer
$status='';
$fullname = $mydata['name'];
$todaysDate = date('d/m/Y');
$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0,8);


// Email Send
$from="support@uniqbizz.com";          // Company Sender
$cc="support@uniqbizz.com";            // admin 

$ta_firstname = '';
$ta_lastname = '';



// check if customer is registered -------------------------------------------------------------------------------------------------------------------------------
$customer = $conn->prepare("SELECT email,address,state,country_code,contact_no,status,ta_reference FROM customer where cust_id='".$cust_id."' ");
$customer->execute();
$customer->setFetchMode(PDO::FETCH_ASSOC);
if($customer->rowCount()>0){
  $cust_status = $customer->fetch();
     
    $status = $cust_status['status'];
    $email = $cust_status["email"];
    $address = $cust_status["address"];
    $state = $cust_status["state"];
    $country_code = $cust_status['country_code'];
    $contact_no = $cust_status['contact_no'];
    $ta_reference = $cust_status['ta_reference'];

    // register lead customer
    if( $status == 2 ){
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
        $result=  $stmt->execute(array(
          ':package' => 1,
          ':status' => 1,
          ':cust_id' => $cust_id
        ));
        
        $sql9= $conn->prepare("SELECT firstname,lastname,email from travel_agent where travel_agent_id='".$ta_reference."'");
        $sql9->execute();
        $sql9->setFetchMode(PDO::FETCH_ASSOC);
        if($sql9->rowCount()>0){
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
$sql = 'INSERT INTO bookings (package_id,payment_id,ta_id,customer_id,name,email,phone,date,adults,children,infants,status,created_date) 
                VALUES (:package_id,:payment_id,:ta_id,:customer_id,:name,:email,:phone,:date,:adults,:children,:infants,:status,:created_date)';
$statement = $conn->prepare($sql);
$result = $statement->execute([
                ':package_id' => $mydata['package_id'],
                ':payment_id' => '',
                ':ta_id'=>$user_cust_id,
                ':customer_id' => $cust_id,
                ':name' => $mydata['name'],
                ':email' => $mydata['email'],
                ':phone' => $mydata['phone'],
                ':date' => $mydata['date'],
                ':adults' => $mydata['adults'],
                ':children' => $mydata['child'],
                ':infants' => $mydata['infants'],
                ':status' => $status,
                ':created_date' => $today
            ]);
  // get Booking ID
  if (  $result ) {
    $bookings_data = $conn->prepare("SELECT id FROM bookings ORDER BY id DESC LIMIT 1");
    $bookings_data->execute();
    $booking_id_data = $bookings_data->fetch();
    $booking_id = (int)$booking_id_data["id"];

    //  create order Id 
    $book_id = 100000 * $m + $booking_id;
    $order_id = $y.$book_id;

    // update bokking table with order id
    $order_sql = $conn->prepare("UPDATE bookings SET order_id=:order_id WHERE id = '".$booking_id."'");
    $order_sql->execute([
              ':order_id' => $order_id
            ]);
  }
// booking Members
$sql1 = 'INSERT INTO booking_member_details (bookings_id,name,age,gender) 
                VALUES (:bookings_id,:name,:age,:gender)';
$stmt1 = $conn->prepare($sql1);
  foreach ( $mydata['members'] as $member )
  {
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
  $sql2 = 'INSERT INTO booking_direct_bill (bookings_id,total_price,ta_markup,final_price,paymentid,amount,pay_type,status) 
                  VALUES (:bookings_id,:total_price,:ta_markup,:final_price,:paymentid,:amount,:pay_type,:status)';
  $stmt2 = $conn->prepare($sql2);
  $result2 = $stmt2->execute([
                  ':bookings_id' => $booking_id,
                  ':total_price' => $gst_total,
                  ':ta_markup' => $ta_markup,
                  ':final_price' => $final_price,
                  ':paymentid'=>$payment_id,
                  ':amount'=>$amount,
                  ':pay_type'=>$pay_type,
                  ':status'=>$status
              ]);
} 
//2 part payment
else if ($pay_type == 2) {
  # code...
  $part_pay_1=$gst_total/2;
  $part_pay_1_status=1;
  $part_pay_2=$gst_total/2;
  $part_pay_2_status=0;
  $sql2 = 'INSERT INTO booking_direct_bill (bookings_id,
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
                  ':paymentid'=>$payment_id,
                  ':part_pay_1'=>$part_pay_1,
                  ':part_pay_1_status'=>$part_pay_1_status,
                  ':part_pay_2'=>$part_pay_2,
                  ':part_pay_2_status'=>$part_pay_2_status,
                  ':pay_type'=>$pay_type,
                  ':status'=>$status
              ]);
} 
//3 part payment
else if ($pay_type == 3) {
  # code...
  $part_pay_1=$gst_total*0.4;
  $part_pay_1_status=1;
  $part_pay_2=$gst_total*0.3;
  $part_pay_2_status=0;
  $part_pay_3=$gst_total*0.3;
  $part_pay_3_status=0;
  $sql2 = 'INSERT INTO booking_direct_bill (bookings_id,
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
                  ':paymentid'=>$payment_id,
                  ':part_pay_1'=>$part_pay_1,
                  ':part_pay_1_status'=>$part_pay_1_status,
                  ':part_pay_2'=>$part_pay_2,
                  ':part_pay_2_status'=>$part_pay_2_status,
                  ':part_pay_3'=>$part_pay_3,
                  ':part_pay_3_status'=>$part_pay_3_status,
                  ':pay_type'=>$pay_type,
                  ':status'=>$status
              ]);
}  # code...




//updating wallet balance after insert in booking_direct_bill

if($result2){
  // Insert the new credited amount into ta_top_up_utilisation
  $stmt = $conn->prepare("INSERT INTO ta_top_up_utilisation (ta_id, ta_top_up_amt_id, amount_deposited,top_up_message) VALUES (:ta_id, :ta_top_up_amt_id, :amount_deposited,:top_up_message)");
  $result3 = $stmt->execute(array(
      ':ta_id' => $user_cust_id,
      ':ta_top_up_amt_id' => $payment_id,
      ':amount_deposited' => $amount,
      ':top_up_message'=>'TopUp used for booking id:'.$booking_id.''
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
          ':ta_id' => $user_cust_id ,
          ':ta_top_up_amt_id' => $payment_id,
          ':available_balance' => (float)$available_bal
      ));

      if ($result5) {
          echo $status;
      } 
  }
} 
//final putput
$output=[
  'mess'=>'success',
  'bookid'=>$booking_id
];
//dummy response
echo json_encode($output);
// package Price
// $package_pricing_data = $conn->prepare("SELECT * FROM package_pricing WHERE package_id='".$mydata['package_id']."'");
// $package_pricing_data->execute();
// $package_pricing = $package_pricing_data->fetch();

//   $adult_price = (int)$package_pricing["net_price_adult"];
//   $child_price = (int)$package_pricing["net_price_child"];
//   $net_gst = (int)$package_pricing["net_gst"];
  
//   $adults_c = (int)$mydata['adults'];
//   $child_c = (int)$mydata['child'];
//   $coupon_discount = (int)$mydata['coupon_discount'];
  

//   // count adult & child
//   $total_adult = $adult_price * $adults_c;
//   $total_child = $child_price * $child_c;

//   $adult_gst = $total_adult * $net_gst/100;
//   $child_gst = $total_child * $net_gst/100;

//   $net_price = $total_adult + $total_child;
//   $net_gst = $adult_gst + $child_gst;

//   $markup_price = (int)$package_pricing["markup_price"];
//   $markup_loading_price = (int)$package_pricing["markup_loading_price"];
//   $markup_gst = (int)$package_pricing["markup_gst"];

//   $markup_loading_price = $markup_price + $markup_loading_price;
//   $markup_loading_gst = $markup_loading_price * $markup_gst/100;

//   $total = $net_price + $markup_loading_price  + $ta_markup;    //    total
//   $net_payable = $total - $coupon_discount;                     // - coupon
//   $gst = $net_gst + $markup_loading_gst;                        //   net payable
//   $total_net_payable = $net_payable + $gst;                     //  + GST
//                                                                 //  total_net_payable
//   $final_price_payable = $total_net_payable - $ta_markup;       //  Final price - ta_markup
         



// booking GST invoice 
// $sql3 = 'INSERT INTO booking_gst_bill (bookings_id,gst_number,total_price,coupon_discount,net_payable,total_gst,total_net_payable,ta_markup,final_price) 
//                 VALUES (:bookings_id,:gst_number,:total_price,:coupon_discount,:net_payable,:total_gst,:total_net_payable,:ta_markup,:final_price)';
// $stmt3 = $conn->prepare($sql3);
// $result3 = $stmt3->execute([
//                 ':bookings_id' => $booking_id,
//                 ':gst_number' => $gst_number,
//                 ':total_price' => $total,
//                 ':coupon_discount' => $coupon_discount,
//                 ':net_payable' => $net_payable,
//                 ':total_gst' => $gst,
//                 ':total_net_payable' => $total_net_payable,
//                 ':ta_markup' => $ta_markup,
//                 ':final_price' => $final_price_payable
//             ]);

// TA Markup Payment (additional markup)
// if ( $ta_markup == !0 ) {
//   $sql6 = 'INSERT INTO package_payout (bookings_id,travel_agent_id,markup) 
//                   VALUES (:bookings_id,:travel_agent_id,:markup)';
//   $stmt6 = $conn->prepare($sql6);
//   $result6 = $stmt6->execute([
//                   ':bookings_id' => $booking_id,
//                   ':travel_agent_id' => $ta_reference,
//                   ':markup' => $ta_markup
//                 ]);
// }


// // Markup Payout
//   // get Mark up Price
//   $cp_customer_share = 0;
//   $mp_travel_agent_share = 0;

//   $markup_price = $conn->prepare("SELECT * FROM markup_distribution WHERE package_id ='".$mydata['package_id']."' ");
//   $markup_price->execute();
//   $markup_price->setFetchMode(PDO::FETCH_ASSOC);
//   $markup_price_data =   $markup_price->fetch();
//   if ($markup_price_data) {
//       $mp_customer_share = $markup_price_data['customer_share'];        
//       $mp_travel_agent_share = $markup_price_data['travel_agent_share'];
//   }
//   $cp_customer_share = (float)$mp_customer_share;
//   $cp_travel_agent_share = (float)$mp_travel_agent_share;

//   //  Get TDS %
//   $tds_data = $conn->prepare("SELECT id,tds FROM tds ORDER BY id DESC LIMIT 1");
//   $tds_data->execute();
//   $get_tds = $tds_data->fetch();
//   $tds_id = (int)$get_tds["id"];
//   $tds_rate = (int)$get_tds["tds"];
  
//   // ----------------------customer Markup Payout START-------------------------------
//   $l1 = "";  // = 0 50% 25% 12.5%   6.25%   3.125%    REWARD( 1.56% ) HOLD
//   $l2 = "";  // = -  0  50% 25%    12.5%    6.25%      3.125%   
//   $l3 = "";  // = -  -   0  50%    25%     12.5%       6.25%  
//   $l4 = "";  // = -  -   -   0     50%     25%        12.5%  
//   $l5 = "";  // = -  -   -   -      0      50%        25%
//   $l6 = "";  // = -  -   -   -      -       0         50%
//   $l7 = "";  // = -  -   -   -      -       -          0   

//   $levelsId = 0;

//   $l1_total = 0;
//   $l2_total = 0;
//   $l3_total = 0;
//   $l4_total = 0;
//   $l5_total = 0;
//   $l6_total = 0;
//   $l7_total = 0;
//   $l1_tds = 0;
//   $l2_tds = 0;
//   $l3_tds = 0;
//   $l4_tds = 0;
//   $l5_tds = 0;
//   $l6_tds = 0;
//   $l7_tds = 0;
//   $l1_payout = 0;
//   $l2_payout = 0;
//   $l3_payout = 0;
//   $l4_payout = 0;
//   $l5_payout = 0;
//   $l6_payout = 0;
//   $l7_payout = 0;
//   $l1_payout_status = 2;
//   $l2_payout_status = 2;
//   $l3_payout_status = 2;
//   $l4_payout_status = 2;
//   $l5_payout_status = 2;
//   $l6_payout_status = 2;
//   $l7_payout_status = 2;
//   $suspence = 0;
//   $payment_status = 1;

//     $levels = $conn->prepare("SELECT * FROM level where direct_cust_id='".$cust_id."' and  status='1'");
//     $levels->execute();
//     $levels->setFetchMode(PDO::FETCH_ASSOC);
//     $level_data = $levels->fetch();
//       if($level_data){
//           $levelsId = $level_data['id'];
//           $l1 = $level_data['direct_cust_id'];
//           $l2 = $level_data['step_up1'];
//           $l3 = $level_data['step_up2'];
//           $l4 = $level_data['step_up3'];
//           $l5 = $level_data['step_up4'];
//           $l6 = $level_data['step_up5'];
//           $l7 = $level_data['step_up6'];
//       }
//       if ( $l7 ) {
//         $l7_total = $cp_customer_share * 1.56/100;
//         $l7_tds = $l7_total * $tds_rate/100;
//         $l7_payout = $l7_total - $l7_tds;
//         $l7_payout_status = 0;
//         // echo ' $l7_payout = '.$l7_payout;
//       }
//       if ( $l6 ) {
//           $l6_total = $cp_customer_share * 3.125/100;
//           $l6_tds = $l6_total * $tds_rate/100;
//           $l6_payout = $l6_total - $l6_tds;
//           $l6_payout_status = 0;
//           // echo ' $l6_payout = '.$l6_payout;
//       }
//       if ( $l5 ) {
//           $l5_total = $cp_customer_share * 6.25/100;
//           $l5_tds = $l5_total * $tds_rate/100;
//           $l5_payout = $l5_total - $l5_tds;
//           $l5_payout_status = 0;
//           // echo ' $l5_payout = '.$l5_payout;
//       }
//       if ( $l4 ) {
//           $l4_total = $cp_customer_share * 12.5/100;
//           $l4_tds = $l4_total * $tds_rate/100;
//           $l4_payout = $l4_total - $l4_tds;
//           $l4_payout_status = 0;
//           // echo ' $l4_payout = '.$l4_payout;
//       }
//       if ( $l3 ) {
//           $l3_total = $cp_customer_share * 25/100;
//           $l3_tds = $l3_total * $tds_rate/100;
//           $l3_payout = $l3_total - $l3_tds;
//           $l3_payout_status = 0;
//           // echo ' $l3_payout = '.$l3_payout;
//       }
//       if ( $l2 ) {
//           $l2_total = $cp_customer_share * 50/100;
//           $l2_tds = $l2_total * $tds_rate/100;
//           $l2_payout = $l2_total - $l2_tds;
//           $l2_payout_status = 0;
//           $payment_status = 0;
//           // echo ' $l2_payout = '.$l2_payout;
//       }
//       if ( $l1 ) {
//           $l1_total = $cp_customer_share * 0/100;
//           $l1_tds = $l1_total * $tds_rate/100;
//           $l1_payout = $l1_total - $l1_tds;
//           $l1_payout_status = 0;
//           // echo ' $l1_payout = '.$l1_payout;
//       }
//       // Calculate Suspence
//       $total_tds_on_customer_club_share = $l7_tds + $l6_tds + $l5_tds + $l4_tds + $l3_tds + $l2_tds + $l1_tds;
//       $total_customer_club_share = $l7_total + $l6_total + $l5_total + $l4_total + $l3_total + $l2_total + $l1_total;
//       $suspence = $cp_customer_share - $total_customer_club_share; 

//       // create payout for customers
//       $sql5 = "INSERT INTO markup_payout_customer (booking_id,level_id,tds_id,tds_rate,direct_cust_id,step_up1,step_up1_with_tds,step_up2,step_up2_with_tds,step_up3,step_up3_with_tds,step_up4,step_up4_with_tds,step_up5,step_up5_with_tds,step_up6,step_up6_with_tds,tds_on_steps,suspence,payment_status,date_paid)
//                             VALUES (:booking_id,:level_id,:tds_id,:tds_rate,:direct_cust_id,:step_up1,:step_up1_with_tds,:step_up2,:step_up2_with_tds,:step_up3,:step_up3_with_tds,:step_up4,:step_up4_with_tds,:step_up5,:step_up5_with_tds,:step_up6,:step_up6_with_tds,:tds_on_steps,:suspence,:payment_status,:date_paid)";
//       $stmt5 = $conn->prepare($sql5);
//       $result5 = $stmt5->execute([
//                     ':booking_id' => $booking_id,
//                     ':level_id' => $levelsId,
//                     ':tds_id' => $tds_id,
//                     ':tds_rate' => $tds_rate,
//                     ':direct_cust_id' => $cust_id,
//                     ':step_up1' => $l2_total,
//                     ':step_up1_with_tds' => $l2_payout,
//                     ':step_up2' => $l3_total,
//                     ':step_up2_with_tds' => $l3_payout,
//                     ':step_up3' => $l4_total,
//                     ':step_up3_with_tds' => $l4_payout,
//                     ':step_up4' => $l5_total,
//                     ':step_up4_with_tds' => $l5_payout,
//                     ':step_up5' => $l6_total,
//                     ':step_up5_with_tds' => $l6_payout,
//                     ':step_up6' => $l7_total,
//                     ':step_up6_with_tds' => $l7_payout,
//                     ':tds_on_steps' => $total_tds_on_customer_club_share,
//                     ':suspence' => $suspence,
//                     ':payment_status' => $payment_status,
//                     ':date_paid' => $today
//                 ]);
//           if ( $result5 ) {
//             $mp_payout_customer_data = $conn->prepare("SELECT id FROM markup_payout_customer ORDER BY id DESC LIMIT 1");
//             $mp_payout_customer_data->execute();
//             $markup_payout_customer_id_data = $mp_payout_customer_data->fetch();
//             $markup_payout_customer_id = (int)$markup_payout_customer_id_data["id"];

//             // create markup_payout_customer PAYMENT STATUS
//             $sql12 = "INSERT INTO markup_payout_status_customer (markup_payout_customer_id,step_up1,step_up2,step_up3,step_up4,step_up5,step_up6,updated_date)
// 										VALUES (:markup_payout_customer_id,:step_up1,:step_up2,:step_up3,:step_up4,:step_up5,:step_up6,:updated_date)";
//             $stmt12 = $conn->prepare($sql12);
//             $stmt12->execute([
//                 ':markup_payout_customer_id' => $markup_payout_customer_id,
//                 ':step_up1' => $l2_payout_status,
//                 ':step_up2' => $l3_payout_status,
//                 ':step_up3' => $l4_payout_status,
//                 ':step_up4' => $l5_payout_status,
//                 ':step_up5' => $l6_payout_status,
//                 ':step_up6' => $l7_payout_status,
//                 ':updated_date' => $today,
//               ]);	
//           }
  
//     // create payout for club Travel Agent
//     $tds_charges_ta = $cp_travel_agent_share * $tds_rate/100;
//     $amount_with_tds_ta = $cp_travel_agent_share - $tds_charges_ta;

//     $sql13 = "INSERT INTO markup_payout_travelagent (booking_id,level_id,tds_id,tds_rate,cust_id,amount,amount_with_tds,tds_charges,suspence,payment_status,created_date)
//             VALUES (:booking_id,:level_id,:tds_id,:tds_rate,:cust_id,:amount,:amount_with_tds,:tds_charges,:suspence,:payment_status,:created_date)";
//     $stmt13 = $conn->prepare($sql13);
//     $result13 = $stmt13->execute([
//             ':booking_id' => $booking_id,
//             ':level_id' => $levelsId,
//             ':tds_id' => $tds_id,
//             ':tds_rate' => $tds_rate,
//             ':cust_id' => $cust_id,
//             ':amount' => $cp_travel_agent_share,
//             ':amount_with_tds' => $amount_with_tds_ta,
//             ':tds_charges' => $tds_charges_ta,
//             ':suspence' => 0,
//             ':payment_status' => "0",
//             ':created_date' => $today
//           ]);
// // -------------------------------make payout for Markup END -------------------------------
// ------------------------------- Levels  END -----------------------------------------------

//  get package name
    // $package_data = $conn->prepare("SELECT name FROM package WHERE id = '".$mydata['package_id']."'");
    // $package_data->execute();
    // $packages = $package_data->fetch();

// check success
    // if ( $result ) {
    //   // echo "success";

    //     sendEmail(
    //       $mydata['email'],
    //       $mydata['name'],
    //       $from,
    //       $cc,
    //       $order_id,
    //       $today_date,
    //       $packages['name'],
    //       $gst_total, $coupon_discount, $gst_net_payable,
    //       $gst_status,
    //       $coupon_status,
    //       $total, $net_payable, $gst, $total_net_payable
    //     );
    //   }else{
    //     echo "fail";
    // }




// Send Email Function for booking
    // function sendEmail($to, $cust_name, $from, $cc, $orderID, $orderDate, $packageName, $gst_total, $coupon_discount, $gst_net_payable, $gst_status, $coupon_status, $total, $net_payable, $gst, $total_net_payable ){
    //   $subject = "Tour Booking";
      
    //   ini_set( 'display_errors', 1 );
    //   error_reporting( E_ALL );
    //   $header = "From:".$from." \r\n";
    //   $header .= "Cc:".$cc."\r\n";
    //   $header .= "MIME-Version: 1.0\r\n";
    //   $header .= "Content-type: text/html\r\n";
    //   $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    //               <html xmlns="http://www.w3.org/1999/xhtml">
    //               <head>
    //                 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    //                 <title>Order Confirmation</title>
    //                 <!-- Start Common CSS -->
    //                 <style type="text/css">
    //                     #outlook a {padding:0;}
    //                     body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family: Helvetica, arial, sans-serif;}
    //                     .ExternalClass {width:100%;}
    //                     .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
    //                     .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
    //                     .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
    //                     .main-temp table td {border-collapse: collapse;}
    //                 </style>
    //                 <!-- End Common CSS -->
    //               </head>
    //               <body style="margin:0;padding:0;">
    //               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    //               <tr>
    //                 <td align="center" style="padding:0;">
    //                   <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
    //                     <tr>
    //                       <td style="padding:30px;background:#0f3a5e80;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
    //                           <tr>
    //                             <td style="padding:0;width:25%; display:block;" >
    //                               <img src="https://uniqbizz.com/admin/images/uniqbizz_logo.png" alt="" width="100" height="14px" style="display:block;padding:3px 33px 33px 0px;"/>
    //                               <img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" height="70px" style="display:block;" />
    //                             </td>
    //                             <td style="padding:0;width:70%;" align="right">
    //                               <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white; margin:0px">
    //                                       UNIQBIZZ<br>
    //                                       304 - 306, Dempo Towers, Patto Plaza Panaji - Goa - 403001<br>
    //                                       Contact No: 91 8010892265 / 0832 2438989<br>
    //                                       Email ID: support@uniqbizz.com<br>
    //                                       URL: uniqbizz.com
    //                                   </p>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td>
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                           <tr>
    //                             <td style="padding:0;">
    //                               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
    //                                     <img src="https://uniqbizz.com/images/assets/checked.png" width="145" height="145" style="display: block; border: 0px;" /><br>
    //                                     <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Thank You For Your Order! </h2>
    //                                   </td>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:0px 30px 0px 30px;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                           <tr>
    //                             <td style="padding:0;">
    //                               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
    //                                     <p style="font-size: 18px; font-weight: 400; line-height: 24px; color: #000000"> Hi '.$cust_name.',</p>
    //                                     <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> Thank you for choosing Uniqbizz. This email contains important information about your order. Please save it for future reference. </p>
    //                                   </td>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:0px 30px 0px 30px;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                           <tr>
    //                             <td style="padding:0;">
    //                               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <td align="left">
    //                                     <table cellspacing="0" cellpadding="0" border="0" width="100%">
    //                                       <!-- Booking ID -->
    //                                       <tr>
    //                                         <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Order Confirmation  </td>
    //                                         <td width="25%" align="right" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> #'.$orderID.' </td>
    //                                       </tr>
    //                                       <tr>
    //                                         <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> Booking Date </td>
    //                                         <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">  '.$orderDate.' </td>
    //                                       </tr>
    //                                       <tr>
    //                                         <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Package </td>
    //                                         <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> '.$packageName.'</td>
    //                                       </tr> ';
    //                                       if ( $gst_status == 1 ) {
    //                                         $message .= '<tr>
    //                                                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Price  </td>
    //                                                       <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Rs. '.$total.'</td>
    //                                                     </tr>';
    //                                           if ( $coupon_status == 1 ) {
    //                                             $message .= '<tr>
    //                                                             <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Discount  </td>
    //                                                             <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> - Rs. '.$coupon_discount.'</td>
    //                                                           </tr>
    //                                                           <tr>
    //                                                             <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 2px; padding: 1px;"> </td>
    //                                                             <td width="25%" align="right" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 2px; padding: 1px;"> </td>
    //                                                           </tr>
    //                                                           <tr>
    //                                                             <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Sub-Total  </td>
    //                                                             <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Rs. '.$net_payable.'</td>
    //                                                           </tr>';
    //                                           }
    //                                         $message .= '<tr>
    //                                                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> GST  </td>
    //                                                       <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">+ Rs. '.$gst.'</td>
    //                                                     </tr>';
    //                                       } else {
    //                                         $message .=  '<tr>
    //                                                       <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Price  </td>
    //                                                       <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Rs. '.$gst_total.'</td>
    //                                                     </tr>';
    //                                         if ( $coupon_status == 1 ) {
    //                                           $message .=  '<tr>
    //                                                           <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Discount  </td>
    //                                                           <td width="25%" align="right" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">- Rs. '.$coupon_discount.'</td>
    //                                                         </tr>'; 
    //                                         }
    //                                       }
    //                                     $message .=  '</table>
    //                                   </td>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:0px 30px 42px 30px;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                           <tr>
    //                             <td style="padding:0;">
    //                               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <td align="left">
    //                                     <table cellspacing="0" cellpadding="0" border="0" width="100%">
    //                                       <tr>
    //                                         <td align="left" >
    //                                           <table cellspacing="0" cellpadding="0" border="0" width="100%">';
    //                                             if ( $gst_status == 1 ) {
    //                                               $message .= '<tr>
    //                                                               <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> TOTAL </td>
    //                                                               <td width="25%" align="right" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Rs. '.$total_net_payable.'</td>
    //                                                             </tr>';
    //                                             } else {
    //                                               if ( $coupon_status == 1 ) {
    //                                                 $message .= '<tr>
    //                                                               <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> TOTAL </td>
    //                                                               <td width="25%" align="right" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Rs. '.$gst_net_payable.'</td>
    //                                                             </tr>';
    //                                               } else {
    //                                                 $message .= '<tr>
    //                                                               <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> TOTAL </td>
    //                                                               <td width="25%" align="right" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Rs. '.$gst_total.'</td>
    //                                                             </tr>';
    //                                               }
    //                                             }
    //                                           $message .= '</table>
    //                                         </td>
    //                                       </tr>
    //                                     </table>
    //                                   </td>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:30px;background:#0f3a5e80;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
    //                           <tr>
    //                             <td style="padding:0;width:50%;" align="left">
    //                               <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color: #ffffff;">
    //                                 UNIQBIZZ<br/>
    //                               </p>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                   </table>
    //                 </td>
    //               </tr>
    //             </table>        
    //           </body>   
    //         </html>';

      
    //   $retval = mail ($to,$subject,$message,$header);

    //   if( $retval == true ) {
    //     echo "success";
    //     // echo "Message sent successfully...";
    //   }else{
    //     echo "fail";
    //     //echo "Message could not be sent...";
    //   }
    // }


// new login register  
    // function sendMail($choosetype,$fullname,$address,$sendTo,$uname,$password,$doj,$cust_id,$ta_firstname,$ta_lastname ){
    //   $fromEmail = 'support@uniqbizz.com';
    //   $uname = $sendTo;
    //   $toEmail = $sendTo;
    //   $subjectName = 'Login Details';
      
    //   ini_set( 'display_errors', 1 );
    //   error_reporting( E_ALL );
    //   $to = $toEmail;
    //   $subject = $subjectName;
    //   $headers = "MIME-Version: 1.0" . "\r\n";
    //   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    //   $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
    //   $message3 = '<!DOCTYPE html>
    //           <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
    //           <head>
    //             <meta charset="UTF-8">
    //             <meta name="viewport" content="width=device-width,initial-scale=1">
    //             <meta name="x-apple-disable-message-reformatting">
    //             <title></title>
    //             <!--[if mso]>
    //             <noscript>
    //               <xml>
    //                 <o:OfficeDocumentSettings>
    //                   <o:PixelsPerInch>96</o:PixelsPerInch>
    //                 </o:OfficeDocumentSettings>
    //               </xml>
    //             </noscript>
    //             <![endif]-->
    //             <style>
    //               table, td, div, h1, p {font-family: Arial, sans-serif;}
    //             </style>
    //           </head>
    //           <body style="margin:0;padding:0;">
    //             <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    //               <tr>
    //                 <td align="center" style="padding:0;">
    //                   <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
    //                     <tr>
    //                       <td style="padding:30px;background:#0f3a5e80;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
    //                           <tr>
    //                             <td style="padding:0;width:25%; display:block;" >
    //                               <img src="https://uniqbizz.com/admin/images/uniqbizz_logo.png" alt="" width="100" height="14px" style="display:block;padding:3px 33px 33px 0px;"/>
    //                               <img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" height="70px" style="display:block;" />
    //                             </td>
    //                             <td style="padding:0;width:70%;" align="right">
    //                               <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white; margin:0px">
    //                                       UNIQBIZZ<br>
    //                                       304 - 306, Dempo Towers, Patto Plaza Panaji - Goa - 403001<br>
    //                                       Contact No: 91 8010892265 / 0832 2438989<br>
    //                                       Email ID: support@uniqbizz.com<br>
    //                                       URL: uniqbizz.com
    //                                   </p>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:36px 30px 42px 30px;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                           <tr>
    //                             <td style="padding:0;">
    //                               <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
    //                                 <tr>
    //                                   <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
    //                                   <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
    //                                     <!-- <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/right.gif" alt="" width="260" style="height:auto;display:block;" /></p> -->
    //                                     ';
                                        
    //                                     if($choosetype == 'cust'){
    //                                       $message3 .= '
    //                                           <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear '.$fullname.'  <br>
    //                                             ID: - '.$cust_id.'<br>
    //                                             DOJ: - '.$doj.'<br>
    //                                             Address: - '.$address.'<br>
    //                                             Username: - '.$uname.'<br>
    //                                             Password: - '.$password.'<br>';

    //                                       $message3 .= '<hr><br><br></p>
    //                                           <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
    //                                             Congratulations on your decision! </p>

    //                                           <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; ">
    //                                               A journey of a thousand miles must begin with a single step. I\'d like to welcome you to Uniqbizz.
    //                                               We are excited that you have accepted our business offer and agreed upon your start date. 
    //                                               I trust that this letter finds you mutually excited about your new opportunity with Uniqbizz.
    //                                             <br><br>
    //                                               Each of us will play a role to ensure your successful integration into the company. 
    //                                               Your agenda will involve planning your orientation with company and setting some intial work goals so that you feel immediately productive in your new role. And to earn money which is optional,
    //                                               your earnings will depend directly upon the amount of questions prior to your start date, please call me anytime, or send email if that is more convenient. 
    //                                               We look forward to having you come onboard. The secret of success is constancy to purpose.
    //                                           </p>';

    //                                     }else if($choosetype == 'admin'){
    //                                       $message3 .= '<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;">
    //                                                       Dear Admin  <hr><br>

    //                                                       Congratulations new customer has been added </p>

    //                                                   <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">

    //                                                       <h3><u>Customer Deatils</u></h3>
    //                                                       Customer ID: - '.$cust_id.'<br>
    //                                                       Customer Name: - '.$fullname.'<br>
    //                                                       DOJ: - '.$doj.'<br>
    //                                                       Address: - '.$address.'<br>
    //                                                       Username: - '.$uname.'<br>
    //                                                       Password: - '.$password.'<br>';
    //                                                     $message3 .= '<hr><br><br>
    //                                                   </p>';

    //                                     }else if($choosetype == 'ta'){
    //                                       $message3 .=  '<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;">

    //                                                       Dear '.$ta_firstname.' '.$ta_lastname.'  <hr><br>

    //                                                       Thank You for adding new customer</p>

    //                                                     <p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">
    //                                                       <h3><u>Customer Deatils</u></h3>
    //                                                         Customer ID: - '.$cust_id.'<br>
    //                                                         Customer Name: - '.$fullname.'<br>
    //                                                         DOJ: - '.$doj.'<br>
    //                                                         Address: - '.$address.'<br><br>
    //                                                       <hr><br><br>
    //                                                     </p>
    //                                                   ';
    //                                     }

    //                                       $message3 .=  '<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
    //                                                       Best Regards,<br>
    //                                                       Uniqbizz</p>
    //                                   </td>
    //                                 </tr>
    //                               </table>
    //                             </td>
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                     <tr>
    //                       <td style="padding:30px;background:#0f3a5e80;">
    //                         <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
    //                           <tr>
    //                             <td style="padding:0;width:50%;" align="left">
    //                               <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
    //                                 UNIQBIZZ<br/>
    //                               </p>
    //                             </td>
                                
    //                           </tr>
    //                         </table>
    //                       </td>
    //                     </tr>
    //                   </table>
    //                 </td>
    //               </tr>
    //             </table>
    //           </body>
    //           </html>';
    //   mail($to, $subject, $message3, $headers);
    // }
?>