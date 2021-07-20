<?php 
namespace App\Libraries\Proyecto;
use App\Models\AccionGeneralModel;
#use App\Traits\PermisoTrait;
use App\Libraries\Usuario;


class UIAccion
{	
	protected $accionModel;	
    protected $proyectoId;
    protected $encrypter; 
    protected $usuario;

    #use PermisoTrait;
	
	public function __construct($proyectoId = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionGeneralModel();
        $this->usuario = new Usuario();        
        $this->proyectoId = $proyectoId;
	}

    public function getProyectoId()
    {
        return $this->proyectoId;
    }

    public function tablaAcciones()
    {
        $html = '';
        foreach ($this->consultarAcciones() as $key => $accion) {
            $uiAccionParticular = new UIAccionParticular($accion['id']);
            $html .= $uiAccionParticular->generarFila($accion);
        }
        return $html;
    }

    public function listadoAcciones()
    {
        $html = '<div class="accordion-acciones" id="accordion-acciones">';
        foreach ($this->consultarAcciones() as $key => $accion) {
            $html .= $this->generaHTMLAccion($accion, ($key+1), $key==0);
        }
        return $html.'</div>';
    }

    public function generaHTMLAccion($accion, $posicion=1, $first=false)
    {
        $uiAccionParticular = new UIAccionParticular($accion['id']);
        $accion['id'] = base64_encode( $this->encrypter->encrypt($accion['id']) );
        $accion['posicion'] = $posicion;
        $accion['first'] = $first;
        
        return view(
            'proyectos/parcial/_v_card_accion', 
            array_merge($accion, ['subacciones'=>$uiAccionParticular->listadoAcciones(), 'permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')])
        );
    }

    public function consultarAcciones()
    {
        return  $this->accionModel
                    ->where(['proyecto_id'=>$this->getProyectoId(), 'estatus'=>1])
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }

    public function headerTitle()
    {
        return '<a href="javascript:;" class="btn btn-warning btn-round jq_regresar_submodulo">
                    <span class="btn-label">
                        <i class="fa fa-undo"></i>
                    </span>
                    Regresar
                </a>';
    }
}
