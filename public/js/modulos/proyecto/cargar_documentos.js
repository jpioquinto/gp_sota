var reader;
var objArchivos = [];
var $carga = (modulo => {

    modulo.progress = {};

    var claseHacerDespues= 'jq_subir_archivos';

    modulo.setClaseHacerDespues = clase => {
      claseHacerDespues = clase;
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

        reader = new FileReader();
        reader.onerror = modulo.errorHandler;
        reader.onprogress = modulo.updateProgress;
        var archivos = e.target.files; 
        reader.onabort = function(e) {
          console.log('Lectura de archivo cancelada');
        };

        reader.onloadstart = function(e) {
          modulo.progress = $(".progress-bar");
          $(".progress").removeClass("invisible");
          $('.content-archivos').removeClass('d-none');
        };

        reader.onload = function(e) {
      
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
          }, 2000);
          
          var html = "";
          $.each(archivos, function(index,archivo) {
            objArchivos.push({descripcion:'',archivo:archivo});    
            var indice = objArchivos.length;                 
            html += `<div class="col-sm-12 data-archivo" data-index='${indice-1}'>
                        <div class="form-group">
                            <p><span class='badge badge-success'>${indice}</span> ${archivo.name}</p>
                            <input type="text" class="form-control jq_desc_archivo" placeholder='Capture una descripción para este documento.'>                            
                        </div>
                    </div>`;
          });
          $(".content-archivos").append(html);
        };

        /* Read in the image file as a binary string.*/
        reader.readAsBinaryString(e.target.files[0]);
    };

    modulo.guardarPrecarga = function(e) {
      e.preventDefault();
      if (objArchivos.length<1) {
        notificacion('No se ha seleccion ningún archivo.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown");            
			  return;
      }
      if (!agrgarDescripcion()) {
        return;
      }
      $('.' + claseHacerDespues).trigger('click');
      $('#jq_modal_carga').modal('hide');
    };

    var agrgarDescripcion = () =>  {
      var agregda = false;
      $.each(objArchivos, function(index, archivo) {
        
        if ($.trim($(".data-archivo[data-index='" + index + "']").find('.jq_desc_archivo').val())=='') {
          notificacion('Debe capturar una descripción.', "error", 200, "bottomRight", "fadeInUp", "fadeOutDown"); 
          $(".data-archivo[data-index='" + index + "']").find('.jq_desc_archivo').focus();                      
          return agregda = false;
        }

        archivo.descripcion = $.trim($(".data-archivo[data-index='" + index + "']").find('.jq_desc_archivo').val());
        agregda = true;
      });
      
      return agregda;
    };

    return modulo;
})($carga || {});

$(function() {
    $("input[name='archivo']").off("change").on("change",$carga.precargaArchivo);
    $("#jq_aceptar_carga").off("click").on("click",$carga.guardarPrecarga);
});