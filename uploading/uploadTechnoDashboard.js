// File use only for Chief, Executive and Super Techno Enterprise 

var uploadUrl = "../../uploading/upload.php";

// ** Document upload  For CTE, ETE, STE, TC**
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

// Resume / CV pic upload 
$('#upload_file5').change(function () {
    var folder = 'resume_cv';

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

// ** Address proof Pic upload **
$('#upload_file6').change(function () {
    var folder = 'address_proof';

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

// ** Professional profile Pic upload **
$('#upload_file7').change(function () {
    var folder = 'professional_profile';

    var file_data = $('#upload_file7').prop('files')[0];
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
                $('#upload_file7').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file7').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file7').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file7').val('');
            }else{
                $("#preview7").show();
                $("#img_pre7").attr("src","../../uploading/"+data);
                $("#img_path7").val(data);
            }
        }
    });
});

// ** Business Profile Pic upload **
$('#upload_file8').change(function () {
    var folder = 'business_profile';

    var file_data = $('#upload_file8').prop('files')[0];
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
                $('#upload_file8').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file8').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file8').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file8').val('');
            }else{
                $("#preview8").show();
                $("#img_pre8").attr("src","../../uploading/"+data);
                $("#img_path8").val(data);
            }
        }
    });
});

// ** Income Proof Pic upload **
$('#upload_file9').change(function () {
    var folder = 'income_proof';

    var file_data = $('#upload_file9').prop('files')[0];
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
                $('#upload_file9').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file9').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file9').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file9').val('');
            }else{
                $("#preview9").show();
                $("#img_pre9").attr("src","../../uploading/"+data);
                $("#img_path9").val(data);
            }
        }
    });
});

// ** Other Document Pic upload **
$('#upload_file10').change(function () {
    var folder = 'other_document';

    var file_data = $('#upload_file10').prop('files')[0];
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
                $('#upload_file10').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file10').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file10').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file10').val('');
            }else{
                $("#preview10").show();
                $("#img_pre10").attr("src","../../uploading/"+data);
                $("#img_path10").val(data);
            }
        }
    });
});

// ** Voting Card Pic upload **
$('#upload_file11').change(function () {
    var folder = 'voting';

    var file_data = $('#upload_file11').prop('files')[0];
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
                $('#upload_file11').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file11').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file11').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file11').val('');
            }else{
                $("#preview11").show();
                $("#img_pre11").attr("src","../../uploading/"+data);
                $("#img_path11").val(data);
            }
        }
    });
});

// ** Payment Proof Pic upload   **
$('#upload_file12').change(function () {
    var folder = 'payment';

    var file_data = $('#upload_file12').prop('files')[0];
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
                $('#upload_file12').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file12').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file12').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file12').val('');
            }else{
                $("#preview12").show();
                $("#img_pre12").attr("src","../../uploading/"+data);
                $("#img_path12").val(data);
            }
        }
    });
});

$('#upload_file13').change(function () {
    var folder = 'profile_pic';

    var file_data = $('#upload_file13').prop('files')[0];
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
                $('#upload_file13').val('');
            }else if(data == 2){
                alert("Invalid file Extension");
                $('#upload_file13').val('');
            }else if(data == 3){
                alert("Please select File");
                $('#upload_file13').val('');
            }else if(data == 4){
                alert("File size is greater then 2 MB");
                $('#upload_file13').val('');
            }else{
                // $("#preview1").show();
                $("#img_pre13").attr("src","../../uploading/"+data);
                $("#img_path13").val(data);
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
                $("#previewcheque1").attr("src", "../../uploading/"+data);
                $("#previewcheque2").val(data);
            }
            
        }
    });
});