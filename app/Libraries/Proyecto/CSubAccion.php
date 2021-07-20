<?php 
namespace App\Libraries\Proyecto;

use App\Models\{AccionEspecificaModel, AccionQuery};
#use App\Traits\PermisoTrait;
use App\Libraries\Usuario;


class CSubAccion
{	
    protected $subAccionModel;	
    protected $encrypter; 
    protected $usuario;
    protected $id;

    #use PermisoTrait;
	
	public function __construct($id = 0)
	{		 
        $this->subAccionModel = new AccionEspecificaModel();
        $this->encrypter = \Config\Services::encrypter();
        $this->usuario = new Usuario();        
        $this->id = $id;
	}

    public function getId()
    {
        return $this->id;
    }

    public function obtenerSubAccion()
    {
        return $this->subAccionModel->find($this->getId()) ?? [];
    }

    public function obtenerPonderacion()
    {
        $accion = $this->subAccionModel->find($this->getId());
        return isset($accion['ponderacion']) ? $accion['ponderacion'] : 0;
    }

    public function eliminarAccion()
    {        
        if (!$this->subAccionModel->update( $this->getId(), ['estatus'=>0] )) {
            return [
                'Solicitud'=>false, 
                'Error'=>'Error al intentar Eliminar la acción.'
            ];
        }

        $cambio = false;
        
        if (($id = $this->obtenerIdAccionGeneral())>0) {
            $cambio = $this->reasignarPonderaciones($id);
        }
        
        return [
            'Solicitud'=>true, 
            'reasignado'=>$cambio,
            'Msg'=>'Acción eliminada correctamente.'
        ];
    }

    public function obtenerIdAccionGeneral()
    {        
        $subaccion = $this->subAccionModel->where('id', $this->getId())->first();
        
        return isset($subaccion['accion_id']) ? $subaccion['accion_id'] : 0;
    }

    public function reasignarPonderaciones($id)
    {
        $accionQuery = new AccionQuery();
        $resultado = $accionQuery->reasignarPonderaciones($id);

        return (isset($resultado[0]['total']) && $resultado[0]['total']>0 && $resultado[0]['subacciones']>0);
    }

}
