$(document).on("mouseenter", ".edit-log-tooltip", function () {

    var el = $(this);

    // If tooltip already loaded, just show it
    if (el.data("tooltipLoaded")) {
        el.tooltip("show");
        return;
    }

    var user_id = el.data("user");
    var table   = el.data("table");
    var column  = el.data("column");

    $.ajax({
        url: "../../models/common_models/get_field_logs.php",
        type: "POST",
        data: {
            user_id: user_id,
            table_name: table,
            column_name: column
        },
        success: function (response) {

            console.log(response); // your debug kept

            el.attr("data-bs-original-title", response);

            // keep your dispose logic
            el.tooltip("dispose")
              .tooltip({
                  html: true,
                  placement: "top",
                  trigger: "manual",
                  container: "body"
              });

            el.tooltip("show");

            // mark as loaded so AJAX doesn't fire again
            el.data("tooltipLoaded", true);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});

$(document).on("mouseleave", ".edit-log-tooltip", function () {
    $(this).tooltip("hide");
});