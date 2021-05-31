var $gPerfil = (modulo=> {
    var $el = {};

    modulo.clickCambiarEstatus = function(e) {
        e.preventDefault();
        if ($(this).parents('tr').find("td[data-estatus]").length==0) {
            return;
        }
        $el = $(this);
        var estatus = parseInt($(this).parents('tr').find("td[data-estatus]").attr('data-estatus'));
        swal({
            title: '¿Estás seguro?',
            text: estatus==1 ? "Se desactivará el perfil y los usuarios que lo tienen asigando pueden tener problemas de accesibilidad." : "Se activará el perfil.",
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

    modulo.clickEditarPerfil = function(e) {
        e.preventDefault();
        if ($(this).parents('tr').attr('data-id').length==0) {
            return;
        }
        $el = $(this);
        var $params = {
            id:$el.parents('tr').attr('data-id')
        };
        mostrarFormulario($params);
    };

    modulo.clickAgregar = function(e) {
        e.preventDefault();
        $el = $(this);
        mostrarFormulario({});
    };

    modulo.cambiarEstatus = estatus => {
        if ($el.parents('tr').attr('data-id').length==0) {
            return;
        }
        var $params = {
            id:$el.parents('tr').attr('data-id'),
            estatus:estatus
        };
        //$util.load.show(true);
        $util.post({
            url: "PerfilUsuario",
            metodo:"cambiarEstatus",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $el.parents('tr').find("td[data-estatus]").attr('data-estatus', data.estatus);

                    data.estatus==1 
                    ? $el.parents('tr').find('td .badge').html('Activo')
                    : $el.parents('tr').find('td .badge').html('Inactivo');

                    data.estatus==1 
                    ? $el.parents('tr').find('td .badge').removeClass('badge-warning').addClass('badge-dark')
                    : $el.parents('tr').find('td .badge').removeClass('badge-dark').addClass('badge-warning');

                    data.estatus==1 
                    ? $el.find('.fa').removeClass('fa-check-circle').addClass('fa-minus-circle')
                    : $el.find('.fa').removeClass('fa-minus-circle').addClass('fa-check-circle');
                    
                    data.estatus==1 
                    ? $el.attr('data-original-title', 'Inhabilitar perfil') : $el.attr('data-original-title', 'Habilitar perfil');
                }            
            }
        });
    };

    modulo.eventoAcciones = () => {
        $('.jq_editar_perfil').off('click').on('click', modulo.clickEditarPerfil);
        $('.jq_switch_estatus').off('click').on('click', modulo.clickCambiarEstatus);
    };

    var mostrarFormulario = $params => {
        //$util.load.show(true);
        $util.post({
            url: "PerfilUsuario",
            metodo:"obtenerVistaFormPerfil",
            datos:$params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-listado-perfiles').hide('animate__backOutLeft');

                    $('.content-modal').html('');
                    $('.content-modal').html(data.vista);
                    $('.content-modal').removeClass('d-none animate__backOutRight').addClass('animate__backInRight');                    
                    $params.hasOwnProperty('id') ? $formPerfil.ini($params.id, $el) : $formPerfil.ini(undefined);
                }            
            }
        });
    }

    return modulo;
})($gPerfil || {});

$(function() {
    $('#jq_listado_perfiles').DataTable({
        "pageLength": 50,
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('.jq_nuevo_perfil').off('click').on('click', $gPerfil.clickAgregar);    

    $gPerfil.eventoAcciones();
});