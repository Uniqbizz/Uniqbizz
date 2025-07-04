<?php
require '../connect.php';
header('Content-Type: application/json');

$identifier_id = $_POST['id'];
$uid = $identifier_id;
//$customer_type = $_POST['customer_type'];
$payment_label = $_POST['payment_label'];
$chequeNo = $_POST['cheque_no'];
$chequeDate = $_POST['cheque_date'] ?? null;;
$payment_fee = $_POST['payment_fee'];
$paid_amount=$payment_fee;

$bankName = $_POST['bank_name'] ?? null;
$payment_proof = $_POST['payment_proof'];
$transactionNo = $_POST['transaction_no'] ?? null;
$comp_check=$_POST['comp_chek'];
$payment_mode=$_POST['paymentMode'];

//coupon part division
function divideAmount($totalAmount, $fixedAmount = 3000)
{
    $parts = [];

    // How many full ₹3000 parts fit?
    if ($totalAmount == 10000) {
        $fixedAmount = 2500;
    }
    $fullParts = floor($totalAmount / $fixedAmount);
    $remaining = $totalAmount % $fixedAmount;

    // Add full ₹3000 parts
    for ($i = 0; $i < $fullParts; $i++) {
        $parts[] = $fixedAmount;
    }

    // Add remaining amount to last part if needed
    if ($remaining > 0) {
        $parts[] = $remaining;
    }

    return $parts;
}
//generate payment id
function generatePaymentID()
{
    return "PAID" . date("YmdHis"); // Format: PAIDYYYYMMDDHHMMSS
}
//coupon code genaration
function generateUniqueCoupon()
{
    $year = date("Y"); // Get current year
    $uniquePart = bin2hex(random_bytes(6)); // Generate a unique random string (6 bytes = 12 hex characters)

    return strtoupper($year . substr($uniquePart, 0, 11)); // Ensures it's exactly 15 characters
}
//ca_customer update
//payment_proof,payment_mode,cheque_no,cheque_date,bank_name,transactio_no,paid_amount,custome_type,compchek
$sql = "UPDATE ca_customer SET
    payment_proof = :payment_proof,
    payment_mode = :payment_mode,
    cheque_no = :cheque_no,
    cheque_date = :cheque_date,
    bank_name = :bank_name,
    transaction_no = :transaction_no,
    paid_amount = :paid_amount,
    customer_type = :customer_type,
    comp_chek = :comp_chek
WHERE ca_customer_id = :id"; // assuming you're updating by customer ID

