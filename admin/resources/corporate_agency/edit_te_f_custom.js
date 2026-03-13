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
$(document).ready(function() {
    var paymentMode = $(".payment:checked").val();
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

$('#business_package_amount').on('change', function() {
    var business_package_amount = $(this).val();
    $('#flex_amount').val(business_package_amount);
});

$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
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
});

//const checkbox = document.getElementById('showTCAlot');
let allowedCount = 0;

// Bind official_purpose change ONCE (outside the checkbox toggle)
$('input[name="official_purpose"]').on('change', function() {
    allowedCount = parseInt($(this).val());
    $('#allowedCount').text(allowedCount);
    $('#selectedCount').text(0);
    $('#selectedTCsInput').val('');

    let reference_no = $('#user_id_name').val();

    $.ajax({
        url: 'get_available_tcs.php',
        type: 'POST',
        data: {
            tc_count: allowedCount,
            reference_no: reference_no
        },
        success: function(response) {
            $('#tcListContainer').html(response);
            $('#availableTCs').removeClass('d-none');

            // Attach event to checkboxes inside response
            $('#tcListContainer').on('change', '.tc-checkbox', function() {
                let selected = $('.tc-checkbox:checked').length;
                if (selected > allowedCount) {
                    this.checked = false;
                    alert('You can only select ' + allowedCount + ' TC(s).');
                    return;
                }
                $('#selectedCount').text(selected);

                let selectedIds = [];
                $('.tc-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $('#selectedTCsInput').val(selectedIds.join(','));
            });
        }
    });
});

// Confirm edit reason click (same pattern as BM)
$("#confirmEditReason").on("click", function (e) {

    var edit_reason = $("#edit_reason").val().trim();

    if(edit_reason === ""){
        alert("Please enter reason for edit");
        return;
    }

    $("#editReasonModal").modal("hide");

    var transfer_check=$('#tr_check').val();
    var prev_user_name=prev_user_email='';

    if (transfer_check == 1) {
        prev_user_name=$('#prev_user_name').val();
        prev_user_email=$('#prev_user_email').val();
    }

    var register_as = $('#registered').val();

    var url = register_as == '16'
        ? '../../controllers/corporate_agency/edit_corporate_agency_data.php'
        : register_as == '29'
        ? '../../controllers/corporate_agency/edit_sub_franchisee_data.php'
        : register_as == '32'
        ? '../../controllers/corporate_agency/edit_institution_data.php'
        : '';

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

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

    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    var testE = $("#testemail").val();

    var birth_date_split = dob.split("-");
    var age = currentYear - birth_date_split[0];

    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var tcCount = $('input[name="official_purpose"]:checked').val();
    var selected_count = $('#selectedCount').text();

    let selectedIds = [];
    $('input[name="tc_ids[]"]:checked').each(function () {
        selectedIds.push($(this).val());
    });

    var tenure = $('input[name="tenure"]:checked').val();
    var roi = $('input[name="roi"]:checked').val();
    var tax = $('#taxAfterDeduction').val() || 0;
    var repayAmount = $('#repayAmount').val() || 0;

    var edit_reason_param = "&edit_reason=" + encodeURIComponent(edit_reason);

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
    } else if (age < 20) {
        alert("Age must be more than 20 Years");
    } else if (business_package == "") {
        alert("Select Business Package");
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
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (aadhar_card === "") {
        alert("Please Upload Aadhar Card Picture");
    } else if (pan_card === "") {
        alert("Please Upload Pan Card Picture");
    } else if (passbook === "") {
        alert("Please Upload Bank Passbook Picture");
    } else if (payment_proof == "") {
        alert("Enter Payment Proof");
    } else {

        var dataString =
            "editfor=" + editfor +
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
            "&note=" + note +
            "&tcCount=" + tcCount +
            "&selectedIds[]=" + selectedIds.join("&selectedIds[]=") +
            "&tenure=" + tenure +
            "&roi=" + roi +
            "&tax=" + tax +
            "&repayAmount=" + repayAmount +
            "&transfer_check=" + transfer_check +
            edit_reason_param;

        $("#editCorporateAgency").attr("disabled", "disabled");

        if (transfer_check == 1) {

            // Transfer workflow (same as BM)

            $("#editCorporateAgency")
                .removeClass("btn-primary")
                .addClass("btn-success")
                .prop("disabled", true);

            $("#transfer_te_f_i").prop("disabled", false);

            $("#te_f_i_form")
                .find("input, textarea, select, button")
                .not("#transfer_te_f_i")
                .prop("disabled", true);

        } else {

            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {

                    console.log(data);

                    $("#loading-overlay").hide();

                    if (data == 1) {
                        alert("Edit Successfuly");
                        location.href = "view_corporate_agency.php";
                    } else {
                        alert("Failed");
                    }
                }
            });

        }

    }

});


// Open reason modal first
$("#editCorporateAgency").click(function (e) {
    console.log('clicked');
    
    e.preventDefault();
    $("#editReasonModal").modal("show");

});
$("#transfer_te_f_i").click(function (e) {

    e.preventDefault();

    var transfer_check = $('#tr_check').val();

    if (transfer_check != 1) {
        alert("Please save changes first");
        return;
    }

    var prev_user_data = $('#prev_user_data').val();
    var register_as = $('#registered').val();
    var id = $("#id").val().trim();
    var email = $("#email").val().trim();
    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();
    var prev_user_email = $("#prev_user_email").val().trim();
    var prev_user_name = $("#prev_user_name").val().trim();
    var prev_user_doj = $("#prev_user_doj").val().trim();

    var dataString =
        "id=" + id +
        "&firstname=" + firstname +
        "&lastname=" + lastname +
        "&email=" + email +
        "&transfer_check=" + transfer_check +
        "&prev_user_email=" + prev_user_email +
        "&prev_user_name=" + prev_user_name +
        "&prev_user_doj=" + prev_user_doj +
        "&user_type=" + register_as +
        "&prev_user_data=" + encodeURIComponent(prev_user_data);

    $("#transfer_bm_sf_mf").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: "../../controllers/user_transfer/transfer_user_custom.php",
        data: dataString,
        success: function (data) {

            if (data == 1) {
                alert("Transfer Requested!");
                location.href = "view_corporate_agency.php";
            } else {
                alert("Transfer Failed");
            }

        }
    });

});