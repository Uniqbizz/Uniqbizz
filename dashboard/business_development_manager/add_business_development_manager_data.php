<?php

	session_start();

	// echo $username = $_SESSION['username'];
	// echo $id = $_SESSION['id'];
	// echo $user_id = $_SESSION['user_id'];

	if(!isset($_SESSION['username'])){
		echo '<script>location.href = "../login.php";</script>';
	}

    include '../connect.php';
    $current_year = date('Y'); 

    // Email files
    // include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $country_cd = $_POST['country_cd'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $joining_date = $_POST['joining_date'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $zone = $_POST['zone'];
    $branch = $_POST['branch'];
    $reporting_manager = $_POST['reporting_manager'];
    $profile_pic = $_POST['profile_pic'];
    $id_proof = $_POST['id_proof'];
    $bank_details = $_POST['bank_details'];
    $register_by = $_POST['userType']; //25
	$userId = $_POST['userId']; // BH250001 taking from reporting manager 
	$status = '2';
	$user_type = '25'; //25
	$designation_name = 'BDM';
    // if($reporting_manager == ''){
    //     $reporting_manager = 'null';
    // }

	//requires to assign user type based on designation
    // if($designation == '1'){
    //     $user_type = '24'; //BCM
    // }else if($designation == '2'){
    //     $user_type = '25'; //BDM
    // }

    // get age of the user
    $birthYear = str_split($birth_date,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    // $title="Business Mentor";
    // $message="Added new Business Mentor by admin";
    // $message2="Added new Business Mentor by admin";
    // $fromWhom="1";

    // set password
    // $string="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
    // $password = substr(str_shuffle($string), 0,8);
    // $status = '1';

    // date_default_timezone_set('Asia/Calcutta');
    // $todayYear = date('Y');
    // $subY=substr($todayYear,2,4);

    // // $sql2= $conn->prepare("SELECT distinct employee_id  from employees order by employee_id desc limit 1");
	// $sql2= $conn->prepare("SELECT distinct employee_id,SUBSTRING(employee_id,3,6) as tc_id from employees where status='1' OR status='3' order by tc_id DESC limit 1");
    // $sql2->execute();
    // $sql2->setFetchMode(PDO::FETCH_ASSOC);
    // if($sql2->rowCount()>0){
    //     foreach (($sql2->fetchAll()) as $key3 => $row3) {
    //         $employee_id = $row3["employee_id"];
    //     } 
    //     if($employee_id ==''){
    //         $uid = 'BH'.$subY.'0001';
    //     }else{
    //         $subV=substr($employee_id,2,4);
    //         if($subV==$subY){
    //             $employee_id++;
    //             $employee_id = str_pad($employee_id, 4, '0', STR_PAD_LEFT);
    //             $uid = $employee_id;
    //         }else{
    //             $employee_id++;
    //             $uid = substr($employee_id,4);
    //             $newValue = 'BH'.$subY.$uid;
    //             $Nemployee_id=str_pad($newValue, 4, '0', STR_PAD_LEFT);
    //             $uid =$Nemployee_id;
    //         }
    //     }
    // }else{
    //     $uid = 'BH'.$subY.'0001';
    // }

    //log file
    $title="Added Employee -".$name.' '.$designation_name ;
    $message= "Employee has been Added";
    $message2= "Employee has been Added By Admin";
    $fromWhom= $register_by;
	$operation = 'Add';

    $sql = "INSERT INTO employees (name, date_of_birth, country_code, contact, email, address, gender, date_of_joining, department, designation, zone, branch, reporting_manager, profile_pic, id_proof, bank_details, register_by, user_type, status) VALUES (:name, :date_of_birth, :country_code, :contact, :email, :address, :gender, :date_of_joining, :department, :designation, :zone, :branch, :reporting_manager, :profile_pic, :id_proof, :bank_details, :register_by, :user_type, :status)"; 
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        // ':employee_id' => $uid,
        ':name' => $name,
        ':date_of_birth' => $birth_date,
        ':country_code' => $country_cd,
        ':contact' => $contact,
        ':email' => $email,
        ':address' => $address,
        ':gender' => $gender,
        ':date_of_joining' => $joining_date,
        ':department' => $department,
        ':designation' => $designation,
        ':zone' => $zone,
        ':branch' => $branch,
        ':reporting_manager' => $reporting_manager,
        ':profile_pic' => $profile_pic,
        ':id_proof' => $id_proof,
        ':bank_details' => $bank_details,
        ':register_by' => $register_by,
        ':user_type' => $user_type,
        ':status' => $status
    ));
   
    if ($result) {
		
		// $sql2= "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
		// $stmt3 =$conn->prepare($sql2);

		// $result2=$stmt3->execute(array(
		// ':uname' => $email, 
		// ':password' => $password, 
		// ':user_id' => $uid, 
		// ':user_type_id' => $user_type, 
		// ':status' => $status
		// ));

		$result2 = 1;

        if($result2){

            $sql3= "INSERT INTO logs ( title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                // ':user_id' => $uid,
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                ':reference_no' => $reporting_manager,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
				':operation' => $operation
            ));

            // if($result3){
				
			// 	//sms
			// 	$apikey = "O1y4qz6QvEirxbrmPubk0g";
			// 	$apisender = "UNIQBI";
			// 	// 	  $msg ="Welcome to Bizzmirth holidays. Your ID is '".$uname."' and your password is '".$password."'";
			// 	$msg ="Welcome to the Uniqbizz. 

			// 		Visit uniqbizz.com
													
			// 		Your ID is : - 
													
			// 		Email ID: - '".$email."'
													
			// 		Password: - '".$password."'
													
			// 		Thank You";
			// 	  $num = $country_cd.$contact; // MULTIPLE NUMBER VARIABLE PUT HERE...!
			// 	  $ms = rawurlencode($msg); //This for encode your message content
			// 	  $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$apikey.'&senderid='.$apisender.'&channel=1&DCS=0&flashsms=0&number='.$num.'&text='.$ms.'&route=1';
			// 	  //echo $url;
			// 	  $ch=curl_init($url);
			// 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// 	  curl_setopt($ch,CURLOPT_POST,1);
			// 	  curl_setopt($ch,CURLOPT_POSTFIELDS,"");
			// 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
			// 	  $data = curl_exec($ch);
			// 	  echo '

			// 	';
				
			// 	//email
			// 	$fromEmail = 'support@uniqbizz.com';
			// 	$toEmail = $email;
			// 	$subjectName = 'Login Details';
			// 	// $to = $toEmail;
			// 	$subject = $subjectName;
			// 	$message3 = '<!DOCTYPE html>
			// 	<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
			// 	<head>
			// 	<meta charset="UTF-8">
			// 	<meta name="viewport" content="width=device-width,initial-scale=1">
			// 	<meta name="x-apple-disable-message-reformatting">
			// 	<title></title>
			// 	<!--[if mso]>
			// 	<noscript>
			// 		<xml>
			// 		<o:OfficeDocumentSettings>
			// 			<o:PixelsPerInch>96</o:PixelsPerInch>
			// 		</o:OfficeDocumentSettings>
			// 		</xml>
			// 	</noscript>
			// 	<![endif]-->
			// 	<style>
			// 		table, td, div, h1, p {font-family: Arial, sans-serif;}
			// 	</style>
			// 	</head>
			// 	<body style="margin:0;padding:0;">
			// 	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
			// 		<tr>
			// 		<td align="center" style="padding:0;">
			// 			<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
			// 			<tr>
			// 				<td style="padding:30px;background:#a5a5a5;">
			// 				<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
			// 					<tr>
			// 					<td style="padding:0;width:50%;" align="left">
			// 						<img src="https://uniqbizz.com/uploading/uniqbizz_logo.png" alt="" width="100" style="height:auto;display:block; position: absolute; top: 37px;" />
			// 						<img src="https://uniqbizz.com/uploading/bizzmirth.png" alt="" width="100" style="height:auto;display:block;" /></p>
			// 					</td>
			// 					<td style="padding:0;width:50%;" align="right">
			// 						<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
			// 						<tr>
			// 						<p style="font-size:14px;line-height:20px;font-family:Arial,sans-serif; color: white;">
			// 							Bizzmirth Holidays<br>
			// 							304-306 3rd floor Dempo Tower Patto Plaza Panjim Goa 403001<br>
			// 							Contact No: 8010892265<br>
			// 							Email ID: support@uniqbizz.com<br>
			// 							URL: uniqbizz.com
			// 						</p>
									
			// 						</tr>
			// 						</table>
			// 					</td>
			// 					</tr>
			// 				</table>
			// 				</td>
			// 			</tr>
			// 			<tr>
			// 				<td style="padding:36px 30px 42px 30px;">
			// 				<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
			// 					<tr>
			// 					<td style="padding:0;">
			// 						<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
			// 						<tr>
										
			// 							<td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
			// 							<td style="width:260px;padding:0;vertical-align:top;color:#153643;">
			// 							<!-- <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/right.gif" alt="" width="260" style="height:auto;display:block;" /></p> -->
			// 							<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear '.$name.'  <br>
			// 							ID: - '.$uid.'<br>
			// 							DOJ: - '.$birth_date.'<br>
			// 							Address: - '.$address.'<br>
			// 							Username: - '.$toEmail.'<br>
			// 							Password: - '.$password.'<br><br>
			// 							<hr><br><br>
			// 							</p>
			// 							<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
			// 								Congratulations on your decision! </p>

			// 								<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; ">
			// 								A journey of a thousand miles must begin with a single step. Id like to welcome you to Bizzmirth Holidays. We are excited that you have accepted our business offer and agreed upon your start date. I trust that this letter finds you mutually excited about your new opportunity with Bizzmirth Holidays.
			// 								<br><br>

			// 								Each of is will play a role to ensure your successful integration into the company. Your agenda will involve planning your orientation with company and setting some intial work goals so that you feel immediately productive in your new role. And to earn money which is optional, your earnings will depend directly in the amount of questions prior to your start date, please call me anytime, or send email if that is more convenient. We look forward to having you come onboard. The secret of success is constancy to purpose.

			// 								</p>
			// 								<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif; color: #a5a5a5;"> 
			// 								Best Regards,<br>
			// 								Bizzmirth Holidays</p>
			// 							</td>
			// 						</tr>
			// 						</table>
			// 					</td>
			// 					</tr>
			// 				</table>
			// 				</td>
			// 			</tr>
			// 			<tr>
			// 				<td style="padding:30px;background:#a5a5a5;">
			// 				<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
			// 					<tr>
			// 					<td style="padding:0;width:50%;" align="left">
			// 						<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
			// 						Bizzmirth Holidays.<br/>
			// 						</p>
			// 					</td>
								
			// 					</tr>
			// 				</table>
			// 				</td>
			// 			</tr>
			// 			</table>
			// 		</td>
			// 		</tr>
			// 	</table>
			// 	</body>
			// 	</html>';
			// 	$mail = new PHPMailer(); 
			// 	$mail->IsSMTP(); 
			// 	$mail->SMTPAuth = true; 
			// 	$mail->SMTPSecure = 'tls'; 
			// 	$mail->Host = "mail.uniqbizz.com";
			// 	$mail->Port = 587; 
			// 	$mail->IsHTML(true);
			// 	$mail->CharSet = 'UTF-8';
			// 	// $mail->SMTPDebug = 2; 
			// 	$mail->Username = "support@uniqbizz.com";
			// 	$mail->Password = "support@uniqbizz";
			// 	$mail->SetFrom("support@uniqbizz.com");
			// 	$mail->Subject = $subject;
			// 	$mail->Body =$message3;
			// 	$mail->AddAddress($toEmail);
			// 	$mail->SMTPOptions=array('ssl'=>array(
			// 		'verify_peer'=>false,
			// 		'verify_peer_name'=>false,
			// 		'allow_self_signed'=>false
			// 	));
			// 	if(!$mail->Send()){
			// 		echo $mail->ErrorInfo;
			// 	}else{
			// 		echo 1;
			// 	}
			// }else{  //email
			// 	echo 0	;
			// }
			echo 1;
        }else{
            echo 0	;
        }
        
    }else{
        echo 0	;
    }

?>