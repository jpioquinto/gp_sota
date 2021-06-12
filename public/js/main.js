var $main = (modulo=> {

    modulo.seleccionarModulo = function(e) {
        e.preventDefault();
        if ($(this).attr("href").length==0 || $(this).attr("href")=='' || $(this).attr("href")=='#') {
            return;
        }
        $('.jq_sidebar li').removeClass('active');
        $(this).parents('.nav-item').addClass('active');
        cargarModulo($(this).attr("href"));
    };

    modulo.clickCerrarSesion = function(e) {
        e.preventDefault();
        //$util.load.show(true);
        $util.post({
            controlador: 'Login',
            metodo: "logout",
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    setTimeout(function() {
                        location.reload();
                      }, 600);
                }            
            }
        });
    };

    modulo.clickVerPerfil = function(e) {
        e.preventDefault();
        $('.jq_sidebar li').removeClass('active');
        cargarModulo('Perfil');
    };

    var cargarModulo = controlador => {
        $util.load.show(true);
        $util.post({
            controlador: controlador,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {
                    $('.gp-content').html('');
                    $('.gp-content').html(data.vista);
                }            
            }
        });
    };

    return modulo;
})($main || {});

$(function() {
    $('.jq_sidebar .jq_modulo').off('click').on('click', $main.seleccionarModulo);
    $('.jq_cerrar_sesion').off('click').on('click', $main.clickCerrarSesion);
    $('.jq_ver_perfil').off('click').on('click', $main.clickVerPerfil);
    $('body .loader-overlay').addClass('loaded');
});