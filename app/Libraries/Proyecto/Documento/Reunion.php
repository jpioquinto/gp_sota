<?php 
namespace App\Libraries\Proyecto\Documento;

class Reunion extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_reunion', 
            [
                '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(), 'conjuntoDatos'=>$this->opcionesConjuntoDatos()]),
                'entidadesAPF'=>$this->opcionesEntidadesAPF(),
                'tipos'=>$this->opcionesCategoriaProyecto(), 
                'paises'=>$this->opcionesPaises(),
            ]
        );

    }
}
