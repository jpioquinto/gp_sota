var $evidencia = (modulo => {

    modulo.clickSelecEvidencia = function(e) {
        e.preventDefault();
        $("#listado-doc .card").removeClass('item-seleccionado');

        $(this).find('.card').addClass('item-seleccionado');console.log($(this).find('.card').attr('url'));

        $("#jq_contenedor_archivo").attr("type", $util.obtenerTipoMIME($(this).find('.card').attr('extension')));
        $("#jq_contenedor_archivo").attr("src", $(this).find('.card').attr('url') + "?hash=" + $util.hash(10));
    };

    return modulo;
})($evidencia || {});
$(function() {
    $("#listado-doc .jq_evidencia").off('click').on('click', $evidencia.clickSelecEvidencia);
});