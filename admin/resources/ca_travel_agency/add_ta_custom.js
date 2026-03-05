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