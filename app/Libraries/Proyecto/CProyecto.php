<?php 
namespace App\Libraries\Proyecto;
use App\Models\ProyectoModel;
use App\Models\CatalogoModel;
use App\Models\UsuarioQuery;
use  App\Libraries\Usuario;

class CProyecto
{	
	#protected $proyectoModel;
    protected $proyecto;
    protected $id;
	#protected $usuario;	

	public function __construct($idProyecto=0)
	{
        $this->proyecto = $this->consultarProyecto($idProyecto);        
		#$this->proyectoModel = new ProyectoModel();
		#$this->usuario = new Usuario();  
        $this->id = $idProyecto;
	}

    public function getId()
    {
        return $this->id;
    }

    public function consultarProyecto($id)
    {
        $proyectoModel = new ProyectoModel();
        return $proyectoModel->find($id)??[];
    }

    public function obtenerProyecto()
    {       
        return $this->proyecto;
    }
}