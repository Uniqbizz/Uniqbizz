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

$(document).ready(function(){
    var registered = $("#registered").val();
    if(registered == 'bm'){
        $('#payment_fee').removeClass('d-none');
        $('#payment_fee2').addClass('d-none');
    }else if(registered == 'mf'){
        $('#payment_fee').addClass('d-none');
        $('#payment_fee2').removeClass('d-none');
    }else if(registered == 'sf'){
        $('#payment_fee').addClass('d-none');
        $('#payment_fee2').removeClass('d-none');
    }
    
    var paymentMode = $(".payment:checked").val();
    if(paymentMode == "cheque"){
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
    }else if(paymentMode == "online"){
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
    } else {
        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
    }
});
$('#paymentMode').on('click', function() {
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
    $.ajax({
        type:'POST',
        url:'../../agents/get_user_Franchisee.php',
        data: "designation="+designation,
        success:function (e) {
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
    var designation = $('#designation').val();

    $.ajax({
        type:'POST',
        url:'../../agents/getUsers.php',
        data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
        success:function(response){
            $('#pin').html(response);
            $('#reference_name').val(response); 
        }
    }); 
    
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
// on zone change get branch associated with that zone
$('#zone').on('change', function() {
    var zone_id = $(this).val();
    $.ajax({
        url: '../../assets/get_data/get_branch.php',
        type: 'POST',
        data: {
            zone_id: zone_id
        },
        success: function(data) {
            $('#branch').html(data);
        }
    });
});
//to hide show payment sections
$('#payment_fee').on('change', function(){
    var paytype=$('#payment_fee').val();
    if (paytype !='FOC') {
        $('#paymentModeBlock').removeClass("d-none"); 
        $('#payProof').removeClass("d-none"); 
    }else {
        $('#paymentModeBlock').addClass("d-none"); 
        $('#payProof').addClass("d-none"); 
    }
});
//to hide show payment sections
$('#payment_fee2').on('change', function(){
    var paytype=$('#payment_fee2').val();
    if (paytype !='FOC') {
        $('#paymentModeBlock').removeClass("d-none"); 
        $('#payProof').removeClass("d-none"); 
    }else {
        $('#paymentModeBlock').addClass("d-none"); 
        $('#payProof').addClass("d-none"); 
    }
});
//payment details
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

// Edit Business Mentor by admin
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
    var url = register_as == '26' ? '../../controllers/business_mentor/editBusinessMentorData.php' 
            : register_as == '28' ? '../../controllers/business_mentor/editMasterFranchiseeData.php' 
            : register_as == '30' ? '../../controllers/business_mentor/editSponsorFranchiseeData.php' 
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

    if (register_as == "30"){
        payment_fee = $("#payment_fee2").val().trim();
    }else if(register_as == "28"){
        payment_fee = $("#payment_fee2").val().trim();
    }else{
        payment_fee = $("#payment_fee").val().trim();
    }
    
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
    function getNumericValue() {
        let feeInput = document.getElementById("payFee").value;
        return feeInput.replace(/[^\d]/g, ""); // Removes everything except numbers
    }
    // var payment_fee =getNumericValue();
    if (reference_name == "") {
        alert("Select Referance name");
    } else if (firstname === "") {
        alert("Enter Proper First Name");
    } else if (lastname === "") {
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
    } else if (zone === "") {
        alert("Please Select zone");
    } else if (branch === "") {
        alert("Please Select branch");
    } else if (payment_fee == "null") {
        alert("Please Select Payment Fee");
    } else if (!paymentMode || !["cash", "cheque", "online", "free"].includes(paymentMode.toLowerCase())) {
        alert('Please select a valid payment mode');
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (aadhar_card === "") {
        alert("Please Upload Aadhar Card Picture");
    } else if (pan_card === "") {
        alert("Please Upload Pan Card Picture");
    } else if (passbook === "") {
        alert("Please Upload Bank Passbook Picture");
    } else if (!paymentMode || (["cash", "cheque", "online"].includes(paymentMode.toLowerCase()) && payment_proof === "")) {
        alert("Enter Payment Proof");
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
            "&zone=" +
            zone +
            "&branch=" +
            branch +
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
            "&payment_fee="
            + payment_fee +
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
            "&note=" +
            note+
            "&transfer_check="+transfer_check+
            edit_reason_param;
        // console.log(dataString);

        $("#editBuisnessMentor").attr("disabled", "disabled");
        if (transfer_check == 1) {
            // Transfer workflow
            $("#editBuisnessMentor")
                .removeClass("btn-primary")
                .addClass("btn-success")
                .prop("disabled", true);

            $("#transfer_bm_sf_mf").prop("disabled", false);

            // Disable entire form fields
            $("#bm_mf_sf_form")
                .find("input, textarea, select, button")
                .not("#transfer_bm_sf_mf")
                .prop("disabled", true);
        }else{
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    console.log(data);
                    if (data == 1) {
                        $("#loading-overlay").hide(); //loading screen
                        alert("Edit Successfuly");
                        location.href = "businessMentor.php";
                    } else {
                        $("#loading-overlay").hide(); //loading screen
                        alert("Failed");
                    }
                },
            });
        }
        
    }
});
$("#editBuisnessMentor").click(function (e) {

    e.preventDefault();

    // show modal first
    $("#editReasonModal").modal("show");

});
//Transfer bm/sf/mf
$("#transfer_bm_sf_mf").click(function (e) {

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
                location.href = "businessMentor.php";
            } else {
                alert("Transfer Failed");
            }

        }
    });

});