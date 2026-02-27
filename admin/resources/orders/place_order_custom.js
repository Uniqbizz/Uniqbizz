let payable_amount=0;
var totalMembers=0
var adults = 0;
var children = 0;
var infants = 0;
let part1=0;
let part2=0;
let part3=0;
function truncateToTwoDecimals(num) {
    return Math.floor(num * 100) / 100;
}
//on load
$(document).ready(function () {
    $('#coupons').removeAttr('multiple');
    $('#coupons').val(null);
    $('#coupon_amount').val('');
    $('#coupons').css('min-height', ''); // Remove min-height
});
//age limit
function memberLimit() {
    var noOfAdults = document.getElementById("b_no_adult").value.trim();
    noOfAdults = parseInt(noOfAdults); 
    var noOfChild = document.getElementById("b_no_child").value.trim();
    noOfChild = parseInt(noOfChild); 
    var noOfInfants = document.getElementById("b_no_infants").value.trim();
    noOfInfants = parseInt(noOfInfants); 
    totalMembers=noOfAdults+noOfChild+noOfInfants

    if (noOfAdults || noOfChild || noOfInfants) {
        if (noOfAdults > 99) {
            alert("Adults cannot be more then 99")
            document.getElementById("b_no_adult").value=""
        } 
        if (noOfChild > 99) {
            alert("Children cannot be more then 99")
            document.getElementById("b_no_child").value=""
        } 
        if (noOfInfants > 99) {
            alert("Infants cannot be more then 99")
            document.getElementById("b_no_infants").value=""
        } 
    }
}
//min adult validation
// $('#b_no_adult').on('change', function () {
//     let val = parseInt($(this).val()) || 0;
    
//     if (val > 1) {
//         $('#coupons').attr('multiple', true);
//         $('#coupons').css('min-height', '80px'); // Apply min-height
//     } else {
//         $('#coupons').removeAttr('multiple');
//         $('#coupons').val(null); // Reset selection
//         $('#coupon_amount').val('');
//         $('#coupons').css('min-height', ''); // Remove min-height
//     }
// });
// On input change for adults, children, infants
$('#b_no_adult, #b_no_child, #b_no_infants').on('input', function () {
    setTimeout(() => {
        let adults = parseInt($('#b_no_adult').val()) || 1;
        let children = parseInt($('#b_no_child').val()) || 0;
        let infants = parseInt($('#b_no_infants').val()) || 0;

        let container = $('#members_details');

        // Clear all dynamic member blocks (keep only #adult-1-block)
        container.children('div').not('.adult-1-block').remove();

        function createMemberBlock(label, ageNote, minAge, maxAge) {
            return `
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="input-block mb-2">
                        <label class="col-form-label">${label} Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control member_name" name="member_name[]" placeholder="Enter Name">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="input-block mb-2">
                        <label class="col-form-label">${label} Age <span class="text-danger">*</span> <small class="text-muted">(${ageNote})</small></label>
                        <input type="number" class="form-control member_age" name="member_age[]" min="${minAge}" max="${maxAge}" placeholder="Age">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="input-block mb-2">
                        <label class="col-form-label">${label} Gender <span class="text-danger">*</span></label>
                        <select name="member_gender[]" class="form-select member_gender">
                            <option disabled selected>--Select Gender--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>`;
        }

        for (let i = 2; i <= adults; i++) {
            container.append(createMemberBlock(`Adult ${i}`, '12 and above', 12, 100));
        }

        for (let i = 1; i <= children; i++) {
            container.append(createMemberBlock(`Child ${i}`, '3 - 11', 3, 11));
        }

        for (let i = 1; i <= infants; i++) {
            container.append(createMemberBlock(`Infant ${i}`, 'Below 3', 0, 2));
        }

        let aprice = truncateToTwoDecimals(parseFloat($('#apackage_price').val())) || 0;
        let cprice = truncateToTwoDecimals(parseFloat($('#cpackage_price').val())) || 0;

        let payable_amount = parseFloat((aprice * adults) + (cprice * children));
        payable_amount = truncateToTwoDecimals(payable_amount);
        $('#payable_amount').val(payable_amount);

        let gst = parseFloat($('#gst').val()) || 0;
        let gstAmt = 0;
        if (gst > 0) {
            gstAmt = ((aprice * gst / 100) * adults) + ((cprice * gst / 100) * children);
            gstAmt = truncateToTwoDecimals(gstAmt);
        }
        $('#gst_amount').val(gstAmt);
        $('#total_amount').val(payable_amount);

        let cAmt = parseFloat($('#coupon_amount').val()) || 0;
        let totalAmt = payable_amount + gstAmt - cAmt;
        totalAmt = truncateToTwoDecimals(totalAmt);
        $('#total_amount').val(totalAmt);
    }, 10);
});

