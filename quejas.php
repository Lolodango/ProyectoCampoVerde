<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mis Quejas | Campo Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="d-flex flex-column min-vh-100">
<div class="d-flex flex-grow-1">
    <?php include 'components/aside.php'; ?>

    <div class="d-flex flex-column flex-grow-1">
        <?php include 'components/header.php'; ?>

        <main class="flex-grow-1">
            <section class="container mt-4">
                <h3 class="text-success mb-4">Mis Quejas</h3>

                <!-- Historial -->
                <div class="mb-5">
                    <h5>Historial de Quejas Enviadas</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Título</th>
                                    <th>Estado</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-quejas">
                                <tr>
                                    <td colspan="5" class="text-center">Cargando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Nueva queja -->
                <div class="mb-5">
                    <h5>Registrar Nueva Queja</h5>
                    <form id="form-queja">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                   placeholder="Ej: Ruido excesivo en la noche" required>
                        </div>
                        <div class="mb-3">
                            <label for="detalle" class="form-label">Descripción</label>
                            <textarea class="form-control" id="detalle" name="descripcion" rows="4"
                                      placeholder="Escriba aquí su queja..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar Queja</button>
                        <small id="msgQueja" class="ms-2"></small>
                    </form>
                </div>
            </section>
        </main>

        <?php include 'components/footer.html'; ?>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const tbody = document.getElementById('tbody-quejas');
  const form  = document.getElementById('form-queja');
  const msg   = document.getElementById('msgQueja');

  function badge(estado) {
    if (estado === 'resuelta') return 'success';
    if (estado === 'en_revision') return 'warning';
    return 'secondary'; // pendiente 
  }

  async function cargarQuejas() {
    try {
      const res = await fetch('router.php?action=quejas_listar', { credentials: 'same-origin' });
      if (res.status === 401) { location.href = 'index.php'; return; }
      const rows = await res.json();

      tbody.innerHTML = '';
      if (!rows || !rows.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Sin quejas registradas</td></tr>';
        return;
      }

      rows.forEach((r, i) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${i + 1}</td>
          <td>${r.fecha ?? ''}</td>
          <td>${r.titulo}</td>
          <td><span class="badge bg-${badge(r.estado)}">${r.estado}</span></td>
          <td>${r.descripcion}</td>
        `;
        tbody.appendChild(tr);
      });
    } catch (e) {
      tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se pudo cargar.</td></tr>';
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    msg.classList.remove('text-danger', 'text-success');
    msg.textContent = 'Enviando...';

    const fd = new FormData(form);
    try {
      const res = await fetch('router.php?action=quejas_crear', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
        body: new URLSearchParams(fd),
        credentials: 'same-origin'
      });
      if (res.status === 401) { location.href = 'index.php'; return; }
      const r = await res.json();

      if (r && r.ok) {
        msg.classList.add('text-success');
        msg.textContent = 'Queja enviada';
        form.reset();
        cargarQuejas();
      } else {
        msg.classList.add('text-danger');
        msg.textContent = (r && r.msg) ? r.msg : 'No se pudo crear la queja';
      }
    } catch (e) {
      msg.classList.add('text-danger');
      msg.textContent = 'Error de red';
    }
  });

  cargarQuejas();
});
</script>
</body>
</html>
