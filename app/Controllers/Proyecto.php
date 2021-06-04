<?php

namespace App\Controllers;

use App\Libraries\Proyecto\UIProyecto;

class Proyecto extends BaseController
{   
    protected $usuario;   

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();                      
    }

    public function indexxxxxxxxxx()
    {
        
        $uiProyecto = new UIProyecto();
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_listado', 
                [
                    'listado'=>$uiProyecto->obtenerListado(), 
                ])
            ]);
    }

    public function index()
    {
        
        #$uiProyecto = new UIProyecto();
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_form_proyecto', 
                [
                    'listado'=>''#$uiProyecto->obtenerListado(), 
                ])
            ]);
    }

}
