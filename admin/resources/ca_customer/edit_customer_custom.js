$(document).ready(function() {
    var paymentMode = $(".payment:checked").val();
    var payment_fee = $('#payment_fee').val()
    if (paymentMode == "cheque") {
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
    } else if (paymentMode == "online") {
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
    } else {
        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
    }
    var state = $('#mystate').val();
});
//select Designation
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url: '../../agents/get_user_Franchisee.php',
        data: "designation=" + designation,
        success: function(e) {
            // console.log(e);
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
    // console.log(user_id_name);

    var designation = $('#designation').val();
    // console.log(designation);

    $.ajax({
        type: 'POST',
        url: '../../agents/getUsers.php',
        data: 'user_id_name=' + user_id_name + '&designation=' + designation,
        success: function(response) {
            // console.log(response);
            // $('#pin').html(response);
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
    // alert();
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
                // $('#pin').html(response);
                $('#pin').val(response);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});
//payment type
    $('#payment_fee').on('change', function() {
    var payval=$(this).val();
    if (payval != 'FOC') {
        $('#paymentMode').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    }else{
        $('#paymentMode').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
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