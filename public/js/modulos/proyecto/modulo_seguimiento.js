var $modSeguimiento = (modulo=>{

    return modulo;
})($modSeguimiento || {});

$(function() {
    $('#jq_listado_acciones').DataTable({  
        'rowsGroup': [0],     
        "pageLength": 50,
        language: {
            url: 'js/plugin/datatables/Spanish_Mexico.json'
        }/*, ,
        'columnDefs': [
            {
               'targets': [1, 2, 3, 4, 5],
               'orderable': true,
               'searchable': true
            }
        ]*/
    });
});