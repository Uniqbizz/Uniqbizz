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
$("#addTravelConsultant").on("click", function (e) {
    e.preventDefault();
    submitAddForm('submit');
});

$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm('draft');
});

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
    
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (user_id_name == '') {
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
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' 
                   && paymentMode !== 'online' && payment_fee =='' 
                   && payment_fee == 'null') {
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

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: data || 'Something went wrong.'
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
    
    // ======================
    // VALIDATION ONLY FOR SUBMIT
    // ======================
    if (actionType === 'submit') {
        
        if (user_id_name == '') {
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
        } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' 
                   && paymentMode !== 'online' && payment_fee =='' 
                   && payment_fee == 'null') {
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

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: data || 'Something went wrong.'
                });

            }
        },
    });
    
};
// @@@@****#### Chief Techno Enterprise End by admin @@@@****####//