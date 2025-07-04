$("#submit").click(function(e){
    e.preventDefault();

    var name = $('#name').val();
    var email = $('#email').val();
    var phnumber = $('#phnumber').val();
    var comments = $('#comments').val();



    if(name ==''){
    	alert("Please Enter Name");
    }else if(email ==''){
    	alert("Please Enter Email");
    }else if(phnumber == ''){
    	alert("Please Enter Phone No.");
    }else if(comments == ''){
    	alert("Please Enter Message");
    }else{

    var datastring='name='+name+'&email='+email+'&phnumber='+phnumber+'&comments='+comments;
    
    

      $.ajax({
        type: "POST",
        url: "send_message/submit_data",
        data: datastring,
        success: function (res) {
        if (res==1) {
          alert("Thank you for contacting us!");
          window.location.reload();
        }
        else{
          alert("Something went wrong!");
        }
            },
        });
  }
    
    
  });
