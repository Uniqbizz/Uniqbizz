var mybutton = document.getElementById("back-to-top");

function scrollFunction() {
    100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
}

function topFunction() {
    document.body.scrollTop = 0,
        document.documentElement.scrollTop = 0
}
mybutton && (window.onscroll = function () {
    scrollFunction()
});


document.addEventListener('click', function (event) {

    var accordion = event.target.closest('.accordion');

    if (!accordion) {
        return;
    }


    /*
    | Do not open accordion
    | when View Profile is clicked
    */

    if (event.target.closest('.view-btn')) {
        return;
    }


    event.preventDefault();


    accordion.classList.toggle('active');


    var panel = accordion.nextElementSibling;


    if (
        panel &&
        panel.classList.contains('panel')
    ) {


        if (
            panel.style.display === 'block'
        ) {

            panel.style.display = 'none';

        }
        else {

            panel.style.display = 'block';

        }

    }

});
$(document).ready(function () {
    // $("#user_table1").DataTable();
    // $("#user_table2").DataTable();
    // $("#user_table3").DataTable();
    // $("#user_table4").DataTable();
    // $("#user_table5").DataTable();
    if ($('#DBtable').val() == 'ca_customer') {
        $("#couponsTable").DataTable();
    }
    $("#payoutDetailsTable").DataTable();

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

function showOrderDetails(id) {
    window.location.href = 'order_details.php?vkvbvjfgfikix=' + id;
}

function downloadInvoice(id) {
    window.location.href = 'download_invoice?vkvbvjfgfikix=' + id;
}


$('#upgardeHistoryTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10
});
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}


//add edit ins downline
function loadDownlineHistory() {

    $.ajax({

        url: 'forms/get_downline_history.php',

        type: 'POST',

        data: {
            institution_id: id
        },

        dataType: 'json',

        success: function (response) {

            if (!response.status) {
                console.error(response.message);
                return;
            }


            if ($.fn.DataTable.isDataTable('#downlineHistoryTable')) {

                $('#downlineHistoryTable')
                    .DataTable()
                    .destroy();

            }


            let rows = '';


            $.each(response.data, function (index, row) {

                let tcStatus =
                    row.downline_tc == 1
                        ? '<span class="badge bg-success">Assigned</span>'
                        : '<span class="badge bg-secondary">Not Assigned</span>';


                let ibrStatus =
                    row.downline_ibr == 1
                        ? '<span class="badge bg-success">Assigned</span>'
                        : '<span class="badge bg-secondary">Not Assigned</span>';


                let status =
                    row.status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Deactivated</span>';


                let tcBooking = '-';


                if (
                    row.downline_tc == 1 &&
                    parseFloat(row.payout_holiday_booking_tc) > 0
                ) {

                    tcBooking =
                        '₹ ' +
                        parseFloat(
                            row.payout_holiday_booking_tc
                        ).toFixed(2);

                } else if (row.downline_tc == 1) {

                    tcBooking = 'As per Package';

                }


                rows += `
                    <tr>

                        <td>${index + 1}</td>

                        <td>${tcStatus}</td>

                        <td>${ibrStatus}</td>

                        <td>
                            ₹ ${parseFloat(
                                row.payout_holiday_account_tc || 0
                            ).toFixed(2)}
                        </td>

                        <td>
                            ₹ ${parseFloat(
                                row.payout_holiday_account_ibr || 0
                            ).toFixed(2)}
                        </td>

                        <td>
                            ${tcBooking}
                        </td>

                        <td>
                            ₹ ${parseFloat(
                                row.payout_holiday_booking_ibr || 0
                            ).toFixed(2)}
                        </td>

                        <td>
                            ${row.create_date}
                        </td>
                        <td>
                            ${row.deleted_date || 'N/A'}
                        </td>

                        <td>
                            ${status}
                        </td>

                    </tr>
                `;

            });


            $('#downlineHistoryTable tbody').html(rows);


            $('#downlineHistoryTable').DataTable({

                pageLength: 10,

                order: [
                    [0, 'desc']
                ],

                responsive: true

            });

        },

        error: function (xhr) {

            console.error(
                'History Error:',
                xhr.responseText
            );

        }

    });

}
loadDownlineHistory();
$(document).on('click', '#tc_holiday_account, #tc_holiday_booking_type, #tc_holiday_fixed_amount', function () {

    if (!$('#tc_check').is(':checked')) {

        $('#downlineError')
            .text('Please select TC before entering TC payout details.')
            .show();

        return false;
    }

    $('#downlineError').hide().text('');
});


