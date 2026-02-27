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