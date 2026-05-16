// ENROLLMENT CHART
const enrollmentCtx = document
    .getElementById('neoEnrollmentChart');

new Chart(enrollmentCtx, {
    type: 'line',

    data: {
        labels: [
            '1 May','6 May','11 May','16 May',
            '21 May','26 May','31 May'
        ],

        datasets: [{
            label: 'Enrollments',
            data: [4,11,14,13,22,27,38],
            borderColor: '#1565d8',
            backgroundColor: 'rgba(21,101,216,0.08)',
            tension: 0.4,
            fill: true,
            pointRadius: 4
        }]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});


// HOLIDAY BAR CHART
const holidayCtx = document
    .getElementById('neoHolidayChart');

new Chart(holidayCtx, {
    type: 'bar',

    data: {
        labels: [
            'Goa','Dubai','Thailand',
            'Kashmir','Singapore','Bali','Others'
        ],

        datasets: [{
            data: [12,7,5,4,3,2,1],
            backgroundColor: [
                '#7b3ff2','#8b5cf6','#9d6eff',
                '#a97dff','#b38aff','#bea0ff','#ccb8ff'
            ],
            borderRadius: 10,
            barThickness: 18
        }]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
