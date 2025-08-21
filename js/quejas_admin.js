$(function(){
  function cargar(){
    const estado = $('#select-estado').val() || '';
    let url = 'router.php?action=quejas_admin_listar';
    if(estado) url += '&estado='+encodeURIComponent(estado);

    $.getJSON(url, function(rows){
      const $tb = $('#tbody-quejas-admin').empty();
      (rows||[]).forEach(r=>{
        $tb.append(`
          <tr>
            <td>${r.id_queja}</td>
            <td>${r.numero_casa}</td>
            <td>${r.titulo}</td>
            <td>${r.descripcion}</td>
            <td>${r.fecha ?? ''}</td>
            <td>${r.estado}</td>
            <td>
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-secondary btn-estado" data-id="${r.id_queja}" data-estado="pendiente">Pendiente</button>
                <button class="btn btn-outline-warning btn-estado"  data-id="${r.id_queja}" data-estado="en_revision">En revisión</button>
                <button class="btn btn-outline-success btn-estado"   data-id="${r.id_queja}" data-estado="resuelta">Resuelta</button>
              </div>
            </td>
          </tr>
        `);
      });
    });
  }

  $('#select-estado').on('change', cargar);

  $(document).on('click', '.btn-estado', function(){
    const id = $(this).data('id');
    const estado = $(this).data('estado');
    $.post('router.php?action=quejas_admin_estado', {id_queja:id, estado:estado}, function(r){
      try{ r = JSON.parse(r); }catch(e){}
      if(r && r.ok) cargar();
      else alert('No se pudo actualizar el estado.');
    });
  });

  cargar();
});
