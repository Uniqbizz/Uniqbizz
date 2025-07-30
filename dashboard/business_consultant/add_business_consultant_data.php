<?php
    // session_start();
    require '../connect.php';
    $current_year = date('Y'); 

    // Email files
    include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

    $user_id_name=$_POST['user_id_name'];
    $registrant=$_POST['reference_name'];
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $nominee_name=$_POST['nominee_name'];
    $nominee_relation=$_POST['nominee_relation'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    // $gst_no=$_POST['gst_no'];
    $country_code=$_POST['country_code'];
    $phone_no=$_POST['phone'];
    // $gst_no=$_POST['gst_no'];
    // $business_package=$_POST['business_package'];
    // $amount=$_POST['amount'];
    // $kyc=$_POST['kyc'];
    $bdate=$_POST['dob'];
    $profile_pic=$_POST['profile_pic'];
    $pan_card=$_POST['pan_card'];
    $aadhar_card=$_POST['aadhar_card'];
    $voting_card=$_POST['voting_card'];
    $passbook=$_POST['passbook'];
    $address=$_POST['address'];
    $pincode=$_POST['pincode'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];

    $user_type="3";
    $register_by="18";

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Business Consultant";
    $message="Added new Business Consultant by CBD";
    $message2="Added new Business Consultant by CBD";
    $fromWhom="1";

    // set password
    $string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
    $password = substr(str_shuffle($string), 0,8);
    $status= '1';

    date_default_timezone_set('Asia/Calcutta');
    $todayYear = date('Y' );
    $subY=substr($todayYear,2,4);

    // made changes in query to get id in order SFA230043 TC230010 select Uniqe user from exesiting users 
    $sql2= $conn->prepare("SELECT distinct business_consultant_id,SUBSTRING(business_consultant_id,3,6) as tc_id from business_consultant where status='1' OR status='3' order by tc_id DESC limit 1");

    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC);
    if($sql2->rowCount()>0){
        foreach (($sql2->fetchAll()) as $key3 => $row3) {
            $business_consultant_id=$row3["business_consultant_id"];
        }
        if($business_consultant_id ==''){	
            $uid = 'BC'.$subY.'0001';
        }else{
            $subV=substr($business_consultant_id,2,4);
            if($subV==$subY){
                $business_consultant_id++;
                $business_consultant_id=str_pad($business_consultant_id, 4, '0', STR_PAD_LEFT);
                $uid =$business_consultant_id;
            }else{
                $business_consultant_id++;
                $fid=substr($business_consultant_id,4);
                $newValue = 'BC'.$subY.$fid;
                $Nbusiness_consultant_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
                $uid =$Nbusiness_consultant_id;
            }
        }
    }else{
        $uid = 'BC'.$subY.'0001';
    }

    //log file
    $title="Confirm Business Consultant";
    $message=$uid." has been approved";
    $message2=$uid." has been approved";
    $fromWhom="1";

    $sql= "INSERT INTO `business_consultant` (business_consultant_id, firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, profile_pic, pan_card, aadhar_card, voting_card, bank_passbook, user_type, registrant, reference_no, register_by, status) VALUES (:business_consultant_id, :firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:profile_pic, :pan_card,:aadhar_card,:voting_card,:bank_passbook, :user_type,:registrant,  :reference_no, :register_by, :status)";
    $stmt3 =$conn->prepare($sql);

    $result=$stmt3->execute(array(
        ':business_consultant_id' => $uid,
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        // ':gst_no' => $gst_no,
        // ':complimentary' => $complimentary,
        // ':converted' => $converted,
        // ':business_package' => $business_package,
        // ':amount' => $amount,
        ':email' => $email,
        ':country_code' => $country_code, 
        ':contact_no' => $phone_no,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,  
        ':bdate' => $bdate,
        ':age' => $age,  
        ':gender' => $gender,
        ':profile_pic' => $profile_pic,
        // ':kyc' => $kyc,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ));

    if ($result) {
		
		$sql2= "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
		$stmt3 =$conn->prepare($sql2);

		$result2=$stmt3->execute(array(
		':uname' => $email, 
		':password' => $password, 
		':user_id' => $uid, 
		':user_type_id' => $user_type, 
		':status' => $status
		));

        if($result2){

            $sql3= "INSERT INTO logs (user_id, title,message,message2,reference_no, register_by, from_whom) VALUES (:user_id, :title ,:message, :message2, :reference_no, :register_by, :from_whom)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                ':user_id' => $uid,
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                ':reference_no' => $user_id_name,
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