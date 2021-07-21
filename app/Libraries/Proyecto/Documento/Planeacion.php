<?php 
namespace App\Libraries\Proyecto\Documento;

class Planeacion extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_planeacion', 
            [
                '_v_nombre_doc'=>$this->vistaNombreDoc(),
            ]
        );

    }
}
