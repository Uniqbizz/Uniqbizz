$(document).ready(function() {
    var paymentMode = $(".payment:checked").val();
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
});
$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
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