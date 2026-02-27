$(document).ready( function () {
    $('#user_table').DataTable();
});


function addMarkup(ta_id,package_id,product_price_adult,product_price_child,update){ 

    var markup = document.getElementById('markup_'+package_id).value;
    var data = {
        ta_id:ta_id,
        package_id:package_id,
        product_price_adult:product_price_adult,
        product_price_child:product_price_child,
        markup:markup
    }

    if ( markup > 2000 ) {
        alert('Mark-up Price cannot be more than ₹2000');
        window.location.reload();
    } else if ( update == 0 && markup == 0 ) {
        alert('Please Add valid Amount !');
    } else {
        $.ajax({
            type: "POST",
            url: "../controllers/markup_payout/markup_price.php",
            data: JSON.stringify(data),
            success:function(e){
                if (e == 1 ){
                    alert("Added Markup for the Product !!");
                    window.location.reload();
                } else if (e == 2 ){
                    alert("Updated Markup for the Product !!");
                    window.location.reload();
                } else{
                    alert("Failed to Create Record !!");
                }
            }
        }); 
    }     
}

// success message snack bar
var x = document.getElementById("bottom-snackbar");
function showBottomSnackBar(textString) {
        x.style.display = "block";
        x.innerText = textString;

        setTimeout(function(){ 
            x.style.display = "none";
        }, 4000);
}