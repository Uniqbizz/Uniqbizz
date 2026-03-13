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
//on change of compcheck
$('#registered').trigger('change');
$('#registered').on('change', function () {

    var register_type = $(this).val();

    if (register_type === 'travel_consultant') {

        // Show main designation
        $('#designation')
            .removeClass('d-none');

        // Hide institution designation
        $('#designation2')
            .addClass('d-none');

    } 
    else if (register_type === 'institution_branch_manager') {

        // Hide main designation
        $('#designation')
            .addClass('d-none');

        // Show institution designation
        $('#designation2')
            .removeClass('d-none');
    }
});

//select Designation
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    console.log(designation);
    $.ajax({
        type:'POST',
        url:'../../agents/get_user_Franchisee.php',
        data: "designation="+designation,
        success:function (e) {
            console.log(e);
            $('#user_id_name').html(e); 
        },
        error: function(err){
            console.log(err);
        },
    });
});

$('#designation2').on('change', function() {
    var designation = $('#designation2').val();
    console.log(designation);
    $.ajax({
        type:'POST',
        url:'../../agents/get_user_Franchisee.php',
        data: "designation="+designation,
        success:function (e) {
            console.log(e);
            $('#user_id_name').html(e); 
        },
        error: function(err){
            console.log(err);
        },
    });
});

// fetch User based on selected designation
$('#user_id_name').on('change', function(){
    var user_id_name = $(this).val();
    var designation = !$('#designation').hasClass('d-none') 
    ? $('#designation').val() 
    : $('#designation2').val();
    console.log(user_id_name);

    // var designation = 'franchisee';
    // console.log(designation);

    $.ajax({
        type:'POST',
        url:'../../agents/getUsers.php',
        data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
        success:function(response){
        // console.log(response);
            $('#pin').html(response);
            $('#reference_name').val(response); 
        }
    }); 
    
}); 
$('#is_complementary').on('change', function () {
    if ($(this).is(':checked')) {
        $('#payment_fee').prop('disabled', true);
        $('.payment').prop('disabled', true);
    } else {
        $('#payment_fee').prop('disabled', false);
        $('.payment').prop('disabled', false);
    }
});


$('#country').on('change', function(){
    var countryID = $(this).val();
    if(countryID){
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'country_id='+countryID,
            success:function(htmll){
                $('#mystate').html(htmll); 
                $('#city').html('<option value="">Select state first</option>'); 
            }
        }); 
    }else{
        $('#mystate').html('<option value="">Select country first</option>');
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');   
    }
});
    
