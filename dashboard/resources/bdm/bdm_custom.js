 $(document).ready(function(){
    $("#example-dataTable").DataTable();
    $("#example-dataTable-2").DataTable();
});

function editfunc(id,dept,desig,zn,br,editfor){
    window.location.href='edit_business_development_manager.php?vkvbvjfgfikix='+id+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&editfor='+editfor;
};

function deletefunc(id,fid,action,userId,userType){
    var dataString = 'id='+id+'&fid='+fid+'&action='+action+'&userId='+userId+'&userType='+userType;

    $.ajax({
        type: "POST",
        url: "../controllers/business_development_manager/delete_business_development_manager_data.php",
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

function overviewPage(id,ref,dept,desig,zn,br,message){
    var designation = 'business_developement_manager';
    //alert("Under Maintenance");
    window.location.href='overview.php?id='+id+'&ref='+ref+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&message='+message+'&designation='+designation;
}