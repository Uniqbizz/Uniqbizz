function editfuncCat(id)
{ 
    window.location.href='../../views/category/edit_category.php?vkvbvjfgfikix='+id;  
};

function editfuncSubCat(id)
{ 
    window.location.href='../../views/category/edit_sub_category.php?vkvbvjfgfikix='+id;  
};

function deletefunc(id)
{ 

    var dataString = 'id='+ id;

    var r = confirm("Do you want to delete the Category?");
    if (r == true) {

            $.ajax({
            type: "POST",
            url: "../../models/category/delete_category.php",
            data: dataString,
            cache: false,
            success:function(data){
                if(data == 1){

                alert("Delete Succesfully");
                window.location.reload();
            }
            else{

            alert("Deletion Failed");
            }
        }
        });
        
    } else {
        
    }   
};


function deletefuncSub(id)
{ 

    var dataString = 'id='+ id;

    var r = confirm("Do you want to delete the Sub Category?");
    if (r == true) {

            $.ajax({
            type: "POST",
            url: "../../views/category/delete_sub_category.php",
            data: dataString,
            cache: false,
            success:function(data){
                if(data == 1){

                alert("Delete Succesfully");
                window.location.reload();
            }
            else{

            alert("Deletion Failed");
            }
        }
        });
        
    } else {
        
    }   
    
};