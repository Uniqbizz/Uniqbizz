<?php
	// session_start();
	require '../../connect.php';
	$current_year = date('Y'); 

	// Email files
	include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

	$branch_name=$_POST['branch'];
	$zone_name=$_POST['zone'];
	$region_name=$_POST['region'];
	$firstname=$_POST['firstname'];
	// $mname=$_POST['mname'];
	$lastname=$_POST['lastname'];
	$email=$_POST['email'];
	$gender=$_POST['gender'];
	$country_code=$_POST['country_code'];
	$phone_no=$_POST['phone'];
	// $age=$_POST['age'];
	$bdate=$_POST['dob'];
	$profile_pic=$_POST['profile_pic'];
	// $kyc=$_POST['kyc'];
	$pan_card=$_POST['pan_card'];
	$aadhar_card=$_POST['aadhar_card'];
	$voting_card=$_POST['voting_card'];
	$passbook=$_POST['passbook'];
	$address=$_POST['address'];
	$pincode=$_POST['pincode'];
	$country=$_POST['country'];
	$state=$_POST['state'];
	$city=$_POST['city'];

	// get age of the user
	$birthYear = str_split($bdate,4);
	$birth_year = $birthYear[0];
	$age = $current_year - $birth_year;

	$user_type="12";
	$register_by="1";
	$ref_no="1";

	$title="Head Office";
	$message="Added New Head Office";
	$message2="Added New Head Office";
	$fromWhom="1";
	// $register_by="5";

	//Set password
	$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
	$password = substr(str_shuffle($string), 0,8);
	$status= '1';

	date_default_timezone_set('Asia/Calcutta');
	$todayYear = date('Y' );
	$subY=substr($todayYear,2,4);

	$sql2= $conn->prepare("SELECT distinct head_office_id,SUBSTRING(head_office_id,5,6) as tc_id from head_office where status='1' OR status='3' order by tc_id DESC limit 1");
	$sql2->execute();
	$sql2->setFetchMode(PDO::FETCH_ASSOC);
	if($sql2->rowCount()>0){
		foreach (($sql2->fetchAll()) as $key3 => $row3) {
			$head_office_id=$row3["head_office_id"];
		}
		if($head_office_id ==''){	
				$uid = 'HDOF'.$subY.'0001';
		}else{
			$subV=substr($head_office_id,4,4);
			if($subV==$subY){
				$head_office_id++;
				$head_office_id=str_pad($head_office_id, 4, '0', STR_PAD_LEFT);
				$uid =$head_office_id;
			}else{
				$head_office_id++;
				$fid=substr($head_office_id,6);
				$newValue = 'HDOF'.$subY.$fid;
				$Nhead_office_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
				$uid =$Nhead_office_id;
			}
		}
	}else{
		$uid = 'HDOF'.$subY.'0001';
	}

	$sql= "INSERT INTO head_office (head_office_id, firstname,lastname, email, country_code, contact_no , date_of_birth,age,gender,country,state,city,pincode,address,profile_pic,pan_card,aadhar_card,voting_card,bank_passbook,user_type,branch,zone,region, status) VALUES (:head_office_id, :firstname ,:lastname, :email, :country_code, :phone_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:profile_pic ,:pan_card,:aadhar_card,:voting_card,:passbook,  :user_type,:branch_name,  :zone_name, :region_name, :status)";
	$stmt3 =$conn->prepare($sql);

	$result=$stmt3->execute(array(
		':head_office_id' => $uid,
		':firstname' => $firstname, 
		':lastname' => $lastname, 
		':email' => $email,
		':country_code' => $country_code, 
		':phone_no' => $phone_no,
		':country' => $country,
		':state' => $state,
		':city' => $city,
		':pincode' => $pincode,
		':address' => $address,  
		':bdate' => $bdate,
		':age' => $age,  
		':gender' => $gender,
		':profile_pic' => $profile_pic,
		':pan_card' => $pan_card,
		':aadhar_card' => $aadhar_card,
		':voting_card' => $voting_card,
		':passbook' => $passbook,  
		':user_type' => $user_type,
		':branch_name' =>$branch_name,
		':zone_name' => $zone_name,
		':region_name' => $region_name,
		':status' => $status
	));

	if ($result) {
		
		$sql= "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
		$stmt3 =$conn->prepare($sql);

		$result2=$stmt3->execute(array(
		':uname' => $email, 
		':password' => $password, 
		':user_id' => $uid, 
		':user_type_id' => $user_type, 
		':status' => $status
		));

		if($result2){
			$sql2= "INSERT INTO logs (user_id,title,message,message2,  register_by, from_whom) VALUES (:user_id,:title ,:message, :message2,  :register_by, :from_whom)";
			$stmt =$conn->prepare($sql2);

			$result3=$stmt->execute(array(
				':user_id' => $uid,
				':title' => $title,
				':message' => $message,
				':message2' =>$message2,
				// ':reference_no' => $ref_no,
				':register_by' => $register_by,
				':from_whom' => $fromWhom
			));

			if($result3){
				
				//sms
				$apikey = "O1y4qz6QvEirxbrmPubk0g";
				$apisender = "UNIQBI";
				// 	  $msg ="Welcome to Bizzmirth holidays. Your ID is '".$uname."' and your password is '".$password."'";
				$msg ="Welcome to the Uniqbizz. 

					Visit uniqbizz.com
													
					Your ID is : - 
													
					Email ID: - '".$email."'
													
					Password: - '".$password."'
													
					Thank You";
				  $num = $country_code.$phone_no; // MULTIPLE NUMBER VARIABLE PUT HERE...!
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
				$toEmail = $email;
				$subjectName = 'Login Details';
				// $to = $toEmail;
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
										<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear '.$firstname.' '.$lastname.'  <br>
										ID: - '.$uid.'<br>
										DOJ: - '.$bdate.'<br>
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
				$mail->AddAddress($toEmail);
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
			}else{  //email
				echo 0	;
			}
		}else{
			echo 0	;
		}
	}else{
		echo 0	;
	}

?>