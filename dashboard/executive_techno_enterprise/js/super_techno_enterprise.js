// @@@@****#### executive_techno_enterprise start by admin @@@@****####
let date = new Date();
let current_year = date.getFullYear();
// for age calculation //
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
// Add executive_techno_enterprise by admin
$("#addSuperTechnoEnterprise").on("click", function (e) {
    e.preventDefault();
    submitAddForm("submit");
});

$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm("draft");
});

function submitAddForm(actionType) {
    // console.log('Add customer button clicked');

    var mobileRegex = /^[0-9]{10}$/;

    // get all values of checkbox and store it in hidden field in json format
    let selected = [];
    document.querySelectorAll('input[name="leadership[]"]:checked').forEach(function (checkbox) {
        selected.push(checkbox.value);
    });
    document.getElementById('leadership_json').value = JSON.stringify(selected);

    // personal Details 
    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country_cd_alt = $("#country_cd_alt").val().trim();
    var alt_phone = $("#altPhone").val().trim();
    var aadhar_No = $("#aadharNo").val().trim();
    var pan_no = $("#panNo").val().trim();

    // residential address 
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // Professional Details
    var occupation = $("#occupation").val().trim();
    var experience = $("#experience").val().trim();
    var annual_income = $("#annual_income").val().trim();
    var team_managed = $(".teamManaged:checked").val();
    var team_size = $("#teamSize").val().trim(); //textbox
    var leadership_json = $(":hidden#leadership_json").val().trim();
    var other_lead = $("#otherLead").val().trim();

    // educational details 
    var qualification = $("#qualification").val().trim();
   
    // Leadership Assessment
    var career_objective = $("#career_objective").val().trim(); //textbox
    var team_expected = $(".teamExpected:checked").val();
    var operating_state = $("#OperatingState").val().trim();

    // Nominee Details
    var nominee_name = $("#nomineeName").val().trim();
    var nominee_relation = $("#nomineeRelation").val().trim();
    var country_cd_nominee = $("#countryCdNominee").val().trim();
    var nominee_phone = $("#nomineePhone").val().trim();
    var nominee_dob = $("#nomineeDob").val().trim();
    var nominee_address = $("#nomineeAddress").val().trim();

    // Bank Details
    var acc_holder_name = $("#accHolderName").val().trim();
    var bank_name = $("#bankName").val().trim();
    var account_number = $("#accountNumber").val().trim();
    var confirm_account_number = $("#confirmAccountNumber").val().trim();
    var ifsc_code = $("#ifscCode").val().trim();
    var branch_name = $("#branchName").val().trim();

    // Attachments
    var profile_pic = aadhar_card = pan_card = passbook = resume_cv = address_proof =professional_profile =business_profile = income_proof =other_document=nominee_profile = '';
    var profile_pic_file = $("#upload_file1").val().trim();
    var aadhar_card_file = $("#upload_file2").val().trim();
    var pan_card_file = $("#upload_file3").val().trim();
    var passbook_file = $("#upload_file4").val().trim();
    var resume_cv_file = $("#upload_file5").val().trim();
    var address_proof_file = $("#upload_file6").val().trim();
    var professional_profile_file = $("#upload_file7").val().trim();
    var business_profile_file = $("#upload_file8").val().trim();
    var income_proof_file = $("#upload_file9").val().trim();
    var other_document_file = $("#upload_file10").val().trim();
    var nominee_profile_file = $("#upload_file13").val().trim();
    var testE = $("#testemail").val();
    clearAllErrors();
    if (actionType === "submit") {
        if (firstname.length < 3) {
            showError("firstname","Enter proper first name");
            return;
        }
        else if (lastname.length < 3) {
            showError("lastname","Enter proper last name");
            return;
        }
        else if (email === "") {
            showError("email","Enter email address");
            return;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError("email","Enter valid email address");
            return;
        }
        else if (testE == "1") {
            showError("email","Email already exists");
            return;
        }
        else if (!mobileRegex.test(phone)) {
            showError("phone","Enter Valid Mobile Number");
            return;
        }
        
        else if (profile_pic_file === "") {
            showFileError("upload_file1","Upload Profile Picture");
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
        else if (nominee_name === "") {
            showError("nomineeName","Enter Nominee Name");
            return;
        }
        else if (acc_holder_name === "") {
            showError("accHolderName","Enter account holder name");
            return;
        }
        else if (bank_name === "") {
            showError("bankName","Enter bank name");
            return;
        }
        else if (account_number === "") {
            showError("accountNumber","Enter account number");
            return;
        }
        else if (account_number !== confirm_account_number) {
            showError("confirmAccountNumber","Account Number and Confirm Account Number do not match");
            return;
        }
        else if (ifsc_code === "") {
            showError("ifscCode","Enter IFSC code");
            return;
        } 
               
        else if (branch_name === "") {
            showError("branchName","Enter bank name");
            return;
        } 
        
        // else if (!mobileRegex.test(alt_phone)) {
        //     showError("altPhone","Enter Valid Mobile Number");
        //     return;
        // }
        else if (!mobileRegex.test(nominee_phone)) {
            showError("nomineePhone","Enter Valid Mobile Number");
            return;
        }
    }
    if (firstname === "") {
        showError("firstname","Enter First Name");
        return;
    }
    else if (lastname === "") {
        showError("lastname","Enter Last Name");
        return;
    }
    else if (email === "") {
        showError("email","Enter Email");
        return;
    }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError("email","Enter Valid Email");
        return;
    }
    else if (testE == "1") {
        showError("email","Email already exists");
        return;
    }
    else if (phone === "") {
        showError("phone","Enter Phone Number");
        return;
    }
    else if (!mobileRegex.test(phone)) {
        showError("phone","Enter Valid Phone Number");
        return;
    }
    function getFilePath(id) {
        return $(id).length
            ? $(id).val().replace('../../uploading/', '').trim()
            : "";
    }

    var profile_pic                 = getFilePath("#img_path1");
    var aadhar_card                 = getFilePath("#img_path2");
    var pan_card                    = getFilePath("#img_path3");
    var passbook                    = getFilePath("#img_path4");
    var passbook                    = getFilePath("#img_path4");
    var resume_cv                   = getFilePath("#img_path5");
    var address_proof               = getFilePath("#img_path6");
    var professional_profile        = getFilePath("#img_path7");
    var business_profile            = getFilePath("#img_path8");
    var income_proof                = getFilePath("#img_path9");
    var other_document              = getFilePath("#img_path10");
    var nominee_profile             = getFilePath("#img_path13");
    

    var dataObj = {
        action_type: actionType,
        firstname: firstname,
        lastname: lastname,
        father_spouse_name: father_spouse_name,
        email: email,
        dob: dob,
        gender: gender,
        country_code: country_cd,
        phone: phone,
        country_code_alt: country_cd_alt,
        alt_phone: alt_phone,
        aadhar_no: aadhar_No,
        pan_no: pan_no,

        country: country,
        state: mystate,
        city: city,
        pincode: pin,
        address: address,

        occupation: occupation,
        experience: experience,
        annual_income: annual_income,
        team_managed: team_managed,
        team_size: team_size,
        leadership_json: leadership_json,
        other_lead: other_lead,

        qualification: qualification,

        career_objective: career_objective,
        team_expected: team_expected,
        operating_state: operating_state,

        nominee_name: nominee_name,
        nominee_relation: nominee_relation,
        country_cd_nominee: country_cd_nominee,
        nominee_phone: nominee_phone,
        nominee_dob: nominee_dob,
        nominee_address: nominee_address,

        acc_holder_name: acc_holder_name,
        bank_name: bank_name,
        account_number: account_number,
        ifsc_code: ifsc_code,
        branch_name: branch_name,

        profile_pic: profile_pic,
        aadhar_card: aadhar_card,
        pan_card: pan_card,
        passbook: passbook,
        resume_cv: resume_cv,
        address_proof: address_proof,
        professional_profile: professional_profile,
        business_profile: business_profile,
        income_proof: income_proof,
        other_document: other_document,
        nominee_profile: nominee_profile
    };
    // console.log(dataObj);

    $("#addSuperTechnoEnterprise").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "models/super_techno_enterprise/addSuperTechnoData.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if ($.trim(data) == "2") {

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Added Successfully!",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.href = "super_techno_enterprise_list.php";
                });

            } else if ($.trim(data) == "4") {

                Swal.fire({
                    icon: "info",
                    title: "Draft Saved",
                    text: "Details have been saved as a draft.",
                    confirmButtonColor: "#0dcaf0"
                }).then(() => {
                    location.href = "super_techno_enterprise_list.php";
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong.",
                    confirmButtonText: "OK"
                });

            }
        },
    });
}

