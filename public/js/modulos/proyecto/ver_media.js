var $verMedia = (modulo => {

    modulo.me = {};

    modulo.cerrarModal = function(e) {
        e.preventDefault();

        $("#jq_modal_show_media").modal('hide');

        setTimeout(()=> {$('.content-modal').html(null)}, 600) ;        
    };

    modulo.eliminarMedia = function(e) {
        e.preventDefault();

        if (!$('.nav-link.active').attr('data-media')) {
            return;
        }
        swal({
            title: '¿Estás seguro?',
            text: "Se eliminará el archivo físicamente del servidor.",
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
                eliminar();
            } else {
                swal.close();
            }
        });

        modulo.me = $(this);              
    };

    var eliminar = () => {
        $util.load.show(true); 
        $util.post({
            url: "Multimedia",
            metodo:"eliminarMedia",
            datos:{media:$('.nav-link.active').attr('data-media'), id:$media.me.attr('data-id')},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    $media.me.parents('.item-' + $media.meTab.attr('data-media')).length>0
                    ? $media.me.parents('.item-' + $media.meTab.attr('data-media')).remove() : null;
                    $('.close').trigger('click');
                }            
            }
        }); 
    };

    return modulo;
})($verMedia || {});

$(function() {
    $('.close').off('click').on('click', $verMedia.cerrarModal);
    $('.jq_eliminar_imagen, .jq_eliminar_video').off('click').on('click', $verMedia.eliminarMedia);
});