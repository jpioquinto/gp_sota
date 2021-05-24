var $usuario = (modulo=>{
    modulo.clickAgregar = function(e) {
        e.preventDefault();
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"obtenerVistaNuevo",
            datos:{},
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_usuario').modal('show');
                    //$('#jq_aceptar_cambio').off('click').on('click', modulo.cambiarPassword);
                }            
            }
        });
    }
    return modulo;
})($usuario || {}); 

$(function() {
    $('#jq_listado_users').DataTable({
        "pageLength": 50,
    });

    $('.jq_nuevo_usuario').off('click').on('click', $usuario.clickAgregar);
});