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
                    $('#data-tipo_doc').trigger('change');
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
            datos:{form:$('#data-tipo_doc option:selected').text(), proyectoId:$proyecto.getId()},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-form').html(data.vista);
                    modulo.me.prop('disable', true);
                    $formDoc.ini();
                }            
            }
        });
    };

    modulo.capturaBusqueda = function(e) {
        e.preventDefault();

        if (e.which == 13) {
			$(".jq_buscar").trigger('click');
		}
    };

    modulo.clickBuscar = function(e) {
        e.preventDefault();

        if ($.trim($("input[name='entrada']").val())=='') { 
            //restaurarContent();                       
           // return;
        }

        var $params = clone(config.busqueda);

        if ($.trim($("input[name='entrada']").val())!=$params.entrada) {
            $params.ini = false;
            $params.total = 0;
            $params.pagina = 0;
        }

        $params['paginacion'] = config.paginacion;
        $params.entrada = $.trim($("input[name='entrada']").val());
        
        modulo.obtenerDocumentos( Object.assign($params,{proyectoId:$proyecto.getId(), tipo:$("select[name='ficha'] option:selected").text()}) );
    };

    modulo.obtenerDocumentos = ($params) => {        
        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"obtenerDocumentos",
            datos:$params,
            funcion: function(data) {   
                             
                if (data.Solicitud) {                                             
                    modulo.inicializaContenido(data, $params.hasOwnProperty('entrada') ? $params.entrada : undefined);
                    //iniEventos();
                }                
                $util.load.hide();          
            }
        });
    };

    modulo.inicializaContenido = (data, busqueda) => {
        var contenido = (busqueda && !config.busqueda.ini)  ? $(".content-documentos").html() : undefined;

        data.info.pagina==1 ? $('.content-documentos').html(data.vista) : $('.content-documentos').append(data.vista);

        if (busqueda) {
            config.busqueda.ini = true;
            config.busqueda.pagina = parseInt(data.info.pagina);
            config.busqueda.total  = parseInt(data.info.total);
            config.busqueda.entrada  = data.info.entrada;
            contenido ? config.vista = contenido : undefined;   
            //ocultarMasContent(config.busqueda.total, (config.busqueda.pagina*config.paginacion));         
        } else {
            config.ini = true;
            config.pagina = parseInt(data.info.pagina);
            config.total  = parseInt(data.info.total);
            config.vista  = '';
            //ocultarMasContent(config.total, (config.pagina*config.paginacion)); 
        }

        //$('.jq_mas_media').off('click').on('click', modulo.clickVerMasMedia);
    };
    
    var config = {
        paginacion:100,
        ini:false, vista:'', pagina:0, total:0, 
        busqueda:{ini:false, vista:'', pagina:0, total:0, entrada:''}        
    };

    return modulo;
})($docs || {});

$(function() {
    $('.jq_subir').off('click').on('click', $docs.clickSubirArchivo);    
    $('.jq_buscar').off('click').on('click', $docs.clickBuscar);
    $("input[name='entrada']").off("keyup").on("keyup", $docs.capturaBusqueda);
});