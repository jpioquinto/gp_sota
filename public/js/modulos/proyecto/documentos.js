var $docs = (modulo => {
    
    modulo.me = {};

    modulo.clickSubirArchivo = function(e) {
        e.preventDefault();

        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"vistaModalCarga",
            datos:{id:$proyecto.getId()},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_form').modal('show');
                    $('#data-tipo_doc').off('change').on('change', modulo.selectTipoDoc);
                }            
            }
        });
    };

    modulo.selectTipoDoc = function(e) {
        e.preventDefault();

        if (!esEnteroPositivo($('#data-tipo_doc option:selected').val())) {
            return;
        }

        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"vistaFormulario",
            datos:{form:$('#data-tipo_doc option:selected').text()},
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
    

    return modulo;
})($docs || {});

$(function() {
    $('.jq_subir').off('click').on('click', $docs.clickSubirArchivo);    
});