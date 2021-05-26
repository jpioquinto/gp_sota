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
                    $('#jq_guardar_perfil').off('click').on('click', modulo.cambiarPerfil);                  
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

    modulo.clickCambiarOrganizacion = function(e) {
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
            metodo:"obtenerVistaCambiarOrganizacion",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);                                       
                    $dependencia.ini(data.opciones, data.organizacion, $params.id);
                    $('#jq_modal_nuevaorg').modal('show');                 
                }            
            }
        });
    };

    modulo.clickCambiarPassword = function(e) {
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
            metodo:"obtenerVistaCambio",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);                                                           
                    $('#jq_nuevo_pass').modal('show'); 
                    $uPass.ini($params.id);                
                }            
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
                    $el.parents('tr').find("td[data-perfil='true']").html( $.trim($("select[name='perfil'] option:selected").text()) );
                    $('#jq_modal_nuevoperfil').modal('hide');
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

                    data.estatus==1 
                    ? $el.parents('tr').find('td .badge').removeClass('badge-warning').addClass('badge-dark')
                    : $el.parents('tr').find('td .badge').removeClass('badge-dark').addClass('badge-warning');

                    data.estatus==1 
                    ? $el.find('.fa').removeClass('fa-check-circle').addClass('fa-minus-circle')
                    : $el.find('.fa').removeClass('fa-minus-circle').addClass('fa-check-circle');
                    
                    data.estatus==1 
                    ? $el.attr('data-original-title', 'Inhabilitar usuario') : $el.attr('data-original-title', 'Habilitar usuario');
                }            
            }
        });
    };

    modulo.eventoAcciones = () => {
        $('.jq_cambiar_perfil').off('click').on('click', modulo.clickCambiarPerfil);
        $('.jq_switch_estatus').off('click').on('click', modulo.clickCambiarEstatus);
        $('.jq_cambiar_org').off('click').on('click', modulo.clickCambiarOrganizacion);
        $('.jq_cambiar_pass').off('click').on('click', modulo.clickCambiarPassword);
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