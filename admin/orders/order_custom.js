//show cancel message
$(document).on('click', '.show-cancel-msg', function() {
    const bookingId = $(this).data('id');

    // Clear previous message
    $('#cancelMessage').text('Loading message...');

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('cancelStatusModal'));
    modal.show();

    // Fetch cancellation message from server
    $.ajax({
        url: '../../models/orders/get_cancel_message.php',
        type: 'POST',
        dataType: 'json',
        data: {
            booking_id: bookingId
        },
        success: function(response) {
            if (response.status === 'success') {
                //$('#cancelMessage').text(response.message);
                // If your message includes new lines and you want formatting:
                console.log('res' + response.message);

                $('#cancelMessage').html(response.message.replace(/\n/g, '<br>'));
            } else {
                $('#cancelMessage').text('No message found.');
            }
        },
        error: function() {
            $('#cancelMessage').text('Failed to load message. Please try again.');
        }
    });
});
// Show modal on click
$(document).on('click', '#refundAction', function(e) {
    e.preventDefault();
    const orderId = $(this).data('order-id');
    console.log('Clicked Refund - Order ID:', orderId); // 🔍 Log here

    $('#refundForm').attr('data-order-id', orderId); // ✅ camelCase
    $('#refundModal').modal('show');
});

// Toggle refund amount field based on radio
$(document).on('change', 'input[name="isRefundApplicable"]', function() {
    if ($(this).val() === 'yes') {
        $('#refundAmountGroup').show();
    } else {
        $('#refundAmountGroup').hide();
    }
});

// Initially set refund amount visibility
$(document).ready(function() {
    $('input[name="isRefundApplicable"]:checked').trigger('change');
});

// Handle refund submission
$('#refundForm').on('submit', function(e) {
    e.preventDefault();

    const orderId = $(this).attr('data-order-id');
    const isRefundApplicable = $('input[name="isRefundApplicable"]:checked').val();
    const amount = $('#refundAmount').val().trim();
    const reason = $('#refundReason').val().trim();

    // 🛑 Validation
    if (isRefundApplicable === 'yes') {
        if (!amount || isNaN(amount) || parseFloat(amount) <= 0) {
            alert('Please enter a valid refund amount.');
            $('#refundAmount').focus();
            return;
        }

        if (!reason) {
            alert('Please enter a reason for the refund.');
            $('#refundReason').focus();
            return;
        }
    } else {
        if (!reason) {
            alert('Please enter a reason for the refund.');
            $('#refundReason').focus();
            return;
        }
    }

    console.log('Order ID:', orderId);
    console.log('Is Refund Applicable:', isRefundApplicable);
    console.log('Refund Amount:', isRefundApplicable === 'yes' ? amount : 0);
    console.log('Reason:', reason);

    // Submit the form via AJAX
    $.post('../../controllers/orders/submit_refund.php', {
        order_id: orderId,
        is_refund_applicable: isRefundApplicable,
        amount: isRefundApplicable === 'yes' ? amount : 0,
        reason: reason
    }, function(response) {
        alert('Refund submitted!');
        $('#refundModal').modal('hide');
        $('#refundForm')[0].reset(); // Optional: reset form
        $('#refundAmountGroup').hide(); // Hide amount after reset
    }).fail(function() {
        alert('Error submitting refund.');
    });
});
function showOrderDetails(id) {
    window.location.href = 'order_details.php?vkvbvjfgfikix=' + id;
}

function downloadInvoice(id) {
    window.location.href = 'download_invoice?vkvbvjfgfikix=' + id;
}
//to reload data tables
// Select the target element
let targetNode = document.getElementById("selectedDate");

// Create a MutationObserver instance
let observer = new MutationObserver(function(mutationsList) {
    for (let mutation of mutationsList) {
        if (mutation.type === "childList") {
            let selectedDate = $("#selectedDate").text().trim(); // Get selected date
            if (selectedDate) {
                reloadTable(selectedDate); // Call function to reload table
            }
        }
    }
});

// Start observing changes in the target element
observer.observe(targetNode, {
    childList: true
});

