<?php
namespace App\Traits;
use App\Models\FuncionalidadAccionModel;

trait AccesoRapidoTrait
{
    public function vistaAcciones($controlador, $accion=24)
    {
        $this->permisos = $this->usuario->permisos;
        if (!$this->tienePermiso($controlador, $accion)) {
            return '';
        }
        $this->accionModel = new FuncionalidadAccionModel();
        $metodo = [24=>'vistaAccesosRapido'];

        return $this->{$metodo[$accion]}($this->obtenerPermisosModulo($controlador));
    }

    public function vistaAccesosRapido($acciones)
    {
        $html = '';
        foreach ($acciones as $accion) {
            if ($accion['tipo']!=2) {
                continue;
            }
            $html .= "<a class='col-6 col-md-4 p-0 jq_acceso_rapido' href='' onClick='return false;' data-control='{$this->obtenerControlador($accion['id'])}'>
                        <div class='quick-actions-item'>
                            <i class='{$accion['icono']}'></i>
                            <span class='text'>{$accion['descripcion']}</span>
                        </div>
                    </a>";
        }

        return $html!='' ? view('layout/parcial/_v_accesos_rapidos', ['v_acciones'=>$html]) : '';
    }

    public function obtenerControlador($accionId)
    {        
        $accion = $this->accionModel->where('accion_id', $accionId)->first();
        return isset($accion['controlador']) ? $accion['controlador'] : '';
    }

}
