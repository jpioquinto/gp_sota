var $media = (modulo => {

    modulo.me = {};

    modulo.meTab = {};
    
    modulo.clickSubirMedia = function(e) {
        e.preventDefault();

        if (!$('.nav-link.active').attr('data-media')) {
            return;
        }
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"vistaFormulario",
            datos:{media:$('.nav-link.active').attr('data-media')},
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

    modulo.clickVerMedia = function(e) {
        e.preventDefault();

        if (!$(this).attr('data-id')) {
            return;
        }
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo: "vistaVerMedia",
            datos:{id:modulo.me.attr('data-id'), proyectoId:$proyecto.getId(), media:$('.nav-link.active').attr('data-media')},
            funcion: function(data) {
                $util.load.hide();
                if (data.Solicitud) {
                    modulo.me.prop('disable', true);
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_show_media').modal('show');
                }            
            }
        });
    };

    modulo.clickVerContenido = function(e) {
        e.preventDefault();
        
        modulo.meTab = $(this); 

        var $params = clone(config[modulo.meTab.attr('data-media')]);
        $params['paginacion'] = config.paginacion;

        if ($params.hasOwnProperty('busqueda')) {
            delete $params.busqueda;
        }
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.meTab.attr('data-media'), proyectoId:$proyecto.getId()}) );       
    };

    modulo.clickVerMasMedia = function(e) {
        e.preventDefault();
        
        if ($.trim($("input[name='entrada']").val()) != '') {
            $('.jq_buscar').trigger('click');
            return;
        }

        var $params = clone(config[modulo.meTab.attr('data-media')]);
        $params['paginacion'] = config.paginacion;

        if ($params.hasOwnProperty('busqueda')) {
            delete $params.busqueda;
        }
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.meTab.attr('data-media'), proyectoId:$proyecto.getId()}) );  
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
            restaurarContent();                       
            return;
        }

        var $params = clone(config[modulo.meTab.attr('data-media')].busqueda);

        if ($.trim($("input[name='entrada']").val())!=$params.entrada) {
            $params.ini = false;
            $params.total = 0;
            $params.pagina = 0;
        }

        $params['paginacion'] = config.paginacion;
        $params.entrada = $.trim($("input[name='entrada']").val());
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.meTab.attr('data-media'), proyectoId:$proyecto.getId()}) );
    };

    modulo.obtenerMultimedia = ($params) => {        
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"obtenerMultimedia",
            datos:$params,
            funcion: function(data) {   
                modulo.meTab.tab('show');             
                if (data.Solicitud) {                                             
                    modulo.inicializaContenido(modulo.meTab.attr('data-media'), data, $params.hasOwnProperty('entrada') ? $params.entrada : undefined);
                    iniEventos();
                }                
                $util.load.hide();          
            }
        });
    };

    modulo.inicializaContenido = (media, data, busqueda) => {
        var contenido = (busqueda && !config[media].busqueda.ini)  ? $(modulo.meTab.attr('href')).html() : undefined;

        data.info.pagina==1 ? $(modulo.meTab.attr('href')).html(data.vista) : $(modulo.meTab.attr('href') + ' .content-media').append(data.vista);

        if (busqueda) {
            config[media].busqueda.ini = true;
            config[media].busqueda.pagina = parseInt(data.info.pagina);
            config[media].busqueda.total  = parseInt(data.info.total);
            config[media].busqueda.entrada  = data.info.entrada;
            contenido ? config[media].vista = contenido : undefined;   
            ocultarMasContent(config[media].busqueda.total, (config[media].busqueda.pagina*config.paginacion));         
        } else {
            config[media].ini = true;
            config[media].pagina = parseInt(data.info.pagina);
            config[media].total  = parseInt(data.info.total);
            config[media].vista  = '';
            ocultarMasContent(config[media].total, (config[media].pagina*config.paginacion)); 
        }

        $('.jq_mas_media').off('click').on('click', modulo.clickVerMasMedia);
    };

    modulo.agregarItemMedia = vista => {
        if (config.paginacion==$(modulo.meTab.attr('href') + ' .content-media').length) {
            return;
        }
        $(modulo.meTab.attr('href') + ' .content-media').append(vista);
        iniEventos();
    };

    modulo.getConfig = () => config;

    var ocultarMasContent = (total, items) => {
        if ($(modulo.meTab.attr('href') + ' .mas-content').length==0) {
            return;
        }

        if (items>=total) {
            $(modulo.meTab.attr('href') + ' .mas-content').addClass('d-none');
        }
    };

    var restaurarContent = () => {
        if (config[modulo.meTab.attr('data-media')].vista=='') {
            return;
        }

        $(modulo.meTab.attr('href')).html(config[modulo.meTab.attr('data-media')].vista);

        setTimeout(()=>{config[modulo.meTab.attr('data-media')].vista = '';}, 3750);

        iniEventos();
        $('.jq_mas_media').off('click').on('click', modulo.clickVerMasMedia);
    };

    var iniEventos = () => {
        modulo.meTab.attr('data-media')=='foto' ? eventosImagenes() : eventosVideos();
        $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
    };

    var eventosImagenes = () => {
        $('.tab-content .jq_imagen').off('click').on('click', modulo.clickVerMedia);
    };

    var eventosVideos = () => {
        $('.tab-content .jq_video').off('click').on('click', modulo.clickVerMedia);
    };

    var config = {
        paginacion:50,
        foto:{ini:false, vista:'', pagina:0, total:0, busqueda:{ini:false, vista:'', pagina:0, total:0, entrada:''}},
        video:{ini:false, vista:'', pagina:0, total:0, busqueda:{ini:false, vista:'', pagina:0, total:0, entrada:''}}
    };

    return modulo;
})($media || {});

$(function() {
    $('#v-pills-tab-with-icon a').off('click').on('click', $media.clickVerContenido);    
    $('.jq_subir').off('click').on('click', $media.clickSubirMedia);
    $('.jq_buscar').off('click').on('click', $media.clickBuscar);
    $("input[name='entrada']").off("keyup").on("keyup", $media.capturaBusqueda);
    //$("input[name='entrada']").off("blur").on("blur", $media.terminaBusqueda);

    $('#v-pills-tab-with-icon a:first').trigger('click');
    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
});