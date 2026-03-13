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

let registeAs=$('#registered').val()

if (registeAs == "24" || registeAs=="25" || registeAs=="31") {
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
}else if (registeAs == "27") {
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
}else {
    $('#emp_block, #zm_block').addClass('d-none');
}
// select Designation disable Reporting Manager
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    // console.log(designation);
    if (designation == 1) {
        $('#reporting_manager').prop('disabled', true);
    } else {
        $('#reporting_manager').prop('disabled', false);
    }
});

// on zone change get branch associated with that zone
$('#zone').on('change', function() {
    var zone_id = $(this).val();
    $.ajax({
        url: '../../assets/get_data/get_branch.php',
        type: 'POST',
        data: {
            zone_id: zone_id
        },
        success: function(data) {
            $('#branch').html(data);
        }
    });
});

// Edit Employee by admin
$("#confirmEditReason").click(function (e) {
    var edit_reason = $("#edit_reason").val().trim();

    if(edit_reason === ""){
        alert("Please enter reason for edit");
        return;
    }

    $("#editReasonModal").modal("hide");
    var transfer_check = $('#tr_check').val();
    var register_as=$('#registered').val();
    var prev_user_data=$('#prev_user_data').val();
    var url=''
    var country=state=city=pin=zonal=id_proof=bank_details=addar=pancard=department=designation=zone=branch=reporting_manager=joining_date='';
      
    if (register_as == '27'){
        url='../../controllers/employee/editZonalManagerData.php';
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
    }else if(register_as == '24' || register_as == '25'){
        url='../../controllers/employee/editEmployeeData.php';
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
    var id = $("#empID").val().trim();
    var name = $("#fullName").val().trim();
    var birth_date = $("#birth_date").val().trim();
    var country_cd = $("#country_cd").val().trim();
    var contact = $("#contact").val().trim();
    var email = $("#email").val().trim();
    var address = $("#address").val().trim();
    var gender = $(".gender:checked").val();
    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
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
    var edit_reason_param = "&edit_reason=" + encodeURIComponent(edit_reason);
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
    } else if (country === "" && register_as == '27') {
        alert("Please Select Country");
    }else if (state === "" && register_as == '27') {
        alert("Please Select State");
    }else if (city === "" && register_as == '27') {
        alert("Please Select City");
    }else if (zonal === "" && register_as == '27') {
        alert("Please Select Zone");
    } else if (joining_date === "" && (register_as == '24' || register_as == '25')) {
        alert("Please Select Joining date");
    } else if (joining > 20 && (register_as == '24' || register_as == '25')) {
        alert("Joining date can not be more than 20 Years");
    } else if (department === "" && (register_as == '24' || register_as == '25')) {
        alert("Please Select department");
    } else if (designation === "" && (register_as == '24' || register_as == '25')) {
        alert("Please Select designation");
    } else if (zone === "" && (register_as == '24' || register_as == '25')) {
        alert("Please Select zone");
    } else if (branch === "" && (register_as == '24' || register_as == '25')) {
        alert("Please Select branch");
    } else if (profile_pic === "") {
        alert("Please Upload profile Picture");
    } else if (id_proof === "" && (register_as == '24' || register_as == '25')) {
        alert("Please provide valid id proof");
    } else if (addar === "" && register_as == '27') {
        alert("Please provide valid id proof");
    } else if (pancard === "" && register_as == '27') {
        alert("Please provide valid id proof");
    } else if (bank_details === "") {
        alert("Please provide correct bank details");
    } else {
        var dataString =
            "id=" +id +
            "&name=" + name +
            "&birth_date=" + birth_date +
            "&country_cd=" + country_cd +
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
            "&ref_id=" + ref_id +
            "&editfor=" + editfor +
            "&note=" + note+
            "&transfer_check="+transfer_check+
            "&user_type="+register_as+
            "&prev_user_data="+encodeURIComponent(prev_user_data)+
            edit_reason_param;

        console.log(dataString);
        $("#edit_employee").attr("disabled", "disabled");
        if (transfer_check == 1) {

            // Transfer workflow
            $("#edit_employee")
                .removeClass("btn-primary")
                .addClass("btn-success")
                .prop("disabled", true);

            $("#transfer_employee").prop("disabled", false);

            // Disable entire form fields
            $("#employee_form")
                .find("input, textarea, select, button")
                .not("#transfer_employee")
                .prop("disabled", true);

        } else {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        alert("Edited Successfully");
                        location.href = "employee.php";

                    } else {
                        alert("Failed");
                    }
                },
            });
        }
        
    }
});
$("#edit_employee").click(function (e) {

    e.preventDefault();

    // show modal first
    $("#editReasonModal").modal("show");

});
//Transfer employee
$("#transfer_employee").click(function (e) {

    e.preventDefault();

    var transfer_check = $('#tr_check').val();

    if (transfer_check != 1) {
        alert("Please save changes first");
        return;
    }

    var prev_user_data = $('#prev_user_data').val();
    var register_as = $('#registered').val();
    var id = $("#empID").val().trim();
    var email = $("#email").val().trim();
    var name = $("#fullName").val().trim();
    var prev_user_email = $("#prev_user_email").val().trim();
    var prev_user_name = $("#prev_user_name").val().trim();
    var prev_user_doj = $("#prev_user_doj").val().trim();

    var dataString =
        "id=" + id +
        "&name=" + name +
        "&email=" + email +
        "&transfer_check=" + transfer_check +
        "&prev_user_email=" + prev_user_email +
        "&prev_user_name=" + prev_user_name +
        "&prev_user_doj=" + prev_user_doj +
        "&user_type=" + register_as +
        "&prev_user_data=" + encodeURIComponent(prev_user_data);

    $("#transfer_employee").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: "../../controllers/user_transfer/transfer_user_custom.php",
        data: dataString,
        success: function (data) {

            if (data == 1) {
                alert("Transfer Requested!");
                location.href = "employee.php";
            } else {
                alert("Transfer Failed");
            }

        }
    });

});