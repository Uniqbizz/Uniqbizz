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
// var cap_date = document.getElementById("cap_date");
// var cap_text = document.getElementById("cap_text");
var cap_text_1 = document.getElementById("cap_text_1");
var cap_month = document.getElementById("month_year");
// cap_text.addEventListener("click", function(){
//     cap_date.classList.replace("d-none","d-block");
//     cap_text.classList.add("d-none");
// } );
cap_text_1.addEventListener("click", function(){
    cap_month.classList.replace("d-none","d-block");
    cap_text_1.classList.add("d-none");
} );

$('[data-bs-dismiss="modal"]').on('click', function(){
    window.location.reload();
});

// **** contracting_payout Javascript Start ****

$('#month_year').on('change', function(){
    var Totaldate = $(this).val();
    const userID = $('#userIDHidden').val();
    const myArray = Totaldate.split('-');  //split date on '-' sign and store it in array
    const TotalYear = myArray[0]; // store splited year in new variable
    const TotalMonth = myArray[1]; // store splited month in new variable
    const totalAmountMessage = "TotalAmountDate";
    const totalTableMessage = "TotalTableDate";
    // console.log(TotalYear+' '+TotalMonth);
    dataString={
        TotalYear, TotalMonth, totalAmountMessage, userID
    }
    dataString2={
        TotalYear, TotalMonth, totalTableMessage, userID
    }
    $.ajax({
        type: 'POST',
        url: 'payout/forms/cbd_payout/cbd_payout_month.php',
        data: dataString,
        cache: false,
        success: function(data){
            // console.log(data);
            $('#TotalPayoutAmountDate').html('Rs. '+data+'/-');

            $.ajax({
                type: 'POST',
                url: 'payout/forms/cbd_payout/cbd_payout_month.php',
                data: dataString2,
                cache: false,
                success: function(data2){
                    // console.log(data2);
                    $('#filteredTotalTable').html(data2);
                    $('#totalPayoutTable').DataTable();
                }
            });
        }
    });
});
// **** Total Payout Pop up model data filteration end****



// Total payout Download in Exel 
function totalPayoutExel(){
    var payoutmessage = 'TotalPayout';
    var totalPayoutDate = $('#month_year').val();
    var userID = $('#userIDHidden').val();
    var userIdTotalPay = document.getElementById('userIdTotalPay').innerHTML;
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
        window.location.href='payout/forms/cbd_payout/download_exel_cbd.php?payoutYear='+payoutYear+'&payoutMonth='+payoutMonth+'&payoutmessage='+payoutmessage+'&user_id='+userID+'&userType='+userIdTotalPay;
    }else{
        alert("Select date first");
        window.location.reload();
    }
}



// **** contracting_payout Javascript End ****