<?php
namespace App\Traits;

use App\Libraries\Proyecto\UIAccionParticular;
use App\Libraries\Proyecto\CAccion;

trait AccionGenetalTrait
{
    public function cambioOrden($oldAccion, $newAccion)
    {
        if (!$oldAccion || !isset($oldAccion['orden']) || !isset($newAccion['orden'])) {
            return false;
        }

        return $oldAccion['orden']!=$newAccion['orden'];
    }

    public function cambioPonderacion($oldAccion, $newAccion)
    {
        if (!$oldAccion || !isset($oldAccion['ponderacion']) || !isset($newAccion['ponderacion'])) {
            return false;
        }

        return $oldAccion['ponderacion']!=$newAccion['ponderacion'];
    }
    
}