$('#mystate').on('change', function(){
    // alert();
    var stateID = $(this).val();
    if(stateID){
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'state_id='+stateID,
            success:function(html){
                $('#city').html(html);
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');   
    }
    let paymentFee = document.getElementById("payment_fee");
});

$('#city').on('change', function(){
    var cityID = $(this).val();
    if(cityID){
        $.ajax({
            type:'POST',
            url:'../../address/pincode.php',
            data:'city_id='+cityID,
            success:function(response){
                $('#pin').val(response); 
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});

$('#payment_fee').on('change', function(){
    var payment_fee = $(this).val();
    if(payment_fee == "FOC"){
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
        $('#payProof').addClass('d-none');  
    }else if(payment_fee == "null"){
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
        $('#payProof').addClass('d-none');  
    }else{
        $("#paymentModeBlock").removeClass("d-none");
        $("#paymentFields").removeClass("d-none");
        $('#payProof').removeClass('d-none');  
    }
});

$('#paymentMode').on('click', function(){
    var paymentMode = $(".payment:checked").val();
    if(paymentMode == "cheque"){
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $('#transactionNo').val('');
    }else if(paymentMode == "online"){
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
        $('#chequeNo').val('');
        $('#chequeDate').val('');
        $('#bankName').val('');
    } else {
        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $('#chequeNo').val('');
        $('#chequeDate').val('');
        $('#bankName').val('');
        $('#transactionNo').val('');
    }
});
//for valid check date --SV
$('#chequeDate').on('input', function () {
    let value = $(this).val();

    // Allow only digits and hyphens, and match pattern yyyy-mm-dd (partial allowed)
    value = value.replace(/[^0-9\-]/g, ''); // Remove non-digit and non-hyphen chars

    // Optional: restrict to yyyy-mm-dd format (prevent too many characters)
    if (value.length > 10) {
        value = value.slice(0, 10);
    }

    // Optional: add hyphens automatically as the user types
    if (/^\d{4}$/.test(value)) {
        value += '-';
    } else if (/^\d{4}-\d{2}$/.test(value)) {
        value += '-';
    }

    $(this).val(value);
});
    // Target the specific input and message
const specificInput = document.getElementById("chequeDate");
const specificMessage = document.getElementById("specificMessage");
// Show message only for this input on focus
specificInput.addEventListener("focus", () => {
    specificMessage.style.display = "block"; // Show the message
});

// Hide message on blur
specificInput.addEventListener("blur", () => {
    specificMessage.style.display = "none"; // Hide the message
});
//for valid check date --SV --end 
//for valid cheque number --SV
$('#chequeNo').on('input', function () {
    this.value = this.value.replace(/\D/g, ''); // Remove any non-digit characters
});
$("#add_ca_travelagency").on("click", function (e) {

    e.preventDefault();
    var transfer_check=$('#tr_check').val();
    var register_as = $('#registered').val();
    var url = register_as == 'travel_consultant'
    ? '../../controllers/ca_travel_agency/add_ca_travelAgency_data.php'
    : register_as == 'institution_branch_manager'
        ? '../../controllers/ca_travel_agency/add_ca_ins_branch_manager_data.php'
        : '';
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var comp_check = $('#is_complementary').is(':checked') ? 1 : 2;//1 complementary 2 non complementary
    var user_id_name = $("#user_id_name").val() == 'NA' ? 'Not Applicable' : $("#user_id_name").val();
    var reference_name = $("#reference_name").val() == 'NA' ? 'Not Applicable' : $("#reference_name").val();

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

    //if note is empty
    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    var testE = $("#testemail").val();

    //age calculation
    var birth_date_split = dob.split("-");
    var age = currentYear - birth_date_split[0];
    // console.log(age);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    if (reference_name == "") {
        alert("Select Referance name");
    } else if (firstname == "") {
        alert("Enter Proper First Name");
    } else if (lastname == "") {
        alert("Enter Proper Last Name");
    } else if (nominee_name === "") {
        alert("Enter Nominee Name");
    } else if (nominee_relation === "") {
        alert("Enter Nominee Relation");
    } else if (email == "") {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (dob === "") {
        alert("Choose Correct Birth date");
    } else if (age < 18) {
        alert("Age must be more than 18 Years");
    } else if (gender !== "male" && gender !== "female" && gender !== "others") {
        alert("Please Select Gender");
    } else if (phone === "") {
        alert("Please enter contact number");
    } else if (!phoneReg.test(phone)) {
        alert("Contact Number Must be 10 Digit");
    } else if (country === "") {
        alert("Please Select Country");
    } else if (mystate === "") {
        alert("Please Select State");
    } else if (city === "") {
        alert("Please Select City");
    } else if (address === "") {
        alert("Please Enter address");
    } else if (paymentMode != "Free" && !paymentMode) {
        alert("Please select payment mode");
    }else if (paymentMode === "online" && !transactionNo) {
        alert("Please enter Transaction No");
    } else if (paymentMode === "cheque") {
        let missingFields = [];
        if (!chequeNo) missingFields.push("Cheque No");
        if (!chequeDate) missingFields.push("Cheque Date");
        if (!bankName) missingFields.push("Bank Name");

        if (missingFields.length > 0) {
            alert("Please enter: " + missingFields.join(", "));
        }
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (aadhar_card === "") {
        alert("Please Upload Aadhar Card Picture");
    } else if (pan_card === "") {
        alert("Please Upload Pan Card Picture");
    } else if (passbook === "") {
        alert("Please Upload Bank Passbook Picture");
    } else if (paymentMode != "Free" && !payment_proof) {
        alert("Please Upload Payment Proof");
    } else {
        var dataString = // "designation=" +designation+
            "user_id_name=" +
            user_id_name +
            "&reference_name=" +
            reference_name +
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
            "&payment_proof=" +
            payment_proof +
            "&payment_fee=" +
            payment_fee +
            "&paymentMode=" +
            paymentMode +
            "&chequeNo=" +
            chequeNo +
            "&chequeDate=" +
            chequeDate +
            "&bankName=" +
            bankName +
            "&transactionNo=" +
            transactionNo +
            "&note=" +
            note+
            "&comp_check="+
            comp_check+
            "&transfer_check="+
            transfer_check;
        // console.log(dataString);

        $("#add_ca_travelagency").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: url ,
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_ca_travelAgency.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }

});