var $gestion = (modulo => {
    var cargados = {};

    modulo.clickCargarModulo = function(e) {
        e.preventDefault();
        if (!$(this).attr('data-control')) {
            console.log('sin controlador');return;
        }
        console.log($(this).attr('data-control'));
        var $params = {id:$proyecto.getId()};
        var me = $(this);
        //$util.load.show(true);
        $util.post({
            controlador:$(this).attr('data-control'),
            datos:$params,
            funcion: function(data){
                if (data.Solicitud) {
                    $('#' + me.attr('aria-controls')).html('');
                    $('#' + me.attr('aria-controls')).html(data.vista);                                     
                }
                //$util.load.hide();
            }
        }); 
        
    }
    return modulo;
})($gestion || {});

$(function() {
    $('#modulos-proyecto a').off('click').on('click', $gestion.clickCargarModulo);
});