// @@@@****#### super_techno_enterprise start by admin @@@@****####
// Add super_techno_enterprise by admin
$("#addSuperTechnoEnterprise").on("click", function (e) {
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

    // var zone = $("#zone").val().trim();
    // var branch = $("#branch").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else {

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
            // "&zone=" +
            // zone +
            // "&branch=" +
            // branch +
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
            "&note=" +
            note;
            // console.log(dataString);

        $("#addSuperTechnoEnterprise").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "addSuperTechnoData.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "superTechno.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// Edit business_trainee by admin
$("#editSuperTechnoEnterprise").on("click", function (e) {
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

    // var zone = $("#zone").val().trim();
    // var branch = $("#branch").val().trim();

    var profile_pic = $(":hidden#img_path1").val().trim();
    var aadhar_card = $(":hidden#img_path2").val().trim();
    var pan_card = $(":hidden#img_path3").val().trim();
    var passbook = $(":hidden#img_path4").val().trim();
    var voting_card = $(":hidden#img_path5").val().trim();

    var rawNote = $("#note").val();
    var note = (typeof rawNote === "string") ? (rawNote === "" ? "" : rawNote.trim()) : "";

    if (firstname.length <= 2) {
        alert("Enter Proper First Name");
    } else if (lastname.length <= 2) {
        alert("Enter Proper Last Name");
    } else {

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
            // "&zone=" +
            // zone +
            // "&branch=" +
            // branch +
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
            "&note=" +
            note;
            // console.log(dataString);

        $("#editSuperTechnoEnterprise").attr("disabled", "disabled");
        // console.log(dataString);
        $("#loading-overlay").show(); //loading screen
        $.ajax({
            type: "POST",
            url: "editSuperTechnoData.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Edit Successfuly");
                    location.href = "superTechno.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }
});
// @@@@****#### Super Techno Enterprise End by admin @@@@****####//