var $gestion = (modulo => {
    var cargados = {};

    modulo.claseSalida = 'animate__backOutLeft animate__delay-5s';
    modulo.claseEntrada = 'animate__fadeInDown animate__delay-5s';

    modulo.clickCargarModulo = function(e) {
        e.preventDefault();
        if (!$(this).attr('data-control') || $.trim($(this).attr('data-control'))=='') {
            console.log('sin controlador');return;
        }
        console.log($(this).attr('data-control'));
        var $params = {id:$proyecto.getId()};
        var me = $(this);
        $util.load.show(true);
        $util.post({
            controlador:$(this).attr('data-control'),
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-modulos').addClass(modulo.claseSalida).hide('slow');
                    $('.content-submodulo').html('');
                    $('.content-submodulo').html(data.vista); 
                    $('.content-submodulo').removeClass('d-none').addClass(modulo.claseEntrada);                                   
                }                
            }
        }); 
        
    }
    return modulo;
})($gestion || {});

$(function() {
    $('.content-modulos .jq_submodulo, .content-modulo .jq_accion').off('click').on('click', $gestion.clickCargarModulo);
});