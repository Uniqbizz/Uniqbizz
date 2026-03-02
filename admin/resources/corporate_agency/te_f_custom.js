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
});

function editfuncCust(id,refno,regby,cut,st,ct,editfor,usertype){ 
    window.location.href='../../views/corporate_agency/edit_corporate_agency.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor+'&usertype='+usertype;
};

function deletefunc(id,fid,action,usertype){ 
    var dataString = 'id='+id+'&refid='+fid+'&action='+action+'&usertype='+usertype;

    $.ajax({
    type: "POST",
    url: "../../controllers/corporate_agency/delete_corporate_agency.php",
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
//only for frnachisee users
var rejectId = null;
var rejectRecId = null;

function approvalfunc(id, action,rec_id){

    if(action == "reject"){
        rejectId = id;
        rejectRecId = rec_id;
        $("#rejectReason").val("");
        $("#charCount").text("0 / 1000");
        $("#rejectModal").modal("show");
        return;
    }

    sendApproval(id, action, "",rec_id);
}

function sendApproval(id, action, reason, rec_id){

    $.ajax({
        type: "POST",
        url: "../../controllers/corporate_agency/approve_reject_franchisee_upgrade.php",
        data: {
            id: id,
            action: action,
            reason: reason,
            rec_id: rec_id
        },
        success:function(data){
            if(data == 1){
                alert("Upgrade Approved");
                location.reload();
            }else if(data == 2){
                alert("Upgrade Rejected");
                location.reload();
            }else{
                alert("Request Failed !!");
            }
        }
    });
}
//rejection modal
$("#rejectReason").on("input", function(){
    $("#charCount").text(this.value.length + " / 1000");
});

$("#confirmReject").click(function(){

    var reason = $("#rejectReason").val().trim();

    if(reason == ""){
        alert("Rejection reason is required!");
        return;
    }

    sendApproval(rejectId, "reject", reason, rec_id);
    $("#rejectModal").modal("hide");
});

function confirmfunc(id,email,usertype){ 

    var dataString = 'id='+ id+'&uname='+email+'&usertype='+usertype;
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "../../controllers/corporate_agency/confirm_corporate_agency.php",
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
    var designation = message=='corporate_agency'?'Techno Enterprise':(message=='sub_franchisee'?'Franchisee':'');
    window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}
//franchisee upgrade
function upgradePage(id,ref){
    // var designation = message=='corporate_agency'?'Techno Enterprise':(message=='sub_franchisee'?'Franchisee':'');
    window.location.href='upgrade_franchisee.php?id='+id+'&ref='+ref;
}

// Hide date label and show input type date 
var cap_date = document.getElementById("cap_date");
var cap_text = document.getElementById("cap_text");
var cap_text_1 = document.getElementById("cap_text_1");
var cap_text_1 = document.getElementById("cap_text_2");
var cap_month = document.getElementById("month_year");
var cap_month = document.getElementById("month_year_1");
cap_text.addEventListener("click", function(){
    cap_date.classList.replace("d-none","d-block");
    cap_text.classList.add("d-none");
} );
cap_text_1.addEventListener("click", function(){
    cap_month.classList.replace("d-none","d-block");
    cap_text_1.classList.add("d-none");
} );

//for tc allotment
//on load
document.addEventListener('DOMContentLoaded', function () {
    function runFilterCA() {
        $('#download_icon').removeClass('d-none');

        var designation = $('#designation').val() || "";
        var package = $('#business_pack').val();
        var StartFrom = $('#cap_date').val();
        var EndFrom = $('#month_year_1').val();

        var dataString = 'package=' + package +
                        '&StartFrom=' + StartFrom +
                        '&EndFrom=' + EndFrom +
                        '&designation=' + designation;

        $.ajax({
        type: 'POST',
        url: '../../controllers/corporate_agency/filter_view_table_ca.php',
        data: dataString,
        cache: false,
        success: function (data) {

            console.log('AJAX response:', data); // remove after debug

            if ($.fn.DataTable.isDataTable('#registeredCustomerList-table')) {
                $('#registeredCustomerList-table').DataTable().clear().destroy();
            }

            $('#registeredCustomerList-table tbody').html(data);

            // $.fn.dataTable.moment('DD-MM-YYYY');

            let table = $('#registeredCustomerList-table').DataTable({
                order: [[5, 'asc']]
            });

            let TotalAmt = 0;
            let rowCount = table.rows().count();

            table.rows().every(function () {
            let amount = parseFloat(this.data()[4]) || 0;
            TotalAmt += amount;
            });

            $('#caAmt').val(TotalAmt);
            $('#caCount').val(rowCount);
        }
        });
    }

    // 🔥 Trigger on input + change
    $('#filterCA, #designation, #business_pack, #cap_date, #month_year_1')
        .on('input change', function (e) {
            e.preventDefault();
            runFilterCA();
        });

    // 🚀 Run once on page load (default filter)
    runFilterCA();
    var tcAllotmentModal = document.getElementById('tcAllotmentModal');

    tcAllotmentModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // The <a> tag that triggered the modal

        // Get values from data attributes
        var assignStatus = button.getAttribute('data-bs-assign');
        var tcNum = button.getAttribute('data-bs-tcnum');
        var teId = button.getAttribute('data-bs-teid');

        // Store these values in hidden inputs inside the modal
        // (Create these hidden inputs in the modal footer or body)
        document.getElementById('hiddenAssign').value = assignStatus;
        document.getElementById('hiddenTcNum').value = tcNum;
        document.getElementById('hiddenTeid').value = teId;

        // (Optional) Update the UI dynamically if needed
        document.getElementById('allowedCount').textContent = tcNum; // Show allowed TC count
    });
});
let allowedCount = 0;

// Bind official_purpose change ONCE (outside the checkbox toggle)
$('input[name="official_purpose"]').on('change', function() {
    allowedCount = parseInt($(this).val());
    $('#allowedCount').text(allowedCount);
    $('#selectedCount').text(0);
    $('#selectedTCsInput').val('');

    // let reference_no = $('#user_id_name').val();

    $.ajax({
        url: '../../controllers/corporate_agency/get_all_bm_tc.php',
        type: 'POST',
        data: {
            tc_count: allowedCount
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
//save changes
$("#AlocTC").on('click',function(){
    var teid = $("#hiddenTeid").val();
    var tcCount = $('input[name="official_purpose"]:checked').val();
    var selected_count = $('#selectedCount').text();
    let selectedIds = [];
    $('input[name="tc_ids[]"]:checked').each(function () {
        selectedIds.push($(this).val());
    });
    var data={
        id:teid,
        tcCount:tcCount,
        selectedIds:selectedIds
    }
    console.log(data);
    
    //AJAX request
    $.ajax({
        url: '../../controllers/corporate_agency/allocate_tcs.php', // Replace with your actual PHP handler
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json', // Important for JSON
        dataType: 'json', // Expect JSON response
        success: function (response) {
            if (response.status == 'success') {
                // Success case
                alert(response.message);
                $('#tcAllotmentModal').modal('hide');
                // Optional: refresh table or update UI
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    });
});
//end
//show tc allotment
document.addEventListener('DOMContentLoaded', function () {
    var allottedTCModal = document.getElementById('allottedTCModal');

    allottedTCModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // The <a> tag that triggered the modal

        // Get values from data attributes
        var assignStatus = button.getAttribute('data-bs-assign');
        var tcNum = button.getAttribute('data-bs-tcnum');
        var teId = button.getAttribute('data-bs-teid');

        // Store these values in hidden inputs inside the modal
        // (Create these hidden inputs in the modal footer or body)
        document.getElementById('hiddenAssign1').value = assignStatus;
        document.getElementById('hiddenTcNum1').value = tcNum;
        document.getElementById('hiddenTeid1').value = teId;

        
    });
});
function loadAllottedTCs() {
    var teId = $("#hiddenTeid1").val(); // added missing '#' for id selector
    $.ajax({
        url: '../../controllers/corporate_agency/get_allotted_tcs.php',
        type: 'POST',
        contentType: 'application/json', // tell server we send JSON
        data: JSON.stringify({ te_id: teId }), // convert to JSON string
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                let tbody = $('#allottedTCTable tbody');
                tbody.empty();
                
                response.data.forEach((item, index) => {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.travel_agency}</br> ( ${item.tc_id} )</td>
                            <td>${item.corporate_agency}</br> ( ${item.te_id} )</td>
                            <td>${item.registrant}</br> ( ${item.reference_no} )</td>
                            <td>${item.business_mentor}</br> (${item.bm_id})</td>
                            <td>${item.map_date}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                $('#allottedTCModal').modal('show');
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Failed to fetch allotted TC details.');
        }
    });
}


$('#allottedTCModal').on('shown.bs.modal', function (event) {
    loadAllottedTCs();
});

//end 
//download excel
function regTcDownload() {
    var packageVal  = $('#business_pack').val() || "";
    var designation = $('#designation').val()   || "";
    var startFrom   = $('#cap_date').val()      || "";
    var endFrom     = $('#month_year_1').val()  || "";

    var params = new URLSearchParams({
        package: packageVal,
        StartFrom: startFrom,
        EndFrom: endFrom,
        designation: designation
    });

    window.location.href = "../../controllers/corporate_agency/download_list.php?" + params.toString();
}