// });
//age validation
$(document).on('input', '.member-age', function () {
    const age = parseInt($(this).val()) || 0;
    const minAge = parseInt($(this).data('min'));
    const maxAge = parseInt($(this).data('max'));

    if (age < minAge || age > maxAge) {
        const label = $(this).closest('.row').find('.col-form-label').first().text().split(' ')[0]; // e.g., "Adult", "Child"
        alert(`${label} age must be between ${minAge} and ${maxAge} years.`);
        $(this).val(''); // Reset the invalid age
    }
});
//tour date valiadtions
document.addEventListener("DOMContentLoaded", function () {
    const travelInput = document.getElementById('travel_date');
    const today = new Date();
    today.setDate(today.getDate() + 2); // Add 2 days

    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const minDate = `${year}-${month}-${day}`;

    travelInput.setAttribute('min', minDate);
});
//package details
$('#packageList').on('change', function () {
    let packageId = $(this).val();
    adults = parseInt($('#b_no_adult').val()) || 0;
    children = parseInt($('#b_no_child').val()) || 0;
    $.ajax({
        type: 'POST',
        url: 'get_package_details.php',
        data: { package_id: packageId },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                // Set package price
                $('#apackage_price').val(truncateToTwoDecimals(parseFloat(response.aprice)));
                $('#cpackage_price').val(truncateToTwoDecimals(parseFloat(response.cprice)));
                let aprice=$('#apackage_price').val();
                let cprice=$('#cpackage_price').val();
                $('#gst').val(response.gst);
                payable_amount=parseFloat((response.aprice*adults)+(response.cprice*children));
                payable_amount=truncateToTwoDecimals(payable_amount);
                
                $('#payable_amount').val(payable_amount);
                let gst=$('#gst').val();
                let gstAmt=0;
                if (gst>0) {
                    gstAmt=(aprice*gst/100)+(cprice*gst/100);
                    gstAmt=truncateToTwoDecimals(gstAmt);
                }
                $('#gst_amount').val(gstAmt);
                $('#total_amount').val(payable_amount);
                let cAmt=$('#coupon_amount').val();
                let totalAmt=$('#total_amount').val();
                totalAmt=totalAmt-cAmt;
                totalAmt=truncateToTwoDecimals(totalAmt);
                $('#total_amount').val(totalAmt);
                //$('#amountInput').val(payable_amount)

                // Rebuild carousel items
                let carouselInner = $('.carousel-inner');
                let indicatorsHtml = '';
                let imagesHtml = '';

                response.images.forEach((img, index) => {
                    imagesHtml += `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <img src="${img}" class="d-block w-100" height="400px" alt="Package Image ${index + 1}">
                        </div>`;
                });

                carouselInner.html(imagesHtml);
            } else {
                alert('Failed to load package details.');
            }
        },
        error: function () {
            alert('Error retrieving package details.');
        }
    });
});
//payment 

