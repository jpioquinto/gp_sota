<?php 
namespace App\Libraries\Proyecto;

use App\Libraries\Proyecto\Seguimiento\Semaforo\{Semaforo, Vigencia, Avance, Estatus};
use App\Models\{AccionEspecificaModel, AccionEspecificaQuery, CriticidadModel};
use App\Traits\{CifradoTrait};
use App\Libraries\Usuario;


class UIAccionParticular
{	
	protected $accionModel;	
    protected $criticidad;
    protected $accion_id;
    protected $encrypter; 
    protected $usuario;

    use CifradoTrait;

    #use PermisoTrait;
	
	public function __construct($accion_id = 0)
	{		 
        $this->encrypter = \Config\Services::encrypter();
        $this->accionModel = new AccionEspecificaModel(); 
        $this->usuario = new Usuario();        
        $this->accion_id = $accion_id;
        $this->criticidad = $this->obtenMatrizCriticidad();
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
            
            $avance = ($val['evidencia']==1 && $val['validado']==0) 
                    ? "<span class='badge badge-danger'>{$val['avance']}</span>" 
                    : "<span class='badge badge-light'>{$val['avance']}</span>";
            
            if (!$ini) {
                $ini = true;
                $html .= sprintf(
                    "<tr id='%s'><td rowspan='%s'>%s</td><td>%s</td><td>%s</td>", 
                    base64_encode($this->encriptar($val['id'])), count($subacciones), $accion['definicion'], $this->vistaIndicadores($val), $val['definicion']
                );                
                $html .= sprintf(
                    "<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", 
                    $val['programa'], $val['sigla'], $val['fecha_ini'], $val['fecha_fin']
                );
                $html .= sprintf(
                    "<td>%s</td><td data-avance='true'>%s</td><td>%s</td></tr>", 
                    $val['meta'], $avance, $accionPermitida
                );
                continue;
            }
            $html .= $this->generaCelda($val, $avance, $accionPermitida);
        }
        return $html;
    }

    public function generaCelda($val, $avance, $accionPermitida)
    {
        
        $html = sprintf(
            "<tr id='%s'><td>%s</td><td>%s</td>", 
            base64_encode($this->encriptar($val['id'])), $this->vistaIndicadores($val), $val['definicion']
        );
        $html .= sprintf(
            "<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", 
            $val['programa'], $val['sigla'], $val['fecha_ini'], $val['fecha_fin']
        );
        return $html .= sprintf(
            "<td>%s</td><td data-avance='true'>%s</td><td>%s</td></tr>",
            $val['meta'], $avance, $accionPermitida
        );
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
        $accion['id'] = base64_encode( $this->encriptar($accion['id']) );
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

    protected function vistaIndicadores($accion)
    {
        $iTiempo  = new Semaforo($tiempo = new Vigencia($accion['fecha_ini'], $accion['fecha_fin']));
        $iAvance  = new Semaforo($avance = new Avance($accion['id'], $accion['evidencia']));
        $iEstatus = new Semaforo(new Estatus($tiempo->getPorcentaje(), $avance->getPorcentaje(), $this->criticidad));

        return "<div class='d-flex indicador-accion'>".$iTiempo->getIcono().$iAvance->getIcono().$iEstatus->getIcono()."</div>";
    }

    protected function obtenMatrizCriticidad()
    {
        $criticidadModel = new CriticidadModel();

        return $criticidadModel->findAll() ?? [];
    }
}
