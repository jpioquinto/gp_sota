var $evidencia = (modulo => {

    modulo.clickSelecEvidencia = function(e) {
        e.preventDefault();
        $("#listado-doc .card").removeClass('item-seleccionado');

        $(this).find('.card').addClass('item-seleccionado');console.log($(this).find('.card').attr('url'));

        $("#jq_contenedor_archivo").attr("type", $util.obtenerTipoMIME($(this).find('.card').attr('extension')));
        $("#jq_contenedor_archivo").attr("src", $(this).find('.card').attr('url') + "?hash=" + $util.hash(10));
    };

    modulo.clickValidarAvance = function(e) {
        e.preventDefault();

        if (!$(this).attr('data-id')) {
            notificacion('No se encontró el Identificador del Reporte de Avance.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            return;
        }
        var me = $(this);
        var $params = {id:$(this).attr('data-id'), accionId:$(this).attr('accion-id')};
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"validarAvance",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    me.remove();
                    $modSeguimiento.me.parents('tr').find('td[data-avance="true"] span').removeClass('badge-danger').addClass('badge-light');
                }            
            }
        });
    };

    return modulo;
})($evidencia || {});
$(function() {
    $("#listado-doc .jq_evidencia").off('click').on('click', $evidencia.clickSelecEvidencia);
    $("#listado-doc .jq_validar").off('click').on('click', $evidencia.clickValidarAvance);

    $("#listado-doc .jq_evidencia .card:first").addClass('item-seleccionado');
});