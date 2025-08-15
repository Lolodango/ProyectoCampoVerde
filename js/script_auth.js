// js/script_auth.js  (sin jQuery, pero mimando el flujo "restaurante")
(function () {
  // Enviar como x-www-form-urlencoded
  async function postLogin(username, password) {
    const body = new URLSearchParams({ username, password }).toString();

    const res = await fetch('router.php?action=login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body
    });

    const data = await res.json().catch(() => ({}));
    if (!res.ok || data.status !== 'success') {
      throw new Error((data && data.message) || 'Credenciales inválidas');
    }
    return true;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (!form) return;

    const userInput = document.getElementById('usuario');
    const passInput = document.getElementById('contrasena');
    const btn = form.querySelector('.btn.btn-green') || form.querySelector('[type="submit"]');
    const errorBox = document.getElementById('login-error');

    // Intercepta el clic del <a> para no navegar sin validar
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      if (errorBox) errorBox.textContent = '';

      const u = (userInput.value || '').trim();
      const p = passInput.value || '';
      if (!u || !p) { if (errorBox) errorBox.textContent = 'Usuario y contraseña son obligatorios'; return; }

      btn.setAttribute('disabled', 'disabled');
      const original = btn.textContent;
      btn.textContent = 'Ingresando...';

      try {
        await postLogin(u, p);
        window.location.href = 'dashboard.html';
      } catch (err) {
        if (errorBox) errorBox.textContent = err.message || 'No se pudo iniciar sesión';
        btn.removeAttribute('disabled');
        btn.textContent = original;
      }
    });
  });
})();
