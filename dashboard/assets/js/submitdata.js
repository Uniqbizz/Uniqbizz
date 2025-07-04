// $(function() {
//     console.log("Submit.js from dashboard");
// });

// for age calculation //
const date = new Date();
let current_year = date.getFullYear();

// console.log(current_year);

$('#email').keyup(function () {
    var email = $('#email').val().trim();
    var testValue = $('#testValue').val().trim();
    emailtest(email, testValue);
});

var emailtest = (emailtest, testValue) => {
    $.ajax({
        type: 'POST',
        url: 'test_data/emailtest.php',
        data: 'email=' + emailtest + '&tablename=' + testValue,
        success: function (response) {
            if (response == 1) {
                $('#testemails').html('<input type="hidden"  id="testemail" value="1" >');
            } else {
                $('#testemails').html('<input  type="hidden" id="testemail" value="0" >');
                // return false;
            }
        }
    });
}

function validateForm() {
    var ta_topup_amt = $("#ta_amt").val().trim();
    var ta_pay_mode = $(".payment:checked").val();
    var ta_cheque_no = $("#chequeNo").val().trim();
    var ta_cheque_date = $("#chequeDate").val().trim();
    var ta_bank_name = $("#bankName").val().trim();
    var ta_transaction_id = $("#transactionNo").val().trim();
    var ta_ref_img = $("#previewcheque2").val();

    if (ta_topup_amt === '') {
        alert('Enter the Top Up amount');
        return false;
    }

    if (!ta_pay_mode) {
        alert('Select Payment Mode');
        return false;
    }

    if (ta_pay_mode === 'cash' && ta_ref_img === '') {
        alert('Upload the payment proof');
        return false;
    }

    if (ta_pay_mode === 'cheque') {
        if (ta_cheque_no === '') {
            alert('Enter Cheque number');
            return false;
        }
        if (ta_cheque_date === '') {
            alert('Enter Cheque date');
            return false;
        }
        if (ta_bank_name === '') {
            alert('Enter bank name');
            return false;
        }
        if (ta_ref_img === '') {
            alert('Upload the payment proof');
            return false;
        }
    }

    if (ta_pay_mode === 'online') {
        if (ta_transaction_id === '') {
            alert('Enter Transaction id');
            return false;
        }
        if (ta_ref_img === '') {
            alert('Upload the payment proof');
            return false;
        }
    }

    return true; // All validations passed
}
//Add topup balance by sv on 28 Jan 2025
$('#add-ta-topup').click(function (e) {
    e.preventDefault();

    var ta_id = $("#user_id_name").val();
    var ta_full_name = $("#reference_name").val();
    var name_parts = ta_full_name.trim().split(/\s+/);
    var ta_fname = name_parts[0];
    var ta_lname = name_parts[1];
    var ta_topup_amt = $("#ta_amt").val().trim();
    var ta_pay_mode = $(".payment:checked").val();
    var ta_cheque_no = $("#chequeNo").val().trim();
    var ta_cheque_date = $("#chequeDate").val().trim();
    var ta_bank_name = $("#bankName").val().trim();
    var ta_transaction_id = $("#transactionNo").val().trim();
    var ta_ref_img = $(":hidden#previewcheque2").val();
    //current date
    var today = new Date();
    var year = today.getFullYear();
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    var day = String(today.getDate()).padStart(2, '0');
    var hours = String(today.getHours()).padStart(2, '0');
    var minutes = String(today.getMinutes()).padStart(2, '0');
    var seconds = String(today.getSeconds()).padStart(2, '0');
    // Format as "YYYY-MM-DD HH:MM:SS"
    var currentDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

    //console.log(currentDateTime);

    var ta_created_date = currentDateTime;
    var ta_updated_date = currentDateTime;

    //validation

    var dataString = {
        ta_id: ta_id,
        ta_fname: ta_fname,
        ta_lname: ta_lname,
        ta_topup_amt: ta_topup_amt,
        ta_pay_mode: ta_pay_mode,
        ta_cheque_no: ta_cheque_no,
        ta_cheque_date: ta_cheque_date,
        ta_bank_name: ta_bank_name,
        ta_transaction_id: ta_transaction_id,
        ta_ref_img: ta_ref_img,
        ta_created_date: ta_created_date,
        ta_updated_date: ta_updated_date,
        ta_status: 1
    };

    if (validateForm()) {
        $.ajax({
            type: "POST",
            url: "travel_agent/add_ta_top_up_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                //console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_ta_topup.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }

});

// @@@@****#### Business Development Manager start by BCH @@@@****####
// Add Business Development Manager by BCH  
$('#add_bdm').click(function (e) {
    e.preventDefault();

    var name = $('#fullName').val().trim();
    var birth_date = $('#birth_date').val().trim();
    var country_cd = $('#country_cd').val().trim();
    var contact = $('#contact').val().trim();
    var email = $('#email').val().trim();
    var address = $('#address').val().trim();
    var gender = $('.gender:checked').val();
    var joining_date = $('#joining_date').val().trim();
    var department = $('#department').val().trim();
    var designation = $('#designation').val().trim();
    var zone = $('#zone').val().trim();
    var branch = $('#branch').val().trim();
    // var reporting_manager = $('#reporting_manager').val().trim();
    var reporting_manager = $('#reporting_manager').val().trim();
    var profile_pic = $(':hidden#img_path1').val().trim();
    var id_proof = $(':hidden#img_path2').val().trim();
    var bank_details = $(':hidden#img_path3').val().trim();

    // var testp= $('#testphone').val();
    var testE = $('#testemails').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    //age calculation
    var birth_date_split = birth_date.split("-");
    var age = current_year - birth_date_split[0];
    // console.log(age);

    //joining date calculation
    var joining_date_split = joining_date.split("-");
    var joining = current_year - joining_date_split[0];
    // console.log(joining);

    if (name === '') {
        alert("Enter Proper Name");
    } else if (birth_date === '') {
        alert('Please Select Correct Birth date');
    } else if (age < 20) {
        alert('Age must be more than 20 Years');
    } else if (contact === '') {
        alert('Please Select Contact Number');
    } else if (!phoneReg.test(contact)) {
        alert("Contact Number Must be 10 Digit");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (address === '') {
        alert('Please Select address');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (joining_date === '') {
        alert('Please Select Joining date');
    } else if (joining > 20) {
        alert('Joining date can not be more than 20 Years');
    } else if (department === '') {
        alert('Please Select department');
    } else if (designation === '') {
        alert('Please Select designation');
    } else if (zone === '') {
        alert('Please Select zone');
    } else if (branch === '') {
        alert('Please Select branch');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (id_proof === '') {
        alert('Please provide valid id proof');
    } else if (bank_details === '') {
        alert('Please provide correct bank details');
    } else {

        var dataString = 'name=' + name + '&birth_date=' + birth_date + '&country_cd=' + country_cd + '&contact=' + contact + '&email=' + email + '&address=' + address + '&gender=' + gender + '&joining_date=' + joining_date + '&department=' + department + '&designation=' + designation + '&zone=' + zone + '&branch=' + branch + '&reporting_manager=' + reporting_manager + '&profile_pic=' + profile_pic + '&id_proof=' + id_proof + '&bank_details=' + bank_details + '&userId=' + userId + '&userType=' + userType;

        console.log(dataString);
        $('#add_bdm').attr("disabled", "disabled");

        $.ajax({
            type: 'POST',
            url: 'business_development_manager/add_business_development_manager_data.php',
            data: dataString,
            cache: false,
            success: function (data) {
                if (data == 1) {
                    alert("Added Successfully");
                    location.href = "view_business_development_manager.php";
                } else {
                    alert("Failed");
                }
            }
        });

    }

});
// Edit Business Development Manager by BCH
$('#edit_bdm').click(function (e) {
    e.preventDefault();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#empID').val().trim();
    var name = $('#fullName').val().trim();
    var birth_date = $('#birth_date').val().trim();
    var country_cd = $('#country_cd').val().trim();
    var contact = $('#contact').val().trim();
    var email = $('#email').val().trim();
    var address = $('#address').val().trim();
    var gender = $('.gender:checked').val();
    var joining_date = $('#joining_date').val().trim();
    var department = $('#department').val().trim();
    var designation = $('#designation').val().trim();
    var zone = $('#zone').val().trim();
    var branch = $('#branch').val().trim();
    var reporting_manager = $('#reporting_manager').val().trim();
    var profile_pic = $(':hidden#img_path1').val().trim();
    var id_proof = $(':hidden#img_path2').val().trim();
    var bank_details = $(':hidden#img_path3').val().trim();

    // var testp= $('#testphone').val();
    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    //age calculation
    var birth_date_split = birth_date.split("-");
    var age = current_year - birth_date_split[0];
    // console.log(age);

    //joining date calculation
    var joining_date_split = joining_date.split("-");
    var joining = current_year - joining_date_split[0];
    // console.log(joining);

    if (name === '') {
        alert("Enter Proper Name");
    } else if (birth_date === '') {
        alert('Please Select Correct Birth date');
    } else if (age < 20) {
        alert('Age must be more than 20 Years');
    } else if (contact === '') {
        alert('Please Select Contact Number');
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (address === '') {
        alert('Please Select address');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (joining_date === '') {
        alert('Please Select Joining date');
    } else if (joining > 20) {
        alert('Joining date can not be more than 20 Years');
    } else if (department === '') {
        alert('Please Select department');
    } else if (designation === '') {
        alert('Please Select designation');
    } else if (zone === '') {
        alert('Please Select zone');
    } else if (branch === '') {
        alert('Please Select branch');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (id_proof === '') {
        alert('Please provide valid id proof');
    } else if (bank_details === '') {
        alert('Please provide correct bank details');
    } else {

        var dataString = 'editfor=' + editfor + '&ref_id=' + ref_id + '&id=' + id + '&name=' + name + '&birth_date=' + birth_date + '&country_cd=' + country_cd + '&contact=' + contact + '&email=' + email + '&address=' + address + '&gender=' + gender + '&joining_date=' + joining_date + '&department=' + department + '&designation=' + designation + '&zone=' + zone + '&branch=' + branch + '&reporting_manager=' + reporting_manager + '&profile_pic=' + profile_pic + '&id_proof=' + id_proof + '&bank_details=' + bank_details + '&userId=' + userId + '&userType=' + userType;

        console.log(dataString);
        $('#edit_bdm').attr("disabled", "disabled");

        $.ajax({
            type: 'POST',
            url: 'business_development_manager/edit_business_development_manager_data.php',
            data: dataString,
            cache: false,
            success: function (data) {
                if (data == 1) {
                    alert("Edited Successfully");
                    location.href = "view_business_development_manager.php";
                } else {
                    alert("Failed");
                }
            }
        });

    }

});
// @@@@****#### Business Development Manager End by BCH @@@@****####

// @@@@****#### Business Mentor start by BCH @@@@****####
// Add Business Mentor by BCH  
$('#addBusinessMentor').on('click', function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

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

    var zone = $("#zone").val().trim();
    var branch = $("#branch").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    let payment_fee,
        paymentMode = "",
        chequeNo = "",
        chequeDate = "",
        bankName = "",
        transactionNo = "",
        payment_proof = "";

    payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == "FOC") {
        paymentMode = "Free";
        chequeNo = "";
        chequeDate = "";
        bankName = "";
        transactionNo = "";
        payment_proof = "";
    } else {
        paymentMode = $(".payment:checked").val();
        chequeNo = $("#chequeNo").val().trim();
        chequeDate = $("#chequeDate").val().trim();
        bankName = $("#bankName").val().trim();
        transactionNo = $("#transactionNo").val().trim();
        payment_proof = $(":hidden#img_path6").val().trim();
    }
    // var paymentMode = $(".payment:checked").val();
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    // var testp= $('#testphone').val();
    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    //age calculation
    var birth_date_split = dob.split("-");
    var age = current_year - birth_date_split[0];
    // console.log(age);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;
    
    //var payment_fee =getNumericValue();

    if (reference_name == '') {
        alert("Select Referance name");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (nominee_name === '') {
        alert("Enter Nominee Name");
    } else if (nominee_relation === '') {
        alert("Enter Nominee Relation");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Choose Correct Birth date');
    } else if (age < 20) {
        alert('Age must be more than 20 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (phone === '') {
        alert('Please enter contact number');
    } else if (!phoneReg.test(phone)) {
        alert('Contact Number Must be 10 Digit');
    } else if (country === '') {
        alert('Please Select Country');
    } else if (mystate === '') {
        alert('Please Select State');
    } else if (city === '') {
        alert('Please Select City');
    } else if (address === '') {
        alert('Please Enter address');
    } else if (zone === '') {
        alert('Please Select zone');
    } else if (branch === '') {
        alert('Please Select branch');
    } else if (!paymentMode || !["cash", "cheque", "online", "free"].includes(paymentMode.toLowerCase())) {
        alert('Please select a valid payment mode');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (!paymentMode || (["cash", "cheque", "online"].includes(paymentMode.toLowerCase()) && payment_proof === "")) {
        alert("Enter Payment Proof");
    }  else {

        var dataString =
            //  "designation=" +designation+ 
            "user_id_name=" + user_id_name +
            "&reference_name=" + reference_name +
            "&firstname=" + firstname +
            "&lastname=" + lastname +
            "&nominee_name=" + nominee_name +
            "&nominee_relation=" + nominee_relation +
            "&email=" + email +
            "&dob=" + dob +
            //  "&amount=" +business_package+
            //  "&gst_no=" +gst_no+
            "&gender=" + gender +
            "&country_code=" + country_cd +
            "&phone=" + phone +
            "&country=" + country +
            "&state=" + mystate +
            "&city=" + city +
            "&pincode=" + pin +
            "&address=" + address +
            "&zone=" + zone +
            "&branch=" + branch +
            "&profile_pic=" + profile_pic +
            "&aadhar_card=" + aadhar_card +
            "&pan_card=" + pan_card +
            "&passbook=" + passbook +
            "&voting_card=" + voting_card+
            "&payment_proof=" +payment_proof +
            "&paymentMode=" +paymentMode +
            "&chequeNo=" +chequeNo +
            "&chequeDate=" +chequeDate +
            "&bankName=" +bankName +
            "&transactionNo=" +transactionNo+
            "&payment_fee="+payment_fee+ 
            '&userId=' + userId+ 
            '&userType=' + userType;
        // console.log(dataString);                 


        $("#addBusinessMentor").attr("disabled", "disabled");
        console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "business_mentor/add_business_mentor_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_mentor.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Business Mentor by BCH
$('#editBuisnessMentor').on('click', function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val().trim();
    var ref_id = $('#ref_id').val().trim();
    var id = $('#id').val().trim();

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

    var zone = $("#zone").val().trim();
    var branch = $("#branch").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    let payment_fee,
        paymentMode = "",
        chequeNo = "",
        chequeDate = "",
        bankName = "",
        transactionNo = "",
        payment_proof = "";

    payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == "FOC") {
        paymentMode = "Free";
        chequeNo = "";
        chequeDate = "";
        bankName = "";
        transactionNo = "";
        payment_proof = "";
    } else {
        paymentMode = $(".payment:checked").val();
        chequeNo = $("#chequeNo").val().trim();
        chequeDate = $("#chequeDate").val().trim();
        bankName = $("#bankName").val().trim();
        transactionNo = $("#transactionNo").val().trim();
        payment_proof = $(":hidden#img_path6").val().trim();
    }
    // var paymentMode = $(".payment:checked").val();
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();
    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    //age calculation
    var birth_date_split = dob.split("-");
    var age = current_year - birth_date_split[0];
    // console.log(age);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;
    
    //var payment_fee =getNumericValue();

    if (reference_name == '') {
        alert("Select Referance name");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (nominee_name === '') {
        alert("Enter Nominee Name");
    } else if (nominee_relation === '') {
        alert("Enter Nominee Relation");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Choose Correct Birth date');
    } else if (age < 20) {
        alert('Age must be more than 20 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (phone === '') {
        alert('Please enter contact number');
    } else if (!phoneReg.test(phone)) {
        alert('Contact Number Must be 10 Digit');
    } else if (country === '') {
        alert('Please Select Country');
    } else if (mystate === '') {
        alert('Please Select State');
    } else if (city === '') {
        alert('Please Select City');
    } else if (address === '') {
        alert('Please Enter address');
    } else if (zone === '') {
        alert('Please Select zone');
    } else if (branch === '') {
        alert('Please Select branch');
    } else if (!paymentMode || !["cash", "cheque", "online", "free"].includes(paymentMode.toLowerCase())) {
        alert('Please select a valid payment mode');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (!paymentMode || (["cash", "cheque", "online"].includes(paymentMode.toLowerCase()) && payment_proof === "")) {
        alert("Enter Payment Proof");
    } else {

        var dataString = "editfor=" + editfor +
            "&ref_id=" + ref_id +
            "&id=" + id +
            "&firstname=" + firstname +
            "&lastname=" + lastname +
            "&nominee_name=" + nominee_name +
            "&nominee_relation=" + nominee_relation +
            "&email=" + email +
            "&dob=" + dob +
            //  "&amount="+business_package+
            //  "&gst_no="+gst_no+
            "&gender=" + gender +
            "&country_code=" + country_cd +
            "&phone=" + phone +
            "&country=" + country +
            "&state=" + mystate +
            "&city=" + city +
            "&pincode=" + pin +
            "&address=" + address +
            "&zone=" + zone +
            "&branch=" + branch +
            "&profile_pic=" + profile_pic +
            "&aadhar_card=" + aadhar_card +
            "&pan_card=" + pan_card +
            "&passbook=" + passbook +
            "&voting_card=" + voting_card+
            "&payment_fee="+payment_fee+
            "&payment_proof=" +payment_proof +
            "&paymentMode=" +paymentMode +
            "&chequeNo=" +chequeNo +
            "&chequeDate=" +chequeDate +
            "&bankName=" +bankName +
            "&transactionNo=" +transactionNo+ 
            '&userId=' + userId + 
            '&userType=' + userType;
        console.log(dataString);

        $("#editBuisnessMentor").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "business_mentor/edit_business_mentor_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_mentor.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Business Mentor End by BCH @@@@****####

// Business Consultant start by client 
// Add by client  
$('#add-business-consultant').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    

    var testE = $('#testemail').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else {
        $("#add-business-consultant").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_consultant/add_business_consultant_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_consultant.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-business-consultant').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $('#testemail').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else {
        $("#edit-business-consultant").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_consultant/edit_business_consultant_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_consultant.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Business Consultant End by client

// Business Trainee start by client 
// Add by client  
$('#add-business-trainee').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // var profile_pic = $(":hidden#img_path1").val().trim();
    // var aadhar_card = $(":hidden#img_path2").val().trim();
    // var pan_card = $(":hidden#img_path3").val().trim();
    // var passbook = $(":hidden#img_path4").val().trim();
    // var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $('#testemail').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address;
    //  "&profile_pic=" +profile_pic+
    //  "&aadhar_card=" +aadhar_card+
    //  "&pan_card=" +pan_card+
    //  "&passbook=" +passbook+
    //  "&voting_card=" +voting_card;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else {
        $("#add-business-trainee").attr("disabled", "disabled");
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_trainee/add_business_trainee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    alert("Added Successfuly");
                    location.href = "view_business_trainee.php";
                } else {
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-business-trainee').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // var profile_pic = $(":hidden#img_path1").val().trim();
    // var aadhar_card = $(":hidden#img_path2").val().trim();
    // var pan_card = $(":hidden#img_path3").val().trim();
    // var passbook = $(":hidden#img_path4").val().trim();
    // var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $('#testemail').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address;
    //  "&profile_pic="+profile_pic+
    //  "&aadhar_card="+aadhar_card+
    //  "&pan_card="+pan_card+
    //  "&passbook="+passbook+
    //  "&voting_card="+voting_card;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else {
        $("#edit-business-trainee").attr("disabled", "disabled");
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_trainee/edit_business_trainee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    alert("Edit Successfuly");
                    location.href = "view_business_trainee.php";
                } else {
                    alert("Failed");
                }
            },
        });
    }
});
// Business Trainee End by client

// Corporate Agency start by client 
// Add by client  
$('#add-corporate-agency').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&amount=" + business_package +
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo + 
        '&userId=' + userId + 
        '&userType=' + userType;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    console.log("Age is: " + age);
    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age <= 18) {
        alert('Age must be more than or equal to 18 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (payment_proof == '') {
        alert("Add Payment Proof");
    } else {
        $("#add-corporate-agency").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "corporate_agency/add_corporate_agency_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_corporate_agency.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-corporate-agency').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&amount=" + business_package +
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo + 
        '&userId=' + userId + 
        '&userType=' + userType;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;
    console.log("Age is: " + age);
    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age <= 18) {
        alert('Age must be more than or equal to 18 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (payment_proof == "") {
        alert("Enter Payment Proof");
    } else {
        $("#edit-corporate-agency").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "corporate_agency/edit_corporate_agency_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_corporate_agency.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Corporate Agency End by client

// Corporate Agency travel-agent start by client 
// Add travel-agent by client  
$('#add-travel-agent').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();
    //for Goa cutomers
    let payment_fee,
        paymentMode = "",
        chequeNo = "",
        chequeDate = "",
        bankName = "",
        transactionNo = "",
        payment_proof = "";

    payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == "FOC") {
        paymentMode = "Free";
        chequeNo = "";
        chequeDate = "";
        bankName = "";
        transactionNo = "";
        payment_proof = "";
    } else {
        paymentMode = $(".payment:checked").val();
        chequeNo = $("#chequeNo").val().trim();
        chequeDate = $("#chequeDate").val().trim();
        bankName = $("#bankName").val().trim();
        transactionNo = $("#transactionNo").val().trim();
        payment_proof = $(":hidden#img_path6").val().trim();
        
    }
    // var paymentMode = $(".payment:checked").val();
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // if(payment_fee == 'FOC'){
    //     var payment_proof = 'none';
    // }else if(payment_fee == 'null'){
    //     var payment_proof = 'none';
    // }else{
    //     var payment_proof = $(":hidden#img_path6").val().trim();
    // }

    var register_by = $('#register_by').val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&payment_fee=" + payment_fee +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo +
        "&register_by=" + register_by + 
        '&userId=' + userId + 
        '&userType=' + userType;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age <= 18) {
        alert('Age must be more than or equal to 18 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (!paymentMode || !["cash", "cheque", "online", "free"].includes(paymentMode.toLowerCase())) {
        alert('Please select a valid payment mode');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (paymentMode !='Free' && payment_proof == "") {
        alert("Please upload Payment Proof");
    } else {
        $("#add-travel-agent").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "travel_agent/add_travel_agent_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_travel_agent.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit travel-agent by client 
$('#edit-travel-agent').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == 'FOC') {
        var paymentMode = 'Free';
    } else {
        var paymentMode = $(".payment:checked").val();
    }
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    if (payment_fee == 'FOC') {
        var payment_proof = 'none';
    } else if (payment_fee == 'null') {
        var payment_proof = 'none';
    } else {
        var payment_proof = $(":hidden#img_path6").val().trim();
    }

    var register_by = $('#register_by').val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo +
        "&register_by=" + register_by + 
        '&userId=' + userId + 
        '&userType=' + userType;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age <= 18) {
        alert('Age must be more than or equal to 18 Years');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (!paymentMode || !["cash", "cheque", "online", "free"].includes(paymentMode.toLowerCase())) {
        alert('Please select a valid payment mode');
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else {
        $("#edit-travel-agent").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "travel_agent/edit_travel_agent_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_travel_agent.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Corporate Agency travel-agent End by client

// Corporate Agency Customer start by client 
// Add customer by client  
$('#add-customer').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var cu_ref_id = $("#cu_ref_id").val(); // customer reference id
    var cu_ref_name = $("#cu_ref_name").val(); // customer reference Name
    var user_id_name = $("#user_id_name").val(); // Travel agent reference id
    var reference_name = $("#reference_name").val(); // Travel agent reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == "FOC") {
        var paymentMode = "Free";
    } else {
        var paymentMode = $(".payment:checked").val();
    }
    //console.log(paymentMode);
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    if (payment_fee == "FOC") {
        var payment_proof = "none";
    } else if (payment_fee == "null") {
        var payment_proof = "none";
    } else {
        var payment_proof = $(":hidden#img_path6").val().trim();
    }
    let payment_text = $("#payment_fee option:selected").text().trim(); // Gets the visible text

    // Check if the text contains a colon (e.g., "Prime: ₹10,000/-")
    let payment_label = payment_text.includes(":")
        ? payment_text.split(":")[0].trim() // Extract part before colon
        : payment_text;

    var register_by = $('#register_by').val().trim();
    var registrant_id = $('#registrant_id').val();
    var editfor = $('#editfor').val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();

    if (!cu_ref_id) {
        cu_ref_id = "";
        cu_ref_name = "";
    }

    if (!user_id_name) {
        user_id_name = "";
        reference_name = "";
    }

    var dataString = // "designation=" +designation+ 
        "cu_ref_id=" + cu_ref_id +
        "&cu_ref_name=" + cu_ref_name +
        "&user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&register_by=" + register_by +
        "&registrant_id=" + registrant_id +
        "&editfor=" + editfor +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo +
        "&payment_fee=" + payment_fee + 
        '&userId=' + userId + 
        '&userType=' + userType+
        '&payment_label=' + payment_label;
    console.log(dataString);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (nominee_name === '') {
        alert("Enter Nominee Name");
    } else if (nominee_relation === '') {
        alert("Enter Nominee Relation");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select birthdate');
    } else if (age < 18) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (!paymentMode || (paymentMode !== "Free" && paymentMode === "")) {
        alert("Please select payment mode");
    } else if (paymentMode === "online" && !transactionNo) {
        alert("Please enter Transaction No");
    } else if (paymentMode === "cheque" && (!chequeNo || !chequeDate || !bankName)) {
        let missing = [];
        if (!chequeNo) missing.push("Cheque No");
        if (!chequeDate) missing.push("Cheque Date");
        if (!bankName) missing.push("Bank Name");
        alert("Please enter: " + missing.join(", "));
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (payment_fee !== "FOC" && !payment_proof) {
        alert("Please upload Payment Proof");
    } else {
        $("#add-customer").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "customer/add_customer_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_customer.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    console.log(data);

                    alert("Failed");
                }
            },
        });
    }
});
// Edit customer by client 
$('#edit-customer').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();
    var ta_reference_no=$("#user_id_name").val().trim();
    var register_by = $('#register_by').val().trim();
    var registrant_id = $('#registrant_id').val();

    var testE = $('#testemail').val();
    var userId = $('#userID').val();
    var userType = $('#userType').val();
    var payment_fee = $("#payment_fee").val().trim();
    if (payment_fee == "FOC") {
        var paymentMode = "Free";
    } else {
        var paymentMode = $(".payment:checked").val();
    }
    //console.log(paymentMode);
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    if (payment_fee == "FOC") {
        var payment_proof = "none";
    } else if (payment_fee == "null") {
        var payment_proof = "none";
    } else {
        var payment_proof = $(":hidden#img_path6").val().trim();
    }
    let payment_text = $("#payment_fee option:selected").text().trim(); // Gets the visible text

    // Check if the text contains a colon (e.g., "Prime: ₹10,000/-")
    let payment_label = payment_text.includes(":")
        ? payment_text.split(":")[0].trim() // Extract part before colon
        : payment_text;
    //age calculation
    var birth_date_split = dob.split("-");
    var age = current_year - birth_date_split[0];
    // console.log(age);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        "&payment_proof=" + payment_proof +
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo+
        "&payment_fee="+ payment_fee+
        "&register_by=" + register_by +
        "&registrant_id=" + registrant_id + 
        '&userId=' + userId + 
        '&userType=' + userType+
        '&payment_label=' + payment_label+
        '&ta_reference_no='+ta_reference_no;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (nominee_name === '') {
        alert("Enter Nominee Name");
    } else if (nominee_relation === '') {
        alert("Enter Nominee Relation");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (!paymentMode || (paymentMode !== "Free" && paymentMode === "")) {
        alert("Please select payment mode");
    } else if (paymentMode === "online" && !transactionNo) {
        alert("Please enter Transaction No");
    } else if (paymentMode === "cheque" && (!chequeNo || !chequeDate || !bankName)) {
        let missing = [];
        if (!chequeNo) missing.push("Cheque No");
        if (!chequeDate) missing.push("Cheque Date");
        if (!bankName) missing.push("Bank Name");
        alert("Please enter: " + missing.join(", "));
    } else if (profile_pic === '') {
        alert('Please Upload profile Picture');
    } else if (aadhar_card === '') {
        alert('Please Upload Aadhar Card Picture');
    } else if (pan_card === '') {
        alert('Please Upload Pan Card Picture');
    } else if (passbook === '') {
        alert('Please Upload Bank Passbook Picture');
    } else if (payment_fee !== "FOC" && !payment_proof) {
        alert("Please upload Payment Proof");
    } else {
        $("#editCustomer").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        //console.log(dataString);


        $.ajax({
            type: "POST",
            url: "customer/edit_customer_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_customer.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Corporate Agency Customer End by client 

// Business Operation Executive start by client 
// Add by client  
$('#add-business-operation-executive').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        "&amount=" + business_package +
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#add-business-operation-executive").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_operation_executive/add_boe_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_operation_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-business-operation-executive').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        //  "&amount=" +business_package+
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof="+payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#edit-business-operation-executive").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "business_operation_executive/edit_boe_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_operation_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Business Operation Executive End by client

// Training Manager start by client 
// Add by client  
$('#add-training-manager').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        //  "&amount=" +business_package+
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#add-training-manager").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "training_manager/add_training_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_training_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-training-manager').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        //  "&amount=" +business_package+
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof="+payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#edit-training-manager").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "training_manager/edit_training_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_training_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Training Manager End by client

// Sales manager/Executive start by client 
// Add by client  
$('#add-sales-manager-executive').click(function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val(); // reference id
    var reference_name = $("#reference_name").val(); // reference Name
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = // "designation=" +designation+ 
        "user_id_name=" + user_id_name +
        "&reference_name=" + reference_name +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        //  "&amount=" +business_package+
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);  

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#add-training-manager").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "sales_manager_executive/add_sales_manager_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_sales_manager_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit by client 
$('#edit-sales-manager-executive').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();
    var email = $("#email").val().trim();
    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();
    var dob = $("#dob").val().trim();
    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $('#testemail').val();

    var dataString = "editfor=" + editfor +
        "&ref_id=" + ref_id +
        "&id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&nominee_name=" + nominee_name +
        "&nominee_relation=" + nominee_relation +
        "&email=" + email +
        "&dob=" + dob +
        //  "&amount=" +business_package+
        "&gst_no=" + gst_no +
        "&gender=" + gender +
        "&country_code=" + country_cd +
        "&phone=" + phone +
        "&country=" + country +
        "&state=" + mystate +
        "&city=" + city +
        "&pincode=" + pin +
        "&address=" + address +
        "&profile_pic=" + profile_pic +
        "&aadhar_card=" + aadhar_card +
        "&pan_card=" + pan_card +
        "&passbook=" + passbook +
        "&voting_card=" + voting_card +
        //  "&payment_proof="+payment_proof+
        "&paymentMode=" + paymentMode +
        "&chequeNo=" + chequeNo +
        "&chequeDate=" + chequeDate +
        "&bankName=" + bankName +
        "&transactionNo=" + transactionNo;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (user_id_name == '') {
        alert("Select Id");
    } else if (firstname === '' || !firstname.match(characterLetters) || firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname === '' || !lastname.match(characterLetters) || lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (email == '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert('Please Select Birthdate');
    } else if (age < 18 || age >= 100) {
        alert('Sorry you are not eligible');
    } else if (gender !== 'male' && gender !== 'female' && gender !== 'others') {
        alert('Please Select Gender');
    } else if (country_cd == '') {
        alert("Select Country Code");
    } else if (phone == '') {
        alert("Enter Phone number");
    } else if (!phoneReg.test(phone)) {
        alert("Enter Proper Phone Number");
    } else if (country === '') {
        alert("Select Country");
    } else if (mystate === '') {
        alert("Select State");
    } else if (city === '') {
        alert("Select City");
    } else if (address === '' || specialChar.test(address) || address.length <= 7) {
        alert("Enter Proper Address");
    } else if (paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online') {
        alert("Select payment Mode");
    } else {
        $("#edit-training-manager").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "sales_manager_executive/edit_sales_manager_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_sales_manager_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Sales manager/Executive End by client