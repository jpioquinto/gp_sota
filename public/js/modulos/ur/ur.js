var $ur = (modulo => {

    var iconCerrado = 'fas fa-angle-double-down';
    var iconAbierto = 'fas fa-angle-double-right';

    var tabla = {};

    var me = {};

    modulo.ini = () => {
        tabla = $('#jq_listado_urs').DataTable({
            "pageLength": 50,
            "scrollY": 400,
            "scrollX": true,
            language: {
                url: 'js/plugins/datatables/Spanish_Mexico.json'
            },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": `<button type='button' data-toggle='tooltip' class='btn btn-icon btn-round btn-xs btn-default' data-original-title='Ver más información'>
                                            <i class='fas fa-angle-double-down'></i>
                                        </button>`
                },
                { "data": "nombre" },
                { "data": "sigla" },
                { "data": "estatus" },
                { "data": "carpeta" },
                { "data": "calle" },
                { "data": "ext" },
                { "data": "int" },
                { "data": "col" },
                { "data": "cp" },
                { "data": "estado" },
                { "data": "municipio" },
                { "data": "acciones" }
            ]
        });
        $('#jq_listado_urs').find('[data-toggle="tooltip"]').tooltip();    
        $('#jq_listado_urs tbody').on('click', 'td.details-control', modulo.clickVerDetalle);
    };

    modulo.clickVerDetalle = function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        var row = tabla.row( tr );
 
        if ( row.child.isShown() ) {            
            row.child.hide();
            tr.find('td:first i').removeClass(iconAbierto).addClass(iconCerrado);
        } else {            
            row.child( modulo.mostrarDetalle(row.data()) ).show();
            tr.find('td:first i').removeClass(iconCerrado).addClass(iconAbierto);
        }
    };

    modulo.mostrarDetalle = datos => {console.log(datos);
        return  `<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;"> 
            <tr> 
                <td>Calle</td> 
                <td> ${datos.calle} </td> 
            </tr> 
            <tr> 
                <td>Num. Ext.</td> 
                <td> ${datos.ext} </td> 
            </tr> 
            <tr> 
                <td>Num. Int.</td> 
                <td>${datos.int}</td> 
            </tr> 
            <tr> 
                <td>Colonia.</td> 
                <td>${datos.col}</td> 
            </tr>
            <tr> 
                <td>C.P.</td> 
                <td>${datos.cp}</td> 
            </tr>  
        </table>`;
    };

    modulo.clickAgregar = function(e) {
        e.preventDefault();
        me = $(this);
        mostrarFormulario({});
    };

    var mostrarFormulario = $params => {
        $util.load.show(true);
        $util.post({
            url: "UnidadResponsable",
            metodo:"vistaForm",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {                    
                    $('.content-modal').html(data.vista);
                    $('#jq_modal_ur').modal('show');
                }            
            }
        });
    };

    return modulo;
})($ur || {});

$(function() {    
    $ur.ini();
    $('.jq_nueva_ur').off('click').on('click', $ur.clickAgregar);
});