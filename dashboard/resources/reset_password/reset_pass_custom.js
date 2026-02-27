// Toggle password visibility (default: visible, type="text")
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    const isVisible = input.type === "text";

    input.type = isVisible ? "password" : "text";
    icon.classList.toggle('fa-eye', isVisible);
    icon.classList.toggle('fa-eye-slash', !isVisible);
    btn.title = isVisible ? "Show Password" : "Hide Password";
}

// Password validation
function validatePasswordDetails(password) {
    return {
        lengthCheck: password.length >= 8,
        letterCheck: /[A-Za-z]/.test(password),
        numberCheck: /\d/.test(password),
        symbolCheck: /[^A-Za-z0-9]/.test(password),
    };
}

function updatePasswordFeedback(checks) {
    updateFeedbackItem('lengthCheck', checks.lengthCheck, 'At least 8 characters');
    updateFeedbackItem('letterCheck', checks.letterCheck, 'At least one letter (a-z, A-Z)');
    updateFeedbackItem('numberCheck', checks.numberCheck, 'At least one number (0–9)');
    updateFeedbackItem('symbolCheck', checks.symbolCheck, 'At least one symbol (!@#$%^&*)');
}

function updateFeedbackItem(id, passed, message) {
    const el = document.getElementById(id);
    el.innerHTML = passed
        ? '✔️ <span style="color:green;">' + message + '</span>'
        : '❌ <span style="color:red;">' + message + '</span>';
}

document.getElementById('newPassword').addEventListener('input', function () {
    const password = this.value;
    const checks = validatePasswordDetails(password);
    updatePasswordFeedback(checks);
});

$('#edit_profile').on('click', function (event) {
    event.preventDefault();

    const currentPassword = $('#currentPassword').val().trim();
    const newPassword = $('#newPassword').val().trim();
    const confirmPassword = $('#confirmPassword').val().trim();
    const user_type = $('#user_type').val().trim();
    const user_id = $('#user_id').val().trim();

    const checks = validatePasswordDetails(newPassword);
    const allPassed = Object.values(checks).every(Boolean);

    if (!allPassed) {
        alert(' Password must be at least 8 characters long and include a letter, a number, and a symbol.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert(' New Password and Confirm Password do not match.');
        return;
    }

    const formData = new FormData();
    formData.append('currentPassword', currentPassword);
    formData.append('newPassword', newPassword);
    formData.append('confirmPassword', confirmPassword);
    formData.append('user_type', user_type);
    formData.append('user_id', user_id);

    $.ajax({
        url: '../controllers/updatedata/reset_password_data.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            switch (response.trim()) {
                case 'success':
                    alert(' Password changed successfully.');
                    location.reload();
                    break;
                case 'mismatch':
                    alert(' Current Password is incorrect.');
                    break;
                case 'invalid':
                    alert(' Password validation failed on server.');
                    break;
                default:
                    alert(' Unknown error occurred. Please try again.');
                    break;
            }
        },
        error: function (xhr, status, error) {
            alert(' AJAX Error: ' + error);
        }
    });
});