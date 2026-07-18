//==============================================================
// Business Mentor JS
// Part 1
// Common Functions + Validation
//==============================================================

const date = new Date();
const current_year = date.getFullYear();

//==============================================================
// Regular Expressions
//==============================================================

const characterLetters = /^[A-Za-z\s]+$/;
const phoneReg = /^[0-9]{10}$/;
const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//==============================================================
// Email Duplicate Check
//==============================================================

$('#email').on('keyup blur', function () {

    let email = $(this).val().trim();
    let table = $('#testValue').val().trim();

    if(email !== ''){

        emailtest(email, table);

    }

});

function emailtest(email, table){

    $.ajax({

        type: "POST",

        url: "../test_data/emailtest.php",

        data: {

            email : email,

            tablename : table

        },

        success:function(response){

            if(response == 1){

                $('#testemails').html(
                    '<input type="hidden" id="testemail" value="1">'
                );

            }else{

                $('#testemails').html(
                    '<input type="hidden" id="testemail" value="0">'
                );

            }

        }

    });

}

//==============================================================
// Age Calculator
//==============================================================

function calculateAge(dob){

    if(dob == ''){

        return 0;

    }

    let birthDate = new Date(dob);

    let age = new Date().getFullYear() - birthDate.getFullYear();

    let month = new Date().getMonth() - birthDate.getMonth();

    if(
        month < 0 ||
        (
            month === 0 &&
            new Date().getDate() < birthDate.getDate()
        )
    ){

        age--;

    }

    return age;

}

//==============================================================
// Collect Form Data
//==============================================================

function getFormData(){

    return{

        registeredas : $("#registered").val()?.trim(),

        id: $("#id").length ? $("#id").val().trim() : "",

        user_id_name : $("#user_id_name").val()?.trim(),

        reference_name : $("#reference_name").val()?.trim(),

        firstname : $("#firstname").val().trim(),

        lastname : $("#lastname").val().trim(),

        nominee_name : $("#nominee_name").val().trim(),

        nominee_relation : $("#nominee_relation").val().trim(),

        email : $("#email").val().trim(),

        dob : $("#dob").val().trim(),

        gender : $(".gender:checked").val(),

        country_code : $("#country_cd").val().trim(),

        phone : $("#phone").val().trim(),

        country : $("#country").val().trim(),

        state : $("#mystate").val().trim(),

        city : $("#city").val().trim(),

        pincode : $("#pin").val().trim(),

        address : $("#address").val().trim(),

        zone : $("#zone").val().trim(),

        branch : $("#branch").val().trim(),

        profile_pic: $("#upload_file1").val().trim() !== "" ? $("#img_path1").val().trim() : "",

        aadhar_card: $("#upload_file2").val().trim() !== "" ? $("#img_path2").val().trim() : "",

        pan_card: $("#upload_file3").val().trim() !== "" ? $("#img_path3").val().trim() : "",

        passbook: $("#upload_file4").val().trim() !== "" ? $("#img_path4").val().trim() : "",

        voting_card: $("#upload_file11").val().trim() !== "" ? $("#img_path11").val().trim() : "",

        userId : $("#userId").val(),

        userType : $("#userType").val(),

        testEmail : $("#testemail").val(),

        age : calculateAge($("#dob").val())

    };

}

//==============================================================
// Validation
//==============================================================

