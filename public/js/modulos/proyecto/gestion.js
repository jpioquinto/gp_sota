var $gestion = (modulo => {
    var cargados = {};

    modulo.clickCargarModulo = function(e) {
        e.preventDefault();
        if (!$(this).attr('data-control')) {
            console.log('sin controlador');return;
        }
        console.log($(this).attr('data-control'));
        
    }
    return modulo;
})($gestion || {});

$(function() {
    $('#modulos-proyecto a').off('click').on('click', $gestion.clickCargarModulo);
});