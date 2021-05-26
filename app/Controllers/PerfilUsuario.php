<?php

namespace App\Controllers;
use  App\Libraries\{Usuario};
use  App\Libraries\Usuario\Perfil as CPerfil;

class PerfilUsuario extends BaseController
{   
    protected $usuario;     
    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();              
    }

    public function index()
    {
        #$perfil = new CPerfil();	
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('perfil/v_listado', ['listado'=>''])
        ]);
    }
}
