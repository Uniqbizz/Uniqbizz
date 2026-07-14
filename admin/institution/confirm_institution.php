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
	//----------------------------------------------
	//executive_techno_enterprise edited on 13-07-2026 by PN
	if ($reference_id == 'ET') {

		$sql11 = $conn->prepare("SELECT * FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = '" . $reference_no . "'");
		$sql11->execute();
		$sql11->setFetchMode(PDO::FETCH_ASSOC);
		if ($sql11->rowCount() > 0) {
			foreach (($sql11->fetchAll()) as $key11 => $row11) {
				$Sf_id = $row11['executive_techno_enterprise_id'];
				$Sf_name = $row11['firstname'] .' '. $row11['lastname'] ;
				$bdm_id = $row11['reference_no'];
				$bdm_name = $row11['registrant'];
			}
		}
	}
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
				//-------------------------------------------------------
				// ete Referral edited on 13-07-2026 by PN 
				//  On institution recruitment ETE gets 5% and CTE get 2.5% commission
				elseif (strpos($reference_no, 'ET') === 0) {
					$master_franchisee = $reference_no;

					// Get ETE name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					// $mfCommiAmt = $amount * 0.05; //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Executive Techno Enterprise(ETE) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Institution and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT firstname, lastname,user_type FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						// $refCommiAmt = $amount * 0.025; //12500
						$ref_name = $ref ? $ref['firstname'].' '.$ref['lastname'] : '';
						// $ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "Chief Techno Enterprise(CTE) $ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					}
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
				//-------------------------------------------------------
				// ete Referral edited on 13-07-2026 by PN 
				//  On institution recruitment ETE gets 5% and CTE get 2.5% commission
				elseif (strpos($reference_no, 'ET') === 0) {
					$master_franchisee = $reference_no;

					// Get ETE name
					$stmt = $conn->prepare("SELECT firstname, lastname,reference_no FROM executive_techno_enterprise WHERE executive_techno_enterprise_id = :sf_id");
					$stmt->execute([':sf_id' => $master_franchisee]);
					$sf = $stmt->fetch(PDO::FETCH_ASSOC);
					$mfCommiAmt = $amount * 0.05; //25000
					$sf_name = $sf ? $sf['firstname'].' '.$sf['lastname'] : '';
					$message_mf = "Executive Techno Enterprise(ETE) $sf_name ($master_franchisee) earned Rs $mfCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					$message_sf="$name ($uid) was on-boarded via $sf_name ($master_franchisee) as a Institution and paid Rs $amount /-";
					if (!empty($sf['reference_no']) && $sf['reference_no'] !== 'Not Applicable' && $sf['reference_no'] !== 'NA') {
						$ref_manager = $sf['reference_no'];

						// Get ref name
						$stmt2 = $conn->prepare("SELECT firstname, lastname,user_type FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = :employee_id");
						$stmt2->execute([':employee_id' => $ref_manager]);
						$ref = $stmt2->fetch(PDO::FETCH_ASSOC);
						$refCommiAmt = $amount * 0.025; //12500
						$ref_name = $ref ? $ref['firstname'].' '.$ref['lastname'] : '';
						// $ref_designation=$ref['user_type'] == '24'?'BCM':($ref['user_type'] == '25'?'BDM':($ref['user_type'] == '31'?'RM':'unknonwn'));
						$message_ref = "Chief Techno Enterprise(CTE) $ref_name ($ref_manager) earned Rs $refCommiAmt/- on registering Institution.Institution Name - $name (ID:$uid). Institution Amount: Rs $amount /-";
					}
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
				$message3 = '
					<!DOCTYPE html>
						<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
						<head>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1.0">
							<meta name="x-apple-disable-message-reformatting">
							<title>Welcome Email</title>

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
								body{
									margin:0;
									padding:0;
									background:#f5f5f5;
									font-family:Arial,Helvetica,sans-serif;
								}
								table{
									border-collapse:collapse;
								}
								.container{
									width:650px;
									max-width:650px;
									margin:20px auto;
									background:#ffffff;
									border:1px solid #e5e5e5;
								}
								.content{
									padding:35px;
									color:#333333;
									font-size:15px;
									line-height:24px;
								}
								.heading{
									font-size:28px;
									font-weight:bold;
									color:#1f2937;
								}
								.subtext{
									color:#555;
								}
								.credential-box{
									background:#fafafa;
									border:1px solid #e6e6e6;
									border-radius:8px;
									padding:20px;
								}
								.credential-box ul{
									padding-left:20px;
									margin:10px 0;
								}
								.credential-box li{
									margin-bottom:14px;
								}
								hr{
									border:none;
									border-top:1px solid #dddddd;
									margin:30px 0;
								}
								.footer{
									color:#555;
								}
								.label{
									font-weight:bold;
								}
								.link{
									color:#0d6efd;
									text-decoration:none;
								}
								.logo{
									text-align:center;
									padding-top:25px;
								}

								@media only screen and (max-width:680px){
									.container{
										width:100% !important;
									}
									.content{
										padding:20px !important;
									}
								}
							</style>
						</head>

						<body>

							<table width="100%" bgcolor="#f5f5f5">
								<tr>
									<td align="center">

										<table class="container" cellpadding="0" cellspacing="0">

											<tr>
												<td class="content">

													<p><strong>Dear '. $name .',</strong></p>

													<p class="subtext">
													Greetings from <strong>Bizzmirth Holidays Pvt. Ltd.</strong>
													🌍✈️
													</p>

													<p>
													We’re delighted to welcome you as <strong>'. $name .'</strong>.
													Your onboarding marks the beginning of a promising collaboration,
													and we look forward to building success together.
													</p>

													<br>

													<div class="credential-box">

														<p style="margin-top:0;">
														🔐 <strong>Your Access Credentials:</strong>
														</p>

														<ul>

														<li>
														🌐
														<span class="label">Portal URL:</span>
														<a href="https://ca.uniqbizz.com" class="link">
														https://ca.uniqbizz.com
														</a>
														</li>

														<li>
														🆔
														<span class="label">Login ID:</span>
														' . $uname . '
														</li>

														<li>
														🔑
														<span class="label">Password:</span>
														' . $password . '
														</li>

														<li>
														👉
														<span class="label">Login As:</span>
														' . $name . '
														</li>

														</ul>

													</div>

													<hr>

													<h3 style="margin-bottom:10px;">📞 Need Help?</h3>

													<p>
													Our Support Team is always available to assist you at every step.
													Feel free to reach out for training, assistance, or business guidance.
													</p>

													<hr>

													<p class="footer">
													Thank you for choosing to be part of the
													<strong>Bizzmirth Holidays</strong> family.
													Let’s work together to deliver memorable travel experiences
													to customers across the globe.
													</p>

													<p style="margin-top:35px;">
													<strong>Warm regards,</strong><br>
													<strong>Team Bizzmirth Holidays Pvt. Ltd.</strong><br>
													<em>In association with UNIQBIZZ</em>
													</p>

												</td>
											</tr>

										</table>

									</td>
								</tr>
							</table>

						</body>
					</html>
				';
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