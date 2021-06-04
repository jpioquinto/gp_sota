<?php

namespace App\Controllers;

use App\Libraries\Proyecto\UIProyecto;
use App\Libraries\Usuario;

class Proyecto extends BaseController
{   
    protected $uiProyecto;   
    protected $usuario;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();  
        $this->uiProyecto = new UIProyecto();                    
    }

    public function indexxxxxxxxxx()
    {            
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_listado', 
                [
                    'listado'=>$this->uiProyecto->obtenerListado(), 
                ])
            ]);
    }

    public function index()
    {
        
        
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_form_proyecto', 
                [
                    'v_acciones'=> view('proyectos/parcial/_v_acciones'),
                    'v_listado_tipos'=>$this->uiProyecto->listadoTipos(),
                    'v_listado_cobertura'=>$this->uiProyecto->listadoCoberturas(),
                    'v_listado_usuarios'=>$this->uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId())                    
                ])
            ]);
    }

}
