    // Trigger on page load
    $(document).ready(function() {
        fetchUserCountDetails(); //userCountDetails
        fetchTopPerformers(); //Top performers

        // line and doughnut charts
        year = "all";
        month = "all";
        customerChart(month,year); //line chart
        getAllUserRevenue(year); //Revenue doughnut chart
        getHolidayRevenue(year); // Holidays doughnut chart

        // load Calender and Transections
        showCalender(); // Load Calender canvas function 
        setTimeout(fetchAndMarkTransactionDates, 800); // Transection load on calender "dot"
    });

    
    var mybutton = document.getElementById("back-to-top");
    function scrollFunction() {
        100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
    }
    function topFunction() {
        document.body.scrollTop = 0,
        document.documentElement.scrollTop = 0
    }
    mybutton && (window.onscroll = function() {
        scrollFunction()
    });

    // date call on chart canvas and chart data load on canvas  

    const currentDate = new Date();
    var getCurrentYear = currentDate.getFullYear();
    var getCurrentMonth = currentDate.getMonth() + 1;
    var userType, monthYear;
    var monthControl = "2020";

    $(function() {
        // get min and max month for input tag
        const date = new Date()
        const year = date.getFullYear()
        monthControl.value = `${year}-${month}`;
        // console.log(monthControl.value);

        // Set Default value for years for line chart
        for (let index = 2023; index <= getCurrentYear; index++) {
            if (index == getCurrentYear) {
                $("#customer_years_id").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                $("#revenue_years_id").append('<option  value="' + index + '">' + index + '</option><option selected="selected" value="all">All</option>');
                $("#holiday_years_id").append('<option value="' + index + '">' + index + '</option><option selected="selected" value="all">All</option>');
            } else {
                $("#customer_years_id").append('<option value="' + index + '">' + index + '</option>');
                $("#revenue_years_id").append('<option value="' + index + '">' + index + '</option>');
                $("#holiday_years_id").append('<option value="' + index + '">' + index + '</option>');
            }
        }

        // Month selector for Customer Line Graph
        const monthNames = [
            "All","January", "February", "March", "April",
            "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];

        const selects = [
            "#customer_month_id"
        ];

        monthNames.forEach((monthText, index) => {

            selects.forEach(id => {
                $(id).append('<option value="' + index + '">' + monthText + '</option>');
            });

        });

        monthYear = monthControl.value;
    });

    //customer line chart
    var chartDom = document.getElementById('line-chart');
    var myChart = echarts.init(chartDom);

    async function customerChart(month,year) {
        try {
            let response = await fetch("../../charts/get_customer_line_echart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({
                    month: month,
                    year: year
                })
            });

            let data = await response.json();

            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: data.months
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    name: 'Customers',
                    type: 'line',
                    smooth: true,
                    data: data.data,
                    lineStyle: {
                        color: "#2ab57d"
                    },
                    itemStyle: {
                        color: "#2ab57d"
                    }
                }]
            };

            myChart.setOption(option);

            // update dashboard values
            document.getElementById("count").innerHTML = data.count;
            document.getElementById("revenue").innerHTML = data.revenue;

        } catch (error) {
            console.error("Chart loading error:", error);
        }
    }

    function customerLineChart(){

        let customerYear = $("#customer_years_id").val();
        let customerMonth = $("#customer_month_id").val();

        // convert month 0 → all
        if(customerMonth == 0){
            customerMonth = "all";
        }

        // console.log(customerYear + " " + customerMonth);

        customerChart(customerMonth, customerYear);
    }

    //updated Code for graph 2 start
    var chartDom2 = document.getElementById('doughnut-chart');
    var myChart2 = echarts.init(chartDom2);
    
    async function getAllUserRevenue(year){

        try{
            let response = await fetch("../../charts/get_revenue_doughnut_echart.php",
            {
                method:"POST",
                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                },
                body:"year="+encodeURIComponent(year)
            });

            let data = await response.json();

            let chartData = [];

            for(let i=0;i<data.labels.length;i++){
                chartData.push({
                    value:data.values[i],
                    name:data.labels[i]
                });
            }

            var option = {
                tooltip:{
                    trigger:'item'
                },
                legend:{
                    orient:'vertical',
                    left:'0%',
                    top:'middle'
                },
                series:[
                    {
                        name:'Users',
                        type:'pie',
                        radius:['40%','70%'],
                        center:['60%','50%'],
                        avoidLabelOverlap:false,
                        itemStyle:{
                            borderRadius:8,
                            borderColor:'#fff',
                            borderWidth:2
                        },
                        data:chartData
                    }
                ]
            };
            myChart2.setOption(option);
            document.getElementById("revenueAllUsers").innerHTML = data.revenue;
        }catch(error){
            console.error("Chart loading error:",error);
        }
    }
    //end graph 2

    //Revenue doughnut-chart 2 graph 3
    var chartDom3 = document.getElementById('doughnut-chart-2');
    var myChart3 = echarts.init(chartDom3);

    async function getHolidayRevenue(year){

        try{
            let response = await fetch("../../charts/get_holiday_revenue_doughnut_echart.php",
            {
                method:"POST",
                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                },
                body:"year="+encodeURIComponent(year)
            });
        
            let data = await response.json();

            let chartData = [];

            for(let i=0;i<data.labels.length;i++){
                chartData.push({
                    value: data.values[i],
                    name: data.labels[i]
                });
            }

            var option = {
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: '0%',
                    top: 'middle'
                },
                series: [
                    {
                        name: 'Users',
                        type: 'pie',
                        radius: ['40%', '70%'],   // makes it doughnut
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 8,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 16,
                                fontWeight: 'bold'
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: chartData
                    }
                ]
            };
            myChart3.setOption(option);
            document.getElementById("holiday_revenue").innerHTML = data.holiday_revenue;
        }catch(error){
            console.error("Chart loading error:",error);
        }
    }   

    
    //end graph 3

    //  calender get data and insert data  
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

    $('#btn-save-event').on('click', function(e) {
        e.preventDefault();
        // alert('Hello');
        var eventTitle = $('#event-title').val();
        var eventDate = $('#event-date').val();
        // console.log(eventTitle);
        // console.log(eventDate);
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
                    // console.log(data);
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
    //calender end
    
    // top performer start 6/3/2026
    // Get the parent UL
    const navMenu = document.getElementById('navMenu');
    // Add click listener to all child links
    navMenu.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // prevent page reload if href="#"
            
            // Remove 'active' from all links
            navMenu.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
            
            // Add 'active' to the clicked link
            this.classList.add('active');
        });
    });
    // top performer end 6/3/2026 
    
    // User Count Details AND Top Performer 
    // ajax calls for user count details section  
    function fetchUserCountDetails(){
        var userCountDetails = $('#userCountCommissionDate').val();
        // console.log(userCountDetails);
        
        if(userCountDetails) {
            var month = userCountDetails.split('-')[1];
            var year = userCountDetails.split('-')[0];
        }else{
            var month = '';
            var year = '';
            
        }   
        dataString = {
            month,
            year
        }
        // console.log(dataString);
        $.ajax({
            type: 'POST',
            data: dataString,
            url: '../../models/home/user_count_commission.php',
            cache: false,
            success: function(data) {
                // console.log(data);
                $('#userCountCommission').html(data);
            }
        });
    };

    // Trigger when month changes for User count details
    $('#userCountCommissionDate').change(fetchUserCountDetails);

    // Ajax call for Top performer 
    // Function to fetch top performers
    function fetchTopPerformers() {
        var userCountDetails = $('#topPerformerDate').val();
        var user = $('.top_p.active').attr('value'); // get currently active tab

        if(userCountDetails) {
            var month = userCountDetails.split('-')[1];
            var year = userCountDetails.split('-')[0];

            var dataString = {
                month,
                year,
                user
            };
            console.log(dataString); // replace this with your AJAX call
        }else{
            var month = "";
            var year = "";

            var dataString = {
                month,
                year,
                user
            };
            // console.log(dataString); // replace this with your AJAX call
        }

        $.ajax({
        type: 'POST',
        data: dataString,
        url: '../../models/home/top_performer_model.php',
        cache: false,
            success: function(data) {
                // console.log(data);
                $('#topPerformer').html(data);
            }
        });
    }
    
    // Trigger when month changes for top performers
    $('#topPerformerDate').change(fetchTopPerformers);

    // Trigger when tab changes
    $('.top_p').click(function(e) {
        e.preventDefault();
        $('.top_p').removeClass('active');
        $(this).addClass('active');
        fetchTopPerformers();
    });
