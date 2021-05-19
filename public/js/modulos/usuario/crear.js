var $modalUser = (modulo=>{

    modulo.passwordCapturada = function(e) {
        e.preventDefault();
        
        if ($.trim($(this).val()).length<8) {
            $(this).parents('.form-group').removeClass("has-success").addClass("has-error");
            $("#mensaje-usuario").removeClass('text-success').addClass('text-danger');

            $("#jq_aceptar_usuario, input[name='copiapassword']").prop('disabled', true);
            $("#mensaje-password").html("<i class='fa fa-times-circle'> La contraseña debe contener mínimo 8 caracteres.");
        }

        if ($.trim($(this).val()).length>7) {
            $(this).parents('.form-group').removeClass("has-error").addClass("has-success");
            $("#mensaje-usuario").removeClass('text-danger').addClass('text-success');

            $("#jq_aceptar_usuario, input[name='copiapassword']").prop('disabled', false);
            $("#mensaje-password").html();
        }

    };

    modulo.verificaCapturaPassword = function(e) {
        e.preventDefault();
        ($.trim($(this).val()).length<8) 
        ? $("#jq_aceptar_usuario, input[name='copiapassword']").prop('disabled', true)
        : $("#jq_aceptar_usuario, input[name='copiapassword']").prop('disabled', false);
    };

    modulo.verificarDisponibilidad = function(e) {
        e.preventDefault();

        if ($.trim($(this).val()).length<8) {
            $(this).parents('.form-group').removeClass('has-success').addClass('has-error');
            $("#mensaje-usuario").removeClass('text-success').addClass('text-danger');

            $("#jq_aceptar_usuario, input[name='password']").prop('disabled', true);
            $("#mensaje-usuario").html("<i class='fa fa-times-circle'> El Usuario debe contener mínimo 8 caracteres.");
        }

        if ($.trim($(this).val()).length>7) {
            verificaExistencia($(this));
        }

    };

    modulo.comprobarCaptura = function(e) {
        e.preventDefault();        

        ($.trim($(this).val()).length<8) ? $("input[name='password']").prop('disabled', true) : $("input[name='password']").prop('disabled', false);        
    };

    modulo.clickGuardar = function(e) {
        e.preventDefault();
        if ($.trim($("input[name='usuario']").val())=='') {
            notificacion('El usuario es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='usuario']").focus();
			return;
        }
        if ($.trim($("input[name='usuario']").val()).length<8) {
            notificacion('El usuario debe contener minímo 8 caracteres.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='usuario']").focus();
			return;
        }
        if ($.trim($("input[name='password']").val())=='') {
            notificacion('La contraseña es requerida.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='password']").focus();
			return;
        }
        if ($.trim($("input[name='password']").val()).length<8) {
            notificacion('La contraseña debe contener minímo 8 caracteres.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='password']").focus();
			return;
        }
        if ($.trim($("input[name='password']").val())!= $.trim($("input[name='copiapassword']").val())) {
            notificacion('La confirmación no coincide con la contraseña.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='copiapassword']").focus();
			return;
        }

        if ( !esEntero($("select[name='perfil'] option:selected").val()) || parseInt($("select[name='perfil'] option:selected").val())<=0 ) {
            notificacion('Seleccione el perfil.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='perfil']").focus();
			return;
		}

        var params = {
            usuario:$.trim($("input[name='usuario']").val()),
            password:$.trim($("input[name='password']").val()),
            copiapassword:$.trim($("input[name='copiapassword']").val()),
            perfil:$("select[name='perfil'] option:selected").val()
        };

        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"agregarUsuario",
            datos:params,
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    $('#jq_modal_usuario').modal('hide');
                }            
            }
        });

    };

    var verificaExistencia = $el => {
        //$util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"verficarExistencia",
            datos:{usuario:$.trim($el.val())},
            funcion: function(data){
                //$util.load.hide();
                if (data.existe) {
                    $el.parents('.form-group').removeClass('has-success').addClass('has-error');
                    $("#jq_aceptar_usuario, input[name='password']").prop('disabled', true);

                    $("#mensaje-usuario").html("<i class='fa fa-times-circle'> Usuario no disponible.");
                } else {
                    $el.parents('.form-group').removeClass('has-error').addClass('has-success');
                    $("#mensaje-usuario").removeClass('text-danger').addClass('text-success');

                    $("#jq_aceptar_usuario, input[name='password']").prop('disabled', false);
                    $("#mensaje-usuario").html("<i class='fa fa-check-circle'> Usuario disponible.");
                }   
            }
        });
    };

    return modulo;
})($modalUser || {});

$(function() {
    $("input[name='usuario']").off('change').on('change', $modalUser.verificarDisponibilidad);
    $("input[name='usuario']").off('keyup').on('keyup', $modalUser.comprobarCaptura);

    $("input[name='password']").off('change').on('change', $modalUser.passwordCapturada);
    $("input[name='password']").off('keyup').on('keyup', $modalUser.verificaCapturaPassword);

    $("#jq_aceptar_usuario").off('click').on('click', $modalUser.clickGuardar);
});