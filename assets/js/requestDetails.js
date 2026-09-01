// Animate price
function animatePrice($element, finalValue, duration = 800) {

    let currentValue = $element.data('current-price') || 0;

    // Stop previous animation
    $element.stop(true, false);

    $({ count: currentValue }).animate(
        {
            count: finalValue
        },
        {
            duration: duration,

            step: function (now) {

                $element.text(
                    '₹ ' +
                    Math.round(now).toLocaleString('en-IN')
                );
            },

            complete: function () {

                $element.text(
                    '₹ ' +
                    Math.round(finalValue).toLocaleString('en-IN')
                );

                $element.data(
                    'current-price',
                    finalValue
                );
            }
        }
    );
}
function updateSubTotal() {

    const adultCount =
        parseInt($('#adultCount').val()) || 0;

    const childrenCount =
        parseInt($('#childrenCount').val()) || 0;

    const adultTotal =
        adultCount * perAdultPrice;

    const childrenTotal =
        childrenCount * perChildPrice;

    const subTotal =
        adultTotal + childrenTotal;

    animatePrice(
        $('#subTotal'),
        subTotal
    );
}
//rooom recomendation
function updateRecommendedRooms() {
    const adults = parseInt($('#adultCount').val()) || 0;
    const children = parseInt($('#childrenCount').val()) || 0;
    const totalPax = adults + children;
    if (totalPax <= 0) { return; }
    /*
    =====================================================
    ROOM CALCULATION
    2 normal members per room
    Maximum 1 extra mattress per room
    1-2 = 1 room
    3   = 1 room + mattress
    4   = 2 rooms
    5   = 2 rooms (one mattress)
    6   = 2 rooms (both mattress)
    7   = 3 rooms (one mattress)
    =====================================================
    */
    const rooms = Math.ceil(totalPax / 3);
    let remainingPax = totalPax;
    let roomsHTML = '';
    for (let i = 1; i <= rooms; i++) {
        let roomPax = Math.min(remainingPax, 3);
        remainingPax -= roomPax;
        const extraMattress = roomPax === 3;
        let bedText = '1 Double Bed';
        if (extraMattress) {
            bedText += ' + 1 Extra Mattress';
        }
        let accommodationText =
            roomPax + ' Pax will be accommodated in 1 room';
        if (extraMattress) {
            accommodationText += ' with extra mattress.';
        } else {
            accommodationText += '.';
        }
        roomsHTML += `
            <p class="fontSize10 fw-bold">Room ${i}</p>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                    <div class="d-flex justify-content-between mobileDisplayBlock">
                        <div>
                            <p class="fontSize10 fw-bold">
                                <i class="ri-hotel-bed-fill destination-title fs-6"></i>
                                ${bedText}
                            </p>
                            <p class="fontSize10">
                                ${accommodationText}
                            </p>
                        </div>
                        <div class="py-1 px-2 text-center text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 recommendedBtn fw-bold fontSize10">
                            Recommended
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                    <button class="btn modifyBtn" type="button" data-room="${i}">Modify Rooms</button>
                </div>
            </div>
        `;
    }
    /*
    =====================================================
    ADD ROOM BUTTON
    KEEP IT INSIDE THE SAME CARD
    =====================================================
    */
    roomsHTML += `
        <div class="d-flex justify-content-center">
            <button class="btn addRoomBtn" type="button">Add Room (If more travellers)</button>
        </div>
    `;
    /*
    =====================================================
    IMPORTANT:
    Do NOT replace #roomRecommendation itself.
    Only replace its contents.
    =====================================================
    */
    $('#roomRecommendation').html(roomsHTML);
}
//load modify rooms
function loadModifyRooms(adults, children, infants) {

    const container = $('#modifyRoomsContainer');

    container.empty();

    // Total counts
    $('#totalAdults').text(adults);
    $('#totalChildren').text(children);
    $('#totalInfants').text(infants);


    // Infants do not consume room occupancy
    const totalOccupancy = adults + children;


    // Max 3 occupants per room
    const rooms = Math.max(
        1,
        Math.ceil(totalOccupancy / 3)
    );


    let remainingOccupancy = totalOccupancy;


    // Create rooms
    for (let i = 1; i <= rooms; i++) {

        const occupancy = Math.min(
            remainingOccupancy,
            3
        );

        remainingOccupancy -= occupancy;


        // Extra mattress default
        const extraMattress = occupancy === 3;


        const roomHTML = `
            <div class="modify-room-card mb-3" data-room="${i}">

                <div class="room-content-row">

                    <!-- ROOM TITLE -->
                    <div class="room-title">
                        <p class="fontSize10 fw-bold mb-0">
                            Room ${i}
                        </p>
                    </div>


                    <!-- ROOM OCCUPANCY -->
                    <div class="occupancy-section">

                        <label class="fontSize10 fw-bold mb-0">
                            Room Occupancy
                        </label>

                        <div class="occupancy-control">

                            <button type="button"
                                    class="occupancy-minus">
                                -
                            </button>

                            <input type="text"
                                class="form-control text-center room-occupancy"
                                value="${occupancy}"
                                readonly>

                            <button type="button"
                                    class="occupancy-plus">
                                +
                            </button>

                        </div>

                    </div>


                    <!-- EXTRA MATTRESS -->
                    <div class="mattress-section">

                        <div class="form-check mb-0">

                            <input class="form-check-input extra-mattress"
                                type="checkbox"
                                id="extraMattress${i}"
                                ${extraMattress ? 'checked' : ''}>

                            <label class="form-check-label fontSize10"
                                for="extraMattress${i}">
                                With Extra Mattress
                            </label>

                        </div>

                    </div>


                    <!-- REMOVE ROOM -->
                    ${i > 1 ? `
                        <div class="ms-auto">

                            <button type="button"
                                    class="removeModifyRoom">
                                Remove
                            </button>

                        </div>
                    ` : ''}

                </div>

            </div>
        `;

        container.append(roomHTML);
    }
}
// =====================================================
// RENUMBER ROOMS
// =====================================================

