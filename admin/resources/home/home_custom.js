const currentDate = new Date();
var getCurrentYear = currentDate.getFullYear();
var getCurrentMonth = currentDate.getMonth() + 1;
var userType, monthYear;
// get month for input tag
var monthControl = "2020";

$(function() {
    // get min and max month for input tag
    const date = new Date()
    const month = ("0" + (date.getMonth() + 1)).slice(-2)
    const year = date.getFullYear()
    monthControl.value = `${year}-${month}`;
    // console.log(monthControl.value);

    // Set Default value for years for line chart
    for (let index = 2020; index <= getCurrentYear; index++) {
        if (index == getCurrentYear) {
            $("#years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
            $("#yearsCustMemb").append('<option selected="selected" value="' + index + '">' + index + '</option>');
            $("#consultant_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
            $("#partner_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
        } else {
            $("#years").append('<option value="' + index + '">' + index + '</option>');
            $("#yearsCustMemb").append('<option value="' + index + '">' + index + '</option>');
            $("#consultant_years").append('<option value="' + index + '">' + index + '</option>');
            $("#partner_years").append('<option value="' + index + '">' + index + '</option>');
        }
    }
    
    // get chart data
    getMonthlyUserData(getCurrentYear);
    // get chart data Customer Membership
    getMonthlyUserDataCustMemb(getCurrentYear);
    // getBIPData(); //BIP pie chart
    getCAData(); //ca Amount Pie Chart
    //getCAData(); //ca Amount Pie Chart
    // get monthly user count
    monthYear = monthControl.value;
    // monthlyUserCount();
    // get birthday table
    // getBirthdayData('customer');

    // console.log('test 22');
});
//line chart for all user, excuding Customer 
async function getMonthlyUserData(get_year) {
    let option = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            year: get_year,
            current_year: getCurrentYear,
            current_month: getCurrentMonth,
            user_id: 0,
            user_type: 0
        })
    }
    const response = await fetch('../../charts/monthly_customer_count.php', option);
    const data = await response.json();
    // console.log(data);
    length = data[0].length;
    labels = [];
    values_cust = [];
    values_ta = [];
    values_bp = [];
    values_cp = [];
    values_bt = [];
    values_ca = [];
    values_cata = [];
    values_cacu = [];
    values_cbd = [];
    values_emp = [];
    values_bm = [];

    for (i = 0; i < length; i++) {
        values_cust.push(data[0][i]);
        values_ta.push(data[1][i]);
        values_bp.push(data[2][i]);
        values_cp.push(data[3][i]);
        values_bt.push(data[4][i]);
        values_ca.push(data[5][i]);
        values_cata.push(data[6][i]);
        values_cacu.push(data[7][i]);
        values_cbd.push(data[8][i]);
        values_emp.push(data[9][i]);
        values_bm.push(data[10][i]);
    }
    var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const hasAnyData = data.some(arr =>Array.isArray(arr) && arr.some(v => Number(v) > 0));
    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: xValues,
            datasets: [
                
                {
                    label: "Employees",
                    data: values_emp,
                    borderColor: "yellow",
                    fill: true
                },
                {
                    label: "Mentor",
                    data: values_bm,
                    borderColor: "blue",
                    fill: true
                },
                {
                    label: "Techno Enterprise",
                    data: values_ca,
                    borderColor: "green",
                    fill: true
                },
                {
                    label: "Travel Consultant",
                    data: values_cata,
                    borderColor: "pink",
                    fill: true
                },
                {
                    label: "Customer",
                    data: values_cacu,
                    borderColor: "red",
                    fill: true
                }
            ]
        },
        options: {
            legend: {
                display: true
            },
            scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: hasAnyData ? undefined : 5,
                            stepSize: hasAnyData ? undefined : 1,
                            precision: 0,   // 👈 still forces integers when empty
                            callback: function(value) {
                                if (!hasAnyData) {
                                return value;            // 0–5 when empty
                                }
                                return Number(value.toFixed(2));  // 👈 formats 0.30000000004 → 0.3
                            }
                        }
                    }]
            },
            title: {
                display: false,
                text: 'Registered Users'
            }
        }
    });
}

