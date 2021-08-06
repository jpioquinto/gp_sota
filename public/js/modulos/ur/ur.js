var $ur = (moddulo => {

    return moddulo;
})($ur || {});

$(function() {

    $('#jq_listado_urs').DataTable({
        "pageLength": 50,
        "scrollY": 400,
        /*"scrollX": true,*/
        language: {
            url: 'js/plugins/datatables/Spanish_Mexico.json'
        }
    });
    $('#jq_listado_urs').find('[data-toggle="tooltip"]').tooltip();    

    /*var $tabla = $('#jq_listado_urs');        
    $tabla.bootstrapTable('destroy').bootstrapTable({
        pagination: true, 
        pageSize: 50,    
        locale:'es-MX',
        paginationParts:[
            'pageInfo', 'pageSize','pageList'
        ]    
    });*/
});