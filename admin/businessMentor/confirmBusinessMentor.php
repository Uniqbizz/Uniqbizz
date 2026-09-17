<?php
	require "../connect.php";
	include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php'); // phpmailer smtp 
	include('../assets/submit/mail_trap_cred.php'); //mailtrap cred

	date_default_timezone_set('Asia/Calcutta'); //set default timeZone
	$todayYear = date('Y'); // year for Custom Id genaration
	$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

	$id = $_POST["id"];
	$uname = $_POST["uname"];
	$usertype = $_POST['usertype'];

	$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
	$password = substr(str_shuffle($string), 0, 8);
	$status = '1';
	$user_type_id = $usertype == 'bm' ? '26' : 
					($usertype == 'mf' ? '28' : 	
					($usertype == 'sf' ? '30' :
					($usertype == 'ete' ? '34' : '')));
	$register_by = '1';

	$subY = substr($todayYear, 2, 4);
	if ($user_type_id == '26') { //Business Mentor
		$sql9 = $conn->prepare("SELECT * from business_mentor where id='" . $id . "' and status='2'");
		$sql9->execute();
		$sql9->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql9->rowCount() > 0) {
			foreach (($sql9->fetchAll()) as $key9 => $row9) {
				$registerDate = new DateTime($row9['register_date']);
				$doj = $registerDate->format('d/m/Y');
				$name = $row9['firstname'] . ' ' . $row9['lastname'];
				$address = $row9['address'];
				$country_code = $row9['country_code'];
				$contact_no = $row9['contact_no'];
				$reference_no = $row9['reference_no'];
				$amount = $row9['paid_amount'];
			}
		}

		$sql10 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $reference_no . "' AND user_type = '25' AND status = '1' ");
		$sql10->execute();
		$sql10->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql10->rowCount() > 0) {
			foreach (($sql10->fetchAll()) as $key10 => $row10) {
				$bdm_id = $row10['employee_id'];
				$bdm_name = $row10['name'];
				$bdm_ref = $row10['reporting_manager'];
			}
		}

		// made changes in query to get id in order SFA230043 TC230010
		$sql2 = $conn->prepare("SELECT distinct business_mentor_id,SUBSTRING(business_mentor_id,3,6) as tc_id from business_mentor where status='1' OR status='3' order by tc_id DESC limit 1");

		$sql2->execute();
		$sql2->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql2->rowCount() > 0) {
			foreach (($sql2->fetchAll()) as $key3 => $row3) {
				$business_mentor_id = $row3["business_mentor_id"];
			}
			if ($business_mentor_id == '') {
				$uid = 'BM' . $subY . '0001';
			} else {
				$subV = substr($business_mentor_id, 2, 4);
				if ($subV == $subY) {
					$business_mentor_id++;
					$business_mentor_id = str_pad($business_mentor_id, 4, '0', STR_PAD_LEFT);
					$uid = $business_mentor_id;
				} else {
					$business_mentor_id++;
					$fid = substr($business_mentor_id, 4);
					$newValue = 'BM' . $subY . $fid;
					$Nbusiness_mentor_id = str_pad($newValue, 4, '0', STR_PAD_LEFT);
					$uid = $Nbusiness_mentor_id;
				}
			}
		} else {
			$uid = 'BM' . $subY . '0001';
		}

		//log file
		$title = "Confirm Business Mentor";
		$message = $uid . " has been approved";
		$message2 = $uid . " has been approved";
		$fromWhom = "1";
		$operation = "Confirm";

		$sql1 = "UPDATE business_mentor SET status=:status,business_mentor_id=:business_mentor_id,register_date=:register_date WHERE id=:id";
		$stmt = $conn->prepare($sql1);
		$result =  $stmt->execute(array(
			':status' => $status,
			':business_mentor_id' => $uid,
			':register_date' => $register_Date,
			// ':deleted_date' => $today,
			':id' => $id
		));

		if ($result) {
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
				$sql4 = "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
				$stmt4 = $conn->prepare($sql4);
				$result3 = $stmt4->execute(array(
					':user_id' => $uid,
					':title' => $title,
					':message' => $message,
					':message2' => $message2,
					':reference_no' => $reference_no,
					':register_by' => $register_by,
					':from_whom' => $fromWhom,
					':operation' => $operation
				));

				if ($result3) {

					if ($reference_no == "Not Applicable") {

						$bdmCommiAmt = 0;

						$message = "BDM - Not Applicable earned 0/- on recruting Business Mentor. Name of the Business Mentor - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";

						$id = "Not Applicable";
						$CommiAmt = $bdmCommiAmt;

						$insertCALSql = "INSERT INTO `bm_recruitment_payout` (bdm_id, message, comm_amt, business_mentor, status) VALUES (:bdm_id, :message, :comm_amt, :business_mentor, :status) ";
						$insertCAL = $conn->prepare($insertCALSql);
						$result4 = $insertCAL->execute(array(
							':bdm_id' => $id,
							':message' => $message,
							':comm_amt' => $CommiAmt,
							':business_mentor' => $uid,
							':status' => '2'
						));
					} else {
						$bdmCommiAmt = 2000;

						$message = "BDM - " . $bdm_name . " " . $bdm_id . " earned " . $bdmCommiAmt . "/- on recruting Business Mentor. Name of the Business Mentor - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";

						$id = $bdm_id;
						$CommiAmt = $bdmCommiAmt;

						$insertCALSql = "INSERT INTO `bm_recruitment_payout` (bdm_id, message, comm_amt, business_mentor, status) VALUES (:bdm_id, :message, :comm_amt, :business_mentor, :status) ";
						$insertCAL = $conn->prepare($insertCALSql);
						$result4 = $insertCAL->execute(array(
							':bdm_id' => $id,
							':message' => $message,
							':comm_amt' => $CommiAmt,
							':business_mentor' => $uid,
							':status' => '2'
						));
					}

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
						$userTypeName = 'Business Mentor';
					
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
	} else if ($user_type_id == '28') { //Master Franchisee
		$sql9 = $conn->prepare("SELECT * from master_franchisee where id='" . $id . "' and status='2'");
		$sql9->execute();
		$sql9->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql9->rowCount() > 0) {
			foreach (($sql9->fetchAll()) as $key9 => $row9) {
				$registerDate = new DateTime($row9['register_date']);
				$doj = $registerDate->format('d/m/Y');
				$name = $row9['firstname'] . ' ' . $row9['lastname'];
				$address = $row9['address'];
				$country_code = $row9['country_code'];
				$contact_no = $row9['contact_no'];
				$reference_no = $row9['reference_no'];
				$amount = $row9['paid_amount'];
				$state = $row9['state'];
			}
		}

		$sql10 = $conn->prepare("SELECT * FROM zonal_manager WHERE zonal_manager_id = '" . $reference_no . "' AND status = '1' ");
		$sql10->execute();
		$sql10->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql10->rowCount() > 0) {
			foreach (($sql10->fetchAll()) as $key10 => $row10) {
				$bdm_id = $row10['zonal_manager_id'];
				$bdm_name = $row10['name'];
				//$bdm_ref = $row10['reporting_manager'];
			}
		}

		// Fetch the highest numeric part from all master_franchisee_id, ignoring prefix
		$sql2 = $conn->prepare("
			SELECT master_franchisee_id,
				CAST(RIGHT(master_franchisee_id, 5) AS UNSIGNED) AS numeric_part
			FROM master_franchisee
			WHERE status = '1' OR status = '3'
			ORDER BY numeric_part DESC
			LIMIT 1
		");
		$sql2->execute();
		$sql2->setFetchMode(PDO::FETCH_ASSOC);

		// Get short name from states
		$sql3 = $conn->prepare("SELECT short_name FROM `states` WHERE id = :state_id");
		$sql3->bindParam(':state_id', $state, PDO::PARAM_INT);
		$sql3->execute();
		$shortName = '';
		if ($row = $sql3->fetch()) {
			$shortName = $row['short_name']; // e.g., MP, GA, KA
		}

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
		$uid = 'MF' . $shortName . $subY . $nextNumber;



		//log file
		$title = "Confirm Master Franchisee";
		$message = $uid . " has been approved";
		$message2 = $uid . " has been approved";
		$fromWhom = "1";
		$operation = "Confirm";

		$sql1 = "UPDATE master_franchisee SET status=:status, master_franchisee_id=:master_franchisee_id, register_date=:register_date WHERE id=:id";
		$stmt = $conn->prepare($sql1);
		$result = $stmt->execute(array(
			':status' => $status,
			':master_franchisee_id' => $uid, 
			':register_date' => $register_Date,
			':id' => $id
		));


		if ($result) {
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
				$sql4 = "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
				$stmt4 = $conn->prepare($sql4);
				$result3 = $stmt4->execute(array(
					':user_id' => $uid,
					':title' => $title,
					':message' => $message,
					':message2' => $message2,
					':reference_no' => $reference_no,
					':register_by' => $register_by,
					':from_whom' => $fromWhom,
					':operation' => $operation
				));

				if ($result3) {

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
					$userTypeName = 'Master Franchisee';
					
					// html design for registration email 
					include('../assets/submit/registration_email.php');
					
					// php mailer structure
					include('../assets/submit/php_mailer_structure.php');

				} else { //email
					echo 0;
				}
			} else { //logs
				echo 0;
			}
		} else { //login
			echo 0;
		}
	} else if ($user_type_id == '30') { //Sponsor Franchisee
		$sql9 = $conn->prepare("SELECT * from sponsor_franchisee where id='" . $id . "' and status='2'");
		$sql9->execute();
		$sql9->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql9->rowCount() > 0) {
			foreach (($sql9->fetchAll()) as $key9 => $row9) {
				$registerDate = new DateTime($row9['register_date']);
				$doj = $registerDate->format('d/m/Y');
				$name = $row9['firstname'] . ' ' . $row9['lastname'];
				$address = $row9['address'];
				$country_code = $row9['country_code'];
				$contact_no = $row9['contact_no'];
				$reference_no = $row9['reference_no'];
				$amount = $row9['paid_amount'];
				$state = $row9['state'];
			}
		}

		// $sql10 = $conn->prepare("SELECT * FROM zonal_manager WHERE zonal_manager_id = '" . $reference_no . "' AND status = '1' ");
		// $sql10->execute();
		// $sql10->setFetchMode(PDO::FETCH_ASSOC);
		// if ($sql10->rowCount() > 0) {
		// 	foreach (($sql10->fetchAll()) as $key10 => $row10) {
		// 		$bdm_id = $row10['zonal_manager_id'];
		// 		$bdm_name = $row10['name'];
		// 		//$bdm_ref = $row10['reporting_manager'];
		// 	}
		// }

		// Fetch the highest numeric part from all master_franchisee_id, ignoring prefix
		$sql2 = $conn->prepare("
			SELECT sponsor_franchisee_id,
				CAST(RIGHT(sponsor_franchisee_id, 5) AS UNSIGNED) AS numeric_part
			FROM sponsor_franchisee
			WHERE status = '1' OR status = '3'
			ORDER BY numeric_part DESC
			LIMIT 1
		");
		$sql2->execute();
		$sql2->setFetchMode(PDO::FETCH_ASSOC);

		// Get short name from states
		$sql3 = $conn->prepare("SELECT short_name FROM `states` WHERE id = :state_id");
		$sql3->bindParam(':state_id', $state, PDO::PARAM_INT);
		$sql3->execute();
		$shortName = '';
		if ($row = $sql3->fetch()) {
			$shortName = $row['short_name']; // e.g., MP, GA, KA
		}

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
		$uid = 'SF' . $shortName . $subY . $nextNumber;



		//log file
		$title = "Confirm Sponsor Franchisee";
		$message = $uid . " has been approved";
		$message2 = $uid . " has been approved";
		$fromWhom = "1";
		$operation = "Confirm";

		$sql1 = "UPDATE sponsor_franchisee SET status=:status, sponsor_franchisee_id=:sponsor_franchisee_id, register_date=:register_date WHERE id=:id";
		$stmt = $conn->prepare($sql1);
		$result = $stmt->execute(array(
			':status' => $status,
			':sponsor_franchisee_id' => $uid, 
			':register_date' => $register_Date,
			':id' => $id
		));


		if ($result) {
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
				$sql4 = "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
				$stmt4 = $conn->prepare($sql4);
				$result3 = $stmt4->execute(array(
					':user_id' => $uid,
					':title' => $title,
					':message' => $message,
					':message2' => $message2,
					':reference_no' => $reference_no,
					':register_by' => $register_by,
					':from_whom' => $fromWhom,
					':operation' => $operation
				));

				if ($result3) {

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
					$userTypeName = 'Sponsor Franchisee';
					
					// html design for registration email 
					include('../assets/submit/registration_email.php');
					
					// php mailer structure
					include('../assets/submit/php_mailer_structure.php');

				} else { //email
					echo 0;
				}
			} else { //logs
				echo 0;
			}
		} else { //login
			echo 0;
		}
	} 
?>