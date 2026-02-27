let cachedEmpBlock = null;
let cachedZmBlock = null;

$('#registered').on('change', function () {
    const selected = $(this).val();

    if (selected === "employee") {
        // Detach ZM block and cache it
        if (!cachedZmBlock && $('#zm_block').length) {
            cachedZmBlock = $('#zm_block').detach();
        }

        // Re-attach emp block if cached
        if (cachedEmpBlock) {
            $('#formParent').append(cachedEmpBlock);
            cachedEmpBlock = null;
        }

        $('#emp_block').removeClass('d-none');
    }
    else if (selected === "zonal_manager") {
        // Detach emp block and cache it
        if (!cachedEmpBlock && $('#emp_block').length) {
            cachedEmpBlock = $('#emp_block').detach();
        }

        // Re-attach zm block if cached
        if (cachedZmBlock) {
            $('#formParent').append(cachedZmBlock);
            cachedZmBlock = null;
        }

        $('#zm_block').removeClass('d-none');
    }
    else {
        $('#emp_block, #zm_block').addClass('d-none');
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
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'city_id='+cityID,
            success:function(html){
                $('#zonal').html(html);
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});



// on zone change get branch associated with that zone Employee section 
$('#zone').on('change', function(){
    var zone_id = $(this).val();
    $.ajax({
        url: '../../assets/get_data/get_branch.php',
        type: 'POST',
        data: {zone_id:zone_id},
        success: function(data){
            $('#branch').html(data);
        }
    });
});