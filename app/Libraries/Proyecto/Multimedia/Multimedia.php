<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;

class Multimedia
{    
    protected $media;
    
    public function __construct(Media $media)
    {             
        $this->media = $media;
    }

    public function guardar($request,  CProyecto $proyecto, $archivo)
    {
        return $this->media->guardar($request, $proyecto, $archivo);
    }
}
