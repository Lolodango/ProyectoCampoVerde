$(function(){
  function badge(estado){
    if(estado === 'resuelta') return 'success';
    if(estado === 'en_revision') return 'warning';
    return 'secondary';
  }

  function cargar(){
    $.getJSON('router.php?action=quejas_listar', function(rows){
      const $tb = $('#tbody-quejas').empty();
      (rows||[]).forEach(r=>{
        $tb.append(`
          <tr>
            <td>${r.id_queja}</td>
            <td>${r.titulo}</td>
            <td>${r.descripcion}</td>
            <td>${r.fecha ?? ''}</td>
            <td><span class="badge bg-${badge(r.estado)}">${r.estado}</span></td>
          </tr>
        `);
      });
    });
  }

  $('#form-queja').on('submit', function(e){
    e.preventDefault();
    $.ajax({
      url: 'router.php?action=quejas_crear',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(r){
        if(r && r.ok){ $('#form-queja')[0].reset(); cargar(); }
        else alert(r.msg || 'No se pudo crear la queja.');
      }
    });
  });

  cargar();
});
