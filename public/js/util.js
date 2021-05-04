var $util = (modulo => {
    var ajaxRequests = [];
    modulo.modulo_actual = '';

    modulo.post = obj=> {
        if (typeof(obj.load) != "undefined") {
            modulo.load.show(obj.load);
        };
        var uri = (((typeof(obj.url) != "undefined") ? obj.url : "") + (((typeof(obj.controlador) != "undefined") ? obj.controlador : modulo.modulo_actual)) + "/" + (((typeof(obj.metodo) != "undefined") ? (obj.metodo + "/") : "")));
        
        ($('[data-rel=tooltip]').length) ? $('[data-rel=tooltip]').tooltip('hide'): '';

        if (typeof(obj.formdata)!='undefined' && obj.formdata) {
            obj.datos.append(tkn,v);
        } else if (typeof(obj.datos) == 'object' || typeof(obj.datos) == 'array') {
            obj.datos[tkn] = v;
        } else {
            obj.datos += ("&" + tkn + "=" + v);
        }
        var notyClose = $("#noty_bottomRight_layout_container").find('li');
        if (notyClose.length >= 1) {
            $.each(notyClose, function(i, e) {                
                $.noty.close( $(e).find('div.noty_bar').attr('id') );
                $(e).remove();
            });
        }


        var size = ajaxRequests.length;
        
        ajx = $.ajax({
            type: ((typeof(obj.tipo) != "undefined") ? obj.tipo : "POST"),
            url: uri,
            data: obj.datos,
            dataType: ((typeof(obj.tipo) != "undefined") ? obj.tipo : "json"), //revisar pendiente
            context: document.body
        }).done(
            (
                (typeof(obj.funcion) != "undefined") ?

                function(data) {
                    var size = ajaxRequests.length;
                    //console.log(size);
                    //if (size<0) {that.load.hide();}else{that.load.show(true)};
                    var fn = obj.funcion;

                    if (data != null) {
                        if (data.hasOwnProperty("Solicitud") && data.Solicitud) {
                            var _notificacion = '';
                            if (data.hasOwnProperty("Notificacion")) {
                                _notificacion = data.Notificacion;
                            } else {
                                _notificacion = "success";
                            }
                            if (typeof(data.Msg) != "undefined" && data.Msg != '') {
                                notificacion(data.Msg, _notificacion, 4000, "bottomRight", "fadeInUp", "fadeOutDown");
                                setTimeout(function() {
                                    $.noty.closeAll();
                                }, 4300);
                            };
                            //callback de la funcion ajax;
                            $('body').find('.clicked').removeClass('clicked');
                            setTimeout(function() {
                                $.noty.closeAll();
                            }, 4300);
                            fn(data);
                        } else {
                            if (typeof(obj.forzar_funcion) != "undefined" && obj.forzar_funcion) {
                                fn(data);
                            }
                            if (data.hasOwnProperty("Session")) {
                                modulo.load.hide();
                                notificacion(data.Error, "success", "100", "bottomRight", "fadeInUp", "fadeOutDown");
                                modal = bootbox.dialog({
                                    title: "<h4><strong> Iniciar Sesión</strong> para continuar</h4>",
                                    message: data.Vista,
                                    className: "sesion-caducada",
                                    keyboard: false,
                                    animate: true
                                });
                                $('section').addClass('blur');
                                $('#usuario,#password').val('');
                                setTimeout(function() {
                                    $(document).find('.sesion-caducada').addClass('animated shake');
                                }, 500)
                                $('body .bootbox-close-button').addClass('hide');
                                $("#jq_modal_login #btn_login").off("click").on("click", function() {
                                    modulo.post({
                                        controlador: "login",
                                        metodo: "loguear",
                                        url: '',
                                        datos: "usuario=" + $("#usuario").val() + "&password=" + $("#password").val() + "&nocaptcha=1",
                                        funcion: function(data) {
                                            if (data.Solicitud) {
                                                $("#jq_modal_login").closeModal();
                                                $("#sidenav-overlay").trigger("click");
                                                modulo.post(obj);
                                                setTimeout(function() { $("#jq_div_modal").remove(); }, 1000);
                                            }
                                        }
                                    });
                                });
                            } else {

                                if (data.hasOwnProperty('Errors')) {
                                    $.each(data.Errors, function(i, v) {
                                        notificacion(v, "error", "300", "bottomRight", "fadeInUp", "fadeOutDown");
                                    });
                                    setTimeout(function() { $.noty.closeAll() }, 4300);
                                } else if (data.hasOwnProperty('Info')) {
                                    fn(data);
                                    notificacion(data.Info, "information", 300, "bottomRight", "fadeInUp", "fadeOutDown");
                                    setTimeout(function() { $.noty.closeAll() }, 4300);
                                } else {
                                    fn(data);
                                    notificacion(data.Error, "error", 300, "bottomRight", "fadeInUp", "fadeOutDown");
                                    setTimeout(function() { $.noty.closeAll() }, 4300);
                                }

                                $('body').find('.clicked').removeClass('clicked');
                            }
                        }
                    } else {
                        $('body').find('.clicked').removeClass('clicked');
                        $('body').find('button').removeAttr('disabled');
                        $('button').prop('disabled', false).removeAttr('disabled');
                        $('body').find('.btn').prop('disabled', false).removeAttr('disabled');
                        notificacion("Posible error de codificación", "error", 1000, "bottomRight", "fadeInUp", "fadeOutDown");
                        setTimeout(function() {
                            $.noty.closeAll();
                        }, 4300);
                    }
                } :
                function() {
                    modulo.load.hide();
                }
            )
        ).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.readyState == 0 && textStatus === "abort") {
                aborted = true;
                notificacion("Ha cancelado la solicitud", "warning", 3000, "bottomRight", "bounceIn", "bounceOut");
            } else if (jqXHR.status == 403) {
                notificacion("Token inválido es necesario recargar la página", "error", 3000, "bottomRight", "bounceIn", "bounceOut");
                setTimeout(function() {
                    location.reload();
                }, 800);
            } else if (jqXHR.status == 0 || jqXHR.readyState == 0) {
                notificacion("Error de comunicación", "warning", 8000, "bottomRight", "bounceIn", "bounceOut");
                $('body').find('.clicked').removeClass('clicked');
                modulo.load.hide();
            } else {
                notificacion(jqXHR.status + " : " + errorThrown, "error", 3000, "bottomRight", "bounceIn", "bounceOut");
                $('body').find('.clicked').removeClass('clicked');
                modulo.load.hide();
            }
            //Materialize.toast('<i class="material-icons">info</i> El servidor no responde o no hay conexi&oacute;n a internet.',4000, 'red');
        });
        ajaxRequests.push(ajx);
    }

    return modulo;
})($util || {});