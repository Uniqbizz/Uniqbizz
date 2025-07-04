<?php
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

date_default_timezone_set('Asia/Calcutta'); //set default timeZone
$todayYear = date('Y' ); // year for Custom Id genaration
$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

$id = $_POST["id"];
$uname = $_POST["uname"];

$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0, 8);
$status = '1';
$user_type_id = '16';

$register_by = '15';

date_default_timezone_set('Asia/Calcutta');
$todayYear = date('Y');

$subY = substr($todayYear, 2, 4);

$sql9 = $conn->prepare("SELECT * from corporate_agency where id='" . $id . "' and status='2'");
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
		$reference_no = $row9['reference_no'];
		$registrant = $row9['registrant'];
		$amount = $row9['amount'];
	}
}

$reference_id = substr($reference_no, 0, 2);
if ($reference_id == "BC") {

	$sql10 = $conn->prepare("SELECT * FROM business_consultant WHERE business_consultant_id = '" . $reference_no . "'");
	$sql10->execute();
	$sql10->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql10->rowCount() > 0) {
		foreach (($sql10->fetchAll()) as $key10 => $row10) {
			$Bc_id = $row10['business_consultant_id'];
			$Bc_name = $row10['firstname'] . ' ' . $row10['lastname'];
			$Bc_ref = $row10['reference_no'];
		}
	}

	$sql11 = $conn->prepare("SELECT * FROM channel_business_director WHERE channel_business_director_id = '" . $Bc_ref . "'");
	$sql11->execute();
	$sql11->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql11->rowCount() > 0) {
		foreach (($sql11->fetchAll()) as $key11 => $row11) {
			$cbd_id = $row11['channel_business_director_id'];
			$cbd_name = $row11['firstname'] . ' ' . $row11['lastname'];
		}
	}

	if ($amount == "100000") {
		$business_package = "standard";
	} else if ($amount == "200000") {
		$business_package = "prime";
	} else if ($amount == "500000") {
		$business_package = "premium";
	}

	$bcCommiAmt = $amount * 5 / 100; //25000
	$cbdCommiAmt = $bcCommiAmt * 30 / 100; //7500

} else if ($reference_id == "BM") {

	$sql10 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '" . $reference_no . "'");
	$sql10->execute();
	$sql10->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql10->rowCount() > 0) {
		foreach (($sql10->fetchAll()) as $key10 => $row10) {
			$BM_id = $row10['business_mentor_id'];
			$BM_name = $row10['firstname'] . ' ' . $row10['lastname'];
			$BM_ref = $row10['reference_no'];
		}
	}

	$sql11 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $BM_ref . "'");
	$sql11->execute();
	$sql11->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql11->rowCount() > 0) {
		foreach (($sql11->fetchAll()) as $key11 => $row11) {
			$bdm_id = $row11['employee_id'];
			$bdm_name = $row11['name'];
			$bdm_user_type_id = $row11['user_type'];
			$bdm_ref = $row11['reporting_manager'];
		}
	}

	$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $bdm_ref . "'");
	$sql12->execute();
	$sql12->setFetchMode(PDO::FETCH_ASSOC);
	if ($sql12->rowCount() > 0) {
		foreach (($sql12->fetchAll()) as $key12 => $row12) {
			$bch_id = $row12['employee_id'];
			$bch_name = $row12['name'];
			$bch_user_type_id = $row12['user_type'];
		}
	}

	if ($amount == "100000") {
		$business_package = "standard";
	} else if ($amount == "200000") {
		$business_package = "prime";
	} else if ($amount == "500000") {
		$business_package = "premium";
	}

	$bmCommiAmt = $amount * 5 / 100; //25000
	$bdmCommiAmt = ($amount * 2.5) / 100; //12500
	// $cbdCommiAmt = $bcCommiAmt * 30/100; //7500

}else if($reference_id == "BH"){
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

	// $sql11 = $conn->prepare("SELECT * FROM channel_business_director WHERE channel_business_director_id = '" . $Bc_ref . "'");
	// $sql11->execute();
	// $sql11->setFetchMode(PDO::FETCH_ASSOC);
	// if ($sql11->rowCount() > 0) {
	// 	foreach (($sql11->fetchAll()) as $key11 => $row11) {
	// 		$cbd_id = $row11['channel_business_director_id'];
	// 		$cbd_name = $row11['firstname'] . ' ' . $row11['lastname'];
	// 	}
	// }

	if ($amount == "200000") {
		$business_package = "standard";
	} else if ($amount == "300000") {
		$business_package = "prime";
	} else if ($amount == "500000") {
		$business_package = "premium";
	}

	$bdmCommiAmt = $amount * 5 / 100; //25000
	
	// $cbdCommiAmt = $bcCommiAmt * 30 / 100; //7500
}

