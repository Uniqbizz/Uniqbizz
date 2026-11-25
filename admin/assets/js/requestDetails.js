// =====================================================
// CURRENT MODIFIED ROOM CONFIGURATION
// =====================================================

let modifiedRoomConfiguration = null;

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

                const truncatedValue =
                    Math.trunc(now * 100) / 100;

                $element.text(
                    '₹ ' +
                    truncatedValue.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                );
            },

            complete: function () {

                const truncatedFinalValue =
                    Math.trunc(finalValue * 100) / 100;

                $element.text(
                    '₹ ' +
                    truncatedFinalValue.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                );

                $element.data(
                    'current-price',
                    truncatedFinalValue
                );
            }
        }
    );
}

//rooom recomendation
function updateRecommendedRooms() {
    const adults = parseInt($('#adultCount1').val()) || 0;
    const children = parseInt($('#childCount1').val()) || 0;
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
            <div class="roomRecommendationItem">
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
// =====================================================
// LOAD MODIFY ROOMS
// =====================================================

function loadModifyRooms(adults, children, infants) {

    const container = $('#modifyRoomsContainer');

    container.empty();

    // =====================================================
    // TOTAL COUNTS
    // =====================================================

    $('#totalAdults').text(adults);
    $('#totalChildren').text(children);
    $('#totalInfants').text(infants);

    const totalOccupancy = adults + children;

    if (totalOccupancy <= 0) {
        return;
    }

    // =====================================================
    // CHECK PREVIOUS MODIFIED CONFIGURATION
    // =====================================================

    let usePreviousConfiguration = false;

    if (
        Array.isArray(modifiedRoomConfiguration) &&
        modifiedRoomConfiguration.length > 0
    ) {

        const previousTotal = modifiedRoomConfiguration.reduce(
            function (total, room) {
                return total + (parseInt(room.occupancy, 10) || 0);
            },
            0
        );

        const validRooms = modifiedRoomConfiguration.every(
            function (room) {
                const occupancy = parseInt(room.occupancy, 10);

                return Number.isInteger(occupancy) && occupancy >= 0;
            }
        );

        usePreviousConfiguration =
            previousTotal === totalOccupancy &&
            validRooms;
    }

    // =====================================================
    // CREATE ROOM CONFIGURATION
    // =====================================================

    let roomConfiguration = [];

    if (usePreviousConfiguration) {

        roomConfiguration = modifiedRoomConfiguration;

    } else {

        // Maximum 3 people per room
        const rooms = Math.max(
            1,
            Math.ceil(totalOccupancy / 3)
        );

        let remainingOccupancy = totalOccupancy;

        for (let i = 1; i <= rooms; i++) {

            const occupancy = Math.min(
                remainingOccupancy,
                3
            );

            remainingOccupancy -= occupancy;

            roomConfiguration.push({
                occupancy: occupancy,
                extraMattress: occupancy === 3
            });
        }

        // Previous configuration is no longer valid
        modifiedRoomConfiguration = null;
    }

    // =====================================================
    // RENDER ROOMS
    // =====================================================

    roomConfiguration.forEach(function (room, index) {

        const roomNumber = index + 1;

        const occupancy = parseInt(room.occupancy, 10) || 0;

        const extraMattress = room.extraMattress === true;

        const roomHTML = `
            <div class="modify-room-card mb-3"
                data-room="${roomNumber}">

                <div class="room-content-row">

                    <!-- ROOM TITLE -->
                    <div class="room-title">

                        <p class="fontSize10 fw-bold mb-0">
                            Room ${roomNumber}
                        </p>

                    </div>

                    <!-- ROOM OCCUPANCY -->
                    <div class="occupancy-section">

                        <label class="fontSize10 fw-bold mb-0">
                            Room Occupancy
                        </label>

                        <div class="occupancy-control">

                            <button
                                type="button"
                                class="occupancy-minus">
                                -
                            </button>

                            <input
                                type="text"
                                class="form-control text-center room-occupancy"
                                value="${occupancy}"
                                readonly
                            >

                            <button
                                type="button"
                                class="occupancy-plus">
                                +
                            </button>

                        </div>

                    </div>

                    <!-- EXTRA MATTRESS -->
                    <div class="mattress-section">

                        <div class="form-check mb-0">

                            <input
                                class="form-check-input extra-mattress"
                                type="checkbox"
                                id="extraMattress${roomNumber}"
                                ${extraMattress ? 'checked' : ''}
                            >

                            <label
                                class="form-check-label fontSize10"
                                for="extraMattress${roomNumber}">

                                With Extra Mattress

                            </label>

                        </div>

                    </div>

                    <!-- REMOVE ROOM -->
                    ${roomNumber > 1 ? `

                        <div class="ms-auto">

                            <button
                                type="button"
                                class="removeModifyRoom">

                                Remove

                            </button>

                        </div>

                    ` : ''}

                </div>

            </div>
        `;

        container.append(roomHTML);

    });

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
function getModifiedRooms() {

    const rooms = [];

    $('#modifyRoomsContainer .modify-room-card').each(function(index) {

        const roomCard = $(this);

        const occupancy = parseInt(
            roomCard.find('.room-occupancy').val(),
            10
        ) || 0;

        // Ignore empty rooms
        if (occupancy <= 0) {
            return;
        }

        const extraMattress = roomCard.find('.extra-mattress').is(':checked');

        const roomNumber = `Room ${index + 1}`;

        const description = extraMattress
            ? '1 Double Bed + 1 Extra Mattress'
            : '1 Double Bed';

        const accommodation = extraMattress
            ? `${occupancy} Pax will be accommodated in 1 room with extra mattress.`
            : `${occupancy} Pax will be accommodated in 1 room.`;

        rooms.push({
            room_number: roomNumber,
            description: description,
            accommodation: accommodation,
            recommendation: 'User Preference',
            occupancy: occupancy
        });

    });

    return rooms;
}

// =====================================================
// GET TOTAL TRAVELLERS
// =====================================================

function getTotalTravellers() {
    return {
        adults: parseInt($('#adultCount1').val()) || 0,
        children: parseInt($('#childCount1').val()) || 0,
        infants: parseInt($('#infantCount1').val()) || 0
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
    // if (occupancy === 3) {
    //     checkbox.prop('checked', true);
    // } else {
    //     checkbox.prop('checked', false);
    // }
}

// =====================================================
// UPDATE RECOMMENDATION FROM USER MODIFICATION
// =====================================================

function updateRecommendedRoomsFromModification(roomOccupancies, adults, children, infants) {

    let roomsHTML = '';
    let totalExtraMattresses = 0;

    const totalRooms = roomOccupancies.length;
    const totalTravellers = adults + children + infants;

    /*
    |--------------------------------------------------------------------------
    | BUILD ROOM RECOMMENDATIONS
    |--------------------------------------------------------------------------
    */

    roomOccupancies.forEach(function (room, index) {

        const roomNumber = index + 1;
        const occupancy = parseInt(room.occupancy, 10) || 0;
        const extraMattress = room.extraMattress === true;

        if (extraMattress) {
            totalExtraMattresses++;
        }

        /*
        |--------------------------------------------------------------------------
        | BED TEXT
        |--------------------------------------------------------------------------
        */

        let bedText = '1 Double Bed';

        if (extraMattress) {
            bedText += ' + 1 Extra Mattress';
        }

        /*
        |--------------------------------------------------------------------------
        | ACCOMMODATION TEXT
        |--------------------------------------------------------------------------
        */

        let accommodationText =
            occupancy + ' Pax will be accommodated in 1 room';

        if (extraMattress) {
            accommodationText += ' with extra mattress.';
        } else {
            accommodationText += '.';
        }

        /*
        |--------------------------------------------------------------------------
        | ROOM HTML
        |--------------------------------------------------------------------------
        */

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

                            <p class="fontSize10">
                                ${accommodationText}
                            </p>
                        </div>

                        <div class="py-1 px-2 text-center text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 userpreferenceBtn fw-bold fontSize10">
                            <span>User Preference</span>
                        </div>

                    </div>

                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">

                    <button
                        class="btn modifyBtn"
                        type="button"
                        data-room="${roomNumber}">
                        Modify Rooms
                    </button>

                </div>

            </div>
        `;
    });

    /*
    |--------------------------------------------------------------------------
    | ADD ROOM BUTTON
    |--------------------------------------------------------------------------
    */

    roomsHTML += `
        <div class="d-flex justify-content-center">
            <button class="btn addRoomBtn" type="button">
                Add Room (If more travellers)
            </button>
        </div>
    `;

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROOM RECOMMENDATIONS
    |--------------------------------------------------------------------------
    */

    $('#roomRecommendation').html(roomsHTML);

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROOM ALLOCATION SUMMARY
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ROOM TYPE SUMMARY WITH COUNT
    |--------------------------------------------------------------------------
    */

    const roomTypeText = totalRooms > 0
        ? totalRooms + (totalRooms === 1 ? ' Double Bed' : ' Double Beds')
        : 'N/A';

    const mattressText = totalExtraMattresses > 0
        ? totalExtraMattresses + (
            totalExtraMattresses === 1
                ? ' Extra Mattress'
                : ' Extra Mattresses'
        )
        : 'N/A';

    const travellerText = `
        ${totalTravellers}
        (${adults} Adults + ${children} Children + ${infants} Infants)
    `;

    /*
    |--------------------------------------------------------------------------
    | UPDATE EXISTING ROOM ALLOCATION TABLE
    |--------------------------------------------------------------------------
    | Add id="roomAllocationSummaryBody" to the existing tbody.
    |--------------------------------------------------------------------------
    */

    $('#roomAllocationSummaryBody').html(`
        <tr>
            <td>
                ${totalRooms}
                ${totalRooms === 1 ? 'Room' : 'Rooms'}
            </td>

            <td>${travellerText}</td>

            <td>${roomTypeText}</td>

            <td>${mattressText}</td>
        </tr>
    `);

    /*
    |--------------------------------------------------------------------------
    | UPDATE PAX DESCRIPTION
    |--------------------------------------------------------------------------
    */

    $('.paxDescriptionBtn span').html(`
        ${totalTravellers}
        ${totalTravellers === 1 ? 'traveller' : 'travellers'}
        will be accommodated in
        ${totalRooms}
        ${totalRooms === 1 ? 'room' : 'rooms'}.
    `);

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
        parseInt($('#adultCount1').val()) || 0;

    const children =
        parseInt($('#childCount1').val()) || 0;

    const infants =
        parseInt($('#infantCount1').val()) || 0;

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





// Travel Date Update
$('#travelStartDate').on('change', function () {

    const startDate = $(this).val();

    if (!startDate || !tourDays) {
        return;
    }

    const totalDays = parseInt(tourDays)-1;

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
// =====================================================
// OPEN MODIFY ROOM MODAL
// =====================================================

$(document).off('click', '.modifyBtn');

$(document).on('click', '.modifyBtn', function (e) {

    e.preventDefault();

    const adults = parseInt($('#adultCount1').val(), 10) || 0;
    const children = parseInt($('#childCount1').val(), 10) || 0;
    const infants = parseInt($('#infantCount1').val(), 10) || 0;

    console.log('========== OPEN MODIFY ROOMS ==========');
    console.log('Adults:', adults);
    console.log('Children:', children);
    console.log('Infants:', infants);

    loadModifyRooms(adults, children, infants);

    const modalElement = document.getElementById('modifyRoomsModal');

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    modal.show();

});



// =====================================================
// ORIGINAL ROOM CONFIGURATION FROM PHP
// =====================================================

let originalRoomConfiguration = [];
let originalRoomConfigurationSaved = false;

// Save only once from the original PHP data
function storeOriginalRoomConfiguration() {

if (originalRoomConfigurationSaved) {
    return true;
}

if (!Array.isArray(originalPhpRooms) || !originalPhpRooms.length) {
    console.error('Original PHP room configuration not found.');
    return false;
}

originalRoomConfiguration = originalPhpRooms.map(function (room, index) {

    return {
        room_number: room.room_number || 'Room ' + (index + 1),
        description: room.description || '1 Double Bed',
        recommendation: room.recommendation || '',
        occupancy: parseInt(room.occupancy, 10) || 0,
        extraMattress:
            room.extraMattress === true ||
            room.extraMattress == 1 ||
            room.extra_mattress == 1
    };

});

originalRoomConfigurationSaved = true;

console.log(
    'Original PHP room configuration saved:',
    originalRoomConfiguration
);

return true;
}


// =====================================================
// RESET ROOM CONFIGURATION
// =====================================================

$(document).off('click', '#resetRoomModification');

$(document).on('click', '#resetRoomModification', function () {

    console.log('========== RESET ROOM CONFIGURATION ==========');

    if (!storeOriginalRoomConfiguration()) {
        return;
    }

    const container = $('#modifyRoomsContainer');

    // Rebuild every room from the original PHP configuration
    container.empty();

    originalRoomConfiguration.forEach(function (room, index) {

        const roomNumber = index + 1;

        const roomHTML = `
            <div class="modify-room-card mb-3"
                data-room="${roomNumber}">

                <div class="room-content-row">

                    <div class="room-title">
                        <p class="fontSize10 fw-bold mb-0">
                            Room ${roomNumber}
                        </p>
                    </div>

                    <div class="occupancy-section">

                        <label class="fontSize10 fw-bold mb-0">
                            Room Occupancy
                        </label>

                        <div class="occupancy-control">

                            <button type="button" class="occupancy-minus">
                                -
                            </button>

                            <input
                                type="text"
                                class="form-control text-center room-occupancy"
                                value="${room.occupancy}"
                                readonly
                            >

                            <button type="button" class="occupancy-plus">
                                +
                            </button>

                        </div>

                    </div>

                    <div class="mattress-section">

                        <div class="form-check mb-0">

                            <input
                                class="form-check-input extra-mattress"
                                type="checkbox"
                                id="extraMattress${roomNumber}"
                                ${room.extraMattress ? 'checked' : ''}
                            >

                            <label
                                class="form-check-label fontSize10"
                                for="extraMattress${roomNumber}">
                                With Extra Mattress
                            </label>

                        </div>

                    </div>

                    ${roomNumber > 1 ? `
                        <div class="ms-auto">
                            <button type="button" class="removeModifyRoom">
                                Remove
                            </button>
                        </div>
                    ` : ''}

                </div>

            </div>
        `;

        container.append(roomHTML);

    });

    // Restore working configuration
    modifiedRoomConfiguration = originalRoomConfiguration.map(function (room) {

        return {
            occupancy: room.occupancy,
            extraMattress: room.extraMattress
        };

    });

    console.log('Reset configuration:', modifiedRoomConfiguration);

    console.log('========== RESET COMPLETED ==========');

});


// =====================================================
// APPLY ROOM MODIFICATION
// =====================================================

$(document).on('click', '#applyRoomModification', function () {

    const adults = parseInt($('#adultCount1').val(), 10) || 0;
    const children = parseInt($('#childCount1').val(), 10) || 0;
    const infants = parseInt($('#infantCount1').val(), 10) || 0;

    const totalTravellers = adults + children;

    let roomOccupancies = [];
    let totalRoomOccupancy = 0;

    // Read rooms.
    $('#modifyRoomsContainer .modify-room-card').each(function () {

        const occupancy =
            parseInt($(this).find('.room-occupancy').val(), 10) || 0;

        const extraMattress =
            $(this).find('.extra-mattress').is(':checked');

        // Ignore empty rooms
        if (occupancy <= 0) {
            return;
        }

        roomOccupancies.push({
            occupancy: occupancy,
            extraMattress: extraMattress
        });

        totalRoomOccupancy += occupancy;

    });

    // Validate occupancy.
    if (totalRoomOccupancy !== totalTravellers) {

        Swal.fire({
            icon: 'warning',
            title: 'Invalid Room Occupancy',
            text: 'Room occupancy must match the total number of Adults and Children.',
            confirmButtonText: 'Okay'
        });

        return;
    }

    // Save the modified room configuration.
    modifiedRoomConfiguration = roomOccupancies.map(function (room) {

        return {
            occupancy: parseInt(room.occupancy, 10) || 0,
            extraMattress: room.extraMattress === true
        };

    });

    // Update recommendations.
    updateRecommendedRoomsFromModification(
        roomOccupancies,
        adults,
        children,
        infants
    );

    // Close modal.
    const modalElement = document.getElementById('modifyRoomsModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);

    if (modalInstance) {
        modalInstance.hide();
    }

});
// =====================================================
// ROOM OCCUPANCY PLUS
// =====================================================

// =====================================================
// ROOM OCCUPANCY PLUS - ADMIN
// =====================================================

$(document).off('click.roomOccupancy', '#modifyRoomsContainer .occupancy-plus');

$(document).on('click.roomOccupancy', '#modifyRoomsContainer .occupancy-plus', function (e) {

    e.preventDefault();

    console.log('========== ADMIN ROOM PLUS CLICKED ==========');

    const roomCard = $(this).closest('.modify-room-card');
    const occupancyInput = roomCard.find('.room-occupancy');

    if (!roomCard.length || !occupancyInput.length) {
        console.error('Room card or occupancy input not found.');
        return;
    }

    let occupancy = parseInt(occupancyInput.val(), 10) || 0;

    const adults = parseInt($('#adultCount1').val(), 10) || 0;
    const children = parseInt($('#childCount1').val(), 10) || 0;

    const totalTravellers = adults + children;

    let currentTotal = 0;

    $('#modifyRoomsContainer .modify-room-card').each(function () {

        const roomOccupancy =
            parseInt($(this).find('.room-occupancy').val(), 10) || 0;

        currentTotal += roomOccupancy;

    });

    console.log('Current room occupancy:', occupancy);
    console.log('Total allocated:', currentTotal);
    console.log('Total travellers:', totalTravellers);

    if (currentTotal >= totalTravellers) {
        console.warn('All travellers are already allocated.');
        return;
    }

    // No maximum of 3 on admin side
    occupancy++;

    occupancyInput.val(occupancy);

    console.log('Updated room occupancy:', occupancy);

    updateRoomExtraMattress(roomCard);

    console.log('========== ADMIN ROOM PLUS COMPLETED ==========');

});
// =====================================================
// ROOM OCCUPANCY MINUS - ADMIN
// =====================================================

$(document).on('click.roomOccupancy', '#modifyRoomsContainer .occupancy-minus', function (e) {

    e.preventDefault();

    console.log('========== ADMIN ROOM MINUS CLICKED ==========');

    const roomCard = $(this).closest('.modify-room-card');
    const occupancyInput = roomCard.find('.room-occupancy');

    if (!roomCard.length || !occupancyInput.length) {
        console.error('Room card or occupancy input not found.');
        return;
    }

    let occupancy = parseInt(occupancyInput.val(), 10) || 0;

    console.log('Current occupancy:', occupancy);

    if (occupancy <= 0) {
        console.warn('Room occupancy is already zero.');
        return;
    }

    occupancy--;

    occupancyInput.val(occupancy);

    console.log('Updated occupancy:', occupancy);

    if (occupancy === 0) {

        console.log('Removing empty room:', roomCard.attr('data-room'));

        roomCard.remove();

        renumberModifyRooms();

    } else {

        updateRoomExtraMattress(roomCard);

    }

    console.log('Remaining room count:', $('#modifyRoomsContainer .modify-room-card').length);

    console.log('========== ADMIN ROOM MINUS COMPLETED ==========');

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

    const adults =
        parseInt($('#adultCount1').val()) || 0;

    const children =
        parseInt($('#childCount1').val()) || 0;

    const infants =
        parseInt($('#infantCount1').val()) || 0;


    // =====================================================
    // OPEN MODAL WITH CURRENT CONFIGURATION
    // =====================================================

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

    // Remove previous selection
    $('.vehicle-option').removeClass('selected');

    // Highlight clicked vehicle
    $(this).addClass('selected');

    // Store selected vehicle details
    selectedVehicle = {
        value: $(this).data('value'),
        name: $(this).data('name')
    };

    console.log('Selected Vehicle:', selectedVehicle);

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
        parseInt($('#adultCount1').val()) || 0;

    const children =
        parseInt($('#childCount1').val()) || 0;

    const infants =
        parseInt($('#infantCount1').val()) || 0;

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
    // PACKAGE COUPON
    // =====================================================

    $('#packageCouponDiscount').text('₹ 0');

    $('#totalCouponDiscount').text('- ₹ 0');

    setupWalletInput(
        'referralWalletBalance',
        'appliedReferralWallet'
    );

    setupWalletInput(
        'discountWalletBalance',
        'appliedDiscountWallet'
    );
    setupWalletInput(
        'extendedWalletBalance',
        'appliedExtendedWallet'
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