$('input[name="payTypeSelect"]').on('change', function () {
    let selectedValue = $(this).val(); // 'full' or 'part'
    let payableAmount=truncateToTwoDecimals(parseFloat($('#payable_amount').val()));
    if (selectedValue === 'full') {
        $('#partPayTypeSelect').val('--Select the Pay Type');
        $('#partPayTypeSelect').prop('disabled', true);  // Hide and disable
        $('#amountInput').val('');
        $('#amountInput').prop('readonly', false).prop('disabled', false);
        $('#partPayDiv').addClass('d-none');

    } else if (selectedValue === 'part') {
        $('#partPayTypeSelect').prop('disabled', false); // Show and enable
        $('#amountInput').val('NA');
        $('#amountInput').prop('readonly', true).prop('disabled', true);
        //$('#partPayDiv').removeClass('d-none');
    }
});
//on change customer id
$('#customerId').on('change', function () {
    var custId = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'get_customer_details.php',
        data: { user_id: custId },
        dataType: 'json',
        success(response) {
            if (response.status === 'success') {
                $('#customer_name').val(response.custName);
                $('#email').val(response.custEmail);
                $('#phone_no').val(response.custPhone);
                $('#customer_age').val(response.custAge);
                $('#customer_gender').val(response.custGender);

                // Populate first adult block
                $('#first_adult_name').val(response.custName);
                $('#first_adult_age').val(response.custAge);
                $('#first_adult_gender').val(response.custGender);

                // Clear previous coupon options
                $('#coupons').empty().append('<option selected value="">--Select Coupon--</option>');

                // Make sure coupons exist
                if (response.couponCodes.length > 0) {
                    // Create a map of code → amount
                    window.couponMap = {};

                    for (let i = 0; i < response.couponCodes.length; i++) {
                        let code = response.couponCodes[i];
                        let amount = response.couponAmts[i];
                        window.couponMap[code] = amount;

                        // Format: CODE (Rs. AMOUNT)
                        $('#coupons').append(
                            `<option value="${code}">${code} (Rs. ${amount})</option>`
                        );
                    }

                    $('.coupon_divs').removeClass('d-none');
                } else {
                    // No coupons: reset and hide amount
                    $('#coupons').empty().append('<option selected value="">--No Coupons--</option>');
                    $('#coupon_amount').val('');
                    $('.coupon_divs').addClass('d-none');
                }

            } else {
                alert('Customer not found.');
            }
        },
        error() {
            alert('Error retrieving customer details.');
        }
    });
});
//on chage of part type
$('#partPayTypeSelect').on('input', function () {
    let paytype = parseInt($(this).val());
    let container = $('#partPayDiv');
    let payable_amount = parseFloat($('#payable_amount').val()) || 0;
    payable_amount =truncateToTwoDecimals(payable_amount)
    container.empty();

    function createTransactionBlock(index, amount) {
        return `
            <div class="card mb-3 shadow-sm border-success" style="${index !== 1 ? 'opacity: 0.5;' : ''}">
                <div class="card-header text-dark fw-bold">
                    <span>Part ${index} Payment</span>
                    <span class=" warning-border-subtle bg-warning-subtle text-warning-emphasis fs-5 px-2 py-1" style="border-radius:5px;">Pending</span>
                </div>
                <div class="card-body row">
                    <div class="col-md-4 py-1">
                        <div class="input-block">
                            <label class="col-form-label" for="paidAmount${index}">Paid Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="paidAmount${index}" name="paid_amount[]" placeholder="Enter Paid Amount" value="${amount.toFixed(2)}" ${index !== 1 ? 'readonly disabled' : ''}>
                        </div>
                    </div>
                    <div class="col-md-4 py-1">
                        <div class="input-block">
                            <label class="col-form-label" for="transactionId${index}">Payment ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="transactionId${index}" name="transaction_id[]" placeholder="Enter Transaction ID" ${index !== 1 ? 'readonly disabled' : ''}>
                        </div>
                    </div>
                    <div class="col-md-4 py-1">
                        <div class="input-block">
                            <label class="col-form-label" for="transactionDate${index}">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="transactionDate${index}" name="transaction_date[]" ${index !== 1 ? 'readonly disabled' : ''}>
                        </div>
                    </div>
                    
                </div>
            </div>
        `;
    }

    if (paytype === 2) {
        $('#partPayDiv').removeClass('d-none');
        part1 = payable_amount / 2;
        part1=truncateToTwoDecimals(part1);
        part2 = payable_amount / 2;
        part2=truncateToTwoDecimals(part2);
        container.append(createTransactionBlock(1, part1));
        container.append(createTransactionBlock(2, part2));
    } else if (paytype === 3) {
        $('#partPayDiv').removeClass('d-none');
        part1 = (payable_amount * 0.4);
        part2 = (payable_amount * 0.3);
        part3 = (payable_amount * 0.3);
        part1=truncateToTwoDecimals(part1);
        part2=truncateToTwoDecimals(part2);
        part3=truncateToTwoDecimals(part3);
        container.append(createTransactionBlock(1, part1));
        container.append(createTransactionBlock(2, part2));
        container.append(createTransactionBlock(3, part3));
    } else {
        $('#partPayDiv').addClass('d-none');
    }
});
//on coupon selection
$('#coupons').on('change', function () {
    let selectedOptions = $('#coupons option:selected');

    // Limit to max 2 selected coupons
    if (selectedOptions.length > 2) {
        alert("You can select a maximum of 2 coupons.");

        // Deselect the last one
        selectedOptions.last().prop('selected', false);

        // Refresh selection to only the first 2
        selectedOptions = $('#coupons option:selected');
    }

    // Update coupon amount field
    let couponAmt = updateCouponAmount(selectedOptions);

    // Get values from form
    let aprice = parseFloat($('#apackage_price').val()) || 0;
    let cprice = parseFloat($('#cpackage_price').val()) || 0;
    let adults = parseInt($('#b_no_adult').val()) || 0;
    let children = parseInt($('#b_no_child').val()) || 0;
    let gst = parseFloat($('#gst').val()) || 0;

    // Calculate payable amount
    let payable_amount = parseFloat((aprice * adults) + (cprice * children));
    payable_amount = truncateToTwoDecimals(payable_amount);
    $('#payable_amount').val(payable_amount);

    // GST calculation
    let gstAmt = 0;
    if (gst > 0) {
        gstAmt = (aprice * gst / 100) + (cprice * gst / 100);
        gstAmt = truncateToTwoDecimals(gstAmt);
    }
    $('#gst_amount').val(gstAmt);

    // Final total after coupon
    let totalAmt = payable_amount + gstAmt - couponAmt;
    totalAmt = truncateToTwoDecimals(totalAmt);
    $('#total_amount').val(totalAmt);
});

