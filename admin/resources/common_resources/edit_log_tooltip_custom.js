$(document).on("mouseenter",".edit-log-tooltip",function(){

    var el = $(this);

    var user_id = el.data("user");
    var table = el.data("table");
    var column = el.data("column");

    $.ajax({
        url:"../../models/common_models/get_field_logs.php",
        type:"POST",
        data:{
            user_id:user_id,
            table_name:table,
            column_name:column
        },
        success:function(response){

            console.log(response); // DEBUG

            el.attr("data-bs-original-title", response);

            el.tooltip("dispose")
                .tooltip({
                    html:true,
                    placement:"top",
                    trigger:"manual",
                    container:"body"
                })
                .tooltip("show");
        },
        error:function(xhr){
            console.log(xhr.responseText);
        }

    });

});
$(document).on("mouseleave",".edit-log-tooltip",function(){
    $(this).tooltip("hide");
});