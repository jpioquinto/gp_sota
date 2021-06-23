var $uPerfil = (modulo => {
    var listaCorreos = [];
    var listaTelefonos = [];
    var cacheMunicipios = [];
    modulo.test = () => {
        return listaTelefonos;
    }
    modulo.ini = () => {
        $util.load.show(true);
        $util.post({
            url: "Perfil",
            metodo:"obtenerCorreoYTelefono",
            datos:{},
            funcion: function(data){
                if (data.Solicitud) {
                    listaCorreos = data.listaCorreos;
                    listaTelefonos = data.listaTelefonos;
                }
                $util.load.hide();
            }
        });
    };

    modulo.clickCargarFoto = function(e) {
        e.preventDefault();
        $('.uploadFile').trigger('click');
    };

    modulo.clickCambiarPassword = function(e) {
        e.preventDefault();
        $util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"obtenerVistaCambio",
            datos:{},
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.content-modal').html(data.vista);
                    $('#jq_nuevo_pass').modal('show');
                    $('#jq_aceptar_cambio').off('click').on('click', modulo.cambiarPassword);
                }            
            }
        });
    };

    modulo.subirFoto = function(e) {
        var me = $(this);
        /* 500 KMB */
        var mb = 0.48828125;
        var limit   = 1048576 * mb;
        var cargado = false;
        var error   = "";
        var datos = new FormData();
        datos.append("foto",this.files[0]);        
        //datos.append(tkn,v);
        if (limit<this.files[0].size) {          
            notificacion("El tamaño del archivo supera lo permitido ( 500 kB )", "error", 5000, "bottomRight");
            return false;          
        }
        //objUtil.load.show(true); 
        $.ajax({
            url:'Perfil/cargarFoto',
            type:"POST",
            data:datos,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",
            success:function(data){
              if (data.Solicitud) {
                cargado = true;  
                $('.jq_foto_perfil').attr("src", data.url + "?id=" + $util.hash());
                //$('.user-image img').attr("src", "./assets/v2/img/perfil/" + data.File + "?id=" + generatePassword());              
                notificacion(data.Msg, "success", 4000, "bottomRight", "fadeInUp", "fadeOutDown"); 
              }

              if (!data.Solicitud) {
                error = data.Error;
              }                        
            }
        }).always(function(){
            //objUtil.load.hide();
            if (!cargado) {            
                notificacion(error, "error", 4000, "bottomRight", "fadeInUp", "fadeOutDown"); 
            }          
        });  
    };

    modulo.cambiarPassword = function(e) {
        e.preventDefault();
        if ($.trim($("input[name='anterior']").val())=='') {
            notificacion('La contraseña anterior es requerida.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='anterior']").focus();
			return;
        }
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

        var params = {
            anterior:$.trim($("input[name='anterior']").val()),
            nueva:$.trim($("input[name='nueva']").val()),
            copianueva:$.trim($("input[name='copianueva']").val())
        };

        $util.load.show(true);
        $util.post({
            url: "Usuario",
            metodo:"cambiarPassword",
            datos:params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('#jq_nuevo_pass').modal('hide');
                }            
            }
        });
    };

    modulo.clickGuardarPerfil = function(e) {
        e.preventDefault();
        if ( $.trim($("input[name='nombre']").val())=='') {
            notificacion('El campo Nombre es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='nombre']").focus();
			return;
		}
        if ( $.trim($("input[name='ap_paterno']").val())=='') {
            notificacion('El campo Apellido Paterno es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='ap_paterno']").focus();
			return;
		}
        if ( $.trim($("input[name='ap_paterno']").val()).length<3) {
            notificacion('Ingrese un Apellido válido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='ap_paterno']").focus();
			return;
		}
        if ( !esEntero($("select[name='estado'] option:selected").val()) || parseInt($("select[name='estado'] option:selected").val())<=0 ) {
            notificacion('Seleccione el estado.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='estado']").focus();
			return;
		}
        if ( !esEntero($("select[name='municipio']").val()) || parseInt($("select[name='municipio']").val())<=0 ) {
            notificacion('Seleccione el municipio.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='municipio']").focus();
			return;
		}
        if ( !esEntero($("select[name='puesto']").val()) || parseInt($("select[name='puesto']").val())<=0 ) {
            notificacion('Seleccione el Puesto.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("select[name='puesto']").focus();
			return;
		}
        if ( $.trim($("input[name='cargo']").val())=='') {
            notificacion('El campo Cargo es requerido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='cargo']").focus();
			return;
		}
        if ( $.trim($("input[name='cargo']").val()).length<6) {
            notificacion('Ingrese un Cargo válido.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='cargo']").focus();
			return;
		}
        if (listaCorreos.length==0) {
            notificacion('Ingrese por lo menos una direción de correo electrónico.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
        }
        if (listaTelefonos.length==0) {
            notificacion('Ingrese por lo menos un número de teléfono.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
        }
        var params = {
            municipio:$("select[name='municipio'] option:selected").val(),
            estado:$("select[name='estado'] option:selected").val(),
            puesto:$("select[name='puesto'] option:selected").val(),
            telefonos:listaTelefonos,
            correos:listaCorreos,
        };

        $('.jq_formulario input').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }
            params[$(this).attr('name')] = $.trim($(this).val());
        });

        $util.load.show(true);
        $util.post({
            url: "Perfil",
            metodo:"guardarInformacion",
            datos:params,
            funcion: function(data){
              if (data.Solicitud) {
                
              }
              $util.load.hide();
            }
          });
    };

    modulo.seleccionarEstado = function(e) {
        e.preventDefault();
        if (esEntero($(this).val()) && parseInt($(this).val())>0) {
            $('#id-municipio').empty().trigger('change');
            obtenerMunicipios($(this).val());
        }
    };

    modulo.capturandoCorreo = function(e) {
        e.preventDefault();
        esEmailValido($('#id-correo').val()) 
        ? $(".jq_agregar_email").prop("disabled", false) 
        : $(".jq_agregar_email").prop("disabled", true);
    };

    modulo.capturandoTelefono = function(e) {
        //e.preventDefault();
        var lada = $("input[name='lada']").val().length >= 2 ? true : false;
        var numero = $("input[name='telefono']").val().length >= 7 ? true : false;
        if (esEntero($("#id-tipo-telefono option:selected").val()) && parseInt($("#id-tipo-telefono option:selected").val())>0) {
            (lada && numero) ? $('.jq_agregar_telefono').prop("disabled", false) : $('.jq_agregar_telefono').prop("disabled", true);
        }
    };

    modulo.clickAgregarTelefono = function(e) {
        e.preventDefault();
        if (!esEntero($("#id-tipo-telefono option:selected").val()) || parseInt($("#id-tipo-telefono option:selected").val())<=0) {
            notificacion("Seleccione el tipo de teléfono.", "error", 5000, "bottomRight", "fadeInRight", "fadeOutRight");
            return;
        }
        if ( !esTelefonoValido($("input[name='telefono']").val()) ) {
            notificacion("El teléfono es incorrecto.", "error", 5000, "bottomRight", "fadeInRight", "fadeOutRight");
            return;
        }
        listaTelefonos[listaTelefonos.length] = {
            id: $util.hash(18),
            tipo: $("#id-tipo-telefono option:selected").val(),
            lada: $.trim( $("input[name='lada']").val() ),
            telefono: $.trim( $("input[name=telefono]").val() ),
            extension: $.trim( $("input[name=extension]").val() )
        };
        agregarFilaTelefono(listaTelefonos[listaTelefonos.length-1], $("#id-tipo-telefono option:selected").text());
        $(this).prop("disabled", true);
    };

    modulo.clickAgregarCorreo = function(e) {
        e.preventDefault();
        if (!esEmailValido($('#id-correo').val())) {
            notificacion("Ingrese una direción de correo válida.", "error", 5000, "bottomRight", "fadeInRight", "fadeOutRight");
            return;
        }
        if (existeCorreo($('#id-correo').val())) {
            notificacion("Este correo ya está añadido.", "error", 5000, "bottomRight", "fadeInRight", "fadeOutRight");
            return;
        }
        if (!esEntero($("#id-tipo-correo option:selected").val()) || parseInt($("#id-tipo-correo option:selected").val())<=0) {
            notificacion("Seleccione el tipo de correo.", "error", 5000, "bottomRight", "fadeInRight", "fadeOutRight");
            return;
        }
        listaCorreos[listaCorreos.length] = {
            id: $util.hash(18),
            tipo: $("#id-tipo-correo option:selected").val(),
            email: $.trim($('#id-correo').val())
        };
        agregarFilaCorreo(listaCorreos[listaCorreos.length-1], $("#id-tipo-correo option:selected").text());
        $(this).prop("disabled", true);
    };

    modulo.clickEliminarFilaCorreo = function(e) {
        e.preventDefault();        
        var email = $.trim( $(this).parents('tr').find("td[data-email='true']").text() );
        var copia = listaCorreos.filter(correo => correo.email!==email);
        listaCorreos = copia;
        $(this).parents('tr').remove();
    };

    modulo.clickEliminarFilaTelefono = function(e) {
        e.preventDefault();        
        var id = $.trim( $(this).parents('tr').attr('data-id'));

        var copia = listaTelefonos.filter(telefono => (telefono.id!=id));
        listaTelefonos = copia;
        $(this).parents('tr').remove();
    };
    
    obtenerMunicipios = idEstado => {
        if (cacheMunicipios.hasOwnProperty(idEstado)) {
            $('#id-municipio').select2({data: cacheMunicipios[idEstado]}); return;
        }
        $util.load.show(true);
        $util.post({
            url: "Perfil",
            metodo:"listadoMunicipios",
            datos:{idEstado:idEstado},
            funcion: function(data){
                if (data.Solicitud) {
                    data.opciones.length>0 ? (cacheMunicipios[idEstado] = data.opciones) : '';
                    $('#id-municipio').select2({data: data.opciones});
                }
                $util.load.hide();
            }
          });
    };

    var agregarFilaCorreo = (correo, descTipo) => {
        $('.jq_tabla_correos tbody').append(`
            <tr data-id='${correo.id}'>
                <td>${listaCorreos.length}</td>
                <td>${descTipo}</td>
                <td data-email='true'>${correo.email}</td>
                <td>
                    <span class="badge badge-danger btn-eliminar-email jq_eliminar_email"><i class="fa fa-minus-circle"></i></span>
                </td>
            </tr>        
        `);
        resetCamposCorreo();
        $('.jq_tabla_correos tbody tr .jq_eliminar_email').off('click').on('click', modulo.clickEliminarFilaCorreo);
    };

    var resetCamposCorreo = () => {        
        $('#id-tipo-correo option').prop('selected', function() {
            return this.defaultSelected;
        });
        $('#id-correo').val(null);

    };

    var esEmailValido = email => {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if ($.trim(email)=='') {
            return false;
        }
        return emailReg.test($.trim(email));
    };

    var existeCorreo = email => {
        var existe = false;
        $.each(listaCorreos, function(index, value) {
            if (value.email == $.trim(email)) {
                existe = true;
            }
        });
        $('.jq_tabla_correos tbody tr').each(function() {
            if ($.trim($(this).find("td[data-email='true']").text()) == $.trim(email)) {
                existe = true;
            }
        });
        return existe;
    };

    var agregarFilaTelefono = (telefono, descTipo) => {
        var desc = (telefono.lada != '' ? `(${telefono.lada})` : '') + telefono.telefono;
            desc += telefono.extension != '' ? ` Ext. ${telefono.extension}` : '';             

        $('.jq_tabla_telefonos tbody').append(`
            <tr data-id='${telefono.id}'>
                <td>${listaTelefonos.length}</td>
                <td>${descTipo}</td>
                <td data-telefono='true'>${desc}</td>
                <td>
                    <span class="badge badge-danger btn-eliminar-tel jq_eliminar_tel"><i class="fa fa-minus-circle"></i></span>
                </td>
            </tr>        
        `);
        resetCamposTelefono();
        $('.jq_tabla_telefonos tbody tr .jq_eliminar_tel').off('click').on('click', modulo.clickEliminarFilaTelefono);
    };
    
    var esTelefonoValido = telefono => {
        telefono = telefono.replace(/[#\s ]*/g, "");  
        return (telefono != "" && telefono.length >= 7) ? true : false;
    }

    var resetCamposTelefono = () => {
        $('#id-tipo-telefono option').prop('selected', function() {
            return this.defaultSelected;
        });
        $("input[name='lada']").val(null);
        $("input[name='telefono']").val(null);
        $("input[name='extension']").val(null);
    }

    return modulo;
})($uPerfil || {});

$(function() {    
    $('#id-municipio').select2();

    $('.jq_cambiar_passw').off('click').on('click', $uPerfil.clickCambiarPassword);
    $('.jq_cargar_foto').off('click').on('click', $uPerfil.clickCargarFoto);
    $('.uploadFile').off('change').on('change', $uPerfil.subirFoto);
    $("input[name='telefono']").mask('99 99 99 99');
    $('.jq_agregar_email').off('click').on('click', $uPerfil.clickAgregarCorreo);
    $('#id-correo').off('keyup').on('keyup', $uPerfil.capturandoCorreo);

    $('.jq_agregar_telefono').off('click').on('click', $uPerfil.clickAgregarTelefono);
    $('.jq_validar_numero').off('keydown').on('keydown', $uPerfil.capturandoTelefono);
    $('.jq_validar_numero').off('keypress').on('keypress', $util.soloEntero);

    $('#id-estado').off('change').on('change', $uPerfil.seleccionarEstado);

    $('.jq_guardar_info').off('click').on('click', $uPerfil.clickGuardarPerfil);

    if ($('#id-municipio option').length==0) {
        $('#id-estado').trigger('change');
    }

    $('.jq_tabla_correos tbody tr .jq_eliminar_email').off('click').on('click', $uPerfil.clickEliminarFilaCorreo);
    $('.jq_tabla_telefonos tbody tr .jq_eliminar_tel').off('click').on('click', $uPerfil.clickEliminarFilaTelefono);

    $uPerfil.ini();

});