//line chart for customer membership
async function getMonthlyUserDataCustMemb(get_year) {
    let option = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            year: get_year,
            current_year: getCurrentYear,
            current_month: getCurrentMonth,
            user_id: 0,
            user_type: 0
        })
    }
    const response = await fetch('../../charts/monthly_customer_membership_count.php', option);
    const data = await response.json();
    // console.log(data);
    length = data[0].length;
    labels = [];
    values_custF = [];
    // values_custPR = [];
    values_custP = [];
    values_custPP = [];
    values_custPS = [];
    values_custPSL = [];
    values_custNS = [];
    values_custNSU = [];
    // values_cacu = [];
    // values_cbd = [];
    // values_emp = [];
    // values_bm = [];

    for (i = 0; i < length; i++) {
        values_custF.push(data[0][i]);
        // values_custPR.push(data[1][i]);
        values_custP.push(data[2][i]);
        values_custPP.push(data[3][i]);
        values_custPS.push(data[4][i]);
        values_custPSL.push(data[5][i]);
        values_custNS.push(data[6][i]);
        values_custNSU.push(data[7][i]);
    }
    var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const hasAnyData = data.some(arr => 
                                    Array.isArray(arr) && arr.some(v => Number(v) > 0)
                                );
    new Chart(document.getElementById("myChartCust"), {
        type: 'line',
        data: {
            labels: xValues,
            datasets: [
                {
                    label: "Regular",
                    data: values_custF,
                    borderColor: "green",
                    fill: true
                },
                {
                    label: "Premium",
                    data: values_custP,
                    borderColor: "red",
                    fill: true
                },
                {
                    label: "Premium Plus",
                    data: values_custPP,
                    borderColor: "purple",
                    fill: true
                },
                {
                    label: "Premium Select",
                    data: values_custPS,
                    borderColor: "blue",
                    fill: true
                },
                {
                    label: "Premium Select Lite",
                    data: values_custPSL,
                    borderColor: "orange",
                    fill: true
                },
                {
                    label: "Neo Select",
                    data: values_custNS,
                    borderColor: "gray",
                    fill: true
                },
                {
                    label: "Neo Select Ultra",
                    data: values_custNSU,
                    borderColor: "black",
                    fill: true
                },
            ]
        },
        options: {
            legend: {
                display: true
            },
            scales: {
                    yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: hasAnyData ? undefined : 5,
                                    stepSize: hasAnyData ? undefined : 1,
                                    precision: 0,   // 👈 still forces integers when empty
                                    callback: function(value) {
                                        if (!hasAnyData) {
                                        return value;            // 0–5 when empty
                                        }
                                        return Number(value.toFixed(2));  // 👈 formats 0.30000000004 → 0.3
                                    }
                                }
                            }]
            },
            title: {
                display: false,
                text: 'Registered Users'
            }
        }
    });
}

//TE pie chart
async function getCAData() {
    const response = await fetch('../../charts/ca_payout.php');
    const data = await response.json();

    // console.log(data);

    var xValues = ["2 Lakhs", "3 Lakhs", "5 Lakhs"];
    var yValues = [data[4], data[3], data[2]];
    var total = data[1];
    var totalCA = data[0];
    var barColors = [
        "#ad2321",
        "#3EB07E",
        "#2e51f0"
    ];

    document.getElementById("ca_total_count").innerText = "Total TE = " + totalCA + "\n";
    document.getElementById("ca_total_price").innerText = " Total Amount = ₹ " + total + "/-";

    if (totalCA == 0) {
        document.getElementById("ca_no_chart_box").style.display = "block";
        document.getElementById("ca_chart_box").style.display = "none";
    } else {
        document.getElementById("ca_no_chart_box").style.display = "none";
        document.getElementById("ca_chart_box").style.display = "block";
    }

    new Chart(document.getElementById("myCAChart"), {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: false,
                text: "BIP Payout",
            }
        }
    });
}
//  all employees payout
let currentChart = null;
let chartDataCache = {};

async function fetchData() {
    const type = document.getElementById("dataTypeSelect").value;
    const monthInput = document.getElementById("monthSelector").value;
    const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

    const formData = new FormData();
    formData.append("type", type);
    formData.append("month", month);
    formData.append("year", year);

    const res = await fetch("../../charts/all_user_payout.php", {

        method: "POST",
        body: formData
    });
    const data = await res.json();
    chartDataCache = data;
    renderChart(type,year, month);
}

