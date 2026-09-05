<?php
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php'); // phpmailer smtp 
include('../assets/submit/mail_trap_cred.php');

date_default_timezone_set('Asia/Calcutta'); //set default timeZone
$todayYear = date('Y'); // year for Custom Id genaration
$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

$id = $_POST["id"];
$uname = $_POST["email"];
$usertype = $_POST['usertype'];
$remark = $_POST['remark']; // for user_logs table

$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0, 8);
$status = '1';
$user_type_id = '36';
$register_by = '1';

$subY = substr($todayYear, 2, 4);
if ($user_type_id == '36') { //Chief Techno Enterprise
	$sql9 = $conn->prepare("SELECT * from chief_techno_enterprise where id='" . $id . "' and status='2'");
	$sql9->execute();
	$sql9->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql9->rowCount() > 0) {
		foreach (($sql9->fetchAll()) as $key9 => $row9) {
			$registerDate = new DateTime($row9['added_on']);
			$doj = $registerDate->format('d/m/Y');
			$name = $row9['firstname'] . ' ' . $row9['lastname'];
			$address = $row9['address'];
			$country_code = $row9['country_code'];
			$contact_no = $row9['contact_no'];
			// $reference_no = $row9['reference_no'];
			$application_id = $row9['application_id'];
		}
	}

	// Fetch the highest numeric part from all master_franchisee_id, ignoring prefix
	$sql2 = $conn->prepare("
		SELECT chief_techno_enterprise_id,
			CAST(RIGHT(chief_techno_enterprise_id, 5) AS UNSIGNED) AS numeric_part
		FROM chief_techno_enterprise
		WHERE status = '1' OR status = '3'
		ORDER BY numeric_part DESC
		LIMIT 1
	");
	$sql2->execute();
	$sql2->setFetchMode(PDO::FETCH_ASSOC);

	// Get short name from states - no state sufix requires 12-05-2026
	// $sql3 = $conn->prepare("SELECT short_name FROM `states` WHERE id = :state_id");
	// $sql3->bindParam(':state_id', $state, PDO::PARAM_INT);
	// $sql3->execute();
	// $shortName = '';
	// if ($row = $sql3->fetch()) {
	// 	$shortName = $row['short_name']; // e.g., MP, GA, KA
	// }

	// Year suffix (last 2 digits of year)
	$subY = date('y'); // e.g., 25 for 2025

	// Generate the next numeric part
	if ($row2 = $sql2->fetch()) {
		$lastNumber = (int)$row2['numeric_part']; // e.g., 3
		$nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT); // 00004
	} else {
		$nextNumber = '00001';
	}

	// Final UID
	// $uid = 'SF' . $shortName . $subY . $nextNumber;
	$uid = 'CTE' . $subY . $nextNumber;

	// check if user/application id present in verified table. if no their then pass message in table as "Admin confirm user without verifing fields"
	$sqlGetVerifiedUser = $conn->prepare("
		SELECT *
		FROM user_verification
		WHERE application_id = :application_id
		ORDER BY id DESC
		LIMIT 1
	");
	$sqlGetVerifiedUser->execute([
		':application_id' => $application_id
	]);
	$latestVerification = $sqlGetVerifiedUser->fetch(PDO::FETCH_ASSOC);
	if ($latestVerification) {
		// Latest record exists
		$isVerified = true;
		// $status = $latestVerification['status'];
		// $rejection_reason = $latestVerification['rejection_reason'];
		$message = $uid ." ". $name ." has been approved";
	} else {
		// No verification record found
		$isVerified = false;
		$message = "Admin confirm Chief Techno Enterprise ". $uid. " ".$name." without verifying fields";
	}

	//log file
	$title = "Confirm Chief Techno Enterprise";
	// $message = $uid . " has been approved";
	$message2 = $uid . " has been approved";
	$fromWhom = "1";
	$operation = "Confirm";

	$sql1 = "UPDATE chief_techno_enterprise SET status=:status,chief_techno_enterprise_id=:chief_techno_enterprise_id,register_date=:register_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$resultSte =  $stmt->execute(array(
		':status' => $status,
		':chief_techno_enterprise_id' => $uid,
		':register_date' => $register_Date,
		// ':deleted_date' => $today,
		':id' => $id
	));

	if($resultSte){
		// enter Chief Techno Enterprise uniq id in all tables mentioned below
		$tables = [
			'professional_and_educational',
			'leadership_assessment',
			'nominee_details',
			'bank_details',
			'documents'
		];

		foreach($tables as $table){

			$sql = "UPDATE `$table`
					SET user_id = :user_id
					WHERE application_id = :application_id";

			$stmtTable = $conn->prepare($sql);

			$resultAllTables = $stmtTable->execute([
				':user_id' => $uid,
				':application_id' => $application_id
			]);
		}

	}

	if ($resultAllTables) {
		$sql = "INSERT INTO login (username,password, user_id, user_type_id , status) VALUES (:uname ,:password, :user_id, :user_type_id, :status)";
		$stmt3 = $conn->prepare($sql);
		$result2 = $stmt3->execute(array(
			':uname' => $uname,
			':password' => $password,
			':user_id' => $uid,
			':user_type_id' => $user_type_id,
			':status' => $status
		));

		if ($result2) {
			$sql4 = "INSERT INTO logs (user_id,title,message,message2, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :register_by, :from_whom, :operation)";
			$stmt4 = $conn->prepare($sql4);
			$result3 = $stmt4->execute(array(
				':user_id' => $uid,
				':title' => $title,
				':message' => $message,
				':message2' => $message2,
				':register_by' => $register_by,
				':from_whom' => $fromWhom,
				':operation' => $operation
			));

			$sqlUserLogs= "INSERT INTO user_logs (application_id, title, message, reference_no, operation, from_whom) VALUES (:application_id, :title ,:message, :reference_no, :operation, :from_whom)";
			$stmtUserlogs =$conn->prepare($sqlUserLogs);
			$stmtUserlogs->execute(array(
				':application_id' => $application_id,
				':title' => $title,
				':message' => $message . ' . ' . $remark,
				':reference_no' => $register_by,
				':operation' => $operation,
				':from_whom' => $fromWhom
			));

			$userVerification= "INSERT INTO user_verification (application_id, approved_reason,payload, verified_by, status) VALUES (:application_id, :approved_reason, :payload, :verified_by, :status)";
			$stmtUserVerification =$conn->prepare($userVerification);
			$stmtUserVerification->execute(array(
				':application_id' => $application_id,
				':approved_reason' => $message,
				':payload' => '{}',
				':verified_by' => $register_by,
				':status' => $status
			));

			if ($result3) {

				// if ($reference_no == "Not Applicable") {

				// 	$bdmCommiAmt = 0;

				// 	$message = "BDM - Not Applicable earned 0/- on recruting Business Mentor. Name of the Business Mentor - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";

				// 	$id = "Not Applicable";
				// 	$CommiAmt = $bdmCommiAmt;

				// 	$insertCALSql = "INSERT INTO `bm_recruitment_payout` (bdm_id, message, comm_amt, business_mentor, status) VALUES (:bdm_id, :message, :comm_amt, :business_mentor, :status) ";
				// 	$insertCAL = $conn->prepare($insertCALSql);
				// 	$result4 = $insertCAL->execute(array(
				// 		':bdm_id' => $id,
				// 		':message' => $message,
				// 		':comm_amt' => $CommiAmt,
				// 		':business_mentor' => $uid,
				// 		':status' => '2'
				// 	));
				// } else {
				// 	$bdmCommiAmt = 2000;

				// 	$message = "BDM - " . $bdm_name . " " . $bdm_id . " earned " . $bdmCommiAmt . "/- on recruting Business Mentor. Name of the Business Mentor - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";

				// 	$id = $bdm_id;
				// 	$CommiAmt = $bdmCommiAmt;

				// 	$insertCALSql = "INSERT INTO `bm_recruitment_payout` (bdm_id, message, comm_amt, business_mentor, status) VALUES (:bdm_id, :message, :comm_amt, :business_mentor, :status) ";
				// 	$insertCAL = $conn->prepare($insertCALSql);
				// 	$result4 = $insertCAL->execute(array(
				// 		':bdm_id' => $id,
				// 		':message' => $message,
				// 		':comm_amt' => $CommiAmt,
				// 		':business_mentor' => $uid,
				// 		':status' => '2'
				// 	));
				// }

				$result4 = 'true';

				if ($result4) {

					//sms
					$apikey = "O1y4qz6QvEirxbrmPubk0g";
					$apisender = "UNIQBI";
					// 	  $msg ="Welcome to Bizzmirth holidays. Your ID is '".$uname."' and your password is '".$password."'";
					$msg = "Welcome to the Uniqbizz. 
	
							Visit uniqbizz.com
															
							Your ID is : - 
															
							Email ID: - '" . $uname . "'
															
							Password: - '" . $password . "'
															
							Thank You";
					$num = $country_code . $contact_no; // MULTIPLE NUMBER VARIABLE PUT HERE...!
					$ms = rawurlencode($msg); //This for encode your message content
					$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=' . $apikey . '&senderid=' . $apisender . '&channel=1&DCS=0&flashsms=0&number=' . $num . '&text=' . $ms . '&route=1';
					//echo $url;
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
					$data = curl_exec($ch);
					echo '
	
						';

					//email
					$fromEmail = 'support@uniqbizz.com';
					$to = $uname; //$uname contains email of user which is now registering 
					$subject = 'Login Credentials - Bizzmirth Holidays Pvt ltd';
					$userTypeName = 'Chief Techno Enterprise';
                   
					// html design for registration email 
                    include('../assets/submit/registration_email.php');
					
					// php mailer structure
                    include('../assets/submit/php_mailer_structure.php');

				} else {  //email
					echo 0;
				}
			} else { //payout for bdm on bm recruitment 
				echo 0;
			}
		} else { //logs
			echo 0;
		}
	} else { //login
		echo 0;
	}
} 
