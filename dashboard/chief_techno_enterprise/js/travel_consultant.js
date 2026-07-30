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
$("#addTravelConsultant").on("click", function (e) {
    e.preventDefault();
    submitAddForm('submit');
});

$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm('draft');
});

//validations
$("#chequeDate").on("input", function () {

    let value = $(this).val().replace(/\D/g, "");

    if (value.length > 4) value = value.slice(0, 4) + "-" + value.slice(4);
    if (value.length > 7) value = value.slice(0, 7) + "-" + value.slice(7);

    $(this).val(value.substring(0, 10));
});
function isValidDate(dateString) {

    if (!/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
        return false;
    }

    const [year, month, day] = dateString.split('-').map(Number);

    const date = new Date(year, month - 1, day);

    return (
        date.getFullYear() === year &&
        date.getMonth() + 1 === month &&
        date.getDate() === day
    );
}
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
//---------------------------------------------------------------

// @@@@****#### TC @@@@****####
function submitAddForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);

    var mobileRegex = /^[0-9]{10}$/;
    var specialChar = /[!@#$%^&*]/g;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    //age calculation
    var today = new Date();
    var current_year = today.getFullYear();
 
    // personal Details 
    
    var user_id_name = $("#user_id_name").val(); //STE ID //not there
    var reference_name = $("#reference_name").val(); // STE Name // not there
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    // var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val() || "";
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var payment_fee = $("#payment_fee").val();
    var paymentMode = $(".payment:checked").val()??'';
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();
    // residential address 
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userId').val();
    var userType = $('#userType').val();

    // Attachments
    function getFilePath(id) {
        return $(id).length
            ? $(id).val().replace('../../uploading/', '').trim()
            : "";
    }

    var profile_pic   = getFilePath("#img_path1");
    var aadhar_card   = getFilePath("#img_path2");
    var pan_card      = getFilePath("#img_path3");
    var passbook      = getFilePath("#img_path4");
    var voting_card   = getFilePath("#img_path11");
    var payment_proof = getFilePath("#img_path12");



    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    clearAllErrors();
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (firstname === '') {
            showError("firstname","First Name is required.");
            return;
        } else if (lastname === '') {
            showError("lastname","Last Name is required.");
            return;
        } else if (email == '') {
            showError("email","Email is required.");
            return;
        } else if (!emailReg.test(email)) {
            showError("email","Enter proper email.");
            return;
        } else if (testE == '1') {
            showError("email","Email already exists.");
            return;
        } else if (dob === '') {
            showError("dob","Please Select Birthdate.");
            return;
        } else if (age <= 20) {
            showError("dob","Age must be more than or equal to 20 Years.");
            return;
        } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
            showGenderError("Please Select Gender.");
            return;
        } else if (country_cd == '') {
            showError("country_cd","Select Country Code.");
            return;
        } else if (phone == '') {
            showError("phone","Enter Phone number.");
            return;
        } else if (!mobileRegex.test(phone)) {
            showError("phone","Enter Proper Phone Number.");
            return;
        } else if (country === '') {
            showError("country","Select Country.");
            return;
        } else if (mystate === '') {
            showError("mystate","Select State.");
            return;
        } else if (city === '') {
            showError("city","Select City.");
            return;
        } else if (address === '' || specialChar.test(address) || address.length <= 7) {
            showError("address","Enter Proper Address.");
            return;
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' 
                   && paymentMode !== 'online' && payment_fee =='' 
                   && payment_fee == 'null') {
            showPaymentError("Select payment Mode");
            return;
        } else if(paymentMode == 'cheque' && chequeNo ==''){
            showError("chequeNo","Please enter Cheque No.");
            return;
        } else if(paymentMode == 'cheque' && chequeDate ==''){
            showError("chequeDate","Please enter Cheque Date.");
            return;
        } else if (paymentMode == 'cheque' && !isValidDate(chequeDate)) {
            showError("chequeDate", "Please enter the valid date in YYYY-MM-DD format.");
            return;
        } else if(paymentMode == 'cheque' && bankName ==''){
            showError("bankName","Please enter Bank Name.");
            return;
        } else if(paymentMode == 'online' && transactionNo ==''){
            showError("transactionNo","Please enter Transaction No/Id.");
            return;
        } else if (profile_pic === '') {
            showFileError("upload_file1", "Please upload Profile Photo.");
            return;
        } else if (aadhar_card === '') {
            showFileError("upload_file2", "Please upload Aadhaar Card.");
            return;
        } else if (pan_card === '') {
            showFileError("upload_file3", "Please upload Pan Card.");
            return;
        } else if (passbook === '') {
            showFileError("upload_file4", "Please upload Bank Passbok Picture.");
            return;
        } 
    } 
    if (firstname === '') {
        showError("firstname","First Name is required.");
        return;
    } else if (lastname === '') {
        showError("lastname","Last Name is required.");
        return;
    } else if (email == '') {
        showError("email","Email is required.");
        return;
    } else if (!emailReg.test(email)) {
        showError("email","Enter proper email.");
        return;
    } else if (testE == '1') {
        showError("email","Email already exists.");
        return;
    } else if (phone == '') {
        showError("phone","Enter Phone number.");
        return;
    } else if (!mobileRegex.test(phone)) {
        showError("phone","Enter Proper Phone Number.");
        return;
    }


    var dataObj = {
        action_type: actionType, // draft or submit
        firstname: firstname,
        lastname: lastname,
        email: email,
        dob: dob,
        gender: gender,
        country_code: country_cd,
        phone: phone,
        paymentMode:paymentMode,
        chequeNo:chequeNo,
        chequeDate:chequeDate,
        bankName:bankName,
        transactionNo:transactionNo,
        country: country,
        state: mystate,
        city: city,
        pincode: pin,
        address: address,
        nominee_name: nominee_name,
        nominee_relation: nominee_relation,
        // note:note,
        profile_pic: profile_pic,
        aadhar_card: aadhar_card,
        pan_card: pan_card,
        passbook: passbook,
        voting_card:voting_card,
        payment_proof:payment_proof,
        payment_fee:payment_fee
    };
    console.log(dataObj);

    $("#addTravelConsultant").attr("disabled", "disabled");
    $("#saveDraftAdd").attr("disabled", "disabled");
    // console.log(dataString);
    Swal.fire({
        title: 'Please wait...',
        text: 'Processing your request.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    $.ajax({
        type: "POST",
        url: "models/travel_consultant/add_travel_agent_data.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            Swal.close();

            if ($.trim(data) == "1") {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Add Successful!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.href = "travel_consultants_list.php";
                });

            }else if (data == 2) {

                Swal.fire({
                    icon: 'info',
                    title: 'Draft Saved',
                    text: 'Travel Consultant details have been saved as a draft.',
                    confirmButtonColor: '#0dcaf0'
                }).then(() => {
                    location.href = "travel_consultants_list.php";
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Something went wrong.' //data || 
                });

            }
        },
    });
    
};


