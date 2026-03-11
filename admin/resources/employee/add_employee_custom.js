let cachedEmpBlock = null;
let cachedZmBlock = null;

$("#email").keyup(function () {
    var email = $("#email").val().trim();
    var testValue = $("#testValue").val().trim();
    emailtest(email, testValue);
});

var emailtest = (emailtest, testValue) => {
    $.ajax({
        type: "POST",
        url: "../../test_data/emailtest.php",
        data: "email=" + emailtest + "&tablename=" + testValue,
        success: function (response) {
            if (response == 1) {
                $("#testemails").html(
                    '<input type="hidden"  id="testemail" value="1" >'
                );
            } else {
                $("#testemails").html(
                    '<input  type="hidden" id="testemail" value="0" >'
                );
                // return false;
            }
        },
    });
};

$('#registered').on('change', function () {
    const selected = $(this).val();

    if (selected === "employee") {
        // Detach ZM block and cache it
        if (!cachedZmBlock && $('#zm_block').length) {
            cachedZmBlock = $('#zm_block').detach();
        }

        // Re-attach emp block if cached
        if (cachedEmpBlock) {
            $('#formParent').append(cachedEmpBlock);
            cachedEmpBlock = null;
        }

        $('#emp_block').removeClass('d-none');
    }
    else if (selected === "zonal_manager") {
        // Detach emp block and cache it
        if (!cachedEmpBlock && $('#emp_block').length) {
            cachedEmpBlock = $('#emp_block').detach();
        }

        // Re-attach zm block if cached
        if (cachedZmBlock) {
            $('#formParent').append(cachedZmBlock);
            cachedZmBlock = null;
        }

        $('#zm_block').removeClass('d-none');
    }
    else {
        $('#emp_block, #zm_block').addClass('d-none');
    }
});


$('#country').on('change', function(){
    var countryID = $(this).val();
    if(countryID){
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'country_id='+countryID,
            success:function(htmll){
                $('#mystate').html(htmll); 
                $('#city').html('<option value="">Select state first</option>'); 
            }
        }); 
    }else{
        $('#mystate').html('<option value="">Select country first</option>');
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');   
    }
});
    
$('#mystate').on('change', function(){
    var stateID = $(this).val();
    if(stateID){
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'state_id='+stateID,
            success:function(html){
                $('#city').html(html);
            }
        }); 
        
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');   
    }
});

