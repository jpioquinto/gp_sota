var $usuario = (modulo=>{
    var $el = {};
    modulo.clickCambiarPerfil = function(e) {
        e.preventDefault();
        if ($(this).parents('tr').attr('data-id').length==0) {
            return;
        }
        var $params = {
            id:$(this).parents('tr').attr('data-id')
        };
        $el = $(this);
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"obtenerVistaCambiarPerfil",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_nuevoperfil').modal('show');                    
                }            
            }
        });
    };

    modulo.clickCambiarEstatus = function(e) {
        e.preventDefault();
        if ($(this).parents('tr').find("td[data-estatus]").length==0) {
            return;
        }
        $el = $(this);
        var estatus = parseInt($(this).parents('tr').find("td[data-estatus]").attr('data-estatus'));
        swal({
            title: '¿Estás seguro?',
            text: estatus==1 ? "Se desactivará el usuario y no podrá acceder al sistema." : "Se activará el usuario.",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Aceptar',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Aceptar) => {
            if (Aceptar) {
                modulo.cambiarEstatus(estatus);
            } else {
                swal.close();
            }
        });
    };

    modulo.clickAgregar = function(e) {
        e.preventDefault();
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"obtenerVistaNuevo",
            datos:{},
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_usuario').modal('show');
                    $('#jq_cambiar_perfil').off('click').on('click', modulo.cambiarPerfil);
                }            
            }
        });
    };

    modulo.cambiarPerfil = function(e) {
        e.preventDefault();
        if ($el.parents('tr').attr('data-id').length==0) {
            return;
        }
        if ( !esEntero($("select[name='perfil'] option:selected").val()) || parseInt($("select[name='perfil'] option:selected").val())<=0 ) {
            notificacion('Seleccione el perfil.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='perfil']").focus();
			return;
		}
        var $params = {
            perfil:$("select[name='perfil'] option:selected").val(),
            id:$el.parents('tr').attr('data-id')
        };
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"cambiarPerfil",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                   
                }            
            }
        });
    };

    modulo.cambiarEstatus = function(estatus) {
        if ($el.parents('tr').attr('data-id').length==0) {
            return;
        }
        var $params = {
            id:$el.parents('tr').attr('data-id'),
            estatus:estatus
        };
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"cambiarEstatus",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $el.parents('tr').find("td[data-estatus]").attr('data-estatus', data.estatus);
                    estatus==1 
                    ? $el.parents('tr').find("td[data-estatus]").find('badge').removeClass('badge-warning').addClass('badge-dark')
                    : $el.parents('tr').find("td[data-estatus]").find('badge').removeClass('badge-dark').addClass('badge-warning');
                }            
            }
        });
    };

    modulo.eventoAcciones = function() {
        $('.jq_cambiar_perfil').off('click').on('click', modulo.clickCambiarPerfil);
        $('.jq_switch_estatus').off('click').on('click', modulo.clickCambiarEstatus);
    };

    return modulo;
})($usuario || {}); 

$(function() {
    $('#jq_listado_users').DataTable({
        "pageLength": 50,
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('.jq_nuevo_usuario').off('click').on('click', $usuario.clickAgregar);

    $usuario.eventoAcciones();
});