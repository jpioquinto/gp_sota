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
            select: true,
            responsive: true,
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
        eventosTabla();
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

    modulo.mostrarDetalle = datos => {//console.log(datos);
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

    modulo.clickEliminarUR = function(e) {
        e.preventDefault();
        if ($(this).parents('tr').attr('data-id').length==0) {
            return;
        }
        me = $(this);
        swal({
            title: '¿Estás seguro(a)?',
            text: "Se eliminará la UR, si contiene usuarios asignados no podrán ingresar.",
            //type: 'warning',
            buttons:{
                confirm: {
                    text : 'Aceptar',
                    className : 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Aceptar) => {
            if (Aceptar) {
                eliminar({id:me.parents('tr').attr('data-id')});
            } else {
                swal.close();
            }
        });
    };

    modulo.clickEditarUR = function(e) {
        e.preventDefault();
        
        if ($(this).parents('tr').attr('data-id').length==0) {
            return;
        }
        
        me = $(this);
        console.log(tabla.row(me.parents('tr').index()).data());
        mostrarFormulario({id:me.parents('tr').attr('data-id')});
    };

    modulo.actualizarTR = $datos => {
        var $actual = Object.assign(tabla.row(me.parents('tr').index()).data(), $datos);
        tabla.row(me.parents('tr').index()).data($actual).draw();
        eventosTabla();
    };

    modulo.agregarFila = $datos => {
        var $ultima = tabla.row($('#jq_listado_urs tbody tr:last').index()).data();

        if (!$datos.hasOwnProperty('id')) {
            return;
        }

        $datos['acciones'] = $ultima.acciones;
        $datos['estatus'] = $ultima.estatus;
        tabla.row.add($datos).draw();
        
        setTimeout(()=>{
            $('#jq_listado_urs tbody tr:last').attr('data-id', $datos.id);
            eventosTabla();
        }, 3500);
    };

    var eliminar = ($params) => {        
        $util.load.show(true);
        $util.post({
            url: "UnidadResponsable",
            metodo:"eliminar",
            datos:$params,
            funcion: function(data){
                $util.load.hide();
                if (data.Solicitud) {                    
                    me.parents('tr').remove();
                }            
            }
        });
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

    var eventosTabla = () => {
        $('#jq_listado_urs').find('[data-toggle="tooltip"]').tooltip();    
        $('#jq_listado_urs tbody tr .details-control').off('click').on('click', modulo.clickVerDetalle);        
        $('#jq_listado_urs tbody tr .jq_editar_ur').off('click').on('click', modulo.clickEditarUR);
        $('#jq_listado_urs tbody tr .jq_eliminar_ur').off('click').on('click', modulo.clickEliminarUR);
    };

    return modulo;
})($ur || {});

$(function() {    
    $ur.ini();
    $('.jq_nueva_ur').off('click').on('click', $ur.clickAgregar);
});