<?php 
namespace App\Libraries\Proyecto\Documento;

class Estadistica extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_estadistica', 
            [
                '_v_nombre_doc'=>$this->vistaNombreDoc(),
            ]
        );

    }
}
