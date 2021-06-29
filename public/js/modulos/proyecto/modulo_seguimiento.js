var $modSeguimiento = (modulo=>{
    modulo.me = {};

    modulo.ini = () => {
        var $tabla = $('#jq_listado_acciones');
        //var $tbody = $tabla.find('tbody').html();
        $tabla.bootstrapTable('destroy').bootstrapTable({
            pagination: true,
            locale:'es-MX',
            search: true,            
        });
        
        $('#jq_listado_acciones').find('[data-toggle="tooltip"]').tooltip();
        modulo.eventosTabla();
    };

    modulo.eventosTabla = () => {
        $('#jq_listado_acciones .jq_actualiza_avance').off('click').on('click', modulo.clickEditarAvance);
        $('#jq_listado_acciones .jq_carga_docs').off('click').on('click', modulo.clickCargarEvidencia);
    };

    modulo.clickCargarEvidencia = function(e) {
        e.preventDefault();
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"vistaCargarDocs",
            datos:{multiple:true},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_carga').modal('show');
                }            
            }
        });
    };

    modulo.clickEditarAvance = function(e) {
        e.preventDefault();
        modulo.me = $(this);
        swal({
            title: 'Ingrese el avance',
            html: '<br><input type="number" class="form-control" id="input-avance">',
            content: {
                element: "input",
                attributes: {                    
                    type: "number",
                    id: "input-avance",
                    className: "form-control"
                },
            },
            buttons: {
                cancel: {
                    visible: true,
                    className: 'btn btn-danger',
                    text:'Cancelar'
                },        			
                confirm: {
                    className : 'btn btn-success',
                    text:'Aceptar'
                }
            },
        }).then(editarAvance);

        $("#input-avance").val($.trim($(this).parents('tr').find('td[data-avance="true"').text()));
    };

    var editarAvance = dato => {
        if (!dato || !modulo.me.parents('tr').attr('id')) {
            return;
        }
        if (!esNumerico(dato)) {
            notificacion('ingrese una cantidad numérica.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("#input-avance").val(null).focus();
			return;
        }
        var $params = {id:modulo.me.parents('tr').attr('id'), avance:dato};
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"actualizarAvance",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.parents('tr').find('td[data-avance="true"').text(parseFloat($params.avance).toFixed(2));
                }            
            }
        });
    };

    return modulo;
})($modSeguimiento || {});

$(function() {
    $modSeguimiento.ini();    
});