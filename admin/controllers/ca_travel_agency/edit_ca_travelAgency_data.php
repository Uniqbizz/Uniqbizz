<?php
	require "../../connect.php";

	$current_year = date('Y');

	$fid = $_POST["ref_id"];
	$editfor = $_POST["editfor"];
	$identifier_id = $_POST["id"];

	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$nominee_name = $_POST['nominee_name'];
	$nominee_relation = $_POST['nominee_relation'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$country_code = $_POST['country_code'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];

	$profile_pic = $_POST['profile_pic'];
	$pan_card = $_POST['pan_card'];
	$aadhar_card = $_POST['aadhar_card'];
	$voting_card = $_POST['voting_card'];
	$bank_passbook = $_POST['passbook'];

	$payment_proof = $_POST['payment_proof'];
	$payment_mode = $_POST['paymentMode'];
	$cheque_no = $_POST['chequeNo'];
	$cheque_date = $_POST['chequeDate'];
	$bank_name = $_POST['bankName'];
	$transaction_no = $_POST['transactionNo'];

	$address = $_POST['address'];
	$pincode = $_POST['pincode'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$city = $_POST['city'];

	$payment_fee = $_POST['payment_fee'];
	$note = $_POST['note'];
	$comp_check = $_POST['comp_check'];

	$edit_reason = $_POST['edit_reason'] ?? '';

	$user_type_id = '11';
	$title = "Travel Consultant";
	$fromWhom = "1";
	$register_by = "1";
	$operation = 'Update';
	$ip_address = 'NA';

	/* -------------------------
	AGE CALCULATION
	------------------------- */

	$birthYear = str_split($dob,4);
	$age = $current_year - $birthYear[0];

	/* -------------------------
	IDENTIFIER COLUMN
	------------------------- */

	if ($editfor == 'pending') {

		$identifier_column = 'id';
		$message = "Updated Travel Consultant details from pending list";

	} else {

		$identifier_column = 'ca_travelagency_id';
		$message = "{$identifier_id} Details has been updated from registered list";

	}

	/* -------------------------
	FETCH PREVIOUS DATA
	------------------------- */

	$stmt = $conn->prepare("SELECT * FROM ca_travelagency WHERE $identifier_column = :id");
	$stmt->execute(['id'=>$identifier_id]);
	$prevUserData = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

	/* -------------------------
	NEW DATA ARRAY
	------------------------- */

	$newUserData = [

		"firstname"=>$firstname,
		"lastname"=>$lastname,
		"nominee_name"=>$nominee_name,
		"nominee_relation"=>$nominee_relation,
		"country_code"=>$country_code,
		"contact_no"=>$phone,
		"email"=>$email,
		"gender"=>$gender,
		"date_of_birth"=>$dob,
		"age"=>$age,
		"country"=>$country,
		"state"=>$state,
		"city"=>$city,
		"pincode"=>$pincode,
		"address"=>$address,
		"note"=>$note,
		"comp_check"=>$comp_check,
		"profile_pic"=>$profile_pic,
		"pan_card"=>$pan_card,
		"aadhar_card"=>$aadhar_card,
		"voting_card"=>$voting_card,
		"passbook"=>$bank_passbook,
		"amount"=>$payment_fee,
		"payment_mode"=>$payment_mode,
		"cheque_no"=>$cheque_no,
		"cheque_date"=>$cheque_date,
		"bank_name"=>$bank_name,
		"transaction_no"=>$transaction_no,
		"payment_proof"=>$payment_proof

	];

	/* -------------------------
	COMPARE CHANGES
	------------------------- */

	$ignoreColumns = [
		'age',
		'amount',
		'payment_mode',
		'cheque_no',
		'cheque_date',
		'bank_name',
		'transaction_no',
		'payment_proof'
	];

	$changes = [];

	foreach($newUserData as $column=>$newValue){

		if(in_array($column,$ignoreColumns)){
			continue;
		}

		$oldValue = $prevUserData[$column] ?? '';

		$oldValue = trim((string)$oldValue);
		$newValue = trim((string)$newValue);

		if($oldValue === $newValue){
			continue;
		}

		$changes[] = [
			"column"=>$column,
			"old"=>$oldValue,
			"new"=>$newValue
		];
	}

	/* -------------------------
	UPDATE TRAVEL CONSULTANT
	------------------------- */

	$sql = "UPDATE ca_travelagency SET

		firstname=:firstname,
		lastname=:lastname,
		nominee_name=:nominee_name,
		nominee_relation=:nominee_relation,
		country_code=:country_code,
		contact_no=:contact_no,
		email=:email,
		gender=:gender,
		date_of_birth=:date_of_birth,
		age=:age,
		country=:country,
		state=:state,
		city=:city,
		pincode=:pincode,
		address=:address,
		note=:note,
		comp_check=:comp_check,
		profile_pic=:profile_pic,
		pan_card=:pan_card,
		aadhar_card=:aadhar_card,
		voting_card=:voting_card,
		passbook=:passbook,
		amount=:amount,
		payment_mode=:payment_mode,
		cheque_no=:cheque_no,
		cheque_date=:cheque_date,
		bank_name=:bank_name,
		transaction_no=:transaction_no,
		payment_proof=:payment_proof

	WHERE $identifier_column=:identifier_id";

	$stmt = $conn->prepare($sql);

	$result = $stmt->execute([

		':firstname'=>$firstname,
		':lastname'=>$lastname,
		':nominee_name'=>$nominee_name,
		':nominee_relation'=>$nominee_relation,
		':country_code'=>$country_code,
		':contact_no'=>$phone,
		':email'=>$email,
		':gender'=>$gender,
		':date_of_birth'=>$dob,
		':age'=>$age,
		':country'=>$country,
		':state'=>$state,
		':city'=>$city,
		':pincode'=>$pincode,
		':address'=>$address,
		':note'=>$note,
		':comp_check'=>$comp_check,
		':profile_pic'=>$profile_pic,
		':pan_card'=>$pan_card,
		':aadhar_card'=>$aadhar_card,
		':voting_card'=>$voting_card,
		':passbook'=>$bank_passbook,
		':amount'=>$payment_fee,
		':payment_mode'=>$payment_mode,
		':cheque_no'=>$cheque_no,
		':cheque_date'=>$cheque_date,
		':bank_name'=>$bank_name,
		':transaction_no'=>$transaction_no,
		':payment_proof'=>$payment_proof,
		':identifier_id'=>$identifier_id

	]);

	/* -------------------------
	INSERT EDIT LOGS
	------------------------- */

	if($result && !empty($changes)){

		foreach($changes as $change){

			$stmtLog = $conn->prepare("
				INSERT INTO field_edit_logs
				(table_name,record_id,column_name,old_value,new_value,change_reason,changed_by,changed_role,ip_address)
				VALUES
				(:table_name,:record_id,:column_name,:old_value,:new_value,:change_reason,:changed_by,:changed_role,:ip_address)
			");

			$stmtLog->execute([
				':table_name'=>'ca_travelagency',
				':record_id'=>$identifier_id,
				':column_name'=>$change['column'],
				':old_value'=>$change['old'],
				':new_value'=>$change['new'],
				':change_reason'=>$edit_reason,
				':changed_by'=>$register_by,
				':changed_role'=>'admin',
				':ip_address'=>$ip_address
			]);
		}
	}

	/* -------------------------
	UPDATE LOGIN
	------------------------- */

	$stmt2 = $conn->prepare("UPDATE login SET username=:email WHERE user_id=:user_id AND user_type_id=:user_type_id");

	$stmt2->execute([
		':email'=>$email,
		':user_id'=>$identifier_id,
		':user_type_id'=>$user_type_id
	]);

	/* -------------------------
	SYSTEM LOG
	------------------------- */

	$stmt3 = $conn->prepare("INSERT INTO logs
	(user_id,title,message,message2,reference_no,register_by,from_whom,operation)
	VALUES
	(:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)");

	$result3 = $stmt3->execute([

		':user_id'=>$identifier_id,
		':title'=>$title,
		':message'=>$message,
		':message2'=>$message,
		':reference_no'=>$fid,
		':register_by'=>$register_by,
		':from_whom'=>$fromWhom,
		':operation'=>$operation

	]);

	echo $result3 ? 1 : 0;
?>