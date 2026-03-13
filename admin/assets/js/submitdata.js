$(function () {
    console.log("4555-------1111 Data");
});

//age calculation
var today = new Date();
var currentYear = today.getFullYear();
// console.log(year);

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

function validateForm() {
    var pay_mode = $(".payment:checked").val();
    var cheque_no = $("#chequeNo").val().trim();
    var cheque_date = $("#chequeDate").val().trim();
    var bank_name = $("#bankName").val().trim();
    var transaction_id = $("#transactionNo").val().trim();
    var ref_img = $("#img_path6").val();

    if (!pay_mode) {
        alert("Select Payment Mode");
        return false;
    }

    if (pay_mode === "cash" && ref_img === "") {
        alert("Upload the payment proof");
        return false;
    }

    if (pay_mode === "cheque") {
        if (cheque_no === "") {
            alert("Enter Cheque number");
            return false;
        }
        if (cheque_date === "") {
            alert("Enter Cheque date");
            return false;
        }
        if (bank_name === "") {
            alert("Enter bank name");
            return false;
        }
        if (ref_img === "") {
            alert("Upload the payment proof");
            return false;
        }
    }

    if (pay_mode === "online") {
        if (transaction_id === "") {
            alert("Enter Transaction id");
            return false;
        }
        if (ref_img === "") {
            alert("Upload the payment proof");
            return false;
        }
    }

    return true; // All validations passed
}

// @@@@****#### Head Office start by admin @@@@****####
// Add Head Office by admin
$("#addHeadOffice").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addHeadOffice").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "head_office/add_head_office_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_head_office.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Head Office by admin
$("#editHeadOffice").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editHeadOffice").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "head_office/edit_head_office_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_head_office.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Head Office End by admin @@@@****####

