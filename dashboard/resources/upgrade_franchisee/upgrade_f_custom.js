
$("#new_select_amount").on('change', function () {
    var prev = parseInt($("#prev_amount").val()) || 0;
    var added = parseInt($(this).val()) || 0;

    var updateAmount = prev + added;
    $("#update_amount").val(updateAmount).trigger('input'); // trigger next calc
});

$("#clear").on('click',function(){
    window.location.reload();
})
$('#update_amount').on('input', function () {
    var amount = parseInt($(this).val()) || 0;

    if (amount == 300000) {
        $("#commission").val('15');
        $("#incentive").val('15');
    } else if (amount == 400000) {
        $("#commission").val('20');
        $("#incentive").val('20');
    } else if (amount >= 500000) {
        $("#commission").val('30');
        $("#incentive").val('30');
    } else {
        $("#commission").val('');
        $("#incentive").val('');
    }
});

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