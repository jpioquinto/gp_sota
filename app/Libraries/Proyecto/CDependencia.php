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