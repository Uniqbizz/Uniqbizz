<?php 
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

$id= $_POST["id"];
$uname= $_POST["uname"];
// $reference = $_POST["ref"];
// $business_package = $_POST["business_package"];
// if($business_package == 'basic'){
// 	$type = 'B';
// }else if($business_package == 'advanced'){
// 	$type = 'A';
// }else if($business_package == 'ultra'){
// 	$type = 'U';
// }else if($business_package == "micro"){
// 	$type = 'M';
// }

$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0,8);
$status= '1';
$user_type_id= '11';

// $sm_id= $_POST["sm_id"];
$register_by ='1';

date_default_timezone_set('Asia/Calcutta');
$todayYear = date('Y' );

$subY=substr($todayYear,2,4);

$sql9= $conn->prepare("SELECT * from ca_travelagency where id='".$id."' and status='2'");
$sql9->execute();
$sql9->setFetchMode(PDO::FETCH_ASSOC);
if($sql9->rowCount()>0){
	foreach (($sql9->fetchAll()) as $key9 => $row9) {

		 $registerDate= new DateTime($row9['register_date']);
         $doj= $registerDate->format('d/m/Y');
         $name= $row9['firstname']. ' ' . $row9['lastname'];
         $address = $row9['address'];
         $country_code = $row9['country_code'];
         $contact_no = $row9['contact_no'];
		 $ca_reference = $row9['reference_no'];
	}
}

//get corporate agencies reference number i.e Travel agent/business consultent to enter it in "payout statments" table
$sql10 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ca_reference."'");
$sql10->execute();
$sql10->setFetchMode(PDO::FETCH_ASSOC);
if($sql10->rowCount()>0){
	foreach(($sql10->fetchAll()) as $key10 => $row10){
		$Ca_id = $row10['corporate_agency_id'];
		$Ca_name = $row10['firstname']. ' ' .$row10['lastname'];
		$Bc_id = $row10['reference_no'];
		$Bc_name = $row10['registrant'];
	}
}
$sql11 = $conn->prepare("SELECT * FROM business_consultant WHERE business_consultant_id = '".$Bc_id."'");
$sql11->execute();
$sql11->setFetchMode(PDO::FETCH_ASSOC);
if($sql11->rowCount()>0){
	foreach(($sql11->fetchAll()) as $key11 => $row11){
		$BcId = $row11['business_consultant_id'];
		$BcName = $row11['firstname']. ' ' .$row11['lastname'];
		$BcRef = $row11['reference_no'];
	}
}
$sql12 = $conn->prepare("SELECT * FROM channel_business_director WHERE channel_business_director_id = '".$BcRef."'");
$sql12->execute();
$sql12->setFetchMode(PDO::FETCH_ASSOC);
if($sql12->rowCount()>0){
	foreach(($sql12->fetchAll()) as $key12 => $row12){
		$cbd_id = $row12['channel_business_director_id'];
		$cbd_name = $row12['firstname']. ' ' .$row12['lastname'];
	}
}
// $uid=0;
// $franchisee_id=0;

// $uid='';
// $sql2= $conn->prepare("SELECT franchisee_id,CAST(franchisee_id as SIGNED) AS casted_column  from franchisee where user_type='4'  ORDER BY casted_column desc limit 1");
// made changes in query to get id in order SFA230043 TC230010
$sql2= $conn->prepare("SELECT distinct ca_travelagency_id,SUBSTRING(ca_travelagency_id,3,6) as tc_id from ca_travelagency where status='1' OR status='3' order by tc_id DESC limit 1");

$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_ASSOC);
if($sql2->rowCount()>0){
	foreach (($sql2->fetchAll()) as $key3 => $row3) {
		 $ca_travelagency_id=$row3["ca_travelagency_id"];
	}
	if($ca_travelagency_id ==''){	
			$uid = 'TA'.$subY.'0001';
	}else{

		$subV=substr($ca_travelagency_id,2,4);
		if($subV==$subY){
			// ''.$ssd
			$ca_travelagency_id++;
			  $ca_travelagency_id=str_pad($ca_travelagency_id, 4, '0', STR_PAD_LEFT);
			  $uid =$ca_travelagency_id;
		}else{

			$ca_travelagency_id++;
			$fid=substr($ca_travelagency_id,4);
			$newValue = 'TA'.$subY.$fid;

			// if($business_package == 'basic'){
			// 	$newValue = 'SFB'.$subY.$fid;
			// }else if($business_package == 'advanced'){
			// 	$newValue = 'SFA'.$subY.$fid;
			// }else if($business_package == 'ultra'){
			// 	$newValue = 'SFU'.$subY.$fid;
			// }

			  $Nca_travelagency_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
			  $uid =$Nca_travelagency_id;
		}
	}



}else
{
	$uid = 'TA'.$subY.'0001';
	// if($business_package == 'basic'){
	// 	$uid = 'SFB'.$subY.'0001';
	// }else if($business_package == 'advanced'){
	// 	$uid = 'SFA'.$subY.'0001';
	// }else if($business_package == 'ultra'){
	// 	$uid = 'SFU'.$subY.'0001';
	// }else{

	// }
}

