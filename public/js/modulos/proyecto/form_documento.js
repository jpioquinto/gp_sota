var reader;
var objArchivos = [];
var $formDoc = ((modulo, valida) => {

    modulo.progress = undefined;

    modulo.ini = () => {
        var tempo = 0, itera = 0;        

        tempo = setInterval(() => {
            if (itera>99) {
                clearInterval(tempo);
            }
            if ($("input[name='id']").length>0) {
                $('.jq_select').select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
                clearInterval(tempo);
                return;
            }
            if ($('.jq_select').length==0) {
                itera++; return;
            }
            $('.jq_select').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            setearNombre();
            clearInterval(tempo);
        }, 500); 
        
    };

    modulo.abortRead = function() {
        reader.abort();
    };

    modulo.errorHandler = function(evt) {
        switch(evt.target.error.code) {
          case evt.target.error.NOT_FOUND_ERR:
            console.log('Archivo no encontrado!');
            break;
          case evt.target.error.NOT_READABLE_ERR:
            console.log('Archivo no leíble');
            break;
          case evt.target.error.ABORT_ERR:
            break; 
          default:
            console.log('A ocurrido un error durante la lectura de este archivo.');
        };
    };
  
    modulo.updateProgress = function(evt) {
        /* evt is an ProgressEvent.*/
        if (evt.lengthComputable) {
          var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
          /* Increase the progress bar length.*/
          if (percentLoaded < 100) {
            $(modulo.progress).attr("aria-valuenow",percentLoaded);
            $(modulo.progress).css({"width":percentLoaded + "%"});
            $(modulo.progress).html(percentLoaded+"%");
          }
        }
    };

    modulo.precargaArchivo = function(e) {

        /* Reset progress indicator on new file selection.*/
        $(modulo.progress).css({"width":"0%"});
        $(modulo.progress).html("0%");

        var archivos = e.target.files; 

        reader = new FileReader();
        reader.onerror = modulo.errorHandler;
        reader.onprogress = modulo.updateProgress;
        reader.onabort = modulo.abortRead;

        reader.onloadstart = function(e) {
           modulo.progress = $(".progress-bar");
           $(".progress").removeClass("invisible");           
        };
 
        reader.onload = function(e) {
       
            objArchivos.push(archivos[0]);
            $(modulo.progress).attr("aria-valuenow","100");
            $(modulo.progress).css({"width":"100%"});
            $(modulo.progress).html("100%");
            setTimeout(function(){
                $(modulo.progress).attr("aria-valuenow","0");
                $(modulo.progress).css({"width":"0%"});
                $(modulo.progress).html("");
                $(".progress").addClass('invisible');
                if (objArchivos.length>0) {
                    $('#jq_aceptar_carga').prop('disabled', false);
                }
                setearNombre();
            }, 2000);

            
        };
 
         /* Read in the image file as a binary string.*/
         reader.readAsBinaryString(e.target.files[0]);
    };

    modulo.guardarDocumento = function(e) {
        e.preventDefault();

        if (objArchivos.length==0 || !objArchivos[0].name) {
            notificacion('No se ha seleccion ningún archivo.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
        }

        if ($.trim($proyecto.getId())=='') {
            return;
        }

        if (!valida.validar()) {
            return;
        }

        var tkn = "csrf_gp_name";
	    var v   = $("input[name='" + tkn + "']").val();

        var formData = new FormData();

        formData.append("proyectoId", $proyecto.getId());
        formData.append("archivo", objArchivos[0]);
        formData.append("tipo_doc", $("select[name='tipo_doc'] option:selected").text());
        
        $.each(valida.params, function(clave, valor) {
            formData.append(clave, valor);
        });

        if ($("select[name='clave']").length>0 && $("select[name='clave']").val().length>0) {            
            formData.append('clave', $("select[name='clave']").val());
        }

        if ($("select[name='redes']").length>0 && $("select[name='redes']").val().length>0) {            
            formData.append('redes', $("select[name='redes']").val());
        }

        formData.append(tkn,v);
        $util.load.show(true);

        var cargado = false;
        var error = '';
        $.ajax({
            url:'Documento/cargarArchivo',
            type:"POST",
            data:formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",
            success:function(data) {
                if (data.Solicitud) {
                    cargado = true;
                    $('#jq_modal_form').modal('hide'); 
                    notificacion(data.Msg, "success", 4000, "bottomRight", "fadeInUp", "fadeOutDown");
                } else {
                    error = data.Error;
                }
            }
        }).always(function() {
            if (!cargado && error!='') {
                notificacion(error, "error", 200, "bottomRight", "fadeInUp", "fadeOutDown"); 
                return;
            }
            $util.load.hide();            
        });
    };

    modulo.actualizarFicha = function(e) {
        e.preventDefault();
        if ($("input[name='id']").length==0) {
            notificacion('No se recibió el Identificador de la Ficha Documental.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			return;
        }

        if ($.trim($proyecto.getId())=='') {
            return;
        }

        if (!valida.validar()) {
            return;
        }

        valida.params["proyectoId"] = $proyecto.getId();        

        if ($("select[name='clave']").length>0 && $("select[name='clave']").val().length>0) {            
            valida.params["clave"] = $("select[name='clave']").val();
        }

        if ($("select[name='redes']").length>0 && $("select[name='redes']").val().length>0) {            
            valida.params["redes"] = $("select[name='redes']").val();
        }

        valida.params['form'] = $('.ficha-form').attr('data-ficha');

        $util.load.show(true);
        $util.post({
            url: "Documento",
            metodo:"actualizarFicha",
            datos:valida.params,
            funcion: function(data){
              if (data.Solicitud) {
                $('#jq_modal_form').modal('hide'); 
              }
              $util.load.hide();
            }
        });   
    };

    var setearNombre = () => {
        if ($("input[name='nombre']").length>0 && $.trim($("input[name='nombre']").val())=='') {
            objArchivos.length>0 ? $("input[name='nombre']").val(quitarExtension(objArchivos[0].name)) : null;
        }
    };
    
    return modulo;
})($formDoc || {}, $objValida || {});

$(function() {
    $formDoc.ini();
    $("input[name='archivo']").off("change").on("change", $formDoc.precargaArchivo);
    $("#jq_aceptar_carga").off("click").on("click", $formDoc.guardarDocumento);
    $("#jq_actualiza_ficha").off("click").on("click", $formDoc.actualizarFicha);
});