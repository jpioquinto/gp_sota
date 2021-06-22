<?php 
namespace App\Libraries\Proyecto;

use App\Models\{AccionGeneralModel, AccionEspecificaModel};
use App\Traits\PermisoTrait;
use App\Libraries\Usuario;


class CAccion
{	
    protected $subAccionModel;
	protected $accionModel;	
    protected $encrypter; 
    protected $usuario;
    protected $id;

    use PermisoTrait;
	
	public function __construct($id = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionGeneralModel();
        $this->subAccionModel = new AccionEspecificaModel();
        $this->usuario = new Usuario();        
        $this->id = $id;
	}

    public function getId()
    {
        return $this->id;
    }

    public function obtenerAccion()
    {
        return $this->accionModel->find($this->getId()) ?? [];
    }

    public function obtenerPonderacion()
    {
        $accion = $this->accionModel->find($this->getId());
        return isset($accion['ponderacion']) ? $accion['ponderacion'] : 0;
    }

    public function eliminarAccion()
    {        
        if (!$this->accionModel->update( $this->getId(), ['estatus'=>0] )) {
            return [
                'Solicitud'=>false, 
                'Error'=>'Error al intentar Eliminar la acción.'
            ];
        }
        
        if ((count($subacciones = $this->obtenerIdsSubAcciones()))>0) {
            $this->subAccionModel->update($subacciones, ['estatus'=>0]);
        }

        return [
            'Solicitud'=>true, 
            'Msg'=>'Acción eliminada correctamente.'
        ];
    }

    public function obtenerIdsSubAcciones()
    {        
        $subacciones = $this->subAccionModel->where('accion_id', $this->getId())->findAll() ?? [];
        $id = [];
        foreach ($subacciones as $subaccion) {
            $id[] = $subaccion['id'];
        }
        return $id;
    }

}