//log file
$title="Confirm CA Travel Agency";
$message=$uid." has been approved";
$message2=$uid." has been approved";
$fromWhom="1";


$sql1 = "UPDATE ca_travelagency SET status=:status,ca_travelagency_id=:ca_travelagency_id WHERE id=:id";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':ca_travelagency_id' => $uid,
	// ':deleted_date' => $today,
	':id' => $id		
));

if ($result) {
	
	$sql= "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
	$stmt3 =$conn->prepare($sql);

	$result2=$stmt3->execute(array(
	':uname' => $uname, 
	':password' => $password, 
	':user_id' => $uid, 
	':user_type_id' => $user_type_id, 
	':status' => $status
	));

	if($result2){
		$sql4= "INSERT INTO logs (user_id,title,message,message2, register_by, from_whom) VALUES (:user_id,:title ,:message, :message2, :register_by, :from_whom)";
		$stmt4 =$conn->prepare($sql4);

		$result3=$stmt4->execute(array(
		':user_id' => $uid,
		':title' => $title,
		':message' => $message,
		':message2' =>$message2,
		// ':reference_no' => $sm_id,
		':register_by' => $register_by,
		':from_whom' => $fromWhom
		));

		if($result3){
			
			$message_bc = "BC - ".$Bc_name." ".$Bc_id." earned 500/- on recruting Travel Agent. Name of the Travel Agent - " .$name." ".$uid. ". Recruitment Fee - 5,000/-. With Reference of Corporate Agency ".$Ca_name." ".$Ca_id.".";
			$commision_bc = "500";

			$message_ca = "CA - ".$Ca_name." ".$Ca_id." earned 2000/- on recruting Travel Agent. Name of the Travel Agent - " .$name." ".$uid. ". Recruitment Fee - 5,000/-";
			$commision_ca = "2000";

			$message_ca_ta = "Travel Agent - "  .$name." ".$uid. " has join with reference of Corporate Agency " .$Ca_name." ".$Ca_id.". Recruitment Fee - 5,000/-";
			$ca_ta_amt_paid = "5000";

			$insertCALSql = "INSERT INTO `ca_ta_payout` (business_consultant, message_bc, commision_bc, corporate_agency, message_ca, commision_ca, ca_travelagency, message_ca_ta, ca_ta_amt_paid, status) VALUES (:business_consultant, :message_bc, :commision_bc,  :corporate_agency, :message_ca, :commision_ca, :ca_travelagency, :message_ca_ta, :ca_ta_amt_paid, :status) ";
			$insertCAL = $conn -> prepare($insertCALSql);
			$result4 = $insertCAL -> execute(array(

				':business_consultant' => $Bc_id,
				':message_bc' => $message_bc,
				':commision_bc' => $commision_bc,
				
				':corporate_agency' => $Ca_id, 
				':message_ca' => $message_ca,
				':commision_ca' => $commision_ca,

				':ca_travelagency' => $uid,
				':message_ca_ta' => $message_ca_ta,
				':ca_ta_amt_paid' => $ca_ta_amt_paid,

				':status' =>  $status
			));

			if($result4){

				$message_cbd = "CBD - ".$cbd_name." ".$cbd_id." earned 150/- From BC - ".$Bc_name." ".$Bc_id." when Corporate Agency  ".$Ca_name." ".$Ca_id." recruited Travel Agency. Name of the Travel Agency - " .$name." ".$uid. ".";
				$payout_type = "Recruitment Payout";
				$cbdCommiAmt = "150";

				$insertCBDPaySQL = " INSERT INTO cbd_payout (cbd_id, cbd_name, payout_type, user_id, user_name, message, amount, status) VALUES (:cbd_id, :cbd_name, :payout_type, :user_id, :user_name, :message, :amount, :status) ";
				$insertCBDPay = $conn -> prepare($insertCBDPaySQL);
				$result5 = $insertCBDPay -> execute( array(
					':cbd_id' => $cbd_id,
					':cbd_name' => $cbd_name,
					':payout_type' => $payout_type,
					':user_id' => $BcId, 
					':user_name' => $BcName, 
					':message' => $message_cbd, 
					':amount' => $cbdCommiAmt, 
					':status' => '2'
				));

				if($result5){
					
					//sms
					$apikey = "O1y4qz6QvEirxbrmPubk0g";
					$apisender = "UNIQBI";
					// 	  $msg ="Welcome to Bizzmirth holidays. Your ID is '".$uname."' and your password is '".$password."'";
					$msg ="Welcome to the Uniqbizz. 

						Visit uniqbizz.com
														
						Your ID is : - 
														
						Email ID: - '".$uname."'
														
						Password: - '".$password."'
														
						Thank You";
					$num = $country_code.$contact_no; // MULTIPLE NUMBER VARIABLE PUT HERE...!
					$ms = rawurlencode($msg); //This for encode your message content
					$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=1&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
					//echo $url;
					$ch=curl_init($url);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch,CURLOPT_POSTFIELDS,"");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
					$data = curl_exec($ch);
					echo '

					';
					
					//email
					$fromEmail = 'support@uniqbizz.com';
					$toEmail = $uname;
					$subjectName = 'Login Details';
					$to = $toEmail;
					$subject = $subjectName;
					$message3 = '<!DOCTYPE html>
					<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
					<head>
					<meta charset="UTF-8">
					<meta name="viewport" content="width=device-width,initial-scale=1">
					<meta name="x-apple-disable-message-reformatting">
					<title></title>
					<!--[if mso]>
					<noscript>
						<xml>
						<o:OfficeDocumentSettings>
							<o:PixelsPerInch>96</o:PixelsPerInch>
						</o:OfficeDocumentSettings>
						</xml>
					</noscript>
					<![endif]-->
					<style>
						table, td, div, h1, p {font-family: Arial, sans-serif;}
					</style>
					</head>
					<body style="margin:0;padding:0;">
					<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
						<tr>
						<td align="center" style="padding:0;">
							<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
							<tr>
								<td style="padding:30px;background:#a5a5a5;">
								<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
									<tr>
									<td style="padding:0;width:50%;" align="left">
										<img src="https://uniqbizz.com/uploading/uniqbizz_logo.png" alt="" width="100" style="height:auto;display:block; position: absolute; top: 37px;" />
										<img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" style="height:auto;display:block;" /></p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
										<tr>
										<p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white;">
											Uniqbizz<br>
											306 Ambrosia Corporate Park EDC Patto Plaza Panjim Goa 403001<br>
											Contact No: 0832 2438500 / 8080785714<br>
											Email ID: support@uniqbizz.com<br>
											URL: uniqbizz.com
										</p>
										
										</tr>
										</table>
									</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td style="padding:36px 30px 42px 30px;">
								<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
									<tr>
									<td style="padding:0;">
										<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
										<tr>
											
											<td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
											<td style="width:260px;padding:0;vertical-align:top;color:#153643;">
											<!-- <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/right.gif" alt="" width="260" style="height:auto;display:block;" /></p> -->
											<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear '.$name.'  <br>
											ID: - '.$uid.'<br>
											DOJ: - '.$doj.'<br>
											Address: - '.$address.'<br>
											Username: - '.$toEmail.'<br>
											Password: - '.$password.'<br><br>
											<hr><br><br>
											</p>
											<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
												Congratulations on your decision! </p>

												<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; ">
												A journey of a thousand miles must begin with a single step. Id like to welcome you to Uniqbizz. We are excited that you have accepted our business offer and agreed upon your start date. I trust that this letter finds you mutually excited about your new opportunity with Uniqbizz.
												<br><br>

												Each of is will play a role to ensure your successful integration into the company. Your agenda will involve planning your orientation with company and setting some intial work goals so that you feel immediately productive in your new role. And to earn money which is optional, your earnings will depend directly in the amount of questions prior to your start date, please call me anytime, or send email if that is more convenient. We look forward to having you come onboard. The secret of success is constancy to purpose.

												</p>
												<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
												Best Regards,<br>
												Uniqbizz</p>
											</td>
										</tr>
										</table>
									</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td style="padding:30px;background:#a5a5a5;">
								<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
									<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
										Uniqbizz.<br/>
										</p>
									</td>
									
									</tr>
								</table>
								</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					</body>
					</html>';
					$mail = new PHPMailer(); 
					$mail->IsSMTP(); 
					$mail->SMTPAuth = true; 
					$mail->SMTPSecure = 'tls'; 
					$mail->Host = "mail.uniqbizz.com";
					$mail->Port = 587; 
					$mail->IsHTML(true);
					$mail->CharSet = 'UTF-8';
					// $mail->SMTPDebug = 2; 
					$mail->Username = "support@uniqbizz.com";
					$mail->Password = "support@uniqbizz";
					$mail->SetFrom("support@uniqbizz.com");
					$mail->Subject = $subject;
					$mail->Body =$message3;
					$mail->AddAddress($to);
					$mail->SMTPOptions=array('ssl'=>array(
						'verify_peer'=>false,
						'verify_peer_name'=>false,
						'allow_self_signed'=>false
					));
					if(!$mail->Send()){
						echo $mail->ErrorInfo;
					}else{
						echo 1;
					}
				}else{
					echo 0	;
				}

			}else{
				echo 0 ;
			}
		}else{
			echo 0 ;
		}
	}else{
		echo 0	;
	}

}else{
	echo 0;
}


?>