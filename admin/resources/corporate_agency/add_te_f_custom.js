
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
//select Register as
$('#registered').on('change',function(){
    var register_type=$(this).val();
    if(register_type == 'corporate_agency'){
        $('#designation1').prop('disabled', false);
        $('#designation1').removeClass('d-none');
        $('#designation2').addClass('d-none');
        $('#business_package_amount1').prop('disabled', false);
        $('#business_package_amount1').removeClass('d-none');
        $('#business_package_amount2').addClass('d-none');
    }else if(register_type == 'sub_franchisee'){
        $('#designation1').addClass('d-none');
        $('#designation2').removeClass('d-none');
        $('#business_package_amount2').removeClass('d-none');
        $('#business_package_amount1').addClass('d-none');
    }else if(register_type == 'institution'){
        $('#designation1').addClass('d-none');
        $('#designation2').removeClass('d-none');
        $('#business_package_amount2').removeClass('d-none');
        $('#business_package_amount1').addClass('d-none');
        const val = $("#test5").val();

        $('.gender[value="' + val + '"]').prop('checked', true);
        $('.gender').prop('disabled', true);
    }
});

//select Designation
$('#designation1').on('change', function() {
    var designation = $('#designation1').val();
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
    var designation = !$('#designation1').hasClass('d-none') 
    ? $('#designation1').val() 
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
});

$('#city').on('change', function(){
    var cityID = $(this).val();
    if(cityID){
        $.ajax({
            type:'POST',
            url:'../../address/pincode.php',
            data:'city_id='+cityID,
            success:function(response){
                // $('#pin').html(response);
                $('#pin').val(response); 
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});

$('#business_package_amount1').on('change', function(){
    var business_package_amount = $(this).val();
    $('#flex_amount').val(business_package_amount);
});

$('#business_package_amount2').on('change', function(){
    var business_package_amount = $(this).val();
    $('#flex_amount').val(business_package_amount);
});


$('#paymentMode').on('click', function(){
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
    if(paymentMode == "cheque"){
        $("#chequeOpt").removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $("#transactionNo").val("");
    }else if(paymentMode == "online"){
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

$("#addCorporateAgency").on("click", function (e) {
    e.preventDefault();
    var transfer_check=$('#tr_check').val();
    var register_as = $('#registered').val();
    var url = register_as == 'corporate_agency'
    ? '../../controllers/corporate_agency/add_corporate_agency_data.php'
    : register_as == 'sub_franchisee'
        ? '../../controllers/corporate_agency/add_sub_franchisee_data.php'
        : register_as == 'institution' 
            ? '../../controllers/corporate_agency/add_institution_data.php'
            : '';
    // console.log('Add customer button clicked');

    //var designation = $("#designation").val() ? "travel_agent" : "";
    var converted = $('#is_converted').is(':checked') ? 1 : 2;//1 converted 2 non converted
    var user_id_name = $("#user_id_name").val() == 'NA' ? 'Not Applicable' :  $("#user_id_name").val();
    var reference_name = $("#reference_name").val() == 'NA' ? 'Not Applicable' :  $("#reference_name").val();

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

    if (register_as == "") {
        alert("Select Registration Type");
    }else if (reference_name == "") {
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
            "&user_id_name=" +
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
            "&amount=" +
            business_package +
            "&gst_no=" +
            gst_no +
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
            "&note=" +
            note+
            "&converted="+
            converted+
            "&transfer_check="+transfer_check;
        console.log(dataString);

        if (validateForm()) {
            $("#addCorporateAgency").attr("disabled", "disabled");
            // console.log(dataString);
            $("#loading-overlay").show(); //loading screen
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    console.log(data);
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
    }
});