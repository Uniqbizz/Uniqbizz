// view terms for user type
var u_type_id = 0;
var show_terms = document.getElementById("terms_view_box");
var terms_travelagent = document.getElementById("terms_travelagent");
var terms_franchise = document.getElementById("terms_franchise");


$("#user_type").on('change', function(){
    u_type_id = $("#user_type").val();
    console.log(u_type_id);

    if ( u_type_id == 4)
    {
      // franchise
      show_terms.style.display = "block";
      terms_franchise.style.display = "block";
      terms_travelagent.style.display = "none";
    } else if ( u_type_id == 3 ) 
    {
      // travel agent
      show_terms.style.display = "block";
      terms_franchise.style.display = "none";
      terms_travelagent.style.display = "block";
    } else {
      // hide tetms for others
      show_terms.style.display = "none";
    }
});


// accept Terms
const terms_check = $("#terms_condtion");
var terms_status = 'false';

  terms_check.change(function(event) {
    var terms = event.target;
        if (terms.checked) {
          terms_status = 'true';
          // console.log(terms_status);
            // console.log('terms has been checked');
        } else {
          terms_status = 'false';
          // console.log(terms_status);
          // console.log('unchecked');
        }
    });
    


// login 
$(document).ready(function(){
  $("#login").click(function(e){
    e.preventDefault();

      userCheck();
  // 	// alert(username);
  });
});



// allow login for users
function userCheck() {
  if ( u_type_id == 4 || u_type_id == 3 ) {
    if ( terms_status == 'true' ) {
        // console.log('terms has been checked');
        userLogin();
    } else {
        showBottomSnackBar();
        console.log('Please Read and accept terms and condition');
    }
  } else if ( u_type_id == 0 ) {
        showBottomSnackBarLoginError();
  } else {
      // console.log('normal login');
      userLogin();
  }
}

// user login function
function userLogin(){
  var username = $('#username').val();
  	var password = $('#password').val();
    var user_type = $('#user_type').val();
    var remember_me = $('#remember_me').prop( "checked" );
   
    // alert(remember_me);

    // if($('#remember_me') == true){
    //   alert('checked');
    // }
    // else{
    //   alert('unchecked');
    // }
  	var datastring='username='+username+'&password='+password+'&remember_me='+remember_me+'&user_type='+user_type;

      if (user_type=='') {
          alert("Please Select Login As");
      }else if (username=='') {
        
        alert("Please Enter Username");
      }
      else if(password==''){
        
        alert("Please Enter Password");
      }else{
        $.ajax({
          type: "POST",
          url: "login_data/submit_data.php",
          data: datastring,
            success: function (res) {
              console.log(res);
              if (res==1) {

                // alert("login ");
                // window.open("index2.php");
                // alert();
                location.href = "dashboard/index.php";
              }
              else{
                alert("username and password not correct");
              }
            },
          });
      }
}



// error message snack bar
function showBottomSnackBar() {
  var x = document.getElementById("bottom-snackbar");
      x.style.display = "block";
      x.innerText = "Please, Read and accept terms and condition, before login !!";

      setTimeout(function(){ 
        x.style.display = "none";
      }, 3000);
}


// error message snack bar
function showBottomSnackBarLoginError() {
  var x = document.getElementById("bottom-snackbar");
      x.style.display = "block";
      x.innerText = "Please, select login as first!!";

      setTimeout(function(){ 
        x.style.display = "none";
      }, 3000);
}
