const base_url = $('input[name="base-url"]').val();
$(document).ready(function () {
    $('#updatePinForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send Ajax request
        $.ajax({
            url: base_url + 'profile/update_pin',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Show success message using SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Show error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function () {
                // Show generic error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
                });
            }
        });
    });
});
