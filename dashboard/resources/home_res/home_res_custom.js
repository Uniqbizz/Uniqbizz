var userType= document.getElementById("user_type").value;
const currentDate = new Date();
// console.log(currentDate);
var getCurrentYear = currentDate.getFullYear();
// console.log(getCurrentYear);
var getCurrentMonth = currentDate.getMonth() + 1;
// console.log(getCurrentMonth);
var userType, monthYear;

$(document).ready(function(){
    $("#top-users").DataTable({
        language: {
            emptyTable: "No data"
        },
        searching: false,   
        paging: false,
        info: false       
    });
});
let monthlyChart;
function hexToRgba(hex, alpha = 0.5) {
    const r = parseInt(hex.substring(1, 3), 16);
    const g = parseInt(hex.substring(3, 5), 16);
    const b = parseInt(hex.substring(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}
async function getMonthlyUserData(get_year) {
    const option = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json;charset=utf-8' },
        body: JSON.stringify({
            year: get_year,
            current_year: getCurrentYear,
            current_month: getCurrentMonth,
            user_id: userId,
            user_type: userType
        })
    };

    try {
        const response = await fetch('../charts/chartData.php', option);
        const data = await response.json();

        if (!Array.isArray(data)) {
            console.error("Invalid data", data);
            return;
        }

        const xValues = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        const labelMap = {
            '24': ['BDM','BM','MF','SF','TE','F','I','TA','IBR','CU'],
            '25': ['BM','MF','SF','TE','F','I','TA','IBR','CU'],
            '26': ['TE','F','I','TA','IBR','CU'],
            '28': ['F','I','TA','IBR','CU'],
            '29': ['TA','CU'],
            '16': ['TA','CU'],
            '30': ['F','I','TA','IBR','CU'],
            '31': ['MF','SF','F','I','TA','IBR','CU'],
            '11': ['CU'],
            '32': ['IBR','CU'],
            '33': ['CU']
        };

        const labels = labelMap[userType] || [];
        const colors = [
                            '#f39c12', // orange
                            '#27ae60', // green
                            '#2980b9', // blue
                            '#8e44ad', // purple
                            '#e74c3c', // red
                            '#1abc9c', // teal
                            '#f1c40f', // yellow
                            '#0ff12d', // neon green
                            '#ff6b6b', // light red
                            '#34495e', // dark blue-grey
                            '#16a085', // dark teal
                            '#d35400', // burnt orange
                            '#2ecc71', // light green
                            '#9b59b6', // soft purple
                            '#c0392b', // dark red
                            '#7f8c8d', // grey
                            '#00cec9', // cyan
                            '#6c5ce7', // violet
                            '#fd79a8', // pink
                            '#e17055'  // coral
                        ];

        const MONTHS = 12;

        const normalizedData = Array.isArray(data[0]) && Array.isArray(data[0][0])
            ? data[0]
            : data;

        const hasAnyData = normalizedData.some(arr =>
            Array.isArray(arr) && arr.some(v => Number(v) > 0)
        );

        const datasets = normalizedData.map((arr, i) => {
            const safeData = Array.isArray(arr) ? arr.slice(0, 12) : [];

            while (safeData.length < 12) {
                safeData.push(0);
            }

            return {
                label: labels[i] || `Series ${i + 1}`,
                data: safeData,
                borderColor: colors[i % colors.length],
                backgroundColor: hexToRgba(colors[i % colors.length], 0.4),
                pointBackgroundColor: colors[i % colors.length],
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                spanGaps: false
            };
        });

        if (monthlyChart) {
            monthlyChart.destroy();
        }

        monthlyChart = new Chart(document.getElementById("myChart"), {
            type: 'line',
            data: {
                labels: xValues,
                datasets
            },
            options: {
                responsive: true,
                legend: { display: true },   //  v2 plugin config
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: hasAnyData ? undefined : 5,
                            stepSize: hasAnyData ? undefined : 1,
                            precision: 0,   //  still forces integers when empty
                            callback: function(value) {
                                if (!hasAnyData) {
                                return value;            // 0–5 when empty
                                }
                                return Number(value.toFixed(2));  //  formats 0.30000000004 → 0.3
                            }
                        }
                    }]
                }
            }
        });
        console.log(hasAnyData);
        

    } catch (error) {
        console.error("Fetch chart error:", error);
    }
}
function showCountlist(userType, userId) {
    $.ajax({
        url: '../assets/submit/pupolar_emp_list.php',
        type: 'POST',
        data: {
            userType: userType,
            userId: userId
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                const data = response.data;
                const prefix2 = userId.substring(0, 2);
                const prefix1 = userId.substring(0, 1);
                // Example: Populate table with ID `#countTableBody`
                const tableBody = $('#countTableBody');
                tableBody.empty(); // Clear previous data
                if (userType == '24'){
                    tableBody.append(`
                        <tr>
                            <th>Business Mentor</th>
                            <td>${data.pendingBM}</td>
                            <td>${data.registeredBM}</td>
                            <td>${data.deletedBM}</td>
                        </tr>
                        <tr>
                            <th>Master Franchisee</th>
                            <td>${data.pendingMF}</td>
                            <td>${data.registeredMF}</td>
                            <td>${data.deletedMF}</td>
                        </tr>
                        <tr>
                            <th>Sponsor Franchisee</th>
                            <td>${data.pendingSF}</td>
                            <td>${data.registeredSF}</td>
                            <td>${data.deletedSF}</td>
                        </tr>
                        <tr>
                            <th>Techno Enterprise</th>
                            <td>${data.pendingTE}</td>
                            <td>${data.registeredTE}</td>
                            <td>${data.deletedTE}</td>
                        </tr>
                        <tr>
                            <th>Franchisee</th>
                            <td>${data.pendingF}</td>
                            <td>${data.registeredF}</td>
                            <td>${data.deletedF}</td>
                        </tr>
                        <tr>
                            <th>Institution</th>
                            <td>${data.pendingI}</td>
                            <td>${data.registeredI}</td>
                            <td>${data.deletedI}</td>
                        </tr>
                        <tr>
                            <th>Travel Consultant</th>
                            <td>${data.pendingTC}</td>
                            <td>${data.registeredTC}</td>
                            <td>${data.deletedTC}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>${data.pendingCU}</td>
                            <td>${data.registeredCU}</td>
                            <td>${data.deletedCU}</td>
                        </tr>
                    `);
                }
                if (userType == '25'){
                   
                    if (['BM', 'MF', 'SF'].includes(prefix2)) {
                        if (prefix2 === 'BM') {
                            tableBody.append(`
                                <tr>
                                    <th>Techno Enterprise</th>
                                    <td>${data.pendingTE}</td>
                                    <td>${data.registeredTE}</td>
                                    <td>${data.deletedTE}</td>
                                </tr>
                                <tr>
                                    <th>Institution</th>
                                    <td>${data.pendingI}</td>
                                    <td>${data.registeredI}</td>
                                    <td>${data.deletedI}</td>
                                </tr>
                                <tr>
                                    <th>Franchisee</th>
                                    <td>${data.pendingF}</td>
                                    <td>${data.registeredF}</td>
                                    <td>${data.deletedF}</td>
                                </tr>
                                <tr>
                                    <th>Travel Consultant</th>
                                    <td>${data.pendingTC}</td>
                                    <td>${data.registeredTC}</td>
                                    <td>${data.deletedTC}</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>${data.pendingCU}</td>
                                    <td>${data.registeredCU}</td>
                                    <td>${data.deletedCU}</td>
                                </tr>
                            `);
                        } else if (prefix2 === 'MF' || prefix2 === 'SF') {
                            tableBody.append(`
                                <tr>
                                    <th>Institution</th>
                                    <td>${data.pendingI}</td>
                                    <td>${data.registeredI}</td>
                                    <td>${data.deletedI}</td>
                                </tr>
                                <tr>
                                    <th>Franchisee</th>
                                    <td>${data.pendingF}</td>
                                    <td>${data.registeredF}</td>
                                    <td>${data.deletedF}</td>
                                </tr>
                                <tr>
                                    <th>Travel Consultant</th>
                                    <td>${data.pendingTC}</td>
                                    <td>${data.registeredTC}</td>
                                    <td>${data.deletedTC}</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>${data.pendingCU}</td>
                                    <td>${data.registeredCU}</td>
                                    <td>${data.deletedCU}</td>
                                </tr>
                            `);
                        }
                    } else if (prefix2 === 'TA') {
                        tableBody.append(`
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'F' || prefix2 === 'TE' || prefix2 === 'CA') {
                        tableBody.append(`
                            <tr>
                                <th>Travel Consultant</th>
                                <td>${data.pendingTC}</td>
                                <td>${data.registeredTC}</td>
                                <td>${data.deletedTC}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'I') {
                        tableBody.append(`
                            <tr>
                                <th>Institution Branch Manager</th>
                                <td>${data.pendingIBR}</td>
                                <td>${data.registeredIBR}</td>
                                <td>${data.deletedIBR}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    }
                }
                if (userType == '26'){

                    if (prefix1 === 'F' || prefix2 === 'TE' || prefix2 === 'CA') {
                        tableBody.append(`
                            <tr>
                                <th>Travel Consultant</th>
                                <td>${data.pendingTC}</td>
                                <td>${data.registeredTC}</td>
                                <td>${data.deletedTC}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'I') {
                        tableBody.append(`
                            <tr>
                                <th>Institution Branch Manager</th>
                                <td>${data.pendingIBR}</td>
                                <td>${data.registeredIBR}</td>
                                <td>${data.deletedIBR}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    }else if (prefix2 === 'TA') {
                        tableBody.append(`
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    }
                }
                if (userType == '16'){
                    tableBody.append(`
                        <tr>
                            <th>Customer</th>
                            <td>${data.pendingCU}</td>
                            <td>${data.registeredCU}</td>
                            <td>${data.deletedCU}</td>
                        </tr>
                    `);
                }
                if (userType == '28'){
                    if (prefix2 === 'TA') {
                        tableBody.append(`
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'F') {
                        tableBody.append(`
                            <tr>
                                <th>Travel Consultant</th>
                                <td>${data.pendingTC}</td>
                                <td>${data.registeredTC}</td>
                                <td>${data.deletedTC}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'I') {
                        tableBody.append(`
                            <tr>
                                <th>Institution Branch Manager</th>
                                <td>${data.pendingIBR}</td>
                                <td>${data.registeredIBR}</td>
                                <td>${data.deletedIBR}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    }
                    
                }
                if (userType == '29'){
                    tableBody.append(`
                        <tr>
                            <th>Customer</th>
                            <td>${data.pendingCU}</td>
                            <td>${data.registeredCU}</td>
                            <td>${data.deletedCU}</td>
                        </tr>
                    `);
                }
                if (userType == '30'){
                    if (prefix1 === 'F') {
                        tableBody.append(`
                            <tr>
                                <th>Travel Consultant</th>
                                <td>${data.pendingTC}</td>
                                <td>${data.registeredTC}</td>
                                <td>${data.deletedTC}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    } else if (prefix1 === 'I') {
                        tableBody.append(`
                            <tr>
                                <th>Institution Branch Manager</th>
                                <td>${data.pendingIBR}</td>
                                <td>${data.registeredIBR}</td>
                                <td>${data.deletedIBR}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>${data.pendingCU}</td>
                                <td>${data.registeredCU}</td>
                                <td>${data.deletedCU}</td>
                            </tr>
                        `);
                    }
                }
                if (userType == '31'){
                    tableBody.append(`
                        <tr>
                            <th>Franchisee</th>
                            <td>${data.pendingF}</td>
                            <td>${data.registeredF}</td>
                            <td>${data.deletedF}</td>
                        </tr>
                        <tr>
                            <th>Travel Consultant</th>
                            <td>${data.pendingTC}</td>
                            <td>${data.registeredTC}</td>
                            <td>${data.deletedTC}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>${data.pendingCU}</td>
                            <td>${data.registeredCU}</td>
                            <td>${data.deletedCU}</td>
                        </tr>
                        
                    `);
                    
                }
                if (userType == '32'){
                    tableBody.append(`
                        <tr>
                            <th>Customer</th>
                            <td>${data.pendingCU}</td>
                            <td>${data.registeredCU}</td>
                            <td>${data.deletedCU}</td>
                        </tr>
                    `);
                }
            } else {
                console.error('Error:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

function highlightSelected(id) {
    // Remove highlight from all items
    document.querySelectorAll('li[id^="list-item-"]').forEach(function(el) {
        el.classList.remove('active-highlight');
    });

    // Add highlight to the clicked item
    const selectedItem = document.getElementById(id);
    if (selectedItem) {
        selectedItem.classList.add('active-highlight');
    }
}

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