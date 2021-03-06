<?php 
namespace App\Libraries\Perfil;
use App\Traits\AccionesTrait;
use App\Models\{PerfilQuery};

use  App\Libraries\Usuario;

use Carbon\{Carbon};
use DateTime;
use DateTimeZone;

class GestionPerfil
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
        Carbon::setLocale('es');   
	}

    public function obtenerArbolPermiso($perfilId)
    {   
        $arbol = new ArbolPermiso($perfilId);

        return $arbol->generarArbol();
    }

    public function obtenerListado()
    {                      
        $sHtml = '';
        foreach ($this->obtenerPerfiles() as $value) {
            $sHtml .= $this->generarFila($value);
        }
        return $sHtml;
    }

    protected function obtenerPerfiles()
    {
        $perfilModel = new PerfilQuery();

        return $perfilModel->listarPerfiles();
    }  

    protected function generarFila($perfil)
    {
        $creado =  new Carbon(new DateTime($perfil['creado_el']), new DateTimeZone('America/Mexico_City'));
        $fila = sprintf(
                "<tr data-id='%s'><td data-nombre='true'>%s</td><td data-descripcion='true'>%s</td><td data-estatus='%d'>%s</td>",
                base64_encode($this->encrypter->encrypt($perfil['id'])), $perfil['nombre'], $perfil['descripcion'], 
                $perfil['estatus'], $this->descripcionEstatus($perfil['estatus'])
            );
        return $fila .= sprintf(
                "<td>%s</td><td>%s</td><td class='text-center'>%s</td></tr>",
                $creado->format('d/m/Y H:i:s'), $perfil['nickname'], $this->obtenerAcciones($perfil['estatus'])
            );
    }

    protected function descripcionEstatus($estatus)
    {
        if ($estatus!=2) {
            return '<span class="badge badge-dark">Activo</span>';
        }
        return '<span class="badge badge-warning">Inactivo</span>';
    }

    protected function obtenerAccionesModulo($estatus)
    {
        $acciones = $this->obtenerAccion(2, $estatus);
        return $acciones.= $this->obtenerAccion(5, $estatus);
    }

    protected function obtenerVistaAcciones()
    {
        return [2=>'_v_btn_editar', 5=>'_v_btn_habilita'];
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
        return 'perfil/parcial/';
    }  
}
