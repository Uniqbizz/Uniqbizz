$(document).ready(function(){
    $("#example-dataTable").DataTable({
        language: {
            emptyTable: "No Pending Users"
        }
    });

    $("#example-dataTable-2").DataTable({
        language: {
            emptyTable: "No Registered Users"
        }
    });
});

function editfunc(id,cut,st,ct,editfor){
    window.location.href='edit_travel_agent.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
};

function deletefunc(id,fid,refid,action,userId,userType){
    var dataString = 'id='+id+'&fid='+fid+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType;
                    
    $.ajax({
        type: "POST",
        url: "../controllers/travel_agent/delete_travel_agent_data.php",
        data: dataString,
        cache: false,
        success:function(data){
            console.log(data);
            if( data == 0 ){
                alert("Deleted Succesfully");
                window.location.reload();
            }else if( data == 1 ){
                alert("User Activated Succesfully");
                window.location.reload();
            }else if( data == 2 ){
                alert("User Restored Succesfully");
                window.location.reload();
            }else if( data == 3 ){
                alert("User Deactivated Succesfully");
                window.location.reload();
            } else {
                alert("Request Failed !!");
            }
        }
    });
};

function overviewPage(id,ref,cut,st,ct,message){
    var designation = 'Travel Consultant';
    window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}