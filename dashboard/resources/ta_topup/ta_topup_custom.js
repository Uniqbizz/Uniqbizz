//reset file input
function resetChequeInput() {
    // Reset file input
    const fileInput = document.getElementById('upload_cheque');
    fileInput.value = ""; // Clear the file input

    // Reset hidden input
    document.getElementById('previewcheque2').value = "";

    // Hide the preview div and remove the image source
    const previewDiv = document.getElementById('previewcheque');
    const previewImg = document.getElementById('previewcheque1');
    previewDiv.style.display = "none";
    previewImg.src = "";
}
// Select the input and feedback elements
const chequeNumberInput = document.getElementById("chequeNo");
const feedback = document.getElementById("chequeMes");

// Validation function for the cheque number
function isValidChequeNumber(chequeNumber) {
    const regex = /^\d{6,10}$/; // Match 6 to 10 digits
    return regex.test(chequeNumber);
}

// Add an event listener for dynamic validation
chequeNumberInput.addEventListener("blur", function() {

    const chequeNumber = chequeNumberInput.value;

    if (!isValidChequeNumber(chequeNumber)) {
        feedback.style.display = "block"; // Show the message
        feedback.className = "message error"; // Apply error styling
    } else {
        feedback.style.display = "none"; // Hide the message
    }
});


//for valid cheque date
// Target the specific input and message
const specificInput = document.getElementById("chequeDate");
const specificMessage = document.getElementById("specificMessage");
// Show message only for this input on focus
specificInput.addEventListener("focus", () => {
    specificMessage.style.display = "block"; // Show the message
});

// Hide message on blur
specificInput.addEventListener("blur", () => {
    specificMessage.style.display = "none"; // Hide the message
});
document.getElementById("chequeDate").addEventListener("input", function(e) {
    const value = e.target.value;

    // Allow only digits and hyphens, and restrict length
    e.target.value = value
        .replace(/[^0-9\-]/g, '') // Remove invalid characters
        .slice(0, 10); // Restrict to 10 characters

    // Optional: Automatically insert hyphens
    if (/^\d{4}$/.test(value)) {
        e.target.value = value + "-";
    } else if (/^\d{4}-\d{2}$/.test(value)) {
        e.target.value = value + "-";
    }
});
// fetch User based on selected designation
$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
    if (paymentMode == "cheque") {
        $("#chequeOpt").removeClass("d-none");
        $('#cheque_upl').removeClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $('#cheque_upl').find('input[type="file"]').val('');

        //check validation
        function isValidChequeNumber(chequeNumber) {
            // Ensure the cheque number is a string of digits only
            const isNumeric = /^\d+$/.test(chequeNumber);

            // Ensure the length of the cheque number is between 6 and 10 digits
            const lengthIsValid = chequeNumber.length >= 6 && chequeNumber.length <= 10;

            return isNumeric && lengthIsValid;
        }
        //reseting
        $('#transactionNo').val('');
        $('#previewcheque2').val('');
    } else if (paymentMode == "online") {
        $("#onlineOpt").removeClass("d-none");
        $("#chequeOpt").addClass("d-none");
        $('#cheque_upl').removeClass("d-none");
        $('#cheque_upl').find('input[type="file"]').val('');
        //reseting
        $('#bankName').val('')
        $('#chequeDate').val('')
        $('#chequeNo').val('')
        $('#previewcheque2').val('');

    } else if (paymentMode == "cash") {
        console.log('hi');

        $("#chequeOpt").addClass("d-none");
        $("#onlineOpt").addClass("d-none");
        $('#cheque_upl').removeClass("d-none");
        $('#cheque_upl').find('input[type="file"]').val('');
        //reseting
        $('#bankName').val('')
        $('#chequeDate').val('')
        $('#chequeNo').val('')
        $('#previewcheque2').val('');
        $('#transactionNo').val('');
    }
});
//Add topup balance by sv on 28 Jan 2025
$('#add-ta-topup').click(function (e) {
    e.preventDefault();

    var ta_id = $("#user_id_name").val();
    var ta_full_name = $("#reference_name").val();
    var name_parts = ta_full_name.trim().split(/\s+/);
    var ta_fname = name_parts[0];
    var ta_lname = name_parts[1];
    var ta_topup_amt = $("#ta_amt").val().trim();
    var ta_pay_mode = $(".payment:checked").val();
    var ta_cheque_no = $("#chequeNo").val().trim();
    var ta_cheque_date = $("#chequeDate").val().trim();
    var ta_bank_name = $("#bankName").val().trim();
    var ta_transaction_id = $("#transactionNo").val().trim();
    var ta_ref_img = $(":hidden#previewcheque2").val();
    //current date
    var today = new Date();
    var year = today.getFullYear();
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    var day = String(today.getDate()).padStart(2, '0');
    var hours = String(today.getHours()).padStart(2, '0');
    var minutes = String(today.getMinutes()).padStart(2, '0');
    var seconds = String(today.getSeconds()).padStart(2, '0');
    // Format as "YYYY-MM-DD HH:MM:SS"
    var currentDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

    //console.log(currentDateTime);

    var ta_created_date = currentDateTime;
    var ta_updated_date = currentDateTime;

    //validation

    var dataString = {
        ta_id: ta_id,
        ta_fname: ta_fname,
        ta_lname: ta_lname,
        ta_topup_amt: ta_topup_amt,
        ta_pay_mode: ta_pay_mode,
        ta_cheque_no: ta_cheque_no,
        ta_cheque_date: ta_cheque_date,
        ta_bank_name: ta_bank_name,
        ta_transaction_id: ta_transaction_id,
        ta_ref_img: ta_ref_img,
        ta_created_date: ta_created_date,
        ta_updated_date: ta_updated_date,
        ta_status: 1
    };

    if (validateForm()) {
        $.ajax({
            type: "POST",
            url: "../controllers/travel_agent/add_ta_top_up_data.php",
            data: dataString,
            cache: false,
            success: function (data) {
                //console.log(data);
                if (data == 1) {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Added Successfuly");
                    location.href = "view_ta_topup.php";
                } else {
                    $("#loading-overlay").hide(); //loading screen
                    alert("Failed");
                }
            },
        });
    }

});