$sql2 = $conn->prepare("SELECT distinct corporate_agency_id,SUBSTRING(corporate_agency_id,3,6) as tc_id from corporate_agency where status='1' OR status='3' order by tc_id DESC limit 1");
$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_ASSOC);
if ($sql2->rowCount() > 0) {
	foreach (($sql2->fetchAll()) as $key3 => $row3) {
		$corporate_agency_id = $row3["corporate_agency_id"];
	}
	if ($corporate_agency_id == '') {
		$uid = 'TE' . $subY . '0111';
	} else {

		$subV = substr($corporate_agency_id, 2, 4);
		if ($subV == $subY) {
			$corporate_agency_id++;
			$corporate_agency_id = str_pad($corporate_agency_id, 4, '0', STR_PAD_LEFT);
			$uid = $corporate_agency_id;
		} else {

			$corporate_agency_id++;
			$fid = substr($corporate_agency_id, 4);
			$newValue = 'TE' . $subY . $fid;
			$Ncorporate_agency_id = str_pad($newValue, 4, '0', STR_PAD_LEFT);
			$uid = $Ncorporate_agency_id;
		}
	}
} else {
	$uid = 'TE' . $subY . '0111';
}

//log file
$title = "Techno Enterprise";
$message = $uid . " has been approved";
$message2 = $uid . " has been approved";
$fromWhom = "15";
$operation = "Confirm";
// if($amount == "null"){
// 	$cbdCommiAmt = "null";
// 	$bcCommiAmt = "null";
// }else{
// 	$bcCommiAmt = $amount * 5/100; //25000
// 	$cbdCommiAmt = $bcCommiAmt * 30/100; //7500
// }



$sql1 = "UPDATE corporate_agency SET status=:status,corporate_agency_id=:corporate_agency_id, register_date=:register_date WHERE id=:id";
$stmt = $conn->prepare($sql1);
$result =  $stmt->execute(array(
	':status' => $status,
	':corporate_agency_id' => $uid,
	':register_date' => $register_Date,
	// ':deleted_date' => $today,
	':id' => $id
));
//get state id
$sqlState = "SELECT state FROM corporate_agency WHERE id = :id";
$stmtState = $conn->prepare($sqlState);
$stmtState->execute([':id' => $id]);

$state = $stmtState->fetch(PDO::FETCH_ASSOC);

// To get just the state value
$stateValue = $state['state'];

