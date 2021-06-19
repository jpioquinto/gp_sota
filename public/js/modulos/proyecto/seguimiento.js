var $seguimiento = (modulo => {

    modulo.clickNuevaAccion = function(e) {
        e.preventDefault();
        
        obtenerFormAccion();
    };

    modulo.clickEditarAccion = function(e) {
        e.preventDefault();

        obtenerFormAccion($(this).parents('.card').attr('data-id'));
    }

    modulo.clickNuevaAccionParticular = function(e) {
        e.preventDefault();

        obtenerFormAccionParticular($(this).parents('.card').attr('data-id'));
    };

    modulo.clickEditarAccionParticular = function(e) {
        e.preventDefault();

        if ( !$(this).parents('.item-accion-especifica').attr('data-id')) {
            return;
        }
        obtenerFormAccionParticular($(this).parents('.card').attr('data-id'), $(this).parents('.item-accion-especifica').attr('data-id'));
    }

    var obtenerFormAccion = id => {
        var $params = {};
        if (id) {
            $params['id'] = id;
        }
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"obtenerVistaNueva",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-submodulo .content-modal').html(data.vista);
                    $('.content-submodulo .content-modal #jq_modal_accion').modal('show');                    
                }            
            }
        });
    };

    var obtenerFormAccionParticular = (accion_id, id) => {
        if (!accion_id) {
            return;
        }
        var $params = {'accion_id':accion_id};

        if (id) {
            $params['id'] = id;
        }
        
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"obtenerVistaFormSubAccion",
            datos:$params,
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
    $('[data-toggle="tooltip"]').tooltip();
    $('.jq_nueva_accion').off('click').on('click', $seguimiento.clickNuevaAccion);
    $('.btn-editar-accion').off('click').on('click', $seguimiento.clickEditarAccion);
    $('.jq_nueva_accion_particular').off('click').on('click', $seguimiento.clickNuevaAccionParticular);
    $('.btn-editar').off('click').on('click', $seguimiento.clickEditarAccionParticular);
});