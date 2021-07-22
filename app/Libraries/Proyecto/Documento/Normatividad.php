<?php 
namespace App\Libraries\Proyecto\Documento;

class Normatividad extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_normatividad',
            [                
                '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(), 'idiomas'=>$this->opcionesIdiomas()]),
                '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas()]),
                'clasificaciones'=>$this->opcionesClasificaciones(),                 
                'instituciones'=>$this->opcionesInstituciones(),
                'entidadesAPF'=>$this->opcionesEntidadesAPF(),
                'tipos'=>$this->opcionesCategoriaProyecto(), 
            ]
        );

    }
}
