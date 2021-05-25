var $dependencia = (modulo=>{
    var usuarioId = -1;

    modulo.ini = (dependencias, id, _usuarioId) => {
        var itera = 0, itempo = 0;
        usuarioId = _usuarioId;
        itempo = setInterval(function() {
            if (itera>99) {
                clearInterval(itempo);
            }
            if ($('#data-dependencia').length==0) {
                itera++; return true;
            }
            $('#data-dependencia').select2();
            $('#data-dependencia').select2({data: dependencias});                     
            $('#data-dependencia').val(id).trigger('change');
            clearInterval(itempo);
        },500);
    };

    modulo.clickActualizar = function(e) {
        e.preventDefault();
        if ( !esEntero($("select[name='dependencia'] option:selected").val()) || parseInt($("select[name='dependencia'] option:selected").val())<=0 ) {
            notificacion('Seleccione la dependencia.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='dependencia']").focus();
			return;
		}
        var $params = {
            dependencia:$("select[name='dependencia'] option:selected").val(),
            id:usuarioId
        };
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"cambiarDependencia",
            datos:$params,
            funcion: function(data){
              if (data.Solicitud) {
                $('#jq_modal_nuevaorg').modal('hide');
              }
              //$util.load.hide();
            }
          });
    };

    return modulo;
})($dependencia || {});

$(function() {
    $('#jq_cambiar_organizacion').off('click').on('click', $dependencia.clickActualizar);
});