function renumberModifyRooms() {
    $('#modifyRoomsContainer .modify-room-card').each(function (index) {
        const roomNumber = index + 1;
        const roomCard = $(this);
        // Update data-room
        roomCard.attr(
            'data-room',
            roomNumber
        );
        // Update Room X text
        roomCard
            .find('p.fontSize10.fw-bold.mb-0')
            .first()
            .text(
                'Room ' + roomNumber
            );
        // Update checkbox ID
        const checkbox =
            roomCard.find('.extra-mattress');
        const checkboxId =
            'extraMattress' + roomNumber;
        checkbox.attr(
            'id',
            checkboxId
        );
        // Update label's for attribute
        roomCard
            .find('label.form-check-label')
            .attr(
                'for',
                checkboxId
            );
        // Room 1 should not have Remove button
        if (roomNumber === 1) {
            roomCard
                .find('.removeModifyRoom')
                .remove();
        }
    });

}
// =====================================================
// GET TOTAL TRAVELLERS
// =====================================================

function getTotalTravellers() {
    return {
        adults: parseInt($('#adultCount').val()) || 0,
        children: parseInt($('#childrenCount').val()) || 0,
        infants: parseInt($('#infantCount').val()) || 0
    };
}

// =====================================================
// UPDATE EXTRA MATTRESS BASED ON OCCUPANCY
// =====================================================

function updateRoomExtraMattress(roomCard) {
    const occupancy = parseInt(roomCard.find('.room-occupancy').val()) || 0;
    const checkbox = roomCard.find('.extra-mattress');
    /*
    3 people = extra mattress recommended
    1 or 2 people = no extra mattress
    */
    if (occupancy === 3) {
        checkbox.prop('checked', true);
    } else {
        checkbox.prop('checked', false);
    }
}

// =====================================================
// UPDATE RECOMMENDATION FROM USER MODIFICATION
// =====================================================

