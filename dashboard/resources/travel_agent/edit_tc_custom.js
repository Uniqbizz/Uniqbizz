$(document).ready(function(){

    var payment_fee = $("#payment_fee").val();
    console.log(payment_fee);
    if(payment_fee == "FOC"){
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
    }else if(payment_fee == "null"){
        $("#paymentModeBlock").addClass("d-none");
        $("#paymentFields").addClass("d-none");
    }else{
        $("#paymentModeBlock").removeClass("d-none");
        $("#paymentFields").removeClass("d-none");
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


$('#country').on('change', function(){
    var countryID = $(this).val();
    if(countryID){
        $.ajax({
            type:'POST',
            url:'../address/countrydata.php',
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
            url:'../address/countrydata.php',
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
            url:'../address/pincode.php',
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

$('#paymentMode').on('click', function(){
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