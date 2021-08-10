var $modSeguimiento = (modulo=>{
    modulo.bloque = undefined;
    modulo.me = {};

    modulo.ini = () => {
        var $tabla = $('#jq_listado_acciones');
        //var $tbody = $tabla.find('tbody').html();
        $tabla.bootstrapTable('destroy').bootstrapTable({
            pagination: true,     
            locale:'es-MX',                                   
            paginationParts:[
                'pageInfo', 'pageSize','pageList'
            ],
            onColumnSwitch:function(field,checked) {
                setTimeout(modulo.eventosTabla, 3500);
            }       
        });
        
        $('#jq_listado_acciones').find('[data-toggle="tooltip"]').tooltip();        
        modulo.eventosTabla();
        $(".jq_subir_archivos").off("click").on("click", modulo.subirArchivos);
    };

    modulo.eventosTabla = () => {
        $('#jq_listado_acciones .jq_actualiza_avance').off('click').on('click', modulo.clickEditarAvance);
        $('#jq_listado_acciones .jq_carga_docs').off('click').on('click', modulo.clickCargarEvidencia);
        $('#jq_listado_acciones .jq_ver_docs').off('click').on('click', modulo.clickVerEvidencia);
    };

    /*modulo.clickCargarEvidencia = function(e) {
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
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_carga').modal('show');
                }            
            }
        });
    };*/

    modulo.clickVerEvidencia = function(e) {
        e.preventDefault();
        if (!$(this).parents('tr').attr('id')) {
            notificacion('No se encontró el Identificador de la Acción Específica.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            return;
        }

        modulo.me = $(this);        
        var $params = {id:modulo.me.parents('tr').attr('id'), proyectoId:$proyecto.getId()};
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"verDocumentos",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_docs').modal('show');
                    $('.listado-docs').find('[data-toggle="tooltip"]').tooltip(); 
                }            
            }
        });
    };

    modulo.clickEditarAvance = function(e) {
        e.preventDefault();
        modulo.bloque = undefined;  
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "AccionParticular",
            metodo:"vistaEditarAvance",
            datos:{multiple:'multiple', evidencia:modulo.me.attr('data-evidencia'), accion_id:modulo.me.parents('tr').attr('id'), avance:$.trim(modulo.me.parents('tr').find('td[data-avance="true"] span').text())},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_carga').modal('show');
                }            
            }
        });
    };

    modulo.subirArchivos = function(e) {
        e.preventDefault();

        if (objArchivos.length<1 || !modulo.me.parents('tr').attr('id')) {
            return;
        }

        var totacargar  = objArchivos.length;
		var totcargados = 0;
		var cont = 0;

        $util.load.show(true);

        $.each(objArchivos, function(index, archivo) {
            var formData = new FormData();
            formData.append("id", modulo.me.parents('tr').attr('id'));
            formData.append("descripcion", archivo.descripcion);
            formData.append("proyectoId", $proyecto.getId());
            formData.append("archivo", archivo.archivo);
            formData.append("bloque", modulo.bloque);
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
                    (totcargados>0) ? notificacion("Se cargaron "+totcargados+" documentos", "success", 4000, "bottomRight", "fadeInUp", "fadeOutDown") : '';
                    $util.load.hide();
                    modulo.me.removeAttr('disabled');
                }
            });
            
        });
    };

    return modulo;
})($modSeguimiento || {});

$(function() {
    $modSeguimiento.ini();    
});