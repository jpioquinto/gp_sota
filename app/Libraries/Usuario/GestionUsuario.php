<?php 
namespace App\Libraries\Usuario;
use App\Models\{UsuarioQuery};
use  App\Libraries\Usuario;

class GestionUsuario
{	
	protected $usuario;	
    protected $encrypter;
    protected $controlador;

	public function __construct($controlador='')
	{
		$this->usuario = new Usuario();
        $this->encrypter = \Config\Services::encrypter(); 
        $this->controlador = $controlador;
        
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
            base64_encode($this->encrypter->encrypt($usuario['id'])), $usuario['estado'], $usuario['nickname'], $usuario['perfil']
            );
        return $fila .= sprintf(
            "<td data-estatus='%d'>%s</td><td>%s</td><td>%s</td><td>%s</td><td class='text-center'>%s</td></tr>",
            $usuario['estatus'], $this->descripcionEstatus($usuario['estatus']), $usuario['creado_el'], $usuario['ultimo_acceso'],
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

    protected function obtenerAcciones($estatus)
    {
        $acciones = '<div class="form-button-action">';
        $acciones.= $this->obtenerAccion(2, $estatus);
        $acciones.= $this->obtenerAccion(5, $estatus);
        $acciones.= $this->obtenerAccion(6, $estatus);
        $acciones.= $this->obtenerAccion(7, $estatus);
        return $acciones.= '</div>';
    }

    protected function obtenerAccion($accion, $estatus)
    {
        $botones = [2=>'_v_btn_editar', 5=>'_v_btn_habilita', 6=>'_v_btn_cambiar_organizacion', 7=>'_v_btn_cambiar_pass'];
        if (!isset( $botones[$accion] )) {
            return '';
        }
        $datos = [];
        if ($accion==5) {
            $datos = [
                'mensaje'=>$estatus==1 ? 'Inhabilitar usuario' : 'Habilitar usuario',
                'clase'=>$estatus==1 ? 'minus-circle' : 'check-circle'
            ];

        }
        return $this->usuario->tienePermiso($this->controlador, $accion)!==FALSE ? view('usuario/parcial/'.$botones[$accion], $datos) : '';
    }
}
