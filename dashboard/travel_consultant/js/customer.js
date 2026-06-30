// for age calculation //
        const date = new Date();
        let current_year = date.getFullYear();
         $(document).ready(function() {
            var paymentMode = $(".payment:checked").val();
            var payment_fee = $('#payment_fee').val()
            if (paymentMode == "cheque") {
                $("#chequeOpt").removeClass("d-none");
                $("#onlineOpt").addClass("d-none");
            } else if (paymentMode == "online") {
                $("#onlineOpt").removeClass("d-none");
                $("#chequeOpt").addClass("d-none");
            } else {
                $("#chequeOpt").addClass("d-none");
                $("#onlineOpt").addClass("d-none");
            }
            var state = $('#mystate').val();
        });
        // fetch User based on selected designation
        $('#user_id_name').on('change', function() {
            var user_id_name = $(this).val();

            var designation = 'CA_Travel_Agent';

            $.ajax({
                type: 'POST',
                url: '../agents/getUsers.php',
                data: 'user_id_name=' + user_id_name + '&designation=' + designation,
                success: function(response) {
                    $('#reference_name').val(response);
                }
            });

        });

        $('#country').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    type: 'POST',
                    url: '../address/countrydata.php',
                    data: 'country_id=' + countryID,
                    success: function(htmll) {
                        $('#mystate').html(htmll);
                        $('#city').html('<option value="">Select state first</option>');
                    }
                });
            } else {
                $('#mystate').html('<option value="">Select country first</option>');
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
        });

        $('#mystate').on('change', function() {
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    type: 'POST',
                    url: '../address/countrydata.php',
                    data: 'state_id=' + stateID,
                    success: function(html) {
                        $('#city').html(html);
                    }
                });
            } else {
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
            //coupon applicable logic for goa
            
        });

        function toggleDiv(show) {
            document.getElementById("paymentMode").classList.toggle("d-none", !show);
            document.getElementById("payOpt").classList.toggle("d-none", !show);
            document.getElementById("payProof").classList.toggle("d-none", !show);
            let paymentFee = document.getElementById("payment_fee");
            paymentFee.value = show ? "10000" : "FOC";

        }
        //payment type
         $('#payment_fee').on('change', function() {
            var payval=$(this).val();
            if (payval != 'FOC') {
                $('#paymentMode').removeClass('d-none');
                $('#payProof').removeClass('d-none');
                $('#payOpt').removeClass('d-none');
            }else{
                $('#paymentMode').addClass('d-none');
                $('#payProof').addClass('d-none');
                $('#payOpt').addClass('d-none');
            }
        });
        // payment mode
        $('#paymentMode').on('click', function() {
            var paymentMode = $(".payment:checked").val();
            if (paymentMode == "cheque") {
                $("#chequeOpt").removeClass("d-none");
                $("#onlineOpt").addClass("d-none");
                $("#transactionNo").val("");
            } else if (paymentMode == "online") {
                $("#onlineOpt").removeClass("d-none");
                $("#chequeOpt").addClass("d-none");
                $("#chequeNo").val("");
                $("#chequeDate").val("");
                $("#bankName").val("");
            } else {
                $("#chequeOpt").addClass("d-none");
                $("#onlineOpt").addClass("d-none");
                $("#chequeNo").val("");
                $("#chequeDate").val("");
                $("#bankName").val("");
                $("#transactionNo").val("");
            }
        });

        $('#city').on('change', function() {
            var cityID = $(this).val();
            if (cityID) {
                $.ajax({
                    type: 'POST',
                    url: '../address/pincode.php',
                    data: 'city_id=' + cityID,
                    success: function(response) {
                        $('#pin').val(response);
                    }
                });
            } else {
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
        });
        document.addEventListener("DOMContentLoaded", function () {

            const callBtn = document.getElementById("callBtn");

            if (callBtn) {
                callBtn.addEventListener("click", function(e) {

                    let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                    if (!isMobile) {
                        e.preventDefault();

                        alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                        location.reload();

                        // Optional clipboard copy (safe fallback)
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText("8010892265");
                        }
                    }
                });
            }

        });
        var modal = document.getElementById('staticBackdrop');

        // Store the element that opened the modal
        let lastFocusedElement;

        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-bs-toggle="modal"]')) {
                lastFocusedElement = e.target;
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            if (lastFocusedElement) {
                lastFocusedElement.focus();
            } else {
                document.body.focus();
            }
        });
        $('#add-customer').click(function (e) {
            e.preventDefault();
            // console.log('Add customer button clicked');

            var cu_ref_id = $("#cu_ref_id").val(); // customer reference id
            var customer_type = $('#customer_type').val(); // customer reference type
            var cu_ref_name = $("#cu_ref_name").val(); // customer reference Name
            var user_id_name = $("#user_id_name").val(); // Travel agent reference id
            var reference_name = $("#reference_name").val(); // Travel agent reference Name
            var firstname = $("#firstname").val().trim();
            var lastname = $("#lastname").val().trim();
            // var nominee_name = $("#nominee_name").val().trim();
            // var nominee_relation = $("#nominee_relation").val().trim();
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

            var payment_fee = $("#payment_fee").val().trim();
            if (payment_fee == "FOC") {
                var paymentMode = "Free";
            } else {
                var paymentMode = $(".payment:checked").val();
            }
            //console.log(paymentMode);
            var chequeNo = $("#chequeNo").val().trim();
            var chequeDate = $("#chequeDate").val().trim();
            var bankName = $("#bankName").val().trim();
            var transactionNo = $("#transactionNo").val().trim();

            var profile_pic = $(":hidden#img_path1").val().trim();
            var aadhar_card = $(":hidden#img_path2").val().trim();
            var pan_card = $(":hidden#img_path3").val().trim();
            var passbook = $(":hidden#img_path4").val().trim();
            var voting_card = $(":hidden#img_path5").val().trim();
            if (payment_fee == "FOC") {
                var payment_proof = "none";
            } else if (payment_fee == "null") {
                var payment_proof = "none";
            } else {
                var payment_proof = $(":hidden#img_path6").val().trim();
            }
            let payment_text = $("#payment_fee option:selected").text().trim(); // Gets the visible text

            // Check if the text contains a colon (e.g., "Prime: ₹10,000/-")
            let payment_label = payment_text.includes(":")
                ? payment_text.split(":")[0].trim() // Extract part before colon
                : payment_text;

            var register_by = $('#register_by').val().trim();
            var registrant_id = $('#registrant_id').val();
            var editfor = $('#editfor').val().trim();

            var testE = $('#testemail').val();
            var userId = $('#userId').val();
            var userType = $('#userType').val();

            if (!cu_ref_id) {
                cu_ref_id = "";
                cu_ref_name = "";
            }

            if (!user_id_name) {
                user_id_name = "";
                reference_name = "";
            }

            var dataString = // "designation=" +designation+ 
                "cu_ref_id=" + cu_ref_id +
                "&cu_ref_name=" + cu_ref_name +
                "&user_id_name=" + user_id_name +
                "&reference_name=" + reference_name +
                "&firstname=" + firstname +
                "&lastname=" + lastname +
                // "&nominee_name=" + nominee_name +
                // "&nominee_relation=" + nominee_relation +
                "&email=" + email +
                "&dob=" + dob +
                "&gender=" + gender +
                "&country_code=" + country_cd +
                "&phone=" + phone +
                "&country=" + country +
                "&state=" + mystate +
                "&city=" + city +
                "&pincode=" + pin +
                "&address=" + address +
                "&profile_pic=" + profile_pic +
                "&aadhar_card=" + aadhar_card +
                "&pan_card=" + pan_card +
                "&passbook=" + passbook +
                "&voting_card=" + voting_card +
                "&payment_proof=" + payment_proof +
                "&register_by=" + register_by +
                "&registrant_id=" + registrant_id +
                "&editfor=" + editfor +
                "&paymentMode=" + paymentMode +
                "&chequeNo=" + chequeNo +
                "&chequeDate=" + chequeDate +
                "&bankName=" + bankName +
                "&transactionNo=" + transactionNo +
                "&payment_fee=" + payment_fee + 
                '&userId=' + userId + 
                '&userType=' + userType+
                '&payment_label=' + payment_label+
                '&customer_type='+customer_type;
            //console.log(dataString);

            var characterLetters = /^[A-Za-z\s]+$/;
            var phoneReg = /^[0-9]{10}$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var specialChar = /[!@#$%^&*]/g;

            var dob_year = dob.substring(0, 4);
            var age = current_year - dob_year;

            if (firstname === '') {
                alert("Enter Proper First Name");
            } else if (lastname === '') {
                alert("Enter Proper Last Name");
            } else if (email === '') {
                alert("Enter Email");
            } else if (!emailReg.test(email)) {
                alert("Enter Proper Email");
            } else if (testE === '1') {
                alert("Email already exists");
            } else if (dob === '') {
                alert("Please Select Birthdate");
            } else if (age < 18) {
                alert("Sorry, you are not eligible");
            } else if (!['male', 'female', 'others'].includes(gender)) {
                alert("Please Select Gender");
            } else if (country_cd === '') {
                alert("Select Country Code");
            } else if (phone === '') {
                alert("Enter Phone Number");
            } else if (!phoneReg.test(phone)) {
                alert("Enter Proper Phone Number");
            } else if (country === '') {
                alert("Select Country");
            } else if (mystate === '') {
                alert("Select State");
            } else if (city === '') {
                alert("Select City");
            } else if (address === '' || specialChar.test(address) || address.length <= 7) {
                alert("Enter Proper Address");
            } else if (!paymentMode) {
                alert("Please Select Payment Mode");
            } else if (paymentMode === "online" && transactionNo === '') {
                alert("Please Enter Transaction No");
            } else if (paymentMode === "cheque") {

                let missing = [];

                if (chequeNo === '') missing.push("Cheque No");
                if (chequeDate === '') missing.push("Cheque Date");
                if (bankName === '') missing.push("Bank Name");

                if (missing.length > 0) {
                    alert("Please Enter: " + missing.join(", "));
                }

            } else if (profile_pic === '') {
                alert("Please Upload Profile Picture");
            } else if (aadhar_card === '') {
                alert("Please Upload Aadhar Card");
            } else if (pan_card === '') {
                alert("Please Upload PAN Card");
            } else if (passbook === '') {
                alert("Please Upload Bank Passbook");
            } else if (payment_fee !== "FOC" && payment_proof === '') {
                alert("Please Upload Payment Proof");
            } else {
                $("#add-customer").attr("disabled", "disabled");
                $("#loading-overlay").show(); //loading screen
                // console.log(dataString);
                $.ajax({
                    type: "POST",
                    url: "ajax/customer/add_customer_data.php",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        // console.log(data);
                        if (data == 1) {
                            $("#loading-overlay").hide(); //loading screen
                            alert("Added Successfuly");
                            location.href = "customers_list.php";
                        } else {
                            $("#loading-overlay").hide(); //loading screen
                            console.log(data);

                            alert("Failed");
                        }
                    },
                });
            }
        });
        // Edit customer by client 
        $('#edit-customer').click(function (e) {
            e.preventDefault();

            // var designation = $("#designation").val();
            // var user_id_name = $("#user_id_name").val();
            // var reference_name = $("#reference_name").val();

            var editfor = $('#editfor').val(); // registered OR pending
            var ref_id = $('#ref_id').val();  // reference id
            var id = $('#id').val(); // customer id
            var customer_type = $('#customer_type').val(); // customer type
            var firstname = $("#firstname").val().trim();
            var lastname = $("#lastname").val().trim();
            // var nominee_name = $("#nominee_name").val().trim();
            // var nominee_relation = $("#nominee_relation").val().trim();
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
            var ta_reference_no=$("#user_id_name").val().trim();
            var register_by = $('#register_by').val().trim();
            var registrant_id = $('#registrant_id').val();

            var testE = $('#testemail').val();
            var userId = $('#userId').val();
            var userType = $('#userType').val();
            var payment_fee = $("#payment_fee").val().trim();
            if (payment_fee == "FOC") {
                var paymentMode = "Free";
            } else {
                var paymentMode = $(".payment:checked").val();
            }
            //console.log(paymentMode);
            var chequeNo = $("#chequeNo").val().trim();
            var chequeDate = $("#chequeDate").val().trim();
            var bankName = $("#bankName").val().trim();
            var transactionNo = $("#transactionNo").val().trim();

            var profile_pic = $(":hidden#img_path1").val().trim();
            var aadhar_card = $(":hidden#img_path2").val().trim();
            var pan_card = $(":hidden#img_path3").val().trim();
            var passbook = $(":hidden#img_path4").val().trim();
            var voting_card = $(":hidden#img_path5").val().trim();
            if (payment_fee == "FOC") {
                var payment_proof = "none";
            } else if (payment_fee == "null") {
                var payment_proof = "none";
            } else {
                var payment_proof = $(":hidden#img_path6").val().trim();
            }
            let payment_text = $("#payment_fee option:selected").text().trim(); // Gets the visible text

            // Check if the text contains a colon (e.g., "Prime: ₹10,000/-")
            let payment_label = payment_text.includes(":")
                ? payment_text.split(":")[0].trim() // Extract part before colon
                : payment_text;
            //age calculation
            var birth_date_split = dob.split("-");
            var age = current_year - birth_date_split[0];
            // console.log(age);

            var characterLetters = /^[A-Za-z\s]+$/;
            var phoneReg = /^[0-9]{10}$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var specialChar = /[!@#$%^&*]/g;

            var dataString = "editfor=" + editfor +
                "&ref_id=" + ref_id +
                "&id=" + id +
                "&firstname=" + firstname +
                "&lastname=" + lastname +
                // "&nominee_name=" + nominee_name +
                // "&nominee_relation=" + nominee_relation +
                "&email=" + email +
                "&dob=" + dob +
                "&gender=" + gender +
                "&country_code=" + country_cd +
                "&phone=" + phone +
                "&country=" + country +
                "&state=" + mystate +
                "&city=" + city +
                "&pincode=" + pin +
                "&address=" + address +
                "&profile_pic=" + profile_pic +
                "&aadhar_card=" + aadhar_card +
                "&pan_card=" + pan_card +
                "&passbook=" + passbook +
                "&voting_card=" + voting_card +
                "&payment_proof=" + payment_proof +
                "&paymentMode=" + paymentMode +
                "&chequeNo=" + chequeNo +
                "&chequeDate=" + chequeDate +
                "&bankName=" + bankName +
                "&transactionNo=" + transactionNo+
                "&payment_fee="+ payment_fee+
                "&register_by=" + register_by +
                "&registrant_id=" + registrant_id + 
                '&userId=' + userId + 
                '&userType=' + userType+
                '&payment_label=' + payment_label+
                '&ta_reference_no='+ta_reference_no+
                '&customer_type='+customer_type;
            // console.log(dataString);                 

            // validation for email, phone, name 
            var characterLetters = /^[A-Za-z\s]+$/;
            var phoneReg = /^[0-9]{10}$/;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var specialChar = /[!@#$%^&*]/g;

            // age calculation 
            var dob_year = dob.substring(0, 4);
            var age = current_year - dob_year;

            if (firstname === '') {
                alert("Enter Proper First Name");
            } else if (lastname === '') {
                alert("Enter Proper Last Name");
            } else if (email === '') {
                alert("Enter Email");
            } else if (!emailReg.test(email)) {
                alert("Enter Proper Email");
            } else if (testE === '1') {
                alert("Email already exists");
            } else if (dob === '') {
                alert("Please Select Birthdate");
            } else if (age < 18) {
                alert("Sorry, you are not eligible");
            } else if (!['male', 'female', 'others'].includes(gender)) {
                alert("Please Select Gender");
            } else if (country_cd === '') {
                alert("Select Country Code");
            } else if (phone === '') {
                alert("Enter Phone Number");
            } else if (!phoneReg.test(phone)) {
                alert("Enter Proper Phone Number");
            } else if (country === '') {
                alert("Select Country");
            } else if (mystate === '') {
                alert("Select State");
            } else if (city === '') {
                alert("Select City");
            } else if (address === '' || specialChar.test(address) || address.length <= 7) {
                alert("Enter Proper Address");
            } else if (!paymentMode) {
                alert("Please Select Payment Mode");
            } else if (paymentMode === "online" && transactionNo === '') {
                alert("Please Enter Transaction No");
            } else if (paymentMode === "cheque") {

                let missing = [];

                if (chequeNo === '') missing.push("Cheque No");
                if (chequeDate === '') missing.push("Cheque Date");
                if (bankName === '') missing.push("Bank Name");

                if (missing.length > 0) {
                    alert("Please Enter: " + missing.join(", "));
                }

            } else if (profile_pic === '') {
                alert("Please Upload Profile Picture");
            } else if (aadhar_card === '') {
                alert("Please Upload Aadhar Card");
            } else if (pan_card === '') {
                alert("Please Upload PAN Card");
            } else if (passbook === '') {
                alert("Please Upload Bank Passbook");
            } else if (payment_fee !== "FOC" && payment_proof === '') {
                alert("Please Upload Payment Proof");
            } else {
                $("#editCustomer").attr("disabled", "disabled");
                $("#loading-overlay").show(); //loading screen
                //console.log(dataString);


                $.ajax({
                    type: "POST",
                    url: "ajax/customer/edit_customers_data.php",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        if (data == 1) {
                            $("#loading-overlay").hide(); //loading screen
                            alert("Edit Successfuly");
                            location.href = "customer_list.php";
                        } else {
                            $("#loading-overlay").hide(); //loading screen
                            alert("Failed");
                        }
                    },
                });
            }
        });