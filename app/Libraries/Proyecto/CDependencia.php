<?php 
namespace App\Libraries\Proyecto;
use App\Models\DependenciaModel;

class CDependencia
{	
    public $dependencia;
    protected $id;

	public function __construct($id=0)
	{
        $this->id = $id;  
        $this->dependencia = $this->consultarDependencia();              		
	}

    public function getId()
    {
        return $this->id;
    }

    public function existe()
    {
        return isset($this->dependencia['id']);
    }

    public function estaActiva()
    {
        return ( isset($this->dependencia['estatus']) && $this->dependencia['estatus'] );
    }

    public function getCarpeta()
    {
        return isset($this->dependencia['carpeta']) ? $this->dependencia['carpeta'] : '';
    }

    public function consultarDependencia()
    {
        $dependenciaModel = new DependenciaModel();
        return $dependenciaModel->find($this->getId())??[];
    }
}