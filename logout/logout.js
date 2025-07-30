$(document).ready(function(){
  $(".mylogout").click(function(e){
  	 e.preventDefault();
// alert();
  location.href = "../dashboard/logout.php";
// alert();
  });

  $(".my2logout").click(function(e){
  	 e.preventDefault();
// alert();
  location.href = "dashboard/logout.php";
// alert();
  });
});





// get coupon code copy
function getCouponCode(value) {
  // get the array index of div Container
  var array_index = Array.prototype.slice.call( document.getElementsByClassName('get_coupon_code'), 0 );
  var index = array_index.indexOf(event.currentTarget);
  
  // Get Inner Text of the span class
  var copyText = document.getElementsByClassName("coupon_code");
  var getText = copyText[index].innerText;

  // Copy Code To Clipboard
  const elem = document.createElement('textarea');
      elem.value = getText;
      document.body.appendChild(elem);
      elem.select();
      document.execCommand('copy');
      document.body.removeChild(elem);
  
  alert("#"+getText+" Copied to Clipboard !! ");
}
