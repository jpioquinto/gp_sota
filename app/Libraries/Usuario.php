<?php 
namespace App\Libraries;
use  App\Libraries\Modelo;

class Usuario extends Modelo
{	
	public function __construct()
	{
		parent::__construct($_SESSION['GP_SOTA']);
        
	}

	
}