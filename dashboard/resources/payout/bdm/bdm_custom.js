
$(document).ready(function() {
    $("#payoutDetailsTable").DataTable();
    $("#previous_payout_table").DataTable();
    $("#next_payout_table").DataTable();
    $("#total_payout_table").DataTable();
    //bdm bcm list
    let user_id = $("#userIDHidden").val();
    let currentDate = new Date();
    let month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Ensures two-digit format
    let year = currentDate.getFullYear();
    let monthYear = `${year}-${month}`; // Format: MM-YYYY
    //console.log(monthYear); // Example: "03-2025"
    //let month_year=$('#cap_date').val();
    function loadBmBdmTables(monthYear) {
        let bmTable = $("#bmTable").DataTable();
        let bdmTable = $("#bdmTable").DataTable();
        $.ajax({
            url: "payout/forms/slab_payout_bdm/getbmdetails.php",
            type: "POST",
            data: {
                designation: 'bdm',
                user_id: user_id,
                month_year: monthYear
            },
            dataType: "json",
            success: function(response) {
                // Update BM Table
                //let bmTable = $("#bmTable").DataTable();


                bmTable.clear();

                if (response.bm_list.length > 0) {
                    $.each(response.bm_list, function(index, data) {
                        bmTable.row.add([
                            index + 1,
                            data.user_id,
                            data.name,
                            data.active_te_count
                        ]).draw();
                    });
                } else {

                    // Add a row that spans all columns
                    bmTable.row.add([
                        "No Data Available", "", "", ""
                    ]).draw();

                    // Center align the "No Data Available" text
                    $('#bmTable tbody tr td').attr('colspan', 4).css('text-align', 'center');
                }
            }
        });
    }
    loadBmBdmTables(monthYear);
    $("#month_year").on('change',function(){
        let monthYear=$(this).val();
        console.log('test');
        console.log('test'+monthYear);
        
        loadBmBdmTables(monthYear);
    });
});

function loadRejectionReason(Id) {
    // Make an AJAX call to fetch rejection reason (Optional)
    fetch(`payout/forms/slab_payout_bdm/get_block_reason.php?id=${Id}&userType=<?php echo $userType; ?>`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("floatingTextarea").innerText = data;
        })
        .catch(error => console.error('Error:', error));
}