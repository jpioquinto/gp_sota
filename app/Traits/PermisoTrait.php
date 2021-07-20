<?php
namespace App\Traits;
use App\Models\{ModuloModel, FuncionalidadAccionModel};

trait PermisoTrait
{
    public function obtenerAccionesModulo($controlador)
    {
        helper('util');
        $moduloModel = new ModuloModel();
        $funcionalidadModel = new FuncionalidadAccionModel();
        
        $modulo = $moduloModel->where('controlador', getNameClass($controlador))->first();

        if (!isset($modulo['acciones'])) {
            return [];
        }

        $listado = $this->obtenerPermisosModulo($controlador);

        $funciondalidad = $funcionalidadModel->whereIn('accion_id', explode(',', $modulo['acciones']))->findAll() ?? [];

        #$listado = [];
        foreach ($funciondalidad as $value) {
            $listado[$value['accion_id']] = $value;
        }
        
        return $listado;
    }

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

    public function obtenerPermisosModulo($controlador)
    {
        helper('util');
        $permisos = [];
        foreach ($this->permisos as $permiso) {
            if (getNameClass($controlador)!==$permiso['controlador']) {
                continue;
            }
            if (!is_array($permiso['acciones'])) {
                continue;
            }    
            $permisos = $this->procesarAcciones($permiso['acciones']);        
        }
        return $permisos;
    }

    public function procesarAcciones($acciones)
    {
        $listado = [];
        foreach ($acciones as $accion) {
            $listado[$accion['id']] = $accion;
        }
        return $listado;
    }

}
