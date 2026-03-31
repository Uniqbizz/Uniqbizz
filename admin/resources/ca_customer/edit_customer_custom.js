function getFormData() {
    let data = {};

    $("#cutomer_form")
        .serializeArray()
        .forEach(field => {
            if (field.name !== "prev_user_data" && field.name !== "testemail") {
                data[field.name] = field.value.trim();
            }
        });

    return data;
}

let originalFormData = {};

$(window).on("load", function () {
    setTimeout(() => {
        originalFormData = getFormData();
        console.log("ORIGINAL:", originalFormData);
    }, 1500); // keep if AJAX is there
});
function isFormChanged(original, current) {
    return JSON.stringify(original) !== JSON.stringify(current);
}
$(document).ready(function() {
    var paymentMode = $(".payment:checked").val();
    var payment_fee = $('#payment_fee').val()
    if (paymentMode == "cheque") {
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
    } else if (paymentMode == "online") {
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
    } else {
        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
    }
    var state = $('#mystate').val();
});
//select Designation
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url: '../../agents/get_user_Franchisee.php',
        data: "designation=" + designation,
        success: function(e) {
            // console.log(e);
            $('#user_id_name').html(e);
        },
        error: function(err) {
            console.log(err);
        },
    });
});

// fetch User based on selected designation
$('#user_id_name').on('change', function() {
    var user_id_name = $(this).val();
    // console.log(user_id_name);

    var designation = $('#designation').val();
    // console.log(designation);

    $.ajax({
        type: 'POST',
        url: '../../agents/getUsers.php',
        data: 'user_id_name=' + user_id_name + '&designation=' + designation,
        success: function(response) {
            // console.log(response);
            // $('#pin').html(response);
            $('#reference_name').val(response);
        }
    });

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
// Edit customer by admin
$("#confirmEditReason").on("click", function (e) {
    e.preventDefault();
    var edit_reason = $("#edit_reason").val().trim();

    if(edit_reason === ""){
        alert("Please enter reason for edit");
        return;
    }

    $("#editReasonModal").modal("hide");
    var transfer_check = $("#tr_check").val();
    var prev_user_name=prev_user_email='';
    if (transfer_check == 1) {
        prev_user_name=$('#prev_user_name').val();
        prev_user_email=$('#prev_user_email').val();
    }
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();
    var cust_id_name = ($("#cust_ref_id").val() || "").trim();
    var cust_name   = ($("#cust_reference_name").val() || "").trim();

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

    //if note is empty
    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    var testE = $("#testemail").val();

    //age calculation
    var birth_date_split = dob.split("-");
    var age = currentYear - birth_date_split[0];
    var edit_reason_param = "&edit_reason=" + encodeURIComponent(edit_reason);
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
        alert("Age must be more than 20 Years");
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
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
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
    } else if (aadhar_card === "") {
        alert("Please Upload Aadhar Card Picture");
    } else if (pan_card === "") {
        alert("Please Upload Pan Card Picture");
    } else if (passbook === "") {
        alert("Please Upload Bank Passbook Picture");
    } else if (payment_proof == "" && mystate == '6') {
        alert("Please upload Payment Proof");
    }else{
        var dataString =
            "editfor=" +
            editfor +
            "&ref_id=" +
            ref_id +
            "&id=" +
            id +
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
            "&payment_fee=" + payment_fee +
            "&note=" +
            note +
            "&payment_label=" +
            payment_label +
            '&isComplementary=' +
            isComplementary+
            "&transfer_check="+
            transfer_check+
            edit_reason_param;
        // console.log(dataString);

        $("#editCustomer").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "../../controllers/ca_customer/edit_customers_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_customers.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
$("#editCustomer").click(function (e) {
    e.preventDefault();

    const currentFormData = getFormData();
    console.log("CURRENT:", currentFormData);

    if (!isFormChanged(originalFormData, currentFormData)) {
        $("#noChangeModal").modal("show");
        return;
    }

    $("#editReasonModal").modal("show");
});
$("#noChangeOk, #noChangeClose").add("#noChangeModal")
.on("click hidden.bs.modal", () => {
    window.location.href = "view_customers.php";
});
$("#close").on('click',function () {
    // Go back to the previous page
    window.history.back(); // or window.history.go(-1);
});