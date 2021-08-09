var $formUR = (modulo => {

    var listado = {};

    modulo.params = {};

    modulo.validarInput = () => {
        var valido = true;
        var me     = undefined;

        $('.jq_form_ur input').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }

            $(this).parents('.form-group').removeClass('has-error');

            me = $(this);

            if ($.trim($(this).val())=='' && $(this).attr('required')) {
                modulo.params = {}; $(this).parents('.form-group').addClass('has-error');
                notificacion('El campo ' + $(this).parents('.form-group').find('label').text() + ' es requerido', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");                 
                return valido = false;
            }
            
            if ($.trim($(this).val())!='') {
                modulo.params[$(this).attr('name')] = $(this).attr('type')=='radio' 
                                                    ? $("input[name='" + $(this).attr('name') +"']:checked").val()
                                                    : $.trim($(this).val());
            }
        });        
        
        if (me) {
            setTimeout(() => {me.focus();}, 1000);
        }

        return valido && Object.keys(modulo.params).length>0;
    };

    modulo.validarSelect  = () => {
        var valido = true, iniciado = false;
        var me     = undefined;

        $('.jq_form_ur select').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }

            $(this).parents('.form-group').removeClass('has-error');

            me = !me ? $(this) : me;

            if ((!$(this).find('option:selected').val() || $(this).find('option:selected').val()=='') && $(this).attr('required')) {
                modulo.params = {}; $(this).parents('.form-group').addClass('has-error');
                notificacion('El campo ' + $(this).parents('.form-group').find('label').text() + ' es requerido', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");                 
                return valido = false;
            }
            
            if ($(this).find('option:selected').val()!='') {
                modulo.params[$(this).attr('name')] = $(this).find('option:selected').val();
            }
            iniciado = true;
        });

        if (me) {
            setTimeout(() => {me.focus();}, 1000);
        }

        return valido && iniciado;
    };

    modulo.guardarUR = function(e) {
        e.preventDefault();

        if (!modulo.validarInput() || !modulo.validarSelect()) {
            return;
        } 

        $util.load.show(true);
        $util.post({
            url: "UnidadResponsable",
            metodo:"guardar",
            datos:modulo.params,
            funcion: function(data) {
              if (data.Solicitud) {
                //$docs.actualizarContenidoFicha(data, valida.params);
                $('#jq_modal_ur').modal('hide'); 
              }
              $util.load.hide();
            }
        }); 
    };

    modulo.selectEntidad = function(e) {
        e.preventDefault();

        if (!esEntero($(this).val())) {
            return;
        }

        if (listado.hasOwnProperty($(this).val())) {
            return $("select[name='municipio']").html(listado[$(this).val()]);
        }
        
        var me = $(this);
        $util.load.show(true);
        $util.post({
            url: "UnidadResponsable",
            metodo:"obtenerListadoMunicipios",
            datos:{entidad:$(this).val()},
            funcion: function(data) {
              if (data.Solicitud) {
                $("select[name='municipio']").html(data.listado);
                listado[me.val()] = data.listado;
              }
              $util.load.hide();
            }
        }); 
    };

    modulo.generaSIGLA = function(e) {
        e.preventDefault();
        
        $("input[name='id']").length>0
        ? $("input[name='sigla']").val( $(this).val().replace(/[a-z|á-ú|ñ|Ñ\s]*/g,'') )
        : $("input[name='sigla'], input[name='carpeta']").val( $(this).val().replace(/[a-z|á-ú|ñ|Ñ\s]*/g,'') );
    };

    return modulo;
})($formUR || {});

$(function() {
    $("#jq_guardar_ur").off("click").on("click", $formUR.guardarUR);
    $("select[name='entidad']").off("change").on("change", $formUR.selectEntidad);
    $("input[name='nombre']").off("blur").on("blur", $formUR.generaSIGLA);

    var tempo = 0, itera = 0;
    tempo = setInterval(() => {
        if (itera>99) {
            clearInterval(tempo);
        }
        if ($('#data-municipio').length==0) {
            itera++; return;
        }
        $('#data-municipio').select2();
        clearInterval(tempo);
    }, 500);     
});