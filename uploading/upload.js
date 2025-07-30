
var uploadUrl = "../../uploading/upload.php";
var transactuploadUrl = "../uploading/upload.php";

//employee BCH and BDM pics upload
// ** Profile Pic upload **
$('#profile_pic').change(function(){
    var folder = 'profile_pic';
    
    var file_data = $('#profile_pic').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('folder',folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#profile_pic').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#profile_pic').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#profile_pic').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#profile_pic').val('');
            }else{
                $("#preview1").show();
                $("#img_pre1").attr("src","../../uploading/"+data);
                $("#img_path1").val(data);
            }
                
        }
    });
});

// ** Id proof Pic upload **
$('#id_proof').change(function(){
    var folder = 'id_proof';

    var file_data = $('#id_proof').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('folder',folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#id_proof').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#id_proof').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#id_proof').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#id_proof').val('');
            }else{
                $("#preview2").show();
                $("#img_pre2").attr("src","../../uploading/"+data);
                $("#img_path2").val(data);
            }
        }
    });
});

// ** Bank Passbook Pic upload **
$('#bank_details').change(function(){
    var folder = 'passbook';

    var file_data = $('#bank_details').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('folder',folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#bank_details').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#bank_details').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#bank_details').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#bank_details').val('');
            }else{
                $("#preview3").show();
                $("#img_pre3").attr("src","../../uploading/"+data);
                $("#img_path3").val(data);
            }
        }
    });
});

// ** cheque/transact pic **
$('#upload_cheque').change(function () {
    
    var folder = 'tatopup';

    var file_data = $('#upload_cheque').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: transactuploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_cheque').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_cheque').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_cheque').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_cheque').val('');
            }else{
                $("#previewcheque").show();
                $("#previewcheque1").attr("src", "../uploading/" + data);
                $("#previewcheque2").val(data);
            }
            
        }
    });
});

// ** Profile Pic upload  For BM BC CBD CA/TE TA CU**
$('#upload_file1').change(function () {
    var folder = 'profile_pic';

    var file_data = $('#upload_file1').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file1').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file1').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file1').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file1').val('');
            }else{
                $("#preview1").show();
                $("#img_pre1").attr("src","../../uploading/"+data);
                $("#img_path1").val(data);
            }
        }
    });
});

// ** Aadhar Card Pic upload **
$('#upload_file2').change(function () {
    var folder = 'aadhar';

    var file_data = $('#upload_file2').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file2').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file2').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file2').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file2').val('');
            }else{
                $("#preview2").show();
                $("#img_pre2").attr("src","../../uploading/"+data);
                $("#img_path2").val(data);
            }
        }
    });
});

// ** PAN Card Pic upload **
$('#upload_file3').change(function () {
    var folder = 'pancard';

    var file_data = $('#upload_file3').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
           if(data == 1){
                alert("Upload Failed");
                $('#upload_file3').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file3').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file3').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file3').val('');
            }else{
                $("#preview3").show();
                $("#img_pre3").attr("src","../../uploading/"+data);
                $("#img_path3").val(data);
            }
        }
    });
});

// ** Bank Passbook Pic upload **
$('#upload_file4').change(function () {
    var folder = 'passbook';

    var file_data = $('#upload_file4').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file4').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file4').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file4').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file4').val('');
            }else{
                $("#preview4").show();
                $("#img_pre4").attr("src","../../uploading/"+data);
                $("#img_path4").val(data);
            }
        }
    });
});

// ** Voting Card Pic upload **
$('#upload_file5').change(function () {
    var folder = 'voting';

    var file_data = $('#upload_file5').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file5').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file5').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file5').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file5').val('');
            }else{
                $("#preview5").show();
                $("#img_pre5").attr("src","../../uploading/"+data);
                $("#img_path5").val(data);
            }
        }
    });
});

// ** Payment Proof Pic upload **
$('#upload_file6').change(function () {
    var folder = 'payment';

    var file_data = $('#upload_file6').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file6').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file6').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file6').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file6').val('');
            }else{
                $("#preview6").show();
                $("#img_pre6").attr("src","../../uploading/"+data);
                $("#img_path6").val(data);
            }
        }
    });
});

// ** Payment Proof Pic upload (overview)**
$('#upload_file61').change(function () {
    var folder = 'payment';

    var file_data = $('#upload_file61').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder', folder);
    $.ajax({
        url: uploadUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            if(data == 1){
                alert("Upload Failed");
                $('#upload_file61').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file61').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file61').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file61').val('');
            }else{
                
                $("#preview61").show();
                $("#img_pre61").attr("src","../../uploading/"+data);
                $("#img_path61").val(data);
            }
        }
    });
});