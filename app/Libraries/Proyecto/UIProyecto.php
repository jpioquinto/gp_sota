<?php 
namespace App\Libraries\Proyecto;
use App\Models\ProyectoModel;
use App\Models\CatalogoModel;
use App\Models\UsuarioQuery;
#use  App\Libraries\Usuario;

class UIProyecto
{	
	protected $proyectoModel;
	protected $uiSubmodulos;
	protected $encrypter;
	#protected $usuario;
	
	public function __construct()
	{
		#$this->usuario = new Usuario();
		$this->encrypter = \Config\Services::encrypter();  
		$this->proyectoModel = new ProyectoModel();
		$this->uiSubmodulos = new UIModulos;
		helper('text');
        
	}

	public function obtenerSubModulos()
	{
		return view('proyectos/parcial/_v_modulos', $this->uiSubmodulos->listadoSubmodulos());
	}

	public function obtenerListado()
	{
		$items = '';
		$proyectos = $this->proyectoModel->orderBy('alias', 'ASC')->findAll() ?? [];
		foreach ($proyectos as $proyecto) {
			$items .= $this->generarItemCard($proyecto);
		}
		return $items;
	}

	public function generarItemCard($proyecto)
	{
		$proyecto['id'] = base64_encode($this->encrypter->encrypt($proyecto['id']));
		
		if (isset($proyecto['imagen']) && trim($proyecto['imagen'])!='') {
			$proyecto['imagen'] .= "?hash=".random_string('alnum', 16);
		}
		
		return view(
			'proyectos/parcial/_v_card_proyecto',
			array_merge($proyecto, ['v_item_criterios'=>''])
		);
	}

	public function listadoTipos($idTipo=null)
	{
		$strHtml = '<option value=0></option>';
		foreach ($this->getCatalogo('cat_tipo_proyectos', '*', 1) as $registro) {
			$seleccionar = $idTipo==$registro['id'] ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['descripcion']);
		}
		return $strHtml;
	}

	public function listadoCoberturas($idCobertura=null)
	{
		$strHtml = '<option value=0></option>';
		foreach ($this->getCatalogo('cat_coberturas', '*', 1) as $registro) {
			$seleccionar = $idCobertura==$registro['id'] ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['descripcion']);
		}
		return $strHtml;
	}

	public function listadoUsuarios($idOrganizacion, $idUsuario=null)
	{
		$listado = $idUsuario ? explode(',', $idUsuario) : [];
		$strHtml = '<option value=0></option>';
		
		$usuarios = new UsuarioQuery();

		foreach ($usuarios->listarUsuariosOrganizacion($idOrganizacion) as $registro) {
			$registro['nombre'] = trim($registro['nombre'])=='' ? $registro['nickname'] : $registro['nombre'];
			$seleccionar = in_array($registro['id'], $listado) ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['nombre']);
		}
		return $strHtml;
	}

	public function getCatalogo($tabla, $campos='*', $estatus=null, $filtro=null)
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo($tabla, $campos, $estatus, $filtro);
    }
}
