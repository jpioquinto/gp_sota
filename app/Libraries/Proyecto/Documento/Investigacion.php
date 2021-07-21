<?php 
namespace App\Libraries\Proyecto\Documento;

class Investigacion extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_investigacion',
            [
                '_v_conjunto_datos'=>$this->vistaConjuntoDatos(),
                '_v_pais_idioma'=>$this->vistaPaisIdioma(),
                '_v_nombre_doc'=>$this->vistaNombreDoc(),
            ]
        );

    }
}
