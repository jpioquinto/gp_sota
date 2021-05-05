<?php

namespace App\Controllers;
use  App\Libraries\Usuario;


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
		
		
		return view(
			'layout/v_plantilla', 
			['v_header'=>view('layout/v_header'), 'v_sidebar'=>view('layout/v_sidebar'), 'v_perfil'=>view('usuario/v_perfil')]
		);		
	}
}
