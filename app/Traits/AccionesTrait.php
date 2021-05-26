<?php
namespace App\Traits;

trait AccionesTrait
{
    protected function obtenerAcciones($estatus)
    {
        $acciones = '<div class="form-button-action">';
        $acciones.=$this->obtenerAccionesModulo($estatus);
        return $acciones.= '</div>';
    }

    protected function obtenerAccion($accion, $estatus)
    {
        $botones = $this->obtenerVistaAcciones();

        if (!isset( $botones[$accion] )) {
            return '';
        }
        
        return $this->usuario->tienePermiso($this->controlador, $accion)!==FALSE 
        ? view($this->vistaRelativaAcciones().$botones[$accion],  $this->infoAccion($accion, $estatus)) : '';
    }

}
