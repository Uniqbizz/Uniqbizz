const currentDate = new Date();
var getCurrentYear = currentDate.getFullYear();

var get_payout;

$(document).ready(function () {
    // get_payout = document.getElementById('get_payout').value;

    // var getNextMonth = currentDate.getMonth() + 2 ;
    // var min = 2019+'-'+getNextMonth;
    // var max = getCurrentYear+'-'+getNextMonth;
    //     $("#month_year").attr({
    //         "min" : min,
    //         "max" : max
    //     });
    // $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="9">No User Selected</td></tr>');

    // console.log("ssssssssssss");
});

var month_year = '';
var quater_year = '';
var payout_status = '';
var designation = '';
var user_id = '';
var user_registration_date;
var level_1_id = '';

var getCurrentMonth, getCurrentDay;

var col_1 = document.getElementById('col_1');
var col_2 = document.getElementById('col_2');
var col_3 = document.getElementById('col_3');
var col_4 = document.getElementById('col_4');

var get_total_payout = document.getElementById('get_total_payout');
var generate_payout = document.getElementById('generate_payout');
var generate_payout_button = document.getElementById('generate_payout_button');
var generate_quarterly_payout = document.getElementById('generate_quarterly_payout');

var payout_type;
var levels_title = document.getElementById('levels_title');
var active_customer_field = document.getElementById("active_customer_field");
var payout_type_field = document.getElementById("payout_type_field");
var month_year_title = document.getElementById("month_year_title");
var month_year_field = document.getElementById("month_year_field");
var quater_year_field = document.getElementById("quater_year_field");
var payout_status_field = document.getElementById("payout_status_field");

// get Users
// Mapping for column text based on designation
const columnMapping = {
    bm: { col_1: "Sr. No.", col_2: "BM ID", col_3: "Payout Message" },
    bdm: { col_1: "Sr. No.", col_2: "BDM ID", col_3: "Payout Message" },
    bcm: { col_1: "Sr. No.", col_2: "BCM ID", col_3: "Payout Message" }
};

// Store user details in an array to optimize performance
var userDetailsArray = [];

