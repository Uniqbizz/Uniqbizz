//get page status
$(document).ready(function() {
    // Fetch User based on selected designation add by SV on 08-09-2025
    $('#user_id_name').on('change', function() {
        var user_id_name = $(this).val();
        var designation = 'ca_travelagency';

        if (user_id_name !== '') { // ✅ only fire if something is selected
            $.ajax({
                type: 'POST',
                url: '../../agents/getUsers.php',
                data: { user_id_name: user_id_name, designation: designation },
                success: function(response) {
                    $('#reference_name').val(response);
                }
            });
        }
    });

    // 🔥 Fire once on page load if a value is already selected
    if ($('#user_id_name').val() !== '') {
        $('#user_id_name').trigger('change');
        $('#user_id_name').prop('disabled',true);
    }
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
$('#pay').removeClass('d-none');
$('#couponFee').removeClass('d-none');

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

function toggleDiv(show) {
    document.getElementById("paymentMode").classList.toggle("d-none", !show);
    document.getElementById("payOpt").classList.toggle("d-none", !show);
    document.getElementById("payProof").classList.toggle("d-none", !show);
    let paymentFee = document.getElementById("payment_fee");
    paymentFee.value = show ? "10000" : "FOC";

}

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