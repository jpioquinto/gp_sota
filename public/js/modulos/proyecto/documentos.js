var $docs = (modulo => {
    
    modulo.me = {};

    modulo.claseSalida = 'animate__fadeOut animate__delay-5s';
    modulo.claseEntrada = 'animate__fadeInUp animate__delay-5s';

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

    modulo.selectFicha = function(e) {
        e.preventDefault();

        var $params = $.trim($("input[name='entrada']").val())!='' ? clone(config.busqueda) : clone(config);
        
        $params.ini = false;
        $params.total = 0;
        $params.pagina = 0;
        
        if (!$params.hasOwnProperty('paginacion')) {
            $params['paginacion'] = config.paginacion;
        }

        if ($.trim($("input[name='entrada']").val())!='') {            
            $params['entrada'] = $.trim($("input[name='entrada']").val());
        }

        
        modulo.obtenerDocumentos( Object.assign($params,{proyectoId:$proyecto.getId(), tipo:$("select[name='ficha'] option:selected").text()}) );
        
    };

    modulo.capturaBusqueda = function(e) {
        e.preventDefault();

        if (e.which == 13) {
			$(".jq_buscar").trigger('click');
		}
    };

    modulo.clickBuscar = function(e) {
        e.preventDefault();

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

    modulo.clickVerMasDocumentos = function(e) {
        e.preventDefault();

        if ($.trim($("input[name='entrada']").val()) != '') {
            $('.jq_buscar').trigger('click');
            return;
        }

        var $params = clone(config);
        $params['paginacion'] = config.paginacion;

        if ($params.hasOwnProperty('busqueda')) {
            delete $params.busqueda;
        }
        
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
                    iniEventos();
                }                
                $util.load.hide();          
            }
        });
    };

    modulo.inicializaContenido = (data, busqueda) => {
        var contenido = (busqueda && !config.busqueda.ini)  ? $(".content-documentos").html() : undefined;

        data.info.pagina==1 ? $('.content-documentos').html(data.vista) : $('.content-documentos .listado-documentos').append(data.vista);

        if (busqueda) {
            config.busqueda.ini = true;
            config.busqueda.pagina = parseInt(data.info.pagina);
            config.busqueda.total  = parseInt(data.info.total);
            config.busqueda.entrada  = data.info.entrada;
            contenido ? config.vista = contenido : undefined;   
            ocultarMasContent(config.busqueda.total, (config.busqueda.pagina*config.paginacion));         
        } else {
            config.ini = true;
            config.pagina = parseInt(data.info.pagina);
            config.total  = parseInt(data.info.total);
            config.vista  = '';
            ocultarMasContent(config.total, (config.pagina*config.paginacion)); 
        }

        $('.jq_mas_docs').off('click').on('click', modulo.clickVerMasDocumentos);
    };

    modulo.clickVerFicha = function(e) {
        e.preventDefault();        
        $(".ficha[data-id='" + $(this).parents('.item-doc').attr('data-id') + "']").removeClass(modulo.claseSalida).addClass(modulo.claseEntrada).show('slow');  
    };

    modulo.clickOcultarFicha = function(e) {
        e.preventDefault();

        $(this).parents('.ficha').removeClass(modulo.claseEntrada).addClass(modulo.claseSalida).hide('slow');
    };

    modulo.clickVerDoc = function(e) {
        e.preventDefault();

        if ($.inArray($(this).attr('extension'),['pdf'])==-1) {
            $('.ver-doc').attr('href', $(this).attr('uri'));
            $('.ver-doc').trigger('click');
            return;
        }

        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"vistaVerDoc",
            datos:{uri:$(this).attr('uri'), mime:$util.obtenerTipoMIME($(this).attr('extension')), nombre:$(this).attr('nombre')},
            funcion: function(data) {   
                $util.load.hide();                              
                if (data.Solicitud) { 
                    $('.content-modal').html(data.vista); 
                    $('#jq_modal_docs').modal('show');                                                             
                }                                         
            }
        });

    };

    modulo.clickEditarFicha = function(e) {
        e.preventDefault();

        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"vistaModalEditar",
            datos:{proyectoId:$proyecto.getId(), id:modulo.me.parents('.content-acciones').attr('data-id'), form:modulo.me.parents('.content-acciones').attr('data-seccion')},
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

    modulo.clickEliminarFicha = function(e) {
        e.preventDefault();
        
        if (!$(this).parents('.content-acciones').attr('data-id')) {
            return;
        }

        modulo.me = $(this);
        swal({
            title: '¿Estás seguro(a)?',
            text: "Se eliminará el archivo físicamente del servidor.",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Aceptar',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Aceptar) => {
            if (Aceptar) {
                eliminar();
            } else {
                swal.close();
            }
        });
    };

    modulo.actualizarContenidoFicha = (data, $params) => {
        var contenedor = modulo.me.parents(".d-flex[data-id='"+ modulo.me.parents('.content-acciones').attr('data-id') +"']").next('.ficha');
        
        contenedor.find('.alert .detalle-ficha').remove();
        contenedor.find('.alert').append(data.detalle);

        contenedor.find('.alias-doc').html($params.alias);
        contenedor.find('.descripcion-doc').html($params.descripcion);

        $(".item-doc[data-id='"+ modulo.me.parents('.content-acciones').attr('data-id') +"']").find('.alias-doc').html($params.alias);
        $(".item-doc[data-id='"+ modulo.me.parents('.content-acciones').attr('data-id') +"']").find('.descripcion-doc').html($params.descripcion);
    };

    var eliminar = () => {
        var $params = {proyectoId:$proyecto.getId(), id:modulo.me.parents('.content-acciones').attr('data-id'), form:modulo.me.parents('.content-acciones').attr('data-seccion')};
        $util.load.show(true); 
        $util.post({
            url: "Documento",
            metodo:"eliminarFicha",
            datos:$params,
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    $(".ficha[data-id='" + $params.id + "']").next('.separator-dashed').remove();
                    $("div[data-id='" + $params.id + "']").remove();                    
                    $('.close').trigger('click');
                }            
            }
        }); 
    };


    var iniEventos = () => {
        $('.avatar, .descripcion-doc').off('click').on('click', modulo.clickVerFicha);        
        $('.jq_ocultar').off('click').on('click', modulo.clickOcultarFicha);
        $('.jq_ver_doc').off('click').on('click', modulo.clickVerDoc);

        $('.jq_editar_ficha').off('click').on('click', modulo.clickEditarFicha);
        $('.jq_eliminar_doc').off('click').on('click', modulo.clickEliminarFicha);

        $('.content-documentos').find('[data-toggle="tooltip"]').tooltip(); 
    };

    var ocultarMasContent = (total, items) => {
        if ($('.mas-content').length==0) {
            return;
        }

        if (items>=total) {
            $('.mas-content').addClass('d-none');
        }
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
    $("select[name='ficha']").off('change').on('change', $docs.selectFicha);
    $("input[name='entrada']").off("keyup").on("keyup", $docs.capturaBusqueda);
    $("select[name='ficha']").trigger('change');
});