// Handle designation change
$('#designation').on('change', function () {
    designation = $(this).val();
    let bmlist = $("#bm_list");
    let bdmlist = $("#bdm_list");

    let bmTable = $("#bmTable").DataTable();
    let bdmTable = $("#bdmTable").DataTable();

    // Hide or show tables based on designation and clear them
    if (designation === 'bm') {
        bmlist.addClass('d-none');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    } else if (designation === 'bdm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
    } else if (designation === 'bcm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.removeClass('d-none').addClass('d-block');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    }
    month_year = new Date().toISOString().slice(0, 7);
    $('#month_year').val(month_year)//by default show currebnt montn year
    $('#payout_type').val('monthly');
    payout_type = $('#payout_type').val();
    $("#user_details").hide();
    $("#user_name").val("");
    $("#address").val("");
    $("#email").val("");
    $("#mobile").val("");


    // if (payout_type == 'monthly') {
    //     showBottomSnackBar("Please, Select Payout Month !! ");
    // }

    month_year_title.innerText = "Select Month & Year";

    if (columnMapping[designation]) {
        updateColumns(columnMapping[designation]);
        payout_type_field.style.display = "block";
        payout_status_field.style.display = "none";
        active_customer_field.style.display = "block";

        // Clear previous user details & reset user dropdown
        userDetailsArray = [];
        resetUserSelection();
        getUsers(designation, month_year);
    } else {
        resetUserSelection();
    }

    checkAndFetchPayoutDetails(designation, month_year, payout_type);
});

// Handle user selection change
$("#user_id_name").on('change', function () {
    let selectedUserid = $(this).val();
    
    let designation = $('#designation').val();
    // let month_year = $('#month_year').val();
    // let payout_type = $('#payout_type').val();

    let bmlist = $("#bm_list");
    let bdmlist = $("#bdm_list");

    let bmTable = $("#bmTable").DataTable();
    let bdmTable = $("#bdmTable").DataTable();

    // Hide or show tables based on designation and clear them
    if (designation === 'bm') {
        bmlist.addClass('d-none');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    } else if (designation === 'bdm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
    } else if (designation === 'bcm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.removeClass('d-none').addClass('d-block');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    }

    if (selectedUserid && selectedUserid !== '--Select Designation First--' && selectedUserid !== '--Select User ID & Name First--') {
        user_id = selectedUserid;
        
        
        getActiveCount(designation, month_year, selectedUserid);

        if (designation === 'bdm' || designation === 'bcm') {
            $.ajax({
                url: "form/getbmdetails.php",
                type: "POST",
                data: { designation: designation, user_id: user_id, month_year: month_year },
                dataType: "json",
                success: function (response) {
                    // Update BM Table
                    //let bmTable = $("#bmTable").DataTable();
                    bmTable.clear();

                    if (response.bm_list.length > 0) {
                        $.each(response.bm_list, function (index, data) {
                            bmTable.row.add([
                                index + 1,
                                data.user_id,
                                data.name,
                                data.active_te_count
                            ]).draw();
                        });
                    } else {
                       
                        // Add a row that spans all columns
                        bmTable.row.add([
                            "No Data Available", "", ""
                        ]).draw();

                        // Center align the "No Data Available" text
                        $('#userTable tbody tr td').attr('colspan', 3).css('text-align', 'center');
                    }

                    // Update BDM Table only if BCM is selected
                    if (designation === 'bcm') {
                        //let bdmTable = $("#bdmTable").DataTable();
                        bdmTable.clear();

                        if (response.bdm_list.length > 0) {
                            $.each(response.bdm_list, function (index, data) {
                                bdmTable.row.add([
                                    index + 1,
                                    data.user_id,
                                    data.name,
                                    data.active_te_count
                                ]).draw();
                            });
                        } else {
                            // Add a row that spans all columns
                        bdmTable.row.add([
                            "No Data Available", "", ""
                        ]).draw();

                        // Center align the "No Data Available" text
                        $('#userTable tbody tr td').attr('colspan', 3).css('text-align', 'center');
                        }
                    }
                }
            });
        }
    }

    checkAndFetchPayoutDetails(designation, month_year, payout_type);
});
//
$('#payout_type').on('change', function () {
    payout_type = $(this).val()

    checkAndFetchPayoutDetails(designation, month_year, payout_type);
});
// Handle month & year selection change
$('#month_year').on('change', function () {
    month_year = $(this).val()
    let designation = $('#designation').val();
    //let payout_type = $('#payout_type').val();
    // Clear previous user details & reset user dropdown
        userDetailsArray = [];
        resetUserSelection();
        getUsers(designation, month_year);
    let user_id = $('#user_id_name').val(); // Get the selected user ID

    let bmlist = $("#bm_list");
    let bdmlist = $("#bdm_list");

    let bmTable = $("#bmTable").DataTable();
    let bdmTable = $("#bdmTable").DataTable();

    // Hide or show tables based on designation and clear them
    if (designation === 'bm') {
        bmlist.addClass('d-none');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    } else if (designation === 'bdm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.addClass('d-none');
        bmTable.clear().draw();
    } else if (designation === 'bcm') {
        bmlist.removeClass('d-none').addClass('d-block');
        bdmlist.removeClass('d-none').addClass('d-block');
        bmTable.clear().draw();
        bdmTable.clear().draw();
    }

    if (!user_id || user_id === '--Select User ID & Name First--') {
        return; // Stop execution if no user is selected
    }

    checkAndFetchPayoutDetails(designation, month_year, payout_type);

    if (designation === 'bdm' || designation === 'bcm') {
        $.ajax({
            url: "form/getbmdetails.php",
            type: "POST",
            data: { designation: designation, user_id: user_id, month_year: month_year },
            dataType: "json",
            success: function (response) {
                // Update BM Table
                //let bmTable = $("#bmTable").DataTable();
                bmTable.clear();

                if (response.bm_list.length > 0) {
                    $.each(response.bm_list, function (index, data) {
                        bmTable.row.add([
                            index + 1,
                            data.user_id,
                            data.name
                        ]).draw();
                    });
                } else {
                    // Add a row that spans all columns
                    bmTable.row.add([
                        "No Data Available", "", ""
                    ]).draw();

                    // Center align the "No Data Available" text
                    $('#userTable tbody tr td').attr('colspan', 3).css('text-align', 'center');
                }

                // Update BDM Table only if BCM is selected
                if (designation === 'bcm') {
                    //let bdmTable = $("#bdmTable").DataTable();
                    bdmTable.clear();

                    if (response.bdm_list.length > 0) {
                        $.each(response.bdm_list, function (index, data) {
                            bdmTable.row.add([
                                index + 1,
                                data.user_id,
                                data.name
                            ]).draw();
                        });
                    } else {
                        // Add a row that spans all columns
                        bdmTable.row.add([
                            "No Data Available", "", ""
                        ]).draw();

                        // Center align the "No Data Available" text
                        $('#userTable tbody tr td').attr('colspan', 3).css('text-align', 'center');
                    }
                }
            }
        });
    }

});



// Function to check and fetch user table details
function checkAndFetchPayoutDetails(designation, month_year, payout_type) {
    let user_id = $("#user_id_name").val();
    if (designation && month_year && user_id && payout_type) {
        getUserTableDetails(designation, month_year, user_id, payout_type);
    } else {
        getUserTableDetails(designation, month_year, user_id, payout_type);
    }
}

// Function to update column headers
function updateColumns(columns) {
    col_1.innerText = columns.col_1;
    col_2.innerText = columns.col_2;
    col_3.innerText = columns.col_3;
}

// Function to fetch users based on designation
function getUsers(designation, month_year) {

    $.ajax({
        url: "form/getUser.php",
        type: "POST",
        data: { designation: designation, month_year: month_year },
        success: function (response) {
            $("#user_id_name").html(response);
        }
    });
}

// Function to reset user selection dropdown
function resetUserSelection() {
    $("#user_id_name").html('<option value="">--Select Designation First--</option>');
}

// Function to get active user count
function getActiveCount(designation, month_year, user_id) {
    console.log('in get active count');
    $.ajax({
        url: "form/getActiveUserCount.php",
        type: "POST",
        data: { designation: designation, month_year: month_year, user_id: user_id },
        success: function (response) {
            console.log('res:'+response);
            
            $("#active_customers").val(response);
        }
    });
}

// Function to fetch user table details
function getUserTableDetails(designation, month_year, user_id, payout_type) {
    console.log("seleted month year:"+month_year);
    $.ajax({
        url: "form/getpayoutdetails.php",
        type: "POST",
        data: { designation: designation, month_year: month_year, user_id: user_id, payout_type: payout_type },
        dataType: "json",
        success: function (response) {
            let table = $("#userTable").DataTable();
            table.clear(); // Clear existing data

            if (response.length > 0) {
                $.each(response, function (index, data) {
                    table.row.add([
                        index + 1,
                        data.user_id,
                        data.message,
                        "₹ " + parseFloat(data.payout_amount).toFixed(2) + "/-",
                        "₹ " + parseFloat(data.tds).toFixed(2) + "/-",
                        "₹ " + parseFloat(data.total).toFixed(2) + "/-",
                        `<a href="#" class="view-payment" title="View Payment"><i class="fa fa-eye" aria-hidden="true"></i><input type='hidden' class='ca_user_id' value="${data.ca_user_id}"></a>`,
                        data.payout_status == 1 ? "Pending" :
                            data.payout_status == 2 ? "Paid" :
                                data.payout_status == 3 ? "Blocked" : ""

                    ]).draw();
                });
            } else {
                // Add a row that spans all columns
                table.row.add([
                    "No Data Available", "", "", "", "", "", "", ""
                ]).draw();

                // Center align the "No Data Available" text
                $('#userTable tbody tr td').attr('colspan', 8).css('text-align', 'center');
            }

           
        },
        
    });
}

// Attach click event to the eye button
$("#userTable tbody").on("click", ".view-payment", function () {
    let row = $(this).closest("tr");
    let table = $("#userTable").DataTable();

    let rowData = table.row(row).data();

    if (rowData) {
        let userId = rowData[1]; // Extract user ID
        let payoutAmount = rowData[3].replace("\u20B9 ", "").replace("/-", "");
        let tds = rowData[4].replace("\u20B9 ", "").replace("/-", "");
        let total = rowData[5].replace("\u20B9 ", "").replace("/-", "");

        let payoutStatus = rowData[7]?.toLowerCase().includes("pending") ? "Pending Due Date" :
            rowData[7]?.toLowerCase().includes("paid") ? "Paid" : "Blocked";

        let caUserId = rowData.ca_user_id || row.find(".ca_user_id").val(); // Fix

        // ✅ Extract Payment ID, Payment Date, and Message from rowData
        let paymentId = "";  // Assuming first column is c_trans_id
        let releaseDate = ""; // Assuming third column is payment_date
        let paymessage = ""; // Assuming sixth column is message

        $("#payment_status")
            .text(payoutStatus)
            .removeClass("btn-primary btn-success btn-warning btn-danger d-block d-none")
            .addClass(
                payoutStatus === "Pending Due Date" ? "btn-warning d-block" :
                    payoutStatus === "Blocked" ? "btn-danger d-block" :
                        payoutStatus === "Paid" ? "btn-success d-block" : ""
            );

        console.log("Updated payout status class:", payoutStatus);
        if (payoutStatus == 'Paid') {
            $('#get_net_payable_title').text("Amount Paid :<br>₹ " + parseFloat(total).toFixed(2))
            $('#paybtn').hide();
        } else {
            $('#paybtn').show();
        }
        //$('#get_net_payable_title').text(payoutStatus === "Paid" ? "Amount Paid :" : "Amount to be paid :");

        $("#get_net_payable").text(parseFloat(total).toFixed(2));
        $("#c_id").val(userId);
        $("#payout_earned").val(parseFloat(payoutAmount).toFixed(2));
        $("#c_tds").val(parseFloat(tds).toFixed(2));
        $("#c_amount_share").val(parseFloat(total).toFixed(2));
        $("#ca_user_id").val(caUserId);

        // ✅ Set Payment ID, Payment Date, and Message
        $("#c_trans_id").val(paymentId);
        $("#c_trans_mode").val(releaseDate);
        $("#c_message").text(paymessage);

        $("#view_payout_details").removeClass("d-none").addClass("d-block");
        $("#view_payout").addClass("d-none");

        let designation = $("#designation").val();
        let existingUser = userDetailsArray.find(user => user.user_id === userId);

        if (existingUser) {
            $("#c_name").val(existingUser.name);
            $("#address").val(existingUser.address);
            $("#c_email").val(existingUser.email);
            $("#c_mobile").val(existingUser.contact_no);
        } else {
            $.ajax({
                type: "POST",
                url: "form/get_user_details.php",
                data: { user_id: userId, designation: designation },
                dataType: "json",
                success: function (res) {
                    if (res) {
                        let userData = {
                            caUserId: caUserId,
                            user_id: userId,
                            name: res.firstname && res.lastname ? `${res.firstname} ${res.lastname}` : res.name ?? "N/A",
                            address: res.address ?? "N/A",
                            email: res.email ?? "N/A",
                            contact_no: res.contact_no ?? res.contact ?? "N/A"
                        };

                        userDetailsArray.push(userData);
                        $("#c_name").val(userData.name);
                        $("#address").val(userData.address);
                        $("#c_email").val(userData.email);
                        $("#c_mobile").val(userData.contact_no);
                    } else {
                        alert("No details found for the selected user.");
                    }
                },
                error: function () {
                    alert("Error fetching user details.");
                }
            });
        }

        // ✅ Fetch payment details from `getpayoutdetail.php`
        $.ajax({
            type: "POST",
            url: "form/getpayoutdetail.php",
            data: { user_id: userId, designation: designation, month_year: $("#month_year").val(), payout_type: "monthly" },
            dataType: "json",
            success: function (res) {
                console.log("Payout Details Response: ", res);

                if (res.length > 0) {
                    // ✅ Match record based on payout amount and date
                    let paymentDetails = res.find(p =>
                        parseFloat(p.payout_amount) === payoutAmount &&
                        p.payout_date === payoutDate
                    );

                    if (!paymentDetails) {
                        console.warn("No exact match found, using first record.");
                        console.log("Available payout records:", res);
                        paymentDetails = res[0]; // Fallback to first record
                    }

                    console.log("Selected Payment Details:", paymentDetails);

                    // ✅ Update modal fields with matched data
                    $("#c_trans_id").val(paymentDetails.paymentid || "N/A");
                    $("#c_trans_mode").val(paymentDetails.release_date || "N/A");
                    $("#c_message").val(paymentDetails.payment_message || "N/A");
                } else {
                    console.warn("No payout records found for this user.");
                    $("#c_trans_id").val("N/A");
                    $("#c_trans_mode").val("N/A");
                    $("#c_message").val("No message available");
                }
            },
            error: function () {
                console.error("Error fetching payout details");
            }
        });

    } else {
        alert("User details not found!");
    }
});





// User details block
var isUserDetails = false;
function showUserDetails() {
    let user_id = $("#user_id_name").val();
    let designation = $("#designation").val();
    let userDetails = $("#user_details");


    if (user_id) {
        if (isUserDetails) {
            isUserDetails = false;
            userDetails.hide();
        } else {
            isUserDetails = true;
            userDetails.show();

            $.ajax({
                type: "POST",
                url: "form/get_user_details.php",
                data: { user_id: user_id, designation: designation },
                dataType: "json",
                success: function (res) {
                    if (res) {
                        $("#user_name").val(res.firstname ? user_id + " " + res.firstname + " " + res.lastname : user_id + " " + res.name);
                        $("#address").val(res.address ?? "N/A");
                        $("#email").val(res.email ?? "N/A");
                        $("#mobile").val(res.contact_no ?? res.contact ?? "N/A");
                    } else {
                        alert("No details found for the selected user.");
                    }
                },
                error: function () {
                    alert("Error fetching user details.");
                }
            });
        }
    } else {
        alert("Please select User ID First!");
    }
}
function hidepayoutdetails() {
    $("#view_payout_details").removeClass("d-block").addClass("d-none");
    $("#view_payout").removeClass("d-none").addClass("d-block");
}
// Generate payid uniquely with payment mode
function makeid(payType) {
    let timestamp = Date.now(); // Get the current timestamp
    return `Payment_${payType}_${timestamp}`;
}

// Make Payment
function makePayment(payType) {
    let pay_id = makeid(25, payType);
    let payment_message = $('#payment_message').val();
    let payment_date = $('#payment_date').val();
    let status = payType === 'block' ? 3 : 2;

    payout_type = $('#payout_type').val();
    let month_year = $('#month_year').val();
    let user_id = $('#c_id').val();
    let designation = $('#designation').val();
    let te = $('#ca_user_id').val(); // Fixed ca_user_id reference

    if (!user_id || !month_year || !designation) {
        alert("Please select the Designation, User ID -- Name, and Month-Year to proceed");
        return;
    }

    let data = {
        te: te,
        user_id: user_id,
        month_year: month_year,
        payment_message: payment_message,
        payment_date: payment_date,
        pay_id: pay_id,
        designation: designation,
        status: status
    };

    $.ajax({
        type: "POST",
        url: "form/make_payment.php",
        data: data,
        success: function (res) {
            console.log('Response:', res);

            if (res == 2) {
                alert(`Payment ${payType === 'block' ? 'Blocked' : 'Successful'}!`);
                $('#show_payment_box').modal('hide');
                $("#payment_status")
                    .text(["online", "offline"].includes(payType.toLowerCase()) ? "Paid" : "")
                    .removeClass("btn-primary btn-success btn-warning btn-danger d-block d-none")
                    .addClass("btn-success", ["online", "offline"].includes(payType.toLowerCase()));

                $("#get_net_payable_title").text(payType === "Paid" ? "Amount Paid :" : "Amount to be paid :");

                $("#payment_btn").hide();
                $("#c_trans_id").val(pay_id);
                $("#c_trans_mode").val(payment_date);
                $("#c_message").val(payment_message);
                $("#view_payout_details").removeClass("d-none").addClass("d-block");

            } else if (res == 3) {
                alert("Payment has been Declined!");
                $('#show_payment_box').modal('hide');
                $("#payment_status")
                    .text(payType == 'block' ? 'Blocked' : '')
                    .removeClass("btn-primary btn-success btn-warning btn-danger d-block d-none")
                    .addClass(payType === "block" ? "d-none" : "d-block");
                $('#get_net_payable_title').text(payType === "Paid" ? "Amount Paid :" : "Amount to be paid :");

                //$("#payment_btn").hide();
                $("#c_trans_id").val(pay_id);
                $("#c_trans_mode").val(payment_date);
                $("#c_message").val(payment_message);
                $("#view_payout_details").removeClass("d-none").addClass("d-block");
                // Refresh DataTable
                let table = $("#userTable").DataTable();
                table.ajax.reload(null, false); // Reload data, keep current paging

            } else {
                alert("Unexpected response: " + res);
            }
            getUserTableDetails(designation, month_year, user_id, payout_type)
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("Payment request failed.");
        }
    });
}

function hidePaymentBox() {
    document.getElementById("view_payout").style.display = "block";
    document.getElementById("view_payout_details").style.display = "block";
    document.getElementById("show_payment_box").style.display = "none";
}


//SV changes till here
// $.ajax({
//     type:'POST',
//     url:'forms/get_users',
//     data: "designation="+designation,
//     success:function (e) {
//         // console.log(e);
//         $('.user_row').remove();
//         if ( e == "no_users" ) {
//             alert("No Users Found !!");
//             $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="9">No Records Found</td></tr>');
//         } else {
//             $('#user_id_name').html(e);
//             $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="9">No User Selected</td></tr>');
//         }
//     },
//     error: function(err){
//         console.log(err);
//     },
// });

// get Levels
// $('#user_id_name').on('change', function() {
//     designation = $('#designation').val();
//     user_id = $('#user_id_name').val();
//     month_year = $('#month_year').val();
//     quater_year = $('#quater_year').val();
//     payout_type = $('#payout_type').val();

//     var data = {
//         user_id:user_id,
//         designation:designation,
//         month_year:month_year
//     };

//     if ( designation == "bdm" ) {

//         if ( month_year == "") {
//             if ( payout_type == 'monthly' ) {
//                 showBottomSnackBar("Please, Select Payout Month !! ");
//             }     // Empty Month

//             if ( payout_type == 'all' ) {
//                 getFranchisee();
//             }

//         } else {
//             // console.log(' month not empty !! ');
//             getFranchisee();
//         }

//     }else if ( designation == "bdm" ) {

//         if ( month_year == "") {
//             if ( payout_type == 'monthly' ) {
//                 showBottomSnackBar("Please, Select Payout Month !! ");
//             }     // Empty Month

//             if ( payout_type == 'all' ) {
//                 getFranchisee();
//             }

//         } else {
//             // console.log(' month not empty !! ');
//             getFranchisee();
//         }

//     }else if ( designation == "bdm" ) {

//         if ( month_year == "") {
//             if ( payout_type == 'monthly' ) {
//                 showBottomSnackBar("Please, Select Payout Month !! ");
//             }     // Empty Month

//             if ( payout_type == 'all' ) {
//                 getFranchisee();
//             }

//         } else {
//             // console.log(' month not empty !! ');
//             getFranchisee();
//         }

//     } 
//     else {
//         $('#levels').html('<option value="">--Select Payout Status--</option>');

//         generate_payout.style.display = "none";

//         //  Get All Members or Customers
//         $.ajax({
//             type:'POST',
//             url:'forms/get_all_levels',
//             data: JSON.stringify(data),
//             success:function (e) {
//                 // console.log(e);
//                 $('.user_row').remove();
//                 $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No User Selected</td></tr>');
//             },
//             error: function(err){
//                 console.log(err);
//             },
//         });

//         onChangeStatusDate();
//     }
// });

// // Display payout Type
// $("#payout_type").on('change', function() {

//     getPayoutType();

//     if ( payout_type == 'monthly' ) {
//         if ( month_year == '' ) { } else {
//             getFranchisee();
//         }
//     } else if ( payout_type == 'quarterly' && quater_year == "") {
//         if ( quater_year == '' ) { } else {
//             getFranchisee();
//         }
//     } else {
//         getFranchisee();
//     }
// });

// function getPayoutType()
// {
//     payout_type = $("#payout_type").val();
//     if ( payout_type == 'monthly' ) {
//         $('#month_year').val(month_year);

//         // Payout Button show and hide
//         generate_payout_button.innerText = 'Monthly';
//         generate_payout_button.style.backgroundColor = '#006dd5';

//         // payout type
//         month_year_field.style.display = "block";
//         month_year_title.innerText = "Select Month & Year for Monthly Payout";
//         quater_year_field.style.display = "none";
//     } 
//     else if (payout_type == 'quarterly' ){
//         // Payout Button show and hide
//         generate_payout_button.innerText = 'Quarterly';
//         generate_payout_button.style.backgroundColor = '#a91e03';

//         // payout type
//         month_year_field.style.display = "none";
//         quater_year_field.style.display = "block";
//     } else {
//         // payout type  =   all
//         generate_payout.style.display = "none";
//         month_year_title.innerText = "Select Month & Year";
//         month_year_field.style.display = "block";
//         quater_year_field.style.display = "none";
//         $('#month_year').val('');
//         month_year = '';
//     }
// }

function onChangeStatusDate() {
    payout_status = $('#payout_status').val();
    month_year = $('#month_year').val();

    if (designation == "customer") {
        // get customers with TA Direct-Cust-ID
        level_1_id = $('#levels').val();
        // if ( payout_status == "" || month_year == "" || level_1_id == "" ) {
        //     // get customers with TA-Refernce ID for travel Agents
        // } else {
        getCustomers_TA();
        // }
    } else if (designation == "franchisee") {
        // get customers with TA Direct-Cust-ID
        level_1_id = $('#levels').val();

        if (payout_status == "" || month_year == "") {
            // get customers with TA Direct-Cust-ID
        } else {
            getCustomers_TA();
        }
    } else {
        // for Travel Agent
        level_1_id = $('#user_id_name').val();

        // if ( payout_status == "" || month_year == "" ) {
        //     // get customers with TA Direct-Cust-ID
        // } else {
        getCustomers_TA();
        // }
    }
}

$('#payout_status').on('change', function () {
    onChangeStatusDate();
});
$('#month_year').on('change', function () {
    onChangeStatusDate();

    if (payout_type == "monthly") {
        if (designation == "franchisee") {
            getFranchisee();
        }
    }
});
$('#quater_year').on('change', function () {
    payout_type = $('#payout_type').val();
    quater_year = $('#quater_year').val();

    if (payout_type == "quarterly") {
        if (designation == "franchisee") {
            getFranchisee();
        }
    }
});

// validate date for showing PAYOUT button
function validateUserPayout() {
    // get Date
    getCurrentMonth = currentDate.getMonth() + 1;
    getCurrentDay = currentDate.getDate();

    var selected_year;
    var selected_month;

    if (payout_type == 'monthly') {
        selected_year = month_year.substring(0, 4);
        selected_month = month_year.replace(/^.{5}/g, '');      // remove year(2021-)and keeps month only
    } else if (payout_type == 'quarterly') {
        selected_year = quater_year.substring(0, 4);
        selected_month = quater_year.replace(/^.{8}/g, '');
    }

    // if payout is not generated  and day is 30th then show Grnerate Payout Button
    if (selected_month !== '' && selected_year == getCurrentYear && selected_month <= getCurrentMonth) {
        // ok
        if (selected_month == getCurrentMonth) {
            if (selected_month == 2) {
                if (getCurrentDay > 26) {
                    generate_payout.style.display = "block";
                    get_total_payout.style.display = "none";
                } else {
                    generate_payout.style.display = "none";
                    get_total_payout.style.display = "block";
                }
            } else {
                if (getCurrentDay > 29) {
                    // if ( getCurrentDay <= 30 ) {
                    generate_payout.style.display = "block";
                    get_total_payout.style.display = "none";
                } else {
                    generate_payout.style.display = "none";
                    get_total_payout.style.display = "block";

                }
            }
        } else if (selected_month < getCurrentMonth) {
            generate_payout.style.display = "block";
            get_total_payout.style.display = "none";
        } else {
            generate_payout.style.display = "none";
            get_total_payout.style.display = "block";

        }
    } else if (selected_month !== '' && selected_year < getCurrentYear) {
        generate_payout.style.display = "block";
        get_total_payout.style.display = "none";
    } else {
        // Error 
        generate_payout.style.display = "none";
        get_total_payout.style.display = "block";
        showBottomSnackBar("Please, Select Valid Date");
    }
}


// generate_montlhy_payout
$("#generate_payout_button").on('click', function () {

    var data = {
        user_id: user_id,
        month_year: month_year,
        quater_year: quater_year,
        payout_type: payout_type,
        get_payout: get_payout
    };

    $.ajax({
        type: 'POST',
        url: 'forms/generate_franchisee_payout',
        data: JSON.stringify(data),
        success: function (e) {
            // console.log(e);
            if (e == "success") {
                // show payouts
                getFranchisee();
                // console.log('success');
            } else if (e == "pending_payout") {
                alert('Monthly Payout Pending !! ');
            } else if (e == "fail") {
                alert('Payout is been Generated Already !');
            } else {
                alert('No Active Business Consultant Found !');
            }
        },
        error: function (err) {
            console.log(err);
        },
    });

});


// get level details - Direct Customer
$('#levels').on('change', function () {
    var temp_level_1_id = $('#levels').val();
    payout_status = $('#payout_status').val();
    month_year = $('#month_year').val();


    if (designation == "franchisee") {
        level_1_id = temp_level_1_id;
    } else if (designation == "franchisee") {
        if (month_year == "" || payout_status == "") {
            if (payout_status == "") {
                alert("Please Select Payout Status !!");
            }
            if (month_year == "") {
                alert("Please Select Month & Year!!");
            }
        }
    } else if (designation == "customer") {

        level_1_id = temp_level_1_id;

        // if ( month_year == "" || payout_status == "" ) {
        //     if ( payout_status == "" ) {
        //         alert("Please Select Payout Status !!");
        //     }
        //     if ( month_year == "" ) {
        //         alert("Please Select Month & Year!!");
        //     }
        // } else {
        getCustomers_TA();
        // }
    }
});
function getCustomers_TA() {
    var data = {
        user_id: user_id,
        payout_status: payout_status,
        month_year: month_year,
        designation: designation,
        level_1_id: level_1_id,
        admin: true,
        get_payout: get_payout
    };

    if (designation == "customer" || designation == "travel_agent") {

        showLoader(true);       // loader start 
        $.ajax({
            type: 'POST',
            url: 'forms/get_customer_chain',
            data: JSON.stringify(data),
            success: function (e) {
                // console.log(e);

                $('.user_row').remove();
                if (e == "no_users") {
                    alert("No Users Found !!");
                    $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No Records Found</td></tr>');
                } else if (e == "fail") {
                    // console.log('check status !');
                } else {
                    $('#userTable').append(e);
                    // $('#userTable').DataTable();
                }
            },
            complete: function () {
                // loader end 
                showLoader(false);
            },
            error: function (err) {
                console.log(err);
            },
        });

        // total payout
        $.ajax({
            type: 'POST',
            url: 'forms/get_customer_chain_total_payout',
            data: JSON.stringify(data),
            success: function (e) {
                document.getElementById("get_total_payout").innerText = "Total Payout ₹" + e;
                // console.log(e);
            },
            complete: function () {
                showLoader(false);   // loader end 
            },
            error: function (err) {
                console.log(err);
            },
        });
    } else {
        // console.log("franchisee");
    }
}

// Payout Form Details 
function showPayoutForm() {
    document.getElementById("view_payout").style.display = "block";
    document.getElementById("view_payout_details").style.display = "none";
    $('html,body').scrollTop(0);
}

function showPayoutDetailsForm(id, level, table, clubPriceDistribution_booking_Id) {
    document.getElementById("view_payout").style.display = "none";
    document.getElementById("view_payout_details").style.display = "block";

    $('#clubPriceDistribution_booking_Id').val(clubPriceDistribution_booking_Id);

    $('html,body').scrollTop(0);

    if (designation == "franchisee") {
        document.getElementById("payout_title").innerText = "Business Partner Payout Details";
        document.getElementById("c_id_title").innerText = "Business Partner ID";
        document.getElementById("c_name_title").innerText = "Business Partner Name";
        document.getElementById("c_amount_share_title").innerText = "Business Partner Share";

        document.getElementById("c_coupon_field").style.display = "none";
        document.getElementById("club_field").style.display = "none";
        document.getElementById("club_transc_mode").style.display = "none";
    } else {
        if (designation == "travel_agent") {
            document.getElementById("payout_title").innerText = "Business Consultant Payout Details";
            document.getElementById("c_amount_share_title").innerText = "Business Consultant Share";
        } else if (designation == "customer") {
            document.getElementById("payout_title").innerText = "Customer Payout Details";
            document.getElementById("c_amount_share_title").innerText = "Customer Share";
        }
        document.getElementById("c_id_title").innerText = "Customer ID";
        document.getElementById("c_name_title").innerText = "Customer Name";

        if (get_payout == 'club') {
            document.getElementById("c_coupon_field").style.display = "block";
        } else {
            document.getElementById("c_coupon_field").style.display = "none";
        }
        document.getElementById("club_field").style.display = "block";
        document.getElementById("club_transc_mode").style.display = "block";
    }

    var data = 'id=' + id + '&level=' + level + '&table=' + table + '&get_payout=' + get_payout + '&clubPriceDistribution_booking_Id=' + clubPriceDistribution_booking_Id;
    $.ajax({
        type: 'POST',
        url: 'forms/get_club_payout_details',
        data: data,
        success: function (e) {
            var user_data = JSON.parse(e);
            // console.log(user_data);

            $('#c_name').val(user_data[0]);
            $('#c_id').val(user_data[1]);
            $('#c_mobile').val(user_data[2]);
            $('#c_email').val(user_data[3]);
            $('#c_coupon').val(user_data[4]);
            $('#c_coupon_name').val(user_data[5]);
            $('#c_amount').val(user_data[6]);
            $('#c_amount_share').val(user_data[7]);
            $('#c_tds').val(user_data[8]);
            $('#c_net_payable').val(user_data[9]);
            document.getElementById("get_net_payable").innerText = user_data[9];
            $('#c_trans_id').val(user_data[10]);
            $('#c_trans_mode').val(user_data[11]);
            // $('#c_fname1').val(user_data[12]);
            // $('#c_lname1').val(user_data[13]);
            // $('#c_contact1').val(user_data[14]);
            $('#c_level').val(user_data[15]);
            $('#c_total').val(user_data[16]);

            $('#c_payout_mode').val(user_data[18]);   // pay mode
            $('#c_payout_id').val(user_data[19]);   // pay id
            $('#c_payout_created').val(user_data[20]);   // created
            $('#c_payout_paid').val(user_data[21]);   // date paid

            $('#c_payout_of').val(user_data[22]);   // payout_of date
            $('#c_message').val(user_data[23]);   // payout_of message

            // console.log('------------------------designation == customer------------------------');
            if (user_data[15] == 6 && designation == "customer") {
                // hide payment for reward price
                document.getElementById("get_net_payable_title").innerText = "Reward Amount :";
                displayPayoutStatus("block", "green", "Reward Earned");      // Success
            } else {
                document.getElementById("get_net_payable_title").innerText = "Amount to pay Customer :";

                if (user_data[17] == "0") {
                    displayPayoutStatus("block", "#e7b90d", "Pending Payment Due"); // Pending
                } else if (user_data[17] == "3") {
                    displayPayoutStatus("none", "red", "Payment Declined"); // Declined
                } else {
                    displayPayoutStatus("none", "green", "Payment Completed");      // Success
                }
            }
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function displayPayoutStatus(display, color, status) {
    document.getElementById("payment_btn").style.display = display;
    document.getElementById("payment_status").style.backgroundColor = color;
    document.getElementById("payment_status").innerText = status;
}









// error message snack bar
function showBottomSnackBar(message) {
    var x = document.getElementById("bottom-snackbar");
    var error1 = document.getElementById("error-message1");
    var error2 = document.getElementById("error-message2");
    x.style.display = "block";
    error1.style.display = "block";
    error2.style.display = "block";
    x.innerText = message;
    error1.innerText = message;
    error2.innerText = message;

    setTimeout(function () {
        x.style.display = "none";
        error1.style.display = "none";
        error2.style.display = "none";
    }, 3000);
}

var loader = document.getElementById("loading-loader");
var loader_text = document.getElementById("loading-loader-text");
var page_body = document.getElementById("page_body");

function showLoader(value) {
    if (value) {
        page_body.classList.add('parent_disable');
        loader.style.display = "block";
        loader_text.style.display = "block";
    } else {
        page_body.classList.remove('parent_disable')
        loader.style.display = "none";
        loader_text.style.display = "none";
        window.scrollTo(0, document.body.scrollHeight);
    }
}