// Edit 
$("#editSuperTechnoEnterprise").on("click", function(e){
    e.preventDefault();    
    submitEditForm("submit");
});

$("#saveDraftEdit").on("click", function(e){
    e.preventDefault();
    submitEditForm("draft");
});

function submitEditForm(actionType){
    // console.log('Add customer button clicked');

    var mobileRegex = /^[0-9]{10}$/;

    // get all values of checkbox and store it in hidden field in json format
    let selected = [];
    document.querySelectorAll('input[name="leadership[]"]:checked').forEach(function (checkbox) {
        selected.push(checkbox.value);
    });
    document.getElementById('leadership_json').value = JSON.stringify(selected);

    // personal Details 
    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();
    var application_id = $("#applicationId").val();
    var editfor = $("#editfor").val().trim(); // pending or confirm
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country_cd_alt = $("#country_cd_alt").val().trim();
    var alt_phone = $("#altPhone").val().trim();
    var aadhar_No = $("#aadharNo").val().trim();
    var pan_no = $("#panNo").val().trim();

    // residential address 
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // Professional Details
    var occupation = $("#occupation").val().trim();
    var experience = $("#experience").val().trim();
    var annual_income = $("#annual_income").val().trim();
    var team_managed = $(".teamManaged:checked").val();
    var team_size = $("#teamSize").val().trim(); //textbox
    var leadership_json = $(":hidden#leadership_json").val().trim();
    var other_lead = $("#otherLead").val().trim();

    // educational details 
    var qualification = $("#qualification").val().trim();
   
    // Leadership Assessment
    var career_objective = $("#career_objective").val().trim(); //textbox
    var team_expected = $(".teamExpected:checked").val();
    var operating_state = $("#OperatingState").val().trim();

    // Nominee Details
    var nominee_name = $("#nomineeName").val().trim();
    var nominee_relation = $("#nomineeRelation").val().trim();
    var country_cd_nominee = $("#countryCdNominee").val().trim();
    var nominee_phone = $("#nomineePhone").val().trim();
    var nominee_dob = $("#nomineeDob").val().trim();
    var nominee_address = $("#nomineeAddress").val().trim();

    // Bank Details
    var acc_holder_name = $("#accHolderName").val().trim();
    var bank_name = $("#bankName").val().trim();
    var account_number = $("#accountNumber").val().trim();
    var confirm_account_number = $("#confirmAccountNumber").val().trim();
    var ifsc_code = $("#ifscCode").val().trim();
    var branch_name = $("#branchName").val().trim();

    //Attachement 
    function getFilePath(id) {
        return $(id).length
            ? $(id).val().replace('../../uploading/', '').trim()
            : "";
    }

    var profile_pic                 = getFilePath("#img_path1");
    var aadhar_card                 = getFilePath("#img_path2");
    var pan_card                    = getFilePath("#img_path3");
    var passbook                    = getFilePath("#img_path4");
    var passbook                    = getFilePath("#img_path4");
    var resume_cv                   = getFilePath("#img_path5");
    var address_proof               = getFilePath("#img_path6");
    var professional_profile        = getFilePath("#img_path7");
    var business_profile            = getFilePath("#img_path8");
    var income_proof                = getFilePath("#img_path9");
    var other_document              = getFilePath("#img_path10");
    var nominee_profile             = getFilePath("#img_path13");


    var testE = $("#testemail").val();
    clearAllErrors();

    if (actionType === "submit") {
        if (firstname.length < 3) {
            showError("firstname","Enter proper first name");
            return;
        }
        else if (lastname.length < 3) {
            showError("lastname","Enter proper last name");
            return;
        }
        else if (email === "") {
            showError("email","Enter email address");
            return;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError("email","Enter valid email address");
            return;
        }
         else if (testE == "1") {
            showError("email","Email already exists");
            return;
        }
        else if (!mobileRegex.test(phone)) {
            showError("phone","Enter Valid Mobile Number");
            return;
        }
        else if (profile_pic === "") {
            showFileError("upload_file1","Upload Profile Picture");
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
        else if (nominee_name === "") {
            showError("nomineeName","Enter Nominee Name");
            return;
        }
        else if (acc_holder_name === "") {
            showError("accHolderName","Enter account holder name");
            return;
        }
        else if (bank_name === "") {
            showError("bankName","Enter bank name");
            return;
        }
        else if (account_number === "") {
            showError("accountNumber","Enter account number");
            return;
        }
        else if (account_number !== confirm_account_number) {
            showError("confirmAccountNumber","Account Number and Confirm Account Number do not match");
            return;
        }
        else if (ifsc_code === "") {
            showError("ifscCode","Enter IFSC code");
            return;
        }  
        else if (branch_name === "") {
            showError("branchName","Enter bank name");
            return;
        }
       
        // else if (!mobileRegex.test(alt_phone)) {
        //     showError("altPhone","Enter Valid Mobile Number");
        //     return;
        // }
        else if (!mobileRegex.test(nominee_phone)) {
            showError("nomineePhone","Enter Valid Mobile Number");
            return;
        }
    }
    if (firstname === "") {
        showError("firstname","Enter First Name");
        return;
    }
    else if (lastname === "") {
        showError("lastname","Enter Last Name");
        return;
    }
    else if (email === "") {
        showError("email","Enter Email");
        return;
    }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError("email","Enter Valid Email");
        return;
    }
    else if (testE == "1") {
        showError("email","Email already exists");
        return;
    }
    else if (phone === "") {
        showError("phone","Enter Phone Number");
        return;
    }
    else if (!mobileRegex.test(phone)) {
        showError("phone","Enter Valid Phone Number");
        return;
    }

    

    var dataObj = {
        actionType:actionType,
        application_id: application_id,
        editfor: editfor,
        firstname: firstname,
        lastname: lastname,
        father_spouse_name: father_spouse_name,
        email: email,
        dob: dob,
        gender: gender,
        country_code: country_cd,
        phone: phone,
        country_code_alt: country_cd_alt,
        alt_phone: alt_phone,
        aadhar_no: aadhar_No,
        pan_no: pan_no,

        country: country,
        state: mystate,
        city: city,
        pincode: pin,
        address: address,

        occupation: occupation,
        experience: experience,
        annual_income: annual_income,
        team_managed: team_managed,
        team_size: team_size,
        leadership_json: leadership_json,
        other_lead: other_lead,

        qualification: qualification,

        career_objective: career_objective,
        team_expected: team_expected,
        operating_state: operating_state,

        nominee_name: nominee_name,
        nominee_relation: nominee_relation,
        country_cd_nominee: country_cd_nominee,
        nominee_phone: nominee_phone,
        nominee_dob: nominee_dob,
        nominee_address: nominee_address,

        acc_holder_name: acc_holder_name,
        bank_name: bank_name,
        account_number: account_number,
        ifsc_code: ifsc_code,
        branch_name: branch_name,

        profile_pic: profile_pic,
        aadhar_card: aadhar_card,
        pan_card: pan_card,
        passbook: passbook,
        resume_cv: resume_cv,
        address_proof: address_proof,
        professional_profile: professional_profile,
        business_profile: business_profile,
        income_proof: income_proof,
        other_document: other_document,
        nominee_profile: nominee_profile
    };
    console.log(dataObj);

    $("#editSuperTechnoEnterprise").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "models/super_techno_enterprise/editSuperTechnoData.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if ($.trim(data) == "2") {

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Updated Successfully!",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.href = "super_techno_enterprise_list.php";
                });

            } else if ($.trim(data) == "4") {

                Swal.fire({
                    icon: "info",
                    title: "Draft Saved",
                    text: "Details have been updated and saved as a draft.",
                    confirmButtonColor: "#0dcaf0"
                }).then(() => {
                    location.href = "super_techno_enterprise_list.php";
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong.",
                    confirmButtonText: "OK"
                });

            }
        },
    });
}
// @@@@****#### Super Techno Enterprise End by admin @@@@****####//