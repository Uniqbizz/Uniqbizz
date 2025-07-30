<?php
include('smtp/PHPMailerAutoload.php');

$name = 'Pandurang Naik';
$uid = 'CA240001';
$doj = '16-03-1997';
$address = 'Aldona Bardez Goa';
$uname = 'pandurang.naik@mirthtrip.com';
$password = '1234567890';

$to = 'pandurang.naik@mirthtrip.com';
$subject = 'Test Email CA';
$msg = '<!DOCTYPE html>
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
								Username: - '.$uname.'<br>
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

// echo smtp_mailer('naikpandurang3@gmail.com','Test Email','Hello CA');
// function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "mail.uniqbizz.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug = 2; 
	$mail->Username = "support@uniqbizz.com";
	$mail->Password = "support@uniqbizz";
	$mail->SetFrom("support@uniqbizz.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
// }
?>