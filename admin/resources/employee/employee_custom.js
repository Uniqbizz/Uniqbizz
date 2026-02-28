$(document).ready(function(){
    $("#pendingCustomerList-table").DataTable();
    $("#registeredCustomerList-table").DataTable();
    $("#deletedCustomerList-table").DataTable();
});

function editfuncCust(id,refno,regby,dept,desig,zn,br,editfor,usertype){ 
    window.location.href='../../views/employee/editEmployee.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&editfor='+editfor+'&usertype='+usertype;
};

function deletefunc(id,fid,action,userType){ 
    var dataString = 'id='+id+'&fid='+fid+'&action='+action+'&userType='+userType;

    $.ajax({
    type: "POST",
    url: "../../controllers/employee/deleteEmployee.php",
    data: dataString,
    cache: false,
        success:function(data){
            // console.log('data'+data);
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

function confirmfunc(id,email,usertype){ 

    var dataString = 'id='+ id+'&uname='+email+'&usertype='+usertype;
    $("#loading-overlay").show(); //loading screen
    $.ajax({
        type: "POST",
        url: "../../controllers/employee/confirmEmployee.php",
        data: dataString,
        cache: false,
        success:function(data){
            if(data == 1){
                $("#loading-overlay").hide(); //loading screen
                alert("Email and Password sent via sms and email");
                window.location.reload();
            }
            else{
                $("#loading-overlay").hide(); //loading screen
                alert("Failed to confirm");
            }
        }
    });
    
};

function overviewPage(id,ref,dept,desig,zn,br,message,userType){
    if (userType == "24") {
        var designation = 'business_chanel_manager';
        message='business_chanel_manager';
    }else if (userType == "25"){
        var designation = 'business_developement_manager';
        message='business_developement_manager';

    }else if(userType =="27"){
        var designation = 'zonal_manager';
        message='zonal_manager'; 
    }else if (userType == "31"){
        var designation = 'relationship_manager';
        message='relationship_manager';

    }
    window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&message='+message+'&designation='+designation;
}