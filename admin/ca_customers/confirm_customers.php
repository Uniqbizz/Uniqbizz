<?php
require "../connect.php";
include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

date_default_timezone_set('Asia/Calcutta'); //set default timeZone
$todayYear = date('Y'); // year for Custom Id genaration
$register_Date = date('Y-m-d H:i:s'); //date added when user is confirmed 

$id = $_POST["id"];
$uname = $_POST["uname"];


$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^*()";
$password = substr(str_shuffle($string), 0, 8);
$status = '1';
$user_type_id = '10';

// $sm_id= $_POST["sm_id"];
$register_by = '1';

date_default_timezone_set('Asia/Calcutta');
$todayYear = date('Y');

$subY = substr($todayYear, 2, 4);

$sql9 = $conn->prepare("SELECT * from ca_customer where id='" . $id . "' and status='2'");
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
		$ta_reference_no = $row9['ta_reference_no'];
		$amount=$row9['paid_amount'];
		$complemetory = $row9['comp_chek'];
		$customer_type = $row9['customer_type'];
		$cu_reference_no = $row9['reference_no']??'NA';
	}
}

$sql2 = $conn->prepare("SELECT distinct ca_customer_id,SUBSTRING(ca_customer_id,3,6) as tc_id from ca_customer where status='1' OR status='3' order by tc_id DESC limit 1");

$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_ASSOC);
if ($sql2->rowCount() > 0) {
	foreach (($sql2->fetchAll()) as $key3 => $row3) {
		$ca_customer_id = $row3["ca_customer_id"];
	}
	if ($ca_customer_id == '') {
		$uid = 'CU' . $subY . '0001';
	} else {

		$subV = substr($ca_customer_id, 2, 4);
		if ($subV == $subY) {
			// ''.$ssd
			$ca_customer_id++;
			$ca_customer_id = str_pad($ca_customer_id, 4, '0', STR_PAD_LEFT);
			$uid = $ca_customer_id;
		} else {

			$ca_customer_id++;
			$fid = substr($ca_customer_id, 4);
			$newValue = 'CU' . $subY . $fid;

			$Nca_customer_id = str_pad($newValue, 4, '0', STR_PAD_LEFT);
			$uid = $Nca_customer_id;
		}
	}
} else {
	$uid = 'CU' . $subY . '0001';
}

//log file
$title = "Customer";
$message = $uid . " has been approved";
$message2 = $uid . " has been approved";
$fromWhom = "1";
$operation = "Confirm";

