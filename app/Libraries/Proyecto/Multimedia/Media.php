<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;

abstract class Media
{
    protected $encrypter; 
    protected $usuario;

    use CifradoTrait;

    abstract public function guardar($request, CProyecto $proyecto, $archivo);
}