// Truncate and sum selected coupons
function updateCouponAmount(selectedOptions) {
    let total = 0;

    selectedOptions.each(function () {
        const text = $(this).text(); // e.g. "SAVE10 (Rs. 10.89)"
        const match = text.match(/\(Rs\. ([\d.]+)\)/);
        if (match && match[1]) {
            total += parseFloat(match[1]);
        }
    });

    let truncated = truncateToTwoDecimals(total);
    $('#coupon_amount').val(truncated);
    return truncated;
}

//makepayid
function makepayid(length) {
    var result = 'Paid_';
    const timestamp = Date.now();
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    result += timestamp;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}
//payment details
$('#paymentMode').on('click', function() {
    var paymentMode = $(".payment:checked").val();
    // console.log(paymentMode);
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
//on click of submit
$('#place_order').on('click', function () {
    // Collect static form fields
    const travelDate = $('#travel_date').val();
    const customerId = $('#customerId').val();
    const customerName = $('#customer_name').val();
    const amountInput = $('#amountInput').val();
    let transactionId1 = '';
    const partPayTypeSelect = $('#partPayTypeSelect').val();
    const payTypeSelect1 = $('#payTypeSelect1').val();
    const payTypeSelect2 = $('#payTypeSelect2').val();
    const payableAmount = $('#payable_amount').val();
    const part1 = window.part1 || ''; // if part1 is set elsewhere
    const payment = $('.payment:checked').val();

    const pay_type = partPayTypeSelect !== '' && partPayTypeSelect !== null ? 0 : 1;
    const part_type =partPayTypeSelect == '2' ? 2:partPayTypeSelect == '3'?'3':'';
    let transactionDate1='';
    if(part_type != ''){
        transactionDate1=$('#transactionDate1').val();
        transactionId1 = $('#transactionId1').val()
    }
    const payment_id = amountInput !== 'NA' && amountInput !== '' ? amountInput : transactionId1;
    const paid_amount = payTypeSelect1 !== '' && payTypeSelect1 !== null
        ? payableAmount
        : (payTypeSelect2 !== '' && payTypeSelect2 !== null ? part1 : '');

    const formData = {
        date: travelDate,
        customerId: customerId,
        customer_name: customerName,
        payment_id: payment_id,
        part_type:part_type,
        pay_type: pay_type,
        transactionDate1:transactionDate1,
        payment: payment,
        paid_amount: paid_amount,
        email: $('#email').val(),
        phone_no: $('#phone_no').val(),
        adults: $('#b_no_adult').val(),
        child: $('#b_no_child').val(),
        infants: $('#b_no_infants').val(),
        package_id: $('#packageList').val(),
        apackage_price: $('#apackage_price').val(),
        cpackage_price: $('#cpackage_price').val(),
        gst: $('#gst').val(),
        gst_amount: $('#gst_amount').val(),
        payable_amount: payableAmount,
        coupon_amount: $('#coupon_amount').val(),
        total_amount: $('#total_amount').val(),
        selected_coupons: $('#coupons').val() || [],
        chequeNo: $('#chequeNo').val(),
        chequeDate: $('#chequeDate').val(),
        bankName: $('#bankName').val(),
        transactionNo: $('#transactionNo').val()
    };

    formData.members = [];

    $('.member_name').each(function (index) {
        const name = $(this).val();
        const age = $('.member_age').eq(index).val();
        const gender = $('.member_gender').eq(index).val();

        if (name && age && gender) {
            formData.members.push({ name, age, gender });
        }
    });

    console.log("Sending Data:", formData); // Debug

    // Validations
    if (!formData.customerId || formData.customerId.toString().trim() === '') {
        alert('Please select customer ID');
        return;
    }

    if (!formData.customer_name || formData.customer_name.toString().trim() === '') {
        alert('Please enter customer name');
        return;
    }

    if (!formData.email || formData.email.toString().trim() === '') {
        alert('Please enter email');
        return;
    }

    if (!formData.phone_no || formData.phone_no.toString().trim() === '') {
        alert('Please enter phone number');
        return;
    }

    if (!formData.package_id || formData.package_id.toString().trim() === '') {
        alert('Please select package');
        return;
    }

    if (!formData.date || formData.date.toString().trim() === '') {
        alert('Please select travel date');
        return;
    }

    if (!formData.payment || formData.payment.toString().trim() === '') {
        alert('Please select a payment mode');
        return;
    }

    // Payment mode specific validations
    if (formData.payment === 'cheque') {
        if (!formData.chequeNo || formData.chequeNo.trim() === '') {
            alert('Please enter cheque number');
            return;
        }
        if (!formData.chequeDate || formData.chequeDate.trim() === '') {
            alert('Please enter cheque date');
            return;
        }
        if (!formData.bankName || formData.bankName.trim() === '') {
            alert('Please enter bank name');
            return;
        }
    }

    if (formData.payment === 'online') {
        if (!formData.transactionNo || formData.transactionNo.trim() === '') {
            alert('Please enter transaction ID');
            return;
        }
    }

    if (formData.pay_type ==0 && (formData.part_type === '' || formData.part_type === null)) {
        alert('Please select part payment type');
        return;
    }

    if ((formData.part_type == '2' || formData.part_type == '3') && (formData.transactionDate1 == '' || formData.payment_id == '')) {
        alert('Please enter part 1 payment Trasaction Id and Date');
        return;
    }


    if (!formData.payment_id || formData.payment_id.toString().trim() === '') {
        alert('Please enter payment ID');
        return;
    }

    if (!formData.paid_amount || formData.paid_amount.toString().trim() === '') {
        alert('Please enter paid amount');
        return;
    }

    if (!formData.payable_amount || formData.payable_amount.toString().trim() === '') {
        alert('Please enter payable amount');
        return;
    }

    if (!formData.apackage_price || formData.apackage_price.toString().trim() === '') {
        alert('Please enter adult package price');
        return;
    }

    if (!formData.cpackage_price || formData.cpackage_price.toString().trim() === '') {
        alert('Please enter child package price');
        return;
    }


    if (!formData.total_amount || formData.total_amount.toString().trim() === '') {
        alert('Please enter total amount');
        return;
    }

    // Email and phone format
    if (!/^[\w.-]+@[\w.-]+\.\w+$/.test(formData.email)) {
        alert("Please enter a valid email address.");
        return;
    }

    if (!/^\d{10}$/.test(formData.phone_no)) {
        alert("Please enter a valid 10-digit phone number.");
        return;
    }

    

    // Optional: Warn if no members
    if (formData.members.length === 0) {
        if (!confirm("No members added. Continue?")) {
            return;
        }
    }

    

    // AJAX
    $.ajax({
        url: 'submit_booking_details.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response == 1) {
                alert('Order placed successfully!');
            } else {
                alert('Failed to place order!');
            }
        },
        error: function () {
            alert('Error sending request.');
        }
    });
});