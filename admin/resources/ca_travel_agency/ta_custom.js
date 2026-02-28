$(document).ready(function(){
    $("#pendingCustomerList-table").DataTable();
    $("#registeredCustomerList-table").DataTable();
    $("#deletedTravelAgentList-table").DataTable();
    // initial load
    loadFilteredTCData();   
});

function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
    window.location.href='../../views/ca_travel_agency/edit_ca_travelAgency.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
};

function deletefunc(id,fid,action){ 
    var dataString = 'id='+id+'&refid='+fid+'&action='+action;

    $.ajax({
    type: "POST",
    url: "../../controllers/ca_travel_agency/delete_ca_travelAgency.php",
    data: dataString,
    cache: false,
        success:function(data){
            console.log('data'+data);
            if( data == 0 ){
                alert("Deleted Succesfully");
                window.location.reload();
            }else if( data == 1 ){
                alert("User Activated Succesfully");
                window.location.reload();
            }else if( data == 2 ){
                alert("User Restored Succesfully");
                window.location.reload();
            }else if( data == 3 ){
                alert("User Deactivated Succesfully");
                window.location.reload();
            } else {
                alert("Request Failed !!");
            }
        }
    });
    
};

function confirmfunc(id,email,ref,compCheck){ 

    var dataString = 'id='+ id+'&uname='+email+'&ref='+ref+'&compCheck='+compCheck;
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "../../controllers/ca_travel_agency/confirm_ca_travelAgency.php",
        data: dataString,
        cache: false,
        success:function(data){
            console.log(data);
            if(data == 1){
                $("#loading-overlay").hide(); //loading screen
                alert("Email and Password sent via sms and email");
                window.location.reload();
            }
            else{
                $("#loading-overlay").hide(); //loading screen
                alert("Failed to confirm");
            }
        }
    });
    
};

function loadTravelAgenciesByState() {
    let filterState = $('#filter_state').val();

    if (!filterState) {
        alert("Select State First");
        return;
    }

    let dataString = 'state=' + filterState;

    $.ajax({
        type: 'POST',
        url: '../../controllers/ca_travel_agency/filterTC.php',
        data: dataString,
        cache: false,
        success: function (data) {
            if (data) {
                console.log('success ' + data);
                $('#tcView').html(data);

                // Destroy existing DataTable if already initialized
                if ($.fn.DataTable.isDataTable('#registeredCustomerList-tableFilter')) {
                    $('#registeredCustomerList-tableFilter').DataTable().destroy();
                }

                let table = $("#registeredCustomerList-tableFilter").DataTable();
                let totalRows = table.rows().count();
                $('#filterCount').val(totalRows);
            } else {
                console.log('unsuccess ' + data);
                $('#tcView').html(data);
            }
        }
    });
}

// On dropdown change
$('#filter_state').on('change', function () {
    loadTravelAgenciesByState();
});

// On page load
$(document).ready(function () {
    loadTravelAgenciesByState();
});

function regTcDownload(){
    const filterState = $('#filter_state').val();
    const stateText = $('#filter_state option:selected').text();
    window.location.href='../../controllers/ca_travel_agency/download_list.php?filterState='+filterState+'&stateText='+stateText;
}

$('#designation').on('change', function () {
    const designation = $(this).val();

    if (designation) {
        $.ajax({
            url: '../../assets/submit/get_users_by_designation.php',
            type: 'POST',
            data: { designation: designation },
            dataType: 'json',
            success: function (response) {
                let options = `<option value="" selected>-- Select User --</option>`;
                response.forEach(user => {
                    options += `<option value="${user.user_id}">${user.fullname}</option>`;
                });
                $('#userIdSelect').html(options);
            },
            error: function () {
                alert('Error fetching users.');
            }
        });
    } else {
        $('#userIdSelect').html('<option value="" selected>-- Select User --</option>');
    }
});


let dateRangeChanged = false; // Flag to track if date range was changed

function loadFilteredTCData() {
    const userId = $('#userIdSelect').val()?.trim() || '';
    const designation = $('#designation').val()?.trim() || '';
    const state = $('#filter_state').val()?.trim() || 'All';

    let fromDate = '', toDate = '';

    if (dateRangeChanged) {
        const dateRange = $('#selectedDate').text().trim();
        if (dateRange.includes(' to ')) {
            [fromDate, toDate] = dateRange.split(' to ');
        }
    }

    const dataString = {
        userId: userId,
        designation: designation,
        state: state
    };

    if (dateRangeChanged) {
        dataString.fromDate = fromDate;
        dataString.toDate = toDate;
    }

    $.ajax({
        type: 'POST',
        url: '../../controllers/ca_travel_agency/filterTC.php',
        data: dataString,
        success: function (data) {
            if (data) {
                $('#tcView').html(data);
                $("#registeredCustomerList-tableFilter").DataTable();
                const totalRows = $("#registeredCustomerList-tableFilter").DataTable().rows().count();
                $('#filterCount').val(totalRows);
            } else {
                $('#tcView').html('<tr><td colspan="9">No data found</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

// 🔁 Change handler for dropdowns (user/state/designation)
$('.filter_items').on('change', function () {
    loadFilteredTCData();
});

// 📅 When date range changes, update flag and reload
$('#reportrange').on('apply.daterangepicker', function (ev, picker) {
    dateRangeChanged = true;
    const formatted = picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY');
    $('#selectedDate').text(formatted);
    loadFilteredTCData();
});

function overviewPage(id,ref,cut,st,ct,message){
    var designation = 'Travel Consultant';
    window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}
// date picker section
$(function () {
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        autoUpdateInput: false, // prevents default range selection
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    // Update input field manually when user selects range
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        cb(picker.startDate, picker.endDate);
    });

    // Clear input when user cancels
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).find('span').html('');
    });
});