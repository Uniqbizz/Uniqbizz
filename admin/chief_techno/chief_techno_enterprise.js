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

$("#addChiefTechnoEnterprise").on("click", function (e) {
    e.preventDefault();
    submitAddForm('submit');
});

$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm('draft');
});

// @@@@****#### executive_techno_enterprise start by admin @@@@****####
// Add executive_techno_enterprise by admin
function submitAddForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);

    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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
    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var resume_cv = $(":hidden#img_path5").val().trim();
    var address_proof = $(":hidden#img_path6").val().trim();
    var professional_profile = $(":hidden#img_path7").val().trim();
    var business_profile = $(":hidden#img_path8").val().trim();
    var income_proof = $(":hidden#img_path9").val().trim();
    var other_document = $(":hidden#img_path10").val().trim();

    var testE = $("#testemail").val(); // Email Validation Only one email address should be present in one user table

    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (firstname.length < 3) {
            alert("Enter proper first name");
            return;
        }
        else if (lastname.length < 3) {
            alert("Enter proper last name");
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
        else if (nominee_name === "") {
            alert("Enter Nominee Name");
            return;
        }
        else if (acc_holder_name === "") {
            alert("Enter account holder name");
            return;
        }
        else if (bank_name === "") {
            alert("Enter bank name");
            return;
        }
        else if (account_number === "") {
            alert("Enter account number");
            return;
        }
        else if (ifsc_code === "") {
            alert("Enter IFSC code");
            return;
        } 
        else if (!phoneReg.test(phone)) {
            alert("Enter Valid Mobile Number");
            return;
        }
        // else if (!mobileRegex.test(alt_phone)) {
        //     alert("Enter Valid Alternate Mobile Number");
        // return;
        // }
        // else if (phone === alt_phone) {
        //     alert("Mobile Number and Alternate Mobile Number cannot be the same");
        // return;
        // }
        else if (account_number !== confirm_account_number) {
            alert("Account Number and Confirm Account Number do not match");
            return;
        } 
        else if (profile_pic === "") {
            alert("Upload Profile Picture");
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
        else if (!phoneReg.test(alt_phone)) {
            alert("Alternate Contact Number Must be 10 Digit");
            return;
        }
        else if (!phoneReg.test(nominee_phone)) {
            alert("Nominee Contact Number Must be 10 Digit");
            return;
        }
    } 

    var dataObj = {
        action_type: actionType, // draft or submit
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
        other_document: other_document
    };
    // console.log(dataObj);

    $("#addChiefTechnoEnterprise").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "addChiefTechnoData.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Added Successfuly");
                location.href = "chief_techno.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};


$("#editChiefTechnoEnterprise").on("click", function (e) {
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
    var ref_id = $("#ref_id").val().trim(); // reference of the user - ETE260003
    var id = $("#id").val().trim(); // ChiefTE id value if user is not registered - 11 , if registered - STE2600011
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
    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var resume_cv = $(":hidden#img_path5").val().trim();
    var address_proof = $(":hidden#img_path6").val().trim();
    var professional_profile = $(":hidden#img_path7").val().trim();
    var business_profile = $(":hidden#img_path8").val().trim();
    var income_proof = $(":hidden#img_path9").val().trim();
    var other_document = $(":hidden#img_path10").val().trim();

    var testE = $("#testemail").val(); // Email Validation Only one email address should be present in one user table

    var phoneReg = /^[0-9]{10}$/;

    //radio button approve/reject Store data in array format
    function getVerificationStatus() {
        let verificationStatus = {};

        $("input[type='radio'][name^='verification_status']").each(function () {
            let name = $(this).attr("name");
            let match = name.match(/\[(.*?)\]/);

            if (match && match[1]) {
                let field = match[1];

                // Initialize field once
                if (!(field in verificationStatus)) {
                    verificationStatus[field] = 'pending';
                }

                // If this radio is checked, update its value
                if ($(this).is(':checked')) {
                    verificationStatus[field] = $(this).val();
                }
            }
        });

        return verificationStatus;
    }

    // function call check which radio button selected
    let verificationStatus = getVerificationStatus();
    // convert data to json
    let verification_status = JSON.stringify(verificationStatus);
    // get value of rejected field
    let reject_reason = $("#reject_reason").val().trim();

    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {

        if (firstname.length < 3) {
            alert("Enter proper first name");
            return;
        }
        else if (lastname.length < 3) {
            alert("Enter proper last name");
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
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
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
        else if (nominee_name === "") {
            alert("Enter Nominee Name");
            return;
        }
        else if (acc_holder_name === "") {
            alert("Enter account holder name");
            return;
        }
        else if (bank_name === "") {
            alert("Enter bank name");
            return;
        }
        else if (account_number === "") {
            alert("Enter account number");
            return;
        }
        else if (ifsc_code === "") {
            alert("Enter IFSC code");
            return;
        } 
        else if (!mobileRegex.test(phone)) {
            alert("Enter Valid Mobile Number");
            return;
        }
        // else if (!mobileRegex.test(alt_phone)) {
        //     alert("Enter Valid Alternate Mobile Number");
        // return;
        // }
        // else if (phone === alt_phone) {
        //     alert("Mobile Number and Alternate Mobile Number cannot be the same");
        // return;
        // }
        else if (account_number !== confirm_account_number) {
            alert("Account Number and Confirm Account Number do not match");
            return;
        } 
        else if (profile_pic === "") {
            alert("Upload Profile Picture");
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
        else if (!phoneReg.test(alt_phone)) {
            alert("Alternate Contact Number Must be 10 Digit");
            return;
        }
        else if (!phoneReg.test(nominee_phone)) {
            alert("Nominee Contact Number Must be 10 Digit");
            return;
        }

        // if even one rejected value is found then check for rejected reason value
        let hasRejected = Object.values(verificationStatus).includes("rejected");
        if (hasRejected && reject_reason === '') {
            alert("Please enter reject reason");
            return;
        }

    }

    var dataObj = {
        verification_status: verification_status,
        reject_reason: reject_reason,
        action_type: actionType, // draft or submit
        application_id: application_id,
        editfor: editfor,
        ref_id: ref_id,
        id: id,
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
        other_document: other_document
    };
    console.log(dataObj);

    $("#editChiefTechnoEnterprise").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "editChiefTechnoData.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Edit Successfuly");
                location.href = "chief_techno.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};
// @@@@****#### Chief Techno Enterprise End by admin @@@@****####//