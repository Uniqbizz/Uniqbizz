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
//get page status

$(document).ready(function() {
    // Fetch User based on selected designation add by SV on 08-09-2025
    $('#user_id_name').on('change', function() {
        var user_id_name = $(this).val();
        var designation = 'ca_travelagency';

        if (user_id_name !== '') { // ✅ only fire if something is selected
            $.ajax({
                type: 'POST',
                url: '../../agents/getUsers.php',
                data: { user_id_name: user_id_name, designation: designation },
                success: function(response) {
                    $('#reference_name').val(response);
                }
            });
        }
    });

    // 🔥 Fire once on page load if a value is already selected
    if ($('#user_id_name').val() !== '') {
        $('#user_id_name').trigger('change');
        $('#user_id_name').prop('disabled',true);
    }
});
$('#country').on('change', function() {
    var countryID = $(this).val();
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: '../../address/countrydata.php',
            data: 'country_id=' + countryID,
            success: function(htmll) {
                $('#mystate').html(htmll);
                $('#city').html('<option value="">Select state first</option>');
            }
        });
    } else {
        $('#mystate').html('<option value="">Select country first</option>');
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});

$('#mystate').on('change', function() {
    // alert();
    var stateID = $(this).val();
    if (stateID) {
        $.ajax({
            type: 'POST',
            url: '../../address/countrydata.php',
            data: 'state_id=' + stateID,
            success: function(html) {
                $('#city').html(html);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
                    
});
$('#pay').removeClass('d-none');
$('#couponFee').removeClass('d-none');

//payment type
$('#payment_fee').on('change', function() {
    var payval=$(this).val();
    if (payval != 'FOC') {
        $('#paymentMode').removeClass('d-none');
        $('#payProof').removeClass('d-none');
        $('#payOpt').removeClass('d-none');
    }else{
        $('#paymentMode').addClass('d-none');
        $('#payProof').addClass('d-none');
        $('#payOpt').addClass('d-none');
    }
});
// payment mode
$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
    if (paymentMode == "cheque") {
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $("#transactionNo").val("");
    } else if (paymentMode == "online") {
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
        $("#chequeNo").val("");
        $("#chequeDate").val("");
        $("#bankName").val("");
    } else {
        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $("#chequeNo").val("");
        $("#chequeDate").val("");
        $("#bankName").val("");
        $("#transactionNo").val("");
    }
});

function toggleDiv(show) {
    document.getElementById("paymentMode").classList.toggle("d-none", !show);
    document.getElementById("payOpt").classList.toggle("d-none", !show);
    document.getElementById("payProof").classList.toggle("d-none", !show);
    let paymentFee = document.getElementById("payment_fee");
    paymentFee.value = show ? "10000" : "FOC";

}

$('#city').on('change', function() {
    var cityID = $(this).val();
    if (cityID) {
        $.ajax({
            type: 'POST',
            url: '../../address/pincode.php',
            data: 'city_id=' + cityID,
            success: function(response) {
                // $('#pin').html(response);
                $('#pin').val(response);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});
$("#addCustomer").on("click", function (e) {
    e.preventDefault();
    var transfer_check = $('#tr_check').val();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val().trim();
    var user_id_name = $("#user_id_name").val().trim();
    var reference_name = $("#reference_name").val().trim();
    var cust_id_name = ($("#cust_ref_id").val() || "").trim();
    var cust_name   = ($("#cust_ref_name").val() || "").trim();

    var isComplementary = $('#is_complementary').is(':checked') ? 1 : 2;
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    // var nominee_name = $("#nominee_name").val().trim();
    // var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
    //var payment_proof = $(":hidden#img_path6").val().trim();
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
        : payment_text; // If no colon, use the whole text
    // } else {
    //     paymentMode = "Free";
    //     chequeNo = "";
    //     chequeDate = "";
    //     bankName = "";
    //     transactionNo = "";
    //     payment_proof = "";
    // }
    //----------------
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();

    // var profile_pic = $(":hidden#img_path1").val().trim();
    // var aadhar_card = $(":hidden#img_path2").val().trim();
    // var pan_card = $(":hidden#img_path3").val().trim();
    // var passbook = $(":hidden#img_path4").val().trim();
    // var voting_card = $(":hidden#img_path5").val().trim();

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
    }
    // else if (nominee_name === "") {
    //     alert("Enter Nominee Name");
    // } else if (nominee_relation === "") {
    //     alert("Enter Nominee Relation");
    // } 
    else if (email == "") {
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
    } else if (paymentMode === "online" && !transactionNo) {
        alert("Please enter Transaction No");
    } else if (paymentMode === "cheque" && (!chequeNo || !chequeDate || !bankName)) {
        let missing = [];
        if (!chequeNo) missing.push("Cheque No");
        if (!chequeDate) missing.push("Cheque Date");
        if (!bankName) missing.push("Bank Name");
        alert("Please enter: " + missing.join(", "));
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (aadhar_card === "") {
        alert("Please Upload Aadhar Card Picture");
    } else if (pan_card === "") {
        alert("Please Upload Pan Card Picture");
    } else if (passbook === "") {
        alert("Please Upload Bank Passbook Picture");
    } else if (payment_fee != "FOC" && payment_proof == "") {
        alert("Please upload Payment Proof");
    } else {
        var dataString = // "designation=" +designation+
            "user_id_name=" +
            user_id_name +
            "&reference_name=" +
            reference_name +
            "&cust_id_name=" +
            cust_id_name +
            "&cust_name=" +
            cust_name +
            "&firstname=" +
            firstname +
            "&lastname=" +
            lastname +
            // "&nominee_name=" +
            // nominee_name +
            // "&nominee_relation=" +
            // nominee_relation +
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
            "&payment_fee=" +
            payment_fee +
            "&note=" +
            note +
            "&payment_label=" +
            payment_label +
            '&isComplementary=' +
            isComplementary+
            "&transfer_check="+
            transfer_check;
        console.log(dataString);

        $("#addCustomer").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "../../controllers/ca_customer/add_customers_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_customers.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});