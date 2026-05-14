//transfer feature modal
function openTransferModal(user_id, transfer_id, status,user_type)
{
    $("#transfer_user_id").val(user_id);
    $("#transfer_id").val(transfer_id);
    $("#transfer_status").val(status);

    $("#transferText").val('');
    $("#charCount").text(0);
    $('#user_type').val(user_type)

    if(status == 2){
        $("#transferTitle").text("Approve Transfer");
        $("#reasonLabel").text("Approval Reason");
    }else{
        $("#transferTitle").text("Reject Transfer");
        $("#reasonLabel").text("Rejection Remark");
    }

    $("#transferModal").modal("show");
}

// Character counter
$("#transferText").on("input", function(){
    $("#charCount").text($(this).val().length);
});

//transfer feature ajax
function submitTransfer()
{
    let user_id = $("#transfer_user_id").val();
    let transfer_id = $("#transfer_id").val();
    let status = $("#transfer_status").val();
    let user_type = $('#user_type').val();
    let text = $("#transferText").val();

    if(text.trim() == ''){
        alert("Reason is required");
        return;
    }

    $.ajax({
        url:'../../controllers/user_transfer/transfer_action.php',
        type:'POST',
        data:{
            transfer_user_id:user_id,
            transfer_id:transfer_id,
            status:status,
                        text:text,
                        user_type:user_type
                    },
                    success:function(res){
                        $("#transferModal").modal("hide");
                        if (res == 2) {
                            alert('User Transfered Approved Successfully!');
                        }else if(res == 3){
                            alert('User Transfer Rejected!');
                        }else{
                            alert('User Transfer Failed!');
                        }
                       location.reload();
                    }
    });
}