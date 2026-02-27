$(document).ready(function(){
    $("#example-dataTable").DataTable();
    $("#example-dataTable-2").DataTable();
});

function editfunc(id,cty,st,ct,zn,br,editfor){
    window.location.href='edit_business_mentor.php?id='+id+'&cty='+cty+'&st='+st+'&ct='+ct+'&zn='+zn+'&br='+br+'&editfor='+editfor;
};


function deletefunc(id,fid,action,userId,userType){
    var dataString = 'id='+id+'&fid='+fid+'&action='+action+'&userId='+userId+'&userType='+userType;    

    $.ajax({
        type: "POST",
        url: "../controllers/business_mentor/delete_business_mentor_data.php",
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

function overviewPage(id,ref,cty,st,ct,zn,br,message){
    var designation = 'business_mentor';
    //alert("Under Maintenance");
    window.location.href='overview.php?id='+id+'&ref='+ref+'&desig='+designation+'&zn='+zn+'&br='+br+'&message='+message+'&designation='+designation;
}