$('#city').on('change', function(){
    var cityID = $(this).val();
    if(cityID){
        $.ajax({
            type:'POST',
            url:'../../address/pincode.php',
            data:'city_id='+cityID,
            success:function(response){
                $('#pin').val(response); 
            }
        }); 
        $.ajax({
            type:'POST',
            url:'../../address/countrydata.php',
            data:'city_id='+cityID,
            success:function(html){
                $('#zonal').html(html);
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>');
        $('#pin').val('');
    }
});



// on zone change get branch associated with that zone Employee section 
$('#zone').on('change', function(){
    var zone_id = $(this).val();
    $.ajax({
        url: '../../assets/get_data/get_branch.php',
        type: 'POST',
        data: {zone_id:zone_id},
        success: function(data){
            $('#branch').html(data);
        }
    });
});
// Add Employee by admin
$("#add_employee").click(function (e) {
    e.preventDefault();
    var transfer_check =$('#tr_check').val();
    var register_as=$('#registered').val();
    var url=''
    var country=state=city=pin=zonal=id_proof=bank_details=addar=pancard=department=designation=zone=branch=reporting_manager=joining_date='';
      
    if (register_as == 'zonal_manager'){
        url='../../controllers/employee/addZonalManagerData.php';
        country=$('#country').val();
        state=$('#mystate').val();
        city=$('#city').val();
        pin=$('#pin').val();
        zonal=$('#zonal').val();
        id_proof = 'NA';
        addar= $(":hidden#img_path2").val().trim();
        pancard= $(":hidden#img_path3").val().trim();
        bank_details = $(":hidden#img_path4").val().trim();
        joining_date = 'NA';
        department = 'NA';
        designation = 'NA';
        zone = 'NA';
        branch = 'NA';
        reporting_manager = 'NA';
    }else if(register_as == 'employee'){
        url='../../controllers/employee/addEmployeeData.php';
        country='NA';
        state='NA';
        city='NA';
        pin='NA';
        zonal='NA';
        id_proof= $(":hidden#img_path2").val().trim();
        addar= 'NA';
        pancard= 'NA';
        bank_details = $(":hidden#img_path3").val().trim();
        joining_date = $("#joining_date").val().trim();
        department = $("#department").val().trim();
        designation = $("#designation").val().trim();
        zone = $("#zone").val().trim();
        branch = $("#branch").val().trim();
        reporting_manager = $("#reporting_manager").val().trim();
    }
    var name = $("#fullName").val().trim();
    var birth_date = $("#birth_date").val().trim();
    var country_cd = $("#country_cd").val().trim();
    var contact = $("#contact").val().trim();
    var email = $("#email").val().trim();
    var address = $("#address").val().trim();
    var gender = $(".gender:checked").val();
    var profile_pic = $(":hidden#img_path1").val().trim();
    
   

    //if note is empty
    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    // var testp= $('#testphone').val();
    var testE = $("#testemail").val();

    //age calculation
    var birth_date_split = birth_date.split("-");
    var age = currentYear - birth_date_split[0];
    // console.log(age);

    //joining date calculation
    var joining_date_split = joining_date.split("-");
    var joining = currentYear - joining_date_split[0];
    // console.log(joining);

    var characterLetters = /^[A-Za-z\s]+$/;
    var phoneReg = /^[0-9]{10}$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var specialChar = /[!@#$%^&*]/g;

    if (name === "" || name.length <= 2) {
        alert("Enter Proper Name");
    } else if (birth_date === "") {
        alert("Choose Correct Birth date");
    } else if (age < 20) {
        alert("Age must be more than 20 Years");
    } else if (contact === "") {
        alert("Please enter contact number");
    } else if (!phoneReg.test(contact)) {
        alert("Contact Number Must be 10 Digit");
    } else if (email == "") {
        alert("Enter Email");
    } else if (!emailReg.test(email)) {
        alert("Enter Proper Email");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (address === "") {
        alert("Please Enter address");
    } else if (gender !== "male" && gender !== "female" && gender !== "others") {
        alert("Please Select Gender");
    }else if (country === "" && register_as == 'zonal_manager') {
        alert("Please Select Country");
    }else if (state === "" && register_as == 'zonal_manager') {
        alert("Please Select State");
    }else if (city === "" && register_as == 'zonal_manager') {
        alert("Please Select City");
    }else if (zonal === "" && register_as == 'zonal_manager') {
        alert("Please Select Zone");
    } else if (joining_date === "" && register_as == 'employee') {
        alert("Please Select Joining date");
    } else if (joining > 20 && register_as == 'employee') {
        alert("Joining date can not be more than 20 Years");
    } else if (department === "" && register_as == 'employee') {
        alert("Please Select department");
    } else if (designation === "" && register_as == 'employee') {
        alert("Please Select designation");
    } else if (zone === "" && register_as == 'employee') {
        alert("Please Select zone");
    } else if (branch === "" && register_as == 'employee') {
        alert("Please Select branch");
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (id_proof === "" && register_as == 'employee') {
        alert("Please provide valid id proof");
    } else if (addar === "" && register_as == 'zonal_manager') {
        alert("Please provide valid id proof");
    } else if (pancard === "" && register_as == 'zonal_manager') {
        alert("Please provide valid id proof");
    } else if (bank_details === "") {
        alert("Please provide correct bank details");
    } else {
       var dataString =
        "name=" + name +
        "&birth_date=" + birth_date +
        "&country_cd=" + country_cd+
        "&contact=" + contact +
        "&email=" + email +
        "&address=" + address +
        "&gender=" + gender +
        "&joining_date=" + joining_date +
        "&department=" + department +
        "&designation=" + designation +
        "&zone=" + zone +
        "&branch=" + branch +
        "&reporting_manager=" + reporting_manager +
        "&profile_pic=" + profile_pic +
        "&id_proof=" + id_proof +
        "&addar=" + addar +
        "&pancard=" + pancard +
        "&bank_details=" + bank_details +
        "&country=" + country +
        "&state=" + state +
        "&city=" + city +
        "&pin=" + pin +
        "&zonal=" + zonal +
        "&note=" + note+
        "&transfer_check="+
        transfer_check;

        //console.log(dataString);
        $("#add_employee").attr("disabled", "disabled");

        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
            success: function (data) {
                if (data == 1) {
                    alert("Added Successfully");
                    location.href = "employee.php";
                } else {
                    alert("Failed");
                }
            },
        });
    }
});