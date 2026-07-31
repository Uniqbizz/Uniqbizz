//age calculation
var today = new Date();
var currentYear = today.getFullYear();

$("#email").keyup(function () {
    var email = $("#email").val().trim();
    var testValue = $("#testValue").val().trim();
    emailtest(email, testValue);
});

var emailtest = (emailtest, testValue) => {
    $.ajax({
        type: "POST",
        url: "../../test_data/emailtest.php",
        data: "email=" + emailtest + "&tablename=" + testValue,
        success: function (response) {
            if (response == 1) {
                $("#testemails").html(
                    '<input type="hidden"  id="testemail" value="1" >'
                );
            } else {
                $("#testemails").html(
                    '<input  type="hidden" id="testemail" value="0" >'
                );
                // return false;
            }
        },
    });
};

function getFilePath(selector) {

    const element = $(selector);

    if (!element.length) {
        return null;
    }

    const value = $.trim(element.val());

    return value !== "" ? value : null;
}
//validations 
function showError(fieldId, message) {

    $("#" + fieldId)
        .addClass("is-invalid")
        .focus();

    $("#" + fieldId + "_error").text(message);
}

function clearError(fieldId) {

    $("#" + fieldId)
        .removeClass("is-invalid");

    $("#" + fieldId + "_error").text("");
}

function clearAllErrors() {

    $(".form-control, .form-select").removeClass("is-invalid");
    $(".error-message").text("");
}
function showGenderError(message){

    $("#gender_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#gender_error").text(message);
}

function clearGenderError(){

    $("#gender_wrapper").removeClass("error");

    $("#gender_error").text("");
}

$(".gender").on("change",function(){

    clearGenderError();

});
function showPaymentError(message){

    $("#payment-mode_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#payment-mode_error").text(message);
}

function clearPaymentError(){

    $("#payment-mode_wrapper").removeClass("error");

    $("#payment-mode_error").text("");
}

$(".payment").on("change",function(){

    clearPaymentError();

});
function showFileError(fileId, message) {

    const input = $("#" + fileId);

    input.closest(".upload-card").addClass("error");

    $("#" + fileId + "_error").text(message);

    input.trigger("click"); // Opens file selector
}
function clearFileError(fileId) {

    $("#" + fileId)
        .closest(".upload-card")
        .removeClass("error");
}
//-------------------------------
// @@@@****#### institution start by admin @@@@****####
// Add institution by admin
$("#addInstitution").on("click", function (e) {
    e.preventDefault();
    submitAddForm('submit');
});

$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm('draft');
});

function submitAddForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);

    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // personal Details 
    var name = $("#name").val().trim();
    var number_branch = $("#numberBranch").val().trim();

    // Institution Types 
    var type_of_institution = $(".instituteType:checked").val(); //radio button values
    if(type_of_institution == "other"){
        var institution_type_value = $("#instituteTypeOther").val().trim(); // when selected "other" option on radio button take text box value
    }else{
        var institution_type_value = $(".instituteType:checked").val(); // if "other" option not selected take radio button value
    }

    var email = $("#email").val().trim();
    var incorporation_date = $("#incorporationDate").val().trim();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var institution_pan = $("#institutionPAN").val().trim();

    // residential address 
    var country = $("#country").val().trim();
    var state = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // Bank Details
    var account_name = $("#accountName").val().trim();
    var account_number = $("#accountNumber").val().trim();
    var ifsc_code = $("#ifscCode").val().trim();
    var branch_name = $("#branchName").val().trim();

    // payment information
    var activation_plan = $("#activationPlan").val().trim() || ""; // amount value
    // if FOC selected set amount to "Free", paymentMode to "free" and skip payment_proof
    if(activation_plan == "FOC"){
        var amount = 'Free';
        var paymentMode = "Free";
        var payment_proof = "";
    }else{
        var amount = activation_plan;
        var paymentMode = $(".payment:checked").val() || "";
        var payment_proof = getFilePath("#img_path14");
    }

    // populate when payment mode is selected
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    // Attachments
    var certificate_of_incorporation   = getFilePath("#img_path11");
    var gstin   = getFilePath("#img_path12");
    var board_resolution      = getFilePath("#img_path13");
    var cancelled_cheque_bank_passbook      = getFilePath("#img_path4");
    var pancard   = getFilePath("#img_path3");
    var address_proof = getFilePath("#img_path6");

    var testE = $("#testemail").val(); // Email Validation Only one email address should be present in one user table
    clearAllErrors();
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (name.length < 3) {
            showError("name","Enter proper name");
            return;
        }
        else if (phone.length !== 10) {
            showError("phone","Enter valid mobile number");
            return;
        }
        else if (!phoneReg.test(phone)) {
            showError("Enter Valid Mobile Number");
            return;
        }
        else if (email === "") {
            showError("email","Enter email address");
            return;
        }
        else if (!emailReg.test(email)) {
            showError("email","Enter valid email address");
            return;
        }
        else if (testE == "1") {
            showError("email","Email already exists");
            return;
        }
        else if (country === "") {
            showError("country","Select Country");
            return;
        }
        else if (mystate === "") {
            showError("mystate","Select State");
            return;
        }
        else if (city === "") {
            showError("city","Select City");
            return;
        }
        else if (address === "") {
            showError("address","Enter Address");
            return;
        }
        else if (accountName === "") {
            showError("accountName","Enter account holder name");
            return;
        }
        else if (accountNumber === "") {
            showError("accountNumber","Enter account number");
            return;
        }
        else if (ifscCode === "") {
            showError("ifscCode","Enter IFSC code");
            return;
        } 
        
        if (activation_plan === "") {
            showError("activationPlan","Please Select Activation Plan");
            return;
        }

        if (activation_plan !== "FOC") {
            if (!paymentMode) {
                showPaymentError("Please Select Payment Mode");
                return;
            }

            if (paymentMode === "cheque") {
                if(!chequeNo) {
                    showError("chequeNo","Please Enter Cheque Number");
                    return;
                }
                if(!chequeDate) {
                    showError("chequeDate","Please Enter Cheque Date");
                    return;
                }
                if(!bankName) {
                    showError("bankName","Please Enter Bank Name");
                    return;
                }
            }

            if (paymentMode === "online") {
                if(!transactionNo) {
                    showError("transactionNo","Please Enter Transaction Number");
                    return;
                }
            }

            if (!payment_proof) {
                showFileError("Please Upload Payment Proof");
                return;
            }
        }
    } 
    if (name.length < 3) {
        showError("name","Enter proper name");
        return;
    }
    else if (phone.length !== 10) {
        showError("phone","Enter valid mobile number");
        return;
    }
    else if (!phoneReg.test(phone)) {
        showError("Enter Valid Mobile Number");
        return;
    }
    else if (email === "") {
        showError("email","Enter email address");
        return;
    }
    else if (!emailReg.test(email)) {
        showError("email","Enter valid email address");
        return;
    }
    else if (testE == "1") {
        showError("email","Email already exists");
        return;
    }
    var dataObj = {
        action_type: actionType, // draft or submit
        designation: designation,
        name: name,
        email: email,
        number_branch: number_branch,
        institution_type_value: institution_type_value,
        incorporation_date: incorporation_date,
        country_code: country_cd,
        phone: phone,
        institution_pan: institution_pan,

        country: country,
        state: state,
        city: city,
        pincode: pin,
        address: address,

        account_name: account_name,
        account_number: account_number,
        ifsc_code: ifsc_code,
        branch_name: branch_name,

        amount: amount,
        payment_proof: payment_proof,
        paymentMode: paymentMode,

        chequeNo: chequeNo,
        chequeDate: chequeDate,
        bankName: bankName,
        transactionNo: transactionNo,

        certificate_of_incorporation: certificate_of_incorporation,
        gstin: gstin,
        board_resolution: board_resolution,
        cancelled_cheque_bank_passbook: cancelled_cheque_bank_passbook,
        pancard: pancard,
        address_proof: address_proof
    };
    console.log(dataObj);

    $("#addInstitution").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "add_institution_data.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); // Hide loading screen

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Added Successfully.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "view_institution.php";
                    }
                });

            } else {
                $("#loading-overlay").hide(); // Hide loading screen

                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
    });
    
};

// Edit institution by admin
$("#editInstitution").on("click", function (e) {
    e.preventDefault();
    submitEditForm('submit');
});

$("#saveDraftEdit").on("click", function (e) {
    e.preventDefault();
    submitEditForm('draft');
});

function submitEditForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);

    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // personal Details 
    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();
    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();
    var name = $("#name").val().trim();
    var number_branch = $("#numberBranch").val().trim();

    // Institution Types 
    var type_of_institution = $(".instituteType:checked").val(); //radio button values
    if(type_of_institution == "other"){
        var institution_type_value = $("#instituteTypeOther").val().trim(); // when selected "other" option on radio button take text box value
    }else{
        var institution_type_value = $(".instituteType:checked").val(); // if "other" option not selected take radio button value
    }

    var email = $("#email").val().trim();
    var incorporation_date = $("#incorporationDate").val().trim();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var institution_pan = $("#institutionPAN").val().trim();

    // residential address 
    var country = $("#country").val().trim();
    var state = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // Bank Details
    var account_name = $("#accountName").val().trim();
    var account_number = $("#accountNumber").val().trim();
    var ifsc_code = $("#ifscCode").val().trim();
    var branch_name = $("#branchName").val().trim();

    // payment information
    var activation_plan = $("#activationPlan").val().trim(); // amount value
    // if FOC selected set amount to "Free", paymentMode to "free" and skip payment_proof
    if(activation_plan == "FOC"){
        var amount = 'Free';
        var paymentMode = "Free";
        var payment_proof = '';
    }else{
        var amount = activation_plan;
        var paymentMode = $(".payment:checked").val();
        var payment_proof = getFilePath("#img_path14");
    }

    // populate when payment mode is selected
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    // Attachments
    var certificate_of_incorporation   = getFilePath("#img_path11");
    var gstin   = getFilePath("#img_path12");
    var board_resolution      = getFilePath("#img_path13");
    var cancelled_cheque_bank_passbook      = getFilePath("#img_path4");
    var pancard   = getFilePath("#img_path3");
    var address_proof = getFilePath("#img_path6");

    var testE = $("#testemail").val(); // Email Validation Only one email address should be present in one user table

    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (name.length < 3) {
            alert("Enter proper name");
            return;
        }
        else if (phone.length !== 10) {
            alert("Enter valid mobile number");
            return;
        }
        else if (email === "") {
            alert("Enter email address");
            return;
        }
        else if (!emailReg.test(email)) {
            alert("Enter valid email address");
            return;
        }
        else if (country === "") {
            alert("Select Country");
            return;
        }
        else if (mystate === "") {
            alert("Select State");
            return;
        }
        else if (city === "") {
            alert("Select City");
            return;
        }
        else if (address === "") {
            alert("Enter Address");
            return;
        }
        else if (accountName === "") {
            alert("Enter account holder name");
            return;
        }
        else if (accountNumber === "") {
            alert("Enter account number");
            return;
        }
        else if (ifscCode === "") {
            alert("Enter IFSC code");
            return;
        } 
        else if (!phoneReg.test(phone)) {
            alert("Enter Valid Mobile Number");
            return;
        }
        else if (testE == "1") {
            alert("Email already exists");
            return;
        }
        else if (!phoneReg.test(phone)) {
            alert("Contact Number Must be 10 Digit");
            return;
        }
    } 

    var dataObj = {
        action_type: actionType, // draft or submit
        // designation: designation,
        // user_id_name: user_id_name,
        // reference_name: reference_name,
        editfor: editfor,
        id: id,
        ref_id: ref_id,
        name: name,
        email: email,
        number_branch: number_branch,
        institution_type_value: institution_type_value,
        incorporation_date: incorporation_date,
        country_code: country_cd,
        phone: phone,
        institution_pan: institution_pan,

        country: country,
        state: state,
        city: city,
        pincode: pin,
        address: address,

        account_name: account_name,
        account_number: account_number,
        ifsc_code: ifsc_code,
        branch_name: branch_name,

        amount: amount,
        payment_proof: payment_proof,
        paymentMode: paymentMode,

        chequeNo: chequeNo,
        chequeDate: chequeDate,
        bankName: bankName,
        transactionNo: transactionNo,

        certificate_of_incorporation: certificate_of_incorporation,
        gstin: gstin,
        board_resolution: board_resolution,
        cancelled_cheque_bank_passbook: cancelled_cheque_bank_passbook,
        pancard: pancard,
        address_proof: address_proof
    };
    console.log(dataObj);

    $("#editInstitution").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "edit_institution_data.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Added Successfuly");
                location.href = "view_institution.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};
// @@@@****#### Institution End by admin @@@@****####//
