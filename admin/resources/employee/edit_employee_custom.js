let cachedEmpBlock = null;
let cachedZmBlock = null;

let registeAs=$('#registered').val()

if (registeAs == "24" || registeAs=="25" || registeAs=="31") {
    // Detach ZM block and cache it
    if (!cachedZmBlock && $('#zm_block').length) {
        cachedZmBlock = $('#zm_block').detach();
    }

    // Re-attach emp block if cached
    if (cachedEmpBlock) {
        $('#formParent').append(cachedEmpBlock);
        cachedEmpBlock = null;
    }

    $('#emp_block').removeClass('d-none');
}else if (registeAs == "27") {
    // Detach emp block and cache it
    if (!cachedEmpBlock && $('#emp_block').length) {
        cachedEmpBlock = $('#emp_block').detach();
    }

    // Re-attach zm block if cached
    if (cachedZmBlock) {
        $('#formParent').append(cachedZmBlock);
        cachedZmBlock = null;
    }

    $('#zm_block').removeClass('d-none');
}else {
    $('#emp_block, #zm_block').addClass('d-none');
}
// select Designation disable Reporting Manager
$('#designation').on('change', function() {
    var designation = $('#designation').val();
    // console.log(designation);
    if (designation == 1) {
        $('#reporting_manager').prop('disabled', true);
    } else {
        $('#reporting_manager').prop('disabled', false);
    }
});

// on zone change get branch associated with that zone
$('#zone').on('change', function() {
    var zone_id = $(this).val();
    $.ajax({
        url: '../../assets/get_data/get_branch.php',
        type: 'POST',
        data: {
            zone_id: zone_id
        },
        success: function(data) {
            $('#branch').html(data);
        }
    });
});