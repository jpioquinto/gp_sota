<?php 
namespace App\Libraries\Perfil;
use App\Models\{PerfilModel};
use  App\Libraries\Usuario;

class GestionPerfil
{	
	protected $usuario;	
    
    public function __construct()
	{
		$this->usuario = new Usuario();                        
	}

    public function obtenerListado()
    {                      
        $sHtml = '';
        foreach ($this->obtenerPerfiles() as $value) {
            $sHtml .= $this->generarFila($value);
        }
        return $sHtml;
    }

    protected function generarFila($perfil)
    {
        $fila = sprintf(
            "<tr data-id='%s'><td>%s</td><td>%s</td><td data-perfil='true'>%s</td>",
            base64_encode($this->encrypter->encrypt($perfil['id'])), $perfil['estado'], $perfil['nickname'], $perfil['perfil']
            );
        return $fila .= sprintf(
            "<td data-estatus='%d'>%s</td><td>%s</td><td>%s</td><td>%s</td><td class='text-center'>%s</td></tr>",
            $perfil['estatus'], $this->descripcionEstatus($perfil['estatus']), $perfil['creado_el'], $perfil['ultimo_acceso'],
            $perfil['creador'], $this->obtenerAcciones($perfil['estatus'])
            );
    }

    protected function obtenerPerfiles()
    {
        $perfilModel = new PerfilModel();

        return $perfilModel->where('estatus', 1)->findAll();
    }
    
}
