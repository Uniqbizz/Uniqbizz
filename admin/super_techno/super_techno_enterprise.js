// @@@@****#### super_techno_enterprise start by admin @@@@****####
// Add super_techno_enterprise by admin
$("#addSuperTechnoEnterprise").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var mobileRegex = /^[0-9]{10}$/;

    // get all values of checkbox and store it in hidden field in json format
    let selected = [];
    document.querySelectorAll('input[name="leadership[]"]:checked').forEach(function (checkbox) {
        selected.push(checkbox.value);
    });
    document.getElementById('leadership_json').value = JSON.stringify(selected);

    // personal Details 
    var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();
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


    if (designation === "") {
        alert("Please select designation");
    }
    else if (firstname.length < 3) {
        alert("Enter proper first name");
    }
    else if (lastname.length < 3) {
        alert("Enter proper last name");
    }
    else if (phone.length !== 10) {
        alert("Enter valid mobile number");
    }
    else if (email === "") {
        alert("Enter email address");
    }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Enter valid email address");
    }
    else if (occupation === "") {
        alert("Select occupation");
    }
    else if (qualification === "") {
        alert("Enter qualification");
    }
    else if (career_objective === "") {
        alert("Enter why you want to become a Super Techno Enterprise");
    }
    else if (acc_holder_name === "") {
        alert("Enter account holder name");
    }
    else if (bank_name === "") {
        alert("Enter bank name");
    }
    else if (account_number === "") {
        alert("Enter account number");
    }
    else if (ifsc_code === "") {
        alert("Enter IFSC code");
    } 
    else if (!mobileRegex.test(phone)) {
        alert("Enter Valid Mobile Number");
    }
    else if (!mobileRegex.test(alt_phone)) {
        alert("Enter Valid Alternate Mobile Number");
    }
    else if (phone === alt_phone) {
        alert("Mobile Number and Alternate Mobile Number cannot be the same");
    }
    else if (account_number !== confirm_account_number) {
        alert("Account Number and Confirm Account Number do not match");
    } else {

        var dataObj = {
            designation: designation,
            user_id_name: user_id_name,
            reference_name: reference_name,
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

        $("#addSuperTechnoEnterprise").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "addSuperTechnoData.php",
            data: dataObj,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "superTechno.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit business_trainee by admin
$("#editSuperTechnoEnterprise").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // var zone = $("#zone").val().trim();
    // var branch = $("#branch").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else {

        var dataString =
            "editfor=" +
            editfor +
            "&ref_id=" +
            ref_id +
            "&id=" +
            id +
            "&firstname=" +
            firstname +
            "&lastname=" +
            lastname +
            "&nominee_name=" +
            nominee_name +
            "&nominee_relation=" +
            nominee_relation +
            "&email=" +
            email +
            "&dob=" +
            dob +
            //  "&amount="+business_package+
            //  "&gst_no="+gst_no+
            "&gender=" +
            gender +
            "&country_code=" +
            country_cd +
            "&phone=" +
            phone +
            "&country=" +
            country +
            "&state=" +
            mystate +
            "&city=" +
            city +
            "&pincode=" +
            pin +
            "&address=" +
            address +
            // "&zone=" +
            // zone +
            // "&branch=" +
            // branch +
            "&profile_pic=" +
            profile_pic +
            "&aadhar_card=" +
            aadhar_card +
            "&pan_card=" +
            pan_card +
            "&passbook=" +
            passbook +
            "&voting_card=" +
            voting_card +
            "&note=" +
            note;
            // console.log(dataString);

        $("#editSuperTechnoEnterprise").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "editSuperTechnoData.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "superTechno.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Super Techno Enterprise End by admin @@@@****####//