function renderChart(type, month, year) {
    let label = '', total = 0, paid = 0, pending = 0;

    const dataMap = {
        te: {
            count: chartDataCache.total_te || 0,
            paid: chartDataCache.total_te_amount || 0,
            pending: chartDataCache.total_te_pending || 0,
            label: 'TE'
        },
        f: {
            count: chartDataCache.total_f || 0,
            paid: chartDataCache.total_f_amount || 0,
            pending: chartDataCache.total_f_pending || 0,
            label: 'F'
        },
        tc: {
            count: chartDataCache.total_tc || 0,
            paid: chartDataCache.total_tc_paid || 0,
            pending: chartDataCache.total_tc_pending || 0,
            label: 'TC'
        },
        customer: {
            count: chartDataCache.total_customer || 0,
            paid: chartDataCache.total_customer_paid || 0,
            pending: chartDataCache.total_customer_pending || 0,
            label: 'Customer'
        },
        bm: {
            count: chartDataCache.total_bm || 0,
            paid: chartDataCache.total_bm_paid || 0,
            pending: chartDataCache.total_bm_pending || 0,
            label: 'BM'
        },
        mf: {
            count: chartDataCache.total_mf || 0,
            paid: chartDataCache.total_mf_paid || 0,
            pending: chartDataCache.total_mf_pending || 0,
            label: 'MF'
        },
        sf: {
            count: chartDataCache.total_sf || 0,
            paid: chartDataCache.total_sf_paid || 0,
            pending: chartDataCache.total_sf_pending || 0,
            label: 'SF'
        }
    };

    let downloadBtn = document.getElementById("downloadChartBtn");
    console.log('type:'+type+'month-year:'+month+'-'+year);
    
    if (type !== 'all' && month && year) {
        downloadBtn.style.display = 'inline-block';
    } else {
        downloadBtn.style.display = 'none';
    }

    if (type === 'all') {
        const totalAmount = Object.values(dataMap).reduce((sum, d) => sum + d.paid, 0);
        if (totalAmount === 0) {
            document.getElementById("payout_chart_box").style.display = "none";
            document.getElementById("payout_no_chart_box").style.display = "block";
            return;
        }

        document.getElementById("payout_chart_box").style.display = "block";
        document.getElementById("payout_no_chart_box").style.display = "none";

        const labels = [];
        const data = [];
        const bgColors = ["#007bff", "#28a745", "#ffc107", "#dc3545","#aaa045", "#cccd07", "#defc45"];
        let displayText = '';

        for (const key in dataMap) {
            const d = dataMap[key];
            const total = (d.paid || 0) + (d.pending || 0);
            if (total > 0) {
                labels.push(`${d.label}: ${d.count}`);
                data.push(total);
                displayText += `${d.label}: ${d.count} (₹${total.toLocaleString()})\n`;
            }
        }

        document.getElementById("ca_total_count1").innerText = "Payout";
        document.getElementById("ca_total_price1").innerText = displayText.trim();

        if (currentChart) currentChart.destroy();

        currentChart = new Chart(document.getElementById("myCAChart1"), {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: bgColors,
                    data: data
                }]
            },
            options: {
                title: { display: false }
            }
        });

    } else {
        const selected = dataMap[type];
        total = selected.count;
        paid = selected.paid;
        pending = selected.pending;
        label = selected.label;

        if (total === 0 && paid === 0 && pending === 0) {
            document.getElementById("payout_chart_box").style.display = "none";
            document.getElementById("payout_no_chart_box").style.display = "block";
            return;
        }

        document.getElementById("payout_chart_box").style.display = "block";
        document.getElementById("payout_no_chart_box").style.display = "none";

        document.getElementById("ca_total_count1").innerText = `Total ${label}: ${total}`;
        document.getElementById("ca_total_price1").innerText = `Paid: ₹${paid.toLocaleString()}\nPending: ₹${pending.toLocaleString()}`;

        if (currentChart) currentChart.destroy();

        currentChart = new Chart(document.getElementById("myCAChart1"), {
            type: "pie",
            data: {
                labels: ["Paid", "Pending"],
                datasets: [{
                    backgroundColor: ["#ad2321", "#3EB07E"],
                    data: [paid, pending]
                }]
            },
            options: {
                title: { display: false }
            }
        });
    }
}

