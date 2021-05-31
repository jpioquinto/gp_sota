var $formPerfil = (modulo=>{
    var perfiId;
    var permisos = {};
    var btnAccion;

    modulo.ini = (id, accion) => {
        perfiId = id;
        btnAccion = accion;
        //$util.load.show(true);
        $util.post({
            url: "PerfilUsuario",
            metodo:"obtenerModulos",
            datos:{id:perfiId},
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    
                    $('#jq_arbol_modulos').jstree({ 'core' : {
                        'data' : data.arbol
                        },
                        "plugins" : [ "checkbox" ]
                    });
                }            
            }
        });

    };

    modulo.clickGuardar = function(e) {
        e.preventDefault();
        
        permisos = {};

        if ( $.trim($("input[name='nombre']").val())=='') {
            notificacion('El campo Nombre es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nombre']").focus();
			return;
		}
        if ( $.trim($("input[name='nombre']").val()).length<5) {
            notificacion('Ingrese un Nombre válido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nombre']").focus();
			return;
		}
        if ( $.trim($("input[name='descripcion']").val())=='') {
            notificacion('El campo Descripción es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='descripcion']").focus();
			return;
		}
        if ( $.trim($("input[name='descripcion']").val()).length<8) {
            notificacion('Ingrese una Descripción válida.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='descripcion']").focus();
			return;
		}
        if ( $('#jq_arbol_modulos').jstree().get_selected().length==0) {
            notificacion('Debe agregar permisos para el perfil.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
		}
        permisos = procesarPermisos($('#jq_arbol_modulos').jstree().get_json());

        if (Object.keys(permisos).length==0) {
            notificacion('Ocurrió un error al obtener los permisos.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
        }
        
        var $params = {
            padre:esEntero($("select[name='padre'] option:selected").val()) ? $("select[name='padre'] option:selected").val() : 0,
            descripcion:$.trim($("input[name='descripcion']").val()),
            nombre:$.trim($("input[name='nombre']").val()),
            permisos:permisos
        }
        if (perfiId) {
            $params['id'] = perfiId;
        }
        //$util.load.show(true);
        $util.post({
            url: "PerfilUsuario",
            metodo:"guardarPerfil",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) { 
                    setTimeout(function() { 
                        $('.jq_regresar_perfiles').trigger('click');
                        if (!perfiId) {
                            $('.jq_sidebar li .active:last').find('a').trigger('click');
                        } else {
                            btnAccion.parents('tr').find("td[data-descripcion]").html($params.descripcion);
                            btnAccion.parents('tr').find("td[data-nombre]").html($params.nombre);
                        }
                     },2500);                                       
                }            
            }
        });
    };

    modulo.clickRegresar = function(e) {
        e.preventDefault();

        $('.content-listado-perfiles').show('animate__backInLeft');                                        
        $('.content-modal').removeClass('animate__backInRight').addClass('animate__backOutRight');
        $('.content-modal').html('');
    };

    var procesarPermisos = $permisos => {        
        $.each($permisos, function() {
            if (this.children.length==0 && this.state.selected) {
                permisos[this.data.elemento_id] = {acciones:[0]};
            }
            if (this.children.length>0) {
                procesarHijos(this.children);
            }
        });
        return permisos;
    };

    var procesarHijos = $items => {        
        $.each($items, function() {
            if (this.children.length==0 && this.state.selected) {
                if (!permisos.hasOwnProperty(this.data.padre_id)) {
                    permisos[this.data.padre_id] = {acciones:[]};
                }
                permisos[this.data.padre_id].acciones.push(this.data.elemento_id);
            }
            if (this.children.length>0) {
                procesarHijos(this.children);
            }
        });
        return permisos;
    };

    return modulo;
})($formPerfil || {});

$(function() {
    $('.jq_regresar_perfiles').off('click').on('click', $formPerfil.clickRegresar);
    $('.jq_guardar_perfil').off('click').on('click', $formPerfil.clickGuardar);
});