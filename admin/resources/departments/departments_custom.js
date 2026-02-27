//on closing form refresh page values to not pass on next form
$('[data-bs-dismiss="modalAdd"]').on('click', function(){
    window.location.reload();
});
$('[data-bs-dismiss="modalEdit"]').on('click', function(){
    window.location.reload();
});
$('[data-bs-dismiss="modalDelete"]').on('click', function(){
    window.location.reload();
});

//add Designation
$('#submitAdd').click(function(e){
    e.preventDefault();

    let desig_name = $('#desig_name').val();
    let dept_id = $('#dept_id').val();

    if(desig_name == '' || dept_id == ''){
        alert('Enter Designation name');
    }else{
        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/addDesignation.php',
            data: 'desig_name='+desig_name+'&dept_id='+dept_id,
            cache: false,
            success: function(data){
                if(data == 1){
                    // console.log("Designation Added");
                    alert("Designation Added");
                    window.location.reload();
                }else{
                    // console.log("Failed To Added");
                    alert("Failed To Added");
                    window.location.reload();
                }
            }
        });
    }
});

//edit Designation
function saveDesig(id, desig_name, dept_id, dept_name, message, status){

    var id = id;
    var desig_name = desig_name;
    var dept_id = dept_id;
    var dept_name = dept_name;
    var message = message;
    var status = status;

    // var datastring2 = {id,desig_name,dept_id,dept_name,message,status}
    // console.log(datastring2);

    var save_desig_name = document.querySelector('#save_desig_name');
    save_desig_name.value = desig_name;
    var dept_saved_name = document.querySelector('#dept_saved');
    dept_saved_name.value = dept_name;

    $('#submitEdit').click(function(e){
        e.preventDefault();
        let desig_name_save = $('#save_desig_name').val().trim();
        let dept_id_save = $('#dept_id_save').val().trim();

        //both ways work data passing in ajax
        // var datastring = 'id='+id+'&saveDeptName='+saveDeptName+'&message='+message+'&status='+status;
        var datastring = {id,desig_name_save,dept_id_save,message,status}

        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/editDesignation.php',
            data: datastring,
            cache: false,
            success: function(data){
                if(data == '1'){
                    alert('Edit Successful');
                    window.location.reload();
                }else{
                    alert('Edit Failed');
                    window.location.reload();
                }
            }
        });
    });
}

//delete Designation
function deleteDesig(id, desig_name, dept_id, dept_name, message, status){
    var id = id;
    var desig_name = desig_name;
    var dept_id = dept_id;
    var dept_name = dept_name;
    var message = message;
    var status = status;

    $('#submitDelete').click(function(e){
        e.preventDefault();

        var datastring = {id,desig_name,dept_id,dept_name,message,status};

        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/deleteDesignation.php',
            data: datastring,
            cache: false,
            success: function(data){
                if(data == '1'){
                    alert('Edit Successful');
                    window.location.reload();
                }else{
                    alert('Edit Failed');
                    window.location.reload();
                }
            }
        });
    });
}

//on closing form refresh page values to not pass on next form
$('[data-bs-dismiss="modalAdd"]').on('click', function(){
    window.location.reload();
});
$('[data-bs-dismiss="modalEdit"]').on('click', function(){
    window.location.reload();
});
$('[data-bs-dismiss="modalDelete"]').on('click', function(){
    window.location.reload();
});

//add department
$('#submit').click(function(e){
    e.preventDefault();
    let deptName = $('#name').val();
    if(deptName == ''){
        alert('Enter Department name');
    }else{
        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/addDepartment.php',
            data: 'name='+deptName,
            cache: false,
            success: function(data){
                if(data == 1){
                    // console.log("Department Added");
                    alert("Department Added");
                    window.location.reload();
                }else{
                    // console.log("Failed To Added");
                    alert("Failed To Added");
                    window.location.reload();
                }
            }
        });
    }
});

//edit department
function saveDept(id, name, message, status){

    var id = id;
    var name = name;
    var message = message;
    var status = status;

    var save_name = document.querySelector('#save_dept_name');
    save_name.value = name;

    $('#submitDept').click(function(e){
        e.preventDefault();
        var saveDeptName = $('#save_dept_name').val().trim();

        //both ways work data passing in ajax
        // var datastring = 'id='+id+'&saveDeptName='+saveDeptName+'&message='+message+'&status='+status;
        var datastring = {id,saveDeptName,message,status}

        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/editDepartment.php',
            data: datastring,
            cache: false,
            success: function(data){
                if(data == '1'){
                    alert('Edit Successful');
                    window.location.reload();
                }else{
                    alert('Edit Failed');
                    window.location.reload();
                }
            }
        });
    });
}

//delete Department
function deleteDept(id, name, message, status){
    var id = id;
    var name = name;
    var message = message;
    var status = status;

    $('#deleteDept').click(function(e){
        e.preventDefault();

        var datastring = {id,name,message,status};

        $.ajax({
            type: 'POST',
            url: '../../controllers/departments/deleteDepartment.php',
            data: datastring,
            cache: false,
            success: function(data){
                if(data == '1'){
                    alert('Edit Successful');
                    window.location.reload();
                }else{
                    alert('Edit Failed');
                    window.location.reload();
                }
            }
        });
    });
}