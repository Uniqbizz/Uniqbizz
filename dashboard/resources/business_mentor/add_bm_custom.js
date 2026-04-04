$('#registered').on('change',function(){
    var register_type = $(this).val();
    if(register_type == 'business_mentor'){
        $('#payment_fee').prop('disabled',false);
        $('#payment_fee2').addClass('d-none');
        $('#payment_fee').removeClass('d-none');
    }else if(register_type == 'master_franchisee'){
        $('#payment_fee').addClass('d-none');
        $('#payment_fee2').removeClass('d-none');
    }else if(register_type == 'sponsor_franchisee'){
        $('#payment_fee').addClass('d-none');
        $('#payment_fee2').removeClass('d-none');
    }
});
//select Designation
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    console.log(designation);
    $.ajax({
        type: 'POST',
        url: '../agents/get_user_Franchisee.php',
        data: "designation=" + designation,
        success: function(e) {
            console.log(e);
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
    var designation = $('#designation').val();
    console.log(user_id_name);
    $.ajax({
        type: 'POST',
        url: '../agents/getUsers.php',
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
            url: '../address/countrydata.php',
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
            url: '../address/countrydata.php',
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
            url: '../address/pincode.php',
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

$('.payment-value').on('change', function() {
    var payment_fee = $(this).val();
    console.log(payment_fee);
    if (payment_fee == "FOC") {
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
        $("#payProof").addClass("d-none");
    } else if (payment_fee == "null") {
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
        $("#payProof").addClass("d-none");
    } else {
        $("#paymentModeBlock").removeClass("d-none");
        $("#paymentFields").removeClass("d-none");
        $("#payProof").removeClass("d-none");
    }
});
// on zone change get branch associated with that zone
$('#zone').on('change', function() {
    var zone_id = $(this).val();
    $.ajax({
        url: '../assets/get_data/get_branch.php',
        type: 'POST',
        data: {
            zone_id: zone_id
        },
        success: function(data) {
            $('#branch').html(data);
        }
    });
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