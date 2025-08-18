$(function () {

    $('#login-form').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: 'router.php?action=login',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#login-form')[0].reset();
                        $('#loginResult').text('Login Okay');
                        setTimeout(function () {
                            window.location.href = 'dashboard.php';
                        }, 1000);
                    } else {
                        $('#loginResult').text(response.message || 'Error en el login');
                    }
                },
                error: function () {
                    $('#loginResult').text('Error de conexión con el servidor');
                }
            });
        });
})













