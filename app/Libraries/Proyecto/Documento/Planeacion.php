<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;

class Planeacion extends Documento
{
    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_planeacion', 
            [                
                '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas()]),
                'instituciones'=>$this->opcionesInstituciones(),
                'entidadesAPF'=>$this->opcionesEntidadesAPF(),
                'tipos'=>$this->opcionesCategoriaProyecto(),
                'paises'=>$this->opcionesPaises(),
            ]
        );

    }
}
