var $accion = (modulo => {

    modulo.clickGuardar = function(e) {
        e.preventDefault();
        if ( $.trim($("input[name='definicion']").val())=='') {
            notificacion('El campo Definición es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='definicion']").focus();
			return;
		}
        if ( $.trim($("input[name='descripcion']").val())=='') {
            notificacion('Es necesaria una descripción para la Acción General.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='descripcion']").focus();
			return;
		}
        if ( !esEntero($("select[name='coordinador'] option:selected").val()) || parseInt($("select[name='coordinador'] option:selected").val())<1 ) {
            notificacion('Seleccione el Coordinador.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='coordinador']").focus();
			return;
		}
        if ( !esEntero($("input[name='ponderacion']").val()) ) {
            notificacion('La Ponderación debe ser numérica.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='ponderacion']").focus();
			return;
		}
        if ( !esEntero($("input[name='orden']").val()) ) {
            notificacion('El campo orden debe ser un entero (Posición de la Orden General en el listado).', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='orden']").focus();
			return;
		}

        var $params = {};
        $('.jq_form_accion').find('input, textarea').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }
            $params[$(this).attr('name')] = $.trim($(this).val());
        });
        
        if (Object.keys($params).length==0) {
            return;
        }
        $params['coordinador'] = $("select[name='coordinador'] option:selected").val();
        $params['proyecto_id'] = $proyecto.getId();
        
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"guardarAccionGral",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('#jq_modal_accion').modal('hide');                
                }              
            }
        });          
    };

    modulo.clickGuardarSubAccion = function(e) {
        e.preventDefault();
        if ( $.trim($("input[name='definicion']").val())=='') {
            notificacion('El campo Definición es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='definicion']").focus();
			return;
		}
        if ( $.trim($("input[name='descripcion']").val())=='') {
            notificacion('Es necesaria una descripción para la Acción General.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='descripcion']").focus();
			return;
		}
        if ( $.trim($("input[name='programa']").val())=='') {
            notificacion('Es necesaria el Identificador del Programa del Ramo.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='programa']").focus();
			return;
		}
        if ( $.trim($("input[name='fecha_ini']").val())=='') {
            notificacion('Seleccione la Fecha inicial.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='fecha_ini']").focus();
			return;
		}
        if ( $.trim($("input[name='fecha_fin']").val())=='') {
            notificacion('Seleccione la Fecha de finalización para esta acción específica.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='fecha_fin']").focus();
			return;
		}
        if ( !esEntero($("select[name='responsable'] option:selected").val()) || parseInt($("select[name='responsable'] option:selected").val())<1 ) {
            notificacion('Seleccione el/la Responsable.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='responsable']").focus();
			return;
		}
        if ( $.trim($("textarea[name='meta']").val())=='') {
            notificacion('Ingrese la meta a lograr con esta acción.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("textarea[name='meta']").focus();
			return;
		}

        var $params = {};
        $('.jq_form_accion').find('input, textarea').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }
            $params[$(this).attr('name')] = $.trim($(this).val());
        });
        
        if (Object.keys($params).length==0 || !$params.hasOwnProperty('accion_id')) {
            return;
        }
        $params['responsable'] = $("select[name='responsable'] option:selected").val();
        
        //console.log($params);return;
        
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"guardarAccioParticular",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('#jq_modal_accion').modal('hide');                
                }              
            }
        });

    };

    return modulo;
})($accion || {});

$(function() {
    $('#jq_guardar_accion').off('click').on('click', $accion.clickGuardar);
    $('#jq_guardar_subaccion').off('click').on('click', $accion.clickGuardarSubAccion);
});