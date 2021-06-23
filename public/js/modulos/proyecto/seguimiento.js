var $seguimiento = (modulo => {
    modulo.me = {};

    modulo.clickNuevaAccion = function(e) {
        e.preventDefault();
        
        obtenerFormAccion();
    };

    modulo.clickEditarAccion = function(e) {
        e.preventDefault();
        modulo.me = $(this);
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
        modulo.me = $(this);
        obtenerFormAccionParticular($(this).parents('.card').attr('data-id'));
    };

    modulo.clickEditarAccionParticular = function(e) {
        e.preventDefault();

        if ( !$(this).parents('.item-accion-especifica').attr('data-id')) {
            return;
        }
        modulo.me = $(this);
        obtenerFormAccionParticular($(this).parents('.card').attr('data-id'), $(this).parents('.item-accion-especifica').attr('data-id'));
    };

    modulo.clickEliminarAccionParticular = function(e) {
        e.preventDefault();
        if ( !$(this).parents('.item-accion-especifica').attr('data-id')) {
            return;
        }
        modulo.me = $(this);
        var $params = {id:$(this).parents('.item-accion-especifica').attr('data-id')};
        $util.load.show(true);
        $util.post({
            url: "Seguimiento",
            metodo:"eliminarAccionEspecifica",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {                                       
                    setTimeout(() => {verificaReasignacion(data);}, 2300);
                }            
            }
        });
    };

    modulo.actualizaVistaAccion = ($params, $respuesta) => {
        
        if ($respuesta.ordenado) {
            setTimeout(() => {$(".content-modulos .jq_submodulo[data-control='" + $gestion.controlador + "']").trigger('click');}, 2300);
            return;
        }

        if (!$params.hasOwnProperty('id') && $.trim($respuesta.vista) != '') {            
            $('#accordion-acciones').append($respuesta.vista);
            modulo.eventosSubAcciones();
            return;
        }  

        var id = modulo.me.parents('.card').attr('data-id');

        if ($params.hasOwnProperty('id') && $.trim($respuesta.vista) != '') {            
            modulo.me.parents(`.card[data-id='${id}']`).find('.card-body .contenedor-subacciones').html($respuesta.vista);
            modulo.eventosSubAcciones();
        } 
        modulo.me.parents(`.card[data-id='${id}']`).find('.card-body .txt-ponderacion-gral').html("Ponderación: " + $respuesta.ponderacion);
        modulo.me.parents(`.card[data-id='${id}']`).find('.txt-definicion-gral').html($params.definicion);
        modulo.me.parents(`.card[data-id='${id}']`).find('.txt-descripcion-gral').html($params.descripcion);         
    };

    modulo.actualizaVistaSubAccion = ($params, $respuesta) => {
        if ($params.hasOwnProperty('id')) {
            modulo.me.parents('li').find('.txt-definicion-subaccion').html($params.definicion);
            modulo.me.parents('li').find('.txt-descripcion-subaccion').html($params.descripcion);
            return;
        }

        if (!$respuesta.hasOwnProperty('ponderacion') || !esNumerico($respuesta.ponderacion)) {
            return;
        }

        var id = modulo.me.parents('.card').attr('data-id');//console.log(id);

        if (parseFloat($respuesta.ponderacion)>0) {
            modulo.me.parents(`.card[data-id='${id}']`).find('.card-body .contenedor-subacciones').html($respuesta.vista);
            modulo.eventosSubAcciones();
            return;    
        }
        modulo.me.parents(`.card[data-id='${id}']`).find('.card-body .listado-subacciones').append($respuesta.vista);
        modulo.eventosSubAcciones();
    };

    modulo.eventosAcciones = () => {
        $('.btn-editar-accion').off('click').on('click', modulo.clickEditarAccion);
        $('.btn-eliminar-accion').off('click').on('click', modulo.clickEliminarAccion);
        $('.jq_nueva_accion_particular').off('click').on('click', modulo.clickNuevaAccionParticular);
    };

    modulo.eventosSubAcciones = () => {
        $('.btn-editar').off('click').on('click', modulo.clickEditarAccionParticular);
        $('.btn-eliminar').off('click').on('click', modulo.clickEliminarAccionParticular);
    };

    var verificaReasignacion = $respuesta => {
        var contenedor = modulo.me.parents('.contenedor-subacciones');
        modulo.me.parents("li").remove(); 
        if ($respuesta.reasignado) {            
            contenedor.html($respuesta.vista);
            modulo.eventosSubAcciones();
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
    $seguimiento.eventosAcciones();
    $seguimiento.eventosSubAcciones();
    
});