var $verMedia = (modulo => {

    modulo.cerrarModal = function(e) {
        e.preventDefault();

        $("#jq_modal_show_media").modal('hide');

        setTimeout(()=> {$('.content-modal').html(null)}, 600) ;        
    };

    return modulo;
})($verMedia || {});

$(function() {
    $('.close').off('click').on('click', $verMedia.cerrarModal);
});