function validateBusinessMentor(data,isEdit=false){

    if(data.firstname == ''){

        showError("firstname","Enter First Name");

        return false;

    }

    if(!characterLetters.test(data.firstname)){

        showError("firstname","First Name should contain only alphabets");

        return false;

    }

    if(data.lastname == ''){

        showError("lastname","Enter Last Name");

        return false;

    }

    if(!characterLetters.test(data.lastname)){

        showError("lastname","Last Name should contain only alphabets");

        return false;

    }

    if(data.nominee_name == ''){

        showError("nominee_name","Enter Nominee Name");

        return false;

    }

    if(data.nominee_relation == ''){

        showError("nominee_relation","Enter Nominee Relation");

        return false;

    }

    if(data.email == ''){

        showError("email","Enter Email");

        return false;

    }

    if(!emailReg.test(data.email)){

        showError("email","Enter Valid Email");

        return false;

    }

    if(data.testEmail == "1"){

        showError("email","Email already exists");

        return false;

    }

    if(data.dob == ''){

        showError("dob","Select Date of Birth");

        return false;

    }

    if(data.age < 20){

        showError("dob","Age must be 20 years or above");

        return false;

    }

    if(!data.gender){

        showGenderError("Please Select Gender.");

        return false;

    }

    if(data.phone == ''){

        showError("phone","Enter Phone Number");

        return false;

    }

    if(!phoneReg.test(data.phone)){

        showError("phone","Phone Number must be 10 digits");

        return false;

    }

    if(data.country == ''){

        showError("country","Select Country");

        return false;

    }

    if(data.state == ''){

        showError("mystate","Select State");

        return false;

    }

    if(data.city == ''){

        showError("city","Select City");

        return false;

    }

    if(data.address == ''){

        showError("address","Enter Address");

        return false;

    }

    if(data.zone == ''){

        showError("zone","Select Zone");

        return false;

    }

    if(data.branch == ''){

        showError("branch","Select Branch");

        return false;

    }

    if(data.profile_pic == ''){

        showFileError("upload_file1","Upload Profile Photo");

        return false;

    }

    if(data.aadhar_card == ''){

        showFileError("upload_file2","Upload Aadhaar Card");

        return false;

    }

    if(data.pan_card == ''){

        showFileError("upload_file3","Upload PAN Card");

        return false;

    }

    if(data.passbook == ''){

        showFileError("upload_file4","Upload Passbook");

        return false;

    }

    return true;

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
//==============================================================
// Add Business Mentor
//==============================================================

$("#addBusinessMentor").on("click", function (e) {

    e.preventDefault();
    clearAllErrors();
    let data = getFormData();

    if (!validateBusinessMentor(data, false)) {
        return;
    }

    let dataString =
        "action_type=submit"+
        "&firstname=" + encodeURIComponent(data.firstname) +
        "&lastname=" + encodeURIComponent(data.lastname) +
        "&nominee_name=" + encodeURIComponent(data.nominee_name) +
        "&nominee_relation=" + encodeURIComponent(data.nominee_relation) +
        "&email=" + encodeURIComponent(data.email) +
        "&dob=" + encodeURIComponent(data.dob) +
        "&gender=" + encodeURIComponent(data.gender) +
        "&country_code=" + encodeURIComponent(data.country_code) +
        "&phone=" + encodeURIComponent(data.phone) +
        "&country=" + encodeURIComponent(data.country) +
        "&state=" + encodeURIComponent(data.state) +
        "&city=" + encodeURIComponent(data.city) +
        "&pincode=" + encodeURIComponent(data.pincode) +
        "&address=" + encodeURIComponent(data.address) +
        "&zone=" + encodeURIComponent(data.zone) +
        "&branch=" + encodeURIComponent(data.branch) +
        "&profile_pic=" + encodeURIComponent(data.profile_pic) +
        "&aadhar_card=" + encodeURIComponent(data.aadhar_card) +
        "&pan_card=" + encodeURIComponent(data.pan_card) +
        "&passbook=" + encodeURIComponent(data.passbook) +
        "&voting_card=" + encodeURIComponent(data.voting_card) +
        "&userId=" + encodeURIComponent(data.userId) +
        "&userType=" + encodeURIComponent(data.userType);

    console.log(dataString);

    $("#addBusinessMentor")
        .prop("disabled", true)
        .html('<i class="fa fa-spinner fa-spin me-2"></i>Please Wait...');

    $("#loading-overlay").show();

    $.ajax({

        type: "POST",

        url: "models/business_mentor/add_business_mentor_data.php",

        data: dataString,

        cache: false,

        success: function (response) {

            console.log(response);

            $("#loading-overlay").hide();

            $("#addBusinessMentor")
                .prop("disabled", false)
                .html('<i class="fa-regular fa-paper-plane me-2"></i>Submit Business Mentor');

            response = $.trim(response);

            if (response == "2") {

                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Business Mentor Added Successfully.",
                    confirmButtonColor: "#3085d6"
                }).then(() => {

                    window.location.href = "business_mentor_list.php";

                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Something Went Wrong",
                    text: "Something went wrong.",
                    // html: `
                    //     <p>An unexpected error occurred.</p>
                    //     <small><b>Server Response:</b> ${response}</small>
                    // `,
                    confirmButtonColor: "#d33"
                });

            }

        },

        error: function (xhr, status, error) {

            $("#loading-overlay").hide();

            $("#addBusinessMentor")
                .prop("disabled", false)
                .html('<i class="fa-regular fa-paper-plane me-2"></i>Submit Business Mentor');

            console.log(xhr.responseText);

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Something went wrong.",
                // html: `
                //     Unable to connect to the server.<br><br>
                //     <small><b>Error:</b> ${xhr.status} - ${xhr.statusText}</small>
                // `,
                confirmButtonColor: "#d33"
            });

        }

    });

});

//==============================================================
// Common AJAX Function
//==============================================================