function downloadChartData() {
    const type = document.getElementById("dataTypeSelect").value; // TE / BM / Customer
    const monthInput = document.getElementById("monthSelector").value;
    const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

    const formData = new FormData();
    formData.append("type", type);
    if (month && year) {
        formData.append("month", month);
        formData.append("year", year);
    }

    fetch("../../charts/download_chart_data.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Failed to generate file");
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = `${type}_payout_data.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
    })
    .catch(error => {
        alert("Error downloading file: " + error.message);
    });
}

// Event listeners
document.getElementById("dataTypeSelect").addEventListener("change", () => {
    const type = document.getElementById("dataTypeSelect").value;
    const [month, year] = document.getElementById("monthSelector").value.split("-");
    fetchData(type, month || '', year || '');
});

document.getElementById("monthSelector").addEventListener("change", () => {
    const type = document.getElementById("dataTypeSelect").value;
    const [month, year] = document.getElementById("monthSelector").value.split("-");
    fetchData(type, month || '', year || '');
});

    // Initial load
fetchData();

// for customer member ship
let currentChart1 = null;
let chartDataCache1 = {};

async function fetchData1() {
    const type = document.getElementById("dataTypeSelect1").value;
    const monthInput = document.getElementById("monthSelector1").value;
    const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

    const formData = new FormData();
    formData.append("type", type);
    formData.append("month", month);
    formData.append("year", year);

    const res = await fetch("../../charts/cust_membership_payout.php", {

        method: "POST",
        body: formData
    });
    const data = await res.json();
    chartDataCache1 = data;
    renderChart1(type,year, month);
}

function renderChart1(type, year, month) {
    let label = '', total = 0;
    let complementary = 0, nonComplementary = 0;

    // These will come from the updated PHP response
    complementary = chartDataCache1.complementary_paid || 0;
    nonComplementary = chartDataCache1.non_complementary_paid || 0;
    total = complementary + nonComplementary;
    label = type !== "all" ? type : "Customer";

    let downloadBtn = document.getElementById("downloadChartBtn1");
    if (month && year) {
        downloadBtn.style.display = 'inline-block';
    } 

    if (total === 0) {
        document.getElementById("ca_chart_box1").style.display = "none";
        document.getElementById("ca_no_chart_box1").style.display = "block";
        return;
    }

    document.getElementById("ca_chart_box1").style.display = "block";
    document.getElementById("ca_no_chart_box1").style.display = "none";

    document.getElementById("ca_total_count2").innerText = `Total ${label} Paid: ₹${total.toLocaleString()}`;
    document.getElementById("ca_total_price2").innerText = `Complimentary: ₹${complementary.toLocaleString()}\nNon-Complimentary: ₹${nonComplementary.toLocaleString()}`;

    if (currentChart1) currentChart1.destroy();

    currentChart1 = new Chart(document.getElementById("myCAChart2"), {
        type: "pie",
        data: {
            labels: ["Complimentary", "Non-Complimentary"],
            datasets: [{
                backgroundColor: ["#3EB07E", "#ad2321"],
                data: [complementary, nonComplementary]
            }]
        },
        options: {
            title: { display: false }
        }
    });
}


function downloadChartData1() {
    const type = document.getElementById("dataTypeSelect1").value; // TE / BM / Customer
    const monthInput = document.getElementById("monthSelector1").value;
    const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

    const formData = new FormData();
    formData.append("type", type);
    if (month && year) {
        formData.append("month", month);
        formData.append("year", year);
    }

    fetch("../../charts/download_chart_data_cust_membership.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Failed to generate file");
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = `${type}_payout_data.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
    })
    .catch(error => {
        alert("Error downloading file: " + error.message);
    });
}
// Event listeners for customer member ship
document.getElementById("dataTypeSelect1").addEventListener("change", () => {
    const type = document.getElementById("dataTypeSelect1").value;
    const [month, year] = document.getElementById("monthSelector1").value.split("-");
    fetchData1(type, month || '', year || '');
});

document.getElementById("monthSelector1").addEventListener("change", () => {
    const type = document.getElementById("dataTypeSelect1").value;
    const [month, year] = document.getElementById("monthSelector1").value.split("-");
    fetchData1(type, month || '', year || '');
});


