var $modSeguimiento = (modulo=>{

    return modulo;
})($modSeguimiento || {});

$(function() {
    $('#jq_listado_acciones').DataTable({
        "pageLength": 50,
        language: {
            url: 'js/plugin/datatables/Spanish_Mexico.json'
        }
    });
});