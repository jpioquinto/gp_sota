<?php 
namespace App\Libraries\Entidad;

use App\Libraries\Validacion\ValidaUR;
use App\Models\DependenciaModel;
use App\Traits\AccionesTrait;
use  App\Libraries\Usuario;

class GestionUR
{	
    use AccionesTrait;

    protected $controlador;
    protected $encrypter;
	protected $usuario;	
    
    public function __construct($controlador='')
	{
        $this->encrypter = \Config\Services::encrypter();         
        $this->controlador = $controlador;                     
		$this->usuario = new Usuario();  
	}

    public function guardar($datos)
    {
        $validacion = new ValidaUR();
        $validar    = $validacion->esSolicitudValida($datos);

        if ($validar['Solicitud']===FALSE) {
            return $validar;
        } 
        
        $campos = [
			'nombre'=>trim($datos['nombre']),
			'sigla'=>trim($datos['sigla']),
            'carpeta'=>trim($datos['carpeta']),
            'estado_id'=>trim($datos['entidad']),
            'municipio_id'=>trim($datos['municipio']),	
		];

        if (!isset($datos['id'])) {
            $campos['creado_por'] = $this->usuario->getId();
        }

        if (isset($datos['calle']) && trim($datos['calle'])!='') {
            $campos['calle'] = trim($datos['calle']);
        }

        if (isset($datos['ext']) && trim($datos['ext'])!='') {
            $campos['ext'] = trim($datos['ext']);
        }

        if (isset($datos['int']) && trim($datos['int'])!='') {
            $campos['int'] = trim($datos['int']);
        }

        if (isset($datos['col']) && trim($datos['col'])!='') {
            $campos['col'] = trim($datos['col']);
        }

        if (isset($datos['cp']) && trim($datos['cp'])!='') {
            $campos['cp'] = trim($datos['cp']);
        }

        $urModel = new DependenciaModel();
         
        if (!$urModel->insert($campos)) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar crear la Unidad Responsable.'];
        }

        return ['Solicitud'=>true, 'Msg'=>'Unidad Responsable creada correctamente.'];
    }

    public function obtenerListado()
    {                      
        $sHtml = '';
        foreach ($this->obtenerURs() as $value) {
            $sHtml .= $this->generarFila($value);
        }
        return $sHtml;
    }

    protected function obtenerURs()
    {
        $urModel = new DependenciaModel();

        return $urModel->listarURs();
    }  

    protected function generarFila($ur)
    {
        $fila = sprintf(
                "<tr data-id='%s'><td></td><td data-nombre='true'>%s</td><td data-sigla='true'>%s</td><td data-estatus='%d'>%s</td>",
                base64_encode($this->encrypter->encrypt($ur['id'])), $ur['nombre'], $ur['sigla'], $ur['estatus'], $this->descripcionEstatus($ur['estatus'])
            );
        $fila.= sprintf(
                "<td data-carpeta='true'>%s</td><td data-calle='true'>%s</td><td data-ext='true'>%s</td><td data-int='true'>%s</td><td data-col='true'>%s</td>",
                $ur['carpeta'], $ur['calle'], $ur['ext'], $ur['int'], $ur['col']
            );
        return $fila .= sprintf(
                "<td data-cp='true'>%s</td><td data-estado='true'>%s</td><td data-municipio='true'>%s</td><td>%s</td></tr>",
                $ur['cp'], $ur['estado'], $ur['municipio'], $this->obtenerAcciones($ur['estatus'])
            );
    }

    protected function descripcionEstatus($estatus)
    {
        if ($estatus!=2) {
            return '<span class="badge badge-dark">Activa</span>';
        }
        return '<span class="badge badge-warning">Inactiva</span>';
    }

    protected function obtenerAccionesModulo($estatus)
    {
        $acciones = $this->obtenerAccion(2, $estatus);
        return $acciones.= $this->obtenerAccion(3, $estatus);
    }

    protected function obtenerVistaAcciones()
    {
        return [2=>'_v_btn_editar', 3=>'_v_btn_eliminar'];
    }

    protected function infoAccion($accion, $estatus)
    {
        if ($accion==5) {
            return [
                'mensaje'=>$estatus==1 ? 'Inhabilitar perfil' : 'Habilitar perfil',
                'clase'=>$estatus==1 ? 'minus-circle' : 'check-circle'
            ];
        }
        return [];
    }

    protected function vistaRelativaAcciones()
    {
        return 'ur/parcial/';
    }  
}
