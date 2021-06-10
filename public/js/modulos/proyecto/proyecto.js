var $proyecto = (modulo => {
    var id;


    modulo.clickVerProyecto = function(e) {
        e.preventDefault();
        if (!$(this).attr('id')) {
            return;
        }
        id = $(this).attr('id');
        var $params = {id:id};
        //$util.load.show(true);
        $util.post({
            url: "Proyecto",
            metodo:"verModulo",
            datos:$params,
            funcion: function(data) {
                if (data.Solicitud) {
                    $('.content-listado-proyectos').hide('animate__fadeOut');

                    $('.content-modulo').html('');
                    $('.content-modulo').html(data.vista);
                    
                    $('.content-modulo').removeClass('d-none animate__fadeOut').addClass('animate__fadeInUp');  
                }
                //$util.load.hide();
            }
        });        
    };

    modulo.getId = function() {
        return id;
    };

    return modulo;
})($proyecto || {});
$(function() {
    $('.jq_ver_proyecto').off('click').on('click', $proyecto.clickVerProyecto);
});