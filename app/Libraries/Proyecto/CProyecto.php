<?php 
namespace App\Libraries\Proyecto;
use App\Models\ProyectoModel;

class CProyecto
{	
    public $dependencia;
    protected $proyecto;
    protected $id;	

	public function __construct($idProyecto=0)
	{
        $this->proyecto = $this->consultarProyecto($idProyecto);
        $this->dependencia = new CDependencia($this->getOrganizacionId());         
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

    public function getAlias()
    {
        return isset($this->proyecto['alias']) ? $this->proyecto['alias'] : '';
    }

    public function getAnio()
    {
        return isset($this->proyecto['fecha_incorporacion']) ? substr($this->proyecto['fecha_incorporacion'], 0, 4) : '';
    }

    public function getOrganizacionId()
    {
        return isset($this->proyecto['organizacion_id']) ? $this->proyecto['organizacion_id'] : 0;
    }

    public function getResponsableId()
    {
        return isset($this->proyecto['responsable_id']) ? $this->proyecto['responsable_id'] : 0;
    }

    public function getCoordinadorId()
    {
        return isset($this->proyecto['coordinador_id']) ? $this->proyecto['coordinador_id'] : 0;
    }

    public function getCarpeta()
    {
        return $this->dependencia->getCarpeta();
    }

    public function actualizaProyecto($campos)
    {
        if (!isset($campos['id'])) {
            return false;
        }
        $proyectoModel = new ProyectoModel();
        return $proyectoModel->save($campos);
    }

    public function opcionesPalabrasClave($palabras)
    {
        return $this->listadoPalabras($palabras);  
    }

    public function listadoPalabras($palabras)
    {
        $palabras = explode(' ', $palabras);
        $listado  = "";

        foreach ($palabras as $palabra) {
            $listado .= sprintf("<option value='%s' selected>%s</option>", $palabra, $palabra);
        }

        return $listado;
    }
}
