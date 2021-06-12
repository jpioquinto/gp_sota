<?php
namespace App\Controllers;
use  App\Libraries\Usuario;

class Seguimiento extends BaseController
{
    protected $encrypter; 
    protected $usuario;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();  
        #$this->uiProyecto = new UIProyecto();  
        $this->encrypter = \Config\Services::encrypter();                   
    }
    
    public function index()
    {

        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view('proyectos/seguimiento/v_contenedor')
        ]);
    }

    public function obtenerVistaNueva()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/seguimiento/v_modal_accion')
        ]);
    }

}
