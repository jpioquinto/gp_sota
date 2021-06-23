var $uPass = (modulo=>{
    var usuarioId = -1;

    modulo.ini = id => {
        usuarioId = id;
    };

    modulo.clickCambiarPassword = function(e) {
        e.preventDefault();
        if ($.trim($("input[name='nueva']").val())=='') {
            notificacion('Ingrese la nueva contraseña.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nueva']").focus();
			return;
        }
        if ($.trim($("input[name='nueva']").val()).length<8) {
            notificacion('La nueva contraseña debe contener minímo 8 caracteres.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nueva']").focus();
			return;
        }
        if ($.trim($("input[name='nueva']").val())!= $.trim($("input[name='copianueva']").val())) {
            notificacion('La confirmación no coincide con la nueva contraseña.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='copianueva']").focus();
			return;
        }

        var $params = {            
            copianueva:$.trim($("input[name='copianueva']").val()),
            nueva:$.trim($("input[name='nueva']").val()),
            id:usuarioId
        };

        $util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"cambiarPasswordDirecto",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('#jq_nuevo_pass').modal('hide');
                }            
            }
        });
    };

    return modulo;
})($uPass || {});

$(function() {
    $('#jq_aceptar_cambio').off('click').on('click', $uPass.clickCambiarPassword);
});