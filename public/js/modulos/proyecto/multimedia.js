var $media = (modulo => {

    modulo.me = {};
    
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
        
        modulo.me = $(this); 

        var $params = clone(config[modulo.me.attr('data-media')]);
        $params['paginacion'] = config.paginacion;

        if ($params.hasOwnProperty('busqueda')) {
            delete $params.busqueda;
        }
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.me.attr('data-media'), proyectoId:$proyecto.getId()}) );       
    };

    modulo.clickVerMasMedia = function(e) {
        e.preventDefault();
        
        var $params = clone(config[modulo.me.attr('data-media')]);
        $params['paginacion'] = config.paginacion;

        if ($params.hasOwnProperty('busqueda')) {
            delete $params.busqueda;
        }
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.me.attr('data-media'), proyectoId:$proyecto.getId()}) );  
    };

    modulo.clickBuscar = function(e) {
        e.preventDefault();

        if ($.trim($("input[name='entrada']").val())=='') {
            return;
        }

        var $params = clone(config[modulo.me.attr('data-media')].busqueda);
        $params['paginacion'] = config.paginacion;
        $params.entrada = $.trim($("input[name='entrada']").val());
        
        modulo.obtenerMultimedia( Object.assign($params,{media:modulo.me.attr('data-media'), proyectoId:$proyecto.getId()}) );
    };

    modulo.capturaBusqueda = function(e) {
        e.preventDefault();

        if (e.which == 13) {
			$(".jq_buscar").trigger('click');
		}
    };

    modulo.obtenerMultimedia = ($params) => {        
        $util.load.show(true);
        $util.post({
            url: "Multimedia",
            metodo:"obtenerMultimedia",
            datos:$params,
            funcion: function(data) {   
                modulo.me.tab('show');             
                if (data.Solicitud) {                                    
                    modulo.inicializaContenido(modulo.me.attr('data-media'), data, $params.hasOwnProperty('entrada') ? $params.entrada : undefined);
                    modulo.me.attr('data-media')=='foto' ? eventosImagenes() : eventosVideos();
                    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
                }                
                $util.load.hide();          
            }
        });
    };

    modulo.inicializaContenido = (media, data, busqueda) => {
        data.info.pagina==1 ? $(modulo.me.attr('href')).html(data.vista) : $(modulo.me.attr('href') + ' .content-media').append(data.vista);

        if (busqueda) {
            config[media].busqueda.ini = true;
            config[media].busqueda.pagina = parseInt(data.info.pagina);
            config[media].busqueda.total  = parseInt(data.info.total);
        } else {
            config[media].ini = true;
            config[media].pagina = parseInt(data.info.pagina);
            config[media].total  = parseInt(data.info.total);
        }

        $('.jq_mas_media').off('click').on('click', modulo.clickVerMasMedia);
    };

    var eventosImagenes = () => {
        $('.tab-content .jq_imagen').off('click').on('click', modulo.clickVerMedia);
    };

    var eventosVideos = () => {
        $('.tab-content .jq_video').off('click').on('click', modulo.clickVerMedia);
    };

    var config = {
        paginacion:2,
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

    $('#v-pills-tab-with-icon a:first').trigger('click');
    $('.tab-content').find('[data-toggle="tooltip"]').tooltip();
});