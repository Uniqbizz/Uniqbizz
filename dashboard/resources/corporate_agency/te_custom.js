$(document).ready(function(){
    $("#example-dataTable").DataTable();
    $("#example-dataTable-2").DataTable();
});

function editfunc(id,cut,regby,country,st,ct,editfor,edittype){
    window.location.href='edit_corporate_agency.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&regby='+regby+'&mst='+st+'&hct='+ct+'&country='+country+'&editfor='+editfor+'&edittype='+edittype;
};

function deletefunc(id,fid,refid,action,userId,userType){
    var dataString = 'id='+id+'&fid='+fid+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType;
    var url='';
    if (userType == '29') {
        url="../controllers/corporate_agency/delete_franchisee_data.php";
    }else if(userType =='16'){
        url="corporate_agency/delete_corporate_agency_data.php";
    }
    $.ajax({
        type: "POST",
        url: url,
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
    var designation =message= '';
    if(id.startsWith('F')){
        designation ='Franchisee'
        message= 'sub_franchisee';
    }else{
        designation ='Techno Enterprise'
        message= 'corporate_agency';
        
    }
    window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
}