function reloadTable(selectedDate) {
    //console.log('selectedDate');
    // Get currently active tab ID (e.g., "#bookedHistory")
    let activeTabId = $(".tab-pane.active").attr("id");
    $.ajax({
        url: "../../models/orders/fetch_bookings.php", // Create a PHP script to fetch filtered data
        type: "POST",
        data: {
            date: selectedDate
        },
        success: function(response) {
            $("#tableList").html("");
            $("#tableList").html(response); // Update table body

            
            // After inserting, re-activate the previous tab
            $(".tab-pane").removeClass("show active");
            $("#" + activeTabId).addClass("show active");

            // Also restore active class on the tab button
            $(".nav-link").removeClass("active");
            $('a[href="#' + activeTabId + '"]').addClass("active");
        },
        error: function() {
            alert("Failed to load data. Please try again.");
        }
    });
}
console.log('test');
document.addEventListener('DOMContentLoaded', function() {


    let classVal;
    let eventCalenderEl = document.getElementById('eventCalender');
    let bookingCardsContainer = document.getElementById('bookingCardData');

    if (!eventCalenderEl || !bookingCardsContainer) {
        console.error("❌ Error: Calendar or Booking Card Container Not Found!");
        //return;
    }

    let calendarEl = document.createElement('div');
    calendarEl.id = 'calendar';
    eventCalenderEl.querySelector('.card').appendChild(calendarEl);

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        navLinks: true,

        // ✅ Calendar navigation buttons
        headerToolbar: {
            right: 'prev,next today',
            center: 'title',
            left: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // ✅ Handle date clicks
        dateClick: function(info) {
            let selectedDate = info.dateStr;

            checkBookingsForDate(selectedDate).then(hasBookings => {
                // if (!hasBookings) return; // Do nothing if no bookings exist
                loadBookingsForDate(selectedDate);
                highlightSelectedDate(info.date);
            });
        },

        // ✅ Fetch events dynamically
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('../../models/orders/fetch_events.php')
                .then(response => response.json())
                .then(data => {
                    if (!data.bookings || !Array.isArray(data.bookings) || data.bookings.length === 0) {
                        console.log("ℹ️ No bookings found, keeping calendar blank.");
                        successCallback([]); // Send empty array to keep the calendar blank
                        return;
                    }

                    // Convert bookings data to FullCalendar format
                    let events = data.bookings.map(booking => ({
                        // title: booking.package_name,
                        title: "",
                        start: booking.date,
                        extendedProps: {
                            order_id: booking.order_id,
                            customer_name: booking.name,
                            status: booking.status
                        }
                    }));

                    successCallback(events);
                })
                .catch(error => {
                    console.error("❌ Failed to fetch events:", error);
                    successCallback([]);
                });
        },
        eventDidMount: function(info) {
            info.el.style.display = "none"; // Hides event completely
        },
        // ✅ Render event titles correctly
        eventContent: function(arg) {
            let eventEl = document.createElement('div');
            eventEl.innerHTML = arg.event.title;
            return {
                domNodes: [eventEl]
            };
        },

        // ✅ Fix Day Cell Content Handling
        dayCellContent: function(arg) {
            let container = document.createElement('div');
            container.innerHTML = arg.dayNumberText;

            checkBookingsForDate(formatDateToIST(arg.date)).then(hasBookings => {
                if (hasBookings) {
                    let dotEl = document.createElement('div');
                    dotEl.style.width = '10px';
                    dotEl.style.height = '10px';
                    dotEl.style.backgroundColor = 'blue';
                    dotEl.style.borderRadius = '50%';
                    dotEl.style.position = 'absolute';
                    dotEl.style.top = '10px';
                    dotEl.style.right = '65px';
                    container.appendChild(dotEl);
                }
            });

            return {
                domNodes: [container]
            };
        }
    });

    calendar.render();

    function loadBookingsForDate(date) {
        console.log("🔍 Fetching bookings for:", date);
        $.ajax({
            url: '../../models/orders/fetch_events.php',
            method: 'GET',
            data: {
                selected_date: date,
                limit: 4
            },
            dataType: 'json',
            success: function(response) {
                if (response.bookings && Array.isArray(response.bookings)) {
                    updateBookingCards(response.bookings);
                } else {
                    console.error("❌ Invalid data format:", response);
                    bookingCardsContainer.innerHTML = '<p class="text-center text-danger">Error: Invalid data format</p>';
                }
            },
            error: function(xhr, status, error) {
                console.error("❌ AJAX Error:", error);
                console.log("❗ Server Response:", xhr.responseText);
            }
        });
    }

    function updateBookingCards(bookings) {
        bookingCardsContainer.innerHTML = '';

        if (bookings.length === 0) {
            bookingCardsContainer.innerHTML = '<p class="text-center">No bookings for this date.</p>';
            return;
        }

        bookings.forEach(booking => {
            let statusBadge = getStatusBadge(booking);
            let message = booking.status == '3' ?
                `<p class="mb-0 cardText"><span class="fw-bold">${booking.name}</span> got a <span class="fw-bold">${statusBadge}</span> towards the package <span class="fw-bold">${booking.package_name}</span> with <span class="fw-bold">Booking ID: ${booking.order_id}</span></p>` :
                `<p class="mb-0 cardText"><span class="fw-bold">${booking.name}</span> has <span class="fw-bold">${statusBadge}</span> the package for <span class="fw-bold">${booking.package_name}</span> with <span class="fw-bold">Booking ID: ${booking.order_id}</span></p>`;

            let card = `
                <div class="card ${classVal} border border-primary-subtle rounded-4 p-2 mt-2 mb-0">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-center fs-5 fw-bold cardText ms-3">${booking.package_name}</span>
                        <span class="text-muted text-end m-0 pera bookingDate">${booking.date}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-3 d-flex align-items-center">
                            <img src="../../../${booking.package_image}" alt="" width="100" height="75" class="rounded-4 card-Img1">
                        </div>
                        <div class="col-md-9 col-sm-9 col-9">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-2 d-flex align-items-center">
                                    <img src="../../../uploading/${booking.customer_profile_pic}" alt="" width="50px" height="50px" class="rounded-circle cardProPic">
                                </div>
                                <div class="col-md-10 col-sm-10 col-10">
                                    ${message}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            bookingCardsContainer.innerHTML += card;
        });
    }

    function checkBookingsForDate(dateStr) {
        return new Promise((resolve) => {
            $.ajax({
                url: '../../models/orders/fetch_events.php',
                method: 'GET',
                data: {
                    selected_date: dateStr
                },
                dataType: 'json',
                success: function(response) {
                    resolve(response.bookings && response.bookings.length > 0);
                },
                error: function(xhr, status, error) {
                    console.error("❌ Error fetching bookings for the date:", error);
                    resolve(false);
                }
            });
        });
    }

    function highlightSelectedDate(date) {
        // Convert selected date to IST
        let istDateStr = formatDateToIST(date);

        // Remove previous highlight
        document.querySelectorAll('.selected-date').forEach(el => {
            el.classList.remove('selected-date');
            el.style.backgroundColor = ''; // Reset background
        });

        // Highlight the clicked date in IST
        let selectedDateCell = document.querySelector(`[data-date="${istDateStr}"]`);
        if (selectedDateCell) {
            selectedDateCell.classList.add('selected-date');
            selectedDateCell.style.backgroundColor = '#dfeaff'; // Light blue highlight
        }
    }

    function formatDateToIST(date) {
        let istOffset = 5.5 * 60 * 60 * 1000; // Convert 5.5 hours to milliseconds
        let local = new Date(date.getTime() + istOffset);
        return local.toISOString().split('T')[0];
    }

    function getStatusBadge(booking) {
        let startDate = new Date(booking.date);
        let tourDays = booking.tour_days ? parseInt(booking.tour_days) : 0;
        let endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + tourDays);

        let today = new Date();
        today.setHours(0, 0, 0, 0);
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);

        if (today > endDate) {
            classVal = 'text-success-emphasis bg-success-subtle border border-success-subtle';
            return `<span class=" text-success-emphasis">Completed</span>`;
        } else if (today >= startDate && today <= endDate) {
            classVal = 'text-info-emphasis bg-info-subtle border border-info-subtle';
            return `<span class="text-info-emphasis">Traveling</span>`;
        } else if (booking.status == '2') {
            classVal = 'text-danger-emphasis bg-danger-subtle border border-danger-subtle';
            return `<span class="text-danger-emphasis">Canceled</span>`;
        } else if (booking.status == '3') {
            classVal = 'text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle';
            return `<span class="text-secondary-emphasis">Refund</span>`;
        } else {
            classVal = 'text-primary-emphasis bg-primary-subtle border border-primary-subtle';
            return `<span class="text-primary-emphasis">Confirmed</span>`;
        }
    }

    // ✅ IST Date Conversion Function
    function formatDateToIST(date) {
        let istOffset = 5.5 * 60 * 60 * 1000; // Convert 5.5 hours to milliseconds
        let local = new Date(date.getTime() + istOffset);
        return local.toISOString().split('T')[0];
    }

    loadBookingsForDate(null);
});
$(function() {

    // var start = moment().subtract(29, 'days');
    // var end = moment();
    var start = moment("<?= $mindate ?>", "YYYY-MM-DD");
    var end = moment("<?= $maxdate ?>", "YYYY-MM-DD");

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});