function updateRecommendedRoomsFromModification(roomOccupancies, adults, children, infants) {
    let roomsHTML = '';
    roomOccupancies.forEach(function (room, index) {
        const roomNumber = index + 1;
        const occupancy = room.occupancy;
        const extraMattress = room.extraMattress;

        // =================================================
        // BED TEXT
        // =================================================

        let bedText = '1 Double Bed';
        if (extraMattress) {
            bedText +=
                ' + 1 Extra Mattress';
        }

        // =================================================
        // ACCOMMODATION TEXT
        // =================================================

        let accommodationText = occupancy + ' Pax will be accommodated in 1 room';

        if (extraMattress) {
            accommodationText +=
                ' with extra mattress.';
        } else {
            accommodationText += '.';
        }

        // =================================================
        // RECOMMENDATION HTML
        // =================================================
        roomsHTML += `
            <p class="fontSize10 fw-bold">Room ${roomNumber}</p>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                    <div class="d-flex justify-content-between mobileDisplayBlock">
                        <div>
                            <p class="fontSize10 fw-bold">
                                <i class="ri-hotel-bed-fill destination-title fs-6"></i>
                                ${bedText}
                            </p>
                            <p class="fontSize10">${accommodationText}</p>
                        </div>
                        <div class="py-1 px-2 text-center text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 userpreferenceBtn fw-bold fontSize10">
                            <span>User Preference</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                    <button class="btn modifyBtn" type="button" data-room="${roomNumber}">Modify Rooms</button>
                </div>
            </div>

        `;
    });

    // =====================================================
    // ADD ROOM BUTTON
    // =====================================================

    roomsHTML += `
        <div class="d-flex justify-content-center">
            <button class="btn addRoomBtn" type="button">Add Room (If more travellers)</button>
        </div>
    `;

    // =====================================================
    // UPDATE ONLY CONTENT
    // =====================================================

    $('#roomRecommendation').html(roomsHTML);
}
//coupon drop down
function updateCouponDropdowns() {
    const selectedCoupons = [];
    let selectedPrimaryCoupons = 0;
    /*
    |--------------------------------------------------------------------------
    | Get all currently selected coupons
    |--------------------------------------------------------------------------
    */
    $('.coupon-select').each(function () {
        const value = $(this).val();
        if (value !== '') {
            selectedCoupons.push(value);
            const type = $(this)
                .find('option:selected')
                .data('type');
            if (type === 'primary') {
                selectedPrimaryCoupons++;
            }
        }
    });
    /*
    |--------------------------------------------------------------------------
    | Primary coupons are considered exhausted
    | when all available primary coupons are selected
    |--------------------------------------------------------------------------
    */
    const primaryCouponsExhausted =
        totalPrimaryCoupons === 0 ||
        selectedPrimaryCoupons >= totalPrimaryCoupons;
    /*
    |--------------------------------------------------------------------------
    | Update all dropdowns
    |--------------------------------------------------------------------------
    */
    $('.coupon-select').each(function () {
        const $select = $(this);
        const currentValue = $select.val();
        $select.find('option').each(function () {
            const $option = $(this);
            const value = $option.val();
            const type = $option.data('type');
            // Skip placeholder
            if (!value) {
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | Disable coupon already selected in another dropdown
            |--------------------------------------------------------------------------
            */
            if (
                selectedCoupons.includes(value) &&
                value !== currentValue
            ) {

                $option.prop('disabled', true);

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Loyalty coupons
            |--------------------------------------------------------------------------
            */

            if (type === 'loyalty') {

                /*
                * Enable loyalty only when all
                * available primary coupons are selected
                */
                if (!primaryCouponsExhausted) {

                    $option.prop('disabled', true);

                } else {

                    $option.prop('disabled', false);

                }

            } else {

                /*
                * Primary coupon is available
                */
                $option.prop('disabled', false);

            }

        });

    });

    // calculate total selected coupon discount
    let totalDiscount = 0;

    $('.coupon-select').each(function () {

        const selectedOption =
            $(this).find('option:selected');

        const amount =
            parseFloat(selectedOption.data('amount')) || 0;

        if ($(this).val() !== '') {
            totalDiscount += amount;
        }
    });

    // Update discount display
    $('#totalCouponDiscount').text(
        '- ₹ ' + totalDiscount.toLocaleString('en-IN')
    );

    // Update final package price
    updateFinalPackagePrice();

}
// =====================================================
// GENERATE COUPON DROPDOWNS
// =====================================================

function generateCouponDropdowns() {

    const adults =
        parseInt($('#adultCount').val()) || 0;

    const children =
        parseInt($('#childrenCount').val()) || 0;

    const container =
        $('#couponPassengerContainer');

    container.empty();

    // Create Adult rows
    for (let i = 1; i <= adults; i++) {

        container.append(
            createCouponRow('Adult', i)
        );

    }

    // Create Child rows
    for (let i = 1; i <= children; i++) {

        container.append(
            createCouponRow('Child', i)
        );

    }

    updateCouponDropdowns();

    // Reset total coupon discount
    updateTotalCouponDiscount();

}

// =====================================================
// UPDATE TOTAL COUPON DISCOUNT
// =====================================================

function updateTotalCouponDiscount() {

    let totalDiscount = 0;

    $('.coupon-select').each(function () {

        const selectedOption =
            $(this).find('option:selected');

        const amount =
            parseFloat(
                selectedOption.data('amount')
            ) || 0;

        totalDiscount += amount;

    });

    $('#totalCouponDiscount').text(
        '- ₹ ' + totalDiscount.toLocaleString('en-IN')
    );

}
// =====================================================
// UPDATE FINAL PACKAGE PRICE
// =====================================================

function updateFinalPackagePrice() {

    const adults =
        parseInt($('#adultCount').val()) || 0;

    const children =
        parseInt($('#childrenCount').val()) || 0;


    // =====================================================
    // ADULT TOTAL
    // =====================================================

    const adultTotal =
        adults * perAdultPrice;


    // =====================================================
    // CHILD TOTAL
    // =====================================================

    const childrenTotal =
        children * perChildPrice;


    // =====================================================
    // COUPON DISCOUNT
    // =====================================================

    const couponDiscount =
        getAmount("#totalCouponDiscount");


    // =====================================================
    // TOTAL AFTER COUPON
    // =====================================================

    const totalAfterCoupon =
        Math.max(
            0,
            adultTotal +
            childrenTotal -
            couponDiscount
        );


    // =====================================================
    // APPLIED REFERRAL WALLET
    // =====================================================

    const referralWallet =
        getAmount("#appliedReferralWallet");


    // =====================================================
    // APPLIED DISCOUNT WALLET
    // =====================================================

    const discountWallet =
        getAmount("#appliedDiscountWallet");


    // =====================================================
    // TOTAL WALLET DEDUCTION
    // =====================================================

    const totalWalletDeduction =
        referralWallet +
        discountWallet;


    // =====================================================
    // AMOUNT AFTER WALLET
    // =====================================================

    const amountAfterWallet =
        Math.max(
            0,
            totalAfterCoupon -
            totalWalletDeduction
        );


    // =====================================================
    // CONVENIENCE FEE - 1%
    // CALCULATED AFTER WALLET
    // =====================================================

    const convenienceFee =
        amountAfterWallet * 0.01;


    // =====================================================
    // GST
    // CALCULATED ON CONVENIENCE FEE
    // =====================================================

    const gstValue =
        convenienceFee * (gstPercentage / 100);


    // =====================================================
    // FINAL PAYABLE AMOUNT
    // =====================================================

    const finalAmount =
        amountAfterWallet +
        convenienceFee +
        gstValue;


    // =====================================================
    // FORMAT FINAL AMOUNT
    // =====================================================

    const formattedFinalAmount =
        finalAmount.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });


    // =====================================================
    // UPDATE FINAL PACKAGE PRICE
    // =====================================================

    $('#finalPackagePrice').text(
        '₹ ' + formattedFinalAmount
    );

    $('#finalPackagePrice1').text(
        '₹ ' + formattedFinalAmount
    );

    $('#finalPackagePrice2').text(
        '₹ ' + formattedFinalAmount
    );


    // =====================================================
    // UPDATE CONVENIENCE FEE
    // =====================================================

    $('#convenienceFeee').text(
        '₹ ' + convenienceFee.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })
    );


    // =====================================================
    // UPDATE GST
    // =====================================================

    $('#gstValue').text(
        '₹ ' + gstValue.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })
    );
}
function getAmount(selector) {

    const element = $(selector);

    if (!element.length) {
        return 0;
    }

    let value;

    // For input fields
    if (element.is('input, select, textarea')) {
        value = element.val();
    } 
    // For normal HTML elements
    else {
        value = element.text();
    }

    if (value === null || value === undefined || value === '') {
        return 0;
    }

    // Remove ₹, commas, spaces, etc.
    value = String(value)
        .replace(/[^\d.-]/g, '');

    return parseFloat(value) || 0;
}
function updateSelectedVehicleText() {

    const adults =
        parseInt($('#adultCount').val()) || 0;

    const children =
        parseInt($('#childrenCount').val()) || 0;

    const infants =
        parseInt($('#infantCount').val()) || 0;

    const totalPax =
        adults + children + infants;

    const currentText =
        $('#selectedVehicleText').text();

    const vehicleName =
        currentText.replace(/\s*\(For\s+\d+\s+Pax\)/i, '');

    $('#selectedVehicleText').text(
        vehicleName + ' (For ' + totalPax + ' Pax)'
    );
}
// Guest Counter
$('.guest-counter').each(function () {

    const $counter = $(this);

    const $minusBtn = $counter.find('.minus');
    const $plusBtn = $counter.find('.plus');
    const $input = $counter.find('.counter-value');


    // Minus button
    $minusBtn.on('click', function () {

        let value = parseInt($input.val()) || 0;

        const minValue = $counter
            .find('.guest-label')
            .text()
            .includes('Adults') ? 1 : 0;


        if (value > minValue) {

            $input.val(value - 1);

            // Trigger price calculation
            $input.trigger('change');

        }

    });


    // Plus button
    $plusBtn.on('click', function () {

        let value = parseInt($input.val()) || 0;

        $input.val(value + 1);

        // Trigger price calculation
        $input.trigger('change');

    });

});
// =====================================================
// Adult Count Change
// =====================================================

$('#adultCount').on('change', function () {

    const adultCount =
        parseInt($(this).val()) || 0;

    const adultTotal =
        adultCount * perAdultPrice;

    $('#totalAdultCount').text(adultCount);

    animatePrice(
        $('#adultTotal'),
        adultTotal,
        '₹ '
    );

    // Update subtotal
    updateSubTotal();

    // Update room recommendation
    updateRecommendedRooms();

    // Update coupon passenger rows
    generateCouponDropdowns();

    //update final price
    updateFinalPackagePrice();
    // Update vehicle text
    updateSelectedVehicleText();
});


// =====================================================
// Children Count Change
// =====================================================

$('#childrenCount').on('change', function () {

    const childrenCount =
        parseInt($(this).val()) || 0;

    const childrenTotal =
        childrenCount * perChildPrice;

    $('#totalChildrenCount').text(childrenCount);

    animatePrice(
        $('#childrenTotal'),
        childrenTotal,
        '₹ '
    );

    // Update subtotal
    updateSubTotal();

    // Update room recommendation
    updateRecommendedRooms();

    // Update coupon passenger rows
    generateCouponDropdowns();

    //update final price
    updateFinalPackagePrice();
    // Update vehicle text
    updateSelectedVehicleText();

});

