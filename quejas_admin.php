<?php
session_start();
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] ?? '') !== 'Administrador') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quejas (Administrador) | Campo Verde</title>
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
        <h3 class="text-success mb-4">Todas las Quejas de Usuarios</h3>

        <!-- Filtros -->
        <div class="mb-3">
          <div class="btn-group" role="group" aria-label="Filtro por estado">
            <button class="btn btn-success active filtro" data-estado="">Todas</button>
            <button class="btn btn-outline-warning filtro" data-estado="pendiente">Pendientes</button>
            <button class="btn btn-outline-primary filtro" data-estado="en_revision">En revisión</button>
            <button class="btn btn-outline-success filtro" data-estado="resuelta">Resueltas</button>
          </div>
          <small id="msgAdmin" class="ms-3"></small>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-success">
              <tr>
                <th style="width:70px">ID</th>
                <th style="width:140px">Casa</th>
                <th style="width:150px">Fecha</th>
                <th style="width:220px">Título</th>
                <th>Descripción</th>
                <th style="width:140px">Estado</th>
                <th style="width:210px">Acciones</th>
              </tr>
            </thead>
            <tbody id="tbody-quejas-admin">
              <tr><td colspan="7" class="text-center">Cargando...</td></tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <?php include 'components/footer.html'; ?>
  </div>
</div>

<script>
// Utilidades UI
function badgeClass(estado){
  if (estado === 'resuelta') return 'success';
  if (estado === 'en_revision') return 'primary';
  return 'warning'; // pendiente
}
function setMsg(text, ok=true){
  const el = document.getElementById('msgAdmin');
  el.classList.remove('text-danger','text-success');
  el.classList.add(ok ? 'text-success' : 'text-danger');
  el.textContent = text || '';
  if (text) setTimeout(()=>{ el.textContent=''; }, 2000);
}

// Carga de datos
async function cargarTabla(estado=''){
  const tbody = document.getElementById('tbody-quejas-admin');
  tbody.innerHTML = '<tr><td colspan="7" class="text-center">Cargando...</td></tr>';

  let url = 'router.php?action=quejas_admin_listar';
  if (estado) url += '&estado=' + encodeURIComponent(estado);

  try {
    const res = await fetch(url, { credentials: 'same-origin' });
    if (res.status === 401 || res.status === 403) { location.href = 'index.php'; return; }
    const rows = await res.json();

    tbody.innerHTML = '';
    if (!rows || !rows.length) {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center">Sin registros</td></tr>';
      return;
    }

    rows.forEach(r => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${r.id_queja}</td>
        <td>${r.numero_casa ?? ''}</td>
        <td>${r.fecha ?? ''}</td>
        <td>${r.titulo}</td>
        <td>${r.descripcion}</td>
        <td><span class="badge bg-${badgeClass(r.estado)}">${r.estado}</span></td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-outline-warning btn-estado" data-id="${r.id_queja}" data-estado="pendiente">Pendiente</button>
            <button class="btn btn-outline-primary btn-estado" data-id="${r.id_queja}" data-estado="en_revision">En revisión</button>
            <button class="btn btn-outline-success btn-estado" data-id="${r.id_queja}" data-estado="resuelta">Resuelta</button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });
  } catch (e) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Error cargando datos</td></tr>';
  }
}

// Eventos
document.addEventListener('DOMContentLoaded', () => {
  // Filtros
  document.querySelectorAll('.filtro').forEach(btn=>{
    btn.addEventListener('click', (e)=>{
      document.querySelectorAll('.filtro').forEach(b=>b.classList.remove('active','btn-success'));
      document.querySelectorAll('.filtro').forEach(b=>b.classList.add('btn-outline-'+(b.dataset.estado==='resuelta'?'success':b.dataset.estado==='en_revision'?'primary':'warning')));
      e.currentTarget.classList.add('active','btn-success');
      e.currentTarget.classList.remove('btn-outline-warning','btn-outline-primary','btn-outline-success');

      const estado = e.currentTarget.dataset.estado || '';
      cargarTabla(estado);
    });
  });

  // Cambiar estado
  document.getElementById('tbody-quejas-admin').addEventListener('click', async (e)=>{
    const btn = e.target.closest('.btn-estado');
    if (!btn) return;
    const id = btn.getAttribute('data-id');
    const estado = btn.getAttribute('data-estado');
    try {
      const res = await fetch('router.php?action=quejas_admin_estado', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        credentials: 'same-origin',
        body: new URLSearchParams({ id_queja: id, estado })
      });
      const r = await res.json();
      if (r && r.ok) {
        setMsg('Estado actualizado', true);
        // recargar conservando filtro activo
        const active = document.querySelector('.filtro.active');
        const filtro = active ? (active.dataset.estado || '') : '';
        cargarTabla(filtro);
      } else {
        setMsg('No se pudo actualizar', false);
      }
    } catch (err) {
      setMsg('Error de red', false);
    }
  });

  // Carga inicial
  cargarTabla('');
});
</script>
</body>
</html>
