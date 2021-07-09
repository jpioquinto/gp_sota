<?php 
namespace App\Libraries\Proyecto;

use App\Models\{AccionEspecificaModel, AccionEspecificaQuery};
use App\Traits\PermisoTrait;
use App\Libraries\Usuario;


class UIAccionParticular
{	
	protected $accionModel;	
    protected $accion_id;
    protected $encrypter; 
    protected $usuario;

    use PermisoTrait;
	
	public function __construct($accion_id = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionEspecificaModel(); 
        $this->usuario = new Usuario();        
        $this->accion_id = $accion_id;
	}

    public function getAccionId()
    {
        return $this->accion_id;
    }

    public function generarFila($accion)
    {
        $subacciones = $this->consulta();
        $html = ''; $ini = false;
        foreach ($subacciones as $key=>$val) {
            $accionPermitida = view(
                'proyectos/seguimiento/parcial/_v_acciones_tabla', 
                ['permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto'), 'evidencia'=>$val['evidencia']]
            );
            if (!$ini) {
                $ini = true;
                $html .= sprintf("<tr id='%s'><td rowspan='%s'>%s</td><td>%s</td>", base64_encode($this->encrypter->encrypt($val['id'])), count($subacciones), $accion['definicion'], $val['definicion']);                
                $html .= sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $val['programa'], $val['sigla'], $val['fecha_ini'], $val['fecha_fin']);
                $html .= sprintf("<td>%s</td><td data-avance='true'>%s</td><td>%s</td></tr>", $val['meta'], $val['avance'], $accionPermitida);
                continue;
            }
            $html .= sprintf("<tr id='%s'><td>%s</td>", base64_encode($this->encrypter->encrypt($val['id'])), $val['definicion']);
            $html .= sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $val['programa'], $val['sigla'], $val['fecha_ini'], $val['fecha_fin']);
            $html .= sprintf("<td>%s</td><td data-avance='true'>%s</td><td>%s</td></tr>", $val['meta'], $val['avance'], $accionPermitida);
        }
        return $html;
    }

    public function listadoAcciones()
    {
        $html = '<ol class="listado-subacciones">';
        foreach ($this->consultarAcciones() as $key => $accion) {
            $html .= '<li>' . $this->generaHTMLAccion($accion, $key==0) . '</li>';
        }
        return $html.'</ol>';
    }

    public function generaHTMLAccion($accion, $first=false)
    {
        $accion['id'] = base64_encode( $this->encrypter->encrypt($accion['id']) );
        $accion['first'] = $first;
        return view('proyectos/parcial/_v_subaccion', array_merge($accion, ['permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')]));
    }

    public function consultarAcciones()
    {
        return  $this->accionModel
                    ->where(['accion_id'=>$this->getAccionId(), 'estatus'=>1])
                    ->orderBy('fecha_ini', 'ASC')
                    ->findAll();
    }

    public function consulta()
    {
        $accionQuery = new AccionEspecificaQuery();

        return $accionQuery->listarAcciones($this->getAccionId());
    }
}
