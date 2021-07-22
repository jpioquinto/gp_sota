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
                '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(), 'conjuntoDatos'=>$this->opcionesConjuntoDatos()]),
                '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(), 'idiomas'=>$this->opcionesIdiomas()]),
                '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas()]),
            ]
        );

    }
}