// @@@@****#### Zonal Manager start by admin @@@@****####
// Add Zonal Manager by admin
$("#addZonalManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addZonalManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "zonal_manager/add_zonal_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_zonal_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Franchisee Manager by admin
$("#editZonalManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');
    var ref_id = $("#ref_id").val();
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "ref_id=" +
        ref_id +
        "&testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editZonalManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "zonal_manager/edit_zonal_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_zonal_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Franchisee Manager End by admin @@@@****####

// @@@@****#### Trainee Manager start by admin @@@@****####
// Add Trainee Manager by admin
$("#addTraineeManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addTraineeManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "trainee_manager/add_trainee_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_trainee_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Trainee Manager by admin
$("#editTraineeManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editTraineeManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "trainee_manager/edit_trainee_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_trainee_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Trainee Manager End by admin @@@@****####

// @@@@****#### Reginal Manage start by admin @@@@****####
// Add Reginal Manage by admin
$("#addReginalManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addReginalManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "regional_manager/add_regional_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_regional_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Reginal Manage by admin
$("#editReginalManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var ref_id = $("#ref_id").val();
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "ref_id=" +
        ref_id +
        "&testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editReginalManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "regional_manager/edit_regional_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_regional_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Reginal Manage End by admin @@@@****####

// @@@@****#### Franchisee Manager start by admin @@@@****####
// Add Franchisee Manager by admin
$("#addFranchiseeManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addFranchiseeManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "franchisee_manager/add_franchisee_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_franchisee_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Franchisee Manager by admin
$("#editFranchiseeManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');
    var ref_id = $("#ref_id").val();
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "ref_id=" +
        ref_id +
        "&testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editFranchiseeManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "franchisee_manager/edit_franchisee_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_franchisee_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Franchisee Manager End by admin @@@@****####

// @@@@****#### Floor Manager start by admin @@@@****####
// Add Floor Manager by admin
$("#addFloorManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addFloorManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "floor_manager/add_floor_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_floor_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Floor Manager by admin
$("#editFloorManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');
    var ref_id = $("#ref_id").val();
    var editfor = $("#editfor").val();
    var testiod = $("#testiod").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var zone = $("#zone_name").val().trim();
    var region = $("#region_name").val().trim();
    var branch = $("#branch_name").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "ref_id=" +
        ref_id +
        "&testiod=" +
        testiod +
        "&editfor=" +
        editfor +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&zone=" +
        zone +
        "&region=" +
        region +
        "&branch=" +
        branch;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editFloorManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "floor_manager/edit_floor_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_floor_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Floor Manager End by admin @@@@****####

// @@@@****#### Business Consultant start by admin @@@@****####
// Add Business Consultant by admin
$("#addChannelBusinessDirector").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        //  "designation=" +designation+
        //  "&user_id_name=" +user_id_name+
        //  "&reference_name=" +reference_name+

        "firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        //  "&gst_no=" +gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addChannelBusinessDirector").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "add_cbd_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_cbd.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Business Consultant by admin
$("#editChannelBusinessDirector").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        //  "&gst_no="+gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editChannelBusinessDirector").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "edit_cbd_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_cbd.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Business Consultant End by admin @@@@****####

// @@@@****#### Employee start by admin @@@@****####


// @@@@****#### Employee End by admin @@@@****####

// @@@@****#### Business Mentor start by admin @@@@****####


// @@@@****#### Business Mentor End by admin @@@@****####//

// @@@@****#### Business Consultant start by admin @@@@****####
// Add Business Consultant by admin
$("#addBusinessConsultant").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    // var testp= $('#testphone').val();
    var testE = $("#testemail").val();

    var dataString =
        "designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        //  "&gst_no=" +gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (reference_name == "") {
        alert("Select Referance name");
    }
    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#addBusinessConsultant").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "add_business_consultant_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_consultant.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Business Consultant by admin
$("#editBusinessConsultant").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        //  "&gst_no="+gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else {
        $("#editBusinessConsultant").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "edit_business_consultant_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_consultant.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Business Consultant End by admin @@@@****####

// @@@@****#### business_trainee start by admin @@@@****####
// Add business_trainee by admin
$("#addBusinessTrainee").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val();
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var dataString =
        "designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        //  "&gst_no=" +gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else {
        $("#addBusinessTrainee").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "add_business_trainee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_trainee.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit business_trainee by admin
$("#editBusinessTrainee").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#business_package_amount").val();
    // var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        //  "&gst_no="+gst_no+
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else {
        $("#editBusinessTrainee").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "edit_business_trainee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_trainee.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### business_trainee End by admin @@@@****####

// @@@@****#### Corporate Agency start by admin @@@@****####
// Add Corporate Agency by admin

// Edit Corporate Agency by admin

// @@@@****#### Corporate Agency End by admin @@@@****####

// @@@@****#### Corporate Agency Travel Agency start by admin @@@@****####
// Add Travel Agency  by admin


//@@@@****#### Corporate Agency Travel Agency End by admin @@@@****####

// @@@@****#### Corporate Agency Customer start by admin @@@@****####
// Add customer by admin


// @@@@****#### Corporate Agency Customer End by admin @@@@****####

// @@@@****#### CA Franchisee start by admin @@@@****####
// Add CA Franchisee by admin
$("#addFranchisee").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val() ? 'travel_agent' : '';
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&payment_proof=" +
        payment_proof +
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (payment_proof == "") {
        alert("Enter Payment Proof");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#addFranchisee").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "franchisee/add_franchisee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_franchisee.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit CA Franchisee by admin
$("#editFranchisee").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        "&payment_proof=" +
        payment_proof +
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (payment_proof == "") {
        alert("Enter Payment Proof");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#editFranchisee").attr("disabled", "disabled");
        console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "franchisee/edit_franchisee_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_franchisee.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### CA Franchisee End by admin @@@@****####

// @@@@****#### Business Operation Executive start by admin @@@@****####
// Add Business Operation Executive by admin
$("#addBusinessOperationExecutive").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val() ? "travel_agent" : "";
    var user_id_name = $("#user_id_name").val()
        ? $("#user_id_name").val()
        : "null";
    var reference_name = $("#reference_name").val()
        ? $("#reference_name").val()
        : "null";

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // var paymentMode = $(".payment:checked").val();
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    //  "&payment_proof=" +payment_proof+
    //  "&paymentMode=" +paymentMode+
    //  "&chequeNo=" +chequeNo+
    //  "&chequeDate=" +chequeDate+
    //  "&bankName=" +bankName+
    //  "&transactionNo=" +transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    }
    // else if(paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online'){
    //     alert("Select Payment Mode");
    // }
    else {
        $("#addBusinessOperationExecutive").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "add_business_operation_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_business_operation_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Business Operation Executive by admin
$("#editBusinessOperationExecutive").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val() ? "travel_agent" : "";
    var user_id_name = $("#user_id_name").val()
        ? $("#user_id_name").val()
        : "null";
    var reference_name = $("#reference_name").val()
        ? $("#reference_name").val()
        : "null";

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    // var paymentMode = $(".payment:checked").val();
    // var chequeNo = $("#chequeNo").val().trim();
    // var chequeDate = $("#chequeDate").val().trim();
    // var bankName = $("#bankName").val().trim();
    // var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card;
    //  "&payment_proof=" +payment_proof+
    //  "&paymentMode=" +paymentMode+
    //  "&chequeNo=" +chequeNo+
    //  "&chequeDate=" +chequeDate+
    //  "&bankName=" +bankName+
    //  "&transactionNo=" +transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    }
    // else if(paymentMode !== 'cash' && paymentMode !== 'cheque' && paymentMode !== 'online'){
    //     alert("Select Payment Mode");
    // }
    else {
        $("#editBusinessOperationExecutive").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "edit_business_operation_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_business_operation_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Business Operation Executive End by admin @@@@****####

// @@@@****#### Training Manager start by admin @@@@****####
// Add Training Manager by admin
$("#addTrainingManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val() ? "travel_agent" : "";
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#addTrainingManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "training_manager/add_training_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_training_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Training Manager by admin
$("#editTrainingManager").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#editTrainingManager").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "training_manager/edit_training_manager_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_training_manager.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Training Manager End by admin @@@@****####

// @@@@****#### Sales Executive start by admin @@@@****####
// Add Sales Executive by admin
$("#addSalesManagerExecutive").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    var designation = $("#designation").val() ? "travel_agent" : "";
    var user_id_name = $("#user_id_name").val();
    var reference_name = $("#reference_name").val();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "designation=" +
        designation +
        "&user_id_name=" +
        user_id_name +
        "&reference_name=" +
        reference_name +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount=" +business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    // console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#addSalesManagerExecutive").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "sales_manager_executive/add_sales_manager_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_sales_manager_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit Sales Executive by admin
$("#editSalesManagerExecutive").on("click", function (e) {
    e.preventDefault();
    // console.log('Add customer button clicked');

    // var designation = $("#designation").val();
    // var user_id_name = $("#user_id_name").val();
    // var reference_name = $("#reference_name").val();

    var editfor = $("#editfor").val().trim();
    var ref_id = $("#ref_id").val().trim();
    var id = $("#id").val().trim();

    var firstname = $("#firstname").val().trim();
    var lastname = $("#lastname").val().trim();

    var nominee_name = $("#nominee_name").val().trim();
    var nominee_relation = $("#nominee_relation").val().trim();

    var email = $("#email").val().trim();
    var dob = $("#dob").val().trim();

    // var business_package = $("#flex_amount").val();
    var gst_no = $("#gst_no").val();

    var gender = $(".gender:checked").val();
    var country_cd = $("#country_cd").val().trim();
    var phone = $("#phone").val().trim();

    var country = $("#country").val().trim();
    var mystate = $("#mystate").val().trim();
    var city = $("#city").val().trim();
    var pin = $("#pin").val().trim();
    var address = $("#address").val().trim();

    var paymentMode = $(".payment:checked").val();
    var chequeNo = $("#chequeNo").val().trim();
    var chequeDate = $("#chequeDate").val().trim();
    var bankName = $("#bankName").val().trim();
    var transactionNo = $("#transactionNo").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();
    // var payment_proof = $(":hidden#img_path6").val().trim();

    var testE = $("#testemail").val();

    var dataString =
        "editfor=" +
        editfor +
        "&ref_id=" +
        ref_id +
        "&id=" +
        id +
        "&firstname=" +
        firstname +
        "&lastname=" +
        lastname +
        "&nominee_name=" +
        nominee_name +
        "&nominee_relation=" +
        nominee_relation +
        "&email=" +
        email +
        "&dob=" +
        dob +
        //  "&amount="+business_package+
        "&gst_no=" +
        gst_no +
        "&gender=" +
        gender +
        "&country_code=" +
        country_cd +
        "&phone=" +
        phone +
        "&country=" +
        country +
        "&state=" +
        mystate +
        "&city=" +
        city +
        "&pincode=" +
        pin +
        "&address=" +
        address +
        "&profile_pic=" +
        profile_pic +
        "&aadhar_card=" +
        aadhar_card +
        "&pan_card=" +
        pan_card +
        "&passbook=" +
        passbook +
        "&voting_card=" +
        voting_card +
        //  "&payment_proof=" +payment_proof+
        "&paymentMode=" +
        paymentMode +
        "&chequeNo=" +
        chequeNo +
        "&chequeDate=" +
        chequeDate +
        "&bankName=" +
        bankName +
        "&transactionNo=" +
        transactionNo;
    console.log(dataString);

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else if (testE == "1") {
        alert("Email already exists");
    } else if (
        paymentMode !== "cash" &&
        paymentMode !== "cheque" &&
        paymentMode !== "online"
    ) {
        alert("Select Payment Mode");
    } else {
        $("#editSalesManagerExecutive").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "sales_manager_executive/edit_sales_manager_executive_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "view_sales_manager_executive.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Sales Executive End by admin @@@@****####
