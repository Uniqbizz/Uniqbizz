$(document).ready(function(){
                
    // Register the date format before using DataTables
    $.fn.dataTable.moment('DD-MM-YYYY');

    // Now initialize DataTables
    $("#pendingCustomerList-table").DataTable({
        order: [[5, 'asc']] // 6th column = index 5
    });

    $("#registeredCustomerList-table").DataTable({
        order: [[5, 'asc']]
    });
    
    $("#deletedCustomerList-table").DataTable({
        order: [[5, 'asc']]
    });

    // initial load
    reloadBMData();
});

function editfuncCust(id,refno,regby,cut,st,ct,zn,br,editfor,usertype){ 
    window.location.href='../../controllers/business_mentor/editBusinessMentor.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&zone='+zn+'&branch='+br+'&editfor='+editfor+'&usertype='+usertype;
};

function deletefunc(id,fid,action,usertype){ 
    var dataString = 'id='+id+'&refid='+fid+'&action='+action+'&usertype='+usertype;

    $.ajax({
    type: "POST",
    url: "../../controllers/business_mentor/deleteBusinessMentor.php",
    data: dataString,
    cache: false,
        success:function(data){
            // console.log('data'+data);
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

function confirmfunc(id,email,usertype){ 

    var dataString = 'id='+ id+'&uname='+email+'&usertype='+usertype;
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "../../controllers/business_mentor/confirmBusinessMentor.php",
        data: dataString,
        cache: false,
        success:function(data){
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

function overviewPage(id,ref,cut,st,ct,message){

    var designation = message == 'business_mentor'?'Business Mentor':(message == 'master_franchisee'?'Master Franchisee':'');
    window.location.href='../../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}

// Global flag
let dateRangeChanged = false;
let fromDate = '', toDate = '';


// On dropdown/filter change
$('.Fileter-list').on('change', function(){
    reloadBMData();
});

// On date range apply
$('#reportrange').on('apply.daterangepicker', function (ev, picker) {
    dateRangeChanged = true;
    fromDate = picker.startDate.format('DD-MM-YYYY');
    toDate   = picker.endDate.format('DD-MM-YYYY');
    $('#selectedDate').text(fromDate + ' to ' + toDate);

    reloadBMData(); // 🔥 reload table when date changes
});

// Reload function
function reloadBMData(){
    let filterDesig = $('#filter_branch').val();
    let desig = $('#designation_value').val();

    let dataString = 'branch='+filterDesig+'&designation='+desig;
    if (dateRangeChanged) {
        dataString += '&fromDate='+fromDate+'&toDate='+toDate;
    }

    $.ajax({
        type: 'POST',
        url: '../../controllers/business_mentor/filterBM.php',
        data: dataString,
        cache: false,
        success: function (data) {

            if ($.fn.DataTable.isDataTable('#registeredCustomerList-table')) {
                $('#registeredCustomerList-table').DataTable().clear().destroy();
            }

            $('#registeredCustomerList-table tbody').html(data);

            let table = $('#registeredCustomerList-table').DataTable({
                order: [[6, 'asc']]
            });

            console.log('Rows:', table.rows().count());
        }
    });
}

//download excel
function regTcDownload() {
    var branchVal  = $('#filter_branch').val() || "";
    var designation = $('#designation_value').val()   || "";
    let fromDate = '', toDate = '';

    if (dateRangeChanged) {
        const dateRange = $('#selectedDate').text().trim();
        if (dateRange.includes(' to ')) {
            [fromDate, toDate] = dateRange.split(' to ');
        }
    }

    var params = new URLSearchParams({
        branch: branchVal,
        designation: designation
    });

    if (dateRangeChanged && fromDate && toDate) {
        params.append("fromDate", fromDate);
        params.append("toDate", toDate);
    }

    window.location.href = "../../controllers/business_mentor/download_list.php?" + params.toString();
}
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