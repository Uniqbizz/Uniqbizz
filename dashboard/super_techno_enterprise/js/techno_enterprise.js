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
$("#addTechnoEnterprise").on("click", function (e) {
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

    var mobileRegex = /^[0-9]{10}$/;
    var specialChar = /[!@#$%^&*]/g;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    //age calculation
    var today = new Date();
    var current_year = today.getFullYear();
 
    // personal Details 
    var registerAs = $("#registerAs").val();
    var url=''
    if (registerAs == '16') {
        url="models/techno_enterprise/add_te_data.php";
    }else if(registerAs == '29'){
        url="models/techno_enterprise/add_f_data.php";
    }
    var user_id_name = $("#user_id_name").val(); //STE ID //not there
    var reference_name = $("#reference_name").val(); // STE Name // not there
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    // var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $("#gender").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    
    var paymentMode = $(".payment:checked").val();
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
    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path11").val().trim();
    var payment_proof = $(":hidden#img_path12").val().trim();
    // var note = $("#note").val().trim();



    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if(registerAs === ''){
            alert("Select Register As First");
            return;
        }
        else if (user_id_name == '') {
            alert("Select Id");
            return;
        } else if (firstname === '') {
            alert("Enter Proper First Name");
            return;
        } else if (lastname === '') {
            alert("Enter Proper Last Name");
            return;
        } else if (email == '') {
            alert("Enter Email");
            return;
        } else if (!emailReg.test(email)) {
            alert("Enter Proper Email");
            return;
        } else if (testE == '1') {
            alert("Email already exists");
            return;
        } else if (dob === '') {
            alert('Please Select Birthdate');
            return;
        } else if (age <= 18) {
            alert('Age must be more than or equal to 18 Years');
            return;
        } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
            alert('Please Select Gender');
            return;
        } else if (country_cd == '') {
            alert("Select Country Code");
            return;
        } else if (phone == '') {
            alert("Enter Phone number");
            return;
        } else if (!mobileRegex.test(phone)) {
            alert("Enter Proper Phone Number");
            return;
        } else if (country === '') {
            alert("Select Country");
            return;
        } else if (mystate === '') {
            alert("Select State");
            return;
        } else if (city === '') {
            alert("Select City");
            return;
        } else if (address === '' || specialChar.test(address) || address.length <= 7) {
            alert("Enter Proper Address");
            return;
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
            alert("Select payment Mode");
            return;
        } else if (profile_pic === '') {
            alert('Please Upload profile Picture');
            return;
        } else if (aadhar_card === '') {
            alert('Please Upload Aadhar Card Picture');
            return;
        } else if (pan_card === '') {
            alert('Please Upload Pan Card Picture');
            return;
        } else if (passbook === '') {
            alert('Please Upload Bank Passbook Picture');
            return;
        } else if (payment_proof == '') {
            alert("Add Payment Proof");
            return;
        }
    } 
    if(registerAs === ''){
        alert("Select Register As First");
        return;
    }
    else if (firstname === '') {
        alert("Enter Proper First Name");
        return;
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
        return;
    } else if (email == '') {
        alert("Enter Email");
        return;
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
        return;
    } else if (testE == '1') {
        alert("Email already exists");
        return;
    } else if (phone == '') {
        alert("Enter Phone number");
        return;
    } else if (!mobileRegex.test(phone)) {
        alert("Enter Proper Phone Number");
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
        business_package,
        gst_no:gst_no,
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
        payment_proof:payment_proof
    };
    console.log(dataObj);

    $("#addTechnoEnterprise").attr("disabled", "disabled");
    $("#saveDraftAdd").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: url,
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Added Successfuly");
                location.href = "techno_enterprise_list.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};


$("#editTechnoEnterprise").on("click", function (e) {
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
    var editfor = $("#editfor").val().trim(); // pending or confirm
    var url=''
    if (editfor == '16') {
        url="models/techno_enterprise/edit_te_data.php";
    }else if(editfor == '29'){
        url="models/techno_enterprise/edit_f_data.php";
    }
    var id = $("#id").val().trim(); // ChiefTE id value if user is not registered - 11 , if registered - STE2600011
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    // var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $("#gender").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var business_package = $("#amount").val();
    var gst_no = $("#gstNo").val();
    
    var paymentMode = $(".payment:checked").val();
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
    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path11").val().trim();
    var payment_proof = $(":hidden#img_path12").val().trim();
    // var note = $("#note").val().trim();

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    

    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (firstname === '') {
            alert("Enter Proper First Name");
            return;
        } else if (lastname === '') {
            alert("Enter Proper Last Name");
            return;
        } else if (email == '') {
            alert("Enter Email");
            return;
        } else if (!emailReg.test(email)) {
            alert("Enter Proper Email");
            return;
        } else if (testE == '1') {
            alert("Email already exists");
            return;
        } else if (dob === '') {
            alert('Please Select Birthdate');
            return;
        } else if (age <= 18) {
            alert('Age must be more than or equal to 18 Years');
            return;
        } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
            alert('Please Select Gender');
            return;
        } else if (country_cd == '') {
            alert("Select Country Code");
            return;
        } else if (phone == '') {
            alert("Enter Phone number");
            return;
        } else if (!mobileRegex.test(phone)) {
            alert("Enter Proper Phone Number");
            return;
        } else if (country === '') {
            alert("Select Country");
            return;
        } else if (mystate === '') {
            alert("Select State");
            return;
        } else if (city === '') {
            alert("Select City");
            return;
        } else if (address === '' || specialChar.test(address) || address.length <= 7) {
            alert("Enter Proper Address");
            return;
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
            alert("Select payment Mode");
            return;
        } else if (profile_pic === '') {
            alert('Please Upload profile Picture');
            return;
        } else if (aadhar_card === '') {
            alert('Please Upload Aadhar Card Picture');
            return;
        } else if (pan_card === '') {
            alert('Please Upload Pan Card Picture');
            return;
        } else if (passbook === '') {
            alert('Please Upload Bank Passbook Picture');
            return;
        } else if (payment_proof == '') {
            alert("Add Payment Proof");
            return;
        }
    } 

    if (firstname === '') {
        alert("Enter Proper First Name");
        return;
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
        return;
    } else if (email == '') {
        alert("Enter Email");
        return;
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
        return;
    } else if (testE == '1') {
        alert("Email already exists");
        return;
    } else if (phone == '') {
        alert("Enter Phone number");
        return;
    } else if (!mobileRegex.test(phone)) {
        alert("Enter Proper Phone Number");
        return;
    }

    var dataObj = {
        action_type: actionType, // draft or submit
        editfor:editfor,
        id:id,
        firstname: firstname,
        lastname: lastname,
        email: email,
        dob: dob,
        gender: gender,
        country_code: country_cd,
        phone: phone,
        business_package,
        gst_no:gst_no,
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
        payment_proof:payment_proof
    };
    console.log(dataObj);

    $("#editTechnoEnterprise").attr("disabled", "disabled");
    $("#saveDraftEdit").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: url,
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Edit Successfuly");
                // location.href = "techno_enterprise_list.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};
// @@@@****#### Chief Techno Enterprise End by admin @@@@****####//