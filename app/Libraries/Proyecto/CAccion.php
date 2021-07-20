<?php 
namespace App\Libraries\Proyecto;

use App\Models\{AccionGeneralModel, AccionEspecificaModel};
use App\Libraries\Usuario;


class CAccion
{	
    protected $subAccionModel;
	protected $accionModel;	
    protected $encrypter; 
    protected $usuario;
    protected $accion;
    protected $id;

    #use PermisoTrait;
	
	public function __construct($id = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionGeneralModel();
        $this->subAccionModel = new AccionEspecificaModel();
        $this->accion = $this->accionModel->find($id) ?? [];
        $this->usuario = new Usuario();        
        $this->id = $id;
	}

    public function getId()
    {
        return $this->id;
    }

    public function getCoordinadorId()
    {
        return isset($this->accion['coordinador_id']) ? $this->accion['coordinador_id'] : 0;
    }

    public function getProyectoId()
    {
        return isset($this->accion['proyecto_id']) ? $this->accion['proyecto_id'] : 0;
    }

    public function obtenerAccion()
    {
        return $this->accion;#$this->accionModel->find($this->getId()) ?? [];
    }

    public function obtenerPonderacion()
    {
        #$accion = $this->accionModel->find($this->getId());
        return isset($this->accion['ponderacion']) ? $this->accion['ponderacion'] : 0;
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

    public function obtenerSubAcciones($id=null)
    {   $condicion = ['accion_id'=> $this->getId()];

        if ($id) {
            $condicion['id'] = $id;
        }
        
        return $this->subAccionModel->where($condicion)->orderBy('fecha_ini', 'ASC')->findAll() ?? [];
    }
}
