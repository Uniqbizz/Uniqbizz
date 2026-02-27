//accordian
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}

//to close accordian
function closeBtn() {
    document.getElementById("display-accordian").style.display = "none";
}

var designation = '';
var user_id = '';

// get Users
$('#designation').on('change', function() {
    designation = $('#designation').val();
    document.getElementById("display-accordian").style.display = "none";

    $.ajax({
        type: 'POST',
        url: '../../payout/forms/get_users.php',
        data: "designation=" + designation,
        success: function(e) {
            $('.user_row').remove();
            if (e == "no_users") {
                alert("No Users Found !!");
                $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No Records Found</td></tr>');
            } else {
                $('#user_id_name').html(e);
                $('#userTable').append('<tr><td class="user_row" style="text-align: center" colspan="8">No User Selected</td></tr>');
            }
        },
        error: function(err) {
            console.log(err);
        },
    });
});

//get levels
$('#user_id_name').on('change', function() {
    designation = $('#designation').val();
    var user_type='';
    if (designation == 'bcm'){
        user_type=24;
    }
    if (designation == 'bdm'){
        user_type=25;
    }
    if (designation == 'business_mentor'){
        user_type=26;
    }
    if (designation == 'master_franchisee'){
        user_type=28;
    }
    if (designation == 'sponsor_franchisee'){
        user_type=30;
    }
    if (designation == 'corporate_agency'){
        user_type=16;
    }
    if (designation == 'sub_franchisee'){
        user_type=29;
    }
    if (designation == 'ca_travelagency'){
        user_type=11;
    }
    if (designation == 'ca_customer'){
        user_type=10;
    }
    user_id = $('#user_id_name').val();
    console.log(user_id);

    $.ajax({
        type: 'POST',
        url: '../../models/channels/get_channels.php',
        data: {
            user_id: user_id,
            user_role: designation,
            user_type:user_type
        },
        success: function(res) {
            $("#accordian_container").html(res);
        },
        error: function(err) {
            console.log(err);
        },
    });
    
});

//-------------------- accordian start --------------------
function showPannel(e) {
    var accordian = e;
    accordian.classList.toggle("active");

    var panel = e.nextElementSibling;
    if (panel.style.display === "block") {
        panel.style.display = "none";
    } else {
        panel.style.display = "block";
    }
}

// close accordian
function closeBtn() {
    document.getElementById("display-accordian").style.display = "none";
}
// makes tr elements active on select
function selectedRow() {
    var index,
        table = document.getElementById("userTable");

    for (var i = 1; i < table.rows.length; i++) {
        table.rows[i].onclick = function() {
            // remove the background from the previous selected row
            if (typeof index !== "undefined") {
                table.rows[index].classList.toggle("selected");
            }
            index = this.rowIndex; // get the selected row index
            this.classList.toggle("selected"); // add class selected to the row

            // get referrals customer ID
            var cell_month = this.getElementsByTagName("td")[0];
            var cell_year = this.getElementsByTagName("td")[1];
            var month = cell_month.innerHTML;
            var year = cell_year.innerHTML;

            // set data
            var data = {
                beneficiary: beneficiary,
                user_id: user_id
            }
            data.dataType = 'accordian_list';
            data.business_scheme_name_id = month;
            data.userType = year;
        }
    }
}
//-------------------- accordian end --------------------