$("#editTravelConsultant").on("click", function (e) {
    e.preventDefault();
    submitEditForm('submit');
});

$("#saveDraftEdit").on("click", function (e) {
    e.preventDefault();
    submitEditForm('draft');
});
// Edit business_trainee by admin
function submitEditForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);

    var mobileRegex = /^[0-9]{10}$/;
    var specialChar = /[!@#$%^&*]/g;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    //age calculation
    var today = new Date();
    var current_year = today.getFullYear();
 
    // personal Details 
    var id = $('#id').val();
    var user_id_name = $("#user_id_name").val(); //STE ID //not there
    var reference_name = $("#reference_name").val(); // STE Name // not there
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    // var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val() || "";
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var payment_fee = $("#payment_fee").val();
    var paymentMode = $(".payment:checked").val()??'';
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();
    // residential address 
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userId').val();
    var userType = $('#userType').val();

    // Attachments
    function getFilePath(id) {
        return $(id).length
            ? $(id).val().replace('../../uploading/', '').trim()
            : "";
    }

    var profile_pic   = getFilePath("#img_path1");
    var aadhar_card   = getFilePath("#img_path2");
    var pan_card      = getFilePath("#img_path3");
    var passbook      = getFilePath("#img_path4");
    var voting_card   = getFilePath("#img_path11");
    var payment_proof = getFilePath("#img_path12");



    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    clearAllErrors();
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (firstname === '') {
            showError("firstname","First Name is required.");
            return;
        } else if (lastname === '') {
            showError("lastname","Last Name is required.");
            return;
        } else if (email == '') {
            showError("email","Email is required.");
            return;
        } else if (!emailReg.test(email)) {
            showError("email","Enter proper email.");
            return;
        } else if (testE == '1') {
            showError("email","Email already exists.");
            return;
        } else if (dob === '') {
            showError("dob","Please Select Birthdate.");
            return;
        } else if (age <= 20) {
            showError("dob","Age must be more than or equal to 20 Years.");
            return;
        } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
            showGenderError("Please Select Gender.");
            return;
        } else if (country_cd == '') {
            showError("country_cd","Select Country Code.");
            return;
        } else if (phone == '') {
            showError("phone","Enter Phone number.");
            return;
        } else if (!mobileRegex.test(phone)) {
            showError("phone","Enter Proper Phone Number.");
            return;
        } else if (country === '') {
            showError("country","Select Country.");
            return;
        } else if (mystate === '') {
            showError("mystate","Select State.");
            return;
        } else if (city === '') {
            showError("city","Select City.");
            return;
        } else if (address === '' || specialChar.test(address) || address.length <= 7) {
            showError("address","Enter Proper Address.");
            return;
        }else if (payment_fee =='' || payment_fee == 'null') {
            showError("payment_fee","Select Payment Fee.");
            return;
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' 
                   && paymentMode !== 'online' && payment_fee =='' 
                   && payment_fee == 'null') {
            showPaymentError("Select payment Mode");
            return;
        } else if(paymentMode == 'cheque' && chequeNo ==''){
            showError("chequeNo","Please enter Cheque No.");
            return;
        } else if(paymentMode == 'cheque' && chequeDate ==''){
            showError("chequeDate","Please enter Cheque Date.");
            return;
        } else if (paymentMode == 'cheque' && !isValidDate(chequeDate)) {
            showError("chequeDate", "Please enter the valid date in YYYY-MM-DD format.");
            return;
        } else if(paymentMode == 'cheque' && bankName ==''){
            showError("bankName","Please enter Bank Name.");
            return;
        } else if(paymentMode == 'online' && transactionNo ==''){
            showError("transactionNo","Please enter Transaction No/Id.");
            return;
        } else if (profile_pic === '') {
            showFileError("upload_file1", "Please upload Profile Photo.");
            return;
        } else if (aadhar_card === '') {
            showFileError("upload_file2", "Please upload Aadhaar Card.");
            return;
        } else if (pan_card === '') {
            showFileError("upload_file3", "Please upload Pan Card.");
            return;
        } else if (passbook === '') {
            showFileError("upload_file4", "Please upload Bank Passbok Picture.");
            return;
        } 
    } 
    if (firstname === '') {
        showError("firstname","First Name is required.");
        return;
    } else if (lastname === '') {
        showError("lastname","Last Name is required.");
        return;
    } else if (email == '') {
        showError("email","Email is required.");
        return;
    } else if (!emailReg.test(email)) {
        showError("email","Enter proper email.");
        return;
    } else if (testE == '1') {
        showError("email","Email already exists.");
        return;
    } else if (phone == '') {
        showError("phone","Enter Phone number.");
        return;
    } else if (!mobileRegex.test(phone)) {
        showError("phone","Enter Proper Phone Number.");
        return;
    }


    var dataObj = {
        id:id,
        action_type: actionType, // draft or submit
        firstname: firstname,
        lastname: lastname,
        email: email,
        dob: dob,
        gender: gender,
        country_code: country_cd,
        phone: phone,
        paymentMode:paymentMode,
        chequeNo:chequeNo,
        chequeDate:chequeDate,
        bankName:bankName,
        transactionNo:transactionNo,
        country: country,
        state: mystate,
        city: city,
        pincode: pin,
        address: address,
        nominee_name: nominee_name,
        nominee_relation: nominee_relation,
        // note:note,
        profile_pic: profile_pic,
        aadhar_card: aadhar_card,
        pan_card: pan_card,
        passbook: passbook,
        voting_card:voting_card,
        payment_proof:payment_proof,
        payment_fee:payment_fee
    };
    console.log(dataObj);

    $("#editTravelConsultant").attr("disabled", "disabled");
    $("#saveDraftEdit").attr("disabled", "disabled");
    // console.log(dataString);
    Swal.fire({
        title: 'Please wait...',
        text: 'Processing your request.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    }); //loading screen
    $.ajax({
        type: "POST",
        url: "models/travel_consultant/edit_travel_agent_data.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            Swal.close();

            if ($.trim(data) == "1") {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Edit Successful!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.href = "travel_consultants_list.php";
                });

            } else if (data == 2) {

                Swal.fire({
                    icon: 'info',
                    title: 'Draft Saved',
                    text: 'Travel Consultant details have been saved as a draft.',
                    confirmButtonColor: '#0dcaf0'
                }).then(() => {
                    location.href = "travel_consultants_list.php";
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Something went wrong.' //data || 
                });

            }
        },
    });
    
};
// @@@@****#### Chief Techno Enterprise End by admin @@@@****####//