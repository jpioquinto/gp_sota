<?php 
namespace App\Libraries\Proyecto;
use App\Models\AccionGeneralModel;


class UIAccion
{	
	protected $accionModel;	
    protected $proyectoId;
    protected $encrypter; 
	
	public function __construct($proyectoId = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionGeneralModel();        
        $this->proyectoId = $proyectoId;
	}

    public function getProyectoId()
    {
        return $this->proyectoId;
    }

    public function listadoAcciones()
    {
        $html = '<div class="accordion-acciones" id="accordion-acciones">';
        foreach ($this->consultarAcciones() as $key => $accion) {
            $html .= $this->generaHTMLAccion($accion, $key==0);
        }
        return $html.'</div>';
    }

    public function generaHTMLAccion($accion, $first=false)
    {
        $accion['id'] = base64_encode( $this->encrypter->encrypt($accion['id']) );
        $accion['first'] = $first;
        return view('proyectos/parcial/_v_card_accion', $accion);
    }

    public function consultarAcciones()
    {
        return  $this->accionModel
                    ->where(['proyecto_id'=>$this->getProyectoId(), 'estatus'=>1])
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
}
