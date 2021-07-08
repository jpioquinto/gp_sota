var $media = (modulo => {

    modulo.me = {};
    
    modulo.clickSubirMedia = function(e) {
        e.preventDefault();

        if (!$('.nav-link.active').attr('data-media')) {
            return;
        }
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"vistaFormulario",
            datos:{media:$('.nav-link.active').attr('data-media')},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_form').modal('show');
                }            
            }
        });
    };

    modulo.clickVerMedia = function(e) {
        e.preventDefault();

        if (!$(this).attr('data-id')) {
            return;
        }
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo: "vistaVerMedia",
            datos:{id:modulo.me.attr('data-id'), proyectoId:$proyecto.getId(), media:$('.nav-link.active').attr('data-media')},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_show_media').modal('show');
                }            
            }
        });
    };

    modulo.clickVerContenido = function(e) {
        e.preventDefault();
        
        var me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"obtenerMultimedia",
            datos:{media:me.attr('data-media'), proyectoId:$proyecto.getId()},
            funcion: function(data) {   
                me.tab('show');             
                if (data.Solicitud) {                
                    $(me.attr('href')).html(data.vista);
                    me.attr('data-media')=='foto' ? eventosImagenes() : eventosVideos();
                    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
                }                
                $util.load.hide();          
            }
        });
    };

    var eventosImagenes = () => {
        $('.tab-content .jq_imagen').off('click').on('click', modulo.clickVerMedia);
    };

    var eventosVideos = () => {
        $('.tab-content .jq_video').off('click').on('click', modulo.clickVerMedia);
    };


    return modulo;
})($media || {});

$(function() {
    $('#v-pills-tab-with-icon a').off('click').on('click', $media.clickVerContenido);    
    $('.jq_subir').off('click').on('click', $media.clickSubirMedia);

    $('#v-pills-tab-with-icon a:first').trigger('click');
    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
});