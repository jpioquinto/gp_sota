var $formPerfil = (modulo=>{
    var perfiId;

    modulo.ini = id => {
        perfiId = id;
        //$util.load.show(true);
        $util.post({
            url: "PerfilUsuario",
            metodo:"obtenerModulos",
            datos:{id:perfiId},
            funcion: function(data){
                //$util.load.hide();
                if (data.Solicitud) {
                    
                    $('#jq_arbol_modulos').jstree({ 'core' : {
                        'data' : data.arbol
                        },
                        "plugins" : [ "checkbox" ]
                    });
                }            
            }
        });

    };

    return modulo;
})($formPerfil || {});