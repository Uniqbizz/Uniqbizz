// for age calculation //
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
const date = new Date();
let current_year = date.getFullYear();
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
// fetch User based on selected designation
$('#user_id_name').on('change', function() {
    var user_id_name = $(this).val();

    var designation = 'CA_Travel_Agent';

    $.ajax({
        type: 'POST',
        url: '../agents/getUsers.php',
        data: 'user_id_name=' + user_id_name + '&designation=' + designation,
        success: function(response) {
            $('#reference_name').val(response);
        }
    });

});

$('#country').on('change', function() {
    var countryID = $(this).val();
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: '../address/countrydata.php',
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
    var stateID = $(this).val();
    if (stateID) {
        $.ajax({
            type: 'POST',
            url: '../address/countrydata.php',
            data: 'state_id=' + stateID,
            success: function(html) {
                $('#city').html(html);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
    //coupon applicable logic for goa
    
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

$('#city').on('change', function() {
    var cityID = $(this).val();
    if (cityID) {
        $.ajax({
            type: 'POST',
            url: '../address/pincode.php',
            data: 'city_id=' + cityID,
            success: function(response) {
                $('#pin').val(response);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});
document.addEventListener("DOMContentLoaded", function () {

    const callBtn = document.getElementById("callBtn");

    if (callBtn) {
        callBtn.addEventListener("click", function(e) {

            let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (!isMobile) {
                e.preventDefault();

                alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                location.reload();

                // Optional clipboard copy (safe fallback)
                if (navigator.clipboard) {
                    navigator.clipboard.writeText("8010892265");
                }
            }
        });
    }

});
var modal = document.getElementById('staticBackdrop');

// Store the element that opened the modal
let lastFocusedElement;

document.addEventListener('click', function(e) {
    if (e.target.closest('[data-bs-toggle="modal"]')) {
        lastFocusedElement = e.target;
    }
});

modal.addEventListener('hidden.bs.modal', function () {
    if (lastFocusedElement) {
        lastFocusedElement.focus();
    } else {
        document.body.focus();
    }
});
//upload files
function bindUploadEvents() {

    document.querySelectorAll('.file-input').forEach(input => {

        if (input.dataset.bound) return;

        input.dataset.bound = "true";

        input.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) return;

            const card = this.closest('.upload-card');
            const title = card.dataset.title;
            const index = card.dataset.index;

            if (file.type.startsWith('image/')) {

                const reader = new FileReader();

                reader.onload = function (e) {

                    card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();

                    let preview = card.querySelector('.preview-wrapper');

                    if (!preview) {

                        preview = document.createElement('div');
                        preview.className = 'preview-wrapper';

                        preview.innerHTML = `
                            <img src="${e.target.result}">
                            <input type="hidden" id="img_path${index}" value="../../uploading/${file.name}">
                            <div class="file-title">
                                ${title}
                            </div>
                        `;

                        card.appendChild(preview);

                    } else {

                        preview.querySelector('img').src = e.target.result;
                    }
                };

                reader.readAsDataURL(file);

            } else {

                card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();

                let preview = document.createElement('div');

                preview.className = 'pdf-preview';

                preview.innerHTML = `
                    <i class="fa-solid fa-file-pdf"></i>
                    <p class="mt-2 mb-0">${file.name}</p>
                    <div class="file-title">
                        ${title}
                    </div>
                `;

                card.appendChild(preview);
            }

            

        });

    });

}

document.addEventListener('DOMContentLoaded', function () {
    bindUploadEvents();
});
$("#saveDraftAdd").on("click", function (e) {
    e.preventDefault();
    submitAddForm('draft');
});
$("#addCustomer").on("click", function (e) {
    e.preventDefault();
    submitAddForm('submit');
});
function submitAddForm(actionType) {
    // e.preventDefault();
    // console.log('Add customer button clicked '+actionType);
    var cu_ref_id = $("#cu_ref_id").val(); // customer reference id
    var customer_type = $('#customer_type').val(); // customer reference type
    var cu_ref_name = $("#cu_ref_name").val(); // customer reference Name
    var user_id_name = $("#user_id_name").val(); // Travel agent reference id
    var mobileRegex = /^[0-9]{10}$/;
    var specialChar = /[!@#$%^&*]/g;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    //age calculation
    var today = new Date();
    var current_year = today.getFullYear();
    var payment_fee = $("#payment_fee").val().trim();
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
    // var father_spouse_name = $("#father_spouse_name").val().trim();
    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();
    var gender = $('input[name="gender"]:checked').val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();
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
    var profile_pic = aadhar_card = pan_card = passbook = voting_card = payment_proof = '';
    var profile_pic_file = $("#upload_file1").val().trim();
    var aadhar_card_file = $("#upload_file2").val().trim();
    var pan_card_file = $("#upload_file3").val().trim();
    var passbook_file = $("#upload_file4").val().trim();
    var voting_card_file = $("#upload_file11").val().trim();
    var payment_proof_file = $("#upload_file12").val().trim();
    // var note = $("#note").val().trim();

    let payment_text = $("#payment_fee option:selected").text().trim(); // Gets the visible text

    // Check if the text contains a colon (e.g., "Prime: ₹10,000/-")
    let payment_label = payment_text.includes(":")
        ? payment_text.split(":")[0].trim() // Extract part before colon
        : payment_text;

    var register_by = $('#register_by').val().trim();
    var registrant_id = $('#registrant_id').val();
    var editfor = $('#editfor').val().trim();

    var testE = $('#testemail').val();
    var userId = $('#userId').val();
    var userType = $('#userType').val();

    if (!cu_ref_id) {
        cu_ref_id = "";
        cu_ref_name = "";
    }

    if (!user_id_name) {
        user_id_name = "";
        reference_name = "";
    }

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
        } else if (profile_pic_file === '') {
            alert('Please Upload profile Picture');
            return;
        } else if (aadhar_card_file === '') {
            alert('Please Upload Aadhar Card Picture');
            return;
        } else if (payment_proof_file == '') {
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
    //get img url only if file exist
    if (profile_pic_file !== '') {
        profile_pic = $("#img_path1").val().trim();
    }
    if (aadhar_card_file !== '') {
        aadhar_card = $("#img_path2").val().trim();
    } 
    if (pan_card_file !== '') {
        pan_card = $("#img_path3").val().trim();
    }
    if (passbook_file !== '') {
        passbook = $("#img_path4").val().trim();
    } 
    if (payment_proof_file !== '') {
        payment_proof = $("#img_path12").val().trim();
    }
    if (voting_card_file !== '') {
        voting_card = $("#img_path11").val().trim();
    }

    var dataObj = {
        action_type: actionType,
        cu_ref_id: cu_ref_id,
        u_ref_name: cu_ref_name,
        user_id_name: user_id_name,
        reference_name: reference_name,

        firstname: firstname,
        lastname: lastname,
        email: email,
        dob: dob,
        gender: gender,

        country_code: country_cd,
        phone: phone,
        gst_no: gst_no,

        paymentMode: paymentMode,
        chequeNo: chequeNo,
        chequeDate: chequeDate,
        bankName: bankName,
        transactionNo: transactionNo,

        country: country,
        state: mystate,
        city: city,
        pincode: pin,
        address: address,

        profile_pic: profile_pic,
        aadhar_card: aadhar_card,
        pan_card: pan_card,
        passbook: passbook,
        voting_card: voting_card,
        payment_proof: payment_proof,

        register_by: register_by,
        registrant_id: registrant_id,
        editfor: editfor,
        payment_fee: payment_fee,
        payment_label: payment_label,

        userId: userId,
        userType: userType,
        customer_type: customer_type
    };
    console.log(dataObj);

    $("#addCustomer").attr("disabled", "disabled");
    $("#saveDraftAdd").attr("disabled", "disabled");
    // console.log(dataString);
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "ajax/customer/add_customer_data.php",
        data: dataObj,
        cache: false,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                $("#loading-overlay").hide(); //loading screen
                alert("Added Successfuly");
                location.href = "customers_list.php";
            } else {
                $("#loading-overlay").hide(); //loading screen
                alert("Failed");
            }
        },
    });
    
};

// Edit customer by client 
$('#edit-customer').click(function (e) {
    e.preventDefault();

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $('#editfor').val(); // registered OR pending
    var ref_id = $('#ref_id').val();  // reference id
    var id = $('#id').val(); // customer id
    var customer_type = $('#customer_type').val(); // customer type
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
    var ta_reference_no=$("#user_id_name").val().trim();
    var register_by = $('#register_by').val().trim();
    var registrant_id = $('#registrant_id').val();

    var testE = $('#testemail').val();
    var userId = $('#userId').val();
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
        // "&nominee_name=" + nominee_name +
        // "&nominee_relation=" + nominee_relation +
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
        '&ta_reference_no='+ta_reference_no+
        '&customer_type='+customer_type;
    // console.log(dataString);                 

    // validation for email, phone, name 
    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    // age calculation 
    var dob_year = dob.substring(0, 4);
    var age = current_year - dob_year;

    if (firstname === '') {
        alert("Enter Proper First Name");
    } else if (lastname === '') {
        alert("Enter Proper Last Name");
    } else if (email === '') {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE === '1') {
        alert("Email already exists");
    } else if (dob === '') {
        alert("Please Select Birthdate");
    } else if (age < 18) {
        alert("Sorry, you are not eligible");
    } else if (!['male', 'female', 'others'].includes(gender)) {
        alert("Please Select Gender");
    } else if (country_cd === '') {
        alert("Select Country Code");
    } else if (phone === '') {
        alert("Enter Phone Number");
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
    } else if (!paymentMode) {
        alert("Please Select Payment Mode");
    } else if (paymentMode === "online" && transactionNo === '') {
        alert("Please Enter Transaction No");
    } else if (paymentMode === "cheque") {

        let missing = [];

        if (chequeNo === '') missing.push("Cheque No");
        if (chequeDate === '') missing.push("Cheque Date");
        if (bankName === '') missing.push("Bank Name");

        if (missing.length > 0) {
            alert("Please Enter: " + missing.join(", "));
        }

    } else if (profile_pic === '') {
        alert("Please Upload Profile Picture");
    } else if (aadhar_card === '') {
        alert("Please Upload Aadhar Card");
    } else if (pan_card === '') {
        alert("Please Upload PAN Card");
    } else if (passbook === '') {
        alert("Please Upload Bank Passbook");
    } else if (payment_fee !== "FOC" && payment_proof === '') {
        alert("Please Upload Payment Proof");
    } else {
        $("#editCustomer").attr("disabled", "disabled");
        $("#loading-overlay").show(); //loading screen
        //console.log(dataString);


        $.ajax({
            type: "POST",
            url: "ajax/customer/edit_customers_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "customer_list.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});