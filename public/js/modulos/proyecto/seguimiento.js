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

    return modulo;
})($seguimiento || {}); 

$(function() {
    $('.jq_nueva_accion').off('click').on('click', $seguimiento.clickNuevaAccion);
});