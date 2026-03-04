
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