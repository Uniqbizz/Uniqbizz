$(document).ready(function() {
    $('a[href="#editLogs"]').on('shown.bs.tab', function () {
        loadLogs();
    });
    $('a[href="#transferLogs"]').on('shown.bs.tab', function () {
        loadTLogs();
    });
    $('a[href="#overview"]').on('shown.bs.tab', function () {
        loadTLogs();
    });
    $('a[href="#activities"]').on('shown.bs.tab', function () {
        loadTLogs();
    });
    $('a[href="#teams"]').on('shown.bs.tab', function () {
        loadTLogs();
    });
    // loadLogs();
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

function showOrderDetails(id) {
    window.location.href = 'order_details.php?vkvbvjfgfikix=' + id;
}

function downloadInvoice(id) {
    window.location.href = 'download_invoice?vkvbvjfgfikix=' + id;
}
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
$(function () {
    function loadData(start, end) {
        var id = $('#user_id').val();
        var DBtable = $('#DBtable').val();
        var user_type = $('#user_type').val();

        $.ajax({
            url: '../models/overview_profile/forms/payout_overview.php',
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
//------------- end of comemted for temp reason

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

let from_date = '';
let to_date = '';

/* ================= LOAD DATA ================= */
function loadLogs(){

    // 🔥 Destroy if already initialized
    if ($.fn.DataTable.isDataTable('#editLogTable')) {
        $('#editLogTable').DataTable().destroy();
    }

    $.ajax({
        url: '../models/overview_profile/forms/edit_log_history.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'fetch_logs',
            record_id: $('#user_id').text().trim(),
            from_date: from_date,
            to_date: to_date
        },
        success: function(res){

            if(res.status !== 'success'){
                console.log("Error:", res.message);
                return;
            }

            let data = res.data;
            let html = '';

            if(!data || data.length === 0){
                html = ``;
            } else {
                data.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.created_at}</td>
                            <td>${row.column_name}</td>
                            <td>${row.old_value ?? '-'}</td>
                            <td>${row.new_value ?? '-'}</td>
                            <td>${row.changed_role ?? '-'}</td>
                            <td>${row.change_reason ?? '-'}</td>
                        </tr>
                    `;
                });
            }

            $('#editLogsbody').html(html);

            // ✅ Reinitialize DataTable
            $('#editLogTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                language: {
                    emptyTable: "No data found"
                }
            });
        }
    });
}

/* ================= DATE RANGE ================= */
$('#editrangeDate').daterangepicker({
    autoUpdateInput: false
});

$('#editrangeDate').on('apply.daterangepicker', function(ev, picker) {
    from_date = picker.startDate.format('YYYY-MM-DD');
    to_date = picker.endDate.format('YYYY-MM-DD');

    $(this).val(from_date + ' - ' + to_date);
    loadLogs();
});

$('#editrangeDate').on('cancel.daterangepicker', function() {
    $(this).val('');
    from_date = '';
    to_date = '';
    loadLogs();
});

/* ================= DOWNLOAD ================= */
$('#downloadBtn').click(function(){
    let url = `../models/overview_profile/forms/edit_log_history.php?download=1&from_date=${from_date}&to_date=${to_date}&record_id=${$('#user_id').text().trim()}`;
    window.open(url, '_blank');
});

/* ================= TRANSFER DATA ================= */
function loadTLogs(){

    // 🔥 Destroy if already initialized
    if ($.fn.DataTable.isDataTable('#transferLogTable')) {
        $('#transferLogTable').DataTable().destroy();
    }

    $.ajax({
        url: '../models/overview_profile/forms/transfer_log_history.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'fetch_logs',
            record_id: $('#user_id').text().trim(),
            from_date: from_date,
            to_date: to_date
        },
        success: function(res){

            if(res.status !== 'success'){
                console.log("Error:", res.message);
                return;
            }

            let data = res.data;
            let html = '';

            if(!data || data.length === 0){
                html = ``;
            } else {
                data.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.transfer_date}</td>
                            <td>${row.prev_user_name}</td>
                            <td>${row.prev_user_email}</td>
                            <td>${row.prev_user_doj}</td>
                            <td>${row.new_user_name}</td>
                            <td>${row.new_user_email}</td>
                            <td>${row.transfer_reason}</td>
                            <td>${row.transfer_remark}</td>
                            <td>
                                ${
                                    row.transfer_status == 2 ? 'Approved' :
                                    row.transfer_status == 3 ? 'Rejected' :
                                    'Pending'
                                }
                            </td>
                            <td>${row.transfer_update_date}</td>
                            <td>Admin</td>
                        </tr>
                    `;
                });
            }

            $('#transferLogsbody').html(html);

            // ✅ Reinitialize DataTable
            $('#transferLogTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                scrollX: true,
                language: {
                    emptyTable: "No data found"
                } 
            });
        }
    });
}

/* ================= DATE RANGE ================= */
$('#editrangeDate1').daterangepicker({
    autoUpdateInput: false
});

$('#editrangeDate1').on('apply.daterangepicker', function(ev, picker) {
    from_date = picker.startDate.format('YYYY-MM-DD');
    to_date = picker.endDate.format('YYYY-MM-DD');

    $(this).val(from_date + ' - ' + to_date);
    loadTLogs();
});

$('#editrangeDate1').on('cancel.daterangepicker', function() {
    $(this).val('');
    from_date = '';
    to_date = '';
    loadTLogs();
});

/* ================= DOWNLOAD ================= */
$('#downloadBtn1').click(function(){
    let url = `../models/overview_profile/forms/transfer_log_history.php?download=1&from_date=${from_date}&to_date=${to_date}&record_id=${$('#user_id').text().trim()}`;
    window.open(url, '_blank');
});