<?php

	include_once(__DIR__ . '/../../../dashboard_user_details.php');

	$current_year = date('Y');

	$refid = $_POST["ref_id"];
	$id = $_POST["id"];
	$editfor = $_POST["editfor"];

	if ($editfor == 'pending') {
		$identifier_id = $id;
		$identifier_name = 'id=';
		$message = "Updated Institution details from " . $editfor . " list";
		$message2 = "Updated Institution details from " . $editfor . " list";
	} else if ($editfor == 'registered') {
		$identifier_id = $id;
		$identifier_name = 'institution_id=';
		$message = $identifier_id . " Details has been updated from " . $editfor . " list";
		$message2 = $identifier_id . " Details has been updated from " . $editfor . " list";
	}

	$action_type = $_POST['action_type'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number_branch = $_POST['number_branch'];
    $institution_type_value = $_POST['institution_type_value'];
    $incorporation_date = $_POST['incorporation_date'];
    $country_code = $_POST['country_code'];
    $phone = $_POST['phone'];
    $institution_pan = $_POST['institution_pan'];

    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];

    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $ifsc_code = $_POST['ifsc_code'];
    $branch_name = $_POST['branch_name'];

    $amount = $_POST['amount'];
    $payment_proof = $_POST['payment_proof'];
    $paymentMode = $_POST['paymentMode'];

    $chequeNo = $_POST['chequeNo'];
    $chequeDate = $_POST['chequeDate'];
    $bankName = $_POST['bankName'];
    $transactionNo = $_POST['transactionNo'];

    $certificate_of_incorporation = $_POST['certificate_of_incorporation'];
    $gstin = $_POST['gstin'];
    $board_resolution = $_POST['board_resolution'];
    $bank_passbook = $_POST['cancelled_cheque_bank_passbook'];
    $pancard = $_POST['pancard'];
    $address_proof = $_POST['address_proof'];
    $payment_proof = $_POST['payment_proof'];

	$user_type_id = '32';

	$title = "Institution";

	$fromWhom = "1";
	$register_by = "1";
	$operation = "Update";

	$sql1 = "UPDATE `institution` SET
            `name` = :name,
            `no_of_branches` = :no_of_branches,
            `types_of_institution` = :types_of_institution,
            `incorporation_date` = :incorporation_date,
            `institution_pan` = :institution_pan,

            `email` = :email,
            `country_code` = :country_code,
            `contact_no` = :contact_no,
            `country` = :country,
            `state` = :state,
            `city` = :city,
            `pincode` = :pincode,
            `address` = :address,

            `account_name` = :account_name,
            `account_number` = :account_number,
            `ifsc_code` = :ifsc_code,
            `bank_and_branch_name` = :bank_and_branch_name,

            `amount` = :amount,
            `payment_mode` = :payment_mode,

            `cheque_no` = :cheque_no,
            `cheque_date` = :cheque_date,
            `bank_name` = :bank_name,
            `transaction_no` = :transaction_no,

            `certificate_of_incorporation` = :certificate_of_incorporation,
            `gstin` = :gstin,
            `pan_card` = :pan_card,
            `address_proof` = :address_proof,
            `board_resolution` = :board_resolution,
            `bank_passbook` = :bank_passbook,
            `payment_proof` = :payment_proof
        WHERE $identifier_name:identifier_id";
	$stmt = $conn->prepare($sql1);
	$result =  $stmt->execute(array(
		':name' => $name,
		':no_of_branches' => $number_branch,
		':types_of_institution' => $institution_type_value,
		':incorporation_date' => $incorporation_date,
		':institution_pan' => $institution_pan,

		':email' => $email,
		':country_code' => $country_code,
		':contact_no' => $phone,
		':country' => $country,
		':state' => $state,
		':city' => $city,
		':pincode' => $pincode,
		':address' => $address,

		':account_name' => $account_name,
		':account_number' => $account_number,
		':ifsc_code' => $ifsc_code,
		':bank_and_branch_name' => $branch_name,

		':amount' => $amount,
		':payment_mode' => $paymentMode,

		':cheque_no' => $chequeNo,
		':cheque_date' => $chequeDate,
		':bank_name' => $bankName,
		':transaction_no' => $transactionNo,

		':certificate_of_incorporation' => $certificate_of_incorporation,
		':gstin' => $gstin,
		':pan_card' => $pancard,
		':address_proof' => $address_proof,
		':board_resolution' => $board_resolution,
		':bank_passbook' => $bank_passbook,
		':payment_proof' => $payment_proof,
		':identifier_id' => $identifier_id
	));

	if ($result) {

		$sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
		$stmt2 = $conn->prepare($sql);
		$result2 =  $stmt2->execute(array(
			':email' => $email,
			':user_type_id' => $user_type_id,
			':user_id' => $identifier_id
		));

		
		if ($result2) {

			$sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";
			$stmt3 = $conn->prepare($sql3);

			$result3 = $stmt3->execute(array(
				':user_id' => $identifier_id,
				':title' => $title,
				':message' => $message,
				':message2' => $message2,
				':reference_no' => $refid,
				':register_by' => $register_by,
				':from_whom' => $fromWhom,
				':operation' => $operation
			));

			if ($result3) {
				echo 1;
			} else {
				echo 0;
			}
			// echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}
	
?>