$sql1 = "UPDATE ca_customer SET status=:status,ca_customer_id=:ca_customer_id,register_date=:register_date WHERE id=:id";
$stmt = $conn->prepare($sql1);
$result =  $stmt->execute(array(
	':status' => $status,
	':ca_customer_id' => $uid,
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
		//update coupon table once the customer is confirmed
		// Check if the ID exists
		$check_sql = "SELECT COUNT(*) FROM cu_coupons WHERE user_id = :id";
		$check_stmt = $conn->prepare($check_sql);
		$check_stmt->execute([':id' => $id]);
		$count = $check_stmt->fetchColumn(); // Fetch count
		//initialization
		$te_id = 'N/A';
		$te_name = 'N/A';

		$message_bdm = 'N/A';
		$message_bm = 'N/A';
		$message_te = 'N/A';
		$message_tc = 'N/A';
		$message_ca_cu = 'N/A';

		$commision_bdm = 0;
		$commision_bm = 0;
		$commision_te = 0;
		$commision_tc = 0;

		$ca_cu_amt_paid = 0;

		//get the TC TE/BM who regitered this TC
		$sqlta = $conn->prepare("
				SELECT ca_travelagency_id as user_id,firstname,lastname,reference_no,registrant FROM ca_travelagency WHERE ca_travelagency_id = '".$ta_reference_no."'
				UNION
				SELECT institution_branch_manager_id as user_id,firstname,lastname,reference_no,registrant FROM institution_branch_manager WHERE institution_branch_manager_id = '".$ta_reference_no."'");
		$sqlta->execute();
		$sqlta->setFetchMode(PDO::FETCH_ASSOC);
		if($sqlta->rowCount()>0){
			foreach(($sqlta->fetchAll()) as $keyta => $rowta){
				$tc_id = $rowta['user_id'];
				$tc_name = $rowta['firstname']. ' ' .$rowta['lastname'];
				$ta_te_id = $rowta['reference_no'];
				$ta_te_name = $rowta['registrant'];
			}
		}else{
			$tc_id = 'N/A';
			$tc_name = 'N/A';
			$ta_te_id = 'N/A';
			$ta_te_name = 'N/A';
		}

		//identify TC ref TE/BM/MF/F/I
		$reference_id = (substr($ta_te_id, 0, 1) == 'F' || substr($ta_te_id, 0, 1) == 'I') 
							? substr($ta_te_id, 0, 1) 
							: substr($ta_te_id, 0, 2);
		
		// echo '<pre> Ta Te Id - '.$ta_te_id. '
		// 			ref id - '.$reference_id.'	
		// </pre>';
		// exit;

		// ####**** correct pre tag format ****####
		// echo "<pre>";

		// echo "tc_id = ".$tc_id."<br>";
		// echo "tc_name = ".$tc_name."<br>";
		// echo "ta_te_id = ".$ta_te_id."<br>";
		// echo "ta_te_name = ".$ta_te_name."<br>";

		// $reference_id = (substr($ta_te_id, 0, 1) == 'F' || substr($ta_te_id, 0, 1) == 'I') 
		// 					? substr($ta_te_id, 0, 1) 
		// 					: substr($ta_te_id, 0, 2);

		// echo "reference_id = ".$reference_id."<br>";
		// exit;

		// Run update only if the ID exists
		if ($count > 0) {

			$update_coupon = "UPDATE cu_coupons 
				SET user_id = :user_id, 
					confirm_status = :confirm_status
				WHERE user_id = :id";

			$update_stmt = $conn->prepare($update_coupon);
			$update_stmt->execute([
				':user_id' => $uid,
				':confirm_status' => 1,
				':id' => $id
			]);
			
			if($complemetory == 2){
				$BdmName = $BdmId = $message_bdm=$commision_bdm='';
				$bdm_commi = '0'; 
				if ($reference_id == "TE" || $reference_id == "CA" ) {
	
					//get corporate agencies/ techno enterprise reference number i.e Travel agent/business mentor to enter it in "payout statments" table
					$sql10 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ta_te_id."'");
					$sql10->execute();
					$sql10->setFetchMode(PDO::FETCH_ASSOC);
					if($sql10->rowCount()>0){
						foreach(($sql10->fetchAll()) as $key10 => $row10){
							$te_id = $row10['corporate_agency_id'];
							$te_name = $row10['firstname']. ' ' .$row10['lastname'];
							$BmId = $row10['reference_no'];
							$BmName = $row10['registrant'];
						}
					}

					//if TE ref is a BM
					if(substr($BmId,0,2) == 'BM'){
						//bm details
						$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$BmId."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['business_mentor_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						
						//bdm deatils
						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BdmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);
						if($sql12->rowCount()>0){
							foreach(($sql12->fetchAll()) as $key12 => $row12){
								$BdmId = $row12['employee_id'];
								$BdmName = $row12['name'];
							}
							//only if bdm is present
							$message_bdm = "BDM - ".$BdmName." ".$BdmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Business Mentor ".$BmName." ".$BmId.".";
							$commision_bdm = $bdm_commi;
						}
					}

					//if TE ref is a STE
					else if(substr($BmId,0,2) == 'ST'){
						//STE details
						$sql11 = $conn->prepare("SELECT * FROM super_techno_enterprise WHERE super_techno_enterprise_id = '".$BmId."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['super_techno_enterprise_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						
						//ETE deatils
						$sql12 = $conn->prepare("SELECT * FROM 	executive_techno_enterprise WHERE executive_techno_enterprise_id = '".$BdmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);
						if($sql12->rowCount()>0){
							foreach(($sql12->fetchAll()) as $key12 => $row12){
								$BdmId = $row12['executive_techno_enterprise_id'];
								$BdmName = $row12['firstname']. ' ' .$row12['lastname'];
								$cteId = $row12['reference_no'];
								$cteName = $row12['registrant'];
							}
						}

						//CTE deatils (Not require as we are getting it directly from ETE reference columns)
						// $sql13 = $conn->prepare("SELECT * FROM 	chief_techno_enterprise WHERE chief_techno_enterprise_id = '".$BdmId."'");
						// $sql13->execute();
						// $sql13->setFetchMode(PDO::FETCH_ASSOC);
						// if($sql13->rowCount()>0){
						// 	foreach(($sql13->fetchAll()) as $key13 => $row13){
						// 		$BdmId = $row13['chief_techno_enterprise_id'];
						// 		$BdmName = $row13['firstname']. ' ' .$row13['lastname'];
						// 	}
						// }

						// if no commission is their
						$message_cte = "CTE - ".$cteName." ".$cteId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Super Techno Enterprise ".$BdmName." ".$BdmId.".";
						// if  commission is their
						// $message_cte = "CTE - ".$cteName." ".$cteId." earned Rs.".$cte_commi."/- on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Super Techno Enterprise ".$BdmName." ".$BdmId.".";
						$commision_cte = '0';
					}

					//if TE ref is BDM
					else if(substr($BmId,0,2) == 'BH'){
												
						//bdm deatils
						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);
						if($sql12->rowCount()>0){
							foreach(($sql12->fetchAll()) as $key12 => $row12){
								$BmId = $row12['employee_id'];
								$BmName = $row12['name'];
							}
						}
					}
					
		
					$commissionRates = [
						'Prime' => ['tc' => 800, 'te' => 400, 'bm' => 120],
						'Premium' => ['tc' => 1500, 'te' => 750, 'bm' => 225],
						'Premium Plus' => ['tc' => 1500, 'te' => 750, 'bm' => 225],
						'Premium Select' => ['tc' => 1000, 'te' => 500, 'bm' => 150],
						'Premium Select Lite' => ['tc' => 1000, 'te' => 500, 'bm' => 150],
						'Neo Select' => ['tc' => 1000, 'te' => 500, 'bm' => 150, 'st' => 150, 'et' => 45, 'ct' => 13.50 ], // commission for STE, ETE and CTE
						'Neo Select Ultra' => ['tc' => 1000, 'te' => 500, 'bm' => 150]

					];

					$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
					$te_commi = $commissionRates[$customer_type]['te'] ?? 0;

					$bm_commi = $commissionRates[$customer_type]['bm'] ?? 0; 
					$bm_commi = $commissionRates[$customer_type]['st'] ?? 0; 
					
					$bdm_commi = $commissionRates[$customer_type]['et'] ?? 0; 
					$bcm_commi = $commissionRates[$customer_type]['ct'] ?? 0; 
					// $bdm_commi = '0';  
					
					$message_bdm = "NA";
					$commision_bdm = $bdm_commi;  

					$prefix = substr($BmId, 0, 2);
					$designationMap = [
						'BH' => 'BH',
						'BM' => 'BM',
						'ST' => 'STE'
					];
					$bm_desig = $designationMap[$prefix] ?? 'NA';
					
					$message_bdm = "BDM - ".$BmName." ".$BdmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Business Mentor ".$BmName." ".$BmId.".";
					$commision_bdm = $bdm_commi;
		
					$message_bm = $bm_desig ." - ".$BmName." ".$BmId." earned Rs.".$bm_commi."/- on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Techno Enterprise ".$te_name." ".$te_id.".";
					$commision_bm = $bm_commi;
		
					$message_te = "TE - ".$te_name." ".$te_id." earned Rs.".$te_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Travel Consultant ".$tc_name." ".$tc_id.".";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned Rs.".$tc_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
		
				}else if($reference_id == "BM"){
		
					$te_id = '';
					$te_name = '';
					
					// echo '<script>alert(refernce:"'.$ta_te_id.'")</script>';
					// exit;
					//bm details
					$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$ta_te_id."' AND status=1");
					$sql11->execute();
					$sql11->setFetchMode(PDO::FETCH_ASSOC);
					if($sql11->rowCount()>0){
						foreach(($sql11->fetchAll()) as $key11 => $row11){
							$BmId = $row11['business_mentor_id'];
							$BmName = $row11['firstname']. ' ' .$row11['lastname'];
							$BdmId = $row11['reference_no'];
							$BdmName = $row11['registrant'];
						}
					}
					
					//bdm deatils
					$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BdmId."' AND status='1' AND user_type='25'");
					$sql12->execute();
					$sql12->setFetchMode(PDO::FETCH_ASSOC);
					if($sql12->rowCount()>0){
						foreach(($sql12->fetchAll()) as $key12 => $row12){
							$BdmId = $row12['employee_id'];
							$BdmName = $row12['name'];
						}
					}
					$commissionRates = [
						'Prime' => ['tc' => 800, 'te' => 0, 'bm' => 400],
						'Premium' => ['tc' => 1500, 'te' => 0, 'bm' => 750],
						'Premium Plus' => ['tc' => 1500, 'te' => 0, 'bm' => 750],
						'Premium Select' => ['tc' => 1000, 'te' => 0, 'bm' => 500],
						'Premium Select Lite' => ['tc' => 1000, 'te' => 0, 'bm' => 500],
						'Neo Select' => ['tc' => 1000, 'te' => 0, 'bm' => 500],
						'Neo Select Ultra' => ['tc' => 1000, 'te' => 0, 'bm' => 500]
					];
					
					$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
					$te_commi = $commissionRates[$customer_type]['te'] ?? 0;
					$bm_commi = $commissionRates[$customer_type]['bm'] ?? 0;  
					$bdm_commi = '0'; //made zero on 25-06-25
					
					// $message_bdm = "BDM - ".$BdmName." ".$BdmId." earned Rs.".$bdm_commi."/- on onboarding Customer . With Reference of Business Mentor - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					// $commision_bdm = $bdm_commi;
					$message_bdm = "BDM - ".$BdmName." ".$BdmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Business Mentor ".$BmName." ".$BmId.".";
					$commision_bdm = $bdm_commi;

					$message_bm = "BM - ".$BmName." ".$BmId." earned Rs.".$bm_commi."/- on onboarding Customer . With Reference of Travel Consultant - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					$commision_bm = $bm_commi;
		
					$message_te = "Direct Travel Consultant Recrutment Through BM";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned Rs.".$tc_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
		
				}else if($reference_id == "F"){
					
					//get franchisee reference number i.e Travel agent/business mentor to enter it in "payout statments" table
					$sql10 = $conn->prepare("SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '".$ta_te_id."'");
					$sql10->execute();
					$sql10->setFetchMode(PDO::FETCH_ASSOC);
					if($sql10->rowCount()>0){
						foreach(($sql10->fetchAll()) as $key10 => $row10){
							$te_id = $row10['sub_franchisee_id'];
							$te_name = $row10['firstname']. ' ' .$row10['lastname'];
							$Bm_Id = $row10['reference_no'];//substring for MF/SF
							$BmName = $row10['registrant'];
						}
					}
					$f_ref = substr($Bm_Id, 0, 2);
					$commissionRates =[];
					$tc_commi = "";
					$te_commi = "";
					$bm_commi = "";
					$franchisee_ref = "";
					if($f_ref == "MF"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['master_franchisee_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						$commissionRates = [
							'Prime' => ['tc' => 800, 'f' => 400, 'mf' => 120],
							'Premium' => ['tc' => 1500, 'f' => 750, 'mf' => 225],
							'Premium Plus' => ['tc' => 1500, 'f' => 750, 'mf' => 225],
							'Premium Select' => ['tc' => 1000, 'f' => 500, 'mf' => 150],
							'Premium Select Lite' => ['tc' => 1000, 'f' => 500, 'mf' => 150],
							'Neo Select' => ['tc' => 1000, 'f' => 500, 'mf' => 150],
							'Neo Select Ultra' => ['tc' => 1000, 'f' => 500, 'mf' => 150]
						];
						
						$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
						$te_commi = $commissionRates[$customer_type]['f'] ?? 0;
						$bm_commi = $commissionRates[$customer_type]['mf'] ?? 0; 

						$franchisee_ref = "MF";
					}else if($f_ref == "SF"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['sponsor_franchisee_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						$commissionRates = [
							'Prime' => ['tc' => 800, 'f' => 400, 'sf' => 120],
							'Premium' => ['tc' => 1500, 'f' => 750, 'sf' => 225],
							'Premium Plus' => ['tc' => 1500, 'f' => 750, 'sf' => 225],
							'Premium Select' => ['tc' => 1000, 'f' => 500, 'sf' => 150],
							'Premium Select Lite' => ['tc' => 1000, 'f' => 500, 'sf' => 150],
							'Neo Select' => ['tc' => 1000, 'f' => 500, 'sf' => 150],
							'Neo Select Ultra' => ['tc' => 1000, 'f' => 500, 'sf' => 150]
						];
						
						$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
						$te_commi = $commissionRates[$customer_type]['f'] ?? 0;
						$bm_commi = $commissionRates[$customer_type]['sf'] ?? 0;

						$franchisee_ref = "SF";
					} 
					//BM ref chain BM -> F -> TC -> CU by PN 11/04/2026
					else if($f_ref == "BM"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['business_mentor_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						$commissionRates = [
							'Prime' => ['tc' => 800, 'f' => 400, 'bm' => 120],
							'Premium' => ['tc' => 1500, 'f' => 750, 'bm' => 225],
							'Premium Plus' => ['tc' => 1500, 'f' => 750, 'bm' => 225],
							'Premium Select' => ['tc' => 1000, 'f' => 500, 'bm' => 150],
							'Premium Select Lite' => ['tc' => 1000, 'f' => 500, 'bm' => 150],
							'Neo Select' => ['tc' => 1000, 'f' => 500, 'bm' => 150],
							'Neo Select Ultra' => ['tc' => 1000, 'f' => 500, 'bm' => 150]
						];
						
						$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
						$te_commi = $commissionRates[$customer_type]['f'] ?? 0;
						$bm_commi = $commissionRates[$customer_type]['bm'] ?? 0;

						$franchisee_ref = "BM";
					}
					//check if BH 
					if ($f_ref == "BH") {
						$sql11 = $conn->prepare("SELECT user_type,name,employee_id FROM employees WHERE employee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key10 => $row10){
								$emp_user_type=$row10['user_type'];								
							}
						}
						//check user type 31-RM and 25-BDM
						if ($emp_user_type == 25) {
							$franchisee_ref='BDM';
						}elseif ($emp_user_type == 31) {
							$franchisee_ref='RM';
						}
						$commissionRates = [
							'Prime' => ['tc' => 800, 'f' => 400, 'bh' => 120],
							'Premium' => ['tc' => 1500, 'f' => 750, 'bh' => 225],
							'Premium Plus' => ['tc' => 1500, 'f' => 750, 'bh' => 225],
							'Premium Select' => ['tc' => 1000, 'f' => 500, 'bh' => 150],
							'Premium Select Lite' => ['tc' => 1000, 'f' => 500, 'bh' => 150],
							'Neo Select' => ['tc' => 1000, 'f' => 500, 'bh' => 150],
							'Neo Select Ultra' => ['tc' => 1000, 'f' => 500, 'bh' => 150]
						];
						$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
						$te_commi = $commissionRates[$customer_type]['f'] ?? 0;
						$bm_commi = $commissionRates[$customer_type]['bh'] ?? 0;
					}
					
					

					$bdm_commi = '0';  
					
					$message_bdm = "NA";
					$commision_bdm = $bdm_commi;
		
					$message_bm = $franchisee_ref." - ".$BmName." ".$BmId." earned Rs.".$bm_commi."/- on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Franchisee ".$te_name." ".$te_id.".";
					//for sponser franchisee seperate message similar to MF
					$commision_bm = $bm_commi;
		
					$message_te = "Franchisee - ".$te_name." ".$te_id." earned Rs.".$te_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Travel Consultant ".$tc_name." ".$tc_id.".";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned Rs.".$tc_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
				}else if($reference_id == "MF"){
					$te_id = '';
					$te_name = '';
					
					//bm details
					$sql11 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$ta_te_id."' AND status=1");
					$sql11->execute();
					$sql11->setFetchMode(PDO::FETCH_ASSOC);
					if($sql11->rowCount()>0){
						foreach(($sql11->fetchAll()) as $key11 => $row11){
							$BmId = $row11['master_franchisee_id'];
							$BmName = $row11['firstname']. ' ' .$row11['lastname'];
							$BdmId = $row11['reference_no'];
							$BdmName = $row11['registrant'];
						}
					}
					
					$commissionRates = [
						'Prime' => ['tc' => 800, 'f' => 0, 'mf' => 400],
						'Premium' => ['tc' => 1500, 'f' => 0, 'mf' => 750],
						'Premium Plus' => ['tc' => 1500, 'f' => 0, 'mf' => 750],
						'Premium Select' => ['tc' => 1000, 'f' => 0, 'mf' => 500],
						'Premium Select Lite' => ['tc' => 1000, 'f' => 0, 'mf' => 500],
						'Neo Select' => ['tc' => 1000, 'f' => 0, 'mf' => 500],
						'Neo Select Ultra' => ['tc' => 1000, 'f' => 0, 'mf' => 500]
					];
					
					$tc_commi = $commissionRates[$customer_type]['tc'] ?? 0;
					$te_commi = $commissionRates[$customer_type]['f'] ?? 0;
					$bm_commi = $commissionRates[$customer_type]['mf'] ?? 0;  
					$bdm_commi = '0'; //made zero on 25-06-25
					
					$message_bdm = "NA";
					$commision_bdm = $bdm_commi;

					$message_bm = "Master Franchisee - ".$BmName." ".$BmId." earned Rs.".$bm_commi."/- on onboarding Customer . With Reference of Travel Consultant - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					$commision_bm = $bm_commi;
		
					$message_te = "Direct Travel Consultant Recrutment Through Master Franchisee";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned Rs.".$tc_commi."/- on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
				} 
				//added on 14-05-2026 by SV -- institution chain payout for holiday account payout
				else if ($reference_id == "I") {

					// get Institution details
					$sql10 = $conn->prepare("SELECT * FROM institution WHERE institution_id = '".$ta_te_id."'");
					$sql10->execute();
					$sql10->setFetchMode(PDO::FETCH_ASSOC);

					if($sql10->rowCount() > 0){
						foreach(($sql10->fetchAll()) as $row10){

							$te_id   = $row10['institution_id'];
							$te_name = $row10['firstname'].' '.$row10['lastname'];

							$BmId    = $row10['reference_no'];
							$BmName  = $row10['registrant'];
						}
					}

					/*
					|--------------------------------------------------------------------------
					| CHECK WHO REFERRED THE INSTITUTION
					|--------------------------------------------------------------------------
					*/

					// Institution referred by BM
					if(substr($BmId,0,2) == 'BM'){

						$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$BmId."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);

						if($sql11->rowCount() > 0){
							foreach(($sql11->fetchAll()) as $row11){

								$BmId   = $row11['business_mentor_id'];
								$BmName = $row11['firstname'].' '.$row11['lastname'];

								$BdmId   = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}

						// get BDM details
						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BdmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);

						if($sql12->rowCount() > 0){
							foreach(($sql12->fetchAll()) as $row12){

								$BdmId   = $row12['employee_id'];
								$BdmName = $row12['name'];
							}
						}

					}

					// Institution referred by Master Franchisee
					else if(substr($BmId,0,2) == 'MF'){

						$sql11 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$BmId."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);

						if($sql11->rowCount() > 0){
							foreach(($sql11->fetchAll()) as $row11){

								$BmId   = $row11['master_franchisee_id'];
								$BmName = $row11['firstname'].' '.$row11['lastname'];

								$BdmId   = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
					}

					// Institution referred by Sponsor Franchisee
					else if(substr($BmId,0,2) == 'SF'){

						$sql11 = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$BmId."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);

						if($sql11->rowCount() > 0){
							foreach(($sql11->fetchAll()) as $row11){

								$BmId   = $row11['sponsor_franchisee_id'];
								$BmName = $row11['firstname'].' '.$row11['lastname'];

								$BdmId   = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
					}

					// Institution referred directly by BDM
					else if(substr($BmId,0,2) == 'BH'){

						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);

						if($sql12->rowCount() > 0){
							foreach(($sql12->fetchAll()) as $row12){

								$BmId   = $row12['employee_id'];
								$BmName = $row12['name'];
							}
						}
					}

					/*
					|--------------------------------------------------------------------------
					| COMMISSION
					|--------------------------------------------------------------------------
					*/

					$commissionRates = [
						'Neo Select' => [
							'ibr' => 500,
							'i'   => 3000,
							'bm'  => 150
						]
					];

					$designation = [
						"BM" => "BM",
						"MF" => "MF",
						"SF" => "SF",
						"BH" => "BDM"
					];

					$bm_prefix = substr($BmId,0,2);
					$bm_desig  = $designation[$bm_prefix] ?? "NA";

					$tc_commi  = $commissionRates[$customer_type]['ibr'] ?? 0;
					$te_commi  = $commissionRates[$customer_type]['i'] ?? 0;
					$bm_commi  = $commissionRates[$customer_type]['bm'] ?? 0;
					$bdm_commi = 0;

					/*
					|--------------------------------------------------------------------------
					| PAYOUT MESSAGES
					|--------------------------------------------------------------------------
					*/

					if ($bm_desig == "BM") {

						$message_bdm =
							"BDM - ".$BdmName." ".$BdmId.
							" earned nothing on onboarding Customer. ".
							"Name of the Customer - ".$name." ".$uid.
							". Onboarding Fee - Rs.".$amount.
							"/-. With Reference of Business Mentor ".
							$BmName." ".$BmId.".";

						$commision_bdm = $bdm_commi;

					} else {

						$message_bdm = "NA";
						$commision_bdm = 0;
					}

					$message_bm =
						$bm_desig." - ".$BmName." ".$BmId.
						" earned Rs.".$bm_commi.
						"/- on onboarding Customer. ".
						"Name of the Customer - ".$name." ".$uid.
						". Onboarding Fee - Rs.".$amount.
						"/-. With Reference of Institution ".
						$te_name." ".$te_id.".";

					$commision_bm = $bm_commi;

					$message_te =
						"I - ".$te_name." ".$te_id.
						" earned Rs.".$te_commi.
						"/- on onboarding Customer. ".
						"Name of the Customer - ".$name." ".$uid.
						". Onboarding Fee - Rs.".$amount.
						"/-. With Reference of Travel Consultant ".
						$tc_name." ".$tc_id.".";

					$commision_te = $te_commi;

					$message_tc =
						"IBR - ".$tc_name." ".$tc_id.
						" earned Rs.".$tc_commi.
						"/- on onboarding Customer. ".
						"Name of the Customer - ".$name." ".$uid.
						". Onboarding Fee - Rs.".$amount."/-";

					$commision_tc = $tc_commi;

					$message_ca_cu =
						"Customer - ".$name." ".$uid.
						" has onboarded with reference of Travel Consultant ".
						$tc_name." ".$tc_id.
						". Onboarding Fee - Rs.".$amount."/-";

					$ca_cu_amt_paid = $amount;
					// DEBUG OUTPUT

				}
				$insertCALSql = "INSERT INTO `ca_cu_payout` (cte_id,message_cte,commision_cte,business_development_manager, message_bdm, commision_bdm,business_mentor, message_bm, commision_bm, techno_enterprise, message_te, commision_te, travel_consultant, message_tc, commision_tc, customer, message_cu, cu_amount_paid, status) 
								VALUES (:cte_id,:message_cte,:commision_cte,:business_development_manager, :message_bdm, :commision_bdm,:business_mentor, :message_bm, :commision_bm,  :techno_enterprise, :message_te, :commision_te, :travel_consultant, :message_tc, :commision_tc, :customer, :message_cu, :cu_amount_paid, :status) ";
				$insertCAL = $conn -> prepare($insertCALSql);
				$result4 = $insertCAL -> execute(array(
		
					':cte_id' => $cteId ?? '',
					':message_cte' => $message_cte ?? '',
					':commision_cte' => $commision_cte ?? '',

					':business_development_manager' => $BdmId,
					':message_bdm' => $message_bdm,
					':commision_bdm' => $commision_bdm,

					':business_mentor' => $BmId,
					':message_bm' => $message_bm,
					':commision_bm' => $commision_bm,
					
					':techno_enterprise' => $te_id, 
					':message_te' => $message_te,
					':commision_te' => $commision_te,
		
					':travel_consultant' => $tc_id,
					':message_tc' => $message_tc,
					':commision_tc' => $tc_commi,

					':customer' => $uid,
					':message_cu' => $message_ca_cu,
					':cu_amount_paid' => $ca_cu_amt_paid,
		
					':status' =>  '2'
				));
			}
			
			
		}else{
			//free customer	non complementary(with payout entry as paid Zero)
			if ($complemetory == 2) {
				if ($reference_id == "TE" || $reference_id == "CA") {
		
					//get corporate agencies/ techno enterprise reference number i.e Travel agent/business mentor to enter it in "payout statments" table
					$sql10 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ta_te_id."'");
					$sql10->execute();
					$sql10->setFetchMode(PDO::FETCH_ASSOC);
					if($sql10->rowCount()>0){
						foreach(($sql10->fetchAll()) as $key10 => $row10){
							$te_id = $row10['corporate_agency_id'];
							$te_name = $row10['firstname']. ' ' .$row10['lastname'];
							$BmId = $row10['reference_no'];
							$BmName = $row10['registrant'];
						}
					}
					if (substr($BmId,0,2) == 'BM') {
						//bm details
						$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$Bm_id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['business_mentor_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						//bdm deatils
						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BdmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);
						if($sql12->rowCount()>0){
							foreach(($sql12->fetchAll()) as $key12 => $row12){
								$BdmId = $row12['employee_id'];
								$BdmName = $row12['name'];
							}
						}
					}
					//if TE ref is BDM
					else if(substr($BmId,0,2) == 'BH'){
												
						//bdm deatils
						$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BmId."'");
						$sql12->execute();
						$sql12->setFetchMode(PDO::FETCH_ASSOC);
						if($sql12->rowCount()>0){
							foreach(($sql12->fetchAll()) as $key12 => $row12){
								$BmId = $row12['employee_id'];
								$BmName = $row12['name'];
							}
						}
					}
		
					$tc_commi = '0';  
					$te_commi = '0';  
					$bm_commi = '0';  
					$bdm_commi = '0';  
					
					$message_bdm = "BDM - ".$BmName." ".$BdmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Business Mentor ".$BmName." ".$BmId.".";
					$commision_bdm = $bdm_commi;
		
					$message_bm = "BM - ".$BmName." ".$BmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Techno Enterprise ".$te_name." ".$te_id.".";
					$commision_bm = $bm_commi;
		
					$message_te = "TE - ".$te_name." ".$te_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Travel Consultant ".$tc_name." ".$tc_id.".";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
		
				}else if($reference_id == "BM"){
		
					$te_id = '';
					$te_name = '';
					
					
					//bm details
					$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$ta_te_id."'");
					$sql11->execute();
					$sql11->setFetchMode(PDO::FETCH_ASSOC);
					if($sql11->rowCount()>0){
						foreach(($sql11->fetchAll()) as $key11 => $row11){
							$BmId = $row11['business_mentor_id'];
							$BmName = $row11['firstname']. ' ' .$row11['lastname'];
							$BdmId = $row11['reference_no'];
							$BdmName = $row11['registrant'];
						}
					}
	
					//bdm deatils
					$sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$BdmId."'");
					$sql12->execute();
					$sql12->setFetchMode(PDO::FETCH_ASSOC);
					if($sql12->rowCount()>0){
						foreach(($sql12->fetchAll()) as $key12 => $row12){
							$BdmId = $row12['employee_id'];
							$BdmName = $row12['name'];
						}
					}
					$te_commi = '0';  
					$tc_commi = '0';  
					$bm_commi = '0';  
					$bdm_commi = '0'; 
					
					$message_bdm = "BDM - ".$BdmName." ".$BdmId." earned nothing on onboarding Customer . With Reference of Business Mentor - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					$commision_bdm = $bdm_commi;
	
					$message_bm = "BM - ".$BmName." ".$BmId." earned nothing on onboarding Customer . With Reference of Travel Consultant - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					$commision_bm = $bm_commi;
		
					$message_te = "Direct Travel Consultant Recrutment Through BM";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Free";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Free Customer onboarding";
					$ca_cu_amt_paid = $amount;
		
				}
				else if($reference_id == "F"){
					
					//get franchisee reference number i.e Travel agent/business mentor to enter it in "payout statments" table
					$sql10 = $conn->prepare("SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '".$ta_te_id."'");
					$sql10->execute();
					$sql10->setFetchMode(PDO::FETCH_ASSOC);
					if($sql10->rowCount()>0){
						foreach(($sql10->fetchAll()) as $key10 => $row10){
							$te_id = $row10['sub_franchisee_id'];
							$te_name = $row10['firstname']. ' ' .$row10['lastname'];
							$Bm_Id = $row10['reference_no'];//substring for MF/SF
							$BmName = $row10['registrant'];
						}
					}
					$f_ref = substr($Bm_Id, 0, 2);
					$commissionRates =[];
					$tc_commi = "";
					$te_commi = "";
					$bm_commi = "";
					$franchisee_ref = "";
					if($f_ref == "MF"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['master_franchisee_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						
						$tc_commi = 0;
						$te_commi = 0;
						$bm_commi = 0; 

						$franchisee_ref = "MF";
					}else if($f_ref == "SF"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['sponsor_franchisee_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						
						$tc_commi = 0;
						$te_commi = 0;
						$bm_commi = 0;

						$franchisee_ref = "SF";
					}
					// Bm ref chain BM -> F -> TC -> CU by SV 11/04/2026
					else if($f_ref == "BM"){
						//MF details
						$sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key11 => $row11){
								$BmId = $row11['business_mentor_id'];
								$BmName = $row11['firstname']. ' ' .$row11['lastname'];
								$BdmId = $row11['reference_no'];
								$BdmName = $row11['registrant'];
							}
						}
						
						$tc_commi = 0;
						$te_commi = 0;
						$bm_commi = 0;

						$franchisee_ref = "BM";
					}
					//check if BH 
					if ($f_ref == "BH") {
						$sql11 = $conn->prepare("SELECT user_type,name,employee_id FROM employees WHERE employee_id = '".$Bm_Id."'");
						$sql11->execute();
						$sql11->setFetchMode(PDO::FETCH_ASSOC);
						if($sql11->rowCount()>0){
							foreach(($sql11->fetchAll()) as $key10 => $row10){
								$emp_user_type=$row10['user_type'];								
							}
						}
						//check user type 31-RM and 25-BDM
						if ($emp_user_type == 25) {
							$franchisee_ref='BDM';
						}elseif ($emp_user_type == 31) {
							$franchisee_ref='RM';
						}
						
						$tc_commi = 0;
						$te_commi = 0;
						$bm_commi = 0;
					}
					
					

					$bdm_commi = '0';  
					
					$message_bdm = "NA";
					$commision_bdm = $bdm_commi;
		
					$message_bm = $franchisee_ref." - ".$BmName." ".$Bm_Id." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Franchisee ".$te_name." ".$te_id.".";
					//for sponser franchisee seperate message similar to MF
					$commision_bm = $bm_commi;
		
					$message_te = "Franchisee - ".$te_name." ".$te_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Travel Consultant ".$tc_name." ".$tc_id.".";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
				}else if($reference_id == "MF"){
					$te_id = '';
					$te_name = '';
					
					//bm details
					$sql11 = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$ta_te_id."' AND status=1");
					$sql11->execute();
					$sql11->setFetchMode(PDO::FETCH_ASSOC);
					if($sql11->rowCount()>0){
						foreach(($sql11->fetchAll()) as $key11 => $row11){
							$BmId = $row11['master_franchisee_id'];
							$BmName = $row11['firstname']. ' ' .$row11['lastname'];
							$BdmId = $row11['reference_no'];
							$BdmName = $row11['registrant'];
						}
					}
					
					$tc_commi = 0;
					$te_commi = 0;
					$bm_commi = 0;  
					$bdm_commi = '0'; //made zero on 25-06-25
					
					$message_bdm = "NA";
					$commision_bdm = $bdm_commi;

					$message_bm = "Master Franchisee - ".$BmName." ".$BmId." earned nothing on onboarding Customer. With Reference of Travel Consultant - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
					$commision_bm = $bm_commi;
		
					$message_te = "Direct Travel Consultant Recrutment Through Master Franchisee";
					$commision_te = $te_commi;
		
					$message_tc = "TC - ".$tc_name." ".$tc_id." earned nothing on onboarding Customer. Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-";
					$commision_tc = $tc_commi;
		
					$message_ca_cu = "Customer - "  .$name." ".$uid. " has onboarded with reference of Travel Consultant " .$tc_name." ".$tc_id.". Onboarding Fee - Rs.".$amount."/-";
					$ca_cu_amt_paid = $amount;
				}
		
				$insertCALSql = "INSERT INTO `ca_cu_payout` (business_development_manager, message_bdm, commision_bdm,business_mentor, message_bm, commision_bm, techno_enterprise, message_te, commision_te, travel_consultant, message_tc, commision_tc, customer, message_cu, cu_amount_paid, status) 
								 VALUES (:business_development_manager, :message_bdm, :commision_bdm,:business_mentor, :message_bm, :commision_bm,  :techno_enterprise, :message_te, :commision_te, :travel_consultant, :message_tc, :commision_tc, :customer, :message_cu, :cu_amount_paid, :status) ";
				$insertCAL = $conn -> prepare($insertCALSql);
				$result4 = $insertCAL -> execute(array(
		
					':business_development_manager' => $BdmId,
					':message_bdm' => $message_bdm??'N/A',
					':commision_bdm' => $commision_bdm??'N/A',
	
					':business_mentor' => $BmId,
					':message_bm' => $message_bm??'N/A',
					':commision_bm' => $commision_bm??'N/A',
					
					':techno_enterprise' => $te_id??'NA', 
					':message_te' => $message_te??'N/A',
					':commision_te' => $commision_te??'N/A',
		
					':travel_consultant' => $tc_id,
					':message_tc' => $message_tc??'N/A',
					':commision_tc' => $tc_commi??'N/A',
	
					':customer' => $uid,
					':message_cu' => $message_ca_cu??'N/A',
					':cu_amount_paid' => $ca_cu_amt_paid??'N/A',
		
					':status' =>  '2'
				));
			}	
		}
		// Customer being referred
		if ($complemetory == 2) {
			//customer ref comission
			$referred_type = $customer_type; 
			$referred_name = $name; 
			$referred_customer_id = $uid; 

			// Helper function to get customer details
			function getCustomerDetailsl1($conn, $customer_id)
			{
				$stmt = $conn->prepare("SELECT ca_customer_id, firstname, lastname, customer_type, reference_no FROM ca_customer WHERE ca_customer_id = ?");
				$stmt->execute([$customer_id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			// Helper function to get customer details
			function getCustomerDetails($conn, $customer_id)
			{
				$stmt = $conn->prepare("SELECT ca_customer_id, firstname, lastname, customer_type, reference_no FROM ca_customer WHERE ca_customer_id = ?");
				$stmt->execute([$customer_id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}

			// Step 1: Get referred customer info (current customer)
			$l1 = getCustomerDetailsl1($conn, $referred_customer_id);
			if (!$l1) {
				die("Customer not found.");
			}

			$l2 = $l3=$l4 = null;
			if (!empty($l1['reference_no'])) {
				$l2 = getCustomerDetails($conn, $l1['reference_no']);
				if ($l2 && !empty($l2['reference_no'])) {
					$l3 = getCustomerDetails($conn, $l2['reference_no']);
					if($l2 && !empty($l2['reference_no'])) {
						$l4= getCustomerDetails($conn, $l3['reference_no']);
					}
				}
			}
			// Rename for consistency
			$level1 = [
				'id' => $l2['ca_customer_id'] ?? null,
				'name' => ($l2['firstname'] ?? '') . ' ' . ($l2['lastname'] ?? ''),
				'customer_type' => $l2['customer_type'] ?? null
			];

			$level2 = [
				'id' => $l3['ca_customer_id'] ?? null,
				'name' => ($l3['firstname'] ?? '') . ' ' . ($l3['lastname'] ?? ''),
				'customer_type' => $l3['customer_type'] ?? null
			];
			$level3 = [
				'id' => $l4['ca_customer_id'] ?? null,
				'name' => ($l4['firstname'] ?? '') . ' ' . ($l4['lastname'] ?? ''),
				'customer_type' => $l4['customer_type'] ?? null
			];
			
			//premium/prime/premium plus not in use
			// === Referred is Prime → only L1 gets Rs.500
			if ($referred_type === 'Prime') {
				if (!empty($level1['id']) && !in_array($level1['customer_type'], ['Premium', 'Premium Plus', 'Premium Select', 'Neo Select', 'Neo Select Ultra'])) {
					// Check for duplicate
					$checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level1'");
					$checkStmt->execute([
						':customer_id' => $level1['id'],
						':refered_customer_id' => $referred_customer_id
					]);
					if (!$checkStmt->fetchColumn()) {
						$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
						$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
													VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
						$stmtCustRef = $conn->prepare($sqlCustRef);
						$stmtCustRef->execute([
							':customer_id' => $level1['id'],
							':customer_type' => $level1['customer_type'],
							':refered_customer_id' => $referred_customer_id,
							':refered_customer_type' => $referred_type,
							':referral_level' => 'Level1',
							':referral_amount' => 500,
							':referral_message' => $referral_message
						]);
						//customer_reference_payout get the id of last entry
						$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 1";
						$stmt_select = $conn->prepare($select_sql);
						$stmt_select->execute();
						
						$ids = [];
						while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
							$ids[] = $row['id'];
						}
						//wallet enrty 
						$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
									VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
						$wallet_stmt = $conn->prepare($wallet_sql);

						$data1 = [
							'transaction_id' => $ids[0],
							'customer_id' => $level1['id'],
							'customer_type' => $level1['customer_type'],
							'redeemable_amt' => 500
						];
						$wallet_stmt->execute($data1);
						
						//balance update for wallet
						//customer_reference_wallet get the id of last entry
						$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 1";
						$stmt_wallet_select = $conn->prepare($select_wallet_sql);
						$stmt_wallet_select->execute();
						
						$wallet_ids = [];
						while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
							$wallet_ids[] = $row['id'];
						}
						//balance enrty 
						$customer_id = $level1['id'];
						$customer_type = $level1['customer_type'];
						$credit_amount = 500; // Amount to credit

						// -------- 1. Wallet Balance Entry --------

						// Get last wallet balance
						$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
													WHERE customer_id = :customer_id 
													ORDER BY id DESC LIMIT 1";
						$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
						$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
						$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

						$current_wallet_balance = ($previous_wallet_balance !== false) 
							? $previous_wallet_balance + $credit_amount 
							: $credit_amount;

						// Insert into wallet utilization
						$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
							(transaction_id, customer_id, earned_amount, balance) 
							VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
						$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

						$wallet_insert_stmt->execute([
							'transaction_id' => $wallet_ids[0],
							'customer_id' => $customer_id,
							'credit_amount' => $credit_amount,
							'balance' => $current_wallet_balance
						]);
						

					}
					//$commissionGiven = true;
				} elseif ($level1['id'] && in_array($level1['customer_type'], ['Premium', 'Premium Plus', 'Premium Select', 'Neo Select', 'Neo Select Ultra'])) {
					//for redeemable amount
					$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.250 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':referral_amount' => 250,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level1['name']} (ID: {$level1['id']}) has gained 250 booking points for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':booking_points' => 250,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'redeemable_amt' => 250
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'booking_points' => 250
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level1['id'];
					$customer_type = $level1['customer_type'];
					$credit_amount = 250; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);
				}
			} elseif (in_array($referred_type, ['Premium', 'Premium Plus','Premium Select','Premium Select','Neo Select', 'Neo Select Ultra'])) {
				$l1_type = $level1['customer_type'];
				$l2_type = $level2['customer_type'];
				$l3_type = $level3['customer_type'];
				if ($l1_type == 'Prime') {
					$checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level1'");
					$checkStmt->execute([
						':customer_id' => $level1['id'],
						':refered_customer_id' => $referred_customer_id
					]);
					if (!$checkStmt->fetchColumn()) {
						$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.1500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
						$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
										VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
						$stmtCustRef = $conn->prepare($sqlCustRef);
						$stmtCustRef->execute([
							':customer_id' => $level1['id'],
							':customer_type' => $level1['customer_type'],
							':refered_customer_id' => $referred_customer_id,
							':refered_customer_type' => $referred_type,
							':referral_level' => 'Level1',
							':referral_amount' => 1500,
							':referral_message' => $referral_message
						]);
						//customer_reference_payout get the id of last entry
						$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 1";
						$stmt_select = $conn->prepare($select_sql);
						$stmt_select->execute();
						
						$ids = [];
						while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
							$ids[] = $row['id'];
						}
						//wallet enrty 
						$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
									VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
						$wallet_stmt = $conn->prepare($wallet_sql);

						$data1 = [
							'transaction_id' => $ids[0],
							'customer_id' => $level1['id'],
							'customer_type' => $level1['customer_type'],
							'redeemable_amt' => 1500
						];
						$wallet_stmt->execute($data1);
						
						//balance update for wallet
						//customer_reference_wallet get the id of last entry
						$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 1";
						$stmt_wallet_select = $conn->prepare($select_wallet_sql);
						$stmt_wallet_select->execute();
						
						$wallet_ids = [];
						while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
							$wallet_ids[] = $row['id'];
						}
						//balance enrty 
						$customer_id = $level1['id'];
						$customer_type = $level1['customer_type'];
						$credit_amount = 1500; // Amount to credit

						// -------- 1. Wallet Balance Entry --------

						// Get last wallet balance
						$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
													WHERE customer_id = :customer_id 
													ORDER BY id DESC LIMIT 1";
						$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
						$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
						$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

						$current_wallet_balance = ($previous_wallet_balance !== false) 
							? $previous_wallet_balance + $credit_amount 
							: $credit_amount;

						// Insert into wallet utilization
						$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
							(transaction_id, customer_id, earned_amount, balance) 
							VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
						$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

						$wallet_insert_stmt->execute([
							'transaction_id' => $wallet_ids[0],
							'customer_id' => $customer_id,
							'credit_amount' => $credit_amount,
							'balance' => $current_wallet_balance
						]);
						

					}
					//$commissionGiven = true;
				}
				if ($l1_type == 'Premium') {
					$checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level1'");
					$checkStmt->execute([
						':customer_id' => $level1['id'],
						':refered_customer_id' => $referred_customer_id
					]);
					if (!$checkStmt->fetchColumn()) {
						$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.1500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
						$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
										VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
						$stmtCustRef = $conn->prepare($sqlCustRef);
						$stmtCustRef->execute([
							':customer_id' => $level1['id'],
							':customer_type' => $level1['customer_type'],
							':refered_customer_id' => $referred_customer_id,
							':refered_customer_type' => $referred_type,
							':referral_level' => 'Level1',
							':referral_amount' => 1500,
							':referral_message' => $referral_message
						]);
						//customer_reference_payout get the id of last entry
						$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 1";
						$stmt_select = $conn->prepare($select_sql);
						$stmt_select->execute();
						
						$ids = [];
						while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
							$ids[] = $row['id'];
						}
						//wallet enrty 
						$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
									VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
						$wallet_stmt = $conn->prepare($wallet_sql);

						$data1 = [
							'transaction_id' => $ids[0],
							'customer_id' => $level1['id'],
							'customer_type' => $level1['customer_type'],
							'redeemable_amt' => 1500
						];
						$wallet_stmt->execute($data1);
						
						//balance update for wallet
						//customer_reference_wallet get the id of last entry
						$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 1";
						$stmt_wallet_select = $conn->prepare($select_wallet_sql);
						$stmt_wallet_select->execute();
						
						$wallet_ids = [];
						while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
							$wallet_ids[] = $row['id'];
						}
						//balance enrty 
						$customer_id = $level1['id'];
						$customer_type = $level1['customer_type'];
						$credit_amount = 1500; // Amount to credit

						// -------- 1. Wallet Balance Entry --------

						// Get last wallet balance
						$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
													WHERE customer_id = :customer_id 
													ORDER BY id DESC LIMIT 1";
						$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
						$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
						$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

						$current_wallet_balance = ($previous_wallet_balance !== false) 
							? $previous_wallet_balance + $credit_amount 
							: $credit_amount;

						// Insert into wallet utilization
						$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
							(transaction_id, customer_id, earned_amount, balance) 
							VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
						$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

						$wallet_insert_stmt->execute([
							'transaction_id' => $wallet_ids[0],
							'customer_id' => $customer_id,
							'credit_amount' => $credit_amount,
							'balance' => $current_wallet_balance
						]);
						

					}
					//$commissionGiven = true;
				}
				//l1 premium plus
				if ($l1_type == 'Premium Plus') {
					//for redeemable amount
					$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.750 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':referral_amount' => 750,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level1['name']} (ID: {$level1['id']}) has gained 750 booking points for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':booking_points' => 750,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'redeemable_amt' => 750
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'booking_points' => 750
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level1['id'];
					$customer_type = $level1['customer_type'];
					$credit_amount = 750; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);
				}
				//l2 premium plus
				if ($l2_type === 'Premium Plus') {
					//level2
					//for redeemable amount
					$referral_message = "{$level2['name']} (ID: {$level2['id']}) has earned Rs.250 as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':referral_amount' => 250,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level2['name']} (ID: {$level2['id']}) has gained 250 booking points as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':booking_points' => 250,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'redeemable_amt' => 250
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'booking_points' => 250
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level2['id'];
					$customer_type = $level2['customer_type'];
					$credit_amount = 250; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);

					//$commissionGiven = true;
				}
				//L3 is preemium plus
				if ($l3_type === 'Premium Plus') {
					//level 3
					//for redeemable amount
					$referral_message = "{$level3['name']} (ID: {$level3['id']}) has earned Rs.125 as a Level 3 referrer for referring {$referred_name} (ID: {$referred_customer_id}), through {$level2['name']} (ID: {$level2['id']}) as Level 2 of {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level3['id'],
						':customer_type' => $level3['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level3',
						':referral_amount' => 125,
						':referral_message' => $referral_message
					]);
					
					//for booking points
					$booking_message = "{$level3['name']} (ID: {$level3['id']}) has gained 125 booking points as a Level 3 referrer for referring {$referred_name} (ID: {$referred_customer_id}), through {$level2['name']} (ID: {$level2['id']}) as Level 2 of {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level3['id'],
						':customer_type' => $level3['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level3',
						':booking_points' => 125,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level3['id'],
						'customer_type' => $level3['customer_type'],
						'redeemable_amt' => 125
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level3['id'],
						'customer_type' => $level3['customer_type'],
						'booking_points' => 125
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level3['id'];
					$customer_type = $level3['customer_type'];
					$credit_amount = 125; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);


					//$commissionGiven = true;
				}
				//l1 Premium Select/Premium Select Lite
                if ($l1_type == 'Premium Select Lite' || $l1_type == 'Premium Select' ) {
                    //for redeemable amount
                    $referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
                    $sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status)
                                                VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
                    $stmtCustRef = $conn->prepare($sqlCustRef);
                    $stmtCustRef->execute([
                        ':customer_id' => $level1['id'],
                        ':customer_type' => $level1['customer_type'],
                        ':refered_customer_id' => $referred_customer_id,
                        ':refered_customer_type' => $referred_type,
                        ':referral_level' => 'Level1',
                        ':referral_amount' => 500,
                        ':referral_message' => $referral_message
                    ]);
 
                    //for booking points
                    $booking_message = "{$level1['name']} (ID: {$level1['id']}) has gained 500 booking points for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
                    $sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status)
                                                VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
                    $stmtCustRef = $conn->prepare($sqlCustRef);
                    $stmtCustRef->execute([
                        ':customer_id' => $level1['id'],
                        ':customer_type' => $level1['customer_type'],
                        ':refered_customer_id' => $referred_customer_id,
                        ':refered_customer_type' => $referred_type,
                        ':referral_level' => 'Level1',
                        ':booking_points' => 500,
                        ':booking_message' => $booking_message
                    ]);
                    //customer_reference_payout get the id of last 2 entries
                    $select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
                    $stmt_select = $conn->prepare($select_sql);
                    $stmt_select->execute();
                   
                    $ids = [];
                    while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
                        $ids[] = $row['id'];
                    }
                    //wallet enrty
                    $wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt)
                                VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
                    $wallet_stmt = $conn->prepare($wallet_sql);
 
                    $data1 = [
                        'transaction_id' => $ids[1],
                        'customer_id' => $level1['id'],
                        'customer_type' => $level1['customer_type'],
                        'redeemable_amt' => 500
                    ];
                    $wallet_stmt->execute($data1);
                    //booking entry in wallet
                    $wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points)
                                VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
                    $wallet_stmt = $conn->prepare($wallet_sql);
 
                    $data2 = [
                        'transaction_id' => $ids[0],
                        'customer_id' => $level1['id'],
                        'customer_type' => $level1['customer_type'],
                        'booking_points' => 500
                    ];
                    $wallet_stmt->execute($data2);
                    //balance update for wallet and booking points
                    //customer_reference_wallet get the id of last 2 entries
                    $select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
                    $stmt_wallet_select = $conn->prepare($select_wallet_sql);
                    $stmt_wallet_select->execute();
                   
                    $wallet_ids = [];
                    while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
                        $wallet_ids[] = $row['id'];
                    }
                    //balance enrty
                    $customer_id = $level1['id'];
                    $customer_type = $level1['customer_type'];
                    $credit_amount = 500; // Amount to credit
 
                    // -------- 1. Wallet Balance Entry --------
 
                    // Get last wallet balance
                    $wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization
                                                WHERE customer_id = :customer_id
                                                ORDER BY id DESC LIMIT 1";
                    $wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
                    $wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
                    $previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();
 
                    $current_wallet_balance = ($previous_wallet_balance !== false)
                        ? $previous_wallet_balance + $credit_amount
                        : $credit_amount;
 
                    // Insert into wallet utilization
                    $wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization
                        (transaction_id, customer_id, earned_amount, balance)
                        VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
                    $wallet_insert_stmt = $conn->prepare($wallet_insert_sql);
 
                    $wallet_insert_stmt->execute([
                        'transaction_id' => $wallet_ids[1],
                        'customer_id' => $customer_id,
                        'credit_amount' => $credit_amount,
                        'balance' => $current_wallet_balance
                    ]);
 
 
                    // -------- 2. Booking Points Entry --------
 
                    // Get last booking balance
                    $booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization
                                                WHERE customer_id = :customer_id
                                                ORDER BY id DESC LIMIT 1";
                    $booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
                    $booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
                    $previous_booking_balance = $booking_balance_check_stmt->fetchColumn();
 
                    $current_booking_balance = ($previous_booking_balance !== false)
                        ? $previous_booking_balance + $credit_amount
                        : $credit_amount;
 
                    // Insert into booking points utilization
                    $booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization
                        (transaction_id, customer_id, earned_amount, balance)
                        VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
                    $booking_insert_stmt = $conn->prepare($booking_insert_sql);
 
                    $booking_insert_stmt->execute([
                        'transaction_id' => $wallet_ids[0],
                        'customer_id' => $customer_id,
                        'credit_amount' => $credit_amount,
                        'balance' => $current_booking_balance
                    ]);
                }
				//l2 Premium Select/Premium Select Lite
				if ($l2_type == 'Premium Select Lite' || $l2_type == 'Premium Select') {
					//level2
					//for redeemable amount
					$referral_message = "{$level2['name']} (ID: {$level2['id']}) has earned Rs.250 as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':referral_amount' => 250,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level2['name']} (ID: {$level2['id']}) has gained 250 booking points as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':booking_points' => 250,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'redeemable_amt' => 250
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'booking_points' => 250
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level2['id'];
					$customer_type = $level2['customer_type'];
					$credit_amount = 250; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);

					//$commissionGiven = true;
				}
				//L3 Premium Select/Premium Select Lite
				if ($l3_type == 'Premium Select Lite' || $l3_type == 'Premium Select') {
					//level 3
					//for redeemable amount
					$referral_message = "{$level3['name']} (ID: {$level3['id']}) has earned Rs.125 as a Level 3 referrer for referring {$referred_name} (ID: {$referred_customer_id}), through {$level2['name']} (ID: {$level2['id']}) as Level 2 of {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level3['id'],
						':customer_type' => $level3['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level3',
						':referral_amount' => 125,
						':referral_message' => $referral_message
					]);
					
					//for booking points
					$booking_message = "{$level3['name']} (ID: {$level3['id']}) has gained 125 booking points as a Level 3 referrer for referring {$referred_name} (ID: {$referred_customer_id}), through {$level2['name']} (ID: {$level2['id']}) as Level 2 of {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level3['id'],
						':customer_type' => $level3['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level3',
						':booking_points' => 125,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level3['id'],
						'customer_type' => $level3['customer_type'],
						'redeemable_amt' => 125
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level3['id'],
						'customer_type' => $level3['customer_type'],
						'booking_points' => 125
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level3['id'];
					$customer_type = $level3['customer_type'];
					$credit_amount = 125; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);


					//$commissionGiven = true;
				}
				//l1 Neo Select
				if ($l1_type == 'Neo Select' ) {
					//for redeemable amount
					$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.1000 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':referral_amount' => 1000,
						':referral_message' => $referral_message
					]);

					
					//balance enrty 
					$customer_id = $level1['id'];
					$customer_type = $level1['customer_type'];
					$credit_amount = 1000; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount,earned_on, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount,:earned_on, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						// 'transaction_id' => $wallet_ids[1],
						'transaction_id' => $uid,
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'earned_on' => $referral_message,
						'balance' => $current_wallet_balance
					]);

				}
				//l2 Neo Select
				if ($l2_type == 'Neo Select') {
					//level2
					//for redeemable amount
					$referral_message = "{$level2['name']} (ID: {$level2['id']}) has earned Rs.500 as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':referral_amount' => 500,
						':referral_message' => $referral_message
					]);
					
					
					//balance enrty 
					$customer_id = $level2['id'];
					$customer_type = $level2['customer_type'];
					$credit_amount = 500; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount,earned_on, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount,:earned_on, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						// 'transaction_id' => $wallet_ids[1],
						'transaction_id' => $uid,
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'earned_on' => $referral_message,
						'balance' => $current_wallet_balance
					]);
				}
				//l1 Neo Select ultra
				if ($l1_type == 'Neo Select Ultra' ) {
					//for redeemable amount
					$referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned Rs.500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 2)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':referral_amount' => 500,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level1['name']} (ID: {$level1['id']}) has gained 500 booking points for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
												VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef = $conn->prepare($sqlCustRef);
					$stmtCustRef->execute([
						':customer_id' => $level1['id'],
						':customer_type' => $level1['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level1',
						':booking_points' => 500,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'redeemable_amt' => 500
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level1['id'],
						'customer_type' => $level1['customer_type'],
						'booking_points' => 500
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level1['id'];
					$customer_type = $level1['customer_type'];
					$credit_amount = 500; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);
				}
				//l2 Neo Select ultra
				if ($l2_type == 'Neo Select Ultra') {
					//level2
					//for redeemable amount
					$referral_message = "{$level2['name']} (ID: {$level2['id']}) has earned Rs.250 as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':referral_amount' => 250,
						':referral_message' => $referral_message
					]);

					//for booking points
					$booking_message = "{$level2['name']} (ID: {$level2['id']}) has gained 250 booking points as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
					$sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, booking_points, booking_message, status) 
									VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :booking_points, :booking_message, 3)";
					$stmtCustRef2 = $conn->prepare($sqlCustRef);
					$stmtCustRef2->execute([
						':customer_id' => $level2['id'],
						':customer_type' => $level2['customer_type'],
						':refered_customer_id' => $referred_customer_id,
						':refered_customer_type' => $referred_type,
						':referral_level' => 'Level2',
						':booking_points' => 250,
						':booking_message' => $booking_message
					]);
					//customer_reference_payout get the id of last 2 entries
					$select_sql = "SELECT id FROM customer_reference_payout ORDER BY id DESC LIMIT 2";
					$stmt_select = $conn->prepare($select_sql);
					$stmt_select->execute();
					
					$ids = [];
					while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
						$ids[] = $row['id'];
					}
					//wallet enrty 
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, redeemable_amt) 
								VALUES (:transaction_id, :customer_id, :customer_type, :redeemable_amt)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data1 = [
						'transaction_id' => $ids[1],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'redeemable_amt' => 250
					];
					$wallet_stmt->execute($data1);
					//booking entry in wallet
					$wallet_sql='INSERT INTO `customer_reference_wallet` (transaction_id, customer_id, customer_type, booking_points) 
								VALUES (:transaction_id, :customer_id, :customer_type, :booking_points)';
					$wallet_stmt = $conn->prepare($wallet_sql);

					$data2 = [
						'transaction_id' => $ids[0],
						'customer_id' => $level2['id'],
						'customer_type' => $level2['customer_type'],
						'booking_points' => 250
					];
					$wallet_stmt->execute($data2);
					//balance update for wallet and booking points
					//customer_reference_wallet get the id of last 2 entries
					$select_wallet_sql = "SELECT id FROM customer_reference_wallet ORDER BY id DESC LIMIT 2";
					$stmt_wallet_select = $conn->prepare($select_wallet_sql);
					$stmt_wallet_select->execute();
					
					$wallet_ids = [];
					while ($row = $stmt_wallet_select->fetch(PDO::FETCH_ASSOC)) {
						$wallet_ids[] = $row['id'];
					}
					//balance enrty 
					$customer_id = $level2['id'];
					$customer_type = $level2['customer_type'];
					$credit_amount = 250; // Amount to credit

					// -------- 1. Wallet Balance Entry --------

					// Get last wallet balance
					$wallet_balance_check_sql = "SELECT balance FROM customer_reference_wallet_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$wallet_balance_check_stmt = $conn->prepare($wallet_balance_check_sql);
					$wallet_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_wallet_balance = $wallet_balance_check_stmt->fetchColumn();

					$current_wallet_balance = ($previous_wallet_balance !== false) 
						? $previous_wallet_balance + $credit_amount 
						: $credit_amount;

					// Insert into wallet utilization
					$wallet_insert_sql = "INSERT INTO customer_reference_wallet_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$wallet_insert_stmt = $conn->prepare($wallet_insert_sql);

					$wallet_insert_stmt->execute([
						'transaction_id' => $wallet_ids[1],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_wallet_balance
					]);


					// -------- 2. Booking Points Entry --------

					// Get last booking balance
					$booking_balance_check_sql = "SELECT balance FROM customer_reference_booking_points_utilization 
												WHERE customer_id = :customer_id 
												ORDER BY id DESC LIMIT 1";
					$booking_balance_check_stmt = $conn->prepare($booking_balance_check_sql);
					$booking_balance_check_stmt->execute(['customer_id' => $customer_id]);
					$previous_booking_balance = $booking_balance_check_stmt->fetchColumn();

					$current_booking_balance = ($previous_booking_balance !== false) 
						? $previous_booking_balance + $credit_amount 
						: $credit_amount;

					// Insert into booking points utilization
					$booking_insert_sql = "INSERT INTO customer_reference_booking_points_utilization 
						(transaction_id, customer_id, earned_amount, balance) 
						VALUES (:transaction_id, :customer_id, :credit_amount, :balance)";
					$booking_insert_stmt = $conn->prepare($booking_insert_sql);

					$booking_insert_stmt->execute([
						'transaction_id' => $wallet_ids[0],
						'customer_id' => $customer_id,
						'credit_amount' => $credit_amount,
						'balance' => $current_booking_balance
					]);

					//$commissionGiven = true;
				}
			}
		}
		// END Customer being referred

		$sql4 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
		$stmt4 = $conn->prepare($sql4);

		$result3 = $stmt4->execute(array(
			':user_id' => $uid,
			':title' => $title,
			':message' => $message,
			':message2' => $message2,
			':reference_no' => $ta_reference_no,
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
?>