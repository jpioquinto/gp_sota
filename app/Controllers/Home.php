<?php

namespace App\Controllers;
use  App\Libraries\Usuario;
use App\Libraries\Usuario\Perfil;
use App\Models\{ContactoModel, CorreoModel, PerfilModel};

class Home extends BaseController
{
	public $usuario;

	public function __construct()
	{
		@session_start();
		$this->usuario = new Usuario();
	}

	public function index()
	{
		
		if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}
		
		$perfil = new Perfil();	

		return view(
			'layout/v_plantilla', 
			[
				'v_header'=>view('layout/v_header', $usuario=$this->obtenerInfoUsuario()??[]), 
				'v_sidebar'=>view('layout/v_sidebar', $usuario),
				'v_usuarios'=>view('usuario/v_listado') 
				#'v_perfil'=>$perfil->obtenerVistaPerfil()
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
}
