<?php 
namespace App\Libraries\Proyecto\Documento;

class Gestor
{    
    protected $doc;
    
    public function __construct(Documento $doc)
    {             
        $this->doc = $doc;
    }

    public function guardar($datos, $archivo)
    {
        return $this->doc->guardar($datos, $archivo);
    }

    public function actualizar($datos)
    {
        return $this->doc->actualizar($datos);
    }

    public function eliminar($id)
    {
        return $this->doc->eliminar($id);
    }

    public function vista($id=null)
    {
        return $this->doc->vistaForm($id);
    }
}
