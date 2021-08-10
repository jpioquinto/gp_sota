<?php

namespace App\Controllers;

use App\Libraries\Proyecto\UIProyecto;
use App\Libraries\Usuario;

class ProyectoPrioritario extends BaseController
{   
    protected $uiProyecto;  
    protected $encrypter; 
    protected $usuario;
    protected $tipo;

    public function __construct()
    {
        @session_start();   
        $this->tipo = 1;
        $this->usuario = new Usuario();  
        $this->uiProyecto = new UIProyecto();  
        $this->encrypter = \Config\Services::encrypter();                   
    }

    public function index()
    {            
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_listado', 
                [
                    'listado'=>$this->uiProyecto->obtenerListado($this->getTipo()), 
                    'titulo'=>'Prioritarios'
                ])
            ]);
    }

    public function getTipo()
    {
        return $this->tipo;
    }
}