// =====================================================
// Children Count Change
// =====================================================

$('#infantCount').on('change', function () {

    const infantCount =
        parseInt($(this).val()) || 0;

    const childrenTotal =
        infantCount * perChildPrice;

    $('#totalInfantCount').text(infantCount);

    animatePrice(
        $('#childrenTotal'),
        childrenTotal,
        '₹ '
    );

    // Update subtotal
    updateSubTotal();

    // Update room recommendation
    updateRecommendedRooms();

    // Update coupon passenger rows
    generateCouponDropdowns();

    //update final price
    updateFinalPackagePrice();
    // Update vehicle text
    updateSelectedVehicleText();

});
// Travel Date Update
$('#travelStartDate').on('change', function () {

    const startDate = $(this).val();

    if (!startDate || !tourDays) {
        return;
    }

    const totalDays = parseInt(tourDays);

    if (totalDays <= 0) {
        return;
    }

    const $endDate = $('#travelEndDate');

    // Stop previous animation
    clearInterval($endDate.data('dateAnimation'));

    const start = new Date(startDate);

    let currentDate = new Date(start);
    let currentDay = 1;

    // Show starting date
    $endDate.val(
        currentDate.toISOString().split('T')[0]
    );

    // Day 1 means no calculation needed
    if (totalDays === 1) {
        return;
    }

    const dateAnimation = setInterval(function () {

        // Add exactly one day
        currentDate.setDate(
            currentDate.getDate() + 1
        );

        currentDay++;

        // Update the input directly
        $endDate.val(
            currentDate.toISOString().split('T')[0]
        );

        // Stop at final day
        if (currentDay >= totalDays) {

            clearInterval(dateAnimation);

            $endDate.data(
                'dateAnimation',
                null
            );
        }

    }, 120);

    // Store animation
    $endDate.data(
        'dateAnimation',
        dateAnimation
    );
});
//pickup drop change value 
$('.location-input').on('blur', function () {

    const $input = $(this);

    const oldValue = $input.data('old-value');
    const newValue = $.trim($input.val());

    // Show old value only if changed
    if (newValue !== oldValue) {

        if ($input.attr('id') === 'pickupLocation') {
            $('#pickupOldValue')
                .html('Previous Pickup: </br>' + oldValue)
                .show();
        }

        if ($input.attr('id') === 'dropLocation') {
            $('#dropOldValue')
                .html('Previous Drop: </br>' + oldValue)
                .show();
        }

    } else {

        if ($input.attr('id') === 'pickupLocation') {
            $('#pickupOldValue').hide();
        }

        if ($input.attr('id') === 'dropLocation') {
            $('#dropOldValue').hide();
        }
    }
});
//trigger room modification modal
$(document).on('click', '.modifyBtn', function (e) {

    e.preventDefault();

    const roomNumber = parseInt($(this).data('room')) || 1;

    const adults =
        parseInt($('#adultCount').val()) || 0;

    const children =
        parseInt($('#childrenCount').val()) || 0;

    const infants =
        parseInt($('#infantCount').val()) || 0;

    console.log('Total Adults:', adults);
    console.log('Total Children:', children);
    console.log('Total Infants:', infants);

    loadModifyRooms(
        adults,
        children,
        infants
    );

    const modalElement =
        document.getElementById('modifyRoomsModal');

    const modal =
        bootstrap.Modal.getOrCreateInstance(modalElement);

    modal.show();

});
// =====================================================
// APPLY ROOM MODIFICATION
// =====================================================

