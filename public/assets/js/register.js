$(document).ready(function() {
    $('#register-id').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = '/';
                } else {
                    console.log(response.errors);
                }
            },
            error: function() {
                console.log('AJAX request failed');
            }
        });
    });
});
