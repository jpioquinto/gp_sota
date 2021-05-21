var $main = (modulo=> {

    modulo.seleccionarModulo = function(e) {
        e.preventDefault();
        if ($(this).attr("href").length==0 || $(this).attr("href")=='' || $(this).attr("href")=='#') {
            return;
        }
        //$util.load.show(true);
        $util.post({
            controlador: $(this).attr("href"),
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    
                }            
            }
        });
    };

    return modulo;
})($main || {});

$(function() {
    $('.jq_sidebar .jq_modulo').off('click').on('click', $main.seleccionarModulo);
});