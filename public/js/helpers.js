var notificacion = function(texto, tipo, tiempo, colocacion, animacionEntrada, animacionSalida) {  
    var notyClose = $("#noty_bottomRight_layout_container").find('li');
    if (notyClose.length >= 1) {
        $.each(notyClose, function(i, e) {
            var id = $(e).find('div.noty_bar').attr('id');
            var msg = $('#' + id).find('.noty_text').text();
            if (texto == msg) {
                $.noty.close(id);
                $(e).remove();
            }
        });
    }


    var colocar = (typeof colocacion == 'undefined') ? 'bottomRight' : colocacion;
    var aE = (typeof animacionEntrada == 'undefined') ? 'fadeInUp' : animacionEntrada;
    var aS = (typeof animacionSalida == 'undefined') ? 'fadeOutDown' : animacionSalida;
    var tipo = (typeof tipo == 'undefined' || tipo==="") ? 'warning' : tipo;
    noty({
        text: texto,
        type: tipo, //'information',
        dismissQueue: true,
        timeout: tiempo, //300,
        layout: colocar, //'bottomRight',
        theme: "defaultTheme",
        height: 30,
        animation: {
            open: 'animated ' + aE, // Animate.css class names
            close: 'animated ' + aS, // Animate.css class names
            easing: 'swing', // unavailable - no need
            speed: 400 // unavailable - no need
        }
    });
    setTimeout(function() {
        $.noty.closeAll();
    }, 6300);
}