if ($reference_id == "BM") {
	$sql13 = "INSERT INTO `ca_hierarchy` (bch_id, bdm_id, bm_id, ca_id ) VALUES (:bch_id ,:bdm_id, :bm_id, :ca_id)";
	$stmt3 = $conn->prepare($sql13);
	$result2 = $stmt3->execute(array(
		':bch_id' => $bch_id,
		':bdm_id' => $bdm_id,
		':bm_id' => $BM_id,
		':ca_id' => $uid
	));
}

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

		if ($result3) {
			if ($reference_id == "BC") {
				$message = "BC - " . $Bc_name . " " . $Bc_id . " earned " . $bcCommiAmt . "/- on recruting Techno Enterprise. Name of the Techno Enterprise - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";
				$id = $Bc_id;
				$CommiAmt = $bcCommiAmt;

				$insertCALSql = "INSERT INTO ca_payout (business_consultant, message, business_package, business_package_amount, comm_amt, corporate_agency, status) VALUES (:business_consultant, :message, :business_package, :business_package_amount, :comm_amt, :corporate_agency, :status) ";
				$insertCAL = $conn->prepare($insertCALSql);
				$result4 = $insertCAL->execute(array(
					':business_consultant' => $id,
					':message' => $message,
					':business_package' => $business_package,
					':business_package_amount' => $amount,
					':comm_amt' => $CommiAmt,
					':corporate_agency' => $uid,
					':status' => '2'
				));
				
			}else if($reference_id == "BH" && $stateValue==6){// isolation for Goa state only

				$message = "BDM - " . $bdm_name . " " . $bdm_id . " earned " . $bdmCommiAmt . "/- on recruiting Techno Enterprise. Name of the Techno Enterprise - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";
				$id = $bdm_id;
				$CommiAmt = $bdmCommiAmt;

				$insertCALSql = "INSERT INTO `goa_bdm_payout` (bdm_id, message, business_package, business_package_amount, comm_amt, techno_enterprise, status) VALUES (:bdm_id, :message, :business_package, :business_package_amount, :comm_amt, :techno_enterprise, :status) ";
				$insertCAL = $conn->prepare($insertCALSql);
				$result4 = $insertCAL->execute(array(
					':bdm_id' => $id,
					':message' => $message,
					':business_package' => $business_package,
					':business_package_amount' => $amount,
					':comm_amt' => $CommiAmt,
					':techno_enterprise' => $uid,
					':status' => '2'
				));

			}else if($reference_id == "BM" && $stateValue==6){// isolation for Goa state only

				$message = "BM - " . $BM_name . " " . $BM_id . " earned " . $bmCommiAmt . "/- on recruiting Techno Enterprise. Name of the Techno Enterprise - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";
				
				$CommiAmt = $bmCommiAmt;

				$insertCALSql = "INSERT INTO `goa_bm_payout` 
				(bm_id, message, business_package, business_package_amount, comm_amt, techno_enterprise, status) 
				VALUES (:bm_id, :message, :business_package, :business_package_amount, :comm_amt, :techno_enterprise, :status) ";
				$insertCAL = $conn->prepare($insertCALSql);
				$result4 = $insertCAL->execute(array(
					':bm_id' => $BM_id,
					':message' => $message,
					':business_package' => $business_package,
					':business_package_amount' => $amount,
					':comm_amt' => $CommiAmt,
					':techno_enterprise' => $uid,
					':status' => '2'
				));

				$message = "BDM - " . $bdm_name . " " . $bdm_id . " earned " . $bdmCommiAmt . "/- on recruiting Techno Enterprise through BM - " . $BM_name . " " . $BM_id . " . Name of the Techno Enterprise - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";
				
				$CommiAmt = $bdmCommiAmt;

				$insertCALSql = "INSERT INTO `goa_bdm_payout` (bdm_id, message, business_package, business_package_amount, comm_amt, techno_enterprise, status) VALUES (:bdm_id, :message, :business_package, :business_package_amount, :comm_amt, :techno_enterprise, :status) ";
				$insertCAL = $conn->prepare($insertCALSql);
				$result4 = $insertCAL->execute(array(
					':bdm_id' => $bdm_id,
					':message' => $message,
					':business_package' => $business_package,
					':business_package_amount' => $amount,
					':comm_amt' => $CommiAmt,
					':techno_enterprise' => $uid,
					':status' => '2'
				));

			}else if ($reference_id == "BM") {
				$message = "BM - " . $BM_name . " " . $BM_id . " earned " . $bmCommiAmt . "/- on recruting Techno Enterprise. Name of the Techno Enterprise - " . $name . " " . $uid . ". Recruitment Fee - " . $amount . " . ";
				$id = $BM_id;
				$CommiAmt = $bmCommiAmt;
				//added bm bdm and bcm slab logic by sv on 17-02-2025
				$current_month = date('m');
				$current_year = date('Y');

				// Get all CA data for the current month
				$stmt = $conn->prepare("SELECT * FROM corporate_agency WHERE MONTH(register_date) = ? AND YEAR(register_date) = ? AND status = '1'");
				$stmt->execute([$current_month, $current_year]);
				$ca_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$bm_id_amt = [];
				$bdm_id_amt = [];

				// Step 1: Calculate BM Earnings for each TE 
				foreach ($ca_data as $row) {
					$bm_id = $row['reference_no'];
					$ca_id = $row['corporate_agency_id'];
					$ca_name = $row['firstname'] . " " . $row['lastname'];
					$te_register_date = $row['register_date'];

					$stmt_bm_date = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = ?");
					$stmt_bm_date->execute([$bm_id]);
					$bm_data = $stmt_bm_date->fetch(PDO::FETCH_ASSOC);

					if (!$bm_data) continue;
					$bm_register_date = $bm_data['register_date'];
					$bm_name = $bm_data['firstname'] . " " . $bm_data['lastname'];

					if ($te_register_date <= $bm_register_date) continue;

					// Messages
					$message_bm = "BM - " .$bm_name. "(ID:" .$bm_id.") earned Rs.25,000/- on recruiting Techno Enterprise. Techno Enterprise Name - ".$ca_name. "(ID:" .$ca_id.")";
					$message_ca = "Recruited Techno Enterprise - ".$ca_name. "(ID:" .$ca_id.") under BM ".$bm_name;

					// Check if BM payout already exists for the current month
					$stmt_check = $conn->prepare("SELECT id FROM bm_payout_history WHERE bm_user_id = ? AND ca_user_id = ? AND MONTH(payout_date) = ? AND YEAR(payout_date) = ?");
					$stmt_check->execute([$bm_id, $ca_id, $current_month, $current_year]);

					if ($stmt_check->rowCount() == 0) {
						// Insert BM Payout
						$stmt_insert = $conn->prepare("INSERT INTO bm_payout_history (bm_user_id, message_bm, ca_user_id, message_ca, payout_amount, payout_date) VALUES (?, ?, ?, ?, 25000, NOW())");
						$stmt_insert->execute([$bm_id, $message_bm, $ca_id, $message_ca]);
					}

					$bm_id_amt[$bm_id] = ($bm_id_amt[$bm_id] ?? 0) + 25000;

					$result4 = 1;
				}

				// Step 2: Calculate BDM Incentives
				$stmt_bm = $conn->prepare("SELECT * FROM business_mentor WHERE status = '1'");
				$stmt_bm->execute();
				$bm_data = $stmt_bm->fetchAll(PDO::FETCH_ASSOC);

				$bdm_bm_mapping = [];
				foreach ($bm_data as $row) {
					$bm_id = $row['business_mentor_id'];
					$bdm_id = $row['reference_no'];

					if (isset($bm_id_amt[$bm_id])) {
						$bdm_bm_mapping[$bdm_id][] = $bm_id;
					}
				}

				foreach ($bdm_bm_mapping as $bdm_id => $bms) {
					$stmt_bdm_date = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
					$stmt_bdm_date->execute([$bdm_id]);
					$bdm_data = $stmt_bdm_date->fetch(PDO::FETCH_ASSOC);

					if (!$bdm_data) continue;
					$bdm_register_date = $bdm_data['register_date'];

					$bm_total_amt = 0;
					foreach ($bms as $bm) {
						$bm_total_amt += $bm_id_amt[$bm] ?? 0;
					}

					$bm_count = count($bms);
					$percentage = ($bm_count >= 5) ? 40 : (($bm_count >= 3) ? 30 : 20);
					$bdm_incentive = ($bm_total_amt * $percentage) / 100;

					$all_bms = json_encode($bms);
					$message_bdm = "BDM - " . $bdm_data['name'] . " (ID:" .$bdm_id.") earned Rs. ".$bdm_incentive."/- on total commission of all Business Mentors, which is ".$percentage."% of total commission Rs.".$bm_total_amt."/-";
					$message_bm = "All Business Mentors: " . implode(',', $bms) . ", total commission Rs.".$bm_total_amt."/-";

					// Check if BDM payout exists
					$stmt_check = $conn->prepare("SELECT id FROM bdm_payout_history WHERE bdm_user_id = ? AND MONTH(payout_date) = ? AND YEAR(payout_date) = ?");
					$stmt_check->execute([$bdm_id, $current_month, $current_year]);

					if ($stmt_check->rowCount() == 0) {
						// Insert new BDM payout
						$stmt_insert = $conn->prepare("INSERT INTO bdm_payout_history (bdm_user_id, message_bdm, bm_user_id, message_bm, payout_amount, payout_date) VALUES (?, ?, ?, ?, ?, NOW())");
						$stmt_insert->execute([$bdm_id, $message_bdm, $all_bms, $message_bm, $bdm_incentive]);
					} else {
						// Update existing BDM payout
						$stmt_update = $conn->prepare("UPDATE bdm_payout_history SET payout_amount = ?, message_bdm = ?, message_bm = ?, bm_user_id = ? WHERE bdm_user_id = ? AND MONTH(payout_date) = ? AND YEAR(payout_date) = ?");
						$stmt_update->execute([$bdm_incentive, $message_bdm, $message_bm, $all_bms, $bdm_id, $current_month, $current_year]);
					}

					$bdm_id_amt[$bdm_id] = $bdm_incentive;
				}

				// Step 3: Calculate BCM Incentives
				$stmt_bdm = $conn->prepare("SELECT * FROM employees WHERE status = '1' AND user_type = '25'");
				$stmt_bdm->execute();
				$bdm_data = $stmt_bdm->fetchAll(PDO::FETCH_ASSOC);

				$bcm_bdm_mapping = [];
				foreach ($bdm_data as $row) {
					$bcm_id = $row['reporting_manager'];
					$bdm_id = $row['employee_id'];
					if (isset($bdm_id_amt[$bdm_id])) {
						$bcm_bdm_mapping[$bcm_id][] = $bdm_id;
					}
				}

				foreach ($bcm_bdm_mapping as $bcm_id => $bdms) {
					$stmt_bcm_date = $conn->prepare("SELECT register_date, name FROM employees WHERE employee_id = ?");
					$stmt_bcm_date->execute([$bcm_id]);
					$bcm_data = $stmt_bcm_date->fetch(PDO::FETCH_ASSOC);

					$bdm_total_amt = array_sum(array_map(fn($bdm) => $bdm_id_amt[$bdm] ?? 0, $bdms));
					$bdm_count = count($bdms);
					$percentage = ($bdm_count >= 4) ? 40 : (($bdm_count == 3) ? 30 : 20);
					$bcm_incentive = ($bdm_total_amt * $percentage) / 100;

					$all_bdms = json_encode($bdms);
					$message_bcm = "BCM - " . $bcm_data['name'] . " (ID:" .$bcm_id.") earned Rs.".$bcm_incentive."/- on total commission of Business Development Managers, which is ".$percentage."% of total commission Rs.".$bdm_total_amt."/-";
					$message_bdm = "All Business Development Managers: " . implode(',', $bdms) . ", total commission Rs.".$bdm_total_amt."/-";

					// $stmt_update = $conn->prepare("INSERT INTO bcm_payout_history (bcm_user_id, message_bcm, bdm_user_id, message_bdm, payout_amount, payout_date) VALUES (?, ?, ?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE payout_amount = VALUES(payout_amount), message_bcm = VALUES(message_bcm), message_bdm = VALUES(message_bdm)");
					// $stmt_update->execute([$bcm_id, $message_bcm, $all_bdms, $message_bdm, $bcm_incentive]);
					
					// Check if BCM payout exists for the current month and year
					$stmt_check = $conn->prepare("SELECT id FROM bcm_payout_history WHERE bcm_user_id = ? AND MONTH(payout_date) = ? AND YEAR(payout_date) = ?");
					$stmt_check->execute([$bcm_id, $current_month, $current_year]);

					if ($stmt_check->rowCount() == 0) {
						// Insert new BCM payout
						$stmt_insert = $conn->prepare("
							INSERT INTO bcm_payout_history (bcm_user_id, message_bcm, bdm_user_id, message_bdm, payout_amount, payout_date) 
							VALUES (?, ?, ?, ?, ?, NOW())");
						$stmt_insert->execute([$bcm_id, $message_bcm, $all_bdms, $message_bdm, $bcm_incentive]);
					} else {
						// Update existing BCM payout for the current month & year
						$stmt_update = $conn->prepare("
							UPDATE bcm_payout_history 
							SET payout_amount = ?, message_bcm = ?, message_bdm = ?, bdm_user_id = ?
							WHERE bcm_user_id = ? AND MONTH(payout_date) = ? AND YEAR(payout_date) = ?");
						$stmt_update->execute([$bcm_incentive, $message_bcm, $message_bdm, $all_bdms, $bcm_id, $current_month, $current_year]);
					}

				}

				//end of slab log
			}
			
			if ($result4) {
				// cbd not active user 
				if ($reference_id == "BC") {
					$message_cbd = "CBD - " . $cbd_name . " " . $cbd_id . " earned " . $cbdCommiAmt . "/- When BC - " . $Bc_name . " " . $Bc_id . " recruited Techno Enterprise. Name of the Techno Enterprise - " . $name . " " . $uid . ".";
					$payout_type = "Contracting Payout";

					$insertCBDPaySQL = " INSERT INTO cbd_payout (cbd_id, cbd_name, payout_type, user_id, user_name, message, amount, status) VALUES (:cbd_id, :cbd_name, :payout_type, :user_id, :user_name, :message, :amount, :status) ";
					$insertCBDPay = $conn->prepare($insertCBDPaySQL);
					$result5 = $insertCBDPay->execute(array(
						':cbd_id' => $cbd_id,
						':cbd_name' => $cbd_name,
						':payout_type' => $payout_type,
						':user_id' => $Bc_id,
						':user_name' => $Bc_name,
						':message' => $message_cbd,
						':amount' => $cbdCommiAmt,
						':status' => '2'
					));
				} else {
					$result5 = 1;
				}

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
					$mail->Password = "support@uniqbizz";
					$mail->SetFrom("support@uniqbizz.com");
					$mail->Subject = $subject;
					$mail->Body = $message3;
					$mail->AddAddress($to);
					$mail->SMTPOptions = array('ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => false
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
	} else {
		echo 0;
	}
} else {
	echo 0;
}
