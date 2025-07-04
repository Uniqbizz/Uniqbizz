// datatable initalise 
$(document).ready(function(){
    $("#payoutDetailsTable").DataTable({
        order: [
            [0, 'desc'], 
            [1, 'desc']
        ], 
        // Assuming 'id' is the first column and 'timestamp_column' is the second column
    });
    $("#previous_payout_table").DataTable();
    $("#next_payout_table").DataTable();
    
});

// Hide date label and show input type date 
var cap_date = document.getElementById("cap_date");
var cap_text = document.getElementById("cap_text");
var cap_text_1 = document.getElementById("cap_text_1");
var cap_month = document.getElementById("month_year");
cap_text.addEventListener("click", function(){
    cap_date.classList.replace("d-none","d-block");
    cap_text.classList.add("d-none");
} );
cap_text_1.addEventListener("click", function(){
    cap_month.classList.replace("d-none","d-block");
    cap_text_1.classList.add("d-none");
} );

$('[data-bs-dismiss="modal"]').on('click', function(){
    window.location.reload();
});

// **** recruitment_payout Javascript Start ****

//get username based on designation changed for All payout
$('#designation').on('change', function(){
    designation = $('#designation').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url:  '../agents/get_user_Franchisee',
        data: 'designation='+designation,
        success:function(data){
            $('#user_id_name').html(data);
        },
        error: function(err){
            console.log(err);
        },
    });
});

//display username for filter perpose for All payout
$('#user_id_name').on('change', function(){
    cap_id = $(this).val();
    $('#cap_date').val('');
    // console.log(cap_id);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter.php',
        data: 'cap_id='+cap_id+'&designation='+designation,
        cache: false,
        success: function(data){
            // console.log(data);
            $("#filterTable").html(data);
            $('#payoutDetailsTable').DataTable();
        },
    });
});

//date split for filter for All payout
$('#cap_date').on('change', function(){
    designation = $('#designation').val();
    if(!designation){
        alert("Select Designation");
        window.location.reload();
    }else{
        cap_id = $('#user_id_name').val();
        cap_date = $(this).val();
        // $('#download_exel').css('display','block');
        $('#download_icon').css('display','block');
        const myArray = cap_date.split('-');  //split date on '-' sign and store it in array
        const year_split = myArray[0]; // store splited year in new variable
        const month_split = myArray[1]; // store splited month in new variable

        dataString={
            cap_id,
            designation,
            year_split,
            month_split
        }
        // console.log(dataString);
        $.ajax({
            type: 'POST',
            url: 'forms/recruitment_payout/recruitment_payout_filter.php',
            data: dataString,
            cache: false,
            success: function(data){
                // console.log(data);
                $("#filterTable").html(data);
                $('#payoutDetailsTable').DataTable();
            }
        });
    }
});
//get username based on designation changed for All payout


// **** Previous Payout Pop up model data filteration Start ****
//get username based on designation changed for Previous Payout
$('#designationPrevious').on('change', function(){
    designation = $('#designationPrevious').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url:  '../agents/get_user_Franchisee',
        data: 'designation='+designation,
        success:function(data){
            $('#user_id_namePrevious').html(data);
        },
        error: function(err){
            console.log(err);
        },
    });
});

//display username for filter perpose for Previous Payout
$('#user_id_namePrevious').on('change', function(){
    cap_id = $(this).val();
    // $('#cap_date').val('');
    // console.log(cap_id);
    year_split = $("#prevYear").val();
    month_split = $("#prevMonth").val();

    dataString={
            cap_id,
            designation,
            year_split,
            month_split
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter.php',
        data: dataString,
        cache: false,
        success: function(data){
            // console.log(data);
            $("#filterTablePrev").html(data);
            $('#payoutDetailsTable').DataTable();
        },
    });
});

// Previous payout filter option select display name and amout below 
$('#user_id_namePrevious').on('change', function(){
    cap_id = $(this).val();
    year_split = $("#prevYear").val();
    month_split = $("#prevMonth").val();
    identify = "prev&next";

    dataString={
            cap_id,
            designation,
            year_split,
            month_split,
            identify
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter_amt_user.php',
        data: dataString,
        cache: false,
        success: function(data){
            $('#prevDiv').html(data);
        },
    });
});
// **** Previous Payout Pop up model data filteration End ****


