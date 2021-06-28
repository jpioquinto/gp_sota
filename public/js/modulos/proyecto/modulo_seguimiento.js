var $modSeguimiento = (modulo=>{

    modulo.ini = () => {
        var $tabla = $('#jq_listado_acciones');
        //var $tbody = $tabla.find('tbody').html();
        $tabla.bootstrapTable('destroy').bootstrapTable({
            pagination: true,
            locale:'es-MX',
            search: true,            
        });
        
        
    };

    return modulo;
})($modSeguimiento || {});

$(function() {
    $modSeguimiento.ini();    
});