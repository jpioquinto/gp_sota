var $avance = (modulo => {

    modulo.avance = undefined;

    modulo.verificarCaptura = function(e) {
        e.preventDefault();
        $('#jq_aceptar_avance').prop('disabled', !esNumerico($(this).val()));
    };

    modulo.clickGuardar = function(e) {
        e.preventDefault();

        if (!esNumerico($('#data-avance').val())) {
            notificacion('ingrese una cantidad numérica.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("#data-avance").val(null).focus();
			return;
        }

        if (parseFloat($('#data-avance').val())<0 || parseFloat($('#data-avance').val())>100) {
            notificacion('La cantidad deberá estar comprendida entre 0 y 100', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("#data-avance").val(null).focus();
            return;
        }
    
        /*$modSeguimiento.avance = $('#data-avance').val();
        
        if ($("input[name='archivo']").length>0) {
            $('#jq_aceptar_carga').trigger('click');
        }*/
        editarAvance($('#data-avance').val(), ($("input[name='archivo']").length>0));
    };

    var editarAvance = (dato, carga) => {
        var $params = {id:$modSeguimiento.me.parents('tr').attr('id'), avance:dato};
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"actualizarAvance",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $modSeguimiento.bloque = data.reporte;
                    $modSeguimiento.me.parents('tr').find('td[data-avance="true"').text(parseFloat($params.avance).toFixed(2));
                    carga ? $('#jq_aceptar_carga').trigger('click') : $('#jq_modal_carga').modal('hide');
                }            
            }
        });
    };

    return modulo;
})($avance || {});

$(function() {
    $('#data-avance').focus();
    $('#data-avance').off('change').on('change', $avance.verificarCaptura);
    $('#jq_aceptar_avance').off('click').on('click', $avance.clickGuardar);
});