// **** Next Payout Pop up model data filteration start****
//get username based on designation changed for Previous Payout
$('#designationNext').on('change', function(){
    designation = $('#designationNext').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url:  '../agents/get_user_Franchisee',
        data: 'designation='+designation,
        success:function(data){
            $('#user_id_nameNext').html(data);
        },
        error: function(err){
            console.log(err);
        },
    });
});

//display username for filter perpose for Next Payout
$('#user_id_nameNext').on('change', function(){
    cap_id = $(this).val();
    // $('#cap_date').val('');
    // console.log(cap_id);
    year_split = $("#nextYear").val();
    month_split = $("#nextMonth").val();

    dataString={
            cap_id,
            designation,
            year_split,
            month_split
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter.php',
        data: dataString,
        cache: false,
        success: function(data){
            // console.log(data);
            $("#filterTableNext").html(data);
            $("#payoutDetailsTable2").DataTable();
        },
    });
});

// Next payout filter option select display name and amout below 
$('#user_id_nameNext').on('change', function(){
    cap_id = $(this).val();
    year_split = $("#nextYear").val();
    month_split = $("#nextMonth").val();
    identify = "prev&next";

    dataString={
            cap_id,
            designation,
            year_split,
            month_split,
            identify
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter_amt_user.php',
        data: dataString,
        cache: false,
        success: function(data){
            $('#nextDiv').html(data);
        },
    });
});
// **** Next Payout Pop up model data filteration end****


// **** Total Payout Pop up model data filteration start****
//get username based on designation changed for Total Payout
$('#designationTotal').on('change', function(){
    designation = $('#designationTotal').val();
    // console.log(designation);
    $.ajax({
        type: 'POST',
        url:  '../agents/get_user_Franchisee',
        data: 'designation='+designation,
        success:function(data){
            $('#user_id_nameTotal').html(data);
        },
        error: function(err){
            console.log(err);
        },
    });
});

//display username for filter perpose for Total Payout
$('#user_id_nameTotal').on('change', function(){
    cap_id = $(this).val();
    // $('#cap_date').val('');
    // console.log(cap_id);
    // year_split = $("#nextYear").val() ? '' : '';
    // month_split = $("#nextMonth").val() ? '' : '';
    TotalPayoutFilter = "TotalPayoutFilter";

    dataString={
            cap_id,
            designation,
            TotalPayoutFilter
            // year_split,
            // month_split
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter.php',
        data: dataString,
        cache: false,
        success: function(data){
            // console.log(data);
            $("#filteredTotalTable").html(data);
            $("#filteredTotalTables").DataTable();
        },
    });
});

// Total payout filter option select display name and amout below 
$('#user_id_nameTotal').on('change', function(){
    cap_id = $(this).val();
    year_split = $("#nextYear").val();
    month_split = $("#nextMonth").val();

    dataString={
            cap_id,
            designation,
            year_split,
            month_split
    }
    // console.log(dataString);
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_filter_amt_user.php',
        data: dataString,
        cache: false,
        success: function(data){
            $('#totalDiv').html(data);
        },
    });
});

$('#month_year').on('change', function(){
    var Totaldate = $(this).val();
    const myArray = Totaldate.split('-');  //split date on '-' sign and store it in array
    const TotalYear = myArray[0]; // store splited year in new variable
    const TotalMonth = myArray[1]; // store splited month in new variable
    const totalAmountMessage = "TotalAmountDate";
    const totalTableMessage = "TotalTableDate";
    // console.log(TotalYear+' '+TotalMonth);
    dataString={
        TotalYear, TotalMonth, totalAmountMessage
    }
    dataString2={
        TotalYear, TotalMonth, totalTableMessage
    }
    $.ajax({
        type: 'POST',
        url: 'forms/recruitment_payout/recruitment_payout_month.php',
        data: dataString,
        cache: false,
        success: function(data){
            console.log(data);
            $('#TotalPayoutAmountDate').html('Rs. '+data+'/-');

            $.ajax({
                type: 'POST',
                url: 'forms/recruitment_payout/recruitment_payout_month.php',
                data: dataString2,
                cache: false,
                success: function(data2){
                    console.log(data);
                    $('#filteredTotalTable').html(data2);
                    $('#totalPayoutTable').DataTable();
                }
            });
        }
    });
});
// **** Total Payout Pop up model data filteration end****

