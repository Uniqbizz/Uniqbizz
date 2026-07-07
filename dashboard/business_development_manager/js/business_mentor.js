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

        profile_pic : $("#img_path1").val().trim(),

        aadhar_card : $("#img_path2").val().trim(),

        pan_card : $("#img_path3").val().trim(),

        passbook : $("#img_path4").val().trim(),

        voting_card : $("#img_path11").val().trim(),

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

    if(!isEdit){

        if(data.registeredas == ''){

            alert("Select Register As");

            return false;

        }

        if(data.reference_name == ''){

            alert("Select Reference Name");

            return false;

        }

    }

    if(data.firstname == ''){

        alert("Enter First Name");

        return false;

    }

    if(!characterLetters.test(data.firstname)){

        alert("First Name should contain only alphabets");

        return false;

    }

    if(data.lastname == ''){

        alert("Enter Last Name");

        return false;

    }

    if(!characterLetters.test(data.lastname)){

        alert("Last Name should contain only alphabets");

        return false;

    }

    if(data.nominee_name == ''){

        alert("Enter Nominee Name");

        return false;

    }

    if(data.nominee_relation == ''){

        alert("Enter Nominee Relation");

        return false;

    }

    if(data.email == ''){

        alert("Enter Email");

        return false;

    }

    if(!emailReg.test(data.email)){

        alert("Enter Valid Email");

        return false;

    }

    if(data.testEmail == "1"){

        alert("Email already exists");

        return false;

    }

    if(data.dob == ''){

        alert("Select Date of Birth");

        return false;

    }

    if(data.age < 20){

        alert("Age must be 20 years or above");

        return false;

    }

    if(!data.gender){

        alert("Select Gender");

        return false;

    }

    if(data.phone == ''){

        alert("Enter Phone Number");

        return false;

    }

    if(!phoneReg.test(data.phone)){

        alert("Phone Number must be 10 digits");

        return false;

    }

    if(data.country == ''){

        alert("Select Country");

        return false;

    }

    if(data.state == ''){

        alert("Select State");

        return false;

    }

    if(data.city == ''){

        alert("Select City");

        return false;

    }

    if(data.address == ''){

        alert("Enter Address");

        return false;

    }

    if(data.zone == ''){

        alert("Select Zone");

        return false;

    }

    if(data.branch == ''){

        alert("Select Branch");

        return false;

    }

    if(data.profile_pic == ''){

        alert("Upload Profile Photo");

        return false;

    }

    if(data.aadhar_card == ''){

        alert("Upload Aadhaar Card");

        return false;

    }

    if(data.pan_card == ''){

        alert("Upload PAN Card");

        return false;

    }

    if(data.passbook == ''){

        alert("Upload Passbook");

        return false;

    }

    return true;

}

//==============================================================
// Add Business Mentor
//==============================================================

$("#addBusinessMentor").on("click", function (e) {

    e.preventDefault();

    let data = getFormData();

    if (!validateBusinessMentor(data, false)) {
        return;
    }

    let dataString =
        "registeredas=" + encodeURIComponent(data.registeredas) +
        "&user_id_name=" + encodeURIComponent(data.user_id_name) +
        "&reference_name=" + encodeURIComponent(data.reference_name) +
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

            if (response == "1") {

                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "Business Mentor Added Successfully.",
                    confirmButtonColor: "#3085d6"
                }).then(() => {

                    window.location.href = "business_mentor_list.php";

                });

            } else if (response == "2") {

                Swal.fire({
                    icon: "warning",
                    title: "Email Already Exists",
                    text: "The email address you entered is already registered.",
                    confirmButtonColor: "#f39c12"
                });

            } else if (response == "3") {

                Swal.fire({
                    icon: "warning",
                    title: "Phone Number Already Exists",
                    text: "The phone number you entered is already registered.",
                    confirmButtonColor: "#f39c12"
                });

            } else if (response == "4") {

                Swal.fire({
                    icon: "error",
                    title: "Reference User Not Found",
                    text: "Please select a valid reference user.",
                    confirmButtonColor: "#d33"
                });

            } else if (response == "5") {

                Swal.fire({
                    icon: "info",
                    title: "Business Mentor Already Exists",
                    text: "A Business Mentor already exists for the selected reference.",
                    confirmButtonColor: "#3085d6"
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Something Went Wrong",
                    html: `
                        <p>An unexpected error occurred.</p>
                        <small><b>Server Response:</b> ${response}</small>
                    `,
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
                title: "Connection Failed",
                html: `
                    Unable to connect to the server.<br><br>
                    <small><b>Error:</b> ${xhr.status} - ${xhr.statusText}</small>
                `,
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

            if(response == "1"){

                alert(successMsg);

                location.href="business_mentor_list.php";

            }else{

                alert(response);

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

$("#editBuisnessMentor").on("click",function(e){

    e.preventDefault();

    let data = getFormData();

    data.editfor = $("#editfor").val().trim();
    data.ref_id = $("#ref_id").val().trim();
    data.id = $("#id").val().trim();

    if(!validateBusinessMentor(data,true)){

        return;

    }

    let dataString =

        "editfor="+encodeURIComponent(data.editfor)+

        "&ref_id="+encodeURIComponent(data.ref_id)+

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

    let data = getFormData();

    let dataString =

        "draft=1"+

        "&registeredas="+encodeURIComponent(data.registeredas)+

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

        "business_mentor/save_business_mentor_draft.php",

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