function submitBusinessMentor(url, dataString, buttonId, buttonText, successMsg){

    $(buttonId)
        .prop("disabled", true)
        .html('<i class="fa fa-spinner fa-spin me-2"></i>Please Wait...');

    $("#loading-overlay").show();

    $.ajax({

        type: "POST",

        url: url,

        data: dataString,

        cache: false,

        success:function(response){

            response = $.trim(response);

            $("#loading-overlay").hide();

            $(buttonId)
                .prop("disabled", false)
                .html(buttonText);

            console.log(response);

            if ($.trim(response) == "2") {

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: successMsg,
                    confirmButtonText: "OK"
                }).then(() => {
                    location.href = "business_mentor_list.php";
                });

            } else if ($.trim(response) == "4") {

                Swal.fire({
                    icon: "info",
                    title: "Draft Saved",
                    text: "Details have been saved as a draft.",
                    confirmButtonColor: "#0dcaf0"
                }).then(() => {
                    location.href = "business_mentor_list.php";
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response +"Something went wrong.", //response || 
                    confirmButtonText: "OK"
                });

            }

        },

        error:function(xhr){

            $("#loading-overlay").hide();

            $(buttonId)
                .prop("disabled", false)
                .html(buttonText);

            console.log(xhr.responseText);

            alert("Server Error");

        }

    });

}


//==============================================================
// Edit Business Mentor
//==============================================================

$("#editBusinessMentor").on("click",function(e){

    e.preventDefault();
    clearAllErrors();
    let data = getFormData();

    // data.editfor = $("#editfor").val().trim();
    // data.ref_id = $("#ref_id").val().trim();
    // data.id = $("#id").val().trim();

    if(!validateBusinessMentor(data,true)){

        return;

    }

    let dataString =
        "action_type=submit"+

        "&id="+encodeURIComponent(data.id)+

        "&firstname="+encodeURIComponent(data.firstname)+

        "&lastname="+encodeURIComponent(data.lastname)+

        "&nominee_name="+encodeURIComponent(data.nominee_name)+

        "&nominee_relation="+encodeURIComponent(data.nominee_relation)+

        "&email="+encodeURIComponent(data.email)+

        "&dob="+encodeURIComponent(data.dob)+

        "&gender="+encodeURIComponent(data.gender)+

        "&country_code="+encodeURIComponent(data.country_code)+

        "&phone="+encodeURIComponent(data.phone)+

        "&country="+encodeURIComponent(data.country)+

        "&state="+encodeURIComponent(data.state)+

        "&city="+encodeURIComponent(data.city)+

        "&pincode="+encodeURIComponent(data.pincode)+

        "&address="+encodeURIComponent(data.address)+

        "&zone="+encodeURIComponent(data.zone)+

        "&branch="+encodeURIComponent(data.branch)+

        "&profile_pic="+encodeURIComponent(data.profile_pic)+

        "&aadhar_card="+encodeURIComponent(data.aadhar_card)+

        "&pan_card="+encodeURIComponent(data.pan_card)+

        "&passbook="+encodeURIComponent(data.passbook)+

        "&voting_card="+encodeURIComponent(data.voting_card)+

        "&userId="+encodeURIComponent(data.userId)+

        "&userType="+encodeURIComponent(data.userType);

    submitBusinessMentor(

        "models/business_mentor/edit_business_mentor_data.php",

        dataString,

        "#editBuisnessMentor",

        "Update Business Mentor",

        "Business Mentor Updated Successfully."

    );

});


//==============================================================
// Save Draft
//==============================================================

