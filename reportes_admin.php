<?php
session_start();
if (empty($_SESSION['usuario'])) { header('Location: index.php'); exit; }
// Solo admin
$rol = $_SESSION['rol'] ?? null;
$esAdmin = ($rol === 1 || $rol === '1' || $rol === 'Administrador');
if (!$esAdmin) { header('Location: dashboard.php'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Reportes (Admin) - Campo Verde</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body class="d-flex flex-column min-vh-100">
  <div class="d-flex flex-grow-1">
    <?php include 'components/aside.php'; ?>
    <div class="d-flex flex-column flex-grow-1">
      <?php include 'components/header.php'; ?>

      <main class="flex-grow-1">
        <section class="container mt-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-success">Reportes (Administrador)</h3>
            <button id="btnRecargar" class="btn btn-outline-success btn-sm">↻ Recargar</button>
          </div>

          <div id="adminMsg"></div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-success">
                <tr>
                  <th>#</th>
                  <th>Fecha</th>
                  <th>Título</th>
                  <th>Descripción</th>
                  <th>Estado</th>
                  <th>Usuario</th>
                  <th>Casa</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="adminReportesBody">
                <tr><td colspan="8" class="text-center text-muted">Cargando…</td></tr>
              </tbody>
            </table>
          </div>
        </section>
      </main>

      <?php include 'components/footer.html'; ?>
    </div>
  </div>

  <script src="js/jquery-3.7.1.min.js"></script>
  <script>
    const BASE = '/ProyectoClienteServidorFinal/ProyectoCampoVerde';

    function estadoTexto(id_estado) {
      if (String(id_estado) === '1') return 'En revisión';
      if (String(id_estado) === '2') return 'Resuelto/Inactivo';
      return String(id_estado || '');
    }

    function pintarLista(data) {
      const $tb = $('#adminReportesBody');
      if (!data || data.length === 0) {
        $tb.html('<tr><td colspan="8" class="text-center text-muted">Sin reportes</td></tr>');
        return;
      }
      const rows = data.map((r, idx) => {
        const usuario = r.nombre_usuario || ((r.nombre || '') + ' ' + (r.primer_apellido || ''));
        const desc = (r.descripcion || '').replace(/\n/g,'<br>');
        const estado = estadoTexto(r.id_estado);
        return `
          <tr data-id="${r.id_reporte}">
            <td>${idx + 1}</td>
            <td>${r.fecha || ''}</td>
            <td>${(r.titulo || '').replaceAll('<','&lt;')}</td>
            <td>${desc}</td>
            <td><span class="badge bg-${r.id_estado==2?'secondary':'info'}">${estado}</span></td>
            <td>${usuario}</td>
            <td>${r.numero_casa || ''}</td>
            <td class="text-center text-nowrap">
              <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-outline-info btn-estado" data-estado="1" title="Marcar En revisión">En revisión</button>
                <button class="btn btn-outline-success btn-estado" data-estado="2" title="Marcar Resuelto/Inactivo">Resuelto</button>
                <button class="btn btn-outline-danger btn-eliminar" title="Eliminar lógico">Eliminar</button>
              </div>
            </td>
          </tr>
        `;
      });
      $tb.html(rows.join(''));
    }

    function cargarReportesAdmin() {
      $('#adminReportesBody').html('<tr><td colspan="8" class="text-center text-muted">Cargando…</td></tr>');
      $.ajax({
        url: `${BASE}/router.php?action=reportes_admin_listar`,
        method: 'GET',
        dataType: 'json',
        success: function(res) {
          if (!res || res.status !== 'success') {
            $('#adminReportesBody').html('<tr><td colspan="8" class="text-center text-danger">No se pudieron cargar</td></tr>');
            return;
          }
          pintarLista(res.data || []);
        },
        error: function(xhr) {
          console.log('admin_listar RAW:', xhr.responseText);
          $('#adminReportesBody').html('<tr><td colspan="8" class="text-center text-danger">Error de red</td></tr>');
        }
      });
    }

    // Cambiar estado (admin)
    $(document).on('click', '.btn-estado', function() {
      const $tr = $(this).closest('tr');
      const id = $tr.data('id');
      const nuevo = $(this).data('estado'); // 1 o 2
      $.ajax({
        url: `${BASE}/router.php?action=reportes_admin_estado`,
        method: 'POST',
        data: { id_reporte: id, id_estado: nuevo },
        dataType: 'json',
        success: function(res) {
          if (res && res.status === 'success') {
            $('#adminMsg').html('<div class="alert alert-success py-2">Estado actualizado</div>');
            cargarReportesAdmin();
          } else {
            $('#adminMsg').html('<div class="alert alert-danger py-2">No se pudo actualizar</div>');
          }
        },
        error: function(xhr) {
          console.log('estado RAW:', xhr.responseText);
          $('#adminMsg').html('<div class="alert alert-danger py-2">Error de red</div>');
        }
      });
    });

    // Eliminar lógico (admin)
    $(document).on('click', '.btn-eliminar', function() {
      if (!confirm('¿Marcar este reporte como inactivo (eliminación lógica)?')) return;
      const $tr = $(this).closest('tr');
      const id = $tr.data('id');
      $.ajax({
        url: `${BASE}/router.php?action=reportes_eliminar`,
        method: 'POST',
        data: { id_reporte: id },
        dataType: 'json',
        success: function(res) {
          if (res && res.status === 'success') {
            $('#adminMsg').html('<div class="alert alert-success py-2">Reporte marcado como inactivo</div>');
            cargarReportesAdmin();
          } else {
            $('#adminMsg').html('<div class="alert alert-danger py-2">No se pudo eliminar lógicamente</div>');
          }
        },
        error: function(xhr) {
          console.log('eliminar RAW:', xhr.responseText);
          $('#adminMsg').html('<div class="alert alert-danger py-2">Error de red</div>');
        }
      });
    });

    // Inicial
    $(function(){
      $('#btnRecargar').on('click', cargarReportesAdmin);
      cargarReportesAdmin();
    });
  </script>
</body>
</html>
