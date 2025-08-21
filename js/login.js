$(function () {
  $('#login-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: 'router.php?action=login',
      method: 'POST',
      data: $(this).serialize(), // requiere name="username" y name="password"
      dataType: 'json',
      success: function (res) {
        if (res && res.status === 'success') {
          window.location.href = 'dashboard.php';
        } else {
          $('#loginResult').text(res && res.message ? res.message : 'Error en el login');
        }
      },
      error: function (xhr) {
        console.log('Respuesta cruda:', xhr.responseText);
        $('#loginResult').text('Error de red');
      }
    });
  });
});