$(document).on('click', '#applyRoomModification', function () {
    const adults = parseInt($('#adultCount').val()) || 0;
    const children = parseInt($('#childrenCount').val()) || 0;
    const infants = parseInt($('#infantCount').val()) || 0;
    const totalTravellers = adults + children;
    let roomOccupancies = [];
    let totalRoomOccupancy = 0;

    // =================================================
    // READ ROOMS
    // =================================================

    $('#modifyRoomsContainer .modify-room-card').each(function () {
        const occupancy = parseInt($(this).find('.room-occupancy').val()) || 0;
        const extraMattress = $(this).find('.extra-mattress').is(':checked');
        roomOccupancies.push({
            occupancy: occupancy,
            extraMattress: extraMattress
        });
        totalRoomOccupancy += occupancy;
    });

    // =================================================
    // VALIDATE ROOM OCCUPANCY
    // =================================================

    if (totalRoomOccupancy !== totalTravellers) {

        Swal.fire({
            icon: 'warning',
            title: 'Invalid Room Occupancy',
            text: 'Room occupancy must match the total number of Adults and Children.',
            confirmButtonText: 'Okay'
        });

        return;
    }

    // =================================================
    // UPDATE RECOMMENDATION
    // USING USER'S ROOM ARRANGEMENT
    // =================================================

    updateRecommendedRoomsFromModification(
        roomOccupancies,
        adults,
        children,
        infants
    );


    // =================================================
    // CLOSE MODAL
    // =================================================

    const modalElement = document.getElementById('modifyRoomsModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }

});
// =====================================================
// ROOM OCCUPANCY PLUS
// =====================================================

$(document).on('click', '.occupancy-plus', function () {
    const roomCard = $(this).closest('.modify-room-card');
    const occupancyInput = roomCard.find('.room-occupancy');
    let occupancy = parseInt(occupancyInput.val()) || 0;

    // =================================================
    // MAX 3 PEOPLE PER ROOM
    // =================================================

    if (occupancy >= 3) {
        return;
    }

    // =================================================
    // TOTAL AVAILABLE OCCUPANCY
    // ADULTS + CHILDREN
    // =================================================

    const adults = parseInt($('#adultCount').val()) || 0;
    const children = parseInt($('#childrenCount').val()) || 0;
    const totalTravellers = adults + children;

    // =================================================
    // CURRENT OCCUPANCY OF ALL ROOMS
    // =================================================

    let currentTotal = 0;
    $('#modifyRoomsContainer .room-occupancy').each(function () {
        currentTotal += parseInt($(this).val()) || 0;
    });

    // =================================================
    // DON'T EXCEED TOTAL TRAVELLERS
    // =================================================

    if (currentTotal >= totalTravellers) {
        return;
    }

    // =================================================
    // INCREASE
    // =================================================
    occupancy++;
    occupancyInput.val(occupancy);

    // =================================================
    // UPDATE EXTRA MATTRESS
    // =================================================

    updateRoomExtraMattress(roomCard);
});
// =====================================================
// ROOM OCCUPANCY MINUS
// =====================================================

$(document).on('click', '.occupancy-minus', function () {
    const roomCard = $(this).closest('.modify-room-card');
    const occupancyInput = roomCard.find('.room-occupancy');
    let occupancy = parseInt(occupancyInput.val()) || 0;

    // =================================================
    // MINIMUM 1 PERSON PER ROOM
    // =================================================

    if (occupancy <= 1) {
        return;
    }

    occupancy--;
    occupancyInput.val(occupancy);

    // =================================================
    // UPDATE EXTRA MATTRESS
    // =================================================

    updateRoomExtraMattress(roomCard);
});
// =====================================================
// ADD ROOM
// =====================================================

$(document).on('click', '#addModifyRoom', function () {

    const container = $('#modifyRoomsContainer');

    const roomCount = container.find('.modify-room-card').length;

    const newRoomNumber = roomCount + 1;


    const roomHTML = `
        <div class="modify-room-card mb-3"
            data-room="${newRoomNumber}">

            <div class="room-content-row">

                <!-- ROOM TITLE -->
                <div class="room-title">

                    <p class="fontSize10 fw-bold mb-0">
                        Room ${newRoomNumber}
                    </p>

                </div>


                <!-- ROOM OCCUPANCY -->
                <div class="occupancy-section">

                    <label class="fontSize10 fw-bold mb-0">
                        Room Occupancy
                    </label>

                    <div class="occupancy-control">

                        <button type="button"
                                class="occupancy-minus">
                            -
                        </button>

                        <input type="text"
                            class="form-control text-center room-occupancy"
                            value="1"
                            readonly>

                        <button type="button"
                                class="occupancy-plus">
                            +
                        </button>

                    </div>

                </div>


                <!-- EXTRA MATTRESS -->
                <div class="mattress-section">

                    <div class="form-check mb-0">

                        <input class="form-check-input extra-mattress"
                            type="checkbox"
                            id="extraMattress${newRoomNumber}">

                        <label class="form-check-label fontSize10"
                            for="extraMattress${newRoomNumber}">
                            With Extra Mattress
                        </label>

                    </div>

                </div>


                <!-- REMOVE ROOM -->
                <div class="ms-auto">

                    <button type="button"
                            class="removeModifyRoom">
                        Remove
                    </button>

                </div>

            </div>

        </div>
    `;

    container.append(roomHTML);

});
// =====================================================
// REMOVE ROOM
// =====================================================

$(document).on('click', '.removeModifyRoom', function () {

    $(this)
        .closest('.modify-room-card')
        .remove();

    renumberModifyRooms();
});
//add button
$(document).on('click', '.addRoomBtn', function () {
    const adults = parseInt($('#adultCount').val()) || 0;
    const children = parseInt($('#childrenCount').val()) || 0;
    const infants = parseInt($('#infantCount').val()) || 0;
    loadModifyRooms(
        adults,
        children,
        infants
    );
    const modalElement = document.getElementById('modifyRoomsModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    modal.show();
});
//vechel modal show
$(document).on('click', '#changeVehicle', function (e) {

    e.preventDefault();

    const modalElement =
        document.getElementById('vehicleSelectionModal');

    const modal =
        bootstrap.Modal.getOrCreateInstance(modalElement);

    modal.show();

});
let selectedVehicle = null;


// =====================================================
// SELECT VEHICLE
// =====================================================

$(document).on('click', '.vehicle-option', function () {

    $('.vehicle-option').removeClass('active');

    $(this).addClass('active');

    selectedVehicle = {
        value: $(this).data('value'),
        name: $(this).data('name')
    };

});


// =====================================================
// APPLY VEHICLE
// =====================================================

$(document).on('click', '#applyVehicleSelection', function () {

    if (!selectedVehicle) {

        alert('Please select a vehicle.');

        return;
    }

    // Get total travellers
    const adults =
        parseInt($('#adultCount').val()) || 0;

    const children =
        parseInt($('#childrenCount').val()) || 0;

    const infants =
        parseInt($('#infantCount').val()) || 0;

    // Pax for vehicle
    const totalPax = adults + children + infants;


    // Update vehicle text
    $('#selectedVehicleText').text(
        selectedVehicle.name + ' (For ' + totalPax + ' Pax)'
    );


    // Store selected vehicle
    $('#vehicle_id').val(selectedVehicle.value);


    // Close modal
    const modalElement =
        document.getElementById('vehicleSelectionModal');

    const modal =
        bootstrap.Modal.getInstance(modalElement);

    if (modal) {
        modal.hide();
    }

});

// =====================================================
// COUPON CHANGE
// =====================================================

$(document).on('change', '.coupon-select', function () {
    const $select = $(this);
    const selectedOption =
        $select.find('option:selected');
    const amount =
        parseFloat(
            selectedOption.data('amount')
        ) || 0;
    // Update individual passenger discount
    const row =
        $select.closest('.coupon-passenger-row');
    row.find('.coupon-discount').text(
        '- ₹ ' + amount.toLocaleString('en-IN')
    );

    // Update coupon restrictions
    updateCouponDropdowns();

    // Update total coupon discount
    updateTotalCouponDiscount();

    //update final price
    updateFinalPackagePrice();

});

// =====================================================
// PACKAGE COUPON CHANGE
// =====================================================

$(document).on('change', '#packageCouponSelect', function () {

    const $select = $(this);

    const amount =
        parseFloat(
            $select.find('option:selected').data('amount')
        ) || 0;

    // Individual coupon discount
    $('#packageCouponDiscount').text(
        '₹ ' + amount.toLocaleString('en-IN')
    );

    // Total coupon discount
    $('#totalCouponDiscount').text(
        '- ₹ ' + amount.toLocaleString('en-IN')
    );

    //update final price
    updateFinalPackagePrice();

});
// =====================================================
// ON PAGE LOAD
// =====================================================

$(document).ready(function () {

    // =====================================================
    // PASSENGER COUPONS
    // =====================================================

    generateCouponDropdowns();


    // =====================================================
    // PACKAGE COUPON
    // =====================================================

    $('#packageCouponDiscount').text('₹ 0');

    $('#totalCouponDiscount').text('- ₹ 0');

    const today = new Date();

    // Add 2 days
    today.setDate(today.getDate() + 2);

    // Format YYYY-MM-DD
    const minDate =
        today.getFullYear() + "-" +
        String(today.getMonth() + 1).padStart(2, "0") + "-" +
        String(today.getDate()).padStart(2, "0");

    // Prevent previous dates and next 2 days
    $('#travelStartDate').attr('min', minDate);

    setupWalletInput(
        'referralWalletBalance',
        'appliedReferralWallet'
    );

    setupWalletInput(
        'discountWalletBalance',
        'appliedDiscountWallet'
    );

    // =====================================================
    // STORE ORIGINAL VALUES
    // =====================================================

    let oldHotelCategory = $('#hotelCategory').val();
    let oldMealPreference = $('#mealPreference').val();
    let oldTransportPreference = $('#transportPreference').val();


    // =====================================================
    // HOTEL CATEGORY CHANGE
    // =====================================================

    $('#hotelCategory').on('change', function () {

        let newValue = $(this).val();

        if (newValue !== oldHotelCategory) {

            let oldText = $('#hotelCategory option[value="' + oldHotelCategory + '"]').text().trim();

            $('#oldHotelCategory')
                .removeClass('d-none')
                .html('Previous: <strong>' + oldText + '</strong>');

        } else {

            $('#oldHotelCategory')
                .addClass('d-none')
                .html('');
        }
    });


    // =====================================================
    // MEAL CHANGE
    // =====================================================

    $('#mealPreference').on('change', function () {

        let newValue = $(this).val();

        if (newValue !== oldMealPreference) {

            let oldText = $('#mealPreference option[value="' + oldMealPreference + '"]').text().trim();

            $('#oldMealPreference')
                .removeClass('d-none')
                .html('Previous: <strong>' + oldText + '</strong>');

        } else {

            $('#oldMealPreference')
                .addClass('d-none')
                .html('');
        }
    });


    // =====================================================
    // TRANSPORT CHANGE
    // =====================================================

    $('#transportPreference').on('change', function () {

        let newValue = $(this).val();

        if (newValue !== oldTransportPreference) {

            let oldText = $('#transportPreference option[value="' + oldTransportPreference + '"]').text().trim();

            $('#oldTransportPreference')
                .removeClass('d-none')
                .html('Previous: <strong>' + oldText + '</strong>');

        } else {

            $('#oldTransportPreference')
                .addClass('d-none')
                .html('');
        }
    });


});
//referral and discount wallet logic 
function setupWalletInput(balanceElementId, inputElementId) {

    const balanceElement = document.getElementById(balanceElementId);
    const inputElement = document.getElementById(inputElementId);

    if (!balanceElement || !inputElement) {
        return;
    }

    function getBalance() {

        // Example text: "- ₹ 1,500"
        let balanceText = balanceElement.textContent || '';

        // Remove everything except numbers and decimal
        balanceText = balanceText.replace(/[^0-9.]/g, '');

        return parseFloat(balanceText) || 0;
    }

    function updateWalletInput() {

        const balance = getBalance();

        inputElement.max = balance;

        if (balance <= 0) {

            inputElement.value = 0;
            inputElement.disabled = true;

        } else {

            inputElement.disabled = false;

            let currentValue = parseFloat(inputElement.value) || 0;

            if (currentValue > balance) {
                currentValue = balance;
            }

            if (currentValue < 0) {
                currentValue = 0;
            }

            inputElement.value = currentValue;
        }

        // Trigger your subtotal/price calculation here
        if (typeof updateFinalPackagePrice === 'function') {
            updateFinalPackagePrice();
        }
    }

    // Prevent value greater than balance
    inputElement.addEventListener('input', function () {

        const balance = getBalance();

        let value = parseFloat(this.value) || 0;

        if (value < 0) {
            value = 0;
        }

        if (value > balance) {
            value = balance;
        }

        this.value = value;

        if (typeof updateFinalPackagePrice === 'function') {
            updateFinalPackagePrice();
        }
    });

    // Also validate when user leaves the field
    inputElement.addEventListener('blur', function () {

        const balance = getBalance();

        let value = parseFloat(this.value) || 0;

        if (value < 0) {
            value = 0;
        }

        if (value > balance) {
            value = balance;
        }

        this.value = value;

        if (typeof updateFinalPackagePrice === 'function') {
            updateFinalPackagePrice();
        }
    });

    updateWalletInput();
}
// =====================================================
// SUBMIT REQUEST
// =====================================================

$("#submitRequst").on("click", function (e) {
    e.preventDefault();
    const submitBtn = $(this);
    // =====================================================
    // TRAVEL & TRANSPORT DETAILS
    // =====================================================
    const travelStartDate = $("#travelStartDate").val().trim();
    const travelEndDate = $("#travelEndDate").val().trim();
    const transportPreference = $("#transportPreference").val() || "";
    // =====================================================
    // REQUIRED VALIDATION
    // =====================================================
    // Travel Start Date
    if (!travelStartDate) {
        Swal.fire({
            icon: "warning",
            title: "Travel Date Required",
            text: "Please select your travel start date.",
            confirmButtonText: "OK"
        });
        $("#travelStartDate").focus();
        return;
    }
    // Travel End Date
    if (!travelEndDate) {
        Swal.fire({
            icon: "warning",
            title: "Travel Date Required",
            text: "Please select your travel end date.",
            confirmButtonText: "OK"
        });
        $("#travelEndDate").focus();
        return;
    }
    // =====================================================
    // DATE ORDER VALIDATION
    // =====================================================
    const startDate = new Date(travelStartDate);
    const endDate = new Date(travelEndDate);
    if (endDate < startDate) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Travel Dates",
            text: "Travel end date cannot be before the start date.",
            confirmButtonText: "OK"
        });
        $("#travelEndDate").focus();
        return;
    }
    // =====================================================
    // TRANSPORT VALIDATION
    // =====================================================
    if (!transportPreference) {
        Swal.fire({
            icon: "warning",
            title: "Transport Required",
            text: "Please select your transport preference.",
            confirmButtonText: "OK"
        });
        $("#transportPreference").focus();
        return;
    }
    // =====================================================
    // GUEST DETAILS
    // =====================================================
    let guestFullName = "";
    let guestPhone = "";
    let guestEmail = "";
    // Check whether guest fields exist in DOM
    const guestFieldsExist =
        $("#guestFullName").length > 0 ||
        $("#guestPhone").length > 0 ||
        $("#guestEmail").length > 0;
    if (guestFieldsExist) {
        // Get guest values
        guestFullName = $.trim($("#guestFullName").val() || "");
        guestPhone = $.trim($("#guestPhone").val() || "");
        guestEmail = $.trim($("#guestEmail").val() || "");
        // -------------------------------------------------
        // Guest Name
        // -------------------------------------------------
        if (!guestFullName) {
            Swal.fire({
                icon: "warning",
                title: "Guest Name Required",
                text: "Please enter the guest full name.",
                confirmButtonText: "OK"
            });

            $("#guestFullName").focus();
            return;
        }
        // -------------------------------------------------
        // Guest Phone
        // -------------------------------------------------
        if (!guestPhone) {

            Swal.fire({
                icon: "warning",
                title: "Guest Phone Required",
                text: "Please enter the guest phone number.",
                confirmButtonText: "OK"
            });

            $("#guestPhone").focus();
            return;
        }
        // -------------------------------------------------
        // Guest Email
        // -------------------------------------------------
        if (!guestEmail) {
            Swal.fire({
                icon: "warning",
                title: "Guest Email Required",
                text: "Please enter the guest email address.",
                confirmButtonText: "OK"
            });
            $("#guestEmail").focus();
            return;
        }
    }
    // =====================================================
    // PREVENT DOUBLE CLICK
    // =====================================================
    if (submitBtn.hasClass("loading")) {
        return;
    }
    submitBtn.addClass("loading");
    submitBtn.prop("disabled", true);
    // =====================================================
    // BASIC PACKAGE DETAILS
    // =====================================================
    const packageId = $("#packageId").val() || "";
    // =====================================================
    // TRAVELLER & TRIP DETAILS
    // =====================================================
    const pickupLocation = $("#pickupLocation").val();
    const dropLocation = $("#dropLocation").val();
    const adults = parseInt($("#adultCount").val()) || 0;
    const children = parseInt($("#childrenCount").val()) || 0;
    const infants = parseInt($("#infantCount").val()) || 0;
    // =====================================================
    // PREFERENCES
    // =====================================================
    const hotelCategory = $("#hotelCategory").val() || "";
    const mealPreference = $("#mealPreference").val() || "";
    const specialRequirement = $("#specialRequirement").val() || "";
    const transportType =  $('#selectedVehicleText').text();
    const oldHotelCategory = $("#hotelCategory").val() || "";
    const oldMealPreference = $("#mealPreference").val() || "";
    const oldTransportPreference = $("#transportPreference").val() || "";
    // =====================================================
    // PRICING
    // =====================================================
    const totalAdultCount = parseInt($("#totalAdultCount").text()) || 0;
    const totalChildrenCount = parseInt($("#totalChildrenCount").text()) || 0;
    const totalInfantCount = parseInt($("#totalInfantCount").text()) || 0;
    // =====================================================
    // GET AMOUNT
    // =====================================================
    function getAmount(selector) {
        let value = $(selector).text() || "0";
        value = value
            .replace(/₹/g, "")
            .replace(/,/g, "")
            .replace(/-/g, "")
            .trim();
        return parseFloat(value) || 0;
    }
    const adultTotal = getAmount("#adultTotal");
    const childrenTotal = getAmount("#childrenTotal");
    const subTotal = getAmount("#subTotal");
    const convenienceFee = getAmount("#convenienceFeee");
    const gstValue = getAmount("#gstValue");
    const couponDiscount = getAmount("#totalCouponDiscount");
    const referralWallet = getAmount("#appliedReferralWallet");
    const discountWallet = getAmount("#appliedDiscountWallet");
    const finalPackagePrice = getAmount("#finalPackagePrice");
    // =====================================================
    // COUPONS
    // =====================================================
    const coupons = [];
    // -----------------------------------------------------
    // PASSENGER COUPONS
    // -----------------------------------------------------
    $("#couponPassengerContainer .coupon-passenger-row").each(function () {
        const select = $(this).find(".coupon-select");
        if (select.length && select.val()) {
            const selectedOption = select.find("option:selected");
            // Get Adult 1 / Adult 2 / Child 1 etc.
            const passenger =
                $(this)
                    .find("p.fontSize10")
                    .first()
                    .text()
                    .trim();
            coupons.push({
                passenger: passenger || "",
                code: select.val(),
                type:
                    selectedOption.data("type") || "",
                amount:
                    parseFloat(
                        selectedOption.data("amount")
                    ) || 0
            });
        }
    });
    // -----------------------------------------------------
    // NORMAL CUSTOMER - ONE COUPON PER PACKAGE
    // -----------------------------------------------------
    const packageCoupon = $("#packageCouponSelect").val();
    if (packageCoupon) {
        const selectedOption = $("#packageCouponSelect option:selected");
        coupons.push({
            passenger: "package",
            code: packageCoupon,
            type:
                selectedOption.data("type") || "",
            amount:
                parseFloat(
                    selectedOption.data("amount")
                ) || 0
        });
    }
    // =====================================================
    // ROOM DETAILS
    // =====================================================
    let rooms = [];
    $("#roomRecommendation").each(function () {
        const room = {
            room_number:
                $(this)
                    .find(".fontSize10.fw-bold")
                    .first()
                    .text()
                    .trim(),
            description:
                $(this)
                    .find(".ri-hotel-bed-fill")
                    .parent()
                    .text()
                    .trim(),
            recommendation:
                $(this)
                    .find(".recommendedBtn")
                    .text()
                    .trim()
        };
        rooms.push(room);
    });
    // =====================================================
    // CREATE FORM DATA
    // =====================================================
    const formData = new FormData();
    // =====================================================
    // PACKAGE
    // =====================================================
    formData.append("package_id", packageId);
    // =====================================================
    // TRIP
    // =====================================================
    formData.append("travel_start_date", travelStartDate);
    formData.append("travel_end_date", travelEndDate);
    formData.append("pickup_location", pickupLocation);
    formData.append("drop_location", dropLocation);
    // =====================================================
    // TRAVELLERS
    // =====================================================
    formData.append("adults", adults);
    formData.append("children", children);
    formData.append("infants", infants);
    // =====================================================
    // GUEST DETAILS
    // =====================================================
    formData.append("guestFullName", guestFullName);
    formData.append("guestPhone", guestPhone);
    formData.append("guestEmail", guestEmail);
    formData.append("userId", userId);
    formData.append("userTypeIdValue", userTypeIdValue);
    // =====================================================
    // PREFERENCES
    // =====================================================
    formData.append("hotel_category", hotelCategory);
    formData.append("meal_preference", mealPreference);
    formData.append("transport_preference", transportPreference);
    formData.append("transport_type", transportType);
    formData.append("special_requirement", specialRequirement);
    formData.append("old_hotel_category", oldHotelCategory);
    formData.append("old_meal_preference", oldMealPreference);
    formData.append("old_transport_preference", oldTransportPreference);
    // =====================================================
    // PRICING
    // =====================================================
    formData.append("adult_price", perAdultPrice);
    formData.append("child_price", perChildPrice);
    formData.append("adult_count", totalAdultCount);
    formData.append("child_count", totalChildrenCount);
    formData.append("infant_count", totalInfantCount);
    formData.append("adult_total", adultTotal);
    formData.append("children_total", childrenTotal);
    formData.append("subtotal", subTotal);
    formData.append("convenience_fee", convenienceFee);
    formData.append("gst_percentage", gstPercentage);
    formData.append("gst_value", gstValue);
    formData.append("coupon_discount", couponDiscount);
    formData.append("referral_wallet", referralWallet);
    formData.append("discount_wallet", discountWallet);
    formData.append("final_package_price", finalPackagePrice);
    // =====================================================
    // JSON ARRAYS
    // =====================================================
    formData.append("coupons", JSON.stringify(coupons));
    formData.append("rooms", JSON.stringify(rooms));
    // =====================================================
    // AJAX
    // =====================================================
    $.ajax({
        url: "assets/submit/submit_request_quote.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        // =================================================
        // BEFORE SEND
        // =================================================
        beforeSend: function () {
            Swal.fire({
                title: "Submitting Request",
                html: "Please wait while we submit your travel enquiry...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        // =================================================
        // SUCCESS
        // =================================================
        success: function (response) {
            $("#loading-overlay").hide();
            submitBtn.removeClass("loading");
            submitBtn.prop("disabled", false);
            // =============================================
            // SUCCESS RESPONSE
            // =============================================
            if (response.status == 1) {
                Swal.fire({
                    icon: "success",
                    title: "Request Submitted Successfully!",
                    html: `<div class="swal-enquiry-success">
                            <p class="swal-thankyou">
                                Thank you for choosing
                                <strong>Bizzmirth Holidays.</strong>
                            </p>
                            <p class="swal-message">
                                Your travel enquiry has been
                                submitted successfully.
                                Our team will review your request
                                and get back to you soon.
                            </p>
                            <div class="enquiry-number-box">
                                <span class="enquiry-number-label">Enquiry Number</span>
                                <strong>${response.enquiry_no || response.enquiry_number || "N/A"}</strong>
                            </div>
                            <div class="enquiry-details">
                                <div class="enquiry-details-header">
                                    <span><i class="ri-file-list-3-line"></i>Enquiry Details</span>
                                </div>
                                <div class="enquiry-detail-row">
                                    <span>Travel Dates</span>
                                    <strong>
                                        ${travelStartDate || "-"}
                                        ${travelEndDate ? " - " + travelEndDate : ""}
                                    </strong>
                                </div>
                                <div class="enquiry-detail-row">
                                    <span>Travellers</span>
                                    <strong>
                                        ${adults}
                                        Adult${adults != 1 ? "s" : ""}
                                        ${children > 0 ? ", " + children + " Child" + (children != 1 ? "ren" : "") : ""}
                                        ${infants > 0 ? ", " + infants + " Infant" + (infants != 1 ? "s" : "") : ""}
                                    </strong>
                                </div>
                                <div class="enquiry-detail-row">
                                    <span>
                                        Pickup Location
                                    </span>
                                    <strong>
                                        ${pickupLocation || "-"}
                                    </strong>
                                </div>
                                <div class="enquiry-detail-row">
                                    <span>
                                        Drop Location
                                    </span>
                                    <strong>
                                        ${dropLocation || "-"}
                                    </strong>
                                </div>
                                <div class="enquiry-detail-row">
                                    <span>
                                        Package Price
                                    </span>
                                    <strong>
                                        ₹${Number(
                        finalPackagePrice
                    ).toLocaleString(
                        "en-IN",
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    )}
                                    </strong>
                                </div>
                            </div>
                            <div class="whats-next-box">
                                <div class="whats-next-title">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    What's Next?
                                </div>
                                <p>
                                    Our travel expert will review
                                    your enquiry, check availability
                                    and prepare the best possible
                                    quotation for you.
                                </p>
                                <p class="whats-next-small">
                                    We will contact you shortly
                                    with the next steps.
                                </p>
                            </div>
                        </div>
                    `,
                    confirmButtonText: "Done",
                    customClass: {
                        popup: "enquiry-success-popup",
                        confirmButton: "enquiry-confirm-btn"
                    },
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(function () {
                    // =====================================
                    // REFRESH AFTER DONE
                    // =====================================
                    window.location.reload();
                });
            }
            // =============================================
            // SERVER RETURNED STATUS 0
            // =============================================
            else {
                Swal.fire({
                    icon: "error",
                    title: "Unable to Submit",
                    text: response.message || "Unable to submit your request. Please try again."
                });
            }
        },
        // =================================================
        // AJAX ERROR
        // =================================================
        error: function (xhr, status, error) {
            $("#loading-overlay").hide();
            submitBtn.removeClass("loading");
            submitBtn.prop("disabled", false);
            Swal.fire({
                icon: "error",
                title: "Something went wrong",
                text: "Unable to submit the request. Please try again."
            });
        }
    });
});
// Pricing Section
document.addEventListener("DOMContentLoaded", function () {
    const pricingSidebar = document.getElementById("pricingSidebar");
    const openBtn = document.getElementById("openPricingBtn");
    const closeBtn = document.getElementById("closePricing");
    const overlay = document.getElementById("pricingOverlay");
    function openPricing() {
        pricingSidebar.classList.add("show");
        overlay.classList.add("show");
        document.body.style.overflow = "hidden";
    }
    function closePricing() {
        pricingSidebar.classList.remove("show");
        overlay.classList.remove("show");
        document.body.style.overflow = "";
    }
    openBtn.addEventListener("click", openPricing);
    closeBtn.addEventListener("click", closePricing);
    overlay.addEventListener("click", closePricing);
    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closePricing();
        }
    });
});
