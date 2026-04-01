$(document).ready(function(){
    $("#pendingCustomerList-table").DataTable();
    $("#registeredCustomerList-table").DataTable();
    $("#deletedCustomerList-table").DataTable();
});

function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
    window.location.href='../../views/ca_customer/edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
};

function addCustRef(id,fullname,taRef,status){ 
    window.location.href='../../views/ca_customer/add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
};

function deletefunc(id,fid,action){ 
    var dataString = 'id='+id+'&refid='+fid+'&action='+action;

    $.ajax({
    type: "POST",
    url: "../../controllers/ca_customer/delete_customers.php",
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

function confirmfunc(id,email){ 

    var dataString = 'id='+ id+'&uname='+email;
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "../../controllers/ca_customer/confirm_customers.php",
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

function loadCustomersByState() {
    let filterState = $('#filter_state').val();

    if (!filterState) {
        alert("Select State First");
        return;
    }

    let dataString = 'state=' + filterState;

    $.ajax({
        type: 'POST',
        url: '../../controllers/ca_customer/filterCU.php',
        data: dataString,
        cache: false,
        success: function (data) {
            if (data) {
                // console.log('success ' + data);
                $('#cuView').html(data);

                // Reinitialize DataTable safely
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

// On change
$('#filter_state').on('change', function () {
    loadCustomersByState();
});

// On page load
$(document).ready(function () {
    loadCustomersByState();
});

function regCuDownload(){
    const filterState = $('#filter_state').val();
    const stateText = $('#filter_state option:selected').text();
    window.location.href='../../controllers/ca_customer/download_list?filterState='+filterState+'&stateText='+stateText;
}


function overviewPage(id,ref,cut,st,ct,message){
    var designation = 'Customer';
    window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}