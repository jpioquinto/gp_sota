var $seguimiento = (modulo => {

    modulo.clickNuevaAccion = function(e) {
        e.preventDefault();
        
        obtenerFormAccion();
    };

    modulo.clickEditarAccion = function(e) {
        e.preventDefault();

        obtenerFormAccion($(this).parents('.card').attr('data-id'));
    };

    modulo.clickEliminarAccion = function(e) {
        e.preventDefault();
        
        if (!$(this).parents('.card').attr('data-id')) {
            return;
        }
        var me = $(this);
        var $params = {id:$(this).parents('.card').attr('data-id')};
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"eliminarAccionGeneral",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    me.parents(".card[data-id='" + $params.id + "']").remove();                    
                }            
            }
        });

    };

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
    };

    modulo.clickEliminarAccionParticular = function(e) {
        e.preventDefault();
        if ( !$(this).parents('.item-accion-especifica').attr('data-id')) {
            return;
        }
        var me = $(this);
        var $params = {id:$(this).parents('.item-accion-especifica').attr('data-id')};
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"eliminarAccionEspecifica",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    verificaReasignacion(data.reasignado);
                    me.parents("li").remove();                    
                }            
            }
        });
    };

    var verificaReasignacion = resultado => {
        if (resultado) {
            $(".jq_submodulo[data-control='Seguimiento']").trigger('click');
        }
    };

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
    $('.btn-eliminar-accion').off('click').on('click', $seguimiento.clickEliminarAccion);
    $('.jq_nueva_accion_particular').off('click').on('click', $seguimiento.clickNuevaAccionParticular);
    $('.btn-editar').off('click').on('click', $seguimiento.clickEditarAccionParticular);
    $('.btn-eliminar').off('click').on('click', $seguimiento.clickEliminarAccionParticular);
});