<?php 
namespace App\Libraries\Proyecto;
use App\Models\ProyectoModel;
use  App\Libraries\Usuario;

class UIProyecto
{	
	protected $proyectoModel;
	protected $uiCriterios;
	protected $encrypter;
	#protected $usuario;	

	public function __construct()
	{
		#$this->usuario = new Usuario();
		$this->encrypter = \Config\Services::encrypter();  
		$this->proyectoModel = new ProyectoModel();
		$this->uiCriterios = new UICriterios;
        
	}

	public function obtenerListado()
	{
		$items = '';
		foreach ($this->proyectoModel->findAll() as $proyecto) {
			$items .= $this->generarItemCard($proyecto);
		}
		return $items;
	}

	public function generarItemCard($proyecto)
	{
		$proyecto['id'] = base64_encode($this->encrypter->encrypt($proyecto['id']));
		return view(
			'proyectos/parcial/_v_card_proyecto',
			array_merge($proyecto, ['v_item_criterios'=>$this->uiCriterios->listadoItems()])
		);
	}
}
