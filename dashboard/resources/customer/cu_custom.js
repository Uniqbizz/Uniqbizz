$(document).ready(function(){
    $("#example-dataTable").DataTable();
    $("#example-dataTable-2").DataTable();
});

function editfunc(id,cut,st,ct,editfor){
    window.location.href='edit_customer.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
};

function addRefFunc(id,taID,cut,st,ct,editfor){
    window.location.href='add_customer.php?vkvbvjfgfikix='+id+'&taId='+taID+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
};

function deletefunc(id,refid,action,userId,userType){
    var dataString = 'id='+id+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType

    $.ajax({
        type: "POST",
        url: "../controllers/customer/delete_customer_data.php",
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

function confirmfunc(id,email){ 
    var dataString = 'id='+ id+'&uname='+email;

    $.ajax({
        type: "POST",
        url: "customer/confirm_customer.php",
        data: dataString,
        cache: false,
        success:function(data){
            if(data == 1){
                alert("Email and Password sent via sms and email");
            window.location.reload();
        }
        else{

        alert("Failed to confirm");
        }
    }
    });
    
};

function overviewPage(id,ref,cut,st,ct,message){
    var designation = 'ca_customer';
    window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}