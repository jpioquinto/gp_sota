var $seguimiento = (modulo => {

    modulo.clickNuevaAccion = function(e) {
        e.preventDefault();
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"obtenerVistaNueva",
            datos:{},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-submodulo .content-modal').html(data.vista);
                    $('.content-submodulo .content-modal #jq_modal_accion').modal('show');                    
                }            
            }
        });
    };

    modulo.clickNuevaAccionParticular = function(e) {
        e.preventDefault();
        if (!$(this).parents('.card').attr('data-id')) {
            return;
        }
        
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"obtenerVistaFormSubAccion",
            datos:{accion_id:$(this).parents('.card').attr('data-id')},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-submodulo .content-modal').html(data.vista);
                    $('.content-submodulo .content-modal #jq_modal_accion').modal('show');                    
                }            
            }
        });
    };

    return modulo;
})($seguimiento || {}); 

$(function() {
    $('.jq_nueva_accion').off('click').on('click', $seguimiento.clickNuevaAccion);
    $('.jq_nueva_accion_particular').off('click').on('click', $seguimiento.clickNuevaAccionParticular);
});