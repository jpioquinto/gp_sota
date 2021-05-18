<?php 
namespace App\Libraries;
use  App\Libraries\Modelo;

class Usuario extends Modelo
{	
	public function __construct()
	{
		parent::__construct(isset($_SESSION['GP_SOTA']) ? $_SESSION['GP_SOTA'] : []);
        
	}
	
	public function getId()
	{
		if ($this->getAttribute('id') && is_numeric($this->getAttribute('id'))) {
			return $this->getAttribute('id');
		}
		return 0;
	}
	
}