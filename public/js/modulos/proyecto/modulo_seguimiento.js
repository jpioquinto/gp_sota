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
        $(".jq_subir_archivos").off("click").on("click", modulo.subirArchivos);
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
            datos:{multiple:'multiple'},
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

    modulo.subirArchivos = function(e) {
        e.preventDefault();

        if (objArchivos.length<1 || !modulo.me.parents('tr').attr('id')) {
            return;
        }

        var totacargar  = objArchivos.length;
		var totcargados = 0;
		var cont = 0;

        var tkn = "csrf_gp_name";
	    var v   = $("input[name='" + tkn + "']").val();

        $util.load.show(true);

        $.each(objArchivos, function(index, archivo) {
            var formData = new FormData();
            formData.append("id", modulo.me.parents('tr').attr('id'));
            formData.append("descripcion", archivo.descripcion);
            formData.append("proyectoId", $proyecto.getId());
            formData.append("archivo", archivo.archivo);
            formData.append(tkn,v);
            $.ajax({
                url:'AccionParticular/cargarArchivo',
                type:"POST",
                data:formData,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                dataType: "json",
                success:function(data) {
                    if (data.Solicitud) {
                        //data.hasOwnProperty('iconoVer') ? modulo.agregarIconoVer(data.iconoVer) : '';
                        //objUtil.notificacion(data.Msg, "success", 4000, "bottomRight", "fadeInUp", "fadeOutDown");
                        totcargados++;
                    }
                }
            }).always(function() {
                cont++;
                if (cont==totacargar) {
                    parametros = {docs:'', proyecto:0, seguimiento:0 };
                    (totcargados>0) ? notificacion("Se cargaron "+totcargados+" documentos", "success", 4000, "bottomRight", "fadeInUp", "fadeOutDown") : '';
                    $util.load.hide();
                    acciones = []; modulo.me.removeAttr('disabled');
                }
            });
            
        });
    }

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