$stmt = $conn->prepare($sql);
$result1=$stmt->execute([
    ':payment_proof'   => $payment_proof,
    ':payment_mode'    => $payment_mode,
    ':cheque_no'       => $chequeNo,
    ':cheque_date'     => $chequeDate,
    ':bank_name'       => $bankName,
    ':transaction_no'  => $transactionNo,
    ':paid_amount'     => $paid_amount,
    ':customer_type'   => $payment_label,
    ':comp_chek'      => $comp_check,
    ':id'              => $identifier_id // customer ID
]);
if($result1){
    if ($payment_label == 'Prime') {
    
        // Step 1: Check if coupons already exist and not utilised
        $sqlCheck = "SELECT 
                                COUNT(*) AS total_coupons,
                                CASE 
                                    WHEN SUM(usage_status = 1) > 0 THEN 1
                                    ELSE 0
                                END AS overall_usage_status
                            FROM cu_coupons
                            WHERE user_id = :identifier_id";
    
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->execute([':identifier_id' => $identifier_id]);
        $couponCount = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        // Access values like:
        $totalCoupons = $couponCount['total_coupons'];
        $overallUsageStatus = $couponCount['overall_usage_status'];
    
        // Step 2: Delete only if existing
        // if ($totalCoupons > 0 && $overallUsageStatus !=1) {
        //     $deleteSQL = "DELETE FROM cu_coupons WHERE user_id = :identifier_id";
        //     $deleteStmt = $conn->prepare($deleteSQL);
        //     $deleteStmt->execute([':identifier_id' => $identifier_id]);
        // 	if ($deleteStmt->rowCount() > 0) {
    
        // 		// Step 3: Generate and insert new coupons (3 coupons)
        // 		$cp_parts = divideAmount($payment_fee, 3);
        // 		$payment_id = generatePaymentID();
    
        // 		$sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
        // 							VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
        // 		$stmtInsert = $conn->prepare($sqlInsertCoupon);
    
        // 		foreach ($cp_parts as $coupon_amt) {
        // 			$couponCode = generateUniqueCoupon();
    
        // 			$stmtInsert->execute([
        // 				':user_id' => $identifier_id,
        // 				':payment_id' => $payment_id,
        // 				':code' => $couponCode,
        // 				':coupon_amt' => $coupon_amt,
        // 				':usage_status' => 0,
        // 				':confirm_status' => 0
        // 			]);
        // 		}
    
        // 		// Step 4: Set confirmation status
        // 		$update_coupon = "UPDATE cu_coupons
        // 						  SET confirm_status = :confirm_status
        // 						  WHERE user_id = :id";
        // 		$update_stmt = $conn->prepare($update_coupon);
        // 		$update_stmt->execute([
        // 			':confirm_status' => 1,
        // 			':id' => $identifier_id
        // 		]);
        // 	}
        // }else 
        if ($totalCoupons == 0 && $overallUsageStatus == 0) {
            // Step 3: Generate and insert new coupons (3 coupons)
            $cp_parts = divideAmount($payment_fee);
            $payment_id = generatePaymentID();
    
            $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
                                        VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
            $stmtInsert = $conn->prepare($sqlInsertCoupon);
    
            foreach ($cp_parts as $coupon_amt) {
                $couponCode = generateUniqueCoupon();
    
                $stmtInsert->execute([
                    ':user_id' => $identifier_id,
                    ':payment_id' => $payment_id,
                    ':code' => $couponCode,
                    ':coupon_amt' => $coupon_amt,
                    ':usage_status' => 0,
                    ':confirm_status' => 0
                ]);
            }
    
            // Step 4: Set confirmation status
            $update_coupon = "UPDATE cu_coupons
                                        SET confirm_status = :confirm_status
                                        WHERE user_id = :id";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':confirm_status' => 1,
                ':id' => $identifier_id
            ]);
            // Step 5: Set expiry  date
            $update_coupon = "UPDATE cu_coupons
                              SET expiry_date = DATE_ADD(created_date, INTERVAL 10 YEAR)
                              WHERE  user_id = :id ";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':id' => $identifier_id
            ]);
        }
    } else if ($payment_label == 'Premium') {
    
        // Step 1: Check if coupons already exist and not utilised
        $sqlCheck = "SELECT 
                                COUNT(*) AS total_coupons,
                                CASE 
                                    WHEN SUM(usage_status = 1) > 0 THEN 1
                                    ELSE 0
                                END AS overall_usage_status
                            FROM cu_coupons
                            WHERE user_id = :identifier_id";
    
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->execute([':identifier_id' => $identifier_id]);
        $couponCount = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        // Access values like:
        $totalCoupons = $couponCount['total_coupons'];
        $overallUsageStatus = $couponCount['overall_usage_status'];
    
        // Step 2: Delete only if existing
        // if ($totalCoupons > 0 && $overallUsageStatus !=1) {
        //     $deleteSQL = "DELETE FROM cu_coupons WHERE user_id = :identifier_id";
        //     $deleteStmt = $conn->prepare($deleteSQL);
        //     $deleteStmt->execute([':identifier_id' => $identifier_id]);
        // 	if ($deleteStmt->rowCount() > 0) {
        // 		# code...
        // 		// Step 3: Generate and insert new coupons (10 coupons)
        // 		$cp_parts = divideAmount($payment_fee, 10);
        // 		$payment_id = generatePaymentID();
    
        // 		$sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
        // 							VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
        // 		$stmtInsert = $conn->prepare($sqlInsertCoupon);
    
        // 		foreach ($cp_parts as $coupon_amt) {
        // 			$couponCode = generateUniqueCoupon();
    
        // 			$stmtInsert->execute([
        // 				':user_id' => $identifier_id,
        // 				':payment_id' => $payment_id,
        // 				':code' => $couponCode,
        // 				':coupon_amt' => $coupon_amt,
        // 				':usage_status' => 0,
        // 				':confirm_status' => 0
        // 			]);
        // 		}
    
        // 		// Step 4: Set confirmation status
        // 		$update_coupon = "UPDATE cu_coupons
        // 						  SET confirm_status = :confirm_status
        // 						  WHERE user_id = :id";
        // 		$update_stmt = $conn->prepare($update_coupon);
        // 		$update_stmt->execute([
        // 			':confirm_status' => 1,
        // 			':id' => $identifier_id
        // 		]);
        // 	}
        // }else 
        if ($totalCoupons == 0 && $overallUsageStatus == 0) {
            // Step 3: Generate and insert new coupons 
            $cp_parts = divideAmount($payment_fee);
            $payment_id = generatePaymentID();
    
            $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
                                            VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
            $stmtInsert = $conn->prepare($sqlInsertCoupon);
    
            foreach ($cp_parts as $coupon_amt) {
                $couponCode = generateUniqueCoupon();
    
                $stmtInsert->execute([
                    ':user_id' => $identifier_id,
                    ':payment_id' => $payment_id,
                    ':code' => $couponCode,
                    ':coupon_amt' => $coupon_amt,
                    ':usage_status' => 0,
                    ':confirm_status' => 0
                ]);
            }
    
            // Step 4: Set confirmation status
            $update_coupon = "UPDATE cu_coupons
                                          SET confirm_status = :confirm_status
                                          WHERE user_id = :id";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':confirm_status' => 1,
                ':id' => $identifier_id
            ]);
            // Step 5: Set expiry  date
            $update_coupon = "UPDATE cu_coupons
                              SET expiry_date = DATE_ADD(created_date, INTERVAL 10 YEAR)
                              WHERE  user_id = :id ";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':id' => $identifier_id
            ]);
        }
    } else if ($payment_label == 'Premium Plus') {
    
        // Step 1: Check if coupons already exist and not utilised
        $sqlCheck = "SELECT 
                                COUNT(*) AS total_coupons,
                                CASE 
                                    WHEN SUM(usage_status = 1) > 0 THEN 1
                                    ELSE 0
                                END AS overall_usage_status
                            FROM cu_coupons
                            WHERE user_id = :identifier_id";
    
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->execute([':identifier_id' => $identifier_id]);
        $couponCount = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        // Access values like:
        $totalCoupons = $couponCount['total_coupons'];
        $overallUsageStatus = $couponCount['overall_usage_status'];
    
        // // Step 2: Delete only if existing
        // if ($totalCoupons > 0 && $overallUsageStatus !=1) {
        //     $deleteSQL = "DELETE FROM cu_coupons WHERE user_id = :identifier_id";
        //     $deleteStmt = $conn->prepare($deleteSQL);
        //     $deleteStmt->execute([':identifier_id' => $identifier_id]);
        // 	if ($deleteStmt->rowCount() > 0) {
        // 		# code...
        // 		// Step 3: Generate and insert new coupons (10 coupons)
        // 		$cp_parts = divideAmount($payment_fee, 10);
        // 		$payment_id = generatePaymentID();
    
        // 		$sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
        // 							VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
        // 		$stmtInsert = $conn->prepare($sqlInsertCoupon);
    
        // 		foreach ($cp_parts as $coupon_amt) {
        // 			$couponCode = generateUniqueCoupon();
    
        // 			$stmtInsert->execute([
        // 				':user_id' => $identifier_id,
        // 				':payment_id' => $payment_id,
        // 				':code' => $couponCode,
        // 				':coupon_amt' => $coupon_amt,
        // 				':usage_status' => 0,
        // 				':confirm_status' => 0
        // 			]);
        // 		}
    
        // 		// Step 4: Set confirmation status
        // 		$update_coupon = "UPDATE cu_coupons
        // 						  SET confirm_status = :confirm_status
        // 						  WHERE user_id = :id";
        // 		$update_stmt = $conn->prepare($update_coupon);
        // 		$update_stmt->execute([
        // 			':confirm_status' => 1,
        // 			':id' => $identifier_id
        // 		]);
        // 	}
        // }else 
        if ($totalCoupons == 0 && $overallUsageStatus == 0) {
            // Step 3: Generate and insert new coupons 
            $cp_parts = divideAmount('30000');
            $payment_id = generatePaymentID();
    
            $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status)
                                            VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
            $stmtInsert = $conn->prepare($sqlInsertCoupon);
    
            foreach ($cp_parts as $coupon_amt) {
                $couponCode = generateUniqueCoupon();
    
                $stmtInsert->execute([
                    ':user_id' => $identifier_id,
                    ':payment_id' => $payment_id,
                    ':code' => $couponCode,
                    ':coupon_amt' => $coupon_amt,
                    ':usage_status' => 0,
                    ':confirm_status' => 0
                ]);
            }
    
            // Step 4: Set confirmation status
            $update_coupon = "UPDATE cu_coupons
                                          SET confirm_status = :confirm_status
                                          WHERE user_id = :id";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':confirm_status' => 1,
                ':id' => $identifier_id
            ]);
            // Step 5: Set expiry  date
            $update_coupon = "UPDATE cu_coupons
                              SET expiry_date = DATE_ADD(created_date, INTERVAL 10 YEAR)
                              WHERE  user_id = :id ";
            $update_stmt = $conn->prepare($update_coupon);
            $update_stmt->execute([
                ':id' => $identifier_id
            ]);
        }
    } else if ($payment_mode == 'Free') {
        // Delete all existing coupons if payment mode is Free
        // $deleteSQL = "DELETE FROM cu_coupons WHERE user_id = :identifier_id";
        // $deleteStmt = $conn->prepare($deleteSQL);
        // $deleteStmt->execute([':identifier_id' => $identifier_id]);
    }
    //get customer details
    $sql9 = $conn->prepare("SELECT * from ca_customer where ca_customer_id='" . $identifier_id . "' and status='1'");
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
            $amount = $row9['paid_amount'];
            $complemetory = $row9['comp_chek'];
            $cu_reference_no = $row9['reference_no'] ?? 'NA';
        }
    }
    $refid = '';
    $register_by = '';
    //get the TC TE/BM who regitered this TC
    $sqlta = $conn->prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '" . $ta_reference_no . "'");
    $sqlta->execute();
    $sqlta->setFetchMode(PDO::FETCH_ASSOC);
    if ($sqlta->rowCount() > 0) {
        foreach (($sqlta->fetchAll()) as $keyta => $rowta) {
            $tc_id = $rowta['ca_travelagency_id'];
            $tc_name = $rowta['firstname'] . ' ' . $rowta['lastname'];
            $ta_te_id = $rowta['reference_no'];
            $ta_te_name = $rowta['registrant'];
        }
        $refid=$tc_id;
        $register_by=$tc_name;
    } else {
        $tc_id = 'N/A';
        $tc_name = 'N/A';
        $ta_te_id = 'N/A';
        $ta_te_name = 'N/A';
    }
    
    //identify TC ref TE/BM
    $reference_id = substr($ta_te_id, 0, 2);
    if ($complemetory == 2) {
        if ($reference_id == "TE" || $reference_id == "CA") {
    
            //get corporate agencies/ techno enterprise reference number i.e Travel agent/business mentor to enter it in "payout statments" table
            $sql10 = $conn->prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $ta_te_id . "'");
            $sql10->execute();
            $sql10->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql10->rowCount() > 0) {
                foreach (($sql10->fetchAll()) as $key10 => $row10) {
                    $te_id = $row10['corporate_agency_id'];
                    $te_name = $row10['firstname'] . ' ' . $row10['lastname'];
                    $BmId = $row10['reference_no'];
                    $BmName = $row10['registrant'];
                }
            }
            //bm details
            $sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '" . $Bm_id . "'");
            $sql11->execute();
            $sql11->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql11->rowCount() > 0) {
                foreach (($sql11->fetchAll()) as $key11 => $row11) {
                    $BmId = $row11['business_mentor_id'];
                    $BmName = $row11['firstname'] . ' ' . $row11['lastname'];
                    $BdmId = $row11['reference_no'];
                    $BdmName = $row11['registrant'];
                }
            }
    
            //bdm deatils
            $sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $BdmId . "'");
            $sql12->execute();
            $sql12->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql12->rowCount() > 0) {
                foreach (($sql12->fetchAll()) as $key12 => $row12) {
                    $BdmId = $row12['employee_id'];
                    $BdmName = $row12['name'];
                }
            }
    
            $commissionRates = [
                'Prime' => ['tc' => 800, 'te' => 400, 'bm' => 120],
                'Premium' => ['tc' => 1500, 'te' => 750, 'bm' => 225],
                'Premium Plus' => ['tc' => 1500, 'te' => 750, 'bm' => 225]
            ];
    
            $tc_commi = $commissionRates[$payment_label]['tc'] ?? 0;
            $te_commi = $commissionRates[$payment_label]['te'] ?? 0;
            $bm_commi = $commissionRates[$payment_label]['bm'] ?? 0;
            $bdm_commi = '0';
    
            // $message_bdm = "BDM - ".$BmName." ".$BdmId." earned nothing on onboarding Customer . Name of the Customer - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-. With Reference of Business Mentor ".$Bm_name." ".$Bm_id.".";
            // $commision_bdm = $bdm_commi;
            $message_bdm = "BDM - " . $BmName . " " . $BdmId . " earned nothing on onboarding Customer . Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-. With Reference of Business Mentor " . $BmName . " " . $BmId . ".";
            $commision_bdm = $bdm_commi;
    
            $message_bm = "BM - " . $BmName . " " . $BmId . " earned Rs." . $bm_commi . "/- on onboarding Customer . Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-. With Reference of Techno Enterprise " . $te_name . " " . $te_id . ".";
            $commision_bm = $bm_commi;
    
            $message_te = "TE - " . $te_name . " " . $te_id . " earned Rs." . $te_commi . "/- on onboarding Customer. Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-. With Reference of Travel Consultant " . $tc_name . " " . $tc_id . ".";
            $commision_te = $te_commi;
    
            $message_tc = "TC - " . $tc_name . " " . $tc_id . " earned Rs." . $tc_commi . "/- on onboarding Customer. Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-";
            $commision_tc = $tc_commi;
    
            $message_ca_cu = "Customer - "  . $name . " " . $uid . " has onboarded with reference of Travel Consultant " . $tc_name . " " . $tc_id . ". Onboarding Fee - Rs." . $amount . "/-";
            $ca_cu_amt_paid = $amount;
        } else if ($reference_id == "BM") {
    
            $te_id = '';
            $te_name = '';
    
            // echo '<script>alert(refernce:"'.$ta_te_id.'")</script>';
            // exit;
            //bm details
            $sql11 = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '" . $ta_te_id . "' AND status=1");
            $sql11->execute();
            $sql11->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql11->rowCount() > 0) {
                foreach (($sql11->fetchAll()) as $key11 => $row11) {
                    $BmId = $row11['business_mentor_id'];
                    $BmName = $row11['firstname'] . ' ' . $row11['lastname'];
                    $BdmId = $row11['reference_no'];
                    $BdmName = $row11['registrant'];
                }
            }
    
            //bdm details
            //bdm deatils
            $sql12 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $BdmId . "' AND status='1' AND user_type='25'");
            $sql12->execute();
            $sql12->setFetchMode(PDO::FETCH_ASSOC);
            if ($sql12->rowCount() > 0) {
                foreach (($sql12->fetchAll()) as $key12 => $row12) {
                    $BdmId = $row12['employee_id'];
                    $BdmName = $row12['name'];
                }
            }
            $commissionRates = [
                'Prime' => ['tc' => 800, 'te' => 0, 'bm' => 400],
                'Premium' => ['tc' => 1500, 'te' => 0, 'bm' => 750],
                'Premium Plus' => ['tc' => 1500, 'te' => 0, 'bm' => 750]
            ];
    
            $tc_commi = $commissionRates[$payment_label]['tc'] ?? 0;
            $te_commi = $commissionRates[$payment_label]['te'] ?? 0;
            $bm_commi = $commissionRates[$payment_label]['bm'] ?? 0;
            $bdm_commi = '0'; //made zero on 25-06-25
    
            // $message_bdm = "BDM - ".$BdmName." ".$BdmId." earned Rs.".$bdm_commi."/- on onboarding Customer . With Reference of Business Mentor - " .$name." ".$uid. ". Onboarding Fee - Rs.".$amount."/-.";
            // $commision_bdm = $bdm_commi;
            $message_bdm = "BDM - " . $BdmName . " " . $BdmId . " earned nothing on onboarding Customer . Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-. With Reference of Business Mentor " . $BmName . " " . $BmId . ".";
            $commision_bdm = $bdm_commi;
    
            $message_bm = "BM - " . $BmName . " " . $BmId . " earned Rs." . $bm_commi . "/- on onboarding Customer . With Reference of Travel Consultant - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-.";
            $commision_bm = $bm_commi;
    
            $message_te = "Direct Travel Consultant Recrutment Through BM";
            $commision_te = $te_commi;
    
            $message_tc = "TC - " . $tc_name . " " . $tc_id . " earned Rs." . $tc_commi . "/- on onboarding Customer. Name of the Customer - " . $name . " " . $uid . ". Onboarding Fee - Rs." . $amount . "/-";
            $commision_tc = $tc_commi;
    
            $message_ca_cu = "Customer - "  . $name . " " . $uid . " has onboarded with reference of Travel Consultant " . $tc_name . " " . $tc_id . ". Onboarding Fee - Rs." . $amount . "/-";
            $ca_cu_amt_paid = $amount;
        }
    
        $insertCALSql = "INSERT INTO `ca_cu_payout` (business_development_manager, message_bdm, commision_bdm,business_mentor, message_bm, commision_bm, techno_enterprise, message_te, commision_te, travel_consultant, message_tc, commision_tc, customer, message_cu, cu_amount_paid, status) 
                                    VALUES (:business_development_manager, :message_bdm, :commision_bdm,:business_mentor, :message_bm, :commision_bm,  :techno_enterprise, :message_te, :commision_te, :travel_consultant, :message_tc, :commision_tc, :customer, :message_cu, :cu_amount_paid, :status) ";
        $insertCAL = $conn->prepare($insertCALSql);
        $result4 = $insertCAL->execute(array(
    
            ':business_development_manager' => $BdmId ?? 'NA',
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
        // Customer being referred
        //customer ref comission
        $referred_type = $payment_label;
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
    
        $l2 = $l3 = $l4 = null;
        if (!empty($l1['reference_no'])) {
            $l2 = getCustomerDetails($conn, $l1['reference_no']);
            if ($l2 && !empty($l2['reference_no'])) {
                $l3 = getCustomerDetails($conn, $l2['reference_no']);
                if ($l2 && !empty($l2['reference_no'])) {
                    $l4 = getCustomerDetails($conn, $l3['reference_no']);
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
    
    
        // === Referred is Prime → only L1 gets ₹500
        if ($referred_type === 'Prime') {
            if ($level1['id']) {
                // Check for duplicate
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level1'");
                $checkStmt->execute([
                    ':customer_id' => $level1['id'],
                    ':refered_customer_id' => $referred_customer_id
                ]);
                $refid = $level1['id'];
                $register_by = $referred_customer_id;
                if (!$checkStmt->fetchColumn()) {
                    $referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned ₹500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
                    $sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
                                                    VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
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
                }
                //$commissionGiven = true;
            }
        } elseif (in_array($referred_type, ['Premium', 'Premium Plus'])) {
            $l1_type = $level1['customer_type'];
            $l2_type = $level2['customer_type'];
            $l3_type = $level3['customer_type'];
            if (in_array($l1_type, ['Premium', 'Premium Plus'])) {
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level1'");
                $checkStmt->execute([
                    ':customer_id' => $level1['id'],
                    ':refered_customer_id' => $referred_customer_id
                ]);
                $refid = $level1['id'];
                $register_by = $referred_customer_id;
                if (!$checkStmt->fetchColumn()) {
                    $referral_message = "{$level1['name']} (ID: {$level1['id']}) has earned ₹1500 for referring {$referred_name} (ID: {$referred_customer_id}) as a Level 1 referrer.";
                    $sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
                                        VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
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
                }
                //$commissionGiven = true;
            }
            //l2 premium plus
            if ($l2_type === 'Premium Plus') {
                //level2
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level2'");
                $checkStmt->execute([
                    ':customer_id' => $level2['id'],
                    ':refered_customer_id' => $referred_customer_id
                ]);
                $refid = $level1['id'];
                $register_by = $referred_customer_id;
                if (!$checkStmt->fetchColumn()) {
                    $referral_message = "{$level2['name']} (ID: {$level2['id']}) has earned ₹500 as a Level 2 referrer for referring {$referred_name} (ID: {$referred_customer_id}) through {$level1['name']} (ID: {$level1['id']}).";
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
                }
                //$commissionGiven = true;
            }
            //L3 is preemium plus
            if ($l3_type === 'Premium Plus') {
                $checkStmt = $conn->prepare("SELECT COUNT(*) FROM customer_reference_payout WHERE customer_id = :customer_id AND refered_customer_id = :refered_customer_id AND referral_level = 'Level3'");
                $checkStmt->execute([
                    ':customer_id' => $level3['id'],
                    ':refered_customer_id' => $referred_customer_id
                ]);
                $refid = $level1['id'];
                $register_by = $referred_customer_id;
                if (!$checkStmt->fetchColumn()) {
                    $referral_message = "{$level3['name']} (ID: {$level3['id']}) has earned ₹250 as a Level 3 referrer for referring {$referred_name} (ID: {$referred_customer_id}), through {$level2['name']} (ID: {$level2['id']}) as Level 2 of {$level1['name']} (ID: {$level1['id']}).";
                    $sqlCustRef = "INSERT INTO customer_reference_payout (customer_id, customer_type, refered_customer_id, refered_customer_type, referral_level, referral_amount, referral_message, status) 
                                        VALUES (:customer_id, :customer_type, :refered_customer_id, :refered_customer_type, :referral_level, :referral_amount, :referral_message, 0)";
                    $stmtCustRef = $conn->prepare($sqlCustRef);
                    $stmtCustRef->execute([
                        ':customer_id' => $level3['id'],
                        ':customer_type' => $level3['customer_type'],
                        ':refered_customer_id' => $referred_customer_id,
                        ':refered_customer_type' => $referred_type,
                        ':referral_level' => 'Level3',
                        ':referral_amount' => 250,
                        ':referral_message' => $referral_message
                    ]);
                }
                //$commissionGiven = true;
            }
        }
        // END Customer being referred
    }
}
//logs
$message = $identifier_id . " Coupons has been generated of " . $payment_label . " type";
$message2 = $identifier_id . " Coupons has been generated of" . $payment_label . " type";
$sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom, operation) 
			VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom, :operation)";
$stmt3 = $conn->prepare($sql3);

$result3 = $stmt3->execute(array(
    ':user_id' => $identifier_id,
    ':title' => 'Coupon Code Generation',
    ':message' => $message,
    ':message2' => $message2,
    ':reference_no' => $refid,
    ':register_by' => $register_by,
    ':from_whom' => 1,
    ':operation' => 'Membership Upgrade'
));
echo 1;
///