$("#saveDraftAdd").on("click",function(e){

    e.preventDefault();
    clearAllErrors();
    let data = getFormData();

    if(data.firstname == ''){

        showError("firstname","Enter First Name");

        return false;

    }

    if(!characterLetters.test(data.firstname)){

        showError("firstname","First Name should contain only alphabets");

        return false;

    }

    if(data.lastname == ''){

        showError("lastname","Enter Last Name");

        return false;

    }

    if(!characterLetters.test(data.lastname)){

        showError("lastname","Last Name should contain only alphabets");

        return false;

    }

    if(data.email == ''){

        showError("email","Enter Email");

        return false;

    }

    if(!emailReg.test(data.email)){

        showError("email","Enter Valid Email");

        return false;

    }

    if(data.testEmail == "1"){

        showError("email","Email already exists");

        return false;

    }

    if(data.phone == ''){

        showError("phone","Enter Phone Number");

        return false;

    }

    if(!phoneReg.test(data.phone)){

        showError("phone","Phone Number must be 10 digits");

        return false;

    }

    let dataString =

        "action_type=draft"+

        "&user_id_name="+encodeURIComponent(data.user_id_name)+

        "&reference_name="+encodeURIComponent(data.reference_name)+

        "&firstname="+encodeURIComponent(data.firstname)+

        "&lastname="+encodeURIComponent(data.lastname)+

        "&nominee_name="+encodeURIComponent(data.nominee_name)+

        "&nominee_relation="+encodeURIComponent(data.nominee_relation)+

        "&email="+encodeURIComponent(data.email)+

        "&dob="+encodeURIComponent(data.dob)+

        "&gender="+encodeURIComponent(data.gender)+

        "&country_code="+encodeURIComponent(data.country_code)+

        "&phone="+encodeURIComponent(data.phone)+

        "&country="+encodeURIComponent(data.country)+

        "&state="+encodeURIComponent(data.state)+

        "&city="+encodeURIComponent(data.city)+

        "&pincode="+encodeURIComponent(data.pincode)+

        "&address="+encodeURIComponent(data.address)+

        "&zone="+encodeURIComponent(data.zone)+

        "&branch="+encodeURIComponent(data.branch)+

        "&profile_pic="+encodeURIComponent(data.profile_pic)+

        "&aadhar_card="+encodeURIComponent(data.aadhar_card)+

        "&pan_card="+encodeURIComponent(data.pan_card)+

        "&passbook="+encodeURIComponent(data.passbook)+

        "&voting_card="+encodeURIComponent(data.voting_card)+

        "&userId="+encodeURIComponent(data.userId)+

        "&userType="+encodeURIComponent(data.userType);

    submitBusinessMentor(

        "models/business_mentor/add_business_mentor_data.php",

        dataString,

        "#saveDraftEdit",

        "Save Draft",

        "Draft Saved Successfully."

    );

});
$("#saveDraftEdit").on("click",function(e){

    e.preventDefault();
    clearAllErrors();
    let data = getFormData();

    if(data.firstname == ''){

        showError("firstname","Enter First Name");

        return false;

    }

    if(!characterLetters.test(data.firstname)){

        showError("firstname","First Name should contain only alphabets");

        return false;

    }

    if(data.lastname == ''){

        showError("lastname","Enter Last Name");

        return false;

    }

    if(!characterLetters.test(data.lastname)){

        showError("lastname","Last Name should contain only alphabets");

        return false;

    }

    if(data.email == ''){

        showError("email","Enter Email");

        return false;

    }

    if(!emailReg.test(data.email)){

        showError("email","Enter Valid Email");

        return false;

    }

    if(data.testEmail == "1"){

        showError("email","Email already exists");

        return false;

    }

    if(data.phone == ''){

        showError("phone","Enter Phone Number");

        return false;

    }

    if(!phoneReg.test(data.phone)){

        showError("phone","Phone Number must be 10 digits");

        return false;

    }

    let dataString =

        "action_type=draft"+

        "&user_id_name="+encodeURIComponent(data.user_id_name)+

        "&reference_name="+encodeURIComponent(data.reference_name)+

        "&firstname="+encodeURIComponent(data.firstname)+

        "&lastname="+encodeURIComponent(data.lastname)+

        "&nominee_name="+encodeURIComponent(data.nominee_name)+

        "&nominee_relation="+encodeURIComponent(data.nominee_relation)+

        "&email="+encodeURIComponent(data.email)+

        "&dob="+encodeURIComponent(data.dob)+

        "&gender="+encodeURIComponent(data.gender)+

        "&country_code="+encodeURIComponent(data.country_code)+

        "&phone="+encodeURIComponent(data.phone)+

        "&country="+encodeURIComponent(data.country)+

        "&state="+encodeURIComponent(data.state)+

        "&city="+encodeURIComponent(data.city)+

        "&pincode="+encodeURIComponent(data.pincode)+

        "&address="+encodeURIComponent(data.address)+

        "&zone="+encodeURIComponent(data.zone)+

        "&branch="+encodeURIComponent(data.branch)+

        "&profile_pic="+encodeURIComponent(data.profile_pic)+

        "&aadhar_card="+encodeURIComponent(data.aadhar_card)+

        "&pan_card="+encodeURIComponent(data.pan_card)+

        "&passbook="+encodeURIComponent(data.passbook)+

        "&voting_card="+encodeURIComponent(data.voting_card)+

        "&userId="+encodeURIComponent(data.userId)+

        "&userType="+encodeURIComponent(data.userType);

    submitBusinessMentor(

        "models/business_mentor/edit_business_mentor_data.php",

        dataString,

        "#saveDraftAdd",

        "Save Draft",

        "Draft Saved Successfully."

    );

});

//==============================================================
// Cancel Button
//==============================================================

$(".cancelBtn").on("click", function () {

    Swal.fire({
        title: "Are you sure?",
        text: "You will be redirected to list page.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d63030",
        cancelButtonColor: "#1b721bf2",
        confirmButtonText: "Yes, Cancel",
        cancelButtonText: "Continue Editing",
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "business_mentor_list.php";

        }

    });

});