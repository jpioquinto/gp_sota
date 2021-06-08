var $formFicha  = (modulo => {

    modulo.clickGuardar = function(e) {
        e.preventDefault();
        if ( $.trim($("input[name='nombre']").val())=='') {
            notificacion('El campo Nombre es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nombre']").focus();
			return;
		}
        if ( $.trim($("input[name='alias']").val())=='') {
            notificacion('El campo Alias es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='alias']").focus();
			return;
		}
        if ( $.trim($("input[name='descripcion']").val())=='') {
            notificacion('El campo Descripción es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nombre']").focus();
			return;
		}
        if ( !esEntero($("select[name='tipo'] option:selected").val()) || parseInt($("select[name='tipo'] option:selected").val())<=0 ) {
            notificacion('Seleccione el Tipo de Proyecto.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='tipo']").focus();
			return;
		}
        if ( !esEntero($("select[name='cobertura'] option:selected").val()) || parseInt($("select[name='cobertura'] option:selected").val())<=0 ) {
            notificacion('Seleccione la cobertura.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='cobertura']").focus();
			return;
		}
        if ( $.trim($("input[name='incorporacion']").val())=='') {
            notificacion('Seleccione la Fecha de incorporación PSPP.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='incorporacion']").focus();
			return;
		}
        if ( !esEntero($("select[name='coordinador'] option:selected").val()) || parseInt($("select[name='coordinador'] option:selected").val())<=0 ) {
            notificacion('Seleccione el Coordinador.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='coordinador']").focus();
			return;
		}
        if ( !esEntero($("select[name='responsable'] option:selected").val()) || parseInt($("select[name='responsable'] option:selected").val())<=0 ) {
            notificacion('Seleccione el Responsable.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='responsable']").focus();
			return;
		}
        if ( $("select[name='colaboradores']").select2('data').length==0 ) {
            notificacion('Seleccione los colaboradores.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='colaboradores']").focus();
			return;
		}
        var $params = {};
        $('.jq_form_proyecto').find('input').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }
            $params[$(this).attr('name')] = $(this).val();
        });
        
        if (Object.keys($params).length==0) {
            return;
        }
        $params['tipo'] = $("select[name='tipo'] option:selected").val();
        $params['cobertura'] = $("select[name='cobertura'] option:selected").val();
        $params['coordinador'] = $("select[name='coordinador'] option:selected").val();
        $params['responsable'] = $("select[name='responsable'] option:selected").val();
        $params['colaboradores'] = $("select[name='colaboradores']").val();
        
        //$util.load.show(true);
        $util.post({
            url: "Proyecto",
            metodo:"guardar",
            datos:$params,
            funcion: function(data){
              if (data.Solicitud) {
                
              }
              //$util.load.hide();
            }
        });        
    };

    modulo.clickCargarImagen = function(e) {
        e.preventDefault();
    };

    return modulo;
})($formFicha || {});
$(function() {
    $('.jq_guardar_ficha').off('click').on('click', $formFicha.clickGuardar);
    $('#data-coordinador, #data-responsable, #data-colaboradores').select2();
    $('.jq_cargar_foto').off('click').on('click', $formFicha.clickCargarImagen);
});