// for customer member ship
fetchData1();

// function calender get data and insert data
function showCalender() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        // ✅ Called whenever the calendar view changes (e.g. next/prev month)
        datesSet: function() {
            fetchAndMarkTransactionDates(); // Custom dots or styles, if any
        },

        // ✅ Called when user clicks a date
        dateClick: function(info) {
            const clickedDate = info.dateStr; // Format: YYYY-MM-DD
            fetchTransactionsByDate(clickedDate);
        },

        // ✅ Load events for the calendar (optional for dots)
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: '../../calendar/loadEvent.php',
                type: 'GET',
                success: function(data) {
                    try {
                        const events = JSON.parse(data);
                        successCallback(events); // Pass parsed events to FullCalendar
                    } catch (err) {
                        console.error("JSON Parse Error:", err);
                        failureCallback(err);
                    }
                },
                error: function(err) {
                    console.error("Event Load Error:", err);
                    failureCallback(err);
                }
            });
        }
    });

    calendar.render();
}

function fetchTransactionsByDate(date) {
    $.ajax({
        url: '../../calendar/loadTransactionByDate.php',
        type: 'POST',
        data: {
            date: date
        },
        success: function(response) {
            $('#latestTransaction').html(response);
        },
        error: function() {
            console.error("Failed to load transactions for date:", date);
            $('#latestTransaction').html('<p>Error loading transactions.</p>');
        }
    });
}

function markTransactionDatesOnCalendar(transactionDates) {
    // Get all date cells in the calendar
    document.querySelectorAll('.fc-daygrid-day').forEach(function(cell) {
        const cellDate = cell.getAttribute('data-date'); // Format: YYYY-MM-DD
        if (transactionDates.includes(cellDate)) {
            // Check if dot already exists
            if (!cell.querySelector('.transaction-dot')) {
                const dot = document.createElement('div');
                dot.classList.add('transaction-dot');
                cell.appendChild(dot);
            }
        }
    });
}

