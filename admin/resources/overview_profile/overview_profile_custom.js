$(function () {
    function loadData(start, end) {
        var id = $('#user_id').val();
        var DBtable = $('#DBtable').val();
        var user_type = $('#user_type').val();

        $.ajax({
            url: '../../controllers/overview_profile/payout_tab.php',
            type: 'POST',
            dataType: 'json',
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
                $('#commissionTotal').html('₹' + response.total);
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
mybutton && (window.onscroll = function() {
    scrollFunction()
});
$(document).ready(function() {
    // $("#user_table1").DataTable();
    // $("#user_table2").DataTable();
    // $("#user_table3").DataTable();
    // $("#user_table4").DataTable();
    // $("#user_table5").DataTable();
    if($('#DBtable').val() == 'ca_customer'){
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
    acc[i].addEventListener("click", function() {
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
function upgradePage(id,ref){
    window.location.href='../corporate_agency/upgrade_franchisee.php?id='+id+'&ref='+ref;
}
//franchisee upgrade History Details
function upgradeHistoryPage(id,ref){
    window.location.href='../corporate_agency/upgrade_franchisee_history.php?id='+id+'&sub_f_id='+ref;
}





//comemted for temp reason
function overviewPage(id,ref,cut,st,ct,message){
    if(message == 'business_consultant'){
        var designation = 'Business Consultant';
    }else if(message == 'corporate_agency'){
        var designation = 'Corporate Agency';
    }else if(message == 'ca_travelagency'){
        var designation = 'Travel Agency';
    }else if(message == 'ca_customer'){
        var designation = 'Customer';
    }else if(message == 'employees'){
        var designation = 'Employees';
    }else if(message == 'business_mentor'){
        var designation = 'Business Mentor';
    }
    window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}
//payment type
    $('#payment_fee').on('change', function() {
    var payval=$(this).val();
    console.log(payval);
    
    if (payval != 'FOC') {
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    }else{
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode1').on('click', function() {
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

$('#comp_chek').on('change',function(){
    var comp=$(this).val();
    if (comp == 1) {
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
    }else if (comp == 2){
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
    }
});

//payment type
    $('#payment_fee').on('change', function() {
    var payval=$(this).val();
    console.log(payval);
    
    if (payval != 'FOC') {
        $('#paymentMode1').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    }else{
        $('#paymentMode1').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode1').on('click', function() {
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
function editfuncCust(data){ 
    if (data.user_type == '26' || data.user_type == '28' || data.user_type == '30') {
        
        var fileName = 'business_mentor/editBusinessMentor.php';

        window.location.href = '../../views/' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&nohbref=' + data.reference_no +
            '&fyfyfregby=' + data.register_by +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&zone=' + data.zone +
            '&branch=' + data.branch +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type +
            '&tr_check=' + data.tr_check;
    }else if(data.user_type == '16' || data.user_type == '29'){
        var fileName = 'corporate_agency/edit_corporate_agency.php';

        window.location.href = '../../views/' + fileName +
            '?vkvbvjfgfikix=' + data.user_id +
            '&fyfyfregby=' + data.reference_no +
            '&nohbref=' + data.register_by +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type+
            '&tr_check=' + data.tr_check;
    }else if(data.user_type == '25' || data.user_type == '24' || data.user_type == '31' || data.user_type == '27'){
        var fileName = 'employee/editEmployee.php';

        window.location.href = '../../views/' + fileName +
            '?vkvbvjfgfikix=' + data.employee_id +
            '&fyfyfregby=' + data.reporting_manager +
            '&nohbref=' + data.register_by +
            '&dept=' + data.department +
            '&desig=' + data.designation +
            '&zn=' + data.zone +
            '&br=' + data.branch +
            '&editfor=' + data.type +
            '&usertype=' + data.user_type+
            '&tr_check=' + data.tr_check;
    }else if(data.user_type == '10'){
        var fileName = 'ca_customer/edit_customers.php';

            window.location.href = '../../views/' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&fyfyfregby=' + data.register_by +
            '&nohbref=' + data.reference_no +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&tr_check=' + data.tr_check;
    }else if(data.user_type == '11'){
        var fileName = 'ca_travel_agency/edit_ca_travelAgency.php';

            window.location.href = '../../views/' + fileName +
            '?vkvbvjfgfikix=' + data.id +
            '&fyfyfregby=' + data.register_by +
            '&nohbref=' + data.reference_no +
            '&ncy=' + data.country +
            '&mst=' + data.state +
            '&hct=' + data.city +
            '&editfor=' + data.type +
            '&tr_check=' + data.tr_check;
    }
}