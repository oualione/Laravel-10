// sweet-alert.js
document.addEventListener("DOMContentLoaded", function() {
    // Success alert
    if (document.getElementById('sweet_success_message')) {
        Swal.fire({
            icon: 'success',
            title: document.getElementById('sweet_success_title').value,
            text: document.getElementById('sweet_success_message').value,
        });
    }
    // Error alert
    if (document.getElementById('sweet_error_message')) {
        Swal.fire({
            icon: 'error',
            title: document.getElementById('sweet_error_title').value,
            text: document.getElementById('sweet_error_message').value,
        });
    }
});