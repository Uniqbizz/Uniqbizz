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
        url: "../test_data/emailtest.php",
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
    var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();
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

        if (activation_plan === "") {
            alert("Please Select Activation Plan");
            return;
        }

        if (activation_plan !== "FOC") {
            if (!paymentMode) {
                alert("Please Select Payment Mode");
                return;
            }

            if (paymentMode === "cheque") {
                if(!chequeNo) {
                    alert("Please Enter Cheque Number");
                    return;
                }
                if(!chequeDate) {
                    alert("Please Enter Cheque Date");
                    return;
                }
                if(!bankName) {
                    alert("Please Enter Bank Name");
                    return;
                }
            }

            if (paymentMode === "online") {
                if(!transactionNo) {
                    alert("Please Enter Transaction Number");
                    return;
                }
            }

            if (!payment_proof) {
                alert("Please Upload Payment Proof");
                return;
            }
        }
    } 

    var dataObj = {
        action_type: actionType, // draft or submit
        designation: designation,
        user_id_name: user_id_name,
        reference_name: reference_name,
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