//get payment details to save in table. 
function paymentId(id, userID, message, Commi, status, col_update){

    // when clicked on pending status buttton dismiss all model and open payment model
    // $("#payoutDetailsTablePrev").attr("data-dismiss","modal");
    // $("#payoutDetailsTableNext").attr("data-dismiss","modal");

    var id = id;
    var userID = userID;
    var message = message;
    var Commi = Commi;
    var status = status;
    var col_update = col_update;

    // data = {
    //     id,userID,message1,BC_Commi,status,col_update
    // }
    // console.log(data);

    // var paymentIds = document.querySelector("#paymentIds"); 
    var paymentMessage = document.querySelector("#paymentMessage");  
    var paymentMessageDetails = document.querySelector("#paymentMessageDetails");  
    var submitPayment = document.querySelector("#submitPayment"); 
    // paymentIds.value = id +' '+ userID + ' ' + message1;
    paymentMessageDetails.value = id +'\n'+ userID + '\n' + message;

    $('#submitPayment').click(function(e){
        e.preventDefault();
        paymentMessage = $('#paymentMessage').val();
        dataString = {
            id,userID, paymentMessage, message, Commi, status, col_update
        }
        console.log(dataString);

        if(paymentMessage.length>0){
            $.ajax({
                type: 'POST',
                url: 'forms/recruitment_payout/recruitment_payout_paid.php',
                data: dataString,
                cache: false,
                success: function(data){
                    console.log(data);
                    if(data == 1){
                        // console.log(data);
                        alert("Payment Details Saved Successfully.");
                        window.location.reload();
                    }else{
                        alert("Somthing went wrong !!");
                        window.location.reload();
                    }
                }
            });
        }else{
            alert("Please Write Payment Message.");
            // window.location.reload();
        }
            
    });
}

// Total payout Download in Exel 
function totalPayoutExel(){
    var payoutmessage = 'TotalPayout';
    var totalPayoutDate = $('#month_year').val();
    if(totalPayoutDate){
        const myArray = totalPayoutDate.split('-');  //split date on '-' sign and store it in array
        const payoutYear = myArray[0]; // store splited year in new variable
        const payoutMonth = myArray[1]; // store splited month in new variable
        // alert("Date :"+totalPayoutDate+" Year :"+year_split+" Month :"+month_split);
        // dataString={
        //     payoutYear, payoutMonth, payoutmessage
        // }
        // $.ajax({
        //     type: 'GET',
        //     url: 'download_exel_ca',
        //     data: dataString,
        //     cache: false,
        //     success: function(data){
        //         console.log(data);
        //     }
        // });
        window.location.href='forms/recruitment_payout/download_exel_ca?payoutYear='+payoutYear+'&payoutMonth='+payoutMonth+'&payoutmessage='+payoutmessage;
    }else{
        alert("Select date first");
        window.location.reload();
    }
}

// All Payout filter option download in exel 
function allPayoutExel(){
    var designation = $('#designation').val();
    var user_id = $('#user_id_name').val();
    var date = $('#cap_date').val();
    var payoutmessage = 'allPayout';
    
    const myArray = date.split('-');  //split date on '-' sign and store it in array
    const payoutYear = myArray[0]; // store splited year in new variable
    const payoutMonth = myArray[1]; // store splited month in new variable
    // console.log(designation + user_id + date + payoutmessage);
    window.location.href='forms/recruitment_payout/download_exel_ca?payoutYear='+payoutYear+'&payoutMonth='+payoutMonth+'&payoutmessage='+payoutmessage+'&designation='+designation+'&user_id='+user_id;
}

// **** recruitment_payout Javascript End ****



