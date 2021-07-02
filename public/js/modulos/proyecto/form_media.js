var $formMedia = (modulo => {
    var archivo = undefined;
    var reader;

    modulo.ini = () => {
        var tempo = 0, itera = 0;

        tempo = setInterval(() => {
            if (itera>99) {
                clearInterval(tempo);
            }
            if ($('.jq_p_clave').length==0) {
                itera++; return;
            }
            $('.jq_p_clave').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            clearInterval(tempo);
        }, 500);        
    };

    modulo.clickGuardar = function(e) {
        e.preventDefault();
        
        if ($("input[name='foto']").length>0) {
            return guardarImagen();
        }

        if ($("input[name='video']").length>0) {
            return guardarVideo();
        }
    };

    modulo.precargaArchivo = function(e) {
        archivo = e.target.files[0];

        reader = new FileReader();
        reader.onerror = function(evt) { archivo = undefined; };
        reader.onprogress = function(evt) { archivo = undefined; };        
        reader.onabort = function(evt) { archivo = undefined; };

        reader.readAsBinaryString(e.target.files[0]);
    };

    var guardarImagen = () => {
        var $params = {};

        if (!archivo) {
            notificacion('No se ha seleccion ningún archivo.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $('#data-media').focus();            
			return $params;
        }

        if ( $.trim($("input[name='descripcion']").val()).length<8) {
            notificacion('Capture una descripción válida.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");
            $("input[name='descripcion']").focus();
			return $params;
		}

        $('.ficha-media').find('input').each(function() {
            if (!$(this).attr('name')) {
                return true;
            }
            $params[$(this).attr('name')] = $.trim( $(this).val() );
        });

        if (Object.keys($params).length==0) {
            return $params;
        }
        
        if ($("select[name='clave']").val().length>0) {
            $params['clave'] = $("select[name='clave']").val();
        }return $params;
    };

    var guardarVideo = () => {
        
    };

    return modulo;
})($formMedia || {});

$(function() {
    $formMedia.ini();
    $('#jq_aceptar_form').off('click').on('click', $formMedia.clickGuardar);
    $("#data-media").off('change').on('change', $formMedia.precargaArchivo);
});