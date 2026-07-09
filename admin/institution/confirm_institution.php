<?php
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

date_default_timezone_set('Asia/Calcutta'); //set default timeZone
$todayYear = date('Y'); // year for Custom Id genaration
$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

$id = $_POST["id"];
$uname = $_POST["uname"];
$utype = $_POST["usertype"]; //add to handle franchisee logic

$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0, 8);
$status = '1';
$user_type_id = $utype == 'te' ? '16' : ($utype == 'sf' ? '29' : ($utype == 'in'?'32':''));

$register_by = '1';

date_default_timezone_set('Asia/Calcutta');
$todayYear = date('Y');

$subY = substr($todayYear, 2, 4);
if ($user_type_id == '32') { //institution
	$sql9 = $conn->prepare("SELECT * from institution where id='" . $id . "' and status='2'");
	$sql9->execute();
	$sql9->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql9->rowCount() > 0) {
		foreach (($sql9->fetchAll()) as $key9 => $row9) {

			$registerDate = new DateTime($row9['added_on']);
			$doj = $registerDate->format('d/m/Y');
			$name = $row9['name'];
			$address = $row9['address'];
			$country_code = $row9['country_code'];
			$contact_no = $row9['contact_no'];
			$reference_no = $row9['reference_no'];
			$registrant = $row9['registrant'];
			$amount = $row9['amount'];
			$state = $row9['state'];
		}
	}
	//reference
	$reference_id = substr($reference_no, 0, 2);
	//added on 15-10-2025 by SV
	$bdm_id='';
	$bdm_name='';
	$bdm_user_type='25';
	//--------------------------
	//Master Franchisee edidted on 15-10-2025 by SV
	if ($reference_id == 'MF') {
		//master franchisee
		$sql10 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '" . $reference_no . "'");
		$sql10->execute();
		$sql10->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql10->rowCount() > 0) {
			foreach (($sql10->fetchAll()) as $key10 => $row10) {
				$Sf_id = $row10['master_franchisee_id'];
				$Sf_name = $row10['firstname'] . ' ' . $row10['lastname'];
				$bdm_id = $row10['reference_no'];
				$bdm_name = $row10['registrant'];
				// $Sf_ref = $row10['reference_no']; No ref for MF since ZM removed 26-07-2025
			}
		}
		//zonal manager removed from system, 26-07-2025
		// $sql11 = $conn->prepare("SELECT * FROM zonal_manager WHERE zonal_manager_id = '" . $Sf_ref . "'");
		// $sql11->execute();
		// $sql11->setFetchMode(PDO::FETCH_ASSOC);
		// if ($sql11->rowCount() > 0) {
		// 	foreach (($sql11->fetchAll()) as $key11 => $row11) {
		// 		$Mf_id = $row11['zonal_manager_id'];
		// 		$Mf_name = $row11['name'];
		// 	}
		// }
	}
	//----------------------------------------------
	//sponsor Franchisee edited on 15-10-2025 by SV
	if ($reference_id == 'SF') {

		$sql11 = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '" . $reference_no . "'");
		$sql11->execute();
		$sql11->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql11->rowCount() > 0) {
			foreach (($sql11->fetchAll()) as $key11 => $row11) {
				$Sf_id = $row11['sponsor_franchisee_id'];
				$Sf_name = $row11['firstname'] .' '. $row11['lastname'] ;
				$bdm_id = $row11['reference_no'];
				$bdm_name = $row11['registrant'];
			}
		}
	}
	//---------------------------------------------------
	//Business Mentor edited on 11-04-2026 by PN
	if ($reference_id == 'BM') {

		$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '" . $reference_no . "'");
		$sql11->execute();
		$sql11->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql11->rowCount() > 0) {
			foreach (($sql11->fetchAll()) as $key11 => $row11) {
				$Sf_id = $row11['business_mentor_id'];
				$Sf_name = $row11['firstname'] .' '. $row11['lastname'] ;
				$bdm_id = $row11['reference_no'];
				$bdm_name = $row11['registrant'];
			}
		}
	}
	//Zonal Manager removed from system 26-07-2025
	// if ($reference_id == 'ZM') {

	// 	$sql11 = $conn->prepare("SELECT * FROM zonal_manager WHERE zonal_manager_id = '" . $reference_no . "'");
	// 	$sql11->execute();
	// 	$sql11->setFetchMode(PDO::FETCH_ASSOC);
	// 	if ($sql11->rowCount() > 0) {
	// 		foreach (($sql11->fetchAll()) as $key11 => $row11) {
	// 			$Zm_id = $row11['zonal_manager_id'];
	// 			$Zm_name = $row11['name'];
	// 		}
	// 	}
	// }

	//BDM/BCM/RM added on 15-10-2025 by SV
	if ($reference_id == 'BH') {

		$sql11 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $reference_no . "'");
		$sql11->execute();
		$sql11->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql11->rowCount() > 0) {
			foreach (($sql11->fetchAll()) as $key11 => $row11) {
				$bdm_id = $row11['employee_id'];
				$bdm_name = $row11['name'];
				$bdm_user_type = $row11['user_type']; //25/24/31 ->BDM/BCM/RM
			}
		}
	}
	//-----------------------------------------
	if ($amount == "500000") {
		$business_package = "premium";
	}
	// Fetch the highest numeric part from all institution_id, ignoring prefix
	$sql2 = $conn->prepare("
		SELECT institution_id,
			CAST(RIGHT(institution_id, 5) AS UNSIGNED) AS numeric_part
		FROM institution
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
	$sql3->setFetchMode(PDO::FETCH_ASSOC);

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

	// Final UID for sub franchisee
	$uid = 'I' . $shortName . $subY . $nextNumber;

	// log for Franchisee
	$title = "Institution";
	$message = $uid . " has been approved";
	$message2 = $uid . " has been approved";
	$fromWhom = "1";
	$operation = "Confirm";

	$sql1 = "UPDATE institution SET status=:status,institution_id=:institution_id, register_date=:register_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result =  $stmt->execute(array(
		':status' => $status,
		':institution_id' => $uid,
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
			$sql4 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
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
			//payouts
			// Determine who referred and calculate commissions

			$ref_manager = $bdm_id == 'Not Applicable'?'NA':$bdm_id;
			$message_ref = 'Not Applicable';
			$refCommiAmt = '0';
			$master_franchisee = '';
			$message_mf = '';
			$mfCommiAmt = '0';
			
			if($amount == "FOC"){
				// Master Franchisee Referral edidted on 15-10-2025 by SV
				if (strpos($reference_no, 'MF') === 0) {
					$master_franchisee = $reference_no;

					// Fetch MF ref and name
					$stmt = $conn->prepare("SELECT reference_no, firstname, lastname FROM master_franchisee WHERE master_franchisee_id = :ref");
					$stmt->execute([':ref' => $reference_no]);
					$row = $stmt->fetch(PDO::FETCH_ASSOC);

					if ($row) {
						$mf_name = $row['firstname'] . ' ' . $row['lastname'];
						
						$message_mf = "Master Franchisee(MF) $mf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
						$message_sf="$name ($uid) was on-boarded via $mf_name ($master_franchisee) as a Franchisee and paid Rs $amount /-";

						if (!empty($row['reference_no']) && ($row['reference_no']) !== 'Not Applicable' && ($row['reference_no']) !== 'NA') {
							$ref_manager = $row['reference_no'];

							// Get ref name
							$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
							$stmt2->execute([':employee_id' => $ref_manager]);
							$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
							
							$ref_name = $ref ? $ref['name'] : '';
							$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
							$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid) via $mf_name ($master_franchisee)";
						}
					}
				}
				//-------------------------------------------------------
				// BM Referral edited on 18-04-2026 by PN
				elseif (strpos($reference_no, 'BM') === 0) {
					$master_franchisee = $reference_no;

					// Get SF name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM business_mentor WHERE business_mentor_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					 //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Business Mentor(BM) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Institution and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						
						$ref_name = $ref ? $ref['name'] : '';
						$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid) via $sf_name ($master_franchisee)";
					}
				}
				// SF Referral edited on 15-10-2025 by SV
				elseif (strpos($reference_no, 'SF') === 0) {
					$master_franchisee = $reference_no;

					// Get SF name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM sponsor_franchisee WHERE sponsor_franchisee_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					 //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Sponsor Franchisee(SF) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Franchisee and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						
						$ref_name = $ref ? $ref['name'] : '';
						$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid) via $sf_name ($master_franchisee)";
					}
				}
				//----------------------------------------
				// Direct BDM/BCM/RM Referral add on 15-10-2025 by SV
				elseif (strpos($reference_no, 'BH') === 0) {
					$ref_manager = $reference_no;

					// Get BDM/BCM/RM name
					$stmt = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :ref_id");
					$stmt->execute([':ref_id' => $ref_manager]);
					$ref = $stmt->fetch(PDO::FETCH_ASSOC);
					$refCommiAmt = $amount * 0.05; //25000
					$ref_name = $ref ? $ref['name'] : '';
					$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
					$message_ref = "Direct $ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on on registering Franchisee. Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
					$message_mf = '';
					$mfCommiAmt = 0;
					$message_sf="$name ($uid) was on-boarded via $ref_name ($ref_manager) as a Franchisee and paid Rs $amount /-"; // check veriable name
				}
			}else{
				// Master Franchisee Referral edidted on 15-10-2025 by SV
				if (strpos($reference_no, 'MF') === 0) {
					$master_franchisee = $reference_no;

					// Fetch MF ref and name
					$stmt = $conn->prepare("SELECT reference_no, firstname, lastname FROM master_franchisee WHERE master_franchisee_id = :ref");
					$stmt->execute([':ref' => $reference_no]);
					$row = $stmt->fetch(PDO::FETCH_ASSOC);

					if ($row) {
						$mf_name = $row['firstname'] . ' ' . $row['lastname'];
						$mfCommiAmt = $amount * 0.05;
						$message_mf = "Master Franchisee(MF) $mf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
						$message_sf="$name ($uid) was on-boarded via $mf_name ($master_franchisee) as a Franchisee and paid Rs $amount /-";

						if (!empty($row['reference_no']) && ($row['reference_no']) !== 'Not Applicable' && ($row['reference_no']) !== 'NA') {
							$ref_manager = $row['reference_no'];

							// Get ref name
							$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
							$stmt2->execute([':employee_id' => $ref_manager]);
							$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
							$refCommiAmt = $amount * 0.025; //12500
							$ref_name = $ref ? $ref['name'] : '';
							$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
							$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid) via $mf_name ($master_franchisee)";
						}
					}
				}
				//-------------------------------------------------------
				// BM Referral edited on 18-04-2026 by PN
				elseif (strpos($reference_no, 'BM') === 0) {
					$master_franchisee = $reference_no;

					// Get SF name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM business_mentor WHERE business_mentor_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					$mfCommiAmt = $amount * 0.05; //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Business Mentor(BM) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Institution and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						$refCommiAmt = $amount * 0.025; //12500
						$ref_name = $ref ? $ref['name'] : '';
						$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid) via $sf_name ($master_franchisee)";
					}
				}
				// SF Referral edited on 15-10-2025 by SV
				elseif (strpos($reference_no, 'SF') === 0) {
					$master_franchisee = $reference_no;

					// Get SF name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM sponsor_franchisee WHERE sponsor_franchisee_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					$mfCommiAmt = $amount * 0.05; //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Sponsor Franchisee(SF) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Franchisee and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						$refCommiAmt = $amount * 0.025; //12500
						$ref_name = $ref ? $ref['name'] : '';
						$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "$ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Franchisee.Franchisee Name - $name (ID:$uid) via $sf_name ($master_franchisee)";
					}
				}
				//----------------------------------------
				// Direct BDM/BCM/RM Referral add on 15-10-2025 by SV
				elseif (strpos($reference_no, 'BH') === 0) {
					$ref_manager = $reference_no;

					// Get BDM/BCM/RM name
					$stmt = $conn->prepare("SELECT name,user_type FROM employees WHERE employee_id = :ref_id");
					$stmt->execute([':ref_id' => $ref_manager]);
					$ref = $stmt->fetch(PDO::FETCH_ASSOC);
					$refCommiAmt = $amount * 0.05; //25000
					$ref_name = $ref ? $ref['name'] : '';
					$ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
					$message_ref = "Direct $ref_designation-$ref_name ($ref_manager) earned Rs $refCommiAmt/- on on registering Franchisee. Franchisee Name - $name (ID:$uid). Franchisee Amount: Rs $amount /-";
					$message_mf = '';
					$mfCommiAmt = 0;
					$message_sf="$name ($uid) was on-boarded via $ref_name ($ref_manager) as a Franchisee and paid Rs $amount /-"; // check veriable name
				}
			}
			//----------------------------------------------------
			// Insert into payout table
			$sql = "INSERT INTO `institution_payout` (
						`employees`, `message_emp`, `commission_emp`, `status_emp`,
						`bm_mf_sf`, `message_bm_mf_sf`, `commission_bm_mf_sf`, `status_bm_mf_sf`,
						`institution`, `message_institution`, `institution_amt_paid`, `status_institution`, `status`
					) VALUES (
						:employees, :message_emp, :commission_emp, '2',
						:bm_mf_sf, :message_bm_mf_sf, :commission_bm_mf_sf, '2',
						:institution, :message_institution, :institution_amt_paid, '2', '2'
					)";

			$stmt = $conn->prepare($sql);
			$inserted = $stmt->execute([
				':employees' => $ref_manager,
				':message_emp' => $message_ref,
				':commission_emp' => $refCommiAmt,
				':bm_mf_sf' => $master_franchisee,
				':message_bm_mf_sf' => $message_mf,
				':commission_bm_mf_sf' => $mfCommiAmt,
				':institution' => $uid,
				':message_institution' => $message_sf,
				':institution_amt_paid' => $amount
			]);


			$result5 = 1;
			if ($result5) {
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
												<p style="margin:0 0 12px 0;font-size:16px;font-family:Arial,sans-serif;">Dear ' . $name . '  <br>
												ID: - ' . $uid . '<br>
												DOJ: - ' . $doj . '<br>
												Address: - ' . $address . '<br>
												Username: - ' . $toEmail . '<br>
												Password: - ' . $password . '<br><br>
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
				$mail->Password = "NCaB6f^jkm^~";
				$mail->SetFrom("support@uniqbizz.com");
				$mail->Subject = $subject;
				$mail->Body =$message3;
				$mail->AddAddress($to);
				$mail->SMTPOptions=array('ssl'=>array(
					'verify_peer'=>false,
					'verify_peer_name'=>false,
					'allow_self_signed'=>false
				));
				if (!$mail->Send()) {
					echo $mail->ErrorInfo;
				} else {
					echo 1;
				}
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}
}
