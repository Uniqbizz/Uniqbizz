$(document).ready(function() {
    $("#example-dataTable").DataTable();
    $("#example-dataTable-2").DataTable();
    $('.rejectMess').click(function () {
        var createdDate=$(this).data("created-date");
        var usersId=$(this).data("user-id");
        $.ajax({
            url:"travel_agent/getRejectReason.php",
            type:"POST",
            data:{createdDate:createdDate,usersId:usersId},
            success:function(response){
            $('#floatingTextarea').text(response);
            $("#rejectTopup").modal("show");
            } 
        });
        
    });
});