<?php

namespace App\Controllers;
use App\Models\{ContactoModel, CorreoModel, PerfilModel, ModuloModel};
use App\Traits\{PermisoTrait, AccesoRapidoTrait};
use App\Libraries\Usuario\Perfil;
use  App\Libraries\Usuario;

class Home extends BaseController
{
	public $usuario;

	protected $elementos;

	use PermisoTrait;
	use AccesoRapidoTrait;

	public function __construct()
	{
		@session_start();
		$this->usuario = new Usuario();
		$this->elementos = [];
	}

	public function index()
	{
		
		if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

		if ($this->request->isAJAX()) {
            echo json_encode(['Solicitud'=>true, 'vista'=>view('inicio/v_inicio')]); return;
        }
		
		#$perfil = new Perfil();	
		#$path = explode('\\', __CLASS__);    
		#echo '<pre>'.array_pop($path);
		#echo '<pre>';print_r($this->usuario->permisos);exit;		
		$datos = ['v_acciones'=>$this->vistaAcciones(get_class($this), 24)];
		return view(
			'layout/v_plantilla', 
			[
				'v_header'=>view('layout/v_header', array_merge( $usuario=$this->obtenerInfoUsuario() ?? [], $datos)), 
				'v_sidebar'=>view('layout/v_sidebar', array_merge($usuario, ['menu'=>$this->generarMenu()])),
				'v_inicio'=>view('inicio/v_inicio')				
			]
		);		
	}

	protected function obtenerInfoUsuario()
	{
		$contactoModel = new ContactoModel();
		

		$info = $contactoModel->find($this->usuario->getId());
		$correo = $this->obtenerPrimerCorreo( isset($info['id']) ? $info['id'] : null );
		
		if (isset($correo['email'])) {
			$info['email'] = $correo['email'];
		}

		$info['perfil'] = $this->nombrePerfil($this->usuario->getPerfilId());
		
		return $info;
	}

	protected function obtenerPrimerCorreo($idContacto=null)
	{
		if (!$idContacto) {
			return [];
		}
		$correoModel = new CorreoModel();
		return $correoModel->where(['contacto_id'=>$idContacto, 'estatus'=>1])->first() ?? [];
	}

	protected function nombrePerfil($idPerfil)
	{
		$perfilModel = new PerfilModel();
		$registro = $perfilModel->find($idPerfil);

		return isset($registro['id']) ? $registro['nombre'] : '';
	}

	protected function generarMenu()
	{
		$menu = ''; $ini = false;
		foreach ($this->usuario->permisos as $key=>$value) {
			if (in_array($value['id'], $this->elementos)) {
				continue;
			}
			if (!$ini) {
				$menu .= $value['controlador']==='Home' 
					? $this->htmlItem($value) . $this->itemInfo() 
					: $this->itemInfo() . $this->htmlItem($value);
				$ini = true;
				continue;
			}
			$menu .= $this->htmlItem($value);
		}
		return $menu;
	}

	protected function htmlItem($modulo, $subitem='')
	{		
		$li = ''; $this->elementos[] = $modulo['id'];
		
		if ($this->esModuloPadre($modulo['id'])===FALSE) {
			return $li .= "<li class='nav-item'>
							<a class='jq_modulo' onclick='return false;' href='{$modulo['controlador']}'>
								<i class='{$modulo['icono']}'></i>
								".($subitem!='' ? "<span class='{$subitem}'>{$modulo['nombre']}</span>" : "<p>{$modulo['nombre']}</p>")."
							</a>
							</li>";
		}

		return $li .= "<li class='nav-item'>
							<a data-toggle='collapse' href='#modulo_".$modulo['id']."'>
								<i class='{$modulo['icono']}'></i>
								<p>{$modulo['nombre']}</p>
								<span class='caret'></span>
							</a>
							<div class='collapse' id='modulo_".$modulo['id']."'>
								<ul class='nav nav-collapse'>".$this->htmlItemHijos($modulo['id'])."</ul>".
							"</div></li>";

	}

	protected function htmlItemHijos($idPadre)
	{
		$subMenu = '';
		foreach ($this->usuario->permisos as $key=>$value) {
			if ($value['nodo_padre']!=$idPadre || in_array($value['id'], $this->elementos)) {
				continue;
			}
			$subMenu .= $this->htmlItem($value);
		}
		return $subMenu;
	}

	protected function esModuloPadre($idModulo)
	{
		return array_search($idModulo, array_column($this->usuario->permisos, 'nodo_padre'));
	}

	protected function itemInfo()
	{
		return '<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Módulos</h4>
				</li>';
	}
}
