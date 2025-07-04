<?php 
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

date_default_timezone_set('Asia/Calcutta'); //set default timeZone
$todayYear = date('Y' ); // year for Custom Id genaration
$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

$id= $_POST["id"];
$uname= $_POST["uname"];

$string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0,8);

$status= '1';
$register_by ='15';

$subY=substr($todayYear,2,4);

$sql9= $conn->prepare("SELECT * from employees where id='".$id."' and status='2'");
$sql9->execute();
$sql9->setFetchMode(PDO::FETCH_ASSOC);
if($sql9->rowCount()>0){
	foreach (($sql9->fetchAll()) as $key9 => $row9) {
		$added_Date= new DateTime($row9['added_on']);
		$doj= $added_Date->format('d/m/Y');
		$name= $row9['name'];
		$address = $row9['address'];
		$country_code = $row9['country_code'];
		$contact_no = $row9['contact'];
		$user_type_id = $row9['user_type'];
		$reference_no = $row9['reporting_manager'];
	}
}

	// $sql2= $conn->prepare("SELECT distinct employee_id  from employees order by employee_id desc limit 1");
	$sql2= $conn->prepare("SELECT distinct employee_id,SUBSTRING(employee_id,3,6) as tc_id from employees where status='1' OR status='3' order by tc_id DESC limit 1");
    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC);
    if($sql2->rowCount()>0){
        foreach (($sql2->fetchAll()) as $key3 => $row3) {
            $employee_id = $row3["employee_id"];
        } 
        if($employee_id ==''){
            $uid = 'BH'.$subY.'0001';
        }else{
            $subV=substr($employee_id,2,4);
            if($subV==$subY){
                $employee_id++;
                $employee_id = str_pad($employee_id, 4, '0', STR_PAD_LEFT);
                $uid = $employee_id;
            }else{
                $employee_id++;
                $uid = substr($employee_id,4);
                $newValue = 'BH'.$subY.$uid;
                $Nemployee_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
                $uid =$Nemployee_id;
            }
        }
    }else{
        $uid = 'BH'.$subY.'0001';
    }

	if($user_type_id == '24'){
        // $user_type = '24'; //BCM
		$designation = 'Business Channel manager';
    }else if($user_type_id == '25'){
        // $user_type = '25'; //BDM
		$designation = 'Business Development Manager';
    }

    //log file
    $title="Employee";
    $message=$uid." has been approved";
    $message2=$uid." has been approved";
    $fromWhom="15";

	$sql1 = "UPDATE employees SET status=:status,employee_id=:employee_id, register_date=:register_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':status' => $status,
		':employee_id' => $uid,
		':register_date' => $register_Date,
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
			$sql4= "INSERT INTO logs (user_id,title,message,message2, reference_no,register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no,:register_by, :from_whom,:operation)";
			$stmt4 =$conn->prepare($sql4);
			$result3=$stmt4->execute(array(
				':user_id' => $uid,
				':title' => $title,
				':message' => $message,
				':message2' =>$message2,
				':reference_no' => $reference_no,
				':register_by' => $register_by,
				':from_whom' => $fromWhom,
				':operation' => 'Confirm'
			));

			if($result3){
				
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
										Bizzmirth Holidays<br>
										304-306 3rd floor Dempo Tower Patto Plaza Panjim Goa 403001<br>
										Contact No: 8010892265<br>
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
											A journey of a thousand miles must begin with a single step. Id like to welcome you to Bizzmirth Holidays. We are excited that you have accepted our business offer and agreed upon your start date. I trust that this letter finds you mutually excited about your new opportunity with Bizzmirth Holidays.
											<br><br>

											Each of is will play a role to ensure your successful integration into the company. Your agenda will involve planning your orientation with company and setting some intial work goals so that you feel immediately productive in your new role. And to earn money which is optional, your earnings will depend directly in the amount of questions prior to your start date, please call me anytime, or send email if that is more convenient. We look forward to having you come onboard. The secret of success is constancy to purpose.

											</p>
											<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
											Best Regards,<br>
											Bizzmirth Holidays</p>
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
									Bizzmirth Holidays.<br/>
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
			}else{  //email
				echo 0	;
			}
		}else{ //logs
			echo 0	;
		}

	}else{ //login
		echo 0;
	}

?>