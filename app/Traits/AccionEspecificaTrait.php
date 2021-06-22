<?php
namespace App\Traits;

use App\Libraries\Proyecto\UIAccionParticular;
use App\Libraries\Proyecto\CSubAccion;

trait AccionEspecificaTrait
{
    public function asignarPonderacion($id)
    {
        $accion = new CSubAccion($id);

        $accion->reasignarPonderaciones($accion->obtenerIdAccionGeneral());

        return $accion->obtenerPonderacion();
    }

    public function vistaListadoSubAccion($accionId)
    {
        $uiSubAccion = new UIAccionParticular($accionId);
        return $uiSubAccion->listadoAcciones();
    }

    public function vistaItemSubAccion($id)
    {
        $accion = new CSubAccion($id);
        $uiSubAccion = new UIAccionParticular();
        return '<li>' . $uiSubAccion->generaHTMLAccion($accion->obtenerSubAccion()) . '</li>';
    }

}
