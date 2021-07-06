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
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_form').modal('show');
                }            
            }
        });
    };

    modulo.clickVerImagen = function(e) {
        e.preventDefault();

        if (!$(this).attr('data-id')) {
            return;
        }
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"vistaVerImagen",
            datos:{id:modulo.me.attr('data-id'), proyectoId:$proyecto.getId()},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_show_media').modal('show');
                }            
            }
        });
    };

    return modulo;
})($media || {});

$(function() {
    $('.tab-content .jq_imagen').off('click').on('click', $media.clickVerImagen);
    $('.jq_subir').off('click').on('click', $media.clickSubirMedia);
    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
});