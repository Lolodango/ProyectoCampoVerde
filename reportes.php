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
  <title>Reportes - Campo Verde</title>
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
          <h3 class="text-success mb-4">Mis Reportes</h3>

          <div class="mb-5">
            <h5>Historial de Reportes Enviados</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="table-success">
                  <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                  </tr>
                </thead>
                <tbody id="misReportesBody">
                  <tr><td colspan="5" class="text-center text-muted">Cargando…</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="mb-5">
            <h5>Registrar Nuevo Reporte</h5>

            <form id="form-reporte" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="area" class="form-label">Área Afectada</label>
                <select class="form-select" id="area" name="area" required>
                  <option value="">Selecciona</option>
                  <option value="Jardines">Jardines</option>
                  <option value="Parque Infantil">Parque Infantil</option>
                  <option value="Gimnasio">Gimnasio</option>
                  <option value="Zonas Comunes">Zonas Comunes</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describa el problema con detalle..." required></textarea>
              </div>

              <div class="mb-3">
                <label for="foto" class="form-label">Foto del Problema (opcional)</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
              </div>

              <button type="submit" class="btn btn-success">Enviar Reporte</button>
            </form>

            <div id="reporteResult" class="mt-3"></div>
          </div>
        </section>
      </main>

      <?php include 'components/footer.html'; ?>
    </div>
  </div>

  <!-- jQuery + script -->
  <script src="js/jquery-3.7.1.min.js"></script>
  <script>
  // Ajusta BASE si tu carpeta cambia
  const BASE = '/ProyectoClienteServidorFinal/ProyectoCampoVerde';

  // Helpers para mostrar datos bonitos
  function areaDesdeTitulo(titulo) {
    if (!titulo) return '';
    const pref = 'Reporte: ';
    return titulo.startsWith(pref) ? titulo.slice(pref.length) : titulo;
  }
  function estadoTexto(id_estado) {
    if (String(id_estado) === '1') return 'En revisión';
    if (String(id_estado) === '2') return 'Resuelto/Inactivo';
    return String(id_estado || '');
  }

  // Cargar "Mis reportes"
  function cargarMisReportes() {
    $.ajax({
      url: `${BASE}/router.php?action=reportes_listar`,
      method: 'GET',
      dataType: 'json',
      success: function(res) {
        const $tb = $('#misReportesBody');
        if (!res || res.status !== 'success') {
          $tb.html('<tr><td colspan="5" class="text-center text-danger">No se pudieron cargar los reportes</td></tr>');
          return;
        }
        const data = res.data || [];
        if (data.length === 0) {
          $tb.html('<tr><td colspan="5" class="text-center text-muted">No hay reportes aún</td></tr>');
          return;
        }

        const rows = data.map((r, idx) => {
          const area = areaDesdeTitulo(r.titulo || '');
          const fecha = r.fecha || '';
          const estado = estadoTexto(r.id_estado);
          const desc = (r.descripcion || '').replace(/\n/g,'<br>');
          return `
            <tr>
              <td>${idx + 1}</td>
              <td>${fecha}</td>
              <td>${area}</td>
              <td>${estado}</td>
              <td>${desc}</td>
            </tr>
          `;
        });
        $tb.html(rows.join(''));
      },
      error: function(xhr) {
        console.log('listar -> RAW:', xhr.responseText);
        $('#misReportesBody').html('<tr><td colspan="5" class="text-center text-danger">Error de red</td></tr>');
      }
    });
  }

  $(function () {
    // Envío del formulario (crear)
    $('#form-reporte').on('submit', function (e) {
      e.preventDefault();
      const fd = new FormData(this);

      const area = ($('#area').val() || '').trim();
      const descripcion = ($('#descripcion').val() || '').trim();

      if (!area || !descripcion) {
        $('#reporteResult').html('<div class="alert alert-danger">Área y descripción son requeridas</div>');
        return;
      }

      fd.append('titulo', `Reporte: ${area}`);

      $.ajax({
        url: `${BASE}/router.php?action=reportes_crear`,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
          if (res && res.status === 'success') {
            $('#reporteResult').html(
              `<div class="alert alert-success">Reporte enviado (#${res.id_reporte})</div>`
            );
            $('#form-reporte')[0].reset();
            // 🔄 Refrescar la tabla
            cargarMisReportes();
          } else {
            $('#reporteResult').html(
              `<div class="alert alert-danger">${(res && res.message) || 'Error al enviar'}</div>`
            );
          }
        },
        error: function (xhr) {
          console.log('Respuesta cruda:', xhr.responseText);
          $('#reporteResult').html('<div class="alert alert-danger">Error de red o ruta inválida</div>');
        }
      });
    });

    // Cargar mis reportes al entrar
    cargarMisReportes();
  });
  </script>
</body>
</html>
