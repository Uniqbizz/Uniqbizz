//rejection modal
function openRejectReasonModal() {
    // Hide the current modal (whichever is open)
    $('.modal.show').modal('hide');

    // Wait a short moment before showing the new one
    setTimeout(function() {
        $('#rejectReasonModal').modal('show');
    }, 400);
}

function showoverlay(ta_id, ta_fname, ta_lname, ta_amount, ta_pay_mode, ta_cheque_no, ta_cheque_date,
    ta_bank_name, ta_transac_id, ta_ref_img, ta_created_date, status, ta_amt_id,reject_reason) {
    console.log('reject_reason:' + reject_reason);
    
    $('#ta_reject_reason').val(reject_reason);
    $('#user_id_name').val(ta_id);
    $('#reference_name').val(ta_fname + ' ' + ta_lname);
    $('#ta_amt').val(ta_amount)
    $('#ta_pay_mode').val(ta_pay_mode);
    $('#created_date').val(ta_created_date);
    $('#status').val(status);
    $('#ta_top_amt_id').val(ta_amt_id);
    if (ta_pay_mode == 'cash') {
        $("#previewcheque1").attr("src", "../../../uploading/" + ta_ref_img);
        $("#previewcheque2").val(ta_ref_img);
        $('#chequeOpt').addClass("d-none");
        $('#onlineOpt').addClass("d-none");
    } else if (ta_pay_mode == 'cheque') {
        $('#chequeOpt').removeClass("d-none");
        $('#onlineOpt').addClass("d-none");
        $('#chequeNo').val(ta_cheque_no);
        $('#chequeDate').val(ta_cheque_date);
        $('#bankName').val(ta_bank_name);
        $("#previewcheque1").attr("src", "../../../uploading/" + ta_ref_img);
        $("#previewcheque2").val(ta_ref_img);
    } else if (ta_pay_mode == 'online') {
        $('#chequeOpt').addClass("d-none");
        $('#onlineOpt').removeClass("d-none");
        $('#transactionNo').val(ta_transac_id);
        $("#previewcheque1").attr("src", "../../../uploading/" + ta_ref_img);
        $("#previewcheque2").val(ta_ref_img);
    }
    //to show/hide accept reject div
    var status = $('#status').val();
    console.log('status:' + status);

    if (status == 1) {
        $('#payaction_div').removeClass("d-none");
    } else if (status != 1) {

        $('#payaction_div').addClass("d-none");
        
    }
    if(status == 3){
        $('#ta_reject_reason_div').removeClass("d-none");
    }else{

        $('#ta_reject_reason_div').addClass("d-none");
    }
    //------------

}
$(document).ready(function() {
    var table = $("#pendingTopUp-table").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        columnDefs: [{
            targets: 0,
            orderable: false
        }], // Prevent sorting on the expand button
        createdRow: function(row, data, dataIndex) {
            if ($(row).hasClass("nested-table-row")) {
                return; // Ignore nested rows
            }
        }
    });

    // Handle expand/collapse of nested rows
    $("#pendingTopUp-table").on("click", ".details-control", function() {
        var tr = $(this).closest("tr");
        var ta_id = tr.data("ta-id");
        var detailsRow = $("#details-" + ta_id);
        var nestedContent = detailsRow.find(".nested-content");
        var exportBtn = tr.find(".exportCSV"); // Correctly select button

        if (detailsRow.is(":visible")) {
            detailsRow.hide();


        } else {
            if (!detailsRow.hasClass("loaded")) {
                $.ajax({
                    url: "ta-top-up-details.php",
                    method: "POST",
                    data: {
                        ta_id: ta_id
                    },
                    success: function(response) {
                        nestedContent.html(response);
                        detailsRow.show().addClass("loaded");

                        // Initialize DataTable for the nested table inside
                        nestedContent.find("table").DataTable({
                            retrieve: true,
                            paging: true,
                            searching: true,
                            ordering: false
                        });

                        // tr.find(".details-control").text("-");
                        // exportBtn.removeClass('d-none');
                    }
                });
            } else {
                detailsRow.show();
                // tr.find(".details-control").text("-");
                // exportBtn.removeClass('d-none');

            }
        }
    });

    var table = $("#approvedTopUp-table").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        createdRow: function(row, data, dataIndex) {
            // Ensure DataTables only processes rows in the main tbody
            if ($(row).closest("tbody").hasClass("nested-tbody")) {
                return; // Skip processing for nested rows
            }
        }
    });

    // Handle expand/collapse of nested rows
    $("#approvedTopUp-table").on("click", ".details-control", function() {
        var tr = $(this).closest("tr");
        var ta_id = tr.data("ta-id");
        var detailsRow = $("#secdetails-" + ta_id);
        var nestedContent = detailsRow.find(".nested-content1");
        var exportBtn = tr.find(".exportCSV1"); // Fix: Ensure correct export button selection

        if (detailsRow.is(":visible")) {
            detailsRow.hide();
            // $(this).text("+");
            // exportBtn.addClass("d-none");
        } else {
            if (!detailsRow.hasClass("loaded")) {
                $.ajax({
                    url: "../../controllers/ta-top-up/ta_top_up_approve_reject_details.php",
                    method: "POST",
                    data: {
                        ta_id: ta_id
                    },
                    success: function(response) {
                        console.log("Response received:", response);
                        nestedContent.html(response);
                        detailsRow.show().addClass("loaded");

                        // Initialize DataTable for the nested table (if not already initialized)
                        nestedContent.find("table").each(function() {
                            if (!$.fn.DataTable.isDataTable(this)) {
                                $(this).DataTable({
                                    retrieve: true,
                                    paging: true,
                                    searching: true,
                                    ordering: false
                                });
                            }
                        });

                        // tr.find(".details-control").text("-");
                        // exportBtn.removeClass("d-none");
                    }
                });
            } else {
                detailsRow.show();
                // exportBtn.removeClass("d-none");
                // tr.find(".details-control").text("-");
            }
        }
    });

});
// Handle individual user CSV download //pending
$(document).on("click", ".exportCSV", function(e) {
    e.preventDefault(); // Prevent default anchor behavior

    var ta_id = $(this).data("ta-id"); // Fetch data-ta-id correctly
    console.log('ta_id:', ta_id);

    if (ta_id) {
        window.location.href = "../../controllers/ta-top-up/export.php?ta_id=" + ta_id;
    } else {
        console.error("TA ID not found!");
    }
});
// Handle individual user CSV download //approve/reject
$(document).on("click", ".exportCSV1", function(e) {
    e.preventDefault(); // Prevent default anchor behavior

    var ta_id = $(this).data("ta-id"); // Fetch data-ta-id correctly
    console.log('ta_id:', ta_id);

    if (ta_id) {
        window.location.href = "../../controllers/ta-top-up/export1.php?ta_id=" + ta_id;
    } else {
        console.error("TA ID not found!");
    }
});

// Handle bulk download for all data tables
$("#exportAllData").click(function() {
    window.location.href = "../../controllers/ta-top-up/export.php?all=true"; // Pass parameter to export all data(pendong)
});
$("#exportAllData1").click(function() {
    window.location.href = "../../controllers/ta-top-up/export1.php?all=true"; // Pass parameter to export all data(Approve/Reject)
});

function actionMarkup(status) {

    var taid = $('#user_id_name').val();
    var created_date = $('#created_date').val();
    var ta_amt_id = $('#ta_top_amt_id').val();
    var ta_amount = $('#ta_amt').val();
    var rejectionReason = $('#rejectionReason').val();
    var dataString = 'created_date=' + created_date + '&taid=' + taid + '&status=' + status + '&ta_amount=' +
        ta_amount + '&ta_amt_id=' + ta_amt_id + '&rejection_reason='+rejectionReason;

    $.ajax({
        type: "POST",
        url: "../../controllers/ta-top-up/ta_top_up_action.php",
        data: dataString,
        cache: false,
        success: function(data) {
            console.log('data' + data);
            if (data == '2') {
                alert("Top Up Aproved");
                window.location.reload();
            } else if (data == '3') {
                alert("Top Up Rejected");
                window.location.reload();
            }
        }
    });

};