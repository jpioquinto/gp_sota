<?php 
namespace App\Libraries\Entidad;
use App\Models\{DependenciaModel};
use  App\Libraries\Usuario;

class Dependencia
{	
	protected $usuario;	

	public function __construct()
	{
		$this->usuario = new Usuario();
        
	}

    public function obtenerListado()
    {
        $dependenciaModel = new DependenciaModel();
        $listado = $dependenciaModel->where('estatus', 1)->findAll();
        
        if (!is_array($listado)) {
            return [];
        }

        $registros = [];
        foreach ($listado as $dependencia) {
            $registros[] = ['id'=>$dependencia['id'], 'text'=>$dependencia['nombre']];
        }
        return $registros;
    }
}
