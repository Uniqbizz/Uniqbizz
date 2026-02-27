$(document).ready(function() {
    $("#pendingMarkup-table").DataTable();
});

function actionMarkup(id, pid, taid, status) {
    var dataString = 'id=' + id + '&pid=' + pid + '&taid=' + taid + '&status=' + status;

    $.ajax({
        type: "POST",
        url: "../../controllers/package_markup/package_markup_action.php",
        data: dataString,
        cache: false,
        success: function(data) {
            // console.log('data'+data);
            if (data == '1') {
                alert("Markup Status Update");
                window.location.reload();
            } else {
                alert("Request Failed !!");
                window.location.reload();
            }
        }
    });

};