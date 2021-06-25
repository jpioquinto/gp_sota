var $gestion = (modulo => {
    var cargados = {};

    modulo.me = {};

    modulo.controlador = '';

    modulo.claseSalida = 'animate__backOutLeft animate__delay-5s';
    modulo.claseEntrada = 'animate__fadeInDown animate__delay-5s';

    modulo.clickCargarModulo = function(e) {
        e.preventDefault();
        
        if (!$(this).attr('data-control') || $.trim($(this).attr('data-control'))=='') {
            console.log('sin controlador');return;
        }

        modulo.controlador = $(this).attr('data-control');
        var $params = {id:$proyecto.getId()};
        modulo.me = $(this);
        $util.load.show(true);
        $util.post({
            controlador:modulo.controlador,
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-modulos').addClass(modulo.claseSalida).hide('slow');
                    $('.content-submodulo').html('');
                    $('.content-submodulo').html(data.vista); 
                    $('.content-submodulo').removeClass('d-none').addClass(modulo.claseEntrada);
                    
                    data.hasOwnProperty('header') ? modulo.setHeader(data.header) : '';
                    //modulo.me.hasClass('jq_accion') ? modulo.me.parents('.ml-md-auto').addClass('d-none') : '';
                    //modulo.me.parents('.jq_content_modulo').find('.card-header:first .ml-md-auto').addClass('d-none');
                    
                    $('.jq_regresar_submodulo').off('click').on('click',  $gestion.regresar);
                }                
            }
        });         
    };

    modulo.eventosSeguimiento = () => {

    };

    modulo.regresar = function(e) {
        e.preventDefault();
        $('.content-modulo .jq_header_submodulo').removeClass('d-flex').addClass('d-none');
        $('.content-modulo .jq_header_submodulo').html(null);
        $('.content-modulo .jq_header_proyecto').removeClass('d-none').addClass('d-flex');

        $('.content-modulos').removeClass(modulo.claseSalida).addClass(modulo.claseEntrada).show('slow');
        $('.content-submodulo').html(null);        
        $('.content-submodulo').removeClass(modulo.claseEntrada).addClass('d-none');

        //modulo.me.hasClass('jq_accion') ? modulo.me.parents('.ml-md-auto').removeClass('d-none') : '';
        modulo.me.parents('.jq_content_modulo').find('.card-header:first .ml-md-auto').removeClass('d-none');
    };

    modulo.setHeader = vista => {
        $('.content-modulo .jq_header_proyecto').removeClass('d-flex').addClass('d-none');
        $('.content-modulo .jq_header_submodulo').html(vista);
        $('.content-modulo .jq_header_submodulo').removeClass('d-none').addClass('d-flex');        
    };
    return modulo;
})($gestion || {});

$(function() {
    $('.content-modulos .jq_submodulo, .content-modulo .jq_accion').off('click').on('click', $gestion.clickCargarModulo);    
});