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

    public function vista()
    {
        return $this->doc->vistaForm();
    }
}
