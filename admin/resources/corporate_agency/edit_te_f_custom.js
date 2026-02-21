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

$('#business_package_amount').on('change', function() {
    var business_package_amount = $(this).val();
    $('#flex_amount').val(business_package_amount);
});

$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
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

//const checkbox = document.getElementById('showTCAlot');
let allowedCount = 0;

// Bind official_purpose change ONCE (outside the checkbox toggle)
$('input[name="official_purpose"]').on('change', function() {
    allowedCount = parseInt($(this).val());
    $('#allowedCount').text(allowedCount);
    $('#selectedCount').text(0);
    $('#selectedTCsInput').val('');

    let reference_no = $('#user_id_name').val();

    $.ajax({
        url: 'get_available_tcs.php',
        type: 'POST',
        data: {
            tc_count: allowedCount,
            reference_no: reference_no
        },
        success: function(response) {
            $('#tcListContainer').html(response);
            $('#availableTCs').removeClass('d-none');

            // Attach event to checkboxes inside response
            $('#tcListContainer').on('change', '.tc-checkbox', function() {
                let selected = $('.tc-checkbox:checked').length;
                if (selected > allowedCount) {
                    this.checked = false;
                    alert('You can only select ' + allowedCount + ' TC(s).');
                    return;
                }
                $('#selectedCount').text(selected);

                let selectedIds = [];
                $('.tc-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $('#selectedTCsInput').val(selectedIds.join(','));
            });
        }
    });
});

// checkbox.addEventListener('change', function() {
//     if (this.checked) {
//         $('#tcallotment').removeClass('d-none');
//         $('#availableTCs').removeClass('d-none');
//     } else {
//         $('#tcallotment').addClass('d-none');
//         $('#availableTCs').addClass('d-none');

//         // Reset all radios
//         $('input[name="official_purpose"]').prop('checked', false);

//         // Clear TC list and counts
//         $('#tcListContainer').html('');
//         $('#selectedCount').text('0');
//         $('#allowedCount').text('0');
//         $('#selectedTCsInput').val('');
//     }
// });