$(document).on('click', '#br_holiday_account, #br_holiday_booking', function () {

    if (!$('#br_check').is(':checked')) {

        $('#downlineError')
            .text('Please select IBR before entering IBR payout details.')
            .show();

        return false;
    }

    $('#downlineError').hide().text('');
});
$(document).on('click', '#editDownlineBtn', function () {

    // Enable only the checkboxes
    $('.downline-checkbox').prop('disabled', false);

    // TC fields stay disabled until TC is checked
    $('#tc_holiday_account').prop('readonly', !$('#tc_check').is(':checked'));
    $('#tc_holiday_booking_type').prop('disabled', !$('#tc_check').is(':checked'));

    // IBR fields stay readonly until IBR is checked
    $('#br_holiday_account').prop('readonly', !$('#br_check').is(':checked'));
    $('#br_holiday_booking').prop('readonly', !$('#br_check').is(':checked'));

    // Show save button
    $('#saveDownlineBtn').show();

    // Hide edit button
    $(this).hide();

});

$(document).on('change', '#tc_holiday_booking_type', function () {

    let bookingType = $(this).val();

    if (bookingType === 'fixed') {

        $('#tc_holiday_fixed_account').show();

    } else {

        $('#tc_holiday_fixed_account').hide();

    }

});
$(document).on('click', '#saveDownlineBtn', function () {

    // Check if at least one downline is selected
    let tcSelected = $('#tc_check').is(':checked');
    let brSelected = $('#br_check').is(':checked');

    if (!tcSelected && !brSelected) {

        $('#downlineError')
            .text('Please select at least one downline (TC or IBR).')
            .show();

        return;
    }

    // Clear previous error
    $('#downlineError')
        .hide()
        .text('');

    let bookingType =
        $('#tc_holiday_booking_type').val();

    let tcBookingAmount = 0;

    if (bookingType === 'fixed') {

        tcBookingAmount =
            $('#tc_holiday_fixed_amount').val() || 0;
    }

    let downlineData = {

        institution_id: id,

        tc: {

            selected: tcSelected ? 1 : 0,

            holiday_account:
                $('#tc_holiday_account').val() || 0,

            booking_amount:
                tcBookingAmount
        },

        br: {

            selected: brSelected ? 1 : 0,

            holiday_account:
                $('#br_holiday_account').val() || 0,

            holiday_booking:
                $('#br_holiday_booking').val() || 0
        }
    };


    $.ajax({

        url: 'forms/save_downline.php',

        type: 'POST',

        data: downlineData,

        dataType: 'json',


        beforeSend: function () {

            $('#saveDownlineBtn')
                .prop('disabled', true)
                .html(
                    '<i class="mdi mdi-loading mdi-spin me-1"></i> Saving...'
                );
        },


        success: function (response) {

            if (response.status) {

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: response.message,

                    confirmButtonText: 'OK'

                }).then(function () {

                    // Reload page after user clicks OK
                    window.location.reload();

                });

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text:
                        response.message ||
                        'Unable to save downline details.',

                    confirmButtonText: 'OK'

                });

            }

        },


        error: function (xhr) {

            console.error(
                'AJAX Error:',
                xhr.responseText
            );

            Swal.fire({

                icon: 'error',

                title: 'Error',

                text:
                    'Something went wrong while saving the downline details.',

                confirmButtonText: 'OK'

            });

        },


        complete: function () {

            $('#saveDownlineBtn')
                .prop('disabled', false)
                .html(
                    '<i class="mdi mdi-content-save me-1"></i> Save Changes'
                );
        }

    });

});
$(document).on('change', '#tc_check', function () {

    let checked = $(this).is(':checked');

    $('#tc_holiday_account')
        .prop('readonly', !checked);

    $('#tc_holiday_booking_type')
        .prop('disabled', !checked);

    // If TC is unchecked, hide fixed amount
    if (!checked) {

        $('#tc_holiday_fixed_account').hide();

    } else {

        // Respect current booking type
        if ($('#tc_holiday_booking_type').val() === 'fixed') {
            $('#tc_holiday_fixed_account').show();
        }

    }

});
$(document).on('change', '#br_check', function () {

    let checked = $(this).is(':checked');

    $('#br_holiday_account')
        .prop('readonly', !checked);

    $('#br_holiday_booking')
        .prop('readonly', !checked);

});
//------------
$(function () {
    function loadData(start, end) {
        var id = $('#user_id').val();
        var DBtable = $('#DBtable').val();
        var user_type = $('#user_type').val();

        $.ajax({
            url: 'forms/payout_overview.php',
            type: 'POST',
            data: {
                id: id,
                DBtable: DBtable,
                user_type: user_type,
                start_date: start,
                end_date: end
            },
            success: function (response) {
                // Step 1: Destroy DataTable
                if ($.fn.DataTable.isDataTable("#payoutDetailsTable")) {
                    $('#payoutDetailsTable').DataTable().destroy();
                }

                // Step 2: Replace table rows
                $('#payoutDetails').html(response.html);

                // Step 3: Re-initialize DataTable
                $('#payoutDetailsTable').DataTable();

                // Step 4: Update commission total
                $('#commissionTotal').html('₹' + (response.total || 0));
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }

    // Initialize with current month on page load
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    loadData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

    // Daterangepicker setup
    $('input[name="daterange"]').daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left'
    }, function (start, end, label) {
        loadData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    });
});
function topFunction() {
    document.body.scrollTop = 0,
        document.documentElement.scrollTop = 0
}
mybutton && (window.onscroll = function () {
    scrollFunction()
});
$(document).ready(function () {

    // 🔥 FIX: Force tabs inside .tab-content
    let $tabContent = $('.tab-content');

    let $editLog = $('#editLogs').closest('.tab-pane');
    if ($editLog.length && !$editLog.parent().hasClass('tab-content')) {
        $tabContent.append($editLog);
    }

    let $transferLog = $('#transferLogs').closest('.tab-pane');
    if ($transferLog.length && !$transferLog.parent().hasClass('tab-content')) {
        $tabContent.append($transferLog);
    }


    // Your existing code 👇 (unchanged)

    $('a[href="#editLogs"]').on('shown.bs.tab', function () {
        loadLogs();
    });

    $('a[href="#transferLogs"]').on('shown.bs.tab', function () {
        loadTLogs();
    });

    if ($('#DBtable').val() == 'ca_customer') {
        $("#couponsTable").DataTable();
    }

    $("#payoutDetailsTable").DataTable();

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

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
//franchisee upgrade
function upgradePage(id, ref) {
    window.location.href = '../corporate_agency/upgrade_franchisee.php?id=' + id + '&ref=' + ref;
}
//franchisee upgrade History Details
function upgradeHistoryPage(id, ref, userType) {
    window.location.href = 'upgrade_franchisee_history.php?id=' + id + '&sub_f_id=' + ref + '&user_type=' + userType;
}





//comemted for temp reason
function overviewPage(id, ref, cut, st, ct, message) {
    if (message == 'business_consultant') {
        var designation = 'Business Consultant';
    } else if (message == 'corporate_agency') {
        var designation = 'Corporate Agency';
    } else if (message == 'ca_travelagency') {
        var designation = 'Travel Agency';
    } else if (message == 'ca_customer') {
        var designation = 'Customer';
    } else if (message == 'employees') {
        var designation = 'Employees';
    } else if (message == 'business_mentor') {
        var designation = 'Business Mentor';
    }
    window.location.href = 'overview.php?id=' + id + '&ref=' + ref + '&cut=' + cut + '&st=' + st + '&ct=' + ct + '&message=' + message + '&designation=' + designation;
}
//payment type
$('#payment_fee').on('change', function () {
    var payval = $(this).val();
    console.log(payval);

    if (payval != 'FOC') {
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    } else {
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode1').on('click', function () {
    var paymentMode = $(".payment1:checked").val();
    // console.log(paymentMode);
    if (paymentMode == "cheque") {
        $("#chequeOpt1").removeClass("d-none");
        $("#onlineOpt1").addClass("d-none");
        $("#transactionNo1").val("");
    } else if (paymentMode == "online") {
        $("#onlineOpt1").removeClass("d-none");
        $("#chequeOpt1").addClass("d-none");
        $("#chequeNo1").val("");
        $("#chequeDate1").val("");
        $("#bankName1").val("");
    } else {
        $("#chequeOpt1").addClass("d-none");
        $("#onlineOpt1").addClass("d-none");
        $("#chequeNo1").val("");
        $("#chequeDate1").val("");
        $("#bankName1").val("");
        $("#transactionNo1").val("");
    }
});

$('#comp_chek').on('change', function () {
    var comp = $(this).val();
    if (comp == 1) {
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
    } else if (comp == 2) {
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
    }
});

//payment type
$('#payment_fee').on('change', function () {
    var payval = $(this).val();
    console.log(payval);

    if (payval != 'FOC') {
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    } else {
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode1').on('click', function () {
    var paymentMode = $(".payment1:checked").val();
    // console.log(paymentMode);
    if (paymentMode == "cheque") {
        $("#chequeOpt1").removeClass("d-none");
        $("#onlineOpt1").addClass("d-none");
        $("#transactionNo1").val("");
    } else if (paymentMode == "online") {
        $("#onlineOpt1").removeClass("d-none");
        $("#chequeOpt1").addClass("d-none");
        $("#chequeNo1").val("");
        $("#chequeDate1").val("");
        $("#bankName1").val("");
    } else {
        $("#chequeOpt1").addClass("d-none");
        $("#onlineOpt1").addClass("d-none");
        $("#chequeNo1").val("");
        $("#chequeDate1").val("");
        $("#bankName1").val("");
        $("#transactionNo1").val("");
    }
});
//for transfer
$(document).on('click', '.edit-btn', function () {
    let data = $(this).attr('data-user');

    try {
        data = JSON.parse(data);
        console.log(data);

        editfuncCust(data);
    } catch (e) {
        console.error("JSON Parse Error:", data);
    }
});

function editfuncCust(data) {
    if (data.user_type == 26 || data.user_type == 28 || data.user_type == 30) {

        var fileName = 'businessMentor/editBusinessMentor.php';

        window.location.href = '../' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&nohbref=' + (data.reference_no || 'NA') +
            '&fyfyfregby=' + data.register_by +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&zone=' + data.zone +
            '&branch=' + data.branch +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type +
            '&tr_check=' + data.tr_check;
    } else if (data.user_type == 16 || data.user_type == 29) {
        var fileName = 'corporate_agency/edit_corporate_agency.php';

        window.location.href = '../' + fileName +
            '?vkvbvjfgfikix=' + data.user_id +
            '&fyfyfregby=' + data.reference_no +
            '&nohbref=' + data.register_by +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type +
            '&tr_check=' + data.tr_check;
    } else if (data.user_type == 25 || data.user_type == 24 || data.user_type == 31 || data.user_type == 27) {

        var fileName = 'employee/editEmployee.php';

        window.location.href = '../' + fileName +
            '?vkvbvjfgfikix=' + data.employee_id +
            '&fyfyfregby=' + (data.reporting_manager || 'NA') +
            '&nohbref=' + data.register_by +
            '&dept=' + data.department +
            '&desig=' + data.designation +
            '&zn=' + data.zone +
            '&br=' + data.branch +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type +
            '&tr_check=' + data.tr_check;
    } else if (data.user_type == 10) {
        var fileName = 'ca_customers/edit_customers.php';

        window.location.href = '../' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&fyfyfregby=' + data.register_by +
            '&nohbref=' + data.reference_no +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&tr_check=' + data.tr_check;
    } else if (data.user_type == 11) {
        var fileName = 'ca_travel_agency/edit_ca_travelAgency.php';

        window.location.href = '../' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&fyfyfregby=' + data.register_by +
            '&nohbref=' + data.reference_no +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type +
            '&tr_check=' + data.tr_check;
    }
}
let from_date = '';
let to_date = '';
$(document).ready(function () {

    let $empBlock = $('#employee');
    let $zmBlock = $('#zonal_manager');

    // Cache and detach blocks only once
    if (!$empBlock.data('detached')) {
        $empBlock.data('detached', true);
        $empBlock = $empBlock.detach();
    }

    if (!$zmBlock.data('detached')) {
        $zmBlock.data('detached', true);
        $zmBlock = $zmBlock.detach();
    }

    // Clear formParent first
    $('#formParent').empty();

    // Append based on condition
    if (selected_div === 'business_developement_manager' || selected_div === 'business_chanel_manager' || selected_div === 'relationship_manager') {
        $('#formParent').append($empBlock);
    } else if (selected_div === 'zonal_manager') {
        $('#formParent').append($zmBlock);
    }
});

$('#generate_coupons').on('click', function () {
    var chequeNo = $("#chequeNo1").val().trim();
    var chequeDate = $("#chequeDate1").val().trim();
    var bankName = $("#bankName1").val().trim();
    var transactionNo = $("#transactionNo1").val().trim();
    let payment_fee = $('#payment_fee').val();
    let payment_text = $("#payment_fee option:selected").text().trim();
    var paymentMode = $(".payment1:checked").val() || 'FOC';
    let payment_label = payment_text.includes(":")
        ? payment_text.split(":")[0].trim()
        : payment_text;
    let allowed_labels = ["Prime", "Premium", "Premium Plus", "Neo Select"];
    let comp_check = $('#comp_chek option:selected').val();

    if (!allowed_labels.includes(payment_label)) {
        alert("Please select a valid Payment Type: Prime, Premium, or Premium Plus.");
        return;
    }
    var payment_proof;
    if (paymentMode === "FOC" || paymentMode === "null") {
        payment_proof = "none";
    } else {
        payment_proof = $("#img_path61").val().trim(); // hidden input
    }
    // Validate payment mode (Cheque or Online)
    if (!paymentMode) {
        alert("Please select a Payment Mode.");
        return;
    }

    // Conditional validation based on payment mode
    if (payment_fee === "Cheque") {
        if (!chequeNo) {
            alert("Please enter the Cheque Number.");
            return;
        }
        if (!chequeDate) {
            alert("Please enter the Cheque Date.");
            return;
        }
        if (!bankName) {
            alert("Please enter the Bank Name.");
            return;
        }
    } else if (payment_fee === "Online") {
        if (!transactionNo) {
            alert("Please enter the Transaction Number.");
            return;
        }
    }

    // Payment proof (optional logic)
    if (paymentMode === "FOC" || paymentMode === "null") {
        payment_proof = "none";
    } else {
        payment_proof = $("#img_path61").val().trim();
        if (!payment_proof) {
            alert("Please upload the Payment Proof.");
            return;
        }
    }

    // Validate complementary type
    if (!comp_check || comp_check === "null") {
        alert("Please select a Complementary Type.");
        return;
    }

    var data = {
        id: id,
        customer_type: customer_type,
        cheque_no: chequeNo,
        cheque_date: chequeDate,
        bank_name: bankName,
        transaction_no: transactionNo,
        payment_proof: payment_proof,
        payment_label: payment_label,
        payment_fee: payment_fee,
        paymentMode: paymentMode,
        comp_chek: comp_check
    }
    //console.log(data);

    $.ajax({
        url: 'generate_coupons.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
                alert('Coupon generated successfully!');
                location.reload();
            } else {
                alert('Failed: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert('An error occurred. Check console.');
        }
    });
});
$('#terms_condition_submit').on('click', function (e) {
    e.preventDefault();
    // console.log('terms_condition Clicked');
    var termsAndConditionImg = $('#img_pathTerms').val();
    var termsAndConditionSection = $('#t_c').val();
    // console.log(termsAndConditionImg);
    if (termsAndConditionImg) {
        var data = {
            cust_id: cust_id,
            termsAndConditionImg: termsAndConditionImg
        }
        // console.log(data);
        $.ajax({
            url: 'forms/upload_terms_condition.php',
            type: 'POST',
            data: data,
            // dataType: 'json',
            success: function (response) {
                if (response == 1) {
                    alert('Terms And Condition Image updated successfully!');
                    $('#terms_condition_submit').prop('disabled', true);
                    $('#terms_condition').prop('disabled', true);
                } else {
                    alert('Failed: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                alert('An error occurred. Check console.');
            }
        });
    } else {
        alert("No Terms And Condition Image Found!")
    }
});