function fetchAndMarkTransactionDates() {
    $.ajax({
        url: '../../calendar/loadTransactionDates.php',
        type: 'GET',
        success: function(response) {
            try {
                const dates = JSON.parse(response); // Should be an array of YYYY-MM-DD
                // Wait a little to ensure calendar is rendered
                setTimeout(() => markTransactionDatesOnCalendar(dates), 500);
            } catch (err) {
                console.error("Error parsing transaction dates JSON:", err);
            }
        },
        error: function() {
            console.error("Error loading transaction dates");
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    showCalender(); // Your existing function
    setTimeout(fetchAndMarkTransactionDates, 800);
});

$('#btn-save-event').on('click', function(e) {
    e.preventDefault();
    // alert('Hello');
    var eventTitle = $('#event-title').val();
    var eventDate = $('#event-date').val();
    var dataString = {
        eventTitle,
        eventDate
    }
    if (eventTitle && eventDate) {
        $.ajax({
            type: 'POST',
            data: dataString,
            url: '../../calendar/insertEvent.php',
            cache: false,
            success: function(data) {
                if (data == '1') {
                    alert("Event Added Successfully");
                    window.location.reload();
                } else {
                    alert("Error Adding Event");
                    window.location.reload();
                }
            }
        });
    } else {
        alert("Insert Valid Values");
        window.location.reload();
    }
});

// Count of Employee
function showDivCount(divNumber) {
    // hide all divs first
    var divs = document.querySelectorAll('.contentCountDiv');
    divs.forEach(function(div) {
        div.style.display = 'none';
    });

    // Show the clicked div 
    var activeDiv = document.getElementById('count' + divNumber);
    activeDiv.style.display = 'block';
}
// Top performer button 
function showDiv(divNumber) {
    // hide all divs first
    var divs = document.querySelectorAll('.contentDiv');
    divs.forEach(function(div) {
        div.style.display = 'none';
    });

    // Show the clicked div 
    var activeDiv = document.getElementById('div' + divNumber);
    activeDiv.style.display = 'block';
}

// Top performer data change based on Month and Year BCH
$('#month_year_BCH').change(function() {
    var date = $(this).val();
    var table_update = 'bch_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            // console.log(data);
            $('#bch_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year BDM
$('#month_year_BDM').change(function() {
    var date = $(this).val();
    var table_update = 'bdm_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#bdm_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year BM
$('#month_year_BM').change(function() {
    var date = $(this).val();
    var table_update = 'bm_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#bm_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year TE
$('#month_year_TE').change(function() {
    var date = $(this).val();
    var table_update = 'te_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#te_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year TA
$('#month_year_TA').change(function() {
    var date = $(this).val();
    var table_update = 'ta_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#ta_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year CU
$('#month_year_CU').change(function() {
    var date = $(this).val();
    var table_update = 'cu_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#cu_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year MF
$('#month_year_MF').change(function() {
    var date = $(this).val();
    var table_update = 'mf_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#mf_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year SF
$('#month_year_SF').change(function() {
    var date = $(this).val();
    var table_update = 'sf_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#sf_top_performer').html(data);
        }
    });
});

// Top performer data change based on Month and Year SF
$('#month_year_FR').change(function() {
    var date = $(this).val();
    var table_update = 'fr_top_performer';
    var month = date.split('-')[1];
    var year = date.split('-')[0];
    dataString = {
        table_update,
        month,
        year
    }

    $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../assets/submit/top_performer.php',
        cache: false,
        success: function(data) {
            $('#fr_top_performer').html(data);
        }
    });
});

// Set current month and year as default value
$(document).ready(function () {
    const monthInput = $("#month_year_count");

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const currentMonth = `${yyyy}-${mm}`;

    monthInput.val(currentMonth);
    monthInput.prop('max', currentMonth);

    fetchMountUserCount(currentMonth);
    fetchMonthlyData(currentMonth);
});
$(document).on("change", "#month_year_count", function () {
    const monthYear = $(this).val();
    fetchMountUserCount(monthYear);
    fetchMonthlyData(monthYear);
});

//Monthly Users Count Table
function handleMonthClick() {
    const monthYear = document.getElementById('month_year_count').value; // format: "2025-05"
    if (monthYear) {
        fetchMountUserCount(monthYear);
        fetchMonthlyData(monthYear);
    }
}
function fetchMountUserCount(monthYear) {
    
    $.ajax({
        url: '../../assets/submit/fetch_monthly_user_count.php', 
        type: 'POST',
        data: { monthYear: monthYear },
        dataType: 'json',
        success: function (response) {
            if (!response || typeof response !== 'object') {
                console.error("Invalid JSON response:", response);
                return;
            }

            // Example: update DOM elements based on the response
            $("#bmCount").text(response.bm_count || 0);
            $("#empCount").text(response.emp_count || 0);
            $("#teCount").text(response.te_count || 0);
            $("#tcCount").text(response.tc_count || 0);
            $("#custCount").text(response.cust_count || 0);
            $("#mfCount").text(response.mf_count || 0);
            $("#sfCount").text(response.sf_count || 0);
            $("#fCount").text(response.f_count || 0);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}



function fetchMonthlyData(monthYear) {
    $.ajax({
        url: "../../assets/submit/fetch_monthly_data.php",
        type: "POST",
        data: { monthYear: monthYear },
        dataType: "json",
        success: function (response) {

            // Destroy existing DataTables BEFORE replacing HTML
            const tableIds = ['#datatable1', '#datatable2', '#datatable3', '#datatable4', '#datatable5', '#datatable6', '#datatable7', '#datatable8'];
            tableIds.forEach(function (id) {
                if ($.fn.DataTable.isDataTable(id)) {
                    $(id).DataTable().destroy();
                }
            });

            // Replace the table HTML
            $("#bm_month_list").html(response.bm_html);
            $("#emp_month_list").html(response.emp_html);
            $("#te_monthly_list").html(response.te_html);
            $("#tc_monthly_list").html(response.tc_html);
            $("#cust_monthly_list").html(response.cust_html);
            $("#mf_monthly_list").html(response.mf_html);
            $("#sf_monthly_list").html(response.sf_html);
            $("#f_monthly_list").html(response.f_html);

            // Re-initialize DataTables after HTML update
            tableIds.forEach(function (id) {
                $(id).DataTable({
                    pageLength: 5,
                    lengthChange: false
                });
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText);
        }
    });
}