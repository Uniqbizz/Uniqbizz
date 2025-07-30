 $('#zone_name').on('change', function(){
        var zoneID = $(this).val();
        if(zoneID){
            $.ajax({
                type:'POST',
                url:'../address/office',
                data:'zone_id='+zoneID,
                success:function(htmll){
                    

                    $('#region_name').html(htmll); 
                      $('#branch_name').html('<option value="">Select region first</option>'); 

                    
                }
            }); 
        }else{
            $('#region_name').html('<option value="">Select zone first</option>');
            $('#branch_name').html('<option value="">Select region first</option>');

        }
        });
        
        $('#region_name').on('change', function(){
            // alert();
            var regionID = $(this).val();
            if(regionID){
                $.ajax({
                    type:'POST',
                    url:'../address/office',
                    data:'region_id='+regionID,
                    success:function(html){
                        $('#branch_name').html(html);
                       
                    }
                }); 
            }else{
                $('#branch_name').html('<option value="">Select region first</option>');

            }
        });