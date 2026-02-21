//select register
$('#registered').on('change',function(){
	var register_type = $(this).val();
	if(register_type == 'business_mentor'){
		$('#designation1').prop('disabled',false);
		$('#designation1').removeClass('d-none');
		$('#designation2').addClass('d-none');
		$('#payment_fee').prop('disabled',false);
		$('#payment_fee2').addClass('d-none');
		$('#payment_fee').removeClass('d-none');
	}else if(register_type == 'master_franchisee'){
		$('#designation1').prop('disabled',true);
		$('#designation2').prop('disabled',true);
		$('#payment_fee').addClass('d-none');
		$('#payment_fee2').removeClass('d-none');
	}else if(register_type == 'sponsor_franchisee'){
		$('#designation1').prop('disabled',true);
		$('#designation2').prop('disabled',true);
		$('#payment_fee').addClass('d-none');
		$('#payment_fee2').removeClass('d-none');
	}
});

//select Designation
$('#designation1').on('change', function() {
	var designation = $('#designation1').val();
	$.ajax({
		type: 'POST',
		url: '../../agents/get_user_Franchisee.php',
		data: "designation=" + designation,
		success: function(e) {
			$('#user_id_name').html(e);
		},
		error: function(err) {
			console.log(err);
		},
	});
});
$('#designation2').on('change', function() {
	var designation = $('#designation2').val();
	$.ajax({
		type: 'POST',
		url: '../../agents/get_user_Franchisee.php',
		data: "designation=" + designation,
		success: function(e) {
			$('#user_id_name').html(e);
		},
		error: function(err) {
			console.log(err);
		},
	});
});

// fetch User based on selected designation
$('#user_id_name').on('change', function() {
	var user_id_name = $(this).val();
	var designation = 'ca_franchisee';

	$.ajax({
		type: 'POST',
		url: '../../agents/getUsers.php',
		data: 'user_id_name=' + user_id_name + '&designation=' + designation,
		success: function(response) {
			$('#pin').html(response);
			$('#reference_name').val(response);
		}
	});

});

$('#country').on('change', function() {
	var countryID = $(this).val();
	if (countryID) {
		$.ajax({
			type: 'POST',
			url: '../../address/countrydata.php',
			data: 'country_id=' + countryID,
			success: function(htmll) {
				$('#mystate').html(htmll);
				$('#city').html('<option value="">Select state first</option>');
			}
		});
	} else {
		$('#mystate').html('<option value="">Select country first</option>');
		$('#city').html('<option value="">Select state first</option>');
		$('#pin').val('');
	}
});

$('#mystate').on('change', function() {
	var stateID = $(this).val();
	if (stateID) {
		$.ajax({
			type: 'POST',
			url: '../../address/countrydata.php',
			data: 'state_id=' + stateID,
			success: function(html) {
				$('#city').html(html);
			}
		});
	} else {
		$('#city').html('<option value="">Select state first</option>');
		$('#pin').val('');
	}
});

$('#city').on('change', function() {
	var cityID = $(this).val();
	if (cityID) {
		$.ajax({
			type: 'POST',
			url: '../../address/pincode.php',
			data: 'city_id=' + cityID,
			success: function(response) {
				$('#pin').val(response);
			}
		});
	} else {
		$('#city').html('<option value="">Select state first</option>');
		$('#pin').val('');
	}
});

// on zone change get branch associated with that zone
$('#zone').on('change', function() {
	var zone_id = $(this).val();
	$.ajax({
		url: '../../assets/get_data/get_branch.php',
		type: 'POST',
		data: {
			zone_id: zone_id
		},
		success: function(data) {
			$('#branch').html(data);
		}
	});
});

//to hide show payment sections
$('#payment_fee').on('change', function(){
	var paytype=$('#payment_fee').val();
	if (paytype !='FOC') {
		$('#paymentModeBlock').removeClass("d-none"); 
		$('#payProof').removeClass("d-none"); 
	}else {
		$('#paymentModeBlock').addClass("d-none"); 
		$('#payProof').addClass("d-none"); 
	}
});

$('#payment_fee2').on('change', function(){
	var paytype=$(this).val();
	if (paytype !='FOC') {
		$('#paymentModeBlock').removeClass("d-none"); 
		$('#payProof').removeClass("d-none"); 
	}else {
		$('#paymentModeBlock').addClass("d-none"); 
		$('#payProof').addClass("d-none"); 
	}
});

$('#registered').on('change', function(){
	var registeredAs = $('#registered').val();
	if(registeredAs == 'sponsor_franchisee'){
		var paytype=$('#payment_fee2').val();
		if (paytype !='FOC') {
			$('#paymentModeBlock').removeClass("d-none"); 
			$('#payProof').removeClass("d-none"); 
		}else {
			$('#paymentModeBlock').addClass("d-none"); 
			$('#payProof').addClass("d-none"); 
		}
	}else if(registeredAs == 'master_franchisee'){
		var paytype=$('#payment_fee2').val();
		if (paytype !='FOC') {
			$('#paymentModeBlock').removeClass("d-none"); 
			$('#payProof').removeClass("d-none"); 
		}else {
			$('#paymentModeBlock').addClass("d-none"); 
			$('#payProof').addClass("d-none"); 
		}
	}else if(registeredAs == 'business_mentor'){
		var paytype=$('#payment_fee').val();
		if (paytype !='FOC') {
			$('#paymentModeBlock').removeClass("d-none"); 
			$('#payProof').removeClass("d-none"); 
		}else {
			$('#paymentModeBlock').addClass("d-none"); 
			$('#payProof').addClass("d-none"); 
		}
	}
});
//payment details
$('#paymentMode').on('click', function() {
	var paymentMode = $(".payment:checked").val();
	if (paymentMode == "cheque") {
		$("#chequeOpt").removeClass("d-none");
		$("#onlineOpt").addClass("d-none");
		$("#transactionNo").val("");
	} else if (paymentMode == "online") {
		$("#onlineOpt").removeClass("d-none");
		$("#chequeOpt").addClass("d-none");
		$("#chequeNo").val("");
		$("#chequeDate").val("");
		$("#bankName").val("");
	} else {
		$("#chequeOpt").addClass("d-none");
		$("#onlineOpt").addClass("d-none");
		$("#chequeNo").val("");
		$("#chequeDate").val("");
		$("#bankName").val("");
		$("#transactionNo").val("");
	}
});