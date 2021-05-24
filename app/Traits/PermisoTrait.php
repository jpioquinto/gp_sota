<?php
namespace App\Traits;

trait PermisoTrait
{
    public function tienePermiso($controlador, $accion)
    {
        helper('util');
        $tienePermiso = false;
        foreach ($this->permisos as $permiso) {
            if (getNameClass($controlador)!==$permiso['controlador']) {
                continue;
            }
            if (!is_array($permiso['acciones'])) {
                continue;
            }
            $tienePermiso = array_search($accion, array_column($permiso['acciones'], 'id'));
        }
        return $tienePermiso;
        
    }

}
