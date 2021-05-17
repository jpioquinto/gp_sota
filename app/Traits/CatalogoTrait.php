<?php
namespace App\Libraries\Traits;
use App\Models\CatalogoModel;

trait CatalogoTrait
{
    public function getCatalogo($tabla, $campos='*', $estatus=null)
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo($tabla, $campos, $estatus);
    }

}
