$(document).ready(function() {
    $("#example-dataTable").DataTable();
    $("#example-dataTable1").DataTable();
    // Hide both tables initially
    $('#booking_ponits_table_div').hide();
    $('#redeemable_amount_table_div').show();

    // Click event for Booking Wallet Card
    $('#booking_wallet_div').on('click', function () {
        $('#booking_ponits_table_div').show();
        $('#redeemable_amount_table_div').hide();
        // Highlight selected tab
        $('.wallet-tab').removeClass('selected-tab');
        $(this).addClass('selected-tab');
    });

    // Click event for Redeemable Wallet Card
    $('#redeemable_wallet_div').on('click', function () {
        $('#redeemable_amount_table_div').show();
        $('#booking_ponits_table_div').hide();
        // Highlight selected tab
        $('.wallet-tab').removeClass('selected-tab');
        $(this).addClass('selected-tab');
    });
    
});