var $proyecto = (modulo => {

    modulo.clickVerProyecto = function(e) {
        e.preventDefault();
        //$util.load.show(true);
        $util.post({
            url: "Proyecto",
            metodo:"verModulo",
            datos:$params,
            funcion: function(data){
                if (data.Solicitud) {
                
                }
                //$util.load.hide();
            }
        });        
    };

    return modulo;
})($proyecto || {});
$(function() {
    $('.jq_ver_proyecto').off('click').on('click', $proyecto.clickVerProyecto);
});