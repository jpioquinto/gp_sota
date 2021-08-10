<?php 
namespace App\Libraries\Usuario;
use App\Models\{UsuarioQuery};
use App\Traits\AccionesTrait;
use  App\Libraries\Usuario;

use Carbon\{Carbon};
use DateTime;
use DateTimeZone;

class GestionUsuario
{	
    use AccionesTrait;

	protected $usuario;	
    protected $encrypter;
    protected $controlador;

	public function __construct($controlador='')
	{
		$this->usuario = new Usuario();
        $this->encrypter = \Config\Services::encrypter(); 
        $this->controlador = $controlador;
        Carbon::setLocale('es');        
	}

    public function obtenerListado()
    {                      
        $sHtml = '';
        foreach ($this->obtenerUsuarios() as $value) {
            $sHtml .= $this->generarFila($value);
        }
        return $sHtml;
    }

    protected function generarFila($usuario)
    {
        $fila = sprintf(
            "<tr data-id='%s'><td>%s</td><td>%s</td><td data-perfil='true'>%s</td>",
            base64_encode($this->encrypter->encrypt($usuario['id'])), $usuario['sigla'], $usuario['nickname'], $usuario['perfil']
            );
        
        $creado =  new Carbon(new DateTime($usuario['creado_el']), new DateTimeZone('America/Mexico_City'));
        $ultimo =  new Carbon(new DateTime($usuario['ultimo_acceso']), new DateTimeZone('America/Mexico_City'));

        return $fila .= sprintf(
            "<td data-estatus='%d'>%s</td><td>%s</td><td>%s</td><td>%s</td><td class='text-center'>%s</td></tr>",
            $usuario['estatus'], $this->descripcionEstatus($usuario['estatus']), $creado->format('d/m/Y H:i:s'), $ultimo->format('d/m/Y H:i:s'),
            $usuario['creador'], $this->obtenerAcciones($usuario['estatus'])
            );
    }
    
    protected function obtenerUsuarios()
    {
        $userQuery = new UsuarioQuery();

        return in_array($this->usuario->getPerfilId(), [1])
                ? $userQuery->listarUsuarios( $this->usuario->getId() , null)
                : $userQuery->listarUsuarios( $this->usuario->getId() , $this->usuario->getOrganizacionId());
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
        $acciones.= $this->obtenerAccion(5, $estatus);
        $acciones.= $this->obtenerAccion(6, $estatus);
        return $acciones.= $this->obtenerAccion(7, $estatus);
    }

    protected function obtenerVistaAcciones()
    {
        return [2=>'_v_btn_editar', 5=>'_v_btn_habilita', 6=>'_v_btn_cambiar_organizacion', 7=>'_v_btn_cambiar_pass'];
    }

    protected function infoAccion($accion, $estatus)
    {
        if ($accion==5) {
            return [
                'mensaje'=>$estatus==1 ? 'Inhabilitar usuario' : 'Habilitar usuario',
                'clase'=>$estatus==1 ? 'minus-circle' : 'check-circle'
            ];
        }
        return [];
    }

    protected function vistaRelativaAcciones()
    {
        return 'usuario/parcial/';
    }
}
