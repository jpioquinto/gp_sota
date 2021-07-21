<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\CProyecto;

class Gestor
{    
    protected $doc;
    
    public function __construct(Documento $doc)
    {             
        $this->doc = $doc;
    }

    public function guardar($request,  CProyecto $proyecto, $archivo)
    {
        return $this->doc->guardar($request, $proyecto, $archivo);
    }

    public function vista()
    {
        return $this->doc->vistaForm();
    }
}
