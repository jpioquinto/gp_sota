var $evidencia = (modulo => {

    modulo.clickSelecEvidencia = function(e) {
        e.preventDefault();

        $(".jq_descargar_evidencia").addClass('d-none');
        $("#listado-doc .card").removeClass('item-seleccionado');

        $(this).find('.card').addClass('item-seleccionado');console.log($util.obtenerTipoMIME($(this).find('.card').attr('extension')), $(this).find('.card').attr('extension'));

        let tipo = $.inArray($(this).find('.card').attr('extension'),['pdf','png11','jpeg111','jpg111'])!=-1 
                   ? 'application/pdf' : $util.obtenerTipoMIME($(this).find('.card').attr('extension'));

        $("#jq_contenedor_archivo").attr("type", tipo);
        $("#jq_contenedor_archivo").attr("src", $(this).find('.card').attr('url') + "?hash=" + $util.hash(10));

        if (tipo!='application/pdf') {
            $(".jq_descargar_evidencia").prop({
                href:$(this).find('.card').attr('url') + "?hash=" + $util.hash(10),
                target:'_blank'
            });
            $(".jq_descargar_evidencia").removeClass('d-none');
        }
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